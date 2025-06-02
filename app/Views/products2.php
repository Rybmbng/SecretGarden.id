<?= $this->include('partials/header') ?>


<div class="mb-8 flex justify-center flex-wrap gap-4 mt-20">
    <a href="/products"
       class="px-5 py-2 rounded-full border font-semibold transition
           <?= $activeCategory === 'all' ? 'bg-indigo-700 text-white border-indigo-700' : 'border-gray-400 text-gray-700 hover:bg-indigo-600 hover:text-white' ?>">
        All
    </a>
    <?php foreach ($categories as $category): ?>
    <a href="/products/category/<?= esc($category) ?>"
       class="px-5 py-2 rounded-full border font-semibold transition
           <?= $activeCategory === $category ? 'bg-indigo-700 text-white border-indigo-700' : 'border-gray-400 text-gray-700 hover:bg-indigo-600 hover:text-white' ?>">
        <?= esc($category) ?>
    </a>
    <?php endforeach; ?>
</div>

<div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 px-4 mb-20">
    <?php if(empty($products)): ?>
        <p class="col-span-full text-center text-gray-500">No products found in this category.</p>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
       <div tabindex="0" role="button" onclick="location.href='/product/<?= esc($product['slug']) ?>'" 
        onkeypress="if(event.key==='Enter'){location.href='/product/<?= esc($product['slug']) ?>'}"
        class="bg-white rounded-2xl shadow-lg cursor-pointer overflow-hidden transform hover:scale-[1.03] transition-transform duration-300">
        <img src="<?= esc($product['image_url']) ?: 'https://via.placeholder.com/400x300?text=No+Image' ?>"
            alt="<?= esc($product['name']) ?>"
            class="w-full h-48 object-cover" />
        <div class="p-5">
            <h2 class="text-xl font-semibold text-gray-900 mb-2"><?= esc($product['name']) ?></h2>
            <p class="text-indigo-600 font-bold text-lg mb-3"><?= 'Rp. ' . number_format($product['price'], 0, ',', '.') ?></p>
            <p class="text-gray-700 line-clamp-3 mb-4"><?= esc($product['description']) ?></p>
            <span class="inline-block px-3 py-1 text-sm text-indigo-700 bg-indigo-100 rounded-full font-semibold">
                <?= esc($product['category']) ?>
            </span>
        </div>
    </div>

        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div id="modalBackdrop" 
     class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-6">
  <div id="modalContent" 
       class="bg-white rounded-3xl shadow-2xl max-w-5xl w-full max-h-[90vh] overflow-y-auto relative p-10 transform scale-90 opacity-0 transition duration-300">
    <button onclick="closeModal()" 
            class="absolute top-6 right-6 text-gray-600 hover:text-gray-900 text-5xl font-extrabold leading-none select-none">&times;</button>
    <div class="flex flex-col md:flex-row gap-12">
      <img id="modalImage" src="" alt="" class="rounded-xl md:w-1/2 w-full h-96 object-cover shadow-xl" />
      <div class="md:w-1/2 flex flex-col justify-between">
        <div>
          <h2 id="modalName" class="text-4xl font-extrabold mb-6 text-gray-900"></h2>
          <p id="modalCategory" class="inline-block mb-6 px-5 py-2 text-indigo-700 bg-indigo-100 rounded-full font-semibold"></p>
          <p id="modalPrice" class="text-indigo-700 text-3xl font-extrabold mb-8"></p>
          <p id="modalDescription" class="text-gray-800 leading-relaxed text-lg"></p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function openModal(product) {
    const backdrop = document.getElementById('modalBackdrop');
    const modal = document.getElementById('modalContent');
    document.getElementById('modalImage').src = product.image_url || 'https://via.placeholder.com/600x400?text=No+Image';
    document.getElementById('modalImage').alt = product.name;
    document.getElementById('modalName').textContent = product.name;
    document.getElementById('modalCategory').textContent = product.category;
    document.getElementById('modalPrice').textContent = `Rp. ${parseFloat(product.price).toLocaleString('id-ID')}`;
    document.getElementById('modalDescription').textContent = product.description || 'No description available.';

    backdrop.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.remove('scale-90', 'opacity-0');
    }, 20);
}

function closeModal() {
    const backdrop = document.getElementById('modalBackdrop');
    const modal = document.getElementById('modalContent');
    modal.classList.add('scale-90', 'opacity-0');
    setTimeout(() => {
        backdrop.classList.add('hidden');
    }, 300);
}

document.getElementById('modalBackdrop').addEventListener('click', (e) => {
    if(e.target === e.currentTarget) {
        closeModal();
    }
});

document.addEventListener('keydown', (e) => {
    if(e.key === "Escape") {
        closeModal();
    }
});
</script>

<?= $this->include('partials/footer') ?>
