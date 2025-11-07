@extends('layouts.journal')

@section('title', 'About the Journal')

@section('meta')
    <meta name="description" content="Learn about African Annals of Health Sciences - an open access journal dedicated to advancing health sciences research across Africa.">
    <meta name="keywords" content="African health sciences, medical journal, open access, health research Africa">
@endsection

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="max-w-4xl">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">About the Journal</h1>
            <p class="text-xl text-blue-100">
                African Annals of Health Sciences - Advancing medical knowledge and research excellence across Africa
            </p>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-4xl mx-auto">
        
        <!-- Journal Overview -->
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 font-serif">Overview</h2>
            <div class="prose prose-lg max-w-none">
                <p class="text-gray-700 leading-relaxed mb-4">
                    The <strong>African Annals of Health Sciences</strong> is a peer-reviewed, open access journal published by the Faculty of Health Sciences. Our mission is to provide a platform for the dissemination of high-quality research, case reports, and review articles that contribute to the advancement of health sciences across Africa and globally.
                </p>
                <p class="text-gray-700 leading-relaxed mb-4">
                    We are committed to promoting evidence-based healthcare practices, fostering collaboration among healthcare professionals, researchers, and policymakers, and addressing the unique health challenges facing African populations.
                </p>
            </div>
        </section>

        <!-- Aims and Scope -->
        <section class="mb-12 bg-gray-50 rounded-lg p-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 font-serif">Aims & Scope</h2>
            <div class="prose prose-lg max-w-none">
                <p class="text-gray-700 leading-relaxed mb-4">
                    African Annals of Health Sciences publishes original research and scholarly articles across all disciplines of health sciences, including but not limited to:
                </p>
                <div class="grid md:grid-cols-2 gap-4 mt-6">
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Clinical Medicine
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Public Health
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Epidemiology
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Nursing Sciences
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Pharmacy
                        </li>
                    </ul>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Medical Laboratory Sciences
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Biomedical Sciences
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Health Policy
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Health Education
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-2 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Environmental Health
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Publication Information -->
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 font-serif">Publication Information</h2>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Frequency</h3>
                    <p class="text-gray-700">Published biannually (July and December)</p>
                </div>
                <div class="border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">ISSN</h3>
                    <p class="text-gray-700">ISSN: [To be assigned]</p>
                </div>
                <div class="border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Publisher</h3>
                    <p class="text-gray-700">Faculty of Health Sciences</p>
                </div>
                <div class="border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Language</h3>
                    <p class="text-gray-700">English</p>
                </div>
            </div>
        </section>

        <!-- Open Access Statement -->
        <section class="mb-12 bg-blue-50 border-l-4 border-blue-600 rounded-r-lg p-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 font-serif">Open Access Policy</h2>
            <div class="prose prose-lg max-w-none">
                <p class="text-gray-700 leading-relaxed mb-4">
                    African Annals of Health Sciences is an <strong>open access journal</strong>, which means that all content is freely available without charge to users or their institutions. Users are allowed to read, download, copy, distribute, print, search, or link to the full texts of the articles in this journal without asking prior permission from the publisher or the author.
                </p>
                <p class="text-gray-700 leading-relaxed mb-4">
                    This is in accordance with the Budapest Open Access Initiative (BOAI) definition of open access. Articles are published under a <strong>Creative Commons Attribution 4.0 International License (CC BY 4.0)</strong>, which permits use, sharing, adaptation, distribution and reproduction in any medium or format, as long as appropriate credit is given to the original authors and the source.
                </p>
                <div class="mt-6">
                    <a href="https://creativecommons.org/licenses/by/4.0/" 
                       target="_blank"
                       rel="noopener noreferrer"
                       class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/>
                            <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"/>
                        </svg>
                        Learn more about CC BY 4.0 License
                    </a>
                </div>
            </div>
        </section>

        <!-- Peer Review Process -->
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 font-serif">Peer Review Process</h2>
            <div class="prose prose-lg max-w-none">
                <p class="text-gray-700 leading-relaxed mb-4">
                    All manuscripts submitted to African Annals of Health Sciences undergo a rigorous <strong>double-blind peer review process</strong> to ensure the highest standards of scientific quality and integrity.
                </p>
                <div class="bg-white border border-gray-200 rounded-lg p-6 mt-6">
                    <ol class="space-y-4 text-gray-700">
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-semibold mr-4">1</span>
                            <div>
                                <strong>Initial Screening:</strong> Manuscripts are first assessed by the editorial team for scope, quality, and adherence to submission guidelines.
                            </div>
                        </li>
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-semibold mr-4">2</span>
                            <div>
                                <strong>Peer Review:</strong> Suitable manuscripts are sent to at least two independent expert reviewers for evaluation.
                            </div>
                        </li>
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-semibold mr-4">3</span>
                            <div>
                                <strong>Editorial Decision:</strong> Based on reviewer recommendations, the editor makes a decision to accept, reject, or request revisions.
                            </div>
                        </li>
                        <li class="flex items-start">
                            <span class="flex-shrink-0 w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-semibold mr-4">4</span>
                            <div>
                                <strong>Publication:</strong> Accepted manuscripts are prepared for publication and published online.
                            </div>
                        </li>
                    </ol>
                </div>
            </div>
        </section>

        <!-- Indexing and Abstracting -->
        <section class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 font-serif">Indexing & Abstracting</h2>
            <div class="prose prose-lg max-w-none">
                <p class="text-gray-700 leading-relaxed mb-4">
                    African Annals of Health Sciences is committed to achieving indexing in major international databases to enhance the visibility and impact of published research. We are currently in the process of applying for indexing in:
                </p>
                <div class="grid md:grid-cols-3 gap-4 mt-6">
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
                        <p class="font-semibold text-gray-900">PubMed/MEDLINE</p>
                    </div>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
                        <p class="font-semibold text-gray-900">Google Scholar</p>
                    </div>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
                        <p class="font-semibold text-gray-900">African Journals Online</p>
                    </div>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
                        <p class="font-semibold text-gray-900">Directory of Open Access Journals</p>
                    </div>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
                        <p class="font-semibold text-gray-900">Scopus</p>
                    </div>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
                        <p class="font-semibold text-gray-900">Web of Science</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Information -->
        <section class="mb-12 bg-gradient-to-br from-gray-50 to-blue-50 rounded-lg p-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 font-serif">Contact Us</h2>
            <div class="space-y-4">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-blue-600 mr-4 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <div>
                        <p class="font-semibold text-gray-900">Editorial Office</p>
                        <p class="text-gray-700">Email: <a href="mailto:editor@africanannals.org" class="text-blue-600 hover:text-blue-800">editor@africanannals.org</a></p>
                    </div>
                </div>
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-blue-600 mr-4 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <div>
                        <p class="font-semibold text-gray-900">Address</p>
                        <p class="text-gray-700">Faculty of Health Sciences<br>P.O. Box [Address]<br>[City, Country]</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-blue-600 mr-4 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <div>
                        <p class="font-semibold text-gray-900">Phone</p>
                        <p class="text-gray-700">+[Country Code] [Phone Number]</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="text-center py-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Ready to Submit Your Research?</h3>
            <p class="text-gray-700 mb-6">Join our community of researchers and contribute to advancing health sciences in Africa.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('journal.submission') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                    View Submission Guidelines
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                <a href="{{ route('journal.editorial-board') }}" 
                   class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg border-2 border-blue-600 hover:bg-blue-50 transition-colors">
                    Meet Our Editorial Board
                </a>
            </div>
        </section>

    </div>
</div>
@endsection