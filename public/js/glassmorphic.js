// =============================================
// Perpustakaan PPIC - Main JavaScript
// Navbar scroll effect + Mobile toggle + Dropdowns
// =============================================

document.addEventListener('DOMContentLoaded', function() {
    var navbar = document.querySelector('.navbar');
    var topBar = document.querySelector('.top-bar');
    var navToggle = document.getElementById('navToggle');
    var navMenu = document.getElementById('navMenu');

    // ===== NAVBAR SCROLL EFFECT =====
    // Transparent at top -> solid & hide on scroll down
    function handleNavScroll() {
        if (!navbar) return;

        var isScrolled = window.scrollY > 80;
        navbar.classList.toggle('scrolled', isScrolled);
        if (topBar) {
            topBar.classList.toggle('collapsed', isScrolled);
        }
    }

    window.addEventListener('scroll', handleNavScroll, { passive: true });
    handleNavScroll();

    // ===== MOBILE HAMBURGER TOGGLE =====
    if (navToggle && navMenu) {
        navToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');

            // Toggle hamburger animation
            var spans = navToggle.querySelectorAll('span');
            if (navMenu.classList.contains('active')) {
                spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
            } else {
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!navMenu.contains(e.target) && !navToggle.contains(e.target)) {
                navMenu.classList.remove('active');
                var spans = navToggle.querySelectorAll('span');
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });

        // Close menu when clicking a link
        navMenu.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', function() {
                navMenu.classList.remove('active');
                var spans = navToggle.querySelectorAll('span');
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            });
        });
    }

    // ===== DROPDOWNS - Desktop hover =====
    var dropdownParents = document.querySelectorAll('.has-dropdown');

    dropdownParents.forEach(function(parent) {
        var dropdownMenu = parent.querySelector('.dropdown');
        if (!dropdownMenu) return;

        // For mobile: toggle dropdown on click
        var dropdownTitle = parent.querySelector('.dropdown-title');
        if (dropdownTitle && window.innerWidth <= 768) {
            dropdownTitle.addEventListener('click', function(e) {
                e.stopPropagation();
                var isOpen = dropdownMenu.style.display === 'block';
                // Close all dropdowns first
                document.querySelectorAll('.has-dropdown .dropdown').forEach(function(d) {
                    d.style.display = 'none';
                });
                dropdownMenu.style.display = isOpen ? 'none' : 'block';
            });
        }
    });

    // ===== SMOOTH SCROLL =====
    document.querySelectorAll('a[href^="#"]').forEach(function(link) {
        link.addEventListener('click', function(e) {
            var href = this.getAttribute('href');
            if (href === '#') return;
            var target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                var offsetTop = target.offsetTop - 70; // account for fixed navbar
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });

    // ===== BODY LOAD TRANSITION =====
    document.body.style.opacity = '1';
    document.body.style.transition = 'opacity 0.4s ease-in-out';
});

// Set initial body opacity for fade-in effect
document.body.style.opacity = '0';
