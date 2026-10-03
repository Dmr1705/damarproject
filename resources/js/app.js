import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

let isNavbarScrolled = false;

function updateNavbar() {
    const box = document.getElementById("navbar-box");

    if (!box) {
        return;
    }

    if (window.scrollY > 20 && !isNavbarScrolled) {
        isNavbarScrolled = true;
        box.classList.remove("py-4", "shadow-sm", "bg-white/90");
        box.classList.add("py-3", "shadow-md", "bg-white/95");
    } else if (window.scrollY <= 20 && isNavbarScrolled) {
        isNavbarScrolled = false;
        box.classList.remove("py-3", "shadow-md", "bg-white/95");
        box.classList.add("py-4", "shadow-sm", "bg-white/90");
    }
}

function initializePublicInteractions() {
    window.addEventListener("scroll", updateNavbar);

    const imageInput = document.getElementById("image");
    const imageFileName = document.getElementById("image-file-name");
    if (imageInput instanceof HTMLInputElement && imageFileName) {
        imageInput.addEventListener("change", () => {
            imageFileName.textContent =
                imageInput.files?.[0]?.name ?? "Format: JPG, PNG (Maks. 2MB)";
        });
    }

    const mobileMenuButton = document.getElementById("mobile-menu-button");
    const mobileMenu = document.getElementById("mobile-menu");
    if (mobileMenuButton && mobileMenu) {
        const setMobileMenuOpen = (isOpen) => {
            mobileMenuButton.setAttribute("aria-expanded", String(isOpen));
            mobileMenu.setAttribute("aria-hidden", String(!isOpen));
            mobileMenu.toggleAttribute("inert", !isOpen);
            mobileMenu.classList.toggle("grid-rows-[1fr]", isOpen);
            mobileMenu.classList.toggle("grid-rows-[0fr]", !isOpen);
            mobileMenu.classList.toggle("translate-y-0", isOpen);
            mobileMenu.classList.toggle("-translate-y-2", !isOpen);
            mobileMenu.classList.toggle("opacity-100", isOpen);
            mobileMenu.classList.toggle("opacity-0", !isOpen);
            mobileMenu.classList.toggle("pointer-events-auto", isOpen);
            mobileMenu.classList.toggle("pointer-events-none", !isOpen);
        };

        mobileMenuButton.addEventListener("click", () => {
            setMobileMenuOpen(
                mobileMenuButton.getAttribute("aria-expanded") !== "true",
            );
        });
        mobileMenu.querySelectorAll("a").forEach((link) => {
            link.addEventListener("click", () => {
                setMobileMenuOpen(false);
            });
        });
    }

    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", (event) => {
            const targetId = anchor.getAttribute("href");
            if (!targetId || targetId === "#") {
                return;
            }

            const targetElement = document.querySelector(targetId);
            if (!targetElement) {
                return;
            }

            event.preventDefault();
            window.scrollTo({
                top:
                    targetElement.getBoundingClientRect().top +
                    window.pageYOffset -
                    90,
                behavior: "smooth",
            });
        });
    });

    const reveals = document.querySelectorAll(".reveal");
    if (!("IntersectionObserver" in window)) {
        reveals.forEach((element) => element.classList.add("active"));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("active");
                }
            });
        },
        { threshold: 0.05 },
    );

    reveals.forEach((element) => observer.observe(element));

    document.querySelectorAll("[data-lightbox]").forEach((trigger) => {
        trigger.addEventListener("click", () => {
            const modal = document.createElement("div");
            modal.className =
                "fixed inset-0 z-[70] flex items-center justify-center bg-slate-950/90 p-4";
            modal.innerHTML = `<button type="button" aria-label="Tutup" class="absolute right-5 top-5 text-3xl text-white">&times;</button><img src="${trigger.dataset.lightbox}" alt="${trigger.dataset.title || ""}" class="max-h-[90vh] max-w-full rounded-2xl object-contain shadow-2xl">`;
            document.body.appendChild(modal);
            document.body.classList.add("lightbox-open");
            modal.addEventListener("click", (event) => {
                if (
                    event.target === modal ||
                    event.target.tagName === "BUTTON"
                ) {
                    modal.remove();
                    document.body.classList.remove("lightbox-open");
                }
            });
        });
    });
}

document.addEventListener("DOMContentLoaded", initializePublicInteractions);
