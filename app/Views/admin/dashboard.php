<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - SecretGarden</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="p-4 bg-white shadow flex justify-between items-center">
        <h1 class="text-2xl font-bold text-[#6dbb43]">Admin Dashboard</h1>
        <a href="<?= site_url('logout') ?>" class="text-red-500 hover:underline">Logout</a>
    </div>
    <div class="p-4">
        <a href="<?= site_url('admin/products') ?>" class="block mb-2 text-blue-500 hover:underline">Manage Products</a>
        <a href="<?= site_url('admin/categories') ?>" class="block mb-2 text-blue-500 hover:underline">Manage Categories</a>
        <a href="<?= site_url('admin/orders') ?>" class="block text-blue-500 hover:underline">Manage Orders</a>
    </div>
</body>
</html>
