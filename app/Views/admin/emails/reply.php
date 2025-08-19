<?=view('adminpartial/header')?>

<div class="max-w-3xl mx-auto p-6">
  <a href="<?= base_url('admin/email/view/'.$email['id']) ?>" class="text-sm text-blue-600">&larr; Back to message</a>
  <div class="bg-white rounded shadow p-6 mt-4">
    <h2 class="font-bold mb-2">Reply to <?= esc($email['sender_name'] ?: $email['sender_email']) ?></h2>
    <div class="bg-gray-50 p-3 rounded mb-3"><?= esc($email['body']) ?></div>
    <form method="post">
      <?= csrf_field() ?>
      <textarea name="message" rows="6" class="w-full border p-2 rounded mb-3" placeholder="Type your reply..." required></textarea>
      <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Send Reply</button>
    </form>
  </div>
</div>
<?= view("adminpartial/footer")?>