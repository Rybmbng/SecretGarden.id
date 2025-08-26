<?= view('adminpartial/header') ?>

<div class="max-w-4xl mx-auto p-6">
  <!-- Header -->
  <div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold">📨 Email Detail</h2>
    <a href="<?= site_url('admin/email/inbox') ?>" class="text-sm px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg shadow">⬅ Back to Inbox</a>
  </div>

  <!-- Email Card -->
  <div class="bg-white shadow rounded-lg p-6">
    <!-- Subject -->
    <h3 class="text-xl font-semibold mb-2"><?= esc($email['subject'] ?? '(No Subject)') ?></h3>

    <!-- Meta Info -->
    <div class="text-sm text-gray-600 mb-4">
      <p><span class="font-medium">From:</span> <?= esc($email['from_email']) ?></p>
      <p><span class="font-medium">To:</span> <?= esc($email['to_email'] ?? 'me@domain.com') ?></p>
      <p><span class="font-medium">Date:</span> <?= date("d M Y H:i", strtotime($email['date'])) ?></p>
    </div>

    <hr class="my-4">

    <!-- Body -->
   <div class="prose max-w-none mb-6">
    <?= $email['body'] ?>
  </div>


    <!-- Attachments -->
    <?php if (!empty($attachments)): ?>
      <div class="mb-6">
        <h4 class="font-semibold text-gray-700 mb-2">📎 Attachments</h4>
        <ul class="list-disc pl-5 text-sm text-blue-600">
          <?php foreach ($attachments as $att): ?>
            <li>
              <a href="<?= site_url('admin/email/download/'.$att['id']) ?>" class="hover:underline">
                <?= esc($att['file_name']) ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <!-- Actions -->
    <div class="flex space-x-3">
      <a href="<?= site_url('admin/email/reply/'.$email['id']) ?>" 
         class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm rounded-lg shadow">↩ Reply</a>
      <a href="<?= site_url('admin/email/forward/'.$email['id']) ?>" 
         class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm rounded-lg shadow">➡ Forward</a>
      <a href="<?= site_url('admin/email/delete/'.$email['id']) ?>" 
         class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm rounded-lg shadow"
         onclick="return confirm('Delete this email?')">🗑 Delete</a>
    </div>
  </div>
</div>
