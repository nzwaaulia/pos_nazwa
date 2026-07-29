@extends('layouts.app')

@section('title', 'Manajemen Produk - Toko Kue')

@section('content')

@include('layouts.navbar')

<!-- Custom Unique & Trendy Styling for Bakery Theme (Mocha, Cream, & Warm Rose) -->
<style>
    .page-wrapper {
        background-color: #fdfbf7; /* Warm Cream background */
        min-height: 100vh;
        padding: 2.5rem 0;
    }
    .hero-banner-unique {
        background: linear-gradient(135deg, #4a3525 0%, #6f4e37 100%); /* Rich Mocha Gradient */
        border-radius: 20px;
        color: #fdfbf7;
        box-shadow: 0 12px 30px rgba(111, 78, 55, 0.2);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(212, 163, 115, 0.2);
    }
    .hero-banner-unique::after {
        content: '🍰';
        position: absolute;
        right: -10px;
        bottom: -20px;
        font-size: 8rem;
        opacity: 0.08;
    }
    .custom-container-card {
        border: 1px solid #f0eae1;
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(74, 53, 37, 0.03);
        background: #ffffff;
        overflow: hidden;
    }
    .search-input-group {
        background: #fff;
        border-radius: 12px;
        border: 2px solid #f0eae1;
        transition: all 0.3s ease;
    }
    .search-input-group:focus-within {
        border-color: #c89666;
        box-shadow: 0 0 0 4px rgba(200, 150, 102, 0.12);
    }
    .table-unique thead {
        background: #4a3525; /* Deep Mocha */
        color: #fdfbf7;
    }
    .table-unique thead th {
        border: none;
        font-weight: 500;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-size: 0.75rem;
        padding: 1.1rem 1rem;
    }
    .product-thumbnail {
        width: 65px;
        height: 65px;
        object-fit: cover;
        border-radius: 14px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.06);
        border: 2px solid #fdfbf7;
    }
    .pill-buy {
        background-color: #f7f4ef;
        color: #7f6e61;
        padding: 5px 10px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.8rem;
    }
    .pill-sell {
        background-color: #faedcd; /* Soft Butter Cream */
        color: #6b4c1b;
        padding: 5px 10px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        border: 1px solid #e9d8a6;
    }
    .pill-stock {
        background: linear-gradient(135deg, #d4a373 0%, #bc6c25 100%);
        color: white;
        padding: 5px 12px;
        border-radius: 10px;
        font-weight: 500;
        font-size: 0.85rem;
    }
    .btn-create-unique {
        background: #fdfbf7;
        color: #4a3525;
        font-weight: 600;
        border-radius: 12px;
        padding: 0.7rem 1.6rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border: 1px solid #e2d9cc;
    }
    .btn-create-unique:hover {
        background: #c89666;
        color: #ffffff;
        border-color: #c89666;
        transform: translateY(-2px);
    }
    .action-btn-detail {
        background-color: #f4f1ea;
        color: #5c4d3c;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        padding: 0.4rem 0.8rem;
        transition: all 0.2s;
    }
    .action-btn-detail:hover {
        background-color: #5c4d3c;
        color: white;
    }
    .action-btn-edit {
        background-color: #fefae0;
        color: #b5838d;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        padding: 0.4rem 0.8rem;
        transition: all 0.2s;
    }
    .action-btn-edit:hover {
        background-color: #b5838d;
        color: white;
    }
    .action-btn-delete {
        background-color: #fdf0ed;
        color: #e07a5f;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        padding: 0.4rem 0.8rem;
        transition: all 0.2s;
    }
    .action-btn-delete:hover {
        background-color: #e07a5f;
        color: white;
    }
</style>

<div class="page-wrapper">
    <div class="container">
        
        <!-- Hero Banner -->
        <div class="hero-banner-unique p-4 p-md-5 mb-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div>
                <span class="badge bg-white text-dark px-3 py-1 rounded-pill fw-bold mb-2 shadow-sm" style="color: #6f4e37 !important;">
                    🥐  Mini Bites Bakery 
                </span>
                <h1 class="display-6 fw-bold mb-1" style="font-family: serif;">Manajemen Katalog Kue</h1>
                <p class="text-white-50 mb-0">Kelola kreasi kue lezat, perbarui harga, dan pantau stok harian butik Anda.</p>
            </div>
            <div class="mt-4 mt-md-0">
                @can('create', App\Models\Produk::class)
                <a href="{{ route('produk.create') }}" class="btn btn-create-unique">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Kue Baru
                </a>
                @endcan
            </div>
        </div>

        <!-- Search Bar Card -->
        <div class="custom-container-card p-3 mb-4">
            <form action="{{ route('produk.index') }}" method="GET">
                <div class="input-group search-input-group px-2 py-1">
                    <span class="input-group-text bg-transparent border-0 text-muted ps-2">
                        <i class="bi bi-search fs-5" style="color: #c89666;"></i>
                    </span>
                    <input 
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control border-0 bg-transparent shadow-none px-2"
                        placeholder="Cari nama kue atau menu spesial..."
                    >
                    <button class="btn px-4 fw-semibold rounded-pill my-1 text-white" type="submit" style="background-color: #6f4e37;">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('produk.index') }}" class="btn btn-link text-muted text-decoration-none ms-2">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table Card -->
        <div class="custom-container-card">
            <div class="table-responsive">
                <table class="table table-unique table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col" class="ps-4">No</th>
                            <th scope="col">Pencatat</th>
                            <th scope="col">Foto Kue</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Harga Modal</th>
                            <th scope="col">Harga Jual</th>
                            <th scope="col">Stok Tersedia</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                            <th scope="row" class="ps-4 text-muted">{{ $products->firstItem() + $loop->index }}</th>
                            <td>
                                <span class="fw-semibold text-dark"><i class="bi bi-person-heart text-muted me-1"></i> {{ $product->user->name }}</span>
                            </td>
                            <td>
                                <img src="{{ asset('storage/'.$product->foto) }}" class="product-thumbnail" alt="{{ $product->nama }}">
                            </td>
                            <td>
                                <span class="fw-bold text-dark fs-6" style="font-family: serif;">{{ $product->nama }}</span>
                            </td>
                            <td>
                                <span class="pill-buy">Rp {{ number_format($product->harga_beli, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <span class="pill-sell">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <span class="pill-stock">{{ $product->stok }} PCS</span>
                            </td>
                            <td class="text-center">
                                <div class="d-inline-flex gap-2 align-items-center justify-content-center">
                                    <a href="{{ route('produk.show', $product) }}" class="action-btn-detail btn-sm">Detail</a>
                                    
                                    @can('update', $product)
                                    <a href="{{ route('produk.edit', $product) }}" class="action-btn-edit btn-sm">Ubah</a>
                                    @endcan
                                    
                                    @can('delete', $product)
                                    <form action="{{ route('produk.destroy', $product) }}" method="POST" class="d-inline m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn-delete btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus kue ini dari katalog?')">
                                            Hapus
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="text-muted py-4">
                                    <i class="bi bi-cup-hot display-4 d-block mb-3" style="color: #c89666;"></i>
                                    <h5 class="fw-bold text-secondary" style="font-family: serif;">Belum ada menu kue di etalase.</h5>
                                    <p class="text-muted small mb-0">Silakan tambahkan produk baru atau periksa kembali kata kunci pencarian Anda.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            <div class="card-footer bg-white border-0 py-4 px-4">
                <div class="d-flex justify-content-center justify-content-md-end">
                    {{ $products->withQueryString()->links() }}
                </div>
            </div>
        </div>

    </div>
</div>

@endsection