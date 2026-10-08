document.addEventListener("DOMContentLoaded", () => {
    const profile = document.querySelector("[data-admin-profile]");
    const trigger = profile?.querySelector("[data-profile-trigger]");
    const menu = profile?.querySelector('[role="menu"]');
    if (!profile || !trigger || !menu) {
        return;
    }

    const menuItems = Array.from(menu.querySelectorAll('[role="menuitem"]'));
    const setOpen = (isOpen, { focusFirst = false } = {}) => {
        profile.classList.toggle("is-open", isOpen);
        trigger.setAttribute("aria-expanded", String(isOpen));
        menu.setAttribute("aria-hidden", String(!isOpen));

        if (isOpen) {
            if (focusFirst) {
                menuItems[0]?.focus({ preventScroll: true });
            }
        }
    };

    trigger.addEventListener("click", () => {
        const isOpening = trigger.getAttribute("aria-expanded") !== "true";
        setOpen(isOpening, { focusFirst: isOpening });
    });

    document.addEventListener("click", (event) => {
        if (!profile.contains(event.target)) {
            setOpen(false);
        }

    });

    document.addEventListener("keydown", (event) => {
        if (!profile.classList.contains("is-open")) {
            return;
        }

        if (event.key === "Escape") {
            event.preventDefault();
            setOpen(false);
            trigger.focus();
            return;
        }

        const currentIndex = menuItems.indexOf(document.activeElement);
        let nextIndex = null;

        if (event.key === "ArrowDown") {
            nextIndex = currentIndex < 0 ? 0 : (currentIndex + 1) % menuItems.length;
        } else if (event.key === "ArrowUp") {
            nextIndex = currentIndex < 0 ? menuItems.length - 1 : (currentIndex - 1 + menuItems.length) % menuItems.length;
        } else if (event.key === "Home") {
            nextIndex = 0;
        } else if (event.key === "End") {
            nextIndex = menuItems.length - 1;
        }

        if (nextIndex !== null) {
            event.preventDefault();
            menuItems[nextIndex]?.focus();
        }
    });

    menu.addEventListener("click", (event) => {
        if (event.target.closest('[role="menuitem"]')) {
            setOpen(false);
        }
    });

    profile.addEventListener("focusout", () => {
        window.setTimeout(() => {
            if (!profile.contains(document.activeElement)) {
                setOpen(false);
            }
        }, 0);
    });
});
