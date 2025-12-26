<?php
$roleId = session()->get('user')['role_id'] ?? null;
if ($roleId == NULL || $roleId == 99) { 
    echo "<script>window.location.href = '/'</script>";
}
$menus = getSidebarMenu($roleId);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($companySetting['name'] ?? 'SecretGarden') ?> | <?= $pageTitle ?? '' ?></title>
<link rel="shortcut icon" href="<?= base_url($companySetting['logo'] ?? 'assets/SGV/logo/logo.jpg') ?>" type="image/x-icon">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://kit.fontawesome.com/72b236a30b.js" crossorigin="anonymous"></script>

<audio id="notifSoundProductAdded" 
       src="<?= $notifSounds['product_added'] ?? base_url('assets/sounds/notif.mp3') ?>" 
       preload="auto">
</audio>

<style>
.icon-picker { display: flex; flex-wrap: wrap; gap: 8px; max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 8px; border-radius: 6px; background: #f9f9f9; }
.icon-picker i { font-size: 20px; cursor: pointer; padding: 4px; border-radius: 4px; transition: 0.2s; }
.icon-picker i:hover, .icon-picker i.selected { background-color: #3b82f6; color: white; }
::-webkit-scrollbar { width: 6px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.2); border-radius: 3px; }
::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,0.3); }
[x-cloak] { display: none !important; }

/* Tooltip */
.tooltip {
  position: absolute;
  left: 100%;
  top: 50%;
  transform: translateY(-50%) translateX(5px);
  background: rgba(0,0,0,0.8);
  color: #fff;
  padding: 0.25rem 0.5rem;
  border-radius: 0.25rem;
  font-size: 0.75rem;
  white-space: nowrap;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.25s ease-in-out, transform 0.25s ease-in-out;
}
.menu-item:hover .tooltip {
  opacity: 1;
  transform: translateY(-50%) translateX(0);
}

.menu-item:hover i {
  animation: bounce 0.3s;
}
@keyframes bounce {
  0%,100% { transform: translateY(0); }
  50% { transform: translateY(-4px); }
}
</style>
</head>
<body class="bg-gray-50 text-black font-<?= ($companySetting['font'] ?? 'playfair') ?> antialiased" x-data="sidebar()" x-init="init()">

<!-- HEADER -->
<header class="bg-white backdrop-blur-md bg-opacity-80 shadow-sm flex justify-between items-center px-6 py-3 sticky top-0 z-50 transition-all duration-300">
  <div class="flex items-center space-x-4">
    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-700 hover:text-gray-900 focus:outline-none">
      <i class="fas fa-bars text-xl transition-transform duration-300" :class="{'rotate-90': sidebarOpen}"></i>
    </button>
    <div class="flex items-center space-x-3">
      <img src="<?= base_url($companySetting['logo'] ?? 'assets/SGV/logo/logo.jpg') ?>" alt="Logo" class="h-10 w-auto  shadow-sm">
    </div>
  </div>

  <div class="flex items-center space-x-4">
    <div x-data="notificationDropdown()" class="relative">
    <!-- Icon bell + badge -->
    <button @click="toggle()" class="relative focus:outline-none">
        <i class="fas fa-bell text-gray-700 text-lg"></i>
        <span x-show="count > 0" x-text="count" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs"></span>
    </button>

    <!-- Dropdown -->
    <div x-show="open" @click.away="open=false" x-transition class="absolute right-0 mt-2 w-96 max-h-96 bg-white border border-gray-200 rounded-2xl shadow-xl z-50 ring-1 ring-gray-200 overflow-auto">
        <div class="p-2">
        <h4 class="font-semibold text-gray-700 mb-2">Notifikasi Produk</h4>
        <template x-for="notif in notifications" :key="notif.id">
            <div class="px-3 py-2 rounded-lg hover:bg-gray-100 cursor-pointer"
                @click="markRead(notif.id)">
            <span x-text="notif.message"></span>
            <p class="text-xs text-gray-500" x-text="new Date(notif.created_at).toLocaleString()"></p>
            </div>
        </template>
        <div x-show="notifications.length == 0" class="px-3 py-2 text-gray-500">Tidak ada notifikasi</div>
        </div>
    </div>
    </div>
    <!-- Profile -->
    <div class="relative" x-data="{ open: false }">
      <button @click="open=!open" class="flex items-center space-x-2 focus:outline-none">
        <span class="font-medium text-gray-800"><?= ucwords(session()->get('user')['username'] ?? 'User') ?></span>
        <img src="<?= base_url(session()->get('user')['avatar'] ?? 'assets/SGV/profile/default.png') ?>" alt="Avatar" class="h-8 w-8 rounded-full border-2 border-gray-200 object-cover shadow-sm">
        <i class="fas fa-chevron-down text-gray-400 text-sm"></i>
      </button>
      <div x-show="open" @click.away="open=false" x-transition class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-2xl shadow-xl z-50 ring-1 ring-gray-200">
        <a href="<?= base_url('/profile') ?>" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 transition rounded-lg">Profile</a>
        <a href="<?= base_url('/logout') ?>" class="block px-4 py-2 text-red-600 hover:bg-red-100 transition rounded-lg">Logout</a>
      </div>
    </div>
  </div>
</header>

<div class="flex h-full overflow-hidden">

  <!-- MOBILE OVERLAY -->
  <div class="fixed inset-0 bg-black bg-opacity-25 z-30 md:hidden" 
       x-show="sidebarOpen" @click="sidebarOpen=false" x-transition.opacity></div>

  <!-- SIDEBAR -->
  <aside 
    x-cloak
    :class="{
      'w-64': expanded && !sidebarOpen,
      'w-30': !expanded && !sidebarOpen,
      'fixed inset-y-0 left-0 z-40 transform md:relative md:translate-x-0 transition-all duration-500 ease-in-out shadow-lg': true,
      '-translate-x-full': !sidebarOpen
    }"
    class="flex flex-col mt-0 bg-white/90 backdrop-blur-md rounded-r-2xl overflow-y-auto text-black">

    <!-- Desktop toggle -->
    <div class="flex  p-2 hidden md:block">
      <button @click="toggle()" 
              class=" justify-right bg-gradient-to-r from-yellow-500 to-purple-500 text-black rounded-full p-2 shadow-lg hover:scale-110 transition-transform duration-300">
        <i :class="expanded ? 'fas fa-angle-left' : 'fas fa-angle-right'"></i>
      </button>
    </div>

    
    <!-- NAV -->
    <nav class="flex-1 flex flex-col mt-4 space-y-2 px-2">
    <?php
    function renderDockMenu($menus) {
        foreach ($menus as $m) {
            $hasChildren = isset($m['children']) && !empty($m['children']);
            $isActive = url_is($m['url'].'*') 
                ? 'bg-yellow-100 text-yellow-800 font-semibold' 
                : 'text-black hover:bg-yellow-50 hover:text-yellow-800';
            $icon = !empty($m['icon']) ? esc($m['icon']) : 'fas fa-circle';

            if ($hasChildren) {
                echo '<div x-data="{ open: false }" class="relative">';
                echo '<button @click="open = !open" class="flex items-center w-full h-12 px-3 rounded-xl '.$isActive.' transition-all duration-300 shadow-sm hover:shadow-md menu-item">';
                echo '<i class="'.$icon.' text-lg transform transition-transform duration-300 group-hover:scale-110 text-black"></i>';
                echo '<span x-show="expanded" x-transition.opacity.duration.300ms class="ml-3 font-medium truncate drop-shadow-sm text-black">'
                     .esc($m['name']).'</span>';
                echo '<span class="tooltip drop-shadow-md" x-show="!expanded" x-transition.opacity.duration.300ms>'.esc($m['name']).'</span>';
                echo '<i class="fas fa-chevron-down ml-auto text-black" x-show="open" x-transition.opacity.duration.300ms></i>';
                echo '</button>';

                echo '<div x-show="open" x-transition:enter="transition ease-out duration-300 transform" 
                      x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                      x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0"
                      x-transition:leave-end="opacity-0 -translate-y-2"
                      class="ml-6 mt-1 flex flex-col space-y-1">
                      ';
                      
                renderDockMenu($m['children']);
                echo '</div></div>';
            } else {
                echo '<a href="'.base_url($m['url']).'" 
                        class="flex items-center w-full h-12 px-3 rounded-xl '.$isActive.'
                        transition-all duration-300 shadow-sm hover:shadow-md group menu-item">';
                echo '<i class="'.$icon.' text-lg transform transition-transform duration-300 group-hover:scale-110 text-black"></i>';
                echo '<span x-show="expanded" x-transition.opacity.duration.300ms class="ml-3 font-medium truncate drop-shadow-sm text-black">'
                     .esc($m['name']).'</span>';
                echo '<span class="tooltip drop-shadow-md" x-show="!expanded" x-transition.opacity.duration.300ms>'.esc($m['name']).'</span>';
                echo '</a>';
            }
        }
    }

    renderDockMenu($menus);
    ?>
    </nav>
  </aside>

  <!-- MAIN CONTENT -->
  <main :class="expanded ? 'ml-0 md:ml-0' : 'ml-0 md:ml-0'" class="flex-1 p-6 transition-all duration-500 ease-in-out">
