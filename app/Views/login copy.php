<?php echo view('partials/header', ['title' => 'User Access']); ?>
<style>
  .bubble-effect {
    background: rgba(255, 255, 255, 0.8);
    border-radius: 20px;
    position: relative;
    overflow: hidden;
  }
  .bubble-effect::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 20%, transparent 20%);
    background-size: 50px 50px;
    animation: bubble 10s infinite;
    pointer-events: none;
  }
  @keyframes bubble {0% {transform: translateY(0);}100% {transform: translateY(-20px);}}
  .bubble-input {width: 100%;padding: 10px;border: 2px solid #c9ac6c;border-radius: 20px;transition: all 0.3s ease;}
  .bubble-input:focus {border-color: #b29356;box-shadow: 0 0 5px rgba(201, 172, 108, 0.5);}
  .bubble-button {width: 100%;padding: 10px;background-color: #c9ac6c;color: white;border: none;border-radius: 20px;cursor: pointer;transition: background-color 0.3s ease;}
  .bubble-button:hover {background-color: #b29356;}
  .tab-button {text-transform: uppercase;font-weight: 500;border-bottom: 2px solid transparent;color: #999;transition: all 0.3s ease;}
  .tab-button.active-tab {color: #c9ac6c;border-bottom: 2px solid #c9ac6c;}
</style>

<div class="min-h-screen flex items-center justify-center px-4 font-[Poppins]">
  <div class="w-full max-w-xl bg-white border border-gray-200 rounded-3xl p-8 shadow-lg bubble-effect">
    <!-- Logo -->
    <div class="text-center mb-6">
      <img src="<?=base_url($companySetting['logo']) ?>" alt="Logo" class="w-[20vh] mx-auto">
    </div>

    <!-- Tabs -->
    <div class="flex justify-center gap-8 mb-6 text-sm">
      <button id="loginTab" class="tab-button active-tab">Login</button>
      <button id="registerTab" class="tab-button">Register</button>
      <button id="forgotTab" class="tab-button">Forgot</button>
    </div>


    <!-- Login Form -->
    <form id="loginForm" action="<?= base_url('auth/login') ?>" method="post" class="space-y-5">
      <?= csrf_field() ?>
      <div>
        <label class="block text-sm text-gray-600">Username/Email</label>
        <input type="text" name="usermail" required placeholder="mail@youremail" class="bubble-input">
      </div>
      <div>
        <label class="block text-sm text-gray-600">Password</label>
        <input type="password" name="password" required placeholder="••••••••" class="bubble-input">
      </div>
      <button type="submit" class="bubble-button">Login</button>
      </br>
    </form>

    <!-- Register Form -->
    <form id="registerForm" action="<?= base_url('auth/register') ?>" method="post" class="space-y-5 hidden">
      <?= csrf_field() ?>
      <div>
        <label class="block text-sm text-gray-600">Full Name</label>
        <input type="text" name="name" required placeholder="Your full name" class="bubble-input">
      </div>
      <div>
        <label class="block text-sm text-gray-600">Username</label>
        <input type="text" name="username" required placeholder="Unique username" class="bubble-input">
      </div>
      <div>
        <label class="block text-sm text-gray-600">Email</label>
        <input type="email" name="email" required placeholder="you@example.com" class="bubble-input">
      </div>
      <div>
        <label class="block text-sm text-gray-600">Phone Number</label>
        <input type="text" name="phone" placeholder="" class="bubble-input">
      </div>
      <div>
        <label class="block text-sm text-gray-600">Address</label>
        <input type="text" name="address" placeholder="Address" class="bubble-input">
      </div>
      <div>
        <label class="block text-sm text-gray-600">Location</label>
        <input type="text" name="location" placeholder="City / Region" class="bubble-input">
      </div>
      <div>
        <label class="block text-sm text-gray-600">Birthday</label>
        <input type="date" name="birthday" class="bubble-input">
      </div>
      <div>
        <label class="block text-sm text-gray-600">Bio</label>
        <textarea name="bio" placeholder="Tell us about yourself..." class="bubble-input"></textarea>
      </div>
      <div>
        <label class="block text-sm text-gray-600">Password</label>
        <input type="password" name="password" required placeholder="Create a password" class="bubble-input">
      </div>
      <div>
        <label class="block text-sm text-gray-600">Confirm Password</label>
        <input type="password" name="password_confirm" required placeholder="Repeat password" class="bubble-input">
      </div>
      <button type="submit" class="bubble-button">Register</button>
    </form>


    <form id="forgotForm" action="<?= base_url('auth/forgot') ?>" method="post" class="space-y-5 hidden">
      <?= csrf_field() ?>
      <div>
        <label class="block text-sm text-gray-600">Username/Email</label>
        <input type="text" name="usermail" required placeholder="Username / Email" class="bubble-input">
      </div>
        <button type="submit" class="bubble-button">Request New Password</button>
    </form>
  </div>
</div>

<script>
  const loginTab = document.getElementById('loginTab');
  const registerTab = document.getElementById('registerTab');
  const forgotTab = document.getElementById('forgotTab');
  const loginForm = document.getElementById('loginForm');
  const registerForm = document.getElementById('registerForm');
  const forgotForm = document.getElementById('forgotForm');

  loginTab.onclick = () => {
    loginTab.classList.add('active-tab');
    registerTab.classList.remove('active-tab');
    forgotTab.classList.remove('active-tab');
    registerForm.classList.add('hidden');
    registerForm.classList.add('hidden');
    forgotForm.classList.add('hidden');
    loginForm.classList.remove('hidden');
  };


  registerTab.onclick = () => {
    registerTab.classList.add('active-tab');
    loginTab.classList.remove('active-tab');
    forgotTab.classList.remove('active-tab');
    loginForm.classList.add('hidden');
    forgotForm.classList.add('hidden');
    registerForm.classList.remove('hidden');
  };

  forgotTab.onclick = () => {
    forgotTab.classList.add('active-tab');
    loginTab.classList.remove('active-tab');
    registerTab.classList.remove('active-tab');
    registerForm.classList.add('hidden');
    loginForm.classList.add('hidden');
    forgotForm.classList.remove('hidden');
  };


  <?php if (old('name')): ?>
    registerTab.click();
  <?php endif; ?>
</script>

<script>
function checkIdentity(type, value, inputElement) {
  if (!value) return;
  fetch(`<?= base_url('auth/checkidentity') ?>?type=${type}&value=${encodeURIComponent(value)}`)
    .then(res => res.json())
    .then(data => {
      const warningId = `${type}-warning`;
      let warning = document.getElementById(warningId);

      if (!warning) {
        warning = document.createElement('div');
        warning.id = warningId;
        warning.className = 'text-xs text-red-500 mt-1';
        inputElement.parentNode.appendChild(warning);
      }

      if (data.exists) {
        warning.textContent = `${type.charAt(0).toUpperCase() + type.slice(1)} sudah digunakan`;
        inputElement.classList.add('border-red-500');
      } else {
        warning.textContent = '';
        inputElement.classList.remove('border-red-500');
      }
    });
}

document.querySelector('input[name="email"]').addEventListener('blur', function() {
  checkIdentity('email', this.value, this);
});
document.querySelector('input[name="username"]').addEventListener('blur', function() {
  checkIdentity('username', this.value, this);
});
</script>

<?php echo view('partials/footer'); ?>
