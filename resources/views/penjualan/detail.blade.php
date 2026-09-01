@extends('layouts.app')

@section('title', 'Detail Penjualan - Sweet Crumbs Bakery')

@section('content')

@include('layouts.navbar')

<!-- Custom Bakery Theme Detail Styling -->
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
        min-height: 100vh;
        padding: 2.5rem 0 3.5rem 0;
    }

    /* Kartu Informasi Transaksi */
    .info-card {
        background: #ffffff;
        border: 1px solid #f0eae1;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(74, 53, 37, 0.05);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .info-header {
        background: linear-gradient(135deg, #4a3525 0%, #6f4e37 100%);
        color: white;
        padding: 1.8rem 2rem;
        position: relative;
    }

    .info-header h3 {
        font-weight: 700;
        margin: 0;
        font-family: serif;
    }

    .info-body {
        padding: 2rem;
    }

    /* Styling Tabel Produk */
    .table-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #f0eae1;
        box-shadow: 0 10px 30px rgba(74, 53, 37, 0.05);
        overflow: hidden;
        padding: 1.5rem;
    }

    .table {
        margin-bottom: 0;
        vertical-align: middle;
    }

    .table thead th {
        background-color: #f7f4ef;
        color: var(--bakery-mocha);
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        font-weight: 700;
        border-bottom: 1px solid #f0eae1;
        padding: 1rem;
        text-transform: uppercase;
    }

    .table td {
        padding: 1rem;
        color: var(--bakery-mocha);
        border-bottom: 1px solid #f7f4ef;
    }

    .product-img {
        width: 65px;
        height: 65px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid #f0eae1;
    }

    /* Tombol Kembali & Cetak */
    .btn-back {
        background: #ffffff;
        color: #4a3525;
        font-weight: 600;
        border-radius: 12px;
        padding: 0.65rem 1.5rem;
        border: 1px solid #e8e3dc;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 2px 8px rgba(74, 53, 37, 0.03);
    }

    .btn-back:hover {
        background: #f7f4ef;
        color: #6f4e37;
        transform: translateY(-2px);
    }

    /* CSS Khusus Mode Print Printer Kasir/Struk */
    @media print {
        body * {
            visibility: hidden;
        }
        .d-print-none {
            display: none !important;
        }
        .receipt-print-area, .receipt-print-area * {
            visibility: visible;
        }
        .receipt-print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            box-shadow: none !important;
            border: none !important;
        }
    }
</style>

<div class="page-wrapper">
    <div class="container">
        
        <!-- Tombol Navigasi & Cetak Struk (Sembunyi saat diprint) -->
        <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
            <a href="{{ route('penjualan.index') }}" class="btn-back">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar Penjualan
            </a>
            <button onclick="window.print()" class="btn text-white fw-bold shadow-sm" style="background-color: var(--bakery-green); border-radius: 12px; padding: 0.65rem 1.5rem;">
                <i class="bi bi-printer me-2"></i> Cetak Struk
            </button>
        </div>

        <!-- Kartu Informasi Utama -->
        <div class="info-card d-print-none">
            <div class="info-header d-flex justify-content-between align-items-center">
                <h3><i class="bi bi-receipt me-2"></i> Detail Transaksi Penjualan</h3>
                <span class="badge bg-white px-3 py-2 rounded-pill shadow-sm fw-bold" style="color: #4a3525;">
                    ID: #{{ $sale->id }}
                </span>
            </div>
            <div class="info-body">
                <div class="row g-4 align-items-center">
                    <div class="col-md-3">
                        <span class="text-muted small d-block mb-1">Kasir Bertugas</span>
                        <h6 class="fw-bold mb-0" style="color: #4a3525;">
                            <i class="bi bi-person-circle me-1" style="color: #d4a373;"></i> {{ optional($sale->user)->name ?? 'Kasir Toko' }}
                        </h6>
                    </div>
                    <div class="col-md-3">
                        <span class="text-muted small d-block mb-1">Waktu Transaksi</span>
                        <h6 class="fw-semibold text-secondary mb-0">
                            <i class="bi bi-clock me-1"></i> {{ optional($sale->created_at)->translatedFormat('d M Y, H:i') }}
                        </h6>
                    </div>
                    <div class="col-md-3">
                        <span class="text-muted small d-block mb-1">Metode Pembayaran</span>
                        <span class="badge bg-light text-secondary border px-3 py-1.5 fw-semibold">
                            {{ $sale->metode_pembayaran ?? 'CASH' }}
                        </span>
                    </div>
                    <div class="col-md-3 text-md-end">
                        <span class="text-muted small d-block mb-1">Total Pembayaran</span>
                        <h4 class="fw-bold mb-0" style="color: #606c38;">
                            Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar Produk (Tampilan Layar Web) -->
        <div class="table-card d-print-none">
            <h5 class="fw-bold mb-4 px-2" style="color: #4a3525; font-family: serif;">
                <i class="bi bi-basket me-2" style="color: #d4a373;"></i> Produk Roti yang Dibeli
            </h5>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th scope="col" width="5%" class="text-center">No</th>
                            <th scope="col" width="12%">Foto</th>
                            <th scope="col" width="43%">Nama Produk</th>
                            <th scope="col" width="15%" class="text-center">Kuantitas (Qty)</th>
                            <th scope="col" width="25%" class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @forelse($sale->itemPenjualan as $item)
                        <tr>
                            <td class="text-center fw-semibold text-muted">{{ $i++ }}</td>
                            <td>
                                @if(optional($item->produk)->foto)
                                    <img src="{{ asset('storage/'.$item->produk->foto) }}" class="product-img shadow-sm" alt="Foto Roti">
                                @else
                                    <div class="product-img bg-light d-flex align-items-center justify-content-center text-muted rounded-3 shadow-sm">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="fw-bold d-block" style="color: #4a3525;">{{ optional($item->produk)->nama ?? 'Produk' }}</span>
                                <small class="text-muted">Harga: Rp {{ number_format($item->produk->harga_jual ?? 0, 0, ',', '.') }}</small>
                            </td>
                            <td class="text-center fw-semibold">
                                <span class="badge bg-light text-dark border px-3 py-1">{{ $item->kuantitas }}</span>
                            </td>
                            <td class="text-end">
                                <span class="fw-bold" style="color: #606c38;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2 text-warning"></i>
                                Tidak ada data item produk pada transaksi ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- AREA STRUK THERMAL (Khusus Untuk Dicetak Printer Kasir) -->
        <div class="receipt-print-area d-none d-print-block mx-auto" style="max-width: 350px; font-family: 'Courier New', Courier, monospace; color: #000;">
            <div class="text-center mb-3">
                <h4 class="fw-bold mb-0">Sweet Crumbs Bakery</h4>
                <p class="small mb-0">Jl. Roti Lezat No. 88, Bandung</p>
                <p class="small mb-0">Telp: 0812-3456-7890</p>
                <p class="mb-0">--------------------------------</p>
            </div>

            <div class="small mb-2">
                <div>No Nota : #{{ $sale->id }}</div>
                <div>Tanggal : {{ optional($sale->created_at)->format('d/m/Y H:i') }}</div>
                <div>Kasir   : {{ optional($sale->user)->name ?? 'Kasir' }}</div>
                <div>Bayar   : {{ $sale->metode_pembayaran ?? 'CASH' }}</div>
            </div>

            <p class="mb-1">--------------------------------</p>

            <table style="width: 100%; font-size: 13px;">
                @foreach($sale->itemPenjualan as $item)
                <tr>
                    <td colspan="3" class="fw-bold">{{ optional($item->produk)->nama ?? 'Produk' }}</td>
                </tr>
                <tr>
                    <td>{{ $item->kuantitas }} x Rp {{ number_format($item->produk->harga_jual ?? 0, 0, ',', '.') }}</td>
                    <td class="text-end" style="text-align: right;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </table>

            <p class="mb-1">--------------------------------</p>

            <div class="d-flex justify-content-between fw-bold fs-6" style="display: flex; justify-content-space-between;">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($sale->total_pembayaran, 0, ',', '.') }}</span>
            </div>

            <p class="mb-2">--------------------------------</p>

            <div class="text-center small">
                <p class="mb-0">Terima Kasih Telah Berbelanja!</p>
                <p class="mb-0">Nikmati Kelezatan Roti Kami 🍞</p>
            </div>
        </div>

    </div>
</div>

@endsection