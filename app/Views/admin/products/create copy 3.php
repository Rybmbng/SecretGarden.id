
  <style>
   /* Custom scrollbar for description textarea toolbar */
    .toolbar button {
      all: unset;
      cursor: pointer;
      padding: 0 0.25rem;
      font-size: 0.875rem;
      color: #4b5563;
    }
    .toolbar button:hover {
      color: #111827;
    }
  </style>

  <div class="max-w-[900px] mx-auto flex flex-col md:flex-row gap-6">
   <div class="flex-1 space-y-6">
    <div>
     <a class="text-[11px] font-semibold text-[#22a55f]" href="#">
      Brand link
     </a>
     <h1 class="mt-1 text-[15px] font-normal text-[#111827]">
      Title
     </h1>
    </div>
    <form class="space-y-6" onsubmit="return false;">
     <!-- Product info -->
     <fieldset class="bg-white rounded border border-[#e5e7eb] p-4 space-y-4">
      <legend class="text-[13px] font-semibold text-[#374151] px-1">
       Product info
      </legend>
      <!-- Thumbnail -->
      <div>
       <label class="block text-[11px] font-semibold text-[#374151] mb-1" for="thumbnail">
        Thumbnail
       </label>
       <div class="flex items-center gap-3">
        <button class="flex items-center gap-1 text-[11px] font-semibold bg-[#22a55f] text-white rounded px-2 py-1 hover:bg-[#1e9a56] transition" type="button">
         <i class="fas fa-upload text-[10px]">
         </i>
         Upload photo
        </button>
        <button class="text-[11px] font-semibold text-[#ef4444] border border-[#ef4444] rounded px-2 py-1 hover:bg-[#ef4444] hover:text-white transition" type="button">
         Delete
        </button>
       </div>
       <p class="mt-1 text-[9px] text-[#6b7280]">
        Your image should be square, at least 100x100px, and JPG or PNG.
       </p>
      </div>
      <!-- Name -->
      <div>
       <label class="block text-[11px] font-semibold text-[#374151] mb-1 flex items-center gap-1" for="name">
        Name
        <span class="inline-block w-3 h-3 rounded-full border border-[#6b7280] text-[9px] text-[#6b7280] font-semibold text-center cursor-default" title="Name field info">
         ?
        </span>
       </label>
       <input class="w-full rounded border border-[#d1d5db] text-[11px] text-[#374151] px-2 py-1 focus:outline-none focus:ring-1 focus:ring-[#22a55f]" id="name" placeholder="Shirt, t-shirts, etc." type="text"/>
      </div>
      <!-- SKU and Weight -->
      <div class="flex gap-4">
       <div class="flex-1">
        <label class="block text-[9px] font-semibold text-[#6b7280] mb-1 uppercase" for="sku">
         SKU
        </label>
        <input class="w-full rounded border border-[#d1d5db] text-[11px] text-[#374151] px-2 py-1 focus:outline-none focus:ring-1 focus:ring-[#22a55f]" id="sku" placeholder="eg. 348121032" type="text"/>
       </div>
       <div class="flex-1">
        <label class="block text-[9px] font-semibold text-[#6b7280] mb-1 uppercase flex items-center justify-between" for="weight">
         <span>
          Weight
         </span>
         <select class="text-[9px] border border-[#d1d5db] rounded px-1 py-[2px] text-[#374151] focus:outline-none focus:ring-1 focus:ring-[#22a55f]" id="weight-unit">
          <option>
           kg
          </option>
          <option>
           lb
          </option>
         </select>
        </label>
        <input class="w-full rounded border border-[#d1d5db] text-[11px] text-[#374151] px-2 py-1 focus:outline-none focus:ring-1 focus:ring-[#22a55f]" id="weight" min="0" step="0.1" type="number" value="0.0"/>
        <p class="mt-1 text-[8px] text-[#6b7280]">
         Used to calculate shipping rates at checkout and label prices during fulfillment.
        </p>
       </div>
      </div>
      <!-- Description -->
      <div>
       <label class="block text-[11px] font-semibold text-[#374151] mb-1" for="description">
        Description
       </label>
       <div class="border border-[#d1d5db] rounded">
        <div class="toolbar flex gap-1 border-b border-[#d1d5db] bg-[#f9faf7] px-2 py-1">
         <button aria-label="Bold" title="Bold" type="button">
          <i class="fas fa-bold">
          </i>
         </button>
         <button aria-label="Italic" title="Italic" type="button">
          <i class="fas fa-italic">
          </i>
         </button>
         <button aria-label="Underline" title="Underline" type="button">
          <i class="fas fa-underline">
          </i>
         </button>
         <button aria-label="Strikethrough" title="Strikethrough" type="button">
          <i class="fas fa-strikethrough">
          </i>
         </button>
         <button aria-label="Link" title="Link" type="button">
          <i class="fas fa-link">
          </i>
         </button>
         <button aria-label="Bullet list" title="Bullet list" type="button">
          <i class="fas fa-list-ul">
          </i>
         </button>
         <button aria-label="Numbered list" title="Numbered list" type="button">
          <i class="fas fa-list-ol">
          </i>
         </button>
         <button aria-label="Code" title="Code" type="button">
          <i class="fas fa-code">
          </i>
         </button>
        </div>
        <textarea class="w-full resize-none border-none text-[11px] text-[#6b7280] px-2 py-1 focus:outline-none" id="description" placeholder="Add a message, if you'd like." rows="5"></textarea>
       </div>
      </div>
     </fieldset>
     <!-- Media -->
     <fieldset class="bg-white rounded border border-[#e5e7eb] p-4 space-y-2">
      <legend class="text-[13px] font-semibold text-[#374151] px-1">
       Media
      </legend>
      <div class="flex justify-end">
       <button class="text-[9px] font-semibold border border-[#d1d5db] rounded px-2 py-1 hover:bg-[#f3f4f6] transition" type="button">
        Upload from URL
       </button>
      </div>
      <label class="block w-full cursor-pointer rounded border-2 border-dashed border-[#d1d5db] p-8 text-center text-[11px] text-[#6b7280] hover:border-[#22a55f] transition" for="media-upload">
       <img alt="Icon representing image upload with a picture and a plus sign" class="mx-auto mb-2" height="40" loading="lazy" src="https://storage.googleapis.com/a1aa/image/933ccb2f-023e-40aa-49ed-5c0df504a988.jpg" width="40"/>
       <span class="font-semibold text-[#374151]">
        Drop your files here or
        <span class="text-[#22a55f]">
         browse
        </span>
       </span>
       <br/>
       <span class="text-[8px]">
        CSV, XLS, DOCX
       </span>
       <input class="hidden" id="media-upload" multiple="" type="file"/>
      </label>
      <p class="text-[9px] text-[#6b7280]">
       Add up to 10 images to your product.
      </p>
     </fieldset>
     <!-- Variants -->
     <fieldset class="bg-white rounded border border-[#e5e7eb] p-4 space-y-2">
      <legend class="text-[13px] font-semibold text-[#374151] px-1">
       Variants
      </legend>
      <div class="grid grid-cols-12 gap-2 text-[8px] font-semibold text-[#6b7280] uppercase px-1">
       <div class="col-span-3">
        Size
       </div>
       <div class="col-span-3">
        Color
       </div>
       <div class="col-span-2">
        Price
       </div>
       <div class="col-span-3">
        Quantity
       </div>
       <div class="col-span-1">
       </div>
      </div>
      <div class="grid grid-cols-12 gap-2 items-center px-1">
       <input class="col-span-3 rounded border border-[#d1d5db] text-[11px] text-[#374151] px-2 py-1 focus:outline-none focus:ring-1 focus:ring-[#22a55f]" placeholder="" type="text"/>
       <input class="col-span-3 rounded border border-[#d1d5db] text-[11px] text-[#374151] px-2 py-1 focus:outline-none focus:ring-1 focus:ring-[#22a55f]" placeholder="" type="text"/>
       <div class="col-span-2 flex">
        <input class="w-full rounded-l border border-[#d1d5db] border-r-0 text-[11px] text-[#374151] px-2 py-1 focus:outline-none focus:ring-1 focus:ring-[#22a55f]" placeholder="USD" type="text"/>
        <span class="rounded-r border border-[#d1d5db] border-l-0 bg-white text-[9px] text-[#6b7280] flex items-center justify-center px-2 select-none">
         USD
        </span>
       </div>
       <div class="col-span-3 flex items-center gap-2">
        <button aria-label="Decrease quantity" class="text-[11px] font-semibold border border-[#d1d5db] rounded px-2 py-0.5 select-none" type="button">
         −
        </button>
        <input class="w-12 text-center rounded border border-[#d1d5db] text-[11px] text-[#374151] px-2 py-1 focus:outline-none focus:ring-1 focus:ring-[#22a55f]" min="0" type="number" value="0"/>
        <button aria-label="Increase quantity" class="text-[11px] font-semibold border border-[#d1d5db] rounded px-2 py-0.5 select-none" type="button">
         +
        </button>
       </div>
       <button aria-label="Remove variant" class="col-span-1 text-[11px] font-semibold text-[#6b7280] hover:text-[#ef4444] transition" type="button">
        ×
       </button>
      </div>
      <button class="text-[9px] font-semibold text-[#6b7280] px-2 py-1 rounded border border-[#d1d5db] hover:bg-[#f3f4f6] transition" type="button">
       + Add variant
      </button>
     </fieldset>
    </form>
   </div>
   <!-- Right side panel -->
   <div class="w-full max-w-[280px] space-y-6">
    <!-- Pricing -->
    <fieldset class="bg-white rounded border border-[#e5e7eb] p-4 space-y-3">
     <legend class="text-[13px] font-semibold text-[#374151] px-1">
      Pricing
     </legend>
     <div>
      <label class="block text-[11px] font-semibold text-[#374151] mb-1" for="price">
       Price
      </label>
      <input class="w-full rounded border border-[#d1d5db] text-[11px] text-[#374151] px-2 py-1 mb-2 focus:outline-none focus:ring-1 focus:ring-[#22a55f]" id="price" type="text" value="45.00"/>
      <select aria-label="Currency" class="w-full rounded border border-[#d1d5db] text-[9px] text-[#374151] px-2 py-[2px] mb-3 focus:outline-none focus:ring-1 focus:ring-[#22a55f]">
       <option>
        IDR
       </option>
      </select>
      <div class="flex items-center justify-between mb-2">
       <span class="text-[9px] font-semibold text-[#6b7280]">
        Availability
       </span>
       <label class="inline-flex relative items-center cursor-pointer" for="availability-toggle">
        <input class="sr-only peer" id="availability-toggle" type="checkbox"/>
        <div class="w-9 h-5 bg-gray-200 rounded-full peer peer-checked:bg-[#22a55f] peer-focus:ring-2 peer-focus:ring-[#22a55f] transition">
        </div>
        <div class="absolute left-[2px] top-[2px] bg-white border border-gray-300 rounded-full w-4 h-4 transition peer-checked:translate-x-[1.3rem]">
        </div>
       </label>
      </div>
      <div class="text-[9px] text-[#22a55f] font-semibold space-y-1">
       <p>
        ★ Set "Compare to" price
       </p>
       <p>
        ★ Bulk discount pricing
       </p>
      </div>
     </div>
    </fieldset>
    <!-- Organization -->
    <fieldset class="bg-white rounded border border-[#e5e7eb] p-4 space-y-3">
     <legend class="text-[13px] font-semibold text-[#374151] px-1">
      Organization
     </legend>
     <div>
      <label class="block text-[11px] font-semibold text-[#374151] mb-1" for="vendor">
       Vendor
      </label>
      <input class="w-full rounded border border-[#d1d5db] text-[11px] text-[#374151] px-2 py-1 focus:outline-none focus:ring-1 focus:ring-[#22a55f]" id="vendor" placeholder="eg. Nike" type="text"/>
     </div>
     <div>
      <label class="block text-[11px] font-semibold text-[#374151] mb-1" for="category">
       Category
      </label>
      <select class="w-full rounded border border-[#d1d5db] text-[11px] text-[#374151] px-2 py-1 focus:outline-none focus:ring-1 focus:ring-[#22a55f]" id="category">
       <option disabled="" selected="">
        Select option...
       </option>
       <option>
        Option 1
       </option>
       <option>
        Option 2
       </option>
      </select>
     </div>
     <div>
      <label class="block text-[11px] font-semibold text-[#374151] mb-1" for="collections">
       Collections
      </label>
      <select class="w-full rounded border border-[#d1d5db] text-[11px] text-[#374151] px-2 py-1 focus:outline-none focus:ring-1 focus:ring-[#22a55f]" id="collections">
       <option disabled="" selected="">
        Select option...
       </option>
       <option>
        Option 1
       </option>
       <option>
        Option 2
       </option>
      </select>
      <p class="text-[8px] text-[#6b7280] mt-1">
       Add this product to a collection so it's easy to find in your store.
      </p>
     </div>
     <div>
      <label class="block text-[11px] font-semibold text-[#374151] mb-1" for="tags">
       Tags
      </label>
      <input class="w-full rounded border border-[#d1d5db] text-[11px] text-[#374151] px-2 py-1 focus:outline-none focus:ring-1 focus:ring-[#22a55f]" id="tags" placeholder="Enter tags" type="text"/>
     </div>
    </fieldset>
   </div>
  </div>