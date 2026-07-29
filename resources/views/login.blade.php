<!-- memanggil file app.blade.php -->
@extends('layouts.app')

<!-- mengirimkan nilai ke tittle untuk ditampilkan -->
@section('title', 'Login - Nazwa Bakery')

<!-- batas awal isi konten -->
@section('content')

<!-- Custom Bakery Theme Styling for Login -->
<style>
    body {
        background: linear-gradient(135deg, #fdfbf7 0%, #f7f1eb 100%);
        min-height: 100vh;
        overflow: hidden;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .login-container {
        width: 100%;
        max-width: 420px;
        border: 1px solid #f0eae1;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(74, 53, 37, 0.08);
        background: #ffffff;
        animation: fadeInScale 0.6s ease-in-out;
        overflow: hidden;
    }
    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: translate(-50%, -45%) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }
    }
    .login-header-bg {
        background: linear-gradient(135deg, #4a3525 0%, #6f4e37 100%); /* Rich Mocha Gradient */
        color: white;
        padding: 2.5rem 1.5rem;
        text-align: center;
        position: relative;
        border-bottom: 1px solid rgba(212, 163, 115, 0.2);
    }
    .login-header-bg::after {
        content: "";
        position: absolute;
        bottom: -10px;
        left: 0;
        right: 0;
        height: 20px;
        background: #ffffff;
        border-radius: 50% 50% 0 0;
    }
    .login-header-bg h3 {
        font-weight: 700;
        margin-bottom: 0.3rem;
        letter-spacing: 0.5px;
        font-family: serif;
    }
    .login-header-bg p {
        font-size: 0.85rem;
        opacity: 0.85;
        margin-bottom: 0;
    }
    .form-control {
        border-radius: 12px;
        border: 1px solid #e2d9cc;
        padding: 0.75rem 1rem;
        background-color: #fdfbf7;
        transition: all 0.3s ease;
    }
    .form-control:focus {
        background-color: #fff;
        border-color: #c89666;
        box-shadow: 0 0 0 4px rgba(200, 150, 102, 0.12);
    }
    .btn-custom-login {
        background: linear-gradient(135deg, #4a3525 0%, #6f4e37 100%);
        border: none;
        border-radius: 12px;
        padding: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(74, 53, 37, 0.2);
    }
    .btn-custom-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(74, 53, 37, 0.3);
        background: linear-gradient(135deg, #3d2c1f 0%, #5c4d3c 100%);
    }
    .form-label {
        font-weight: 600;
        color: #5c4d3c;
        font-size: 0.85rem;
    }
    .input-group-text {
        background-color: #fdfbf7 !important;
        border-color: #e2d9cc !important;
    }
</style>

<div class="card position-absolute top-50 start-50 translate-middle login-container">
    <div class="login-header-bg">
        <div class="mb-2">
            <i class="bi bi-cake2 fs-1 text-white"></i>
        </div>
        <h3>Mini Bites Bakery</h3>
        <p>Masuk untuk mengelola kue dan roti favoritmu</p>
    </div>
    
    <div class="card-body p-4 p-md-5 pt-3">
        <form action="{{ route('auth') }}" method="POST">
            @csrf
            
            <div class="mb-3 text-start">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text border-end-0 rounded-start-3">
                        <i class="bi bi-envelope text-muted"></i>
                    </span>
                    <input type="email" name="email" class="form-control border-start-0 ps-0" 
                    id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="nama@email.com" value="{{ old('email') }}">
                </div>
                @error('email')
                    <div class="badge text-bg-danger mt-1 rounded-pill px-2">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-4 text-start">
                <label for="exampleInputPassword1" class="form-label">Kata sandi</label>
                <div class="input-group">
                    <span class="input-group-text border-end-0 rounded-start-3">
                        <i class="bi bi-lock text-muted"></i>
                    </span>
                    <input type="password" name="password" class="form-control border-start-0 ps-0" 
                    id="exampleInputPassword1" placeholder="••••••••">
                </div>
                @error('password')
                    <div class="badge text-bg-danger mt-1 rounded-pill px-2">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-custom-login text-white w-100">Masuk Sekarang</button>
        </form>
    </div>
</div>

<!-- batas Akhir isi konten -->
@endsection