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

    // Contact page: Traveller / Travel Agent tabs
    var tabs = document.querySelectorAll('.ls-path-tabs [role=tab]');
    tabs.forEach(function (tab, index) {
        function select() {
            tabs.forEach(function (t) {
                var on = t === tab;
                t.setAttribute('aria-selected', String(on));
                t.tabIndex = on ? 0 : -1;
                var panel = document.getElementById(t.getAttribute('aria-controls'));
                if (panel) panel.hidden = !on;
            });
        }
        tab.addEventListener('click', select);
        tab.addEventListener('keydown', function (e) {
            if (e.key !== 'ArrowRight' && e.key !== 'ArrowLeft') return;
            var next = tabs[(index + (e.key === 'ArrowRight' ? 1 : -1) + tabs.length) % tabs.length];
            next.focus();
            next.click();
        });
    });

    // Destinations: client-side region filter
    document.querySelectorAll('[data-ls-filter]').forEach(function (bar) {
        var grid = document.querySelector(bar.getAttribute('data-ls-filter'));
        if (!grid) return;
        bar.addEventListener('click', function (e) {
            var btn = e.target.closest('button[data-region]');
            if (!btn) return;
            var region = btn.getAttribute('data-region');
            bar.querySelectorAll('button').forEach(function (b) {
                b.classList.toggle('is-active', b === btn);
                b.setAttribute('aria-pressed', String(b === btn));
            });
            grid.querySelectorAll('[data-region]').forEach(function (card) {
                card.hidden = region !== 'all' && card.getAttribute('data-region') !== region;
            });
        });
    });

    // Enquiry forms: pass the page / tour name in the hidden 'page_title' field
    function setPageTitle(value) {
        document.querySelectorAll('input[name=page_title]').forEach(function (input) {
            input.value = value;
        });
    }
    setPageTitle(document.title);

    // Photo lightbox
    if (window.GLightbox && document.querySelector('.ls-page .glightbox')) {
        window.GLightbox({ selector: '.ls-page .glightbox' });
    }

    // Scroll reveal (AOS). Attributes are added here rather than in the
    // templates, so content stays visible if the script never runs.
    // Heroes keep their own CSS animation, and grids animate as a whole
    // because AOS's transform would cancel the cards' hover lift.
    if (window.AOS) {
        var reveal = [
            '.ls-section-head',
            '.ls-exp-grid', '.ls-testi-grid', '.ls-grid', '.ls-stats-grid',
            '.ls-why-photo',
            '.ls-b2b > .ls-wrap', '.ls-cta-band > .ls-wrap', '.ls-cta-green > .ls-wrap'
        ];

        document.querySelectorAll(reveal.join(',')).forEach(function (el) {
            if (!el.closest('.ls-hero, .ls-page-hero') && !el.hasAttribute('data-aos')) {
                el.setAttribute('data-aos', 'fade-up');
            }
        });

        // List items come in one after another.
        document.querySelectorAll('.ls-why-list li').forEach(function (li, i) {
            li.setAttribute('data-aos', 'fade-up');
            li.setAttribute('data-aos-delay', String(Math.min(i, 5) * 100));
        });

        window.AOS.init({
            once: true,
            duration: 700,
            easing: 'ease-out-cubic',
            offset: 60,
            disable: function () {
                return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            }
        });
    }
})();
