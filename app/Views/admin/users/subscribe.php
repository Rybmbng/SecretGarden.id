<?= view("adminpartial/header")?>

<div class="container mx-auto px-6 py-6">
  <h1 class="text-3xl font-bold mb-6 text-gray-800">Subscribe</h1>

  <!-- User List -->
  <div class="bg-white shadow-md rounded-2xl p-6">
    <h2 class="text-xl font-semibold mb-4 text-gray-700">Subscribe List</h2>
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-gray-100 text-gray-700">
            <th class="p-3">ID</th>
            <th class="p-3">Username</th>
            <th class="p-3">Email</th>
            <th class="p-3">Status</th>
            <th class="p-3">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($subscribe as $u): ?>
          <tr class="border-t hover:bg-gray-50">
            <td class="p-3"><?= $u['id'] ?></td>
            <td class="p-3 font-medium"><?= $u['username'] ?></td>
            <td class="p-3"><?= $u['email'] ?></td>
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
