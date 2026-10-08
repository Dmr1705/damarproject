document.addEventListener("DOMContentLoaded", () => {
    const shell = document.querySelector("[data-admin-shell]");
    const toggle = document.querySelector("[data-admin-toggle]");
    const closeButton = document.querySelector("[data-admin-close]");
    const overlay = document.querySelector("[data-admin-overlay]");
    const sidebar = document.querySelector("[data-admin-sidebar]");

    if (!shell || !toggle || !sidebar) {
        return;
    }

    const mobileQuery = window.matchMedia("(max-width: 992px)");
    const setOpen = (isOpen) => {
        shell.classList.toggle("is-sidebar-open", isOpen && mobileQuery.matches);
        if (!mobileQuery.matches) {
            shell.classList.remove("is-sidebar-open");
        }
        toggle.setAttribute("aria-expanded", String(isOpen));
        sidebar.setAttribute("aria-hidden", String(mobileQuery.matches && !isOpen));
        sidebar.toggleAttribute("inert", mobileQuery.matches && !isOpen);
        document.body.classList.toggle("admin-drawer-open", isOpen && mobileQuery.matches);
    };

    setOpen(!mobileQuery.matches);

    toggle.addEventListener("click", () => {
        if (mobileQuery.matches) {
            setOpen(toggle.getAttribute("aria-expanded") !== "true");
        } else {
            shell.classList.toggle("is-collapsed");
            toggle.setAttribute("aria-expanded", String(!shell.classList.contains("is-collapsed")));
        }
    });

    closeButton?.addEventListener("click", () => {
        setOpen(false);
        toggle.focus();
    });
    overlay?.addEventListener("click", () => {
        setOpen(false);
        toggle.focus();
    });

    sidebar.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", () => {
            if (mobileQuery.matches) {
                setOpen(false);
            }
        });
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && shell.classList.contains("is-sidebar-open")) {
            setOpen(false);
            toggle.focus();
        }
    });

    mobileQuery.addEventListener("change", () => {
        shell.classList.remove("is-sidebar-open");
        document.body.classList.remove("admin-drawer-open");
        sidebar.removeAttribute("inert");
        sidebar.removeAttribute("aria-hidden");
        toggle.setAttribute("aria-expanded", String(!shell.classList.contains("is-collapsed")));
    });

    const confirmationDialog = document.querySelector("[data-confirm-dialog]");
    const confirmationMessage = document.getElementById("admin-confirm-message");
    const cancelConfirmation = document.querySelector("[data-confirm-cancel]");
    const proceedConfirmation = document.querySelector("[data-confirm-proceed]");
    let pendingDeleteForm = null;

    document.querySelectorAll("[data-confirm-delete]").forEach((form) => {
        form.addEventListener("submit", (event) => {
            if (form.dataset.confirmed === "true") {
                delete form.dataset.confirmed;
                return;
            }

            if (!(confirmationDialog instanceof HTMLDialogElement)) {
                if (!window.confirm(form.dataset.confirmMessage || "Hapus data ini secara permanen?")) {
                    event.preventDefault();
                }
                return;
            }

            event.preventDefault();
            pendingDeleteForm = form;
            if (confirmationMessage) {
                confirmationMessage.textContent = form.dataset.confirmMessage || "Data yang dihapus tidak dapat dipulihkan.";
            }
            confirmationDialog.showModal();
            cancelConfirmation?.focus();
        });
    });

    cancelConfirmation?.addEventListener("click", () => confirmationDialog?.close());
    confirmationDialog?.addEventListener("close", () => {
        pendingDeleteForm = null;
    });
    proceedConfirmation?.addEventListener("click", () => {
        if (!pendingDeleteForm) {
            return;
        }

        const form = pendingDeleteForm;
        pendingDeleteForm = null;
        confirmationDialog?.close();
        form.dataset.confirmed = "true";
        form.requestSubmit();
    });

    document.querySelectorAll("[data-flash-message]").forEach((message) => {
        window.setTimeout(() => message.classList.add("is-dismissed"), 6000);
    });
});
