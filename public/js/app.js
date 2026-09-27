(() => {
    const menu = document.querySelector('[data-admin-menu]');
    const toggle = document.querySelector('[data-menu-toggle]');
    const close = document.querySelector('[data-menu-close]');
    const setMenu = (open) => {
        document.body.classList.toggle('menu-open', open);
        toggle?.setAttribute('aria-expanded', String(open));
    };
    toggle?.addEventListener('click', () => setMenu(!document.body.classList.contains('menu-open')));
    close?.addEventListener('click', () => setMenu(false));
    menu?.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => setMenu(false)));

    document.querySelectorAll('[data-copy]').forEach((button) => button.addEventListener('click', async () => {
        try {
            await navigator.clipboard.writeText(button.dataset.copy || '');
            const original = button.textContent;
            button.textContent = 'Cupom copiado!';
            setTimeout(() => { button.textContent = original; }, 1800);
        } catch (_) {}
    }));
})();
