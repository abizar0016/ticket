<div class="min-h-screen bg-gray-50 dark:bg-gray-900 p-3 sm:p-4 md:p-6 transition-colors duration-500">

    <!-- Animated Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Product Sold --}}
        <div
            class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 group animate-[float_6s_ease-in-out_infinite]">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium opacity-90">Products Sold</p>
                    <h3 class="md:text-3xl text-xl font-bold mt-2 animate-count">
                        {{ $summary['totalTicketsSold'] }}
                    </h3>
                </div>
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm group-hover:rotate-12 transition-transform">
                    <i class="ri-shopping-basket-line text-2xl"></i>
                </div>
            </div>
        </div>

        {{-- Attendees --}}
        <div
            class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 group animate-[float_6s_ease-in-out_infinite] delay-100">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium opacity-90">Attendees</p>
                    <h3 class="md:text-3xl text-xl font-bold mt-2 animate-count">
                        {{ $summary['attendeeCount'] }}
                    </h3>
                </div>
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm group-hover:rotate-12 transition-transform">
                    <i class="ri-group-line text-2xl"></i>
                </div>
            </div>
        </div>

        {{-- Revenue --}}
        <div
            class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 group animate-[float_6s_ease-in-out_infinite] delay-200">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium opacity-90">Revenue</p>
                    <h3 class="md:text-3xl text-xl font-bold mt-2">
                        <span class="animate-count">Rp.
                            {{ $summary['totalRevenue'] >= 1000000
                                ? number_format($summary['totalRevenue'] / 1000000, 1, ',', '.') . ' jt'
                                : number_format($summary['totalRevenue'], 0, ',', '.') }}
                        </span>
                    </h3>
                </div>
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm group-hover:rotate-12 transition-transform">
                    <i class="ri-money-dollar-circle-line text-2xl"></i>
                </div>
            </div>
        </div>

        {{-- Completed Orders --}}
        <div
            class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 group animate-[float_6s_ease-in-out_infinite] delay-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium opacity-90">Completed Orders</p>
                    <h3 class="md:text-3xl text-xl font-bold mt-2 animate-count">
                        {{ $summary['completedOrders'] }}
                    </h3>
                </div>
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm group-hover:rotate-12 transition-transform">
                    <i class="ri-checkbox-circle-line text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Animated Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        {{-- Revenue Chart --}}
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-1 animate-[slideUp_0.8s_ease-out_forwards]">
            <div class="border-b border-gray-100 dark:border-gray-700 px-6 py-4 flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                    <i class="ri-line-chart-line text-rose-500 animate-[pulse_2s_ease-in-out_infinite]"></i>
                    Revenue Overview
                </h3>
            </div>
            <div class="p-6">
                <div class="h-80">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Sales Chart --}}
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden transition-all duration-500 hover:shadow-2xl hover:-translate-y-1 animate-[slideUp_0.8s_ease-out_forwards] delay-100">
            <div class="border-b border-gray-100 dark:border-gray-700 px-6 py-4 flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                    <i class="ri-bar-chart-2-line text-blue-500 animate-[pulse_2s_ease-in-out_infinite]"></i>
                    Sales Performance
                </h3>
            </div>
            <div class="p-6">
                <div class="h-80">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Dependencies --}}
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    window.chartLabels = @json($chartLabels);
    window.revenueData = @json($revenueData);
    window.salesData = @json($salesData);

    // Chart.js init
    document.addEventListener("alpine:init", () => {
        const textColor = getComputedStyle(document.documentElement).getPropertyValue('--tw-prose-body');
        const borderColor = '#e5e7eb';

        const revenueCtx = document.getElementById("revenueChart");
        new Chart(revenueCtx, {
            type: "line",
            data: {
                labels: window.chartLabels,
                datasets: [{
                    label: "Revenue",
                    data: window.revenueData,
                    borderColor: "#f43f5e",
                    backgroundColor: "rgba(244,63,94,0.2)",
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: "#9ca3af"
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: "#9ca3af"
                        },
                        grid: {
                            color: "rgba(255,255,255,0.05)"
                        }
                    },
                    y: {
                        ticks: {
                            color: "#9ca3af"
                        },
                        grid: {
                            color: "rgba(255,255,255,0.05)"
                        }
                    }
                }
            }
        });

        const salesCtx = document.getElementById("salesChart");
        new Chart(salesCtx, {
            type: "bar",
            data: {
                labels: window.chartLabels,
                datasets: [{
                    label: "Sales",
                    data: window.salesData,
                    backgroundColor: "#3b82f6",
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        labels: {
                            color: "#9ca3af"
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: "#9ca3af"
                        },
                        grid: {
                            color: "rgba(255,255,255,0.05)"
                        }
                    },
                    y: {
                        ticks: {
                            color: "#9ca3af"
                        },
                        grid: {
                            color: "rgba(255,255,255,0.05)"
                        }
                    }
                }
            }
        });
    });
</script>
