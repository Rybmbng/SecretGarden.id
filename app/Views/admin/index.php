
    <?= view("adminpartial/header") ?>
    <main class="flex-1 overflow-y-auto bg-gray-50">
      <div class="container mx-auto px-6 py-8">
        <header class="flex items-center justify-between mb-6">
          <div class="flex items-center">
            <h2 id="monthLabel" class="text-2xl font-semibold text-gray-800 mr-4"></h2>
            <div class="flex items-center text-gray-500">
              <button id="prevWeek" class="mr-2"><i class="fas fa-chevron-left"></i></button>
              <div id="weekDays" class="flex space-x-2 text-xs text-center"></div>
              <button id="nextWeek" class="ml-2"><i class="fas fa-chevron-right"></i></button>
            </div>
          </div>
          <div>
            <!-- <img src="<?php //$user['id_user']?>" alt="Profile" class="w-8 h-8 rounded-full"/> -->
          </div>
        </header>

        <section class="flex flex-wrap gap-4 mb-6">
          <button class="quick-action bg-white rounded-md shadow-md p-4 text-center flex-1" data-action="Top Up">
            <i class="fas fa-arrow-up text-blue-500 text-2xl"></i>
            <p class="text-sm text-gray-500">Top Up</p>
          </button>
          <button class="quick-action bg-white rounded-md shadow-md p-4 text-center flex-1" data-action="Subscribe">
            <i class="fas fa-envelope text-blue-500 text-2xl"></i>
            <p class="text-sm text-gray-500">Subscribe</p>
          </button>
          <button class="quick-action bg-white rounded-md shadow-md p-4 text-center flex-1" data-action="Pay Bills">
            <i class="fas fa-file-invoice-dollar text-blue-500 text-2xl"></i>
            <p class="text-sm text-gray-500">Pay Bills</p>
          </button>
          <button class="quick-action bg-yellow-100 rounded-md shadow-md p-4 text-center flex-1" data-action="Statement">
            <i class="fas fa-file-alt text-yellow-500 text-2xl"></i>
            <p class="text-sm text-gray-500">Statement</p>
          </button>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
          <div class="bg-white rounded-md shadow-md p-4">
            <p class="text-sm text-gray-500">Savings <i class="far fa-heart"></i></p>
            <p id="savings" class="text-2xl font-semibold">$7,211.00</p>
          </div>

          <div class="bg-white rounded-md shadow-md p-4">
            <p class="text-sm text-gray-500">Spendings <i class="far fa-heart"></i></p>
            <p id="spendings" class="text-2xl font-semibold">$79 <span class="text-sm">/day</span></p>
          </div>

          <div class="bg-white rounded-md shadow-md p-4">
            <p class="text-sm text-gray-500">Today</p>
            <div class="flex justify-between">
              <div>
                <p class="text-sm">Debit</p>
                <p id="debit" class="text-sm">$122.00</p>
              </div>
              <div>
                <p class="text-sm">Credit</p>
                <p id="credit" class="text-sm">$616.00</p>
              </div>
            </div>
            <p class="text-sm text-gray-500 mt-2">Balance</p>
            <p id="balance" class="text-2xl font-semibold">$9,358.20</p>
          </div>
        </section>

        <section class="grid grid-cols-1 lg:grid-cols-2 gap-4">
          <div class="bg-white rounded-md shadow-md p-4">
            <p class="text-sm text-gray-500 mb-2">Daily Account Summary</p>
            <canvas id="dailySummary"></canvas>
          </div>
          <div class="bg-white rounded-md shadow-md p-4">
            <p class="text-sm text-gray-500 mb-2">Change in Income</p>
            <p class="text-2xl font-semibold mb-2">12.2k</p>
            <canvas id="incomeChart"></canvas>
          </div>
        </section>

      </div>
    </main>

    <?= view("adminpartial/footer") ?>