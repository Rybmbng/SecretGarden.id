<?=view('adminpartial/header')?>
<div class="max-w-3xl mx-auto p-6">
  <a href="<?= base_url('admin/email/index/inbox') ?>" class="text-sm text-blue-600">&larr; Back</a>
  <div class="bg-white rounded shadow p-6 mt-4">
    <form method="post">
      <?= csrf_field() ?>
      <label class="block mb-2 text-sm font-medium">To</label>
      <input type="email" name="to" class="w-full border p-2 rounded mb-3" required>
      <label class="block mb-2 text-sm font-medium">Subject</label>
      <input type="text" name="subject" class="w-full border p-2 rounded mb-3" required>
      <label class="block mb-2 text-sm font-medium">Message</label>
      <textarea name="message" rows="8" class="w-full border p-2 rounded mb-3" required></textarea>
      <div class="flex gap-2">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Send</button>
        <button type="submit" name="save_draft" value="1" class="bg-gray-200 px-4 py-2 rounded">Save as Draft</button>
      </div>
    </form>
  </div>
</div>
<?= view("adminpartial/footer")?>
