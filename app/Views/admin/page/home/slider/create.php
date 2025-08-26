<?= $this->include('adminpartial/header') ?>

<div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-8 mt-10">
  <h2 class="text-2xl font-semibold mb-6">Tambah Slider Baru</h2>

  <form action="<?= base_url('admin/page/home/slider/store') ?>" method="post" enctype="multipart/form-data" class="space-y-6">
    <!-- File Upload -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Pilih File</label>
      <input type="file" name="file" accept="image/*,video/*" required
        class="mt-2 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:ring focus:ring-blue-200" />
      <p class="text-xs text-gray-500 mt-1">Mendukung: JPG, PNG, MP4, WEBM</p>
    </div>

    <!-- Alt Text -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Alt Text (gambar)</label>
      <input type="text" name="alt" placeholder="Deskripsi gambar"
        class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
    </div>

    <!-- Durasi -->
    <div>
      <label class="block text-sm font-medium text-gray-700">Durasi Tayang (ms)</label>
      <input type="number" name="duration" value="5000"
        class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
      <p class="text-xs text-gray-500 mt-1">Default: 5000 ms (5 detik)</p>
    </div>

    <!-- Submit -->
    <div class="flex justify-end">
      <a href="<?= base_url('/admin/sliders') ?>" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 mr-2">Batal</a>
      <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Simpan</button>
    </div>
  </form>
</div>
