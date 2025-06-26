<?= view('adminpartial/header'); ?>

<div class="max-w-4xl mx-auto py-10 px-4">
  <h1 class="text-2xl font-bold mb-6 text-gray-800">Add New Product</h1>

  <form action="<?= base_url('admin/products/store') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <!-- Product Info -->
  <div id="form-sections">
    <section id="step-product" class="form-step space-y-4 bg-white p-6 rounded shadow mb-8">
      <h2 class="text-lg font-semibold text-gray-700">Product Information</h2>

      <input type="text" name="name" placeholder="Product Name" required class="w-full border px-3 py-2 rounded">

      <select name="category_id" required class="w-full border px-3 py-2 rounded">
        <option value="">-- Select Category --</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= $cat['id'] ?>"><?= esc($cat['name']) ?></option>
        <?php endforeach ?>
      </select>
      <label class="block font-medium mb-1">Main Image</label> 
      <input type="file" name="variant_images_0[]" id="main-image-input" multiple accept="image/*" class="w-full border px-3 py-2 rounded">
      <div id="main-image-preview" class="flex flex-wrap gap-2 mt-2"></div>
      <textarea name="description" placeholder="Description" rows="3" class="w-full border px-3 py-2 rounded"></textarea>
    </section>
    <!-- Multi-step Sections -->
    
      <!-- Step 1: Variant -->
      <section id="step-variant" class="form-step bg-white p-6 rounded shadow mb-8">
        <h2 class="text-lg font-semibold text-gray-700">Variant</h2>
        <div id="variants-container" class="space-y-6">
          <div class="variant-group">
            <input type="text" name="variant_name[]" placeholder="Variant Name" required class="w-full border px-3 py-2 rounded">
            <input type="number" name="variant_price[]" placeholder="Price" class="w-full border px-3 py-2 rounded">
            <input type="text" name="variant_sku[]" placeholder="SKU" class="w-full border px-3 py-2 rounded">
            <input type="number" name="variant_stock[]" placeholder="Stock" class="w-full border px-3 py-2 rounded">
            <textarea name="variant_desc[]" placeholder="Variant Description" rows="2" class="w-full border px-3 py-2 rounded"></textarea>
            <label class="block font-medium mb-1">Variant Image</label>
            <input type="file" name="variant_images_0[]" multiple accept="image/*" class="w-full border px-3 py-2 rounded">
          </div>
        </div>
        <button type="button" id="add-variant" class="mt-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">+ Add Variant</button>
      </section>

      <!-- Step 2: Section -->
      <section id="step-section" class="form-step bg-white p-6 rounded shadow mb-8 hidden">
        <h2 class="text-lg font-semibold text-gray-700">Product Section</h2>
        <div id="sections-container" class="space-y-6">
          <div class="section-group">
            <select name="section_type[]" class="w-full border px-3 py-2 rounded">
              <option value="story">Story</option>
              <option value="directions">Directions</option>
              <option value="characteristics">Characteristics</option>
              <option value="ingredients">Ingredients</option>
            </select>
            <input type="text" name="section_header[]" placeholder="Section Title" class="w-full border px-3 py-2 rounded">
            <textarea name="section_detail[]" placeholder="Section Content" rows="3" class="w-full border px-3 py-2 rounded"></textarea>
          </div>
        </div>
        <button type="button" id="add-section" class="mt-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">+ Add Section</button>
      </section>
    </div>

    <!-- Navigation Buttons -->
    <div class="mt-6 flex justify-between">
      <button type="button" id="prev-section" class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded hidden">Previous</button>
      <button type="button" id="next-section" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">Next</button>
      <button type="submit" id="submit-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded hidden">Save</button>
    </div>
  </form>

  <script>
  let currentStep = 0;
  const steps = document.querySelectorAll('.form-step');
  const nextBtn = document.getElementById('next-section');
  const prevBtn = document.getElementById('prev-section');
  const submitBtn = document.getElementById('submit-btn');

  function showStep(idx) {
    steps.forEach((step, i) => {
      step.classList.toggle('hidden', i !== idx);
    });
    prevBtn.classList.toggle('hidden', idx === 0);
    nextBtn.classList.toggle('hidden', idx === steps.length - 1);
    submitBtn.classList.toggle('hidden', idx !== steps.length - 1);
  }

  nextBtn.addEventListener('click', function () {
    if (currentStep < steps.length - 1) {
      currentStep++;
      showStep(currentStep);
    }
  });

  prevBtn.addEventListener('click', function () {
    if (currentStep > 0) {
      currentStep--;
      showStep(currentStep);
    }
  });

  showStep(currentStep);

  let variantIndex = 1;

  document.getElementById('add-variant').addEventListener('click', function () {
    const container = document.getElementById('variants-container');
    const newGroup = container.firstElementChild.cloneNode(true);

    newGroup.querySelectorAll('input, textarea').forEach(el => {
      if (el.type !== 'file') el.value = '';
    });

    const fileInput = newGroup.querySelector('input[type="file"]');
    fileInput.name = `variant_images_${variantIndex}[]`;
    variantIndex++;

    container.appendChild(newGroup);
  });

  document.getElementById('add-section').addEventListener('click', function () {
    const container = document.getElementById('sections-container');
    const newGroup = container.firstElementChild.cloneNode(true);

    newGroup.querySelectorAll('input, textarea, select').forEach(el => {
      el.value = '';
    });

    container.appendChild(newGroup);
  });
  </script>
</div>

<script>
let variantIndex = 1;

document.getElementById('add-variant').addEventListener('click', function () {
  const container = document.getElementById('variants-container');
  const newGroup = container.firstElementChild.cloneNode(true);

  newGroup.querySelectorAll('input, textarea').forEach(el => {
    if (el.type !== 'file') el.value = '';
  });

  const fileInput = newGroup.querySelector('input[type="file"]');
  fileInput.name = `variant_images_${variantIndex}[]`;
  variantIndex++;

  container.appendChild(newGroup);
});

document.getElementById('add-section').addEventListener('click', function () {
  const container = document.getElementById('sections-container');
  const newGroup = container.firstElementChild.cloneNode(true);

  // Clear all input values
  newGroup.querySelectorAll('input, textarea, select').forEach(el => {
    el.value = '';
  });

  container.appendChild(newGroup);
});
</script>

<script>
      document.getElementById('main-image-input').addEventListener('change', function(e) {
        const preview = document.getElementById('main-image-preview');
        preview.innerHTML = '';
        Array.from(e.target.files).forEach(file => {
          if (!file.type.startsWith('image/')) return;
          const reader = new FileReader();
          reader.onload = function(ev) {
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
