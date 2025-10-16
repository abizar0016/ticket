<?php

namespace App\Http\Controllers\SuperAdmin\Events;

use App\Http\Controllers\SuperAdmin\Events\SuperAdminEventsBaseController;
use App\Models\Event;
use App\Models\Report;
use Illuminate\Http\Request;

class SuperAdminEventsReportsController extends SuperAdminEventsBaseController
{
    public function index(Request $request, $eventId)
    {
        $events = Event::with(['user', 'organization'])->findOrFail($eventId);

        $reports = Report::with(['user', 'event'])
            ->where('event_id', $eventId)
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(10);

        $viewData = $this->getEventsViewData('reports', $eventId);

        return view('layouts.superAdmin.index', array_merge($viewData, [
            'events' => $events,
            'customersReports' => $reports,
        ]));
    }

    public function show($eventId, $reportId)
    {
        $events = Event::findOrFail($eventId);
        $report = Report::with(['user', 'event'])->findOrFail($reportId);

        $viewData = $this->getEventsViewData('reports-show', $eventId);

        return view('layouts.superAdmin.index', array_merge($viewData, [
            'events' => $events,
            'report' => $report,
        ]));
    }

    public function reply(Request $request, $eventId, $reportId)
    {
        $request->validate(['admin_reply' => 'required|string|max:2000']);

        $report = Report::findOrFail($reportId);
        $report->update([
            'admin_reply' => $request->admin_reply,
            'admin_replied_at' => now(),
            'status' => 'replied',
        ]);

        return back()->with('success', 'Reply sent successfully.');
    }

    public function destroy($eventId, $reportId)
    {
        $report = Report::findOrFail($reportId);
        $report->delete();

        return back()->with('success', 'Report deleted successfully.');
    }
}
