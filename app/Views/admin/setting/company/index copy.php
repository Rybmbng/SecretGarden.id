<?= view('adminpartial/header'); ?>

<div class="w-full mx-auto py-10 px-6">
  <h1 class="text-3xl font-bold mb-8 text-gray-800">Company Settings</h1>

  <?php if(session()->getFlashdata('success')): ?>
    <div class="p-4 mb-4 text-white bg-[<?= $companySetting['base_color']?>] rounded-lg">
      <?= session()->getFlashdata('success') ?>
    </div>
  <?php endif; ?>

  <form action="<?= base_url('admin/setting/company/update') ?>" method="post" enctype="multipart/form-data" class="bg-white shadow-md rounded-2xl p-6">
    <input type="hidden" name="id" value="<?= $company['id'] ?? '' ?>">

    <div class="mb-4">
      <label class="block text-gray-700 font-semibold mb-2">Company Name</label>
      <input type="text" name="name" value="<?= esc($company['name'] ?? '') ?>" class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-200">
    </div>

    <div class="mb-4">
      <label class="block text-gray-700 font-semibold mb-2">Tagline</label>
      <input type="text" name="tagline" value="<?= esc($company['tagline'] ?? '') ?>" class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-200">
    </div>

    <div class="mb-4 grid grid-cols-2 gap-6">
      <div>
        <label class="block text-gray-700 font-semibold mb-2">Logo</label>
        <?php if(!empty($company['logo'])): ?>
          <img src="<?= base_url($company['logo']) ?>" alt="Logo" class="h-16 mb-2">
        <?php endif; ?>
        <input type="file" name="logo" class="w-full text-sm">
      </div>
      <div>
        <label class="block text-gray-700 font-semibold mb-2">Favicon</label>
        <?php if(!empty($company['favicon'])): ?>
          <img src="<?= base_url($company['favicon']) ?>" alt="Favicon" class="h-12 mb-2">
        <?php endif; ?>
        <input type="file" name="favicon" class="w-full text-sm">
      </div>
    </div>

    <div cla<div x-data="{ font: '<?= $company['font'] ?? 'Arial' ?>' }" class="mb-6">
      <div class="mt-4 p-4 border rounded bg-gray-50">
        <p :style="`font-family: ${font}`" class="text-lg">
          The quick brown fox jumps over the lazy dog.
        </p>
        <span class="text-xs text-gray-500 font-mono" x-text="font"></span>
      </div>

      <label for="font" class="block text-sm font-medium text-gray-700 mb-2">
        Font Display
      </label>
      <select
        id="font"
        name="font"
        x-model="font"
        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
      >
        <option disabled>Select Font</option>
        <option value="Arial">Arial</option>
        <option value="sans-serif">Sans</option>
        <option value="serif">Serif</option>
        <option value="monospace">Mono</option>
        <option value="'Playfair Display', serif">Playfair</option>
      </select>
    </div>


    <div class="mb-4 grid grid-cols-2 gap-6">
     <div x-data="{ color: '<?=$company["base_color"]?>', alpha: 100 }" >
        <label class="block text-sm font-medium text-gray-700">Select Base Color</label>
        <div class="flex gap-2 flex-wrap">
            <?php
            $colors = array_unique(array_merge(
              [$company['base_color'] ?? '#ef4444','#22c55e', '#3b82f6', '#eab308', '#a855f7', '#6b7280'],
            ));
            ?>
          <template x-for="hex in [<?= implode(',', array_map(fn($c) => "'$c'", $colors)) ?>]">
            <div
              :style="`background-color: ${hex}`"
              @click="color = hex"
              class="w-8 h-8 rounded cursor-pointer border border-gray-300"
              :class="{ 'ring-2 ring-offset-2 ring-[<?=$company["base_color"]?>]': color === hex }"
            ></div>
          </template>

        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Opacity: <span x-text="alpha + '%'"></span></label>
          <input type="range" min="0" max="100" x-model="alpha" class="w-full mt-1" />
        </div>

        <div class="flex items-center gap-2 mt-4">
          <div
            :style="`background-color: ${color}; opacity: ${alpha / 100}`"
            class="w-10 h-10 border rounded"
          ></div>
          <span class="font-mono text-sm" x-text="`${color}`"></span>
        </div>

        <input type="hidden" name="base_color" :value="color" />
      </div>
    </div>
    
    
    <div class="mt-6">
      <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700">💾 Save Changes</button>
    </div>

  </form>
</div>
<?=view("adminpartial/footer")?>