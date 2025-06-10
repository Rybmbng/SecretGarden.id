<!-- /var/www/SecretGarden.id-1/app/Views/login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login & Register - SecretGarden</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .sg-green { background-color: #6dbb43; color: #fff; }
        .sg-green-text { color: #6dbb43; }
        .sg-gold { color: #bfa046; }
        .sg-gold-border { border-color: #bfa046 !important; }
        .sg-shadow { box-shadow: 0 8px 32px 0 rgba(34, 49, 63, 0.12); }
    </style>
</head>
<body class="bg-white min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-2xl sg-shadow w-full max-w-md p-8">
        <div class="flex flex-col items-center mb-8">
            <img src="https://www.secretgarden.co.id/frontsite/assets/img/logo.png" alt="SecretGarden Logo" class="h-14 mb-2">
            <h2 class="text-2xl font-semibold sg-green-text">Welcome to SecretGarden</h2>
        </div>
        <div class="flex justify-center mb-6">
            <button id="loginTab" class="px-6 py-2 font-semibold sg-green-text border-b-4 sg-gold-border focus:outline-none transition">Login</button>
            <button id="registerTab" class="px-6 py-2 font-semibold text-gray-400 border-b-4 border-transparent focus:outline-none transition">Register</button>
        </div>
        <!-- Login Form -->
        <form id="loginForm" action="<?= site_url('auth/login') ?>" method="post" class="space-y-4">
            <?= csrf_field() ?>
            <div>
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#6dbb43]">
            </div>
            <div>
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" required class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#6dbb43]">
            </div>
            <button type="submit" class="w-full sg-green py-2 rounded-lg hover:bg-[#5aa93a] transition font-semibold">Login</button>
        </form>
        <!-- Register Form -->
        <form id="registerForm" action="<?= site_url('auth/register') ?>" method="post" class="space-y-4 hidden">
            <?= csrf_field() ?>
            <div>
                <label class="block text-gray-700">Name</label>
                <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#6dbb43]">
            </div>
            <div>
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#6dbb43]">
            </div>
            <div>
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" required class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#6dbb43]">
            </div>
            <button type="submit" class="w-full sg-green py-2 rounded-lg hover:bg-[#5aa93a] transition font-semibold">Register</button>
        </form>
    </div>
    <script>
        const loginTab = document.getElementById('loginTab');
        const registerTab = document.getElementById('registerTab');
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');

        loginTab.onclick = () => {
            loginTab.classList.add('sg-green-text', 'sg-gold-border');
            loginTab.classList.remove('text-gray-400', 'border-transparent');
            registerTab.classList.remove('sg-green-text', 'sg-gold-border');
            registerTab.classList.add('text-gray-400', 'border-transparent');
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
        };
        registerTab.onclick = () => {
            registerTab.classList.add('sg-green-text', 'sg-gold-border');
            registerTab.classList.remove('text-gray-400', 'border-transparent');
            loginTab.classList.remove('sg-green-text', 'sg-gold-border');
            loginTab.classList.add('text-gray-400', 'border-transparent');
            registerForm.classList.remove('hidden');
            loginForm.classList.add('hidden');
        };
    </script>
</body>
</html>