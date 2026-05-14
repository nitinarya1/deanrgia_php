/**
 * Dean RGIA - Main JavaScript
 * Handles mobile menu and slideshow — NO navbar scroll logic (CSS handles everything)
 */
document.addEventListener('DOMContentLoaded', function () {

    // ========== MOBILE MENU ==========
    var menuBtn = document.getElementById('mobile-menu-btn');
    var mobileMenu = document.getElementById('mobile-menu');
    var menuIconOpen = document.getElementById('menu-icon-open');
    var menuIconClose = document.getElementById('menu-icon-close');
    var menuOpen = false;

    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', function () {
            menuOpen = !menuOpen;
            if (menuOpen) {
                mobileMenu.classList.remove('mobile-menu-closed');
                mobileMenu.classList.add('mobile-menu-open');
                menuIconOpen.classList.add('hidden');
                menuIconClose.classList.remove('hidden');
            } else {
                mobileMenu.classList.remove('mobile-menu-open');
                mobileMenu.classList.add('mobile-menu-closed');
                menuIconOpen.classList.remove('hidden');
                menuIconClose.classList.add('hidden');
            }
        });

        // Close mobile menu when clicking a link
        mobileMenu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                menuOpen = false;
                mobileMenu.classList.remove('mobile-menu-open');
                mobileMenu.classList.add('mobile-menu-closed');
                menuIconOpen.classList.remove('hidden');
                menuIconClose.classList.add('hidden');
            });
        });
    }

    // ========== INTERSECTION OBSERVER — Animate elements on scroll ==========
    var observer = null;
    if ('IntersectionObserver' in window) {
        observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.style.animationPlayState = 'running';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

        document.querySelectorAll('.animate-fade-in-up, .animate-slide-in-left, .animate-fade-in').forEach(function (el) {
            el.style.animationPlayState = 'paused';
            observer.observe(el);
        });
    }

    // ========== SLIDESHOW ==========
    var slides = document.querySelectorAll('.slideshow-slide');
    var dots = document.querySelectorAll('.slideshow-dot');
    var currentSlide = 0;
    var slideInterval = null;

    function showSlide(index) {
        slides.forEach(function (slide, i) {
            slide.classList.toggle('active', i === index);
            slide.classList.toggle('inactive', i !== index);
        });
        dots.forEach(function (dot, i) {
            if (i === index) {
                dot.classList.add('w-6', 'bg-white');
                dot.classList.remove('w-1.5', 'bg-white/50');
            } else {
                dot.classList.remove('w-6', 'bg-white');
                dot.classList.add('w-1.5', 'bg-white/50');
            }
        });
        currentSlide = index;
    }

    function nextSlide() {
        if (slides.length <= 1) return;
        showSlide((currentSlide + 1) % slides.length);
    }

    function prevSlide() {
        if (slides.length <= 1) return;
        showSlide((currentSlide - 1 + slides.length) % slides.length);
    }

    if (slides.length > 0) {
        showSlide(0);
        if (slides.length > 1) {
            slideInterval = setInterval(nextSlide, 5000);
        }
    }

    // Expose for onclick
    window.slideshowPrev = function () { prevSlide(); clearInterval(slideInterval); slideInterval = setInterval(nextSlide, 5000); };
    window.slideshowNext = function () { nextSlide(); clearInterval(slideInterval); slideInterval = setInterval(nextSlide, 5000); };
    window.slideshowGoto = function (i) { showSlide(i); clearInterval(slideInterval); slideInterval = setInterval(nextSlide, 5000); };
});
