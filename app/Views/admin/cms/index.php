<?= view("adminpartial/header")?>

<div class="max-w-5xl mx-auto">
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">CMS Pages</h1>
    <a href="/admin/cms/create" class="px-4 py-2 bg-indigo-600 text-white rounded">+ New Page</a>
  </div>

  <?php if(session()->getFlashdata('success')): ?>
    <div class="mb-4 text-green-700 bg-green-100 p-3 rounded"><?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>

  <div class="bg-white shadow rounded overflow-hidden">
    <table class="min-w-full">
      <thead class="bg-gray-50 text-left">
        <tr>
          <th class="px-4 py-3">Title</th>
          <th class="px-4 py-3">Slug</th>
          <th class="px-4 py-3">Status</th>
          <th class="px-4 py-3">Updated</th>
          <th class="px-4 py-3">Action</th>
        </tr>
      </thead>
      <tbody class="divide-y">
        <?php foreach($pages as $p): ?>
        <tr>
          <td class="px-4 py-3"><?= esc($p['title']) ?></td>
          <td class="px-4 py-3"><?= esc($p['slug']) ?></td>
          <td class="px-4 py-3"><?= esc($p['status']) ?></td>
          <td class="px-4 py-3"><?= esc($p['updated_at']) ?></td>
          <td class="px-4 py-3">
            <a href="/admin/cms/edit/<?= $p['id'] ?>" class="text-indigo-600 mr-2">Edit</a>
            <a href="/admin/cms/delete/<?= $p['id'] ?>" class="text-red-600" onclick="return confirm('Delete this page?')">Delete</a>
            <a href="/page/<?= esc($p['slug']) ?>" class="text-green-600 ml-2" target="_blank">View</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?= view("adminpartial/footer")?>