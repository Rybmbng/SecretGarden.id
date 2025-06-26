<?= view('adminpartial/header') ?>

<div class="max-w-2xl mx-auto py-10 px-6">
  <div class="bg-white shadow-xl rounded-xl p-6 space-y-6 border border-gray-100">
    <h2 class="text-2xl font-bold text-gray-800">Edit Category</h2>

    <form action="<?= site_url('admin/categories/update/' . $category['id']) ?>" method="post" enctype="multipart/form-data" class="space-y-5">
      <input type="hidden" name="old_img" value="<?= esc($category['img']) ?>">

      <!-- Name -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
        <input type="text" name="name" value="<?= esc($category['name']) ?>" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 px-4 py-2" required>
      </div>

      <!-- Slug / Path -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Slug (Path)</label>
        <input type="text" name="path" value="<?= esc($category['path']) ?>" class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2">
      </div>
      
      <!-- Desc -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
        <textarea name="description" placeholder="Deskripsi" rows="3" class="w-full border px-3 py-2 rounded"><?= esc($category['description']) ?></textarea>

      </div>

      <!-- Image Upload -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
        <input type="file" name="img" class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2">
        <?php if ($category['img']): ?>
          <div class="mt-3">
            <img src="<?= base_url('assets/SGV/Category/'.strtolower(str_replace(" ","-",$category['name'])). '/'. $category['img']) ?>" alt="Category Image" class="w-20 h-20 object-cover rounded-lg border border-gray-200 shadow">
          </div>
        <?php endif; ?>
      </div>

      <!-- Status -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
        <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2">
          <option value="1" <?= $category['status'] ? 'selected' : '' ?>>Active</option>
          <option value="0" <?= !$category['status'] ? 'selected' : '' ?>>Inactive</option>
        </select>
      </div>

      <!-- Submit -->
      <div class="text-right">
        <button type="submit" class="inline-flex items-center px-5 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-lg shadow transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          Update Category
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Slug Auto Update -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const nameInput = document.querySelector('input[name="name"]');
    const pathInput = document.querySelector('input[name="path"]');

    nameInput.addEventListener('input', function () {
      let slug = nameInput.value
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9\s-]/g, '') 
        .replace(/\s+/g, '-')        
        .replace(/-+/g, '-');        
      pathInput.value = slug;
    });
  });
</script>

<?= view('adminpartial/footer') ?>
