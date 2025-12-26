<style>
@keyframes fadeIn {
  0% { opacity: 0; transform: translateY(10px); }
  100% { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
  animation: fadeIn 0.3s ease;
}
</style>
<footer class="w-full font-<?= ($companySetting['font'] ?? 'playfair') ?>" id="ordernow" style="position: relative;">
  <div class="w-full py-10 px-6 flex flex-col md:flex-row justify-between items-center max-w-7xl mx-auto bg-white border-t border-gray-200">
    <div class="max-w-xs flex flex-col text-center items-center md:text-left md:mb-0 mb-10">
      <img src="<?= base_url($companySetting['logo'] ?? 'assets/SGV/footer/footer.jpg') ?>"
           alt="Logo of <?= esc($companySetting['name'] ?? 'Company') ?>"
           class="md:h-[100px] h-[100px] w-auto border-40 object-fit" />
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

  <div class="flex flex-row mb-5 justify-center text-xl text-[#0a2540] text-center md:text-right">
    <p>© <?= date('Y'); ?> <?= esc($companySetting['name'] ?? 'SGV') ?>. All rights reserved.</p>
  </div>
</footer>
<button id="chat-btn"
    class="fixed bottom-5 right-5 bg-green-600 text-white p-4 rounded-full shadow-lg hover:bg-green-700 transition transform hover:scale-110">
   <img src="<?=base_url("assets/icon/whatsapp.png")?>" class="w-10" alt="">
</button>

<div id="chat-box"
     class="fixed bottom-20 right-10 w-50 bg-white shadow-2xl rounded-2xl overflow-hidden hidden flex flex-col">
    <div id="chat-body" class="h-64 p-3 overflow-y-auto text-sm flex flex-col space-y-2 scroll-smooth">
        <div class="self-start bg-gray-100 px-3 py-2 rounded text-gray-700 animate-fade-in">
            Hello, welcome to secretgarden
        </div>
         <div class="self-start bg-gray-100 px-3 py-2 rounded text-gray-700 animate-fade-in">
            <a href="https://wa.me"><img src="<?=base_url("assets/icon/whatsapp.png")?>" class="w-10 h-auto" alt=""></a>
        </div>
    </div>
</div>

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


<script>
  function sidebar() {
    return {
      expanded: true,
      sidebarOpen: false,
      init() {
        const stored = localStorage.getItem('sidebarExpanded');
        if (stored !== null) this.expanded = stored === 'true';
      },
      toggle() {
        this.expanded = !this.expanded;
        localStorage.setItem('sidebarExpanded', this.expanded);
      }
    }
  }
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


<script>
  window.addEventListener('load', function() {
    const loader = document.getElementById('loader-overlay');
    if (loader) {
      loader.style.opacity = '0';
      setTimeout(() => loader.style.display = 'none', 500);
    }
  });
</script>

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
  });

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