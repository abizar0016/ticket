<?php

namespace App\Http\Controllers\SuperAdmin\Dashboard;

use App\Http\Controllers\SuperAdmin\SuperAdminBaseController;
use App\Models\Activity;
use App\Models\Event;
use App\Models\Order;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SuperAdminDashboardController extends SuperAdminBaseController
{
    public function index()
    {
        $viewData = $this->getViewData('dashboard');

        $totalUsers = User::count();
        $totalOrganizations = Organization::count();
        $totalEvents = Event::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'paid')->sum('total_price');

        $userGrowth = User::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $publishedEvents = Event::where('is_published', true)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $bestSellerEvents = Event::withCount([
            'orders' => function ($query) {
                $query->where('status', 'paid');
            },
        ])
            ->orderByDesc('orders_count')
            ->orderByDesc('created_at')
            ->take(5)
            ->pluck('orders_count', 'title')
            ->toArray();

        $reportEvents = Event::select('events.title', DB::raw('COUNT(reports.id) as total'))
            ->leftJoin('reports', 'events.id', '=', 'reports.event_id')
            ->groupBy('events.id', 'events.title')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $mostIncome = Event::select(
            'events.id',
            'events.title',
            DB::raw('COALESCE(SUM(orders.total_price), 0) as revenue')
        )
            ->leftJoin('orders', function ($join) {
                $join->on('events.id', '=', 'orders.event_id')
                    ->where('orders.status', '=', 'paid');
            })
            ->groupBy('events.id', 'events.title')
            ->orderByDesc('revenue')
            ->take(5)
            ->get()
            ->mapWithKeys(function ($event) {
                return [$event->title => (int) $event->revenue];
            })
            ->toArray();

        $upcomingEvents = Event::where('start_date', '>', now())
            ->orderBy('start_date', 'asc')
            ->take(5)
            ->get();

        // ✅ Refactored recent activities
        $recentActivities = Activity::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($activity) {
                $relatedName = null;
                switch ($activity->model_type) {
                    case 'User':
                        $relatedName = User::find($activity->model_id)?->name;
                        break;
                    case 'Organization':
                        $relatedName = Organization::find($activity->model_id)?->name;
                        break;
                    case 'Event':
                        $relatedName = Event::find($activity->model_id)?->title;
                        break;
                    case 'Attendee':
                        $relatedName = 'Attendee #'.$activity->model_id;
                        break;
                    case 'Product':
                        $relatedName = 'Product #'.$activity->model_id;
                        break;
                    case 'Checkin':
                        $relatedName = 'Checkin #'.$activity->model_id;
                        break;
                    case 'Order':
                        $relatedName = 'Order #'.$activity->model_id;
                        break;
                    case 'Promo':
                        $relatedName = 'Promo #'.$activity->model_id;
                        break;
                    case 'Category':
                        $relatedName = 'Category #'.$activity->model_id;
                        break;
                }

                $userName = $activity->user->name ?? 'Someone';
                $action = strtolower($activity->action);
                $model = strtolower($activity->model_type);

                // Pesan Activity
                $message = match (true) {
                    $action === 'register' => "$userName mendaftar akun",

                    $action === 'create' && $model === 'event' => "$userName membuat event $relatedName",
                    $action === 'update' && $model === 'event' => "$userName memperbarui event $relatedName",
                    $action === 'delete' && $model === 'event' => "$userName menghapus event $relatedName",
                    $action === 'publish' && $model === 'event' => "$userName mempublikasikan event $relatedName",

                    $action === 'update' && $model === 'order' => "$userName memperbarui $relatedName",
                    $action === 'delete' && $model === 'order' => "$userName membatalkan $relatedName",
                    $action === 'mark as paid' && $model === 'order' => "$userName menandai $relatedName sebagai lunas",

                    $action === 'checkin' => "$userName melakukan check-in",
                    $action === 'checkout' => "$userName melakukan checkout",
                    $action === 'checkin attendee' => "$userName melakukan check-in untuk attendee $relatedName",

                    $action === 'create' && $model === 'organization' => "$userName membuat organisasi $relatedName",
                    $action === 'update' && $model === 'organization' => "$userName memperbarui organisasi $relatedName",
                    $action === 'delete' && $model === 'organization' => "$userName menghapus organisasi $relatedName",

                    $action === 'create' && $model === 'product' => "$userName menambahkan produk $relatedName",
                    $action === 'update' && $model === 'product' => "$userName memperbarui produk $relatedName",
                    $action === 'delete' && $model === 'product' => "$userName menghapus produk $relatedName",

                    $action === 'create' && $model === 'promo' => "$userName membuat promo $relatedName",
                    $action === 'update' && $model === 'promo' => "$userName memperbarui promo $relatedName",
                    $action === 'delete' && $model === 'promo' => "$userName menghapus promo $relatedName",
                    $action === 'activate' && $model === 'promo' => "$userName mengaktifkan promo $relatedName",
                    $action === 'deactivate' && $model === 'promo' => "$userName menonaktifkan promo $relatedName",

                    $action === 'create' && $model === 'category' => "$userName menambahkan kategori $relatedName",
                    $action === 'update' && $model === 'category' => "$userName memperbarui kategori $relatedName",
                    $action === 'delete' && $model === 'category' => "$userName menghapus kategori $relatedName",

                    $action === 'create' && $model === 'checkin' => "$userName membuat data check-in baru",
                    $action === 'delete' && $model === 'checkin' => "$userName menghapus data check-in",

                    default => "$userName melakukan aksi $activity->action pada $activity->model_type",
                };

                // Ikon
                $icon = match (true) {
                    $action === 'register' => 'ri-user-add-line',

                    $action === 'create' && $model === 'event' => 'ri-calendar-event-line',
                    $action === 'update' && $model === 'event' => 'ri-edit-line',
                    $action === 'delete' && $model === 'event' => 'ri-delete-bin-line',
                    $action === 'publish' && $model === 'event' => 'ri-rocket-line',

                    $action === 'update' && $model === 'order' => 'ri-file-edit-line',
                    $action === 'delete' && $model === 'order' => 'ri-delete-bin-line',
                    $action === 'mark as paid' && $model === 'order' => 'ri-money-dollar-circle-line',

                    $action === 'checkin' => 'ri-check-line',
                    $action === 'checkout' => 'ri-shopping-cart-line',
                    $action === 'checkin attendee' => 'ri-calendar-check-line',

                    $action === 'create' && $model === 'organization' => 'ri-building-line',
                    $action === 'update' && $model === 'organization' => 'ri-building-2-line',
                    $action === 'delete' && $model === 'organization' => 'ri-delete-bin-line',

                    $action === 'create' && $model === 'product' => 'ri-shopping-bag-line',
                    $action === 'update' && $model === 'product' => 'ri-edit-box-line',
                    $action === 'delete' && $model === 'product' => 'ri-delete-bin-line',

                    $action === 'create' && $model === 'promo' => 'ri-ticket-2-line',
                    $action === 'update' && $model === 'promo' => 'ri-edit-line',
                    $action === 'delete' && $model === 'promo' => 'ri-delete-bin-line',
                    $action === 'activate' && $model === 'promo' => 'ri-check-double-line',
                    $action === 'deactivate' && $model === 'promo' => 'ri-close-circle-line',

                    $action === 'create' && $model === 'category' => 'ri-folder-add-line',
                    $action === 'update' && $model === 'category' => 'ri-folder-chart-line',
                    $action === 'delete' && $model === 'category' => 'ri-folder-reduce-line',

                    $action === 'create' && $model === 'checkin' => 'ri-login-circle-line',
                    $action === 'delete' && $model === 'checkin' => 'ri-logout-circle-line',

                    default => 'ri-information-line',
                };

                // Warna latar belakang
                $bgColor = match (true) {
                    $action === 'register' => 'bg-indigo-100 dark:bg-indigo-900/60',

                    $action === 'create' && $model === 'event' => 'bg-sky-100 dark:bg-sky-900/60',
                    $action === 'update' && $model === 'event' => 'bg-amber-100 dark:bg-amber-900/60',
                    $action === 'delete' && $model === 'event' => 'bg-rose-100 dark:bg-rose-900/60',
                    $action === 'publish' && $model === 'event' => 'bg-emerald-100 dark:bg-emerald-900/60',

                    $action === 'update' && $model === 'order' => 'bg-orange-100 dark:bg-orange-900/60',
                    $action === 'delete' && $model === 'order' => 'bg-red-100 dark:bg-red-900/60',
                    $action === 'mark as paid' && $model === 'order' => 'bg-green-100 dark:bg-green-900/60',

                    $action === 'checkin' => 'bg-teal-100 dark:bg-teal-900/60',
                    $action === 'checkout' => 'bg-cyan-100 dark:bg-cyan-900/60',
                    $action === 'checkin attendee' => 'bg-yellow-100 dark:bg-yellow-900/60',

                    $action === 'create' && $model === 'organization' => 'bg-purple-100 dark:bg-purple-900/60',
                    $action === 'update' && $model === 'organization' => 'bg-fuchsia-100 dark:bg-fuchsia-900/60',
                    $action === 'delete' && $model === 'organization' => 'bg-rose-100 dark:bg-rose-900/60',

                    $action === 'create' && $model === 'product' => 'bg-indigo-100 dark:bg-indigo-900/60',
                    $action === 'update' && $model === 'product' => 'bg-blue-100 dark:bg-blue-900/60',
                    $action === 'delete' && $model === 'product' => 'bg-red-100 dark:bg-red-900/60',

                    $action === 'create' && $model === 'promo' => 'bg-pink-100 dark:bg-pink-900/60',
                    $action === 'update' && $model === 'promo' => 'bg-pink-200 dark:bg-pink-800/60',
                    $action === 'delete' && $model === 'promo' => 'bg-rose-100 dark:bg-rose-900/60',
                    $action === 'activate' && $model === 'promo' => 'bg-green-100 dark:bg-green-900/60',
                    $action === 'deactivate' && $model === 'promo' => 'bg-gray-100 dark:bg-gray-900/60',

                    $action === 'create' && $model === 'category' => 'bg-cyan-100 dark:bg-cyan-900/60',
                    $action === 'update' && $model === 'category' => 'bg-blue-100 dark:bg-blue-900/60',
                    $action === 'delete' && $model === 'category' => 'bg-red-100 dark:bg-red-900/60',

                    $action === 'create' && $model === 'checkin' => 'bg-teal-100 dark:bg-teal-900/60',
                    $action === 'delete' && $model === 'checkin' => 'bg-rose-100 dark:bg-rose-900/60',

                    default => 'bg-gray-100 dark:bg-gray-800',
                };

                // Warna teks
                $textColor = match (true) {
                    $action === 'register' => 'text-indigo-600 dark:text-indigo-300',

                    $action === 'create' && $model === 'event' => 'text-sky-600 dark:text-sky-300',
                    $action === 'update' && $model === 'event' => 'text-amber-600 dark:text-amber-300',
                    $action === 'delete' && $model === 'event' => 'text-rose-600 dark:text-rose-300',
                    $action === 'publish' && $model === 'event' => 'text-emerald-600 dark:text-emerald-300',

                    $action === 'update' && $model === 'order' => 'text-orange-600 dark:text-orange-300',
                    $action === 'delete' && $model === 'order' => 'text-red-600 dark:text-red-300',
                    $action === 'mark as paid' && $model === 'order' => 'text-green-600 dark:text-green-300',

                    $action === 'checkin' => 'text-teal-600 dark:text-teal-300',
                    $action === 'checkout' => 'text-cyan-600 dark:text-cyan-300',
                    $action === 'checkin attendee' => 'text-yellow-600 dark:text-yellow-300',

                    default => 'text-gray-600 dark:text-gray-400',
                };

                return [
                    'message' => $message,
                    'created_at' => $activity->created_at->diffForHumans(),
                    'icon' => $icon,
                    'bg_color' => $bgColor,
                    'text_color' => $textColor,
                ];
            });

        return view('layouts.superAdmin.index', array_merge($viewData, [
            'totalUsers' => $totalUsers,
            'totalOrganizations' => $totalOrganizations,
            'totalEvents' => $totalEvents,
            'totalOrders' => $totalOrders,
            'totalRevenue' => $this->formatRupiah($totalRevenue),
            'userGrowth' => $userGrowth,
            'publishedEvents' => $publishedEvents,
            'bestSellerEvents' => $bestSellerEvents,
            'reportEvents' => $reportEvents,
            'mostIncome' => $mostIncome,
            'recentActivities' => $recentActivities,
            'upcomingEvents' => $upcomingEvents,
        ]));
    }

    private function formatRupiah($angka)
    {
        if ($angka >= 1000000000) {
            return 'Rp '.number_format($angka / 1000000000, 2).' M';
        } elseif ($angka >= 1000000) {
            return 'Rp '.number_format($angka / 1000000, 2).' jt';
        } else {
            return 'Rp '.number_format($angka, 0, ',', '.');
        }
    }
}
