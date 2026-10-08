document.addEventListener("DOMContentLoaded", () => {
    const roleSelect = document.querySelector("[data-role-select]");
    const adminCode = document.getElementById("adminCodeWrapper");

    roleSelect?.addEventListener("change", () => {
        if (adminCode) {
            adminCode.hidden = roleSelect.value !== "admin";
        }
    });

    document.querySelectorAll("[data-password-toggle]").forEach((toggle) => {
        const input = document.getElementById(toggle.getAttribute("aria-controls"));

        toggle.addEventListener("click", () => {
            if (!(input instanceof HTMLInputElement)) {
                return;
            }

            const shouldShow = input.type === "password";
            input.type = shouldShow ? "text" : "password";
            toggle.setAttribute("aria-pressed", String(shouldShow));
            toggle.textContent = shouldShow ? "Sembunyikan" : "Tampilkan";
        });
    });
});
