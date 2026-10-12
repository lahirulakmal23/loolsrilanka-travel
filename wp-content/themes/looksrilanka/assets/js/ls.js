/* Look Sri Lanka — redesign scripts (no dependencies). */
(function () {
    'use strict';

    // Mobile menu
    var burger = document.querySelector('.ls-burger');
    var menu = document.getElementById('ls-mobile-menu');

    if (burger && menu) {
        burger.addEventListener('click', function () {
            var open = burger.getAttribute('aria-expanded') === 'true';
            burger.setAttribute('aria-expanded', String(!open));
            burger.setAttribute('aria-label', open ? 'Open menu' : 'Close menu');
            menu.hidden = open;
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !menu.hidden) {
                burger.click();
                burger.focus();
            }
        });
    }

    // Preloader (redesigned pages; legacy pages use main.js)
    var preloader = document.querySelector('.ls-redesign .ls-preloader');
    if (preloader) {
        window.addEventListener('load', function () {
            preloader.classList.add('is-done');
            setTimeout(function () { preloader.remove(); }, 400);
        });
    }

    // Hero slider
    document.querySelectorAll('[data-ls-slider]').forEach(function (hero) {
        var slides = hero.querySelectorAll('.ls-slide');
        var dots = hero.querySelectorAll('[data-ls-go]');
        var delay = parseInt(hero.getAttribute('data-interval'), 10) || 6000;
        var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var current = 0;
        var timer = null;

        if (slides.length < 2) {
            return;
        }

        function show(n) {
            slides[current].classList.remove('is-active');
            slides[current].setAttribute('aria-hidden', 'true');
            dots[current] && dots[current].classList.remove('is-active');

            current = (n + slides.length) % slides.length;

            slides[current].classList.add('is-active');
            slides[current].removeAttribute('aria-hidden');
            dots[current] && dots[current].classList.add('is-active');
        }

        function stop() {
            clearInterval(timer);
            timer = null;
        }

        function start() {
            stop();
            if (!reduced) {
                timer = setInterval(function () { show(current + 1); }, delay);
            }
        }

        hero.addEventListener('click', function (e) {
            var go = e.target.closest('[data-ls-go]');
            var move = e.target.closest('[data-ls-move]');
            if (go) {
                show(parseInt(go.getAttribute('data-ls-go'), 10));
                start();
            } else if (move) {
                show(current + parseInt(move.getAttribute('data-ls-move'), 10));
                start();
            }
        });

        // Swipe on touch devices
        var startX = null;
        hero.addEventListener('touchstart', function (e) { startX = e.touches[0].clientX; }, { passive: true });
        hero.addEventListener('touchend', function (e) {
            if (startX === null) return;
            var dx = e.changedTouches[0].clientX - startX;
            if (Math.abs(dx) > 50) {
                show(current + (dx < 0 ? 1 : -1));
                start();
            }
            startX = null;
        });

        hero.addEventListener('mouseenter', stop);
        hero.addEventListener('mouseleave', start);
        hero.addEventListener('focusin', stop);
        hero.addEventListener('focusout', start);
        document.addEventListener('visibilitychange', function () {
            document.hidden ? stop() : start();
        });

        start();
    });
})();
