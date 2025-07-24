<div class="min-h-screen bg-white p-6">
    {{-- Animated Header --}}
    <div
        class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-50 to-indigo-100 p-8 mb-8 shadow-lg transition-all duration-500 hover:shadow-xl">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 z-10 relative">
            <div class="flex items-center gap-6">
                <div
                    class="p-4 rounded-xl bg-gradient-to-tr from-indigo-500 to-indigo-600 text-white shadow-lg animate-[pulse_3s_ease-in-out_infinite]">
                    <i class="ri-coupon-line text-3xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Promo Codes</h1>
                    <p class="text-indigo-600/80 text-lg mt-2">Manage discounts and special offers</p>
                </div>
            </div>
            <button id="openAddPromoModal"
                class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 flex items-center gap-2">
                <i class="ri-add-line"></i>
                Create Promo
            </button>
        </div>
        <div class="absolute -right-10 -top-10 text-purple-100/40 text-9xl z-0">
            <i class="ri-coupon-3-fill"></i>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- Total Promos --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Promo Codes</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $totalPromos }}</h3>
                </div>
                <div class="p-3 rounded-lg bg-purple-100 text-purple-600">
                    <i class="ri-coupon-3-line text-2xl"></i>
                </div>
            </div>
        </div>

        {{-- Active Promos --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Active Promos</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $activePromos }}</h3>
                </div>
                <div class="p-3 rounded-lg bg-green-100 text-green-600">
                    <i class="ri-checkbox-circle-line text-2xl"></i>
                </div>
            </div>
        </div>

        {{-- Total Discounts --}}
        <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Discounts Given</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">Rp
                        {{ number_format($totalDiscounts, 0, ',', '.') }}</h3>
                </div>
                <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
                    <i class="ri-money-dollar-circle-line text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-2xl border border-gray-200 p-4 mb-6 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <form method="GET" class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                {{-- Pastikan content tetap ada --}}
                <input type="hidden" name="content" value="{{ request('content') }}">

                {{-- Search --}}
                <div class="relative flex-1">
                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                        placeholder="Search promos..."
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:-indigo-500 focus:outline-indigo-500 w-full">
                    <i class="ri-search-line absolute left-3 top-2.5 text-gray-400"></i>
                </div>

                {{-- Status Filter --}}
                <div class="flex items-center gap-4">
                    <select name="status" id="statusFilter"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="used" {{ request('status') === 'used' ? 'selected' : '' }}>Used</option>
                        <option value="unlimited" {{ request('status') === 'unlimited' ? 'selected' : '' }}>Unlimited
                        </option>
                        <option value="limited" {{ request('status') === 'limited' ? 'selected' : '' }}>Limited</option>
                    </select>
                    <button type="submit"
                        class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-lg hover:from-indigo-600 hover:to-indigo-700 transition-colors">
                        Apply
                    </button>
                </div>
            </form>

        </div>
    </div>

    {{-- Promo Codes Table --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm mb-6">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">All Promo Codes</h3>
            <div class="text-sm text-gray-500">
                Showing {{ $promos->firstItem() }} to {{ $promos->lastItem() }} of {{ $promos->total() }} results
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Discount</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Product</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uses
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status</th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($promos as $promo)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600">
                                        <i class="ri-coupon-2-line"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $promo->code }}</div>
                                        <div class="text-sm text-gray-500">Created:
                                            {{ $promo->created_at->format('M d, Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    @if ($promo->type === 'percentage')
                                        {{ $promo->discount }}% off
                                    @else
                                        ${{ number_format($promo->discount, 2) }} off
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $promo->product->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ $promo->order_items_count }}@if ($promo->max_uses > 0)
                                        /{{ $promo->max_uses }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($promo->max_uses == 0 || $promo->order_items_count < $promo->max_uses)
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                @else
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Used</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="#"
                                        class="p-2 text-indigo-600 hover:text-indigo-800 rounded hover:bg-indigo-50 transition"
                                        title="Edit">
                                        <i class="ri-edit-line text-xl"></i>
                                    </a>
                                    <form action="" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="p-2 text-red-600 hover:text-red-800 rounded hover:bg-red-50 transition"
                                            title="Delete">
                                            <i class="ri-delete-bin-line text-xl"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{$promos->appends(['content' => 'promo-codes'])->links('pagination::default')}}
    </div>
</div>

{{-- Add Promo Modal --}}
@include('components.modal.create-promo')
