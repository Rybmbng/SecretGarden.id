
<html class="scroll-smooth" lang="en" lang="en" x-data="{ mobileMenuOpen: false, searchOpen: false, isScrolled: false }"
  x-init="window.addEventListener('scroll', () => isScrolled = window.scrollY > 50)">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- <meta content="width=device-width, initial-scale=1" name="viewport"/> -->
    <title><?= esc($companySetting['name'] ?? 'SecretGarden') ?> | <?= $pageTitle ?? '' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
     <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="<?= base_url($companySetting['logo'] ?? 'assets/SGV/logo/logo.jpg') ?>" type="image/x-icon">
    <link rel="icon" href="<?= base_url($companySetting['logo'] ?? 'assets/SGV/logo/logo.jpg') ?>" type="image/x-icon">
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
<?= view('partials/search_overlay') ?>

<!-- Header -->
 
    <div id="loader-overlay" class="fixed inset-0 z-50 flex items-center justify-center bg-white transition-opacity duration-500">
      <div class="flex flex-col items-center">
        <svg class="animate-spin h-12 w-12 text-green-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
        <span class="text-green-700 font-semibold text-lg">Loading...</span>
      </div>
    </div>
    
<div class="h-[70px] md:h-[70px]"></div>

<header class="fixed top-0 left-0 w-full z-50 bg-white shadow" x-data="{ mobileOpen: false } ">
  <div class="container mx-auto px-4 py-4 flex justify-between items-center">
    <a href="/" class="text-xl flex flex-col font-bold text-[#8c9464] select-none flex justify-between items-center">
      <img class="h-10 w-auto object-contain" 
          src="<?= base_url($companySetting['logo'] ?? 'assets/SGV/logo/logo.jpg') ?>" 
          alt="<?= esc($companySetting['name'] ?? 'SecretGarden Official') ?>">
    </a>

    <!-- Desktop Menu -->
    <nav class="hidden lg:flex items-center space-x-8 font-poppins text-lg font-bold">
      <a href="<?= base_url('brand') ?>" class="text-gray-700 hover:text-[#8c9464] transition-colors duration-200 select-none px-2 py-1 rounded hover:bg-gray-100">
        Brand
      </a>
      <a href="<?= base_url('products') ?>" class="text-gray-700 hover:text-[#8c9464] transition-colors duration-200 select-none px-2 py-1 rounded hover:bg-gray-100">
        Products
      </a>
      <div class="relative" x-data="{ showServices: false }">
        <button @click="showServices = !showServices"
          class="text-gray-700 hover:text-[#8c9464] transition-colors duration-200 select-none px-2 py-1 rounded hover:bg-gray-100 flex items-center gap-1 font-bold">
          Services
          <svg class="w-4 h-4 ml-1 transition-transform duration-200" :class="{'rotate-180': showServices}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div x-show="showServices" @click.outside="showServices = false" x-cloak x-transition
             class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg z-50 py-2 border border-gray-100">
          <a href="<?= base_url('services/contactus/') ?>" class="block px-5 py-2 text-gray-700 hover:bg-gray-100 hover:text-[#8c9464] transition-colors duration-200 rounded font-bold text-base">
            Contact Us
          </a>
          <a href="<?= base_url('services/cg') ?>" class="block px-5 py-2 text-gray-700 hover:bg-gray-100 hover:text-[#8c9464] transition-colors duration-200 rounded font-bold text-base">
            Corporate Gift
          </a>
        </div>
      </div>
      <a href="<?= base_url('findus') ?>" class="text-gray-700 hover:text-[#8c9464] transition-colors duration-200 select-none px-2 py-1 rounded hover:bg-gray-100">
        Find Us
      </a>

    </nav>

    <div class="flex items-center space-x-4">
      <button class="flex p-2 hover:bg-blue-300 rounded" id='openSearch'>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="1.5em"
            height="1.5em"
            aria-hidden="true"
            viewBox="0 0 24 24"
            stroke-width="2"
            fill="none"
            stroke="currentColor"
            class="icon"
          >
            <path
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
              stroke-linejoin="round"
              stroke-linecap="round"
            ></path>
          </svg>
        </button>
      <a href="<?= base_url('cart') ?>" class="p-2 rounded hover:bg-gray-100">
        <i data-lucide="shopping-bag" class="w-5 h-5"></i>
      </a>
      <div class="relative" x-data="{ showProfile: false }">
        <button @click="showProfile = !showProfile" class="p-2 rounded hover:bg-gray-100">
          <i data-lucide="user" class="w-5 h-5"></i>
        </button>
        <div x-show="showProfile" @click.outside="showProfile = false" x-cloak x-transition
             class="absolute right-0 mt-2 w-40 bg-white shadow-md rounded z-50 py-2">
          <?php if (session()->has('user')): ?>
            <a href="<?= base_url('profile') ?>" class="block px-4 py-2 hover:bg-gray-100 font-bold text-base">My Account</a>
            <a href="<?= base_url('order') ?>" class="block px-4 py-2 hover:bg-gray-100 font-bold text-base">My Orders</a>
            <a href="<?= base_url('logout') ?>" class="block px-4 py-2 hover:bg-gray-100 font-bold text-base">Logout</a>
          <?php else: ?>
            <a href="<?= base_url('profile') ?>" class="block px-4 py-2 hover:bg-gray-100 font-bold text-base">My Account</a>
          <?php endif; ?>
        </div>
      </div>

      <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 rounded hover:bg-gray-100">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
  </div>

  <!-- Mobile Side Menu -->
  <div 
    x-show="mobileOpen" 
    x-cloak 
    x-transition:enter="transition ease-in-out duration-300 transform"
    x-transition:enter-start="translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in-out duration-300 transform"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="translate-x-full"
    class="fixed inset-y-0 right-0 w-64 bg-white shadow-lg z-50 flex flex-col px-6 py-8 lg:hidden"
    @keydown.window.escape="mobileOpen = false"
  >
    <button @click="mobileOpen = false" class="self-end mb-6 p-2 rounded hover:bg-black-100">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
    <a href="<?= base_url('brand') ?>" class="block py-2 text-black-700 hover:text-[#8c9464] select-none font-bold text-lg">Brand</a>
    <a href="<?= base_url('products') ?>" class="block py-2 text-black-600 hover:text-[#8c9464] select-none font-bold text-lg">Products</a>
    <div x-data="{ dropdown: false }" class="py-2">
      <button @click="dropdown = !dropdown" class="w-full text-left text-black-700 hover:text-[#8c9464] select-none font-bold text-lg">
        Services
      </button>
      <div x-show="dropdown" x-cloak x-transition class="pl-4 mt-1 space-y-1">
        <a href="<?= base_url('services/cu') ?>" class="block py-1 text-black-600 hover:text-[#8c9464] select-none font-bold text-base">Contact Us</a>
        <a href="<?= base_url('services/cg') ?>" class="block py-1 text-black-600 hover:text-[#8c9464] select-none font-bold text-base">Corporate Gift</a>
      </div>
    </div>
    <a href="<?= base_url('findus') ?>" class="block py-2 text-black-700 hover:text-[#8c9464] select-none font-bold text-lg">Find Us</a>
    <hr class="block py-2 select-none font-bold text-lg" style="border-color: black;">
  </div>
  <!-- Overlay -->
  <div 
    x-show="mobileOpen" 
    x-cloak 
    x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-30 z-40 lg:hidden"
    @click="mobileOpen = false"
  >
</div>
</header>
