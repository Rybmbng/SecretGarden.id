<?= view("adminpartial/header") ?>

<div class="container mx-auto px-6 py-6 font-sans text-gray-800">
    <h1 class="text-3xl font-bold mb-8 text-gray-900">Menu Management</h1>

    <!-- Add New Menu -->
    <div class="bg-white shadow-lg rounded-3xl p-6 mb-10 border border-gray-100">
        <h2 class="text-xl font-semibold mb-6 text-gray-900">Add New Menu</h2>
        <form action="<?= base_url('admin/setting/menu/create') ?>" method="post" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" name="name" placeholder="Menu Name" class="p-4 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-300 focus:border-blue-300 transition" required>
            <input type="text" name="url" placeholder="URL" class="p-4 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-300 focus:border-blue-300 transition" required>

            <!-- Icon Picker -->
            <div class="md:col-span-2">
                <label class="block mb-2 font-medium text-gray-600">Select Icon</label>
                <input type="text" id="icon-search" placeholder="Search icon..." class="p-3 border border-gray-200 rounded-2xl w-full mb-3 focus:ring-2 focus:ring-blue-300 transition">
                <div id="icon-picker" class="grid grid-cols-6 gap-3 max-h-48 overflow-y-auto border border-gray-200 p-3 rounded-2xl bg-gray-50"></div>
                <input type="hidden" name="icon" id="icon-input">
            </div>

            <select name="parent_id" class="md:col-span-2 p-4 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-300 transition">
                <option value="">-- No Parent --</option>
                <?php foreach ($menus as $pm): ?>
                    <option value="<?= $pm['id'] ?>"><?= $pm['name'] ?></option>
                <?php endforeach; ?>
            </select>

            <div class="flex items-center space-x-2">
                <input type="checkbox" name="is_active" checked class="w-5 h-5 rounded-lg border-gray-300">
                <span>Active</span>
            </div>

            <button type="submit" class="md:col-span-2 bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-3xl shadow-md transition-all">+ Add Menu</button>
        </form>
    </div>

    <!-- Menu List -->
    <div class="bg-white shadow-lg rounded-3xl p-6 mb-10 border border-gray-100">
        <h2 class="text-xl mb-6 text-gray-900">Menu List</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse rounded-2xl overflow-hidden">
                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="p-4">ID</th>
                        <th class="p-4">Name</th>
                        <th class="p-4">URL</th>
                        <th class="p-4">Icon</th>
                        <th class="p-4">Parent</th>
                        <th class="p-4">Active</th>
                        <th class="p-4">Action</th>
                    </tr>
                </thead>
                <tbody id="menu-list" class="divide-y divide-gray-100">
                    <?php
                    $menuTree = $menuModel->getMenuTree($menus);
                    function renderMenu($menus, $level=0){
                        foreach($menus as $m){
                            $padding = $level * 24;
                            $activeLabel = $m['is_active'] 
                                ? '<span class="text-green-600 font-semibold">Active</span>' 
                                : '<span class="text-red-500 font-semibold">Inactive</span>';
                            echo '<tr data-id="'.$m['id'].'" data-name="'.htmlspecialchars($m['name']).'" data-url="'.htmlspecialchars($m['url']).'" data-icon="'.htmlspecialchars($m['icon']).'" data-parent="'.$m['parent_id'].'" data-active="'.$m['is_active'].'" class="hover:bg-gray-50 transition">';
                            echo '<td class="p-3">'. $m['id'] .'</td>';
                            echo '<td class="p-3" style="padding-left:'.$padding.'px;"><i class="'. $m['icon'] .' mr-2 text-gray-500"></i>'. $m['name'] .'</td>';
                            echo '<td class="p-3">'. $m['url'] .'</td>';
                            echo '<td class="p-3 text-center"><i class="'. $m['icon'] .' text-gray-500"></i></td>';
                            echo '<td class="p-3">'. ($m['parent_id'] ?: '-') .'</td>';
                            echo '<td class="p-3">'.$activeLabel.'</td>';
                            echo '<td class="p-3 space-x-3">
                                    <button onclick="openEditModal(this)" data-id="'.$m['id'].'" class="text-blue-500 hover:underline">Edit</button>
                                    <a href="'. base_url('admin/setting/menu/delete/'.$m['id']) .'" class="text-red-500 hover:underline">Delete</a>
                                  </td>';
                            echo '</tr>';
                            if(!empty($m['children'])){
                                renderMenu($m['children'], $level+1);
                            }
                        }
                    }
                    renderMenu($menuTree);
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Role Access -->
    <div class="bg-white shadow-lg rounded-3xl p-6 mb-10 border border-gray-100">
        <h2 class="text-xl font-semibold mb-4 text-gray-900">Role Access</h2>
        <form action="<?= base_url('admin/setting/menu/setRoleAccess') ?>" method="post" id="roleAccessForm">
            <select name="role_id" class="p-4 border border-gray-200 rounded-2xl mb-4 w-full focus:ring-2 focus:ring-green-300 transition">
                <?php foreach ($roles as $r): ?>
                    <option value="<?= $r['id'] ?>"><?= $r['role_name'] ?></option>
                <?php endforeach; ?>
            </select>

            <div class="flex justify-end mb-2 space-x-2">
                <button type="button" id="selectAll" class="px-4 py-2 bg-blue-200 text-blue-800 rounded-2xl hover:bg-blue-300 transition">Select All</button>
                <button type="button" id="deselectAll" class="px-4 py-2 bg-red-200 text-red-800 rounded-2xl hover:bg-red-300 transition">Deselect All</button>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 p-4 border border-gray-200 rounded-2xl max-h-64 overflow-y-auto bg-gray-50" id="role-checkboxes">
                <?php
                function renderCheckbox($menus, $level=0){
                    foreach($menus as $m){
                        $margin = $level * 4;
                        echo '<label class="flex items-center ml-'.$margin.' space-x-2 hover:bg-gray-100 p-2 rounded-2xl transition">';
                        echo '<input type="checkbox" name="menu_ids[]" value="'. $m['id'] .'" class="role-checkbox w-5 h-5 rounded-lg">';
                        echo '<span class="flex items-center"><i class="'. $m['icon'] .' mr-2 text-gray-500"></i>'. $m['name'] .'</span>';
                        echo '</label>';
                        if(!empty($m['children'])){
                            renderCheckbox($m['children'], $level+1);
                        }
                    }
                }
                renderCheckbox($menuTree);
                ?>
            </div>

            <button type="submit" class="mt-4 w-full bg-green-500 hover:bg-green-600 text-white py-3 rounded-3xl shadow-md transition">Save Access</button>
        </form>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-3xl shadow-2xl w-11/12 md:w-1/2 p-6 relative">
            <h2 class="text-xl font-semibold mb-6 text-gray-900">Edit Menu</h2>
            <form id="editForm" action="<?= base_url('admin/setting/menu/update') ?>" method="post" class="space-y-3">
                <input type="hidden" name="id" id="edit-id">
                <input type="text" name="name" id="edit-name" placeholder="Menu Name" class="p-4 border border-gray-200 rounded-2xl w-full focus:ring-2 focus:ring-blue-300 transition" required>
                <input type="text" name="url" id="edit-url" placeholder="URL" class="p-4 border border-gray-200 rounded-2xl w-full focus:ring-2 focus:ring-blue-300 transition" required>

                <!-- Icon Picker -->
                <div>
                    <label class="block mb-2 text-gray-600">Select Icon</label>
                    <input type="text" id="edit-icon-search" placeholder="Search icon..." class="p-3 border border-gray-200 rounded-2xl w-full mb-3 focus:ring-2 focus:ring-blue-300 transition">
                    <div id="edit-icon-picker" class="grid grid-cols-6 gap-3 max-h-48 overflow-y-auto border border-gray-200 p-3 rounded-2xl bg-gray-50"></div>
                    <input type="hidden" name="icon" id="edit-icon">
                </div>

                <select name="parent_id" id="edit-parent" class="p-4 border border-gray-200 rounded-2xl w-full focus:ring-2 focus:ring-blue-300 transition">
                    <option value="">-- No Parent --</option>
                    <?php foreach ($menus as $pm): ?>
                        <option value="<?= $pm['id'] ?>"><?= $pm['name'] ?></option>
                    <?php endforeach; ?>
                </select>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" name="is_active" id="edit-active" class="w-5 h-5 rounded-lg border-gray-300">
                    <span>Active</span>
                </div>

                <div class="flex justify-end space-x-3 mt-4">
                    <button type="button" onclick="closeEditModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-5 rounded-3xl transition">Cancel</button>
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-5 rounded-3xl shadow-md transition">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Select / Deselect All
const selectAllBtn = document.getElementById('selectAll');
const deselectAllBtn = document.getElementById('deselectAll');
const checkboxes = document.querySelectorAll('.role-checkbox');

selectAllBtn.addEventListener('click', ()=>{
    checkboxes.forEach(cb=>cb.checked = true);
});
deselectAllBtn.addEventListener('click', ()=>{
    checkboxes.forEach(cb=>cb.checked = false);
});
</script>

<script>
// Icon Picker
const faIcons = ["fa-home","fa-user","fa-cog","fa-chart-bar","fa-envelope","fa-folder","fa-shopping-cart","fa-file-alt","fa-bell","fa-camera","fa-book","fa-star","fa-heart","fa-comment"];

function initIconPicker(pickerId, inputId, searchId){
    const picker = document.getElementById(pickerId);
    const input = document.getElementById(inputId);
    const search = document.getElementById(searchId);

    picker.innerHTML = '';
    faIcons.forEach(icon=>{
        const i = document.createElement('i');
        i.className = 'fas ' + icon + ' cursor-pointer p-2  hover:bg-blue-100 transition';
        i.title = icon.replace('fa-','');
        picker.appendChild(i);
        i.addEventListener('click', function(){
            picker.querySelectorAll('i').forEach(x=>x.classList.remove('bg-blue-200'));
            this.classList.add('bg-blue-200');
            this.classList.remove('bg-blue-200');
            input.value = this.className;
        });
    });

    search.addEventListener('input', function(){
        const q = this.value.toLowerCase();
        picker.querySelectorAll('i').forEach(icon=>icon.style.display = icon.title.includes(q)?'inline-block':'none');
    });
}

initIconPicker('icon-picker','icon-input','icon-search');
initIconPicker('edit-icon-picker','edit-icon','edit-icon-search');

function openEditModal(button){
    const row = button.closest('tr');
    document.getElementById('edit-id').value = row.dataset.id;
    document.getElementById('edit-name').value = row.dataset.name;
    document.getElementById('edit-url').value = row.dataset.url;
    document.getElementById('edit-parent').value = row.dataset.parent || '';
    document.getElementById('edit-active').checked = row.dataset.active === '1';
    const iconInput = document.getElementById('edit-icon');
    iconInput.value = row.dataset.icon;
    document.querySelectorAll('#edit-icon-picker i').forEach(i=>{
        i.classList.toggle('bg-blue-200', i.className === row.dataset.icon);
    });
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal(){
    document.getElementById('editModal').classList.add('hidden');
}

document.getElementById('editForm').addEventListener('submit', async function(e){
    e.preventDefault();
    const id = document.getElementById('edit-id').value;
    const formData = new FormData(this);
    const res = await fetch(`<?= base_url('admin/setting/menu/update') ?>/${id}`, {
        method: 'POST',
        body: formData
    });
    const result = await res.json();
    if(result.success){
        alert('Menu updated!');
        location.reload();
    }
});
</script>

<?= view("adminpartial/footer") ?>
