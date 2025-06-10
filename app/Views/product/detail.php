<?= view('partials/header') ?>

<!-- Meta SEO -->
<meta property="og:title" content="<?= esc($product['name']) ?>" />
<meta property="og:description" content="<?= esc($product['description']) ?>" />
<?php
$ogImage = !empty($galleryImages) 
    ? base_url("assets/SGV/Category/{$category['name']}/{$product['name']}/{$galleryImages[0]['image_path']}")
    : base_url("assets/default-image.jpg"); 
?>
<meta property="og:image" content="<?= $ogImage ?>" />
<meta name="description" content="<?= esc($product['description']) ?>">

<div class="max-w-7xl mx-auto px-6 py-16 grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">

  <!-- Gallery Thumbnail -->
  <aside class="lg:col-span-1 flex lg:flex-col gap-4 overflow-x-auto lg:overflow-x-visible" id="thumbnail-container">
    <?php foreach ($galleryImages as $img): ?>
      <img
        src="<?= base_url("assets/SGV/Category/{$category['name']}/{$product['name']}/{$img['image_path']}") ?>"
        alt="Thumbnail"
        class="thumb-img w-20 h-20 object-cover rounded-md border border-gray-300 hover:border-black cursor-pointer transition duration-200"
      />
    <?php endforeach; ?>
  </aside>

  <!-- Gambar Utama -->
  <div class="lg:col-span-6 flex justify-center items-center  max-h-[700px] max-w-[700px] mx-auto">
    <div class="w-full border border-gray-300 rounded-md overflow-hidden relative max-h-[700px]">
      <div id="loading-spinner" class="absolute inset-0 flex items-center justify-center bg-white/70 hidden">
        <div class="w-6 h-6 border-2 border-gray-400 border-t-transparent animate-spin rounded-full"></div>
      </div>
      <img
        id="main-image"
        src="<?= base_url("assets/SGV/Category/{$category['name']}/{$product['name']}/" . ($galleryImages[0]['image_path'] ?? 'default.jpg')) ?>"
        class="w-full h-[auto] object-contain transition duration-500 ease-in-out"
        alt="<?= esc($product['name']) ?>"
        data-action="zoom"
      />
    </div>
  </div>

  <!-- Detail Produk -->
  <div class="lg:col-span-5 space-y-8">
    <div>
      <h1 class="font-serif text-4xl font-semibold tracking-tight"><?= esc($product['name']) ?></h1>
      <div class="mt-4 text-gray-800 text-base leading-relaxed whitespace-pre-line">
        <?= esc($product['description']) ?>
      </div>
    </div>

    <!-- Variants -->
    <?php if (!empty($variants)): ?>
      <div>
        <h3 class="uppercase text-sm font-semibold text-gray-600 tracking-wide mb-3">Choose a Variant</h3>
        <div class="flex flex-wrap gap-3">
          <?php foreach ($variants as $variant): ?>
            <button
              class="variant-btn border border-gray-400 px-5 py-2 rounded-full text-sm transition hover:bg-black hover:text-white"
              data-id="<?= esc($variant['id']) ?>"
              data-price="<?= esc($variant['price']) ?>"
              data-desc="<?= esc($variant['desc']) ?>"
              data-images='<?= json_encode(array_map(fn($img) => base_url("assets/SGV/Category/" . str_replace(" ", "-", $category["name"]) . "/" . str_replace(" ", "-", $product["name"]) . "/" . $img), $variant["images"])) ?>'
            >
              <?= esc($variant['name']) ?>
            </button>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

    <!-- Harga dan Aksi -->
    <div class="border-t pt-6">
      <p class="text-xs text-gray-500 uppercase mb-2 font-semibold">Price</p>
      <p id="price-display" class="text-3xl font-serif font-bold">
        <?= esc($variants[0]['price'] ?? $product['price']) ?>
      </p>
      <p id="desc-display" class="mt-2 text-sm italic text-gray-600">
        <?= esc($variants[0]['desc'] ?? '') ?>
      </p>

      <button class="mt-6 bg-black text-white px-6 py-3 rounded-md text-sm uppercase tracking-wide hover:bg-gray-900 transition w-full sm:w-auto">
        Add to Cart
      </button>
    </div>

    <?php if (!empty($sections)): ?>
      <div class="max-w-4xl mx-auto mt-24 space-y-16 px-6">
        <?php foreach ($sections as $type => $sectionList): ?>
          <?php foreach ($sectionList as $section): ?>
            <section>
              <h2 class="text-2xl font-serif font-semibold mb-4"><?= ucwords(esc($section['header'])) ?></h2>
              <div class="space-y-3 text-base text-gray-700 leading-relaxed">
                <?php foreach ($section['details'] as $detail): ?>
                  <p><?= nl2br(esc($detail)) ?></p>
                <?php endforeach; ?>
              </div>
            </section>
          <?php endforeach; ?>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <!-- Rekomendasi Produk -->
    <div class="mt-24 border-t pt-12">
      <h2 class="text-xl font-semibold mb-6">You Might Also Like</h2>
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
        <?php foreach ($products ?? [] as $item): ?>
          <a href="<?= site_url('products/' . $item['slug']) ?>" class="block group">
            <img src="<?= base_url('assets/SGV/Category/' . $category['name'] . '/' . $item['name'] . '/' . $item['name']) ?>" class="w-full h-48 object-cover rounded-md group-hover:opacity-80 transition" />
            <p class="mt-2 text-sm"><?= esc($item['name']) ?></p>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<!-- Sticky Cart (Mobile) -->
<div class="fixed bottom-0 left-0 right-0 bg-white shadow-lg p-4 z-50 lg:hidden flex justify-between items-center">
  <span class="text-xl font-semibold" id="mobile-price"><?= esc($variants[0]['price'] ?? $product['price']) ?></span>
  <button class="bg-black text-white px-5 py-2 rounded-md text-sm">Add to Cart</button>
</div>

<!-- Style tambahan -->
<style>
  .variant-btn.active {
    border-width: 2px;
    border-color: black;
    background-color: black;
    color: white;
  }
  .thumb-img.fade-in {
    animation: fadeIn 0.4s ease-in-out;
  }
  @keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
  }
</style>

<!-- Script Gallery & Variant -->
<script src="https://cdn.jsdelivr.net/npm/medium-zoom@1.0.6/dist/medium-zoom.min.js"></script>
<script>
  mediumZoom('#main-image', { background: '#000' });

  const mainImage = document.getElementById('main-image');
  const priceDisplay = document.getElementById('price-display');
  const descDisplay = document.getElementById('desc-display');
  const mobilePrice = document.getElementById('mobile-price');
  const thumbnails = document.getElementById('thumbnail-container');
  const variantButtons = document.querySelectorAll('.variant-btn');
  const loadingSpinner = document.getElementById('loading-spinner');

  const defaultThumbs = Array.from(thumbnails.querySelectorAll('.thumb-img')).map(img => img.src);

  function setMainImage(src) {
    loadingSpinner.classList.remove('hidden');
    mainImage.onload = () => loadingSpinner.classList.add('hidden');
    mainImage.src = src;
  }

  thumbnails.addEventListener('click', (e) => {
    if (e.target.tagName === 'IMG') {
      setMainImage(e.target.src);
    }
  });

  function updateVariant(button) {
    variantButtons.forEach(btn => btn.classList.remove('active'));
    button.classList.add('active');

    priceDisplay.textContent = button.dataset.price;
    mobilePrice.textContent = button.dataset.price;
    descDisplay.textContent = button.dataset.desc;

    try {
      const images = JSON.parse(button.dataset.images);
      thumbnails.innerHTML = '';
      (images.length ? images : defaultThumbs).forEach(img => {
        const el = document.createElement('img');
        el.src = img;
        el.className = 'thumb-img fade-in w-20 h-20 object-cover rounded-md border border-gray-300 hover:border-black cursor-pointer transition';
        thumbnails.appendChild(el);
      });
      setMainImage(images[0] || defaultThumbs[0]);
    } catch {
      setMainImage(defaultThumbs[0]);
    }
  }

  if (variantButtons.length) updateVariant(variantButtons[0]);
  variantButtons.forEach(btn => btn.addEventListener('click', () => updateVariant(btn)));
</script>

<?= view('partials/footer') ?>
