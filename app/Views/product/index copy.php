<?php echo view('partials/header'); ?>

<section class="page relative w-full h-auto">
    <img alt="Elegant Karmakamet style fragrance display" class="w-full object-cover max-h-[700px]" height="700" loading="lazy" src="<?= base_url('assets/sgv/fragrance.jpeg') ?>" width="1920"/>
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-white/70 to-white flex flex-col justify-center items-center text-center px-6 md:px-12">
        <h1 class="text-4xl md:text-6xl font-playfair font-bold text-gray-900 max-w-4xl leading-tight mb-6">
            Discover the Art of Fragrance
        </h1>
        <p class="max-w-2xl text-gray-700 text-lg md:text-xl mb-8">
            Handcrafted aromatic experiences inspired by nature and tradition.
        </p>
        <a class="inline-block bg-black text-white uppercase tracking-widest px-8 py-3 text-sm md:text-base hover:bg-gray-800 transition" href="#">
            Shop Now
        </a>
    </div>

</section>
<section class="relative w-full h-[300px] px-4 md:px-12 flex items-center justify-center">
  <div class="overflow-hidden w-full max-w-7xl mx-auto">
    <div id="slider-track"
         class="flex space-x-6 transition-transform duration-700 ease-in-out will-change-transform md:justify-center"
         style="padding-left: calc((100vw - 240px) / 2);"
    >
      <?php 
      $images = [
               ['img' => 'cr1.png', 'name' => 'Body Care'],
               ['img' => 'cr1.png', 'name' => 'Hand Care'],
               ['img' => 'cr1.png', 'name' => 'Perfume'],
               ['img' => 'cr1.png', 'name' => 'Wellness'],

      ];
      foreach ($images as $img): ?>
        <div class="flex-shrink-0 w-[240px] p-2 flex flex-col snap-center">
          <a href="<?= base_url('category/' . strtolower(str_replace(' ', '-', $img['name']))) ?>" class="overflow-hidden text-center">
            <img src="<?= base_url('assets/sgv/' . $img['img']) ?>" alt="Gallery Image" class="h-[200px] object-cover rounded mx-auto">
            <p class="text-gray-700 font-bold text-lg md:text-xl mt-2"><?= $img['name'] ?></p>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="page relative w-full h-[480px]">
    <img alt="Full width image of SGV luxury spa treatment room"  class="w-full h-auto object-cover"  loading="lazy" src="<?= base_url('assets/sgv/fragrance.jpeg') ?>" />
</section>
  
<?php
$categories = [
  [
    'name' => 'Body Care',
    'products' => [
      ['img' => 'Loofah.jpg', 'name' => 'Loofah', 'price' => 'Rp 120.000'],
      ['img' => 'SG.jpg', 'name' => 'Shower Gel', 'price' => 'Rp 120.000'],
      ['img' => 'BL.jpg', 'name' => 'Body Lotion', 'price' => 'Rp 120.000'],
      ['img' => 'BB.jpg', 'name' => 'Body Butter', 'price' => 'Rp 120.000'],
      ['img' => 'BS.jpg', 'name' => 'Body Scrub', 'price' => 'Rp 120.000'],
      ['img' => 'TK.jpg', 'name' => 'Travel Kit', 'price' => 'Rp 120.000'],
      ['img' => 'BB.jpg', 'name' => 'Bath Bomb', 'price' => 'Rp 120.000 - Rp 150.000'],
    ],
  ],
  [
    'name' => 'Hand Care',
    'products' => [
      ['img' => 'cr1.png', 'name' => 'Hand Wash', 'price' => 'Rp 300.000'],
    ],
  ],
  [
    'name' => 'Perfume',
    'products' => [
      ['img' => 'cr1.png', 'name' => 'EDP Musk Series', 'price' => 'Rp 200.000'],
      ['img' => 'cr1.png', 'name' => 'EDP Gardenia Series', 'price' => 'Rp 250.000'],
      ['img' => 'cr1.png', 'name' => 'ExDP Gardinia Series', 'price' => 'Rp 250.000'],
    ],
  ],
  [
    'name' => 'Wellness',
    'products' => [
      ['img' => 'cr1.png', 'name' => 'Reed Diffuser', 'price' => 'Rp 180.000'],
      ['img' => 'cr1.png', 'name' => 'Linen Spray', 'price' => 'Rp 190.000'],
      ['img' => 'cr1.png', 'name' => 'Essential Oil Diffuser', 'price' => 'Rp 190.000'],
    ],
  ],
];
?>

<?php foreach ($categories as $catIndex => $category): ?>
<section class="bg-[#f4e4cc] text-white h-[50vh] relative overflow-hidden">
  <div class="max-w-7xl mx-auto px-6 py-20 h-full flex flex-col md:flex-row items-center justify-between gap-10">
    
    <!-- TEKS -->
    <div class="max-w-xl text-black text-center md:text-left z-10 flex flex-col justify-center" id="#<?= $category['name'] ?>">
      <h2 class="font-extrabold text-xl md:text-2xl leading-tight mb-4"><?= $category['name'] ?></h2>
      <p class="text-xs xs:text-base leading-relaxed mb-6">
        Drops of pure natural oil. Experience the healing power of nature with the essence of various plant scents.
      </p>
      <button class="inline-block border border-black rounded-md px-3 py-2 text-xs xs:text-base hover:bg-white hover:text-[#f4e4cc] transition">
        See all
      </button>
    </div>

    <div class="flex-shrink-0 max-w-lg w-full h-full z-0 flex items-center justify-center">
      <img
        id="parallax-image"
        alt="Aromatic oil set"
        class="w-full h-auto max-h-[40vh] object-contain"
        src="<?=base_url("assets/sgv/cr1.png")?>"
      />
    </div>
  </div>
</section>
<section class="relative w-full h-[400px] px-4 md:px-12 flex flex-col items-center justify-center mb-12">
  <div class="relative w-full max-w-7xl mx-auto">
    
    <button onclick="slideLeft(<?= $catIndex ?>)" class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white/80 p-2 rounded-full shadow-md hover:bg-white hidden md:block">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
    </button>

    <div id="product-slider-track-<?= $catIndex ?>"
         class="flex space-x-6 transition-transform duration-700 ease-in-out will-change-transform md:justify-center overflow-x-hidden"
         style="padding-left: calc((100vw - 240px) / 2);"
    >
      <?php foreach ($category['products'] as $product): ?>
        <div class="flex-shrink-0 w-[240px] p-2 flex flex-col snap-center bg-white ">
          <img src="<?= base_url('assets/sgv/category/'.$category['name'] . '/'. $product['name'].'/'. $product['img']) ?>" alt="<?= $product['name'] ?>" class="h-[240px] aspect-square object-cover rounded-t">
          <div class="p-4 text-center">
            <h3 class="font-semibold text-lg"><?= $product['name'] ?></h3>
            <p class="text-primary font-bold mt-2"><?= $product['price'] ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <button onclick="slideRight(<?= $catIndex ?>)" class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white/80 p-2 rounded-full shadow-md hover:bg-white hidden md:block">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
    </button>

  </div>
</section>
<?php endforeach; ?>

<script>
  function setupSlider(catIndex) {
    const track = document.getElementById(`product-slider-track-${catIndex}`);
    if (!track) return;

    const items = track.querySelectorAll("div.flex-shrink-0");
    const itemWidth = 240 + 24;
    let index = 0;

    function autoplay() {
      if (window.innerWidth >= 768) return;
      index++;
      if (index >= items.length) index = 0;
      track.style.transform = `translateX(-${index * itemWidth}px)`;
    }

    function adjustPadding() {
      if (window.innerWidth < 768) {
        track.style.paddingLeft = "calc((100vw - 240px) / 2)";
      } else {
        track.style.paddingLeft = "0px";
        track.style.transform = "translateX(0)"; // reset posisi
      }
    }

    window.addEventListener("resize", adjustPadding);
    adjustPadding();

    if (window.innerWidth < 768) {
      setInterval(autoplay, 3000);
    }
  }

  <?php foreach ($categories as $index => $_): ?>
    setupSlider(<?= $index ?>);
  <?php endforeach; ?>
</script>

  <script>
    const image = document.getElementById("parallax-image");
    let currentScroll = 0;
    let targetScroll = 0;

    function smoothParallax() {
      currentScroll += (targetScroll - currentScroll) * 0.1;
      image.style.transform = `translateY(${currentScroll}px)`;
      requestAnimationFrame(smoothParallax);
    }

    window.addEventListener("scroll", () => {
      targetScroll = window.scrollY * 0.005; 
    });

    smoothParallax();
  </script>

<script>
  const track = document.getElementById("slider-track");
  const items = track.querySelectorAll("div.flex-shrink-0");
  const itemWidth = 240 + 24;
  let index = 0;

  function autoplaySlider() {
    if (window.innerWidth >= 768) return;
    index++;
    if (index >= items.length) index = 0;
    track.style.transform = `translateX(-${index * itemWidth}px)`;
  }

  function adjustPadding() {
    if (window.innerWidth < 768) {
      track.style.paddingLeft = "calc((100vw - 240px) / 2)";
    } else {
      track.style.paddingLeft = "0px";
      track.style.transform = "translateX(0)";
    }
  }

  window.addEventListener("load", () => {
    adjustPadding();
    if (window.innerWidth < 768) {
      setInterval(autoplaySlider, 3000);
    }
  });

  window.addEventListener("resize", adjustPadding);
</script>


<script>
  const sliderPositions = {};

  function slideLeft(catIndex) {
    const track = document.getElementById(`product-slider-track-${catIndex}`);
    if (!track) return;

    const itemWidth = 240 + 24;
    sliderPositions[catIndex] = (sliderPositions[catIndex] || 0) - 1;
    if (sliderPositions[catIndex] < 0) sliderPositions[catIndex] = 0;

    track.style.transform = `translateX(-${sliderPositions[catIndex] * itemWidth}px)`;
  }

  function slideRight(catIndex) {
    const track = document.getElementById(`product-slider-track-${catIndex}`);
    if (!track) return;

    const items = track.querySelectorAll("div.flex-shrink-0");
    const itemWidth = 240 + 24;
    sliderPositions[catIndex] = (sliderPositions[catIndex] || 0) + 1;
    if (sliderPositions[catIndex] >= items.length - 1) sliderPositions[catIndex] = items.length - 1;

    track.style.transform = `translateX(-${sliderPositions[catIndex] * itemWidth}px)`;
  }

  function setupSlider(catIndex) {
    const track = document.getElementById(`product-slider-track-${catIndex}`);
    if (!track) return;

    const items = track.querySelectorAll("div.flex-shrink-0");
    const itemWidth = 240 + 24;
    let index = 0;

    function autoplay() {
      if (window.innerWidth >= 768) return; // autoplay hanya di mobile
      index++;
      if (index >= items.length) index = 0;
      track.style.transform = `translateX(-${index * itemWidth}px)`;
    }

    setInterval(autoplay, 3000);

    function adjustPadding() {
      if (window.innerWidth >= 768) {
        track.style.paddingLeft = "0px";
      } else {
        track.style.paddingLeft = "calc((100vw - 240px) / 2)";
      }
    }

    window.addEventListener("resize", adjustPadding);
    adjustPadding();
  }

  <?php foreach ($categories as $index => $_): ?>
    setupSlider(<?= $index ?>);
  <?php endforeach; ?>
</script>

<?= $this->include('partials/footer') ?>
