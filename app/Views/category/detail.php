<?= $this->include('partials/header'); ?>
<style>
  .fade-in-up {
    opacity: 0;
    transform: translateY(50px);
    transition: all 0.9s ease-out;
  }
  .fade-in-up.visible {
    opacity: 1;
    transform: translateY(0);
  }

  .parallax-section {
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
  }

  @media (max-width: 768px) {
    .parallax-section {
      background-attachment: scroll;
    }
  }
</style>

<section class="relative">
  <!-- Hero Header -->
 <div class="w-full h-[500px] bg-center bg-cover bg-no-repeat text-black text-center px-4 relative overflow-hidden parallax-section"
     style="background-image: url('<?= base_url('assets/SGV/category/' . $category['path'] . '.jpg') ?>');">
  <div class="absolute inset-0 bg-white/50 backdrop-blur-sm z-[1]"></div>
  <div class="relative z-[2] flex flex-col items-center justify-center h-full opacity-0 translate-y-10 transition-all duration-1000 ease-in-out fade-in-up">
    <div class="bg-white/70 p-6 rounded-xl">
      <h1 class="text-4xl md:text-6xl font-serif tracking-wide mb-2"><?= $category['name'] ?></h1>
      <p class="max-w-2xl text-lg md:text-xl font-light"><?= $category['description'] ?></p>
    </div>
  </div>
</div>

<!-- filter form -->
<div class="max-w-7xl mx-auto px-6 mt-12">
  <form method="get" class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <input type="text" name="search" placeholder="Cari produk..." value="<?= esc($_GET['search'] ?? '') ?>"
           class="border border-gray-300 px-4 py-2 rounded-md w-full md:w-1/3">

    <select name="sort" class="border border-gray-300 px-4 py-2 rounded-md w-full md:w-1/4">
      <option value="">Urutkan</option>
      <option value="price_asc" <?= ($_GET['sort'] ?? '') == 'price_asc' ? 'selected' : '' ?>>Harga Termurah</option>
      <option value="price_desc" <?= ($_GET['sort'] ?? '') == 'price_desc' ? 'selected' : '' ?>>Harga Tertinggi</option>
      <option value="name_asc" <?= ($_GET['sort'] ?? '') == 'name_asc' ? 'selected' : '' ?>>Nama A-Z</option>
      <option value="name_desc" <?= ($_GET['sort'] ?? '') == 'name_desc' ? 'selected' : '' ?>>Nama Z-A</option>
    </select>

    <button type="submit" class="bg-black text-white px-6 py-2 rounded-md">Terapkan</button>
  </form>
</div>

  <!-- Produk Grid -->
  <div class="max-w-7xl mx-auto py-16 px-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
      <?php foreach ($products as $product): ?>
        <a href="<?php echo base_url('products/').str_replace(" ","-",$product['pname'])?>" class="group fade-in-up transition-all duration-1000 ease-out">
          <div class="overflow-hidden rounded-lg shadow-md">
            <img src="<?= base_url('assets/SGV/Category/' . $category['path'] . '/'. str_replace(" ","-",$product['pname']) .'/'. $product['image_path']) ?>" alt="<?= $product['name'] ?>"
                 class="w-full h-[350px] object-cover transform transition-transform duration-500 group-hover:scale-105" />
          </div>
          <div class="mt-4 text-center">
            <h3 class="text-lg font-semibold text-gray-900"><?= $product['name'] ?></h3>
            <p class="text-sm text-gray-600 mt-1"><?= $product['desc'] ?></p>
            <p class="mt-2 text-base font-medium text-gray-800">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const fadeElements = document.querySelectorAll('.fade-in-up');

    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, {
      threshold: 0.1
    });

    fadeElements.forEach(el => observer.observe(el));
  });
</script>

<?= $this->include('partials/footer'); ?>
