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

    const siteMenu = document.querySelector('[data-site-menu]');
    const siteMenuToggle = document.querySelector('[data-site-menu-toggle]');
    const setSiteMenu = (open) => {
        document.body.classList.toggle('site-menu-open', open);
        siteMenuToggle?.setAttribute('aria-expanded', String(open));
    };
    siteMenuToggle?.addEventListener('click', () => setSiteMenu(!document.body.classList.contains('site-menu-open')));
    document.querySelectorAll('[data-site-menu-close]').forEach((button) => button.addEventListener('click', () => setSiteMenu(false)));
    siteMenu?.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => setSiteMenu(false)));
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') setSiteMenu(false);
    });

    document.querySelectorAll('[data-copy]').forEach((button) => button.addEventListener('click', async () => {
        try {
            await navigator.clipboard.writeText(button.dataset.copy || '');
            const original = button.textContent;
            button.textContent = 'Cupom copiado!';
            setTimeout(() => { button.textContent = original; }, 1800);
        } catch (_) {}
    }));

    document.querySelectorAll('[data-price-mode]').forEach((button) => {
        button.addEventListener('click', () => {
            const mode = button.dataset.priceMode;
            const summary = button.closest('.product-summary');
            const card = summary?.querySelector('.product-price-card');
            if (!card) return;

            button.parentElement.querySelectorAll('[data-price-mode]').forEach((tab) => {
                const active = tab === button;
                tab.classList.toggle('is-active', active);
                tab.setAttribute('aria-pressed', String(active));
            });

            card.querySelector('[data-cash-price]')?.toggleAttribute('hidden', mode !== 'cash');
            card.querySelector('[data-installment-price]')?.toggleAttribute('hidden', mode !== 'installments');
            card.querySelector('[data-installment-detail]')?.toggleAttribute('hidden', mode !== 'installments');

            const description = card.querySelector('[data-price-description]');
            if (description) {
                description.textContent = mode === 'installments'
                    ? description.dataset.installmentDescription
                    : description.dataset.cashDescription;
            }
        });
    });
})();
