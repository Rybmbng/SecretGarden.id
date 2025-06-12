<?php echo view('partials/header', ['title' => 'User Profile']); ?>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-72 bg-white shadow-xl rounded-r-3xl flex flex-col py-10 px-8 items-center">
            <div class="flex flex-col items-center mb-10">
                <img class="w-24 h-24 rounded-full border-4 border-[#8c9464] shadow-lg mb-4" src="<?= esc($user['profile_picture']) ?>" alt="Profile Picture">
                <span class="font-bold text-xl text-gray-800 mb-1"><?= esc($user['username']) ?></span>
                <span class="text-gray-500 text-sm mb-2"><?= esc($user['email']) ?></span>
                <span class="italic text-gray-600 text-center"><?= esc($user['bio']) ?></span>
            </div>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 flex items-center justify-center p-10">
            <div class="bg-white rounded-3xl border border-[#8c9464]/20 shadow-2xl p-10 w-full max-w-2xl">
                <h2 class="text-3xl font-extrabold text-[#8c9464] mb-8 text-center">Account Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-gray-500 mb-1 font-semibold">Username</label>
                        <div class="bg-[#8c9464]/10 rounded-lg px-4 py-3 font-medium text-gray-800 shadow-inner"><?= esc($user['username']) ?></div>
                    </div>
                    <div>
                        <label class="block text-gray-500 mb-1 font-semibold">Email</label>
                        <div class="bg-[#8c9464]/10 rounded-lg px-4 py-3 font-medium text-gray-800 shadow-inner"><?= esc($user['email']) ?></div>
                    </div>
                    <div class="mt-8">
                    <label class="block text-gray-500 mb-1 font-semibold">Bio</label>
                    <div class="bg-[#8c9464]/10 rounded-lg px-4 py-3 text-gray-700 shadow-inner"><?= esc($user['bio']) ?></div>
                </div>
               
                <div class="mt-10 text-center">
                    <a href="#" class="bg-gradient-to-r from-[#8c9464] to-[#6c704a] hover:from-[#7c8454] hover:to-[#5c6040] text-white px-8 py-3 rounded-full shadow-lg font-bold text-lg transition duration-200">Edit Profile</a>
                </div>
            </div>
                </div> 
        </main>
    </div>
     <?php if (!empty($user['social_links'])): ?>
                <div class="mt-8">
                    <label class="block text-gray-500 mb-1 font-semibold">Social Links</label>
                    <div class="flex space-x-6 mt-2">
                        <?php foreach ($user['social_links'] as $platform => $link): ?>
                            <a href="<?= esc($link) ?>" target="_blank" class="text-[#8c9464] hover:text-[#6c704a] hover:underline transition capitalize font-semibold"><?= esc($platform) ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
<?php echo view('partials/footer'); ?>