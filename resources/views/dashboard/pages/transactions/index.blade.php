@extends('dashboard.layouts.app')
@section('content')
    <div class="container">
        <h3>Daftar Pesanan</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" value="{{ $search }}" class="form-control"
                    placeholder="Cari berdasarkan username">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Total Harga</th>
                    <th>Metode Pembayaran</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                    <tr>
                        <td>{{ $trx->username }}</td>
                        <td>Rp {{ number_format($trx->total_price, 2, ',', '.') }}</td>
                        <td>{{ $trx->payment_method ?? '-' }}</td>
                        <td>
                            <span
                                class="badge bg-{{ $trx->status == 'approved' ? 'success' : ($trx->status == 'rejected' ? 'danger' : 'secondary') }}">
                                {{ ucfirst($trx->status) }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y H:i') }}</td>
                        {{-- <td>
                            <form action="{{ route('admin.transactions.approve', $trx->id) }}" method="POST"
                                class="d-inline">
                                @csrf @method('PUT')
                                <button class="btn btn-success btn-sm">Approve</button>
                            </form>

                            @if ($trx->status == 'pending')
                                <form action="{{ route('admin.transactions.approve', $trx->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf @method('PUT')
                                    <button class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <form action="{{ route('admin.transactions.reject', $trx->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf @method('PUT')
                                    <button class="btn btn-warning btn-sm">Tolak</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.transactions.destroy', $trx->id) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Hapus pesanan ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td> --}}
                        <td>
    @if ($trx->status === 'approved')
        <a href="{{ route('admin.transactions.invoice', $trx->id) }}" class="btn btn-primary btn-sm">
            <i class="bi bi-printer"></i> Cetak Invoice
        </a>
    @else
        <form action="{{ route('admin.transactions.approve', $trx->id) }}" method="POST" class="d-inline">
            @csrf @method('PUT')
            <button class="btn btn-success btn-sm">Approve</button>
        </form>

        <form action="{{ route('admin.transactions.reject', $trx->id) }}" method="POST" class="d-inline">
            @csrf @method('PUT')
            <button class="btn btn-warning btn-sm">Tolak</button>
        </form>
    @endif

    <form action="{{ route('admin.transactions.destroy', $trx->id) }}" method="POST"
        class="d-inline" onsubmit="return confirm('Hapus pesanan ini?')">
        @csrf @method('DELETE')
        <button class="btn btn-danger btn-sm">Hapus</button>
    </form>
</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
