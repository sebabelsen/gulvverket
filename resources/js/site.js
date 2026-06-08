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
