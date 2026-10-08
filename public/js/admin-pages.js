document.addEventListener("DOMContentLoaded", () => {
    const countElements = document.querySelectorAll("[data-count-up]");

    countElements.forEach((element) => {
        const target = Number.parseInt(element.dataset.countUp || "0", 10);
        if (!Number.isFinite(target) || target <= 0) {
            element.textContent = String(Math.max(0, target || 0));
            return;
        }

        const duration = window.matchMedia("(prefers-reduced-motion: reduce)").matches ? 0 : 650;
        const start = performance.now();
        const update = (now) => {
            const progress = duration === 0 ? 1 : Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            element.textContent = String(Math.round(target * eased));
            if (progress < 1) {
                window.requestAnimationFrame(update);
            }
        };

        window.requestAnimationFrame(update);
    });

    const tabRoot = document.querySelector("[data-profile-tabs]");
    if (tabRoot) {
        const tabs = Array.from(tabRoot.querySelectorAll("[data-profile-tab]"));
        const panels = Array.from(tabRoot.querySelectorAll("[data-profile-panel]"));
        const accountSettings = document.querySelector("[data-account-settings]");

        const activateTab = (name, { focus = false, updateHash = false } = {}) => {
            const selectedTab = tabs.find((tab) => tab.dataset.profileTab === name);
            if (!selectedTab) {
                return;
            }

            tabs.forEach((tab) => {
                const isSelected = tab === selectedTab;
                tab.setAttribute("aria-selected", String(isSelected));
                tab.tabIndex = isSelected ? 0 : -1;
            });
            panels.forEach((panel) => {
                panel.hidden = panel.dataset.profilePanel !== name;
            });

            if (accountSettings) {
                accountSettings.dataset.activeTab = name;
            }
            if (updateHash) {
                window.history.replaceState(null, "", `#${encodeURIComponent(name)}`);
            }
            if (focus) {
                selectedTab.focus();
            }
        };

        tabs.forEach((tab, index) => {
            tab.addEventListener("click", () => activateTab(tab.dataset.profileTab, { updateHash: true }));
            tab.addEventListener("keydown", (event) => {
                let nextIndex = null;
                if (event.key === "ArrowRight") {
                    nextIndex = (index + 1) % tabs.length;
                } else if (event.key === "ArrowLeft") {
                    nextIndex = (index - 1 + tabs.length) % tabs.length;
                } else if (event.key === "Home") {
                    nextIndex = 0;
                } else if (event.key === "End") {
                    nextIndex = tabs.length - 1;
                }

                if (nextIndex !== null) {
                    event.preventDefault();
                    activateTab(tabs[nextIndex].dataset.profileTab, { focus: true, updateHash: true });
                }
            });
        });

        const initialTab = window.location.hash.slice(1)
            || accountSettings?.dataset.activeTab
            || "informasi";
        activateTab(initialTab);
    }

    const photoInput = document.querySelector("[data-profile-photo-input]");
    const photoTrigger = document.querySelector("[data-profile-photo-trigger]");
    const photoDropzone = document.querySelector("[data-profile-photo-dropzone]");
    const photoPreview = document.querySelector("[data-profile-photo-preview]");
    const photoPreviewImage = document.querySelector("[data-profile-photo-preview-image]");
    const photoFilename = document.querySelector("[data-profile-photo-filename]");
    const photoClientError = document.querySelector("[data-photo-client-error]");
    const clearPhotoButton = document.querySelector("[data-clear-profile-photo]");
    const avatarImage = document.querySelector("[data-profile-avatar-image]");
    const avatarInitials = document.querySelector("[data-profile-avatar-initials]");
    let photoObjectUrl = null;
    let previousAvatarSource = avatarImage && !avatarImage.hidden ? avatarImage.getAttribute("src") || "" : "";

    const showPhotoError = (message) => {
        if (!photoClientError) {
            return;
        }
        photoClientError.textContent = message;
        photoClientError.hidden = !message;
    };

    photoTrigger?.addEventListener("click", () => {
        const informationTab = document.querySelector('[data-profile-tab="informasi"]');
        if (informationTab instanceof HTMLButtonElement) {
            informationTab.click();
        }
        photoInput?.click();
    });

    const clearSelectedPhoto = () => {
        if (photoInput) {
            photoInput.value = "";
        }
        if (photoObjectUrl) {
            URL.revokeObjectURL(photoObjectUrl);
            photoObjectUrl = null;
        }
        if (photoPreview) {
            photoPreview.hidden = true;
        }
        if (avatarImage) {
            if (previousAvatarSource) {
                avatarImage.src = previousAvatarSource;
                avatarImage.hidden = false;
                if (avatarInitials) {
                    avatarInitials.hidden = true;
                }
            } else {
                avatarImage.removeAttribute("src");
                avatarImage.hidden = true;
                if (avatarInitials) {
                    avatarInitials.hidden = false;
                }
            }
        }
    };

    const acceptPhoto = (file) => {
        if (!file) {
            return;
        }
        if (!["image/jpeg", "image/png"].includes(file.type)) {
            showPhotoError("Pilih foto berformat JPG atau PNG.");
            clearSelectedPhoto();
            return;
        }
        if (file.size > 2 * 1024 * 1024) {
            showPhotoError("Ukuran foto maksimal 2 MB.");
            clearSelectedPhoto();
            return;
        }

        showPhotoError("");
        if (photoObjectUrl) {
            URL.revokeObjectURL(photoObjectUrl);
        }
        photoObjectUrl = URL.createObjectURL(file);
        if (photoPreviewImage) {
            photoPreviewImage.src = photoObjectUrl;
        }
        if (photoFilename) {
            photoFilename.textContent = file.name;
        }
        if (photoPreview) {
            photoPreview.hidden = false;
        }
        if (avatarImage) {
            if (!avatarImage.hidden && avatarImage.getAttribute("src") && !avatarImage.getAttribute("src").startsWith("blob:")) {
                previousAvatarSource = avatarImage.getAttribute("src");
            }
            avatarImage.src = photoObjectUrl;
            avatarImage.hidden = false;
            if (avatarInitials) {
                avatarInitials.hidden = true;
            }
        }
    };

    photoInput?.addEventListener("change", () => acceptPhoto(photoInput.files?.[0]));

    photoDropzone?.addEventListener("dragover", (event) => {
        event.preventDefault();
        photoDropzone.classList.add("is-dragover");
    });
    photoDropzone?.addEventListener("dragleave", () => photoDropzone.classList.remove("is-dragover"));
    photoDropzone?.addEventListener("drop", (event) => {
        event.preventDefault();
        photoDropzone.classList.remove("is-dragover");
        const file = event.dataTransfer?.files?.[0];
        if (!file || !photoInput) {
            return;
        }
        const transfer = new DataTransfer();
        transfer.items.add(file);
        photoInput.files = transfer.files;
        acceptPhoto(file);
    });
    clearPhotoButton?.addEventListener("click", clearSelectedPhoto);

    document.querySelectorAll("[data-password-toggle]").forEach((button) => {
        button.addEventListener("click", () => {
            const field = button.closest(".profile-password-field")?.querySelector("input");
            if (!(field instanceof HTMLInputElement)) {
                return;
            }
            const isVisible = field.type === "text";
            field.type = isVisible ? "password" : "text";
            button.setAttribute("aria-pressed", String(!isVisible));
            button.setAttribute("aria-label", `${isVisible ? "Tampilkan" : "Sembunyikan"} ${field.labels?.[0]?.textContent?.trim().toLowerCase() || "kata sandi"}`);
        });
    });

    const passwordInput = document.querySelector("[data-password-strength]");
    const strengthMeter = document.querySelector("[data-password-strength-meter]");
    const strengthText = document.querySelector("[data-password-strength-text]");
    const confirmationInput = document.querySelector("[data-password-confirmation]");
    const matchMessage = document.querySelector("[data-password-match]");

    const updatePasswordStrength = () => {
        if (!(passwordInput instanceof HTMLInputElement)) {
            return;
        }
        const password = passwordInput.value;
        const score = [
            password.length >= 8,
            /[a-z]/.test(password) && /[A-Z]/.test(password),
            /\d/.test(password),
            /[^A-Za-z0-9]/.test(password) || password.length >= 12,
        ].filter(Boolean).length;
        const level = password.length === 0 ? 0 : score;
        strengthMeter?.setAttribute("data-strength", String(level));
        strengthMeter?.setAttribute("aria-valuenow", String(level));
        if (strengthText) {
            strengthText.textContent = ["Gunakan kombinasi huruf, angka, dan simbol.", "Lemah", "Cukup", "Baik", "Kuat"][level];
        }
        updatePasswordMatch();
    };

    const updatePasswordMatch = () => {
        if (!(passwordInput instanceof HTMLInputElement) || !(confirmationInput instanceof HTMLInputElement) || !matchMessage) {
            return;
        }
        matchMessage.classList.remove("is-match", "is-mismatch");
        if (!confirmationInput.value) {
            matchMessage.textContent = "";
            confirmationInput.removeAttribute("aria-invalid");
            return;
        }

        const matches = passwordInput.value === confirmationInput.value;
        matchMessage.textContent = matches ? "Konfirmasi kata sandi cocok." : "Konfirmasi kata sandi belum cocok.";
        matchMessage.classList.add(matches ? "is-match" : "is-mismatch");
        confirmationInput.setAttribute("aria-invalid", String(!matches));
    };

    passwordInput?.addEventListener("input", updatePasswordStrength);
    confirmationInput?.addEventListener("input", updatePasswordMatch);
    updatePasswordStrength();

    document.querySelectorAll("[data-loading-button]").forEach((button) => {
        const form = button.closest("form");
        form?.addEventListener("submit", () => {
            button.classList.add("is-loading");
            button.setAttribute("aria-busy", "true");
            button.disabled = true;
        });
    });

    const deleteDialog = document.querySelector("[data-profile-delete-dialog]");
    const openDeleteButton = document.querySelector("[data-open-delete-dialog]");
    const closeDeleteButton = document.querySelector("[data-close-delete-dialog]");
    const deletePassword = document.getElementById("delete_account_password");

    const openDeleteDialog = () => {
        if (!(deleteDialog instanceof HTMLDialogElement)) {
            return;
        }
        if (typeof deleteDialog.showModal === "function") {
            deleteDialog.showModal();
        } else {
            deleteDialog.setAttribute("open", "");
        }
        window.requestAnimationFrame(() => deletePassword?.focus());
    };

    openDeleteButton?.addEventListener("click", openDeleteDialog);
    closeDeleteButton?.addEventListener("click", () => {
        if (deleteDialog instanceof HTMLDialogElement) {
            deleteDialog.close();
        }
    });
    deleteDialog?.addEventListener("click", (event) => {
        if (event.target === deleteDialog) {
            deleteDialog.close();
        }
    });
    if (deleteDialog?.dataset.openOnLoad === "true") {
        openDeleteDialog();
    }

    document.querySelectorAll("[data-profile-toast]").forEach((toast) => {
        const dismiss = () => toast.classList.add("is-dismissed");
        toast.querySelector("[data-toast-dismiss]")?.addEventListener("click", dismiss);
        window.setTimeout(dismiss, 6000);
        window.setTimeout(() => toast.remove(), 6300);
    });
});
