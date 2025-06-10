<html class="scroll-smooth" lang="en" lang="en" x-data="{ mobileMenuOpen: false, searchOpen: false, isScrolled: false }"
  x-init="window.addEventListener('scroll', () => isScrolled = window.scrollY > 50)">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <title>SGV</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
     <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="https://www.secretgarden.co.id/skins/secret//img/logo/favicon.png" type="image/x-icon">
    <link rel="icon" href="https://www.secretgarden.co.id/skins/secret//img/logo/favicon.png" type="image/x-icon">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>

    <style>
      html, body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      scroll-behavior: smooth;
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
      background-attachment: fixed;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      will-change: transform;
      perspective: 1000px;
      overflow: visible
    }
    .parallax {
      perspective: 1000px;
      overflow-x: hidden;
      overflow-y: auto;
      height: 100vh;
      scroll-snap-type: y mandatory;
    }
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
  .brand {
     transform-style: preserve-3d;
      perspective: 1000px;
      will-change: transform;
      transition: transform 0.1s ease-out;
    }

    /* Scroll indicator track */
    #scroll-track {
      width: 4px;
      height: 150px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 9999px;
      position: fixed;
      right: 20px;
      top: 50%;
      transform: translateY(-50%);
      z-index: 50;
    }

    /* Scroll indicator bar */
    #scroll-bar {
      width: 4px;
      background: white;
      border-radius: 9999px;
      height: 0;
      transition: height 0.2s ease;
    }

    /* Intro overlay */
    #intro {
      position: fixed;
      inset: 0;
      background: black;
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      z-index: 100;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      transition: opacity 1s ease;
    }
    #intro.hide {
      opacity: 0;
      pointer-events: none;
    }
    .story-section {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    perspective: 1500px;
    background-attachment: fixed;
    background-size: cover;
    background-position: center;
    position: relative;
    overflow: visible;
  }

  .content-wrapper {
    background: rgba(0,0,0,0.6);
    padding: 3rem;
    border-radius: 1rem;
    max-width: 800px;
    color: white;
    transform-style: preserve-3d;
  }
  #background-container {
      padding-top: 10px;
      object-fit: cover;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100vh;
      overflow: hidden;
      filter: brightness(0.4) saturate(1.1);
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      transition: opacity 1s ease-in-out;
      opacity: 0;
    }
    #background-container video {
      position: fixed;
      width: 100%;
      height: 100%;
      object-fit: cover;
      top: 0; left: 0;
      z-index: -1;
    }
    .brand-story {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 2rem;
      text-align: center;
      scroll-snap-type: y mandatory;
      scroll-padding-top: 0;
      color: white; 
      transition: color 1s ease-in-out;     

    }
    .brand-story:hover {
      color: rgba(255, 255, 255, 0.8);
    }

    .typing-text {
      font-size: 5vw;
      max-width: auto;
      line-height: 1;
      text-shadow: 2px 2px 8px rgba(0,0,0,0.85);
      white-space: pre-wrap;
      user-select: none;
      /* background: rgba(0, 0, 0, 0.9);  */
      padding: 1rem 1.5rem;
      border-radius: 12px;
      margin-bottom: 3rem;
      min-height: 50px; /* jaga space supaya gak lompat */
      color: black; /* teks putih di typing */
      transition: color 1s ease-in-out;

    }
    typing-text:hover {
      color: white;
    }

    #welcome-text {
      font-size: 3rem;
      font-weight: bold;
      margin-bottom: 3rem;
      text-shadow: 3px 3px 10px rgba(0,0,0,0.9);
      color: white; 
    }

   
    </style>
</head>
<body x-data="{ mobileMenuOpen: false, searchOpen: false, isScrolled: false }"
      x-init="
        const trigger = document.getElementById('trigger');
        const observer = new IntersectionObserver(
          ([entry]) => isScrolled = !entry.isIntersecting,
          { threshold: 0 }
        );
        observer.observe(trigger);
      ">
      
  <header class="sticky top-0 z-50 bg-white shadow transition duration-300 ease-in-out"
    :class="{
      'bg-white/80 backdrop-blur-md shadow-md': isScrolled,
      'bg-transparent shadow-none': !isScrolled
    }">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 items-center justify-between">

        <!-- Logo -->
        <a href="/" class="text-xl sm:text-2xl font-bold text-gray-800 hover:text-gray-600 transition-colors">
          SGV
        </a>

        <!-- Desktop Menu -->
        <nav class="hidden lg:flex space-x-6">
            <a href="<?= base_url('brand') ?>" class="text-gray-700 hover:text-[#8c9464] transition">Brand</a>
            <a href="<?= base_url('products') ?>" class="text-gray-700 hover:text-[#8c9464] transition">Products</a>
            <a href="<?= base_url('services') ?>" class="text-gray-700 hover:text-[#8c9464] transition">Services</a>
            <a href="<?= base_url('findus') ?>" class="text-gray-700 hover:text-[#8c9464] transition">Find Us</a>
        </nav>

        <!-- Right Icons -->
        <div class="flex items-center space-x-3">
          <button @click="searchOpen = !searchOpen" class="p-2 rounded hover:bg-gray-100">
            <i data-lucide="search" class="w-5 h-5"></i>
          </button>

          <button class="relative p-2 rounded hover:bg-gray-100">
            <i data-lucide="shopping-cart" class="w-5 h-5"></i>
            <span class="absolute -top-1 -right-1 bg-purple-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
          </button>

          <a href="/profile" class="p-2 rounded hover:bg-gray-100">
            <i data-lucide="user" class="w-5 h-5"></i>
          </a>

          <!-- Hamburger -->
          <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded hover:bg-gray-100">
            <i :data-lucide="mobileMenuOpen ? 'x' : 'menu'" class="w-6 h-6"></i>
          </button>
        </div>
      </div>

      <!-- Search Box -->
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
        <a href="<?= base_url('brand') ?>" class="block py-2 px-3 rounded hover:bg-gray-100">Brand</a>
        <a href="<?= base_url('products') ?>" class="block py-2 px-3 rounded hover:bg-gray-100">Products</a>
        <a href="<?= base_url('services') ?>" class="block py-2 px-3 rounded hover:bg-gray-100">Services</a>
        <a href="<?= base_url('findus') ?>" class="block py-2 px-3 rounded hover:bg-gray-100">Find Us</a>
      </div>
    </div>
  </header>

  <script>
    document.addEventListener('alpine:init', () => {
      lucide.createIcons(); 
    });

    document.addEventListener('DOMContentLoaded', () => {
      lucide.createIcons();
    });

    document.addEventListener('alpine:mutate', () => {
      lucide.createIcons();
    });
  </script>
