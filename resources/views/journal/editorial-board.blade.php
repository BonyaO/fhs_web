@extends('layouts.journal')

@section('title', 'Editorial Board - African Annals of Health Sciences')

@section('meta')
<meta name="description" content="Meet the editorial board members of African Annals of Health Sciences - leading experts in health sciences from across Africa.">
<meta name="keywords" content="editorial board, editors, African health sciences, medical journal, health research">
@endsection

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-purple-700 to-purple-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Editorial Board</h1>
                <p class="text-xl text-purple-100 max-w-3xl mx-auto">
                    Our distinguished panel of experts committed to advancing health sciences research in Africa
                </p>
            </div>
        </div>
    </div>

    <!-- Breadcrumb -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="{{ route('journal.home') }}" class="text-purple-600 hover:text-purple-800">
                            Journal Home
                        </a>
                    </li>
                    <li>
                        <span class="text-gray-400">/</span>
                    </li>
                    <li class="text-gray-600">Editorial Board</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Search Bar (Optional) -->
    @if(request('search'))
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <p class="text-gray-600">
                    Search results for: <span class="font-semibold">"{{ request('search') }}"</span>
                </p>
                <a href="{{ route('journal.editorial-board') }}" class="text-purple-600 hover:text-purple-800 text-sm">
                    Clear search
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Statistics Section -->
        <div class="mb-12 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-4xl font-bold text-purple-700 mb-2">{{ $stats['total_members'] ?? 0 }}</div>
                <div class="text-gray-600">Total Board Members</div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-4xl font-bold text-purple-700 mb-2">{{ $stats['countries'] ?? 0 }}</div>
                <div class="text-gray-600">Countries Represented</div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-4xl font-bold text-purple-700 mb-2">{{ $stats['institutions'] ?? 0 }}</div>
                <div class="text-gray-600">Institutions</div>
            </div>
        </div>

        <!-- Search Form -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-12">
            <form action="{{ route('journal.editorial-board') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Search by name, affiliation, or role..." 
                        value="{{ request('search') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                    >
                </div>
                <button 
                    type="submit" 
                    class="px-8 py-3 bg-purple-700 text-white rounded-lg hover:bg-purple-800 transition-colors font-semibold"
                >
                    Search
                </button>
            </form>
        </div>

        <!-- Editorial Board Members by Role -->
        @forelse($orderedMembers as $role => $members)
            <div class="mb-16">
                <!-- Role Header -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2 pb-3 border-b-4 border-purple-600 inline-block">
                        {{ $role }}
                    </h2>
                    <p class="text-gray-600 mt-3">{{ $members->count() }} {{ Str::plural('member', $members->count()) }}</p>
                </div>

                <!-- Members List - Horizontal Layout -->
                <div class="space-y-6">
                    @foreach($members as $member)
                        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                            <!-- Horizontal Layout: Photo | Contact Details | Bio -->
                            <div class="flex flex-col lg:flex-row">
                                
                                <!-- Member Photo Section -->
                                <div class="bg-gradient-to-br from-purple-100 to-purple-50 p-6 lg:p-8 flex items-center justify-center lg:w-64 flex-shrink-0">
                                    @if($member->photo)
                                        <img 
                                            src="{{ Storage::url($member->photo) }}" 
                                            alt="{{ $member->name }}"
                                            class="w-40 h-40 lg:w-48 lg:h-48 rounded-full object-cover border-4 border-white shadow-lg"
                                        >
                                    @else
                                        <div class="w-40 h-40 lg:w-48 lg:h-48 rounded-full bg-purple-200 flex items-center justify-center border-4 border-white shadow-lg">
                                            <span class="text-5xl lg:text-6xl font-bold text-purple-700">
                                                {{ strtoupper(substr($member->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Contact Details Section -->
                                <div class="p-6 lg:p-8 lg:w-80 xl:w-96 flex-shrink-0 border-b lg:border-b-0 lg:border-r border-gray-200">
                                    <h3 class="text-xl lg:text-2xl font-bold text-gray-900 mb-2">
                                        {{ $member->name }}
                                    </h3>

                                    @if($member->qualifications)
                                        <p class="text-sm text-gray-600 mb-4 font-medium">{{ $member->qualifications }}</p>
                                    @endif

                                    <div class="space-y-3 text-sm">
                                        @if($member->affiliation)
                                            <div class="flex items-start">
                                                <svg class="w-5 h-5 text-purple-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                                <span class="text-gray-700 leading-relaxed">{{ $member->affiliation }}</span>
                                            </div>
                                        @endif

                                        @if($member->country)
                                            <div class="flex items-start">
                                                <svg class="w-5 h-5 text-purple-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                <span class="text-gray-700">{{ $member->country }}</span>
                                            </div>
                                        @endif

                                        @if($member->email)
                                            <div class="flex items-start">
                                                <svg class="w-5 h-5 text-purple-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                                <a href="mailto:{{ $member->email }}" class="text-purple-600 hover:text-purple-800 hover:underline break-all">
                                                    {{ $member->email }}
                                                </a>
                                            </div>
                                        @endif

                                        @if($member->phone)
                                            <div class="flex items-start">
                                                <svg class="w-5 h-5 text-purple-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                </svg>
                                                <span class="text-gray-700">{{ $member->phone }}</span>
                                            </div>
                                        @endif

                                        @if($member->orcid)
                                            <div class="flex items-start">
                                                <svg class="w-5 h-5 text-purple-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 0C5.372 0 0 5.372 0 12s5.372 12 12 12 12-5.372 12-12S18.628 0 12 0zM7.369 8.378c.525 0 .947.431.947.947a.95.95 0 01-.947.947.95.95 0 01-.947-.947c0-.525.422-.947.947-.947zm-.722 3.038h1.444v6.272H6.647v-6.272zm3.562 0h3.9c1.303 0 2.344.84 2.344 2.712 0 1.872-1.041 3.019-2.344 3.019h-2.456v-2.531h2.109c.497 0 .769-.272.769-.788 0-.516-.272-.788-.769-.788h-2.109v5.378H10.21v-6.272z"></path>
                                                </svg>
                                                <a href="https://orcid.org/{{ $member->orcid }}" target="_blank" rel="noopener" class="text-purple-600 hover:text-purple-800 hover:underline">
                                                    {{ $member->orcid }}
                                                </a>
                                            </div>
                                        @endif

                                        @if($member->website)
                                            <div class="flex items-start">
                                                <svg class="w-5 h-5 text-purple-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                                </svg>
                                                <a href="{{ $member->website }}" target="_blank" rel="noopener" class="text-purple-600 hover:text-purple-800 hover:underline break-all">
                                                    Website
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    @if($member->research_interests)
                                        <div class="mt-4 pt-4 border-t border-gray-200">
                                            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Research Interests</h4>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach(explode(',', $member->research_interests) as $interest)
                                                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-medium">
                                                        {{ trim($interest) }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Bio Section -->
                                <div class="p-6 lg:p-8 flex-1">
                                    @if($member->bio)
                                        <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Biography</h4>
                                        <div class="text-gray-700 leading-relaxed prose prose-sm max-w-none">
                                            {!! nl2br(e($member->bio)) !!}
                                        </div>
                                    @else
                                        <div class="flex items-center justify-center h-full text-gray-400">
                                            <p class="text-sm italic">No biography available</p>
                                        </div>
                                    @endif

                                    @if($member->publications_count && $member->publications_count > 0)
                                        <div class="mt-6 pt-4 border-t border-gray-200">
                                            <div class="flex items-center text-sm text-gray-600">
                                                <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                                <span class="font-semibold">{{ $member->publications_count }}</span>
                                                <span class="ml-1">{{ Str::plural('publication', $member->publications_count) }}</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <!-- No Members Found -->
            <div class="text-center py-12">
                <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Board Members Found</h3>
                <p class="text-gray-600">
                    @if(request('search'))
                        No members match your search criteria.
                    @else
                        The editorial board information will be available soon.
                    @endif
                </p>
            </div>
        @endforelse

    </div>
</div>
@endsection