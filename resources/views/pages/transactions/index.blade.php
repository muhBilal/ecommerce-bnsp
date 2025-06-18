@extends('layouts.app')

@section('content')
    <h4 class="mb-4">Riwayat Transaksi</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#ID</th>
                <th>Total</th>
                <th>Status</th>
                <th>Metode Bayar</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $trx)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                    <td>
                        <span
                            class="badge 
                            @if ($trx->status == 'pending') bg-warning 
                            @elseif($trx->status == 'cancelled') bg-danger 
                            @else bg-success @endif">
                            {{ ucfirst($trx->status) }}
                        </span>
                    </td>
                    <td>{{ ucfirst($trx->payment_method ?? '-') }}</td>
                    <td>{{ date('d/m/Y H:i', strtotime($trx->created_at)) }}</td>
                    <td>
                        @if ($trx->status === 'pending')
                            <form action="{{ route('transactions.cancel', $trx->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin membatalkan transaksi ini?');">
                                @csrf
                                <button class="btn btn-sm btn-danger">Cancel</button>
                            </form>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada transaksi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
