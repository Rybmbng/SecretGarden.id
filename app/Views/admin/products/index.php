<?= view('adminpartial/header'); ?>

<div class="max-w-7xl mx-auto py-10 px-4">
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">List Products</h1>
    <a href="<?= base_url('/admin/products/create') ?>" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">+ Add New Product</a>
  </div>

  <div class="overflow-x-auto bg-white rounded shadow">
    <table class="min-w-full table-auto border border-gray-200">
      <thead class="bg-gray-100 text-gray-700 text-left">
        <tr>
          <th class="p-4">Image</th>
          <th class="p-4">Name</th>
          <th class="p-4">Categories</th>
          <th class="p-4">Slug</th>
          <th class="p-4 text-center">Act</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $product): ?>
          <tr class="border-t hover:bg-gray-50">
            <td class="p-4">
              <?php
                $categoryPath = $product['category_path'] ?? 'default';
                $variantSlug = isset($product['name']) ? url_title($product['name'], '-', true) : 'default-product';
                $imageFile = $product['image'] ?? 'default-product.jpg';
                $slug = str_replace('-', ' ', strtolower($variantSlug)); 
                $pretty = ucwords($slug);                            
                $final = str_replace(' ', '-', $pretty);  
                $imgPath = base_url('assets/SGV/Category/' .  $categoryPath . '/' . strtolower($final) . '/' . basename($imageFile));
              ?>
              <img src="<?= $imgPath ?>" alt="Thumbnail" class="w-16 h-16 object-cover rounded border">
            </td>
            <td class="p-4 font-semibold text-gray-800"><?= esc($product['name']) ?></td>
            <td class="p-4 text-gray-600"><?= esc($product['category_name']) ?></td>
            <td class="p-4 text-gray-500"><?= esc($product['slug']) ?></td>
            <td class="p-4 text-center">
              <div class="flex justify-center gap-2">
                <a href="<?= base_url('/admin/products/show/' . $product['id']) ?>" class="bg-sky-500 text-white px-3 py-1 rounded text-sm hover:bg-sky-600">Detail</a>
                <a href="<?= base_url('/admin/products/edit/' . $product['id']) ?>" class="bg-yellow-400 text-white px-3 py-1 rounded text-sm hover:bg-yellow-500">Edit</a>
                <form method="post" action="<?= base_url('/admin/products/delete/' . $product['id']) ?>" onsubmit="return confirm('Hapus produk ini?')">
                  <?= csrf_field() ?>
                  <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">Del</button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>

<?= view('adminpartial/footer'); ?>
