<?php
$roleId = session()->get('user')['role_id'] ?? null;
if ($roleId === null || $roleId == 99) {
    return redirect()->to('/');
}
$menus = getSidebarMenu($roleId) ?? [];
$companyName = esc($companySetting['name'] ?? 'SecretGarden');
$logoUrl = base_url($companySetting['logo'] ?? 'assets/SGV/logo/logo.jpg');
$fontFamily = esc($companySetting['font'] ?? 'playfair');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $companyName ?> | <?= $pageTitle ?? '' ?></title>
<link rel="shortcut icon" href="<?= $logoUrl ?>" type="image/x-icon">

<script src="https://cdn.tailwindcss.com/3.4.13"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
<script src="https://kit.fontawesome.com/72b236a30b.js" crossorigin="anonymous" defer></script>

<audio id="notifSoundProductAdded"
       src="<?= $notifSounds['product_added'] ?? base_url('assets/sounds/notif.mp3') ?>"
       preload="auto"></audio>

<style>
.icon-picker{display:flex;flex-wrap:wrap;gap:8px;max-height:200px;overflow-y:auto;border:1px solid #ddd;padding:8px;border-radius:6px;background:#f9f9f9}
.icon-picker i{font-size:20px;cursor:pointer;padding:4px;border-radius:4px;transition:.2s}
.icon-picker i:hover,.icon-picker i.selected{background:#3b82f6;color:white}
::-webkit-scrollbar{width:6px}
::-webkit-scrollbar-thumb{background:rgba(0,0,0,0.3);border-radius:3px}
[x-cloak]{display:none!important}

/* Tooltip */
.tooltip{position:absolute;left:100%;top:50%;transform:translateY(-50%) translateX(5px);background:rgba(0,0,0,0.8);color:#fff;padding:.25rem .5rem;border-radius:.25rem;font-size:.75rem;white-space:nowrap;opacity:0;pointer-events:none;transition:opacity .25s ease,transform .25s ease}
.menu-item:hover .tooltip{opacity:1;transform:translateY(-50%) translateX(0)}
.menu-item:hover i{animation:bounce .3s}
@keyframes bounce{50%{transform:translateY(-4px)}}

@media (min-width: 1024px){
  .sidebar{transform:none!important;translate:none!important;position:relative!important;left:0!important;opacity:1!important;display:flex!important}
}
</style>
</head>

<body class="bg-gray-50 text-black font-<?= $fontFamily ?> antialiased" x-data="sidebar()" x-init="init()">

<!-- HEADER -->
<header class="bg-white/80 backdrop-blur-md shadow-sm flex justify-between items-center px-6 py-3 sticky top-0 z-50">
  <div class="flex items-center space-x-4">
    <!-- Toggle mobile -->
    <button @click="toggle()" class="md:hidden">
      <i class="fa-solid fa-bars-staggered text-xl transition-transform duration-300"
         :class="{'rotate-90': sidebarOpen}"></i>
    </button>
    <img src="<?= $logoUrl ?>" alt="Logo" class="h-10 w-auto rounded-lg shadow-sm">
  </div>

  <div class="flex items-center space-x-4">
    <!-- Notifikasi -->
    <div x-data="notificationDropdown()" class="relative">
      <button @click="toggle()" class="relative">
        <i class="fa-regular fa-bell text-gray-700 text-lg"></i>
        <span x-show="count>0" x-text="count"
              class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs"></span>
      </button>
      <div x-show="open" @click.away="open=false" x-transition
           class="absolute right-0 mt-2 w-96 max-h-96 bg-white border rounded-2xl shadow-xl overflow-auto z-50">
        <div class="p-2">
          <h4 class="font-semibold mb-2">Notifikasi Produk</h4>
          <template x-for="notif in notifications" :key="notif.id">
            <div class="px-3 py-2 hover:bg-gray-100 cursor-pointer" @click="markRead(notif.id)">
              <span x-text="notif.message"></span>
              <p class="text-xs text-gray-500" x-text="new Date(notif.created_at).toLocaleString()"></p>
            </div>
          </template>
          <div x-show="notifications.length===0" class="px-3 py-2 text-gray-500">Tidak ada notifikasi</div>
        </div>
      </div>
    </div>

    <!-- Profile -->
    <div class="relative" x-data="{ open:false }">
      <button @click="open=!open" class="flex items-center space-x-2">
        <span class="font-medium hidden sm:inline"><?= ucwords(session()->get('user')['username'] ?? 'User') ?></span>
        <img src="<?= base_url(session()->get('user')['avatar'] ?? 'assets/SGV/profile/default.png') ?>"
             class="h-8 w-8 rounded-full border object-cover">
        <i class="fa-solid fa-chevron-down text-gray-400 text-sm"></i>
      </button>
      <div x-show="open" @click.away="open=false" x-transition
           class="absolute right-0 mt-2 w-48 bg-white border rounded-2xl shadow-xl z-50">
        <a href="<?= base_url('/profile') ?>" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
        <a href="<?= base_url('/logout') ?>" class="block px-4 py-2 text-red-600 hover:bg-red-100">Logout</a>
      </div>
    </div>
  </div>
</header>

<div class="flex h-full overflow-hidden">
  <!-- Overlay Mobile -->
  <div class="fixed inset-0 bg-black bg-opacity-25 z-30 md:hidden"
       x-show="sidebarOpen" @click="sidebarOpen=false" x-transition.opacity></div>

  <!-- SIDEBAR -->
  <aside x-cloak
    :class="[expanded ? 'w-64' : 'w-20',
    'flex flex-col bg-white/90 backdrop-blur-md rounded-r-2xl overflow-y-auto text-black transition-all duration-500 ease-in-out shadow-lg',
    sidebarOpen ? 'translate-x-0' : '-translate-x-full']"
    class="sidebar fixed inset-y-0 left-0 z-40 transform md:relative md:translate-x-0">

    <!-- Toggle Button Desktop -->
    <div class="hidden md:flex justify-end p-2">
      <button @click="toggle()" class="bg-gradient-to-r from-yellow-400 to-purple-500 rounded-full p-2 shadow-lg hover:scale-110 transition">
        <i :class="expanded ? 'fa-solid fa-circle-chevron-left' : 'fa-solid fa-circle-chevron-right'" class="text-white text-lg"></i>
      </button>
    </div>

    <!-- Menu -->
    <nav class="flex-1 flex flex-col mt-4 space-y-2 px-2">
      <?php
      function renderDockMenu($menus){
        foreach($menus as $m){
          $hasChildren=isset($m['children']) && !empty($m['children']);
          $isActive=url_is($m['url'].'*')?'bg-yellow-100 text-yellow-800 font-semibold':'text-black hover:bg-yellow-50 hover:text-yellow-800';
          $icon=!empty($m['icon'])?esc($m['icon']):'fas fa-circle';

          if($hasChildren){
            echo '<div x-data="{ open:false }" class="relative">';
            echo '<button @click="open=!open" class="flex items-center w-full h-12 px-3 rounded-xl '.$isActive.' transition-all duration-300 shadow-sm hover:shadow-md menu-item">';
            echo '<i class="'.$icon.' text-lg"></i>';
            echo '<span x-show="expanded" x-transition.opacity.duration.300ms class="ml-3 font-medium truncate text-black">'.esc($m['name']).'</span>';
            echo '<span class="tooltip" x-show="!expanded">'.esc($m['name']).'</span>';
            echo '<i class="fa-solid fa-chevron-down ml-auto" x-show="open" x-transition></i>';
            echo '</button>';
            echo '<div x-show="open" x-transition:enter="transition ease-out duration-300 transform"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-200 transform"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2"
                        class="ml-6 mt-1 flex flex-col space-y-1">';
            renderDockMenu($m['children']);
            echo '</div></div>';
          } else {
            echo '<a href="'.base_url($m['url']).'" class="flex items-center w-full h-12 px-3 rounded-xl '.$isActive.' transition-all duration-300 shadow-sm hover:shadow-md menu-item">';
            echo '<i class="'.$icon.' text-lg"></i>';
            echo '<span x-show="expanded" x-transition.opacity.duration.300ms class="ml-3 font-medium truncate text-black">'.esc($m['name']).'</span>';
            echo '<span class="tooltip" x-show="!expanded">'.esc($m['name']).'</span>';
            echo '</a>';
          }
        }
      }
      renderDockMenu($menus);
      ?>
    </nav>
  </aside>

  <!-- MAIN -->
  <main class="flex-1 p-6 transition-all duration-500 ease-in-out">
