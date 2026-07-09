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

    {{-- Bootstrap CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">

    {{-- Animate.css --}}
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">

    {{-- Bootsnav CSS --}}
    <link rel="stylesheet" href="{{ asset('css/bootsnav.css') }}">

    {{-- Main Styles --}}
    <link rel="stylesheet" href="{{ asset('css/style.css?v=' . time()) }}">

    @yield('css')
</head>

<body>

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- Main Scripts --}}
    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    
    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>

    {{-- Bootsnav JS --}}
    <script src="{{ asset('js/bootsnav.js') }}"></script>

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

        var topBar = document.querySelector('.top-bar');
        var body = document.body;

        function toggleTopBar() {
            if (!topBar) {
                return;
            }

            if (window.scrollY > 20) {
                topBar.classList.add('collapsed');
                body.classList.add('navbar-condensed');
            } else {
                topBar.classList.remove('collapsed');
                body.classList.remove('navbar-condensed');
            }
        }

        toggleTopBar();
        window.addEventListener('scroll', toggleTopBar, { passive: true });
    });
    </script>

    @yield('scripts')

    <script>
    window.onload = function() {
        // MAIN MENU
        document.querySelectorAll('.has-dropdown > .menu-item').forEach(item => {
            item.onclick = function() {
                const parent = this.parentElement;

                // close semua
                document.querySelectorAll('.has-dropdown').forEach(el => {
                    if (el !== parent) el.classList.remove('active');
                });

                parent.classList.toggle('active');
            };
        });

        // SUB MENU
        document.querySelectorAll('.has-sub-dropdown > .menu-item').forEach(item => {
            item.onclick = function(e) {
                e.stopPropagation();

                const parent = this.parentElement;
                parent.classList.toggle('active');
            };
        });
    };
    </script>

</body>

</html>