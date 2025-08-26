<?php
$roleId = session()->get('user')['role_id'] ?? null;
    if ($roleId == NULL || $roleId == 99) { 
    echo "<script>    window.location.href = '/'</script> ";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($companySetting['name'] ?? 'SecretGarden') ?> | <?= $pageTitle ?? '' ?></title>
<link rel="shortcut icon" href="<?= base_url($companySetting['logo'] ?? 'assets/SGV/logo/logo.jpg') ?>" type="image/x-icon">
<link rel="icon" href="<?= base_url($companySetting['logo'] ?? 'assets/SGV/logo/logo.jpg') ?>" type="image/x-icon">
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<meta name="csrf-token-name" content="<?= csrf_token() ?>">
<meta name="csrf-token-hash" content="<?= csrf_hash() ?>">
</head>
<body class="bg-gray-100 font-sans antialiased" x-data="{ sidebarOpen: false }">
<header class="bg-white shadow flex justify-between items-center px-4 md:px-6 py-3 sticky top-0 z-30">
    <div class="flex items-center space-x-4">
        <button @click="sidebarOpen = !sidebarOpen" class="md:hidden focus:outline-none">
            <i class="fas fa-bars text-xl text-gray-700"></i>
        </button>
        <div class="flex items-center space-x-2">
            <img src="<?= base_url($companySetting['logo'] ?? 'assets/SGV/logo/logo.jpg') ?>" alt="Logo" class="h-10 w-auto">
            <span class="hidden md:block font-bold text-lg text-gray-800"><?= esc($companySetting['name'] ?? 'SecretGarden') ?></span>
        </div>
    </div>

    <div class="relative" x-data="{ open: false }">
        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
            <span class="font-medium text-gray-700"><?= session()->get('user')['name'] ?? 'User' ?></span>
            <img src="<?= base_url(session()->get('user')['avatar'] ?? 'assets/SGV/avatar/default.png') ?>" 
                 alt="Avatar" class="h-8 w-8 rounded-full object-cover">
            <i class="fas fa-chevron-down text-gray-500 text-sm"></i>
        </button>

        <div x-show="open" @click.away="open = false" x-transition
             class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50">
            <a href="<?= base_url('/profile') ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
            <a href="<?= base_url('/logout') ?>" class="block px-4 py-2 text-red-600 hover:bg-red-100">Logout</a>
        </div>
    </div>
</header>

<div class="flex h-screen overflow-hidden">

    <aside class="bg-white border-r border-gray-200 fixed inset-y-0 left-0 z-30 w-64
                  transform md:translate-x-0 transition-transform duration-300 ease-in-out"
           :class="{'-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen}">
        <div class="p-4 flex items-center justify-center md:justify-start">
            <img src="<?= base_url($companySetting['logo'] ?? 'assets/SGV/logo/logo.jpg') ?>" alt="Logo" class="h-10 w-auto md:ml-2">
        </div>
        <nav class="mt-6 px-2" x-data="{ openMenu: null }">
            <?php
            $menus = getSidebarMenu($roleId);

            function renderMenu($menus, $level = 0) {
                foreach ($menus as $m) {
                    $hasChildren = isset($m['children']) && !empty($m['children']);
                    $isActive = url_is($m['url'].'*') ? 'bg-gray-200 font-semibold' : '';

                    if ($hasChildren) {
                        echo '<div class="mb-1" x-data="{ open: false }">';
                        echo '<button @click="open = !open" class="flex items-center justify-between w-full py-2 px-3 hover:bg-gray-100 '.$isActive.'">';
                        echo '<span><i class="'.esc($m['icon']).' mr-2"></i>'.esc($m['name']).'</span>';
                        echo '<i :class="open ? \'fa fa-chevron-up\' : \'fa fa-chevron-down\'" class="text-xs text-gray-500"></i>';
                        echo '</button>';
                        echo '<div x-show="open" x-transition class="ml-4 border-l border-gray-200 pl-2">';
                        renderMenu($m['children'], $level+1);
                        echo '</div></div>';
                    } else {
                        echo '<a href="'.base_url($m['url']).'" class="flex items-center py-2 px-3 hover:bg-gray-100 '.$isActive.'">';
                        echo '<i class="'.esc($m['icon']).' mr-2 text-gray-600"></i>'.esc($m['name']).'</a>';
                    }
                }
            }
            renderMenu($menus);
            ?>
        </nav>
    </aside>

    <div class="fixed inset-0 bg-black bg-opacity-25 z-20 md:hidden" x-show="sidebarOpen" @click="sidebarOpen = false" x-transition></div>
    <main class="flex-1 ml-0 md:ml-64 p-6 overflow-auto">
     
    