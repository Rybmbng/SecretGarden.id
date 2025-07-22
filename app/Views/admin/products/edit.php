<?= view('adminpartial/header'); ?>

<div class="max-w-4xl mx-auto py-12 px-4">
  <h1 class="text-3xl font-extrabold mb-8 text-rang-900 text-center"><?= esc($product['name'])?></h1>

  <form action="<?= base_url('admin/products/update/' . $product['id']) ?>" method="post" enctype="multipart/form-data" class="space-y-8">
    <?= csrf_field() ?>

    <!-- Product Info -->
    <div class="bg-white p-8 rounded-xl shadow-lg">
      <h2 class="text-xl font-semibold text-blue-700 mb-4">Product Information</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm text-gray-400 font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Name</label>
        <input type="text" name="name" value="<?= esc($product['name']) ?>" required class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
      </div>

      <div>
        <label class="block text-sm text-gray-400 font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Category</label>
        <select name="category_id" required class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
          <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= $product['category_id'] == $cat['id'] ? 'selected' : '' ?>>
              <?= esc($cat['name']) ?>
            </option>
          <?php endforeach ?>
        </select>
      </div>

      <div>
        <label class="block text-sm text-gray-400 font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Description</label>
        <textarea name="description" rows="3" class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"><?= esc($product['description']) ?></textarea>
      </div>           
       <div class="grid grid-cols-1 gap-1">
                <label class="block text-sm text-gray-400 font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Main Image</label>
                <input id="picture" type="file" class="block flex h-10 w-full rounded-md border border-input bg-white px-3 py-2 text-sm text-gray-400 file:border-0 file:bg-transparent file:text-gray-600 file:text-sm file:font-medium">
        <img src="<?= base_url('assets/SGV/Category/' . strtolower($product['category_path']) . '/' . strtolower($product['slug']) . '/' . esc($imageMain[0]['image_path'])) ?>" class="w-full h-32 object-cover border rounded-lg shadow">
      </div>
      </div>
    </div>

    <!-- Variants -->
    <div class="space-y-8">
      <?php foreach ($variants as $v): ?>
      <div class="bg-white p-8 rounded-xl shadow-lg">
        <h2 class="text-lg font-semibold text-blue-700 mb-4"><?= esc($v['name']) ?></h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-gray-700 font-medium mb-1">Price</label>
            <input type="number" step="0.01" name="variant_price[]" value="<?= esc($v['price']) ?>" required class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">

            <label class="block text-gray-700 font-medium mb-1 mt-4">SKU</label>
            <input type="text" name="variant_sku[]" value="<?= esc($v['sku']) ?>" required class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">

            <label class="block text-gray-700 font-medium mb-1 mt-4">Stock</label>
            <input type="number" name="variant_stock[]" value="<?= esc($v['stock']) ?>" required class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">

            <label class="block text-gray-700 font-medium mb-1 mt-4">Description</label>
            <textarea name="variant_desc[]" rows="2" class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"><?= esc($v['desc']) ?></textarea>
          </div>
          <div>
            <p class="text-gray-700 font-medium mb-2">Images:</p>
            <div class="grid grid-cols-2 gap-2">
              <?php foreach ($v['images'] as $img): ?>
              <?php
                $variantFolder = str_replace(' ', '-', strtolower($v['name']));
              ?>
              <img src="<?= base_url('assets/SGV/Category/' . strtolower($product['category_path']) . '/' . strtolower($product['slug']) . '/' . $variantFolder . '/' . $img['image_path']) ?>" class="w-full h-32 object-cover border rounded-lg shadow">
              <?php endforeach ?>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach ?>
    </div>

    <!-- Sections -->
    <div class="space-y-8">
      <?php foreach ($sections as $i => $sec): ?>
      <div class="bg-white p-8 rounded-xl shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="block text-gray-700 font-medium mb-1">Type</label>
            <select name="section_type[]" class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
              <option value="story" <?= $sec['type'] == 'story' ? 'selected' : '' ?>>Story</option>
              <option value="directions" <?= $sec['type'] == 'directions' ? 'selected' : '' ?>>Directions</option>
              <option value="characteristics" <?= $sec['type'] == 'characteristics' ? 'selected' : '' ?>>Characteristics</option>
              <option value="ingredients" <?= $sec['type'] == 'ingredients' ? 'selected' : '' ?>>Ingredients</option>
            </select>
          </div>
          <div>
            <label class="block text-gray-700 font-medium mb-1">Header</label>
            <input type="text" name="section_header[]" value="<?= esc($sec['header']) ?>" class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
          </div>
          <div>
            <label class="block text-gray-700 font-medium mb-1">Detail</label>
            <textarea name="section_detail[]" rows="3" class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none"><?= esc($sec['detail']) ?></textarea>
          </div>
        </div>
      </div>
      <?php endforeach ?>
    </div>

    <div class="mt-8 text-right">
      <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold shadow transition">Save Changes</button>
    </div>
  </form>
</div>

<?= view('adminpartial/footer'); ?>
