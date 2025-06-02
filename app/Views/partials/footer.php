<footer class="py-10 px-6 flex flex-col md:flex-row justify-between items-center max-w-7xl mx-auto">
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
   // 2. Main slider autoplay with smooth fade transitions
    (() => {
      const slides = document.querySelectorAll('#mainSlider > div');
      let current = 0;
      const total = slides.length;
      function showSlide(index) {
        slides.forEach((slide, i) => {
          slide.style.opacity = i === index ? '1' : '0';
          slide.style.zIndex = i === index ? '10' : '1';
        });
      }
      function nextSlide() {
        current = (current + 1) % total;
        showSlide(current);
      }
      showSlide(current);
      setInterval(nextSlide, 7000);
    })();

    // 3. Tilt parallax effect on sample image
    (() => {
      const tiltContainer = document.getElementById('tiltSample');
      if (!tiltContainer) return;
      tiltContainer.addEventListener('mousemove', (e) => {
        const rect = tiltContainer.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        const rotateX = ((y - centerY) / centerY) * 10; // max 10deg
        const rotateY = ((x - centerX) / centerX) * 10; // max 10deg
        tiltContainer.style.transform = `rotateX(${-rotateX}deg) rotateY(${rotateY}deg) translateZ(30px)`;
      });
      tiltContainer.addEventListener('mouseleave', () => {
        tiltContainer.style.transform = 'rotateX(0deg) rotateY(0deg) translateZ(0)';
      });
    })();

    // 3. Category slider with buttons
    (() => {
      const slider = document.getElementById('categorySlider');
      const prevBtn = document.getElementById('prevCategory');
      const nextBtn = document.getElementById('nextCategory');
      const totalItems = slider.children.length;
      let currentIndex = 0;

      function updateSlider() {
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
      updateSlider();
    })();

    // 8. Fullwide slider with buttons
    (() => {
      const slider = document.getElementById('fullwideSlider');
      const prevBtn = document.getElementById('prevFullwide');
      const nextBtn = document.getElementById('nextFullwide');
      const totalItems = slider.children.length;
      let currentIndex = 0;

      function updateSlider() {
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
      updateSlider();
    })();

    // Parallax scroll effect for background images on full width sections
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
      lucide.createIcons();
  </script>
 </body>
</html>


