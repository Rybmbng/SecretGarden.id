<?= view('partials/header'); ?>

<style>
  /* Parallax Effect */
  .parallax-bg {
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
  }
  .parallax-container {
    perspective: 1000px;
    transform-style: preserve-3d;
    overflow: hidden;
  }
  .parallax-item {
    transform: translateZ(0);
    transition: transform 0.3s ease;
  }

  /* Fade-in Animation */
  .fade-in-up {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 1s ease-out, transform 1s ease-out;
  }
  .fade-in-up.visible {
    opacity: 1;
    transform: translateY(0);
  }

  /* Slider Styling */
  #slide-main {
    position: relative;
    width: 100%;
    height: 100vh;
    overflow: hidden;
    cursor: grab;
  }
  .slides-container {
    position: relative;
    width: 100%;
    height: 100%;
  }
  .slide {
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity 1s ease-in-out;
  }
  .slide.active {
    opacity: 1;
    z-index: 2;
  }
  .slide video, .slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .indicator-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: rgba(255,255,255,0.5);
    cursor: pointer;
    transition: background-color 0.3s;
  }
  .indicator-dot.active {
    background-color: white;
  }
</style>

<!-- Hero Slider -->
<section id="slide-main" class="page relative h-screen w-full overflow-hidden fade-in-up">
  <div class="slides-container">
    <?php foreach ($sliders as $i => $slide): ?>
      <div class="slide <?= $i === 0 ? 'active' : '' ?>"
           data-duration="<?= esc($slide['duration'] ?? 8000) ?>"
           data-src-d="<?= base_url('assets/SGV/Page/Home/'.$slide['srcD']) ?>"
           data-src-m="<?= base_url('assets/SGV/Page/Home/'.$slide['srcM']) ?>">
      </div>
    <?php endforeach; ?>
  </div>
  <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
    <?php foreach ($sliders as $i => $slide): ?>
      <span class="indicator-dot <?= $i === 0 ? 'active' : '' ?>" data-dot="<?= $i ?>"></span>
    <?php endforeach; ?>
  </div>
</section>

<!-- Slogan Section -->
<section class="page w-full relative h-auto text-center fade-in-up flex justify-center items-center select-none">
  <div class="w-full aspect-video h-[450px] md:h-[600px] flex flex-col justify-center items-center bg-gradient-to-b from-transparent to-white">
    <p class="text-gray-800 text-2xl md:text-6xl text-center">
      𝘐𝘯𝘴𝘱𝘪𝘳𝘦𝘥 𝘣𝘺 <b class="ml-2">𝘌𝘢𝘳𝘵𝘩</b>, 𝘔𝘢𝘥𝘦 𝘍𝘰𝘳 <b class="ml-2">𝘠𝘰𝘶</b>
    </p>
  </div>
</section>

<!-- Banner 1 -->
<section class="page relative w-full h-auto fade-in-up">
  <a href="<?= base_url('products') ?>" class="block w-full h-full">
    <img alt="Secretgarden.id Products"
         class="aspect-video w-full h-[300px] md:h-[700px] object-cover"
         loading="lazy"
         src="<?= base_url('assets/SGV/home/home3.jpg') ?>" />
  </a>
</section>

<!-- Featured Product + Category Slider -->
<section class="page flex flex-col md:flex-row w-full bg-white fade-in-up">
  <!-- Main Product -->
  <div class="parallax-container w-full md:w-1/2 flex justify-center items-center">
    <a href="<?= base_url('products/'.str_replace(' ','-',$mainProduct['pname'])) ?>"
       class="parallax-item max-w-md rounded-lg overflow-hidden">
      <div class="relative flex flex-col items-center">
        <h2 class="text-xl font-bold text-black"><?= esc($mainProduct['pname']) ?></h2>
        <p class="text-black"><?= esc($mainProduct['cat_name']) ?></p>
        <img alt="<?= esc($mainProduct['pname']) ?>"
             class="aspect-square w-auto h-[300px] md:w-[50vh] md:h-[500px] object-contain"
             loading="lazy"
             src="<?= base_url("assets/SGV/Category/".strtolower(str_replace(' ','-',$mainProduct['cat_name']))."/".strtolower(str_replace(' ','-',$mainProduct['pname']))."/".($mainProduct['img'] ?? 'default.jpg')) ?>" />
      </div>
    </a>
  </div>

  <!-- Category Slider -->
  <div class="w-full md:w-1/2 flex justify-center items-center relative">
    <div class="relative overflow-hidden rounded-lg w-full">
      <div id="categorySlider" class="flex transition-transform duration-500 ease-in-out">
        <?php foreach ($products as $product): ?>
          <a href="<?= base_url('products/'.str_replace(' ','-',$product['pname'])) ?>"
             class="w-full p-10 flex-shrink-0 flex items-center justify-center">
            <img alt="<?= esc($product['pname']) ?>"
                 class="h-[300px] md:h-[500px] object-contain mx-auto"
                 loading="lazy"
                 src="<?= base_url("assets/SGV/Category/".strtolower(str_replace(' ','-',$product['cat_name']))."/".strtolower(str_replace(' ','-',$product['pname']))."/".($product['img'] ?? 'default.jpg')) ?>" />
          </a>
        <?php endforeach; ?>
      </div>
      <button aria-label="Previous"
              class="absolute top-1/2 left-2 -translate-y-1/2 text-2xl rounded-full bg-white/70 hover:bg-white p-2"
              id="prevCategory">
        <i class="fas fa-chevron-left"></i>
      </button>
      <button aria-label="Next"
              class="absolute top-1/2 right-2 -translate-y-1/2 text-2xl rounded-full bg-white/70 hover:bg-white p-2"
              id="nextCategory">
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>
  </div>
</section>

<section class="page relative w-full h-auto fade-in-up">
  <a href="<?= base_url('products') ?>" class="block w-full h-full">
    <img alt="Secretgarden.id Products"
         class="aspect-video w-full h-[300px] md:h-[700px] object-cover"
         loading="lazy"
         src="<?= base_url('assets/SGV/home/banner2.jpg') ?>" />
  </a>
</section>

<section class="page relative h-[80vh] md:h-[800px] w-full aspect-video overflow-hidden fade-in-up">
  <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out opacity-70">
    <video autoplay loop muted playsinline class="w-full h-full object-cover">
      <source src="<?= base_url('assets/SGV/video/slide2.mp4') ?>" type="video/mp4" />
    </video>
  </div>
</section>

<section class="page relative w-full h-auto bg-white py-20">
  <div class="max-w-4xl mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-semibold text-gray-900 leading-tight mb-8">
      Experience the Essence of Bali with <span class="font-bold">Secret Garden</span>
    </h1>

    <div class="space-y-6 text-gray-700">
      <p class="text-lg md:text-xl leading-relaxed">
        Founded in Bali in 2016, <strong>Secret Garden</strong> offers natural body and wellness products inspired by the island’s rich botanical heritage.
      </p>
      <p class="text-lg md:text-xl leading-relaxed">
        Our mission is to bring the calm and spirit of Bali into your daily rituals through sustainably crafted, plant-based skincare and aromatherapy.
      </p>
      <p class="text-lg md:text-xl leading-relaxed">
        Each product reflects our deep respect for nature and commitment to holistic well-being.
      </p>
    </div>

    <div class="mt-10 w-20 h-1 bg-black mx-auto rounded-full"></div>
  </div>
</section>



<script src="<?= base_url("js/home.js"); ?>"></script>

<?= $this->include('partials/footer'); ?>
