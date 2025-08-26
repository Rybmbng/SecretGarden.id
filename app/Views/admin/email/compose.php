<?=view("adminpartial/header")?>

<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6">✉️ Compose Email</h2>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php elseif(session()->getFlashdata('success')): ?>
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('admin/email/send') ?>" method="post" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label class="block text-sm font-medium">To</label>
            <input type="email" name="to" required class="w-full border rounded px-3 py-2 mt-1 focus:ring focus:ring-blue-300">
        </div>

        <div>
            <label class="block text-sm font-medium">Subject</label>
            <input type="text" name="subject" required class="w-full border rounded px-3 py-2 mt-1 focus:ring focus:ring-blue-300">
        </div>

        <div>
            <label class="block text-sm font-medium">Message</label>
            <textarea name="message" rows="8" class="w-full border rounded px-3 py-2 mt-1 focus:ring focus:ring-blue-300"></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium">Attachments</label>
            <input type="file" name="attachments[]" multiple class="w-full border rounded px-3 py-2 mt-1">
        </div>

        <div class="flex justify-end space-x-2">
            <a href="<?= site_url('admin/email/inbox') ?>" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">Cancel</a>
            <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Send</button>
        </div>
    </form>
</div>
