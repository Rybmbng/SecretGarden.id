<?php
session()->start();
$cart = session('cart') ?? [];
// echo '<pre>' . print_r($product, true) . '</pre>';

// echo $cart ? '<pre>' . print_r($cart, true) . '</pre>' : 'Keranjang kosong.';
?>
<?php echo view('partials/header'); ?>
<section class="bg-white py-8 antialiased light:bg-gray-900 md:py-16">
  <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
    <h2 class="text-xl font-semibold text-gray-900 light:text-white sm:text-2xl">Shopping Cart</h2>

    <div class="mt-6 sm:mt-8 md:gap-6 lg:flex lg:items-start xl:gap-8">
      <div class="mx-auto w-full flex-none lg:max-w-2xl xl:max-w-4xl">
        <div class="space-y-6">
         <?php 
          if (empty($cart)) {
              echo '<div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm light:border-gray-700 light:bg-gray-800">
                      <p class="text-center text-gray-500 light:text-gray-400">Your cart is empty.</p>
                    </div>';
              }
          ?>
         <?php foreach ($cart as $item): ?>
          <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm light:border-gray-700 light:bg-gray-800 md:p-6">
            <div class="space-y-4 md:flex md:items-center md:justify-between md:gap-6 md:space-y-0">
              <a href="" class="shrink-0 md:order-1">
                <img class="h-20 w-20 rounded-lg light:hidden" src="<?= base_url("assets/SGV/Category/" . strtolower(str_replace(" ", "-", $item["category"])) . "/" . strtolower(str_replace(" ", "-", $item["name"])) . "/" .strtolower(str_replace(" ", "-", $item["variant"])) .'/'. $item['image']) ?>" alt="<?= $item['name'] ?>" />
              </a>

              <label for="counter-input" class="sr-only">Choose quantity:</label>
              <div class="flex items-center justify-between md:order-3 md:justify-end">
                <div class="flex items-center">
                  <a href="<?= base_url('cart/min/' . $item['idVariant']) ?>"  id="decrement-button" data-input-counter-decrement="counter-input" class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 light:border-gray-600 light:bg-gray-700 light:hover:bg-gray-600 light:focus:ring-gray-700">
                    <svg class="h-2.5 w-2.5 text-gray-900 light:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                    </svg>
                  </a>
                  <input type="text" id="counter-input" data-input-counter class="w-10 shrink-0 border-0 bg-transparent text-center text-sm font-medium text-gray-900 focus:outline-none focus:ring-0 light:text-white" placeholder="" value="<?=$item['qty']?>" required />
                  <a href="<?= base_url('cart/add/' .$item['id'] .'/'. $item['idVariant']) ?>"  id="increment-button" data-input-counter-increment="counter-input" class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 light:border-gray-600 light:bg-gray-700 light:hover:bg-gray-600 light:focus:ring-gray-700">
                    <svg class="h-2.5 w-2.5 text-gray-900 light:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                    </svg>
                  </a>
                </div>
                <div class="text-end md:order-4 md:w-32">
                    <p class="text-base font-bold text-gray-900 light:text-white">
                        Rp. <?php echo number_format($item['price'] * $item['qty'], 2); ?>
                    </p>
                </div>
              </div>

              <div class="w-full min-w-0 flex-1 space-y-4 md:order-2 md:max-w-md">
                <a href="<?= site_url('products/' . strtolower(str_replace(' ', '-', $item['name']))) ?>" class="text-base font-medium text-gray-900 hover:underline light:text-white"><?php echo esc($item['name']) ?> (<?= esc($item['variant']); ?>)</a>

                <div class="flex items-center gap-4">
                  <a href="<?= base_url('cart/fav/' . $item['idVariant']) ?>"  class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 hover:underline light:text-gray-400 light:hover:text-white">
                    <svg class="me-1.5 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z" />
                    </svg>
                    Add to Favorites
                  </a>

                  <a href="<?= base_url('cart/remove/' . $item['idVariant']) ?>"  class="inline-flex items-center text-sm font-medium text-red-600 hover:underline light:text-red-500">
                    <svg class="me-1.5 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                    </svg>
                    Remove
                  </a>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <div class="hidden xl:mt-8 xl:block">
          <h3 class="text-2xl font-semibold text-gray-900 light:text-white">People also bought</h3>
          <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
            <?php
              $randomProducts = [];
              foreach ($product as $category) {
                foreach ($category['products'] as $p) {
                  $p['category'] = $category; 
                  $randomProducts[] = $p;
                }
              }
              shuffle($randomProducts);
              $randomProducts = array_slice($randomProducts, 0, 6);
            ?>

            <?php foreach ($randomProducts as $products): ?>
              <div class="space-y-4 overflow-hidden rounded-lg border border-gray-200 bg-white p-4 shadow-sm light:border-gray-700 light:bg-gray-800">
                <a href="<?= site_url('products/' . strtolower($products['slug'])) ?>" class="block overflow-hidden rounded">
                  <img src="<?= base_url('assets/SGV/Category/' . strtolower($products['category']['path']) . '/'. strtolower(str_replace(" ","-",$products['name'])).'/' . strtolower(str_replace(" ","-",$products['pname'])).'/' . $products['img']) ?>" alt="<?= $products['name'] ?>" class="w-full h-52 object-cover rounded">
                </a>
                <div>
                  <a href="<?= site_url('products/' . strtolower($products['slug'])) ?>" class="text-lg font-semibold text-gray-900 hover:underline light:text-white">
                    <?= $products['name'] ?> 
                  </a>
                  <p class="text-sm text-gray-500 mt-1 light:text-gray-400"><?= $products['description'] ?: 'Tanpa deskripsi.' ?></p>
                </div>
                <div>
                  <!-- <p class="text-sm text-gray-400 line-through">Rp <?= number_format($products['variant_price'] * 1.2, 0, ',', '.') ?></p> -->
                  <p class="text-lg font-bold text-red-600 light:text-red-500">Rp <?= number_format($products['variant_price'], 0, ',', '.') ?></p>
                </div>
                <div class="flex items-center gap-2.5 mt-4">
                  <button data-tooltip-target="favourites-tooltip-<?= $products['id'] ?>" type="button" class="p-2 rounded-lg border text-gray-900 hover:bg-gray-100 light:border-gray-600 light:bg-gray-800 light:text-gray-400 light:hover:bg-gray-700">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6C6.5 1 1 8 5.8 13l6.2 7 6.2-7C23 8 17.5 1 12 6Z"/></svg>
                  </button>
                  <button type="button" class="flex-1 inline-flex items-center justify-center rounded-lg bg-primary-700 px-4 py-2 text-sm font-medium text-white hover:bg-primary-800">
                    <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16h8m-8 0a2 2 0 100 4 2 2 0 000-4zm8 0a2 2 0 100 4 2 2 0 000-4zM8.5 13h9.25L19 7h-1M8 7H7.3M13 5v4m-2-2h4"/></svg>
                    Tambah ke Keranjang
                  </button>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

      <div class="mx-auto mt-6 max-w-4xl flex-1 space-y-6 lg:mt-0 lg:w-full">
        <div class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm light:border-gray-700 light:bg-gray-800 sm:p-6">
          <p class="text-xl font-semibold text-gray-900 light:text-white">Order summary</p>

          <div class="space-y-4">
            <div class="space-y-2">
              <dl class="flex items-center justify-between gap-4">
                <dt class="text-base font-normal text-gray-500 light:text-gray-400">Original price</dt>
                <dd class="text-base font-medium text-gray-900 light:text-white">
                  <?php
                    $price = 0;
                    foreach ($cart as $item) {
                      $price += $item['price'] * $item['qty'];
                    }
                    echo 'Rp.'.$price;
                  ?>
                </dd>
              </dl>

              <!-- <dl class="flex items-center justify-between gap-4">
                <dt class="text-base font-normal text-gray-500 light:text-gray-400">Savings</dt>
                <dd class="text-base font-medium text-green-600">-$299.00</dd>
              </dl> -->

              <dl class="flex items-center justify-between gap-4">
                <dt class="text-base font-normal text-gray-500 light:text-gray-400">Store Pickup</dt>
                <dd class="text-base font-medium text-gray-900 light:text-white">
                  <?php
                    if($price > 10000)
                    { $ship = 10000; }else{ $ship = 0; }
                    echo 'Rp.'.$ship;
                  ?>
                  </dd>
              </dl>

              <dl class="flex items-center justify-between gap-4">
                <dt class="text-base font-normal text-gray-500 light:text-gray-400">Tax</dt>
                <dd class="text-base font-medium text-gray-900 light:text-white">
                  <?php
                    if($price > 10000)
                    { $tax = 10000; }else{ $tax = 0; }
                    echo 'Rp.'.$tax;
                  ?>
              </dl>
            </div>

            <dl class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 light:border-gray-700">
              <dt class="text-base font-bold text-gray-900 light:text-white">Total</dt>
              <dd class="text-base font-bold text-gray-900 light:text-white"><?php $total = $price + $ship + $tax; echo 'Rp.'.$total; ?> </dd>
            </dl>
          </div>
          
          <?php if ($total > 0): ?>
          <a href="/checkout" class="flex w-full items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-black hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 light:bg-primary-600 light:hover:bg-primary-700 light:focus:ring-primary-800">Proceed to Checkout</a>
          <?php endif ?>
          <div class="flex items-center justify-center gap-2">
            <a href="<?=base_url('products')?>" title="" class="inline-flex items-center gap-2 text-sm font-medium text-primary-700 underline hover:no-underline light:text-primary-500">
              Continue Shopping
              <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4" />
              </svg>
            </a>
          </div>
        </div>

        <div class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm light:border-gray-700 light:bg-gray-800 sm:p-6">
          <form class="space-y-4">
            <div>
              <label for="voucher" class="mb-2 block text-sm font-medium text-gray-900 light:text-white"> Do you have a voucher or gift card? </label>
              <input type="text" id="voucher" class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 light:border-gray-600 light:bg-gray-700 light:text-white light:placeholder:text-gray-400 light:focus:border-primary-500 light:focus:ring-primary-500" placeholder="" required />
            </div>
            <button type="submit" class="flex w-full items-center justify-center rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 light:bg-primary-600 light:hover:bg-primary-700 light:focus:ring-primary-800">Apply Code</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<?php echo view('partials/footer'); ?>