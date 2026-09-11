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
            // Filter berdasarkan role (Pengecekan role kasir aman jika role berupa string/relasi)
            ->when(optional($user->role)->name === 'kasir' || $user->role === 'kasir', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            // Search nama user
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
     * Show the form for creating a new resource.
     */
    public function create(SearchRequest $request)
    {
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

        $keyword = $request->input('search');

        if ($keyword) {
            $products = Produk::when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', '%' . $keyword . '%');
            })
            ->orderBy('nama')
            ->get();
        } else {
            $products = Produk::orderBy('nama')->get();
        }

        $mode = 'create';

        return view('penjualan.pos', compact('sale', 'products', 'mode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ... proses simpan transaksi / checkout ...

        return redirect()->route('penjualan.index')
            ->with('success', 'Transaksi berhasil disimpan!');
    }

    /**
     * Display the specified resource (Halaman Detail & Struk).
     */
    public function show(Penjualan $penjualan)
    {
        $sale = $penjualan;

        // Eager loading relasi itempenjualan beserta data produk & kasir (user) untuk cetak struk
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

        $sale->load('itempenjualan');
        $products = Produk::orderBy('nama')->get();
        $mode = 'edit';

        return view('penjualan.pos', compact('sale', 'products', 'mode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        // Validasi input dari form
        $request->validate([
            'metode_pembayaran' => 'required|in:CASH,QRIS',
            'bayar'             => 'nullable|numeric|min:0'
        ]);

        if ($penjualan->status !== 'OPEN') {
            return back()->withErrors(['msg' => 'Transaksi sudah diproses']);
        }

        if ($penjualan->itempenjualan()->count() === 0) {
            return back()->withErrors(['msg' => 'Keranjang masih kosong']);
        }

        // Hitung ulang total pembayaran dari item keranjang (anti manipulasi client)
        $total = $penjualan->itempenjualan()->sum('subtotal');
        $bayar = $request->input('bayar', 0);
        $kembali = 0;

        if ($request->metode_pembayaran === 'CASH') {
            // Cek apakah nominal uang tunai mencukupi
            if ($bayar < $total) {
                return back()->withErrors(['msg' => 'Uang pembayaran kurang dari total tagihan!']);
            }
            $kembali = $bayar - $total;
        } else if ($request->metode_pembayaran === 'QRIS') {
            // Jika QRIS, anggap uang pas
            $bayar = $total;
            $kembali = 0;
        }

        DB::transaction(function () use ($penjualan, $request, $total, $bayar, $kembali) {
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

        // Pastikan hanya transaksi OPEN
        if ($penjualan->status !== 'OPEN') {
            return redirect()
                ->route('penjualan.index')
                ->withErrors(['msg' => 'Transaksi sudah selesai tidak bisa dibatalkan']);
        }

        DB::transaction(function () use ($penjualan) {
            foreach ($penjualan->itempenjualan as $item) {
                // Kembalikan stok
                if ($item->produk) {
                    $item->produk->increment('stok', $item->kuantitas);
                }
            }

            // Hapus item
            $penjualan->itempenjualan()->delete();

            // Hapus penjualan
            $penjualan->delete();
        });

        return redirect()
            ->route('penjualan.index')
            ->with('success', 'Transaksi berhasil dibatalkan');
    }
}