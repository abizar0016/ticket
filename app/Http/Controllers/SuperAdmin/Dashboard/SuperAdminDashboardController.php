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

        $recentActivities = Activity::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($activity) {
                $relatedName = null;
                if ($activity->model_type === 'User') {
                    $user = User::find($activity->model_id);
                    $relatedName = $user?->name;
                } elseif ($activity->model_type === 'Organization') {
                    $organization = Organization::find($activity->model_id);
                    $relatedName = $organization?->name;
                } elseif ($activity->model_type === 'Event') {
                    $event = Event::find($activity->model_id);
                    $relatedName = $event?->title;
                } elseif ($activity->model_type === 'Order') {
                    $order = Order::find($activity->model_id);
                    $relatedName = 'Order #'.$order?->id;
                }

                $userName = $activity->user->name ?? 'Someone';

                $message = match ($activity->action) {
                    'register' => "$userName register an account",
                    'create event' => "$userName membuat $relatedName",
                    'update event' => "$userName memperbarui $relatedName",
                    'delete event' => "$userName menghapus $relatedName",
                    'publish event' => "$userName mempublikasikan $relatedName",
                    'checkin' => "$userName melakukan check-in",
                    'checkout' => "$userName melakukan checkout",
                    'update order' => "$userName memperbarui $relatedName",
                    'pay order' => "$userName membayar $relatedName",
                    'delete order' => "$userName membatalkan $relatedName",
                    'apply promo' => "$userName menggunakan promo $relatedName",
                    'checkin attendee' => "$userName check-in attendee $relatedName",
                    default => "$userName melakukan aksi $activity->action",
                };

                $icon = match ($activity->action) {
                    'register' => 'ri-user-add-line',
                    'create event' => 'ri-calendar-event-line',
                    'update event' => 'ri-edit-line',
                    'delete event' => 'ri-delete-bin-line',
                    'publish event' => 'ri-rocket-line',
                    'checkin' => 'ri-check-line',
                    'checkout' => 'ri-shopping-cart-line',
                    'update order' => 'ri-file-edit-line',
                    'pay order' => 'ri-money-dollar-circle-line',
                    'delete order' => 'ri-delete-bin-line',
                    'apply promo' => 'ri-ticket-2-line',
                    'checkin attendee' => 'ri-calendar-check-line',
                    default => 'ri-information-line',
                };

                $bgColor = match ($activity->action) {
                    'register' => 'bg-indigo-100 dark:bg-indigo-900/60',
                    'create event' => 'bg-sky-100 dark:bg-sky-900/60',
                    'update event' => 'bg-amber-100 dark:bg-amber-900/60',
                    'delete event' => 'bg-rose-100 dark:bg-rose-900/60',
                    'publish event' => 'bg-emerald-100 dark:bg-emerald-900/60',
                    'checkin' => 'bg-teal-100 dark:bg-teal-900/60',
                    'checkout' => 'bg-cyan-100 dark:bg-cyan-900/60',
                    'update order' => 'bg-orange-100 dark:bg-orange-900/60',
                    'pay order' => 'bg-green-100 dark:bg-green-900/60',
                    'delete order' => 'bg-red-100 dark:bg-red-900/60',
                    'apply promo' => 'bg-purple-100 dark:bg-purple-900/60',
                    'checkin attendee' => 'bg-yellow-100 dark:bg-yellow-900/60',
                    default => 'bg-gray-100 dark:bg-gray-800',
                };

                $textColor = match ($activity->action) {
                    'register' => 'text-indigo-600 dark:text-indigo-300',
                    'create event' => 'text-sky-600 dark:text-sky-300',
                    'update event' => 'text-amber-600 dark:text-amber-300',
                    'delete event' => 'text-rose-600 dark:text-rose-300',
                    'publish event' => 'text-emerald-600 dark:text-emerald-300',
                    'checkin' => 'text-teal-600 dark:text-teal-300',
                    'checkout' => 'text-cyan-600 dark:text-cyan-300',
                    'update order' => 'text-orange-600 dark:text-orange-300',
                    'pay order' => 'text-green-600 dark:text-green-300',
                    'delete order' => 'text-red-600 dark:text-red-300',
                    'apply promo' => 'text-purple-600 dark:text-purple-300',
                    'checkin attendee' => 'text-yellow-600 dark:text-yellow-300',
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
