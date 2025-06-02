<?= $this->include('partials/header') ?>

<div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 lg:grid-cols-5 gap-12">

    <!-- Sidebar Kategori + Filter -->
    <aside class="col-span-1 border rounded-xl p-6 shadow-md bg-white sticky top-20 h-max">

        <h2 class="text-2xl font-bold mb-6">Categories</h2>
        <ul class="space-y-3 mb-10">
            <li>
                <a href="/products/category/all"
                   class="block px-4 py-2 rounded-full font-semibold transition
                   <?= $activeCategory === 'all' ? 'bg-indigo-700 text-white' : 'text-gray-700 hover:bg-indigo-600 hover:text-white' ?>">
                    All Categories
                </a>
            </li>
            <?php foreach ($categories as $cat): ?>
            <li>
                <a href="/products/category/<?= esc($cat) ?>"
                   class="block px-4 py-2 rounded-full font-semibold transition
                   <?= $activeCategory === $cat ? 'bg-indigo-700 text-white' : 'text-gray-700 hover:bg-indigo-600 hover:text-white' ?>">
                    <?= esc(ucwords($cat)) ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>

        <h2 class="text-2xl font-bold mb-6">Filter by Price</h2>
        <form method="GET" action="" class="space-y-4">
            <div>
                <label for="min_price" class="block font-semibold mb-1">Min Price</label>
                <input
                    id="min_price"
                    name="min_price"
                    type="number"
                    min="0"
                    placeholder="Rp. 0"
                    value="<?= esc($minPrice) ?>"
                    class="w-full border rounded px-3 py-2"
                />
            </div>

            <div>
                <label for="max_price" class="block font-semibold mb-1">Max Price</label>
                <input
                    id="max_price"
                    name="max_price"
                    type="number"
                    min="0"
                    placeholder="Rp. 1.000.000"
                    value="<?= esc($maxPrice) ?>"
                    class="w-full border rounded px-3 py-2"
                />
            </div>

            <div>
                <label for="search" class="block font-semibold mb-1">Search</label>
                <input
                    id="search"
                    name="search"
                    type="text"
                    placeholder="Search products..."
                    value="<?= esc($search) ?>"
                    class="w-full border rounded px-3 py-2"
                />
            </div>

            <button type="submit"
                    class="w-full bg-indigo-700 text-white py-2 rounded hover:bg-indigo-800 transition">
                Apply Filters
            </button>

            <a href="/products/category/<?= esc($activeCategory) ?>"
               class="block mt-4 text-center text-indigo-600 hover:underline font-semibold">
                Reset Filters
            </a>
        </form>

    </aside>

    <!-- Produk List -->
    <section class="col-span-4">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-6 text-gray-600 text-sm">
            <ol class="list-reset flex flex-wrap gap-2">
                <li><a href="/" class="hover:underline">Home</a></li>
                <li>/</li>
                <li><a href="/products" class="hover:underline">Products</a></li>
                <li>/</li>
                <li class="font-semibold text-indigo-700 capitalize"><?= esc($activeCategory) ?></li>
            </ol>
        </nav>

        <h1 class="text-4xl font-extrabold mb-8 capitalize"><?= esc($activeCategory) ?></h1>

        <?php if(empty($products)): ?>
            <p class="text-gray-500 text-center py-20 text-lg">No products found.</p>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                <?php foreach ($products as $product): ?>
                <a href="/products/<?= esc($product['slug']) ?>"
                   class="block bg-white rounded-2xl shadow-lg overflow-hidden transform hover:scale-[1.04] transition-transform duration-300">
                    <img
                        src="<?= esc($product['image_url']) ?: 'https://via.placeholder.com/400x300?text=No+Image' ?>"
                        alt="<?= esc($product['name']) ?>"
                        class="w-full h-48 object-cover"
                    />
                    <div class="p-5">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2"><?= esc($product['name']) ?></h2>
                        <p class="text-indigo-600 font-bold text-lg mb-3"><?= 'Rp. ' . number_format($product['price'], 0, ',', '.') ?></p>
                        <p class="text-gray-700 line-clamp-3 mb-4"><?= esc($product['description']) ?></p>
                        <span class="inline-block px-3 py-1 text-sm text-indigo-700 bg-indigo-100 rounded-full font-semibold">
                            <?= esc($product['category']) ?>
                        </span>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </section>
</div>

<?= $this->include('partials/footer') ?>
