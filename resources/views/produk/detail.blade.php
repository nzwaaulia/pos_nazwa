@extends('layouts.app')

@section('title', 'Detail Produk - Sweet Crumbs Bakery')

@section('content')

@include('layouts.navbar')

<!-- Custom Bakery Theme Detail Styling -->
<style>
    .page-wrapper {
        background-color: #fdfbf7 !important; /* Warm Cream Background */
        min-height: 100vh;
        padding: 2.5rem 0 3.5rem 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .detail-card {
        border: 1px solid #f0eae1;
        border-radius: 24px;
        box-shadow: 0 15px 35px rgba(74, 53, 37, 0.06);
        background: #ffffff;
        overflow: hidden;
        transition: transform 0.3s ease;
        max-width: 480px;
        margin: 0 auto;
    }
    .detail-card:hover {
        transform: translateY(-4px);
    }
    .product-img-wrapper {
        position: relative;
        overflow: hidden;
        background: #f7f4ef;
        height: 280px;
    }
    .product-img-top {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .detail-card:hover .product-img-top {
        transform: scale(1.04);
    }
    .hero-title-section {
        background: linear-gradient(135deg, #4a3525 0%, #6f4e37 100%); /* Rich Mocha Gradient */
        border-radius: 20px;
        color: #fff;
        padding: 2.5rem;
        box-shadow: 0 10px 25px rgba(74, 53, 37, 0.15);
        margin-bottom: 2.5rem;
        border: 1px solid rgba(212, 163, 115, 0.2);
        position: relative;
        overflow: hidden;
    }
    .hero-title-section::before {
        content: '🥐';
        position: absolute;
        top: -10px;
        right: 20px;
        font-size: 6rem;
        opacity: 0.08;
    }
    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.85rem 0;
        border-bottom: 1px solid #f4f1ea;
    }
    .info-item:last-child {
        border-bottom: none;
    }
    .info-label {
        font-weight: 600;
        color: #6f4e37;
        font-size: 0.9rem;
    }
    .info-value {
        font-weight: 700;
        color: #4a3525;
    }
    .badge-price-sell {
        background: #f4f7ed;
        color: #606c38;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 0.9rem;
    }
    .badge-stock {
        background: linear-gradient(135deg, #d4a373 0%, #bc6c25 100%);
        color: white;
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 0.85rem;
    }
    .btn-back {
        background: linear-gradient(135deg, #4a3525 0%, #6f4e37 100%);
        border: none;
        border-radius: 12px;
        padding: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.3px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(74, 53, 37, 0.2);
    }
    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(74, 53, 37, 0.3);
        background: linear-gradient(135deg, #3a291d 0%, #5f422e 100%);
        color: #ffffff;
    }
</style>

<div class="page-wrapper">
    <div class="container">
        
        <!-- Header Banner -->
        <div class="hero-title-section text-center">
            <span class="badge bg-white px-3 py-1 rounded-pill fw-bold mb-2 shadow-sm" style="color: #4a3525 !important;">
                🧁  Mini Bites Bakery
            </span>
            <h1 class="display-6 fw-bold mb-1" style="font-family: serif;">Informasi Varian Kue</h1>
            <p class="text-white-50 mb-0">Rincian lengkap spesifikasi, harga, dan ketersediaan stok produk.</p>
        </div>

        <!-- Detail Card -->
        <div class="card detail-card">
            <div class="product-img-wrapper">
                @if($produk->gambar ?? $produk->foto)
                    <img src="{{ asset('storage/' . ($produk->gambar ?? $produk->foto)) }}" class="product-img-top" alt="{{ $produk->nama }}">
                @else
                    <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                        <i class="bi bi-image fs-1"></i>
                    </div>
                @endif
            </div>
            
            <div class="card-body p-4">
                <h4 class="card-title fw-bold text-dark text-center mb-4 pb-2 border-bottom" style="font-family: serif; color: #4a3525 !important;">
                    {{ $produk->nama }}
                </h4>
                
                <div class="info-list mb-4">
                    @if(isset($produk->kategori))
                    <div class="info-item">
                        <span class="info-label"><i class="bi bi-tag me-2" style="color: #bc6c25;"></i> Kategori</span>
                        <span class="info-value">{{ $produk->kategori }}</span>
                    </div>
                    @endif

                    @if(isset($produk->harga))
                    <div class="info-item">
                        <span class="info-label"><i class="bi bi-cash-coin me-2" style="color: #606c38;"></i> Harga Jual</span>
                        <span class="info-value badge-price-sell">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    
                    <div class="info-item">
                        <span class="info-label"><i class="bi bi-box-seam me-2" style="color: #d4a373;"></i> Stok Tersedia</span>
                        <span class="info-value badge-stock">{{ $produk->stok }} pcs</span>
                    </div>

                    @if(isset($produk->berat))
                    <div class="info-item">
                        <span class="info-label"><i class="bi bi-basket me-2" style="color: #6f4e37;"></i> Berat / Porsi</span>
                        <span class="info-value text-dark">{{ $produk->berat }}</span>
                    </div>
                    @endif
                    
                    @if(isset($produk->user))
                    <div class="info-item">
                        <span class="info-label"><i class="bi bi-person-badge me-2" style="color: #4a3525;"></i> Penginput</span>
                        <span class="info-value text-dark">{{ $produk->user->name }}</span>
                    </div>
                    @endif
                </div>

                @if(isset($produk->deskripsi) && $produk->deskripsi)
                <div class="mb-4 p-3 rounded-4" style="background-color: #f7f4ef;">
                    <span class="d-block small fw-bold text-uppercase mb-1" style="color: #6f4e37; font-size: 0.75rem;">Deskripsi Rasa</span>
                    <p class="mb-0 text-muted small">{{ $produk->deskripsi }}</p>
                </div>
                @endif
                
                <a href="{{ route('produk.index') }}" class="btn btn-back text-white w-100">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar Produk
                </a>
            </div>
        </div>

    </div>
</div>

@endsection