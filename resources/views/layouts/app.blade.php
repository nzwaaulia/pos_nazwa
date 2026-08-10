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
    <!-- Isi title yang dikirimkan dari views lain -->
    <title>@yield('title')</title>
    <!-- Memanggil link bootstrap -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <!-- NAVBAR DITAROH DI LUAR CONTAINER AGAR FULL LEBARNYA -->
   
    <!-- KONTEN UTAMA -->
    <div class="container-fluid px-0">
        @yield('content')
    </div>

</body>
</html>