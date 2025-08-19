<?=view('adminpartial/header')?>

<div class="max-w-4xl mx-auto p-6">
  <a href="<?= base_url('admin/email/index/inbox') ?>" class="text-sm text-blue-600">&larr; Back</a>
  <div class="bg-white rounded shadow p-6 mt-4">
    <h2 class="text-xl font-bold"><?= esc($email['subject']) ?></h2>
    <div class="text-sm text-gray-600 mb-4">From: <?= esc($email['sender_name'] ?: $email['sender_email']) ?> &lt;<?= esc($email['sender_email']) ?>&gt; · <?= esc($email['received_at']) ?></div>

    <div class="prose max-w-none bg-gray-50 p-4 rounded"><?= esc($email['body']) ?></div>

    <div class="mt-4 flex gap-2">
      <a href="<?= base_url('admin/email/reply/'.$email['id']) ?>" class="bg-green-600 text-white px-3 py-2 rounded">Reply</a>
      <a href="<?= base_url('admin/email/trash/'.$email['id']) ?>" class="bg-yellow-500 text-white px-3 py-2 rounded">Move to Trash</a>
    </div>
  </div>

  <?php if(!empty($thread)): ?>
    <div class="mt-6 space-y-4">
      <h3 class="font-bold">Thread</h3>
      <?php foreach($thread as $t): ?>
        <div class="bg-white rounded shadow p-4">
          <div class="text-sm text-gray-600"><?= esc($t['sender_name'] ?: $t['sender_email']) ?> · <?= esc($t['received_at']) ?></div>
          <div class="mt-2 prose"><?= esc($t['body']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?= view("adminpartial/footer")?>
