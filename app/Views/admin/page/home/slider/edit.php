<?= view('adminpartial/header') ?>

<div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-8 mt-10">
  <h2 class="text-2xl font-semibold mb-6">Edit Slider</h2>

  <form action="<?= base_url('admin/page/home/slider/update/') ?><?=$slider['id']?>" method="post" enctype="multipart/form-data" class="space-y-6">
    <!-- Preview -->

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">Preview Desktop</label>
      <?php if($slider['type'] === 'image' && $slider['srcD']): ?>
        <img src="<?= base_url('public/assets/SGV/Page/Home/'.$slider['srcD']) ?>" class="w-60 h-36 object-cover rounded">
      <?php else: ?>
        <video src="<?= base_url('public/assets/SGV/Page/Home/'.$slider['srcD']) ?>" class="w-60 h-36 rounded" muted autoplay loop></video>
      <?php endif; ?>
    </div>
    
     <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">Preview Mobile</label>
      <?php if($slider['type'] === 'image' && $slider['srcM']): ?>
        <img src="<?= base_url('public/assets/SGV/Page/Home/'.$slider['srcM']) ?>" class="w-60 h-36 object-cover rounded">
      <?php else: ?>
        <video src="<?= base_url('public/assets/SGV/Page/Home/'.$slider['srcM']) ?>" class="w-60 h-36 rounded" muted autoplay loop></video>
      <?php endif; ?>
    </div>

    <!-- File Baru -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Change File Desktop
        <span title="Maksimal 10MB, format MP4, resolusi 16:9" class="text-blue-500 cursor-pointer">ℹ️</span>
      </label>
      <input type="file" name="fileD" accept="image/*,video/*"
        class="mt-2 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:ring focus:ring-blue-200" />
      <p class="text-xs text-gray-500 mt-1">Leave Blank If There No Change</p>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700">Change File Mobile 
        <span title="Maksimal 10MB, format MP4, resolusi 16:9" class="text-blue-500 cursor-pointer">ℹ️</span>
      </label>
      <input type="file" name="fileM" accept="image/*,video/*"
        class="mt-2 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:ring focus:ring-blue-200" />
      <p class="text-xs text-gray-500 mt-1">Leave Blank If There No Change</p>
    </div>

    <!-- Alt Text -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Alt Text</label>
      <input type="text" name="alt" value="<?= esc($slider['alt']) ?>"
        class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
    </div>

    <!-- Durasi -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Durasi Tayang (ms)</label>
      <input type="number" name="duration" value="<?= $slider['duration'] ?>"
        class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
    </div>
    
    <select name="status" class="w-full border p-2 rounded">
      <option value="1" <?= $slider['status']=='active'?'selected':'' ?>>Active</option>
      <option value="0" <?= $slider['status']=='inactive'?'selected':'' ?>>Inactive</option>
    </select>

    <!-- Submit -->
    <div class="flex justify-end">
      <a href="/admin/page/home" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 mr-2">Batal</a>
      <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Update</button>
    </div>
  </form>
  </div>

  <?= view('adminpartial/footer') ?>
