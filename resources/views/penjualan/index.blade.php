@extends('layouts.app')

@section('title', 'Penjualan - Sweet Crumbs Bakery')

@section('content')

@include('layouts.navbar')

<!-- Custom Bakery Theme Penjualan Styling -->
<style>
    :root {
        --bakery-mocha: #4a3525;
        --bakery-caramel: #6f4e37;
        --bakery-cream: #fdfbf7;
        --bakery-accent: #d4a373;
    }

    body {
        background-color: var(--bakery-cream);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .page-wrapper {
        padding: 2.5rem 0 3.5rem 0;
        min-height: 100vh;
    }

    .hero-penjualan {
        background: linear-gradient(135deg, #4a3525 0%, #6f4e37 100%); /* Rich Mocha Gradient */
        border-radius: 20px;
        padding: 2.5rem;
        color: white;
        box-shadow: 0 10px 25px rgba(74, 53, 37, 0.15);
        border: 1px solid rgba(212, 163, 115, 0.2);
        position: relative;
        overflow: hidden;
    }

    .hero-penjualan::before {
        content: '🥐';
        position: absolute;
        top: -10px;
        right: 20px;
        font-size: 7rem;
        opacity: 0.08;
    }

    .custom-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(74, 53, 37, 0.05);
        border: 1px solid #f0eae1;
        overflow: hidden;
    }

    .btn-create {
        background: #ffffff;
        color: #4a3525;
        border-radius: 12px;
        padding: 0.75rem 1.8rem;
        font-weight: 700;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        text-decoration: none;
        display: inline-block;
    }

    .btn-create:hover {
        background: #f7f4ef;
        color: #6f4e37;
        transform: translateY(-2px);
    }

    .search-box {
        border-radius: 14px;
        border: 2px solid #f0eae1;
        padding: 6px;
        background-color: #fcfbfa;
    }

    .search-box input {
        border: none;
        height: 42px;
        background: transparent;
        color: #4a3525;
    }

    .search-box input:focus {
        box-shadow: none;
        background: transparent;
    }

    .table thead {
        background: #4a3525;
        color: white;
    }

    .table thead th {
        padding: 16px;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
    }

    .table tbody tr {
        transition: background 0.2s;
    }

    .table tbody tr:hover {
        background: #f7f4ef;
    }

    .total-price {
        color: #606c38; /* Soft Olive Green */
        font-weight: 700;
    }

    .status {
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .status-selesai {
        background: #f4f7ed;
        color: #606c38;
    }

    .status-proses {
        background: #fdf6ec;
        color: #bc6c25;
    }

    .status-batal {
        background: #fdf2f2;
        color: #bc4749;
    }

    .btn-action {
        border: none;
        border-radius: 10px;
        padding: 6px 14px;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: transform 0.2s;
    }

    .btn-action:hover {
        transform: translateY(-1px);
    }

    .btn-detail {
        background: #f4f1ea;
        color: #6f4e37;
    }

    .btn-edit {
        background: #fdf6ec;
        color: #bc6c25;
    }

    .btn-delete {
        background: #fdf2f2;
        color: #bc4749;
    }
</style>

<div class="page-wrapper">
    <div class="container">

        @if(session('errors'))
        <div class="alert alert-danger rounded-4 border-0 shadow-sm">
            {{ session('errors') }}
        </div>
        @endif

        <!-- Hero Section -->
        <div class="hero-penjualan mb-4">
            <span class="badge bg-white px-3 py-1 rounded-pill fw-bold mb-2 shadow-sm" style="color: #4a3525 !important;">
                💰 Transaksi Kasir
            </span>
            <h1 class="fw-bold mb-1" style="font-family: serif;">Halaman Penjualan</h1>
            <p class="mb-4 text-white-50 small">
                Kelola transaksi, pembayaran pesanan kue, dan aktivitas kasir toko dengan mudah.
            </p>

            <a href="{{ route('penjualan.create') }}" class="btn btn-create">
                <i class="bi bi-plus-circle me-1"></i> Tambah Penjualan
            </a>
        </div>

        <!-- Main Card List -->
        <div class="custom-card">

            <div class="p-4 border-bottom border-light">
                <form action="{{ route('penjualan.index') }}" method="GET">
                    <div class="search-box d-flex align-items-center">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               class="form-control"
                               placeholder="Cari transaksi berdasarkan ID atau kasir...">

                        <button class="btn rounded-pill px-4 text-white fw-bold" style="background-color: #4a3525;">
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kasir</th>
                            <th>Total</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($sales as $sale)
                        <tr>
                            <td class="ps-4">{{ $sales->firstItem() + $loop->index }}</td>

                            <td class="text-muted small">
                                {{ $sale->created_at->translatedFormat('d M Y H:i') }}
                            </td>

                            <td class="fw-semibold" style="color: #4a3525;">
                                {{ $sale->user->name }}
                            </td>

                            <td>
                                <span class="total-price">
                                    Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-light text-secondary border px-2 py-1">
                                    {{ $sale->metode_pembayaran }}
                                </span>
                            </td>

                            <td>
                                @if(strtolower($sale->status) == 'selesai')
                                    <span class="status status-selesai">{{ $sale->status }}</span>
                                @elseif(strtolower($sale->status) == 'proses')
                                    <span class="status status-proses">{{ $sale->status }}</span>
                                @else
                                    <span class="status status-batal">{{ $sale->status }}</span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('penjualan.show', $sale) }}" class="btn-action btn-detail">
                                        Detail
                                    </a>

                                    @can('view', $sale)
                                    <a href="{{ route('penjualan.edit', $sale) }}" class="btn-action btn-edit">
                                        Edit
                                    </a>
                                    @endcan

                                    @can('delete', $sale)
                                    <form action="{{ route('penjualan.destroy', $sale) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-action btn-delete" onclick="return confirm('Yakin ingin menghapus data transaksi ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2 text-warning"></i>
                                Data transaksi penjualan tidak ditemukan.
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            <div class="p-4 border-top border-light">
                {{ $sales->links() }}
            </div>

        </div>

    </div>
</div>

@endsection