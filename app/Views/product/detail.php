<?= view('partials/header') ?>

<?php

function slugify($string){ return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string))); }

$ogImage = !empty($galleryImages)
    ? base_url($galleryPath . '/' . strtolower($galleryImages[0]['image_path']))
    : base_url($galleryPath . '/' . strtolower($product['main_images'] ?? 'default.jpg'));

$videoSrc = !empty($product['video']) ? base_url($galleryPath . '/' . strtolower($product['video'])) : null;
?>

<meta property="og:title" content="<?= esc($product['name']) ?>" />
<meta property="og:description" content="<?= esc(strip_tags($product['description'] ?? ($variants[0]['desc'] ?? ''))) ?>" />
<meta property="og:image" content="<?= $ogImage ?>" />
<meta name="description" content="<?= esc(strip_tags($product['description'] ?? ($variants[0]['desc'] ?? ''))) ?>">
<style>
  .glass { backdrop-filter: saturate(180%) blur(16px); background: rgba(255,255,255,.6); }
  .btn-smooth { transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease, color .2s ease; }
  .btn-smooth:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(0,0,0,.08); }
  .btn-smooth:active { transform: translateY(0); }
  .ring-fine { box-shadow: inset 0 0 0 1px rgba(0,0,0,.08); }
  .shimmer { background: linear-gradient(90deg,#eee,#f5f5f5,#eee); background-size: 200% 100%; animation: shimmer 1.2s infinite linear; }
  @keyframes shimmer { 0%{background-position:-200% 0}100%{background-position:200% 0} }
  .thumb-active { outline: 2px solid #111; outline-offset: 2px; }
  .CartBtn { width: 140px; height: 40px; border-radius: 9999px; border: none; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; transition:.2s ease; }
  .CartBtn:active { transform: scale(.98); }
  .scrollbar-hide::-webkit-scrollbar { display: none; }
  .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<div class="max-w-[1200px] mx-auto px-5 md:px-8 py-10 md:py-16 font-sans">

  <nav aria-label="Breadcrumb" class="text-xs md:text-sm text-gray-400 mb-6 md:mb-10">
    <a href="/" class="hover:text-gray-900">Home</a>
    <span class="mx-2">/</span>
    <a href="/category/<?= strtolower(esc(str_replace(" ","-",$category['name']))) ?>" class="hover:text-gray-900"><?= esc($category['name']) ?></a>
    <span class="mx-2">/</span>
    <span class="text-gray-600"><?= esc($product['name']) ?></span>
  </nav>

  <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">

    <aside class="hidden lg:flex lg:col-span-2 flex-col gap-3 max-h-[700px] overflow-y-auto pr-1" id="thumbnail-container" aria-label="Media thumbnails">
      <?php if ($videoSrc): ?>
        <div class="w-20 h-20 rounded-xl ring-fine overflow-hidden cursor-pointer group" data-kind="video" data-src="<?= $videoSrc ?>" tabindex="0" role="button" aria-label="Video thumbnail">
          <video src="<?= $videoSrc ?>#t=0.1" class="w-full h-full object-cover" muted playsinline></video>
        </div>
      <?php endif; ?>
      <?php foreach ($galleryImages as $img): $src = base_url($galleryPath . '/' . strtolower($img['image_path'])); ?>
        <img src="<?= $src ?>" alt="Thumbnail-<?= esc($product['name']) ?>" loading="lazy"
             class="thumb-img w-full h-full object-cover rounded-xl ring-fine cursor-pointer hover:opacity-80" data-kind="image" data-src="<?= $src ?>">
      <?php endforeach; ?>
    </aside>

    <section class="lg:col-span-6 w-full max-w-full mx-auto">
      <div class="relative w-full aspect-square md:aspect-[4/3] bg-white rounded-2xl ring-fine overflow-hidden">
        <div id="media-skeleton" class="flex h-screen inset-0 shimmer"></div>

        <img id="main-image"
             src="<?= base_url($galleryPath . '/' . strtolower($galleryImages[0]['image_path'] ?? 'default.jpg')) ?>"
             alt="Image-<?= esc($product['name']) ?>" class="w-full h-full max-h-screen object-contain opacity-0 transition-opacity duration-300" data-action="zoom">

        <video id="main-video" class="w-full h-full object-contain hidden bg-black" controls playsinline preload="metadata">
          <?php if ($videoSrc): ?><source src="<?= $videoSrc ?>" type="video/mp4"><?php endif; ?>
          Browser Anda tidak mendukung video.
        </video>

        <div class="absolute top-3 right-3 flex items-center gap-2">
          <button id="btn-share" class="btn-smooth glass px-3 py-1.5 rounded-full text-xs text-gray-700">Share</button>
          <button id="btn-wishlist" class="btn-smooth glass px-3 py-1.5 rounded-full text-xs text-gray-700" aria-pressed="false">♥ Wishlist</button>
        </div>
      </div>

      <div class="lg:hidden flex gap-3 mt-4 overflow-x-auto" id="thumbnail-container-mobile">
        <?php if ($videoSrc): ?>
          <div class="min-w-[76px] h-20 rounded-xl ring-fine overflow-hidden cursor-pointer" data-kind="video" data-src="<?= $videoSrc ?>">
            <video src="<?= $videoSrc ?>#t=0.1" class="w-full h-full object-cover" muted playsinline></video>
          </div>
        <?php endif; ?>
        <?php foreach ($galleryImages as $img): $src = base_url($galleryPath . '/' . strtolower($img['image_path'])); ?>
          <img src="<?= $src ?>" alt="Thumbnail" loading="lazy"
               class="w-20 h-20 object-cover rounded-xl ring-fine cursor-pointer" data-kind="image" data-src="<?= $src ?>">
        <?php endforeach; ?>
      </div>
    </section>
    <aside class="lg:col-span-4 space-y-6">
      <header>
        <h1 class="text-3xl md:text-4xl font-semibold tracking-tight text-gray-900 leading-tight"><?= esc($product['name']) ?></h1>
        <p id="desc-display" class="mt-3 text-sm md:text-base text-gray-600 leading-relaxed">
          <?= esc($variants[0]['desc'] ?? ($product['short_desc'] ?? '')) ?>
        </p>
      </header>

      <?php
        $initialPrice = (float)($variants[0]['price'] ?? 0);
        $initialOld   = (float)($variants[0]['old_price'] ?? 0);
        $hasOld       = $initialOld > $initialPrice;
      ?>
      <section class="pt-3">
        <p class="text-[10px] uppercase tracking-[.2em] text-gray-400 mb-1">Price</p>
        <div class="flex items-end gap-3">
          <span id="price-display" class="text-3xl md:text-4xl font-bold text-gray-900">Rp <?= number_format($initialPrice,0,',','.') ?></span>
          <?php if ($hasOld): ?>
            <span id="price-old" class="text-lg md:text-xl text-gray-400 line-through">Rp <?= number_format($initialOld,0,',','.') ?></span>
            <span class="text-xs px-2 py-1 rounded-full bg-black text-white">-<?= number_format(100 - ($initialPrice/$initialOld*100), 0) ?>%</span>
          <?php else: ?>
            <span id="price-old" class="hidden"></span>
          <?php endif; ?>
        </div>
      </section>
      <?php if (!empty($variants)): ?>
      <section>
        <h3 class="uppercase text-[11px] font-semibold text-gray-500 tracking-[.18em] mb-2">Choose a Variant</h3>
        <div class="flex flex-wrap gap-2" id="variants-wrap">
          <?php foreach ($variants as $i => $variant): $variantSlug = slugify($variant['name']); ?>
            <button
              class="variant-btn btn-smooth px-5 py-2 rounded-full ring-fine text-sm text-gray-800 hover:bg-gray-900 hover:text-white <?= $i===0 ? 'bg-gray-900 text-white' : '' ?>"
              data-id="<?= esc($variant['id']) ?>"
              data-idp="<?= esc($product['id']) ?>"
              data-price="<?= esc($variant['price']) ?>"
              data-old="<?= esc($variant['old_price'] ?? '') ?>"
              data-stock="<?= esc($variant['stock'] ?? '') ?>"
              data-desc="<?= esc($variant['desc'] ?? '') ?>"
              data-images='<?= htmlspecialchars(json_encode(array_map(fn($img)=> base_url("assets/SGV/Category/{$categorySlug}/{$productSlug}/{$variantSlug}/".strtolower($img)), $variant["images"] ?? []))) ?>'
              data-video='<?= !empty($variant['video']) ? base_url("assets/SGV/Category/{$categorySlug}/{$productSlug}/{$variantSlug}/" . strtolower($variant['video'])) : '' ?>'
            >
              <?= esc($variant['name']) ?>
            </button>
          <?php endforeach; ?>
        </div>
        <div class="mt-3" id="stock-wrap" style="display: none;">
          <div class="w-full h-1.5 bg-gray-200 rounded-full overflow-hidden">
            <div id="stock-bar" class="h-1.5 bg-gray-900" style="width:30%"></div>
          </div>
          <p class="text-xs text-gray-500 mt-1" id="stock-text">Stock Left: -</p>
        </div>
      </section>
      <?php endif; ?>

      <section class="flex items-center gap-3 pt-2">
        <a id="idcart" href="/cart/add/<?= esc($product['id']) ?>/<?= esc($variants[0]['id'] ?? 0) ?>"
           class="btn-smooth bg-black text-white px-6 py-3 rounded-full text-sm uppercase tracking-wide">Add to Cart</a>
        <button id="btn-buy" class="btn-smooth px-6 py-3 rounded-full text-sm uppercase tracking-wide ring-fine">Buy Now</button>
      </section>

      <?php if (!empty($product['description'])): ?>
      <section class="pt-4 text-[15px] leading-7 text-gray-700">
        <?= $product['description'] ?>
      </section>
      <?php endif; ?>
    </aside>
  </div>
</div>
<div class="max-width-full">
  <?php if(!empty($product['main_videos'])){?>
<section class="page relative h-auto w-full md:h-auto aspect-video overflow-hidden fade-in-up">
  <div class="absolute inset-0 w-auto h-auto transition-opacity duration-1000 ease-in-out opacity-70">
    <video loading="lazy" autoplay loop muted playsinline  class="md:aspect-video w-auto h-full md:h-[auto] md:w-full object-fit">
      <source src="<?= base_url().'assets/SGV/Category/'.$categorySlug.'/'.$productSlug.'/'.$product["main_videos"]?>" type="video/mp4" />
    </video>
  </div>
</section>
<?php } ?>
<section class="mt-16 md:mt-24 border-t pt-10 relative">
  <h2 class="text-lg text-center md:text-xl font-semibold mb-6">You Might Also Like</h2>
  <div class="relative">
    <button id="scrollLeft"
      class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white/80 hover:bg-white p-2 rounded-full shadow hidden">
      &#8592;
    </button>
    <div class="w-full">
      <div id="related-scroll"
           class="flex gap-6 overflow-x-auto snap-x snap-mandatory scrollbar-hide scroll-smooth mx-auto max-w-full">
        <?php foreach (($recommendedProducts ?? []) as $item): $itemSlug = slugify($item['name']); ?>
          <a href="<?= site_url('products/'.$item['slug']) ?>"
             class="group flex-shrink-0 w-[200px] aspect-[4/5] snap-start">
            <div class="w-full aspect-[4/5] bg-white rounded-2xl ring-fine overflow-hidden">
              <img src="<?= base_url('assets/SGV/Category/'.slugify($item['category_name']).'/'.slugify($item['name']).'/'.$item['main_images']) ?>"
                   alt="<?= esc($item['name']) ?>"
                   class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-300"
                   loading="lazy" />
            </div>
            <p class="mt-2 text-center text-sm text-black-700 group-hover:underline truncate">
              <?= esc($item['name']) ?>
            </p>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
    <button id="scrollRight"
      class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white/80 hover:bg-white p-2 rounded-full shadow hidden">
      &#8594;
    </button>
  </div>
</section>

</div>

<script>
  const scrollContainer = document.getElementById("related-scroll");
  const btnLeft = document.getElementById("scrollLeft");
  const btnRight = document.getElementById("scrollRight");

  const scrollStep = 220; // 200px card + gap

  btnLeft.addEventListener("click", () => {
    scrollContainer.scrollBy({ left: -scrollStep, behavior: "smooth" });
  });

  btnRight.addEventListener("click", () => {
    scrollContainer.scrollBy({ left: scrollStep, behavior: "smooth" });
  });

  function updateButtons() {
    const maxScroll = scrollContainer.scrollWidth - scrollContainer.clientWidth;
    btnLeft.classList.toggle("hidden", scrollContainer.scrollLeft <= 0);
    btnRight.classList.toggle("hidden", scrollContainer.scrollLeft >= maxScroll - 5);

    // 👉 Auto center kalau sedikit item
    if (scrollContainer.scrollWidth <= scrollContainer.clientWidth) {
      scrollContainer.classList.add("justify-center");
    } else {
      scrollContainer.classList.remove("justify-center");
    }
  }

  scrollContainer.addEventListener("scroll", updateButtons);
  window.addEventListener("load", updateButtons);
  window.addEventListener("resize", updateButtons);
</script>

<!-- JS: Zoom, Variants, Media, Wishlist, Share, Price formatting -->
<script src="https://cdn.jsdelivr.net/npm/medium-zoom@1.0.6/dist/medium-zoom.min.js"></script>
<script>
  // Zoom on image only, not video
  const zoom = mediumZoom('#main-image', { background: '#000' });

  const mainImage   = document.getElementById('main-image');
  const mainVideo   = document.getElementById('main-video');
  const skeleton    = document.getElementById('media-skeleton');
  const priceEl     = document.getElementById('price-display');
  const oldPriceEl  = document.getElementById('price-old');
  const descEl      = document.getElementById('desc-display');
  const cartBtn     = document.getElementById('idcart');
  const buyBtn      = document.getElementById('btn-buy');
  const variants    = document.querySelectorAll('.variant-btn');
  const stockWrap   = document.getElementById('stock-wrap');
  const stockBar    = document.getElementById('stock-bar');
  const stockText   = document.getElementById('stock-text');

  function formatIDR(n){ return new Intl.NumberFormat('id-ID',{ style:'currency', currency:'IDR', minimumFractionDigits:0 }).format(Number(n||0)); }

  function showImage(src){
    mainVideo.pause(); mainVideo.classList.add('hidden');
    mainImage.classList.remove('hidden');
    skeleton.style.display='block';
    mainImage.onload = ()=>{ mainImage.classList.remove('opacity-0'); skeleton.style.display='none'; };
    mainImage.classList.add('opacity-0');
    mainImage.src = src;
  }
  function showVideo(src){
    zoom.detach(); // prevent zoom overlay on video
    skeleton.style.display='none';
    mainImage.classList.add('hidden');
    mainVideo.src = src;
    mainVideo.classList.remove('hidden');
  }

  // Thumbnails click (desktop + mobile)
  function hookThumbContainer(container){
    if(!container) return;
    container.addEventListener('click', (e)=>{
      const el = e.target.closest('[data-kind]') || (e.target.tagName==='IMG'? e.target : null);
      if(!el) return;
      const kind = el.dataset.kind || 'image';
      const src  = el.dataset.src || el.getAttribute('src');
      container.querySelectorAll('.thumb-active').forEach(t=> t.classList.remove('thumb-active'));
      el.classList.add('thumb-active');
      kind==='video' ? showVideo(src) : showImage(src);
    });
  }
  hookThumbContainer(document.getElementById('thumbnail-container'));
  hookThumbContainer(document.getElementById('thumbnail-container-mobile'));

  // Variants
  function updateVariant(btn){
    variants.forEach(b=> b.classList.remove('bg-gray-900','text-white'));
    btn.classList.add('bg-gray-900','text-white');

    // Price
    const price = Number(btn.dataset.price||0);
    const old   = Number(btn.dataset.old||0);
    priceEl.textContent = formatIDR(price);
    if(old>price){ oldPriceEl.textContent = formatIDR(old); oldPriceEl.classList.remove('hidden'); }
    else { oldPriceEl.classList.add('hidden'); }

    // Desc
    descEl.textContent = btn.dataset.desc || '';

    // Cart links
    const idp = btn.dataset.idp, idv = btn.dataset.id;
    cartBtn.href = `/cart/add/${idp}/${idv}`;
    buyBtn.onclick = ()=>{ window.location.href = `/checkout?add=${idp}&variant=${idv}`; };

    // Stock
    const stock = Number(btn.dataset.stock||0);
    if(stock>0){
      stockWrap.style.display='block';
      const pct = Math.max(8, Math.min(100, (stock/50)*100));
      stockBar.style.width = pct+"%";
      stockText.textContent = `Stock Left: ${stock}`;
    } else { stockWrap.style.display='none'; }

    // Media: variant video > variant images > default
    const vVideo = btn.dataset.video;
    const vImgs  = (()=>{ try { return JSON.parse(btn.dataset.images||'[]'); } catch { return []; } })();

    const desk = document.getElementById('thumbnail-container');
    const mob  = document.getElementById('thumbnail-container-mobile');
    function fillThumbs(container){
      if(!container) return;
      container.innerHTML='';
      if(vVideo){
        const w = document.createElement('div');
        w.className = container.id==='thumbnail-container' ? 'w-20 h-20 rounded-xl ring-fine overflow-hidden cursor-pointer thumb-active' : 'min-w-[76px] h-20 rounded-xl ring-fine overflow-hidden cursor-pointer thumb-active';
        w.dataset.kind='video'; w.dataset.src=vVideo;
        w.innerHTML = `<video src="${vVideo}#t=0.1" class="w-full h-full object-cover" muted playsinline></video>`;
        container.appendChild(w);
        showVideo(vVideo);
      }
      const list = vImgs.length ? vImgs : [<?= json_encode($ogImage) ?>];
      list.forEach((src,i)=>{
        const img = document.createElement('img');
        img.src = src; img.loading='lazy'; img.dataset.kind='image'; img.dataset.src=src;
        img.className = container.id==='thumbnail-container' ? (vVideo && i===0? 'thumb-img w-20 h-20 object-cover rounded-xl ring-fine cursor-pointer' : 'thumb-img w-20 h-20 object-cover rounded-xl ring-fine cursor-pointer'+(vVideo?'' : ' thumb-active')) : 'w-20 h-20 object-cover rounded-xl ring-fine cursor-pointer';
        container.appendChild(img);
        if(!vVideo && i===0) showImage(src);
      });
    }
    fillThumbs(desk); fillThumbs(mob);
  }

  if(variants.length){ updateVariant(variants[0]); variants.forEach(v=> v.addEventListener('click', ()=> updateVariant(v))); }

  // Image load -> fade in & stop skeleton
  mainImage.addEventListener('load', ()=>{ skeleton.style.display='none'; mainImage.classList.remove('opacity-0'); zoom.attach(mainImage); });

  // Wishlist (toggle demo)
  const wishBtn = document.getElementById('btn-wishlist');
  wishBtn.addEventListener('click', ()=>{
    const pressed = wishBtn.getAttribute('aria-pressed')==='true';
    wishBtn.setAttribute('aria-pressed', String(!pressed));
    wishBtn.textContent = pressed ? '♥ Wishlist' : '♥ Wishlisted';
    fetch('/wishlist/toggle?product_id=<?= esc($product['id']) ?>', {method:'POST'}).catch(()=>{});
  });

  // Share
  document.getElementById('btn-share').addEventListener('click', async ()=>{
    try{
      await navigator.share({ title: '<?= esc($product['name']) ?>', text: 'Cek produk ini', url: window.location.href });
    }catch{ navigator.clipboard.writeText(window.location.href).then(()=>alert('Link disalin')); }
  });
</script>
<?= view('partials/footer') ?>