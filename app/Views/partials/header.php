<?php
$roleId = session()->get('user')['role_id'] ?? 999;
if (!in_array($roleId, [99, 999])) {
    echo "<script>window.location.href = '/admin'</script>";
    exit;
}
$menus = getSidebarMenuPublic($roleId);
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title><?= esc($companySetting['name'] ?? 'SecretGarden') ?> | <?= $pageTitle ?? '' ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Cormorant+Garamond:wght@500;700&display=swap" rel="stylesheet">
  <link rel="icon" href="<?= base_url($companySetting['logo'] ?? 'assets/SGV/logo/logo.jpg') ?>">
  <script src="https://unpkg.com/alpinejs" defer></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="stylesheet" href="<?= base_url('css/style.css')?>">

  <style>
    #loader-overlay {
      opacity: 1;
      display: flex;
      transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
      background: rgba(255,255,255,0.9);
      backdrop-filter: blur(8px);
    }
    #loader-overlay.fade-out {
      opacity: 0;
      transform: scale(0.5);
      pointer-events: none;
    }
    @keyframes pulseLogo {
      0%, 100% { transform: scale(1); opacity: 0.9; }
      50% { transform: scale(0.5); opacity: 1; }
    }
    .loader-logo {
      animation: pulseLogo 2s infinite;
    }
  </style>
</head>

<body class="font-[Poppins]" x-data="{ mobileOpen:false, showServices:false, showProfile:false }">

<div class="loader border-r-2 rounded-full border-yellow-500 bg-yellow-300 animate-bounce
aspect-square w-8 flex justify-center items-center text-yellow-700">SecretGarden.ID</div>
<header 
  x-data="{ showNav:false, isScrolled:false }"
  x-init="
    window.addEventListener('scroll', () => {
      isScrolled = window.scrollY > 50;
      if(isScrolled) showNav = true;
    });
    window.addEventListener('mousemove', (e)=>{
      if(e.clientY < 80) showNav = true; 
      else if(!isScrolled) showNav = false;
    });
  "
  :class="showNav ? 'bg-white/80 shadow-md backdrop-blur-xl' : 'bg-transparent'"
  class="fixed top-0 left-0 w-full z-50 transition-all duration-500 ease-in-out"
>
  <div class="container mx-auto px-6 lg:px-12 py-4 flex justify-between items-center 
              transition-all duration-500 ease-in-out"
       :class="showNav ? 'text-gray-900' : 'text-white'">
    
    <a href="/" class="flex items-center space-x-3 transition-all duration-500">
      <img class="h-12 w-auto object-contain transition-all duration-500"
           :class="showNav ? 'opacity-100 scale-100' : 'opacity-90 scale-95'"
           src="<?= base_url($companySetting['logo'] ?? 'assets/SGV/logo/logo.jpg') ?>" 
           alt="<?= esc($companySetting['name'] ?? 'SecretGarden Official') ?>">
    </a>

    <nav class="hidden lg:flex items-center space-x-10 font-medium text-lg">
      <template x-for="item in [
        { text:'Brand', url:'<?= base_url('brand') ?>' },
        { text:'Products', url:'<?= base_url('products') ?>' },
        { text:'Find Us', url:'<?= base_url('findus') ?>' }
      ]">
        <a :href="item.url" 
           class="relative group transition-colors duration-300"
           :class="showNav ? 'text-gray-700 hover:text-[#8c9464]' : 'text-white hover:text-gray-200'">
          <span x-text="item.text"></span>
          <span class="absolute left-1/2 -bottom-1 w-0 h-[2px] bg-[#8c9464] 
                       transition-all duration-300 group-hover:w-full group-hover:left-0"></span>
        </a>
      </template>

      <!-- Dropdown -->
      <div class="relative" x-data="{ open:false }">
        <button @click="open=!open"
          class="flex items-center relative group transition-colors duration-300"
          :class="showNav ? 'text-gray-700 hover:text-[#8c9464]' : 'text-white hover:text-gray-200'">
          Services
          <svg class="ml-1 w-4 h-4 transition-transform duration-300"
               :class="{ 'rotate-180': open }" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
          <span class="absolute left-1/2 -bottom-1 w-0 h-[2px] bg-[#8c9464] 
                       transition-all duration-300 group-hover:w-full group-hover:left-0"></span>
        </button>
        <div x-show="open" @click.outside="open=false" x-transition
             class="absolute right-0 mt-3 w-52 bg-white/95 backdrop-blur-md shadow-lg rounded-xl p-3 space-y-2">
          <a href="<?= base_url('services/contact-us/') ?>" 
             class="block px-4 py-2 rounded-lg hover:bg-gray-100">Contact Us</a>
          <a href="<?= base_url('services/coorporate-gift') ?>" 
             class="block px-4 py-2 rounded-lg hover:bg-gray-100">Corporate Gift</a>
        </div>
      </div>
    </nav>

   <div class="flex items-center space-x-4">
    <button id="openSearch" 
            class="p-2 rounded-full transition-all duration-300"
            :class="showNav ? 'hover:bg-gray-100 bg-transparent' : 'bg-transparent hover:bg-transparent'">
      <i data-lucide="search" class="w-5 h-5"></i>
    </button>
    
    <a href="<?= base_url('cart') ?>" 
      class="p-2 rounded-full relative transition-all duration-300"
      :class="showNav ? 'hover:bg-gray-100 bg-transparent' : 'bg-transparent hover:bg-transparent'">
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
    <button @click="mobileOpen=!mobileOpen" 
            class="lg:hidden p-2 rounded-full transition-all duration-300"
            :class="showNav ? 'hover:bg-gray-100 bg-transparent' : 'bg-transparent hover:bg-transparent'">
      <i data-lucide="menu" class="w-6 h-6"></i>
    </button>
  </div>
  

  </div>
</header>


<!-- MOBILE SIDEBAR -->
<div x-show="mobileOpen" x-transition class="fixed inset-0 z-50 flex">
  <div class="fixed inset-0 bg-black/50" @click="mobileOpen=false"></div>
  <aside class="bg-white w-64 p-6 shadow-xl relative z-50">
    <button @click="mobileOpen=false" class="absolute top-4 right-4 p-1 hover:bg-gray-200 rounded">
      <i data-lucide="x" class="w-5 h-5"></i>
    </button>
    <nav class="mt-10 flex flex-col space-y-4 text-lg font-semibold">
      <a href="<?= base_url('brand') ?>" class="hover:text-[#8c9464]">Brand</a>
      <a href="<?= base_url('products') ?>" class="hover:text-[#8c9464]">Products</a>
      <div>
        <button @click="showServices=!showServices" class="w-full flex justify-between hover:text-[#8c9464]">
          Services
          <i :class="{ 'rotate-90': showServices }" data-lucide="chevron-right" class="w-4 h-4 transition-transform"></i>
        </button>
        <div x-show="showServices" x-transition class="ml-4 mt-2 space-y-2">
          <a href="<?= base_url('services/contact-us/') ?>" class="block hover:text-[#8c9464]">Contact Us</a>
          <a href="<?= base_url('services/coorporate-gift') ?>" class="block hover:text-[#8c9464]">Corporate Gift</a>
        </div>
      </div>
      <a href="<?= base_url('findus') ?>" class="hover:text-[#8c9464]">Find Us</a>
    </nav>
  </aside>
</div>

