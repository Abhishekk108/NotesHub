/**
 * Noteshub — script.js
 * Mobile nav toggle, active nav link, scroll-to-top,
 * search auto-submit, delete confirmation guard.
 */

/* ── Mobile Navigation ──────────────────────────── */
(function () {
    const toggle = document.getElementById('navToggle');
    const menu   = document.getElementById('navMenu');
    if (!toggle || !menu) return;

    toggle.addEventListener('click', () => {
        const isOpen = menu.classList.toggle('open');
        toggle.setAttribute('aria-expanded', String(isOpen));
    });

    document.addEventListener('click', (e) => {
        if (!toggle.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.remove('open');
            toggle.setAttribute('aria-expanded', 'false');
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && menu.classList.contains('open')) {
            menu.classList.remove('open');
            toggle.setAttribute('aria-expanded', 'false');
            toggle.focus();
        }
    });
})();

/* ── Active Nav Link ────────────────────────────── */
(function () {
    const current = window.location.pathname;
    document.querySelectorAll('.site-nav a, nav a').forEach(link => {
        try {
            const url = new URL(link.href, window.location.origin);
            if (url.pathname === current) {
                link.classList.add('text-blue-600', 'bg-blue-50');
                link.setAttribute('aria-current', 'page');
            }
        } catch (_) {}
    });
})();

/* ── Scroll-to-top ──────────────────────────────── */
(function () {
    const btn = document.getElementById('scrollTop');
    if (!btn) return;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            btn.classList.remove('opacity-0', 'pointer-events-none');
            btn.classList.add('opacity-100');
        } else {
            btn.classList.add('opacity-0', 'pointer-events-none');
            btn.classList.remove('opacity-100');
        }
    }, { passive: true });

    btn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
})();

/* ── Search: auto-submit on select change ───────── */
(function () {
    const form = document.querySelector('form[role="search"]');
    if (!form) return;
    form.querySelectorAll('select').forEach(sel => {
        sel.addEventListener('change', () => form.submit());
    });
})();
