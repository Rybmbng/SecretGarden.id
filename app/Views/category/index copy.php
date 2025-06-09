<?= view('partials/header') ?>

<section class="bg-[#f4e4cc] text-white h-[50vh] relative overflow-hidden">
  <div class="max-w-7xl mx-auto px-6 py-20 h-full flex flex-col md:flex-row items-center justify-between gap-10">
    
    <div class="max-w-xl text-black text-center md:text-left z-10 flex flex-col justify-center">
        <h2 class="font-extrabold text-xl md:text-2xl leading-tight mb-4"><?= $category['title'] ?></h2>
        <p class="text-xs xs:text-base leading-relaxed mb-6">
          <?= $category['description'] ?>
        </p>
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
  <div class="overflow-hidden w-full max-w-7xl mx-auto">
    <div id="product-slider-track"
         class="flex space-x-6 transition-transform duration-700 ease-in-out will-change-transform md:justify-center"
         style="padding-left: calc((100vw - 240px) / 2);"
    >
      <?php foreach ($category['products'] as $product): ?>
        <a href="<?= base_url('product/' . $product['slug']) ?>" class="block">
            <div class="flex-shrink-0 w-[240px] p-2 flex flex-col snap-center bg-white ">
                <img src="<?= base_url('assets/sgv/' . $product['img']) ?>" alt="<?= $product['name'] ?>" class="h-[240px] object-cover rounded-t">
                <div class="p-4 text-center">
                    <h3 class="font-semibold text-lg"><?= $product['name'] ?></h3>
                    <p class="text-primary font-bold mt-2"><?= $product['price'] ?></p>
                </div>
            </div>
        </a>

      <?php endforeach; ?>
    </div>
  </div>
</section>

<script>
  const track = document.getElementById("product-slider-track");
  const items = track.querySelectorAll("div.flex-shrink-0");
  const itemWidth = 240 + 24;
  let index = 0;

  function autoplay() {
    if (window.innerWidth >= 768) return;
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
</script>

<?= view('partials/footer') ?>
