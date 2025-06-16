<?php echo view('partials/header'); ?>
<style>
.card {
  position: relative;
  top: 2em;
  width: 12.5em;
  height: 7.5em;
  background: white;
  transition: .4s ease-in-out;
  border-radius: 15px;
  box-shadow: rgba(0, 0, 0, 0.07) 0px 1px 1px, rgba(0, 0, 0, 0.07) 0px 2px 2px, rgba(0, 0, 0, 0.07) 0px 4px 4px, rgba(0, 0, 0, 0.07) 0px 8px 8px, rgba(0, 0, 0, 0.07) 0px 16px 16px;
  overflow: hidden;
}

.heading {
  position: relative;
  color: black;
  font-weight: bold;
  font-size: 1.1em;
  padding-top: 1em;
  padding-left: 1em;
  transition: .4s ease-in-out;
}

.details {
  position: relative;
  color: black;
  font-size: 0.6em;
  padding-top: 1.5em;
  padding-left: 1em;
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
  padding-left: 6.9em;
  padding-right: 6.9em;
  padding-top: 0.8em;
  padding-bottom: 0.85em;
  border-radius: 10px;
  left: 2.6em;
  top: 14.8em;
  transition: .4s ease-in-out;
  font-weight: bold;
}

.btndetail:hover {
  background-color: #EDDEC9;
  cursor: pointer;
}

.img-hover {
  position: relative;
  top: -4em;
  left: 3em;
  width: 70px;
  height: 70px;
  transition: .4s ease-in-out;
}

.card:hover {
  width: 12.5em;
  height: 23em;
  transform: translateY(1.25em);
}

.card:hover + .img-hover {
  transform: rotateX(360deg);
  height: 100px;
  width: 100px;
  left: 0;
  top: -18em;
}


.card:hover .heading {
  transform: translateY(7em) translateX(2.3em);
}

.card:hover .details {
  flex-item: center;
  animation: fadein 2s;
  text-align: center;
  padding-right: 7em;

  transform: translateY(13em) translateX(3.5em);
  
}

</style>
<section class="page relative w-full h-auto">
    <img alt="Elegant Karmakamet style fragrance display" class="w-full object-cover max-h-[700px]" height="700" loading="lazy" src="<?= base_url('assets/SGV/fragrance.jpeg') ?>" width="1920"/>
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
      <?php foreach ($images as $img): ?>
        <div class="flex-shrink-0 w-[240px] p-2 flex flex-col snap-center">
          <div class="main">
          <div class="card">
            <div class="heading"><?= esc($img['name']) ?></div>
            <div class="details"><?= esc($img['desc']) ?></div>
              <a href="<?= site_url('category/' . str_replace(' ', '-', $img['name'])) ?>" class="btndetail overflow-hidden text-center">Check</a>
          </div>
          <img src="<?= base_url('assets/SGV/Category/' . str_replace(' ', '-', $img['name']).'/'. $img['img']) ?>" alt="<?= esc($img['name']) ?>" class="img-hover h-[50px] object-cover rounded mx-auto">
          </svg>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="page relative w-full h-[480px]">
    <img alt="Full width image of SGV luxury spa treatment room"  class="w-full h-auto object-cover"  loading="lazy" src="<?= base_url('assets/SGV/fragrance.jpeg') ?>" />
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
        id="parallax-image"
        alt="Aromatic oil set"
        class="w-full h-auto max-h-[40vh] object-contain"
        src="<?= base_url("assets/SGV/cr1.png") ?>"
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
          <a href="<?= site_url('products/' . strtolower(str_replace(' ', '-', $product['name']))) ?>">
            <div class="product-card w-[300px] rounded-md shadow-xl overflow-hidden z-[100] relative cursor-pointer snap-start shrink-0 py-8 px-6 bg-white flex flex-col items-center justify-center gap-3 transition-all duration-300 group">
                <div class="para uppercase text-center leading-none z-40">
                  <p
                    style="-webkit-text-stroke: 1px rgb(207, 205, 205);
                              -webkit-text-fill-color: transparent;"
                    class="z-10 font-bold text-lg -mb-5 tracking-wider text-gray-500"
                  >
                    <?=$category['name']?>
                </p>
                  <p class="font-bold text-xl tracking-wider text-[#495c48] z-30">
                    <?=$category['name']?>
                  </p>
                </div>
                <div
                  class="w-[180px] aspect-square relative z-20 after:absolute after:h-1 after:w-full after:opacity-0 after:bg-[#7b956a] after:top-8 after:left-0 after:group-hover:opacity-100 after:translate-x-1/2 after:translate-y-1/2 after:-z-20 after:group-hover:w-full after:transition-all after:duration-300 after:group-hover:origin-right after:group-hover:-translate-x-1/2 group-hover:translate-x-1/2 transition-all duration-300"
                >
                    <img src="<?= base_url('assets/SGV/Category/'.str_replace(' ', '-', $category['name']) . '/'. str_replace(' ', '-', $product['name']).'/'. $product['img']) ?>" alt="<?= esc($product['name']) ?>" class="h-[240px] aspect-square object-cover rounded-t">
                    <linearGradient
                      y2="0"
                      y1="512"
                      x2="256"
                      x1="256"
                      gradientUnits="userSpaceOnUse"
                      id="id0"
                    >
                      <stop stop-color="#495c48" offset="0"></stop>
                      <stop stop-color="#9db891" offset=".490196"></stop>
                      <stop stop-color="#7b956a" offset="1"></stop>
                    </linearGradient>
                    <g id="Layer_x0020_1">
                      <path
                        fill="url(#id0)"
                        d="m310 512h-108c-16.4 0-31.9-6.5-43.7-18.3s-18.3-27.3-18.3-43.7v-261c0-29.8 24.2-54 54-54h123c30.3 0 55 24.2 55 54v261c0 16.4-6.5 31.9-18.3 43.7s-27.3 18.3-43.7 18.3zm-90-439v-34c0-23 9.9-39 24-39h24c13.5 0 24 17.1 24 39v34zm-33 48.36v-27.36c0-3.9 3.1-7 7-7h124c3.9 0 7 3.1 7 7v27.46c-2.63-.3-5.3-.46-8-.46h-123c-2.36 0-4.7.12-7 .36zm69 71.6c-33.94 54.87-38.25 93.49-29.7 116.4 5.82 15.59 17.8 23.39 29.7 23.39s23.88-7.8 29.7-23.39c8.55-22.91 4.24-61.53-29.7-116.4zm-42.77 121.27c-10.32-27.64-5.23-73.83 36.85-137.91.52-.84 1.22-1.57 2.09-2.14 3.22-2.12 7.54-1.22 9.65 1.99 42.17 64.16 47.27 110.4 36.95 138.06-8.09 21.68-25.39 32.52-42.77 32.52s-34.68-10.84-42.77-32.52zm102.27 126.87c-2.8 0-5.9-.4-9.3-1.3-.1 0-.1 0-.2 0-14-4.2-21.8-18.1-17.7-31.7.1-.4.3-.8.4-1.1.2-.4.4-.8.6-1.3.8-1.9 1.9-4.3 3.8-6.5 24.5-50.8 21.9-118.2 21.9-118.9-.1-3.5 2.3-6.5 5.7-7.2s6.8 1.3 7.9 4.6c3.3 9.6 11.2 41 15.2 73.2 5.1 42 1.8 69.7-9.9 82.2-3.7 4-9.6 8-18.4 8zm-5.6-14.8c8 2.2 11.7-.5 13.7-2.7 12.5-13.4 9.3-57.7 2.8-94.5-2.9 23.5-8.9 51.9-21.2 76.9-.3.7-.8 1.3-1.3 1.9-.6.6-1.3 2.1-1.8 3.4-.2.4-.4.8-.5 1.2-1.5 5.9 2.1 11.9 8.3 13.8zm-113.4 14.8c-8.9 0-14.8-4-18.4-7.9-11.7-12.5-15-40.2-9.9-82.2 3.9-32.2 11.8-63.6 15.2-73.2 1.1-3.3 4.5-5.2 8-4.6 3.4.7 5.8 3.8 5.6 7.3 0 .7-3.5 68 21.8 118.6 1.9 2.2 3 4.7 3.9 6.6.2.5.4.9.6 1.3s.3.7.4 1.1c4.1 13.6-3.7 27.5-17.7 31.7-.1 0-.1 0-.2 0-3.4.9-6.5 1.3-9.3 1.3zm-11.2-110.6c-6.3 36.5-9.3 79.8 3.1 93.1 2 2.2 5.7 4.8 13.7 2.7 6.3-1.9 9.9-7.9 8.4-13.8-.2-.4-.4-.8-.5-1.2-.5-1.2-1.2-2.7-1.8-3.4-.5-.5-1-1.1-1.3-1.8-12.7-24.5-18.7-52.3-21.6-75.6z"
                      ></path>
                    </g>
                  </svg>
                  <div
                    class="tooltips absolute top-0 left-0 -translate-x-[150%] p-2 flex flex-col items-start gap-10 transition-all duration-300 group-hover:-translate-x-full"
                  >
                    <p
                      class="text-[#7b956a] font-semibold text-xl uppercase group-hover:delay-1000 transition-all opacity-0 group-hover:opacity-100 group-hover:transition-all group-hover:duration-500"
                    >
                      <?= esc($product['name']) ?>
                    </p>
                    <ul class="flex flex-col items-start gap-2">
                      <li
                        class="inline-flex gap-2 items-center justify-center group-hover:delay-200 transition-all opacity-0 group-hover:opacity-100 group-hover:transition-all group-hover:duration-500"
                      >
                        <svg
                          stroke-linejoin="round"
                          stroke-linecap="round"
                          stroke-width="3"
                          class="stroke-[#495c48]"
                          stroke="#000000"
                          fill="none"
                          viewBox="0 0 24 24"
                          height="10"
                          width="10"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                          <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        <p class="text-xs font-semibold text-[#495c48]">Hydration</p>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>

          </a>
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
