<div x-data="{ searchOpen: false, query: '', results: [], loading: false }" class="relative">

    <button @click="searchOpen = true; $nextTick(() => $refs.searchInput.focus())"
            class="p-2 rounded hover:bg-gray-200  lg:flex items-center justify-center">
        <i data-lucide="search" class="w-5 h-5 text-gray-700"></i>
    </button>

    <div x-show="searchOpen" x-cloak
         x-transition:enter="transition ease-out duration-400"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex flex-col items-center justify-start bg-white/90 backdrop-blur-md p-6 overflow-y-auto">

        <div @click.away="searchOpen = false"
             x-transition:enter="transition transform ease-out duration-500"
             x-transition:enter-start="translate-y-[-50px] scale-95 opacity-0"
             x-transition:enter-end="translate-y-0 scale-100 opacity-100"
             x-transition:leave="transition transform ease-in duration-300"
             x-transition:leave-start="translate-y-0 scale-100 opacity-100"
             x-transition:leave-end="translate-y-[-50px] scale-95 opacity-0"
             class="w-full max-w-3xl bg-white rounded-3xl p-6 mt-24 flex flex-col gap-6 border border-gray-200 shadow-lg">

            <div class="relative">
                <input x-ref="searchInput" type="text" placeholder="Type product, variant, or category..." x-model="query"
                       @input.debounce.300ms="
                           if(query.length > 0){
                               loading = true;
                               results = [];
                               $refs.ripple.classList.remove('scale-0');
                               $refs.ripple.classList.add('scale-100');
                               fetch('<?= base_url("search/query") ?>?q=' + encodeURIComponent(query))
                                   .then(res => res.json())
                                   .then(data => {
                                       results = data;
                                       loading = false;
                                       $refs.ripple.classList.remove('scale-100');
                                       $refs.ripple.classList.add('scale-0');
                                   });
                           } else { results = []; }
                       "
                       class="w-full bg-gray-50 border border-gray-300 rounded-xl py-4 pl-14 pr-4 text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-indigo-400 outline-none text-lg transition-all duration-300">
                <span class="absolute left-5 top-4 text-gray-400 text-lg">🔍</span>
                <span x-ref="ripple" class="absolute left-0 top-0 w-full h-full rounded-xl bg-indigo-100/50 scale-0 pointer-events-none transition-transform duration-500"></span>
            </div>

            <div x-show="loading" class="text-gray-500 italic">Searching...</div>

            <div class="flex flex-col gap-3 max-h-80 overflow-y-auto mt-2">
                <template x-for="(item,index) in results" :key="item.url">
                    <a :href="item.url"
                       x-transition:enter="transition ease-out duration-500"
                       x-transition:enter-start="opacity-0 translate-y-4"
                       x-transition:enter-end="opacity-100 translate-y-0"
                       :style="'transition-delay:' + (index*50) + 'ms'"
                       class="flex items-center gap-3 p-3 rounded-xl bg-gray-100 hover:bg-indigo-100 transition shadow-sm text-gray-800">

                        <template x-if="item.type=='product' && item.image">
                            <img :src="item.image" class="w-12 h-12 object-cover rounded" alt="">
                        </template>

                        <template x-if="item.type!='product'">
                            <div class="w-12 h-12 flex items-center justify-center bg-gray-200 rounded text-lg font-bold text-gray-700">
                                <span x-text="item.type=='variant' ? 'V' : 'C'"></span>
                            </div>
                        </template>

                        <span class="font-semibold" x-html="item.name.replace(new RegExp(query,'gi'), match => '<mark class=\'bg-indigo-200 text-gray-900 rounded px-1\'>'+match+'</mark>')"></span>
                    </a>
                </template>

                <div x-show="query.length > 0 && results.length === 0 && !loading" class="text-gray-500 italic">
                    No results found.
                </div>
            </div>
        </div>
    </div>
</div>
