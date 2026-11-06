/* Look Sri Lanka — redesign scripts (no dependencies). */
(function () {
    'use strict';


    // A non-modal chatbox beside the launcher keeps the page usable and clear.
    var waDialog = document.getElementById('ls-wa-dialog');
    var waLauncher = document.querySelector('.ls-wa');
    var waTrigger = null;
    if (waDialog && typeof waDialog.show === 'function') {
        var waQuestion = document.getElementById('ls-wa-question');
        var waMessages = waDialog.querySelector('.ls-wa-chat-messages');
        var waReturnFocus = false;
        var waFrame = false;
        function appendWaMessage(text, isQuestion) {
            var bubble = document.createElement('div');
            bubble.className = 'ls-wa-chat-bubble' + (isQuestion ? ' ls-wa-chat-user' : ' ls-wa-chat-reply');
            bubble.textContent = text;
            waMessages.appendChild(bubble);
        }
        function positionWaChat() {
            if (!waDialog.open || !waLauncher) return;
            var icon = waLauncher.getBoundingClientRect();
            var bottom = Math.max(12, window.innerHeight - icon.top + 12);
            waDialog.style.bottom = bottom + 'px';
            waDialog.style.right = Math.max(12, window.innerWidth - icon.right) + 'px';
            waDialog.style.maxHeight = Math.max(120, window.innerHeight - bottom - 12) + 'px';
        }
        function scheduleWaPosition() {
            if (!waDialog.open || waFrame) return;
            waFrame = true;
            window.requestAnimationFrame(function () {
                positionWaChat();
                waFrame = false;
            });
        }
        function closeWaChat(returnFocus) {
            waReturnFocus = returnFocus;
            waDialog.close();
        }
        document.querySelectorAll('a[href]').forEach(function (link) {
            var url = new URL(link.href, window.location.href);
            if (['wa.me', 'api.whatsapp.com', 'web.whatsapp.com'].indexOf(url.hostname) === -1) return;
            link.setAttribute('aria-haspopup', 'dialog');
            link.setAttribute('aria-controls', 'ls-wa-dialog');
            link.setAttribute('aria-expanded', 'false');
            link.addEventListener('click', function (event) {
                event.preventDefault();
                if (waDialog.open && link === waLauncher) {
                    closeWaChat(true);
                    return;
                }
                waTrigger = link;
                if (!waDialog.open) waDialog.show();
                link.setAttribute('aria-expanded', 'true');
                if (waLauncher) waLauncher.setAttribute('aria-expanded', 'true');
                positionWaChat();
            });
        });
        waDialog.querySelector('.ls-wa-close').addEventListener('click', function () {
            closeWaChat(true);
        });
        waDialog.querySelectorAll('[data-ls-wa-question]').forEach(function (button) {
            button.addEventListener('click', function () {
                waDialog.querySelectorAll('[data-ls-wa-question]').forEach(function (item) {
                    item.setAttribute('aria-pressed', String(item === button));
                });
                waQuestion.value = button.getAttribute('data-ls-wa-question');
                appendWaMessage(waQuestion.value, true);
                var answer = button.getAttribute('data-ls-wa-answer-text');
                if (answer) appendWaMessage(answer, false);
                waMessages.scrollTop = waMessages.scrollHeight;
            });
        });
        var waMoreQuestions = waDialog.querySelector('[data-ls-wa-more]');
        if (waMoreQuestions) {
            waMoreQuestions.addEventListener('click', function () {
                var expanded = waMoreQuestions.getAttribute('aria-expanded') !== 'true';
                waDialog.querySelectorAll('[data-ls-wa-question]').forEach(function (button, index) {
                    button.hidden = !expanded && index >= 4;
                });
                waMoreQuestions.setAttribute('aria-expanded', String(expanded));
                waMoreQuestions.textContent = waMoreQuestions.getAttribute(expanded ? 'data-label-fewer' : 'data-label-more');
                if (!expanded) waDialog.querySelector('.ls-wa-question-list').scrollTop = 0;
                scheduleWaPosition();
            });
        }
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && waDialog.open) closeWaChat(true);
        });
        document.addEventListener('click', function (event) {
            if (!waDialog.open || waDialog.contains(event.target)) return;
            if (event.target.closest('a[aria-controls="ls-wa-dialog"]')) return;
            closeWaChat(false);
        });
        waDialog.addEventListener('close', function () {
            document.querySelectorAll('a[aria-controls="ls-wa-dialog"]').forEach(function (link) {
                link.setAttribute('aria-expanded', 'false');
            });
            if (waReturnFocus && waTrigger) waTrigger.focus();
            waReturnFocus = false;
        });
        window.addEventListener('resize', scheduleWaPosition);
        window.addEventListener('scroll', scheduleWaPosition, { passive: true });
        if ('ResizeObserver' in window && waLauncher) {
            var waPositionObserver = new ResizeObserver(scheduleWaPosition);
            waPositionObserver.observe(waLauncher);
            waPositionObserver.observe(document.body);
        }
    }

    // Itinerary enquiry bar appears after the hero leaves the header.
    var tourBar = document.querySelector('[data-ls-tour-scrollbar]');
    var tourHero = document.querySelector('.single-tour .ls-page-hero');
    if (tourBar && tourHero) {
        var tourFrame = false;
        var updateTourBar = function () {
            var siteHeader = document.querySelector('.ls-header');
            var adminBar = document.getElementById('wpadminbar');
            var top = Math.max(0, siteHeader ? siteHeader.getBoundingClientRect().bottom : 0,
                adminBar ? adminBar.getBoundingClientRect().bottom : 0);
            var visible = tourHero.getBoundingClientRect().bottom <= top;
            tourBar.hidden = !visible;
            if (visible) {
                document.documentElement.style.setProperty('--ls-tour-bar-height', tourBar.getBoundingClientRect().height + 'px');
            }
            tourBar.style.top = 'auto';
            document.documentElement.style.setProperty('--ls-tour-bar-bottom', top + 'px');
            tourFrame = false;
        };
        var scheduleTourBar = function () {
            if (!tourFrame) {
                tourFrame = true;
                window.requestAnimationFrame(updateTourBar);
            }
        };
        window.addEventListener('scroll', scheduleTourBar, { passive: true });
        window.addEventListener('resize', scheduleTourBar);
        if ('ResizeObserver' in window) {
            var tourSizeObserver = new ResizeObserver(scheduleTourBar);
            tourSizeObserver.observe(tourBar);
            var tourHeader = document.querySelector('.ls-header');
            if (tourHeader) tourSizeObserver.observe(tourHeader);
        }
        updateTourBar();
    }

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

    // A menu opened on mobile must not keep the desktop header in its open state.
    if (burger && menu) {
        var desktopMenu = window.matchMedia('(min-width: 1081px)');
        desktopMenu.addEventListener('change', function (event) {
            if (event.matches && !menu.hidden) {
                menu.hidden = true;
                burger.setAttribute('aria-expanded', 'false');
                burger.setAttribute('aria-label', 'Open menu');
                if (header) header.classList.remove('is-open');
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
        if (!track) return;
        var prev = carousel.querySelector('[data-ls-step="-1"]');
        var next = carousel.querySelector('[data-ls-step="1"]');
        if (!prev || !next) return;
        var nav = carousel.querySelector('.ls-hdest-nav');

        var step = function () {
            var card = track.firstElementChild;
            var gap = parseFloat(getComputedStyle(track).columnGap || getComputedStyle(track).gap) || 0;
            return card ? card.getBoundingClientRect().width + gap : track.clientWidth;
        };
        var update = function () {
            var max = track.scrollWidth - track.clientWidth;
            if (nav) {
                nav.hidden = max < 4;
            } else {
                prev.hidden = max < 4;
                next.hidden = max < 4;
            }
            prev.disabled = track.scrollLeft <= 2;
            next.disabled = track.scrollLeft >= max - 2;
        };

        carousel.addEventListener('click', function (e) {
            var btn = e.target.closest('[data-ls-step]');
            if (btn && !btn.disabled) {
                track.scrollBy({ left: step() * parseInt(btn.getAttribute('data-ls-step'), 10), behavior: 'smooth' });
            }
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

        // Hidden slides are inert until needed, rather than competing with the hero.
        function prepareSlide(n) {
            var slide = slides[(n + slides.length) % slides.length];
            var template = slide.querySelector('.ls-slide-photo');
            if (template) {
                var image = template.content.querySelector('img');
                if (image) image.loading = 'eager';
                template.replaceWith(template.content.cloneNode(true));
            }
        }

        function prepareNext() {
            if (!reduced && !document.hidden) prepareSlide(current + 1);
        }

        function show(n) {
            prepareSlide(n);
            slides[current].classList.remove('is-active');
            slides[current].setAttribute('aria-hidden', 'true');
            dots[current] && dots[current].classList.remove('is-active');

            current = (n + slides.length) % slides.length;

            slides[current].classList.add('is-active');
            slides[current].removeAttribute('aria-hidden');
            dots[current] && dots[current].classList.add('is-active');
            window.setTimeout(prepareNext, 1000);
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

        // Warm just the next slide after the first image finishes downloading.
        var firstImage = slides[0].querySelector('img');
        if (firstImage && !firstImage.complete) {
            firstImage.addEventListener('load', function () {
                window.setTimeout(prepareNext, 1000);
            }, { once: true });
        } else {
            window.setTimeout(prepareNext, 1000);
        }

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

    // Filter the complete set before splitting itinerary cards into pages.
    document.querySelectorAll('[data-ls-filter]').forEach(function (bar) {
        var grid = document.querySelector(bar.getAttribute('data-ls-filter'));
        if (!grid) return;
        var cards = Array.prototype.slice.call(grid.querySelectorAll('[data-region]'));
        var pager = document.getElementById(grid.id + '-pages');
        var perPage = parseInt(grid.getAttribute('data-per-page'), 10) || 0;
        var page = 1;
        var region = 'all';
        var emptyMsg = grid.parentElement.querySelector('.ls-empty-filter');

        function render() {
            var matches = cards.filter(function (card) {
                return region === 'all' || (' ' + card.getAttribute('data-region') + ' ').indexOf(' ' + region + ' ') !== -1;
            });
            var pages = perPage ? Math.ceil(matches.length / perPage) : 1;
            page = Math.max(1, Math.min(page, pages || 1));
            cards.forEach(function (card) { card.hidden = true; });
            var visible = perPage ? matches.slice((page - 1) * perPage, page * perPage) : matches;
            visible.forEach(function (card) { card.hidden = false; });
            if (emptyMsg) emptyMsg.hidden = matches.length > 0;
            if (!pager || !perPage) return;
            pager.hidden = pages <= 1;
            var links = pager.querySelector('.nav-links');
            links.replaceChildren();
            if (pages <= 1) return;
            function button(text, target, label, disabled, current, direction) {
                var item = document.createElement('button');
                item.type = 'button';
                item.className = 'page-numbers' + (current ? ' current' : '');
                if (direction) {
                    var icon = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                    icon.setAttribute('viewBox', '0 0 24 24');
                    icon.setAttribute('width', '18');
                    icon.setAttribute('height', '18');
                    icon.setAttribute('aria-hidden', 'true');
                    icon.setAttribute('focusable', 'false');
                    var arrow = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                    arrow.setAttribute('d', direction === 'previous' ? 'M14 7l-5 5 5 5' : 'M10 7l5 5-5 5');
                    arrow.setAttribute('fill', 'none');
                    arrow.setAttribute('stroke', 'currentColor');
                    arrow.setAttribute('stroke-width', '2');
                    arrow.setAttribute('stroke-linecap', 'round');
                    arrow.setAttribute('stroke-linejoin', 'round');
                    icon.appendChild(arrow);
                    item.appendChild(icon);
                } else {
                    item.textContent = text;
                }
                item.setAttribute('aria-label', label);
                item.setAttribute('aria-controls', grid.id);
                item.setAttribute('data-page', String(target));
                if (current) item.setAttribute('aria-current', 'page');
                item.disabled = disabled;
                links.appendChild(item);
            }
            button('', page - 1, pager.getAttribute('data-previous'), page === 1, false, 'previous');
            for (var number = 1; number <= pages; number++) {
                button(String(number), number, pager.getAttribute('data-page-label') + ' ' + number, false, number === page);
            }
            button('', page + 1, pager.getAttribute('data-next'), page === pages, false, 'next');
        }
        bar.addEventListener('click', function (event) {
            var btn = event.target.closest('button[data-region]');
            if (!btn) return;
            region = btn.getAttribute('data-region');
            page = 1;
            bar.querySelectorAll('button').forEach(function (item) {
                item.classList.toggle('is-active', item === btn);
                item.setAttribute('aria-pressed', String(item === btn));
            });
            render();
        });
        if (pager && perPage) {
            pager.addEventListener('click', function (event) {
                var btn = event.target.closest('button[data-page]');
                if (!btn || btn.disabled) return;
                page = parseInt(btn.getAttribute('data-page'), 10);
                render();
                var current = pager.querySelector('[aria-current="page"]');
                if (current) current.focus({ preventScroll: true });
                grid.scrollIntoView({ block: 'start', behavior: 'instant' });
            });
        }
        render();
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
            '.ls-gl-grid', '.ls-hg-grid', '.ls-blog-layout',
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
