<div class="min-h-screen bg-white p-6">
    {{-- Header --}}
    <div
        class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-50 to-indigo-100 p-8 mb-8 shadow-lg transition-all duration-500 hover:shadow-xl">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 z-10 relative">
            <div class="flex items-center gap-6">
                <div
                    class="p-4 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-lg animate-[pulse_3s_ease-in-out_infinite]">
                    @if ($activeTab === 'tickets')
                        <i class="ri-ticket-2-line text-3xl"></i>
                    @else
                        <i class="ri-shopping-bag-3-line text-3xl"></i>
                    @endif

                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Tickets & Merchandise</h1>
                    <p class="text-indigo-600/80 text-lg mt-2">Manage your event offerings</p>
                </div>
            </div>
            <button id="openItemModal"
                class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex items-center gap-2">
                <i class="ri-add-line"></i> Add New
            </button>
        </div>
        <div class="absolute -right-10 -top-10 text-purple-100/40 text-9xl z-0">
            <i class="ri-shopping-bag-3-fill"></i>
        </div>
    </div>


    {{-- Tabs --}}
    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8">
            <a href="{{ request()->fullUrlWithQuery(['tab' => 'tickets']) }}"
                class="tab-button {{ $activeTab === 'tickets' ? 'border-indigo-500 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 text-sm font-medium">
                <i class="ri-ticket-2-line mr-2"></i>Tickets
                <span class="ml-1 bg-purple-100 text-purple-600 text-xs font-medium px-2 py-0.5 rounded-full">
                    {{ $ticketCount }}
                </span>
            </a>

            <a href="{{ request()->fullUrlWithQuery(['tab' => 'merchandise']) }}"
                class="tab-button {{ $activeTab === 'merchandise' ? 'border-indigo-500 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap pb-4 px-1 text-sm font-medium">
                <i class="ri-shopping-bag-3-line mr-2"></i>Merchandise
                <span class="ml-1 bg-purple-100 text-purple-600 text-xs font-medium px-2 py-0.5 rounded-full">
                    {{ $merchandiseCount }}
                </span>
            </a>

        </nav>
    </div>

    {{-- Content --}}
    <div id="tickets-tab" class="tab-content {{ $activeTab === 'tickets' ? '' : 'hidden' }}">
        @include('eventDashboard.partials.products-grid', [
            'items' => $tickets,
            'type' => 'ticket',
        ])
    </div>

    <div id="merchandise-tab" class="tab-content {{ $activeTab === 'merchandise' ? '' : 'hidden' }}">
        @include('eventDashboard.partials.products-grid', [
            'items' => $merchandise,
            'type' => 'merchandise',
        ])
    </div>

    @include('components.modal.create-product')
</div>
