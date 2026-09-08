

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

let isNavbarScrolled = false;

function updateNavbar() {
    const wrapper = document.getElementById('navbar-wrapper');
    const box = document.getElementById('navbar-box');

    if (!wrapper || !box) {
        return;
    }

    if (window.scrollY > 20 && !isNavbarScrolled) {
        isNavbarScrolled = true;
        wrapper.classList.remove('py-4', 'px-4', 'sm:px-6');
        wrapper.classList.add('py-0', 'px-0');
        box.classList.remove('max-w-6xl', 'rounded-full', 'shadow-sm', 'border', 'border-emerald-500/20', 'py-3', 'px-6', 'md:px-10', 'bg-white/80', 'backdrop-blur-lg');
        box.classList.add('max-w-none', 'rounded-none', 'shadow-md', 'border-b', 'border-gray-200', 'py-3.5', 'px-4', 'sm:px-6', 'bg-white/95', 'backdrop-blur-md');
    } else if (window.scrollY <= 20 && isNavbarScrolled) {
        isNavbarScrolled = false;
        wrapper.classList.remove('py-0', 'px-0');
        wrapper.classList.add('py-4', 'px-4', 'sm:px-6');
        box.classList.remove('max-w-none', 'rounded-none', 'shadow-md', 'border-b', 'border-gray-200', 'py-3.5', 'px-4', 'sm:px-6', 'bg-white/95', 'backdrop-blur-md');
        box.classList.add('max-w-6xl', 'rounded-full', 'shadow-sm', 'border', 'border-emerald-500/20', 'py-3', 'px-6', 'md:px-10', 'bg-white/80', 'backdrop-blur-lg');
    }
}

function initializePublicInteractions() {
    window.addEventListener('scroll', updateNavbar);

    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            mobileMenu.classList.toggle('flex');
        });
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                mobileMenu.classList.remove('flex');
            });
        });
    }

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', event => {
            const targetId = anchor.getAttribute('href');
            if (!targetId || targetId === '#') {
                return;
            }

            const targetElement = document.querySelector(targetId);
            if (!targetElement) {
                return;
            }

            event.preventDefault();
            window.scrollTo({
                top: targetElement.getBoundingClientRect().top + window.pageYOffset - 90,
                behavior: 'smooth'
            });
        });
    });

    const reveals = document.querySelectorAll('.reveal');
    if (!('IntersectionObserver' in window)) {
        reveals.forEach(element => element.classList.add('active'));
        return;
    }

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.05 });

    reveals.forEach(element => observer.observe(element));

    document.querySelectorAll('[data-lightbox]').forEach(trigger => {
        trigger.addEventListener('click', () => {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 z-[70] flex items-center justify-center bg-slate-950/90 p-4';
            modal.innerHTML = `<button type="button" aria-label="Tutup" class="absolute right-5 top-5 text-3xl text-white">&times;</button><img src="${trigger.dataset.lightbox}" alt="${trigger.dataset.title || ''}" class="max-h-[90vh] max-w-full rounded-2xl object-contain shadow-2xl">`;
            document.body.appendChild(modal);
            document.body.classList.add('lightbox-open');
            modal.addEventListener('click', event => {
                if (event.target === modal || event.target.tagName === 'BUTTON') {
                    modal.remove();
                    document.body.classList.remove('lightbox-open');
                }
            });
        });
    });
}

document.addEventListener('DOMContentLoaded', initializePublicInteractions);
