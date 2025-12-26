<?= view('adminpartial/header'); ?>

<div class="w-full mx-auto py-10 px-6" x-data="{ openModal: false, editData: {} }">
  <h1 class="text-3xl font-bold mb-8 text-gray-800">Footer Links</h1>

  <?php if(session()->getFlashdata('success')): ?>
    <div class="p-4 mb-4 text-green-700 bg-green-100 rounded-lg">
      <?= session()->getFlashdata('success') ?>
    </div>
  <?php endif; ?>

  <div class="mb-6 flex justify-end">
    <button @click="openModal = true; editData = {}"
      class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">
      ➕ Add Link
    </button>
  </div>

  <div class="overflow-x-auto bg-white shadow-md rounded-2xl">
    <table class="w-full text-left border-collapse">
      <thead>
        <tr class="bg-gray-100 text-gray-700">
          <th class="p-3">#</th>
          <th class="p-3">Title</th>
          <th class="p-3">URL</th>
          <th class="p-3">Position</th>
          <th class="p-3">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($links as $i => $link): ?>
          <tr class="border-t">
            <td class="p-3"><?= $i+1 ?></td>
            <td class="p-3"><?= esc($link['title']) ?></td>
            <td class="p-3 text-blue-600"><a href="<?= esc($link['url']) ?>" target="_blank"><?= esc($link['url']) ?></a></td>
            <td class="p-3"><?= esc($link['position']) ?></td>
            <td class="p-3">
              <button @click="openModal = true; editData = <?= htmlspecialchars(json_encode($link)) ?>"
                class="px-3 py-1 bg-yellow-500 text-white rounded-lg">✏️ Edit</button>
              <a href="<?= base_url('admin/setting/footer/delete/'.$link['id']) ?>" 
                 onclick="return confirm('Delete this link?')" 
                 class="px-3 py-1 bg-red-600 text-white rounded-lg ml-2">🗑️ Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Modal -->
  <div x-show="openModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-lg p-6 w-full max-w-lg relative">
      <h2 class="text-xl font-semibold mb-4" x-text="editData.id ? 'Edit Link' : 'Add Link'"></h2>
      <form :action="editData.id ? '<?= base_url('admin/setting/footer/update/') ?>' + editData.id : '<?= base_url('admin/setting/footer/create') ?>'" method="post">
        <div class="mb-4">
          <label class="block text-gray-700 font-semibold mb-2">Title</label>
          <input type="text" name="title" class="w-full border rounded-lg p-3"
                 :value="editData.title ?? ''">
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 font-semibold mb-2">URL</label>
          <input type="text" name="url" class="w-full border rounded-lg p-3"
                 :value="editData.url ?? ''">
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 font-semibold mb-2">Position</label>
          <input type="number" name="position" class="w-full border rounded-lg p-3"
                 :value="editData.position ?? 0">
        </div>

        <div class="flex justify-end space-x-3">
          <button type="button" @click="openModal = false"
            class="px-4 py-2 bg-gray-500 text-white rounded-lg">Cancel</button>
          <button type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg">💾 Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?=view("adminpartial/footer")?>