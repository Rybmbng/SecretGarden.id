<?= view("adminpartial/header")?>

<section class="max-w-3xl mx-auto py-12 px-6 bg-white rounded-xl shadow-lg">
  <h2 class="text-3xl font-bold mb-6 text-gray-800 text-center">Email Configuration</h2>

  <?php if(session()->getFlashdata('success')): ?>
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded"><?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>

  <form action="<?= base_url('admin/email-config/update') ?>" method="post" class="space-y-4">
    <div>
      <label class="block mb-1 font-semibold text-gray-700">SMTP Host</label>
      <input type="text" name="smtp_host" value="<?= esc($config['smtp_host'] ?? '') ?>" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400"/>
    </div>
    <div>
      <label class="block mb-1 font-semibold text-gray-700">SMTP User</label>
      <input type="text" name="smtp_user" value="<?= esc($config['smtp_user'] ?? '') ?>" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400"/>
    </div>
    <div>
      <label class="block mb-1 font-semibold text-gray-700">SMTP Pass</label>
      <input type="password" name="smtp_pass" value="<?= esc($config['smtp_pass'] ?? '') ?>" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400"/>
    </div>
    <div>
      <label class="block mb-1 font-semibold text-gray-700">SMTP Port</label>
      <input type="number" name="smtp_port" value="<?= esc($config['smtp_port'] ?? 587) ?>" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400"/>
    </div>
    <div>
      <label class="block mb-1 font-semibold text-gray-700">SMTP Crypto</label>
      <select name="smtp_crypto" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
        <option value="tls" <?= (isset($config['smtp_crypto']) && $config['smtp_crypto']=='tls')?'selected':'' ?>>TLS</option>
        <option value="ssl" <?= (isset($config['smtp_crypto']) && $config['smtp_crypto']=='ssl')?'selected':'' ?>>SSL</option>
      </select>
    </div>
    <div>
      <label class="block mb-1 font-semibold text-gray-700">From Email</label>
      <input type="email" name="from_email" value="<?= esc($config['from_email'] ?? '') ?>" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400"/>
    </div>
    <div>
      <label class="block mb-1 font-semibold text-gray-700">To Email (penerima)</label>
      <input type="email" name="to_email" value="<?= esc($config['to_email'] ?? '') ?>" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400"/>
    </div>
    <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">Save Configuration</button>
  </form>
</section>

<?= view("adminpartial/footer")?>