{{-- resources/views/partials/journal/header.blade.php --}}
<header class="journal-header-sticky">
    <div class="container-fluid">
        <div class="header-content">
            <!-- Logo & Title -->
            <div class="header-logo">
                <a href="{{ route('journal.home') }}" class="logo-link">
                    @if(file_exists(public_path('images/journal/logo.png')))
                        <img src="{{ asset('images/journal/logo.png') }}" 
                             alt="African Annals of Health Sciences Logo" 
                             class="logo-image">
                    @else
                        <div style="height: 40px; width: 40px; background: linear-gradient(135deg, #00B4A6 0%, #009688 100%); border-radius: 0.5rem; display: flex; align-items: center; justify-center;">
                            <span style="color: white; font-weight: 700; font-size: 1.25rem;">AA</span>
                        </div>
                    @endif
                    <span class="logo-text">African Annals of Health Sciences</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="header-nav" aria-label="Main navigation">
                <a href="{{ route('journal.home') }}" 
                   class="nav-link {{ request()->routeIs('journal.home') ? 'active' : '' }}"
                   @if(request()->routeIs('journal.home')) aria-current="page" @endif>
                    Home
                </a>
                <a href="{{ route('journal.about') }}" 
                   class="nav-link {{ request()->routeIs('journal.about') ? 'active' : '' }}"
                   @if(request()->routeIs('journal.about')) aria-current="page" @endif>
                    About
                </a>
                <a href="{{ route('journal.editorial-board') }}" 
                   class="nav-link {{ request()->routeIs('journal.editorial-board') ? 'active' : '' }}"
                   @if(request()->routeIs('journal.editorial-board')) aria-current="page" @endif>
                    Editorial Board
                </a>
                <a href="{{ route('journal.archive') }}" 
                   class="nav-link {{ request()->routeIs('journal.archive*') ? 'active' : '' }}"
                   @if(request()->routeIs('journal.archive*')) aria-current="page" @endif>
                    Archive
                </a>
                <a href="{{ route('journal.policies') }}" 
                   class="nav-link {{ request()->routeIs('journal.policies') ? 'active' : '' }}"
                   @if(request()->routeIs('journal.policies')) aria-current="page" @endif>
                    Policies
                </a>
            </nav>

            <!-- Actions -->
            <div class="header-actions">
                {{-- Search Button (Optional - implement search later) --}}
                <button type="button" 
                        class="search-toggle" 
                        aria-label="Search articles"
                        aria-expanded="false"
                        onclick="toggleSearch()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>

                {{-- Submit Article CTA --}}
                <a href="{{ route('journal.submission') }}" class="btn-submit-header">
                    Submit Article
                </a>
                
                {{-- Mobile Menu Toggle --}}
                <button type="button" 
                        class="mobile-menu-btn" 
                        id="mobile-menu-toggle"
                        aria-label="Open menu"
                        aria-expanded="false"
                        aria-controls="mobile-menu"
                        onclick="toggleMobileMenu()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>

{{-- Mobile Menu Overlay --}}
<div class="mobile-menu-overlay" id="mobile-menu-overlay" onclick="toggleMobileMenu()"></div>

{{-- Mobile Menu --}}
<div class="mobile-menu" id="mobile-menu" role="dialog" aria-modal="true" aria-label="Mobile navigation">
    <div style="padding: 1rem; border-bottom: 1px solid #E2E8F0; display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: 600; font-size: 1.125rem; color: #0F172A;">Menu</span>
        <button type="button" 
                onclick="toggleMobileMenu()" 
                aria-label="Close menu"
                style="padding: 0.5rem; background: none; border: none; cursor: pointer; color: #64748B;">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    <nav aria-label="Mobile navigation">
        <a href="{{ route('journal.home') }}" class="mobile-nav-link {{ request()->routeIs('journal.home') ? 'active' : '' }}">
            Home
        </a>
        <a href="{{ route('journal.about') }}" class="mobile-nav-link {{ request()->routeIs('journal.about') ? 'active' : '' }}">
            About
        </a>
        <a href="{{ route('journal.editorial-board') }}" class="mobile-nav-link {{ request()->routeIs('journal.editorial-board') ? 'active' : '' }}">
            Editorial Board
        </a>
        <a href="{{ route('journal.archive') }}" class="mobile-nav-link {{ request()->routeIs('journal.archive*') ? 'active' : '' }}">
            Archive
        </a>
        <a href="{{ route('journal.submission') }}" class="mobile-nav-link {{ request()->routeIs('journal.submission') ? 'active' : '' }}">
            For Authors
        </a>
        <a href="{{ route('journal.policies') }}" class="mobile-nav-link {{ request()->routeIs('journal.policies') ? 'active' : '' }}">
            Policies
        </a>
        <a href="{{ route('journal.submission') }}" class="mobile-nav-link" style="background-color: #E0F7F5; color: #00B4A6; font-weight: 600;">
            Submit Article
        </a>
    </nav>
</div>

{{-- Mobile Menu Styles --}}
<style>
.mobile-menu {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    width: 100%;
    max-width: 320px;
    background-color: white;
    z-index: 60;
    transform: translateX(100%);
    transition: transform 300ms ease-in-out;
    overflow-y: auto;
}

.mobile-menu.active {
    transform: translateX(0);
}

.mobile-menu-overlay {
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 50;
    opacity: 0;
    pointer-events: none;
    transition: opacity 300ms ease-in-out;
}

.mobile-menu-overlay.active {
    opacity: 1;
    pointer-events: auto;
}

.mobile-nav-link {
    display: block;
    padding: 1rem 1.5rem;
    font-size: 1.125rem;
    font-weight: 500;
    color: #0F172A;
    text-decoration: none;
    border-bottom: 1px solid #E2E8F0;
    transition: background-color 200ms ease-in-out, color 200ms ease-in-out;
}

.mobile-nav-link:hover,
.mobile-nav-link.active {
    background-color: #E0F7F5;
    color: #00B4A6;
}

.mobile-menu-btn {
    display: block;
    padding: 0.5rem;
    color: #64748B;
    background: none;
    border: none;
    cursor: pointer;
    transition: color 200ms ease-in-out;
}

.mobile-menu-btn:hover {
    color: #00B4A6;
}

@media (min-width: 768px) {
    .mobile-menu-btn {
        display: none;
    }
}
</style>

{{-- Scroll Detection Script --}}
<script>
// Sticky Header Scroll Detection
if (typeof window !== 'undefined') {
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
}

// Mobile Menu Toggle Function
function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    const overlay = document.getElementById('mobile-menu-overlay');
    const button = document.getElementById('mobile-menu-toggle');
    
    if (!menu || !overlay || !button) return;
    
    const isActive = menu.classList.contains('active');
    
    if (isActive) {
        menu.classList.remove('active');
        overlay.classList.remove('active');
        button.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    } else {
        menu.classList.add('active');
        overlay.classList.add('active');
        button.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }
}

// Search Toggle Function (Placeholder)
function toggleSearch() {
    console.log('Search clicked - implement search modal');
    // TODO: Implement search modal functionality
}

// Close mobile menu on window resize
window.addEventListener('resize', function() {
    if (window.innerWidth >= 768) {
        const menu = document.getElementById('mobile-menu');
        const overlay = document.getElementById('mobile-menu-overlay');
        const button = document.getElementById('mobile-menu-toggle');
        
        if (menu && menu.classList.contains('active')) {
            menu.classList.remove('active');
            overlay.classList.remove('active');
            button.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }
    }
});
</script>