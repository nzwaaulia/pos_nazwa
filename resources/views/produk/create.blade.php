@extends('layouts.app')

@section('title', 'Tambah Produk Baru - Sweet Crumbs Bakery')

@section('content')

@include('layouts.navbar')

<style>
    :root {
        --bakery-mocha: #4a3525;
        --bakery-caramel: #6f4e37;
        --bakery-cream: #fdfbf7;
        --bakery-accent: #d4a373;
        --success-gradient: linear-gradient(135deg, #606c38 0%, #283618 100%);
    }

    .page-wrapper {
        background-color: var(--bakery-cream) !important;
        min-height: 100vh;
        padding: 2.5rem 0 3.5rem 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .form-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #f0eae1;
        box-shadow: 0 10px 30px rgba(74, 53, 37, 0.05);
        overflow: hidden;
        animation: slideUp 0.4s ease-out forwards;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-header {
        background: linear-gradient(135deg, #4a3525 0%, #6f4e37 100%);
        padding: 2.5rem 2rem;
        color: white;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid rgba(212, 163, 115, 0.2);
    }

    .form-header::before {
        content: '🥐';
        position: absolute;
        top: -10px;
        right: 20px;
        font-size: 7rem;
        opacity: 0.08;
    }

    .form-header h2 {
        font-weight: 700;
        font-family: serif;
        letter-spacing: -0.3px;
        position: relative;
        z-index: 1;
    }

    .form-header p {
        position: relative;
        z-index: 1;
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.95rem;
    }

    .form-body {
        padding: 2.5rem;
    }
</style>

<div class="page-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-xl-8">
                
                <div class="form-card">
                    <!-- Header -->
                    <div class="form-header">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-25 p-3 rounded-4 me-3 text-white">
                                <i class="bi bi-cake2 fs-3"></i>
                            </div>
                            <div>
                                <h2 class="mb-1 fs-3">Tambah Produk Kue Baru</h2>
                                <p class="mb-0">Lengkapi formulir di bawah ini untuk menambahkan varian kue baru ke katalog sistem.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Body -->
                    <div class="form-body">
                        <form action="{{ route('produk.store') }}" 
                              method="POST" 
                              enctype="multipart/form-data">
                            
                            @csrf

                            <!-- Memuat Form Partial -->
                            @include('produk._form')
                            
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection