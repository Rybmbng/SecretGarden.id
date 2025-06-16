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