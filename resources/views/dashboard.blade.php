@extends('layouts.app')

@section('title', 'Dashboard - Sweet Crumbs Bakery')

@section('content')

@include('layouts.navbar')

<!-- Custom Bakery Theme Dashboard Styling -->
<style>
    .dashboard-wrapper {
        background-color: #fdfbf7 !important; /* Warm Cream Background */
        min-height: 100vh;
        padding: 1.5rem 0 2.5rem 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .hero-banner-vibrant {
        background: linear-gradient(135deg, #4a3525 0%, #6f4e37 100%); /* Rich Mocha Gradient */
        border-radius: 24px;
        color: #ffffff;
        padding: 2.8rem;
        box-shadow: 0 15px 35px rgba(74, 53, 37, 0.15);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(212, 163, 115, 0.2);
    }
    .hero-banner-vibrant::before {
        content: '🍰';
        position: absolute;
        top: -10px;
        right: 20px;
        font-size: 8rem;
        opacity: 0.08;
    }
    .stat-card-purple {
        background: linear-gradient(135deg, #5c4d3c 0%, #7f6e61 100%); /* Warm Taupe/Mocha */
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(92, 77, 60, 0.15);
        color: #fff;
    }
    .stat-card-teal {
        background: linear-gradient(135deg, #8c6d53 0%, #b08968 100%); /* Caramel & Bronze */
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(140, 109, 83, 0.15);
        color: #fff;
    }
    .card-vibrant {
        background: #ffffff;
        border: 1px solid #f0eae1;
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(74, 53, 37, 0.03);
        transition: transform 0.3s ease;
    }
    .card-vibrant:hover {
        transform: translateY(-4px);
    }
    .section-title {
        font-weight: 700;
        color: #4a3525;
        font-size: 1.3rem;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-family: serif;
    }
    .table-vibrant thead th {
        background-color: #f7f4ef;
        color: #6f4e37;
        font-weight: 600;
        border: none;
        padding: 1rem;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.8px;
    }
    .table-vibrant tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f4f1ea;
    }
    .badge-pill-warning {
        background: linear-gradient(135deg, #d4a373 0%, #bc6c25 100%);
        color: white;
        padding: 6px 14px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.8rem;
    }
    .badge-pill-danger {
        background: linear-gradient(135deg, #e07a5f 0%, #b5838d 100%);
        color: white;
        padding: 6px 14px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.8rem;
    }
    .badge-pill-success {
        background: linear-gradient(135deg, #606c38 0%, #283618 100%);
        color: white;
        padding: 6px 14px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.8rem;
    }
</style>
<div class="dashboard-wrapper">

    <div class="container-fluid px-4">

        <!-- Hero Banner -->
        <div class="hero-banner-vibrant mb-5">
            <span class="badge bg-white text-dark px-3 py-1 rounded-pill fw-bold mb-2 shadow-sm" style="color: #4a3525 !important;">
                🥐 Mini Bites Bakery
            </span>
            <h1 class="display-6 fw-bold mb-2" style="font-family: serif;">Mini Bites Bakery</h1>
            <p class="text-white-50 fs-5 mb-0">
                <i class="bi bi-calendar-check me-2"></i> Ringkasan Hari Ini: <b>{{ $tanggalHariIni->translatedFormat('l, d F Y') }}</b>
            </p>
        </div>

        @can('__viewAny', App\Models\User::class)
        <!-- Statistik Penjualan -->
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="card stat-card-purple p-2">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0 fw-semibold opacity-75">Total Penjualan Hari Ini</h5>
                            <div class="bg-white bg-opacity-25 p-3 rounded-4">
                                <i class="bi bi-cash-coin fs-3"></i>
                            </div>
                        </div>
                        <h2 class="fw-bold display-6 mb-0">
                            Rp {{ number_format($ringkasan['total_penjualan'], 0, ',', '.') }}
                        </h2>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card stat-card-teal p-2">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0 fw-semibold opacity-75">Jumlah Transaksi</h5>
                            <div class="bg-white bg-opacity-25 p-3 rounded-4">
                                <i class="bi bi-bag-check fs-3"></i>
                            </div>
                        </div>
                        <h2 class="fw-bold display-6 mb-0">
                            {{ number_format($ringkasan['total_transaksi'], 0, ',', '.') }} Transaksi
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Pembayaran -->
        <h3 class="section-title">
            <i class="bi bi-credit-card-2-back" style="color: #c89666;"></i> Status Pembayaran
        </h3>
        
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="card card-vibrant h-100">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 text-success p-3 rounded-4 me-3">
                            <i class="bi bi-wallet2 fs-3"></i>
                        </div>
                        <div>
                            <span class="text-muted d-block small fw-bold text-uppercase">Pembayaran Tunai</span>
                            <h3 class="fw-bold mb-0" style="color: #606c38;">
                                Rp {{ number_format($ringkasan['total_cash'], 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-vibrant h-100">
                    <div class="card-body p-4 d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-4 me-3">
                            <i class="bi bi-credit-card fs-3"></i>
                        </div>
                        <div>
                            <span class="text-muted d-block small fw-bold text-uppercase">Pembayaran Non Tunai</span>
                            <h3 class="fw-bold mb-0" style="color: #6f4e37;">
                                Rp {{ number_format($ringkasan['total_non_tunai'], 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        <!-- Inventory Status -->
        <h3 class="section-title">
            <i class="bi bi-boxes" style="color: #d4a373;"></i> Status Inventory
        </h3>

        <div class="row g-4 mb-5">
            <!-- Stok Hampir Habis -->
            <div class="col-md-6">
                <div class="card card-vibrant h-100">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold mb-0" style="color: #bc6c25;"><i class="bi bi-exclamation-circle me-2"></i> Stok Hampir Habis</h5>
                    </div>
                    <div class="card-body px-4">
                        <div class="table-responsive">
                            <table class="table table-vibrant align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-3">No</th>
                                        <th>Nama Produk</th>
                                        <th class="text-center">Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($produkStokRendah as $index => $produk)
                                    <tr>
                                        <td class="ps-3 fw-bold text-muted">{{ $produkStokRendah->firstItem() + $index }}</td>
                                        <td class="fw-bold text-dark">{{ $produk->nama }}</td>
                                        <td class="text-center">
                                            <span class="badge-pill-warning">{{ $produk->stok }} pcs</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            Semua stok kue aman 🥐
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $produkStokRendah->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Produk Habis -->
            <div class="col-md-6">
                <div class="card card-vibrant h-100">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold mb-0" style="color: #e07a5f;"><i class="bi bi-dash-circle me-2"></i> Produk Habis</h5>
                    </div>
                    <div class="card-body px-4">
                        <div class="table-responsive">
                            <table class="table table-vibrant align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-3">No</th>
                                        <th>Nama Produk</th>
                                        <th class="text-center">Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($produkStokHabis as $index => $produk)
                                    <tr>
                                        <td class="ps-3 fw-bold text-muted">{{ $produkStokHabis->firstItem() + $index }}</td>
                                        <td class="fw-bold text-dark">{{ $produk->nama }}</td>
                                        <td class="text-center">
                                            <span class="badge-pill-danger">{{ $produk->stok }} pcs</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            Tidak ada produk kue yang habis 🍰
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $produkStokHabis->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Best Seller -->
        <div class="card card-vibrant">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold text-dark mb-0" style="font-family: serif;"><i class="bi bi-star-fill text-warning me-2"></i> Produk Terlaris</h5>
            </div>
            <div class="card-body px-4 pb-4">
                <div class="table-responsive">
                    <table class="table table-vibrant align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-3">Nama Produk</th>
                                <th>Stok Tersisa</th>
                                <th class="text-center">Total Terjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($produkTerlaris as $produk)
                            <tr>
                                <td class="ps-3 fw-bold text-dark">{{ $produk->nama }}</td>
                                <td class="text-muted">{{ $produk->stok }} pcs</td>
                                <td class="text-center">
                                    <span class="badge-pill-success">{{ $produk->total_terjual }} terjual</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    Belum ada data penjualan roti hari ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection