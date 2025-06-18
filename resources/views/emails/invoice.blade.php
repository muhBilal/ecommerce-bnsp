@component('mail::message')
# Halo {{ $transaction->username }},

Pesanan Anda telah disetujui dan invoice telah dilampirkan.

@component('mail::panel')
**Total Pembayaran:** Rp {{ number_format($transaction->total_price, 0, ',', '.') }}  
**Metode Pembayaran:** {{ $transaction->payment_method ?? '-' }}
@endcomponent

Terima kasih telah berbelanja di Toko Medika Sehat!

Salam,  
Toko Medika Sehat
@endcomponent
