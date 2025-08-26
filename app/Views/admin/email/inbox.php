<?= view('adminpartial/header') ?>

<div class="max-w-6xl mx-auto p-6">
  <h2 class="text-4xl font-bold mb-4">Mail Area</h2>

  <!-- Navigation Tabs -->
  <div class="border-b border-gray-200 mb-4">
    <nav class="-mb-px flex space-x-6">
      <a href="<?= site_url('admin/email/inbox') ?>" 
         class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm <?= service('uri')->getSegment(3) == 'inbox' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?>">
        Inbox <span class="ml-1 bg-blue-100 text-blue-600 text-xs font-semibold px-2 py-0.5 rounded-full"><?= count($emails ?? []) ?></span>
      </a>
      <a href="<?= site_url('admin/email/sent') ?>" 
         class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm <?= service('uri')->getSegment(3) == 'sent' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?>">
        Sent
      </a>
      <a href="<?= site_url('admin/email/draft') ?>" 
         class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm <?= service('uri')->getSegment(3) == 'draft' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?>">
        Draft
      </a>
      <a href="<?= site_url('admin/email/trash') ?>" 
         class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm <?= service('uri')->getSegment(3) == 'trash' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?>">
        Trash
      </a>
    </nav>
  </div>

  <!-- Toolbar -->
  <div class="flex items-center justify-between mb-4">
    <div class="space-x-2">
      <a href="<?= site_url('admin/email/sync') ?>" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg shadow text-sm">🔄 Sync</a>
      <a href="<?= site_url('admin/email/compose') ?>" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg shadow text-sm">✉️ Compose</a>
    </div>
    <div>
      <input type="text" placeholder="Search email..." class="px-3 py-2 border rounded-lg w-64 focus:ring-2 focus:ring-blue-500">
    </div>
  </div>

  <!-- Email List -->
  <div class="bg-white shadow rounded-lg divide-y divide-gray-200">
    <?php if (!empty($emails)): ?>
      <?php foreach ($emails as $mail): ?>
        <a href="<?= site_url('admin/email/view/'.$mail['id']) ?>" class="block hover:bg-gray-50">
          <div class="px-4 py-3 flex items-center <?= $mail['is_seen'] ? '' : 'bg-blue-50 font-semibold' ?>">
            <div class="flex-1 min-w-0">
              <p class="text-sm text-gray-800 truncate"><?= esc($mail['subject']) ?: '(No Subject)' ?></p>
              <p class="text-xs text-gray-500 truncate">From: <?= esc($mail['from_email']) ?></p>
            </div>
            <div class="text-xs text-gray-400 ml-3 whitespace-nowrap">
              <?= date("d M Y H:i", strtotime($mail['date'])) ?>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="p-4 text-gray-500 text-center">⚠️ No emails found.</div>
    <?php endif; ?>
  </div>
</div>


<?= view('adminpartial/footer') ?>
