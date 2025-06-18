@extends('auth.layouts')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow rounded">
                <div class="card-header text-center">
                    <h4>Register</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('register.submit') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="birthdate" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Gender</label>
                            <select name="gender" class="form-control" required>
                                <option value="male">Laki-laki</option>
                                <option value="female">Perempuan</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Alamat</label>
                            <textarea name="address" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Kota</label>
                            <input type="text" name="city" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>No Telepon</label>
                            <input type="text" name="phone_number" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>PayPal ID</label>
                            <input type="text" name="paypal_id" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Daftar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
