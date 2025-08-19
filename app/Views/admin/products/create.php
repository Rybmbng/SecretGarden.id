<?= view('adminpartial/header'); ?>

<div class="max-w-5xl mx-auto py-12 px-6">
  <!-- Title -->
  <h1 class="text-3xl font-extrabold mb-8 text-gray-800 flex items-center gap-2">
    <span>Add New Product</span>
  </h1>

  <!-- Step Indicator -->
  <div class="flex items-center justify-center mb-10">
    <div class="flex items-center space-x-8 text-sm font-medium">
      <span class="step-indicator cursor-pointer flex items-center gap-2 text-blue-600" data-step="0">① Product Info</span>
      <span class="step-indicator cursor-pointer flex items-center gap-2 text-gray-400" data-step="1">② Variants</span>
      <span class="step-indicator cursor-pointer flex items-center gap-2 text-gray-400" data-step="2">③ Sections</span>
    </div>
  </div>

  <form action="<?= base_url('admin/products/store') ?>" method="post" enctype="multipart/form-data" class="space-y-10">
    <?= csrf_field() ?>

    <div id="form-sections">
      <!-- Step 1: Product Info -->
      <section id="step-product" class="form-step bg-white p-8 rounded-2xl shadow-lg space-y-6 mb-10">
        <h2 class="text-xl font-bold text-gray-700 border-b pb-3">📄 Product Information</h2>

        <div class="grid md:grid-cols-2 gap-6">
          <div>
            <label class="block font-medium mb-1">Product Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" required placeholder="e.g. Herbal Tea Candle" class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
          </div>
          <div>
            <label class="block font-medium mb-1">Category <span class="text-red-500">*</span></label>
            <select name="category_id" required class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <option value="">-- Select Category --</option>
              <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= esc($cat['name']) ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>

        <div>
          <label class="block font-medium mb-1">Main Images</label>
          <input type="file" name="main_images" id="main-image-input" multiple accept="image/*" class="w-full border px-4 py-2 rounded-lg">
          <div id="main-image-preview" class="flex gap-3 mt-3 flex-wrap"></div>
        </div>

        <div>
          <label class="block font-medium mb-1">Description</label>
          <textarea name="description" rows="4" class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Write something about the product..."></textarea>
        </div>
      </section>

      <!-- Step 2: Variants -->
      <section id="step-variant" class="form-step bg-white p-8 rounded-2xl shadow-lg space-y-6 mb-10 hidden">
        <h2 class="text-xl font-bold text-gray-700 border-b pb-3">🧩 Product Variants</h2>

        <div id="variants-container" class="space-y-auto">
          <div class="variant-group grid grid-row-4 md:grid-cols-2 gap-6 relative border border-gray-200 p-5 rounded-xl bg-gray-50" data-variant-index="0">
            <button type="button" class="remove-variant absolute -top-3 -right-3 bg-red-500 text-white w-7 h-7 rounded-full shadow hover:bg-red-600" title="Remove Variant">×</button>
            <input type="text" name="variant_name[]" placeholder="Variant Name" required class="border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400">
            <input type="number" name="variant_price[]" placeholder="Price" class="border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400">
            <input type="text" name="variant_sku[]" placeholder="SKU" class="border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400">
            <input type="number" name="variant_stock[]" placeholder="Stock" class="border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400">
            <textarea name="variant_desc[]" rows="2" placeholder="Variant Description" class="border px-4 py-2 rounded-lg col-span-2 focus:ring-2 focus:ring-blue-400"></textarea>
            <div class="col-span-1">
              <label class="block mb-1 font-medium">Variant Images</label>
              <div class="variant-image-group space-y-2">
                <input type="file" name="variant_images_0[]" multiple accept="image/*" class="variant-file border px-4 py-2 rounded-lg w-full" />
                <div class="variant-image-preview flex gap-2 flex-wrap mt-2"></div>
                <button type="button" class="add-variant-image bg-blue-500 text-white text-xs px-3 py-1 rounded hover:bg-blue-600 mt-2">+ Add Image</button>
              </div>
            </div>
          </div>
        </div>

        <button type="button" id="add-variant" class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700">+ Add Variant</button>
      </section>

      <!-- Step 3: Sections -->
      <section id="step-section" class="form-step bg-white p-8 rounded-2xl shadow-lg space-y-6 mb-10 hidden">
        <h2 class="text-xl font-bold text-gray-700 border-b pb-3">📦 Product Sections</h2>

        <div id="sections-container" class="space-y-6">
          <div class="section-group grid md:grid-cols-2 gap-6 relative border border-gray-200 p-5 rounded-xl bg-gray-50" data-section-index="0">
            <button type="button" class="remove-section absolute -top-3 -right-3 bg-red-500 text-white w-7 h-7 rounded-full shadow hover:bg-red-600" title="Remove Section">×</button>
            
            <select name="section_type[]" class="border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400">
              <option value="story">Story</option>
              <option value="directions">Directions</option>
              <option value="characteristics">Characteristics</option>
              <option value="ingredients">Ingredients</option>
            </select>
            <input type="text" name="section_header[]" placeholder="Section Title" class="border px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-400">
            <textarea name="section_detail[]" rows="3" placeholder="Section Content" class="border px-4 py-2 rounded-lg col-span-2 focus:ring-2 focus:ring-blue-400"></textarea>
          </div>
        </div>

        <button type="button" id="add-section" class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700">+ Add Section</button>
      </section>
    </div>

    <div class="flex justify-between items-center mt-10">
      <button type="button" id="prev-section" class="bg-gray-400 text-white px-6 py-2 rounded-lg hover:bg-gray-500 hidden">← Previous</button>
      <button type="button" id="next-section" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Next →</button>
      <button type="submit" id="submit-btn" class="bg-blue-700 text-white px-6 py-2 rounded-lg hover:bg-blue-800 hidden">💾 Save Product</button>
    </div>
  </form>
</div>

<script>
let currentStep = 0;
const steps = document.querySelectorAll('.form-step');
const indicators = document.querySelectorAll('.step-indicator');
const nextBtn = document.getElementById('next-section');
const prevBtn = document.getElementById('prev-section');
const submitBtn = document.getElementById('submit-btn');

let variantIndex = 1;

function showStep(idx){
  steps.forEach((step,i)=>step.classList.toggle('hidden', i!==idx));
  indicators.forEach((ind,i)=>{
    ind.classList.toggle('text-blue-600', i===idx);
    ind.classList.toggle('text-gray-400', i!==idx);
  });
  prevBtn.classList.toggle('hidden', idx===0);
  nextBtn.classList.toggle('hidden', idx===steps.length-1);
  submitBtn.classList.toggle('hidden', idx!==steps.length-1);
}

indicators.forEach(ind => {
  ind.addEventListener('click', () => {
    const step = parseInt(ind.getAttribute('data-step'));
    currentStep = step;
    showStep(currentStep);
  });
});

nextBtn.addEventListener('click', ()=>{
  if(currentStep===0){
    const name = document.querySelector('input[name="name"]').value.trim();
    const cat = document.querySelector('select[name="category_id"]').value;
    if(!name || !cat){ alert("Please fill product name and category."); return; }
  }
  if(currentStep < steps.length-1){ currentStep++; showStep(currentStep); }
});

prevBtn.addEventListener('click', ()=>{
  if(currentStep>0){ currentStep--; showStep(currentStep); }
});

showStep(currentStep);

document.getElementById('main-image-input').addEventListener('change', function(e){
  const preview = document.getElementById('main-image-preview');
  preview.innerHTML='';
  Array.from(e.target.files).forEach((file,idx)=>{
    if(!file.type.startsWith('image/')) return;
    const reader = new FileReader();
    reader.onload = ev=>{
      const wrapper = document.createElement('div');
      wrapper.className="relative";
      const img=document.createElement('img');
      img.src=ev.target.result;
      img.className="h-20 w-20 object-cover rounded border";
      const btn=document.createElement('button');
      btn.type="button";
      btn.innerText="×";
      btn.className="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-5 h-5 text-xs";
      btn.addEventListener('click', ()=>{
        const dt = new DataTransfer();
        Array.from(e.target.files).forEach((f,i)=>{ if(i!==idx) dt.items.add(f); });
        e.target.files = dt.files;
        wrapper.remove();
      });
      wrapper.appendChild(img);
      wrapper.appendChild(btn);
      preview.appendChild(wrapper);
    };
    reader.readAsDataURL(file);
  });
});

document.getElementById('add-variant').addEventListener('click', ()=>{
  const container=document.getElementById('variants-container');
  const template=container.querySelector('.variant-group');
  const clone=template.cloneNode(true);
  clone.setAttribute('data-variant-index', variantIndex);
  clone.querySelectorAll('input,textarea').forEach(input=>{
    if(input.type==='file') input.setAttribute('name', 'variant_images_'+variantIndex+'[]');
    else input.value='';
  });
  const preview = clone.querySelector('.variant-image-preview'); if(preview) preview.innerHTML='';
  container.appendChild(clone);
  variantIndex++;
});

document.getElementById('add-section').addEventListener('click', ()=>{
  const container=document.getElementById('sections-container');
  const template=container.firstElementChild.cloneNode(true);
  const index = container.children.length;
  template.setAttribute('data-section-index', index);
  template.querySelectorAll('input,textarea,select').forEach(el=>el.value='');
  container.appendChild(template);
});

document.addEventListener('click', e=>{
  if(e.target.classList.contains('remove-variant')){
    const group=e.target.closest('.variant-group');
    if(group.parentNode.children.length>1) group.remove();
    else alert("At least one variant required.");
  }
  if(e.target.classList.contains('remove-section')){
    const group=e.target.closest('.section-group');
    if(group.parentNode.children.length>1) group.remove();
    else alert("At least one section required.");
  }
  if(e.target.classList.contains('add-variant-image')){
    const group=e.target.closest('.variant-image-group');
    const indexMatch = group.querySelector('input[type="file"]').name.match(/variant_images_(\d+)/);
    if(!indexMatch) return;
    const index=indexMatch[1];
    const newInput=document.createElement('input');
    newInput.type='file';
    newInput.name=`variant_images_${index}[]`;
    newInput.accept='image/*';
    newInput.className='variant-file border px-4 py-2 rounded-lg w-full';
    group.insertBefore(newInput, group.querySelector('.variant-image-preview'));
  }
});

document.addEventListener('change', e=>{
  if(e.target.classList.contains('variant-file')){
    const preview=e.target.closest('.variant-image-group').querySelector('.variant-image-preview');
    preview.innerHTML='';
    Array.from(e.target.files).forEach(file=>{
      if(!file.type.startsWith('image/')) return;
      const reader=new FileReader();
      reader.onload=ev=>{
        const wrapper=document.createElement('div');
        wrapper.className="relative";
        const img=document.createElement('img');
        img.src=ev.target.result;
        img.className="h-16 w-16 object-cover rounded border";
        const btn=document.createElement('button');
        btn.type="button";
        btn.innerText="×";
        btn.className="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 text-xs";
        btn.addEventListener('click', ()=>{ wrapper.remove(); });
        wrapper.appendChild(img);
        wrapper.appendChild(btn);
        preview.appendChild(wrapper);
      };
      reader.readAsDataURL(file);
    });
  }
});
</script>

<?= view('adminpartial/footer'); ?>
