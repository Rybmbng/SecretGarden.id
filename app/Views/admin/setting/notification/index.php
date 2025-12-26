<?= view("adminpartial/header")?>
<div class="container mx-auto p-6" x-data="notifApp()">

    <h1 class="text-2xl font-bold mb-4">Notification Settings</h1>
    <button @click="openCreate()" class="bg-blue-600 text-white px-4 py-2 rounded mb-4">+ Add Notification</button>

    <table class="w-full border-collapse border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-2 py-1">Type</th>
                <th class="border px-2 py-1">Model</th>
                <th class="border px-2 py-1">Condition</th>
                <th class="border px-2 py-1">Template</th>
                <th class="border px-2 py-1">Limit</th>
                <th class="border px-2 py-1">Enabled</th>
                <th class="border px-2 py-1">Audio</th>
                <th class="border px-2 py-1">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($settings as $s): ?>
            <tr>
                <td class="border px-2 py-1"><?= $s['type'] ?></td>
                <td class="border px-2 py-1"><?= $s['model'] ?></td>
                <td class="border px-2 py-1"><?= $s['condition'] ?></td>
                <td class="border px-2 py-1"><?= $s['message_template'] ?></td>
                <td class="border px-2 py-1"><?= $s['limit'] ?></td>
                <td class="border px-2 py-1"><?= $s['is_enabled'] ? 'Yes' : 'No' ?></td>
                <td class="border px-2 py-1">
                    <?php if($s['sound_file']): ?>
                        <audio controls class="w-32">
                            <source src="<?= base_url($s['sound_file']) ?>" type="audio/mpeg">
                        </audio>
                    <?php endif; ?>
                </td>
                <td class="border px-2 py-1 flex gap-2">
                    <button @click="openEdit(<?= htmlspecialchars(json_encode($s)) ?>)" class="text-blue-600">Edit</button>
                    <button @click="openDelete(<?= $s['id'] ?>)" class="text-red-600">Delete</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Create Modal -->
    <div x-show="createModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-transition>
        <div class="bg-white p-6 rounded w-96 relative">
            <h2 class="text-xl font-bold mb-4">Add Notification</h2>
            <form action="<?= base_url('admin/setting/notification/store') ?>" method="post" enctype="multipart/form-data" class="space-y-3">
                <input type="text" name="type" placeholder="Type" class="border p-2 w-full" required>
                <label>Model</label>
                <select name="model" x-model="selectedModel" @change="updateFields(false)" class="border p-2 w-full" required>
                    <?php foreach($modelOptions as $label => $model): ?>
                        <option value="<?= $model ?>"><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
                <label>Field</label>
                <select name="field" x-ref="fieldSelect" class="border p-2 w-full" required></select>
                <label>Operator</label>
                <select name="operator" class="border p-2 w-full" required>
                    <option value="=">=</option>
                    <option value="<="><=</option>
                    <option value="<"><</option>
                    <option value=">=">>=</option>
                    <option value=">">></option>
                </select>
                <input type="text" name="value" placeholder="Value" class="border p-2 w-full" required>
                <input type="text" name="message_template" placeholder="Message Template" class="border p-2 w-full">
                <input type="number" name="limit" placeholder="Limit" class="border p-2 w-full" value="5">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_enabled" checked> Enabled
                </label>
                <label class="block">
                    Audio Notification
                    <input type="file" name="sound_file" accept="audio/*" class="mt-1">
                </label>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="createModal=false" class="px-4 py-2 bg-gray-400 rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
                </div>
            </form>
            <button @click="createModal=false" class="absolute top-2 right-2 text-gray-500">✕</button>
        </div>
    </div>

    <!-- Edit Modal -->
    <div x-show="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-transition>
        <div class="bg-white p-6 rounded w-96 relative">
            <h2 class="text-xl font-bold mb-4">Edit Notification</h2>
            <form :action="`<?= base_url('admin/setting/notification/update') ?>/${editData.id}`" method="post" enctype="multipart/form-data" class="space-y-3">
                <input type="text" name="type" placeholder="Type" class="border p-2 w-full" x-model="editData.type" required>
                <label>Model</label>
                <select name="model" x-model="selectedModel" @change="updateFields(true)" class="border p-2 w-full" required>
                    <?php foreach($modelOptions as $label => $model): ?>
                        <option value="<?= $model ?>"><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
                <label>Field</label>
                <select name="field" x-ref="editFieldSelect" class="border p-2 w-full" x-model="editData.field" required></select>
                <label>Operator</label>
                <select name="operator" class="border p-2 w-full" x-model="editData.operator" required>
                    <option value="=">=</option>
                    <option value="<="><=</option>
                    <option value="<"><</option>
                    <option value=">=">>=</option>
                    <option value=">">></option>
                </select>
                <input type="text" name="value" placeholder="Value" class="border p-2 w-full" x-model="editData.value" required>
                <input type="text" name="message_template" placeholder="Message Template" class="border p-2 w-full" x-model="editData.message_template">
                <input type="number" name="limit" placeholder="Limit" class="border p-2 w-full" x-model="editData.limit">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_enabled" :checked="editData.is_enabled"> Enabled
                </label>
                <label class="block">
                    Audio Notification
                    <input type="file" name="sound_file" accept="audio/*" class="mt-1">
                </label>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="editModal=false" class="px-4 py-2 bg-gray-400 rounded">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
                </div>
            </form>
            <button @click="editModal=false" class="absolute top-2 right-2 text-gray-500">✕</button>
        </div>
    </div>

</div>

<script src="//unpkg.com/alpinejs" defer></script>
<script>
function notifApp(){
    return {
        createModal: false,
        editModal: false,
        deleteModal: false,
        selectedModel: 'Product',
        editData: {},      
        fieldOptions: <?= json_encode($fieldOptions) ?>,
        updateFields(edit=false){
            let options = this.fieldOptions[this.selectedModel] || [];
            let ref = edit ? this.$refs.editFieldSelect : this.$refs.fieldSelect;
            ref.innerHTML = '';
            options.forEach(f=>{
                let opt = document.createElement('option');
                opt.value = f; 
                opt.innerText = f;
                ref.appendChild(opt);
            });
        },
        openCreate(){ 
            this.createModal=true; 
            this.selectedModel='Product'; 
            this.$nextTick(()=>this.updateFields(false)) 
        },
        openEdit(data){ 
            this.editData = {...data}; 
            this.selectedModel = data.model; 
            this.editModal=true; 
            this.$nextTick(()=>this.updateFields(true))
        },
        openDelete(id){ 
            this.deleteId=id; 
            this.deleteModal=true 
        }
    }
}
</script>

<?= view("adminpartial/footer")?>
