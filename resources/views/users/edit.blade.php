@extends('layouts.app')

@section('title', 'Edit User - Manis Bakery')

@section('content')

@include('layouts.navbar')

<!-- Google Fonts khusus nuansa toko kue yang estetik -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">

<style>
    .user-wrapper-bakery {
        background: linear-gradient(135deg, #fdfbf7 0%, #f4f1ea 100%) !important;
        min-height: 90vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        font-family: 'Quicksand', sans-serif !important;
    }

    .user-card-bakery {
        width: 650px;
        background: #ffffff;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(74, 53, 37, 0.08);
        border: 1px solid #f0eae1;
    }

    /* HEADER TOKO KUE */
    .user-header-bakery {
        background: linear-gradient(135deg, #4a3525 0%, #6f4e37 100%); /* Mocha Gradient senada dashboard */
        color: white;
        padding: 35px;
        text-align: center;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid rgba(212, 163, 115, 0.2);
    }

    .user-header-bakery::before {
        content: '🥐';
        position: absolute;
        top: -15px;
        right: 20px;
        font-size: 7rem;
        opacity: 0.08;
    }

    .user-header-bakery .icon {
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

    .user-header-bakery h3 {
        margin-top: 15px;
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    /* FORM BODY */
    .user-body-bakery {
        padding: 40px;
    }

    .input-box-bakery {
        margin-bottom: 22px;
    }

    .input-box-bakery label {
        font-weight: 700;
        color: #4a3525; /* Warna cokelat tua pastry */
        font-size: 14px;
        margin-bottom: 8px;
        display: block;
    }

    .input-group-custom-bakery {
        display: flex;
        align-items: center;
        border: 2px solid #f0eae1;
        border-radius: 18px;
        padding: 0 16px;
        background: #fdfbf7;
        transition: .3s;
    }

    .input-group-custom-bakery i {
        color: #bc6c25; /* Warna aksen karamel hangat */
        font-size: 18px;
    }

    .input-group-custom-bakery input,
    .input-group-custom-bakery select {
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

    .input-group-custom-bakery input::placeholder {
        color: #b0a397;
        font-weight: 500;
    }

    .input-group-custom-bakery:focus-within {
        border-color: #bc6c25;
        box-shadow: 0 0 12px rgba(188, 108, 37, 0.15);
        background: #ffffff;
    }

    /* BUTTONS */
    .button-area-bakery {
        display: flex;
        justify-content: space-between;
        margin-top: 35px;
        gap: 15px;
    }

    .btn-back-bakery {
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

    .btn-back-bakery:hover {
        background: #eee8df;
        color: #4a3525;
    }

    .btn-update-bakery {
        background: linear-gradient(135deg, #d4a373 0%, #bc6c25 100%);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 14px;
        font-weight: 700;
        box-shadow: 0 4px 15px rgba(188, 108, 37, 0.25);
        transition: .2s;
        font-family: 'Quicksand', sans-serif;
    }

    .btn-update-bakery:hover {
        background: linear-gradient(135deg, #bc6c25 0%, #9a5319 100%);
        color: white;
    }
</style>

<div class="user-wrapper-bakery">
    <div class="user-card-bakery">
        
        <div class="user-header-bakery">
            <div class="icon">
                <i class="bi bi-person-gear"></i>
            </div>
            <h3>Edit Akun</h3>
            <p class="mb-0 text-white-50" style="font-size: 14px;">Perbarui data akun pengguna toko Mini Bites Bakery 🍰</p>
        </div>

        <div class="user-body-bakery">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="input-box-bakery">
                    <label>Nama Akun</label>
                    <div class="input-group-custom-bakery">
                        <i class="bi bi-person-heart"></i>
                        <input 
                            type="text" 
                            name="name" 
                            value="{{ old('name', $user->name) }}" 
                            placeholder="Masukkan nama user">
                    </div>
                </div>

                <div class="input-box-bakery">
                    <label>Email</label>
                    <div class="input-group-custom-bakery">
                        <i class="bi bi-envelope-at"></i>
                        <input 
                            type="email" 
                            name="email" 
                            value="{{ old('email', $user->email) }}" 
                            placeholder="Masukkan email">
                    </div>
                </div>

                <div class="input-box-bakery">
                    <label>Kata Sandi</label>
                    <div class="input-group-custom-bakery">
                        <i class="bi bi-key"></i>
                        <input 
                            type="password" 
                            name="password" 
                            placeholder="Kosongkan jika tidak ingin mengganti password">
                    </div>
                </div>

                <div class="input-box-bakery">
                    <label>Role</label>
                    <div class="input-group-custom-bakery">
                        <i class="bi bi-award"></i>
                        <select name="role_id">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @if($user->role_id == $role->id) selected @endif>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="button-area-bakery">
                    <a href="{{ route('admin.users') }}" class="btn-back-bakery">
                        ← Kembali
                    </a>
                    <button type="submit" class="btn-update-bakery">
                        ✏️ Simpan Akun 
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

@endsection