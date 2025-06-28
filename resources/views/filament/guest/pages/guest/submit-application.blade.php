<x-filament-panels::page>
    @if (auth()->user()->payment)
        @if (auth()->user()->payment->status == 'PENDING')
            <x-filament::button wire:click="validatePayment">
                Validate
            </x-filament::button>
            <x-filament::button color="danger" wire:click="cancelPayment">
                Cancel
            </x-filament::button>
        @elseif (auth()->user()->payment->status == 'FAILED')
            <div class="border border-gray-400 rounded-lg p-4 space-y-4 text-center">
                <h3 class="text-2xl font-semibold text-orange-600">Oops!! An error occured</h3>
                <p>Your payment has failed or it was cancelled</p>
                <x-filament::button color="warning" tag="a" href="/guest/process-payment">
                    Try again
                </x-filament::button>
            </div>
        @else
            <x-filament::section collapsible>
                <x-slot name="heading">
                    Step1: Fill the application form
                </x-slot>

                @livewire('application-form')
            </x-filament::section>

            <x-filament::section collapsible>
                <x-slot name="heading">
                    Qualifications
                </x-slot>

                @livewire('qualification-form')
            </x-filament::section>
        @endif
    @else

        <x-filament::button tag="a" href="/guest/process-payment">
            Make payment
        </x-filament::button>
    @endif
</x-filament-panels::page>
