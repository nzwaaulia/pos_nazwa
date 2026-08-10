<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Menampilkan daftar semua produk.
     */
    public function index(Request $request)
    {
        $query = Produk::latest();

        // Pencarian disesuaikan dengan kolom 'nama' di database
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $products = $query->get();

        return view('produk.index', compact('products'));
    }

    /**
     * Menampilkan form untuk menambah produk baru.
     */
    public function create()
    {
        return view('produk.create');
    }

    /**
     * Menyimpan data produk baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga_beli'  => 'required|numeric|min:0',
            'harga_jual'  => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // 2. Petakan data input ke kolom database
        $data = [
            'user_id'    => Auth::id(),
            'nama'       => $request->nama_produk,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'stok'       => $request->stok,
        ];

        // 3. Olah upload foto jika ada
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        // 4. Simpan data baru ke database
        Produk::create($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail produk.
     */
    public function show(Produk $produk)
{
    return view('produk.detail', compact('produk')); // Diubah dari 'produk.show' ke 'produk.detail'
}

    /**
     * Menampilkan form untuk mengedit produk.
     */
    public function edit(Produk $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    /**
     * Memperbarui data produk di database.
     */
    public function update(Request $request, Produk $produk)
    {
        // 1. Validasi input
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga_beli'  => 'required|numeric|min:0',
            'harga_jual'  => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // 2. Petakan data input ke kolom database (menggunakan kolom 'nama')
        $data = [
            'user_id'    => Auth::id(),
            'nama'       => $request->nama_produk,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'stok'       => $request->stok,
        ];

        // 3. Olah upload foto baru jika ada
        if ($request->hasFile('foto')) {
            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                Storage::disk('public')->delete($produk->foto);
            }
            $data['foto'] = $request->file('foto')->store('products', 'public');
        }

        // 4. Update data ke database
        $produk->update($data);

        return redirect()->route('produk.index')->with('success', 'Data produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk dari database.
     */
    public function destroy(Produk $produk)
    {
        if (method_exists($produk, 'itemPenjualan') && $produk->itemPenjualan()->exists()) {
            return redirect()->route('produk.index')
                ->with('error', 'Produk tidak dapat dihapus karena sudah memiliki riwayat transaksi.');
        }

        if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}