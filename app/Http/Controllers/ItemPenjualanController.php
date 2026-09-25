<?php

namespace App\Http\Controllers;

use App\Models\ItemPenjualan;
use App\Models\Penjualan;
use App\Models\Produk; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemPenjualanController extends Controller
{
    public function index() {}
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produk,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {

                $sale = Penjualan::where('user_id', Auth::id())
                    ->where('status', 'OPEN')
                    ->firstOrFail();

                $product = Produk::lockForUpdate()->findOrFail($request->product_id);

                // 1. Cek stok produk
                if ($product->stok < $request->quantity) {
                    throw new \Exception("Stok {$product->nama_produk} tidak mencukupi! Sisa stok: {$product->stok}");
                }

                // Kurangi stok
                $product->decrement('stok', $request->quantity);

                // Update / insert item penjualan
                $item = ItemPenjualan::where('penjualan_id', $sale->id)
                    ->where('produk_id', $product->id)
                    ->lockForUpdate()
                    ->first();

                if ($item) {
                    // UPDATE
                    $item->kuantitas += $request->quantity;
                } else {
                    // CREATE
                    $item = new ItemPenjualan([
                        'penjualan_id' => $sale->id,
                        'produk_id'    => $product->id,
                        'kuantitas'    => $request->quantity,
                        'harga_satuan' => $product->harga_jual,
                    ]);
                }

                // hitung subtotal SETELAH kuantitas fix
                $item->subtotal = $item->kuantitas * $item->harga_satuan;
                $item->save();

                // TOTAL PEMBAYARAN
                $sale->total_pembayaran = $sale->itemPenjualan()->sum('subtotal');
                $sale->save();
            });

            return back()->with('success', 'Berhasil menambahkan produk ke keranjang.');

        } catch (\Exception $e) {
            // Tangkap exception dan kirimkan pesan error ke Blade
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(string $id) {}
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemPenjualan $itempenjualan)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            DB::transaction(function () use ($request, $itempenjualan) {

                $produk = $itempenjualan->produk()->lockForUpdate()->first();

                $selisih = $request->quantity - $itempenjualan->kuantitas;

                // Jika qty bertambah → kurangi stok
                if ($selisih > 0) {
                    if ($produk->stok < $selisih) {
                        throw new \Exception("Stok {$produk->nama_produk} tidak mencukupi! Sisa stok yang bisa ditambah: {$produk->stok}");
                    }
                    $produk->decrement('stok', $selisih);
                }

                // Jika qty berkurang → kembalikan stok
                if ($selisih < 0) {
                    $produk->increment('stok', abs($selisih));
                }

                // Update item
                $itempenjualan->update([
                    'kuantitas' => $request->quantity,
                    'subtotal'  => $request->quantity * $itempenjualan->harga_satuan
                ]);

                // Update total penjualan
                $itempenjualan->penjualan->update([
                    'total_pembayaran' =>
                        $itempenjualan->penjualan->itemPenjualan()->sum('subtotal')
                ]);
            });

            return back()->with('success', 'Jumlah pesanan berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemPenjualan $itempenjualan)
    {
        DB::transaction(function () use ($itempenjualan) {

            $produk = $itempenjualan->produk;
            $sale   = $itempenjualan->penjualan;

            // Kembalikan stok
            $produk->increment('stok', $itempenjualan->kuantitas);

            // Hapus item
            $itempenjualan->delete();

            // Update total penjualan
            $sale->update([
                'total_pembayaran' => $sale->itemPenjualan()->sum('subtotal')
            ]);
        });

        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}