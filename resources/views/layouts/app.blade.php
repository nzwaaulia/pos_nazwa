<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
    /* Paksa seluruh halaman memenuhi viewport tanpa margin */
    html, body {
        width: 100%;
        min-height: 100vh;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    .page-wrapper {
        width: 100%;
        min-height: 100vh;
        background-color: #fff0f3;
        box-sizing: border-box;
    }

    /* === STYLING TOAST ELEGAN MEMAKSA WARNA TEMA === */
    .swal2-container.swal2-top-end .swal2-popup.swal2-toast {
        background-color: #3D2B1F !important; /* Cokelat tua elegan */
        color: #FDFBF7 !important;            /* Krem soft */
        border: 1px solid #7D5239 !important; /* Border aksen cokelat */
        border-radius: 12px !important;       /* Sudut melengkung halus */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25) !important;
        padding: 12px 16px !important;
    }

    /* Warna Teks Judul & Pesan */
    .swal2-toast .swal2-title {
        color: #FDFBF7 !important;
        font-weight: 600 !important;
        font-size: 0.95rem !important;
    }

    .swal2-toast .swal2-html-container {
        color: #D3C1B5 !important;
        font-size: 0.85rem !important;
    }

    /* Warna Ikon Centang */
    .swal2-toast .swal2-icon.swal2-success {
        border-color: #C69C6D !important;
    }
    .swal2-toast .swal2-icon.swal2-success [class^='swal2-success-line'] {
        background-color: #C69C6D !important;
    }
    .swal2-toast .swal2-icon.swal2-success .swal2-success-ring {
        border: 4px solid rgba(198, 156, 109, 0.3) !important;
    }

    /* Progress Bar waktu hilang */
    .swal2-toast .swal2-timer-progress-bar {
        background-color: #C69C6D !important;
    }
    </style>
</head>
<body>

    <div class="container-fluid px-0">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 4000,
            timerProgressBar: true,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    </script>
    @endif

</body>
</html>