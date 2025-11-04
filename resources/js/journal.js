/**
 * African Annals of Health Sciences - Journal JavaScript
 * Handles interactivity, mobile menu, animations, and UI enhancements
 */

document.addEventListener('DOMContentLoaded', function() {
    // ========================================
    // Mobile Menu Toggle
    // ========================================
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');

    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            const isExpanded = mobileMenuToggle.getAttribute('aria-expanded') === 'true';
            
            // Toggle menu visibility
            mobileMenu.classList.toggle('hidden');
            
            // Toggle icons
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
            
            // Update ARIA attribute
            mobileMenuToggle.setAttribute('aria-expanded', !isExpanded);
            
            // Prevent body scroll when menu is open
            document.body.style.overflow = isExpanded ? '' : 'hidden';
        });

        // Close menu when clicking a link
        const mobileMenuLinks = mobileMenu.querySelectorAll('a');
        mobileMenuLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
                menuIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
                mobileMenuToggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            });
        });
    }

    // ========================================
    // Mobile Search Toggle
    // ========================================
    const mobileSearchToggle = document.getElementById('mobile-search-toggle');
    const mobileSearch = document.getElementById('mobile-search');

    if (mobileSearchToggle && mobileSearch) {
        mobileSearchToggle.addEventListener('click', function() {
            mobileSearch.classList.toggle('hidden');
            
            // Focus on search input when opened
            if (!mobileSearch.classList.contains('hidden')) {
                const searchInput = mobileSearch.querySelector('input[type="search"]');
                if (searchInput) {
                    setTimeout(() => searchInput.focus(), 100);
                }
            }
        });
    }

    // ========================================
    // Smooth Scroll
    // ========================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                // Update URL without page jump
                history.pushState(null, null, targetId);
            }
        });
    });

    // ========================================
    // Copy Citation Functionality
    // ========================================
    document.querySelectorAll('.copy-citation').forEach(button => {
        button.addEventListener('click', async function() {
            const citationText = this.getAttribute('data-citation');
            const format = this.getAttribute('data-format') || 'citation';
            
            try {
                await navigator.clipboard.writeText(citationText);
                showToast(`${format} citation copied to clipboard!`, 'success');
                
                // Visual feedback
                const originalText = this.innerHTML;
                this.innerHTML = '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> Copied!';
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                }, 2000);
            } catch (err) {
                showToast('Failed to copy citation', 'error');
            }
        });
    });

    // ========================================
    // Accordion Functionality (for Archive)
    // ========================================
    document.querySelectorAll('.accordion-toggle').forEach(toggle => {
        toggle.addEventListener('click', function() {
            const content = this.nextElementSibling;
            const icon = this.querySelector('.accordion-icon');
            
            // Toggle content
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                content.style.maxHeight = content.scrollHeight + 'px';
                if (icon) icon.style.transform = 'rotate(180deg)';
                this.setAttribute('aria-expanded', 'true');
            } else {
                content.style.maxHeight = '0';
                setTimeout(() => {
                    content.classList.add('hidden');
                }, 300);
                if (icon) icon.style.transform = 'rotate(0deg)';
                this.setAttribute('aria-expanded', 'false');
            }
        });
    });

    // ========================================
    // Expandable Abstract
    // ========================================
    document.querySelectorAll('.expand-abstract').forEach(button => {
        button.addEventListener('click', function() {
            const abstract = this.previousElementSibling;
            
            if (abstract.classList.contains('line-clamp-4')) {
                abstract.classList.remove('line-clamp-4');
                this.textContent = 'Show less';
            } else {
                abstract.classList.add('line-clamp-4');
                this.textContent = 'Read more';
            }
        });
    });

    // ========================================
    // Lazy Loading Images
    // ========================================
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    const src = img.getAttribute('data-src');
                    
                    if (src) {
                        img.src = src;
                        img.classList.remove('skeleton');
                        img.classList.add('fade-in');
                        observer.unobserve(img);
                    }
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // ========================================
    // Search Highlighting
    // ========================================
    const urlParams = new URLSearchParams(window.location.search);
    const searchQuery = urlParams.get('q');
    
    if (searchQuery && searchQuery.length > 2) {
        highlightSearchTerms(searchQuery);
    }

    function highlightSearchTerms(query) {
        const searchableElements = document.querySelectorAll('.searchable-content');
        const terms = query.toLowerCase().split(' ').filter(term => term.length > 2);
        
        searchableElements.forEach(element => {
            let html = element.innerHTML;
            
            terms.forEach(term => {
                const regex = new RegExp(`(${escapeRegExp(term)})`, 'gi');
                html = html.replace(regex, '<mark class="search-highlight">$1</mark>');
            });
            
            element.innerHTML = html;
        });
    }

    function escapeRegExp(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    // ========================================
    // Toast Notification System
    // ========================================
    window.showToast = function(message, type = 'info', duration = 5000) {
        const toastContainer = document.getElementById('toast-container');
        if (!toastContainer) return;

        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'polite');
        
        const icon = getToastIcon(type);
        
        toast.innerHTML = `
            ${icon}
            <div class="flex-1">
                <p class="font-medium">${message}</p>
            </div>
            <button type="button" class="text-gray-400 hover:text-gray-600 transition-colors" onclick="this.parentElement.remove()" aria-label="Close notification">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        `;
        
        toastContainer.appendChild(toast);
        
        // Auto-remove after duration
        setTimeout(() => {
            toast.remove();
        }, duration);
    };

    function getToastIcon(type) {
        const icons = {
            success: `<svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>`,
            error: `<svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>`,
            warning: `<svg class="w-6 h-6 text-yellow-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>`,
            info: `<svg class="w-6 h-6 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>`
        };
        return icons[type] || icons.info;
    }

    // ========================================
    // Form Validation Enhancements
    // ========================================
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            
            if (submitButton && !this.hasAttribute('data-no-disable')) {
                submitButton.disabled = true;
                submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                
                const originalText = submitButton.innerHTML;
                submitButton.innerHTML = `
                    <svg class="animate-spin h-5 w-5 mr-2 inline-block" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Processing...
                `;
                
                // Re-enable after 10 seconds as fallback
                setTimeout(() => {
                    submitButton.disabled = false;
                    submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    submitButton.innerHTML = originalText;
                }, 10000);
            }
        });
    });

    // ========================================
    // Article Metrics Animation
    // ========================================
    function animateCounter(element, target, duration = 1000) {
        const start = 0;
        const increment = target / (duration / 16);
        let current = start;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target.toLocaleString();
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(current).toLocaleString();
            }
        }, 16);
    }

    // Animate counters when in viewport
    if ('IntersectionObserver' in window) {
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = parseInt(counter.getAttribute('data-count'));
                    animateCounter(counter, target);
                    counterObserver.unobserve(counter);
                }
            });
        });

        document.querySelectorAll('[data-count]').forEach(counter => {
            counterObserver.observe(counter);
        });
    }

    // ========================================
    // Back to Top Button
    // ========================================
    const backToTopButton = document.getElementById('back-to-top');
    
    if (backToTopButton) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('hidden');
            } else {
                backToTopButton.classList.add('hidden');
            }
        });

        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // ========================================
    // Print Article Functionality
    // ========================================
    document.querySelectorAll('.print-article').forEach(button => {
        button.addEventListener('click', function() {
            window.print();
        });
    });
});