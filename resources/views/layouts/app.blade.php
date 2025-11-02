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

        /* Mobile menu animations */
        .mobile-menu-open {
            transform: translateX(0);
        }
        
        .mobile-menu-closed {
            transform: translateX(-100%);
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 dark:text-white/50">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <nav class="relative max-w-7xl w-full flex items-center justify-between px-4 md:px-6 lg:px-8 mx-auto py-4"
            aria-label="Global">
            
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a class="flex-none rounded-xl text-xl inline-block font-semibold focus:outline-none focus:opacity-80"
                    href="/" aria-label="Home page">
                    <img src="{{ asset('images/uba.png') }}" width="50" height="50" alt="Faculty of Health Sciences - University of Bamenda"
                         class="h-12 w-auto md:h-14">
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex md:items-center md:space-x-8">
                <a class="relative inline-block text-gray-900 hover:text-blue-600 transition-colors duration-200 font-medium
                   {{ request()->is('/') ? 'text-blue-600 font-semibold' : '' }}"
                    href="/">
                    Home
                    @if(request()->is('/'))
                        <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-blue-600"></span>
                    @endif
                </a>
                <a class="inline-block text-gray-900 hover:text-blue-600 transition-colors duration-200 font-medium"
                    href="#">Programmes</a>
                <a class="inline-block text-gray-900 hover:text-blue-600 transition-colors duration-200 font-medium"
                    href="#">Campus News</a>
                <a class="relative inline-block text-gray-900 hover:text-blue-600 transition-colors duration-200 font-medium
                   {{ request()->is('defenses*') ? 'text-blue-600 font-semibold' : '' }}"
                    href="{{ route('defenses.index') }}">
                    Defenses
                    @if(request()->is('defenses*'))
                        <span class="absolute -bottom-1 left-0 w-full h-0.5 bg-blue-600"></span>
                    @endif
                </a>
                <a class="inline-block text-gray-900 hover:text-blue-600 transition-colors duration-200 font-medium"
                    href="#">About</a>
            </div>

            <!-- Desktop Apply Button -->
            <div class="hidden md:flex md:items-center">
                <a href="/guest/register"
                    class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 transition-all duration-200 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                    </svg>
                    <span>Apply today</span>
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button id="mobile-menu-button" type="button" 
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-900 hover:text-blue-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-colors duration-200"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Hamburger icon -->
                    <svg id="hamburger-icon" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- Close icon -->
                    <svg id="close-icon" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </nav>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="md:hidden hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t border-gray-200 shadow-lg">
                <a href="/" 
                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:text-blue-600 hover:bg-gray-50 transition-colors duration-200
                   {{ request()->is('/') ? 'text-blue-600 bg-blue-50' : '' }}">
                    Home
                </a>
                <a href="#" 
                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:text-blue-600 hover:bg-gray-50 transition-colors duration-200">
                    Programmes
                </a>
                <a href="#" 
                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:text-blue-600 hover:bg-gray-50 transition-colors duration-200">
                    Campus News
                </a>
                <a href="{{ route('defenses.index') }}" 
                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:text-blue-600 hover:bg-gray-50 transition-colors duration-200
                   {{ request()->is('defenses*') ? 'text-blue-600 bg-blue-50' : '' }}">
                    Defenses
                </a>
                <a href="#" 
                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:text-blue-600 hover:bg-gray-50 transition-colors duration-200">
                    About
                </a>
                
                <!-- Mobile Apply Button -->
                <div class="pt-4 pb-2 border-t border-gray-200 mt-4">
                    <a href="/guest/register"
                        class="block w-full py-3 px-4 text-center text-sm font-semibold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 inline mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                        </svg>
                        Apply today
                    </a>
                </div>
            </div>
        </div>
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
                        <li><a href="/system/login" class="text-gray-400 hover:text-white transition-colors inline-flex items-center gap-2">
                            <i class="fas fa-lock"></i>
                            Admin Login
                        </a></li>
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
                <div class="flex space-x-6 mt-4 md:mt-0">
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
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburgerIcon = document.getElementById('hamburger-icon');
            const closeIcon = document.getElementById('close-icon');
            
            let isMenuOpen = false;
            
            function toggleMenu() {
                isMenuOpen = !isMenuOpen;
                
                if (isMenuOpen) {
                    mobileMenu.classList.remove('hidden');
                    hamburgerIcon.classList.add('hidden');
                    closeIcon.classList.remove('hidden');
                    mobileMenuButton.setAttribute('aria-expanded', 'true');
                } else {
                    mobileMenu.classList.add('hidden');
                    hamburgerIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                    mobileMenuButton.setAttribute('aria-expanded', 'false');
                }
            }
            
            // Toggle menu on button click
            mobileMenuButton.addEventListener('click', function(e) {
                e.preventDefault();
                toggleMenu();
            });
            
            // Close menu when clicking on a menu item
            const mobileMenuLinks = mobileMenu.querySelectorAll('a');
            mobileMenuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (isMenuOpen) {
                        toggleMenu();
                    }
                });
            });
            
            // Close menu when clicking outside
            document.addEventListener('click', function(e) {
                if (isMenuOpen && !mobileMenuButton.contains(e.target) && !mobileMenu.contains(e.target)) {
                    toggleMenu();
                }
            });
            
            // Close menu on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && isMenuOpen) {
                    toggleMenu();
                }
            });
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768 && isMenuOpen) { // md breakpoint
                    toggleMenu();
                }
            });
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