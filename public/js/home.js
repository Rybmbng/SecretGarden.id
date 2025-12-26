const box = document.getElementById('parallaxBox');
  const item = document.getElementById('parallaxItem');
  if(box && item){
    box.addEventListener('mousemove', (e) => {
      const rect = box.getBoundingClientRect();
      const x = e.clientX - rect.left; 
      const y = e.clientY - rect.top;  
      const centerX = rect.width / 2;
      const centerY = rect.height / 2;
      const deltaX = (x - centerX) / centerX;
      const deltaY = (y - centerY) / centerY;
      const rotateX = deltaY * 10; 
      const rotateY = deltaX * -10;
      item.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.05)`;
    });
    box.addEventListener('mouseleave', () => {
      item.style.transform = 'rotateX(0deg) rotateY(0deg) scale(1)';
    });
  }
const slides = document.querySelectorAll('#slide-main .slide');
  const dots = document.querySelectorAll('#slide-main [data-dot]');
  const slider = document.getElementById('slide-main');
  let current = 0;
  let slideTimeout;
  let isDragging = false;
  let startX = 0;

  function showSlide(index){
    index = (index + slides.length) % slides.length;
    slides.forEach((s,i)=>s.classList.toggle('active', i===index));
    dots.forEach((d,i)=>d.classList.toggle('active', i===index));
    current = index;

    clearTimeout(slideTimeout);
    const duration = parseInt(slides[current].dataset.duration) || 8000;
    slideTimeout = setTimeout(()=>showSlide(current+1), duration);
  }

  dots.forEach(dot => dot.addEventListener('click', ()=>showSlide(parseInt(dot.dataset.dot))));

  slider.addEventListener('mouseenter', ()=>clearTimeout(slideTimeout));
  slider.addEventListener('mouseleave', ()=>showSlide(current));

  slider.addEventListener('mousedown', e => { isDragging=true; startX=e.clientX; slider.style.cursor="grabbing"; });
  slider.addEventListener('touchstart', e => { isDragging=true; startX=e.touches[0].clientX; });

  slider.addEventListener('mouseup', e => {
    if(!isDragging) return;
    const diff = e.clientX - startX;
    if(diff > 50) showSlide(current-1);
    else if(diff < -50) showSlide(current+1);
    isDragging = false;
    slider.style.cursor="grab";
  });
  slider.addEventListener('touchend', e => {
    if(!isDragging) return;
    const diff = e.changedTouches[0].clientX - startX;
    if(diff > 50) showSlide(current-1);
    else if(diff < -50) showSlide(current+1);
    isDragging = false;
  });
  showSlide(current);
  const faders=document.querySelectorAll('.fade-in-up');
  const observer = new IntersectionObserver((entries, obs)=>{
    entries.forEach(entry=>{
      if(entry.isIntersecting){
        entry.target.classList.add('visible');
        obs.unobserve(entry.target);
      }
    });
  },{threshold:0.1, rootMargin:"0px 0px -100px 0px"});
  faders.forEach(fader=>observer.observe(fader));

document.addEventListener("DOMContentLoaded", function () {
  const slides = document.querySelectorAll(".slide");

  function renderSlides() {
    const isMobile = window.innerWidth <= 767;

    slides.forEach(slide => {
      const src = isMobile ? slide.dataset.srcM : slide.dataset.srcD;
      const ext = src.split('.').pop().toLowerCase();

      slide.innerHTML = "";

      if (["mp4", "webm", "ogg"].includes(ext)) {
        const video = document.createElement("video");
        video.autoplay = true;
        video.loop = true;
        video.muted = true;
        video.playsInline = true;
        video.className = "w-full h-full object-cover";

        const source = document.createElement("source");
        source.src = src;
        source.type = "video/" + (ext === "mp4" ? "mp4" : ext);

        video.appendChild(source);
        slide.appendChild(video);
      } else {
        const img = document.createElement("img");
        img.src = src;
        img.alt = "slide";
        img.loading = "lazy";
        img.className = "w-full h-full object-cover";
        slide.appendChild(img);
      }
    });
  }
  renderSlides();
  let resizeTimer;
  window.addEventListener("resize", function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(renderSlides, 200);
  });
});