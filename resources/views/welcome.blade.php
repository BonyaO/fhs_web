<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FHS-UBa application</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!--<link href="/build/css/app.css" rel="stylesheet" />-->
    <script src="https://cdn.tailwindcss.com"></script>
    <!--@vite('resources/css/app.css')-->
</head>

<body class="font-sans antialiased bg-white dark:bg-black dark:text-white/50">
    <x-navbar />

    <!-- Hero -->
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 lg:mt-16">
        <!-- Grid -->
        <div class="grid md:grid-cols-2 gap-4 md:gap-8 xl:gap-20 md:items-center">
            <div>
                <h1
                    class="block text-3xl font-bold text-gray-800 sm:text-4xl lg:text-6xl lg:leading-tight dark:text-white">
                    Start your journey in <span class="text-blue-600"> Faculty of Health Sciences</span></h1>
                <p class="mt-3 text-lg text-gray-800 dark:text-neutral-400">Make a difference in the lives of others,
                    and discover a rewarding career that will change yours with the Faculty of Health Sciences (FHS) in the
                    University of Bamenda</p>
                    

                <!-- Buttons -->
                <div class=" mt-7 grid gap-3 w-full sm:inline-flex">
                    <a class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                        href="/guest/register">
                        Get started
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                    </a>
                    <a class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                        href="{{ asset('images/comm.pdf') }}">
                        Download Communique
                    </a>
                    <a class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                        href="{{ asset('images/userguide.pdf') }}">
                        Download Guide
                    </a>
                </div>
                <!-- End Buttons -->
                <p class="mt-3 text-lg text-gray-800 dark:text-neutral-400">Have questions or issues with your application? email: <span class="text-blue-600">fhs_admissions@uniba.cm</span></p>
            </div>
            <!-- End Col -->

            <div class="relative ms-4">
                <img class="w-full rounded-md"
                    src="https://images.pexels.com/photos/5327921/pexels-photo-5327921.jpeg?auto=compress&cs=tinysrgb&w=600"
                    alt="Hero Image">
                <div
                    class="absolute inset-0 -z-[1] bg-gradient-to-tr from-gray-200 via-white/0 to-white/0 size-full rounded-md mt-4 -mb-4 me-4 -ms-4 lg:mt-6 lg:-mb-6 lg:me-6 lg:-ms-6 dark:from-neutral-800 dark:via-neutral-900/0 dark:to-neutral-900/0">
                </div>

                <!-- SVG-->
                <div class="absolute bottom-0 start-0">
                    <svg class="w-2/3 ms-auto h-auto text-white dark:text-neutral-900" width="630" height="451"
                        viewBox="0 0 630 451" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="531" y="352" width="99" height="99" fill="currentColor" />
                        <rect x="140" y="352" width="106" height="99" fill="currentColor" />
                        <rect x="482" y="402" width="64" height="49" fill="currentColor" />
                        <rect x="433" y="402" width="63" height="49" fill="currentColor" />
                        <rect x="384" y="352" width="49" height="50" fill="currentColor" />
                        <rect x="531" y="328" width="50" height="50" fill="currentColor" />
                        <rect x="99" y="303" width="49" height="58" fill="currentColor" />
                        <rect x="99" y="352" width="49" height="50" fill="currentColor" />
                        <rect x="99" y="392" width="49" height="59" fill="currentColor" />
                        <rect x="44" y="402" width="66" height="49" fill="currentColor" />
                        <rect x="234" y="402" width="62" height="49" fill="currentColor" />
                        <rect x="334" y="303" width="50" height="49" fill="currentColor" />
                        <rect x="581" width="49" height="49" fill="currentColor" />
                        <rect x="581" width="49" height="64" fill="currentColor" />
                        <rect x="482" y="123" width="49" height="49" fill="currentColor" />
                        <rect x="507" y="124" width="49" height="24" fill="currentColor" />
                        <rect x="531" y="49" width="99" height="99" fill="currentColor" />
                    </svg>
                </div>
                <!-- End SVG-->
            </div>
            <!-- End Col -->
        </div>
        <!-- End Grid -->
    </div>
    <!-- End Hero -->

    <!-- Hero -->
    <div class="hidden relative overflow-hidden">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="max-w-2xl text-center mx-auto">
                <h1 class="block text-3xl font-black text-gray-800 sm:text-4xl md:text-5xl dark:text-white">Faculty of
                    Health Sciences
                </h1>
                <p class="mt-3 text-gray-800 dark:text-neutral-400 leading-loose">Kick start your application into the
                    Faculty
                    of Health Sciences (FHS) for Nursing and Midwivery domains. Applications are now open!! </p>
            </div>

            <div class="mt-10 relative max-w-5xl mx-auto">
                <div
                    class="w-full object-cover h-96 sm:h-[480px] bg-[url('https://images.pexels.com/photos/5721671/pexels-photo-5721671.jpeg?auto=compress&cs=tinysrgb&w=800')] bg-no-repeat bg-center bg-cover rounded-xl">
                </div>

                <div class="absolute inset-0 size-full">
                    <div class="flex flex-col justify-center items-center size-full">
                        <a class="animate-bounce py-3 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-full border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800"
                            href="{{ asset('images/userguide.pdf') }}" download="User guide">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m-6 3.75 3 3m0 0 3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75" />
                            </svg>
                            Download application guide
                        </a>
                    </div>
                </div>

                <div
                    class="absolute bottom-12 -start-20 -z-[1] size-48 bg-gradient-to-b from-orange-500 to-white p-px rounded-lg dark:to-neutral-900">
                    <div class="bg-white size-48 rounded-lg dark:bg-neutral-900"></div>
                </div>

                <div
                    class="absolute -top-12 -end-20 -z-[1] size-48 bg-gradient-to-t from-blue-600 to-cyan-400 p-px rounded-full">
                    <div class="bg-white size-48 rounded-full dark:bg-neutral-900"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Hero -->

    <header class="hidden text-center h-[20rem] flex flex-col gap-4 lg:gap-8 items-center justify-center">
        <h1 class="font-black text-6xl">Welcome to the College of Technology</h1>
        <p>Applications into the College of Technology are now open</p>
        <div d-none class="space-x-4">
            <a href="/guest/register"
                class="py-2 px-3 animate-pulse inline-flex items-center gap-x-2 text-sm font-medium rounded-xl border
                border-transparent bg-blue-400 text-black hover:bg-blue-500 transition disabled:opacity-50
                disabled:pointer-events-none focus:outline-none focus:bg-blue-500">
                Apply now
            </a>
            <a href="{{ asset('images/userguide.pdf') }}" download="User guide"
                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-xl border border-transparent
            bg-orange-400 text-black hover:bg-blue-500 transition disabled:opacity-50 disabled:pointer-events-none
            focus:outline-none focus:bg-blue-500">
                Download pdf guide
            </a>
        </div>
    </header>
    <main>
        <!-- Icon Blocks -->
        <div class="hidden max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <!-- Grid -->
            <div class="grid md:grid-cols-2 gap-12">
                <div class="lg:w-3/4">
                    <h2 class="text-3xl text-gray-800 font-bold lg:text-4xl dark:text-white">
                        Collaborative tools to design better user experience
                    </h2>
                    <p class="mt-3 text-gray-800 dark:text-neutral-400">
                        We help businesses bring ideas to life in the digital world, by designing and implementing the
                        technology tools that they need to win.
                    </p>
                    <p class="mt-5">
                        <a class="inline-flex items-center gap-x-1 font-medium text-blue-600 dark:text-blue-500"
                            href="#">
                            Contact sales to learn more
                            <svg class="flex-shrink-0 size-4 transition ease-in-out group-hover:translate-x-1"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="m9 18 6-6-6-6" />
                            </svg>
                        </a>
                    </p>
                </div>
                <!-- End Col -->

                <div class="space-y-6 lg:space-y-10">
                    <!-- Icon Block -->
                    <div class="flex">
                        <!-- Icon -->
                        <span
                            class="flex-shrink-0 inline-flex justify-center items-center size-[46px] rounded-full border border-gray-200 bg-white text-gray-800 shadow-sm mx-auto dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200">
                            <svg class="flex-shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                            </svg>
                        </span>
                        <div class="ms-5 sm:ms-8">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 dark:text-neutral-200">
                                Industry-leading documentation
                            </h3>
                            <p class="mt-1 text-gray-600 dark:text-neutral-400">
                                Our documentation and extensive Client libraries contain everything a business needs to
                                build a custom integration in a fraction of the time.
                            </p>
                        </div>
                    </div>
                    <!-- End Icon Block -->

                    <!-- Icon Block -->
                    <div class="flex">
                        <!-- Icon -->
                        <span
                            class="flex-shrink-0 inline-flex justify-center items-center size-[46px] rounded-full border border-gray-200 bg-white text-gray-800 shadow-sm mx-auto dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200">
                            <svg class="flex-shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 9a2 2 0 0 1-2 2H6l-4 4V4c0-1.1.9-2 2-2h8a2 2 0 0 1 2 2v5Z" />
                                <path d="M18 9h2a2 2 0 0 1 2 2v11l-4-4h-6a2 2 0 0 1-2-2v-1" />
                            </svg>
                        </span>
                        <div class="ms-5 sm:ms-8">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 dark:text-neutral-200">
                                Developer community support
                            </h3>
                            <p class="mt-1 text-gray-600 dark:text-neutral-400">
                                We actively contribute to open-source projects—giving back to the community through
                                development, patches, and sponsorships.
                            </p>
                        </div>
                    </div>
                    <!-- End Icon Block -->

                    <!-- Icon Block -->
                    <div class="flex">
                        <!-- Icon -->
                        <span
                            class="flex-shrink-0 inline-flex justify-center items-center size-[46px] rounded-full border border-gray-200 bg-white text-gray-800 shadow-sm mx-auto dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200">
                            <svg class="flex-shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M7 10v12" />
                                <path
                                    d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2h0a3.13 3.13 0 0 1 3 3.88Z" />
                            </svg>
                        </span>
                        <div class="ms-5 sm:ms-8">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 dark:text-neutral-200">
                                Simple and affordable
                            </h3>
                            <p class="mt-1 text-gray-600 dark:text-neutral-400">
                                From boarding passes to movie tickets, there's pretty much nothing you can't store with
                                Preline.
                            </p>
                        </div>
                    </div>
                    <!-- End Icon Block -->
                </div>
                <!-- End Col -->
            </div>
            <!-- End Grid -->
        </div>
        <!-- End Icon Blocks -->
    </main>
</body>

</html>
