<?= $this->include('partials/header') ?>

<section class="max-w-6xl mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold mb-6"><?= esc($category['name']) ?></h1>
    <p class="text-gray-600 mb-8"><?= esc($category['description']) ?></p>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <?php foreach ($category['products'] as $product): ?>
            <a href="<?= site_url('product/' . $product['slug']) ?>" class="bg-white shadow rounded overflow-hidden hover:shadow-lg transition">
                <img src="<?= base_url('assets/sgv/category/' . $category['name'] . '/' . $product['name'] . '/' . $product['img']) ?>" alt="<?= esc($product['name']) ?>" class="h-60 w-full object-cover">
                <div class="p-4 text-center">
                    <h3 class="text-lg font-semibold"><?= esc($product['name']) ?></h3>
                    <p class="text-primary font-bold">Rp <?= number_format($product['price']) ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<?= $this->include('partials/footer') ?>
