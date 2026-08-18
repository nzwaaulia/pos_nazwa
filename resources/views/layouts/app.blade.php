<!DOCTYPE html>
<html lang="id">
<head>
    <style>
    /* Paksa seluruh halaman memenuhi viewport tanpa margin */
    html, body {
        width: 100%;
        min-height: 100vh;
        margin: 0;
        padding: 0;
        overflow-x: hidden; /* Hilangkan scroll samping */
    }

    /* Hilangkan padding default pada wrapper utama */
    .page-wrapper {
        width: 100%;
        min-height: 100vh;
        background-color: #fff0f3;
        box-sizing: border-box;
    }
    </style>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
            timer: 5000, // Otomatis hilang dalam 5000 milidetik (5 detik)
            timerProgressBar: true,
            showConfirmButton: false,
            toast: true,
            position: 'top-end', // Tampil di pojok kanan atas
            background: '#ffffff',
            color: '#333333'
        });
    </script>
    @endif

</body>
</html>