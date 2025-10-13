@component('mail::message')
# Pesanan Baru 🎉

Halo {{ $order->event->user->name }},

Anda baru saja menerima pesanan baru untuk event **{{ $order->event->title }}**.

**Nama Pemesan:** {{ $order->name }}  
**Email:** {{ $order->email }}  
**Total Pembayaran:** Rp{{ number_format($order->total_price + $order->unique_price, 0, ',', '.') }}

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
