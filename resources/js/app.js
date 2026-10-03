import Alpine from "alpinejs";

document.documentElement.classList.add("js");
window.Alpine = Alpine;

Alpine.start();

function initializePublicInteractions() {
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
        document.addEventListener("keydown", (event) => {
            if (
                event.key === "Escape" &&
                mobileMenuButton.getAttribute("aria-expanded") === "true"
            ) {
                setMobileMenuOpen(false);
                mobileMenuButton.focus();
            }
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

            const targetElement = document.getElementById(targetId.slice(1));
            if (!targetElement) {
                return;
            }

            event.preventDefault();
            window.scrollTo({
                top:
                    targetElement.getBoundingClientRect().top +
                    window.pageYOffset -
                    90,
                behavior: window.matchMedia("(prefers-reduced-motion: reduce)")
                    .matches
                    ? "auto"
                    : "smooth",
            });
        });
    });

    const reveals = document.querySelectorAll(".reveal");
    const prefersReducedMotion = window.matchMedia(
        "(prefers-reduced-motion: reduce)",
    ).matches;
    if (prefersReducedMotion || !("IntersectionObserver" in window)) {
        reveals.forEach((element) => element.classList.add("active"));
    } else {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("active");
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.05 },
        );

        reveals.forEach((element) => observer.observe(element));
    }

    document.querySelectorAll("[data-lightbox]").forEach((trigger) => {
        trigger.addEventListener("click", () => {
            if (!(trigger instanceof HTMLElement)) {
                return;
            }

            const previousFocus = document.activeElement;
            const modal = document.createElement("div");
            modal.className =
                "fixed inset-0 z-[70] flex items-center justify-center bg-slate-950/90 p-4";
            modal.setAttribute("role", "dialog");
            modal.setAttribute("aria-modal", "true");
            modal.setAttribute("aria-label", trigger.dataset.title || "Pratinjau foto");
            modal.tabIndex = -1;

            const closeButton = document.createElement("button");
            closeButton.type = "button";
            closeButton.setAttribute("aria-label", "Tutup pratinjau foto");
            closeButton.className =
                "absolute right-5 top-5 flex h-11 w-11 items-center justify-center rounded-full bg-white/10 text-3xl leading-none text-white transition hover:bg-white/20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-white";
            closeButton.textContent = "×";

            const image = document.createElement("img");
            image.src = trigger.dataset.lightbox || "";
            image.alt = trigger.dataset.title || "";
            image.className =
                "max-h-[90vh] max-w-full rounded-2xl object-contain shadow-2xl";

            modal.append(closeButton, image);
            document.body.appendChild(modal);
            document.body.classList.add("lightbox-open");

            const closeModal = () => {
                modal.remove();
                document.body.classList.remove("lightbox-open");
                document.removeEventListener("keydown", handleKeydown);
                if (previousFocus instanceof HTMLElement) {
                    previousFocus.focus();
                }
            };

            const handleKeydown = (event) => {
                if (event.key === "Escape") {
                    closeModal();
                } else if (event.key === "Tab") {
                    event.preventDefault();
                    closeButton.focus();
                }
            };

            closeButton.addEventListener("click", closeModal);
            modal.addEventListener("click", (event) => {
                if (event.target === modal) {
                    closeModal();
                }
            });
            document.addEventListener("keydown", handleKeydown);
            closeButton.focus();
        });
    });
}

document.addEventListener("DOMContentLoaded", initializePublicInteractions);
