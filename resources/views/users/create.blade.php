@extends('layouts.app')

@section('title', 'Tambah User - Nazwa Bakery')

@section('content')

@include('layouts.navbar')

<!-- Google Fonts khusus nuansa toko kue yang estetik -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">

<style>
body {
    background: #fdfbf7 !important; /* Warm Cream Background */
    font-family: 'Quicksand', sans-serif !important;
}

.user-wrapper {
    min-height: 90vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
}

.user-card {
    width: 650px;
    background: #ffffff;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(74, 53, 37, 0.08);
    border: 1px solid #f0eae1;
}

/* HEADER TOKO KUE */
.user-header {
    background: linear-gradient(135deg, #4a3525 0%, #6f4e37 100%); /* Rich Mocha Gradient */
    color: white;
    padding: 35px;
    text-align: center;
    position: relative;
    overflow: hidden;
    border-bottom: 1px solid rgba(212, 163, 115, 0.2);
}

.user-header::after {
    content: "";
    width: 180px;
    height: 180px;
    background: rgba(255, 255, 255, 0.08);
    position: absolute;
    right: -40px;
    bottom: -50px;
    border-radius: 50%;
}

.user-header .icon {
    width: 75px;
    height: 75px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 38px;
    margin: auto;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.user-header h3 {
    margin-top: 15px;
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    letter-spacing: 0.5px;
}

/* FORM BODY */
.user-body {
    padding: 40px;
}

.input-box {
    margin-bottom: 22px;
}

.input-box label {
    font-weight: 700;
    color: #4a3525; /* Warna Rich Mocha */
    font-size: 14px;
    margin-bottom: 8px;
    display: block;
}

.input-group-custom {
    display: flex;
    align-items: center;
    border: 2px solid #e2d9cc; /* Soft cream-brown border */
    border-radius: 16px;
    padding: 0 16px;
    background: #fdfbf7;
    transition: .3s;
}

.input-group-custom i {
    color: #6f4e37; /* Warna ikon cokelat */
    font-size: 18px;
}

.input-group-custom input,
.input-group-custom select {
    border: none;
    height: 50px;
    width: 100%;
    outline: none;
    padding-left: 12px;
    background: transparent;
    color: #4a3525;
    font-family: 'Quicksand', sans-serif;
    font-weight: 600;
}

.input-group-custom input::placeholder {
    color: #b0a397;
    font-weight: 500;
}

.input-group-custom:focus-within {
    border-color: #6f4e37;
    box-shadow: 0 0 12px rgba(111, 78, 55, 0.15);
    background: #ffffff;
}

/* BUTTONS */
.button-area {
    display: flex;
    justify-content: space-between;
    margin-top: 35px;
}

.btn-back {
    background: #f7f4ef;
    color: #6f4e37;
    border: none;
    padding: 12px 25px;
    border-radius: 14px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: .2s;
    font-family: 'Quicksand', sans-serif;
}

.btn-back:hover {
    background: #f0eae1;
    color: #4a3525;
}

.btn-save {
    background: linear-gradient(135deg, #4a3525 0%, #6f4e37 100%);
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 14px;
    font-weight: 700;
    box-shadow: 0 4px 15px rgba(74, 53, 37, 0.2);
    transition: .2s;
    font-family: 'Quicksand', sans-serif;
}

.btn-save:hover {
    background: linear-gradient(135deg, #3d2c1f 0%, #5c4d3c 100%);
    color: white;
}
</style>

<div class="user-wrapper">
    <div class="user-card">
        <div class="user-header">
            <div class="icon">
                <i class="bi bi-cake2"></i>
            </div>
            <h3>Tambah Akun Baru</h3>
            <p class="mb-0 text-white-50" style="font-size: 14px;">Buat akun dan atur hak akses pengguna Mini Bites Bakery🥐</p>
        </div>

        <div class="user-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="input-box">
                    <label>Nama Akun</label>
                    <div class="input-group-custom">
                        <i class="bi bi-person-heart"></i>
                        <input type="text" name="name" placeholder="Masukkan nama user" required>
                    </div>
                </div>

                <div class="input-box">
                    <label>Email</label>
                    <div class="input-group-custom">
                        <i class="bi bi-envelope-at"></i>
                        <input type="email" name="email" placeholder="Masukkan email" required>
                    </div>
                </div>

                <div class="input-box">
                    <label>Kata sandi </label>
                    <div class="input-group-custom">
                        <i class="bi bi-key"></i>
                        <input type="password" name="password" placeholder="Masukkan password" required>
                    </div>
                </div>

                <div class="input-box">
                    <label>Role</label>
                    <div class="input-group-custom">
                        <i class="bi bi-award"></i>
                        <select name="role_id" required>
                            <option value="">-- Pilih Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="button-area">
                    <a href="{{ route('admin.users') }}" class="btn-back">
                        ← Kembali
                    </a>
                    <button type="submit" class="btn-save">
                        Simpan Akun
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection