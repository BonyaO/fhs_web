
@extends('layouts.app')

@section('title', 'Thesis Defenses')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Thesis Defenses</h1>
        <p class="text-gray-600">List of Scheduled Defenses</p>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('defenses.index') }}" class="space-y-4 md:space-y-0 md:flex md:gap-4 md:items-end">
            <!-- Search -->
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" 
                       id="search" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Student name, room, jury, title..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Date Filter -->
            <div>
                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input type="date" 
                       id="date" 
                       name="date" 
                       value="{{ request('date') }}"
                       class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Venue Filter -->
            <div>
                <label for="venue" class="block text-sm font-medium text-gray-700 mb-1">Venue</label>
                <select id="venue" 
                        name="venue"
                        class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Venues</option>
                    @foreach($venues as $venue)
                        <option value="{{ $venue }}" {{ request('venue') == $venue ? 'selected' : '' }}>
                            {{ $venue }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status" 
                        name="status"
                        class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Statuses</option>
                    <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex gap-2">
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-search mr-1"></i> Search
                </button>
                <a href="{{ route('defenses.index') }}" 
                   class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <i class="fas fa-times mr-1"></i> Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Results Count -->
    <div class="mb-4 text-sm text-gray-600">
        {{ $defenses->total() }} thesis defense(s) found
    </div>


<!-- Defense Cards Grid -->
@if($defenses->count() > 0)
    <!-- Single Card Container for All Defenses -->
    <div class="bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden">
        <!-- Header with Column Labels -->
        <div class="bg-gradient-to-r from-purple-600 to-blue-600 text-white">
            <div class="p-4">
                <div class="grid grid-cols-12 gap-4 items-center font-semibold">
                    <!-- Date & Time Column Header -->
                    <div class="col-span-2">
                        <h4 class="text-sm uppercase tracking-wide">Date & Time</h4>
                    </div>
                    
                    <!-- Thesis Title Column Header -->
                    <div class="col-span-6">
                        <h4 class="text-sm uppercase tracking-wide">Thesis Title</h4>
                    </div>
                    
                    <!-- Jury Information Column Header -->
                    <div class="col-span-3">
                        <h4 class="text-sm uppercase tracking-wide">Jury Information</h4>
                    </div>
                    
                    <!-- Actions Column Header -->
                    <div class="col-span-1">
                        <h4 class="text-sm uppercase tracking-wide">Actions</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Defense Items List -->
        <div class="divide-y divide-gray-200">
            @foreach($defenses as $defense)
                <div class="p-4 hover:bg-gray-50 transition-colors duration-200">
                    <div class="grid grid-cols-12 gap-4 items-start">
                        <!-- Date & Time Section -->
                        <div class="col-span-2">
                            <div class="bg-purple-50 rounded-lg p-3 text-center">
                                <h3 class="text-lg font-bold text-purple-800 mb-1">{{ $defense->date->format('d/m/Y') }}</h3>
                                <p class="text-sm text-purple-600 font-medium">{{ $defense->time->format('H:i') }}</p>
                                <p class="text-xs text-purple-500 mt-1">{{ $defense->venue }}</p>
                            </div>
                        </div>

                        <!-- Thesis Title Section (Largest width) -->
                        <div class="col-span-6">
                            <div class="pr-4">
                                <h2 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2 leading-tight">
                                    {{ $defense->thesis_title }}
                                </h2>
                                <div class="flex items-start gap-6">
                                    @if($defense->student_photo)
                                        <img src="{{ asset('storage/' . $defense->student_photo) }}" 
                                            alt="Photo de {{ $defense->student_name }}"
                                            class="w-16 h-16 rounded-lg object-cover shadow-md">
                                    @else
                                        <div class="hidden w-32 h-32 rounded-lg bg-gray-200 flex items-center justify-center shadow-md">
                                            <i class="fas fa-user text-gray-400 text-4xl"></i>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-600">Student: <span class="font-semibold text-gray-900 mb-2">{{ $defense->student_name }}</span></p>
                                        <p class="text-gray-600 mb-4">
                                            <span class="font-medium">Registration Number:</span> {{ $defense->registration_number }}
                                        </p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Jury Information Section -->
                        <div class="col-span-3">
                            <div class="bg-gray-50 rounded-lg p-3">
                                <h5 class="text-sm font-bold text-gray-700 mb-2">Jury N° {{ $defense->jury_number }}</h5>
                                <div class="space-y-1 text-xs">
                                    <div>
                                        <span class="font-medium text-purple-700">President:</span> 
                                        <span class="block text-gray-800 mt-1">{{ $defense->president_info }}</span>
                                    </div>
                                    <div class="mt-2">
                                        <span class="font-medium text-purple-700">Rapporteur:</span> 
                                        <span class="block text-gray-800 mt-1">{{ $defense->rapporteur_info }}</span>
                                    </div>
                                    @if($defense->jury_members && count($defense->jury_members) > 0)
                                        <div class="mt-2">
                                            <span class="font-medium text-purple-700">Members:</span>
                                            @foreach($defense->jury_members as $member)
                                                <span class="block text-gray-800 mt-1 ml-2">
                                                    {{ isset($member['title']) ? $member['title'] . ' ' : '' }}{{ $member['name'] ?? '' }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Actions Section -->
                        <div class="col-span-1 text-center">
                            <a href="{{ route('defenses.show', $defense) }}" 
                               class="inline-flex items-center justify-center w-10 h-10 bg-blue-600 text-white rounded-full hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200"
                               title="View Details">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $defenses->withQueryString()->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                <i class="fas fa-calendar-times text-6xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Thesis Defense Found</h3>
            <p class="text-gray-600">No thesis defense matches your search criteria.</p>
        </div>
    @endif
</div>

@push('styles')
<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush
@endsection
                     