@extends('layouts.journal')

@section('title', "Volume {$issueModel->volume->number}, Issue {$issueModel->number} - African Annals of Health Sciences")

@section('meta')
<meta name="description" content="Browse Volume {{ $issueModel->volume->number }}, Issue {{ $issueModel->number }} of African Annals of Health Sciences published {{ $issueModel->publication_date->format('F Y') }}">
<meta property="og:title" content="Volume {{ $issueModel->volume->number }}, Issue {{ $issueModel->number }} - African Annals of Health Sciences">
<meta property="og:description" content="Explore all articles from Volume {{ $issueModel->volume->number }}, Issue {{ $issueModel->number }}">
@if($issueModel->cover_image)
<meta property="og:image" content="{{ asset('storage/' . $issueModel->cover_image) }}">
@endif
@endsection

@section('content')
<!-- Breadcrumbs -->
<nav class="bg-gray-50 border-b border-gray-200">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <ol class="flex items-center space-x-2 text-sm">
            @foreach($breadcrumbs as $index => $crumb)
                @if($loop->last)
                    <li class="text-gray-600 font-medium">{{ $crumb['label'] }}</li>
                @else
                    <li>
                        <a href="{{ $crumb['url'] }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                            {{ $crumb['label'] }}
                        </a>
                    </li>
                    <li class="text-gray-400">/</li>
                @endif
            @endforeach
        </ol>
    </div>
</nav>

<!-- Issue Header -->
<section class="py-12 bg-gradient-to-br from-blue-50 to-purple-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-3 gap-8 items-start">
            <!-- Issue Cover -->
            <div class="md:col-span-1">
                @if($issueModel->cover_image)
                    <img src="{{ asset('storage/' . $issueModel->cover_image) }}" 
                         alt="Volume {{ $issueModel->volume->number }}, Issue {{ $issueModel->number }} Cover"
                         class="w-full rounded-lg shadow-2xl border-4 border-white">
                @else
                    <div class="w-full aspect-[3/4] bg-gradient-to-br from-blue-600 to-purple-700 rounded-lg shadow-2xl border-4 border-white flex items-center justify-center">
                        <div class="text-center p-8">
                            <div class="text-white mb-4">
                                <svg class="w-16 h-16 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                </svg>
                            </div>
                            <p class="text-3xl font-bold text-white mb-2">Volume {{ $issueModel->volume->number }}</p>
                            <p class="text-2xl text-white opacity-90">Issue {{ $issueModel->number }}</p>
                        </div>
                    </div>
                @endif

                <!-- Quick Download Option (if full issue PDF exists) -->
                @if($issueModel->full_issue_pdf)
                    <a href="{{ route('journal.issue.download', [$issueModel->volume->number, $issueModel->number]) }}" 
                       class="mt-4 w-full btn btn-primary flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download Full Issue
                    </a>
                @endif
            </div>

            <!-- Issue Metadata -->
            <div class="md:col-span-2">
                <div class="mb-4">
                    <span class="badge badge-primary">
                        Volume {{ $issueModel->volume->number }}, Issue {{ $issueModel->number }}
                    </span>
                </div>

                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 font-serif">
                    African Annals of Health Sciences
                </h1>

                @if($issueModel->title)
                    <h2 class="text-2xl text-gray-700 mb-6 font-medium">{{ $issueModel->title }}</h2>
                @endif

                <!-- Publication Info -->
                <div class="bg-white rounded-lg p-6 shadow-md border border-gray-200 mb-6">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-600 mb-2">Publication Date</h3>
                            <p class="text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $issueModel->publication_date->format('F d, Y') }}
                            </p>
                        </div>

                        @if($issueModel->volume->year)
                            <div>
                                <h3 class="text-sm font-semibold text-gray-600 mb-2">Volume Year</h3>
                                <p class="text-gray-900">{{ $issueModel->volume->year }}</p>
                            </div>
                        @endif

                        <div>
                            <h3 class="text-sm font-semibold text-gray-600 mb-2">Total Articles</h3>
                            <p class="text-gray-900 font-bold text-lg">{{ $issueModel->articles->count() }}</p>
                        </div>

                        @if($issueModel->articles->count() > 0)
                            <div>
                                <h3 class="text-sm font-semibold text-gray-600 mb-2">Total Pages</h3>
                                <p class="text-gray-900 font-bold text-lg">
                                    {{ $issueModel->articles->sum(fn($a) => ($a->page_end - $a->page_start + 1)) }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                @if($issueModel->description)
                    <div class="prose max-w-none mb-6">
                        <p class="text-gray-700 leading-relaxed">{{ $issueModel->description }}</p>
                    </div>
                @endif

                <!-- Issue Statistics -->
                @if($issueModel->articles->count() > 0)
                    <div class="grid grid-cols-3 gap-4 py-6 border-y border-gray-200">
                        <div class="text-center">
                            <p class="text-3xl font-bold text-blue-600">{{ $issueModel->articles->count() }}</p>
                            <p class="text-sm text-gray-600">Articles</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-blue-600">
                                {{ $issueModel->articles->flatMap->authors->unique('id')->count() }}
                            </p>
                            <p class="text-sm text-gray-600">Authors</p>
                        </div>
                        <div class="text-center">
                            <p class="text-3xl font-bold text-blue-600">
                                {{ $issueModel->articles->sum(fn($a) => ($a->page_end - $a->page_start + 1)) }}
                            </p>
                            <p class="text-sm text-gray-600">Pages</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Table of Contents -->
<section class="py-16 bg-white" id="toc">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8 font-serif">Table of Contents</h2>

            @if($issueModel->articles->count() > 0)
                <div class="space-y-6">
                    @foreach($issueModel->articles as $index => $article)
                        <article class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-all duration-300 hover:border-blue-300">
                            <!-- Article Number -->
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 text-blue-600 font-bold text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                </div>

                                <div class="flex-grow">
                                    <!-- Article Type Badge -->
                                    @if($article->article_type)
                                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full mb-3
                                            {{ $article->article_type === 'original' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $article->article_type === 'review' ? 'bg-purple-100 text-purple-800' : '' }}
                                            {{ $article->article_type === 'case_report' ? 'bg-orange-100 text-orange-800' : '' }}
                                            {{ $article->article_type === 'editorial' ? 'bg-blue-100 text-blue-800' : '' }}
                                        ">
                                            {{ ucfirst(str_replace('_', ' ', $article->article_type)) }}
                                        </span>
                                    @endif

                                    <!-- Article Title -->
                                    <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-blue-600 transition-colors">
                                        <a href="{{ route('journal.article.show', $article->slug) }}" class="hover:underline">
                                            {{ $article->title }}
                                        </a>
                                    </h3>

                                    <!-- Authors -->
                                    <div class="mb-3">
                                        <p class="text-gray-700">
                                            @foreach($article->authors as $author)
                                                <a href="{{ route('journal.author', $author->slug) }}" 
                                                   class="hover:text-blue-600 hover:underline">
                                                    {{ $author->name }}
                                                </a>
                                                @if($author->pivot->is_corresponding)
                                                    <sup class="text-blue-600">*</sup>
                                                @endif
                                                @if(!$loop->last), @endif
                                            @endforeach
                                        </p>
                                    </div>

                                    <!-- Page Numbers & DOI -->
                                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-4">
                                        @if($article->page_start && $article->page_end)
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                                </svg>
                                                Pages {{ $article->page_start }}-{{ $article->page_end }}
                                            </span>
                                        @endif

                                        @if($article->doi)
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                                </svg>
                                                DOI: <a href="https://doi.org/{{ $article->doi }}" target="_blank" class="text-blue-600 hover:underline">{{ $article->doi }}</a>
                                            </span>
                                        @endif

                                        @if($article->views_count > 0)
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                {{ number_format($article->views_count) }} views
                                            </span>
                                        @endif

                                        @if($article->downloads_count > 0)
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                </svg>
                                                {{ number_format($article->downloads_count) }} downloads
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Abstract Preview -->
                                    @if($article->abstract)
                                        <div class="text-gray-600 text-sm mb-4 line-clamp-3">
                                            {{ Str::limit(strip_tags($article->abstract), 200) }}
                                        </div>
                                    @endif

                                    <!-- Action Buttons -->
                                    <div class="flex flex-wrap gap-3">
                                        <a href="{{ route('journal.article.show', $article->slug) }}" 
                                           class="btn btn-sm btn-primary">
                                            Read Article
                                        </a>
                                        
                                        @if($article->pdf_file)
                                            <a href="{{ route('journal.article.download', $article->slug) }}" 
                                               class="btn btn-sm btn-outline"
                                               target="_blank">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                Download PDF
                                            </a>
                                        @endif

                                        @if($article->keywords && is_array($article->keywords) && count($article->keywords) > 0)
                                            <button type="button" 
                                                    class="btn btn-sm btn-ghost"
                                                    onclick="toggleKeywords('keywords-{{ $article->id }}')">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                </svg>
                                                Keywords
                                            </button>
                                        @endif
                                    </div>

                                    <!-- Keywords Section (Hidden by default) -->
                                    @if($article->keywords && is_array($article->keywords) && count($article->keywords) > 0)
                                        <div id="keywords-{{ $article->id }}" class="hidden mt-4 pt-4 border-t border-gray-200">
                                            <h4 class="text-sm font-semibold text-gray-600 mb-2">Keywords:</h4>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($article->keywords as $keyword)
                                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs">
                                                        {{ $keyword }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No Articles Yet</h3>
                    <p class="text-gray-600">Articles for this issue are currently being prepared.</p>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Issue Navigation -->
@if($previousIssue || $nextIssue)
    <section class="py-12 bg-gray-50 border-t border-gray-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-5xl mx-auto">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Browse Other Issues</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    @if($previousIssue)
                        <a href="{{ route('journal.issue', [$previousIssue->volume->number, $previousIssue->number]) }}" 
                           class="group block p-6 bg-white rounded-lg border border-gray-200 hover:border-blue-300 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-center mb-3">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                <span class="text-sm text-gray-600 group-hover:text-blue-600">Previous Issue</span>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 group-hover:text-blue-600">
                                Volume {{ $previousIssue->volume->number }}, Issue {{ $previousIssue->number }}
                            </h4>
                            <p class="text-sm text-gray-600 mt-2">
                                {{ $previousIssue->publication_date->format('F Y') }}
                            </p>
                        </a>
                    @endif

                    @if($nextIssue)
                        <a href="{{ route('journal.issue', [$nextIssue->volume->number, $nextIssue->number]) }}" 
                           class="group block p-6 bg-white rounded-lg border border-gray-200 hover:border-blue-300 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-center justify-end mb-3">
                                <span class="text-sm text-gray-600 group-hover:text-blue-600">Next Issue</span>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 text-right">
                                Volume {{ $nextIssue->volume->number }}, Issue {{ $nextIssue->number }}
                            </h4>
                            <p class="text-sm text-gray-600 mt-2 text-right">
                                {{ $nextIssue->publication_date->format('F Y') }}
                            </p>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endif

<!-- Call to Action -->
<section class="py-16 bg-gradient-to-r from-blue-600 to-purple-700 text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4 font-serif">Submit Your Research</h2>
        <p class="text-xl mb-8 text-blue-100 max-w-2xl mx-auto">
            Share your research with the African health sciences community
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('journal.submission') }}" class="btn btn-white">
                Submission Guidelines
            </a>
            <a href="{{ route('journal.archive') }}" class="btn btn-outline-white">
                Browse Archive
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    function toggleKeywords(elementId) {
        const element = document.getElementById(elementId);
        if (element.classList.contains('hidden')) {
            element.classList.remove('hidden');
        } else {
            element.classList.add('hidden');
        }
    }
</script>
@endpush