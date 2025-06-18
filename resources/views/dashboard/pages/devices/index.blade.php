@extends('dashboard.layouts.app')
@section('content')
    <div class="container">
        <h3>Daftar Alat Kesehatan</h3>
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Tambah Alat</button>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Merek</th>
                    <th>Tipe</th>
                    <th>Jumlah</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($devices as $device)
                    <tr>
                        <td>
                            @if ($device->image)
                                <img src="{{ asset('storage/' . $device->image) }}" alt="{{ $device->name }}" class="img-fluid"
                                    style="max-width: 100px;">
                            @else
                                <img src="{{ asset('images/no-image.png') }}" alt="No Image" class="img-fluid"
                                    style="max-width: 100px;">
                            @endif
                        </td>
                        <td>{{ $device->name }}</td>
                        <td>{{ $device->brand }}</td>
                        <td>{{ $device->type_name }}</td>
                        <td>{{ $device->quantity }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $device->id }}">Edit</button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $device->id }}">Hapus</button>
                        </td>
                    </tr>

                    {{-- Edit Modal --}}
                    <div class="modal fade" id="editModal{{ $device->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <form method="POST" action="{{ route('admin.devices.update', $device->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Alat</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label>Nama</label>
                                                <input type="text" name="name" class="form-control"
                                                    value="{{ $device->name }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Merek</label>
                                                <input type="text" name="brand" class="form-control"
                                                    value="{{ $device->brand }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Jumlah</label>
                                                <input type="number" name="quantity" class="form-control"
                                                    value="{{ $device->quantity }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Harga</label>
                                                <input type="number" name="price" class="form-control"
                                                    value="{{ $device->price }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Tipe</label>
                                                <select name="type" class="form-control" required>
                                                    @foreach ($types as $type)
                                                        <option value="{{ $type->id }}"
                                                            {{ $device->type == $type->id ? 'selected' : '' }}>
                                                            {{ $type->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Gambar (opsional)</label>
                                                <input type="file" name="image" class="form-control" accept="image/*">
                                                @if ($device->image)
                                                    <img src="{{ asset('images/' . $device->image) }}" class="mt-2 rounded"
                                                        style="height: 80px;" alt="Gambar Lama">
                                                @endif
                                            </div>
                                            <div class="col-12">
                                                <label>Deskripsi</label>
                                                <textarea name="description" class="form-control" rows="3" required>{{ $device->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                    {{-- Delete Modal --}}
                    <div class="modal fade" id="deleteModal{{ $device->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('admin.devices.destroy', $device->id) }}">
                                @csrf @method('DELETE')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        Yakin ingin menghapus <strong>{{ $device->name }}</strong>?
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

    {{-- Create Modal --}}
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ route('admin.devices.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Alat Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label>Nama</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Merek</label>
                                <input type="text" name="brand" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Jumlah</label>
                                <input type="number" name="quantity" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Harga</label>
                                <input type="number" name="price" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Tipe</label>
                                <select name="type" class="form-control" required>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Gambar</label>
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                            <div class="col-12">
                                <label>Deskripsi</label>
                                <textarea name="description" class="form-control" rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
