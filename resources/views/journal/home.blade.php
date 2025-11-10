@extends('layouts.journal')

@section('title', 'African Annals of Health Sciences - Home')
@section('meta_description', 'African Annals of Health Sciences - A peer-reviewed open access journal dedicated to advancing health sciences research in Africa.')

@section('content')
<!-- Skip to Main Content Link -->
<a href="#main-content" class="skip-to-main">Skip to main content</a>

<!-- Hero Section -->
<section class="relative text-white overflow-hidden" style="min-height: 60vh;">
    <div class="absolute inset-0">
        <img src="{{ asset('images/hero.png') }}" alt="African Annals of Health Sciences" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-black/70 via-black/50 to-black/70"></div>
    </div>

    <div class="container-default relative z-10" style="padding-top: 8rem; padding-bottom: 4rem;">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl md:text-6xl font-bold font-serif mb-6 fade-in" style="line-height: 1.1;">
                African Annals of Health Sciences
            </h1>
            <p class="text-xl md:text-2xl mb-8 fade-in-delay-1" style="color: rgba(255, 255, 255, 0.9);">
                Advancing Healthcare Research Across the African Continent
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center fade-in-delay-2">
                <a href="{{ route('journal.archive') }}" class="btn-primary btn-primary-lg">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Browse Archive
                </a>
                <a href="{{ route('journal.submission') }}" class="btn-secondary btn-primary-lg">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Submit Article
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<main id="main-content">

<!-- Latest Issue Section -->
@if($latestIssue)
<section class="journal-section-lg" style="background-color: white; margin-top: 6rem;">
    <div class="container-default">
        <div class="section-header">
            <h2 class="section-title">Latest Issue</h2>
            <p class="section-subtitle">Current research and findings from our latest publication</p>
        </div>

        <div class="max-w-5xl mx-auto">
            <div class="latest-issue-card scale-in">
                <div class="latest-issue-grid">
                    <!-- Cover Image -->
                    <div class="latest-issue-cover">
                        @if($latestIssue->cover_image)
                            <img src="{{ Storage::url($latestIssue->cover_image) }}" 
                                 alt="Volume {{ $latestIssue->volume->number }}, Issue {{ $latestIssue->number }} Cover" 
                                 class="latest-issue-cover-image">
                        @else
                            <div class="latest-issue-cover-image" style="background: linear-gradient(135deg, #E0F7F5 0%, #00B4A6 100%); display: flex; align-items: center; justify-content: center;">
                                <div class="text-center p-6">
                                    <p class="text-2xl font-bold mb-2" style="color: #065f46;">Volume {{ $latestIssue->volume->number }}</p>
                                    <p class="text-xl" style="color: #0A2540;">Issue {{ $latestIssue->number }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Issue Details -->
                    <div class="latest-issue-content">
                        <div>
                            <span class="latest-issue-badge">Latest Issue</span>
                            <h3 class="latest-issue-title">
                                Volume {{ $latestIssue->volume->number }}, Issue {{ $latestIssue->number }}
                            </h3>
                            <div class="latest-issue-meta">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>Published: {{ $latestIssue->publication_date->format('F Y') }}</span>
                            </div>

                            <div class="latest-issue-stats">
                                <div class="latest-issue-stat">
                                    <p class="latest-issue-stat-number">{{ $latestIssue->articles->count() }}</p>
                                    <p class="latest-issue-stat-label">Articles</p>
                                </div>
                                <div class="latest-issue-stat">
                                    <p class="latest-issue-stat-number">{{ $latestIssue->articles->sum(fn($a) => ($a->page_end - $a->page_start + 1)) }}</p>
                                    <p class="latest-issue-stat-label">Pages</p>
                                </div>
                                <div class="latest-issue-stat">
                                    <p class="latest-issue-stat-number">{{ $latestIssue->articles->flatMap->authors->unique('id')->count() }}</p>
                                    <p class="latest-issue-stat-label">Authors</p>
                                </div>
                            </div>
                        </div>

                        <div class="latest-issue-actions">
                            <a href="{{ route('journal.issue', [$latestIssue->volume->number, $latestIssue->number]) }}" 
                               class="btn-primary">
                                View Full Issue
                            </a>
                            <a href="{{ route('journal.issue', [$latestIssue->volume->number, $latestIssue->number]) }}#toc" 
                               class="btn-outline">
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
<section class="journal-section" style="background-color: #F8FAFC; margin-top: 5rem;">
    <div class="container-default">
        <div class="section-header">
            <h2 class="section-title">Recent Publications</h2>
            <p class="section-subtitle">Explore our latest research contributions</p>
        </div>

        @if($recentArticles->count() > 0)
            <div class="grid-articles" style="margin-bottom: 3rem;">
                @foreach($recentArticles->take(6) as $index => $article)
                    <article class="article-card fade-in-delay-{{ ($index % 3) + 1 }}" aria-labelledby="article-{{ $article->id }}-title">
                        <div class="article-card-content">
                            <!-- Article Type Badge -->
                            <span class="article-card-badge">Research Article</span>

                            <!-- Title -->
                            <h3 id="article-{{ $article->id }}-title" class="article-card-title">
                                <a href="{{ route('journal.article.show', $article->slug) }}">
                                    {{ $article->title }}
                                </a>
                            </h3>

                            <!-- Authors -->
                            <p class="article-card-authors">
                                {{ $article->authors->pluck('name')->join(', ') }}
                            </p>

                            <!-- Abstract Preview -->
                            <p class="article-card-abstract">
                                {{ Str::limit(strip_tags($article->abstract), 150) }}
                            </p>

                            <!-- Keywords -->
                            @if($article->keywords)
                                <div class="article-card-keywords">
                                    @foreach(array_slice(explode(',', $article->keywords), 0, 3) as $keyword)
                                        <span class="keyword-tag">{{ trim($keyword) }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Metadata -->
                            <div class="article-card-meta">
                                <span>Vol {{ $article->issue->volume->number }}, Issue {{ $article->issue->number }}</span>
                                <span>{{ $article->publication_date->format('M Y') }}</span>
                            </div>

                            <!-- Actions -->
                            <div class="article-card-actions">
                                <a href="{{ route('journal.article.show', $article->slug) }}" 
                                   class="btn-primary btn-primary-sm"
                                   style="flex: 1;">
                                    Read More
                                </a>
                                <a href="{{ route('journal.article.download', $article->slug) }}" 
                                   class="btn-outline btn-primary-sm"
                                   aria-label="Download PDF">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- View All Articles Button -->
            <div class="text-center">
                <a href="{{ route('journal.archive') }}" class="btn-outline btn-primary-lg">
                    View All Publications
                    <svg class="w-5 h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        @else
            <div class="text-center" style="padding: 3rem 0;">
                <svg class="w-16 h-16 mx-auto mb-4" style="color: #94A3B8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p style="color: #64748B; font-size: 1.125rem;">No articles published yet. Check back soon!</p>
            </div>
        @endif
    </div>
</section>

<!-- Statistics Section -->
<section class="journal-section" style="background-color: white; margin-top: 4rem;">
    <div class="container-default">
        <div class="max-w-4xl mx-auto">
            <div class="grid-stats">
                <div class="stat-card scale-in">
                    <div class="stat-number" data-count="{{ $stats['total_volumes'] }}">{{ $stats['total_volumes'] }}</div>
                    <div class="stat-label">Volumes</div>
                </div>
                <div class="stat-card scale-in">
                    <div class="stat-number" data-count="{{ $stats['total_issues'] }}">{{ $stats['total_issues'] }}</div>
                    <div class="stat-label">Issues</div>
                </div>
                <div class="stat-card scale-in">
                    <div class="stat-number" data-count="{{ $stats['total_articles'] }}">{{ $stats['total_articles'] }}</div>
                    <div class="stat-label">Articles</div>
                </div>
                <div class="stat-card scale-in">
                    <div class="stat-number" data-count="{{ $stats['total_downloads'] }}">{{ $stats['total_downloads'] }}</div>
                    <div class="stat-label">Downloads</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="journal-section" style="background: linear-gradient(135deg, #00B4A6 0%, #009688 100%); color: white; margin-top: 4rem;">
    <div class="container-default">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-bold font-serif mb-4">Submit Your Research</h2>
            <p class="text-xl mb-8" style="color: rgba(255, 255, 255, 0.9);">
                Join our community of researchers advancing health sciences in Africa. Submit your manuscript today.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('journal.submission') }}" class="btn-primary btn-primary-lg" style="background-color: white; color: #00B4A6;">
                    Submission Guidelines
                </a>
                <a href="{{ route('journal.about') }}" class="btn-outline btn-primary-lg" style="border-color: white; color: white;">
                    Learn More About Us
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Quick Links Section -->
<section class="journal-section" style="background-color: #F8FAFC; margin-top: 3rem;">
    <div class="container-default">
        <div class="grid-quick-links">
            <a href="{{ route('journal.about') }}" class="quick-link-card">
                <svg class="quick-link-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="quick-link-title">About the Journal</h3>
                <p class="quick-link-description">Learn about our mission, scope, and commitment to advancing health sciences research.</p>
            </a>

            <a href="{{ route('journal.editorial-board') }}" class="quick-link-card">
                <svg class="quick-link-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h3 class="quick-link-title">Editorial Board</h3>
                <p class="quick-link-description">Meet our distinguished editorial team of experts from across Africa and beyond.</p>
            </a>

            <a href="{{ route('journal.policies') }}" class="quick-link-card">
                <svg class="quick-link-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <h3 class="quick-link-title">Policies & Ethics</h3>
                <p class="quick-link-description">Read our publication policies, ethical guidelines, and open access information.</p>
            </a>
        </div>
    </div>
</section>

</main>
@endsection

@push('scripts')
<script>
// Sticky Header Scroll Detection
window.addEventListener('scroll', function() {
    const header = document.querySelector('.journal-header-sticky');
    if (header) {
        if (window.scrollY > 20) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    }
});

// Number Counter Animation (Optional)
function animateCounter(element) {
    const target = parseInt(element.getAttribute('data-count'));
    const duration = 2000;
    const increment = target / (duration / 16);
    let current = 0;
    
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            element.textContent = target;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current);
        }
    }, 16);
}

// Trigger counter animation when stats section is visible
const statsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const counters = entry.target.querySelectorAll('.stat-number[data-count]');
            counters.forEach(counter => animateCounter(counter));
            statsObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });

const statsSection = document.querySelector('.grid-stats');
if (statsSection) {
    statsObserver.observe(statsSection.parentElement);
}
</script>
@endpush