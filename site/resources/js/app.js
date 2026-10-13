// Navigation and search work without JavaScript. Escape closes the native mobile menu.
document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        const menu = document.querySelector('.mobile-menu[open]');
        if (menu) {
            menu.removeAttribute('open');
            menu.querySelector('summary').focus();
        }
    }
});

// Desktop starts expanded; compact screens get a disclosure to save space.
const compactListing = window.matchMedia('(max-width: 720px)');
const syncListingFilters = () => {
    document.querySelectorAll('.listing-filters').forEach((filters) => {
        if (compactListing.matches) {
            filters.removeAttribute('open');
        } else {
            filters.setAttribute('open', '');
        }
    });
};

syncListingFilters();
compactListing.addEventListener('change', syncListingFilters);

document.querySelectorAll('[data-listing-form]').forEach((form) => {
    form.addEventListener('submit', () => {
        const results = document.querySelector('#catalogue-results');
        const status = document.querySelector('[data-loading-status]');
        results?.setAttribute('aria-busy', 'true');
        if (status) status.hidden = false;
    });
});
