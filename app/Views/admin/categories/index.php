<?= view('adminpartial/header') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (session()->getFlashdata('success')): ?>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '<?= session()->getFlashdata('success') ?>',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
    });
  </script>
<?php endif; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Category List</h2>
    <a href="<?= site_url('admin/categories/create') ?>" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-semibold shadow hover:bg-blue-700 transition">
      + Add Category
    </a>
  </div>

  <?php if (!empty($categories)): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <?php foreach ($categories as $category): ?>
        <div class="bg-white border border-gray-200 rounded-xl shadow hover:shadow-md transition group overflow-hidden">
          <div class="relative h-40 bg-gray-100">
            <?php if (!empty($category['img'])): ?>
              <img src="<?= base_url('assets/SGV/Category/' . $category['path'] . '/' . str_replace(" ", "-", $category['img'])) ?>"
                   alt="<?= esc($category['name']) ?>"
                   class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            <?php else: ?>
              <div class="w-full h-full flex items-center justify-center text-gray-400 italic text-sm">
                No Image
              </div>
            <?php endif; ?>
          </div>

          <div class="p-4">
            <h3 class="text-lg font-semibold text-gray-800 truncate"><?= esc($category['name']) ?></h3>
            <div class="mt-2">
              <?php if ($category['status'] == 1): ?>
                <span class="inline-block bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Active</span>
              <?php else: ?>
                <span class="inline-block bg-gray-200 text-gray-600 text-xs px-2 py-1 rounded-full">Inactive</span>
              <?php endif; ?>
            </div>

            <div class="mt-4 flex justify-between items-center">
              <a href="<?= site_url('admin/categories/edit/' . $category['id']) ?>"
                 class="text-yellow-600 hover:underline text-sm font-medium">Edit</a>
              <a href="javascript:void(0);"
                 onclick="confirmDelete(<?= $category['id'] ?>)"
                 class="text-red-600 hover:underline text-sm font-medium">Delete</a>

            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="text-center text-gray-400 italic py-10">
      No categories found.
    </div>
  <?php endif; ?>
</div>

<script>
  function confirmDelete(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "This action cannot be undone!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = '<?= site_url('admin/categories/delete/') ?>' + id;
      }
    });
  }
</script>

<?= view('adminpartial/footer') ?>
