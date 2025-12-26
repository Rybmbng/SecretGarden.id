<?= view("adminpartial/header") ?>

<div class="container mx-auto px-6 py-6 font-sans text-gray-800">
    <h1 class="text-3xl font-bold mb-8 text-gray-900">Menu Public Management</h1>

    <!-- Add / Edit Menu Form -->
    <div class="bg-white shadow-lg rounded-3xl p-6 mb-10 border border-gray-100">
        <h2 class="text-xl font-semibold mb-6 text-gray-900">Add / Edit Menu</h2>
        <form id="menuForm" action="<?= base_url('admin/setting/menupublic/create') ?>" method="post" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="hidden" name="id" id="menu-id">
            <input type="text" name="name" id="menu-name" placeholder="Menu Name" class="p-4 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-300 transition" required>
            <input type="text" name="url" id="menu-url" placeholder="URL" class="p-4 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-300 transition">

            <select name="type" id="menu-type" class="md:col-span-2 p-4 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-300 transition">
                <option value="static">Static</option>
                <option value="post">Post</option>
                <option value="product">Product</option>
            </select>

            <textarea name="description" id="menu-description" placeholder="Description (optional)" class="md:col-span-2 p-4 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-300 transition"></textarea>

            <!-- Post Children -->
            <div id="post-children" class="md:col-span-2 space-y-2 hidden">
                <label class="block font-medium">Post Items</label>
                <div id="post-items"></div>
                <button type="button" id="add-post-item" class="px-4 py-2 bg-blue-500 text-white rounded-2xl">+ Add Post</button>
            </div>

            <!-- Product Children -->
            <div id="product-children" class="md:col-span-2 hidden">
                <label class="block font-medium mb-2">Select Products</label>
                <select name="children_data[]" id="menu-products" class="w-full border border-gray-200 rounded-2xl p-4" multiple>
                    <?php foreach($products as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= $p['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Icon Picker -->
            <div class="md:col-span-2">
                <label class="block mb-2 font-medium text-gray-600">Select Icon</label>
                <input type="text" id="icon-search" placeholder="Search icon..." class="p-3 border border-gray-200 rounded-2xl w-full mb-3 focus:ring-2 focus:ring-blue-300 transition">
                <div id="icon-picker" class="grid grid-cols-6 gap-3 max-h-48 overflow-y-auto border border-gray-200 p-3 rounded-2xl bg-gray-50"></div>
                <input type="hidden" name="icon" id="icon-input">
            </div>

            <!-- Parent Menu -->
            <select name="parent_id" id="menu-parent" class="md:col-span-2 p-4 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-blue-300 transition">
                <option value="">-- No Parent --</option>
                <?php foreach ($menus as $pm): ?>
                    <option value="<?= $pm['id'] ?>"><?= $pm['name'] ?></option>
                <?php endforeach; ?>
            </select>

            <div class="flex items-center space-x-2">
                <input type="checkbox" name="is_active" id="menu-active" checked class="w-5 h-5 rounded-lg border-gray-300">
                <span>Active</span>
            </div>

            <button type="submit" class="md:col-span-2 bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-3xl shadow-md transition-all">Save Menu</button>
        </form>
    </div>

    <!-- Menu List Table -->
    <div class="bg-white shadow-lg rounded-3xl p-6 mb-10 border border-gray-100">
        <h2 class="text-xl mb-6 text-gray-900">Menu List</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse rounded-2xl overflow-hidden">
                <thead>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="p-4">ID</th>
                        <th class="p-4">Name</th>
                        <th class="p-4">Type</th>
                        <th class="p-4">URL / Children</th>
                        <th class="p-4">Icon</th>
                        <th class="p-4">Active</th>
                        <th class="p-4">Action</th>
                    </tr>
                </thead>
                <tbody id="menu-list" class="divide-y divide-gray-100">
                    <?php
                    function renderMenu($menus){
                        foreach($menus as $m){
                            $activeLabel = $m['is_active'] ? '<span class="text-green-600 font-semibold">Active</span>' : '<span class="text-red-500 font-semibold">Inactive</span>';
                            $childrenDisplay = '';

                            // decode children_data JSON
                            $children = !empty($m['children_data']) ? json_decode($m['children_data'], true) : [];

                            $children = [];
                            if (!empty($m['children_data'])) {
                                $decoded = json_decode($m['children_data'], true);
                                if (is_array($decoded)) {
                                    $children = $decoded;
                                } elseif ($m['type'] === 'product') {
                                    $children = is_array($decoded) ? $decoded : [$decoded];
                                }
                            }

                            if($m['type'] == 'post' || $m['type'] == 'product'){
                                if(!empty($children)){
                                    foreach($children as $c){
                                        if($m['type'] === 'post') {
                                            $title = $c['title'] ?? '';
                                            $url = $c['url'] ?? '#';
                                        } else {
                                            $title = $c;
                                            $url = '#';
                                        }
                                        $childrenDisplay .= $title . ' (<a href="'.$url.'" class="text-blue-500 hover:underline">link</a>)<br>';
                                    }
                                }
                            } else {
                                $childrenDisplay = $m['url'];
                            }

                            echo '<tr data-id="'.$m['id'].'" data-name="'.htmlspecialchars($m['name']).'" data-url="'.htmlspecialchars($m['url']).'" data-icon="'.htmlspecialchars($m['icon']).'" data-parent="'.$m['parent_id'].'" data-active="'.$m['is_active'].'" data-type="'.$m['type'].'" data-description="'.htmlspecialchars($m['description']).'" data-children=\''.json_encode($children).'\' class="hover:bg-gray-50 transition">';
                            echo '<td class="p-3">'. $m['id'] .'</td>';
                            echo '<td class="p-3"><i class="'. $m['icon'] .' mr-2 text-gray-500"></i>'. $m['name'] .'</td>';
                            echo '<td class="p-3">'. ucfirst($m['type']) .'</td>';
                            echo '<td class="p-3">'.$childrenDisplay.'</td>';
                            echo '<td class="p-3 text-center"><i class="'. $m['icon'] .' text-gray-500"></i></td>';
                            echo '<td class="p-3">'.$activeLabel.'</td>';
                            echo '<td class="p-3 space-x-3">
                                    <button type="button" onclick="editMenu(this)" class="text-blue-500 hover:underline">Edit</button>
                                    <a href="'. base_url('admin/setting/menupublic/delete/'.$m['id']) .'" class="text-red-500 hover:underline">Delete</a>
                                  </td>';
                            echo '</tr>';
                        }
                    }
                    renderMenu($menus);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// Show children fields
const menuType = document.getElementById('menu-type');
const postChildren = document.getElementById('post-children');
const productChildren = document.getElementById('product-children');
const postItemsDiv = document.getElementById('post-items');
const addPostBtn = document.getElementById('add-post-item');

function updateChildrenDisplay(){
    const type = menuType.value;
    postChildren.classList.toggle('hidden', type!=='post');
    productChildren.classList.toggle('hidden', type!=='product');
}
menuType.addEventListener('change', updateChildrenDisplay);
updateChildrenDisplay();

// Add Post Item
addPostBtn.addEventListener('click', ()=>{
    const index = postItemsDiv.children.length;
    const html = `<div class="flex space-x-2 mb-2">
        <input type="text" name="children_data[${index}][title]" placeholder="Title" class="p-2 border border-gray-200 rounded-2xl flex-1">
        <input type="text" name="children_data[${index}][url]" placeholder="URL" class="p-2 border border-gray-200 rounded-2xl flex-1">
        <button type="button" onclick="this.parentNode.remove()" class="px-2 bg-red-500 text-white rounded-2xl">X</button>
    </div>`;
    postItemsDiv.insertAdjacentHTML('beforeend', html);
});

// Icon Picker
const faIcons = ["fa-home","fa-user","fa-cog","fa-chart-bar","fa-envelope","fa-folder","fa-shopping-cart","fa-file-alt","fa-bell","fa-camera","fa-book","fa-star","fa-heart","fa-comment"];
function initIconPicker(pickerId, inputId, searchId){
    const picker = document.getElementById(pickerId);
    const input = document.getElementById(inputId);
    const search = document.getElementById(searchId);
    picker.innerHTML = '';
    faIcons.forEach(icon=>{
        const i = document.createElement('i');
        i.className = 'fas ' + icon + ' cursor-pointer p-2 hover:bg-blue-100 transition';
        i.title = icon.replace('fa-','');
        picker.appendChild(i);
        i.addEventListener('click', function(){
            picker.querySelectorAll('i').forEach(x=>x.classList.remove('bg-blue-200'));
            this.classList.add('bg-blue-200');
            input.value = this.className;
        });
    });
    search.addEventListener('input', function(){
        const q = this.value.toLowerCase();
        picker.querySelectorAll('i').forEach(icon=>icon.style.display = icon.title.includes(q)?'inline-block':'none');
    });
}
initIconPicker('icon-picker','icon-input','icon-search');

// Edit Menu
function editMenu(btn){
    const tr = btn.closest('tr');
    document.getElementById('menu-id').value = tr.dataset.id;
    document.getElementById('menu-name').value = tr.dataset.name;
    document.getElementById('menu-url').value = tr.dataset.url;
    document.getElementById('menu-type').value = tr.dataset.type;
    document.getElementById('menu-description').value = tr.dataset.description;
    document.getElementById('menu-parent').value = tr.dataset.parent || '';
    document.getElementById('menu-active').checked = tr.dataset.active==='1';

    // Reset children fields
    postItemsDiv.innerHTML = '';
    document.getElementById('menu-products').querySelectorAll('option').forEach(opt=>opt.selected=false);

    const children = tr.dataset.children ? JSON.parse(tr.dataset.children) : [];
    if(children && tr.dataset.type==='post'){
        children.forEach((c,i)=>{
            const html = `<div class="flex space-x-2 mb-2">
                <input type="text" name="children_data[${i}][title]" value="${c.title || ''}" placeholder="Title" class="p-2 border border-gray-200 rounded-2xl flex-1">
                <input type="text" name="children_data[${i}][url]" value="${c.url || ''}" placeholder="URL" class="p-2 border border-gray-200 rounded-2xl flex-1">
                <button type="button" onclick="this.parentNode.remove()" class="px-2 bg-red-500 text-white rounded-2xl">X</button>
            </div>`;
            postItemsDiv.insertAdjacentHTML('beforeend', html);
        });
    } else if(children && tr.dataset.type==='product'){
        children.forEach(c=>{
            const opt = document.getElementById('menu-products').querySelector(`option[value='${c}']`);
            if(opt) opt.selected = true;
        });
    }

    updateChildrenDisplay();
}
</script>

<?= view("adminpartial/footer") ?>
