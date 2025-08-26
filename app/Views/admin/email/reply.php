<?=view("adminpartial/header")?>
<div class="max-w-3xl mx-auto p-6">
  <h2 class="text-xl font-bold mb-4">↩ Reply to <?= esc($email['from_email']) ?></h2>

  <form method="post" class="space-y-4">
    <?= csrf_field() ?>
    <div>
      <label class="block font-medium">To</label>
      <input type="text" name="to" value="<?= esc($email['from_email']) ?>" readonly class="w-full border rounded-lg p-2 bg-gray-100">
    </div>
    <div>
      <label class="block font-medium">Subject</label>
      <input type="text" name="subject" value="Re: <?= esc($email['subject']) ?>" readonly class="w-full border rounded-lg p-2 bg-gray-100">
    </div>
    <div>
      <label class="block font-medium">Message</label>
      <textarea name="body" rows="6" class="w-full border rounded-lg p-3"></textarea>
    </div>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">Send Reply</button>
  </form>
</div>
