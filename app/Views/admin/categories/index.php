<?= view('adminpartial/header') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="w-full mx-auto px-6 py-10 min-h-screen">

  <div class="flex items-center justify-between mb-8">
    <h1 class="text-4xl font-semibold text-black tracking-wide drop-shadow-sm">Category</h1>
    <button id="openCreateBtn" 
      class="inline-flex items-center text-black font-semibold px-5 py-2 rounded-full shadow hover:shadow-lg transition-transform duration-300 hover:scale-[1.05]">
      + Add Category
    </button>
  </div>

  <?php if (!empty($categories)): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <?php foreach ($categories as $category): ?>
        <div class="bg-white border border-gray-200 rounded-3xl shadow hover:shadow-lg transition group overflow-hidden p-4 flex flex-col justify-between">
          <div class="relative h-40 bg-gray-100 rounded-xl overflow-hidden mb-4">
            <?php if (!empty($category['img'])): ?>
              <img src="<?= base_url('assets/SGV/Category/' . $category['path'] . '/' . str_replace(" ", "-", $category['img'])) ?>"
                   alt="<?= esc($category['name']) ?>"
                   class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 rounded-xl">
            <?php else: ?>
              <div class="w-full h-full flex items-center justify-center text-gray-400 italic text-sm rounded-xl">
                No Image
              </div>
            <?php endif; ?>
          </div>

          <h3 class="text-lg font-serif font-semibold text-amber-800 truncate mb-1"><?= esc($category['name']) ?></h3>
          <div>
            <?php if ($category['status'] == 1): ?>
              <span class="inline-block bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Active</span>
            <?php else: ?>
              <span class="inline-block bg-gray-200 text-gray-600 text-xs px-2 py-1 rounded-full">Inactive</span>
            <?php endif; ?>
          </div>

          <div class="mt-6 flex justify-between items-center">
            <button 
              class="text-amber-700 hover:text-amber-900 font-semibold text-sm editBtn"
              data-id="<?= $category['id'] ?>"
              data-name="<?= esc(addslashes($category['name'])) ?>"
              data-path="<?= esc($category['path']) ?>"
              data-description="<?= esc($category['description']) ?>"
              data-status="<?= $category['status'] ?>"
              data-img="<?= !empty($category['img']) ? base_url('assets/SGV/Category/' . $category['path'] . '/' . str_replace(" ", "-", $category['img'])) : '' ?>"
              >
              Edit
            </button>
            <button
              class="text-red-600 hover:text-red-800 font-semibold text-sm"
              onclick="confirmDelete(<?= $category['id'] ?>)">
              Delete
            </button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="text-center text-gray-400 italic py-20 text-lg font-serif">
      No categories found.
    </div>
  <?php endif; ?>
</div>

<!-- Modal Background Overlay (hidden default) -->
<div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50"></div>

<!-- Create Modal -->
<div id="createModal" class="fixed inset-0 bg-white rounded-3xl p-8 max-w-md w-full shadow-lg animate-fadeIn hidden z-50 overflow-auto max-h-[90vh] mx-auto my-10">
  <button id="createModalClose" class="absolute top-4 right-6 text-amber-600 hover:text-amber-900 text-3xl font-bold cursor-pointer">&times;</button>
  <h3 class="text-2xl font-serif font-semibold text-amber-800 mb-6 text-center">Add New Category</h3>

  <form action="<?= site_url('admin/categories/store') ?>" method="post" enctype="multipart/form-data" class="space-y-6" id="createForm">
    <?= csrf_field() ?>

    <div>
      <label class="block text-sm font-medium text-amber-700 mb-2">Category Name</label>
      <input type="text" name="name" placeholder="e.g. Fragrance" required
        class="w-full rounded-lg border border-amber-300 shadow-sm px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 transition" />
    </div>

    <div>
      <label class="block text-sm font-medium text-amber-700 mb-2">Slug (URL Path)</label>
      <input type="text" name="path" readonly placeholder="auto-generated-slug"
        class="w-full rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-amber-600 cursor-not-allowed" />
    </div>

    <div>
      <label class="block text-sm font-medium text-amber-700 mb-2">Description</label>
      <textarea name="description" placeholder="Deskripsi" rows="4"
        class="w-full rounded-lg border border-amber-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 transition resize-none"></textarea>
    </div>

    <div>
      <label class="block text-sm font-medium text-amber-700 mb-2">Image</label>
      <input type="file" name="img" accept="image/*" class="w-full rounded-lg border border-amber-300 shadow-sm px-4 py-3" />
      <div id="createPreviewContainer" class="mt-3 hidden">
        <img id="createImgPreview" class="w-24 h-24 object-cover rounded-xl border border-amber-200 shadow" alt="Preview Image" />
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-amber-700 mb-2">Status</label>
      <select name="status"
        class="w-full rounded-lg border border-amber-300 shadow-sm px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 transition">
        <option value="1" selected>Active</option>
        <option value="0">Inactive</option>
      </select>
    </div>

    <div class="flex justify-end gap-4">
      <button type="button" id="createCancelBtn" class="px-6 py-3 rounded-full bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 transition">
        Cancel
      </button>
      <button type="submit" class="px-6 py-3 rounded-full bg-amber-600 hover:bg-amber-700 text-white font-semibold transition">
        Save
      </button>
    </div>
  </form>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-white rounded-3xl p-8 max-w-md w-full shadow-lg animate-fadeIn hidden z-50 overflow-auto max-h-[90vh] mx-auto my-10">
  <button id="editModalClose" class="absolute top-4 right-6 text-amber-600 hover:text-amber-900 text-3xl font-bold cursor-pointer">&times;</button>
  <h3 class="text-2xl font-serif font-semibold text-amber-800 mb-6 text-center">Edit Category</h3>

  <form action="" method="post" enctype="multipart/form-data" class="space-y-6" id="editForm">
    <?= csrf_field() ?>
    <input type="hidden" name="old_img" id="oldImgInput" value="">

    <div>
      <label class="block text-sm font-medium text-amber-700 mb-2">Category Name</label>
      <input type="text" name="name" id="editName" required
        class="w-full rounded-lg border border-amber-300 shadow-sm px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 transition" />
    </div>

    <div>
      <label class="block text-sm font-medium text-amber-700 mb-2">Slug (URL Path)</label>
      <input type="text" name="path" id="editPath" 
        class="w-full rounded-lg border border-amber-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 transition" />
    </div>

    <div>
      <label class="block text-sm font-medium text-amber-700 mb-2">Description</label>
      <textarea name="description" id="editDescription" rows="4"
        class="w-full rounded-lg border border-amber-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 transition resize-none"></textarea>
    </div>

    <div>
      <label class="block text-sm font-medium text-amber-700 mb-2">Image</label>
      <input type="file" name="img" id="editImgInput" accept="image/*" class="w-full rounded-lg border border-amber-300 shadow-sm px-4 py-3" />
      <div id="editPreviewContainer" class="mt-3 hidden">
        <img id="editImgPreview" class="w-24 h-24 object-cover rounded-xl border border-amber-200 shadow" alt="Preview Image" />
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-amber-700 mb-2">Status</label>
      <select name="status" id="editStatus" 
        class="w-full rounded-lg border border-amber-300 shadow-sm px-4 py-3 focus:outline-none focus:ring-2 focus:ring-amber-500 transition">
        <option value="1">Active</option>
        <option value="0">Inactive</option>
      </select>
    </div>

    <div class="flex justify-end gap-4">
      <button type="button" id="editCancelBtn" class="px-6 py-3 rounded-full bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 transition">
        Cancel
      </button>
      <button type="submit" class="px-6 py-3 rounded-full bg-amber-600 hover:bg-amber-700 text-white font-semibold transition">
        Update
      </button>
    </div>
  </form>
</div>

<script>
  // SweetAlert2 Delete Confirmation
  function confirmDelete(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "This action cannot be undone!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete it!'
    }).then(result => {
      if (result.isConfirmed) {
        window.location.href = '<?= site_url('admin/categories/delete/') ?>' + id;
      }
    });
  }

  // Modal and form logic
  const modalOverlay = document.getElementById('modalOverlay');

  // Create modal elements
  const createModal = document.getElementById('createModal');
  const openCreateBtn = document.getElementById('openCreateBtn');
  const createModalClose = document.getElementById('createModalClose');
  const createCancelBtn = document.getElementById('createCancelBtn');
  const createForm = document.getElementById('createForm');
  const createNameInput = createForm.querySelector('input[name="name"]');
  const createPathInput = createForm.querySelector('input[name="path"]');
  const createImgInput = createForm.querySelector('input[name="img"]');
  const createPreviewContainer = document.getElementById('createPreviewContainer');
  const createImgPreview = document.getElementById('createImgPreview');

  // Edit modal elements
  const editModal = document.getElementById('editModal');
  const editModalClose = document.getElementById('editModalClose');
  const editCancelBtn = document.getElementById('editCancelBtn');
  const editForm = document.getElementById('editForm');
  const editNameInput = document.getElementById('editName');
  const editPathInput = document.getElementById('editPath');
  const editDescriptionInput = document.getElementById('editDescription');
  const editStatusSelect = document.getElementById('editStatus');
  const editImgInput = document.getElementById('editImgInput');
  const editPreviewContainer = document.getElementById('editPreviewContainer');
  const editImgPreview = document.getElementById('editImgPreview');
  const oldImgInput = document.getElementById('oldImgInput');

  // Utility: open modal
  function openModal(modal) {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    modalOverlay.classList.remove('hidden');
    modalOverlay.classList.add('flex');
  }

  // Utility: close modal
  function closeModal(modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    modalOverlay.classList.add('hidden');
    modalOverlay.classList.remove('flex');
  }

  // Open create modal
  openCreateBtn.addEventListener('click', () => {
    createForm.reset();
    createPreviewContainer.classList.add('hidden');
    createImgPreview.src = '';
    openModal(createModal);
  });

  createModalClose.addEventListener('click', () => closeModal(createModal));
  createCancelBtn.addEventListener('click', () => closeModal(createModal));

  // Open edit modal with data
  document.querySelectorAll('.editBtn').forEach(btn => {
    btn.addEventListener('click', e => {
      const target = e.currentTarget;
      const id = target.getAttribute('data-id');
      const name = target.getAttribute('data-name');
      const path = target.getAttribute('data-path');
      const description = target.getAttribute('data-description');
      const status = target.getAttribute('data-status');
      const img = target.getAttribute('data-img');

      editForm.action = "<?= site_url('admin/categories/update/') ?>" + id;
      editNameInput.value = name;
      editPathInput.value = path;
      editDescriptionInput.value = description;
      editStatusSelect.value = status;
      oldImgInput.value = img ? img.split('/').pop() : '';

      if (img) {
        editImgPreview.src = img;
        editPreviewContainer.classList.remove('hidden');
      } else {
        editPreviewContainer.classList.add('hidden');
        editImgPreview.src = '';
      }

      editImgInput.value = ''; // clear file input

      openModal(editModal);
    });
  });

  editModalClose.addEventListener('click', () => closeModal(editModal));
  editCancelBtn.addEventListener('click', () => closeModal(editModal));

  // Close modals when clicking outside modal content
  modalOverlay.addEventListener('click', () => {
    if (!createModal.classList.contains('hidden')) closeModal(createModal);
    if (!editModal.classList.contains('hidden')) closeModal(editModal);
  });

  // Auto slug for create modal
  createNameInput.addEventListener('input', () => {
    let slug = createNameInput.value
      .toLowerCase()
      .trim()
      .replace(/[^a-z0-9\s-]/g, '')
      .replace(/\s+/g, '-')
      .replace(/-+/g, '-');
    createPathInput.value = slug;
  });

  // Auto slug for edit modal (only when user types slug)
  editNameInput.addEventListener('input', () => {
    let slug = editNameInput.value
      .toLowerCase()
      .trim()
      .replace(/[^a-z0-9\s-]/g, '')
      .replace(/\s+/g, '-')
      .replace(/-+/g, '-');
    editPathInput.value = slug;
  });

  // Image preview for create modal
  createImgInput.addEventListener('change', e => {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = e => {
        createImgPreview.src = e.target.result;
        createPreviewContainer.classList.remove('hidden');
      };
      reader.readAsDataURL(file);
    } else {
      createPreviewContainer.classList.add('hidden');
      createImgPreview.src = '';
    }
  });

  // Image preview for edit modal
  editImgInput.addEventListener('change', e => {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = e => {
        editImgPreview.src = e.target.result;
        editPreviewContainer.classList.remove('hidden');
      };
      reader.readAsDataURL(file);
    } else {
      if (oldImgInput.value) {
        editImgPreview.src = "<?= base_url('assets/SGV/Category/') ?>" + oldImgInput.value;
        editPreviewContainer.classList.remove('hidden');
      } else {
        editPreviewContainer.classList.add('hidden');
        editImgPreview.src = '';
      }
    }
  });
</script>

<style>
  @keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9);}
    to { opacity: 1; transform: scale(1);}
  }
  .animate-fadeIn {
    animation: fadeIn 0.3s ease forwards;
  }
  #modalOverlay {
    z-index: 49;
  }
  #createModal, #editModal {
    top: 5vh;
    left: 50%;
    transform: translateX(-50%);
    position: fixed;
    z-index: 50;
    display: none; /* Controlled by JS */
    flex-direction: column;
    max-height: 90vh;
    overflow-y: auto;
    box-sizing: border-box;
  }
  #createModal.flex, #editModal.flex {
    display: flex;
  }
</style>

<?= view('adminpartial/footer') ?>
 