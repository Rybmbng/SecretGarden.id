<?php echo view('partials/header'); ?>

<section class="page relative w-full h-auto">
    <img alt="Elegant Karmakamet style fragrance display" class="w-full object-cover max-h-[700px]" height="700" loading="lazy" src="<?= base_url('assets/SGV/fragrance.jpeg') ?>" width="1920"/>
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-white/70 to-white flex flex-col justify-center items-center text-center px-6 md:px-12">
        <h1 class="text-4xl md:text-6xl font-playfair font-bold text-gray-900 max-w-4xl leading-tight mb-6">
            Discover the Art of Fragrance
        </h1>
        <p class="max-w-2xl text-gray-700 text-lg md:text-xl mb-8">
            Handcrafted aromatic experiences inspired by nature and tradition.
        </p>       
    </div>
</section>
<?php foreach ($primaryImage as $pm): ?>
    <?php $pm['img'] = $pm['image_path'] ?? 'default-product.jpg'; ?>
<section class="relative w-full h-[400px] px-4 md:px-12 flex flex-col items-center justify-center mb-12">
  <div class="relative w-full max-w-7xl mx-auto">
    <div id="product-slider-track"
         class="flex space-x-6 transition-transform duration-700 ease-in-out will-change-transform md:justify-center overflow-x-hidden"
         style="padding-left: calc((100vw - 240px) / 2);">
      <?php foreach ($products as $product): ?>
        <div class="flex-shrink-0 w-[240px] p-2 flex flex-col snap-center bg-white ">
          <a href="<?= site_url('products/' . strtolower(str_replace(' ', '-', $product['name']))) ?>">
            <img src="<?= base_url('assets/SGV/Category/'.str_replace(' ', '-', $category['name']) . '/'. str_replace(' ', '-', $product['name']).'/'. $product['img']) ?>" alt="<?= esc($product['name']) ?>" class="h-[240px] aspect-square object-cover rounded-t">
            <div class="p-4 text-center">
              <h3 class="font-semibold text-lg"><?= esc($product['name']) ?></h3>
              <p class="text-primary font-bold mt-2"><?= esc($product['price']) ?></p>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
<?php endforeach; ?>


  </div>
</section>

<?= $this->include('partials/footer') ?>
