<?php /**
 * Upgraded Product Detail View (CodeIgniter 4 + Tailwind + Alpine.js)
 * Features:
 * - Mixed media gallery (images + video), vertical (desktop) / horizontal (mobile)
 * - Lightbox + zoom for images, fullscreen video
 * - Variant-aware: price, stock, SKU, media set, description, discount
 * - Flash Sale timer + progress bar (optional per variant)
 * - Quantity selector with stock guard; sticky bar on mobile
 * - Wishlist toggle (AJAX), Share (incl. copy link)
 * - Shipping estimator (AJAX placeholder) + ETA preview
 * - Installment calculator
 * - Tabs: Description, Specs, Reviews (list + form), Q&A (list + form)
 * - Recommended products slider; Recently viewed (localStorage)
 * - SEO: OG tags (assumed in header), JSON-LD Product & Breadcrumbs
 * - Analytics: dataLayer events
 */ ?>

<?= view('partials/header') ?>
<?php
function slugify($string) { return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string))); }

$categorySlug = slugify($category['name']);
$productSlug  = slugify($product['name']);
$mainImage    = $product['main_images'] ?? 'default.jpg';
$galleryPath  = "assets/SGV/Category/{$categorySlug}/{$productSlug}";
$productVideo = $product['video'] ?? null; // string file name or null

// Variant bootstrap
$activeVariant = $variants[0] ?? [
  'id' => 0,
  'name' => '-',
  'price' => 0,
  'desc' => '-',
  'sku' => $product['sku'] ?? ($product['id'] ?? 'SKU-UNKNOWN'),
  'stock' => 0,
  'discount_price' => null,
  'discount_percent' => null,
  'sale_end' => null, // e.g., '2025-09-01T23:59:59+07:00'
  'images' => [$mainImage],
  'video' => $productVideo
];

$priceNow = $activeVariant['discount_price'] ?? $activeVariant['price'];
$hasDiscount = !empty($activeVariant['discount_price']);
$reviewsSummary = $reviewsSummary ?? ['avg' => 4.8, 'count' => 123];
$specs = $specs ?? [
  ['label' => 'Bahan','value' => 'Cotton Premium'],
  ['label' => 'Berat','value' => '500 gr'],
];
?>

<!-- Alpine.js (if header hasn't included) -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- JSON-LD: Product -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "<?= esc($product['name']) ?>",
  "sku": "<?= esc($activeVariant['sku']) ?>",
  "image": [
    <?php $imgs = array_map(fn($g)=> base_url($galleryPath.'/'.strtolower($g['image_path'])), $galleryImages);
    echo '"'.implode('","', $imgs).'"'; ?>
  ],
  "brand": {"@type": "Brand","name": "<?= esc($product['brand'] ?? ($companySetting['name'] ?? 'Brand')) ?>"},
  "description": "<?= esc(strip_tags($product['description'] ?? $activeVariant['desc'])) ?>",
  "aggregateRating": {"@type":"AggregateRating","ratingValue":"<?= $reviewsSummary['avg'] ?>","reviewCount":"<?= $reviewsSummary['count'] ?>"},
  "offers": {
    "@type": "Offer",
    "priceCurrency": "IDR",
    "price": "<?= $priceNow ?>",
    "availability": "<?= ($activeVariant['stock'] ?? 0) > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' ?>"
  }
}
</script>

<!-- JSON-LD: Breadcrumb -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {"@type":"ListItem","position":1,"name":"Home","item":"<?= base_url('/') ?>"},
    {"@type":"ListItem","position":2,"name":"<?= esc($category['name']) ?>","item":"<?= base_url('category/'.$category['id']) ?>"},
    {"@type":"ListItem","position":3,"name":"<?= esc($product['name']) ?>","item":"<?= current_url() ?>"}
  ]
}
</script>

<div class="max-w-7xl mx-auto px-6 py-12 font-sans"
     x-data="productDetail()"
     x-init='init(<?= json_encode($product) ?>, <?= json_encode($variants) ?>, <?= json_encode($galleryImages) ?>)'>

  <!-- Breadcrumb -->
  <nav class="text-sm mb-6 text-gray-500">
    <a href="/" class="hover:text-black">Home</a> /
    <a href="/category/<?= $category['id'] ?>" class="hover:text-black"><?= esc($category['name']) ?></a> /
    <span class="text-gray-700"><?= esc($product['name']) ?></span>
  </nav>

  <!-- GRID -->
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

    <!-- LEFT: Thumbs (desktop) -->
    <div class="hidden lg:flex flex-col gap-3 col-span-2 max-h-[600px] overflow-y-auto pr-2">
      <template x-for="(m, i) in media" :key="'thumb-'+i">
        <div :title="m.type.toUpperCase()" @click="setMain(i)"
             class="w-20 h-20 rounded-md border border-gray-200 hover:border-gray-900 cursor-pointer overflow-hidden">
          <template x-if="m.type==='video'">
            <video :src="m.src" class="w-full h-full object-cover" muted></video>
          </template>
          <template x-if="m.type==='image'">
            <img :src="m.src" class="w-full h-full object-cover" loading="lazy"/>
          </template>
        </div>
      </template>
    </div>

    <!-- MIDDLE: Main Media -->
    <div class="col-span-6">
      <div class="w-full h-[600px] bg-gray-50 rounded-xl overflow-hidden shadow-sm relative">
        <!-- Skeleton -->
        <div x-show="loading" class="absolute inset-0 animate-pulse bg-gray-100"></div>

        <!-- Main -->
        <template x-if="active.type==='video'">
          <video x-ref="video" :src="active.src" @loadeddata="loading=false" controls class="w-full h-[600px] object-cover"></video>
        </template>
        <template x-if="active.type==='image'">
          <img :src="active.src" @load="loading=false" @click="openLightbox()" class="w-full h-[600px] object-cover cursor-zoom-in" alt="<?= esc($product['name']) ?>"/>
        </template>

        <!-- Wishlist -->
        <button @click="toggleWishlist()" :class="{'text-red-600':wishlisted}" class="absolute top-3 right-3 bg-white rounded-full p-2 shadow hover:scale-105 transition">♥</button>
      </div>

      <!-- Thumbs (mobile) -->
      <div class="lg:hidden flex gap-3 mt-3 overflow-x-auto">
        <template x-for="(m, i) in media" :key="'thumb-m-'+i">
          <div @click="setMain(i)" class="min-w-[80px] h-20 rounded-md border border-gray-200 overflow-hidden">
            <template x-if="m.type==='video'">
              <video :src="m.src" class="w-full h-full object-cover" muted></video>
            </template>
            <template x-if="m.type==='image'">
              <img :src="m.src" class="w-full h-full object-cover" loading="lazy"/>
            </template>
          </div>
        </template>
      </div>
    </div>

    <!-- RIGHT: Info -->
    <div class="col-span-4 flex flex-col space-y-6">
      <div>
        <h1 class="text-4xl font-light uppercase tracking-wider mb-2"><?= esc($product['name']) ?></h1>

        <!-- Rating -->
        <div class="flex items-center space-x-2 mb-2">
          <div class="flex text-yellow-400" aria-label="rating">
            <template x-for="i in 5"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5"><path d="M12 2l3 7h7l-5.5 4.2 2.1 7-6-4.5-6 4.5 2.1-7L2 9h7z"/></svg></template>
          </div>
          <span class="text-sm text-gray-600" x-text="`(${reviews.count} Reviews)`"></span>
        </div>

        <!-- Price + discount -->
        <div class="mb-2">
          <div class="flex items-end gap-3">
            <h2 id="price-display" class="text-3xl font-bold text-gray-900" x-text="formatIDR(current.price)"></h2>
            <template x-if="current.discount_price">
              <span class="text-gray-400 line-through mb-1" x-text="formatIDR(current.price)"></span>
            </template>
            <template x-if="current.discount_percent">
              <span class="bg-red-600 text-white text-xs px-2 py-1 rounded-full mb-1" x-text="`-${current.discount_percent}%`"></span>
            </template>
          </div>
        </div>

        <!-- Flash sale -->
        <template x-if="flash.active">
          <div class="mb-3">
            <div class="flex items-center justify-between text-sm text-red-600 mb-1">
              <span>Flash Sale berakhir dalam</span>
              <span x-text="flash.countdown"></span>
            </div>
            <div class="w-full h-2 bg-red-100 rounded-full overflow-hidden">
              <div class="h-2 bg-red-500" :style="`width:${flash.progress}%`"></div>
            </div>
          </div>
        </template>

        <!-- Stock & SKU -->
        <p class="text-sm text-gray-600">SKU: <span x-text="current.sku"></span></p>
        <p class="text-sm" :class="current.stock>0 ? 'text-green-600' : 'text-red-600'" x-text="current.stock>0 ? 'Stok tersedia' : 'Stok habis'"></p>

        <!-- Variants -->
        <div class="mt-4">
          <p class="uppercase text-xs text-gray-500 mb-2">Pilih Varian</p>
          <div class="flex flex-wrap gap-2">
            <template x-for="(v, idx) in variants" :key="v.id">
              <button @click="selectVariant(idx)"
                class="px-6 py-2 border rounded-full text-sm tracking-wide transition"
                :class="idx===activeVariantIndex ? 'border-gray-900' : 'border-gray-400 hover:border-gray-900'"
                x-text="v.name"></button>
            </template>
          </div>
        </div>

        <!-- Description (short) -->
        <div class="mt-4">
          <p id="desc-display" class="text-gray-700 leading-relaxed" x-text="current.desc"></p>
        </div>

        <!-- Qty + Add to Cart -->
        <div class="mt-4 flex items-center gap-3">
          <div class="flex items-center border rounded-full">
            <button class="px-3 py-2" @click="decQty()">-</button>
            <input type="number" min="1" :max="current.stock" x-model.number="qty" class="w-14 text-center outline-none"/>
            <button class="px-3 py-2" @click="incQty()">+</button>
          </div>
          <a id="idcart" :href="`/cart/add/${product.id}?variant=${current.id}&qty=${qty}`"
             @click.prevent="addToCart()"
             class="bg-black text-white text-center px-6 py-3 rounded-full uppercase tracking-wider hover:bg-gray-800 transition">Tambah ke Keranjang</a>
          <button @click="buyNow()" class="border border-black px-6 py-3 rounded-full uppercase tracking-wider">Beli Sekarang</button>
        </div>

        <!-- Share -->
        <div class="flex items-center space-x-3 mt-3">
          <span class="text-sm text-gray-500">Bagikan:</span>
          <a :href="`https://wa.me/?text=${encodeURIComponent(window.location.href)}`" target="_blank" class="text-green-600 hover:underline">WA</a>
          <a :href="`https://facebook.com/sharer/sharer.php?u=${encodeURIComponent(window.location.href)}`" target="_blank" class="text-blue-600 hover:underline">FB</a>
          <a :href="`https://twitter.com/intent/tweet?url=${encodeURIComponent(window.location.href)}`" target="_blank" class="text-sky-500 hover:underline">Twitter</a>
          <button @click="copyLink()" class="text-gray-700 underline">Copy Link</button>
        </div>

        <!-- Shipping & Installment -->
        <div class="mt-6 space-y-3">
          <div class="p-4 border rounded-xl">
            <div class="flex items-center gap-2 mb-2"><span class="font-medium">Cek Ongkir</span><span class="text-xs text-gray-500">(estimasi)</span></div>
            <div class="flex gap-2">
              <input type="text" placeholder="Kode Pos" x-model="shipping.postcode" class="border rounded-lg px-3 py-2 w-40">
              <select x-model="shipping.courier" class="border rounded-lg px-3 py-2">
                <option value="jne">JNE</option>
                <option value="pos">POS</option>
                <option value="tiki">TIKI</option>
              </select>
              <button @click="calcShipping()" class="px-4 py-2 rounded-lg bg-gray-900 text-white">Cek</button>
            </div>
            <div class="mt-2 text-sm" x-text="shipping.result"></div>
          </div>

          <div class="p-4 border rounded-xl">
            <div class="flex items-center gap-2 mb-2"><span class="font-medium">Cicilan</span><span class="text-xs text-gray-500">(simulasi)</span></div>
            <div class="flex gap-2">
              <select x-model.number="install.months" class="border rounded-lg px-3 py-2">
                <option :value="3">3 bulan</option>
                <option :value="6">6 bulan</option>
                <option :value="12">12 bulan</option>
              </select>
              <input type="number" step="0.01" min="0" x-model.number="install.rate" class="border rounded-lg px-3 py-2 w-28" placeholder="Bunga %">
              <button @click="calcInstallment()" class="px-4 py-2 rounded-lg bg-gray-900 text-white">Hitung</button>
            </div>
            <div class="mt-2 text-sm" x-text="install.result"></div>
          </div>
        </div>
      </div>

      <!-- Sticky CTA (mobile) -->
      <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t p-3 flex items-center justify-between z-40">
        <div>
          <div class="text-xs text-gray-500">Harga</div>
          <div class="text-lg font-semibold" x-text="formatIDR(current.discount_price ?? current.price)"></div>
        </div>
        <a :href="`/cart/add/${product.id}?variant=${current.id}&qty=${qty}`" @click.prevent="addToCart()" class="bg-black text-white px-5 py-3 rounded-full">Tambah</a>
      </div>
    </div>
  </div>

  <!-- Tabs -->
  <div class="mt-16" x-data="{ tab: 'desc' }">
    <div class="flex border-b mb-6 overflow-x-auto">
      <button @click="tab='desc'" :class="tab==='desc' ? 'border-b-2 border-black' : ''" class="px-4 py-2 whitespace-nowrap">Deskripsi</button>
      <button @click="tab='spec'" :class="tab==='spec' ? 'border-b-2 border-black' : ''" class="px-4 py-2 whitespace-nowrap">Spesifikasi</button>
      <button @click="tab='review'" :class="tab==='review' ? 'border-b-2 border-black' : ''" class="px-4 py-2 whitespace-nowrap">Ulasan</button>
      <button @click="tab='qa'" :class="tab==='qa' ? 'border-b-2 border-black' : ''" class="px-4 py-2 whitespace-nowrap">Q&A</button>
    </div>
    <div>
      <div x-show="tab==='desc'">
        <div class="prose max-w-none"><?= $product['description'] ?? '-' ?></div>
      </div>
      <div x-show="tab==='spec'">
        <ul class="list-disc pl-5 space-y-2">
          <?php foreach ($specs as $sp): ?>
            <li><span class="text-gray-500"><?= esc($sp['label']) ?>:</span> <?= esc($sp['value']) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div x-show="tab==='review'" class="space-y-6">
        <div class="flex items-center gap-3">
          <div class="text-3xl font-bold" x-text="reviews.avg.toFixed(1)"></div>
          <div class="text-sm text-gray-600" x-text="`${reviews.count} ulasan`"></div>
        </div>
        <!-- List reviews -->
        <template x-for="r in reviews.items" :key="r.id">
          <div class="border rounded-xl p-4">
            <div class="flex items-center gap-2 mb-1">
              <div class="font-medium" x-text="r.author"></div>
              <div class="text-xs text-gray-500" x-text="r.date"></div>
            </div>
            <div class="text-yellow-400 flex">
              <template x-for="i in r.rating"><svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-4 h-4"><path d="M12 2l3 7h7l-5.5 4.2 2.1 7-6-4.5-6 4.5 2.1-7L2 9h7z"/></svg></template>
            </div>
            <p class="text-sm mt-2" x-text="r.text"></p>
          </div>
        </template>
        <!-- Form review -->
        <form @submit.prevent="submitReview" class="border rounded-xl p-4 space-y-3">
          <div class="font-medium">Tulis Ulasan</div>
          <div>
            <label class="text-sm">Rating</label>
            <select x-model.number="reviewForm.rating" class="border rounded-lg px-3 py-2">
              <option :value="5">5</option>
              <option :value="4">4</option>
              <option :value="3">3</option>
              <option :value="2">2</option>
              <option :value="1">1</option>
            </select>
          </div>
          <textarea x-model="reviewForm.text" class="w-full border rounded-lg px-3 py-2" placeholder="Bagikan pengalamanmu"></textarea>
          <button class="bg-black text-white px-4 py-2 rounded-lg">Kirim</button>
          <div class="text-sm text-green-600" x-text="reviewForm.msg"></div>
        </form>
      </div>
      <div x-show="tab==='qa'" class="space-y-6">
        <template x-for="q in qa.items" :key="q.id">
          <div class="border rounded-xl p-4">
            <div class="font-medium" x-text="q.question"></div>
            <div class="text-sm text-gray-600" x-text="q.answer ? q.answer : 'Menunggu jawaban admin' "></div>
          </div>
        </template>
        <form @submit.prevent="submitQuestion" class="border rounded-xl p-4 space-y-3">
          <div class="font-medium">Tanya Produk</div>
          <input x-model="qaForm.question" class="w-full border rounded-lg px-3 py-2" placeholder="Tulis pertanyaanmu"/>
          <button class="bg-black text-white px-4 py-2 rounded-lg">Kirim</button>
          <div class="text-sm text-green-600" x-text="qaForm.msg"></div>
        </form>
      </div>
    </div>
  </div>

  <!-- Rekomendasi -->
  <div class="mt-20">
    <h3 class="text-xl font-semibold mb-6 uppercase tracking-wide">Produk yang Disarankan</h3>
    <div class="flex space-x-6 overflow-x-auto pb-4">
      <?php foreach ($recommendedProducts as $rec): 
        $recSlug = slugify($rec['name']);
        $recCatSlug = slugify($rec['category']);
        $recImage = $rec['main_images'] ?? 'default.jpg';
      ?>
      <a href="/product/<?= $rec['id'] ?>" class="group min-w-[200px]">
        <div class="w-full h-72 bg-gray-50 rounded-xl overflow-hidden shadow-sm">
          <img src="<?= base_url("assets/SGV/Category/{$recCatSlug}/{$recSlug}/" . strtolower($recImage)) ?>"
               alt="<?= esc($rec['name']) ?>"
               class="w-full h-full object-cover group-hover:scale-105 transition duration-500" loading="lazy">
        </div>
        <p class="mt-3 text-sm text-gray-700 group-hover:underline"><?= esc($rec['name']) ?></p>
        <p class="text-gray-900 font-semibold">Rp <?= number_format($rec['price'], 0, ',', '.') ?></p>
      </a>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Recently Viewed -->
  <div class="mt-16" x-show="recent.length">
    <h3 class="text-xl font-semibold mb-6 uppercase tracking-wide">Baru Dilihat</h3>
    <div class="flex space-x-6 overflow-x-auto pb-4">
      <template x-for="r in recent" :key="r.id">
        <a :href="`/product/${r.id}`" class="group min-w-[200px]">
          <div class="w-full h-64 bg-gray-50 rounded-xl overflow-hidden shadow-sm">
            <img :src="r.image" alt="" class="w-full h-full object-cover" loading="lazy">
          </div>
          <p class="mt-3 text-sm text-gray-700 group-hover:underline" x-text="r.name"></p>
          <p class="text-gray-900 font-semibold" x-text="formatIDR(r.price)"></p>
        </a>
      </template>
    </div>
  </div>

</div>

<!-- Lightbox Modal -->
<div x-data="{open:false, src:''}" x-show="open" @open-lightbox.window="open=true; src=$event.detail.src" @keydown.escape.window="open=false" class="fixed inset-0 bg-black/90 z-50 flex items-center justify-center">
  <img :src="src" class="max-w-[90vw] max-height-[90vh] object-contain">
  <button class="absolute top-5 right-5 bg-white text-black rounded-full px-3 py-1" @click="open=false">Tutup</button>
</div>

<script>
function productDetail(){
  return {
    product: {},
    variants: [],
    gallery: [],
    media: [], // [{type:'image'|'video', src:''}]
    active: {type:'image', src:''},
    activeVariantIndex: 0,
    current: {}, // selected variant
    qty: 1,
    loading: true,
    wishlisted: false,
    reviews: {avg: 4.8, count: 123, items: []},
    reviewForm: {rating: 5, text: '', msg: ''},
    qa: {items: []},
    qaForm: {question: '', msg: ''},
    shipping: {postcode:'', courier:'jne', result:''},
    install: {months: 6, rate: 1.5, result:''},
    flash: {active:false, end:null, countdown:'', progress:0, start:null},
    recent: [],

    init(product, variants, gallery){
      this.product = product;
      this.variants = variants.map(v=>({
        ...v,
        images: (v.images||[]).map(img=>`<?= base_url($galleryPath) ?>/${v.name ? '<?= '' ?>'+(''+v.name).toLowerCase().replace(/[^a-z0-9-]+/g,'-')+'/' : ''}${String(img).toLowerCase()}`)
      }));
      this.gallery = gallery;

      // Build media set: video first (if any), then images
      const base = `<?= base_url($galleryPath) ?>`;
      this.media = [];
      if (this.product.video) this.media.push({type:'video', src: base + '/' + this.product.video});
      (this.gallery||[]).forEach(g=> this.media.push({type:'image', src: base + '/' + String(g.image_path).toLowerCase()}));

      this.active = this.media[0] || {type:'image', src: base + '/<?= strtolower($mainImage) ?>'};

      // Select first variant
      this.selectVariant(0);

      // Load reviews & QA (could be pre-passed from controller)
      this.reviews.items = (window.__REVIEWS__||[]);
      this.reviews.avg = Number(<?= json_encode($reviewsSummary['avg']) ?>);
      this.reviews.count = Number(<?= json_encode($reviewsSummary['count']) ?>);

      // Recently viewed
      this.pushRecent();
      this.recent = this.getRecent().filter(r=>r.id !== this.product.id);

      // Analytics view
      window.dataLayer = window.dataLayer || [];
      window.dataLayer.push({event:'view_item', item_id: this.product.id, item_name: this.product.name});

      // Flash sale ticker
      setInterval(()=>this.tickFlash(), 1000);
    },

    setMain(i){ this.loading=true; this.active = this.media[i]; },
    openLightbox(){ window.dispatchEvent(new CustomEvent('open-lightbox', {detail:{src:this.active.src}})); },

    formatIDR(n){ return new Intl.NumberFormat('id-ID',{style:'currency', currency:'IDR', minimumFractionDigits:0}).format(Number(n||0)); },

    selectVariant(idx){
      if (!this.variants[idx]) return;
      this.activeVariantIndex = idx;
      const v = this.variants[idx];
      this.current = {
        id: v.id, name: v.name, desc: v.desc||'—', price: Number(v.price||0),
        discount_price: v.discount_price ? Number(v.discount_price) : null,
        discount_percent: v.discount_percent ? Number(v.discount_percent) : null,
        sku: v.sku || (this.product.sku || `SKU-${this.product.id}-${v.id}`),
        stock: Number(v.stock||0),
      };
      // Variant media override: prepend variant video if exists, else images
      const base = `<?= base_url($galleryPath) ?>`;
      const variantSlug = (v.name||'').toLowerCase().replace(/[^a-z0-9-]+/g,'-');
      const vMedia = [];
      if (v.video) vMedia.push({type:'video', src: `${base}/${variantSlug}/${v.video}`});
      (v.images||[]).forEach(img=> vMedia.push({type:'image', src:`${base}/${variantSlug}/${String(img).toLowerCase()}`}));
      this.media = vMedia.length ? vMedia : this.media;
      this.active = this.media[0] || this.active;

      // Flash sale
      if (v.sale_end) {
        this.flash.active = true;
        this.flash.end = new Date(v.sale_end).getTime();
        this.flash.start = Date.now();
      } else { this.flash.active=false; }

      // Adjust qty
      this.qty = Math.min(1, this.current.stock) || 1;

      // Update cart link (for non-JS fallback already exists)
      const cart = document.getElementById('idcart');
      if (cart) cart.href = `/cart/add/${this.product.id}?variant=${this.current.id}&qty=${this.qty}`;
    },

    decQty(){ if (this.qty>1) this.qty--; },
    incQty(){ if (this.qty < this.current.stock) this.qty++; },

    addToCart(){
      if (this.current.stock<=0) { alert('Stok habis'); return; }
      fetch(`/cart/add/${this.product.id}?variant=${this.current.id}&qty=${this.qty}`, {method:'POST'})
        .then(r=>r.json()).then(() => {
          window.dataLayer.push({event:'add_to_cart', item_id:this.product.id, variant_id:this.current.id, qty:this.qty});
          alert('Ditambahkan ke keranjang');
        }).catch(()=>alert('Gagal menambahkan ke keranjang'));
    },
    buyNow(){ this.addToCart(); window.location.href='/checkout'; },

    toggleWishlist(){
      this.wishlisted = !this.wishlisted;
      fetch(`/wishlist/toggle?product_id=${this.product.id}`, {method:'POST'});
    },

    copyLink(){ navigator.clipboard.writeText(window.location.href).then(()=>alert('Link disalin')); },

    calcShipping(){
      this.shipping.result = 'Menghitung...';
      fetch('/shipping/calc', {method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({product_id:this.product.id, variant_id:this.current.id, postcode:this.shipping.postcode, courier:this.shipping.courier})})
        .then(r=>r.json()).then(d=>{ this.shipping.result = d.text || 'Estimasi tidak tersedia'; })
        .catch(()=> this.shipping.result = 'Gagal menghitung');
    },

    calcInstallment(){
      const P = Number(this.current.discount_price ?? this.current.price);
      const r = (Number(this.install.rate||0)/100)/12;
      const n = Number(this.install.months||0);
      if (!P || !n) { this.install.result='—'; return; }
      const m = r ? (P*r)/(1-Math.pow(1+r,-n)) : P/n;
      this.install.result = `≈ ${this.formatIDR(m)} / bulan`;
    },

    submitReview(){
      fetch('/reviews/add', {method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({product_id:this.product.id, rating:this.reviewForm.rating, text:this.reviewForm.text})})
        .then(r=>r.json()).then(()=>{ this.reviewForm.msg='Terima kasih atas ulasanmu!'; })
        .catch(()=> this.reviewForm.msg='Gagal mengirim ulasan');
    },

    submitQuestion(){
      fetch('/qa/add', {method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({product_id:this.product.id, question:this.qaForm.question})})
        .then(r=>r.json()).then(()=>{ this.qaForm.msg='Pertanyaan terkirim'; })
        .catch(()=> this.qaForm.msg='Gagal mengirim pertanyaan');
    },

    tickFlash(){
      if (!this.flash.active || !this.flash.end) return;
      const now = Date.now();
      const diff = this.flash.end - now;
      if (diff <= 0){ this.flash.active=false; return; }
      // countdown display
      const s = Math.floor(diff/1000); const h = String(Math.floor(s/3600)).padStart(2,'0'); const m=String(Math.floor((s%3600)/60)).padStart(2,'0'); const ss=String(s%60).padStart(2,'0');
      this.flash.countdown = `${h}:${m}:${ss}`;
      // simple progress (from init start to end)
      const total = (this.flash.end - this.flash.start); const passed = now - this.flash.start; this.flash.progress = Math.min(100, Math.max(0, (passed/total)*100));
    },

    // Recently viewed helpers
    pushRecent(){
      const key='recent_products';
      const item={id:this.product.id, name:this.product.name, price:this.current?.price || <?= (int)$priceNow ?>, image:this.media.find(m=>m.type==='image')?.src || '<?= base_url($galleryPath . '/' . strtolower($mainImage)) ?>'};
      const arr = this.getRecent().filter(r=>r.id!==item.id);
      arr.unshift(item); // most recent first
      localStorage.setItem(key, JSON.stringify(arr.slice(0,12)));
    },
    getRecent(){ try { return JSON.parse(localStorage.getItem('recent_products')||'[]'); } catch(e){ return []; } }
  }
}
</script>

<?= $this->include('partials/footer') ?>

<?php /* =========================
 BACKEND ENDPOINT SKETCH (Controller methods)
==========================
// In app/Controllers/Api/Wishlist.php
public function toggle(){
  $pid = $this->request->getGet('product_id');
  // $userId = service('auth')->id(); // adjust accordingly
  // Toggle in DB, return JSON
  return $this->response->setJSON(['ok'=>true]);
}

// In app/Controllers/Api/Shipping.php
public function calc(){
  $data = $this->request->getJSON(true);
  // Integrate with RajaOngkir / internal table; for now dummy
  $eta = rand(2,5);
  $cost = 20000 + rand(0,15000);
  return $this->response->setJSON(['text'=>"ETA ${eta} hari • ".number_format($cost,0,',','.')]);
}

// In app/Controllers/Api/Reviews.php
public function add(){
  $data = $this->request->getJSON(true);
  // validate + insert into reviews table
  return $this->response->setJSON(['ok'=>true]);
}

// In app/Controllers/Api/QA.php
public function add(){
  $data = $this->request->getJSON(true);
  // validate + insert into qa table
  return $this->response->setJSON(['ok'=>true]);
}

// ROUTES (app/Config/Routes.php)
$routes->post('shipping/calc', 'Api\Shipping::calc');
$routes->post('reviews/add', 'Api\Reviews::add');
$routes->post('qa/add', 'Api\QA::add');
$routes->post('wishlist/toggle', 'Api\Wishlist::toggle');

// MIGRATIONS (sketch)
// reviews: id, product_id, user_id, rating TINYINT, text TEXT, created_at
// qas: id, product_id, user_id, question TEXT, answer TEXT NULL, created_at, answered_at NULL
// wishlists: id, user_id, product_id, created_at
// products: add column 'video' VARCHAR(255) NULL
// product_variants: add columns sku, stock INT, discount_price INT NULL, discount_percent INT NULL, sale_end DATETIME NULL, video VARCHAR(255) NULL
*/ ?>
