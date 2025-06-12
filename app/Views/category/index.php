<?= view('partials/header') ?>

<!-- Search Form -->
<form action="<?= site_url('category/search') ?>" method="get" class="mb-8 max-w-lg mx-auto flex">
    <input 
        type="text" 
        name="q" 
        class="flex-1 border border-gray-300 rounded-l px-4 py-2 focus:outline-none" 
        placeholder="Cari produk atau kategori..." 
        value="<?= esc($this->request->getGet('q') ?? '') ?>"
        required
    >
    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-r hover:bg-blue-700">Cari</button>
</form>
    <section class="py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-bold mb-6"><?= esc($category['name']) ?></h1>

            <?php if (count($products) === 0): ?>
                <p class="text-gray-500">Tidak ada produk dalam kategori ini.</p>
            <?php else: ?>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                    <?php foreach ($products as $product): ?>
                        <a href="<?= site_url('product/' . $product['slug']) ?>" class="border rounded-lg overflow-hidden hover:shadow-lg transition duration-200 bg-white">
                            <img src="<?= base_url('assets/sgv/category/' . $category['slug'] . '/' . $product['image']) ?>" alt="<?= esc($product['name']) ?>" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h2 class="font-semibold text-lg"><?= esc($product['name']) ?></h2>
                                <p class="text-sm text-gray-600 mt-1">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

<?= view('partials/footer') ?>