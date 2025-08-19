<?php $pageTitle="Error 404"; ?>
<div class="flex h-[100vh] min-h-screen bg-white">
    <!-- Sidebar Image -->
    <div class="hidden lg:block lg:w-1/2 relative">
        <img
            src="https://images.unsplash.com/photo-1549415697-8e9a0872f910?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            alt="Lost man in desert"
            class="h-full w-full object-cover"
        />
        <div class="absolute inset-0 bg-black bg-opacity-30"></div>
    </div>

    <!-- Main content -->
    <main class="flex flex-1 items-center justify-center px-6 py-24 sm:py-32 lg:px-8">
        <div class="text-center max-w-md">
                <h1 class="text-2xl font-semibold text-red-600">404</h1>
                <h1 class="mt-4 text-5xl font-semibold tracking-tight text-balance text-gray-900 sm:text-7xl">
                        Page Not Found
                </h1>
                <p class="mt-6 text-lg font-medium text-pretty text-gray-500 sm:text-xl/8">
                        Sorry, the page you are looking for could not be found.
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a
                                href="/"
                                class="rounded-md bg-green-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-green-800 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >
                                Go back home
                        </a>
                        <a href="/services/cu" class="text-sm font-semibold text-gray-900">
                                Contact support <span aria-hidden="true">&rarr;</span>
                        </a>
                </div>
        </div>
    </main>
</div>