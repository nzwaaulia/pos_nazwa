<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LaporanPenjualanService;
use App\Services\MonitoringStokService;
use App\Models\Penjualan; // pastikan nama model penjualan/transaksi Anda sesuai
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function __construct(
        protected LaporanPenjualanService $laporanService,
        protected MonitoringStokService $stokService
    ) {}

    public function index()
    {
        $ringkasan = $this->laporanService->ringkasanHariIni();

        // Ambil riwayat penjualan terbaru beserta relasi user & itemnya
        $recentSales = Penjualan::with(['user', 'itemPenjualan.produk'])
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard', [
            'tanggalHariIni'   => Carbon::now(),
            'ringkasan'        => $ringkasan,
            'recentSales'      => $recentSales, // <-- Variabel dikirim ke Blade
            'produkTerlaris'   => $this->laporanService->produkTerlarisHariIni(),
            'produkStokRendah' => $this->stokService->produkStokRendah(),
            'produkStokHabis'  => $this->stokService->produkStokHabis(),
        ]);
    }
}