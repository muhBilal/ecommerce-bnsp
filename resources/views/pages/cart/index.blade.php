@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Keranjang</h3>
    <table class="table table-bordered align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @forelse($cartItems as $item)
                @php $subtotal = $item->price * $item->quantity; $total += $subtotal; @endphp
                <tr id="item-{{ $item->id }}">
                    <td class="text-start">{{ $item->device_name }}</td>
                    <td>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <button class="btn btn-sm btn-outline-secondary decrease-btn" data-id="{{ $item->id }}">−</button>
                            <span id="qty-{{ $item->id }}" class="px-2">{{ $item->quantity }}</span>
                            <button class="btn btn-sm btn-outline-secondary increase-btn" data-id="{{ $item->id }}">+</button>
                        </div>
                    </td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td id="subtotal-{{ $item->id }}">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                    <td>
                        <form method="POST" action="{{ route('cart.remove', $item->id) }}" onsubmit="return confirm('Yakin ingin menghapus item ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Keranjang kosong.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if(count($cartItems))
        <div class="mt-4 text-end">
            <h5>Total: <span id="total-price">Rp {{ number_format($total, 0, ',', '.') }}</span></h5>
        </div>

        <form action="{{ route('cart.checkout') }}" method="POST" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="payment_method" class="form-label">Metode Pembayaran</label>
                <select name="payment_method" id="payment_method" class="form-select" required>
                    <option value="">Pilih Metode</option>
                    <option value="cod">COD (Bayar di tempat)</option>
                    <option value="debit">Kartu Debit</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Checkout Sekarang</button>
        </form>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(number);
    }

    function updateSubtotalAndTotal() {
        let total = 0;

        $('[id^="item-"]').each(function () {
            const id = $(this).attr('id').split('-')[1];
            const qty = parseInt($('#qty-' + id).text());
            const price = parseInt($(this).find('td').eq(2).text().replace(/[^\d]/g, ''));
            const subtotal = qty * price;

            $('#subtotal-' + id).text(formatRupiah(subtotal));
            total += subtotal;
        });

        $('#total-price').text(formatRupiah(total));
    }

    $(document).ready(function () {
        $('.increase-btn').on('click', function () {
            const id = $(this).data('id');

            $.ajax({
                url: `/cart/increase/${id}`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function () {
                    const qtyElem = $('#qty-' + id);
                    const newQty = parseInt(qtyElem.text()) + 1;
                    qtyElem.text(newQty);
                    updateSubtotalAndTotal();
                },
                error: function () {
                    alert('Gagal menambah jumlah produk.');
                }
            });
        });

        $('.decrease-btn').on('click', function () {
            const id = $(this).data('id');

            $.ajax({
                url: `/cart/decrease/${id}`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function () {
                    const qtyElem = $('#qty-' + id);
                    const currentQty = parseInt(qtyElem.text());
                    if (currentQty > 1) {
                        qtyElem.text(currentQty - 1);
                        updateSubtotalAndTotal();
                    } else {
                        alert('Minimal jumlah adalah 1');
                    }
                },
                error: function () {
                    alert('Gagal mengurangi jumlah produk.');
                }
            });
        });
    });
</script>
@endpush
