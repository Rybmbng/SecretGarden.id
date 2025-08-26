<?= view('adminpartial/header'); ?>

<div class="w-full mx-auto px-6 py-10 min-h-screen">

  <!-- Header -->
  <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
    <h1 class="text-3xl sm:text-4xl font-bold text-gray-800">Product Management</h1>
    <a href="<?= base_url('/admin/products/create') ?>"
       class="inline-flex items-center bg-amber-500 text-black font-medium px-6 py-3 rounded-lg shadow hover:bg-amber-600 transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
      </svg>
      Add Product
    </a>
  </div>

  <!-- Search -->
  <div class="mb-6 flex justify-end">
    <input id="searchInput" type="text" placeholder="🔍 Search products..."
      class="w-full max-w-sm px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-amber-400 text-gray-700 placeholder-gray-400 shadow-sm" />
  </div>

  <!-- Table -->
  <div class="overflow-x-auto bg-white shadow rounded-lg">
    <table class="min-w-full border-collapse">
      <thead>
        <tr class="bg-amber-100 text-left text-gray-700 text-sm uppercase">
          <th class="px-4 py-3 border-b">Image</th>
          <th class="px-4 py-3 border-b">Name</th>
          <th class="px-4 py-3 border-b">Category</th>
          <th class="px-4 py-3 border-b">Slug</th>
          <th class="px-4 py-3 border-b">Main</th>
          <th class="px-4 py-3 border-b">SlideShowHome</th>
          <th class="px-4 py-3 border-b text-center">Actions</th>
        </tr>
      </thead>
      <tbody id="productsTable">
        <?php foreach ($products as $product): ?>
          <?php
            $categoryPath = $product['category_path'] ?? 'default';
            $variantSlug = isset($product['name']) ? url_title($product['name'], '-', true) : 'default-product';
            $imageFile = $product['main_images'] ?? 'default-product.jpg';
            $slug = str_replace('-', ' ', strtolower($variantSlug)); 
            $pretty = ucwords($slug);                            
            $final = str_replace(' ', '-', $pretty);  
            $imgPath = base_url('assets/SGV/Category/' .  $categoryPath . '/' . strtolower($final) . '/' . basename($imageFile));
          ?>
          <tr class="hover:bg-amber-50 transition"
              data-name="<?= strtolower(esc($product['name'])) ?>"
              data-id="<?= esc($product['id']) ?>"
              data-description="<?= esc($product['description'] ?? 'No description available.') ?>"
              data-image="<?= $imgPath ?>"
              data-slug="<?= esc($product['slug']) ?>"
              data-categoryname="<?= esc($product['category_name']) ?>">
            <td class="px-4 py-3 border-b">
              <img src="<?= $imgPath ?>" alt="<?= esc($product['name']) ?>" class="w-12 h-12 rounded object-cover">
            </td>
            <td class="px-4 py-3 border-b font-medium text-gray-800"><?= esc($product['name']) ?></td>
            <td class="px-4 py-3 border-b text-amber-600 text-sm"><?= esc($product['category_name']) ?></td>
            <td class="px-4 py-3 border-b text-gray-400 text-xs"><?= esc($product['slug']) ?></td>
            <td class="px-4 py-3 border-b text-gray-400 text-xs">
               <span class="badge-display text-white px-2 py-1 rounded <?= $product['is_display'] ? 'bg-green-500' : 'bg-gray-400' ?>">
                  <?= $product['is_display'] ? 'Displayed' : 'Hidden' ?>
              </span>
              <form action="<?= site_url('admin/products/toggle-display/' . $product['id']) ?>" method="post">
                  <?= csrf_field() ?>
                  <button type="submit" class="ml-2 px-3 py-1 rounded bg-blue-600 text-white hover:bg-blue-700">
                      Switch
                  </button>
              </form>
            </td>
            <td class="px-4 py-3 border-b text-gray-400 text-xs">
               <span class="badge-display text-white px-2 py-1 rounded <?= $product['is_show'] ? 'bg-green-500' : 'bg-gray-400' ?>">
                  <?= $product['is_show'] ? 'Displayed' : 'Hidden' ?>
              </span>
              <form action="<?= site_url('admin/products/toggle-slide/' . $product['id']) ?>" method="post">
                  <?= csrf_field() ?>
                  <button type="submit" class="ml-2 px-3 py-1 rounded bg-blue-600 text-white hover:bg-blue-700">
                      Switch
                  </button>
              </form>
            </td>
            <td class="px-4 py-3 border-b text-center">
              <button class="detail-btn bg-amber-100 text-amber-700 px-3 py-1 rounded shadow hover:bg-amber-200 text-sm">View</button>
              <form method="post" action="<?= base_url('/admin/products/delete/' . $product['id']) ?>" 
                    onsubmit="return confirm('Hapus produk ini?')" class="inline-block">
                <?= csrf_field() ?>
                <button type="submit" class="bg-red-100 text-red-600 px-3 py-1 rounded shadow hover:bg-red-200 text-sm">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <div id="pagination" class="mt-8 flex justify-center space-x-2"></div>

</div>

<!-- Modal -->
<div id="productModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
  <div class="bg-white rounded-xl p-8 max-w-md w-full relative shadow-lg animate-fadeIn">
    <button id="modalCloseBtn" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
    <div class="flex flex-col items-center text-center">
      <div class="w-36 h-36 rounded-lg overflow-hidden shadow mb-5 ring-2 ring-amber-300">
        <img id="modalImage" src="" alt="Product Image" class="w-full h-full object-cover" />
      </div>
      <h3 id="modalTitle" class="text-2xl font-semibold text-gray-800 mb-1"></h3>
      <p id="modalCategory" class="uppercase text-sm font-semibold text-amber-600 mb-2"></p>
      <p id="modalSlug" class="font-mono text-gray-400 text-xs mb-4"></p>
      <p id="modalDescription" class="text-gray-600 mb-6 max-h-40 overflow-y-auto text-sm"></p>
      <div class="flex gap-3">
        <a href="#" id="modalEditLink" class="bg-amber-500 text-black px-5 py-2 rounded shadow hover:bg-amber-600 text-sm">Detail</a>
        <form id="modalDeleteForm" method="post" onsubmit="return confirm('Hapus produk ini')" class="inline-block">
          <?= csrf_field() ?>
          <button type="submit" class="bg-red-500 text-black px-5 py-2 rounded shadow hover:bg-red-600 text-sm">
            Delete
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  const searchInput = document.getElementById('searchInput');
  const productsTable = document.getElementById('productsTable');
  const rows = Array.from(productsTable.querySelectorAll('tr'));
  const paginationContainer = document.getElementById('pagination');

  const itemsPerPage = 8;
  let currentPage = 1;
  let filteredRows = rows;

  function renderPage(page = 1) {
    currentPage = page;
    const start = (page - 1) * itemsPerPage;
    const end = start + itemsPerPage;

    rows.forEach(row => row.style.display = 'none');
    filteredRows.slice(start, end).forEach(row => row.style.display = '');

    renderPagination();
  }

  function renderPagination() {
    paginationContainer.innerHTML = '';
    const totalPages = Math.ceil(filteredRows.length / itemsPerPage);
    if (totalPages <= 1) return;

    for (let i = 1; i <= totalPages; i++) {
      const pageBtn = document.createElement('button');
      pageBtn.textContent = i;
      pageBtn.className = `px-3 py-1 rounded ${i === currentPage ? 'bg-amber-500 text-black' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`;
      pageBtn.onclick = () => renderPage(i);
      paginationContainer.appendChild(pageBtn);
    }
  }

  function filterProducts() {
    const query = searchInput.value.toLowerCase().trim();
    filteredRows = rows.filter(row => row.getAttribute('data-name').includes(query));
    renderPage(1);
  }

  searchInput.addEventListener('input', filterProducts);

  // Modal
  const modal = document.getElementById('productModal');
  const modalCloseBtn = document.getElementById('modalCloseBtn');
  const modalImage = document.getElementById('modalImage');
  const modalTitle = document.getElementById('modalTitle');
  const modalCategory = document.getElementById('modalCategory');
  const modalSlug = document.getElementById('modalSlug');
  const modalDescription = document.getElementById('modalDescription');
  const modalEditLink = document.getElementById('modalEditLink');
  const modalDeleteForm = document.getElementById('modalDeleteForm');

  document.querySelectorAll('.detail-btn').forEach(btn => {
    btn.addEventListener('click', e => {
      const row = e.target.closest('tr');

      modalImage.src = row.getAttribute('data-image');
      modalTitle.textContent = row.getAttribute('data-name');
      modalCategory.textContent = row.getAttribute('data-categoryname');
      modalSlug.textContent = row.getAttribute('data-slug');
      modalDescription.textContent = row.getAttribute('data-description');
      modalEditLink.href = "<?= base_url('/admin/products/edit/') ?>" + row.getAttribute('data-id');
      modalDeleteForm.action = "<?= base_url('/admin/products/delete/') ?>" + row.getAttribute('data-id');

      modal.classList.remove('hidden');
      modal.classList.add('flex');
    });
  });

  modalCloseBtn.addEventListener('click', () => {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  });

  modal.addEventListener('click', (e) => {
    if (e.target === modal) {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }
  });

  renderPage(1);
</script>

<style>
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px);}
    to { opacity: 1; transform: translateY(0);}
  }
  .animate-fadeIn {
    animation: fadeIn 0.3s ease forwards;
  }
</style>


<?= view('adminpartial/footer'); ?>
