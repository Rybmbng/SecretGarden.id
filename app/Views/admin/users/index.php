<?= view("adminpartial/header")?>

<div class="container mx-auto px-6 py-6">
  <h1 class="text-3xl font-bold mb-6 text-gray-800">User Management</h1>

  <!-- Add User Form -->
  <div class="bg-white shadow-md rounded-2xl p-6 mb-8">
    <h2 class="text-xl font-semibold mb-4 text-gray-700">Add New User</h2>
    <form action="<?= base_url('admin/users/create') ?>" method="post" class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <input type="text" name="username" placeholder="Username" class="p-3 border rounded-lg focus:ring focus:ring-blue-200" required>
      <input type="email" name="email" placeholder="Email" class="p-3 border rounded-lg focus:ring focus:ring-blue-200" required>
      <input type="password" name="password" placeholder="Password" class="p-3 border rounded-lg focus:ring focus:ring-blue-200" required>

      <select name="role_id" class="p-3 border rounded-lg focus:ring focus:ring-blue-200">
        <?php foreach ($roles as $r): ?>
          <option value="<?= $r['id'] ?>"><?= $r['role_name'] ?></option>
        <?php endforeach; ?>
      </select>

      <div class="flex items-center">
        <input type="checkbox" name="is_active" checked class="mr-2">
        <span class="text-gray-700">Active</span>
      </div>

      <div class="md:col-span-2">
        <button class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
          + Add User
        </button>
      </div>
    </form>
  </div>

  <!-- User List -->
  <div class="bg-white shadow-md rounded-2xl p-6">
    <h2 class="text-xl font-semibold mb-4 text-gray-700">User List</h2>
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-gray-100 text-gray-700">
            <th class="p-3">ID</th>
            <th class="p-3">Username</th>
            <th class="p-3">Email</th>
            <th class="p-3">Role</th>
            <th class="p-3">Status</th>
            <th class="p-3">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $u): ?>
          <tr class="border-t hover:bg-gray-50">
            <td class="p-3"><?= $u['id'] ?></td>
            <td class="p-3 font-medium"><?= $u['username'] ?></td>
            <td class="p-3"><?= $u['email'] ?></td>
            <td class="p-3">
              <?php 
                $role = array_filter($roles, fn($r) => $r['id'] == $u['role_id']);
                echo $role ? array_values($role)[0]['role_name'] : '—';
              ?>
            </td>
            <td class="p-3">
              <?php if ($u['is_active']): ?>
                <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Active</span>
              <?php else: ?>
                <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Inactive</span>
              <?php endif; ?>
            </td>
            <td class="p-3">
              <a href="<?= base_url('admin/users/delete/'.$u['id']) ?>" 
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
