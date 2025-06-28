<div>
    @if (auth()->user()->application && !$isEdit)
        {{ $this->applicationInfoList }}

        @if (!auth()->user()->application->validated_on)
            <div class="mt-3">
                <x-filament::button wire:click="toggleEdit">
                    Edit application
                </x-filament::button>
            </div>
        @endif
    @elseif (auth()->user()->application && $isEdit)
        <form wire:submit="edit">
            {{ $this->editForm }}

            <x-filament::button type="sumbit" style="margin-top: 1rem;">
                Update application
            </x-filament::button>
        </form>
    @else
        <form wire:submit="create">
            {{ $this->createForm }}

            <x-filament::button type="sumbit" style="margin-top: 1rem;">
                Submit application
            </x-filament::button>
        </form>
    @endif
</div>
