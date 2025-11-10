@extends('layouts.journal')

@section('title', 'Author Guidelines - African Annals of Health Sciences')

@section('content')

@php
    $settings = \App\Models\JournalSettings::getInstance();
@endphp

<style>
    .tab-button.active {
        border-color: #2563eb;
        color: #2563eb;
    }
    
    .tab-button:not(.active) {
        border-color: transparent;
        color: #6b7280;
    }
    
    .tab-button:not(.active):hover {
        color: #374151;
        border-color: #d1d5db;
    }
    
    .prose h2 {
        font-size: 1.5em;
        font-weight: 700;
        margin-top: 2em;
        margin-bottom: 1em;
        color: #1f2937;
    }
    
    .prose h3 {
        font-size: 1.25em;
        font-weight: 600;
        margin-top: 1.6em;
        margin-bottom: 0.6em;
        color: #374151;
    }
    
    .prose ul, .prose ol {
        margin-top: 1.25em;
        margin-bottom: 1.25em;
        padding-left: 1.625em;
    }
    
    .prose li {
        margin-top: 0.5em;
        margin-bottom: 0.5em;
    }
    
    .prose p {
        margin-top: 1.25em;
        margin-bottom: 1.25em;
    }
</style>

<!-- Main Content -->
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-6xl mx-auto">
        
        <!-- Introduction Section -->
        <section class="mb-12">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                <div class="prose prose-lg max-w-none">
                    <div class="bg-blue-50 border-l-4 border-blue-600 p-6 mb-6">
                        <h3 class="text-lg font-semibold text-blue-900 mb-2">Before You Submit</h3>
                        <p class="text-blue-800 mb-0">
                            Please read the submission guidelines and manuscript preparation requirements below before submitting your manuscript.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Submission Guidelines and Manuscript Preparation Tabs -->
        @if($settings->submission_guidelines || $settings->manuscript_preparation)
        <section class="mb-12">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <!-- Tab Navigation -->
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px" aria-label="Guidelines">
                        <button 
                            onclick="switchTab('submission')" 
                            id="tab-submission"
                            class="tab-button active w-1/2 py-4 px-6 text-center border-b-2 font-semibold text-sm focus:outline-none transition-colors"
                        >
                            <svg class="w-5 h-5 inline-block mr-2 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Submission Guidelines
                        </button>
                        <button 
                            onclick="switchTab('preparation')" 
                            id="tab-preparation"
                            class="tab-button w-1/2 py-4 px-6 text-center border-b-2 font-semibold text-sm focus:outline-none transition-colors"
                        >
                            <svg class="w-5 h-5 inline-block mr-2 -mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Manuscript Preparation
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-8">
                    <!-- Submission Guidelines Tab -->
                    <div id="content-submission" class="tab-content prose prose-lg max-w-none">
                        @if($settings->submission_guidelines)
                            {!! $settings->submission_guidelines !!}
                        @else
                            <p class="text-gray-600 italic">Submission guidelines will be available soon.</p>
                        @endif
                    </div>

                    <!-- Manuscript Preparation Tab -->
                    <div id="content-preparation" class="tab-content hidden prose prose-lg max-w-none">
                        @if($settings->manuscript_preparation)
                            {!! $settings->manuscript_preparation !!}
                        @else
                            <p class="text-gray-600 italic">Manuscript preparation guidelines will be available soon.</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        @endif

        <!-- How to Submit Section -->
        <section class="mb-12">
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg border border-blue-200 p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-serif">How to Submit</h2>
                <p class="text-gray-700 mb-6 text-lg">
                    To submit your manuscript to {{ $settings->journal_name }}, please send your complete 
                    submission package via email to our editorial office.
                </p>
                
                <div class="bg-white rounded-lg p-6 mb-6 shadow-sm">
                    <div class="flex items-start mb-4">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Submission Email</h3>
                            <a href="mailto:{{ $settings->submission_email ?? $settings->contact_email }}" 
                               class="text-xl font-bold text-blue-600 hover:text-blue-800 transition-colors">
                                {{ $settings->submission_email ?? $settings->contact_email }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900">Your submission should include:</h3>
                    <ul class="space-y-3 text-gray-700">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span><strong>Main manuscript file</strong> in Word (.doc, .docx) or PDF format</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span><strong>Cover letter</strong> stating the significance and originality of your work</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span><strong>Author information</strong> including full names, affiliations, and contact details</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span><strong>Supplementary materials</strong> (if applicable) - tables, figures, appendices</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span><strong>Suggested reviewers</strong> (optional) - names and contact information of 2-3 experts</span>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="mb-12">
            <div class="bg-blue-50 rounded-lg border border-blue-200 p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 font-serif">Need Help?</h2>
                <p class="text-gray-700 mb-4">
                    If you encounter any issues with the submission process or have questions about our requirements, 
                    please don't hesitate to contact our editorial team.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a 
                        href="mailto:{{ $settings->submission_email ?? $settings->contact_email }}" 
                        class="inline-flex items-center px-6 py-3 bg-white border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition-colors font-medium"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Email Editorial Office
                    </a>
                    <a 
                        href="/journal/policies" 
                        class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        View Editorial Policies
                    </a>
                </div>
            </div>
        </section>

    </div>
</div>

<!-- JavaScript for Tabs -->
<script>
// Tab Switching
function switchTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active class from all tab buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'border-blue-600', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
    });
    
    // Show selected tab content
    document.getElementById('content-' + tabName).classList.remove('hidden');
    
    // Add active class to selected tab button
    const activeButton = document.getElementById('tab-' + tabName);
    activeButton.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
    activeButton.classList.add('active', 'border-blue-600', 'text-blue-600');
}
</script>

@endsection