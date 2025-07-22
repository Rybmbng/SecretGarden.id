<?= view('adminpartial/header'); ?>

<div class="max-w-5xl mx-auto py-10 px-6">
  <h1 class="text-3xl font-bold mb-8 text-gray-800">🛍️ Add New Product</h1>

  <form action="<?= base_url('admin/products/store') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div id="form-sections"><?= view('adminpartial/header'); ?>

<div class="max-w-5xl mx-auto py-10 px-6">
  <h1 class="text-3xl font-bold mb-8 text-gray-800">🛍️ Add New Product</h1>

  <form action="<?= base_url('admin/products/store') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div id="form-sections">
      <!-- Step 1: Product Info -->
      <section id="step-product" class="form-step bg-white p-8 rounded-2xl shadow-md space-y-6 mb-10">
        <h2 class="text-xl font-bold text-gray-700 border-b pb-2">📄 Product Information</h2>

        <div class="grid md:grid-cols-2 gap-6">
          <div>
            <label class="block font-medium mb-1">Product Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" required placeholder="e.g. Herbal Tea Candle" class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400">
          </div>
          <div>
            <label class="block font-medium mb-1">Category <span class="text-red-500">*</span></label>
            <select name="category_id" required class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400">
              <option value="">-- Select Category --</option>
              <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= esc($cat['name']) ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>

        <div>
          <label class="block font-medium mb-1">Main Images</label>
          <input type="file" name="variant_images_0[]" id="main-image-input" multiple accept="image/*" class="w-full border px-4 py-2 rounded-lg">
          <div id="main-image-preview" class="flex gap-2 mt-3 flex-wrap"></div>
        </div>

        <div>
          <label class="block font-medium mb-1">Description</label>
          <textarea name="description" rows="4" class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400" placeholder="Write something about the product..."></textarea>
        </div>
      </section>

      <!-- Step 2: Variant -->
      <section id="step-variant" class="form-step bg-white p-8 rounded-2xl shadow-md space-y-6 mb-10 hidden">
        <h2 class="text-xl font-bold text-gray-700 border-b pb-2">🧩 Product Variants</h2>
        <div id="variants-container" class="space-y-6">
          <div class="variant-group grid md:grid-cols-2 gap-6 relative border p-4 rounded-lg bg-gray-50">
            <button type="button" class="remove-variant absolute top-2 right-2 text-red-500 hover:text-red-700 font-bold text-lg" title="Remove Variant">×</button>
            <input type="text" name="variant_name[]" placeholder="Variant Name" required class="border px-4 py-2 rounded-lg" />
            <input type="number" name="variant_price[]" placeholder="Price" class="border px-4 py-2 rounded-lg" />
            <input type="text" name="variant_sku[]" placeholder="SKU" class="border px-4 py-2 rounded-lg" />
            <input type="number" name="variant_stock[]" placeholder="Stock" class="border px-4 py-2 rounded-lg" />
            <textarea name="variant_desc[]" rows="2" placeholder="Variant Description" class="border px-4 py-2 rounded-lg col-span-2"></textarea>
            <div class="col-span-2">
              <label class="block mb-1 font-medium">Variant Images</label>
              <div class="variant-image-group space-y-2">
                <input type="file" name="variant_images_0[]" multiple accept="image/*" class="variant-file border px-4 py-2 rounded-lg w-full" />
                <div class="variant-image-preview flex gap-2 flex-wrap mt-2"></div>
                <button type="button" class="add-variant-image bg-blue-500 text-white text-sm px-3 py-1 rounded hover:bg-blue-600 mt-2">+ Add Image</button>
              </div>
            </div>

          </div>
        </div>
        <button type="button" id="add-variant" class="bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700">+ Add Variant</button>
      </section>

      <!-- Step 3: Section -->
      <section id="step-section" class="form-step bg-white p-8 rounded-2xl shadow-md space-y-6 mb-10 hidden">
        <h2 class="text-xl font-bold text-gray-700 border-b pb-2">📦 Product Sections</h2>
        <div id="sections-container" class="space-y-6">
          <div class="section-group grid md:grid-cols-2 gap-6 relative border p-4 rounded-lg bg-gray-50">
            <button type="button" class="remove-section absolute top-2 right-2 text-red-500 hover:text-red-700 font-bold text-lg" title="Remove Section">×</button>
            <select name="section_type[]" class="border px-4 py-2 rounded-lg">
              <option value="story">Story</option>
              <option value="directions">Directions</option>
              <option value="characteristics">Characteristics</option>
              <option value="ingredients">Ingredients</option>
            </select>
            <input type="text" name="section_header[]" placeholder="Section Title" class="border px-4 py-2 rounded-lg" />
            <textarea name="section_detail[]" rows="3" placeholder="Section Content" class="border px-4 py-2 rounded-lg col-span-2"></textarea>
          </div>
        </div>
        <button type="button" id="add-section" class="bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700">+ Add Section</button>
      </section>
    </div>

    <!-- Navigation Buttons -->
    <div class="flex justify-between items-center mt-10">
      <button type="button" id="prev-section" class="bg-gray-400 text-white px-5 py-2 rounded hover:bg-gray-500 hidden">← Previous</button>
      <button type="button" id="next-section" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">Next →</button>
      <button type="submit" id="submit-btn" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 hidden">💾 Save Product</button>
    </div>
  </form>
</div>

<!-- JS -->
<script>
  let currentStep = 0;
  const steps = document.querySelectorAll('.form-step');
  const nextBtn = document.getElementById('next-section');
  const prevBtn = document.getElementById('prev-section');
  const submitBtn = document.getElementById('submit-btn');

  function showStep(idx) {
    steps.forEach((step, i) => step.classList.toggle('hidden', i !== idx));
    prevBtn.classList.toggle('hidden', idx === 0);
    nextBtn.classList.toggle('hidden', idx === steps.length - 1);
    submitBtn.classList.toggle('hidden', idx !== steps.length - 1);
  }

  nextBtn.addEventListener('click', () => {
    if (currentStep < steps.length - 1) {
      currentStep++;
      showStep(currentStep);
    }
  });

  prevBtn.addEventListener('click', () => {
    if (currentStep > 0) {
      currentStep--;
      showStep(currentStep);
    }
  });

  showStep(currentStep);

  let variantIndex = 1;

  document.getElementById('add-variant').addEventListener('click', () => {
  const container = document.getElementById('variants-container');
  const template = container.firstElementChild.cloneNode(true);

  template.querySelectorAll('input, textarea').forEach(el => {
    if (el.type !== 'file') el.value = '';
  });
  const fileInput = template.querySelector('input[type="file"]');
  fileInput.name = `variant_images_${variantIndex}[]`;
  fileInput.setAttribute('multiple', 'multiple');
  fileInput.setAttribute('accept', 'image/*'); 

  variantIndex++;
  container.appendChild(template);
});


  document.getElementById('add-section').addEventListener('click', () => {
    const container = document.getElementById('sections-container');
    const template = container.firstElementChild.cloneNode(true);
    template.querySelectorAll('input, textarea, select').forEach(el => el.value = '');
    container.appendChild(template);
  });

  document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-variant')) {
      const group = e.target.closest('.variant-group');
      const container = document.getElementById('variants-container');
      if (container.children.length > 1) {
        group.remove();
      } else {
        alert("At least one variant is required.");
      }
    }
    if (e.target.classList.contains('remove-section')) {
      const group = e.target.closest('.section-group');
      const container = document.getElementById('sections-container');
      if (container.children.length > 1) {
        group.remove();
      } else {
        alert("At least one section is required.");
      }
    }
  });

  document.getElementById('main-image-input').addEventListener('change', function (e) {
    const preview = document.getElementById('main-image-preview');
    preview.innerHTML = '';
    Array.from(e.target.files).forEach(file => {
      if (!file.type.startsWith('image/')) return;
      const reader = new FileReader();
      reader.onload = function (ev) {
        const img = document.createElement('img');
        img.src = ev.target.result;
        img.className = "h-20 w-20 object-cover rounded border";
        preview.appendChild(img);
      };
      reader.readAsDataURL(file);
    });
  });

  // Event delegation: preview + add image input
document.addEventListener('change', function (e) {
  if (e.target.classList.contains('variant-file')) {
    const previewContainer = e.target.closest('.variant-image-group').querySelector('.variant-image-preview');
    previewContainer.innerHTML = '';

    Array.from(e.target.files).forEach(file => {
      if (!file.type.startsWith('image/')) return;
      const reader = new FileReader();
      reader.onload = function (ev) {
        const img = document.createElement('img');
        img.src = ev.target.result;
        img.className = "h-16 w-16 object-cover rounded border";
        previewContainer.appendChild(img);
      };
      reader.readAsDataURL(file);
    });
  }
});

document.addEventListener('click', function (e) {
  if (e.target.classList.contains('add-variant-image')) {
    const group = e.target.closest('.variant-image-group');
    const indexMatch = group.querySelector('input[type="file"]').name.match(/variant_images_(\d+)/);
    if (!indexMatch) return;

    const index = indexMatch[1];
    const newInput = document.createElement('input');
    newInput.type = 'file';
    newInput.name = `variant_images_${index}[]`;
    newInput.className = 'variant-file border px-4 py-2 rounded-lg w-full';
    newInput.accept = 'image/*';

    group.insertBefore(newInput, group.querySelector('.variant-image-preview'));
  }
});

</script>

<?= view('adminpartial/footer'); ?>

      <!-- Step 1: Product Info -->
      <section id="step-product" class="form-step bg-white p-8 rounded-2xl shadow-md space-y-6 mb-10">
        <h2 class="text-xl font-bold text-gray-700 border-b pb-2">📄 Product Information</h2>

        <div class="grid md:grid-cols-2 gap-6">
          <div>
            <label class="block font-medium mb-1">Product Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" required placeholder="e.g. Herbal Tea Candle" class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400">
          </div>
          <div>
            <label class="block font-medium mb-1">Category <span class="text-red-500">*</span></label>
            <select name="category_id" required class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400">
              <option value="">-- Select Category --</option>
              <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= esc($cat['name']) ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>

        <div>
          <label class="block font-medium mb-1">Main Images</label>
          <input type="file" name="variant_images_0[]" id="main-image-input" multiple accept="image/*" class="w-full border px-4 py-2 rounded-lg">
          <div id="main-image-preview" class="flex gap-2 mt-3 flex-wrap"></div>
        </div>

        <div>
          <label class="block font-medium mb-1">Description</label>
          <textarea name="description" rows="4" class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400" placeholder="Write something about the product..."></textarea>
        </div>
      </section>

      <!-- Step 2: Variant -->
      <section id="step-variant" class="form-step bg-white p-8 rounded-2xl shadow-md space-y-6 mb-10 hidden">
        <h2 class="text-xl font-bold text-gray-700 border-b pb-2">🧩 Product Variants</h2>
        <div id="variants-container" class="space-y-6">
          <div class="variant-group grid md:grid-cols-2 gap-6 relative border p-4 rounded-lg bg-gray-50">
            <button type="button" class="remove-variant absolute top-2 right-2 text-red-500 hover:text-red-700 font-bold text-lg" title="Remove Variant">×</button>
            <input type="text" name="variant_name[]" placeholder="Variant Name" required class="border px-4 py-2 rounded-lg" />
            <input type="number" name="variant_price[]" placeholder="Price" class="border px-4 py-2 rounded-lg" />
            <input type="text" name="variant_sku[]" placeholder="SKU" class="border px-4 py-2 rounded-lg" />
            <input type="number" name="variant_stock[]" placeholder="Stock" class="border px-4 py-2 rounded-lg" />
            <textarea name="variant_desc[]" rows="2" placeholder="Variant Description" class="border px-4 py-2 rounded-lg col-span-2"></textarea>
            <div class="col-span-2">
              <label class="block mb-1 font-medium">Variant Images</label>
              <input type="file" name="variant_images_0[]" multiple accept="image/*" class="border px-4 py-2 rounded-lg w-full" />
            </div>
          </div>
        </div>
        <button type="button" id="add-variant" class="bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700">+ Add Variant</button>
      </section>

      <!-- Step 3: Section -->
      <section id="step-section" class="form-step bg-white p-8 rounded-2xl shadow-md space-y-6 mb-10 hidden">
        <h2 class="text-xl font-bold text-gray-700 border-b pb-2">📦 Product Sections</h2>
        <div id="sections-container" class="space-y-6">
          <div class="section-group grid md:grid-cols-2 gap-6 relative border p-4 rounded-lg bg-gray-50">
            <button type="button" class="remove-section absolute top-2 right-2 text-red-500 hover:text-red-700 font-bold text-lg" title="Remove Section">×</button>
            <select name="section_type[]" class="border px-4 py-2 rounded-lg">
              <option value="story">Story</option>
              <option value="directions">Directions</option>
              <option value="characteristics">Characteristics</option>
              <option value="ingredients">Ingredients</option>
            </select>
            <input type="text" name="section_header[]" placeholder="Section Title" class="border px-4 py-2 rounded-lg" />
            <textarea name="section_detail[]" rows="3" placeholder="Section Content" class="border px-4 py-2 rounded-lg col-span-2"></textarea>
          </div>
        </div>
        <button type="button" id="add-section" class="bg-green-600 text-white px-5 py-2 rounded hover:bg-green-700">+ Add Section</button>
      </section>
    </div>

    <!-- Navigation Buttons -->
    <div class="flex justify-between items-center mt-10">
      <button type="button" id="prev-section" class="bg-gray-400 text-white px-5 py-2 rounded hover:bg-gray-500 hidden">← Previous</button>
      <button type="button" id="next-section" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">Next →</button>
      <button type="submit" id="submit-btn" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 hidden">💾 Save Product</button>
    </div>
  </form>
</div>

<!-- JS -->
<script>
  let currentStep = 0;
  const steps = document.querySelectorAll('.form-step');
  const nextBtn = document.getElementById('next-section');
  const prevBtn = document.getElementById('prev-section');
  const submitBtn = document.getElementById('submit-btn');

  function showStep(idx) {
    steps.forEach((step, i) => step.classList.toggle('hidden', i !== idx));
    prevBtn.classList.toggle('hidden', idx === 0);
    nextBtn.classList.toggle('hidden', idx === steps.length - 1);
    submitBtn.classList.toggle('hidden', idx !== steps.length - 1);
  }

  nextBtn.addEventListener('click', () => {
    if (currentStep < steps.length - 1) {
      currentStep++;
      showStep(currentStep);
    }
  });

  prevBtn.addEventListener('click', () => {
    if (currentStep > 0) {
      currentStep--;
      showStep(currentStep);
    }
  });

  showStep(currentStep);

  let variantIndex = 1;

  document.getElementById('add-variant').addEventListener('click', () => {
    const container = document.getElementById('variants-container');
    const template = container.firstElementChild.cloneNode(true);
    template.querySelectorAll('input, textarea').forEach(el => el.type !== 'file' && (el.value = ''));
    const fileInput = template.querySelector('input[type="file"]');
    fileInput.name = `variant_images_${variantIndex}[]`;
    variantIndex++;
    container.appendChild(template);
  });

  document.getElementById('add-section').addEventListener('click', () => {
    const container = document.getElementById('sections-container');
    const template = container.firstElementChild.cloneNode(true);
    template.querySelectorAll('input, textarea, select').forEach(el => el.value = '');
    container.appendChild(template);
  });

  document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-variant')) {
      const group = e.target.closest('.variant-group');
      const container = document.getElementById('variants-container');
      if (container.children.length > 1) {
        group.remove();
      } else {
        alert("At least one variant is required.");
      }
    }
    if (e.target.classList.contains('remove-section')) {
      const group = e.target.closest('.section-group');
      const container = document.getElementById('sections-container');
      if (container.children.length > 1) {
        group.remove();
      } else {
        alert("At least one section is required.");
      }
    }
  });

  document.getElementById('main-image-input').addEventListener('change', function (e) {
    const preview = document.getElementById('main-image-preview');
    preview.innerHTML = '';
    Array.from(e.target.files).forEach(file => {
      if (!file.type.startsWith('image/')) return;
      const reader = new FileReader();
      reader.onload = function (ev) {
        const img = document.createElement('img');
        img.src = ev.target.result;
        img.className = "h-20 w-20 object-cover rounded border";
        preview.appendChild(img);
      };
      reader.readAsDataURL(file);
    });
  });
</script>

<?= view('adminpartial/footer'); ?>
