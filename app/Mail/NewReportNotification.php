<?php

namespace App\Mail;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewReportNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $report;
    public $event;

    public function __construct(Report $report)
    {
        $this->report = $report;
        $this->event = $report->event;
    }

    public function build()
    {
        return $this->subject('🔔 Laporan Baru Diterima')
            ->markdown('emails.reports.new', [
                'report' => $this->report,
                'event' => $this->event,
            ]);
    }
}


