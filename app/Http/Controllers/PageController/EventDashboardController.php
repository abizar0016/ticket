<?php

namespace App\Http\Controllers\PageController;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use App\Models\Checkin;
use App\Models\Organizer;
use App\Models\Product;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Storage;

class EventDashboardController extends Controller
{
    public function index(Request $request, $id)
    {
        $activeContent = $request->query('content', 'dashboard');
        $tz = $request->cookie('user_timezone', config('app.timezone'));
        $now = Carbon::now($tz);
        $user = auth()->user();

        $allowedContents = [
            'dashboard',
            'settings',
            'attendees',
            'orders',
            'ticket-products',
            'checkins',
            'promo-codes'
        ];

        if (!in_array($activeContent, $allowedContents)) {
            abort(404);
        }

        $event = Event::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        $viewData = [
            'activeContent' => $activeContent,
            'now' => $now,
            'tz' => $tz,
            'user' => $user,
            'event' => $event,
            'organizations' => Organizer::where('user_id', $user->id)->get(),
            'currentFilter' => $request->input('status'),
        ];

        return match ($activeContent) {
            'dashboard' => $this->renderDashboard($viewData, $id),
            'settings' => $this->renderSettings($viewData, $id),
            'attendees' => $this->renderAttendees($viewData, $id),
            'orders' => $this->renderOrders($viewData, $id),
            'checkins' => $this->renderCheckins($viewData, $id),
            'promo-codes' => $this->renderPromoCodes($viewData, $id),
            'ticket-products' => $this->renderTicketProducts($viewData, $id),
            default => view('eventDashboard.index', $viewData),
        };
    }

    private function renderDashboard(array $viewData, int $id)
    {
        $user = $viewData['user'];
        $tz = $viewData['tz'];
        $event = $viewData['event'];

        $labels = [];
        $revenues = [];
        $sales = [];

        // Hitung jumlah attendee yang ordernya paid untuk event ini
        $attendeeCount = Attendee::whereHas('order', function ($q) use ($event) {
            $q->where('status', 'paid')
                ->whereHas('items.product', fn($q2) => $q2->where('event_id', $event->id));
        })->count();

        // Loop 7 hari ke belakang
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now($tz)->subDays($i)->toDateString();
            $label = Carbon::now($tz)->subDays($i)->format('d M');

            $items = OrderItem::whereDate('created_at', $date)
                ->whereHas('order', fn($q) => $q->where('status', 'paid'))
                ->whereHas('product', fn($q) => $q->where('event_id', $event->id))
                ->get();

            $labels[] = $label;
            $revenues[] = $items->sum('total_price');
            $sales[] = $items->sum('quantity');
        }

        // Total produk terjual untuk event ini
        $orderItemsCount = OrderItem::whereHas('order', fn($q) => $q->where('status', 'paid'))
            ->whereHas('product', fn($q) => $q->where('event_id', $event->id))
            ->sum('quantity');

        // Total revenue untuk event ini
        $revenueTotal = OrderItem::whereHas('order', fn($q) => $q->where('status', 'paid'))
            ->whereHas('product', fn($q) => $q->where('event_id', $event->id))
            ->sum('total_price');

        // Jumlah order selesai untuk event ini
        $completed = Order::where('status', 'paid')
            ->whereHas('items.product', fn($q) => $q->where('event_id', $event->id))
            ->count();

        return view('eventDashboard.index', array_merge($viewData, [
            'chartLabels' => $labels,
            'revenueData' => $revenues,
            'salesData' => $sales,
            'orderItemsCount' => $orderItemsCount,
            'revenueTotal' => $revenueTotal,
            'completedOrders' => $completed,
            'attendeeCount' => $attendeeCount,
        ]));
    }

    private function renderSettings(array $viewData, int $id)
    {
        $event = Event::with('organizer', 'location')
            ->where('user_id', $viewData['user']->id)
            ->where('id', $id)
            ->firstOrFail();

        $organizers = Organizer::where('user_id', $viewData['user']->id)->get();

        return view('eventDashboard.index', array_merge($viewData, [
            'event' => $event,
            'organizers' => $organizers
        ]));
    }

    private function renderAttendees(array $viewData, int $id)
    {
        $event = Event::where('user_id', $viewData['user']->id)
            ->where('id', $id)
            ->firstOrFail();

        $search = request('search');

        $attendeesQuery = Attendee::whereHas('order.items.product', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        });

        if ($search) {
            $attendeesQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $attendees = $attendeesQuery->latest()->paginate(10);

        $totalAttendees = $attendeesQuery->count();
        $activeAttendees = $attendeesQuery->where('status', 'active')->count();
        $pendingAttendees = $totalAttendees - $activeAttendees;

        $activePercentage = $totalAttendees > 0 ? round(($activeAttendees / $totalAttendees) * 100) : 0;
        $pendingPercentage = $totalAttendees > 0 ? round(($pendingAttendees / $totalAttendees) * 100) : 0;

        return view('eventDashboard.index', array_merge($viewData, [
            'event' => $event,
            'attendees' => $attendees,
            'totalAttendees' => $totalAttendees,
            'activeAttendees' => $activeAttendees,
            'pendingAttendees' => $pendingAttendees,
            'activePercentage' => $activePercentage,
            'pendingPercentage' => $pendingPercentage,
        ]));
    }

    protected function renderOrders(array $viewData, int $id)
    {
        $user = $viewData['user'];

        // Get event
        $event = Event::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        $search = request('search');

        // Build query dasar
        $ordersQuery = Order::whereHas('items.product', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        });

        // Jika ada search, filter berdasarkan name atau email
        if ($search) {
            $ordersQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Ambil hasil dengan pagination
        $orders = $ordersQuery->orderByDesc('created_at')->paginate(10);

        // Hitung total dari query hasil filter (bukan semua)
        $totalOrders = $orders->total();

        // Statistik paid dan pending tetap dihitung dari semua data event
        $paidOrdersCount = Order::whereHas('items.product', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })->where('status', 'paid')->count();

        $pendingOrdersCount = Order::whereHas('items.product', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })->where('status', 'pending')->count();

        $paidPercentage = $totalOrders > 0 ? round(($paidOrdersCount / $totalOrders) * 100) : 0;
        $pendingPercentage = $totalOrders > 0 ? round(($pendingOrdersCount / $totalOrders) * 100) : 0;

        // Total revenue dari semua order paid
        $totalRevenue = Order::whereHas('items.product', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })->where('status', 'paid')->sum('total_price');

        // Dummy growth sementara
        $growthPercentage = 0;

        return view('eventDashboard.index', array_merge($viewData, [
            'orders' => $orders,
            'event' => $event,
            'paidOrdersCount' => $paidOrdersCount,
            'pendingOrdersCount' => $pendingOrdersCount,
            'paidPercentage' => $paidPercentage,
            'pendingPercentage' => $pendingPercentage,
            'totalRevenue' => $totalRevenue,
            'growthPercentage' => $growthPercentage,
            'search' => $search,
        ]));
    }

    protected function renderTicketProducts(array $viewData, int $id)
    {
        $event = $viewData['event'];
        $now = $viewData['now'];
        $search = request('search');
        $statusFilter = request('status');
        $activeTab = request('tab', 'tickets');

        // Base query
        $baseQuery = Product::where('event_id', $event->id)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            });

        // Tickets and Products query
        $ticketsQuery = (clone $baseQuery)->where('type', 'ticket');
        $merchandiseQuery = (clone $baseQuery)->where('type', '!=', 'ticket');

        $withSums = [
            'orderItems as total_sold' => function ($query) {
                $query->whereHas('order', fn($q) => $q->where('status', 'paid'));
            }
        ];

        $tickets = $ticketsQuery->withSum($withSums, 'quantity')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'tickets_page')
            ->appends(['tab' => 'tickets']);

        $merchandise = $merchandiseQuery->withSum($withSums, 'quantity')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'merchandise_page')
            ->appends(['tab' => 'merchandise']);


        // Count total
        $ticketCount = $tickets->total();
        $merchandiseCount = $merchandise->total();

        return view('eventDashboard.index', array_merge($viewData, [
            'tickets' => $tickets,
            'merchandise' => $merchandise,
            'ticketCount' => $ticketCount,
            'merchandiseCount' => $merchandiseCount,
            'activeTab' => $activeTab,
            'search' => $search,
            'statusFilter' => $statusFilter,
            'statusOptions' => [
                'all' => 'All Items',
                'active' => 'Currently Available',
                'upcoming' => 'Upcoming',
                'ended' => 'Ended'
            ]
        ]));
    }

    protected function renderCheckins(array $viewData, int $id)
    {
        $user = $viewData['user'];
        $tz = $viewData['tz'];

        $search = request('search');
        $status = request('status');

        // Get user's event by ID
        $event = Event::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        // Get attendees with their check-in status
        $attendees = Attendee::whereHas('order.items.product', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('ticket_code', 'like', "%$search%");
                });
            })
            ->when($status === 'checked', function ($query) {
                $query->whereHas('checkins');
            })
            ->when($status === 'pending', function ($query) {
                $query->whereDoesntHave('checkins');
            })
            ->with(['order', 'checkins'])
            ->select('attendees.*')
            ->selectRaw('(SELECT MAX(created_at) FROM checkins WHERE checkins.attendee_id = attendees.id) as last_checkin_at')
            ->orderByDesc('last_checkin_at')
            ->paginate(15);

        // Calculate statistics
        $totalAttendees = Attendee::whereHas('order.items.product', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })->count();

        $checkedInCount = Checkin::whereHas('attendee.order.items.product', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })
            ->distinct('attendee_id')
            ->count('attendee_id');

        $remainingCount = $totalAttendees - $checkedInCount;

        $checkedInPercentage = $totalAttendees > 0 ? round(($checkedInCount / $totalAttendees) * 100) : 0;
        $remainingPercentage = 100 - $checkedInPercentage;

        // Get recent check-ins (last 5)
        $recentCheckIns = Checkin::with(['attendee'])
            ->whereHas('attendee.order.items.product', function ($query) use ($event) {
                $query->where('event_id', $event->id);
            })
            ->orderByDesc('created_at')
            ->take(5)
            ->get()
            ->map(function ($checkin) use ($tz) {
                return (object) [
                    'name' => $checkin->attendee->name,
                    'checked_in_at' => $checkin->created_at->setTimezone($tz)
                ];
            });

        return view('eventDashboard.index', array_merge($viewData, [
            'event' => $event,
            'attendees' => $attendees,
            'totalAttendees' => $totalAttendees,
            'checkedInCount' => $checkedInCount,
            'remainingCount' => $remainingCount,
            'checkedInPercentage' => $checkedInPercentage,
            'remainingPercentage' => $remainingPercentage,
            'recentCheckIns' => $recentCheckIns,
        ]));
    }

    protected function renderPromoCodes(array $viewData, int $id)
    {
        $user = $viewData['user'];
        $search = request('search');
        $statusFilter = request('status');

        // Get the event
        $event = Event::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        // Get all products for this event for the dropdown
        $products = Product::where('event_id', $event->id)
            ->orderBy('title')
            ->get();

        // Base query for promos
        $promosQuery = PromoCode::with(['product'])
            ->whereHas('product', function ($query) use ($event) {
                $query->where('event_id', $event->id);
            });

        // Apply search filter if provided
        if ($search) {
            $promosQuery->where(function ($query) use ($search) {
                $query->where('code', 'like', "%{$search}%")
                    ->orWhereHas('product', function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%");
                    });
            });
        }

        // Apply status filter if provided
        if ($statusFilter) {
            $promosQuery = $this->applyPromoStatusFilter($promosQuery, $statusFilter);
        }

        // Paginate results
        $promos = $promosQuery->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculate statistics
        $totalPromos = PromoCode::whereHas('product', fn($q) => $q->where('event_id', $event->id))->count();

        $activePromos = PromoCode::whereHas('product', fn($q) => $q->where('event_id', $event->id))
            ->where(function ($query) {
                $query->where('max_uses', 0)
                    ->orWhereRaw('(SELECT COUNT(*) FROM order_items WHERE order_items.promo_code_id = promo_codes.id) < max_uses');
            })
            ->count();

        $totalDiscounts = OrderItem::whereHas('order', fn($q) => $q->where('status', 'paid'))
            ->whereHas('product', fn($q) => $q->where('event_id', $event->id))
            ->whereNotNull('promo_code_id')
            ->sum(DB::raw('price_before_discount - total_price'));

        return view('eventDashboard.index', array_merge($viewData, [
            'event' => $event,
            'promos' => $promos,
            'products' => $products,
            'totalPromos' => $totalPromos,
            'activePromos' => $activePromos,
            'totalDiscounts' => $totalDiscounts,
            'search' => $search,
            'statusFilter' => $statusFilter,
        ]));
    }

    protected function applyPromoStatusFilter($query, string $status)
    {
        return match ($status) {
            'active' => $query->where(function ($q) {
                    $q->where('max_uses', 0)
                    ->orWhereRaw('(SELECT COUNT(*) FROM order_items WHERE order_items.promo_code_id = promo_codes.id) < max_uses');
                }),
            'used' => $query->where(function ($q) {
                    $q->where('max_uses', '>', 0)
                    ->whereRaw('(SELECT COUNT(*) FROM order_items WHERE order_items.promo_code_id = promo_codes.id) >= max_uses');
                }),
            'unlimited' => $query->where('max_uses', 0),
            'limited' => $query->where('max_uses', '>', 0),
            default => $query
        };
    }

    protected function applyStatusFilter($query, string $status, Carbon $now)
    {
        return match ($status) {
            'draft' => $query->where('status', 'draft'),
            'upcoming' => $query->where('status', 'published')->where('start_date', '>', $now),
            'ended' => $query->where('status', 'published')->whereNotNull('end_date')->where('end_date', '<', $now),
            'ongoing' => $query->where('status', 'published')
                ->where('start_date', '<=', $now)
                ->where(fn($q) => $q->whereNull('end_date')->orWhere('end_date', '>=', $now)),
            default => $query
        };
    }
}