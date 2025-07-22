<?= $this->include('adminpartial/header') ?>

<div class="min-h-screen bg-gray-100 p-6">
  <div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">📊 Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Card 1: Total Produk -->
      <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
        <h2 class="text-xl font-semibold text-gray-700 mb-2">🛍️ Total Produk</h2>
        <p class="text-3xl font-bold text-blue-600"><?= esc($totalProducts ?? 0) ?></p>
      </div>

      <!-- Card 2: Total Kategori -->
      <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
        <h2 class="text-xl font-semibold text-gray-700 mb-2">📂 Total Kategori</h2>
        <p class="text-3xl font-bold text-green-600"><?= esc($totalCategories ?? 0) ?></p>
      </div>

      <!-- Card 3: Total User -->
      <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
        <h2 class="text-xl font-semibold text-gray-700 mb-2">👥 Total User</h2>
        <p class="text-3xl font-bold text-purple-600"><?= esc($totalUsers ?? 0) ?></p>
      </div>
    </div>

    <div class="mt-10">
      <h2 class="text-2xl font-bold text-gray-700 mb-4">📌 Aktivitas Terakhir</h2>
      <div class="bg-white p-4 rounded-xl shadow">
        <ul class="space-y-3 text-gray-600">
          <?php if (!empty($recentActivities)): ?>
            <li class="font-semibold text-gray-800">Aktivitas Terakhir:</li>
            <?php foreach ($recentActivities as $activity): ?>
              <li>
                <?= esc(date('Dd M ', strtotime($activity['date']))) ?> • <?= esc($activity['description']) ?>  (<?= esc(date('H:i', strtotime($activity['time']))) ?>)
              </li>
            <?php endforeach ?>
          <?php else: ?>
            <li>Belum ada aktivitas terbaru.</li>
          <?php endif ?>
        </ul>
      </div>
    </div>
  </div>
</div>

<?= $this->include('adminpartial/footer') ?>
