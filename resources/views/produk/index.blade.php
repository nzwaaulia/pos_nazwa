@extends('layouts.app')

@section('title', 'Daftar Produk - Sweet Crumbs Bakery')

@section('content')

@include('layouts.navbar')

<style>
    :root {
        --bakery-mocha: #4a3525;
        --bakery-caramel: #6f4e37;
        --bakery-cream: #fdfbf7;
        --bakery-accent: #d4a373;
        --bakery-soft-bg: #f8f4ee;
        --bakery-user-bg: #f3e8dc;
        --bakery-user-text: #6f4e37;
        
        /* Action Button Colors */
        --btn-detail-bg: #f4f1ea;
        --btn-detail-text: #6f4e37;
        --btn-edit-bg: #f3e8dc;
        --btn-edit-text: #4a3525;
        --btn-delete-bg: #e8ded1;
        --btn-delete-text: #8c4343;
    }

    body {
        background-color: var(--bakery-cream);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* MEMBERI JARAK ANTARA NAVBAR DENGAN DASHBOARD/CONTENT */
    .page-wrapper {
        padding-top: 35px;
        padding-bottom: 40px;
    }

    /* Hero Banner Theme Penjualan */
    .hero-banner {
        background: #5a4130;
        color: #ffffff;
        border-radius: 20px;
        padding: 2.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(74, 53, 37, 0.15);
    }

    .hero-badge {
        background: #ffffff;
        color: #5a4130;
        font-size: 0.8rem;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 20px;
        display: inline-block;
        margin-bottom: 12px;
    }

    .hero-title {
        font-family: 'Georgia', serif;
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .hero-subtitle {
        color: #d1c2b5;
        font-size: 0.95rem;
        margin-bottom: 20px;
    }

    .btn-hero-add {
        background: #ffffff;
        color: #5a4130 !important;
        font-weight: 700;
        border-radius: 12px;
        padding: 10px 22px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .btn-hero-add:hover {
        background: #f8f4ee;
        transform: translateY(-2px);
    }

    /* Watermark Icon Roti/Croissant */
    .hero-watermark {
        position: absolute;
        right: -20px;
        bottom: -20px;
        font-size: 11rem;
        opacity: 0.08;
        pointer-events: none;
        color: #ffffff;
    }

    /* Container Grid */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
        gap: 1.25rem;
        padding: 1.5rem 0;
    }

    /* Card Item */
    .product-card {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #efe8de;
        box-shadow: 0 4px 15px rgba(74, 53, 37, 0.04);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        position: relative;
        transition: all 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(74, 53, 37, 0.12);
        border-color: var(--bakery-accent);
    }

    /* Gambar & Badge Stok */
    .card-img-wrapper {
        position: relative;
        width: 100%;
        height: 190px;
        overflow: hidden;
    }

    .card-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .badge-stok {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255, 255, 255, 0.92);
        color: var(--bakery-mocha);
        font-weight: 700;
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 20px;
        border: 1px solid rgba(74, 53, 37, 0.1);
        backdrop-filter: blur(2px);
    }

    /* Body Card */
    .card-body-custom {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .badge-user {
        background-color: var(--bakery-user-bg);
        color: var(--bakery-user-text);
        font-size: 0.75rem;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 12px;
        display: inline-block;
        margin-bottom: 8px;
        width: fit-content;
    }

    .product-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--bakery-mocha);
        margin-bottom: 6px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Price Section */
    .price-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.8rem;
        margin-bottom: 3px;
    }

    .price-label {
        color: #8c857b;
    }

    .price-sell {
        color: #2e7d32;
        font-weight: 800;
        font-size: 1.05rem;
    }

    /* Action Group */
    .action-group {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 12px;
        padding-top: 10px;
        border-top: 1px solid #f6f1e9;
    }

    .btn-action-custom {
        height: 34px;
        border: none;
        border-radius: 8px;
        font-size: 0.78rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .btn-action-custom:hover {
        transform: translateY(-1px);
        filter: brightness(0.95);
    }

    .btn-card-detail { 
        background: var(--btn-detail-bg); 
        color: var(--btn-detail-text); 
        flex: 1; 
    }

    .btn-card-edit { 
        background: var(--btn-edit-bg); 
        color: var(--btn-edit-text); 
        flex: 1; 
    }
    
    .form-delete-inline {
        margin: 0 !important;
        padding: 0 !important;
        display: flex !important;
        width: 36px;
    }

    .btn-card-delete { 
        background: var(--btn-delete-bg); 
        color: var(--btn-delete-text); 
        width: 100%;
        padding: 0;
    }

    /* Search Box Theme */
    .search-bakery {
        background: #ffffff;
        border-radius: 16px;
        padding: 6px 12px;
        border: 2px solid #efe8de;
        box-shadow: 0 4px 12px rgba(74, 53, 37, 0.03);
    }

    .search-bakery input {
        border: none;
        box-shadow: none !important;
        background: transparent;
        color: var(--bakery-mocha);
    }

    .btn-search-bakery {
        background: var(--bakery-mocha);
        color: white;
        border-radius: 12px;
        padding: 8px 24px;
        font-weight: 600;
        border: none;
        transition: background 0.2s;
    }

    .btn-search-bakery:hover {
        background: var(--bakery-caramel);
    }
</style>

<div class="page-wrapper">
    <div class="container-fluid px-4">
        
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert" style="background-color: #d1e7dd; color: #0f5132;">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert" style="background-color: #f8d7da; color: #842029;">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="hero-banner mb-4">
        <div class="hero-badge">
            🥐 Mini Bites Bakery
        </div>
        <h1 class="hero-title">Halaman Produk</h1>
        <p class="hero-subtitle">Kelola inventaris, harga jual, dan stok varian kue toko Anda.</p>
        
        <a href="{{ route('produk.create') }}" class="btn-hero-add">
            <i class="bi bi-plus-circle-fill"></i> Tambah Produk
        </a>

        <i class="bi bi-shop hero-watermark"></i>
    </div>

    <form action="{{ route('produk.index') }}" method="GET" class="mb-4">
        <div class="search-bakery d-flex align-items-center">
            <i class="bi bi-search text-muted me-2 ms-2"></i>
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama produk kue...">
            <button type="submit" class="btn btn-search-bakery">Cari</button>
        </div>
    </form>

    <div class="product-grid">
        @forelse($products as $product)
        <div class="product-card">
            
            <div class="card-img-wrapper">
                <span class="badge-stok">📦 {{ $product->stok ?? '0' }} pcs</span>
                <img src="{{ $product->foto ? asset('storage/' . $product->foto) : 'https://via.placeholder.com/300x200?text=No+Image' }}" alt="{{ $product->nama ?? $product->nama_produk ?? 'Kue' }}">
            </div>

            <div class="card-body-custom">
                
                <div class="product-title" title="{{ $product->nama ?? $product->nama_produk ?? 'Nama Kue Tidak Ada' }}">
                    {{ $product->nama ?? $product->nama_produk ?? 'Nama Produk Kue' }}
                </div>

                <div class="badge-user">
                    👤 {{ $product->user->name ?? 'Admin' }}
                </div>

                <div class="price-row">
                    <span class="price-label">Jual:</span>
                    <span class="price-sell">Rp {{ number_format($product->harga_jual ?? 0, 0, ',', '.') }}</span>
                </div>

                <div class="action-group">
                    <a href="{{ route('produk.show', $product) }}" class="btn-action-custom btn-card-detail">
                        👁️ Detail
                    </a>
                    
                    <a href="{{ route('produk.edit', $product) }}" class="btn-action-custom btn-card-edit">
                        ✏️ Edit
                    </a>

                    <form action="{{ route('produk.destroy', $product) }}" method="POST" class="form-delete-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action-custom btn-card-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus produk {{ $product->nama ?? $product->nama_produk }}?')" title="Hapus">
                            🗑️
                        </button>
                    </form>
                </div>

            </div>

        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">
            <i class="bi bi-box-seam fs-1 d-block mb-2" style="color: var(--bakery-caramel);"></i>
            Data produk tidak ditemukan.
        </div>
        @endforelse
    </div>

</div>

@endsection