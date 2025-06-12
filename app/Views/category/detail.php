<?php view('partials/header') ?>

<?php if (isset($category) && $category): ?>
    <section class="max-w-6xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold mb-6"><?= esc($category['name']) ?></h1>
        <p class="mb-6"><?= esc($category['description']) ?></p>

        <?php if (!empty($category['products'])): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <?php foreach ($category['products'] as $product): ?>
                    <a href="<?= site_url('product/' . strtolower(str_replace(' ', '-', $product['slug'] ?? $product['name']))) ?>" class="bg-white shadow rounded overflow-hidden hover:shadow-lg transition">
                        <img src="<?= base_url('assets/sgv/' . $product['img']) ?>" alt="<?= esc($product['name']) ?>" class="h-60 w-full object-cover">
                        <div class="p-4 text-center">
                            <h3 class="text-lg font-semibold"><?= esc($product['name']) ?></h3>
                            <p class="text-primary font-bold mt-2"><?= esc($product['price']) ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Tidak ada produk dalam kategori ini.</p>
        <?php endif; ?>
    </section>
<?php else: ?>
    <div class="max-w-2xl mx-auto py-12">
        <p class="text-center text-red-600">Kategori tidak ditemukan.</p>
    </div>
<?php endif; ?>

<a href="<?= site_url() ?>" class="inline-block mt-8 text-blue-600 hover:underline">&larr; Back to home</a>

<?= view('partials/footer') ?>
