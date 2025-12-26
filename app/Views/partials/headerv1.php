<?php
$roleId = session()->get('user')['role_id'] ?? 999;
if (!in_array($roleId, [99, 999])) {
    echo "<script>window.location.href = '/admin'</script>";
}
$menus = getSidebarMenuPublic($roleId);

function renderDockMenu($menus, $isMobile = false) {
    foreach ($menus as $m) {
        $type = $m['type'] ?? 'static';
        $children = $m['children'] ?? [];
        $hasChildren = !empty($children);

        if ($hasChildren) {
            $containerClass = $isMobile ? 'mb-2' : 'relative group';
            echo '<div class="'.$containerClass.'" x-data="{ open: false }">';

            // BUTTON HANYA UNTUK MENU YANG PUNYA CHILD
            echo '<button @click="open = !open" '.(!$isMobile ? '@mouseenter="open=true" @mouseleave="open=false"' : '').' 
                  class="w-full text-left px-4 py-2 flex items-center justify-between font-bold hover:bg-gray-100 rounded transition">
                    '.esc($m['name']).'
                    <svg class="w-4 h-4 ml-2 transition-transform" :class="{\'rotate-180\': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                  </button>';

            // CHILD MENU
            echo '<div x-show="open" x-cloak x-transition class="'.($isMobile ? 'pl-4' : 'absolute left-0 top-full w-screen max-w-4xl bg-white shadow-xl rounded-lg z-50 border border-gray-100 p-6').'">';
            echo '<div class="'.($isMobile ? 'flex flex-col gap-1' : 'grid grid-cols-2 md:grid-cols-3 gap-6').'">';

            foreach ($children as $child) {
                $childType = $child['type'] ?? 'static';

                if ($childType === 'static') {
                    echo '<a href="'.base_url($child['url'] ?? '#').'" class="block w-full px-4 py-2 font-semibold text-gray-800 hover:text-[#8c9464] hover:bg-gray-100 rounded transition">
                            '.esc($child['name']).'
                          </a>';
                }

                if ($childType === 'product') {
                    $img = $child['main_images'] ?? 'noimg.jpg';
                    $catSlug = strtolower(str_replace(' ','-',$child['catname'] ?? ''));
                    echo '<a href="'.base_url('products/'.$child['url']).'" class="flex flex-col w-full group hover:bg-gray-50 rounded transition p-1">
                            <img src="'.base_url("assets/SGV/Category/$catSlug/".$child['url'].'/'.$img).'" 
                                class="w-[50px] h-[50px] object-cover rounded mb-2 group-hover:opacity-80 " alt="'.esc($child['name']).'">
                            <span class="text-sm font-semibold">'.esc($child['name']).'</span>
                          </a>';
                }

                if ($childType === 'post') {
                    echo '<a href="'.base_url($child['url'] ?? '#').'" class="block w-full px-4 py-2 font-semibold text-gray-800 hover:text-[#8c9464] hover:bg-gray-100 rounded transition">
                            '.esc($child['name']).'
                          </a>';
                }
            }

            echo '</div></div></div>';
        } else {
            echo '<a href="'.base_url($m['url'] ?? '#').'" class="block w-full px-4 py-2 font-bold hover:text-[#8c9464] hover:bg-gray-100 rounded transition">
                    '.esc($m['name']).'
                  </a>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth" x-data="{ mobileMenuOpen: false, searchOpen: false, isScrolled: false }"
      x-init="window.addEventListener('scroll', () => isScrolled = window.scrollY > 50)">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?= esc($companySetting['name'] ?? 'SecretGarden') ?> | <?= $pageTitle ?? '' ?></title>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/alpinejs" defer></script>
<script src="https://unpkg.com/lucide@latest"></script>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;700&display=swap" rel="stylesheet">
<link rel="shortcut icon" href="<?= base_url($companySetting['logo'] ?? 'assets/SGV/logo/logo.jpg') ?>" type="image/x-icon">
<link rel="stylesheet" href="<?= base_url('style.css') ?>">

</head>
<body class="font-poppins">

<div id="loader-overlay" class="fixed inset-0 z-50 flex items-center justify-center bg-white transition-opacity duration-500">
  <div class="flex flex-row gap-2">
    <div class="w-4 h-4 rounded-full bg-yellow-700 animate-bounce"></div>
    <div class="w-4 h-4 rounded-full bg-yellow-700 animate-bounce [animation-delay:-.3s]"></div>
    <div class="w-4 h-4 rounded-full bg-yellow-700 animate-bounce [animation-delay:-.5s]"></div>
  </div>
</div>
<div class="h-[70px] md:h-[70px]"></div>

<!-- Header -->
<header x-data="{ mobileOpen: false }" :class="mobileOpen ? 'overflow-hidden' : ''" class="fixed top-0 left-0 w-full z-50 bg-white shadow">
  <div class="container mx-auto px-4 py-4 flex justify-between items-center">
    <!-- Logo -->
    <a href="/" class="text-xl flex items-center font-bold text-[#8c9464] select-none">
      <img class="h-10 w-auto object-contain" src="<?= base_url($companySetting['logo'] ?? 'assets/SGV/logo/logo.jpg') ?>" alt="<?= esc($companySetting['name'] ?? 'SecretGarden') ?>">
    </a>

    <!-- Desktop Menu -->
    <nav class="hidden lg:flex items-center space-x-6 font-poppins text-lg font-bold">
        <?php renderDockMenu($menus); ?>
    </nav>

    <!-- Right Buttons -->
    <div class="flex items-center space-x-4">

      <!-- Search Overlay Trigger -->
      <?= view('partials/search_overlay') ?>
      
      <!-- Cart -->
      <a href="<?= base_url('cart') ?>" class="p-2 rounded hover:bg-gray-100"><i data-lucide="shopping-bag" class="w-5 h-5"></i></a>

      <!-- Profile -->
      <div class="relative" x-data="{ showProfile: false }">
        <button @click="showProfile = !showProfile" class="p-2 rounded hover:bg-gray-100">
          <i data-lucide="user" class="w-5 h-5"></i>
        </button>
        <div x-show="showProfile" @click.outside="showProfile = false" x-cloak x-transition class="absolute right-0 mt-2 w-40 bg-white shadow-md rounded z-50 py-2">
          <?php if (session()->has('user')): ?>
            <a href="<?= base_url('profile') ?>" class="block px-4 py-2 hover:bg-gray-100 font-bold text-base">My Account</a>
            <a href="<?= base_url('order') ?>" class="block px-4 py-2 hover:bg-gray-100 font-bold text-base">My Orders</a>
            <a href="<?= base_url('logout') ?>" class="block px-4 py-2 hover:bg-gray-100 font-bold text-base">Logout</a>
          <?php else: ?>
            <a href="<?= base_url('profile') ?>" class="block px-4 py-2 hover:bg-gray-100 font-bold text-base">Login</a>
          <?php endif; ?>
        </div>
      </div>

      <!-- Mobile Menu Toggle -->
      <button @click="mobileOpen = !mobileOpen; document.body.style.overflow = mobileOpen ? 'hidden' : 'auto'" class="lg:hidden p-2 rounded hover:bg-gray-100">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
      </button>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div x-show="mobileOpen" x-cloak x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="fixed inset-y-0 right-0 w-64 bg-white shadow-lg z-50 flex flex-col px-6 py-8 lg:hidden overflow-y-auto">
    <button @click="mobileOpen=false; document.body.style.overflow='auto'" class="self-end mb-6 p-2 rounded hover:bg-gray-100">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
    <?php renderDockMenu($menus, true); ?>
  </div>

  <!-- Overlay -->
  <div x-show="mobileOpen" x-cloak x-transition.opacity class="fixed inset-0 bg-black bg-opacity-30 z-40 lg:hidden" @click="mobileOpen=false; document.body.style.overflow='auto'"></div>
</header>


<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('mobileMenu', () => ({
        open: false,
        toggle() {
            this.open = !this.open;
            document.body.style.overflow = this.open ? 'hidden' : 'auto';
        },
        close() {
            this.open = false;
            document.body.style.overflow = 'auto';
        }
    }));
});
</script>
