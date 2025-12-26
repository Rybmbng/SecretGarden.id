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
<section class="relative w-full px-4 md:px-12 py-12 ">
  <div class="max-w-7xl mx-auto relative">

    <!-- Tombol Scroll -->
    <button id="scroll-left"
      class="absolute -left-4 top-1/2 -translate-y-1/2 z-10  backdrop-blur-md rounded-full shadow-md p-3 hidden md:flex items-center justify-center transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
    </button>

    <!-- Slider -->
    <div id="slider-track"
         class="flex overflow-x-auto scroll-smooth snap-x snap-mandatory gap-6 px-2 no-scrollbar cursor-grab transition-all">
      <?php foreach ($images as $img): ?>
        <?php $imgSlug = slugify($img['name']); ?>
        <div class="snap-center flex-shrink-0 w-[220px] sm:w-[260px] md:w-[280px] lg:w-[300px] 
                    rounded-xl shadow-md p-4 flex flex-col items-center text-center 
                    transition-transform duration-300 ">
          <a href="<?= site_url('category/' . str_replace(' ', '-', $img['name'])) ?>" 
             class="  overflow-hidden transform transition duration-300 ">

            <?php if (!empty($img['img'])): ?>
            <img src="<?= base_url('assets/SGV/Category/' . $imgSlug . '/' . $img['img']) ?>"
                 alt="<?= esc($img['name']) ?>"
                 class="w-full h-64 object-cover"/>
            <?php else: ?>
              <div class=" flex flex-center justify-center w-full h-64 object-cover">
                <p class="mt-32">No Image</p>
              </div>
            <?php endif; ?>

            <!-- Nama & Harga Produk -->
            <div class="p-4 text-center">
              <h4 class="text-lg font-bold mb-1"><?= esc($img['name']) ?></h4>
              <!-- <p class="text-gray-800 font-semibold"><?= esc($img['desc'] ?? '-') ?></p> -->
            </div>
          </a>
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



<?php  foreach ($categories as $catIndex => $category): ?>
  <section class="bg-[#f4e4cc] h-[50vh] relative overflow-hidden flex items-center">
    <div class="max-w-full mx-auto px-6 py-12 grid grid-cols-2 gap-10 items-center">
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
        <?php if(!empty($images[$catIndex]['img'])) : ?>
        <img src="<?= base_url('assets/SGV/Category/' . strtolower(str_replace(' ', '-', $category['name'])) . '/' . $images[$catIndex]['img']) ?>" 
             alt="<?= esc($category['name']) ?>" 
             class="max-h-[60vh] object-contain parallax-hover transition-transform duration-500 hover:scale-105"/>
             <?php else: ?>
              <div class=" flex flex-center justify-center w-full h-64 object-cover">
                <p class="mt-32">No Image</p>
              </div>
            <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Slider Produk per Kategori -->
  <section class="relative w-full px-4 md:px-12 py-12 fade-in-up">
    <div class="max-w-7xl mx-auto relative">

      <?php $isFew = count($category['products']) < 4; ?>

      <?php if (!$isFew): ?>
        <!-- Tombol Panah Kiri -->
        <button onclick="slideLeft(<?= $catIndex ?>)"
                class="absolute -left-4 top-1/2 -translate-y-1/2 z-10 bg-white/80 p-2 rounded-full shadow-md hover:bg-white hidden md:block">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
          </svg>
        </button>
      <?php endif; ?>

      <!-- Track Produk -->
      <div id="product-slider-track-<?= $catIndex ?>" 
          class="flex overflow-x-auto scroll-smooth snap-x snap-mandatory gap-6 no-scrollbar cursor-grab 
                  <?= $isFew ? 'justify-center' : '' ?>">
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

      <?php if (!$isFew): ?>
        <!-- Tombol Panah Kanan -->
        <button onclick="slideRight(<?= $catIndex ?>)"
                class="absolute -right-4 top-1/2 -translate-y-1/2 z-10 bg-white/80 p-2 rounded-full shadow-md hover:bg-white hidden md:block">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </button>
      <?php endif; ?>

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
const slider = document.getElementById('slider-track');
const btnLeft = document.getElementById('scroll-left');
const btnRight = document.getElementById('scroll-right');

// draggable
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
makeDraggable(slider);

// tombol scroll
btnLeft.onclick = () => slider.scrollBy({ left: -320, behavior: 'smooth' });
btnRight.onclick = () => slider.scrollBy({ left: 320, behavior: 'smooth' });

// Atur center jika item < 4
const items = slider.querySelectorAll('div.snap-center').length;
if (items <= 4) {
  slider.classList.add("justify-center");
  btnLeft.style.display = "none";
  btnRight.style.display = "none";
} else {
  slider.classList.add("justify-start");
}
</script>

<script>
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
