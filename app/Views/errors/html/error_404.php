<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SecretGarden</title>

<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="flex bg-white">
    <!-- Sidebar Image -->
    <div class="hidden h-[100vh] lg:block lg:w-1/2 relative">
        <img
            src="https://images.unsplash.com/photo-1549415697-8e9a0872f910?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            alt="Lost man in desert"
            class=" w-auto object-cover"
        />
        <div class="absolute inset-0 bg-black bg-opacity-30"></div>
    </div>

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
                        <a href="/services/contactus" class="text-sm font-semibold text-gray-900">
                                Contact support <span aria-hidden="true">&rarr;</span>
                        </a>
                </div>
        </div>
    </main>
</div>
</body>
</html>