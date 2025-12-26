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

<section class="w-full relative">
 <div class="w-full h-[500px] bg-center bg-cover bg-no-repeat text-black text-left px-4 relative overflow-hidden parallax-section"
      style="background-image: url('<?= base_url('assets/SGV/fragrance.jpeg') ?>');">
    <div class="relative ml-10 z-[2] mt-[150px] flex flex-col items-left justify-left h-full transition-all duration-1000 ease-in-out fade-in-up">
      <div class="">
        <a class="text-sm md:text-sm text-white mb-2" href="<?=base_url("products") ?>">< Back</a>
        <h1 class="text-xl md:text-xl text-white tracking-wide mb-2">ALL PRODUCTS</h1>
      </div>
    </div>
  </div>
</section >
<section class="w-full flex flex-col-2 mb-10">
    <div class="overflow:flex w-1/4 mx-auto px-6 mt-5 item-center justify-center ">
      <div id="path" class="mt-5 mb-5">
          <a class="font-light">SHOP > </a><a class="font-bold">ALL PRODUCTS</a>
      </div>
      <form method="get" class="flex flex-row md:flex-col md:items-center justify-between">
        <input type="text" name="search" placeholder="Search Product" value="<?= esc($_GET['search'] ?? '') ?>"
              class="border border-gray-300 mb-2 mt-2 px-4 py-2 rounded-md w-full">
        <select name="sort" class="border border-gray-300  mb-2 mt-2  py-2 rounded-md w-full">
          <option value="">Order</option>
          <option value="price_asc" <?= ($_GET['sort'] ?? '') == 'price_asc' ? 'selected' : '' ?>>Low Cost</option>
          <option value="price_desc" <?= ($_GET['sort'] ?? '') == 'price_desc' ? 'selected' : '' ?>>High Cost</option>
          <option value="name_asc" <?= ($_GET['sort'] ?? '') == 'name_asc' ? 'selected' : '' ?>>Order By A-Z</option>
          <option value="name_desc" <?= ($_GET['sort'] ?? '') == 'name_desc' ? 'selected' : '' ?>>Order Z-A</option>
        </select>
        <button type="submit" class="bg-black text-white px-6 py-2 rounded-md">Search</button>
      </form>

      <div class="w-auto mt-20 text-left">
        <div class="mb-5">
          <h1 class="font-bold">PRODUCT CATEGORIES</h1>
        </div>
        <div class="mb-2 mt-3" alt="all product list here">
          <h1><a class="font-bold mb-2 mt-2">ALL PRODUCT</a></h1>
          <?php foreach($catname as $cat):?>
            <a href="<?=base_url('category/'). $cat['name']?>" class="font-bold text-yellow-800 mb-2 mt-2"><?=$cat['name']?></a>
            <div class="mb-2 mt-2">
              <?php foreach ($cat['products'] as $product):?>
              <a class="p-2" href="<?=base_url('category/'). str_replace(" ","-",$cat['name']).'/'.str_replace(" ","-",$product['name'])?>"><?= $product['name']?></a><br/>
              <?php endforeach?>
            </div>
            <?php endforeach ?>
        </div>
      </div>
    </div>

    <div class="w-3/4 mx-auto md:mt-20">
      <div class="grid item-center justify-center grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-10">
        <?php foreach ($products as $product): ?>
          <a href="<?php echo base_url('products/').str_replace(" ","-",$product['pname'])?>" class="group w-[150px] h-auto  fade-in-up transition-all duration-1000 ease-out">
            <div class="flex overflow-hidden items-center  justify-center ">
                  <img src="<?php echo base_url('assets/SGV/Category/'.strtolower(str_replace(" ","-",$product['catname'])).'/'.strtolower(str_replace(" ","-",$product['pname']).'/'.strtolower(str_replace(" ","-",$product['img']))))?>" class="w-auto h-[150px] object-cover items-center justify-center transform transition-transform duration-500 group-hover:scale-105" />
            </div>
            <div class="mt-4 text-center">
              <h3 class="text-lg font-semibold text-gray-900"><?= $product['pname'] ?></h3>
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
