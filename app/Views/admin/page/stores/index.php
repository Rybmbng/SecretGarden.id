<?= view('adminpartial/header') ?>

<div class="max-w-full mx-auto py-10">
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">List Store</h1>
    <a href="/admin/page/stores/create" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Add Store</a>
  </div>

  <table class="w-full border">
    <thead class="bg-gray-100">
      <tr>
        <th class="p-3 text-left">Name</th>
        <th class="p-3 text-left">Address</th>
        <th class="p-3">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($stores as $store): ?>
      <tr class="border-t">
        <td class="p-3"><?= esc($store['name']) ?></td>
        <td class="p-3"><?= esc($store['address']) ?></td>
        <td class="p-3 text-center">
          <a href="/admin/page/stores/edit/<?= $store['id'] ?>" class="px-3 py-1 bg-yellow-500 text-white rounded">Edit</a>
          <a href="/admin/page/stores/delete/<?= $store['id'] ?>" onclick="return confirm('Yakin hapus?')" class="px-3 py-1 bg-red-600 text-white rounded">Hapus</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>


<?= view('adminpartial/footer') ?>
