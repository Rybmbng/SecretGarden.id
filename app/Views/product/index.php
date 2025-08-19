<?php echo view('partials/header'); 

function slugify($string)
{
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
}
?>
<style>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<!-- Hero -->
<section class="relative w-full h-auto fade-in-up">
  <img alt="Fragrance display" 
       class="w-full object-cover max-h-[700px]" 
       src="<?= base_url('assets/SGV/fragrance.jpeg') ?>" />

  <div class="absolute inset-0 bg-gradient-to-b from-transparent via-white/70 to-white flex flex-col justify-center items-center text-center px-6 md:px-12">
    <h1 class="text-4xl md:text-6xl font-playfair font-bold text-gray-900 max-w-4xl leading-tight mb-6">
      Discover the Art of Fragrance
    </h1>
    <p class="max-w-2xl text-gray-700 text-lg md:text-xl mb-8">
      Handcrafted aromatic experiences inspired by nature and tradition.
    </p>
  </div>
</section>

<section class="relative w-full px-4 md:px-12 py-12 bg-gradient-to-b from-white to-gray-50">
  <div class="max-w-7xl mx-auto relative">

    <!-- Tombol Scroll -->
    <button id="scroll-left"
      class="absolute -left-4 top-1/2 -translate-y-1/2 z-10 bg-white/70 backdrop-blur-md rounded-full shadow-md p-3 hover:bg-white hidden md:flex items-center justify-center transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
    </button>

    <!-- Slider -->
    <div id="slider-track"
         class="flex overflow-x-auto scroll-smooth snap-x snap-mandatory gap-8 px-2 no-scrollbar cursor-grab">
      <?php foreach ($images as $catImg => $img): ?>
        <?php $imgSlug = slugify($img['name']); ?>
        <div class="snap-center flex-shrink-0 w-[280px] sm:w-[320px]">
          <div class="group relative bg-white rounded-2xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-[1.03] hover:shadow-xl">

            <!-- Gambar -->
            <img src="<?= base_url('assets/SGV/Category/' . $imgSlug . '/' . $img['img']) ?>"
                 alt="<?= esc($img['name']) ?>"
                 class="h-48 w-full object-cover group-hover:scale-105 transition duration-500"/>

            <!-- Overlay Gradient -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>

            <!-- Konten -->
            <div class="absolute bottom-0 left-0 w-full p-4 text-white">
              <h3 class="text-lg font-bold"><?= esc($img['name']) ?></h3>
              <p class="text-sm opacity-80 line-clamp-2"><?= esc($img['desc']) ?></p>
              <a href="<?= site_url('category/' . str_replace(' ', '-', $img['name'])) ?>"
                 class="inline-block mt-3 px-4 py-2 bg-white text-gray-800 font-semibold rounded-xl shadow hover:bg-gray-100 hover:shadow-lg transition">
                Check
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Tombol Scroll -->
    <button id="scroll-right"
      class="absolute -right-4 top-1/2 -translate-y-1/2 z-10 bg-white/70 backdrop-blur-md rounded-full shadow-md p-3 hover:bg-white hidden md:flex items-center justify-center transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
      </svg>
    </button>
  </div>
</section>


<!-- Section Kategori Produk -->
<?php foreach ($categories as $catIndex => $category): ?>
  <?php if (empty($category['products'])) continue; ?>
  <section class="bg-[#f4e4cc] h-[50vh] relative overflow-hidden flex items-center">
    <div class="max-w-7xl mx-auto px-6 py-12 grid md:grid-cols-2 gap-10 items-center">
      <!-- Teks -->
      <div class="text-center md:text-left text-black">
        <h2 class="text-2xl font-extrabold mb-4"><?= esc($category['name']) ?></h2>
        <p class="text-sm md:text-base mb-6"><?= esc($category['description']) ?></p>
        <a href="<?= site_url('category/' . strtolower(str_replace(' ', '-', $category['name']))) ?>" 
           class="inline-block border border-black rounded-md px-4 py-2 text-sm hover:bg-white hover:text-[#f4e4cc] transition">
          See all
        </a>
      </div>

      <!-- Gambar -->
      <div class="flex justify-center">
        <img src="<?= base_url("assets/SGV/cr1.png") ?>" 
             alt="<?= esc($category['name']) ?>" 
             class="max-h-[40vh] object-contain parallax-hover transition-transform duration-500 hover:scale-105"/>
      </div>
    </div>
  </section>

  <!-- Slider Produk per Kategori -->
  <section class="relative w-full px-4 md:px-12 py-12 fade-in-up">
    <div class="max-w-7xl mx-auto relative">
      <button onclick="slideLeft(<?= $catIndex ?>)"
              class="absolute -left-4 top-1/2 -translate-y-1/2 z-10 bg-white/80 p-2 rounded-full shadow-md hover:bg-white hidden md:block">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
      </button>

      <div id="product-slider-track-<?= $catIndex ?>" 
           class="flex overflow-x-auto scroll-smooth snap-x snap-mandatory gap-6 no-scrollbar cursor-grab">
        <?php foreach ($category['products'] as $product): ?>
          <a href="<?= site_url('products/' . strtolower(str_replace(' ', '-', $product['name']))) ?>"
             class="flex-shrink-0 w-[240px] bg-white rounded-xl shadow-lg p-4 flex flex-col items-center text-center snap-center transition-transform duration-300 hover:scale-105 hover:shadow-2xl">
            <div class="text-xs uppercase text-[#7b956a] font-semibold mb-1"><?= esc($category['name']) ?></div>
            <div class="font-bold text-base text-[#495c48] mb-2"><?= esc($product['name']) ?></div>
            <img src="<?= base_url('assets/SGV/Category/'.strtolower(str_replace(' ', '-', $category['name'])) . '/'. strtolower(str_replace(' ', '-', $product['name'])).'/'. $product['main_images']) ?>"
                 alt="<?= esc($product['name']) ?>" 
                 class="w-[180px] h-[180px] object-cover rounded-md mb-3 transition-transform duration-500 hover:scale-110"/>
            <p class="text-xs text-gray-500 line-clamp-3"><?= esc($product['desc'] ?? '') ?></p>
          </a>
        <?php endforeach; ?>
      </div>

      <button onclick="slideRight(<?= $catIndex ?>)"
              class="absolute -right-4 top-1/2 -translate-y-1/2 z-10 bg-white/80 p-2 rounded-full shadow-md hover:bg-white hidden md:block">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
      </button>
    </div>
  </section>
<?php endforeach; ?>

<!-- No Scrollbar CSS -->
<style>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<!-- Script Slider -->
<script>
const makeDraggable = (slider) => {
  let isDown = false, startX, scrollLeft;

  slider.addEventListener('mousedown', (e) => {
    isDown = true;
    startX = e.pageX - slider.offsetLeft;
    scrollLeft = slider.scrollLeft;
  });
  slider.addEventListener('mouseleave', () => isDown = false);
  slider.addEventListener('mouseup', () => isDown = false);
  slider.addEventListener('mousemove', (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - slider.offsetLeft;
    slider.scrollLeft = scrollLeft - (x - startX) * 2;
  });

  // touch
  slider.addEventListener('touchstart', (e) => {
    startX = e.touches[0].pageX;
    scrollLeft = slider.scrollLeft;
  });
  slider.addEventListener('touchmove', (e) => {
    const x = e.touches[0].pageX;
    slider.scrollLeft = scrollLeft - (x - startX) * 2;
  });
};

makeDraggable(document.getElementById('slider-track'));
<?php foreach ($categories as $index => $_): ?>
makeDraggable(document.getElementById('product-slider-track-<?= $index ?>'));
<?php endforeach; ?>

// Scroll tombol utama
document.getElementById('scroll-left').onclick = () => {
  document.getElementById('slider-track').scrollBy({ left: -320, behavior: 'smooth' });
};
document.getElementById('scroll-right').onclick = () => {
  document.getElementById('slider-track').scrollBy({ left: 320, behavior: 'smooth' });
};

function slideLeft(catIndex) {
  document.getElementById(`product-slider-track-${catIndex}`)
    .scrollBy({ left: -260, behavior: 'smooth' });
}
function slideRight(catIndex) {
  document.getElementById(`product-slider-track-${catIndex}`)
    .scrollBy({ left: 260, behavior: 'smooth' });
}
</script>

<script>
const slider = document.getElementById('slider-track');
let isDown = false, startX, scrollLeft;

// drag pakai mouse
slider.addEventListener('mousedown', (e) => {
  isDown = true;
  slider.classList.add('active');
  startX = e.pageX - slider.offsetLeft;
  scrollLeft = slider.scrollLeft;
});
slider.addEventListener('mouseleave', () => isDown = false);
slider.addEventListener('mouseup', () => isDown = false);
slider.addEventListener('mousemove', (e) => {
  if (!isDown) return;
  e.preventDefault();
  const x = e.pageX - slider.offsetLeft;
  const walk = (x - startX) * 2;
  slider.scrollLeft = scrollLeft - walk;
});

// drag pakai touch
let touchStartX = 0;
slider.addEventListener('touchstart', (e) => {
  touchStartX = e.touches[0].pageX;
  scrollLeft = slider.scrollLeft;
});
slider.addEventListener('touchmove', (e) => {
  const x = e.touches[0].pageX;
  const walk = (x - touchStartX) * 2;
  slider.scrollLeft = scrollLeft - walk;
});

// tombol panah
document.getElementById('scroll-left').onclick = () => {
  slider.scrollBy({ left: -320, behavior: 'smooth' });
};
document.getElementById('scroll-right').onclick = () => {
  slider.scrollBy({ left: 320, behavior: 'smooth' });
};
</script>

<?= $this->include('partials/footer') ?>
