<?= view('adminpartial/header') ?>

<div class="container mx-auto px-6 py-6">
  <h1 class="text-3xl font-bold mb-6">Home Management</h1>

  <a href="<?= base_url('admin/page/home/slider/create') ?>" class="bg-blue-600 text-white px-4 py-2 rounded">+ Add Slider</a>
  <h1 class="text-3xl font-bold mb-6">Slider</h1>
  <table class="w-full mt-6 border">
    <thead>
      <tr class="bg-gray-200">
        <th class="p-2 border">#</th>
        <th class="p-2 border">Name</th>
        <th class="p-2 border">Type</th>
        <th class="p-2 border">Path</th>
        <th class="p-2 border">Status</th>
        <th class="p-2 border">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php $no=1; foreach ($slider as $b): ?>
        <tr>
          <td class="p-2 border"><?= $no++; ?></td>
          <td class="p-2 border"><?= esc($b['alt']) ?></td>
          <td class="p-2 border"><?= esc($b['type']) ?></td>
          <td class="p-2 border"><?= esc($b['src']) ?></td>
          <td class="p-2 border"> <?= $b['status'] ? '<h1 class="font-bold ">Active</h1>' : '<h1 class="font-bold text-red-600">inActive</h1>' ?></td>
          <td class="p-2 border">
            <a href="<?= base_url('admin/page/home/slider/edit/'.$b['id']) ?>" class="text-blue-600">Edit</a> |
            <a href="<?= base_url('admin/page/home/slider/delete/'.$b['id']) ?>" onclick="return confirm('Delete this slider?')" class="text-red-600">Delete</a>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>

<?= view('adminpartial/footer') ?>
