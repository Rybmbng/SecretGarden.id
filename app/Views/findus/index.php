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

  <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-10 p-10">
    <?php foreach ($stores as $store): ?>
      <div class="text-left mt-10">
          <h1 class="text-black text-sm md:text-2xl font-medium mb-2">
              <?= esc($store['name']) ?>
          </h1>
          <h2 class="text-black text-sm md:text-xl">
              <?= esc($store['floor']) ?>
          </h2>
          <h2 class="text-black text-sm md:text-xl">
              <?= esc($store['open_hours']) ?>
          </h2>
          <h2 class="text-black text-sm md:text-xl">
              Tel. <?= esc($store['phone']) ?>
          </h2>
          <?php if (!empty($store['map_link'])): ?>
            <a href="<?= esc($store['map_link']) ?>" target="_blank" 
               class="text-black text-sm md:text-xl underline mt-5 inline-block">
               Get Direction
            </a>
          <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php echo view('partials/footer'); ?>
