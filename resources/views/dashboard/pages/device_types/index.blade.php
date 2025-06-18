@extends('dashboard.layouts.app')
@section('content')
<div class="container">
    <h3>Daftar Tipe Alat</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Tambah Tipe</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Tipe</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($types as $type)
            <tr>
                <td>{{ $type->name }}</td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $type->id }}">Edit</button>
                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $type->id }}">Hapus</button>
                </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal{{ $type->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('admin.device-types.update', $type->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5>Edit Tipe Alat</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Nama Tipe</label>
                                    <input type="text" name="name" class="form-control" value="{{ $type->name }}" required>
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
            <div class="modal fade" id="deleteModal{{ $type->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('admin.device-types.destroy', $type->id) }}">
                        @csrf
                        @method('DELETE')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5>Hapus Tipe</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                Yakin ingin menghapus <strong>{{ $type->name }}</strong>?
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

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.device-types.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Tambah Tipe Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Tipe</label>
                        <input type="text" name="name" class="form-control" required>
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
