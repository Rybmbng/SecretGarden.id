<?= view('adminpartial/header') ?>

<div class="max-w-4xl mx-auto p-6">
  <h3 class="font-bold mb-4">Mail Configuration</h3>
  <div class="bg-white rounded shadow p-6 mt-4">
    <?php if(session()->getFlashdata('success')): ?>
      <div class="bg-green-100 text-green-800 p-3 rounded mb-3"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <form id="emailConfigForm" method="post" action="<?= base_url('admin/setting/email/save') ?>">
      <?= csrf_field() ?>
      <div>
        <label class="block text-sm">Name Alias</label>
        <input name="name" value="<?= esc($config['name'] ?? '') ?>" class="w-full border p-2 rounded">
      </div>
      <div>
        <label class="block text-sm">SMTP Host</label>
        <input name="smtp_host" value="<?= esc($config['smtp_host'] ?? '') ?>" class="w-full border p-2 rounded">
      </div>
      <div>
        <label class="block text-sm">SMTP User</label>
        <input name="smtp_user" value="<?= esc($config['smtp_user'] ?? '') ?>" class="w-full border p-2 rounded">
      </div>
      <div>
        <label class="block text-sm">SMTP Pass</label>
        <input name="smtp_pass" type="password" value="<?= esc($config['smtp_pass'] ?? '') ?>" class="w-full border p-2 rounded">
      </div>
      <div>
        <label class="block text-sm">SMTP Port</label>
        <input name="smtp_port" value="<?= esc($config['smtp_port'] ?? '587') ?>" class="w-full border p-2 rounded">
      </div>
      <div>
        <label class="block text-sm">IMAP Host</label>
        <input name="imap_host" value="<?= esc($config['imap_host'] ?? '') ?>" class="w-full border p-2 rounded">
      </div>
      <div>
        <label class="block text-sm">IMAP User</label>
        <input name="imap_user" value="<?= esc($config['imap_user'] ?? '') ?>" class="w-full border p-2 rounded">
      </div>
      <div>
        <label class="block text-sm">IMAP Pass</label>
        <input name="imap_pass" type="password" value="<?= esc($config['imap_pass'] ?? '') ?>" class="w-full border p-2 rounded">
      </div>
      <div>
        <label class="block text-sm">IMAP Port</label>
        <input name="imap_port" value="<?= esc($config['imap_port'] ?? '993') ?>" class="w-full border p-2 rounded">
      </div>
      <div class="col-span-2">
        <label class="block text-sm">Mail Type</label>
        <select name="mail_type" class="w-full border p-2 rounded">
          <option value="html" <?= (isset($config['mail_type']) && $config['mail_type']=='html')?'selected':'' ?>>HTML</option>
          <option value="text" <?= (isset($config['mail_type']) && $config['mail_type']=='text')?'selected':'' ?>>Text</option>
        </select>
      </div>

      <!-- Field TO muncul hanya jika test SMTP -->
      <div id="smtpToField" class="mt-4 hidden">
        <label class="block text-sm">To Email (untuk test SMTP)</label>
        <input type="email" name="to" placeholder="email@domain.com" class="w-full border p-2 rounded">
      </div>

      <div class="flex gap-4 mt-4">
        <button type="submit" 
            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Simpan Konfigurasi
        </button>

        <!-- Dropdown untuk pilih test -->
        <select id="testType" class="border p-2 rounded">
            <option value="imap">Test IMAP</option>
            <option value="smtp">Test SMTP (Kirim Email)</option>
            <option value="smtp-connection">Test SMTP (Koneksi Saja)</option>
        </select>

        <!-- Tombol jalankan test -->
        <button type="button" id="runTestBtn"
            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
            Run Test
        </button>
      </div>
    </form>
  </div>
</div>

<script>
const testTypeEl = document.getElementById("testType");
const smtpToField = document.getElementById("smtpToField");

// Tampilkan/hilangkan field To sesuai testType
testTypeEl.addEventListener("change", function() {
    smtpToField.classList.toggle('hidden', this.value !== 'smtp');
});

document.getElementById("runTestBtn").addEventListener("click", function() {
    const form = document.getElementById("emailConfigForm");
    const formData = new FormData(form);

    formData.append("test_type", testTypeEl.value); 

    fetch("<?= base_url('admin/setting/email/test') ?>", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === 'success'){
            alert("✅ " + data.message);
        } else {
            alert("❌ " + data.message);
        }
    })
    .catch(err => {
        alert("Error testing connection: " + err);
    });
});
</script>

<?= view("adminpartial/footer") ?>
