<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>@yield('title', 'African Annals of Health Sciences')</title>
    <meta name="description" content="@yield('meta_description', 'African Annals of Health Sciences - A peer-reviewed open access journal dedicated to advancing health sciences research in Africa.')">
    
    @stack('meta')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=merriweather:300,400,700|inter:400,500,600,700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/css/journal.css'])
    
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <!-- Skip to main content for accessibility -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:px-4 focus:py-2 focus:bg-blue-600 focus:text-white focus:rounded-lg">
        Skip to main content
    </a>

    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        @include('partials.journal.header')

        <!-- Navigation -->
        @include('partials.journal.navigation')

        <!-- Main Content -->
        <main id="main-content" class="flex-grow">
            <!-- Breadcrumbs (if provided) -->
            @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
                <div class="bg-white border-b border-gray-200">
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-3">
                        <nav aria-label="Breadcrumb">
                            <ol class="flex items-center space-x-2 text-sm">
                                @foreach($breadcrumbs as $index => $crumb)
                                    @if($index > 0)
                                        <li class="text-gray-400">/</li>
                                    @endif
                                    <li>
                                        @if(isset($crumb['url']) && !$loop->last)
                                            <a href="{{ $crumb['url'] }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                                                {{ $crumb['label'] }}
                                            </a>
                                        @else
                                            <span class="text-gray-700 font-medium">{{ $crumb['label'] }}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ol>
                        </nav>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </main>

        <!-- Footer -->
        @include('partials.journal.footer')
    </div>

    <!-- Toast Notifications Container -->
    <div id="toast-container" class="fixed bottom-4 right-4 z-50 space-y-2" aria-live="polite" aria-atomic="true"></div>

    <!-- Scripts -->
    @vite(['resources/js/app.js', 'resources/js/journal.js'])
    
    @stack('scripts')
</body>
</html>