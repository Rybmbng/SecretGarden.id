<?= view("adminpartial/header")?>

<div class="max-w-3xl mx-auto bg-white shadow rounded p-6">
  <h1 class="text-xl font-bold mb-4">Edit Page</h1>
  <form method="post" action="/admin/cms/update/<?= $page['id'] ?>">
    <div class="mb-4">
      <label class="block text-sm font-medium">Title</label>
      <input type="text" name="title" value="<?= esc($page['title']) ?>" class="w-full border p-2 rounded" required>
    </div>
    <div class="mb-4">
      <label class="block text-sm font-medium">Slug</label>
      <input type="text" name="slug" value="<?= esc($page['slug']) ?>" class="w-full border p-2 rounded">
    </div>
    <div class="mb-4">
      <label class="block text-sm font-medium">Content</label>
      <textarea name="content" class="rich-editor w-full border p-2 rounded"><?= esc($page['content']) ?></textarea>
    </div>
    <div class="mb-4">
      <label class="block text-sm font-medium">Status</label>
      <select name="status" class="w-full border p-2 rounded">
        <option value="published" <?= $page['status']=='published' ? 'selected' : '' ?>>Published</option>
        <option value="draft" <?= $page['status']=='draft' ? 'selected' : '' ?>>Draft</option>
      </select>
    </div>
    <div class="flex gap-2">
      <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Update</button>
      <a href="/admin/cms" class="px-4 py-2 border rounded">Cancel</a>
    </div>
  </form>
</div>
<?= view("adminpartial/footer")?>