<?php echo view('partials/header', ['title' => 'Service Us']); ?>

<section class="relative w-full bg-[white] text-black font-sans">
  <!-- Banner -->
  <div class="relative h-[80vh] overflow-hidden">
    <img src="<?= base_url('assets/SGV/services/cu/background.jpeg') ?>" alt="Service Banner" class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex items-center justify-center">
      <h1 class="text-4xl text-white md:text-6xl font-light tracking-wide">Our Service</h1>
    </div>
  </div>

  <!-- Description -->
  <div class="max-w-4xl mx-auto px-6 py-16 text-center space-y-6">
    <h3 class="text-2xl py-0 md:text-xl tracking-wider uppercase text-black">SecretGarden.ID</h3>
    <h1 class="text-2xl py-0 md:text-3xl tracking-wider uppercase text-black">Coorporate Gift</h1>
    <h2 class="text-2xl py-0 md:text-1xl tracking-wider uppercase text-black">A Thoughtful Experience</h2>
    <p class="text-lg leading-relaxed text-black-300">
      At Secret Garden, we believe in not just providing products, but crafting meaningful experiences.
      From curated packaging to personalized care, every detail is designed to delight your senses and soul.
    </p>
  </div>

  <!-- Service List -->
  <div class="max-w-6xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-10 py-12">
    <div class="group">
      <div class="overflow-hidden rounded-2xl">
        <img src="<?= base_url('assets/SGV/services/cg/img1.jpg') ?>" alt="Packaging Service" class="w-full h-64 object-cover transition-transform duration-700 group-hover:scale-105" />
      </div>
      <h3 class="mt-6 text-xl font-semibold text-[#c9ac6c]">Personalized Packaging</h3>
      <p class="text-black-400 mt-2 text-sm">Elegant wrapping with heartfelt message cards to enhance every gift.</p>
    </div>

    <div class="group">
      <div class="overflow-hidden rounded-2xl">
        <img src="<?= base_url('assets/SGV/services/cg/img2.jpg') ?>" alt="Delivery Service" class="w-full h-64 object-cover transition-transform duration-700 group-hover:scale-105" />
      </div>
      <h3 class="mt-6 text-xl font-semibold text-[#c9ac6c]">Nationwide Delivery</h3>
      <p class="text-black-400 mt-2 text-sm">Reliable & safe shipping across Indonesia, ensuring product integrity.</p>
    </div>

    <div class="group">
      <div class="overflow-hidden rounded-2xl">
        <img src="<?= base_url('assets/SGV/services/cg/img3.jpg') ?>" alt="Customer Support" class="w-full h-64 object-cover transition-transform duration-700 group-hover:scale-105" />
      </div>
      <h3 class="mt-6 text-xl font-semibold text-[#c9ac6c]">Dedicated Support</h3>
      <p class="text-black-400 mt-2 text-sm">We’re here to help—before, during, and after your purchase journey.</p>
    </div>
  </div>

  <!-- Call to Action -->
  <div class="text-center py-16">
    <h4 class="text-xl text-black-300 mb-4">Need a tailored service or corporate gift?</h4>
    <a href="<?= base_url('contact') ?>" class="inline-block px-6 py-3 border border-[#c9ac6c] text-[#c9ac6c] hover:bg-[#c9ac6c] hover:text-black transition duration-300 rounded-full">
      Contact Us
    </a>
  </div>
</section>

<?php echo view('partials/footer'); ?>
