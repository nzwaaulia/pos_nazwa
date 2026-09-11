<!-- Custom Style Khusus Form & Tombol Cokelat Bakery -->
<style>
    .form-label {
        color: #4a3525;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .form-control {
        border-radius: 12px;
        border: 1.5px solid #f0eae1;
        padding: 0.65rem 1rem;
        background-color: #fcfbfa;
        color: #4a3525;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #d4a373;
        box-shadow: 0 0 0 0.25rem rgba(212, 163, 115, 0.2);
        background-color: #ffffff;
    }

    /* CSS Pembatas Gambar Preview */
    .preview-wrapper {
        display: inline-block;
        max-width: 250px;
        max-height: 200px;
        overflow: hidden;
        border-radius: 12px;
        border: 1.5px solid #f0eae1;
        background-color: #fcfbfa;
    }

    #img-preview {
        max-width: 250px;
        max-height: 200px;
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* TOMBOL SIMPAN - Tema Cokelat Mocha */
    .btn-simpan-bakery {
        background-color: #4a3525 !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 0.65rem 1.8rem !important;
        font-weight: 700 !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 4px 12px rgba(74, 53, 37, 0.15) !important;
    }

    .btn-simpan-bakery:hover {
        background-color: #6f4e37 !important; /* Caramel Hover */
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(74, 53, 37, 0.25) !important;
    }

    /* TOMBOL KEMBALI - Tema Soft Cream */
    .btn-kembali-bakery {
        background-color: #f7f4ef !important;
        color: #6f4e37 !important;
        border: 1px solid #e8e1d5 !important;
        border-radius: 12px !important;
        padding: 0.65rem 1.8rem !important;
        font-weight: 700 !important;
        text-decoration: none !important;
        transition: all 0.3s ease !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-kembali-bakery:hover {
        background-color: #e8e1d5 !important;
        color: #4a3525 !important;
        transform: translateY(-2px);
    }
</style>

<!-- Input Foto Produk -->
<div class="mb-3">
    <label for="foto" class="form-label">Foto Produk</label>
    <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" onchange="previewImage()">
    @error('foto')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Preview Foto (Satu-satunya bagian yang diperbaiki ukurannya) -->
<div class="mb-3 text-center">
    <label class="form-label d-block">Preview Foto</label>
    <div class="preview-wrapper shadow-sm">
        @if(isset($produk) && $produk->foto)
            <img src="{{ asset('storage/' . $produk->foto) }}" id="img-preview" alt="Preview">
        @else
            <img src="https://via.placeholder.com/200?text=No+Image" id="img-preview" alt="Preview">
        @endif
    </div>
</div>

<!-- Input Nama Produk -->
<div class="mb-3">
    <label for="nama_produk" class="form-label">Nama Produk</label>
    <input type="text" 
           class="form-control @error('nama_produk') is-invalid @enderror" 
           id="nama_produk" 
           name="nama_produk" 
           value="{{ old('nama_produk', $produk->nama_produk ?? $produk->nama ?? '') }}" 
           placeholder="Masukkan nama kue..." required>
    @error('nama_produk')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Input Harga Beli -->
<div class="mb-3">
    <label for="harga_beli" class="form-label">Harga Beli</label>
    <input type="number" 
           class="form-control @error('harga_beli') is-invalid @enderror" 
           id="harga_beli" 
           name="harga_beli" 
           value="{{ old('harga_beli', $produk->harga_beli ?? '') }}" 
           placeholder="Contoh: 30000" required>
    @error('harga_beli')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Input Harga Jual -->
<div class="mb-3">
    <label for="harga_jual" class="form-label">Harga Jual</label>
    <input type="number" 
           class="form-control @error('harga_jual') is-invalid @enderror" 
           id="harga_jual" 
           name="harga_jual" 
           value="{{ old('harga_jual', $produk->harga_jual ?? '') }}" 
           placeholder="Contoh: 35000" required>
    @error('harga_jual')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Input Stok -->
<div class="mb-4">
    <label for="stok" class="form-label">Stok</label>
    <input type="number" 
           class="form-control @error('stok') is-invalid @enderror" 
           id="stok" 
           name="stok" 
           value="{{ old('stok', $produk->stok ?? '') }}" 
           placeholder="Contoh: 20" required>
    @error('stok')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Tombol Aksi (Simpan & Kembali) -->
<div class="d-flex gap-2 pt-2">
    <button type="submit" class="btn btn-simpan-bakery">
        <i class="bi bi-check-circle me-1"></i> Simpan
    </button>
    <a href="{{ route('produk.index') }}" class="btn btn-kembali-bakery">
        Kembali
    </a>
</div>

<!-- Script Preview Image -->
<script>
    function previewImage() {
        const image = document.querySelector('#foto');
        const imgPreview = document.querySelector('#img-preview');

        if(image.files && image.files[0]) {
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    }
</script>