@component('mail::message')
# Pesanan Anda Telah Dikonfirmasi 🎉

Halo **{{ $recipientName }}**,

Pesanan Anda untuk acara **{{ $event->name ?? '-' }}** telah dikonfirmasi dan dinyatakan **lunas**.

---

### 📅 Detail Pesanan
- **Event:** {{ $event->title ?? '-' }}
- **Tanggal:** {{ optional($order->created_at)->format('d F Y') ?? '-' }}
- **Total Pembayaran:** Rp {{ number_format(($order->total_price ?? 0) + ($order->unique_price ?? 0), 0, ',', '.') }}

---

@component('mail::button', ['url' => route('orders.show', $order->id)])
Lihat Detail Pesanan
@endcomponent

Terima kasih telah memesan tiket di **{{ config('app.name') }}**!  
Kami menantikan kehadiranmu di acara ini 🙌

Salam hangat,  
**Tim {{ config('app.name') }}**
@endcomponent
