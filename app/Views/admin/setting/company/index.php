<?= view('adminpartial/header'); ?>

<div class="w-full mx-auto py-10 px-6">
  <h1 class="text-3xl font-bold mb-8 text-gray-800">Company Settings</h1>

  <?php if(session()->getFlashdata('success')): ?>
    <div class="p-4 mb-4 text-green-700 bg-green-100 rounded-lg">
      <?= session()->getFlashdata('success') ?>
    </div>
  <?php endif; ?>

  <form action="<?= base_url('admin/setting/company/update') ?>" method="post" enctype="multipart/form-data" class="bg-white shadow-md rounded-2xl p-6">
    <input type="hidden" name="id" value="<?= $company['id'] ?? '' ?>">

    <div class="mb-4">
      <label class="block text-gray-700 font-semibold mb-2">Company Name</label>
      <input type="text" name="name" value="<?= esc($company['name'] ?? '') ?>" class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-200">
    </div>

    <div class="mb-4">
      <label class="block text-gray-700 font-semibold mb-2">Tagline</label>
      <input type="text" name="tagline" value="<?= esc($company['tagline'] ?? '') ?>" class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-200">
    </div>

    <div class="grid grid-cols-2 gap-6">
      <div>
        <label class="block text-gray-700 font-semibold mb-2">Logo</label>
        <?php if(!empty($company['logo'])): ?>
          <img src="<?= base_url($company['logo']) ?>" alt="Logo" class="h-16 mb-2">
        <?php endif; ?>
        <input type="file" name="logo" class="w-full text-sm">
      </div>
      <div>
        <label class="block text-gray-700 font-semibold mb-2">Favicon</label>
        <?php if(!empty($company['favicon'])): ?>
          <img src="<?= base_url($company['favicon']) ?>" alt="Favicon" class="h-12 mb-2">
        <?php endif; ?>
        <input type="file" name="favicon" class="w-full text-sm">
      </div>
    </div>

    <div class="mt-6">
      <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700">💾 Save Changes</button>
    </div>
  </form>
</div>
