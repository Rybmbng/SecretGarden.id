<?= view('adminpartial/header') ?>

<div class="max-w-2xl mx-auto py-10 px-6">
  <div class="bg-white shadow-xl rounded-xl p-6 space-y-6 border border-gray-100">
    <h2 class="text-2xl font-bold text-gray-800">Add New Category</h2>

    <form action="<?= site_url('admin/categories/store') ?>" method="post" enctype="multipart/form-data" class="space-y-5">
      
      <!-- Name -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
        <input type="text" name="name" placeholder="e.g. Fragrance" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 px-4 py-2" required>
      </div>

      <!-- Slug -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Slug (URL Path)</label>
        <input type="text" name="path" readonly placeholder="auto-generated-slug" class="w-full bg-gray-100 border-gray-300 rounded-lg shadow-sm px-4 py-2 text-gray-600">
      </div> 
      
      <!-- Desc -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
        <textarea name="description" placeholder="Deskripsi" rows="3" class="w-full border px-3 py-2 rounded"></textarea>
      </div>

      <!-- Image Upload -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Image        
          <span title="Maksimal 2MB, format JPG/PNG, resolusi 1080x1080px" class="text-blue-500 cursor-pointer">ℹ️</span>
        </label>
        <input type="file" name="img" class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2">
        <!-- Optional preview -->
        <div id="previewContainer" class="mt-2 hidden">
          <img id="imgPreview" class="w-20 h-20 object-cover rounded-lg border border-gray-200 shadow" />
        </div>
      </div>

      <!-- Status -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
        <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2">
          <option value="1">Active</option>
          <option value="0">Inactive</option>
        </select>
      </div>

      <!-- Submit -->
      <div class="text-right">
        <button type="submit" class="inline-flex items-center px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          Save Category
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Slug & Image Preview Script -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const nameInput = document.querySelector('input[name="name"]');
    const pathInput = document.querySelector('input[name="path"]');
    const fileInput = document.querySelector('input[name="img"]');
    const previewContainer = document.getElementById('previewContainer');
    const imgPreview = document.getElementById('imgPreview');

    // Auto-slug
    nameInput.addEventListener('input', function () {
      let slug = nameInput.value
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');
      pathInput.value = slug;
    });

    // Image preview
    fileInput.addEventListener('change', function (e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          imgPreview.src = e.target.result;
          previewContainer.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
      }
    });
  });
</script>

<?= view('adminpartial/footer') ?>
