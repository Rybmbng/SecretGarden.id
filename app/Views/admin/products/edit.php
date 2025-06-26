<?= view('adminpartial/header'); ?>

<div class="max-w-4xl mx-auto py-10 px-4">
  <h1 class="text-2xl font-bold mb-6 text-gray-800">Edit Product</h1>

  <form action="<?= base_url('admin/products/update/' . $product['id']) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <!-- Product Info -->
    <div class="space-y-4 bg-white p-6 rounded shadow">
      <h2 class="text-lg font-semibold text-gray-700">Product Information</h2>

      <input type="text" name="name" value="<?= esc($product['name']) ?>" required class="w-full border px-3 py-2 rounded">

      <select name="category_id" required class="w-full border px-3 py-2 rounded">
        <?php foreach ($categories as $cat): ?>
          <option value="<?= $cat['id'] ?>" <?= $product['category_id'] == $cat['id'] ? 'selected' : '' ?>>
            <?= esc($cat['name']) ?>
          </option>
        <?php endforeach ?>
      </select>

      <textarea name="description" rows="3" class="w-full border px-3 py-2 rounded"><?= esc($product['description']) ?></textarea>
    </div>

    <div class="space-y-6 mt-6">
      <?php foreach ($variants as $v): ?>
      <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold text-gray-700">Variant: <?= esc($v['name']) ?></h2>
        <p>Price: <?= esc($v['price']) ?></p>
        <p>SKU: <?= esc($v['sku']) ?></p>
        <p>Stock: <?= esc($v['stock']) ?></p>
        <p>Description: <?= esc($v['desc']) ?></p>
        <p>Images:</p>
        <div class="grid grid-cols-2 gap-2">
            <?php foreach ($v['images'] as $img): ?>
            <?php
              $variantFolder = str_replace(' ', '-', strtolower($v['name']));
            ?>
            <img src="<?= base_url('assets/SGV/Category/' . strtolower($product['category_path']) . '/' . strtolower($product['slug']) . '/' . $variantFolder . '/' . $img['image_path']) ?>" class="w-full h-auto border rounded">
            <?php endforeach ?>
        </div>
      </div>
      <?php endforeach ?>
    </div>

    <!-- Sections -->
    <div class="space-y-6 mt-6">
      <?php foreach ($sections as $i => $sec): ?>
      <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold text-gray-700">Section <?= $i + 1 ?></h2>
        <select name="section_type[]" class="w-full border px-3 py-2 rounded">
          <option value="story" <?= $sec['type'] == 'story' ? 'selected' : '' ?>>Story</option>
          <option value="directions" <?= $sec['type'] == 'directions' ? 'selected' : '' ?>>Directions</option>
          <option value="characteristics" <?= $sec['type'] == 'characteristics' ? 'selected' : '' ?>>Characteristics</option>
          <option value="ingredients" <?= $sec['type'] == 'ingredients' ? 'selected' : '' ?>>Ingredients</option>
        </select>
        <input type="text" name="section_header[]" value="<?= esc($sec['header']) ?>" class="w-full border px-3 py-2 rounded">
        <textarea name="section_detail[]" rows="3" class="w-full border px-3 py-2 rounded"><?= esc($sec['detail']) ?></textarea>
      </div>
      <?php endforeach ?>
    </div>

    <div class="mt-6 text-right">
      <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">Save Changes</button>
    </div>
  </form>
</div>

<?= view('adminpartial/footer'); ?>
