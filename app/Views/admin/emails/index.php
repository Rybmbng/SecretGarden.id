<?=view('adminpartial/header')?>

<div class="max-w-7xl mx-auto p-6">
  <div class="flex gap-6">
    <aside class="w-64 bg-white rounded p-4 shadow">
      <h3 class="font-bold mb-4">Mailboxes</h3>
      <ul class="space-y-2 text-sm">
        <li><a href="<?= base_url('admin/email/index/inbox') ?>" class="flex justify-between"><span>Inbox</span><span class="text-red-600 font-semibold"><?= $counts['inbox'] ?? 0 ?></span></a></li>
        <li><a href="<?= base_url('admin/email/index/sent') ?>">Sent</a></li>
        <li><a href="<?= base_url('admin/email/index/draft') ?>">Drafts</a></li>
        <li><a href="<?= base_url('admin/email/index/trash') ?>">Trash</a></li>
        <li><a href="<?= base_url('admin/email/config') ?>" class="text-blue-600">Email Config</a></li>
      </ul>
      <a href="<?= base_url('admin/email/compose') ?>" class="mt-4 inline-block bg-green-600 text-white px-3 py-2 rounded">Compose</a>
    </aside>

    <main class="flex-1">
      <div class="bg-white rounded shadow p-4">
        <div class="flex items-center gap-3 mb-4">
          <form method="get" class="flex gap-2 items-center flex-1">
            <input type="text" name="search" value="<?= esc($search ?? '') ?>" placeholder="Search..." class="border px-3 py-2 rounded w-80">
            <select name="filter" class="border px-3 py-2 rounded">
              <option value="all" <?= ($filter ?? '')==='all'?'selected':'' ?>>All</option>
              <option value="unread" <?= ($filter ?? '')==='unread'?'selected':'' ?>>Unread</option>
              <option value="replied" <?= ($filter ?? '')==='replied'?'selected':'' ?>>Replied</option>
            </select>
            <button class="bg-blue-600 text-white px-3 py-2 rounded">Filter</button>
          </form>
          <a href="<?= base_url('admin/email/fetch') ?>" class="bg-indigo-600 text-white px-3 py-2 rounded">Fetch</a>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full divide-y">
            <thead class="bg-gray-100 text-left">
              <tr>
                <th class="px-4 py-2">From</th>
                <th class="px-4 py-2">Subject</th>
                <th class="px-4 py-2">Date</th>
                <th class="px-4 py-2">Replied</th>
                <th class="px-4 py-2">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($emails)): foreach($emails as $e): ?>
              <tr class="<?= ($e['is_new']??0) ? 'bg-yellow-50' : '' ?>">
                <td class="px-4 py-3 border-b"><?= esc($e['sender_name'] ?: $e['sender_email']) ?><div class="text-xs text-gray-500"><?= esc($e['sender_email']) ?></div></td>
                <td class="px-4 py-3 border-b"><?= esc($e['subject']) ?></td>
                <td class="px-4 py-3 border-b"><?= esc($e['received_at']) ?></td>
                <td class="px-4 py-3 border-b"><?= ($e['replied']??0)?'Yes':'No' ?></td>
                <td class="px-4 py-3 border-b"><a href="<?= base_url('admin/email/view/'.$e['id']) ?>" class="text-blue-600">Open</a></td>
              </tr>
              <?php endforeach; else: ?>
              <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No messages</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <div class="mt-4"><?= $pager->links('emails','default_full') ?></div>
      </div>
    </main>
  </div>
</div>

<script src="<?= base_url('js/email-pro-notif.js') ?>"></script>
<?= view("adminpartial/footer")?>