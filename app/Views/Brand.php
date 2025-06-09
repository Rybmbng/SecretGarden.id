<?php echo view('partials/header'); ?>
<style>
   #ordernow {
      display: none;
    }
</style>
<button id="start-btn" class="fixed inset-0 bg-white flex items-center justify-center z-50 text-xl font-bold">
  Tap to Start Experience
</button>

<audio id="audio-player" preload="auto" >
  <source src="<?= base_url('assets/sgv/audio/0.mp3') ?>" type="audio/mp3">
</audio>

<div id="background-container"></div>

<main class="brand-story w-auto">
  <div id="welcome-text"></div>
  <p id="typing" class="typing-text"></p>
</main>

<section class="page relative" id="ordernow" style="display:none;">
  <img alt="Elegant Karmakamet style fragrance display" class="w-full object-cover max-h-[700px]" height="700" loading="lazy" src="<?= base_url('assets/sgv/fragrance.jpeg') ?>" width="1920"/>
  <div class="absolute inset-0 bg-gradient-to-b from-transparent via-white/70 to-white flex flex-col justify-center items-center text-center px-6 md:px-12">
    <h1 class="text-4xl md:text-6xl font-playfair font-bold text-gray-900 max-w-4xl leading-tight mb-6">
      Discover the Art of Fragrance
    </h1>
    <p class="max-w-2xl text-gray-700 text-lg md:text-xl mb-8">
      Handcrafted aromatic experiences inspired by nature and tradition.
    </p>
    <a class="inline-block bg-black text-white uppercase tracking-widest px-8 py-3 text-sm md:text-base hover:bg-gray-800 transition" href="/products">
      Shop Now
    </a>
  </div>
</section>

<script>
  const bgContainer = document.getElementById('background-container');
  const welcomeText = document.getElementById('welcome-text');
  const typingElem = document.getElementById('typing');
  const orderNowSection = document.getElementById('ordernow');
  const startBtn = document.getElementById('start-btn');

  // Simpan referensi audio global supaya tidak di-GC
  let currentAudio = null;

  // Sequence seperti semula
  const sequence = [
    { type: 'text', content: "Welcome To SecretGarden.id" }, 
    { type: 'video', content: 'http://localhost:8080/assets/sgv/video/slide1.mp4', duration: 5000 },
    { type: 'text', content: "Born in Bali in 2016, Secret Garden was founded with deep reverence for the beauty of nature and a commitment to harnessing its essence for your well-being.", audio:"http://localhost:8080/assets/sgv/audio/1.mp3" },
    { type: 'video', content: 'http://localhost:8080/assets/sgv/video/slide2_1.mp4', duration: 5000 },
    { type: 'text', content: "Rooted in the lush landscapes of Bali, we have curated a line of body and wellness products that reflect the island’s rich botanical heritage." ,audio:"http://localhost:8080/assets/sgv/audio/2.mp3"  },
    { type: 'video', content: 'http://localhost:8080/assets/sgv/video/slide1_2.mp4', duration: 5000 },
    { type: 'text', content: "From the very beginning, our mission has been to infuse the calm and spirit of Bali into your daily rituals—inviting you on a sensory journey that not only revitalizes your body, but also uplifts your spirit.", audio:"http://localhost:8080/assets/sgv/audio/3.mp3"  },
    { type: 'video', content: 'http://localhost:8080/assets/sgv/video/slide1_3.mp4', duration: 5000 },
    { type: 'text', content: "As we grow, our dedication to sustainability remains unwavering. Every product you experience is crafted to align with your values and care for the planet we all call home.", audio:"http://localhost:8080/assets/sgv/audio/4.mp3" },
    { type: 'video', content: 'http://localhost:8080/assets/sgv/video/slide2_2.mp4', duration: 5000 },
    { type: 'text', content: "Welcome to Secret Garden—where the beauty and tranquility of Bali come together to nurture your body and soul.", audio:"http://localhost:8080/assets/sgv/audio/5.mp3" },
    { type: 'text', content: "Join us on this journey toward holistic wellness, where every drop and every scent is a tribute to the nature that has inspired us from the start.", audio:"http://localhost:8080/assets/sgv/audio/6.mp3" },
  ];

  function showVideo(src) {
    return new Promise((resolve) => {
      bgContainer.style.opacity = 0;
      setTimeout(() => {
        bgContainer.innerHTML = '';
        bgContainer.style.backgroundImage = '';

        const video = document.createElement('video');
        video.src = src;
        video.autoplay = true;
        video.muted = true;         // muting video supaya autoplay bisa jalan di mobile
        video.loop = true;
        video.playsInline = true;
        video.style.opacity = 0;
        video.style.width = '100%';
        video.style.height = '100%';
        video.style.objectFit = 'cover';

        bgContainer.appendChild(video);

        video.play().then(() => {
          bgContainer.style.opacity = 1;
          video.style.opacity = 1;
          // gunakan durasi manual dari sequence atau fallback 5 detik
          const duration = sequence.find(s => s.content === src)?.duration || 5000;
          setTimeout(() => {
            resolve();
          }, duration);
        }).catch(err => {
          console.warn('Video play error or autoplay blocked:', err);
          bgContainer.style.backgroundImage = `url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1280&q=80')`;
          bgContainer.style.opacity = 1;
          resolve();
        });

        video.addEventListener('error', () => {
          bgContainer.style.backgroundImage = `url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1280&q=80')`;
          bgContainer.style.opacity = 1;
          resolve();
        });
      }, 800);
    });
  }

  // Fungsi typing text dengan delay per karakter
  async function typeText(text) {
    typingElem.textContent = '';
    for (let i = 0; i < text.length; i++) {
      typingElem.textContent += text.charAt(i);
      await new Promise(r => setTimeout(r, 50));
    }
  }

  function clearText() {
    typingElem.textContent = '';
  }

  async function runSequence() {
    welcomeText.style.opacity = 1;
    bgContainer.style.opacity = 0;

    for (let i = 0; i < sequence.length; i++) {
      const step = sequence[i];

      if (step.type === 'video') {
        clearText();
        welcomeText.style.opacity = 0;
        await showVideo(step.content);

      } else if (step.type === 'text') {
        bgContainer.style.opacity = 0;
        await new Promise(r => setTimeout(r, 500));
        bgContainer.innerHTML = '';
        bgContainer.style.backgroundImage = '';
        welcomeText.style.opacity = 0;

        if (currentAudio) {
          currentAudio.pause();
          currentAudio = null;
        }

        if (step.audio) {
          currentAudio = new Audio(step.audio);
          try {
            await currentAudio.play();
          } catch (err) {
            console.warn('Audio play error:', err);
          }
        }

        await typeText(step.content);
        await new Promise(r => setTimeout(r, 1000));
      }
    }

    clearText();
    bgContainer.style.opacity = 0;

    orderNowSection.style.display = 'block';
    orderNowSection.scrollIntoView({ behavior: 'smooth' });
  }

  // Tombol start event listener
  startBtn.addEventListener('click', () => {
    startBtn.style.display = 'none';

    // Set volume audio player utama (jika masih pakai <audio> tag)
    const audio = document.getElementById('audio-player');
    if(audio) {
      audio.volume = 0.1;
      audio.play().catch(e => console.warn('Audio autoplay blocked', e));
    }

    runSequence();
  });
</script>



<?php echo view('partials/footer'); ?>
