{{-- resources/views/partials/journal/footer.blade.php --}}
<footer style="background-color: #0A2540; color: white; padding: 3rem 0 1.5rem; margin-top: 4rem;">
    <div class="container-default">
        <div style="display: grid; gap: 2rem; grid-template-columns: repeat(3, 1fr); margin-bottom: 2rem;">
            <!-- Left Column: About Section -->
            <div>
                <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem; color: white;">About the Journal</h3>
                <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.875rem; line-height: 1.6; margin-bottom: 1rem;">
                    African Annals of Health Sciences is a peer-reviewed open access journal dedicated to advancing health sciences research across the African continent.
                </p>
                @if(isset($journalSettings->issn))
                <div style="color: rgba(255, 255, 255, 0.7); font-size: 0.875rem;">
                    <strong>ISSN:</strong> {{ $journalSettings->issn }}
                </div>
                @endif

                <!-- Contact Information -->
                <div style="margin-top: 2rem;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem; color: white;">Contact</h3>
                    <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.875rem; line-height: 1.6;">
                        Faculty of Health Sciences<br>
                        University of Bamenda<br>
                        Cameroon
                    </p>
                    @if(isset($journalSettings->contact_email))
                    <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.875rem; margin-top: 0.5rem;">
                        <strong>Email:</strong> <a href="mailto:{{ $journalSettings->contact_email }}" style="color: #00B4A6; text-decoration: none;" onmouseover="this.style.color='#00D4C6'" onmouseout="this.style.color='#00B4A6'">{{ $journalSettings->contact_email }}</a>
                    </p>
                    @else
                    <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.875rem; margin-top: 0.5rem;">
                        <strong>Email:</strong> <a href="mailto:editor@africanannals.org" style="color: #00B4A6; text-decoration: none;" onmouseover="this.style.color='#00D4C6'" onmouseout="this.style.color='#00B4A6'">editor@africanannals.org</a>
                    </p>
                    @endif
                </div>
            </div>

            <!-- Middle Column: Quick Links -->
            <div>
                <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem; color: white;">Quick Links</h3>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 0.5rem;">
                        <a href="{{ route('journal.home') }}" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; font-size: 0.875rem; transition: color 200ms ease-in-out;" onmouseover="this.style.color='#00B4A6'" onmouseout="this.style.color='rgba(255, 255, 255, 0.8)'">Home</a>
                    </li>
                    <li style="margin-bottom: 0.5rem;">
                        <a href="{{ route('journal.archive') }}" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; font-size: 0.875rem; transition: color 200ms ease-in-out;" onmouseover="this.style.color='#00B4A6'" onmouseout="this.style.color='rgba(255, 255, 255, 0.8)'">Browse Archive</a>
                    </li>
                    <li style="margin-bottom: 0.5rem;">
                        <a href="{{ route('journal.editorial-board') }}" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; font-size: 0.875rem; transition: color 200ms ease-in-out;" onmouseover="this.style.color='#00B4A6'" onmouseout="this.style.color='rgba(255, 255, 255, 0.8)'">Editorial Board</a>
                    </li>
                    <li style="margin-bottom: 0.5rem;">
                        <a href="/" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; font-size: 0.875rem; transition: color 200ms ease-in-out;" onmouseover="this.style.color='#00B4A6'" onmouseout="this.style.color='rgba(255, 255, 255, 0.8)'">FHS Website</a>
                    </li>
                </ul>
            </div>

            <!-- Right Column: For Authors -->
            <div>
                <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem; color: white;">For Authors</h3>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 0.5rem;">
                        <a href="{{ route('journal.submission') }}" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; font-size: 0.875rem; transition: color 200ms ease-in-out;" onmouseover="this.style.color='#00B4A6'" onmouseout="this.style.color='rgba(255, 255, 255, 0.8)'">Submission Guidelines</a>
                    </li>
                    <li style="margin-bottom: 0.5rem;">
                        <a href="{{ route('journal.policies') }}" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; font-size: 0.875rem; transition: color 200ms ease-in-out;" onmouseover="this.style.color='#00B4A6'" onmouseout="this.style.color='rgba(255, 255, 255, 0.8)'">Publication Ethics</a>
                    </li>
                    <li style="margin-bottom: 0.5rem;">
                        <a href="{{ route('journal.policies') }}#copyright" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; font-size: 0.875rem; transition: color 200ms ease-in-out;" onmouseover="this.style.color='#00B4A6'" onmouseout="this.style.color='rgba(255, 255, 255, 0.8)'">Copyright Policy</a>
                    </li>
                    <li style="margin-bottom: 0.5rem;">
                        <a href="{{ route('journal.policies') }}#peer-review" style="color: rgba(255, 255, 255, 0.8); text-decoration: none; font-size: 0.875rem; transition: color 200ms ease-in-out;" onmouseover="this.style.color='#00B4A6'" onmouseout="this.style.color='rgba(255, 255, 255, 0.8)'">Peer Review Process</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Open Access Badge -->
        <div style="border-top: 1px solid rgba(255, 255, 255, 0.2); padding-top: 2rem; margin-bottom: 2rem;">
            <div style="display: flex; flex-direction: column; align-items: center; gap: 1rem; text-align: center;">
                <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap; justify-content: center;">
                    <div style="background-color: #10B981; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 600; font-size: 0.875rem;">
                        Open Access
                    </div>
                    <span style="font-size: 0.875rem; color: rgba(255, 255, 255, 0.8);">Licensed under CC BY 4.0</span>
                </div>
                <a href="https://creativecommons.org/licenses/by/4.0/" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   style="color: rgba(255, 255, 255, 0.8); text-decoration: none; font-size: 0.875rem; display: flex; align-items: center; gap: 0.5rem;"
                   onmouseover="this.style.color='#00B4A6'" 
                   onmouseout="this.style.color='rgba(255, 255, 255, 0.8)'">
                    <span>Learn about our license</span>
                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Copyright -->
        <div style="border-top: 1px solid rgba(255, 255, 255, 0.2); padding-top: 1.5rem; text-align: center;">
            <p style="color: rgba(255, 255, 255, 0.6); font-size: 0.875rem; margin-bottom: 0.5rem;">
                © {{ date('Y') }} African Annals of Health Sciences. All rights reserved.
            </p>
            <p style="color: rgba(255, 255, 255, 0.6); font-size: 0.875rem;">
                Published by <a href="/" style="color: #00B4A6; text-decoration: none;" onmouseover="this.style.color='#00D4C6'" onmouseout="this.style.color='#00B4A6'">Faculty of Health Sciences, University of Bamenda</a>
            </p>
        </div>
        
    </div>
</footer>

<style>
/* Responsive Grid for Footer */
@media (max-width: 767px) {
    footer > div > div:first-child {
        grid-template-columns: 1fr;
    }
}

@media (min-width: 768px) and (max-width: 1023px) {
    footer > div > div:first-child {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>
