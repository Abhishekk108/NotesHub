/**
 * Noteshub — script.js
 * Hamburger nav, scroll-to-top, active nav link,
 * textarea character counter, toast notifications,
 * delete confirmation guard.
 */

/* ── Helpers ──────────────────────────────────────── */

const $ = (sel, ctx = document) => ctx.querySelector(sel);
const $$ = (sel, ctx = document) => [...ctx.querySelectorAll(sel)];

/* ── Mobile Navigation ────────────────────────────── */

(function initNav() {
    const toggle = $('#navToggle');
    const menu   = $('#navMenu');
    if (!toggle || !menu) return;

    toggle.addEventListener('click', () => {
        const isOpen = menu.classList.toggle('open');
        toggle.classList.toggle('open', isOpen);
        toggle.setAttribute('aria-expanded', String(isOpen));
    });

    // Close menu on outside click
    document.addEventListener('click', (e) => {
        if (!toggle.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.remove('open');
            toggle.classList.remove('open');
            toggle.setAttribute('aria-expanded', 'false');
        }
    });

    // Close on Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && menu.classList.contains('open')) {
            menu.classList.remove('open');
            toggle.classList.remove('open');
            toggle.setAttribute('aria-expanded', 'false');
            toggle.focus();
        }
    });
})();

/* ── Active Nav Link ──────────────────────────────── */

(function markActiveLink() {
    const current = window.location.pathname;
    $$('.site-nav a').forEach(link => {
        const url = new URL(link.href, window.location.origin);
        if (url.pathname === current) {
            link.classList.add('active');
            link.setAttribute('aria-current', 'page');
        }
    });
})();

/* ── Scroll-to-top ────────────────────────────────── */

(function initScrollTop() {
    const btn = $('#scrollTop');
    if (!btn) return;

    const threshold = 300;

    window.addEventListener('scroll', () => {
        btn.classList.toggle('visible', window.scrollY > threshold);
    }, { passive: true });

    btn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
})();

/* ── Toast Notifications ──────────────────────────── */

/**
 * Show a toast message.
 * @param {string} message  - Text to display
 * @param {'success'|'danger'|'warning'|''} type - Visual variant
 * @param {number} duration - Auto-dismiss delay in ms (0 = no auto-dismiss)
 */
function showToast(message, type = '', duration = 3500) {
    const container = $('#toastContainer');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = ['toast', type ? `toast-${type}` : ''].join(' ').trim();
    toast.textContent = message;
    toast.setAttribute('role', 'status');
    container.appendChild(toast);

    const dismiss = () => {
        toast.classList.add('hiding');
        toast.addEventListener('animationend', () => toast.remove(), { once: true });
    };

    if (duration > 0) setTimeout(dismiss, duration);

    // Click to dismiss early
    toast.addEventListener('click', dismiss);
}

/* ── Textarea Character Counter ───────────────────── */

(function initCharCounters() {
    $$('textarea[maxlength], textarea[data-maxlength]').forEach(textarea => {
        const max = parseInt(textarea.getAttribute('maxlength') ||
                             textarea.dataset.maxlength, 10);
        if (!max) return;

        const counter = document.createElement('span');
        counter.className = 'char-counter';
        counter.setAttribute('aria-live', 'polite');
        textarea.parentNode.insertBefore(counter, textarea.nextSibling);

        const update = () => {
            const remaining = max - textarea.value.length;
            counter.textContent = `${textarea.value.length} / ${max}`;
            counter.classList.toggle('near-limit', remaining <= max * 0.1 && remaining > 0);
            counter.classList.toggle('at-limit', remaining <= 0);
        };

        textarea.addEventListener('input', update);
        update(); // initialise
    });

    // Also attach to textareas without maxlength but with data-count
    $$('textarea.form-textarea:not([maxlength])').forEach(textarea => {
        const counter = document.createElement('span');
        counter.className = 'char-counter';
        counter.setAttribute('aria-live', 'polite');
        textarea.parentNode.insertBefore(counter, textarea.nextSibling);

        textarea.addEventListener('input', () => {
            counter.textContent = `${textarea.value.length} characters`;
        });
    });
})();

/* ── Delete Confirmation Guard ────────────────────── */

(function initDeleteGuard() {
    // Intercept any delete link that doesn't already have an onclick
    $$('a.action-delete:not([onclick])').forEach(link => {
        link.addEventListener('click', (e) => {
            if (!confirm('Are you sure you want to delete this? This cannot be undone.')) {
                e.preventDefault();
            }
        });
    });
})();

/* ── Auto-submit search form on select change ─────── */

(function initSearchAutoSubmit() {
    const form = $('form.search-bar');
    if (!form) return;

    $$('select', form).forEach(select => {
        select.addEventListener('change', () => form.submit());
    });
})();

/* ── Dismiss alerts on click ──────────────────────── */

(function initAlertDismiss() {
    $$('.alert').forEach(alert => {
        alert.style.cursor = 'pointer';
        alert.title = 'Click to dismiss';
        alert.addEventListener('click', () => {
            alert.style.transition = 'opacity 0.25s ease, max-height 0.3s ease';
            alert.style.opacity = '0';
            alert.style.maxHeight = '0';
            alert.style.overflow = 'hidden';
            setTimeout(() => alert.remove(), 320);
        });
    });
})();
