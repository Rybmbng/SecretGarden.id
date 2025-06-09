<?php echo view('partials/header'); ?>
<h1 class="text-3xl font-bold mb-6">Category: <?= esc($category['name']) ?></h1>
<p class="mb-6"><?= esc($category['description']) ?></p>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <?php foreach ($products as $product): ?>
        <div class="border rounded p-4">
            <a href="<?= site_url('product/' . strtolower(str_replace(' ', '-', $product['slug'] ?: $product['name']))) ?>">
                <img src="<?= base_url('assets/sgv/category/' . $category['name'] . '/' . $product['name'] . '/' . $product['img']) ?>" alt="<?= esc($product['name']) ?>" class="mb-2 rounded">
                <h3 class="text-xl font-semibold"><?= esc($product['name']) ?></h3>
                <p class="text-primary font-bold"><?= esc($product['price']) ?></p>
            </a>
        </div>
    <?php endforeach; ?>
</div>

<a href="<?= site_url() ?>" class="inline-block mt-8 text-blue-600 hover:underline">&larr; Back to home</a>


<?php echo view('partials/footer'); ?>
