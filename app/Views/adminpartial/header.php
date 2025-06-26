<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Panel - SecretGarden</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="shortcut icon" href="<?= base_url('assets/SGV/sg.png') ?>" type="image/x-icon">
  <link rel="icon" href="<?= base_url('assets/SGV/sg.png') ?>" type="image/x-icon">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            secretGarden: '#eab676',
          }
        }
      }
    }
  </script>
</head>
<body class="bg-gray-100 text-gray-800">

<div class="flex min-h-screen">
  <!-- Sidebar -->
  <aside class="w-64 bg-white shadow-lg flex flex-col fixed inset-y-0 left-0 z-40 transform -translate-x-full transition-transform duration-200 ease-in-out md:relative md:translate-x-0 md:flex">
    <div class="p-6 border-b border-gray-200">
      <h1 class="text-2xl font-bold text-secretGarden tracking-wide">
      <img class="w-[90px] h-auto" src="<?= base_url('assets/SGV/sg.png') ?>" alt="SecretGarden Official"></h1>
    </div>
    <nav class="flex-1 px-4 py-4 space-y-2 text-sm">
      <a href="<?= site_url('admin/dashboard') ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-secretGarden/20 text-gray-700 hover:text-secretGarden transition ">
        <svg class="w-5 h-5 text-secretGarden group-hover:scale-110 transition" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M13 5v6m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        Dashboard
      </a>
      <a href="<?= site_url('admin/categories') ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-secretGarden/10 text-gray-700 hover:text-secretGarden transition group">
        <svg class="w-5 h-5 text-secretGarden group-hover:scale-110 transition" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h8m-8 6h16"/></svg>
        Categories
      </a>
      <a href="<?= site_url('admin/products') ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-secretGarden/10 text-gray-700 hover:text-secretGarden transition group">
        <svg class="w-5 h-5 text-secretGarden group-hover:scale-110 transition" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18m-6 5h6"/></svg>
        Products
      </a>
      <a href="<?= site_url('admin/orders') ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-secretGarden/10 text-gray-700 hover:text-secretGarden transition group">
        <svg class="w-5 h-5 text-secretGarden group-hover:scale-110 transition" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        Orders
      </a>
      <a href="<?= site_url('admin/users') ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-secretGarden/10 text-gray-700 hover:text-secretGarden transition group">
        <svg class="w-5 h-5 text-secretGarden group-hover:scale-110 transition" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A11.963 11.963 0 0112 15c2.485 0 4.779.755 6.879 2.041M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        Users
      </a>
      <a href="<?= site_url('admin/settings') ?>" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-secretGarden/10 text-gray-700 hover:text-secretGarden transition group">
        <svg class="w-5 h-5 text-secretGarden group-hover:scale-110 transition" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17a4 4 0 01-4-4V5m4 0a4 4 0 014 4v8m0 0h4m-4 0H7"/></svg>
        Settings
      </a>
    </nav>
  </aside>

  <button id="sidebarToggle" class="md:hidden fixed top-4 right-4 z-50 bg-secretGarden text-white p-2 rounded-full shadow-lg focus:outline-none">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
    </svg>
  </button>

  <!-- Main Content Area -->
  <div class="flex-1 flex flex-col overflow-hidden">

    <!-- Header -->
   <header class="bg-white shadow flex items-center justify-between px-6 h-16">
  <div class="text-lg font-semibold tracking-wide text-secretGarden">Admin Panel</div>

  <div class="flex items-center space-x-6">
    <!-- Notification Bell -->
    <div class="relative group">
      <button class="relative focus:outline-none">
        <svg class="w-6 h-6 text-gray-600 hover:text-secretGarden transition" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C8.67 6.165 8 7.388 8 8.75v5.408c0 .538-.214 1.055-.595 1.437L6 17h5m4 0v1a2 2 0 11-4 0v-1m4 0H9" />
        </svg>

        <!-- Notification Badge -->
        <span class="absolute top-0 right-0 inline-block w-2.5 h-2.5 bg-red-600 rounded-full animate-ping"></span>
        <span class="absolute top-0 right-0 inline-block w-2.5 h-2.5 bg-red-600 rounded-full"></span>
      </button>

      <!-- Dropdown (Optional Future Feature) -->
      <div class="hidden group-hover:block absolute right-0 mt-2 w-64 bg-white rounded-md shadow-lg border z-50">
        <div class="p-4 text-sm text-gray-700">
          <p class="font-semibold">Notifications</p>
          <ul class="mt-2 space-y-2">
            <li class="text-gray-600">🔔 No new notifications.</li>
            <!-- Tambahkan item notifikasi di sini -->
          </ul>
        </div>
      </div>
    </div>

    <span class="text-sm font-medium text-gray-700">Hi, <?= isset($_SESSION['user']['name']) && $_SESSION['user']['name'] !== null ? htmlspecialchars($_SESSION['user']['name']) : 'Guest' ?></span>
    <a href="<?= site_url('logout') ?>" class="text-sm text-red-600 hover:underline">Logout</a>
  </div>
</header>

    <main class="flex-1 overflow-y-auto p-6">



      <script>
    const sidebar = document.querySelector('aside');
    const toggleBtn = document.getElementById('sidebarToggle');
    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('-translate-x-full');
    });
    document.addEventListener('click', function(e) {
      if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target) && window.innerWidth < 768) {
        sidebar.classList.add('-translate-x-full');
      }
    });
  </script>
