<?php

namespace App\Http\Controllers\SuperAdmin\CustomersReports;

use App\Http\Controllers\SuperAdmin\SuperAdminBaseController;
use App\Models\Report;
use Illuminate\Http\Request;

class SuperAdminCustomersReportsController extends SuperAdminBaseController
{
    public function index(Request $request)
    {
        $viewData = $this->getViewData('customers-reports');

        $search = $request->search;
        $status = $request->status;

        // Ambil semua laporan, tanpa event_id
        $reports = Report::with(['user', 'event'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('reason', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"))
                        ->orWhereHas('event', fn ($e) => $e->where('title', 'like', "%{$search}%"));
                });
            })
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(10);

        // Statistik ringkas
        $totalReports = Report::count();
        $unreadReports = Report::where('status', 'unread')->count();
        $resolvedReports = Report::where('status', 'resolved')->count();
        $escalatedReports = Report::where('status', 'escalated')->count();

        return view('layouts.superAdmin.index', array_merge($viewData, [
            'customersReports' => $reports,
            'totalReports' => $totalReports,
            'unreadReports' => $unreadReports,
            'resolvedReports' => $resolvedReports,
            'escalatedReports' => $escalatedReports,
        ]));
    }

    public function show($id)
    {
        $viewData = $this->getViewData('reports-show');

        $report = Report::with(['user', 'event'])->findOrFail($id);

        if ($report->status === 'unread') {
            $report->update(['status' => 'read']);
        }

        $report->load(['user', 'event']);

        return view('layouts.superAdmin.index', array_merge($viewData, [
            'report' => $report,
        ]));
    }
}
