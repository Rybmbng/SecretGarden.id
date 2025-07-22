<?= view('partials/header'); ?>

<style>
  .fade-in-up {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 1s ease-out, transform 1s ease-out;
  }

  .fade-in-up.visible {
    opacity: 1;
    transform: translateY(0);
  }

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
</style>


<section class="page relative h-[100vh] w-[100%] aspect-video overflow-hidden fade-in-up" id="slide-main">
  <?php foreach ($sliders as $index => $slide): ?>
    <div class="absolute inset-0 w-auto h-auto transition-opacity duration-1000 ease-in-out <?= $index === 0 ? 'opacity-100' : 'opacity-0' ?>" data-index="<?= $index ?>">
      <?php if ($slide['type'] === 'video'): ?>
        <video loading="lazy" autoplay loop muted playsinline class="md:aspect-video w-auto h-[100vh] md:h-[auto] md:w-full object-fit" loading="lazy">
          <source src="<?= base_url($slide['src']) ?>" type="video/mp4" />
        </video>
      <?php elseif ($slide['type'] === 'image'): ?>
        <img src="<?= base_url($slide['src']) ?>" alt="<?= esc($slide['alt']) ?>" class="md:aspect-video w-auto h-auto md:w-full md:h-auto object-fit" loading="lazy" />
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</section>

<section class="page w-full relative h-auto text-center fade-in-up flex justify-center items-center select-none">
  <div class="w-full aspect-video h-[450px] md:h-[600px] flex flex-col justify-center items-center bg-gradient-to-b from-transparent to-white">
    <p class="text-black-700 text-2xl md:text-6xl flex justify-center items-center text-center select-none">
      𝘐𝘯𝘴𝘱𝘪𝘳𝘦𝘥 𝘣𝘺 <b class="ml-[0.5rem]"> 𝘌𝘢𝘳𝘵𝘩</b>, 𝘔𝘢𝘥𝘦 𝘍𝘰𝘳 <b class="ml-[0.5rem]"> 𝘠𝘰𝘶</b>
    </p>
  </div>
</section>

<section class="page relative w-full h-auto fade-in-up">
  <a href="<?= base_url('products') ?>" class="block w-full h-full">
    <img alt="Secretgarden.id Products" class="aspect-video w-full h-[300px] md:h-[700px] object-fit" loading="lazy" src="<?= base_url('assets/SGV/home/home3.jpg') ?>" />
  </a>
</section>

<section class="page flex w-full h-[800px] md:h-auto flex-col md:flex-row items-center justify-center bg-white fade-in-up">
  <div class="parallax-container h-[100%] w-100 aspect-square md:w-1/2 flex justify-center items-center p-4" id="parallaxBox">
    <a href="<?=base_url('products/').str_replace(" ","-",$mainProduct['pname'])?>" class="parallax-item max-w-md rounded-lg overflow-hidden" id="parallaxItem">
      <div class="flex flex-row items-center w-[100%] object-cover">
        <div class="flex-1 flex flex-col justify-center items-start p-2">
          <h2 class="text-xl font-bold text-gray-900"><?= esc($mainProduct['pname']) ?></h2>
          <p class="text-gray-700"><?= esc($mainProduct['cat_name']) ?></p>
        </div>
        <div class="flex-1 flex justify-center items-center">
          <img alt="<?= $mainProduct['pname'] ?>" class="aspect-square w-auto h-[300px] md:w-[50vh] md:h-[500px] object-cover" loading="lazy"
            src="<?= base_url("assets/SGV/Category/" . strtolower(str_replace(' ', '-', $mainProduct['cat_name'])) . "/" . strtolower(str_replace(' ', '-', $mainProduct['pname'])) . "/" . ($mainProduct['img'] ?? 'default.jpg')) ?>" />
        </div>
      </div>
    </a>
  </div>
  <div class="w-full md:w-1/2 h-100% aspect-square flex justify-center items-center">
    <div class="relative h-[100%] overflow-hidden rounded-lg">
      <div class="flex transition-transform duration-500 ease-in-out" id="categorySlider">
        <?php foreach ($products as $product) : ?>
        <a href="<?=base_url('products/').str_replace(" ","-",$product['pname'])?>" class="w-full flex-shrink-0 flex items-center justify-center">
          <img alt="<?= $product['pname'] ?>" class="aspect-square w-auto h-[300px]  md:w-auto md:h-[100%] object-cover mx-auto" loading="lazy"
            src="<?= base_url("assets/SGV/Category/" . strtolower(str_replace(' ', '-', $product['cat_name'])) . "/" . strtolower(str_replace(' ', '-', $product['pname'])) . "/" . strtolower(str_replace(' ', '-', $product['variant_name'])) . "/" . ($product['img'] ?? 'default.jpg')) ?>" />
        </a>
        <?php endforeach; ?>
      </div>
      <button aria-label="Previous" class="text-2xl absolute top-1/2 left-1 -translate-y-1/2 rounded-full" id="prevCategory">
        <i class="fas fa-chevron-left"></i>
      </button>
      <button aria-label="Next" class="text-2xl absolute top-1/2 right-1 -translate-y-1/2 rounded-full" id="nextCategory">
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>
  </div>
</section>

<section class="page relative w-full h-auto fade-in-up">
  <a href="<?= base_url('products') ?>" class="block w-full h-full">
    <img alt="Secretgarden.id Products" class="aspect-video w-full h-[300px] md:h-[700px] object-fit" loading="lazy" src="<?= base_url('assets/SGV/home/banner2.jpg') ?>" />
  </a>
</section>
<!-- 
<section class="page flex w-full h-auto md:h-[550px] md:h-auto flex-col md:flex-row items-center justify-center bg-white fade-in-up">
  <div class="w-full md:w-1/2 h-auto md:h-[550px] aspect-square flex justify-center items-center">
    <a href="<?= base_url('products') ?>" class="block w-full h-full">
    <img alt="Secretgarden.id Products" class="aspect-video w-auto h-full md:h-auto object-cover" loading="lazy" src="<?= base_url('assets/SGV/home/banner2.jpg') ?>" />
  </a>
  </div>
  <div class="parallax-container w-full h-auto md:h-[550px] md:w-1/2 h-auto aspect-square flex justify-center items-center" id="parallaxBox">
    <a href="<?=base_url('products/').str_replace(" ","-",$mainProduct['pname'])?>" class="parallax-item max-w-md rounded-lg overflow-hidden" id="parallaxItem">
      <div class="flex flex-row items-center w-[100%] object-cover">
        <div class="flex-1 flex flex-col justify-center items-start p-2">
          <h2 class="text-xl font-bold text-gray-900"><?= esc($mainProduct['pname']) ?></h2>
          <p class="text-gray-700"><?= esc($mainProduct['cat_name']) ?></p>
        </div>
        <div class="flex-1 flex justify-center items-center">
          <img alt="<?= $mainProduct['pname'] ?>" class="aspect-square w-auto h-[300px] md:w-[50vh] md:h-[300px] object-cover" loading="lazy"
            src="<?= base_url("assets/SGV/Category/" . strtolower(str_replace(' ', '-', $mainProduct['cat_name'])) . "/" . strtolower(str_replace(' ', '-', $mainProduct['pname'])) . "/" . ($mainProduct['img'] ?? 'default.jpg')) ?>" />
        </div>
      </div>
    </a>
  </div>
</section> -->


<section class="page relative h-[80vh] md:h-[800px] w-full aspect-video overflow-hidden fade-in-up">
  <div class="absolute inset-0 w-auto h-auto transition-opacity duration-1000 ease-in-out opacity-70">
    <video loading="lazy" autoplay loop muted playsinline  class="md:aspect-video w-auto h-full md:h-[auto] md:w-full object-fit">
      <source src="<?= base_url('assets/SGV/video/slide2.mp4') ?>" type="video/mp4" />
    </video>
  </div>
</section>

<section class="page relative w-full h-auto fade-in-up select-none">
   <h1 class="text-2xl md:text-4xl font-playfair font-bold text-center justify-center items-center text-gray-900 leading-tight mt-5 select-none">
      Experience the Essence of Bali with Secret Garden
    </h1>
  <div class="fix inset-0 mt-10 mb-10 flex flex-col text-center justify-center items-center  px-6 md:px-6">
    <p class="max-w-2xl md:max-w-6xl text-white-100 text-xl md:text-4xl mb-8 text-justify justify-center items-center select-none">
      Founded in Bali in 2016, Secret Garden offers natural body and wellness products inspired by the island’s rich botanical heritage. Our mission is to bring the calm and spirit of Bali into your daily rituals through sustainably crafted, plant-based skincare and aromatherapy. Each product reflects our deep respect for nature and commitment to holistic well-being.
    </p>

   
  </div>
</section>


<script>
  const box = document.getElementById('parallaxBox');
  const item = document.getElementById('parallaxItem');

  box.addEventListener('mousemove', (e) => {
    const rect = box.getBoundingClientRect();
    const x = e.clientX - rect.left; 
    const y = e.clientY - rect.top;  

    const centerX = rect.width / 2;
    const centerY = rect.height / 2;

    const deltaX = (x - centerX) / centerX;
    const deltaY = (y - centerY) / centerY;

    const rotateX = deltaY * 10; 
    const rotateY = deltaX * -10;

    item.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.05)`;
  });

  box.addEventListener('mouseleave', () => {
    item.style.transform = 'rotateX(0deg) rotateY(0deg) scale(1)';
  });
</script>

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

  // Fade-in on scroll
  const faders = document.querySelectorAll('.fade-in-up');
  const appearOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -100px 0px"
  };

  const appearOnScroll = new IntersectionObserver(function(entries, observer) {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      entry.target.classList.add('visible');
      observer.unobserve(entry.target);
    });
  }, appearOptions);

  faders.forEach(fader => {
    appearOnScroll.observe(fader);
  });
</script>


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
