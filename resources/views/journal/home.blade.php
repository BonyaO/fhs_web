@extends('layouts.journal')

@section('title', 'African Annals of Health Sciences - Home')
@section('meta_description', 'African Annals of Health Sciences - A peer-reviewed open access journal dedicated to advancing health sciences research in Africa.')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 text-white py-16 md:py-24">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold font-serif mb-6 fade-in">
                African Annals of Health Sciences
            </h1>
            <p class="text-xl md:text-2xl text-blue-100 mb-8 fade-in-delay-1">
                Advancing Healthcare Research Across the African Continent
            </p>
            <p class="text-lg text-blue-200 mb-10 max-w-2xl mx-auto fade-in-delay-2">
                A peer-reviewed, open access journal dedicated to publishing high-quality research in all areas of health sciences relevant to Africa.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center fade-in-delay-3">
                <a href="{{ route('journal.archive') }}" class="btn btn-lg bg-white text-blue-900 hover:bg-blue-50">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Browse Archive
                </a>
                <a href="{{ route('journal.submission') }}" class="btn btn-lg btn-success">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Submit Article
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Latest Issue Section -->
@if($latestIssue)
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3 font-serif">Latest Issue</h2>
            <p class="text-gray-600">Current research and findings from our latest publication</p>
        </div>

        <div class="max-w-5xl mx-auto">
            <div class="issue-card scale-in">
                <div class="grid md:grid-cols-3 gap-8 p-6 md:p-8">
                    <!-- Cover Image -->
                    <div class="md:col-span-1">
                        @if($latestIssue->cover_image)
                            <img src="{{ Storage::url($latestIssue->cover_image) }}" 
                                 alt="Volume {{ $latestIssue->volume->number }}, Issue {{ $latestIssue->number }} Cover" 
                                 class="w-full rounded-lg shadow-lg">
                        @else
                            <div class="w-full aspect-[3/4] bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg shadow-lg flex items-center justify-center">
                                <div class="text-center p-6">
                                    <p class="text-2xl font-bold text-blue-900 mb-2">Volume {{ $latestIssue->volume->number }}</p>
                                    <p class="text-xl text-blue-800">Issue {{ $latestIssue->number }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Issue Details -->
                    <div class="md:col-span-2">
                        <div class="mb-4">
                            <span class="badge badge-primary text-sm">Latest Issue</span>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3 font-serif">
                            Volume {{ $latestIssue->volume->number }}, Issue {{ $latestIssue->number }}
                        </h3>
                        <p class="text-gray-600 mb-6">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Published: {{ $latestIssue->publication_date->format('F Y') }}
                        </p>

                        <div class="grid grid-cols-3 gap-4 mb-6 py-6 border-y border-gray-200">
                            <div class="text-center">
                                <p class="text-3xl font-bold text-blue-600">{{ $latestIssue->articles->count() }}</p>
                                <p class="text-sm text-gray-600">Articles</p>
                            </div>
                            <div class="text-center">
                                <p class="text-3xl font-bold text-blue-600">{{ $latestIssue->articles->sum(fn($a) => ($a->page_end - $a->page_start + 1)) }}</p>
                                <p class="text-sm text-gray-600">Pages</p>
                            </div>
                            <div class="text-center">
                                <p class="text-3xl font-bold text-blue-600">{{ $latestIssue->articles->flatMap->authors->unique('id')->count() }}</p>
                                <p class="text-sm text-gray-600">Authors</p>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('journal.issue', [$latestIssue->volume->number, $latestIssue->number]) }}" 
                               class="btn btn-primary">
                                View Full Issue
                            </a>
                            <a href="{{ route('journal.issue', [$latestIssue->volume->number, $latestIssue->number]) }}#toc" 
                               class="btn btn-outline">
                                Table of Contents
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Recent Articles Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3 font-serif">Recent Publications</h2>
            <p class="text-gray-600">Explore our latest research contributions</p>
        </div>

        @if($recentArticles->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 mb-8">
                @foreach($recentArticles->take(6) as $index => $article)
                    <div class="article-card article-card-hover-lift fade-in-delay-{{ ($index % 3) + 1 }}">
                        <div class="p-6">
                            <!-- Article Type Badge -->
                            <div class="mb-3">
                                <span class="badge badge-primary text-xs">Research Article</span>
                            </div>

                            <!-- Title -->
                            <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 hover:text-blue-600 transition-colors">
                                <a href="{{ route('journal.article.show', $article->slug) }}">
                                    {{ $article->title }}
                                </a>
                            </h3>

                            <!-- Authors -->
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                {{ $article->authors->pluck('name')->join(', ') }}
                            </p>

                            <!-- Abstract Preview -->
                            <p class="text-sm text-gray-700 mb-4 line-clamp-3">
                                {{ Str::limit(strip_tags($article->abstract), 150) }}
                            </p>

                            <!-- Keywords -->
                            @if($article->keywords)
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach(array_slice(explode(',', $article->keywords), 0, 3) as $keyword)
                                        <span class="keyword-tag text-xs">{{ trim($keyword) }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Metadata -->
                            <div class="flex items-center justify-between text-xs text-gray-500 mb-4 pt-4 border-t border-gray-200">
                                <span>Vol {{ $article->issue->volume->number }}, Issue {{ $article->issue->number }}</span>
                                <span>{{ $article->publication_date->format('M Y') }}</span>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2">
                                <a href="{{ route('journal.article.show', $article->slug) }}" 
                                   class="btn btn-primary btn-sm flex-1">
                                    Read More
                                </a>
                                <a href="{{ route('journal.article.download', $article->slug) }}" 
                                   class="btn btn-outline btn-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- View All Articles Button -->
            <div class="text-center">
                <a href="{{ route('journal.archive') }}" class="btn btn-outline btn-lg">
                    View All Articles
                    <svg class="w-5 h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-gray-600 text-lg">No articles published yet. Check back soon!</p>
            </div>
        @endif
    </div>
</section>

<!-- Statistics Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="stat-card scale-in">
                    <div class="stat-number" data-count="{{ $stats['total_volumes'] }}">0</div>
                    <div class="stat-label">Volumes</div>
                </div>
                <div class="stat-card scale-in">
                    <div class="stat-number" data-count="{{ $stats['total_issues'] }}">0</div>
                    <div class="stat-label">Issues</div>
                </div>
                <div class="stat-card scale-in">
                    <div class="stat-number" data-count="{{ $stats['total_articles'] }}">0</div>
                    <div class="stat-label">Articles</div>
                </div>
                <div class="stat-card scale-in">
                    <div class="stat-number" data-count="{{ $stats['total_downloads'] }}">0</div>
                    <div class="stat-label">Downloads</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-16 bg-gradient-to-r from-blue-600 to-blue-700 text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4 font-serif">Submit Your Research</h2>
            <p class="text-xl text-blue-100 mb-8">
                Join our community of researchers advancing health sciences in Africa. Submit your manuscript today.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('journal.submission') }}" class="btn btn-lg bg-white text-blue-900 hover:bg-blue-50">
                    Submission Guidelines
                </a>
                <a href="{{ route('journal.about') }}" class="btn btn-lg border-2 border-white text-white hover:bg-white hover:text-blue-900">
                    Learn More About Us
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Quick Links Section -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-3 gap-6">
            <a href="{{ route('journal.about') }}" class="block p-6 bg-white rounded-lg border border-gray-200 hover:shadow-lg hover:border-blue-300 transition-all">
                <svg class="w-10 h-10 text-blue-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">About the Journal</h3>
                <p class="text-gray-600 text-sm">Learn about our mission, scope, and commitment to advancing health sciences research.</p>
            </a>

            <a href="{{ route('journal.editorial-board') }}" class="block p-6 bg-white rounded-lg border border-gray-200 hover:shadow-lg hover:border-blue-300 transition-all">
                <svg class="w-10 h-10 text-blue-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Editorial Board</h3>
                <p class="text-gray-600 text-sm">Meet our distinguished editorial team of experts from across Africa and beyond.</p>
            </a>

            <a href="{{ route('journal.policies') }}" class="block p-6 bg-white rounded-lg border border-gray-200 hover:shadow-lg hover:border-blue-300 transition-all">
                <svg class="w-10 h-10 text-blue-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Policies & Ethics</h3>
                <p class="text-gray-600 text-sm">Read our publication policies, ethical guidelines, and open access information.</p>
            </a>
        </div>
    </div>
</section>
@endsection