<?= view('adminpartial/header') ?>

<div class="container mx-auto px-6 py-6">
  <h1 class="text-2xl font-bold mb-4">Add Store</h1>

  <form action="<?= base_url('admin/page/findus/store') ?>" method="post" enctype="multipart/form-data" class="space-y-4">
    <input type="text" name="title" placeholder="Title" class="w-full border p-2 rounded" required>
    <input type="text" name="address" placeholder="address" class="w-full border p-2 rounded">
    <select name="status" class="w-full border p-2 rounded">
      <option value="1">Active</option>
      <option value="0">Inactive</option>
    </select>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
  </form>
</div>

<?= view('adminpartial/footer') ?>
