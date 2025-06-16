<?php echo view('partials/header', ['title' => 'User Profile']); ?>
<style>
    .lognreg {
    font-family: 'Poppins', sans-serif;
    background: #f9f7f4;
    color: #1a1a1a;
    overflow: hidden;
  }

  .lux-gold {
    color: #c9ac6c;
  }

  .lux-btn {
    background-color: #c9ac6c;
    color: white;
    transition: background-color 0.3s;
  }

  .lux-btn:hover {
    background-color: #b29356;
  }

  .form-container {
    backdrop-filter: blur(16px);
    background-color: rgba(255, 255, 255, 0.7);
    border: 1px solid rgba(200, 200, 200, 0.3);
  }

  .fade-in {
    animation: fadeIn 1.5s ease-in-out forwards;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .bg-clouds {
    position: absolute;
    width: 200%;
    height: 200%;
    top: -50%;
    left: -50%;
    background: url('https://www.transparenttextures.com/patterns/cloudy-day.png');
    opacity: 0.08;
    animation: moveClouds 80s linear infinite;
    z-index: -10;
  }

  @keyframes moveClouds {
    0% { transform: translate(0, 0); }
    100% { transform: translate(50%, 50%); }
  }

  .bg-parallax-circle {
    position: absolute;
    width: 800px;
    height: 800px;
    border-radius: 9999px;
    background: radial-gradient(circle, rgba(201,172,108,0.06), transparent 70%);
    animation: moveCircle 60s ease-in-out infinite alternate;
    z-index: -20;
  }

  .bg-parallax-circle:nth-child(2) {
    top: -200px;
    left: -200px;
  }

  .bg-parallax-circle:nth-child(3) {
    bottom: -250px;
    right: -200px;
  }

  @keyframes moveCircle {
    0% { transform: translate(0, 0) scale(1); }
    100% { transform: translate(50px, 30px) scale(1.03); }
  }

  input, label {
    color: #1a1a1a;
  }

  input::placeholder {
    color: #999;
  }

  .form-container input {
    background-color: rgba(255,255,255,0.5);
    border-color: #ccc;
    color: #1a1a1a;
  }

  .form-container input:focus {
    border-color: #c9ac6c;
    outline: none;
    box-shadow: 0 0 0 1px #c9ac6c;
  }
</style>
<div class="lognreg relative flex items-center justify-center min-h-screen px-4">
    <div class="bg-gradient-back"></div>
    <div class="bg-parallax-circle"></div>
    <div class="bg-parallax-circle"></div>
    <div class="bg-clouds z-0"></div>
  <!-- Background Cloud Effect -->
  <div class="bg-clouds z-0"></div>

  <!-- Content -->
  <div class="form-container z-10 w-full max-w-md p-10 rounded-xl fade-in">

    <!-- Logo -->
    <div class="text-center mb-8">
      <img src="https://www.secretgarden.co.id/skins/secret/img/logo/favicon.png" alt="Logo" class="w-14 mx-auto mb-3">
      <h2 class="text-2xl font-semibold lux-gold uppercase tracking-widest" style="font-family: 'Playfair Display', serif;">SecretGarden</h2>
      <p class="text-sm text-gray-300 italic">Luxury Botanical Experience</p>
    </div>

    <!-- Tabs -->
    <div class="flex justify-center gap-8 mb-6 text-sm">
      <button id="loginTab" class="uppercase tracking-widest font-medium border-b-2 border-[#c9ac6c] text-[#c9ac6c] focus:outline-none">Login</button>
      <button id="registerTab" class="uppercase tracking-widest font-medium text-gray-400 border-b-2 border-transparent focus:outline-none">Register</button>
    </div>

    <!-- Login Form -->
    <form id="loginForm" action="<?= site_url('auth/login') ?>" method="post" class="space-y-5">
      <?= csrf_field() ?>
      <div>
        <label class="block text-sm text-gray-300">Email</label>
        <input type="email" name="email" required class="w-full px-3 py-2 rounded bg-transparent border border-gray-600 text-white focus:outline-none focus:ring-1 focus:ring-[#c9ac6c]">
      </div>
      <div>
        <label class="block text-sm text-gray-300">Password</label>
        <input type="password" name="password" required class="w-full px-3 py-2 rounded bg-transparent border border-gray-600 text-white focus:outline-none focus:ring-1 focus:ring-[#c9ac6c]">
      </div>
      <button type="submit" class="w-full py-2 mt-2 rounded lux-btn font-semibold tracking-wide">Login</button>
    </form>

    <!-- Register Form -->
    <form id="registerForm" action="<?= site_url('auth/register') ?>" method="post" class="space-y-5 hidden">
      <?= csrf_field() ?>
      <div>
        <label class="block text-sm text-gray-300">Name</label>
        <input type="text" name="name" required class="w-full px-3 py-2 rounded bg-transparent border border-gray-600 text-white focus:outline-none focus:ring-1 focus:ring-[#c9ac6c]">
      </div>
      <div>
        <label class="block text-sm text-gray-300">Email</label>
        <input type="email" name="email" required class="w-full px-3 py-2 rounded bg-transparent border border-gray-600 text-white focus:outline-none focus:ring-1 focus:ring-[#c9ac6c]">
      </div>
      <div>
        <label class="block text-sm text-gray-300">Password</label>
        <input type="password" name="password" required class="w-full px-3 py-2 rounded bg-transparent border border-gray-600 text-white focus:outline-none focus:ring-1 focus:ring-[#c9ac6c]">
      </div>
      <div>
        <label class="block text-sm text-gray-300">Confirm Password</label>
        <input type="password" name="password_confirm" required class="w-full px-3 py-2 rounded bg-transparent border border-gray-600 text-white focus:outline-none focus:ring-1 focus:ring-[#c9ac6c]">
      </div>
      <button type="submit" class="w-full py-2 mt-2 rounded lux-btn font-semibold tracking-wide">Register</button>
    </form>
  </div>

  <!-- Script: Tab Switch -->
  <script>
    const loginTab = document.getElementById('loginTab');
    const registerTab = document.getElementById('registerTab');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    loginTab.onclick = () => {
      loginTab.classList.add('text-[#c9ac6c]', 'border-[#c9ac6c]');
      registerTab.classList.remove('text-[#c9ac6c]', 'border-[#c9ac6c]');
      registerTab.classList.add('text-gray-400', 'border-transparent');
      loginForm.classList.remove('hidden');
      registerForm.classList.add('hidden');
    };

    registerTab.onclick = () => {
      registerTab.classList.add('text-[#c9ac6c]', 'border-[#c9ac6c]');
      loginTab.classList.remove('text-[#c9ac6c]', 'border-[#c9ac6c]');
      loginTab.classList.add('text-gray-400', 'border-transparent');
      registerForm.classList.remove('hidden');
      loginForm.classList.add('hidden');
    };

    <?php if (old('name')): ?>
      registerTab.click();
    <?php endif; ?>
  </script>
</div>
<?php echo view('partials/footer'); ?>