@extends('dashboard.layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Dashboard Admin</h3>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Pengguna</h5>
                    <p class="card-text fs-4">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Transaksi</h5>
                    <p class="card-text fs-4">{{ $totalTransactions }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Barang</h5>
                    <p class="card-text fs-4">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
