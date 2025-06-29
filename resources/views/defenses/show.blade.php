@extends('layouts.app')

@section('title', 'Defense Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('defenses.index') }}" 
           class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
            <i class="fas fa-arrow-left mr-2"></i> Back to List
        </a>
    </div>

    <!-- Defense Details Card -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-blue-600 px-6 py-8 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Thesis Defense</h1>
                    <p class="text-purple-100">{{ $defense->date->format('l d F Y') }} at {{ $defense->time->format('H:i') }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-sm font-medium
                    {{ $defense->status === 'scheduled' ? 'bg-yellow-500 text-yellow-100' : '' }}
                    {{ $defense->status === 'in_progress' ? 'bg-blue-500 text-blue-100' : '' }}
                    {{ $defense->status === 'completed' ? 'bg-green-500 text-green-100' : '' }}
                    {{ $defense->status === 'cancelled' ? 'bg-red-500 text-red-100' : '' }}">
                    @switch($defense->status)
                        @case('scheduled') Scheduled @break
                        @case('in_progress') In Progress @break
                        @case('completed') Completed @break
                        @case('cancelled') Cancelled @break
                    @endswitch
                </span>
            </div>
        </div>

        <div class="p-6">
            <!-- Event Information -->
            <div class="grid md:grid-cols-3 gap-6 mb-8">
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <i class="fas fa-calendar-alt text-2xl text-purple-600 mb-2"></i>
                    <h3 class="font-semibold text-gray-900">Date</h3>
                    <p class="text-gray-600">{{ $defense->date->format('d/m/Y') }}</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <i class="fas fa-clock text-2xl text-purple-600 mb-2"></i>
                    <h3 class="font-semibold text-gray-900">Time</h3>
                    <p class="text-gray-600">{{ $defense->time->format('H:i') }}</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <i class="fas fa-map-marker-alt text-2xl text-purple-600 mb-2"></i>
                    <h3 class="font-semibold text-gray-900">Location</h3>
                    <p class="text-gray-600">{{ $defense->venue }}</p>
                </div>
            </div>

            <!-- Student Information -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">
                    <i class="fas fa-user-graduate mr-2 text-purple-600"></i>Candidate Information
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="flex items-start gap-6">
                        @if($defense->student_photo)
                            <img src="{{ asset('storage/' . $defense->student_photo) }}" 
                                alt="Photo de {{ $defense->student_name }}"
                                class="w-32 h-32 rounded-lg object-cover shadow-md">
                        @else
                            <div class="w-32 h-32 rounded-lg bg-gray-200 flex items-center justify-center shadow-md">
                                <i class="fas fa-user text-gray-400 text-4xl"></i>
                            </div>
                        @endif
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $defense->student_name }}</h3>
                            <p class="text-gray-600 mb-4">
                                <span class="font-medium">Registration Number:</span> {{ $defense->registration_number }}
                            </p>
                            
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2">Thesis Title:</h4>
                        <p class="text-gray-800 leading-relaxed">{{ $defense->thesis_title }}</p>
                    </div>
                </div>
                
            </div>
            

            <!-- Jury Information -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">
                    <i class="fas fa-users mr-2 text-purple-600"></i>Jury Composition N° {{ $defense->jury_number }}
                </h2>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- President -->
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-crown text-purple-600 mr-2"></i>
                            <h3 class="font-semibold text-purple-900">President</h3>
                        </div>
                        <p class="text-gray-800">{{ $defense->president_info }}</p>
                    </div>

                    <!-- Rapporteur -->
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-file-alt text-blue-600 mr-2"></i>
                            <h3 class="font-semibold text-blue-900">Rapporteur</h3>
                        </div>
                        <p class="text-gray-800">{{ $defense->rapporteur_info }}</p>
                    </div>
                </div>

                <!-- Other Members -->
                @if($defense->jury_members && count($defense->jury_members) > 0)
                    <div class="mt-6">
                        <h3 class="font-semibold text-gray-900 mb-3">
                            <i class="fas fa-user-friends mr-2 text-purple-600"></i>Other Members
                        </h3>
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($defense->jury_members as $member)
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <p class="text-gray-800">
                                        {{ isset($member['title']) ? $member['title'] . ' ' : '' }}{{ $member['name'] ?? '' }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Additional Notes -->
            @if($defense->notes)
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4 border-b border-gray-200 pb-2">
                        <i class="fas fa-sticky-note mr-2 text-purple-600"></i>Notes
                    </h2>
                    <div class="bg-yellow-50 p-4 rounded-lg">
                        <p class="text-gray-800 leading-relaxed">{{ $defense->notes }}</p>
                    </div>
                </div>
            @endif

            
        </div>
    </div>
</div>

@push('styles')
<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        font-size: 12pt;
        line-height: 1.4;
    }
    
    .container {
        max-width: none;
        margin: 0;
        padding: 20px;
    }
}
</style>
@endpush

@push('scripts')
<script>
function downloadPDF() {
    // This would integrate with a PDF generation service
    // For now, we'll use the browser's print dialog
    window.print();
}
</script>
@endpush
@endsection