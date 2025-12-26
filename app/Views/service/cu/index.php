<?php echo view('partials/header', ['title' => 'Service Us']); ?>

<section class="relative w-full bg-white text-gray-800">

  <!-- Hero Section -->
  <div class="relative h-[50vh] md:h-[70vh] overflow-hidden">
    <img src="<?= base_url('assets/SGV/services/cu/background.jpeg') ?>" 
         alt="Service Banner" 
         class="absolute inset-0 w-full h-full object-cover brightness-75" />
    <div class="absolute inset-0 flex items-center justify-center">
      <h1 class="text-4xl md:text-6xl font-extrabold tracking-wide text-white drop-shadow-lg">
        Our Service
      </h1>
    </div>
  </div>

  <!-- Description -->
  <div class="max-w-3xl mx-auto px-6 py-12 text-center space-y-4">
    <h2 class="text-2xl md:text-3xl font-semibold text-gray-800">
      Get in Touch
    </h2>
    <p class="text-gray-600 text-lg">
      Have questions, feedback, or business inquiries? Fill out the form below and our team will respond as soon as possible.
    </p>
  </div>

  <!-- Contact Form -->
  <section class="max-w-2xl mx-auto py-10 px-6 bg-white rounded-2xl shadow-xl border border-gray-100">
    <h2 class="text-3xl font-bold mb-6 text-gray-900 text-center">Contact Us</h2>

    <?php if (session()->getFlashdata('success')): ?>
      <div class="mb-4 flex items-center gap-2 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
        <i class="fas fa-check-circle"></i>
        <span><?= session()->getFlashdata('success') ?></span>
      </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="mb-4 flex items-center gap-2 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
        <i class="fas fa-exclamation-circle"></i>
        <span><?= session()->getFlashdata('error') ?></span>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('services/contact-us/send') ?>" method="post" class="space-y-5">
      <div>
        <label for="name" class="block mb-1 font-semibold text-gray-700">Name</label>
        <input id="name" type="text" name="name" required
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"/>
      </div>

      <div>
        <label for="email" class="block mb-1 font-semibold text-gray-700">Email</label>
        <input id="email" type="email" name="email" required
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"/>
      </div>

      <div>
        <label for="message" class="block mb-1 font-semibold text-gray-700">Message</label>
        <textarea id="message" name="message" rows="5" required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"></textarea>
      </div>

      <button type="submit"
              class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-black px-6 py-3 rounded-lg shadow-md hover:from-blue-700 hover:to-blue-800 transition-all duration-200">
        <i class="fas fa-paper-plane mr-2"></i> Send Message
      </button>
    </form>
  </section>

</section>

<?php echo view('partials/footer'); ?>
