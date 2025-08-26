<?= view('adminpartial/header') ?>

<div class="max-w-3xl mx-auto py-10">
  <h1 class="text-2xl font-bold mb-6">Edit Store</h1>

  <form action="/admin/page/stores/update/<?= $store['id'] ?>" method="post" enctype="multipart/form-data" class="space-y-4">
    <?= csrf_field() ?>
    <div>
      <label>Nama Store</label>
      <input type="text" name="name" value="<?= esc($store['name']) ?>" class="w-full border rounded p-2" required>
    </div>
    <div>
      <label>Alamat</label>
      <textarea name="address" class="w-full border rounded p-2"><?= esc($store['address']) ?></textarea>
    </div>
    <div>
      <label>Telepon</label>
      <input type="text" name="phone" value="<?= esc($store['phone']) ?>" class="w-full border rounded p-2">
    </div>
    <div>
      <label>Jam Buka</label>
      <input type="text" name="open_hours" value="<?= esc($store['open_hours']) ?>" class="w-full border rounded p-2">
    </div>
    <div>
      <label>Google Maps Embed</label>
      <textarea name="map_embed" class="w-full border rounded p-2"><?= esc($store['map_embed']) ?></textarea>
    </div>

    <div>
      <label>Tambah Gambar Baru</label>
      <input type="file" name="images[]" multiple class="w-full border rounded p-2">
    </div>

    <div class="grid grid-cols-3 gap-3 mt-4">
      <?php foreach($images as $img): ?>
        <img src="/assets/SGV/stores/<?= esc($img['image']) ?>" class="w-full h-32 object-cover rounded">
      <?php endforeach; ?>
    </div>

    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
  </form>
</div>

<?= view('adminpartial/footer') ?>
