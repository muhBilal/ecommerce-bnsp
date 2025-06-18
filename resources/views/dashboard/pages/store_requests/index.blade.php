@extends('dashboard.layouts.app')

@section('content')
<div class="container">
    <h3>Pengajuan Menjadi Toko</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Kota</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->city }}</td>
                <td>{{ $user->phone_number }}</td>
                <td>{{ $user->address }}</td>
                <td>
                    @if($user->isStore)
                        <span class="badge bg-success">Toko Aktif</span>
                    @elseif ($user->isStore == 0)
                        <span class="badge bg-danger">Toko Ditolak</span>
                    @else
                        <span class="badge bg-warning">Menunggu Persetujuan</span>
                    @endif
                <td>
                    <form action="{{ route('admin.store_requests.approve', $user->id) }}" method="POST" class="d-inline">
                        @csrf @method('PUT')
                        <button class="btn btn-success btn-sm">Approve</button>
                    </form>
                    <form action="{{ route('admin.store_requests.reject', $user->id) }}" method="POST" class="d-inline">
                        @csrf @method('PUT')
                        <button class="btn btn-danger btn-sm">Tolak</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada pengajuan toko</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
