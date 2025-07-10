{{-- resources/views/livewire/application-progress.blade.php --}}
<div class="mb-6">
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <h3 class="text-lg font-semibold mb-4">Application Progress</h3>
        
        <div class="flex items-start justify-between">
            @foreach($steps as $key => $label)
                <div class="flex-1 relative">
                    {{-- Connection line (except for last item) --}}
                    @if(!$loop->last)
                        <div class="absolute top-5 left-1/2 w-full h-0.5 {{ $this->getStepStatus($key) ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                    @endif
                    
                    <div class="relative flex flex-col items-center">
                        {{-- Step indicator --}}
                        <div class="relative z-10 flex items-center justify-center">
                            @if($this->getStepStatus($key))
                                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center shadow-md">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            @else
                                <div class="w-10 h-10 bg-white border-2 {{ $loop->iteration <= array_search(array_filter(array_map([$this, 'getStepStatus'], array_keys($steps)))[count(array_filter(array_map([$this, 'getStepStatus'], array_keys($steps))))-1] ?? array_keys($steps)[0], array_keys($steps)) + 1 ? 'border-green-500' : 'border-gray-300' }} rounded-full flex items-center justify-center shadow-sm">
                                    <span class="text-sm font-semibold {{ $loop->iteration <= array_search(array_filter(array_map([$this, 'getStepStatus'], array_keys($steps)))[count(array_filter(array_map([$this, 'getStepStatus'], array_keys($steps))))-1] ?? array_keys($steps)[0], array_keys($steps)) + 1 ? 'text-green-600' : 'text-gray-400' }}">{{ $loop->iteration }}</span>
                                </div>
                            @endif
                        </div>
                        
                        {{-- Step label --}}
                        <div class="mt-2 text-center">
                            <p class="text-xs sm:text-sm font-medium {{ $this->getStepStatus($key) ? 'text-green-700' : 'text-gray-500' }} max-w-[100px] leading-tight">
                                {{ $label }}
                            </p>
                        </div>
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