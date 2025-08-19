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
    <section class="max-w-3xl mx-auto py-12 px-6 bg-white rounded-xl shadow-lg">
    <h2 class="text-4xl font-bold mb-6 text-gray-800 text-center">Contact Us</h2>

    <?php if(session()->getFlashdata('success')): ?>
      <div class="mb-4 p-4 bg-green-100 text-green-800 rounded"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
      <div class="mb-4 p-4 bg-red-100 text-red-800 rounded"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('services/contactus/send') ?>" method="post" class="space-y-4">
      <div>
        <label class="block mb-1 font-semibold text-gray-700">Name</label>
        <input type="text" name="name" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"/>
      </div>
      <div>
        <label class="block mb-1 font-semibold text-gray-700">Email</label>
        <input type="email" name="email" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"/>
      </div>
      <div>
        <label class="block mb-1 font-semibold text-gray-700">Message</label>
        <textarea name="message" rows="5" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">Send Message</button>
    </form>
  </section>

  <!-- Call to Action -->
  <div class="text-center py-16">
    <h4 class="text-xl text-black-300 mb-4">Need a tailored service or corporate gift?</h4>
    <a href="<?= base_url('contact') ?>" class="inline-block px-6 py-3 border border-[#c9ac6c] text-[#c9ac6c] hover:bg-[#c9ac6c] hover:text-black transition duration-300 rounded-full">
      Contact Us
    </a>
  </div>
</section>

<?php echo view('partials/footer'); ?>
