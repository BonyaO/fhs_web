<div>
    @if(!$payment || $payment->status == 'FAILED')
        <p class="mb-4">You will be billed 1000 XAF for this transaction.</p>
        <form wire:submit="create" class="space-y-4">
            <label for="phone_number">Mobile money number</label>
            <input type="text" id="phone_number"
               placeholder="E.g: 6734448912"
               wire:model="phone_number"
               class="block border border-gray-300 rounded-lg"
            />
            @error('phone_number')
                <span class="block text-sm text-orange-500" style="color: red;">{{$message}}</span>
            @enderror
            <x-filament::button icon="heroicon-o-banknotes" class="flex" type="submit">
                @if($processing)
                    <x-filament::loading-indicator class="h-5 w-5 inline" />
                @endif
                <span>Pay now</span>
            </x-filament::button>
        </form>

    @elseif($payment->status == 'PENDING')
        <p class="mb-4">Your payment is pending. Click continue to validate</p>
        <x-filament::button tag="a" href="/guest/submit-application">
            Click to continue
        </x-filament::button>
    @else
        <p class="mb-4">Your payment has been processed already.</p>
        <x-filament::button tag="a" href="/guest/submit-application">
            Continue
        </x-filament::button>
    @endif
</div>
