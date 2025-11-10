@extends('layouts.journal')

@section('title', 'Policies - ' . ($journalSettings->journal_name ?? 'African Annals of Health Sciences'))
@section('meta_description', 'Publication policies for African Annals of Health Sciences')

@section('content')
<div class="bg-gradient-to-br from-blue-50 via-white to-purple-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">

        <!-- Policy Sections -->
        <div class="space-y-20">

            <!-- Copyright Policy -->
            @if($journalSettings->copyright_policy)
                <article class="group">
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                        <header class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-7 md:px-10 md:py-9">
                            <div class="flex items-center">
                                <div>
                                    <h2 class="text-3xl md:text-4xl font-bold text-white font-serif">Copyright Policy</h2>
                                </div>
                            </div>
                        </header>
                        <div class="px-8 py-10 md:px-10 md:py-12 bg-gray-50">
                            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                                {!! $journalSettings->copyright_policy !!}
                            </div>
                        </div>
                    </div>
                </article>
            @endif

            <!-- Open Access Statement -->
            @if($journalSettings->open_access_statement)
                <article class="group">
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                        <header class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-7 md:px-10 md:py-9">
                            <div class="flex items-center">
                                <div>
                                    <h2 class="text-3xl md:text-4xl font-bold text-white font-serif">Open Access Statement</h2>
                                </div>
                            </div>
                        </header>
                        <div class="px-8 py-10 md:px-10 md:py-12 bg-gray-50">
                            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                                {!! $journalSettings->open_access_statement !!}
                            </div>
                        </div>
                    </div>
                </article>
            @endif

            <!-- Ethical Guidelines -->
            @if($journalSettings->ethical_guidelines)
                <article class="group">
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                        <header class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-7 md:px-10 md:py-9">
                            <div class="flex items-center">
                                <div>
                                    <h2 class="text-3xl md:text-4xl font-bold text-white font-serif">Ethical Guidelines</h2>
                                </div>
                            </div>
                        </header>
                        <div class="px-8 py-10 md:px-10 md:py-12 bg-gray-50">
                            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                                {!! $journalSettings->ethical_guidelines !!}
                            </div>
                        </div>
                    </div>
                </article>
            @endif

            <!-- Peer Review Policy -->
            @if($journalSettings->peer_review_policy)
                <article class="group">
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-1">
                        <header class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-7 md:px-10 md:py-9">
                            <div class="flex items-center">
                                <div>
                                    <h2 class="text-3xl md:text-4xl font-bold text-white font-serif">Peer Review Policy</h2>
                                </div>
                            </div>
                        </header>
                        <div class="px-8 py-10 md:px-10 md:py-12 bg-gray-50">
                            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                                {!! $journalSettings->peer_review_policy !!}
                            </div>
                        </div>
                    </div>
                </article>
            @endif

            <!-- Empty State -->
            @if(!$journalSettings->copyright_policy && !$journalSettings->open_access_statement && !$journalSettings->ethical_guidelines && !$journalSettings->peer_review_policy)
                <div class="text-center py-24">
                    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-16 max-w-2xl mx-auto">
                        <h3 class="text-3xl font-bold text-gray-900 mb-4">No Policies Available</h3>
                        <p class="text-gray-600 text-lg mb-4">
                            Journal policies have not been configured yet.
                        </p>
                        <p class="text-gray-500">
                            Please contact the editorial office for more information.
                        </p>
                    </div>
                </div>
            @endif

        </div>

        <!-- Contact CTA -->
        <section class="mt-24 bg-blue-600 rounded-3xl shadow-2xl p-10 md:p-14 text-white overflow-hidden">
            <div class="text-center max-w-4xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold mb-5 font-serif">Questions About Our Policies?</h2>
                <p class="text-lg md:text-xl mb-10 text-blue-100 leading-relaxed">
                    If you have questions about our publication policies or need clarification on any aspect, please don't hesitate to contact us.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="mailto:{{ $journalSettings->contact_email ?? 'editor@africanannals.org' }}" 
                       class="inline-flex items-center justify-center px-8 py-4 bg-white text-blue-700 rounded-2xl font-semibold text-lg hover:bg-blue-50 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        Contact Editorial Office
                    </a>
                    <a href="{{ route('journal.submission') }}" 
                       class="inline-flex items-center justify-center px-8 py-4 bg-transparent border-2 border-white text-white rounded-2xl font-semibold text-lg hover:bg-white hover:text-blue-700 transition-all duration-300 transform hover:-translate-y-1">
                        View Submission Guidelines
                    </a>
                </div>
            </div>
        </section>

    </div>
</div>
@endsection