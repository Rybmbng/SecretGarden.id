<?php echo view('partials/header'); ?>

<section class="page relative h-auto w-full aspect-video overflow-hidden" id="slide-main">
  <?php foreach ($sliders as $index => $slide): ?>
    <div class="absolute aspect-video inset-0 w-[100%] h-auto md:w-[100%] md:h-full transition-opacity duration-1000 ease-in-out <?= $index === 0 ? 'opacity-100' : 'opacity-0' ?>" data-index="<?= $index ?>">
      <?php if ($slide['type'] === 'video'): ?>
        <video autoplay loop muted playsinline class="w-[100%] h-auto md:w-[100%] md:h-full object-cover" loading="lazy" >
          <source src="<?= base_url($slide['src']) ?>" type="video/mp4" />
        </video>
      <?php elseif ($slide['type'] === 'image'): ?>
        <img src="<?= base_url($slide['src']) ?>" alt="<?= esc($slide['alt']) ?>" class="w-[100%] h-full object-cover" loading="lazy" />
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</section>

<section class="page w-full relative object-cover h-auto"  id="fullwide1">
    <div class="w-full object-cover h-[200px] md:h-[400px] text-center flex flex-col justify-center items-center bg-gradient-to-b from-transparent to-white">
            <p class="text-gray-700 text-2xl md:text-4xl mb-8">
                𝘐𝘯𝘴𝘱𝘪𝘳𝘦𝘥 𝘣𝘺 𝘌𝘢𝘳𝘵𝘩, 𝘔𝘢𝘥𝘦 𝘍𝘰𝘳 𝘠𝘰𝘶
            </p>
    </div>
</section>    

<section class="page relative w-full h-auto" id="fullwide1">
<a href="<?= base_url('products') ?>" class="block w-full h-full">
<img alt="Secretgarden.id Products" class="aspect-video w-[100%] h-[200px] md:h-[700px] object-cover"  loading="lazy" src="<?= base_url('assets/SGV/home/home3.jpg') ?>" />
</a>   
</section>

<div id="trigger"></div>
<section class="page flex  h-full w-full flex-col md:flex-row items-center justify-center bg-white" id="sample-category">
    <div class="w-full md:w-1/2 flex justify-center items-center p-4" style="perspective: 1500px;">
        <div class="tilt-parallax max-w-md rounded-lg overflow-hidden" id="tiltSample">
            <img alt="Sample SGV beauty device product image" class="w-full h-full object-cover" loading="lazy" src="<?= base_url('assets/SGV/careso.png') ?>" />
        </div>
    </div>
    <div class="w-full md:w-1/2">
        <div class="relative overflow-hidden rounded-lg shadow-lg">
            <div class="flex transition-transform duration-500 ease-in-out" id="categorySlider" style="width: 100%;">
                <a href="#product1" class="w-full flex-shrink-0 object-cover"><img alt="Category image of SGV device" class="w-full object-scale-down flex-shrink-0 object-cover" height="100vh" loading="lazy" src="<?= base_url('assets/SGV/slide1.jpg') ?>" width="100vh"/></a>
                <a href="#product2" class="w-full flex-shrink-0 object-cover"><img alt="Category image of SGV skincare product" class="w-full object-scale-down flex-shrink-0 object-cover" height="100vh" loading="lazy" src="<?= base_url('assets/SGV/slide2.jpg') ?>" width="100vh"/></a>
                <a href="#product3" class="w-full flex-shrink-0 object-cover"><img alt="Category image of SGV beauty device accessories" class="w-full object-scale-down flex-shrink-0 object-cover" height="100vh" loading="lazy" src="<?= base_url('assets/SGV/slide3.jpg') ?>" width="100vh"/></a>
                <a href="#product4" class="w-full flex-shrink-0 object-cover"><img alt="Category image of SGV luxury skincare set" class="w-full object-scale-down flex-shrink-0 object-cover" height="100vh" loading="lazy" src="<?= base_url('assets/SGV/slide4.jpeg') ?>" width="100vh"/></a>
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

<section class="page relative w-full h-[300px]">
    <img alt="Secretgarden.id" class="w-full h-auto object-cover"  loading="lazy" src="<?= base_url('assets/SGV/home/home1.jpg') ?>" />
</section>

<section class="page relative w-full h-auto">
    <img alt="Secretgarden.id About" class="w-full object-cover max-h-[700px]" height="700" loading="lazy" src="<?= base_url('assets/SGV/fragrance.jpeg') ?>" width="1920"/>
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-white/70 to-white flex flex-col justify-center items-center text-center px-6 md:px-12">
        <h1 class="text-4xl md:text-6xl font-playfair font-bold text-gray-900 max-w-4xl leading-tight mb-6">
            About Us
        </h1>
        <p class="max-w-2xl text-gray-700 text-lg md:text-xl mb-8">
            Experience the Essence of Bali with Secret Garden Founded in Bali in 2016, Secret Garden offers natural body and wellness products inspired by the island’s rich botanical heritage. Our mission is to bring the calm and spirit of Bali into your daily rituals through sustainably crafted, plant-based skincare and aromatherapy. Each product reflects our deep respect for nature and commitment to holistic well-being.
        </p>
    </div>
</section>


<script>
  const slides = document.querySelectorAll("#slide-main > div");
  const durations = [28000, 12000, 10000, 8000]; 
  let current = 0;

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.classList.toggle("opacity-100", i === index);
      slide.classList.toggle("opacity-0", i !== index);
    });

    setTimeout(() => {
      current = (index + 1) % slides.length;
      showSlide(current);
    }, durations[index] || 8000);
  }
  showSlide(current);
</script>

<?= $this->include('partials/footer') ?>
