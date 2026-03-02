{{-- Layout utama Perpustakaan PPIC --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Perpustakaan PPIC' }}</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Space+Grotesk:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Animate.css --}}
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">

    {{-- Main Styles --}}
    <link rel="stylesheet" href="{{ asset('css/style.css?v=' . time()) }}">
    <link rel="stylesheet" href="{{ asset('css/glassmorphic.css?v=' . time()) }}">

    @yield('css')
</head>

<body>

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- Main Scripts --}}
    <script src="{{ asset('js/glassmorphic.js?v=' . time()) }}"></script>

    {{-- Scroll Reveal Animations --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var observerOptions = {
            threshold: 0.15,
            rootMargin: '0px 0px -50px 0px'
        };

        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var el = entry.target;
                    var animation = el.getAttribute('data-animate');
                    var delay = el.getAttribute('data-delay') || '0';

                    setTimeout(function() {
                        el.classList.add('animated', animation);
                        el.style.visibility = 'visible';
                    }, parseInt(delay));

                    observer.unobserve(el);
                }
            });
        }, observerOptions);

        document.querySelectorAll('[data-animate]').forEach(function(el) {
            el.style.visibility = 'hidden';
            observer.observe(el);
        });
    });
    </script>

    @yield('scripts')

</body>

</html>