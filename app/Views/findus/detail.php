<?php echo view('partials/header', ['title' => 'Find Us']); ?>

<div class="max-w-5xl mx-auto py-10">
  <!-- Gallery Slider -->
  <div class="relative w-full overflow-hidden rounded-xl shadow">
    <div id="slider-track" class="flex transition-transform duration-500">
      <?php foreach ($images as $img): ?>
        <img src="/assets/SGV/stores/<?= esc($img['image']) ?>" 
             class="w-full h-80 object-cover flex-shrink-0" 
             alt="<?= esc($store['name']) ?>">
      <?php endforeach; ?>
    </div>

    <!-- Navigation -->
    <button onclick="prevSlide()" class="absolute top-1/2 left-3 -translate-y-1/2 bg-white/70 p-2 rounded-full shadow">‹</button>
    <button onclick="nextSlide()" class="absolute top-1/2 right-3 -translate-y-1/2 bg-white/70 p-2 rounded-full shadow">›</button>
  </div>

  <h1 class="text-3xl font-bold mt-6"><?= esc($store['name']) ?></h1>
  <p class="mt-2 text-gray-700"><?= esc($store['address']) ?></p>

  <div class="mt-4 bg-gray-50 p-4 rounded-lg shadow">
    <p><strong>Jam Buka:</strong> <?= esc($store['open_hours']) ?></p>
    <p><strong>Telepon:</strong> <?= esc($store['phone']) ?></p>
  </div>

  <div class="mt-6">
    <h2 class="text-xl font-semibold mb-2">Lokasi di Google Maps</h2>
    <iframe 
      src="https://www.google.com/maps?q=<?= urlencode($store['address']) ?>&output=embed" 
      width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy">
    </iframe>
  </div>
</div>

<script>
let currentIndex = 0;
const track = document.getElementById("slider-track");
const slides = track.children;

function updateSlider() {
  track.style.transform = `translateX(-${currentIndex * 100}%)`;
}

function nextSlide() {
  currentIndex = (currentIndex + 1) % slides.length;
  updateSlider();
}

function prevSlide() {
  currentIndex = (currentIndex - 1 + slides.length) % slides.length;
  updateSlider();
}
</script>
<?php echo view('partials/footer'); ?>
