<?php echo view('partials/header', ['title' => 'User Profile']); ?>
<div class="bg-white text-gray-900">
  <div class="max-w-5xl mx-auto p-6 space-y-6">
    <section
      class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden"
    >
      <div
        class="relative h-28 bg-gradient-to-r from-[#cbd5e1] to-[#7b8ca6] rounded-t-xl"
      >
        <img
          src="<?= base_url().'assets/SGV/profile/'.strtolower(str_replace(" ","-",$user['id'])).'/'.$user['cover_photo']?>"
          alt="Profile Cover"
          class="w-[1000px] h-[110px] object-cover rounded-t-xl"
        />
      </div>
      <div class="relative -mt-14 flex flex-col items-center px-6 pb-6">
        <div class="relative">
          <img
            src="<?= base_url().'assets/SGV/profile/'.strtolower(str_replace(" ","-",$user['id'])).'/'.$user['avatar']?>"
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
        <h2 class="mt-3 font-semibold text-gray-900 text-lg"><?= esc(Ucwords($user['username']))?></h2>
        <p class="text-gray-500 text-sm"><?= esc($user['bio'])?></p>
      </div>
      <nav
        class="flex items-center justify-start space-x-6 border-t border-gray-200 px-6 py-3 text-gray-500 text-sm"
      >
        <a
          href="#"
          class="flex items-center space-x-1 hover:text-gray-700 transition"
          ><i class="fas fa-user-circle text-xs"></i><span>My Profile</span></a
        >
        <a href="<?=base_url('profile/'.$user['username']) ?>"
          class="mr-100 bg-white border border-gray-300 rounded-md px-4 py-1.5 text-gray-700 text-sm font-semibold hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
          Edit
        </a>
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
            <a href="#profile">Profile</a>
          </li>
          <li class="flex items-center space-x-2">
            <i class="fas fa-map-marker-alt text-xs"></i>
            <a  href="#address">Address</a>
          </li>
          <li class="flex items-center space-x-2">
            <i class="far fa-clock text-xs"></i>
            <a  href="#privacy">Privacy</a>
          </li>
          <li class="flex items-center space-x-2">
            <i class="far fa-envelope text-xs"></i>
            <a  href="#notification">Notification</a>
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
              <span>Help center</span>
            </span>
            <i class="fas fa-chevron-right text-gray-400"></i>
          </button>
        </div>
      </aside>

     <main class="p-6 flex-1">
        <div class="flex items-center justify-between mb-4">
          <h3 class="font-semibold text-gray-900 text-base">History</h3>
          <div class="flex items-center space-x-3">
            <div
              aria-label="Search projects"
              class="relative text-gray-400 focus-within:text-gray-600"
            >
              <input
                type="search"
                placeholder="Search"
                class="pl-9 pr-3 py-1.5 rounded-lg border border-gray-200 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              />
              <i
                class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400 text-sm"
              ></i>
            </div>
            
          </div>
        </div>
        <div
          class="border border-gray-200 rounded-lg p-10 flex flex-col items-center justify-center text-center text-gray-500 space-y-4"
        >
          
        </div>
      </main>
    </section>
  </div>
</div>
<?php echo view('partials/footer'); ?>