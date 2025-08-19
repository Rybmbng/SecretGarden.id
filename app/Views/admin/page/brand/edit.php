<?= view('adminpartial/header') ?>

<div class="container mx-auto px-6 py-6">
  <h1 class="text-2xl font-bold mb-4">Edit Brand</h1>

  <form action="<?= base_url('admin/page/brand/update/'.$brand['id']) ?>" method="post" enctype="multipart/form-data" class="space-y-4">
    <input type="text" name="title" value="<?= esc($brand['title']) ?>" class="w-full border p-2 rounded" required>
    <textarea name="content" class="w-full border p-2 rounded"><?= esc($brand['content']) ?></textarea>

    <div>
      <?php if ($brand['img_path']): ?>
        <img src="<?= base_url($brand['img_path']) ?>" class="h-16 mb-2">
      <?php endif ?>
      <input type="file" name="img_path" class="w-full border p-2 rounded">
    </div>

    <select name="position" class="w-full border p-2 rounded">
      <option value="left" <?= $brand['position']=='left'?'selected':'' ?>>Left</option>
      <option value="right" <?= $brand['position']=='right'?'selected':'' ?>>Right</option>
    </select>

    <input type="number" name="year" value="<?= esc($brand['year']) ?>" class="w-full border p-2 rounded">

    <select name="status" class="w-full border p-2 rounded">
      <option value="1" <?= $brand['status']=='active'?'selected':'' ?>>Active</option>
      <option value="0" <?= $brand['status']=='inactive'?'selected':'' ?>>Inactive</option>
    </select>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
  </form>
</div>

<?= view('adminpartial/footer') ?>

