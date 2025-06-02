<html class="scroll-smooth" lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>
   SGV
  </title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&amp;display=swap" rel="stylesheet"/>

<link rel="shortcut icon" href="https://www.secretgarden.co.id/skins/secret//img/logo/favicon.png" type="image/x-icon">
<link rel="icon" href="https://www.secretgarden.co.id/skins/secret//img/logo/favicon.png" type="image/x-icon">
  <style>
   html,
    body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      scroll-behavior: smooth;
      background-color: #ffffff;
      color: #0a2540;
    }
    /* Remove gap between sections */
    section {
      margin: 0;
      padding: 0;
    }
    /* Parallax container */
    .parallax {
      perspective: 1000px;
      overflow-x: hidden;
      overflow-y: auto;
      height: 100vh;
      scroll-snap-type: y mandatory;
    }
    /* Each page full viewport height */
    .page {
      scroll-snap-align: start;
      height: 100vh;
      position: relative;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
    /* Tilt Parallax effect container */
    .tilt-parallax {
      transform-style: preserve-3d;
      transition: transform 0.2s ease-out;
      will-change: transform;
    }
    /* Hide scrollbar for all browsers */
    .parallax::-webkit-scrollbar {
      display: none;
    }
    .parallax {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
    .slider-button {
      background-color: #8c9464;
      border: none;
      color: #a1c6ea;
      font-size: 1.5rem;
      padding: 0.5rem 0.75rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
      user-select: none;
      box-shadow: 0 0 8px rgba(10,37,64,0.3);
    }
    .slider-button:hover {
      background-color: #a1c6ea;
      color: #0a2540;
    }
    video::-internal-media-controls {
      display:none;
    }
    nav {
      background-color: rgba(255 255 255 / 0.95);
      backdrop-filter: saturate(180%) blur(10px);
      color: #0a2540;
      box-shadow: 0 2px 8px rgba(10,37,64,0.1);
    }
    nav a {
      color: #0a2540;
      font-weight: 600;
    }
    nav a:hover {
      color: #4a90e2;
    }
    
    footer {
      background-color: #f0f6fc;
      color: #0a2540;
      box-shadow: inset 0 1px 0 #d9e6f5;
    }
    footer a {
      color: #4a90e2;
    }
    footer a:hover {
      color: #0a2540;
    }
    #discover h2, #discover p {
      color: #0a2540;
    }
    #discover button {
      background-color: #4a90e2;
      color: white;
    }
    #discover button:hover {
      background-color: #a1c6ea;
      color: #0a2540;
    }
    #ourStory {
      color: #0a2540;
      font-weight: 500;
      text-align: center;
      padding: 4rem 1.5rem;
      background: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1920&q=80') center center/cover no-repeat;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      overflow: hidden;
    }
    #ourStory::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(255 255 255 / 0.25);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      z-index: 1;
      pointer-events: none;
    }
    #ourStory img.bg-image {
      display: none;
    }
    #ourStory .content {
      position: relative;
      max-width: 900px;
      z-index: 10;
      background: rgba(255 255 255 / 0.6);
      padding: 2.5rem 3rem;
      border-radius: 1rem;
      box-shadow: 0 8px 24px rgba(10,37,64,0.15);
      backdrop-filter: saturate(180%) blur(10px);
      -webkit-backdrop-filter: saturate(180%) blur(10px);
    }
    #ourStory h2 {
      font-size: 2.75rem;
      font-weight: 700;
      margin-bottom: 1rem;
      color: #0a2540;
    }
    #ourStory p {
      font-size: 1.125rem;
      line-height: 1.6;
      color: #2c3e50;
      margin-bottom: 2rem;
    }
    #ourStory button {
      background-color: #4a90e2;
      color: white;
      font-weight: 600;
      padding: 0.75rem 2.5rem;
      border-radius: 9999px;
      font-size: 1.125rem;
      cursor: pointer;
      border: none;
      transition: background-color 0.3s ease;
      box-shadow: 0 4px 12px rgba(74,144,226,0.5);
    }
      video {
          width: 100%;
          height: auto;
      }
    #ourStory button:hover {
      background-color: #a1c6ea;
      color: #0a2540;
    }
    @media (max-width: 768px) {
      #ourStory {
        padding: 3rem 1rem;
      }
      #ourStory .content {
        padding: 2rem 1.5rem;
      }
      #ourStory h2 {
        font-size: 2rem;
      }
      #ourStory p {
        font-size: 1rem;
      }
      #ourStory button {
        width: 100%;
        font-size: 1rem;
        padding: 0.75rem 0;
      } 
      video {
              object-fit: cover;
          }
          
    #mainslider{
          margin: 0 ;
          width: 100vh;
          height:50vh;
    }
    }
    

     
  </style>
 </head>
 <body class="overflow-y-scroll parallax">
  <nav class="fixed top-0 left-0 w-full z-50 bg-white/95 backdrop-blur-sm shadow-sm">
   <div class="max-w-7xl mx-auto relative h-16 flex items-center px-6">
    <div class="absolute left-6 top-1/2 -translate-y-1/2 flex-shrink-0">
     <a href="/" class="block w-[120] h-[75] h-130 h-80"><img alt="/"   src="https://www.secretgarden.co.id/skins/secret/img/logo/logoSGVNew.png"  /></a>
    </div>
    <button id="menu-button" aria-label="Toggle menu" class="md:hidden absolute right-6 top-1/2 -translate-y-1/2 text-black text-2xl focus:outline-none">
     <i class="fas fa-bars"></i>
    </button>
    <ul id="menu" class="hidden md:flex space-x-8 text-black text-sm font-semibold tracking-wide mx-auto">
     <li class="flex items-center space-x-1 cursor-pointer select-none">
      <span>PRODUCTS</span>
      <i class="fas fa-chevron-down text-black text-xs"></i>
      <ul class="hidden absolute top-full left-0 w-48 bg-white shadow-md py-2" style="display: none;">
       <li class="px-4 py-2 hover:bg-gray-100"><a href="/products">All</a></li>
       <li class="px-4 py-2 hover:bg-gray-100"><a href="/products/category/skin">Skin</a></li>
       <li class="px-4 py-2 hover:bg-gray-100"><a href="/products/category/hair">Hair</a></li>
       <li class="px-4 py-2 hover:bg-gray-100"><a href="/products/category/body">Body</a></li>
       <li class="px-4 py-2 hover:bg-gray-100"><a href="/products/category/men">Men</a></li>
      </ul>
     </li>
     <li class="flex items-center cursor-pointer select-none">STORY</li>
     <li class="flex items-center space-x-1 cursor-pointer select-none">
      <span>LEARN</span>
      <i class="fas fa-chevron-down text-black text-xs"></i>
      <ul></ul>
     </li>
     <li class="flex items-center cursor-pointer select-none">STORY</li>
    </ul>
    <div class="hidden md:flex absolute right-6 top-1/2 -translate-y-1/2 items-center space-x-6 text-black text-sm font-semibold tracking-wide">
     <button aria-label="Search" class="text-black text-lg focus:outline-none">
      <i class="fas fa-search"></i>
     </button>
     <button aria-label="Cart" class="relative text-black text-lg focus:outline-none">
      <i class="fas fa-shopping-bag"></i>
      <span class="absolute -top-1 -right-2 bg-black text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">0</span>
     </button>
    </div>
   </div>
   <div id="mobile-menu" class="md:hidden hidden bg-white/95 backdrop-blur-sm shadow-md absolute top-full left-0 w-full z-40">
    <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" /> </svg>
      </div>
    <ul class="flex flex-col space-y-4 p-6 text-black text-base font-semibold tracking-wide">
     <li class="flex items-center justify-between cursor-pointer select-none">
      <span>SHOP</span>
      <i class="fas fa-chevron-down text-black text-sm"></i>
     </li>
     <li class="cursor-pointer select-none">STORY</li>
     <li class="flex items-center justify-between cursor-pointer select-none">
      <span>LEARN</span>
      <i class="fas fa-chevron-down text-black text-sm"></i>
     </li>
     <li class="cursor-pointer select-none">STORY</li>
     <li class="flex space-x-6 pt-2">
      <button aria-label="Search" class="text-black text-lg focus:outline-none">
       <i class="fas fa-search"></i>
      </button>
      <button aria-label="Cart" class="relative text-black text-lg focus:outline-none">
       <i class="fas fa-shopping-bag"></i>
       <span class="absolute -top-1 -right-2 bg-black text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">0</span>
      </button>
     </li>
    </ul>
   </div>
  </nav>
  <script>
   const menuButton = document.getElementById('menu-button');
   const mobileMenu = document.getElementById('mobile-menu');
   menuButton.addEventListener('click', () => {
     const isHidden = mobileMenu.classList.contains('hidden');
     if (isHidden) {
       mobileMenu.classList.remove('hidden');
       menuButton.innerHTML = '<i class="fas fa-times"></i>';
     } else {
       mobileMenu.classList.add('hidden');
       menuButton.innerHTML = '<i class="fas fa-bars"></i>';
     }
   });
  </script>