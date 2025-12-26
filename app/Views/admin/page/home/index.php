<?= $this->include('adminpartial/header') ?>

<div class="container mx-auto px-6 py-6">
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Slider List</h1>
    <a href="<?= base_url('admin/page/home/slider/create') ?>" 
       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
      + Add Slider
    </a>
  </div>

  <div class="bg-white shadow rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b">
      <h2 class="text-xl font-semibold text-gray-700">Sliders</h2>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full border-collapse text-sm">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-3 text-left">#</th>
            <th class="px-4 py-3 text-left">Alt</th>
            <th class="px-4 py-3 text-left">Desktop</th>
            <th class="px-4 py-3 text-left">Mobile</th>
            <th class="px-4 py-3 text-left">Status</th>
            <th class="px-4 py-3 text-center">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <?php $no=1; foreach($slider as $s): ?>
          <tr class="hover:bg-gray-50">
            <td class="px-4 py-3"><?= $no++ ?></td>
            <td class="px-4 py-3"><?= esc($s['alt']) ?></td>

            <td class="px-4 py-3">
              <div class="truncate max-w-[200px] text-blue-600"><?= esc($s['srcD']) ?></div>
              <div class="bg-gray-200 h-4 w-full rounded overflow-hidden">
                <div id="progressD<?= $s['id'] ?>" class="bg-blue-600 h-4 w-0"></div>
              </div>
            </td>

            <td class="px-4 py-3">
              <div class="truncate max-w-[200px] text-blue-600"><?= esc($s['srcM']) ?></div>
              <div class="bg-gray-200 h-4 w-full rounded overflow-hidden">
                <div id="progressM<?= $s['id'] ?>" class="bg-blue-600 h-4 w-0"></div>
              </div>
            </td>

            <td class="px-4 py-3" id="status-<?= $s['id'] ?>">Loading...</td>

            <td class="px-4 py-3 text-center space-x-2">
              <a href="<?= base_url('admin/page/home/slider/edit/'.$s['id']) ?>" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
              <a href="<?= base_url('admin/page/home/slider/delete/'.$s['id']) ?>" onclick="return confirm('Delete this slider?')" class="text-red-600 hover:text-red-800 font-medium">Delete</a>
            </td>
          </tr>

          <script>
          const sliderId<?= $s['id'] ?> = <?= $s['id'] ?>;
          const srcD<?= $s['id'] ?> = "<?= $s['srcD'] ?>";
          const srcM<?= $s['id'] ?> = "<?= $s['srcM'] ?>";

          async function checkSliderStatus<?= $s['id'] ?>(){
              try {
                  const resD = await fetch('<?= base_url('admin/page/home/slider/pollCompress') ?>/desktop/'+encodeURIComponent(srcD<?= $s['id'] ?>));
                  const resM = await fetch('<?= base_url('admin/page/home/slider/pollCompress') ?>/mobile/'+encodeURIComponent(srcM<?= $s['id'] ?>));
                  const dataD = await resD.json();
                  const dataM = await resM.json();

                  document.getElementById('progressD'+sliderId<?= $s['id'] ?>).style.width = (dataD.progress || 0)+'%';
                  document.getElementById('progressM'+sliderId<?= $s['id'] ?>).style.width = (dataM.progress || 0)+'%';

                  const st = document.getElementById('status-'+sliderId<?= $s['id'] ?>);
                  if(dataD.status==='done' && dataM.status==='done'){
                      st.textContent='Active';
                      st.className='text-green-700 font-semibold';
                  } else if(dataD.status==='error' || dataM.status==='error'){
                      st.textContent='Error';
                      st.className='text-red-700 font-semibold';
                  } else {
                      st.textContent='Compressing...';
                      st.className='text-yellow-600 font-semibold';
                  }
              } catch(e){
                  console.error('Failed to poll compress status', e);
              }
          }

          setInterval(checkSliderStatus<?= $s['id'] ?>, 2000);
          </script>

          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?= $this->include('adminpartial/footer') ?>