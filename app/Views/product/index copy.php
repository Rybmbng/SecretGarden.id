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

</section><section class="relative w-full h-[300px] px-4 md:px-12 flex items-center justify-center">
  <div class="overflow-hidden w-full max-w-7xl mx-auto">
    <div id="slider-track"
         class="flex space-x-6 transition-transform duration-700 ease-in-out will-change-transform md:justify-center"
         style="padding-left: calc((100vw - 200px) / 2);"
    >
      <?php 
      $images = [
          'careso.png',
          'careso.png',
          'careso.png',
          'careso.png'
      ];
      $no = 0;
      foreach ($images as $img): ?>
        <div class="flex-shrink-0 w-[200px] p-2 flex flex-col snap-center">
          <div class="overflow-hidden text-center">
            <img src="<?= base_url('assets/sgv/' . $img) ?>" alt="Gallery Image" class="h-[200px] object-cover rounded mx-auto">
            <p class="text-gray-700 font-bold text-lg md:text-xl mt-2">Kategori <?= ++$no; ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="page relative w-full h-[480px]">
    <img alt="Full width image of SGV luxury spa treatment room"  class="w-full h-auto object-cover"  loading="lazy" src="<?= base_url('assets/sgv/fragrance.jpeg') ?>" />
</section>
  
<!-- kategori1 -->
  <section class="bg-[#f4e4cc] text-white h-[50vh] relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 py-20 h-full flex flex-col md:flex-row items-center justify-between gap-10">
      
      <!-- TEKS -->
    <div class="max-w-xl text-black text-center md:text-left z-10 flex flex-col justify-center">
        <h2 class="font-extrabold text-xl md:text-2xl leading-tight mb-4">Body Care</h2>
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
</section><section class="relative w-full h-[300px] px-4 md:px-12 flex items-center justify-center">
  <div class="overflow-hidden w-full max-w-7xl mx-auto">
    <div id="slider-track"
         class="flex space-x-6 transition-transform duration-700 ease-in-out will-change-transform md:justify-center"
         style="padding-left: calc((100vw - 200px) / 2);"
    >
      <?php 
      $images = [
          'careso.png',
          'careso.png',
          'careso.png',
          'careso.png'
      ];
      $no = 0;
      foreach ($images as $img): ?>
        <div class="flex-shrink-0 w-[200px] p-2 flex flex-col snap-center">
          <div class="overflow-hidden text-center">
            <img src="<?= base_url('assets/sgv/' . $img) ?>" alt="Gallery Image" class="h-[200px] object-cover rounded mx-auto">
            <p class="text-gray-700 font-bold text-lg md:text-xl mt-2">Kategori <?= ++$no; ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>



<!-- kategori2 -->
  <section class="bg-[#f4e4cc] text-white h-[50vh] relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 py-20 h-full flex flex-col md:flex-row items-center justify-between gap-10">
      
      <!-- TEKS -->
      <div class="max-w-xl text-black text-center md:text-left z-10 flex flex-col justify-center">
        <h2 class="font-extrabold text-xl md:text-2xl leading-tight mb-4">Hand Care</h2>
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
</section><section class="relative w-full h-[300px] px-4 md:px-12 flex items-center justify-center">
  <div class="overflow-hidden w-full max-w-7xl mx-auto">
    <div id="slider-track"
         class="flex space-x-6 transition-transform duration-700 ease-in-out will-change-transform md:justify-center"
         style="padding-left: calc((100vw - 200px) / 2);"
    >
      <?php 
      $images = [
          'careso.png',
          'careso.png',
          'careso.png',
          'careso.png'
      ];
      $no = 0;
      foreach ($images as $img): ?>
        <div class="flex-shrink-0 w-[200px] p-2 flex flex-col snap-center">
          <div class="overflow-hidden text-center">
            <img src="<?= base_url('assets/sgv/' . $img) ?>" alt="Gallery Image" class="h-[200px] object-cover rounded mx-auto">
            <p class="text-gray-700 font-bold text-lg md:text-xl mt-2">Kategori <?= ++$no; ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>




<!-- kategori3 -->
  <section class="bg-[#f4e4cc] text-white h-[50vh] relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 py-20 h-full flex flex-col md:flex-row items-center justify-between gap-10">
      
      <!-- TEKS -->
            <div class="max-w-xl text-black text-center md:text-left z-10 flex flex-col justify-center">
        <h2 class="font-extrabold text-xl md:text-2xl leading-tight mb-4">Parfume</h2>
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
</section><section class="relative w-full h-[300px] px-4 md:px-12 flex items-center justify-center">
  <div class="overflow-hidden w-full max-w-7xl mx-auto">
    <div id="slider-track"
         class="flex space-x-6 transition-transform duration-700 ease-in-out will-change-transform md:justify-center"
         style="padding-left: calc((100vw - 200px) / 2);"
    >
      <?php 
      $images = [
          'careso.png',
          'careso.png',
          'careso.png',
          'careso.png'
      ];
      $no = 0;
      foreach ($images as $img): ?>
        <div class="flex-shrink-0 w-[200px] p-2 flex flex-col snap-center">
          <div class="overflow-hidden text-center">
            <img src="<?= base_url('assets/sgv/' . $img) ?>" alt="Gallery Image" class="h-[200px] object-cover rounded mx-auto">
            <p class="text-gray-700 font-bold text-lg md:text-xl mt-2">Kategori <?= ++$no; ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>




<!-- kategori4 -->
  <section class="bg-[#f4e4cc] text-white h-[50vh] relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 py-20 h-full flex flex-col md:flex-row items-center justify-between gap-10">
      
      <!-- TEKS -->
            <div class="max-w-xl text-black text-center md:text-left z-10 flex flex-col justify-center">
        <h2 class="font-extrabold text-xl md:text-2xl leading-tight mb-4">Wellness</h2>
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
</section>
<section class="relative w-full h-[300px] px-4 md:px-12 flex items-center justify-center">
  <div class="overflow-hidden w-full max-w-7xl mx-auto">
    <div id="slider-track"
         class="flex space-x-6 transition-transform duration-700 ease-in-out will-change-transform md:justify-center"
         style="padding-left: calc((100vw - 200px) / 2);"
    >
      <?php 
      $images = [
          'careso.png',
          'careso.png',
          'careso.png',
          'careso.png'
      ];
      $no = 0;
      foreach ($images as $img): ?>
        <div class="flex-shrink-0 w-[200px] p-2 flex flex-col snap-center">
          <div class="overflow-hidden text-center">
            <img src="<?= base_url('assets/sgv/' . $img) ?>" alt="Gallery Image" class="h-[200px] object-cover rounded mx-auto">
            <p class="text-gray-700 font-bold text-lg md:text-xl mt-2">Kategori <?= ++$no; ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>





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
  const itemWidth = 200 + 24; // 200px item + 24px (1.5rem) space-x
  let index = 0;

  function autoplaySlider() {
    if (window.innerWidth >= 768) return; // autoplay hanya untuk mobile
    index++;
    if (index >= items.length) index = 0;
    track.style.transform = `translateX(-${index * itemWidth}px)`;
  }

  // Delay autoplay agar Kategori 1 tampil dulu
  window.addEventListener("load", () => {
    setTimeout(() => {
      setInterval(autoplaySlider, 3000);
    }, 1500);
  });

  // Reset padding-left di desktop
  function adjustPadding() {
    if (window.innerWidth >= 768) {
      track.style.paddingLeft = "0px";
    } else {
      track.style.paddingLeft = "calc((100vw - 200px) / 2)";
    }
  }

  window.addEventListener("resize", adjustPadding);
  adjustPadding(); // initial run
</script>

<?= $this->include('partials/footer') ?>
