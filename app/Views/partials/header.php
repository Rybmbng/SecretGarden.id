<html class="scroll-smooth" lang="en" lang="en" x-data="{ mobileMenuOpen: false, searchOpen: false, isScrolled: false }"
  x-init="window.addEventListener('scroll', () => isScrolled = window.scrollY > 50)">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <title>SGV</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
    <link rel="shortcut icon" href="https://www.secretgarden.co.id/skins/secret//img/logo/favicon.png" type="image/x-icon">
    <link rel="icon" href="https://www.secretgarden.co.id/skins/secret//img/logo/favicon.png" type="image/x-icon">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="css/style.css">
    <style>
      html, body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      scroll-behavior: smooth;
      background-color: #ffffff;
      color: #0a2540;
    }
    video {
      width: 100%;
      height: auto;
      aspect-ratio: 16 / 9;
      object-fit: cover;
    }
    .hamburger span {
      display: block;
      width: 24px;
      height: 2px;
      background-color: #000;
      margin: 5px auto;
      transition: all 0.3s ease-in-out;
    }
    .hamburger.active span:nth-child(1) {
      transform: rotate(45deg) translate(5px, 5px);
    }
    .hamburger.active span:nth-child(2) {
      opacity: 0;
    }
    .hamburger.active span:nth-child(3) {
      transform: rotate(-45deg) translate(5px, -5px);
    }

    section {
      margin: 0;
      padding: 0;
    }
    /* Parallax container */
    .parallax {
      perspective: 1000px;
      overflow-x: hidden;
      overflow-y: auto;
      height: 100vh;
      scroll-snap-type: y mandatory;
    }
    /* Each page full viewport height */
    .page {
      scroll-snap-align: start;
      height: 100vh;
      position: relative;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
    /* Tilt Parallax effect container */
    .tilt-parallax {
      transform-style: preserve-3d;
      transition: transform 0.2s ease-out;
      will-change: transform;
    }
    /* Hide scrollbar for all browsers */
    .parallax::-webkit-scrollbar {
      display: none;
    }
    .parallax {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
    .slider-button {
      background-color: #8c9464;
      border: none;
      color: #a1c6ea;
      font-size: 1.5rem;
      padding: 0.5rem 0.75rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
      user-select: none;
      box-shadow: 0 0 8px rgba(10,37,64,0.3);
    }
    .slider-button:hover {
      background-color: #a1c6ea;
      color: #0a2540;
    }
    video::-internal-media-controls {
      display:none;
    }
        nav {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: saturate(180%) blur(10px);
            color: #0a2540;
            box-shadow: 0 2px 8px rgba(10, 37, 64, 0.1);
        }
        nav a {
            color: #0a2540;
            font-weight: 600;
        }
        nav a:hover {
            color: #4a90e2;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
      #parallax-image {
      transform: translateY(0px);
      transition: transform 0.1s linear;
      will-change: transform;
    }
     .no-scrollbar::-webkit-scrollbar {
    display: none;
  }
  .no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
  }
  [x-cloak] 
  { display: none; }
    </style>
</head>

<body class="overflow-y-scroll parallax">
  <header class="sticky top-0 z-50 w-full transition-all duration-300"
    :class="{ 'bg-white shadow-lg': isScrolled, 'bg-transparent shadow-none': !isScrolled }"
    x-data="{ mobileMenuOpen: false, searchOpen: false }">

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex h-16 items-center justify-between">

      <a href="/" class="text-xl sm:text-2xl font-bold text-black-600 hover:text-black-500 transition-colors">
        <span class="text-black-700 light:text-black-200">SGV</span>
      </a>

      <nav class="hidden  lg:flex space-x-4 xl:space-x-12 bg-white rounded-lg p-2 shadow-md">
        <a href="/" class="text-gray-700 light:text-gray-200 hover:text-8c9464-600 transition text-lg xl:text-base">Brand</a>
        <a href="/products" class="text-gray-700 light:text-gray-200 hover:text-8c9464-600 transition text-lg xl:text-base">Products</a>
        <a href="/" class="text-gray-700 light:text-gray-200 hover:text-8c9464-600 transition text-lg xl:text-base">Services</a>
        <a href="/" class="text-gray-700 light:text-gray-200 hover:text-8c9464-600 transition text-lg xl:text-base">FindUs</a>
      </nav>

      <div class="flex items-center space-x-2">
        <button @click="searchOpen = !searchOpen" class="p-2 rounded hover:bg-gray-100 light:hover:bg-gray-800">
          <i data-lucide="search" class="w-5 h-5 sm:w-6 sm:h-6"></i>
        </button>

        <button class="relative p-2 rounded hover:bg-gray-100 light:hover:bg-gray-800">
          <i data-lucide="shopping-cart" class="w-5 h-5 sm:w-6 sm:h-6"></i>
          <span class="absolute -top-1 -right-1 bg-purple-600 text-white text-[10px] sm:text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
        </button>
        <a href="/profile" class="p-2 rounded hover:bg-gray-100 light:hover:bg-gray-800">
          <i data-lucide="user" class="w-5 h-5 sm:w-6 sm:h-6"></i>
        </a>
        <button
          class="lg:hidden p-2 rounded hover:bg-gray-100 light:hover:bg-gray-800"
          @click="mobileMenuOpen = !mobileMenuOpen"
          x-init="x$watch('mobileMenuOpen', () => lucide.createIcons())"
        >
          <i :data-lucide="mobileMenuOpen ? 'x' : 'menu'" class="w-5 h-5 sm:w-6 sm:h-6"></i>
        </button>
      </div>
    </div>

    <div x-show="searchOpen" x-cloak x-transition class="mt-2 border-t pt-3">
      <div class="relative">
        <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-4 w-4"></i>
        <input
          type="search"
          placeholder="Search products..."
          class="w-full py-2 pl-10 pr-4 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
          autofocus
        />
      </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" x-cloak x-transition class="lg:hidden mt-3 border-t pt-3 space-y-2 pb-4">
      <a href="/" class="block text-lg xl:text-base py-2 px-3 rounded hover:bg-gray-100 light:hover:bg-gray-800">Brand</a>
      <a href="/products" class="block text-lg xl:text-base py-2 px-3 rounded hover:bg-gray-100 light:hover:bg-gray-800">Products</a>
      <a href="/" class="block text-lg xl:text-base py-2 px-3 rounded hover:bg-gray-100 light:hover:bg-gray-800">Services</a>
      <a href="/" class="block text-lg xl:text-base py-2 px-3 rounded hover:bg-gray-100 light:hover:bg-gray-800">Find Us</a>
      <hr class="border-gray-200 light:border-gray-700" />
      <!-- <a href="/" class="block py-2 px-3 rounded hover:bg-gray-100 light:hover:bg-gray-800">Sign In</a> -->
      <!-- <a href="/" class="block py-2 px-3 rounded hover:bg-gray-100 light:hover:bg-gray-800">Register</a> -->
    </div>
  </div>
</header>

  <script>
    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobileMenu');

    hamburger.addEventListener('click', () => {
      hamburger.classList.toggle('active');
      mobileMenu.classList.toggle('hidden');
    });

    function toggleDropdown(button) {
      const ul = button.nextElementSibling;
      ul.classList.toggle('hidden');
    }
  </script>