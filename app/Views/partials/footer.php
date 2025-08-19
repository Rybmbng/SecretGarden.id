
<style>
@keyframes fadeIn {
  0% { opacity: 0; transform: translateY(10px); }
  100% { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
  animation: fadeIn 0.3s ease;
}
</style>
<?php
$session = session();
$cart = $session->get('cart') ?? [];
?>
<!-- <?php if (isset($cart) && !empty($cart)): ?>
<button onclick="showCartModal()" class="fixed bottom-6 right-6 z-40 bg-[#0a2540] text-white rounded-full shadow-lg p-4 hover:bg-[#183b6b] transition flex items-center group md:flex">
  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A1 1 0 007.5 17h9a1 1 0 00.9-1.45L17 13M7 13V6h13" />
  </svg>
  <span class="hidden md:inline group-hover:inline">Cart</span>
  <?php if (isset($cart) && count($cart) > 0): ?>
    <span class="ml-2 bg-red-500 text-white rounded-full px-2 py-0.5 text-xs"><?php echo count($cart); ?></span>
  <?php endif; ?>
</button>
<?php endif; ?> -->

<?php if (isset($cart) && !empty($cart)): ?>
<div id="modalCart" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 transition-opacity duration-300 hidden">
  <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg p-8 border border-gray-100">
    <button id="closeCartModal" class="absolute top-4 right-4 text-gray-400 hover:text-[#0a2540] text-2xl transition-colors duration-200 focus:outline-none">
      &times;
    </button>
    <h2 class="text-2xl font-bold mb-6 text-[#0a2540] flex items-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#0a2540]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A1 1 0 007.5 17h9a1 1 0 00.9-1.45L17 13M7 13V6h13" />
      </svg>
      Your Cart
    </h2>
    <ul class="divide-y divide-gray-200 mb-6 max-h-64 overflow-y-auto">
      <?php foreach ($cart as $item): ?>
        <li class="py-3 flex justify-between items-center">
          <div class="flex flex-col">
            <span class="font-medium text-gray-800"><?php echo htmlspecialchars($item['name']); ?> (<?php echo htmlspecialchars($item['variant']); ?>)</span>
            <span class="text-xs text-gray-400">x<?php echo (int)$item['qty']; ?></span>
          </div>
          <span class="font-semibold text-[#0a2540] text-lg">
            Rp <?php echo number_format($item['price'] * $item['qty'], 0, ',', '.'); ?>
          </span>
        </li>
      <?php endforeach; ?>
    </ul>
    <div class="flex justify-between items-center mb-6 border-t pt-4">
      <span class="font-semibold text-lg text-gray-700">Total:</span>
      <span class="font-bold text-2xl text-[#0a2540]">
        Rp
        <?php
          $total = 0;
          foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
          }
          echo number_format($total, 0, ',', '.');
        ?>
      </span>
    </div>
    <a href="<?= base_url('cart') ?>" class="block w-full text-center bg-[#0a2540] text-white py-3 rounded-xl font-semibold text-lg hover:bg-[#183b6b] transition-colors duration-200 shadow-md">
      Checkout
    </a>
  </div>
</div>
<?php endif; ?>
<footer class="w-full font-playfair" id="ordernow" style="position: relative;">
  <div class="w-full py-10 px-6 flex flex-col md:flex-row justify-between items-center max-w-7xl mx-auto bg-white border-t border-gray-200">
    
    <div class="max-w-xs flex flex-col text-center items-center md:text-left md:mb-0 mb-10">
      <img src="<?= base_url($companySetting['logo'] ?? 'assets/SGV/footer/footer.jpg') ?>" 
           alt="Logo of <?= esc($companySetting['name'] ?? 'Company') ?>" 
           class="md:h-auto h-auto w-auto border-40 object-fit" />
      <p class="font-medium"><?= esc($companySetting['tagline'] ?? '𝘐𝘯𝘴𝘱𝘪𝘳𝘦𝘥 𝘣𝘺 𝘌𝘢𝘳𝘵𝘩, 𝘔𝘢𝘥𝘦 𝘍𝘰𝘳 𝘠𝘰𝘶') ?></p>
    </div>

    <?php if (!empty($companySetting['footer_links'])): ?>
      <?php $footerGroups = json_decode($companySetting['footer_links'], true); ?>
      <div class="flex flex-col md:flex-row gap-10">
        <?php foreach ($footerGroups as $group): ?>
          <div class="flex flex-col">
            <h1 class="font-medium text-black mb-1 text-lg"><?= esc($group['title']) ?></h1>
            <?php if (!empty($group['links'])): ?>
              <?php foreach ($group['links'] as $link): ?>
                <a href="<?= base_url($link['url']) ?>" class="text-base hover:text-[#8c9464]">
                  <?= esc($link['label']) ?>
                </a>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <!-- Copyright -->
  <div class="flex flex-row mb-5 justify-center text-xl text-[#0a2540] text-center md:text-right">
    <p>© <?= date('Y'); ?> <?= esc($companySetting['name'] ?? 'SGV') ?>. All rights reserved.</p>
  </div>
</footer>
<!-- Floating Chat Button -->
<button id="chat-btn"
    class="fixed bottom-5 right-5 bg-green-600 text-white p-4 rounded-full shadow-lg hover:bg-green-700 transition transform hover:scale-110">
    Chat
</button>

<!-- Chat Box -->
<div id="chat-box"
     class="fixed bottom-20 right-5 w-80 bg-white shadow-2xl rounded-2xl overflow-hidden hidden flex flex-col">

    <!-- Header -->
    <div class="bg-green-600 text-white p-3 text-sm font-semibold flex justify-between items-center">
        <span>SecretGarden.id</span>
        <button id="chat-close" class="text-white font-bold">✖</button>
    </div>

    <!-- Body -->
    <div id="chat-body" class="h-64 p-3 overflow-y-auto text-sm flex flex-col space-y-2 scroll-smooth">
        <div class="self-start bg-gray-100 px-3 py-2 rounded text-gray-700 animate-fade-in">
            Halo! Ada yang bisa kami bantu?
        </div>
    </div>

    <!-- Input -->
    <form id="chat-form" class="flex border-t">
        <input type="text" id="chat-input" class="flex-1 p-2 outline-none text-sm" placeholder="Ketik pesan...">
        <button type="submit" class="bg-green-600 text-white px-3 hover:bg-green-700 transition">Kirim</button>
    </form>
</div>

<!-- Chat AI JS -->
<script>
const chatBtn = document.getElementById('chat-btn');
const chatBox = document.getElementById('chat-box');
const chatClose = document.getElementById('chat-close');
const chatBody = document.getElementById('chat-body');
const chatForm = document.getElementById('chat-form');
const chatInput = document.getElementById('chat-input');

chatBtn.addEventListener('click', () => chatBox.classList.toggle('hidden'));
chatClose.addEventListener('click', () => chatBox.classList.add('hidden'));

chatForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    let message = chatInput.value.trim();
    if(!message) return;

    // User message
    let userMsg = document.createElement('div');
    userMsg.className = 'self-end bg-green-100 px-3 py-2 rounded animate-fade-in';
    userMsg.textContent = message;
    chatBody.appendChild(userMsg);
    chatInput.value = '';
    chatBody.scrollTop = chatBody.scrollHeight;

    try {
        let res = await fetch("<?= base_url('/chat/ai') ?>", {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: "message=" + encodeURIComponent(message)
        });
        let data = await res.json();

        // Bot reply
        let botMsg = document.createElement('div');
        botMsg.className = 'self-start bg-gray-100 px-3 py-2 rounded animate-fade-in';
        botMsg.textContent = data.reply;
        chatBody.appendChild(botMsg);
        chatBody.scrollTop = chatBody.scrollHeight;
    } catch(err) {
        console.error(err);
        let botMsg = document.createElement('div');
        botMsg.className = 'self-start bg-gray-100 px-3 py-2 rounded animate-fade-in';
        botMsg.textContent = 'Terjadi kesalahan saat mengirim pesan.';
        chatBody.appendChild(botMsg);
        chatBody.scrollTop = chatBody.scrollHeight;
    }
});
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  document.getElementById('openSearch').onclick = function () {
    const overlay = document.getElementById('searchOverlay');
    const input = document.getElementById('searchInput');

    if (overlay.classList.contains('hidden')) {
      overlay.classList.remove('hidden');
    } else {
      overlay.classList.add('hidden');
      input.focus();
    }
  };


   document.addEventListener('keydown', function(event) {
  if (event.key === 'Escape') {
    document.getElementById('searchOverlay').classList.add('hidden');
  }
});

  document.getElementById('closeSearch').onclick = function () {
    document.getElementById('searchOverlay').classList.add('hidden');
  };

  $('#searchInput').on('keyup', function () {
    let keyword = $(this).val();
    if (keyword.length > 1) {
      $.get("<?= base_url('search/suggestion') ?>", { q: keyword }, function (data) {
        $('#searchSuggestions').html(data);
      });

    } else {
      $('#searchSuggestions').html(`
        <p class="text-gray-500 mb-2">Popular Searches:</p>
        <ul class="space-y-2">
          <li><a href="<?= base_url('search?q=candle') ?>" class="text-lg hover:underline">Candle</a></li>
          <li><a href="<?= base_url('search?q=diffuser') ?>" class="text-lg hover:underline">Diffuser</a></li>
          <li><a href="<?= base_url('search?q=fragrance') ?>" class="text-lg hover:underline">Fragrance Oil</a></li>
        </ul>`);
    }
  });
</script>

<style>
  
  footer {
    margin-top: auto;
    width: 100%;
  }
</style>
</footer>

<!-- cart script -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modalCart');
    const closeBtn = document.getElementById('closeCartModal');
    window.showCartModal = function() {
      modal.classList.remove('hidden');
    };
    closeBtn.addEventListener('click', function() {
      modal.classList.add('hidden');
    });
    modal.addEventListener('click', function(e) {
      if (e.target === modal) modal.classList.add('hidden');
    });
  });
</script>


<!-- loader script -->
<script>
  window.addEventListener('load', function() {
    const loader = document.getElementById('loader-overlay');
    if (loader) {
      loader.style.opacity = '0';
      setTimeout(() => loader.style.display = 'none', 500);
    }
  });
</script>

<!-- slider product -->
  <script>
    (() => {
  const slider = document.getElementById('categorySlider');
  const prevBtn = document.getElementById('prevCategory');
  const nextBtn = document.getElementById('nextCategory');
  const totalItems = slider.children.length;
  let currentIndex = 0;

  let isDown = false;
  let startX;
  let scrollLeft;

  function updateSlider() {
    slider.style.transition = 'transform 0.3s';
    slider.style.transform = `translateX(-${currentIndex * 100}%)`;
  }

  prevBtn.addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + totalItems) % totalItems;
    updateSlider();
  });
  nextBtn.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % totalItems;
    updateSlider();
  });

  // Mouse events
  slider.addEventListener('mousedown', (e) => {
    isDown = true;
    startX = e.pageX;
    slider.style.cursor = 'grabbing';
  });
  slider.addEventListener('mouseleave', () => {
    isDown = false;
    slider.style.cursor = '';
  });
  slider.addEventListener('mouseup', (e) => {
    if (!isDown) return;
    isDown = false;
    slider.style.cursor = '';
    const diff = e.pageX - startX;
    if (diff > 50) {
      currentIndex = (currentIndex - 1 + totalItems) % totalItems;
    } else if (diff < -50) {
      currentIndex = (currentIndex + 1) % totalItems;
    }
    updateSlider();
  });
  slider.addEventListener('mousemove', (e) => {
    if (!isDown) return;
    // Optionally, you can add visual feedback here
  });

  // Touch events
  slider.addEventListener('touchstart', (e) => {
    isDown = true;
    startX = e.touches[0].pageX;
  });
  slider.addEventListener('touchend', (e) => {
    if (!isDown) return;
    isDown = false;
    const endX = e.changedTouches[0].pageX;
    const diff = endX - startX;
    if (diff > 50) {
      currentIndex = (currentIndex - 1 + totalItems) % totalItems;
    } else if (diff < -50) {
      currentIndex = (currentIndex + 1) % totalItems;
    }
    updateSlider();
  });

  updateSlider();
})();

    (() => {
      const parallaxSections = [
        document.getElementById('fullwide1'),
        document.getElementById('fullwide2'),
        document.getElementById('discover'),
        document.getElementById('fullwide-slide'),
      ];

      window.addEventListener('scroll', () => {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        parallaxSections.forEach((section) => {
          if (!section) return;
          const rect = section.getBoundingClientRect();
          const offsetTop = rect.top + scrollTop;
          const height = rect.height;
          const windowHeight = window.innerHeight;
          const scrollPos = scrollTop + windowHeight;
          if (scrollPos > offsetTop && scrollTop < offsetTop + height) {
            const yPos = (scrollTop - offsetTop) * 0.3;
            const img = section.querySelector('img, video');
            if (img) {
              img.style.transform = `translateY(${yPos}px) scale(1.05)`;
              img.style.transition = 'transform 0.1s ease-out';
            }
          }
        });
      });
    })();
  </script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    lucide.createIcons();
  });
</script>
</body>
</html>