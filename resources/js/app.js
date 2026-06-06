import './bootstrap';

const setNavOpen = (button, menu, open) => {
    menu.classList.toggle('hidden', !open);
    button.setAttribute('aria-expanded', String(open));

    const top = button.querySelector('[data-nav-line="top"]');
    const middle = button.querySelector('[data-nav-line="middle"]');
    const bottom = button.querySelector('[data-nav-line="bottom"]');

    top?.classList.toggle('translate-y-2', open);
    top?.classList.toggle('rotate-45', open);
    middle?.classList.toggle('opacity-0', open);
    bottom?.classList.toggle('-translate-y-2', open);
    bottom?.classList.toggle('-rotate-45', open);
};

document.addEventListener('DOMContentLoaded', () => {
    const navButton = document.querySelector('[data-nav-toggle]');
    const mobileNav = document.querySelector('[data-mobile-nav]');

    if (navButton && mobileNav) {
        navButton.addEventListener('click', () => {
            const isOpen = navButton.getAttribute('aria-expanded') === 'true';
            setNavOpen(navButton, mobileNav, !isOpen);
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                setNavOpen(navButton, mobileNav, false);
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                setNavOpen(navButton, mobileNav, false);
            }
        });
    }

    document.querySelectorAll('[data-fill-status]').forEach((button) => {
        button.addEventListener('click', () => {
            const numberInput = document.querySelector('[name="registration_number"]');
            const birthDateInput = document.querySelector('[name="birth_date"]');

            if (numberInput instanceof HTMLInputElement) {
                numberInput.value = button.getAttribute('data-registration-number') ?? '';
            }

            if (birthDateInput instanceof HTMLInputElement) {
                birthDateInput.value = button.getAttribute('data-birth-date') ?? '';
            }
        });
    });

    document.querySelectorAll('[name="registration_number"]').forEach((input) => {
        input.addEventListener('input', () => {
            input.value = input.value.toUpperCase();
        });
    });

    document.querySelectorAll('[data-print-page]').forEach((button) => {
        button.addEventListener('click', () => {
            window.print();
        });
    });

    const tabButtons = document.querySelectorAll('[data-announcement-tab]');
    const tabPanels = document.querySelectorAll('[data-announcement-panel]');

    tabButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const target = button.getAttribute('data-announcement-tab');

            tabButtons.forEach((item) => {
                const isActive = item === button;
                item.classList.toggle('tab-button-active', isActive);
                item.setAttribute('aria-selected', String(isActive));
            });

            tabPanels.forEach((panel) => {
                panel.classList.toggle('hidden', panel.getAttribute('data-announcement-panel') !== target);
            });
        });
    });
});
