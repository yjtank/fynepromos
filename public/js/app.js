(() => {
    const root = document.documentElement;
    const setTheme = (theme) => {
        root.dataset.theme = theme;
        localStorage.setItem('fyne-theme', theme);
        document.querySelectorAll('[data-theme-toggle]').forEach((button) => button.setAttribute('aria-label', theme === 'dark' ? 'Ativar tema claro' : 'Ativar tema escuro'));
    };
    document.querySelectorAll('[data-theme-toggle]').forEach((button) => button.addEventListener('click', () => setTheme(root.dataset.theme === 'dark' ? 'light' : 'dark')));

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
