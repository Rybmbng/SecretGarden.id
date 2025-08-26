<?php echo view('partials/header', ['title' => 'Find Us']); ?>

<section class="w-full bg-[white] text-black font-sans">
  <div class="overflow-hidden">
      <img src="<?= base_url('assets/SGV/services/cu/background.jpeg') ?>" 
           alt="Service Banner" 
           class="w-full h-[40vh] aspect-square md:aspect-video object-cover" />
  </div>
        
  <div class="w-full mt-20 mb-10 flex items-center justify-center">
      <h1 class="text-4xl text-black font-medium md:text-6xl">FIND US</h1>
  </div>

<div class="max-w-6xl mx-auto py-10">
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach($stores as $store): ?>
      <a href="/findus/<?= esc($store['slug']) ?>" 
         class="block bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition">
        <?php 
          $firstImg = (new \App\Models\StoreImageModel())
                        ->where('store_id', $store['id'])
                        ->first();
        ?>
        <?php if ($firstImg): ?>
          <img src="/assets/SGV/stores/<?= esc($firstImg['image']) ?>" 
               alt="<?= esc($store['name']) ?>" 
               class="w-full h-48 object-cover">
        <?php endif; ?>
        <div class="p-4">
          <h2 class="font-semibold text-lg"><?= esc($store['name']) ?></h2>
          <p class="text-sm text-gray-600"><?= esc($store['address']) ?></p>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
</div>

</section>

<?php echo view('partials/footer'); ?>
