{{-- resources/views/livewire/application-progress.blade.php --}}
<div class="mb-6">
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <h3 class="text-lg font-semibold mb-4">Application Progress</h3>
        
        <div class="space-y-4">
            @foreach($steps as $key => $label)
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        @if($this->getStepStatus($key))
                            <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        @else
                            <div class="w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center">
                                <div class="w-2 h-2 bg-gray-500 rounded-full"></div>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium {{ $this->getStepStatus($key) ? 'text-green-700' : 'text-gray-500' }}">
                            {{ $label }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        @if($this->canValidate())
            <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-yellow-800">
                            Ready to submit! Click "Validate Application" to complete your application.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>