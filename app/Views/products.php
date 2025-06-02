<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<section class="max-w-7xl mx-auto px-4 py-8">
  <h1 class="text-3xl font-semibold mb-6 text-center">Our Products</h1>

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    <?php foreach ($products as $product): ?>
      <div class="bg-white rounded-2xl shadow p-4 transition hover:shadow-xl">
        <a href="<?= base_url('product/detail/' . $product['id']) ?>">
          <img src="<?= base_url('assets/img/' . $product['image']) ?>" alt="<?= esc($product['name']) ?>" class="rounded-xl w-full h-64 object-cover">
          <div class="mt-4 text-center">
            <h2 class="text-lg font-medium"><?= esc($product['name']) ?></h2>
            <p class="text-sm text-gray-500 mt-1"><?= esc($product['category']) ?></p>
          </div>
        </a>
      </div>
    <?php endforeach; ?>
  </div>
</section>
<?= $this->endSection() ?>
