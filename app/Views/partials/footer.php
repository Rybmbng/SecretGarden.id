<!-- Modal Cart PHP Up -->
<!-- Removed redundant Open Cart Modal button -->

<?php if (isset($cart) && !empty($cart)): ?>
<div id="modalCart" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
    <button id="closeCartModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">
      &times;
    </button>
    <h2 class="text-lg font-semibold mb-4">Your Cart</h2>
    <ul class="divide-y divide-gray-200 mb-4">
      <?php foreach ($cart as $item): ?>
        <li class="py-2 flex justify-between items-center">
          <span><?php echo htmlspecialchars($item['name']); ?></span>
          <span>x<?php echo (int)$item['qty']; ?></span>
          <span class="font-semibold"><?php echo number_format($item['price'] * $item['qty'], 0, ',', '.'); ?></span>
        </li>
      <?php endforeach; ?>
    </ul>
    <div class="flex justify-between items-center mb-4">
      <span class="font-semibold">Total:</span>
      <span class="font-bold text-[#0a2540]">
        <?php
          $total = 0;
          foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
          }
          echo number_format($total, 0, ',', '.');
        ?>
      </span>
    </div>
    <a href="/cart/checkout" class="block w-full text-center bg-[#0a2540] text-white py-2 rounded hover:bg-[#183b6b] transition">Checkout</a>
  </div>
</div>
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
<?php endif; ?>

<button onclick="showCartModal()" class="fixed bottom-6 right-6 z-40 bg-[#0a2540] text-white rounded-full shadow-lg p-4 hover:bg-[#183b6b] transition flex items-center group">
  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A1 1 0 007.5 17h9a1 1 0 00.9-1.45L17 13M7 13V6h13" />
  </svg>
  <span class="hidden md:inline group-hover:inline">Cart</span>
  <?php if (isset($cart) && count($cart) > 0): ?>
    <span class="ml-2 bg-red-500 text-white rounded-full px-2 py-0.5 text-xs"><?php echo count($cart); ?></span>
  <?php endif; ?>
</button>

<footer class="py-10 px-6 flex flex-col md:flex-row justify-between items-center max-w-7xl mx-auto" id="ordernow">
   <div class="mb-6 md:mb-0 max-w-xs">
    <h3 class="text-xl font-semibold mb-2">
     SGV
    </h3>
    <p>
     SGV is your destination for premium beauty with
        innovation and passion.
    </p>
   </div>
   <div class="flex space-x-6 mb-6 md:mb-0">
    <a aria-label="Facebook" class="hover:text-[#0a2540] transition-colors duration-300" href="#">
     <i class="fab fa-facebook-f text-lg">
     </i>
    </a>
    <a aria-label="Twitter" class="hover:text-[#0a2540] transition-colors duration-300" href="#">
     <i class="fab fa-twitter text-lg">
     </i>
    </a>
    <a aria-label="Instagram" class="hover:text-[#0a2540] transition-colors duration-300" href="#">
     <i class="fab fa-instagram text-lg">
     </i>
    </a>
    <a aria-label="LinkedIn" class="hover:text-[#0a2540] transition-colors duration-300" href="#">
     <i class="fab fa-linkedin-in text-lg">
     </i>
    </a>
   </div>
   <div class="text-sm text-[#0a2540]">
    © <?php echo date('Y'); ?> SGV. All rights reserved.
   </div>
  </footer>
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