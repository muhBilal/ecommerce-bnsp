@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Profil</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Pengguna</label>
            <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal Lahir</label>
            <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate', $user->birthdate) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select name="gender" class="form-select" required>
                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="address" class="form-control" required>{{ old('address', $user->address) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Kota</label>
            <input type="text" name="city" class="form-control" value="{{ old('city', $user->city) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nomor Telepon</label>
            <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $user->phone_number) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">PayPal ID (opsional)</label>
            <input type="text" name="paypal_id" class="form-control" value="{{ old('paypal_id', $user->paypal_id) }}">
        </div>

        <hr>

        <div class="mb-3">
            <label class="form-label">Password Baru (opsional)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
