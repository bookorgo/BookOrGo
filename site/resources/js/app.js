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
