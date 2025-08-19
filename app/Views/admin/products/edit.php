<?= view('adminpartial/header'); ?>

<div class="w-full mx-auto py-12 px-6 bg-gray-50 min-h-screen rounded-2xl shadow-lg">

  <!-- Breadcrumb -->
  <h1 class="text-lg text-gray-500 mb-2">Products / <span class="font-bold text-gray-800">Product Details</span></h1>
  <h1 class="text-3xl font-bold text-gray-900 mb-8"><?= esc($product['name']) ?></h1>

  <form id="productForm" action="<?= base_url('admin/products/update/' . $product['id']) ?>" method="post" enctype="multipart/form-data" class="space-y-12">
    <?= csrf_field() ?>

    <!-- Product Information -->
    <section class="bg-white p-8 rounded-3xl shadow">
      <h2 class="text-lg font-semibold text-gray-800 mb-6 border-b pb-2">Product Information</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">

        <!-- Thumbnail -->
        <div class="flex flex-col items-center">
          <label class="text-sm font-semibold text-gray-700 mb-2">Thumbnail</label>
          <img 
            id="thumbnailPreview"
            src="<?= base_url('assets/SGV/Category/' . strtolower(str_replace(" ", "-",$product['category_path'])) . '/' . strtolower($product['slug']) . '/' . esc($product['main_images'])) ?>" 
            alt="Main Product Image"
            class="w-40 h-40 rounded-full object-cover shadow-md ring-1 ring-gray-300 mb-4"
          >
          <label for="main_images" class="cursor-pointer bg-gray-100 px-4 py-2 rounded-lg text-sm hover:bg-gray-200 transition">
            Change Thumbnail
          </label>
          <input type="file" id="main_images" name="main_images" accept="image/*" class="hidden" onchange="previewThumbnail(this)">
        </div>

        <!-- Info Form -->
        <div class="space-y-6">
          <div>
            <label class="block text-sm font-semibold mb-1">Name</label>
            <input type="text" name="name" value="<?= esc($product['name']) ?>" required
              class="w-full border border-gray-300 px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500">
          </div>
          <div>
            <label class="block text-sm font-semibold mb-1">Category</label>
            <select name="category_id" required
              class="w-full border border-gray-300 px-4 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500">
              <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= $product['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                  <?= esc($cat['name']) ?>
                </option>
              <?php endforeach ?>
            </select>
          </div>
          <div>
            <label class="block text-sm font-semibold mb-1">Description</label>
            <textarea name="description" rows="4"
              class="w-full border border-gray-300 px-4 py-3 rounded-xl resize-y focus:outline-none focus:ring-2 focus:ring-amber-500"><?= esc($product['description']) ?></textarea>
          </div>
        </div>
      </div>
    </section>

    <!-- Variants -->
    <section class="bg-white p-8 rounded-3xl shadow">
      <h2 class="text-lg font-semibold text-gray-800 mb-6 border-b pb-2 flex justify-between items-center">
        Variants
        <button type="button" id="addVariantBtn" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-sm">+ Add Variant</button>
      </h2>
      <div id="variantsContainer" class="space-y-4">
        <?php foreach ($variants as $v): ?>
        <div class="variant-item bg-gray-50 p-4 rounded-xl shadow relative" data-id="<?= $v['id'] ?>">
          <button type="button" class="delete-variant absolute top-2 right-2 bg-red-500 text-white w-6 h-6 rounded-full text-xs flex items-center justify-center hover:bg-red-600">&times;</button>
          <div class="grid md:grid-cols-2 gap-4">
            <div>
              <label class="block font-semibold text-sm mb-1">Name</label>
              <input type="text" name="variant_name[<?= $v['id'] ?>]" value="<?= esc($v['name']) ?>" class="w-full border px-3 py-2 rounded-lg">
            </div>
            <div>
              <label class="block font-semibold text-sm mb-1">Price</label>
              <input type="number" name="variant_price[<?= $v['id'] ?>]" value="<?= esc($v['price']) ?>" class="w-full border px-3 py-2 rounded-lg">
            </div>
            <div>
              <label class="block font-semibold text-sm mb-1">Stock</label>
              <input type="number" name="variant_stock[<?= $v['id'] ?>]" value="<?= esc($v['stock']) ?>" class="w-full border px-3 py-2 rounded-lg">
            </div>
            <div>
              <label class="block font-semibold text-sm mb-1">SKU</label>
              <input type="text" name="variant_sku[<?= $v['id'] ?>]" value="<?= esc($v['sku']) ?>" class="w-full border px-3 py-2 rounded-lg">
            </div>
            <div class="md:col-span-2">
              <label class="block font-semibold text-sm mb-1">Description</label>
              <textarea name="variant_desc[<?= $v['id'] ?>]" rows="2" class="w-full border px-3 py-2 rounded-lg"><?= esc($v['desc']) ?></textarea>
            </div>
            <div class="md:col-span-2">
              <label class="block font-semibold text-sm mb-1">Images</label>
              <input type="file" name="variant_images_<?= $v['id'] ?>[]" multiple accept="image/*" class="w-full border px-3 py-2 rounded-lg mb-2">
              <div class="flex gap-2 flex-wrap">
                <?php foreach ($v['images'] as $img): ?>
                  <div class="relative variant-image-item" data-id="<?= $img['id'] ?>">
                    <img src="<?= base_url('assets/SGV/Category/' . strtolower($product['category_path']) . '/' . strtolower($product['slug']) . '/' . strtolower($v['name']) . '/' . $img['image_path']) ?>" class="w-24 h-24 object-cover rounded shadow">
                    <button type="button" class="delete-variant-image absolute -top-1 -right-1 bg-red-500 text-white w-5 h-5 rounded-full text-xs flex items-center justify-center" data-image-id="<?= $img['id'] ?>">&times;</button>
                  </div>
                <?php endforeach ?>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach ?>
      </div>
    </section>

    <!-- Sections -->
    <section class="bg-white p-8 rounded-3xl shadow">
      <h2 class="text-lg font-semibold text-gray-800 mb-6 border-b pb-2 flex justify-between items-center">
        Sections
        <button type="button" id="addSectionBtn" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-sm">+ Add Section</button>
      </h2>
      <div id="sectionsContainer" class="space-y-4">
        <?php foreach ($sections as $sec): ?>
        <div class="section-item bg-gray-50 p-4 rounded-xl shadow relative">
          <button type="button" class="delete-section absolute top-2 right-2 bg-red-500 text-white w-6 h-6 rounded-full text-xs flex items-center justify-center hover:bg-red-600">&times;</button>
          <div class="grid md:grid-cols-2 gap-4">
            <div>
              <label class="block font-semibold text-sm mb-1">Title</label>
              <input type="text" name="section_header[]" value="<?= esc($sec['header']) ?>" class="w-full border px-3 py-2 rounded-lg">
            </div>
            <div>
              <label class="block font-semibold text-sm mb-1">Detail</label>
              <textarea name="section_detail[]" rows="2" class="w-full border px-3 py-2 rounded-lg"><?= esc($sec['detail']) ?></textarea>
            </div>
          </div>
        </div>
        <?php endforeach ?>
      </div>
    </section>

    <!-- Submit -->
    <div class="text-right">
      <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white px-10 py-3 rounded-2xl font-semibold shadow-md transition transform hover:scale-105">
        Save Changes
      </button>
    </div>
  </form>
</div>

<script>
  function previewThumbnail(input) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = e => document.getElementById('thumbnailPreview').src = e.target.result;
      reader.readAsDataURL(input.files[0]);
    }
  }

  // Add Variant
  document.getElementById('addVariantBtn').addEventListener('click', () => {
    const newId = 'new_' + Date.now();
    const html = `
      <div class="variant-item bg-gray-50 p-4 rounded-xl shadow relative" data-id="${newId}">
        <button type="button" class="delete-variant absolute top-2 right-2 bg-red-500 text-white w-6 h-6 rounded-full text-xs flex items-center justify-center hover:bg-red-600">&times;</button>
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block font-semibold text-sm mb-1">Name</label>
            <input type="text" name="variant_name[${newId}]" class="w-full border px-3 py-2 rounded-lg">
          </div>
          <div>
            <label class="block font-semibold text-sm mb-1">Price</label>
            <input type="number" name="variant_price[${newId}]" class="w-full border px-3 py-2 rounded-lg">
          </div>
          <div>
            <label class="block font-semibold text-sm mb-1">Stock</label>
            <input type="number" name="variant_stock[${newId}]" class="w-full border px-3 py-2 rounded-lg">
          </div>
          <div>
            <label class="block font-semibold text-sm mb-1">SKU</label>
            <input type="text" name="variant_sku[${newId}]" class="w-full border px-3 py-2 rounded-lg">
          </div>
          <div class="md:col-span-2">
            <label class="block font-semibold text-sm mb-1">Description</label>
            <textarea name="variant_desc[${newId}]" rows="2" class="w-full border px-3 py-2 rounded-lg"></textarea>
          </div>
          <div class="md:col-span-2">
            <label class="block font-semibold text-sm mb-1">Images</label>
            <input type="file" name="variant_images_${newId}[]" multiple accept="image/*" class="w-full border px-3 py-2 rounded-lg mb-2">
            <div class="flex gap-2 flex-wrap"></div>
          </div>
        </div>
      </div>
    `;
    document.getElementById('variantsContainer').insertAdjacentHTML('beforeend', html);
  });

  // Add Section
  document.getElementById('addSectionBtn').addEventListener('click', () => {
    const html = `
      <div class="section-item bg-gray-50 p-4 rounded-xl shadow relative">
        <button type="button" class="delete-section absolute top-2 right-2 bg-red-500 text-white w-6 h-6 rounded-full text-xs flex items-center justify-center hover:bg-red-600">&times;</button>
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block font-semibold text-sm mb-1">Title</label>
            <input type="text" name="section_header[]" class="w-full border px-3 py-2 rounded-lg">
          </div>
          <div>
            <label class="block font-semibold text-sm mb-1">Detail</label>
            <textarea name="section_detail[]" rows="2" class="w-full border px-3 py-2 rounded-lg"></textarea>
          </div>
        </div>
      </div>
    `;
    document.getElementById('sectionsContainer').insertAdjacentHTML('beforeend', html);
  });

document.addEventListener('click', e => {
    if(e.target.classList.contains('delete-variant')){
        const variantId = e.target.closest('.variant-item').dataset.id;

        if(variantId.startsWith('new_')){
            e.target.closest('.variant-item').remove();
            return;
        }

        if(confirm('Delete this variant and all its images?')){
            fetch('<?= base_url("admin/products/delete-variant") ?>/' + variantId, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With':'XMLHttpRequest',
                    'X-CSRF-TOKEN':'<?= csrf_hash() ?>'
                }
            })
            .then(res=>res.json())
            .then(res=>{
                if(res.success) e.target.closest('.variant-item').remove();
                else alert(res.message);
            });
        }
    }

    // Hapus section
    if(e.target.classList.contains('delete-section')){
        e.target.closest('.section-item').remove();
    }

    // Hapus image
    if(e.target.classList.contains('delete-variant-image')){
        const imageId = e.target.dataset.imageId;
        if(confirm('Delete this image?')){
            fetch('<?= base_url("admin/products/delete-variant-image") ?>/' + imageId, {
                method:'DELETE',
                headers:{
                    'X-Requested-With':'XMLHttpRequest',
                    'X-CSRF-TOKEN':'<?= csrf_hash() ?>'
                }
            })
            .then(res=>res.json())
            .then(res=>{
                if(res.success) e.target.closest('.variant-image-item').remove();
                else alert(res.message);
            });
        }
    }
});

</script>

<?= view('adminpartial/footer'); ?>
