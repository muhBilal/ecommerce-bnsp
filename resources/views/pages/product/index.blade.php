@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form method="GET" action="{{ route('products.index') }}" class="row mb-4">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Cari alat kesehatan..."
                value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="category" class="form-control">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <div class="row">
        @forelse($products as $device)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    @if ($device->image)
                        <img src="{{ asset('storage/' . $device->image) }}" class="card-img-top img-fluid"
                            alt="{{ $device->name }}" style="max-height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $device->name }}</h5>
                        <p class="card-text">{{ $device->brand }}</p>
                        <p class="card-text">Stok: {{ $device->quantity }}</p>
                        @auth
                            <button class="btn btn-success mt-2 add-to-cart" data-id="{{ $device->id }}">
                                Tambah ke Keranjang
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary mt-2">
                                Login untuk membeli
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted">Produk tidak ditemukan.</p>
            </div>
        @endforelse
    </div>


    <div class="mt-4">
        {{ $products->links() }}
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $('.add-to-cart').click(function() {
                var deviceId = $(this).data('id');
                $.post("/cart/add/" + deviceId, {
                    _token: '{{ csrf_token() }}'
                }, function(response) {
                    alert('Produk berhasil ditambahkan ke keranjang');
                }).fail(function() {
                    alert('Gagal menambahkan ke keranjang');
                });
            });
        });
    </script>
@endpush
