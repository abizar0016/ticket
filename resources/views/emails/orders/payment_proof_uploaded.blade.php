@component('mail::message')
# Bukti Pembayaran Baru Diupload

Halo **{{ $order->items->first()->product->event->user->name ?? 'Admin' }}**,  
Ada peserta yang baru saja mengupload bukti pembayaran untuk event Anda.

---

### Detail Order:
- **Nama Customer:** {{ $customer->name }}
- **Email:** {{ $customer->email }}
- **Event:** {{ $order->items->first()->product->event->title ?? 'Tidak diketahui' }}
- **Total Pembayaran:** Rp {{ number_format(($order->total_price ?? 0) + ($order->unique_price ?? 0), 0, ',', '.') }}
- **Tanggal Upload:** {{ now()->format('d M Y H:i') }}

---

@component('mail::button', [
    'url' => route(
        auth()->user()->role === 'superadmin'
            ? 'superAdmin.events.orders.show'
            : 'admin.events.orders.show',
        [$order->event_id, $order->id]
    )
])
Lihat Pesanan
@endcomponent

Terima kasih,  
{{ config('app.name') }}
@endcomponent
