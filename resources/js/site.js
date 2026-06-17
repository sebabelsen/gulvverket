// Nav: burger toggle + scroll detection
document.addEventListener('DOMContentLoaded', () => {
    const header = document.querySelector('.site-header');
    if (!header) return;

    // Burger toggle
    const burger = header.querySelector('.nav-burger');
    if (burger) {
        burger.addEventListener('click', () => {
            header.classList.toggle('is-open');
            const isOpen = header.classList.contains('is-open');
            burger.setAttribute('aria-expanded', isOpen);
        });
    }

    // Close dropdown when clicking a link inside it
    header.querySelectorAll('.nav-drop a').forEach((link) => {
        link.addEventListener('click', () => {
            header.classList.remove('is-open');
            burger?.setAttribute('aria-expanded', 'false');
        });
    });

    // Scroll detection — adds .is-scrolled after threshold
    const SCROLL_THRESHOLD = 20;
    let ticking = false;

    const onScroll = () => {
        if (!ticking) {
            requestAnimationFrame(() => {
                const scrolled = window.scrollY > SCROLL_THRESHOLD;
                header.classList.toggle('is-scrolled', scrolled);
                ticking = false;
            });
            ticking = true;
        }
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll(); // Set initial state
});

// Product page: interactive gallery, lightbox, quantity stepper
document.addEventListener('DOMContentLoaded', () => {
    const gallery = document.querySelector('[data-gallery]');

    if (gallery) {
        const mainImg = gallery.querySelector('[data-gallery-main-img]');
        const thumbs = Array.from(gallery.querySelectorAll('[data-gallery-thumb]'));

        // Thumbnail → swap main image
        const activate = (thumb) => {
            if (!thumb || !mainImg) return;
            mainImg.src = thumb.dataset.src;
            mainImg.alt = thumb.dataset.alt || '';
            thumbs.forEach((t) => t.classList.toggle('is-active', t === thumb));
        };

        thumbs.forEach((thumb) => {
            thumb.addEventListener('click', () => activate(thumb));
        });

        // Lightbox
        const lightbox = document.querySelector('[data-lightbox]');
        if (lightbox && mainImg) {
            const lbImg = lightbox.querySelector('[data-lightbox-img]');
            const openBtn = gallery.querySelector('[data-gallery-open]');
            const closeBtn = lightbox.querySelector('[data-lightbox-close]');
            const prevBtn = lightbox.querySelector('[data-lightbox-prev]');
            const nextBtn = lightbox.querySelector('[data-lightbox-next]');

            const sources = thumbs.length
                ? thumbs.map((t) => ({ src: t.dataset.full || t.dataset.src, alt: t.dataset.alt || '' }))
                : [{ src: mainImg.dataset.full || mainImg.src, alt: mainImg.alt }];

            const hasMany = sources.length > 1;
            if (prevBtn) prevBtn.hidden = !hasMany;
            if (nextBtn) nextBtn.hidden = !hasMany;

            let index = 0;
            const render = () => {
                index = (index + sources.length) % sources.length;
                lbImg.src = sources[index].src;
                lbImg.alt = sources[index].alt;
            };

            const open = () => {
                const active = thumbs.find((t) => t.classList.contains('is-active'));
                index = active ? thumbs.indexOf(active) : 0;
                render();
                lightbox.hidden = false;
                document.body.style.overflow = 'hidden';
                closeBtn?.focus();
            };
            const close = () => {
                lightbox.hidden = true;
                document.body.style.overflow = '';
                openBtn?.focus();
            };

            openBtn?.addEventListener('click', open);
            closeBtn?.addEventListener('click', close);
            prevBtn?.addEventListener('click', () => { index -= 1; render(); });
            nextBtn?.addEventListener('click', () => { index += 1; render(); });
            lightbox.addEventListener('click', (e) => {
                if (e.target === lightbox) close();
            });
            document.addEventListener('keydown', (e) => {
                if (lightbox.hidden) return;
                if (e.key === 'Escape') close();
                else if (e.key === 'ArrowLeft' && hasMany) { index -= 1; render(); }
                else if (e.key === 'ArrowRight' && hasMany) { index += 1; render(); }
            });
        }
    }

    // Quantity stepper
    document.querySelectorAll('[data-qty]').forEach((wrap) => {
        const input = wrap.querySelector('input[type="number"]');
        if (!input) return;
        const min = parseInt(input.min, 10) || 1;
        const val = () => parseInt(input.value, 10) || min;

        wrap.querySelector('[data-qty-dec]')?.addEventListener('click', () => {
            input.value = Math.max(min, val() - 1);
        });
        wrap.querySelector('[data-qty-inc]')?.addEventListener('click', () => {
            input.value = val() + 1;
        });
    });
});
