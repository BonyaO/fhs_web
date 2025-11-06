@extends('layouts.journal')

@section('title', $article->title . ' - African Annals of Health Sciences')

@section('meta')
    {{-- Google Scholar Meta Tags --}}
    <meta name="citation_title" content="{{ $article->title }}">
    <meta name="citation_journal_title" content="African Annals of Health Sciences">
    @foreach($article->authors as $author)
    <meta name="citation_author" content="{{ $author->name }}">
    <meta name="citation_author_institution" content="{{ $author->affiliation }}">
    @endforeach
    <meta name="citation_publication_date" content="{{ $article->publication_date?->format('Y/m/d') }}">
    <meta name="citation_volume" content="{{ $article->issue->volume->number }}">
    <meta name="citation_issue" content="{{ $article->issue->number }}">
    @if($article->page_start && $article->page_end)
    <meta name="citation_firstpage" content="{{ $article->page_start }}">
    <meta name="citation_lastpage" content="{{ $article->page_end }}">
    @endif
    @if($article->doi)
    <meta name="citation_doi" content="{{ $article->doi }}">
    @endif
    @if($article->primaryFile)
    <meta name="citation_pdf_url" content="{{ $article->primaryFile->url }}">
    @endif
    

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $article->title }}">
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($article->abstract), 200) }}">
    
    {{-- Schema.org Structured Data --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ScholarlyArticle",
        "headline": "{{ $article->title }}",
        "description": "{{ Str::limit(strip_tags($article->abstract), 500) }}",
        "author": [
            @foreach($article->authors as $index => $author)
            {
                "@type": "Person",
                "name": "{{ $author->name }}",
                "affiliation": {
                    "@type": "Organization",
                    "name": "{{ $author->affiliation }}"
                }
            }{{ $loop->last ? '' : ',' }}
            @endforeach
        ],
        "datePublished": "{{ $article->publication_date?->toIso8601String() }}",
        "isPartOf": {
            "@type": "PublicationIssue",
            "issueNumber": "{{ $article->issue->number }}",
            "isPartOf": {
                "@type": "PublicationVolume",
                "volumeNumber": "{{ $article->issue->volume->number }}",
                "isPartOf": {
                    "@type": "Periodical",
                    "name": "African Annals of Health Sciences"
                }
            }
        }
        @if($article->doi)
        ,"identifier": "https://doi.org/{{ $article->doi }}"
        @endif
    }
    </script>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Breadcrumbs --}}
    <nav class="mb-6 text-sm" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-gray-600">
            <li><a href="{{ route('journal.home') }}" class="hover:text-primary-600">Home</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('journal.archive') }}" class="hover:text-primary-600">Archive</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('journal.issue', [$article->issue->volume->number, $article->issue->number]) }}" class="hover:text-primary-600">
                Vol {{ $article->issue->volume->number }}, Issue {{ $article->issue->number }}
            </a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-900 font-medium">Article</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Main Content --}}
        <div class="lg:col-span-2">
            {{-- Article Type Badge --}}
            @if($article->article_type)
            <div class="mb-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-primary-800">
                    {{ $article->article_type }}
                </span>
            </div>
            @endif

            {{-- Article Title --}}
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 leading-tight">
                {{ $article->title }}
            </h1>

            {{-- Authors --}}
            <div class="mb-6">
                <div class="flex flex-wrap items-center gap-2">
                    @foreach($article->authors as $author)
                    <div class="group">
                        <a href="{{ route('journal.author', $author->id) }}" 
                           class="text-primary-700 hover:text-primary-900 font-medium transition-colors">
                            {{ $author->full_name }}@if($author->pivot->author_order > 0)<sup>{{ $author->pivot->author_order }}</sup>@endif</a>@if(!$loop->last)<span class="text-gray-500">,</span>@endif
                    </div>
                    @endforeach
                </div>
                
                {{-- Affiliations --}}
                <div class="mt-3 text-sm text-gray-600 space-y-1">
                    @foreach($article->authors as $author)
                    <div class="flex items-start">
                        <span class="mr-1">@if($author->pivot->author_order > 0)<sup>{{ $author->pivot->author_order }}</sup>@endif</span>
                        <span class="italic">{{ $author->pivot->affiliation_at_time ?? $author->affiliation }}</span>
                    </div>
                    @endforeach
                </div>

                {{-- Correspondence --}}
                @php
                    $correspondingAuthor = $article->correspondingAuthor();
                @endphp
                @if($correspondingAuthor)
                <div class="mt-3 text-sm text-gray-600">
                    <strong>*Correspondence:</strong> {{ $correspondingAuthor->full_name }}
                    @if($correspondingAuthor->email)
                    <br>Email: <a href="mailto:{{ $correspondingAuthor->email }}" class="text-primary-600 hover:text-primary-800">{{ $correspondingAuthor->email }}</a>
                    @endif
                </div>
                @endif
            </div>

            {{-- Publication Info --}}
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6 text-sm">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <div class="text-gray-500 font-medium">Volume</div>
                        <div class="text-gray-900">{{ $article->issue->volume->number }}</div>
                    </div>
                    <div>
                        <div class="text-gray-500 font-medium">Issue</div>
                        <div class="text-gray-900">{{ $article->issue->number }}</div>
                    </div>
                    @if($article->page_start && $article->page_end)
                    <div>
                        <div class="text-gray-500 font-medium">Pages</div>
                        <div class="text-gray-900">{{ $article->page_start }}-{{ $article->page_end }}</div>
                    </div>
                    @endif
                    <div>
                        <div class="text-gray-500 font-medium">Published</div>
                        <div class="text-gray-900">{{ $article->publication_date?->format('M d, Y') ?? 'In Press' }}</div>
                    </div>
                </div>
                
                @if($article->submission_date || $article->acceptance_date)
                <div class="mt-4 pt-4 border-t border-gray-200 grid grid-cols-2 gap-4">
                    @if($article->submission_date)
                    <div>
                        <div class="text-gray-500 font-medium">Received</div>
                        <div class="text-gray-900">{{ $article->submission_date->format('M d, Y') }}</div>
                    </div>
                    @endif
                    @if($article->acceptance_date)
                    <div>
                        <div class="text-gray-500 font-medium">Accepted</div>
                        <div class="text-gray-900">{{ $article->acceptance_date->format('M d, Y') }}</div>
                    </div>
                    @endif
                </div>
                @endif

                @if($article->doi)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <div class="text-gray-500 font-medium mb-1">DOI</div>
                    <a href="https://doi.org/{{ $article->doi }}" target="_blank" class="text-primary-600 hover:text-primary-800 break-all">
                        https://doi.org/{{ $article->doi }}
                    </a>
                </div>
                @endif
            </div>

            {{-- Article Metrics --}}
            <div class="flex items-center gap-6 mb-6 text-sm text-gray-600">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span><strong>{{ number_format($article->view_count) }}</strong> views</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span><strong>{{ number_format($article->download_count) }}</strong> downloads</span>
                </div>
            </div>

            {{-- Abstract --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Abstract</h2>
                <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                    {!! nl2br(e($article->abstract)) !!}
                </div>
            </div>

            {{-- Keywords --}}
            @if($article->keywords)
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-900 mb-3">Keywords</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($article->keywords_array as $keyword)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        {{ $keyword }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Download Button --}}
            @if($article->primaryFile)
            <div class="mb-8">
                <a href="{{ route('journal.article.download', $article->slug) }}" 
                   class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition-colors shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Download PDF
                </a>
                <span class="ml-3 text-sm text-gray-600">({{ $article->primaryFile->human_file_size }})</span>
            </div>
            @endif

            {{-- Citations Section (Expandable) --}}
            <div class="border border-gray-200 rounded-lg mb-8">
                <button onclick="toggleSection('citations')" 
                        class="w-full flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 transition-colors rounded-lg">
                    <h3 class="text-lg font-bold text-gray-900">How to Cite This Article</h3>
                    <svg id="citations-icon" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                
                <div id="citations-content" class="hidden p-4 space-y-4">
                    {{-- APA Format --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-semibold text-gray-900">APA</h4>
                            <button onclick="copyCitation('apa')" 
                                    class="text-sm text-primary-600 hover:text-primary-800 font-medium">
                                Copy
                            </button>
                        </div>
                        <div id="citation-apa" class="p-3 bg-gray-50 rounded text-sm text-gray-700 font-mono overflow-x-auto">
                            {{ $citations['apa'] }}
                        </div>
                    </div>

                    {{-- MLA Format --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-semibold text-gray-900">MLA</h4>
                            <button onclick="copyCitation('mla')" 
                                    class="text-sm text-primary-600 hover:text-primary-800 font-medium">
                                Copy
                            </button>
                        </div>
                        <div id="citation-mla" class="p-3 bg-gray-50 rounded text-sm text-gray-700 font-mono overflow-x-auto">
                            {{ $citations['mla'] }}
                        </div>
                    </div>

                    {{-- Chicago Format --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-semibold text-gray-900">Chicago</h4>
                            <button onclick="copyCitation('chicago')" 
                                    class="text-sm text-primary-600 hover:text-primary-800 font-medium">
                                Copy
                            </button>
                        </div>
                        <div id="citation-chicago" class="p-3 bg-gray-50 rounded text-sm text-gray-700 font-mono overflow-x-auto">
                            {{ $citations['chicago'] }}
                        </div>
                    </div>

                    {{-- BibTeX Format --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-semibold text-gray-900">BibTeX</h4>
                            <button onclick="copyCitation('bibtex')" 
                                    class="text-sm text-primary-600 hover:text-primary-800 font-medium">
                                Copy
                            </button>
                        </div>
                        <div id="citation-bibtex" class="p-3 bg-gray-50 rounded text-sm text-gray-700 font-mono overflow-x-auto whitespace-pre">{{ $citations['bibtex'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-1">
            {{-- Issue Information --}}
            <div class="bg-white border border-gray-200 rounded-lg p-5 mb-6 shadow-sm">
                <h3 class="font-bold text-gray-900 mb-3">Issue Information</h3>
                @if($article->issue->cover_image)
                <a href="{{ route('journal.issue', [$article->issue->volume->number, $article->issue->number]) }}">
                    <img src="{{ asset($article->issue->cover_image) }}" 
                         alt="Issue Cover" 
                         class="w-full rounded-lg mb-3 hover:opacity-90 transition-opacity">
                </a>
                @endif
                <div class="text-sm text-gray-700 space-y-2">
                    <div>
                        <strong>Volume {{ $article->issue->volume->number }}</strong>, 
                        Issue {{ $article->issue->number }}
                    </div>
                    <div>{{ $article->issue->publication_date?->format('F Y') }}</div>
                    <a href="{{ route('journal.issue', [$article->issue->volume->number, $article->issue->number]) }}" 
                       class="inline-block mt-2 text-primary-600 hover:text-primary-800 font-medium">
                        View Full Issue →
                    </a>
                </div>
            </div>

            {{-- Related Articles --}}
            @if($relatedArticles && $relatedArticles->count() > 0)
            <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
                <h3 class="font-bold text-gray-900 mb-4">Related Articles</h3>
                <div class="space-y-4">
                    @foreach($relatedArticles as $related)
                    <div class="pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                        <a href="{{ route('journal.article', $related->slug) }}" 
                           class="text-sm font-medium text-gray-900 hover:text-primary-600 line-clamp-2 mb-1 block">
                            {{ $related->title }}
                        </a>
                        <div class="text-xs text-gray-600">
                            {{ $related->authors->pluck('full_name')->take(3)->join(', ') }}
                            @if($related->authors->count() > 3)
                                <span>, et al.</span>
                            @endif
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            Vol {{ $related->issue->volume->number }}, Issue {{ $related->issue->number }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Toast Notification --}}
<div id="toast" class="fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg hidden transform transition-all">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span>Citation copied to clipboard!</span>
    </div>
</div>

@push('scripts')
<script>
// Toggle expandable sections
function toggleSection(sectionId) {
    const content = document.getElementById(sectionId + '-content');
    const icon = document.getElementById(sectionId + '-icon');
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        content.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}

// Copy citation to clipboard
function copyCitation(format) {
    const citationElement = document.getElementById('citation-' + format);
    const citation = citationElement.textContent;
    
    navigator.clipboard.writeText(citation).then(() => {
        showToast();
    }).catch(err => {
        console.error('Failed to copy citation:', err);
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = citation;
        textArea.style.position = 'fixed';
        textArea.style.opacity = '0';
        document.body.appendChild(textArea);
        textArea.select();
        try {
            document.execCommand('copy');
            showToast();
        } catch (err) {
            console.error('Fallback: Failed to copy citation:', err);
        }
        document.body.removeChild(textArea);
    });
}

// Show toast notification
function showToast() {
    const toast = document.getElementById('toast');
    toast.classList.remove('hidden');
    setTimeout(() => {
        toast.classList.add('hidden');
    }, 3000);
}

// Track article view on page load
document.addEventListener('DOMContentLoaded', function() {
    // Send view tracking request
    fetch('{{ route('journal.article.track-view', $article->slug) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
    });
});
</script>
@endpush
@endsection