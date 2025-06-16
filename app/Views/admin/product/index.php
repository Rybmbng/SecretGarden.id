<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Manajemen Produk</h1>

    <form action="<?= base_url('admin/produk/tambah') ?>" method="post" class="bg-white p-4 rounded shadow space-y-4 mb-6">
        <input type="text" name="name" placeholder="Nama Produk" class="w-full border p-2 rounded" required>
        <textarea name="description" placeholder="Deskripsi Produk" class="w-full border p-2 rounded"></textarea>

        <select name="category_id" class="w-full border p-2 rounded" required>
            <option value="">-- Pilih Kategori --</option>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= $k['id'] ?>"><?= esc($k['name']) ?></option>
            <?php endforeach ?>
        </select>

        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah Produk</button>
    </form>

    <table class="w-full text-sm bg-white rounded shadow table-auto">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Kategori</th>
                <th class="px-4 py-2">Slug</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produk as $p): ?>
                <tr class="border-t">
                    <td class="px-4 py-2"><?= esc($p['name']) ?></td>
                    <td class="px-4 py-2"><?= esc($p['category_name']) ?></td>
                    <td class="px-4 py-2 text-gray-500"><?= esc($p['slug']) ?></td>
                    <td class="px-4 py-2">
                        <form action="<?= base_url('admin/produk/hapus/' . $p['id']) ?>" method="post" onsubmit="return confirm('Yakin hapus produk?')" class="inline">
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
