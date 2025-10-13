@component('mail::message')
# Bukti Pembayaran Baru Diupload

Halo **{{ $order->items->first()->product->event->user->name ?? 'Admin' }}**,  
Ada peserta yang baru saja mengupload bukti pembayaran untuk event Anda.

---

### Detail Order:
- **Nama Customer:** {{ $customer->name }}
- **Email:** {{ $customer->email }}
- **Event:** {{ $order->items->first()->product->event->title ?? 'Tidak diketahui' }}
- **Total Pembayaran:** Rp {{ number_format($order->total_price, 0, ',', '.') }}
- **Tanggal Upload:** {{ now()->format('d M Y H:i') }}

---

@component('mail::button', ['url' => route('admin.orders.show', $order->id)])
Lihat Order
@endcomponent

Terima kasih,  
{{ config('app.name') }}
@endcomponent
