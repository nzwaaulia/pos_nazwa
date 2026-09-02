@extends('layouts.app')

@section('content')

@include('layouts.navbar')

<div class="container mt-4 mb-5">
    <div class="row">
        <!-- 1. Tentang Saya -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header fw-bold text-white py-3" style="background-color: #5C3D2E;">👤 Tentang Saya</div>
                <div class="card-body text-center bg-light">
                    <img src="{{ asset('images/potonazwa.jpeg') }}" class="rounded-circle mb-3 shadow" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #5C3D2E;">
                    <h5 class="fw-bold text-dark">Nazwa Aulia Fahra</h5>
                    <p class="text-muted small">Pengembang & Pemilik Mini Bites Bakery</p>
                    <p class="text-secondary small">Saya adalah pengembang aplikasi ini yang berfokus pada efisiensi manajemen toko cookies dan cupcake.</p>
                </div>
            </div>
        </div>

        <!-- 2. Tentang Aplikasi -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header fw-bold text-white py-3" style="background-color: #5C3D2E;">💻 Tentang Aplikasi</div>
                <div class="card-body bg-light text-secondary">
                    <p><strong>Mini Bites Bakery</strong> adalah aplikasi sistem kasir (POS) yang dirancang khusus untuk mempermudah pencatatan penjualan roti secara digital.</p>
                    <p class="mb-0">Aplikasi ini membantu meminimalisir kesalahan manual dalam menghitung total pendapatan harian toko Anda secara praktis.</p>
                </div>
            </div>
        </div>

        <!-- 3. Fitur Utama -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header fw-bold text-white py-3" style="background-color: #5C3D2E;">✨ Fitur Utama</div>
                <div class="card-body bg-light text-secondary">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">✅ Manajemen Data Produk Roti</li>
                        <li class="mb-2">✅ Pencatatan Transaksi Penjualan</li>
                        <li class="mb-2">✅ Ringkasan Penjualan Harian</li>
                        <li>✅ Manajemen Akun Pengguna (Admin/Kasir)</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- 4. Teknologi yang Digunakan -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header fw-bold text-white py-3" style="background-color: #5C3D2E;">💻 Teknologi</div>
                <div class="card-body bg-light text-secondary">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><strong>Framework:</strong> Laravel (PHP)</li>
                        <li class="mb-2"><strong>Frontend:</strong> Bootstrap 5 & Blade Templates</li>
                        <li class="mb-2"><strong>Database:</strong> MySQL</li>
                        <li><strong>Server:</strong> Laragon / Apache</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Kontak & Tombol Kembali -->
    <div class="card shadow-sm border-0 p-4 text-center bg-light" style="border-radius: 12px;">
        <h5 class="fw-bold mb-3" style="color: #5C3D2E;">📬 Hubungi Pengembang</h5>
        <p class="mb-3 text-secondary">
            📧 Email: <a href="nzwaauliafahra@email.com" class="text-decoration-none fw-bold" style="color: #5C3D2E;">nzwaauliafahra@email.com</a> | 
            📸 Instagram: <a href="https://instagram.com/nzwaaulia.22" target="_blank" class="text-decoration-none fw-bold" style="color: #5C3D2E;">@nzwaaulia.22</a>
        </p>
        <div>
            <a href="{{ route('dashboard') }}" class="btn text-white px-4 py-2 fw-bold shadow-sm" style="background-color: #5C3D2E; border-radius: 8px;">Kembali ke Beranda</a>
        </div>
    </div>
</div>
@endsection