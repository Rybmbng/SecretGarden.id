<?php
//  $user = session()->get('user');
//         if ($user['role'] == 'admin')
//     {
//         return view('admin/index');
//     }
;
?>

<html class="scroll-smooth" lang="en" lang="en" x-data="{ mobileMenuOpen: false, searchOpen: false, isScrolled: false }"
  x-init="window.addEventListener('scroll', () => isScrolled = window.scrollY > 50)">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- <meta content="width=device-width, initial-scale=1" name="viewport"/> -->
    <title>SecretGarden | <?= $pageTitle ?? '' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
     <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="<?= base_url('assets/SGV/sg.png') ?>" type="image/x-icon">
    <link rel="icon" href="<?= base_url('assets/SGV/sg.png') ?>" type="image/x-icon">
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <link rel="stylesheet" href="<?= base_url('style.css')?>">
    
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
<!-- Header -->
<header class="bg-white shadow" x-data="{ mobileOpen: false } ">
  <div class="container mx-auto px-4 py-4 flex justify-between items-center">
    
    <!-- Logo -->
    <a href="/" class="text-xl font-bold text-[#8c9464] select-none flex justify-between items-center">
      <img class="w-[90px] h-auto" src="<?= base_url('assets/SGV/sg.png') ?>" alt="SecretGarden Official">
    </a>

    <!-- Desktop Menu -->
    <nav class="hidden lg:flex items-center space-x-6">
      <a href="<?= base_url('brand') ?>" class="text-gray-700 hover:text-[#8c9464] transition select-none">Brand</a>
      <a href="<?= base_url('products') ?>" class="text-gray-700 hover:text-[#8c9464] transition select-none">Products</a>
      <div class="relative dropdown select-none" x-data="{ open: false }">
        <button 
          @click="open = !open" 
          class="text-gray-700 hover:text-[#8c9464] transition flex items-center"
          :aria-expanded="open"
          aria-haspopup="true"
          type="button"
        >
          Services
          <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div 
          class="dropdown-content absolute left-0 mt-2 w-48 bg-white shadow-md rounded z-50 py-2"
          x-show="open"
          x-cloak
          x-transition
          @click.away="open = false"
        >
          <a href="<?= base_url('services/cu') ?>" class="block px-4 py-2 text-gray-600 hover:text-[#8c9464] hover:bg-gray-100 select-none">Contact Us</a>
          <a href="<?= base_url('services/cg') ?>" class="block px-4 py-2 text-gray-600 hover:text-[#8c9464] hover:bg-gray-100 select-none">Corporate Gift</a>
        </div>
      </div>
      <a href="<?= base_url('findus') ?>" class="text-gray-700 hover:text-[#8c9464] transition select-none">Find Us</a>
    </nav>

    <!-- Icons -->
    <div class="flex items-center space-x-4">
      <!-- Cart -->
      <a href="<?= base_url('cart') ?>" class="p-2 rounded hover:bg-gray-100">
        <i data-lucide="shopping-bag" class="w-5 h-5"></i>
      </a>

      <!-- Profile Dropdown -->
      <div class="relative" x-data="{ showProfile: false }">
        <button @click="showProfile = !showProfile" class="p-2 rounded hover:bg-gray-100">
          <i data-lucide="user" class="w-5 h-5"></i>
        </button>
        <div x-show="showProfile" @click.outside="showProfile = false" x-cloak x-transition
             class="absolute right-0 mt-2 w-40 bg-white shadow-md rounded z-50 py-2">
          <?php if (session()->has('user')): ?>
            <a href="<?= base_url('profile') ?>" class="block px-4 py-2 hover:bg-gray-100">My Account</a>
            <a href="<?= base_url('order') ?>" class="block px-4 py-2 hover:bg-gray-100">My Orders</a>
            <a href="<?= base_url('logout') ?>" class="block px-4 py-2 hover:bg-gray-100">Logout</a>
          <?php else: ?>
            <a href="<?= base_url('profile') ?>" class="block px-4 py-2 hover:bg-gray-100">My Account</a>
          <?php endif; ?>
        </div>
      </div>

      <!-- Hamburger (Mobile only) -->
      <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 rounded hover:bg-gray-100">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div x-show="mobileOpen" x-cloak x-transition class="lg:hidden px-4 pb-4">
    <a href="<?= base_url('brand') ?>" class="block py-2 text-gray-700 hover:text-[#8c9464] select-none">Brand</a>

    <!-- Dropdown mobile -->
    <a href="<?= base_url('products') ?>" class="block py-1 text-gray-600 hover:text-[#8c9464] select-none">Products</a>
    
    <div x-data="{ dropdown: false }" class="py-2">
      <button @click="dropdown = !dropdown" class="w-full text-left text-gray-700 hover:text-[#8c9464] select-none">
        Services
      </button>
      <div x-show="dropdown" x-cloak x-transition class="pl-4 mt-1 space-y-1">
        <a href="<?= base_url('services/cu') ?>" class="block py-1 text-gray-600 hover:text-[#8c9464] select-none">Contact Us</a>
        <a href="<?= base_url('services/cg') ?>" class="block py-1 text-gray-600 hover:text-[#8c9464] select-none">Coorporate Gift</a>
      </div>
    </div>
    <a href="<?= base_url('findus') ?>" class="block py-2 text-gray-700 hover:text-[#8c9464] select-none">Find Us</a>
  </div>
</header>
