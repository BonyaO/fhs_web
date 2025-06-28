<header class="flex flex-wrap md:justify-start md:flex-nowrap z-50 w-full py-7">
    <nav class="relative max-w-7xl w-full flex flex-wrap md:grid md:grid-cols-12 basis-full items-center px-4 md:px-6 lg:px-8 mx-auto"
        aria-label="Global">
        <div class="md:col-span-3">
            <!-- Logo -->
            <a class="flex-none rounded-xl text-xl inline-block font-semibold focus:outline-none focus:opacity-80"
                href="/" aria-label="Home page">
                <img src="{{ asset('images/uba.png') }}" width="70" alt="College of Technology Logo">
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
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 17v1a3 3 0 0 1-6 0v-1m6 0a3 3 0 0 0-6 0m6 0V9a4 4 0 1 0-8 0v8m8 0H8" />
                    </svg>
                    <span>Admin Login</span>
                </a>
            </div>
            </div>
        </div>
        <!-- End Button Group -->

        <!-- Collapse -->
        <div id="navbar-collapse-with-animation"
            class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow md:block md:w-auto md:basis-auto md:order-2 md:col-span-6">
            <div
                class="flex flex-col gap-y-4 gap-x-0 mt-5 md:flex-row md:justify-center md:items-center md:gap-y-0 md:gap-x-7 md:mt-0">
                <div>
                    <a class="relative inline-block text-black before:absolute before:bottom-0.5 before:start-0 before:-z-[1]
                    before:w-full before:h-1 before:bg-blue-400 dark:text-white"
                        href="#" aria-current="page">Home</a>
                </div>
                <div>
                    <a class="inline-block text-black hover:text-gray-600 dark:text-white dark:hover:text-neutral-300"
                        href="#">Programmes</a>
                </div>
                <div>
                    <a class="inline-block text-black hover:text-gray-600 dark:text-white dark:hover:text-neutral-300"
                        href="#">Campus
                        news</a>
                </div>
                <div>
                    <a class="inline-block text-black hover:text-gray-600 dark:text-white dark:hover:text-neutral-300"
                        href="/defenses">Defenses</a>
                </div>
                <div>
                    <a class="inline-block text-black hover:text-gray-600 dark:text-white dark:hover:text-neutral-300"
                        href="#">About</a>
                </div>
            </div>
        </div>
        <!-- End Collapse -->
    </nav>
</header>
