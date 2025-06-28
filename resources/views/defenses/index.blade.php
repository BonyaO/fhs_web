
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
                <label for="venue" class="block text-sm font-medium text-gray-700 mb-1">Salle</label>
                <select id="venue" 
                        name="venue"
                        class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Toutes les salles</option>
                    @foreach($venues as $venue)
                        <option value="{{ $venue }}" {{ request('venue') == $venue ? 'selected' : '' }}>
                            {{ $venue }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select id="status" 
                        name="status"
                        class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Tous les statuts</option>
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
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($defenses as $defense)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <!-- Header with date and status -->
                    <div class="p-4 border-b border-gray-200 bg-purple-50 rounded-t-lg">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold text-purple-800">{{ $defense->date->format('d/m/Y') }}</h3>
                                <p class="text-sm text-purple-600">{{ $defense->time->format('H:i') }} - {{ $defense->venue }}</p>
                            </div>

                        <!-- Thesis Title -->
                        <div class="mb-4">
                            <h5 class="text-sm font-medium text-gray-700 mb-1">Thesis Title:</h5>
                            <p class="text-sm text-gray-900 line-clamp-3">{{ $defense->thesis_title }}</p>
                        </div>

                        <!-- Jury Info -->
                        <div class="mb-4">
                            <h5 class="text-sm font-medium text-gray-700 mb-2">Jury N° {{ $defense->jury_number }}</h5>
                            <div class="space-y-1 text-sm">
                                <div>
                                    <span class="font-medium text-purple-700">President:</span> 
                                    {{ $defense->president_info }}
                                </div>
                                <div>
                                    <span class="font-medium text-purple-700">Rapporteur:</span> 
                                    {{ $defense->rapporteur_info }}
                                </div>
                                @if($defense->jury_members && count($defense->jury_members) > 0)
                                    <div>
                                        <span class="font-medium text-purple-700">Members:</span>
                                        @foreach($defense->jury_members as $member)
                                            <span class="block ml-2">
                                                {{ isset($member['title']) ? $member['title'] . ' ' : '' }}{{ $member['name'] ?? '' }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- View Details Button -->
                        <div class="pt-2 border-t border-gray-200">
                            <a href="{{ route('defenses.show', $defense) }}" 
                               class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium">
                                <i class="fas fa-eye mr-1"></i> View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
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
                            <span class="px-2 py-1 text-xs rounded-full 
                                {{ $defense->status === 'scheduled' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $defense->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $defense->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $defense->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                @switch($defense->status)
                                    @case('scheduled') Scheduled @break
                                    @case('in_progress') In Progress @break
                                    @case('completed') Completed @break
                                    @case('cancelled') Cancelled @break
                                @endswitch
                            </span>
                        </div>
                    </div>

                    <!-- Student Info -->
                    <div class="p-4">
                        <div class="flex items-start gap-4 mb-4">
                            @if($defense->student_photo)
                                <img src="{{ asset('storage/' . $defense->student_photo) }}" 
                                     alt="Photo de {{ $defense->student_name }}"
                                     class="w-16 h-16 rounded-full object-cover">
                            @else
                                <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-400 text-xl"></i>
                                </div>
                            @endif
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 mb-1">{{ $defense->student_name }}</h4>
                                <p class="text-sm text-gray-600">{{ $defense->registration_number }}</p>
                            </div>
                        </div>