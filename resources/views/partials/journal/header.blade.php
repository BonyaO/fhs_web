<header class="journal-header-sticky">
    <div class="container-fluid">

        <!-- Main Header -->
        <div class="header-content">
            <div class="flex items-center justify-between">
                <!-- Logo & Title -->
                <div class="flex items-center space-x-3 md:space-x-4">
                    @if(file_exists(public_path('images/journal/logo.png')))
                        <img src="{{ asset('images/journal/logo.png') }}" alt="African Annals of Health Sciences Logo" class="logo-image">
                    @else
                        <div class="h-12 w-12 md:h-16 md:w-16 bg-blue-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-xl md:text-2xl">AAHS</span>
                        </div>
                    @endif
                    <div>
                        <h1 class="logo-text">
                            <a href="{{ route('journal.home') }}" class="hover:text-blue-600 transition-colors">
                                African Annals of Health Sciences
                            </a>
                        </h1>
                        <p class="text-xs md:text-sm text-gray-600 mt-0.5">Advancing Healthcare Research in Africa</p>
                    </div>
                </div>

                <!-- Search & Mobile Menu Toggle -->
                <div class="flex items-center space-x-3">
                    <!-- Search Button (Mobile) -->
                    <button type="button" id="mobile-search-toggle" class="lg:hidden p-2 text-gray-600 hover:text-blue-600 transition-colors" aria-label="Open search">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>

                    <!-- Search Form (Desktop) -->
                    <form action="{{ route('journal.search') }}" method="GET" class="hidden lg:block">
                        <div class="relative">
                            <input 
                                type="search" 
                                name="q" 
                                placeholder="Search articles, authors..." 
                                class="pl-10 pr-4 py-2 w-64 xl:w-80 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                value="{{ request('q') }}"
                            >
                            <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" aria-label="Submit search">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </button>
                        </div>
                    </form>

                    <!-- Mobile Menu Toggle -->
                    <button type="button" id="mobile-menu-toggle" class="lg:hidden p-2 text-gray-600 hover:text-blue-600 transition-colors" aria-label="Toggle menu" aria-expanded="false">
                        <svg class="w-6 h-6" id="menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg class="w-6 h-6 hidden" id="close-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Search (Hidden by default) -->
        <div id="mobile-search" class="hidden pb-4 lg:hidden">
            <form action="{{ route('journal.search') }}" method="GET">
                <div class="relative">
                    <input 
                        type="search" 
                        name="q" 
                        placeholder="Search articles, authors..." 
                        class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        value="{{ request('q') }}"
                    >
                    <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" aria-label="Submit search">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</header>