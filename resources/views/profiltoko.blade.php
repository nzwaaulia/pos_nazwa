@extends('layouts.app')

@section('title', 'Profil Toko - Mini Bites Bakery')

@section('content')

<style>
    :root {
        --bakery-mocha: #4a3525;
        --bakery-caramel: #6f4e37;
        --bakery-cream: #fdfbf7;
        --bakery-accent: #d4a373;
        --bakery-soft-bg: #f8f4ee;
    }

    body {
        background-color: var(--bakery-cream);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .page-wrapper {
        padding-top: 35px;
        padding-bottom: 40px;
    }

    .profile-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #efe8de;
        box-shadow: 0 10px 25px rgba(74, 53, 37, 0.08);
        overflow: hidden;
    }

    .profile-header {
        background: #5a4130;
        color: #ffffff;
        padding: 2.5rem;
        text-align: center;
        position: relative;
    }

    .store-logo {
        width: 100px;
        height: 100px;
        background: #ffffff;
        color: var(--bakery-mocha);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        margin: 0 auto 15px auto;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px dashed #efe8de;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-icon {
        width: 40px;
        height: 40px;
        background: var(--bakery-soft-bg);
        color: var(--bakery-caramel);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .info-title {
        font-size: 0.85rem;
        color: #8c857b;
        margin: 0;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: var(--bakery-mocha);
        margin: 0;
    }

    /* Styling Tombol Kembali */
    .btn-back {
        background-color: var(--bakery-caramel);
        color: #ffffff;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        width: 100%;
        display: inline-block;
        text-align: center;
    }

    .btn-back:hover {
        background-color: var(--bakery-mocha);
        color: #ffffff;
    }
</style>

<div class="page-wrapper">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                
                <div class="profile-card">
                    <!-- Header Profil -->
                    <div class="profile-header">
                        <div class="store-logo">
                            🧁
                        </div>
                        <h2 class="fw-bold mb-1">Mini Bites Bakery</h2>
                        <p class="mb-0 text-white-50">Sistem Kasir & Toko Kue</p>
                    </div>

                    <!-- Detail Informasi Toko -->
                    <div class="p-4">

                        <!-- Pengertian / Deskripsi Toko -->
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-info-circle-fill"></i>
                            </div>
                            <div>
                                <p class="info-title">Tentang Toko</p>
                                <p class="info-value" style="font-weight: normal; font-size: 0.95rem; line-height: 1.5;">
                                    <strong>Mini Bites Bakery</strong> adalah toko kue modern yang menyajikan berbagai macam roti, cookies, dan cupcake berkualitas tinggi dengan bahan-bahan pilihan. Kami berkomitmen untuk memberikan cita rasa manis terbaik di setiap gigitan kecil Anda.
                                </p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-shop"></i>
                            </div>
                            <div>
                                <p class="info-title">Nama Toko</p>
                                <p class="info-value">Mini Bites Bakery</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div>
                                <p class="info-title">Alamat Lengkap</p>
                                <p class="info-value">Jl. Mawar No. 45, Bandung, Jawa Barat</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-telephone-fill"></i>
                            </div>
                            <div>
                                <p class="info-title">Nomor Telepon / WhatsApp</p>
                                <p class="info-value">+62 812-3456-7890</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-clock-fill"></i>
                            </div>
                            <div>
                                <p class="info-title">Jam Operasional</p>
                                <p class="info-value">Senin - Minggu (08.00 - 20.00 WIB)</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <i class="bi bi-receipt"></i>
                            </div>
                            <div>
                                <p class="info-title">Catatan Struk Pembayaran</p>
                                <p class="info-value">"Terima kasih telah berbelanja di Mini Bites Bakery!"</p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Tombol Kembali ke Beranda di Bawah -->
                <div class="mt-4 text-center">
                    <a href="{{ route('dashboard') }}" class="btn btn-back py-2 shadow-sm">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection