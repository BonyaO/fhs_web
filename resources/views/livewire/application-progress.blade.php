{{-- resources/views/livewire/application-progress.blade.php --}}
<div class="mb-6">
    <div class="bg-white rounded-lg shadow-sm border p-6">
        <h3 class="text-lg font-semibold mb-4">Application Progress</h3>
        
        <div class="flex items-start justify-between">
            @foreach($steps as $key => $label)
                @php
                    $stepIndex = $loop->iteration;
                    $isCompleted = $this->getStepStatus($key);
                    $isActive = $this->isStepActive($stepIndex);
                @endphp
                
                <div class="flex-1 relative">
                    {{-- Connection line (except for last item) --}}
                    @if(!$loop->last)
                        <div class="absolute top-5 left-1/2 w-full h-0.5 transform translate-x-1/2 z-0 
                            {{ $isCompleted ? 'bg-green-500' : 'bg-gray-300' }}">
                        </div>
                    @endif
                    
                    <div class="relative flex flex-col items-center">
                        {{-- Step indicator --}}
                        <div class="relative z-10 flex items-center justify-center">
                            @if($isCompleted)
                                {{-- Completed step with green checkmark --}}
                                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center shadow-md">
                                    <span class="text-2xl text-green-100 font-bold">&#10003;</span>
                                </div>
                            @else
                                {{-- Uncompleted step --}}
                                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm
                                    {{ $isActive ? 'border-2 border-green-500' : 'border-2 border-gray-300' }}">
                                    <span class="text-sm font-semibold 
                                        {{ $isActive ? 'text-green-600' : 'text-gray-400' }}">
                                        {{ $stepIndex }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        {{-- Step label --}}
                        <div class="mt-2 text-center">
                            <p class="text-xs sm:text-sm font-medium max-w-[100px] leading-tight
                                {{ $isCompleted ? 'text-green-700' : ($isActive ? 'text-blue-600' : 'text-gray-500') }}">
                                {{ $label }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Validation warning --}}
        @if($this->canValidate())
            <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-yellow-800">
                            Ready to submit! Click "" to complete your application.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>