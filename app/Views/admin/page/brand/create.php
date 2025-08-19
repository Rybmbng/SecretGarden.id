<?= view('adminpartial/header') ?>

<div class="container mx-auto px-6 py-6">
  <h1 class="text-2xl font-bold mb-4">Add Brand</h1>

  <form action="<?= base_url('admin/page/brand/store') ?>" method="post" enctype="multipart/form-data" class="space-y-4">
    <input type="text" name="title" placeholder="Title" class="w-full border p-2 rounded" required>
    <textarea name="content" placeholder="Content" class="w-full border p-2 rounded"></textarea>
    <input type="file" name="img_path" class="w-full border p-2 rounded">
    <select name="position" class="w-full border p-2 rounded">
      <option value="left" selected ?>>Left</option>
      <option value="right">Right</option>
    </select>

    <input type="number" name="year" placeholder="Year" class="w-full border p-2 rounded">
    <select name="status" class="w-full border p-2 rounded">
      <option value="1">Active</option>
      <option value="0">Inactive</option>
    </select>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
  </form>
</div>

<?= view('adminpartial/footer') ?>
