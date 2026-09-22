<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $user = Auth::user();
        $keyword = $request->input('search');

        $sales = Penjualan::query()
            ->when(optional($user->role)->name === 'kasir' || $user->role === 'kasir', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->when($keyword, function ($query) use ($keyword) {
                $query->whereHas('user', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('penjualan.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource (Halaman POS).
     */
    public function create(SearchRequest $request)
    {
        // Ambil atau buat transaksi aktif (OPEN)
        $sale = Penjualan::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'status'  => 'OPEN'
            ],
            [
                'total_pembayaran'  => 0,
                'metode_pembayaran' => 'CASH'
            ]
        );

        // Load item keranjang beserta produknya
        $sale->load('itempenjualan.produk');

        // Fitur Pencarian Produk
        $keyword = $request->input('search');

        $products = Produk::when($keyword, function ($query) use ($keyword) {
            $query->where('nama', 'like', '%' . $keyword . '%');
        })
        ->orderBy('nama')
        ->get();

        $mode = 'create';

        return view('penjualan.pos', compact('sale', 'products', 'mode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return redirect()->route('penjualan.index')
            ->with('success', 'Transaksi berhasil disimpan!');
    }

    /**
     * Display the specified resource (Halaman Detail & Struk).
     */
    public function show(Penjualan $penjualan)
    {
        $sale = $penjualan;
        $sale->load(['itempenjualan.produk', 'user']);
        $products = Produk::orderBy('nama')->get();
        $mode = 'view';

        return view('penjualan.detail', compact('sale', 'products', 'mode'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penjualan $penjualan)
    {
        $sale = $penjualan;

        abort_if($sale->status === 'COMPLETED', 403);

        $sale->load('itempenjualan.produk');
        $products = Produk::orderBy('nama')->get();
        $mode = 'edit';

        return view('penjualan.pos', compact('sale', 'products', 'mode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:CASH,QRIS',
            'bayar'             => 'nullable|numeric|min:0'
        ]);

        if ($penjualan->status !== 'OPEN') {
            return back()->withErrors('Transaksi sudah diproses');
        }

        $items = $penjualan->itempenjualan()->with('produk')->get();

        if ($items->isEmpty()) {
            return back()->withErrors('Keranjang masih kosong');
        }

        // Pengecekan stok untuk setiap item di keranjang
        foreach ($items as $item) {
            if (!$item->produk) {
                return back()->withErrors('Salah satu produk di keranjang tidak ditemukan di database.');
            }

            if ($item->produk->stok < $item->kuantitas) {
                return back()->withErrors("Stok produk '{$item->produk->nama}' tidak mencukupi! (Tersedia: {$item->produk->stok}, Dibutuhkan: {$item->kuantitas})");
            }
        }

        $total = $items->sum('subtotal');
        $bayar = $request->input('bayar', 0);
        $kembali = 0;

        if ($request->metode_pembayaran === 'CASH') {
            if ($bayar < $total) {
                return back()->withErrors('Uang pembayaran kurang dari total tagihan!');
            }
            $kembali = $bayar - $total;
        } else if ($request->metode_pembayaran === 'QRIS') {
            $bayar = $total;
            $kembali = 0;
        }

        // Pemrosesan transaksi & pengurangan stok
        DB::transaction(function () use ($penjualan, $request, $total, $bayar, $kembali, $items) {
            foreach ($items as $item) {
                $item->produk->decrement('stok', $item->kuantitas);
            }

            $penjualan->update([
                'metode_pembayaran' => $request->metode_pembayaran,
                'total_pembayaran'  => $total,
                'bayar'             => $bayar,
                'kembali'           => $kembali,
                'status'            => 'COMPLETED'
            ]);
        });

        return redirect()
            ->route('penjualan.index')
            ->with('success', 'Transaksi berhasil diselesaikan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        $this->authorize('delete', $penjualan);

        if ($penjualan->status !== 'OPEN') {
            return redirect()
                ->route('penjualan.index')
                ->withErrors('Transaksi sudah selesai tidak bisa dibatalkan');
        }

        DB::transaction(function () use ($penjualan) {
            foreach ($penjualan->itempenjualan as $item) {
                if ($item->produk) {
                    $item->produk->increment('stok', $item->kuantitas);
                }
            }

            $penjualan->itempenjualan()->delete();
            $penjualan->delete();
        });

        return redirect()
            ->route('penjualan.index')
            ->with('success', 'Transaksi berhasil dibatalkan');
    }
}