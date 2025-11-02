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

    public $paymentInfo;

    // Add reactive properties
    protected $listeners = ['qualificationAdded' => 'refreshHeaderActions'];

    public function mount()
    {
        // Ensure we have fresh data on mount
        $this->refreshHeaderActions();
    }

    public function refreshHeaderActions()
    {
        // This will trigger a re-render of the header actions
        $this->dispatch('$refresh');
    }

    protected function getHeaderActions(): array
    {
        // Fresh query each time to get current state
        $user_application = auth()->user()->fresh()->application;

        if (isset($user_application) && !isset($user_application->validated_on) && $user_application->qualifications()->count() > 0) {
            return [
                \Filament\Actions\Action::make('validateApplication')
                    ->label('Finalise Application')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Verify Your Application Details')
                    ->modalDescription('Please review all your information carefully before confirming. You will not be able to make changes after submitting.')
                    ->modalContent(view('components.application-verification-modal', [
                        'application' => $user_application,
                        'qualifications' => $user_application->qualifications
                    ]))
                    ->modalSubmitActionLabel('Confirm & Submit Application')
                    ->modalCancelActionLabel('Cancel')
                    ->modalWidth('7xl')
                    ->action(function () {
                        auth()->user()->application->validated_on = \Carbon\Carbon::now();
                        auth()->user()->application->save();
                        
                        Notification::make()
                            ->title('Your application has now been confirmed and submitted.')
                            ->success()
                            ->send();

                        return $this->downloadForm();
                    }),
            ];
        } elseif (isset($user_application) && $user_application->validated_on) {
            return [
                \Filament\Actions\Action::make('downloadApplication')
                    ->label('Download Application')
                    ->color('primary')
                    ->action(function () {
                        return $this->downloadForm();
                    })
            ];
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
        }, 'FHS25-' . auth()->user()->application->fullname . '.pdf');
    }

    public function cancelPayment()
    {
        $transaction = Payments::where('user_id', auth()->user()->id)->first();
        if ($transaction && $transaction->status == 'PENDING') {
            $transaction->delete();
            Notification::make()
                ->title('Your transaction has been cancelled.')
                ->success()
                ->send();
        }
    }

    public function validatePayment()
    {
        $campay = new Campay();
        $response = $campay->collect($this->paymentInfo);
        
        if ($response['status'] == 'SUCCESSFUL') {
            Notification::make()
                ->title('Payment validated successfully')
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Payment validation failed')
                ->danger()
                ->send();
        }
    }
}