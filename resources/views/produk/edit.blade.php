@extends('layouts.app')

@section('title', 'Edit Produk - Sweet Crumbs Bakery')

@section('content')

@include('layouts.navbar')

<!-- Custom Bakery Theme Edit Styling -->
<style>
    .page-wrapper {
        background-color: #fdfbf7 !important; /* Warm Cream Background */
        min-height: 100vh;
        padding: 2.5rem 0 3.5rem 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card {
        border: 1px solid #f0eae1;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(74, 53, 37, 0.05);
        background: #ffffff;
        overflow: hidden;
        animation: fadeIn 0.4s ease-out forwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card-header {
        background: linear-gradient(135deg, #4a3525 0%, #6f4e37 100%); /* Rich Mocha Gradient */
        color: #fff;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid rgba(212, 163, 115, 0.2);
    }

    .card-header::before {
        content: '🥐';
        position: absolute;
        top: -10px;
        right: 20px;
        font-size: 7rem;
        opacity: 0.08;
    }

    .card-header h4 {
        margin: 0;
        font-weight: 700;
        font-family: serif;
        letter-spacing: -0.3px;
        position: relative;
        z-index: 1;
    }

    .card-body {
        padding: 2.5rem !important;
    }

    .preview {
        width: 200px;
        height: 200px;
        border: 2px dashed #d4a373;
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #f7f4ef;
        margin: auto;
        transition: all 0.3s ease;
    }

    .preview:hover {
        border-color: #bc6c25;
    }

    .preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    @media (max-width: 768px) {
        .preview {
            width: 150px;
            height: 150px;
        }
        .card-body {
            padding: 1.5rem !important;
        }
    }
</style>

<div class="page-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-xl-8">

                <div class="card">
                    <!-- Header Mocha Bakery -->
                    <div class="card-header">
                        <h4>
                            <i class="bi bi-pencil-square me-2"></i> Edit Informasi Produk Kue
                        </h4>
                        <p class="text-white-50 mb-0 mt-1 small">Perbarui detail, harga, atau stok varian kue pada sistem.</p>
                    </div>

                    <!-- Body -->
                    <div class="card-body">
                        <form action="{{ route('produk.update', $produk) }}"
                              method="POST"
                              enctype="multipart/form-data">

                            @csrf
                            @method('PUT')

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