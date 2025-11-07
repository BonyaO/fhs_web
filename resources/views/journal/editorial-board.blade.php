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
            <form action="{{ route('journal.editorial-board') }}" method="GET" class="flex gap-4">
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

                <!-- Members Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($members as $member)
                        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                            <!-- Member Photo -->
                            <div class="bg-gradient-to-br from-purple-100 to-purple-50 p-6 flex justify-center">
                                @if($member->photo)
                                    <img 
                                        src="{{ Storage::url($member->photo) }}" 
                                        alt="{{ $member->name }}"
                                        class="w-40 h-40 rounded-full object-cover border-4 border-white shadow-lg"
                                    >
                                @else
                                    <div class="w-40 h-40 rounded-full bg-purple-200 flex items-center justify-center border-4 border-white shadow-lg">
                                        <span class="text-5xl font-bold text-purple-700">
                                            {{ strtoupper(substr($member->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Member Info -->
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">
                                    {{ $member->name }}
                                </h3>

                                @if($member->qualifications)
                                    <p class="text-sm text-gray-600 mb-3">{{ $member->qualifications }}</p>
                                @endif

                                <div class="space-y-2 text-sm">
                                    @if($member->affiliation)
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 text-purple-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            <span class="text-gray-700">{{ $member->affiliation }}</span>
                                        </div>
                                    @endif

                                    @if($member->country)
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 text-purple-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span class="text-gray-700">{{ $member->country }}</span>
                                        </div>
                                    @endif

                                    @if($member->email)
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 text-purple-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            <a href="mailto:{{ $member->email }}" class="text-purple-600 hover:text-purple-800 hover:underline break-all">
                                                {{ $member->email }}
                                            </a>
                                        </div>
                                    @endif

                                    @if($member->orcid)
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 text-purple-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 0C5.372 0 0 5.372 0 12s5.372 12 12 12 12-5.372 12-12S18.628 0 12 0zM7.369 8.24c.56 0 1.013-.453 1.013-1.012 0-.56-.453-1.013-1.013-1.013-.56 0-1.013.453-1.013 1.013 0 .56.453 1.012 1.013 1.012zm-.44 1.567v7.118h1.773V9.807H6.93zm3.67 0v7.118h1.773v-3.846c0-1.627.926-2.523 2.177-2.523 1.23 0 1.947.796 1.947 2.223v4.146h1.773v-4.413c0-2.224-1.25-3.705-3.32-3.705-1.447 0-2.417.73-2.817 1.567h-.04V9.807h-1.493z"/>
                                            </svg>
                                            <a href="https://orcid.org/{{ $member->orcid }}" target="_blank" rel="noopener" class="text-purple-600 hover:text-purple-800 hover:underline">
                                                {{ $member->orcid }}
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                @if($member->bio)
                                    <div class="mt-4 pt-4 border-t border-gray-200">
                                        <p class="text-sm text-gray-600 line-clamp-4">{{ $member->bio }}</p>
                                    </div>
                                @endif

                                @if($member->expertise)
                                    <div class="mt-4">
                                        <p class="text-xs font-semibold text-gray-700 mb-2">Areas of Expertise:</p>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach(explode(',', $member->expertise) as $area)
                                                <span class="inline-block bg-purple-100 text-purple-700 text-xs px-2 py-1 rounded">
                                                    {{ trim($area) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Board Members Found</h3>
                <p class="text-gray-600 mb-4">
                    @if(request('search'))
                        No board members match your search criteria.
                    @else
                        The editorial board information is currently being updated.
                    @endif
                </p>
                @if(request('search'))
                    <a href="{{ route('journal.editorial-board') }}" class="inline-block px-6 py-3 bg-purple-700 text-white rounded-lg hover:bg-purple-800 transition-colors">
                        View All Board Members
                    </a>
                @endif
            </div>
        @endforelse

        <!-- Contact Section -->
        <div class="mt-16 bg-gradient-to-r from-purple-700 to-purple-900 rounded-lg shadow-xl p-8 text-white">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl font-bold mb-4">Join Our Editorial Team</h2>
                <p class="text-lg text-purple-100 mb-6">
                    We are always looking for qualified experts to join our editorial board and contribute to advancing health sciences research in Africa.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('journal.about') }}" class="inline-block px-8 py-3 bg-white text-purple-700 rounded-lg hover:bg-purple-50 transition-colors font-semibold">
                        Learn More About Us
                    </a>
                    <a href="mailto:editor@africanannals.org" class="inline-block px-8 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-500 transition-colors font-semibold">
                        Contact Editorial Office
                    </a>
                </div>
            </div>
        </div>

        <!-- Back to Top Button -->
        <div class="mt-12 text-center">
            <button 
                onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
                class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                </svg>
                Back to Top
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add smooth scroll behavior for back to top
    document.addEventListener('DOMContentLoaded', function() {
        // Optional: Show/hide back to top button based on scroll position
        const backToTopBtn = document.querySelector('button[onclick*="scrollTo"]');
        if (backToTopBtn) {
            window.addEventListener('scroll', function() {
                if (window.scrollY > 300) {
                    backToTopBtn.classList.remove('opacity-0');
                } else {
                    backToTopBtn.classList.add('opacity-0');
                }
            });
        }
    });
</script>
@endpush