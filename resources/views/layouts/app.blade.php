{{-- Contoh konversi Layout dari CodeIgniter ke Laravel Blade --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Perpustakaan PPIC' }}</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alegreya:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @yield('css')
</head>

<body>

    @include('partials.navbar')

    @yield('content')

    @include('partials.footer')

</body>

</html>