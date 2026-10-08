document.documentElement.classList.add("js");

function initializeLandingPage() {
    const siteHeader = document.querySelector("[data-site-header]");
    const menuToggle = document.querySelector("[data-menu-toggle]");
    const mobileMenu = document.querySelector("[data-mobile-menu]");
    const menuClose = document.querySelector("[data-menu-close]");
    const menuBackdrop = document.querySelector("[data-menu-backdrop]");
    const searchToggle = document.querySelector("[data-search-toggle]");
    const desktopSearch = document.querySelector("[data-desktop-search]");
    const reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)");

    const setMenuOpen = (isOpen) => {
        if (!menuToggle || !mobileMenu) {
            return;
        }

        menuToggle.setAttribute("aria-expanded", String(isOpen));
        menuToggle.setAttribute("aria-label", isOpen ? "Tutup menu" : "Buka menu");
        mobileMenu.setAttribute("aria-hidden", String(!isOpen));
        mobileMenu.toggleAttribute("inert", !isOpen);
        mobileMenu.classList.toggle("is-open", isOpen);
        document.body.classList.toggle("menu-open", isOpen);

        if (isOpen) {
            menuClose?.focus();
        } else {
            menuToggle.focus();
        }
    };

    menuToggle?.addEventListener("click", () => {
        setMenuOpen(menuToggle.getAttribute("aria-expanded") !== "true");
    });
    menuClose?.addEventListener("click", () => setMenuOpen(false));
    menuBackdrop?.addEventListener("click", () => setMenuOpen(false));
    mobileMenu?.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", () => setMenuOpen(false));
    });
    mobileMenu?.addEventListener("keydown", (event) => {
        if (event.key !== "Tab") {
            return;
        }

        const focusableItems = [...mobileMenu.querySelectorAll("a, button, input")];
        const firstItem = focusableItems[0];
        const lastItem = focusableItems[focusableItems.length - 1];

        if (event.shiftKey && document.activeElement === firstItem) {
            event.preventDefault();
            lastItem?.focus();
        } else if (!event.shiftKey && document.activeElement === lastItem) {
            event.preventDefault();
            firstItem?.focus();
        }
    });

    const setSearchOpen = (isOpen) => {
        if (!searchToggle || !desktopSearch) {
            return;
        }

        searchToggle.setAttribute("aria-expanded", String(isOpen));
        searchToggle.setAttribute("aria-label", isOpen ? "Tutup pencarian" : "Buka pencarian");
        desktopSearch.setAttribute("aria-hidden", String(!isOpen));
        desktopSearch.toggleAttribute("inert", !isOpen);
        desktopSearch.classList.toggle("is-open", isOpen);

        if (isOpen) {
            desktopSearch.querySelector("input")?.focus();
        }
    };

    searchToggle?.addEventListener("click", () => {
        if (window.matchMedia("(max-width: 992px)").matches) {
            setMenuOpen(true);
            mobileMenu?.querySelector("[data-search-input]")?.focus();
            return;
        }

        setSearchOpen(searchToggle.getAttribute("aria-expanded") !== "true");
    });

    document.addEventListener("click", (event) => {
        if (
            searchToggle?.getAttribute("aria-expanded") === "true" &&
            !desktopSearch?.contains(event.target) &&
            !searchToggle.contains(event.target)
        ) {
            setSearchOpen(false);
        }
    });

    document.addEventListener("keydown", (event) => {
        if (event.key !== "Escape") {
            return;
        }

        if (menuToggle?.getAttribute("aria-expanded") === "true") {
            setMenuOpen(false);
        }

        if (searchToggle?.getAttribute("aria-expanded") === "true") {
            setSearchOpen(false);
            searchToggle.focus();
        }
    });

    const updateHeader = () => {
        siteHeader?.classList.toggle("is-scrolled", window.scrollY > 12);
    };

    updateHeader();
    window.addEventListener("scroll", updateHeader, { passive: true });

    const revealElements = document.querySelectorAll(".reveal");
    if (reducedMotion.matches || !("IntersectionObserver" in window)) {
        revealElements.forEach((element) => element.classList.add("is-visible"));
    } else {
        const revealObserver = new IntersectionObserver(
            (entries, observer) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("is-visible");
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.12, rootMargin: "0px 0px -32px 0px" },
        );

        revealElements.forEach((element) => revealObserver.observe(element));
    }

    const searchInputs = document.querySelectorAll("[data-search-input]");

    searchInputs.forEach((input) => {
        input.addEventListener("input", () => {
            searchInputs.forEach((peer) => {
                if (peer !== input) {
                    peer.value = input.value;
                }
            });
        });
    });

    if ("IntersectionObserver" in window && siteHeader) {
        const sectionLinks = [...document.querySelectorAll(".desktop-nav__link")];
        const sections = sectionLinks
            .map((link) => document.getElementById(link.getAttribute("href").split("#").pop()))
            .filter((section) => section instanceof HTMLElement);

        const sectionObserver = new IntersectionObserver(
            (entries) => {
                const activeEntry = entries
                    .filter((entry) => entry.isIntersecting)
                    .sort((first, second) => second.intersectionRatio - first.intersectionRatio)[0];

                if (!activeEntry) {
                    return;
                }

                sectionLinks.forEach((link) => {
                    const isActive = link.getAttribute("href").endsWith(`#${activeEntry.target.id}`);
                    link.classList.toggle("is-active", isActive);
                    if (isActive) {
                        link.setAttribute("aria-current", "location");
                    } else {
                        link.removeAttribute("aria-current");
                    }
                });
            },
            { rootMargin: "-25% 0px -60% 0px", threshold: [0, 0.25, 0.5] },
        );

        sections.forEach((section) => sectionObserver.observe(section));
    }

    const counters = document.querySelectorAll("[data-counter]");
    if (reducedMotion.matches || !("IntersectionObserver" in window)) {
        counters.forEach((counter) => {
            counter.textContent = new Intl.NumberFormat("id-ID").format(Number(counter.dataset.counter));
        });
    } else {
        const counterObserver = new IntersectionObserver(
            (entries, observer) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) {
                        return;
                    }

                    const counter = entry.target;
                    const target = Number(counter.dataset.counter);
                    const startTime = performance.now();
                    const duration = 1050;

                    const animateCounter = (now) => {
                        const progress = Math.min((now - startTime) / duration, 1);
                        const eased = 1 - Math.pow(1 - progress, 4);
                        counter.textContent = new Intl.NumberFormat("id-ID").format(Math.round(target * eased));

                        if (progress < 1) {
                            requestAnimationFrame(animateCounter);
                        }
                    };

                    requestAnimationFrame(animateCounter);
                    observer.unobserve(counter);
                });
            },
            { threshold: 0.55 },
        );

        counters.forEach((counter) => counterObserver.observe(counter));
    }
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initializeLandingPage, { once: true });
} else {
    initializeLandingPage();
}
