<?= view("adminpartial/header")?>

<div class="container mx-auto px-6 py-6">
  <!-- Title -->
  <h1 class="text-3xl font-bold mb-6 text-gray-800">Menu Management</h1>

  <!-- Add Menu Form -->
  <div class="bg-white shadow-md rounded-2xl p-6 mb-8">
    <h2 class="text-xl font-semibold mb-4 text-gray-700">Add New Menu</h2>
    <form action="<?= base_url('admin/menu/create') ?>" method="post" class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <input type="text" name="name" placeholder="Menu Name" class="p-3 border rounded-lg focus:ring focus:ring-blue-200" required>
      <input type="text" name="url" placeholder="URL" class="p-3 border rounded-lg focus:ring focus:ring-blue-200" required>
      <input type="text" name="icon" placeholder="Icon (ex: fas fa-home)" class="p-3 border rounded-lg focus:ring focus:ring-blue-200">
      
      <!-- Dropdown Parent ID -->
      <div class="md:col-span-2">
        <label class="block mb-2 font-medium text-gray-600">Parent Menu</label>
        <select name="parent_id" class="w-full p-3 border rounded-lg focus:ring focus:ring-blue-200">
          <option value="">-- No Parent (Main Menu) --</option>
          <?php foreach ($menus as $pm): ?>
            <option value="<?= $pm['id'] ?>"><?= $pm['name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="flex items-center">
        <input type="checkbox" name="is_active" checked class="mr-2">
        <span class="text-gray-700">Active</span>
      </div>

      <div class="md:col-span-2">
        <button class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
          + Add Menu
        </button>
      </div>
    </form>
  </div>

  <!-- Menu List -->
  <div class="bg-white shadow-md rounded-2xl p-6 mb-8">
    <h2 class="text-xl font-semibold mb-4 text-gray-700">Menu List</h2>
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-gray-100 text-gray-700">
            <th class="p-3">ID</th>
            <th class="p-3">Name</th>
            <th class="p-3">URL</th>
            <th class="p-3">Icon</th>
            <th class="p-3">Parent</th>
            <th class="p-3">Active</th>
            <th class="p-3">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($menus as $m): ?>
          <tr class="border-t hover:bg-gray-50">
            <td class="p-3"><?= $m['id'] ?></td>
            <td class="p-3 font-medium"><?= $m['name'] ?></td>
            <td class="p-3 text-blue-600"><?= $m['url'] ?></td>
            <td class="p-3"><i class="<?= $m['icon'] ?> text-gray-600"></i></td>
            <td class="p-3">
              <?php 
                $parent = array_filter($menus, fn($x) => $x['id'] == $m['parent_id']);
                echo $m['parent_id'] ? reset($parent)['name'] : '-';
              ?>
            </td>
            <td class="p-3">
              <?php if ($m['is_active']): ?>
                <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Active</span>
              <?php else: ?>
                <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Inactive</span>
              <?php endif; ?>
            </td>
            <td class="p-3">
              <a href="<?= base_url('admin/menu/delete/'.$m['id']) ?>" 
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

  <!-- Role Access Form -->
  <div class="bg-white shadow-md rounded-2xl p-6">
    <h2 class="text-xl font-semibold mb-4 text-gray-700">Set Role Access</h2>
    <form action="<?= base_url('admin/menu/setRoleAccess') ?>" method="post">
      <div class="mb-4">
        <label class="block mb-2 font-medium text-gray-600">Select Role</label>
        <select name="role_id" class="w-full p-3 border rounded-lg focus:ring focus:ring-blue-200">
          <?php foreach ($roles as $r): ?>
            <option value="<?= $r['id'] ?>"><?= $r['role_name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <label class="block mb-2 font-medium text-gray-600">Select Menus</label>
      <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-3 border rounded-lg bg-gray-50 max-h-60 overflow-y-auto">
        <?php foreach ($menus as $m): ?>
          <label class="flex items-center space-x-2 bg-white shadow-sm rounded-lg px-3 py-2 hover:bg-gray-100">
            <input type="checkbox" name="menu_ids[]" value="<?= $m['id'] ?>" class="w-4 h-4 text-blue-600">
            <span class="text-gray-700">
              <?= $m['name'] ?> 
              <?php if ($m['parent_id']): ?> 
                <small class="text-gray-400">(Child)</small> 
              <?php endif; ?>
            </span>
          </label>
        <?php endforeach; ?>
      </div>

      <button class="mt-6 w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition">
        ✅ Save Access
      </button>
    </form>
  </div>
</div>

<?= view("adminpartial/footer")?>
