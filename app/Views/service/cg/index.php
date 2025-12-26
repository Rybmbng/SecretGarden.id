<?php echo view('partials/header', ['title' => 'Corporate Gift']); ?>

<section class="relative w-full bg-white text-black font-sans">

  <!-- Hero Banner -->
  <div class="relative h-[70vh] overflow-hidden">
    <img src="<?= base_url('assets/SGV/services/cu/background.jpeg') ?>" 
         alt="Corporate Gift Banner" 
         class="w-full h-full object-cover" />
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center bg-black/40">
      <h1 class="text-4xl md:text-6xl text-white font-light tracking-widest">
        Corporate Gift
      </h1>
      <p class="text-white mt-4 text-lg max-w-2xl">
        Transforming gifts into unforgettable experiences.
      </p>
    </div>
  </div>

  <!-- Brand Story -->
  <div class="max-w-4xl mx-auto px-6 py-20 text-center">
    <h3 class="text-xs font-bold tracking-[0.2em] uppercase text-[#c9ac6c]">SecretGarden.ID</h3>
    <h2 class="text-3xl md:text-4xl font-light tracking-wide my-6">
      Thoughtful Gifts for Meaningful Connections
    </h2>
    <p class="text-lg leading-relaxed text-gray-700">
      We curate gifts that go beyond objects — each one crafted to create lasting impressions.
      From elegant packaging to curated selections, we help you share gratitude with style.
    </p>
  </div>

  <!-- Value Proposition -->
  <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-10 px-6 pb-20 text-center">
    <div class="group">
      <div class="overflow-hidden rounded-2xl shadow-md">
        <img src="<?= base_url('assets/SGV/services/cg/img1.jpg') ?>" 
             alt="Packaging Service" 
             class="w-full h-72 object-cover transition-transform duration-700 group-hover:scale-105" />
      </div>
      <h3 class="mt-6 text-xl font-semibold text-[#c9ac6c]">Curated Packaging</h3>
      <p class="text-gray-600 mt-2 text-sm">
        Elegant wrapping, handpicked materials, and bespoke message cards for a truly unique experience.
      </p>
    </div>

    <div class="group">
      <div class="overflow-hidden rounded-2xl shadow-md">
        <img src="<?= base_url('assets/SGV/services/cg/img2.jpg') ?>" 
             alt="Delivery Service" 
             class="w-full h-72 object-cover transition-transform duration-700 group-hover:scale-105" />
      </div>
      <h3 class="mt-6 text-xl font-semibold text-[#c9ac6c]">Nationwide Delivery</h3>
      <p class="text-gray-600 mt-2 text-sm">
        Seamless, secure, and temperature-safe delivery across Indonesia to preserve the quality of every gift.
      </p>
    </div>

    <div class="group">
      <div class="overflow-hidden rounded-2xl shadow-md">
        <img src="<?= base_url('assets/SGV/services/cg/img3.jpg') ?>" 
             alt="Customer Support" 
             class="w-full h-72 object-cover transition-transform duration-700 group-hover:scale-105" />
      </div>
      <h3 class="mt-6 text-xl font-semibold text-[#c9ac6c]">Dedicated Support</h3>
      <p class="text-gray-600 mt-2 text-sm">
        Personalized assistance from consultation to delivery, ensuring a smooth and thoughtful process.
      </p>
    </div>
  </div>

  <!-- CTA Section -->
  <div class="bg-[#f8f8f8] py-16 text-center">
    <h4 class="text-xl text-gray-700 mb-6">Looking to create your next memorable corporate gifting moment?</h4>
    <a href="<?= base_url('services/contactus') ?>" 
       class="inline-block px-8 py-3 border border-[#c9ac6c] text-[#c9ac6c] hover:bg-[#c9ac6c] hover:text-black rounded-full transition duration-300">
      Start Your Journey
    </a>
  </div>

</section>

<?php echo view('partials/footer'); ?>
