<nav class="bg-blue-900 text-white" aria-label="Main navigation">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Desktop Navigation -->
        <div class="hidden lg:flex items-center justify-between py-3">
            <ul class="flex items-center space-x-1">
                <li>
                    <a href="{{ route('journal.home') }}" class="px-4 py-2 rounded-lg hover:bg-blue-800 transition-colors {{ request()->routeIs('journal.home') ? 'bg-blue-800 font-semibold' : '' }}">
                        Home
                    </a>
                </li>
                <li>
                    <a href="{{ route('journal.archive') }}" class="px-4 py-2 rounded-lg hover:bg-blue-800 transition-colors {{ request()->routeIs('journal.archive*') ? 'bg-blue-800 font-semibold' : '' }}">
                        Archive
                    </a>
                </li>
                <li>
                    <a href="{{ route('journal.editorial-board') }}" class="px-4 py-2 rounded-lg hover:bg-blue-800 transition-colors {{ request()->routeIs('journal.editorial-board') ? 'bg-blue-800 font-semibold' : '' }}">
                        Editorial Board
                    </a>
                </li>
                <li>
                    <a href="{{ route('journal.about') }}" class="px-4 py-2 rounded-lg hover:bg-blue-800 transition-colors {{ request()->routeIs('journal.about') ? 'bg-blue-800 font-semibold' : '' }}">
                        About
                    </a>
                </li>
                <li>
                    <a href="{{ route('journal.submission') }}" class="px-4 py-2 rounded-lg hover:bg-blue-800 transition-colors {{ request()->routeIs('journal.submission') ? 'bg-blue-800 font-semibold' : '' }}">
                        For Authors
                    </a>
                </li>
                <li>
                    <a href="{{ route('journal.policies') }}" class="px-4 py-2 rounded-lg hover:bg-blue-800 transition-colors {{ request()->routeIs('journal.policies') ? 'bg-blue-800 font-semibold' : '' }}">
                        Policies
                    </a>
                </li>
            </ul>
            <a href="{{ route('journal.submission') }}" class="px-6 py-2 bg-green-600 hover:bg-green-700 rounded-lg font-semibold transition-colors">
                Submit Article
            </a>
        </div>

        <!-- Mobile Navigation (Hidden by default) -->
        <div id="mobile-menu" class="hidden lg:hidden py-4">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('journal.home') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-800 transition-colors {{ request()->routeIs('journal.home') ? 'bg-blue-800 font-semibold' : '' }}">
                        Home
                    </a>
                </li>
                <li>
                    <a href="{{ route('journal.archive') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-800 transition-colors {{ request()->routeIs('journal.archive*') ? 'bg-blue-800 font-semibold' : '' }}">
                        Archive
                    </a>
                </li>
                <li>
                    <a href="{{ route('journal.editorial-board') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-800 transition-colors {{ request()->routeIs('journal.editorial-board') ? 'bg-blue-800 font-semibold' : '' }}">
                        Editorial Board
                    </a>
                </li>
                <li>
                    <a href="{{ route('journal.about') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-800 transition-colors {{ request()->routeIs('journal.about') ? 'bg-blue-800 font-semibold' : '' }}">
                        About
                    </a>
                </li>
                <li>
                    <a href="{{ route('journal.submission') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-800 transition-colors {{ request()->routeIs('journal.submission') ? 'bg-blue-800 font-semibold' : '' }}">
                        For Authors
                    </a>
                </li>
                <li>
                    <a href="{{ route('journal.policies') }}" class="block px-4 py-2 rounded-lg hover:bg-blue-800 transition-colors {{ request()->routeIs('journal.policies') ? 'bg-blue-800 font-semibold' : '' }}">
                        Policies
                    </a>
                </li>
                <li class="pt-2 border-t border-blue-800">
                    <a href="{{ route('journal.submission') }}" class="block px-4 py-2 bg-green-600 hover:bg-green-700 rounded-lg font-semibold text-center transition-colors">
                        Submit Article
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>