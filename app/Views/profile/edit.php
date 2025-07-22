<?php echo view('partials/header', ['title' => 'User Profile']); ?>
<?php
// echo '<pre>' . print_r($address, true) . '</pre>';
?>
<style>
.section{
  display:none;
}
.active{
  display:block;
}

</style>

<div class="bg-white text-gray-900">
  <div class="max-w-5xl mx-auto p-6 space-y-6">
    <section
      class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden"
    >
      <div
        class="relative h-28 bg-gradient-to-r from-[#cbd5e1] to-[#7b8ca6] rounded-t-xl"
      >
        <img
          src="<?= base_url().'assets/SGV/profile/'.strtolower(str_replace(" ","-",$user['id_user'])).'/'.$user['cover_photo']?>"
          alt="Profile Cover"
          class="w-[1000px] h-[110px] object-cover rounded-t-xl"
        />
      </div>
      <div class="relative -mt-14 flex flex-col items-center px-6 pb-6">
        <div class="relative">
          <img
            src="<?= base_url().'assets/SGV/profile/'.strtolower(str_replace(" ","-",$user['id_user'])).'/'.$user['avatar']?>"
            alt="Profile Picture"
            class="w-24 h-24 rounded-full border-4 border-white object-cover"
            width="96"
            height="96"
          />
          <button
            aria-label="Mood icon"
            class="absolute bottom-0 right-0 bg-white border border-gray-200 rounded-full p-1.5 text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            <i class="far fa-smile"></i>
          </button>
        </div>
        <h2 class="mt-3 font-semibold text-gray-900 text-lg"><?= esc($user['name'])?></h2>
        <p class="text-gray-500 text-sm"><?= esc($user['bio'])?></p>
      </div>
      <nav
        class="flex items-center justify-start space-x-6 border-t border-gray-200 px-6 py-3 text-gray-500 text-sm"
      >
        <a
          class=" flex items-center space-x-1 hover:text-gray-700 transition"
          ><i class="fas fa-user-circle text-xs"></i><span>My Profile</span></a
        >
        
      </nav>
    </section>

    <section
      class="bg-white border border-gray-200 rounded-xl shadow-sm flex flex-col md:flex-row overflow-hidden"
    >
      <aside
        class="border-b md:border-b-0 md:border-r border-gray-200 p-6 w-full md:w-64 flex-shrink-0"
      >
        <h3 class="font-semibold text-gray-900 mb-4">About</h3>
        <ul class="space-y-3 text-gray-600 text-sm">
          <li class="flex items-center space-x-2">
            <i class="fas fa-building text-xs"></i>
            <button onclick="changeSection('profile')">Profile</button>
          </li>
          <li class="flex items-center space-x-2">
            <i class="fas fa-map-marker-alt text-xs"></i>
            <button onclick="changeSection('address')">Address</button>
          </li>
          <li class="flex items-center space-x-2">
            <i class="far fa-clock text-xs"></i>
            <button onclick="changeSection('privacy')">Privacy</button>
          </li>
          <li class="flex items-center space-x-2">
            <i class="far fa-envelope text-xs"></i>
            <button onclick="changeSection('notification')">Notification</button>
          </li>
        </ul>
        <hr class="my-6 border-gray-200" />
        <p class="text-gray-500 text-xs mb-3">Explore help topics</p>
        <div class="space-y-3">
          <button
            class="w-full flex items-center justify-between border border-gray-300 rounded-lg px-4 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            <span class="flex items-center space-x-2">
              <i class="fas fa-life-ring text-gray-600 text-sm"></i>
              <a href="<?= base_url("service") ?>">Help center</a>
            </span>
            <i class="fas fa-chevron-right text-gray-400"></i>
          </button>
        </div>
      </aside>

      <main class="p-6 flex-1"> 
          <div class="y3kub w5ck6 zxv30 k9mkq yxawv ntfdl mzy38 light:bg-neutral-800 light:border-neutral-700">
          

          <form action="<?= base_url('profile/update') ?>" method="post" class="space-y-6" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="section" id="profile">
              <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold light:text-neutral-200">
                  Profile
                </h1>
                <p class="text-sm text-gray-500 mb-10">
                  Manage your name, password and account settings.
                </p>
              </div>

              <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input
                  type="text"
                  name="name"
                  id="name"
                  value="<?= esc($user['name']) ?>"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-gray-900"
                  required
                />
              </div>
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input
                  type="email"
                  name="email"
                  id="email"
                  value="<?= esc($user['email']) ?>"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-gray-900"
                  required
                />
              </div>
              <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input
                  type="text"
                  name="username"
                  id="username"
                  value="<?= esc($user['username']) ?>"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-gray-900"
                  required
                />
                <button class="bg-blue rounded-md">Check</button>
              </div>
              <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input
                  type="password"
                  name="password"
                  id="password"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-gray-900"
                  placeholder="Leave blank to keep current password"
                />
              </div>
              <div>
                <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                <textarea
                  name="bio"
                  id="bio"
                  rows="3"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-gray-900"
                ><?= esc($user['bio']) ?></textarea>
              </div>
            </div>
            <div class="section" id="addresses">
              <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold light:text-neutral-200">
                  Address
                </h1>
                <p class="text-sm text-gray-500 mb-10">
                  Manage your address and contact information.
                </p>
              </div>
              <?php $no=0; foreach($address as $addr): ?>
                <div class="mb-4">
                  <label class="block text-sm font-medium text-gray-700">Address <?= $no+=1?></label>
                  <input
                    type="text"
                    name="address_line1[]"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-gray-900"
                    placeholder="<?= esc($addr['address_line1']) ?>"
                  />
                </div>
                  <?php endforeach; ?>
                <button onclick="changeSection('addressadd')">Privacy</button>

            </div>
            <div class="section" id="address">
              <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold light:text-neutral-200">
                  Address
                </h1>
                <p class="text-sm text-gray-500 mb-10">
                  Manage your address and contact information.
                </p>
              </div>
                <div>
                <label for="address_line1" class="block text-sm font-medium text-gray-700">Address Line 1</label>
                <input
                  type="text"
                  name="address_line1"
                  id="address_line1"
                  value="<?= esc($user['address_line1'] ?? '') ?>"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-gray-900"
                  placeholder="Street address, P.O. box"
                />
                </div>
                <div class="mt-4">
                <label for="address_line2" class="block text-sm font-medium text-gray-700">Address Line 2</label>
                <input
                  type="text"
                  name="address_line2"
                  id="address_line2"
                  value="<?= esc($user['address_line2'] ?? '') ?>"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-gray-900"
                  placeholder="Apartment, suite, unit, building, floor, etc."
                />
                </div>
                <div class="mt-4">
                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                <input
                  type="text"
                  name="city"
                  id="city"
                  value="<?= esc($user['city'] ?? '') ?>"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-gray-900"
                />
                </div>
                <div class="mt-4">
                <label for="state" class="block text-sm font-medium text-gray-700">State/Province</label>
                <input
                  type="text"
                  name="state"
                  id="state"
                  value="<?= esc($user['state'] ?? '') ?>"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-gray-900"
                />
                </div>
                <div class="mt-4">
                <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal Code</label>
                <input
                  type="text"
                  name="postal_code"
                  id="postal_code"
                  value="<?= esc($user['postal_code'] ?? '') ?>"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-gray-900"
                />
                </div>
                <div class="mt-4">
                <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                <?php
                // Fetch country list from an online API (e.g., restcountries.com)
                $countries = [];
                try {
                  $response = file_get_contents('https://restcountries.com/v3.1/all');
                  if ($response !== false) {
                    $data = json_decode($response, true);
                    if (is_array($data)) {
                      foreach ($data as $country) {
                        if (isset($country['name']['common'])) {
                          $countries[] = $country['name']['common'];
                        }
                      }
                      sort($countries);
                    }
                  }
                } catch (Exception $e) {
                  $countries = ['Indonesia', 'Malaysia', 'Singapore', 'Thailand', 'Philippines', 'Vietnam', 'Brunei', 'Cambodia', 'Laos', 'Myanmar', 'Timor-Leste'];
                }
                ?>
                <select
                  name="country"
                  id="country"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-gray-900"
                >
                  <option value="">Select country</option>
                  <?php foreach ($countries as $country): 
                  $selected = (isset($user['country']) && $user['country'] === $country) ? 'selected' : '';
                  ?>
                  <option value="<?= esc($country) ?>" <?= $selected ?>><?= esc($country) ?></option>
                  <?php endforeach; ?>
                </select>
                </div>
                <div class="mt-4">
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input
                  type="text"
                  name="phone"
                  id="phone"
                  value="<?= esc($user['phone'] ?? '') ?>"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-gray-900"
                />
                </div>
            </div>

            <div class="section" id="privacy">
              <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold light:text-neutral-200">
                  Privacy
                </h1>
                <p class="text-sm text-gray-500 mb-10">
                  Manage your privacy settings and who can see your information.
                </p>
              </div>
            </div>

            <div class="section" id="notification">
              <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold light:text-neutral-200">
                  Notification
                </h1>
                <p class="text-sm text-gray-500 mb-10">
                  Manage your notification preferences and alerts.
                </p>
              </div>
            </div>

            <div>
              <button
                type="submit"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
              >
                Save Changes
              </button>
            </div>
          </form>
        </div>
      </main>
    </section>
  </div>
</div>


<script>

  function changeSection(section) {
    const sections = document.querySelectorAll('.section');
    sections.forEach(sec => {
      sec.style.display = 'none';
    });
    document.getElementById(section).style.display = 'block';
  }
changeSection('profile');
</script>
<?php echo view('partials/footer'); ?>