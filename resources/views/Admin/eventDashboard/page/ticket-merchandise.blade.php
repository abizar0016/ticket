<div class="min-h-screen bg-gray-50 p-4 sm:p-6">
    <!-- Dynamic Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6 md:gap-8">
        <!-- Header Card -->
        <div class="lg:col-span-12 relative overflow-hidden rounded-xl sm:rounded-2xl bg-gradient-to-r from-indigo-50 to-indigo-100 p-4 sm:p-6 md:p-8 mb-4 sm:mb-6 md:mb-8 shadow-lg hover:shadow-xl transition-all duration-300 group">
            <!-- Header content -->
            <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:gap-6">
                <div class="flex items-center gap-3 sm:gap-4 md:gap-6">
                    <div class="p-2 sm:p-3 md:p-4 rounded-lg sm:rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-md sm:shadow-lg">
                        @if ($activeTab === 'tickets')
                            <i class="ri-ticket-2-line text-xl sm:text-2xl md:text-3xl"></i>
                        @else
                            <i class="ri-shopping-bag-3-line text-xl sm:text-2xl md:text-3xl"></i>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 tracking-tight">Tickets & Merchandise</h1>
                        <p class="text-indigo-600/80 text-sm sm:text-base md:text-lg mt-1 sm:mt-2">Manage your event offerings</p>
                    </div>
                </div>

                <!-- Add New Button -->
                <button id="openItemModal"
                    class="relative z-10 px-3 sm:px-4 md:px-6 py-1.5 sm:py-2 md:py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-lg sm:rounded-xl shadow-md hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5 sm:hover:-translate-y-1 flex items-center justify-center gap-1 sm:gap-2 text-sm sm:text-base">
                    <i class="ri-add-line"></i> Add New
                </button>
            </div>

            <div class="absolute -right-6 sm:-right-8 md:-right-10 -top-6 sm:-top-8 md:-top-10 text-purple-100/40 text-6xl sm:text-7xl md:text-8xl lg:text-9xl z-0 pointer-events-none">
                <i class="ri-shopping-bag-3-fill"></i>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-12">
            <!-- Tabs -->
            <div class="border-b border-gray-200 mb-4 sm:mb-6 md:mb-8">
                <nav class="-mb-px flex space-x-4 sm:space-x-6 md:space-x-8 overflow-x-auto">
                    <a href="{{ request()->fullUrlWithQuery(['tab' => 'tickets']) }}"
                        class="tab-button {{ $activeTab === 'tickets' ? 'border-indigo-500 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-3 sm:pb-4 px-1 text-xs sm:text-sm font-medium">
                        <i class="ri-ticket-2-line mr-1 sm:mr-2"></i>Tickets
                        <span class="ml-1 bg-purple-100 text-purple-600 text-xs font-medium px-1.5 sm:px-2 py-0.5 rounded-full">
                            {{ $ticketCount }}
                        </span>
                    </a>

                    <a href="{{ request()->fullUrlWithQuery(['tab' => 'merchandise']) }}"
                        class="tab-button {{ $activeTab === 'merchandise' ? 'border-indigo-500 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-3 sm:pb-4 px-1 text-xs sm:text-sm font-medium">
                        <i class="ri-shopping-bag-3-line mr-1 sm:mr-2"></i>Merchandise
                        <span class="ml-1 bg-purple-100 text-purple-600 text-xs font-medium px-1.5 sm:px-2 py-0.5 rounded-full">
                            {{ $merchandiseCount }}
                        </span>
                    </a>
                </nav>
            </div>

            <!-- Content -->
            <div id="tickets-tab" class="tab-content {{ $activeTab === 'tickets' ? '' : 'hidden' }}">
                @include('Admin.eventDashboard.partials.products-grid', [
                    'items' => $tickets,
                    'type' => 'ticket',
                ])
            </div>

            <div id="merchandise-tab" class="tab-content {{ $activeTab === 'merchandise' ? '' : 'hidden' }}">
                @include('Admin.eventDashboard.partials.products-grid', [
                    'items' => $merchandise,
                    'type' => 'merchandise',
                ])
            </div>
        </div>
    </div>
</div>

@include('components.modal.create-product')
