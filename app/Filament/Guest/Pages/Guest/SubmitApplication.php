<?php

namespace App\Filament\Guest\Pages\Guest;

use App\Models\Payments;
use Barryvdh\DomPDF\Facade\Pdf;
use BlessDarah\PhpCampay\Campay;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Blade;

class SubmitApplication extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $title = 'Your application';

    protected static string $view = 'filament.guest.pages.guest.submit-application';

    // protected static bool $shouldRegisterNavigation = false;
    public $paymentInfo;

    protected function getHeaderActions(): array
    {
        $user_application = auth()->user()->application;

        if (isset($user_application) && ! isset($user_application->validated_on) && count($user_application->qualifications) > 0) {
            return [
                \Filament\Actions\Action::make('Validate Application')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalDescription('You will not be able to make changes after this after submitting this. Are you sure to proceed?')
                    ->action(function () {
                        auth()->user()->application->validated_on = \Carbon\Carbon::now();
                        auth()->user()->application->save();
                        Notification::make()
                            ->title('Your application has now been validated')
                            ->success()
                            ->send();

                        return $this->downloadForm();
                    }),
            ];
        } elseif (isset($user_application) && $user_application->validated_on) {
            return [\Filament\Actions\Action::make('Download Application')
                ->color('primary')
                ->action(function () {
                    return $this->downloadForm();
                })];
        } else {
            return [];
        }
    }

    public function downloadForm()
    {
        return response()->streamDownload(function () {
            echo Pdf::loadHtml(
                Blade::render('reports.student-form', [
                    'student' => auth()->user()->application,
                    'qualifications' => auth()->user()->application->qualifications,
                ])
            )->stream();
        }, 'coltech24-'.auth()->user()->application->name.'-'.auth()->user()->application->surname.'.pdf');
    }

    public function cancelPayment()
    {
        $transaction = Payments::where('user_id', auth()->user()->id)->first();
        if ($transaction && $transaction->status == 'PENDING') {
            $transaction->delete();
            Notification::make()
                ->title('Your transaction has been cancelled.')
                ->warning()
                ->send();
            $this->redirect('/guest/process-payment');
        }
    }

    public function validatePayment()
    {
        $campay = new Campay("https://www.campay.net/api/");

        $paymentRecord = auth()->user()->payment;
        $res = $campay->getTransactionStatus($paymentRecord->reference);
        $transaction_feedback = json_decode($res);

        if ($transaction_feedback->status == 'SUCCESSFUL') {
            $paymentRecord->update(json_decode($res, true));
            Notification::make()
                ->title('Your payment has been validated')
                ->send();
        }

        if ($transaction_feedback->status == 'PENDING') {
            // $paymentRecord->update(json_decode($res, true));
            Notification::make()
                ->title('Your payment is still pending. Try again.')
                ->warning()
                ->send();
        }

        if ($transaction_feedback->status == 'FAILED') {
            $paymentRecord->update(json_decode($res, true));
            Notification::make()
                ->title('Your payment has failed')
                ->danger()
                ->send();
        }
    }

    public function makePayment()
    {
        $campay = new Campay();

        $data = [
            'amount' => 3,
            'currency' => 'XAF',
            'from' => '237672374414',
            'description' => 'test payment',
        ];
        $res = $campay->collect($data);
        $decoded_response = json_decode($res);
        $this->paymentInfo = $decoded_response;

        if (auth()->user()->payment) {
            auth()->user()->payment->delete();
        }

        Payments::create([
            'reference' => $decoded_response->reference,
            'user_id' => auth()->id(),
        ]);
    }
}
