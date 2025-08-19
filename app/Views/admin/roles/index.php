<?= view("adminpartial/header")?>

<div class="container mx-auto px-6 py-6">
  <h1 class="text-3xl font-bold mb-6 text-gray-800">Role Management</h1>

  <!-- Add Role Form -->
  <div class="bg-white shadow-md rounded-2xl p-6 mb-8">
    <h2 class="text-xl font-semibold mb-4 text-gray-700">Add New Role</h2>
    <form action="<?= base_url('admin/roles/create') ?>" method="post" class="flex gap-4">
      <input type="number" name="id" placeholder="ID" 
             class="flex-1 p-3 border rounded-lg focus:ring focus:ring-blue-200" required>
      <input type="text" name="role_names" placeholder="Role Name" 
            class="flex-1 p-3 border rounded-lg focus:ring focus:ring-blue-200" required>
      <button class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
        + Add Role
      </button>
    </form>
  </div>

  <!-- Role List -->
  <div class="bg-white shadow-md rounded-2xl p-6">
    <h2 class="text-xl font-semibold mb-4 text-gray-700">Role List</h2>
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-gray-100 text-gray-700">
            <th class="p-3">ID</th>
            <th class="p-3">Role Name</th>
            <th class="p-3">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($roles as $r): ?>
          <tr class="border-t hover:bg-gray-50">
            <td class="p-3"><?= $r['id'] ?></td>
            <td class="p-3 font-medium"><?= $r['role_name'] ?></td>
            <td class="p-3">
              <a href="<?= base_url('admin/roles/delete/'.$r['id']) ?>" 
                 class="text-red-600 hover:text-red-800 font-semibold">
                Delete
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?= view("adminpartial/footer")?>
