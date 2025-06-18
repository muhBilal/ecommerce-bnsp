@extends('dashboard.layouts.app')
@section('content')
<div class="container">
    <h3>Daftar Pengguna</h3>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>Kota</th>
                <th>Telepon</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->address }}</td>
                <td>{{ $user->city }}</td>
                <td>{{ $user->phone_number }}</td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $user->id }}">Edit</button>
                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">Hapus</button>
                </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5>Edit Pengguna</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                </div>
                                <div class="mb-2">
                                    <label>Password (biarkan kosong jika tidak ingin diubah)</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                                <div class="mb-2">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                                </div>
                                <div class="mb-2">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="birthdate" class="form-control" value="{{ $user->birthdate }}" required>
                                </div>
                                <div class="mb-2">
                                    <label>Jenis Kelamin</label>
                                    <select name="gender" class="form-control" required>
                                        <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Perempuan</option>
                                        <option value="other" {{ $user->gender == 'other' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label>Alamat</label>
                                    <textarea name="address" class="form-control" required>{{ $user->address }}</textarea>
                                </div>
                                <div class="mb-2">
                                    <label>Kota</label>
                                    <input type="text" name="city" class="form-control" value="{{ $user->city }}" required>
                                </div>
                                <div class="mb-2">
                                    <label>Telepon</label>
                                    <input type="text" name="phone_number" class="form-control" value="{{ $user->phone_number }}" required>
                                </div>
                                <div class="mb-2">
                                    <label>PayPal ID</label>
                                    <input type="text" name="paypal_id" class="form-control" value="{{ $user->paypal_id }}">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Modal -->
            <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}">
                        @csrf
                        @method('DELETE')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5>Hapus Pengguna</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                Yakin ingin menghapus <strong>{{ $user->username }}</strong>?
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
