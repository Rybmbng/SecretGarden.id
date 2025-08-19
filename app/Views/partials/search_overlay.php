<div id="searchOverlay" class="absolute inset-0 bg-white z-50 p-6 h-[100vh] hidden opacity-100">
    <button id="closeSearch" class="absolute top-4 right-6 text-2xl font-light">✕</button>
    <div class="max-w-2xl mx-auto mt-24 text-center h-[100vh]">
        <input type="text" id="searchInput" class="w-full text-2xl border-b border-gray-400 focus:outline-none placeholder-gray-400" placeholder="Search for a product..." autocomplete="off">
                <div id="searchSuggestions" class="mt-8 text-left">
            <p class="text-gray-500 mb-2">Popular Searches:</p>
            <ul class="space-y-2">
                <li><a href="<?= base_url('/category/Body-Care') ?>" class="text-lg hover:underline">Body Care</a></li>
                <li><a href="<?= base_url('/category/Hand-Wash') ?>" class="text-lg hover:underline">Hand Wash</a></li>
                <li><a href="<?= base_url('/category/Perfume') ?>" class="text-lg hover:underline">Perfume</a></li>
            </ul>
        </div>
    </div>
</div>