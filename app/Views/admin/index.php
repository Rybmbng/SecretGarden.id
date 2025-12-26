<?= view("adminpartial/header") ?>
<script>
  function highlightKeyword(row, columnIndex, keyword) {
    let cell = row.cells[columnIndex];
    let text = cell.innerText;
    if (!keyword) {
        cell.innerHTML = text; 
        return;
    }
    let regex = new RegExp(`(${keyword})`, 'gi');
    cell.innerHTML = text.replace(regex, '<span class="bg-yellow-200">$1</span>');
}

document.getElementById('filterPage').addEventListener('input', function() {
    let filter = this.value.toLowerCase();
    document.querySelectorAll('#tablePages tbody tr').forEach(row => {
        let cellText = row.cells[0].innerText.toLowerCase();
        row.style.display = cellText.includes(filter) ? '' : 'none';
        highlightKeyword(row, 0, filter);
    });
});
document.getElementById('filterIP').addEventListener('input', function() {
    let filter = this.value.toLowerCase();
    document.querySelectorAll('#tableLocation tbody tr').forEach(row => {
        let cellText = row.cells[0].innerText.toLowerCase();
        row.style.display = cellText.includes(filter) ? '' : 'none';
        highlightKeyword(row, 0, filter);
    });
});

</script>
<main class="flex-1 overflow-y-auto bg-gray-50">
  <div class="container mx-auto px-6 py-6">
    <h1 class="text-3xl font-bold mb-6">Traffic Dashboard</h1>

    <!-- Today & Total Visitors -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
      <div class="bg-white shadow rounded-lg p-4">
        <p class="text-gray-600">Visitors Today</p>
        <h2 class="text-2xl font-bold"><?= $todayCount ?></h2>
      </div>
      <div class="bg-white shadow rounded-lg p-4">
        <p class="text-gray-600">Total Visitors</p>
        <h2 class="text-2xl font-bold"><?= $totalVisitors ?></h2>
      </div>
    </div>

    <!-- Filter Tanggal -->
    <form method="get" class="mb-4 flex gap-2">
      <input type="date" name="from_date" value="<?= $fromDate ?>" class="p-2 border rounded">
      <input type="date" name="to_date" value="<?= $toDate ?>" class="p-2 border rounded">
      <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Filter</button>
    </form>

    <!-- Last 7 Days Chart -->
    <div class="bg-white shadow rounded-lg p-4 mb-6">
      <h2 class="text-xl font-semibold mb-4">Last 7 Days Visitors</h2>
      <canvas id="trafficChart" height="100"></canvas>
    </div>

    <!-- Top Pages -->
    <div class="bg-white shadow rounded-lg p-4 mb-6">
      <h2 class="text-xl font-semibold mb-4">Top 10 Popular Pages</h2>
      <input type="text" id="filterPage" placeholder="Filter page..." class="mb-2 p-2 border rounded w-full">
      <table class="min-w-full border" id="tablePages">
        <thead>
          <tr class="bg-gray-100">
            <th class="py-2 px-4 border">Page</th>
            <th class="py-2 px-4 border">Views</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($popularPages as $p): ?>
          <tr>
            <td class="py-2 px-4 border"><?= $p['page'] ?></td>
            <td class="py-2 px-4 border"><?= $p['views'] ?></td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>

    <!-- IP & Pages (Collapsible) -->
    <div class="bg-white shadow rounded-lg p-4 mb-6" x-data="{ filter: '', openIPs: {} }">
      <h2 class="text-xl font-semibold mb-4">IP & Pages Visited</h2>
      <input type="text" x-model="filter" placeholder="Filter IP..." class="mb-2 p-2 border rounded w-full">
      <table class="min-w-full border">
        <thead>
          <tr class="bg-gray-100">
            <th class="py-2 px-4 border">IP</th>
            <th class="py-2 px-4 border">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($visitors as $v): ?>
          <tr x-show="'<?= $v['ip_address'] ?>'.includes(filter)">
            <td class="py-2 px-4 border"><?= $v['ip_address'] ?></td>
            <td class="py-2 px-4 border">
              <button @click="openIPs['<?= $v['ip_address'] ?>'] = !openIPs['<?= $v['ip_address'] ?>']" 
                      class="px-2 py-1 bg-blue-500 text-white rounded text-sm">Toggle Pages</button>
            </td>
          </tr>
          <tr x-show="openIPs['<?= $v['ip_address'] ?>']" class="bg-gray-50">
            <td colspan="2" class="py-2 px-4">
              <table class="min-w-full border">
                <thead>
                  <tr class="bg-gray-200">
                    <th class="py-1 px-2 border">Page</th>
                    <th class="py-1 px-2 border">Views</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($ipPages as $p): ?>
                    <?php if($p['ip_address'] == $v['ip_address']): ?>
                    <tr>
                      <td class="py-1 px-2 border"><?= $p['page'] ?></td>
                      <td class="py-1 px-2 border"><?= $p['views'] ?></td>
                    </tr>
                    <?php endif ?>
                  <?php endforeach ?>
                </tbody>
              </table>
            </td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>

    <!-- IP & Location -->
    <div class="bg-white shadow rounded-lg p-4 mb-6">
      <h2 class="text-xl font-semibold mb-4">IP & Location</h2>
      <input type="text" id="filterIP" placeholder="Filter IP..." class="mb-2 p-2 border rounded w-full">
      <table class="min-w-full border" id="tableLocation">
        <thead>
          <tr class="bg-gray-100">
            <th class="py-2 px-4 border">IP</th>
            <th class="py-2 px-4 border">Country - City (ISP)</th>
            <th class="py-2 px-4 border">Num Count</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($visitors as $v): ?>
          <tr>
            <td class="py-2 px-4 border"><?= $v['ip_address'] ?></td>
            <td class="py-2 px-4 border"><?= $v['location'] ?></td>
            <td class="py-2 px-4 border"><?= $v['views'] ?></td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="//unpkg.com/alpinejs" defer></script>
  <script>
    // Chart
    const ctx = document.getElementById('trafficChart').getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: <?= json_encode(array_column($chartData,'date')) ?>,
        datasets: [{
          label: 'Visitors',
          data: <?= json_encode(array_column($chartData,'count')) ?>,
          borderWidth: 2,
          fill: true,
          borderColor: 'rgba(59,130,246,1)',
          backgroundColor: 'rgba(59,130,246,0.2)'
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, precision:0 } }
      }
    });

    // Filter Top Pages
    document.getElementById('filterPage').addEventListener('input', function() {
      let filter = this.value.toLowerCase();
      document.querySelectorAll('#tablePages tbody tr').forEach(row => {
        row.style.display = row.cells[0].innerText.toLowerCase().includes(filter) ? '' : 'none';
      });
    });

    // Filter IP & Location
    document.getElementById('filterIP').addEventListener('input', function() {
      let filter = this.value.toLowerCase();
      document.querySelectorAll('#tableLocation tbody tr').forEach(row => {
        row.style.display = row.cells[0].innerText.toLowerCase().includes(filter) ? '' : 'none';
      });
    });
  </script>
</main>

<?= view("adminpartial/footer") ?>
