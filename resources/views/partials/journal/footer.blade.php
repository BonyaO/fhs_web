<footer class="bg-gray-900 text-gray-300 mt-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
            <!-- About Section -->
            <div>
                <h3 class="text-white font-semibold text-lg mb-4">About the Journal</h3>
                <p class="text-sm leading-relaxed mb-4">
                    African Annals of Health Sciences is a peer-reviewed open access journal dedicated to advancing health sciences research across the African continent.
                </p>
                <div class="flex items-center space-x-3">
                    @if(isset($journalSettings->issn))
                        <span class="text-sm">ISSN: {{ $journalSettings->issn }}</span>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-white font-semibold text-lg mb-4">Quick Links</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('journal.home') }}" class="hover:text-white transition-colors">Home</a></li>
                    <li><a href="{{ route('journal.archive') }}" class="hover:text-white transition-colors">Browse Archive</a></li>
                    <li><a href="{{ route('journal.search') }}" class="hover:text-white transition-colors">Search Articles</a></li>
                    <li><a href="{{ route('journal.editorial-board') }}" class="hover:text-white transition-colors">Editorial Board</a></li>
                    <li><a href="/" class="hover:text-white transition-colors">FHS Website</a></li>
                </ul>
            </div>

            <!-- For Authors -->
            <div>
                <h3 class="text-white font-semibold text-lg mb-4">For Authors</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('journal.submission') }}" class="hover:text-white transition-colors">Submission Guidelines</a></li>
                    <li><a href="{{ route('journal.policies') }}" class="hover:text-white transition-colors">Publication Ethics</a></li>
                    <li><a href="{{ route('journal.policies') }}#copyright" class="hover:text-white transition-colors">Copyright Policy</a></li>
                    <li><a href="{{ route('journal.policies') }}#peer-review" class="hover:text-white transition-colors">Peer Review Process</a></li>
                </ul>
            </div>

            <!-- Contact & Social -->
            <div>
                <h3 class="text-white font-semibold text-lg mb-4">Contact & Connect</h3>
                <ul class="space-y-2 text-sm mb-4">
                    @if(isset($journalSettings->contact_email))
                        <li class="flex items-start space-x-2">
                            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <a href="mailto:{{ $journalSettings->contact_email }}" class="hover:text-white transition-colors break-all">
                                {{ $journalSettings->contact_email }}
                            </a>
                        </li>
                    @endif
                </ul>
                
                <!-- Social Media Links (if available) -->
                <div class="flex items-center space-x-3">
                    {{-- Add social media links when available --}}
                    {{-- Example:
                    <a href="#" class="text-gray-400 hover:text-white transition-colors" aria-label="Twitter">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/></svg>
                    </a>
                    --}}
                </div>
            </div>
        </div>

        <!-- Open Access Badge -->
        <div class="border-t border-gray-800 pt-8 mb-8">
            <div class="flex flex-col md:flex-row items-center justify-center md:justify-between space-y-4 md:space-y-0">
                <div class="flex items-center space-x-3">
                    <div class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold text-sm">
                        Open Access
                    </div>
                    <span class="text-sm">Licensed under CC BY 4.0</span>
                </div>
                <a href="https://creativecommons.org/licenses/by/4.0/" target="_blank" rel="noopener noreferrer" class="text-sm hover:text-white transition-colors flex items-center space-x-2">
                    <span>Learn about our license</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-800 pt-8 text-center text-sm">
            <p>&copy; {{ date('Y') }} African Annals of Health Sciences. All rights reserved.</p>
            <p class="mt-2">
                Published by <a href="/" class="text-blue-400 hover:text-blue-300 transition-colors">Faculty of Health Sciences</a>
            </p>
        </div>
    </div>
</footer>