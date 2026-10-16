/* Look Sri Lanka — redesign scripts (no dependencies). */
(function () {
    'use strict';

    // Mobile menu
    var burger = document.querySelector('.ls-burger');
    var menu = document.getElementById('ls-mobile-menu');

    var header = document.querySelector('.ls-header');

    if (burger && menu) {
        burger.addEventListener('click', function () {
            var open = burger.getAttribute('aria-expanded') === 'true';
            burger.setAttribute('aria-expanded', String(!open));
            burger.setAttribute('aria-label', open ? 'Open menu' : 'Close menu');
            menu.hidden = open;
            if (header) header.classList.toggle('is-open', !open);
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !menu.hidden) {
                burger.click();
                burger.focus();
            }
        });
    }

    // Header: solid with a shadow once the page scrolls (transparent over photo heroes until then).
    if (header) {
        var onScroll = function () {
            header.classList.toggle('is-scrolled', window.scrollY > 24);
        };
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    }

    // Hero destination cards: rise in when the band scrolls into view.
    var heroDest = document.querySelector('.ls-hero-dest');
    if (heroDest && 'IntersectionObserver' in window) {
        heroDest.setAttribute('data-reveal', '');
        var destObserver = new IntersectionObserver(function (entries) {
            if (entries[0].isIntersecting) {
                heroDest.classList.add('is-in');
                destObserver.disconnect();
            }
        }, { threshold: 0.2 });
        destObserver.observe(heroDest);
    }

    // Card sliders: arrows scroll one card at a time and are disabled at the ends.
    // The arrows stay hidden when every card already fits.
    document.querySelectorAll('[data-ls-carousel]').forEach(function (carousel) {
        var track = carousel.querySelector('[data-ls-track]');
        var nav = carousel.querySelector('.ls-hdest-nav');
        if (!track || !nav) return;
        var prev = nav.querySelector('[data-ls-step="-1"]');
        var next = nav.querySelector('[data-ls-step="1"]');

        var step = function () {
            var card = track.firstElementChild;
            var gap = parseFloat(getComputedStyle(track).columnGap) || 0;
            return card ? card.getBoundingClientRect().width + gap : track.clientWidth;
        };
        var update = function () {
            var max = track.scrollWidth - track.clientWidth;
            nav.hidden = max < 4;
            prev.disabled = track.scrollLeft <= 2;
            next.disabled = track.scrollLeft >= max - 2;
        };

        nav.addEventListener('click', function (e) {
            var btn = e.target.closest('[data-ls-step]');
            if (btn) track.scrollBy({ left: step() * parseInt(btn.getAttribute('data-ls-step'), 10), behavior: 'smooth' });
        });
        track.addEventListener('scroll', update, { passive: true });
        window.addEventListener('resize', update);
        update();
    });

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
                // A card can list several space-separated regions / categories.
                var own = ' ' + card.getAttribute('data-region') + ' ';
                card.hidden = region !== 'all' && own.indexOf(' ' + region + ' ') === -1;
            });
        });
    });

    // Gallery page: category filter, search and paging. The lightbox only
    // steps through the photos that match the current filter.
    document.querySelectorAll('[data-ls-gallery]').forEach(function (gallery) {
        var items = Array.prototype.slice.call(gallery.querySelectorAll('.ls-gl-item'));
        var search = gallery.querySelector('.ls-gl-search input');
        var empty = gallery.querySelector('.ls-gl-empty');
        var pager = gallery.querySelector('.ls-gl-pages');
        var perPage = parseInt(gallery.getAttribute('data-per-page'), 10) || 8;
        var category = 'all';
        var page = 1;
        var matches = items;

        function pageButton(label, target, ariaLabel, current) {
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'page-numbers' + (current ? ' current' : '');
            btn.innerHTML = label;
            btn.disabled = target < 1 || target > Math.ceil(matches.length / perPage);
            if (ariaLabel) btn.setAttribute('aria-label', ariaLabel);
            if (current) btn.setAttribute('aria-current', 'page');
            btn.addEventListener('click', function () {
                page = target;
                render();
                var top = gallery.getBoundingClientRect().top;
                if (top < 0) gallery.scrollIntoView({ behavior: 'smooth' });
            });
            return btn;
        }

        function render() {
            var term = search ? search.value.trim().toLowerCase() : '';
            matches = items.filter(function (item) {
                return (category === 'all' || item.getAttribute('data-cat') === category) &&
                    (!term || item.getAttribute('data-search').indexOf(term) !== -1);
            });
            var pages = Math.max(1, Math.ceil(matches.length / perPage));
            page = Math.min(page, pages);

            items.forEach(function (item) { item.hidden = true; });
            matches.slice((page - 1) * perPage, page * perPage).forEach(function (item) { item.hidden = false; });
            if (empty) empty.hidden = matches.length > 0;

            if (!pager) return;
            var links = pager.querySelector('.nav-links');
            links.innerHTML = '';
            pager.hidden = pages < 2;
            if (pages < 2) return;
            links.appendChild(pageButton('&lsaquo;', page - 1, 'Previous page'));
            for (var i = 1; i <= pages; i++) {
                links.appendChild(pageButton(String(i), i, 'Page ' + i, i === page));
            }
            links.appendChild(pageButton('&rsaquo;', page + 1, 'Next page'));
        }

        var bar = gallery.querySelector('.ls-gl-filters');
        if (bar) {
            bar.addEventListener('click', function (e) {
                var btn = e.target.closest('button[data-cat]');
                if (!btn) return;
                category = btn.getAttribute('data-cat');
                page = 1;
                bar.querySelectorAll('button').forEach(function (b) {
                    b.classList.toggle('is-active', b === btn);
                    b.setAttribute('aria-pressed', String(b === btn));
                });
                render();
            });
        }
        if (search) {
            // "View all photos" links from destination pages pass ?q=<place>.
            var query = new URLSearchParams(window.location.search).get('q');
            if (query) search.value = query;
            search.addEventListener('input', function () {
                page = 1;
                render();
            });
        }

        // GLightbox is checked on click because it may load after this file.
        gallery.addEventListener('click', function (e) {
            var item = e.target.closest('.ls-gl-item');
            if (!item || !window.GLightbox) return;
            e.preventDefault();
            var box = window.GLightbox({
                elements: matches.map(function (el) {
                    return { href: el.getAttribute('href'), type: 'image', title: el.getAttribute('data-title') };
                })
            });
            box.on('close', function () { setTimeout(function () { box.destroy(); }, 400); });
            box.openAt(matches.indexOf(item));
        });

        render();
    });

    // Enquiry forms: pass the page / tour name in the hidden 'page_title' field
    function setPageTitle(value) {
        document.querySelectorAll('input[name=page_title]').forEach(function (input) {
            input.value = value;
        });
    }
    setPageTitle(document.title);

    // Day tours listing: "Book" on a card names that tour in the booking form.
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-ls-book]');
        if (!btn) return;
        var tour = btn.getAttribute('data-ls-book');
        setPageTitle(tour + ' — ' + document.title);
        var selected = document.querySelector('.ls-dt-selected');
        if (selected) {
            selected.querySelector('strong').textContent = tour;
            selected.hidden = false;
        }
    });

    // Tour form: the departure date appears once an arrival date is picked,
    // and can't be earlier than it. Arrival can't be in the past.
    var today = new Date();
    today = new Date(today.getTime() - today.getTimezoneOffset() * 60000).toISOString().slice(0, 10);
    document.querySelectorAll('input[name=arrival-date]').forEach(function (input) {
        input.min = today;
    });
    document.addEventListener('change', function (e) {
        if (!e.target.matches('input[name=arrival-date]')) return;
        var form = e.target.form;
        var wrap = form && form.querySelector('.ls-depart');
        var depart = form && form.querySelector('input[name=departure-date]');
        if (!wrap || !depart) return;
        wrap.hidden = !e.target.value;
        depart.min = e.target.value || today;
        if (depart.value && depart.value < e.target.value) depart.value = '';
    });
    document.addEventListener('wpcf7reset', function (e) {
        var wrap = e.target.querySelector('.ls-depart');
        if (wrap) wrap.hidden = true;
    });

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
            '.ls-gl-grid', '.ls-blog-layout',
            '.ls-b2b > .ls-wrap', '.ls-cta-band > .ls-wrap', '.ls-cta-green > .ls-wrap'
        ];

        document.querySelectorAll(reveal.join(',')).forEach(function (el) {
            if (!el.closest('.ls-hero, .ls-page-hero') && !el.hasAttribute('data-aos')) {
                el.setAttribute('data-aos', 'fade-up');
            }
        });

        // List items come in one after another, and so do the collage photos.
        document.querySelectorAll('.ls-why-list li').forEach(function (li, i) {
            li.setAttribute('data-aos', 'fade-up');
            li.setAttribute('data-aos-delay', String(Math.min(i, 5) * 100));
        });
        document.querySelectorAll('.ls-why-photo').forEach(function (photo, i) {
            photo.setAttribute('data-aos', 'fade-up');
            photo.setAttribute('data-aos-delay', String(i * 150));
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
