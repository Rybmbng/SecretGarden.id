<?php echo view('partials/header')?>

  <div class="w-auto sticky top-0 z-50 bg-white px-4 py-4 ">
    <div class="relative flex items-center justify-center space-x-8">
      <div id="topNav" class="flex items-center space-x-8 text-gray-400 text-sm md:text-xl font-semibold">
        <div data-target="year2016" class="cursor-pointer hover:text-black transition">2016</div>
        <div data-target="year2020" class="cursor-pointer hover:text-black transition">2020</div>
        <div data-target="year2023" class="cursor-pointer hover:text-black transition">2023</div>
        <div data-target="year2025" class="cursor-pointer hover:text-black transition">2025</div>
      </div>
      <div class="absolute bottom-0 left-0 w-auto h-1 mt-2 overflow-hidden">
        <div id="topProgress" class="bg-black h-auto w-0 transition-all"></div>
      </div>
    </div>
  </div>

  <section class="min-h-screen w-full bg-white text-black text-center flex flex-col items-center justify-center ">
    <h1 class="text-5xl font-bold tracking-wider mb-6">Welcome To Secret Garden</h1>
    <p class="text-xl text-center max-w-2xl opacity-70">A look back at the milestones that shaped our story.</p>
  </section>

  <div class="w-full text-center">
  <?= view('brand/section_2016') ?>
  <?= view('brand/section_2020') ?>
  <?= view('brand/section_2023') ?>
  <?= view('brand/section_2025') ?>
  </div>
  <section class="w-auto min-h-screen flex items-center justify-center bg-white text-black px-4 ">
    <div class="text-center">
      <h2 class="text-4xl font-bold mb-4">Welcome To Secret Garden</h2>
      <p class="text-xl max-w-xl mx-auto opacity-70">Every scent tells a story. Every moment is part of our legacy.</p>
    </div>
  </section>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 1000,
    once: true
  });
</script>

  <script>
    gsap.registerPlugin(ScrollTrigger);

    document.querySelectorAll("section[id^='year']").forEach((section) => {
      gsap.to(section.children[0], {
        scrollTrigger: {
          trigger: section,
          start: "top 80%",
          toggleActions: "play none none reverse"
        },
        opacity: 1,
        y: 0,
        duration: 1.2,
        ease: "power3.out"
      });
    });

    gsap.to("#topProgress", {
      width: "100%",
      ease: "none",
      scrollTrigger: {
        trigger: "body",
        start: "top top",
        end: "bottom bottom",
        scrub: true
      }
    });

    const navItems = document.querySelectorAll("#yearNav li");
    navItems.forEach((item) => {
      item.addEventListener("click", () => {
        const target = document.getElementById(item.dataset.target);
        window.scrollTo({ top: target.offsetTop - 50, behavior: "smooth" });
      });
    });

    const topNavItems = document.querySelectorAll("#topNav div");
    topNavItems.forEach((item) => {
      item.addEventListener("click", () => {
        const target = document.getElementById(item.dataset.target);
        window.scrollTo({ top: target.offsetTop - 100, behavior: "smooth" });
      });
    });

    document.querySelectorAll("section[id^='year']").forEach((section, i) => {
      ScrollTrigger.create({
        trigger: section,
        start: "top center",
        end: "bottom center",
        onEnter: () => activateNav(i),
        onEnterBack: () => activateNav(i)
      });
    });

    function activateNav(index) {
      navItems.forEach((el, i) => el.classList.toggle("active-year", i === index));
      topNavItems.forEach((el, i) => {
        el.classList.toggle("text-black", i === index);
        el.classList.toggle("text-gray-400", i !== index);
      });
    }
  </script>
  <script>
  gsap.utils.toArray("section[id^='year']").forEach((section, i) => {
    gsap.from(section, {
      scrollTrigger: {
        trigger: section,
        start: "top 80%",
        toggleActions: "play none none reverse"
      },
      opacity: 0,
      y: 100,
      duration: 1.5,
      ease: "power3.out"
    });

    const heading = section.querySelector("h2, h1");
    if (heading) {
      gsap.to(heading, {
        yPercent: -10,
        ease: "none",
        scrollTrigger: {
          trigger: section,
          start: "top bottom",
          end: "bottom top",
          scrub: true
        }
      });
    }
  });
</script>


  <?= view('partials/footer') ?>