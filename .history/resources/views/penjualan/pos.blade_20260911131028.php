@extends('layouts.app')

@section('title', 'POS Kasir - Sweet Crumbs Bakery')

@section('content')

@include('layouts.navbar')

<!-- Custom Bakery Theme POS Styling -->
<style>
    :root {
        --bakery-mocha: #4a3525;
        --bakery-caramel: #6f4e37;
        --bakery-cream: #fdfbf7;
        --bakery-accent: #d4a373;
        --bakery-green: #606c38;
    }

    body {
        background-color: var(--bakery-cream);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .page-wrapper {
        padding: 2.5rem 0 3.5rem 0;
        min-height: 100vh;
    }

    .pos-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #f0eae1;
        box-shadow: 0 10px 30px rgba(74, 53, 37, 0.05);
    }

    .product-card {
        border: 1px solid #f4f1ea !important;
        border-radius: 16px;
        background: #ffffff;
        transition: all 0.25s ease;
    }

    .product-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(74, 53, 37, 0.08) !important;
        border-color: var(--bakery-accent) !important;
    }

    .search-input-group {
        border-radius: 14px;
        border: 2px solid #f0eae1;
        background-color: #fcfbfa;
        overflow: hidden;
    }

    .search-input-group input {
        border: none;
        background: transparent;
        color: var(--bakery-mocha);
    }

    .search-input-group input:focus {
        box-shadow: none;
        background: transparent;
    }

    .btn-add-product {
        background: #f7f4ef;
        color: var(--bakery-caramel);
        border: 1px solid #e8e3dc;
        font-weight: 600;
        border-radius: 10px;
        transition: all 0.2s;
    }

    .btn-add-product:hover {
        background: var(--bakery-caramel);
        color: white;
        border-color: var(--bakery-caramel);
    }

    .btn-checkout {
        background: linear-gradient(135deg, #606c38 0%, #283618 100%);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(96, 108, 56, 0.2);
        transition: all 0.3s ease;
    }

    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(96, 108, 56, 0.35);
        color: white;
    }

    .table thead th {
        background: #f7f4ef;
        color: var(--bakery-mocha);
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #f0eae1;
    }

    .hover-danger:hover {
        background-color: #fdf2f2 !important;
    }
</style>

<div class="page-wrapper">
    <div class="container">

        @if(session('errors'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-4 border-0 mb-4" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i> {{ session('errors') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Header Title -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <span class="badge bg-white px-3 py-1 rounded-pill fw-bold mb-2 shadow-sm" style="color: #4a3525 !important;">
                    🥖 Mini Bites Bakery
                </span>
                <h2 class="fw-bold mb-0" style="font-family: serif; color: #4a3525;">Kasir & Penjualan Roti</h2>
                <p class="text-muted small mb-0">Kelola transaksi pesanan kue pelanggan dengan cepat dan efisien.</p>
            </div>
            <div class="badge px-3 py-2 fs-6 shadow-sm rounded-pill {{ optional($sale)->status === 'COMPLETED' ? 'bg-success text-white' : 'bg-warning text-dark' }}">
                Status: {{ optional($sale)->status ?? 'DRAFT' }}
            </div>
        </div>

        <div class="row g-4">

            <!-- ====================== DAFTAR PRODUK KUE (KIRI) ============================ -->
            <div class="col-lg-7">
                <div class="pos-card p-4 h-100">
                    
                    <!-- Form Pencarian Produk -->
                    <div class="mb-4">
                        <form method="GET" action="{{ route('penjualan.create') }}">
                            <div class="input-group search-input-group shadow-sm">
                                <span class="input-group-text bg-white border-0 text-muted ps-3">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text"
                                       name="search"
                                       value="{{ request('search') }}"
                                       class="form-control ps-2"
                                       placeholder="Cari varian kue atau pastry..."
                                       onkeyup="this.form.submit()">
                            </div>
                        </form>
                    </div>

                    <!-- Grid Produk Kue -->
                    <div class="product-list-container" style="max-height: 60vh; overflow-y: auto; padding-right: 5px;">
                        <div class="row g-3">
                            @foreach($products as $product)
                            <div class="col-md-6">
                                <form method="POST" action="{{ route('itempenjualan.store') }}" class="card product-card h-100">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    
                                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            @if($product->foto ?? $product->gambar)
                                                <img src="{{ asset('storage/'.($product->foto ?? $product->gambar)) }}"
                                                     alt="{{ $product->nama }}"
                                                     class="rounded-3 shadow-sm"
                                                     style="width: 55px; height: 55px; object-fit: cover;">
                                            @else
                                                <div class="rounded-3 bg-light d-flex align-items-center justify-content-center text-muted" style="width: 55px; height: 55px;">
                                                    <i class="bi bi-image"></i>
                                                </div>
                                            @endif
                                            
                                            <div class="overflow-hidden">
                                                <h6 class="fw-semibold text-truncate mb-1" style="color: #4a3525;" title="{{ $product->nama }}">{{ $product->nama }}</h6>
                                                <span class="fw-bold" style="color: #606c38;">Rp {{ number_format($product->harga_jual ?? $product->harga, 0, ',', '.') }}</span>
                                            </div>
                                        </div>

                                        <div class="d-flex gap-2">
                                            <input type="number" name="quantity" value="1" min="1"
                                                   class="form-control form-control-sm text-center fw-bold {{ optional($sale)->status === 'COMPLETED' ? 'bg-light' : '' }}"
                                                   style="width: 70px; border-radius: 10px;"
                                                   {{ optional($sale)->status === 'COMPLETED' ? 'readonly' : '' }}>
                                            
                                            <button type="submit" class="btn btn-add-product btn-sm w-100 {{ optional($sale)->status === 'COMPLETED' ? 'disabled' : '' }}">
                                                <i class="bi bi-plus-lg me-1"></i> Tambah
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>

            <!-- ================================ KERANJANG BELANJA (KANAN) =========================== -->
            <div class="col-lg-5">
                <div class="pos-card h-100 d-flex flex-column">
                    <div class="card-header bg-white border-0 py-3 px-4 border-bottom">
                        <h5 class="fw-bold mb-0" style="color: #4a3525; font-family: serif;">
                            <i class="bi bi-basket me-2" style="color: #d4a373;"></i> Keranjang Belanja Kue
                        </h5>
                    </div>

                    <div class="card-body p-0 flex-grow-1" style="max-height: 42vh; overflow-y: auto;">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Produk</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($sale) && $sale && $sale->itemPenjualan)
                                    @forelse($sale->itemPenjualan as $item)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-semibold" style="color: #4a3525;">{{ $item->produk->nama }}</div>
                                            <small class="text-muted">Rp {{ number_format($item->produk->harga_jual ?? $item->produk->harga, 0, ',', '.') }}</small>
                                        </td>
                                        <td style="width: 80px;">
                                            <form method="POST" action="{{ route('itempenjualan.update', $item->id) }}">
                                                @csrf @method('PUT')
                                                <input type="number" name="quantity"
                                                       value="{{ $item->kuantitas }}"
                                                       min="1"
                                                       class="form-control form-control-sm text-center fw-bold"
                                                       style="border-radius: 8px;"
                                                       onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <td class="fw-semibold text-success">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                        <td class="text-end pe-4">
                                            <!-- Tombol Aksi Hapus yang sudah dibenarkan -->
                                            <form method="POST" action="{{ route('itempenjualan.destroy', $item->id) }}" class="d-inline" onsubmit="return confirm('Hapus item ini dari keranjang?')">
                                                @csrf 
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-light btn-sm text-danger border-0 hover-danger rounded-circle" title="Hapus Item">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="bi bi-cart-x fs-1 d-block mb-2 text-warning"></i>
                                            <p class="mb-0 small">Keranjang belanja kue masih kosong.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="bi bi-cart-x fs-1 d-block mb-2 text-warning"></i>
                                            <p class="mb-0 small">Keranjang belanja kue masih kosong.</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer / Total & Checkout -->
                    <div class="card-footer bg-light border-top border-light p-4 rounded-bottom-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted fw-medium">Total Pembayaran:</span>
                            <h3 class="fw-bold mb-0" style="color: #606c38;">Rp {{ number_format(optional($sale)->total_pembayaran ?? 0, 0, ',', '.') }}</h3>
                        </div>

                        @if(isset($sale) && $sale)
                        <form method="POST" 
                              action="{{ route('penjualan.update', $sale->id) }}"
                              onsubmit="return confirm('Yakin ingin melanjutkan proses checkout pesanan kue?')" class="mb-2">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <select name="payment_method" class="form-select shadow-sm" required style="border-radius: 12px; border: 2px solid #f0eae1;">
                                    <option value="">-- Pilih Metode Pembayaran --</option>
                                    <option value="CASH">Cash (Tunai)</option>
                                    <option value="QRIS">QRIS</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-checkout w-100 py-2.5 fw-semibold {{ optional($sale)->status === 'COMPLETED' ? 'disabled' : '' }}">
                                <i class="bi bi-check-circle me-2"></i> Checkout Transaksi
                            </button>
                        </form>

                        @can('delete', $sale)
                        <form action="{{ route('penjualan.destroy', $sale->id) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin ingin membatalkan seluruh transaksi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100 py-2 fw-semibold border-0 text-danger" style="background: #fdf2f2; border-radius: 12px;">
                                <i class="bi bi-x-circle me-2"></i> Batal Transaksi
                            </button>
                        </form>
                        @endcan
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection