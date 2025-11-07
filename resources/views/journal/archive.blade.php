@extends('layouts.journal')

@section('title', 'Archive - African Annals of Health Sciences')

@push('meta')
<meta name="description" content="Browse all volumes and issues of African Annals of Health Sciences. Access published articles from our complete archive.">
<meta name="keywords" content="journal archive, health sciences publications, medical research, African health research">
@endpush

@section('content')
<!-- Page Header -->
<div class="bg-gradient-to-r from-purple-700 to-indigo-800 text-white py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl">
            <h1 class="text-4xl md:text-5xl font-bold font-serif mb-4">Journal Archive</h1>
            <p class="text-lg text-purple-100">
                Browse all published volumes and issues of African Annals of Health Sciences
            </p>
        </div>
    </div>
</div>

<!-- Filters Section -->
<div class="bg-white border-b border-gray-200 shadow-sm">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <form method="GET" action="{{ route('journal.archive') }}" class="flex flex-col sm:flex-row gap-4">
            <!-- Year Filter -->
            <div class="flex-1">
                <label for="year" class="block text-sm font-medium text-gray-700 mb-2">
                    Filter by Year
                </label>
                <select name="year" id="year" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">All Years</option>
                    @foreach($availableYears as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Keyword Filter -->
            <div class="flex-1">
                <label for="keyword" class="block text-sm font-medium text-gray-700 mb-2">
                    Search by Keyword
                </label>
                <input type="text" 
                       name="keyword" 
                       id="keyword" 
                       value="{{ request('keyword') }}"
                       placeholder="Enter keyword..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>

            <!-- Action Buttons -->
            <div class="flex items-end gap-2">
                <button type="submit" 
                        class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200 font-medium">
                    <i class="fas fa-filter mr-2"></i>Apply Filters
                </button>
                @if(request('year') || request('keyword'))
                    <a href="{{ route('journal.archive') }}" 
                       class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                        <i class="fas fa-times mr-2"></i>Clear
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Archive Content -->
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($volumes->isEmpty())
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="mx-auto h-24 w-24 text-gray-400 mb-6">
                <i class="fas fa-archive text-7xl"></i>
            </div>
            <h3 class="text-2xl font-semibold text-gray-900 mb-2">No Volumes Found</h3>
            <p class="text-gray-600 mb-6">
                @if(request('year') || request('keyword'))
                    No volumes match your search criteria. Try adjusting your filters.
                @else
                    The journal archive is currently empty. Check back soon for published content.
                @endif
            </p>
            @if(request('year') || request('keyword'))
                <a href="{{ route('journal.archive') }}" 
                   class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200 font-medium">
                    <i class="fas fa-times-circle mr-2"></i>Clear Filters
                </a>
            @endif
        </div>
    @else
        <!-- Results Summary -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">
                {{ $volumes->count() }} {{ Str::plural('Volume', $volumes->count()) }} Found
            </h2>
            @if(request('year') || request('keyword'))
                <p class="text-gray-600">
                    Showing results for
                    @if(request('year'))
                        <span class="font-medium text-purple-700">{{ request('year') }}</span>
                    @endif
                    @if(request('year') && request('keyword'))
                        and
                    @endif
                    @if(request('keyword'))
                        keyword: <span class="font-medium text-purple-700">"{{ request('keyword') }}"</span>
                    @endif
                </p>
            @endif
        </div>

        <!-- Volumes Accordion -->
        <div class="space-y-6">
            @foreach($volumes as $volume)
                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-200">
                    <!-- Volume Header (Accordion Toggle) -->
                    <button type="button" 
                            class="accordion-toggle w-full px-6 py-5 text-left focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-inset"
                            aria-expanded="false"
                            aria-controls="volume-{{ $volume->id }}-content">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-4 mb-2">
                                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold">
                                        Volume {{ $volume->number }}
                                    </span>
                                    <span class="text-gray-600 text-sm">
                                        {{ $volume->year }}
                                    </span>
                                    <span class="text-gray-400 text-sm">
                                        {{ $volume->issues->count() }} {{ Str::plural('Issue', $volume->issues->count()) }}
                                    </span>
                                </div>
                                @if($volume->title)
                                    <h3 class="text-xl font-bold text-gray-900">{{ $volume->title }}</h3>
                                @endif
                                @if($volume->description)
                                    <p class="text-gray-600 mt-2">{{ Str::limit($volume->description, 150) }}</p>
                                @endif
                            </div>
                            <div class="ml-4">
                                <i class="fas fa-chevron-down accordion-icon text-gray-400 text-xl transition-transform duration-300"></i>
                            </div>
                        </div>
                    </button>

                    <!-- Volume Content (Issues) -->
                    <div id="volume-{{ $volume->id }}-content" 
                         class="hidden transition-all duration-300 ease-in-out overflow-hidden"
                         style="max-height: 0;">
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                            @if($volume->issues->isEmpty())
                                <p class="text-gray-500 text-center py-8">No issues published yet for this volume.</p>
                            @else
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    @foreach($volume->issues as $issue)
                                        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:border-purple-300 hover:shadow-md transition-all duration-200">
                                            <div class="flex">
                                                <!-- Issue Cover Image -->
                                                @if($issue->cover_image)
                                                    <div class="w-32 flex-shrink-0">
                                                        <a href="{{ route('journal.issue', [$volume->number, $issue->number]) }}">
                                                            <img src="{{ Storage::url($issue->cover_image) }}" 
                                                                 alt="Issue {{ $issue->number }} Cover"
                                                                 class="w-full h-full object-cover">
                                                        </a>
                                                    </div>
                                                @endif

                                                <!-- Issue Details -->
                                                <div class="flex-1 p-4">
                                                    <div class="flex items-center gap-2 mb-2">
                                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-semibold">
                                                            Issue {{ $issue->number }}
                                                        </span>
                                                        <span class="text-gray-500 text-xs">
                                                            {{ $issue->publication_date->format('F Y') }}
                                                        </span>
                                                    </div>

                                                    @if($issue->title)
                                                        <h4 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                                                            {{ $issue->title }}
                                                        </h4>
                                                    @endif

                                                    @if($issue->description)
                                                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                                            {{ $issue->description }}
                                                        </p>
                                                    @endif

                                                    <!-- Article Count -->
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-sm text-gray-500">
                                                            <i class="fas fa-file-alt mr-1"></i>
                                                            {{ $issue->articles->count() }} {{ Str::plural('article', $issue->articles->count()) }}
                                                        </span>
                                                        <a href="{{ route('journal.issue', [$volume->number, $issue->number]) }}" 
                                                           class="text-purple-600 hover:text-purple-800 text-sm font-medium transition-colors duration-200">
                                                            View Issue <i class="fas fa-arrow-right ml-1"></i>
                                                        </a>
                                                    </div>

                                                    <!-- Article List (Expandable) -->
                                                    @if($issue->articles->isNotEmpty())
                                                        <div class="mt-4 pt-4 border-t border-gray-100">
                                                            <details class="group">
                                                                <summary class="cursor-pointer text-sm font-medium text-gray-700 hover:text-purple-600 transition-colors duration-200 list-none flex items-center justify-between">
                                                                    <span>View Articles</span>
                                                                    <i class="fas fa-chevron-down group-open:rotate-180 transition-transform duration-200 text-gray-400"></i>
                                                                </summary>
                                                                <div class="mt-3 space-y-3">
                                                                    @foreach($issue->articles as $article)
                                                                        <div class="pl-3 border-l-2 border-purple-200">
                                                                            <a href="{{ route('journal.article.show', $article->slug) }}" 
                                                                               class="text-sm font-medium text-gray-900 hover:text-purple-600 transition-colors duration-200 line-clamp-2">
                                                                                {{ $article->title }}
                                                                            </a>
                                                                            <p class="text-xs text-gray-600 mt-1">
                                                                                {{ $article->authors->pluck('name')->join(', ') }}
                                                                            </p>
                                                                            @if($article->page_start && $article->page_end)
                                                                                <p class="text-xs text-gray-500 mt-1">
                                                                                    Pages {{ $article->page_start }}-{{ $article->page_end }}
                                                                                </p>
                                                                            @endif
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </details>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Statistics Section -->
        <div class="mt-12 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-lg p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Archive Statistics</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-3xl mx-auto">
                <div class="text-center">
                    <div class="text-4xl font-bold text-purple-700 mb-2">
                        {{ $volumes->count() }}
                    </div>
                    <div class="text-gray-600 font-medium">
                        Total Volumes
                    </div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-indigo-700 mb-2">
                        {{ $volumes->sum(function($v) { return $v->issues->count(); }) }}
                    </div>
                    <div class="text-gray-600 font-medium">
                        Total Issues
                    </div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-green-700 mb-2">
                        {{ $volumes->sum(function($v) { return $v->issues->sum(function($i) { return $i->articles->count(); }); }) }}
                    </div>
                    <div class="text-gray-600 font-medium">
                        Published Articles
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Call to Action Section -->
<div class="bg-gray-900 text-white py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h3 class="text-3xl font-bold mb-4">Stay Updated</h3>
        <p class="text-gray-300 mb-6 max-w-2xl mx-auto">
            Subscribe to receive notifications about new issues and articles in African Annals of Health Sciences
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('journal.about') }}" 
               class="inline-flex items-center justify-center px-6 py-3 bg-white text-gray-900 rounded-lg hover:bg-gray-100 transition-colors duration-200 font-medium">
                <i class="fas fa-info-circle mr-2"></i>About the Journal
            </a>
            <a href="{{ route('journal.submission') }}" 
               class="inline-flex items-center justify-center px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200 font-medium">
                <i class="fas fa-paper-plane mr-2"></i>Submit Your Manuscript
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Line clamping utility */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Smooth accordion transitions */
.accordion-toggle {
    transition: background-color 0.2s ease;
}

.accordion-toggle:hover {
    background-color: rgba(243, 244, 246, 0.5);
}

/* Accordion icon rotation */
.accordion-icon {
    transition: transform 0.3s ease;
}
</style>
@endpush

@push('scripts')
<script>

document.addEventListener('DOMContentLoaded', function() {
    // Auto-expand first volume if no filters are applied
    @if(!request('year') && !request('keyword') && $volumes->isNotEmpty())
        const firstToggle = document.querySelector('.accordion-toggle');
        if (firstToggle) {
            firstToggle.click();
        }
    @endif

    // Smooth scroll to volume if coming from a link with hash
    if (window.location.hash) {
        const target = document.querySelector(window.location.hash);
        if (target) {
            setTimeout(() => {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 300);
        }
    }
});
</script>
@endpush