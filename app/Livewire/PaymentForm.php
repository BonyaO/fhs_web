<?php

namespace App\Livewire;

use App\Models\Payments;
use BlessDarah\PhpCampay\Campay;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PaymentForm extends Component
{
    #[Validate('required')]
    public ?string $phone_number;

    public bool $continue = false;

    public bool $processing = false;

    public ?Payments $payment;

    public function mount()
    {
        $this->payment = Auth::user()->payment;
    }

    public function create()
    {
        $this->processing = true;
        $this->validate();

        $campay = new Campay();

        $data = [
            'amount' => 3,
            'currency' => 'XAF',
            'from' => '237'.$this->phone_number,
            'description' => 'Platform fee',
        ];

        $res = $campay->collect($data);
        $decoded_response = json_decode($res);

        if (auth()->user()->payment) {
            auth()->user()->payment->delete();
        }

        Payments::create([
            'reference' => $decoded_response->reference,
            'user_id' => Auth::id(),
        ]);
        Notification::make()
            ->title('Your payment is being processed Dial *126# for MTN the equivalent for Orange money to confirm your payment')
            ->success()
            ->send();

        $this->continue = true;
        $this->processing = true;

        $this->redirect('/guest/process-payment');
    }

    /**
     * @return View|Factory
     *
     * @throws BindingResolutionException
     */
    public function render()
    {
        return view('livewire.payment-form');
    }
}
