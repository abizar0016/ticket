@component('mail::message')
# 🔔 Laporan Baru Diterima

Hai {{ $report->event->user->name }},

Ada laporan baru dari **{{ $report->user->name ?? 'Pengguna' }}** terkait event **{{ $report->event->title }}**.

**Alasan:**  
{{ ucfirst(str_replace('_', ' ', $report->reason)) }}

**Deskripsi:**  
{{ $report->description }}

@component('mail::button', ['url' => '#'])
Lihat Laporan
@endcomponent

Terima kasih,  
{{ config('app.name') }}
@endcomponent
