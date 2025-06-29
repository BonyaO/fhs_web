<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'FHS-UBa') | Faculty of Health Sciences</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Styles -->
    @stack('styles')
    
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #6366f1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #4f46e5;
        }

        /* Smooth transitions */
        * {
            transition: all 0.2s ease-in-out;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 dark:text-white/50">
    <!-- Header -->
    <header class="flex flex-wrap md:justify-start md:flex-nowrap z-50 w-full py-7 bg-white shadow-sm">
        <nav class="relative max-w-7xl w-full flex flex-wrap md:grid md:grid-cols-12 basis-full items-center px-4 md:px-6 lg:px-8 mx-auto"
            aria-label="Global">
            <div class="md:col-span-3">
                <!-- Logo -->
                <a class="flex-none rounded-xl text-xl inline-block font-semibold focus:outline-none focus:opacity-80"
                    href="/" aria-label="Home page">
                    <img src="{{ asset('images/uba.png') }}" width="70" alt="Faculty of Health Sciences - University of Bamenda"
                         class="h-14 w-auto">
                </a>
                <!-- End Logo -->
            </div>

            <!-- Button Group -->
            <div class="flex items-center gap-x-2 ms-auto py-1 md:ps-6 md:order-3 md:col-span-3">
                <a href="/guest/register"
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-xl border border-transparent bg-blue-400 text-black hover:bg-blue-500 transition disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 animate-pulse">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                    </svg>
                    <span>Apply today</span>
                </a>

                <div class="md">
                    <a href="/system/login"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-xl border border-gray-200 text-black bg-white hover:bg-gray-100 transition disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-100">
                        <i class="fas fa-lock"></i>
                        <span>Admin Login</span>
                    </a>
                </div>
            </div>
            <!-- End Button Group -->

            <!-- Collapse -->
            <div id="navbar-collapse-with-animation"
                class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow md:block md:w-auto md:basis-auto md:order-2 md:col-span-6">
                <div
                    class="flex flex-col gap-y-4 gap-x-0 mt-5 md:flex-row md:justify-center md:items-center md:gap-y-0 md:gap-x-7 md:mt-0">
                    <div>
                        <a class="relative inline-block text-black hover:text-blue-600 transition-colors duration-200 
                           {{ request()->is('/') ? 'text-blue-600 font-semibold' : '' }}"
                            href="/">
                            Home
                            @if(request()->is('/'))
                                <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-blue-600"></span>
                            @endif
                        </a>
                    </div>
                    <div>
                        <a class="inline-block text-black hover:text-blue-600 transition-colors duration-200"
                            href="#">Programmes</a>
                    </div>
                    <div>
                        <a class="inline-block text-black hover:text-blue-600 transition-colors duration-200"
                            href="#">Campus News</a>
                    </div>
                    <div>
                        <a class="relative inline-block text-black hover:text-blue-600 transition-colors duration-200
                           {{ request()->is('defenses*') ? 'text-blue-600 font-semibold' : '' }}"
                            href="{{ route('defenses.index') }}">
                            Defenses
                            @if(request()->is('defenses*'))
                                <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-blue-600"></span>
                            @endif
                        </a>
                    </div>
                    <div>
                        <a class="inline-block text-black hover:text-blue-600 transition-colors duration-200"
                            href="#">About</a>
                    </div>
                </div>
            </div>
            <!-- End Collapse -->
        </nav>
    </header>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <!-- University Info -->
                <div class="lg:col-span-2">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/uba.png') }}" width="60" alt="University of Bamenda" class="mr-3">
                        <div>
                            <h3 class="text-lg font-semibold">Faculty of Health Sciences</h3>
                            <p class="text-gray-400">The University of Bamenda</p>
                        </div>
                    </div>
                    <p class="text-gray-400 mb-4">
                        Excellence in health sciences education, research, and community service. 
                        Preparing future healthcare professionals to serve with competence and compassion.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="https://ubastudent.online" class="text-gray-400 hover:text-white transition-colors" target="_blank" rel="noopener">Student Portal</a></li>
                        <li><a href="https://www.uniba.cm" class="text-gray-400 hover:text-white transition-colors" target="_blank" rel="noopener">University Website</a></li>
                        <li><a href="{{ route('defenses.index') }}" class="text-gray-400 hover:text-white transition-colors">Thesis Defenses</a></li>
                        <li><a href="https://www.unibaonlinelearning.net" class="text-gray-400 hover:text-white transition-colors" target="_blank" rel="noopener">E-learning</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Student Life</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Alumni</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact</h4>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-blue-400 mt-1 mr-3"></i>
                            <div>
                                <p class="text-gray-400">University of Bamenda</p>
                                <p class="text-gray-400">P.O. Box 39, Bambili</p>
                                <p class="text-gray-400">North West Region, Cameroon</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-phone text-blue-400 mr-3"></i>
                            <p class="text-gray-400">+237  233 366 033</p>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-blue-400 mr-3"></i>
                            <p class="text-gray-400">info@uniba.cm</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-800 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">
                    © {{ date('Y') }} Faculty of Health Sciences, University of Bamenda. All rights reserved.
                </p>
                <div class="hidden flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Terms of Service</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Accessibility</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    @stack('scripts')
    
    <!-- Mobile Menu Toggle Script -->
    <script>
        // Simple mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('[data-hs-collapse]');
            const mobileMenu = document.getElementById('navbar-collapse-with-animation');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>

</html>