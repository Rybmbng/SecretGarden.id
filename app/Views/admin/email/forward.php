<?=view("adminpartial/header")?>
<div class="max-w-3xl mx-auto p-6">
  <h2 class="text-xl font-bold mb-4">➡ Forward Email</h2>

  <form method="post" class="space-y-4">
    <?= csrf_field() ?>
    <div>
      <label class="block font-medium">To</label>
      <input type="email" name="to" class="w-full border rounded-lg p-2">
    </div>
    <div>
      <label class="block font-medium">Subject</label>
      <input type="text" name="subject" value="Fwd: <?= esc($email['subject']) ?>" class="w-full border rounded-lg p-2">
    </div>
    <div>
      <label class="block font-medium">Message</label>
      <textarea name="body" rows="6" class="w-full border rounded-lg p-3"><?= "\n\n---------- Forwarded message ----------\nFrom: ".$email['from_email']."\nSubject: ".$email['subject']."\n\n".($email['body_text'] ?? '') ?></textarea>
    </div>
    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">Forward</button>
  </form>
</div>
