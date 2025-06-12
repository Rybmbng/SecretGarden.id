<?php view('partials/header') ?>

<section class="max-w-6xl mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold mb-6"><?= esc($title ?? 'Hasil Pencarian') ?></h1>
    <?php if (!empty($categories)): ?>
        <?php foreach ($categories as $category): ?>
            <div class="mb-8">
                <h2 class="text-2xl font-semibold mb-2"><?= esc($category['name']) ?></h2>
                <p class="mb-4"><?= esc($category['description']) ?></p>
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
                    <p>Tidak ada produk ditemukan dalam kategori ini.</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Tidak ada kategori ditemukan.</p>
    <?php endif; ?>
</section>

<a href="<?= site_url() ?>" class="inline-block mt-8 text-blue-600 hover:underline">&larr; Back to home</a>

<?= view('partials/footer') ?>