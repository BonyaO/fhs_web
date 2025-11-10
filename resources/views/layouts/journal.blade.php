<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'African Annals of Health Sciences - A peer-reviewed open access journal')">
    <title>@yield('title', 'African Annals of Health Sciences')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/css/journal.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="padding-top: 64px;">

    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        @include('partials.journal.header')


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