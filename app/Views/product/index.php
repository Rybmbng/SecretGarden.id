<?php echo view('partials/header'); 

function slugify($string)
{
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
}
?>

<style>
  .section{
    overflow: hidden;
  }
  .fade-in-up {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 1s ease-out, transform 1s ease-out;
  }

  .fade-in-up.visible {
    opacity: 1;
    transform: translateY(0);
  }

.card {
  position: relative;
  align-items: center;
  top: 1.5em;
  width: 20em;
  height: 15em;
  background: white;
  transition: .4s ease-in-out;
  border-radius: 15px;
  box-shadow: rgba(0, 0, 0, 0.07) 0px 1px 1px, rgba(0, 0, 0, 0.07) 0px 2px 2px, rgba(0, 0, 0, 0.07) 0px 4px 4px, rgba(0, 0, 0, 0.07) 0px 8px 8px, rgba(0, 0, 0, 0.07) 0px 16px 16px;
  overflow: hidden;

}

.heading {
  align-items:center;
  position: relative;
  color: black;
  font-weight: bold;
  font-size: 1.5em;
  padding-top: 1em;
  padding-left: 4em;
  transition: .4s ease-in-out;
}

.details {  
  max-width:200px;
  flex-item: center;
  animation: fadein 2s;
  text-align: left;
  padding: 20px;
  color: black;
  font-weight:light;
  font-size: 0.8em;
  padding-top: 1.5em;
  padding-left: auto;
  transition: .4s ease-in-out;
}

.price {
  position: relative;
  color: black;
  font-weight: bold;
  font-size: 0.8em;
  padding-top: 1.5em;
  padding-left: 1.5em;
  top: 9.6em;
  left: 5em;
  transition: .4s ease-in-out;
}

.btndetail {
  position: relative;
  border: none;
  outline: none;
  background-color: black;
  color: white;
  font-size: 0.6em;
  padding-left: 10em;
  padding-right: 10em;
  padding-top: 0.8em;
  padding-bottom: 1em;
  border-radius: 10px;
  top: 14.8em;
  left: 5em;
  transition: .4s ease-in-out;
  font-weight: bold;
}

.btndetail:hover {
  background-color: #EDDEC9;
  cursor: pointer;
}

.img-hover {
  position: relative;
  top: -10em;
  left: 5em;
  width: 250px;
  height: 250px;
  transition: .4s ease-in-out;
}

.card:hover {
  width: 20em;
  height: 25em;
  transform: translateY(1.25em);
}

.card:hover + .img-hover {
  transform: rotateX(360deg);
  height: 150px;
  width: 150px;  
  margin-left:0;
  top: -23em;
}


.card:hover .heading {
  transform: translateY(5em) translateX(0em);
}

.card:hover .details {
  max-width:100%;
  flex-item: center;
  animation: fadein 3s;
  text-align: center;
  padding-right: 6em;
  transform: translateY(8em) translateX(2em);
  
  animation: fadeout 3s;

}
.parallax-hover {
    transition: transform 0.5s ease;
    will-change: transform;
    cursor: pointer;
  }

  

</style>

<section class="page relative w-full h-auto fade-in-up">
  <img alt="Elegant Karmakamet style fragrance display with bottles and candles on wooden table in warm ambient light" class="w-full object-cover max-h-[700px]" height="700" loading="lazy" src="<?= base_url('assets/SGV/fragrance.jpeg') ?>" width="1920"/>
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

<section class="relative w-full h-[400px] px-4 md:px-12 flex items-center justify-center fade-in-up">
  <div class="overflow-hidden w-full max-w-7xl mx-auto">
    <div id="slider-track"
         class="flex  space-x-10 transition-transform duration-700 ease-in-out will-change-transform md:justify-center mx-auto"
         style="padding-left: calc((100vw - 240px) / 2);"
    >
      <?php foreach ($images as $catImg => $img): ?>
        <?php $imgSlug = slugify($img['name']); ?>
        <div class="product-slider-track-<?= $catImg ?> flex-shrink-0 w-[240px] p-2 flex flex-col mr-[200px] snap-center items-center px-4">
          <div class="main">
            <div class="card">
              <div class="heading"><?= esc($img['name']) ?></div>
              <div class="details"><?= esc($img['desc']) ?></div>
              <a href="<?= site_url('category/' . str_replace(' ', '-', $img['name'])) ?>" class="btndetail overflow-hidden text-center">Check</a>
            </div>
            <img src="<?= base_url('assets/SGV/Category/' . $imgSlug . '/' . $img['img']) ?>" alt="Product image of <?= esc($img['name']) ?> category showing a detailed view of the product packaging and design" class="img-hover object-cover rounded mx-auto parallax-hover">
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="page relative w-full h-[480px] fade-in-up">
  <img alt="Full width image of SGV luxury spa treatment room with soft lighting and elegant decor"  class="w-full h-auto object-cover"  loading="lazy" src="<?= base_url('assets/SGV/fragrance.jpeg') ?>" />
</section>

<?php foreach ($categories as $catIndex => $category): ?>
<section class="bg-[#f4e4cc] text-white h-[50vh] relative overflow-hidden">
  <div class="max-w-7xl mx-auto px-6 py-20 h-full flex flex-col md:flex-row items-center justify-between gap-10">
    
    <!-- TEKS -->
    <div class="max-w-xl text-black text-center md:text-left z-10 flex flex-col justify-center" id="#<?= esc($category['name']) ?>">
      <h2 class="font-extrabold text-xl md:text-2xl leading-tight mb-4"><?= esc($category['name']) ?></h2>
      <p class="text-xs xs:text-base leading-relaxed mb-6">
       <?= esc($category['description']) ?>
      </p>

      <a href="<?= site_url('category/' . strtolower(str_replace(' ', '-', $category['name']))) ?>" class="inline-block border border-black rounded-md px-3 py-2 text-xs xs:text-base hover:bg-white hover:text-[#f4e4cc] transition">
        See all
      </a>
    </div>

    <div class="flex-shrink-0 max-w-lg w-full h-full z-0 flex items-center justify-center">
      <img
        id="parallax-image-<?= $catIndex ?>"
        alt="Aromatic oil set with glass bottles and natural ingredients on wooden surface"
        class="w-full h-auto max-h-[40vh] object-contain parallax-hover"
        src="<?= base_url("assets/SGV/cr1.png") ?>"
      />
    </div>
  </div>
</section>
<section class="relative w-full min-h-[400px] md:min-h-[600px] px-4 md:px-12 flex flex-col items-center justify-center mb-12 fade-in-up">
  <div class="relative h-full w-full max-w-7xl mx-auto flex items-center justify-center">
    <!-- Left Arrow -->
    <button onclick="slideLeft(<?= $catIndex ?>)" class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white/80 p-2 rounded-full shadow-md hover:bg-white hidden md:block">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
    </button>

    <!-- Product Slider Track -->
    <div id="product-slider-track-<?= $catIndex ?>"
         class="flex space-x-6 transition-transform duration-700 ease-in-out will-change-transform md:justify-center overflow-x-auto scrollbar-hide mx-auto py-4"
         style="padding-left: calc((100vw - 240px) / 2);"
    >
      <?php foreach ($category['products'] as $product): ?>
        <div class="flex-shrink-0 w-[240px] bg-white rounded-lg shadow-lg p-4 flex flex-col items-center justify-between group transition-all duration-300 hover:shadow-2xl hover:scale-105">
          <div class="w-full flex flex-col items-center">
            <div class="text-xs uppercase tracking-widest text-[#7b956a] font-semibold mb-1"><?= esc($category['name']) ?></div>
            <div class="font-bold text-base text-[#495c48] text-center mb-2"><?= esc($product['name']) ?></div>
            <div class="w-[180px] h-[180px] flex items-center justify-center mb-3">
              <img src="<?= base_url('assets/SGV/Category/'.strtolower(str_replace(' ', '-', $category['name'])) . '/'. strtolower(str_replace(' ', '-', $product['name'])).'/'. $product['img']) ?>"
                   alt="Product image of <?= esc($product['name']) ?>"
                   class="object-cover rounded-md w-full h-full parallax-hover transition-all duration-300 group-hover:scale-105" />
            </div>
            <div class="text-xs text-gray-500 text-center mb-3 line-clamp-3">
              <?= isset($product['desc']) ? esc($product['desc']) : '' ?>
            </div>
          </div>
          <a href="<?= site_url('products/' . strtolower(str_replace(' ', '-', $product['name']))) ?>"
             class="mt-auto inline-block bg-[#495c48] text-white px-4 py-2 rounded-md text-xs font-semibold uppercase tracking-wide hover:bg-[#7b956a] transition">
            Detail
          </a>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Right Arrow -->
    <button onclick="slideRight(<?= $catIndex ?>)" class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white/80 p-2 rounded-full shadow-md hover:bg-white hidden md:block">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
    </button>
  </div>
</section>
<?php endforeach; ?>

<script>
  const parallaxImages = document.querySelectorAll('.parallax-hover');

  parallaxImages.forEach(img => {
    let currentY = 0;
    let targetY = 0;

    function smoothParallax() {
      currentY += (targetY - currentY) * 0.1;
      img.style.transform = `translateY(${currentY}px) scale(1)`;
      requestAnimationFrame(smoothParallax);
    }

    window.addEventListener('scroll', () => {
      const rect = img.getBoundingClientRect();
      const windowHeight = window.innerHeight;
      if (rect.top < windowHeight && rect.bottom > 0) {
        const scrollPercent = 1 - (rect.top / windowHeight);
        targetY = scrollPercent * 20;
      } else {
        targetY = 0;
      }
    });

    img.addEventListener('mouseenter', () => {
      img.style.transition = 'transform 0.5s ease';
      img.style.transform = `translateY(${targetY - 15}px) scale(1.05)`;
    });
    img.addEventListener('mouseleave', () => {
      img.style.transition = 'transform 0.5s ease';
      img.style.transform = `translateY(${targetY}px) scale(1)`;
    });

    smoothParallax();
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
  const track = document.getElementById("slider-track");
  const items = track.querySelectorAll("div.flex-shrink-0");
  const itemWidth = 240 + 24;
  let index = 0;

  

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

<script>
  const sliderPositions = {};

  function slideLeft(catImg) {
    const track = document.getElementById(`product-slider-track-${catImg}`);
    if (!track) return;

    const itemWidth = 240 + 24;
    sliderPositions[catImg] = (sliderPositions[catImg] || 0) - 1;
    if (sliderPositions[catImg] < 0) sliderPositions[catImg] = 0;

    track.style.transform = `translateX(-${sliderPositions[catImg] * itemWidth}px)`;
  }

  function slideRight(catImg) {
    const track = document.getElementById(`product-slider-track-${catImg}`);
    if (!track) return;

    const items = track.querySelectorAll("div.flex-shrink-0");
    const itemWidth = 240 + 24;
    sliderPositions[catImg] = (sliderPositions[catImg] || 0) + 1;
    if (sliderPositions[catImg] >= items.length - 1) sliderPositions[catImg] = items.length - 1;

    track.style.transform = `translateX(-${sliderPositions[catImg] * itemWidth}px)`;
  }

  function setupSlider(catImg) {
    const track = document.getElementById(`product-slider-track-${catImg}`);
    if (!track) return;

    const items = track.querySelectorAll("div.flex-shrink-0");
    const itemWidth = 240 + 24;
    let index = 0;

    
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
