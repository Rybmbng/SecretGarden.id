<?= view('adminpartial/header') ?>

<div class="container mx-auto px-6 py-6">
  <h1 class="text-2xl font-bold mb-4">Edit Store</h1>

  <form action="<?= base_url('admin/page/brand/update/'.$brand['id']) ?>" method="post" enctype="multipart/form-data" class="space-y-4">
    <input type="text" name="title" value="<?= esc($brand['title']) ?>" class="w-full border p-2 rounded" required>
    <input type="text" name="address" value="<?= esc($brand['address']) ?>" class="w-full border p-2 rounded" required>
    <select name="status" class="w-full border p-2 rounded">
      <option value="1" <?= $brand['status']=='active'?'selected':'' ?>>Active</option>
      <option value="0" <?= $brand['status']=='inactive'?'selected':'' ?>>Inactive</option>
    </select>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
  </form>
</div>

<?= view('adminpartial/footer') ?>
