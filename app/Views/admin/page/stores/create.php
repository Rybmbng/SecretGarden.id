<?= view('adminpartial/header') ?>

<div class="max-w-3xl mx-auto py-10">
  <h1 class="text-2xl font-bold mb-6">Create Store</h1>

  <form action="/admin/page/stores/store" method="post" enctype="multipart/form-data" class="space-y-4">
    <?= csrf_field() ?>
    <div>
      <label>Store Name</label>
      <input type="text" name="name" class="w-full border rounded p-2" required>
    </div>
    <div>
      <label>Address</label>
      <textarea name="address" class="w-full border rounded p-2"></textarea>
    </div>
    <div>
      <label>Telephone</label>
      <input type="text" name="phone" class="w-full border rounded p-2">
    </div>
    <div>
      <label>Open Hour</label>
      <input type="text" name="open_hours" class="w-full border rounded p-2">
    </div>
    <div>
      <label>Google Maps Embed</label>
      <textarea name="map_embed" class="w-full border rounded p-2"></textarea>
    </div>
    <div>
      <label>Image</label>
      <input type="file" name="images[]" multiple class="w-full border rounded p-2">
    </div>
    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Save</button>
  </form>
</div>

<?= view('adminpartial/footer') ?>
