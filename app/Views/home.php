<?php echo view('partials/header'); ?>

<section class="relative w-full h-full aspect-video overflow-hidden" id="slide-main">
  <div class="absolute inset-0 w-full h-full transition-opacity duration-1000 ease-in-out opacity-100" data-index="0">
    <video autoplay loop muted playsinline class="w-full h-full object-cover">
      <source src="<?= base_url('assets/sgv/video/slide1.mp4') ?>" type="video/mp4" />
    </video>
  </div>
  <div class="absolute inset-0 w-full h-full transition-opacity duration-1000 ease-in-out opacity-0" data-index="1">
    <video autoplay loop muted playsinline class="w-full h-full object-cover">
      <source src="//vci.co.id/wp-content/uploads/2021/05/Skin-Care-Herborist-Nu-Face-Cosmetics-Miranda-Hair-HOME-BANNER-VIDEO-1.mp4" type="video/mp4" />
    </video>
  </div>
  <div class="absolute inset-0 w-full h-full transition-opacity duration-1000 ease-in-out opacity-0" data-index="2">
    <video autoplay loop muted playsinline class="w-full h-full object-cover">
      <source src="<?= base_url('assets/sgv/video/slide2.mp4') ?>" type="video/mp4" />
    </video>
  </div>
</section>

<section class="page flex flex-col md:flex-row items-center justify-center bg-white" id="sample-category">
    <div class="w-full md:w-1/2 flex justify-center items-center p-4" style="perspective: 1500px;">
        <div class="tilt-parallax max-w-md rounded-lg overflow-hidden" id="tiltSample">
            <img alt="Sample SGV beauty device product image" class="w-full h-auto object-cover" height="600" loading="lazy" src="<?= base_url('assets/sgv/careso.png') ?>" width="600"/>
        </div>
    </div>
    <div class="w-full md:w-1/2">
        <div class="relative overflow-hidden rounded-lg shadow-lg">
            <div class="flex transition-transform duration-500 ease-in-out" id="categorySlider" style="width: 100%;">
                <a href="#product1" class="w-full flex-shrink-0 object-cover"><img alt="Category image of SGV device" class="w-full flex-shrink-0 object-cover" height="100vh" loading="lazy" src="<?= base_url('assets/sgv/slide1.jpg') ?>" width="100vh"/></a>
                <a href="#product2" class="w-full flex-shrink-0 object-cover"><img alt="Category image of SGV skincare product" class="w-full flex-shrink-0 object-cover" height="100vh" loading="lazy" src="<?= base_url('assets/sgv/slide2.jpg') ?>" width="100vh"/></a>
                <a href="#product3" class="w-full flex-shrink-0 object-cover"><img alt="Category image of SGV beauty device accessories" class="w-full flex-shrink-0 object-cover" height="100vh" loading="lazy" src="<?= base_url('assets/sgv/slide3.jpg') ?>" width="100vh"/></a>
                <a href="#product4" class="w-full flex-shrink-0 object-cover"><img alt="Category image of SGV luxury skincare set" class="w-full flex-shrink-0 object-cover" height="100vh" loading="lazy" src="<?= base_url('assets/sgv/slide4.jpeg') ?>" width="100vh"/></a>
            </div>
            <button aria-label="Previous category" class="slider-button absolute top-1/2 left-2 -translate-y-1/2 rounded-full" id="prevCategory">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button aria-label="Next category" class="slider-button absolute top-1/2 right-2 -translate-y-1/2 rounded-full" id="nextCategory">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>

<section class="page relative w-full h-auto" id="fullwide1">
    <img alt="Full width image of SGV luxury spa treatment room" class="w-full h-auto object-cover" height="1080" loading="lazy" src="<?= base_url('assets/sgv/slide1.jpg') ?>" />
</section>

<section class="page relative w-full h-auto" id="fullwide2">
    <img alt="Full width image of SGV skincare products" class="w-full h-auto object-cover" height="1080" loading="lazy" src="<?= base_url('assets/sgv/slide2.jpg') ?>" />
</section>

<section class="page relative aspect-video w-full h-full" id="video-full">
    <video autoplay class="w-full h-full object-cover" loop muted playsinline preload="auto">
        <source src="<?= base_url('assets/sgv/video/slide1.mp4') ?>" type="video/mp4"/>
        Your browser does not support the video tag.
    </video>
</section>

<section class="page relative w-full h-auto">
    <img alt="Elegant Karmakamet style fragrance display" class="w-full object-cover max-h-[700px]" height="700" loading="lazy" src="<?= base_url('assets/sgv/fragrance.jpeg') ?>" width="1920"/>
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-white/70 to-white flex flex-col justify-center items-center text-center px-6 md:px-12">
        <h1 class="text-4xl md:text-6xl font-playfair font-bold text-gray-900 max-w-4xl leading-tight mb-6">
            Discover the Art of Fragrance
        </h1>
        <p class="max-w-2xl text-gray-700 text-lg md:text-xl mb-8">
            Handcrafted aromatic experiences inspired by nature and tradition.
        </p>
        <a class="inline-block bg-black text-white uppercase tracking-widest px-8 py-3 text-sm md:text-base hover:bg-gray-800 transition" href="/products">
            Shop Now
        </a>
    </div>
</section>


<script>
  const slides = document.querySelectorAll("#slide-main > div");
  const durations = [8000, 12000, 10000]; 
  let current = 0;

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.classList.toggle("opacity-100", i === index);
      slide.classList.toggle("opacity-0", i !== index);
    });

    setTimeout(() => {
      current = (index + 1) % slides.length;
      showSlide(current);
    }, durations[index]);
  }
  showSlide(current);
</script>

<?= $this->include('partials/footer') ?>
