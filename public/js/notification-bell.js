document.addEventListener("DOMContentLoaded", () => {
    const bells = Array.from(document.querySelectorAll("[data-notification-bell]"));

    const createElement = (tagName, className, text = "") => {
        const element = document.createElement(tagName);
        if (className) {
            element.className = className;
        }
        if (text) {
            element.textContent = text;
        }
        return element;
    };

    const safeUrl = (candidate, fallback) => {
        if (typeof candidate !== "string" || candidate.trim() === "") {
            return fallback;
        }

        try {
            const url = new URL(candidate, window.location.origin);
            if (url.protocol === "http:" || url.protocol === "https:") {
                return url.href;
            }
        } catch {
            return fallback;
        }

        return fallback;
    };

    const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]')?.content || "";

    const closeOtherMenus = (currentBell) => {
        document.querySelectorAll("[data-notification-bell]").forEach((bell) => {
            if (bell === currentBell || !bell.classList.contains("is-open")) {
                return;
            }
            bell.querySelector("[data-notification-trigger]")?.click();
        });

        const openProfile = document.querySelector("[data-admin-profile].is-open");
        openProfile?.querySelector("[data-profile-trigger]")?.click();

        const openSearch = document.querySelector('[data-search-toggle][aria-expanded="true"]');
        openSearch?.click();
    };

    bells.forEach((bell) => {
        const mode = bell.dataset.mode;
        const endpoint = bell.dataset.endpoint;
        const storageKey = bell.dataset.storageKey || "nu_seen_news_ids";
        const trigger = bell.querySelector("[data-notification-trigger]");
        const panel = bell.querySelector("[data-notification-panel]");
        const badge = bell.querySelector("[data-notification-badge]");
        const screenReaderCount = bell.querySelector("[data-notification-sr-count]");
        const headerCount = bell.querySelector("[data-notification-header-count]");
        const list = bell.querySelector("[data-notification-list]");
        const loading = bell.querySelector("[data-notification-loading]");
        const empty = bell.querySelector("[data-notification-empty]");
        const error = bell.querySelector("[data-notification-error]");
        const message = bell.querySelector("[data-notification-message]");
        const markAllButton = bell.querySelector("[data-notification-mark-all]");
        const retryButton = bell.querySelector("[data-notification-retry]");
        const panelFooterLink = bell.querySelector(".notification-bell__footer a");

        if (!trigger || !panel || !endpoint || !list || !loading || !empty || !error) {
            return;
        }

        let notificationItems = [];
        let unreadCount = 0;
        let hasLoaded = false;
        let pollTimer = null;
        let previousIds = new Set();
        const seenWhileOpen = new Set();

        const readSeenIds = () => {
            if (mode !== "public") {
                return new Set();
            }
            try {
                const value = window.localStorage.getItem(storageKey);
                const parsed = value ? JSON.parse(value) : [];
                return new Set(Array.isArray(parsed) ? parsed.map(String) : []);
            } catch {
                return new Set();
            }
        };

        const saveSeenIds = (ids) => {
            if (mode !== "public") {
                return;
            }
            try {
                const allSeen = new Set([...readSeenIds(), ...ids.map(String)]);
                window.localStorage.setItem(storageKey, JSON.stringify(Array.from(allSeen).slice(-250)));
            } catch {
                // Browser storage may be unavailable; the news list remains usable for this visit.
            }
        };

        const setBadge = (count) => {
            unreadCount = Math.max(0, Number(count) || 0);
            trigger.setAttribute("aria-label", unreadCount > 0
                ? `Notifikasi, ${unreadCount} notifikasi baru`
                : "Notifikasi");
            badge.hidden = unreadCount === 0;
            if (badge) {
                badge.textContent = unreadCount > 9 ? "9+" : String(unreadCount);
            }
            if (screenReaderCount) {
                screenReaderCount.textContent = unreadCount === 0
                    ? "Tidak ada notifikasi baru"
                    : `${unreadCount} notifikasi baru`;
            }
            if (headerCount) {
                headerCount.textContent = unreadCount === 0
                    ? "Tidak ada yang belum dibaca"
                    : `${unreadCount} belum dibaca`;
            }
            if (markAllButton) {
                markAllButton.disabled = unreadCount === 0;
            }
        };

        const ringBell = () => {
            trigger.classList.remove("is-ringing");
            void trigger.offsetWidth;
            trigger.classList.add("is-ringing");
            window.setTimeout(() => trigger.classList.remove("is-ringing"), 850);
        };

        const setPanelState = (state) => {
            loading.hidden = state !== "loading";
            error.hidden = state !== "error";
            empty.hidden = state !== "empty";
            list.hidden = state !== "list";
        };

        const setMessage = (text = "") => {
            if (!message) {
                return;
            }
            message.textContent = text;
            message.hidden = text === "";
        };

        const makeNewsIcon = () => {
            const icon = document.createElementNS("http://www.w3.org/2000/svg", "svg");
            icon.setAttribute("viewBox", "0 0 24 24");
            icon.setAttribute("fill", "none");
            icon.setAttribute("stroke", "currentColor");
            icon.setAttribute("stroke-width", "1.7");
            icon.setAttribute("aria-hidden", "true");
            const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
            path.setAttribute("d", "M5 4h12a2 2 0 0 1 2 2v14H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Zm3 4h7m-7 4h7m-7 4h4");
            icon.append(path);
            return icon;
        };

        const makeThumbnail = (item) => {
            const thumbnail = createElement("span", "notification-bell__thumbnail");
            const imageUrl = safeUrl(item.image, "");
            if (!imageUrl) {
                thumbnail.append(makeNewsIcon());
                return thumbnail;
            }
            const image = createElement("img");
            image.src = imageUrl;
            image.alt = "";
            image.width = 48;
            image.height = 48;
            image.loading = "lazy";
            image.addEventListener("error", () => {
                image.replaceWith(makeNewsIcon());
            }, { once: true });
            thumbnail.append(image);
            return thumbnail;
        };

        const renderItems = () => {
            list.replaceChildren();
            const seenIds = readSeenIds();
            notificationItems.forEach((item) => {
                const id = String(item.id ?? "");
                const isUnread = mode === "admin"
                    ? item.read !== true
                    : (!seenIds.has(id) || seenWhileOpen.has(id));
                const itemElement = createElement("li", `notification-bell__item${isUnread ? " is-unread" : ""}`);
                const link = createElement("a", "notification-bell__item-link");
                link.href = safeUrl(item.url, panelFooterLink?.href || window.location.href);
                link.dataset.notificationItem = "";
                link.dataset.notificationId = id;
                link.setAttribute("aria-label", `${item.title || "Berita baru"}${item.time_ago ? `, ${item.time_ago}` : ""}`);
                link.append(makeThumbnail(item));

                const copy = createElement("span", "notification-bell__copy");
                copy.append(
                    createElement("span", "notification-bell__title", item.title || "Berita baru"),
                    createElement("span", "notification-bell__excerpt", item.excerpt || ""),
                    createElement("span", "notification-bell__time", item.time_ago || ""),
                );
                link.append(copy);

                const dot = createElement("span", "notification-bell__unread-dot");
                dot.setAttribute("aria-label", "Belum dibaca");
                dot.hidden = !isUnread;
                link.append(dot);
                itemElement.append(link);
                list.append(itemElement);
            });

            if (!hasLoaded) {
                setPanelState("loading");
            } else if (notificationItems.length === 0) {
                setPanelState("empty");
            } else {
                setPanelState("list");
            }
        };

        const updatePublicCount = () => {
            const seenIds = readSeenIds();
            const count = notificationItems.reduce((total, item) => (
                total + (seenIds.has(String(item.id ?? "")) ? 0 : 1)
            ), 0);
            setBadge(count);
        };

        const fetchNotifications = async ({ retry = false } = {}) => {
            if (retry) {
                setMessage("");
                if (!hasLoaded) {
                    setPanelState("loading");
                }
            }
            try {
                const response = await fetch(endpoint, {
                    cache: "no-store",
                    credentials: "same-origin",
                    headers: { Accept: "application/json" },
                });
                if (!response.ok) {
                    throw new Error(`Notification request failed with status ${response.status}.`);
                }
                const payload = await response.json();
                if (!payload || !Array.isArray(payload.items)) {
                    throw new Error("Notification response has an invalid shape.");
                }

                const fetchedItems = payload.items;
                const fetchedIds = new Set(fetchedItems.map((item) => String(item.id ?? "")));
                const isNew = hasLoaded && Array.from(fetchedIds).some((id) => !previousIds.has(id));
                previousIds = fetchedIds;
                notificationItems = fetchedItems;
                hasLoaded = true;

                if (mode === "admin") {
                    setBadge(payload.unread_count);
                } else {
                    if (bell.classList.contains("is-open")) {
                        markPublicItemsSeen();
                    } else {
                        updatePublicCount();
                    }
                }

                if (isNew) {
                    ringBell();
                } else if (unreadCount > 0 && previousIds.size > 0 && !bell.dataset.initialRingDone) {
                    ringBell();
                }
                bell.dataset.initialRingDone = "true";
                setMessage("");
                renderItems();
            } catch (requestError) {
                console.error("Unable to load notifications.", requestError);
                if (hasLoaded) {
                    setMessage("Gagal memperbarui notifikasi. Coba lagi sebentar.");
                    renderItems();
                } else {
                    setPanelState("error");
                }
            }
        };

        const startPolling = () => {
            if (document.visibilityState !== "visible" || pollTimer !== null) {
                return;
            }
            pollTimer = window.setInterval(() => {
                if (document.visibilityState === "visible") {
                    fetchNotifications();
                }
            }, 60000);
        };

        const stopPolling = () => {
            if (pollTimer !== null) {
                window.clearInterval(pollTimer);
                pollTimer = null;
            }
        };

        const markPublicItemsSeen = () => {
            const visibleIds = notificationItems.map((item) => String(item.id ?? ""));
            visibleIds.forEach((id) => seenWhileOpen.add(id));
            saveSeenIds(visibleIds);
            updatePublicCount();
            renderItems();
        };

        const openPanel = () => {
            closeOtherMenus(bell);
            bell.classList.add("is-open");
            trigger.setAttribute("aria-expanded", "true");
            panel.setAttribute("aria-hidden", "false");
            panel.hidden = false;
            if (mode === "public" && hasLoaded) {
                markPublicItemsSeen();
            }
        };

        const closePanel = ({ restoreFocus = false } = {}) => {
            bell.classList.remove("is-open");
            trigger.setAttribute("aria-expanded", "false");
            panel.setAttribute("aria-hidden", "true");
            panel.hidden = true;
            if (mode === "public") {
                seenWhileOpen.clear();
                renderItems();
            }
            if (restoreFocus) {
                trigger.focus();
            }
        };

        trigger.addEventListener("click", () => {
            if (bell.classList.contains("is-open")) {
                closePanel();
            } else {
                openPanel();
            }
        });

        markAllButton?.addEventListener("click", async () => {
            if (unreadCount === 0) {
                return;
            }

            setMessage("");
            if (mode === "public") {
                markPublicItemsSeen();
                return;
            }

            const previousUnreadCount = unreadCount;
            const previousItems = notificationItems.map((item) => ({ ...item }));
            notificationItems = notificationItems.map((item) => ({ ...item, read: true }));
            setBadge(0);
            renderItems();
            markAllButton.disabled = true;

            try {
                const response = await fetch(bell.dataset.readAllUrl, {
                    method: "POST",
                    credentials: "same-origin",
                    headers: {
                        Accept: "application/json",
                        "X-CSRF-TOKEN": getCsrfToken(),
                        "X-Requested-With": "XMLHttpRequest",
                    },
                });
                if (!response.ok) {
                    throw new Error(`Mark-all request failed with status ${response.status}.`);
                }
                await response.json();
            } catch (requestError) {
                console.error("Unable to mark all notifications as read.", requestError);
                notificationItems = previousItems;
                setBadge(previousUnreadCount);
                renderItems();
                setMessage("Tidak dapat menandai semua sebagai dibaca. Coba lagi.");
            }
        });

        retryButton?.addEventListener("click", () => fetchNotifications({ retry: true }));

        list.addEventListener("click", async (event) => {
            const link = event.target.closest("[data-notification-item]");
            if (!link || mode !== "admin") {
                return;
            }
            event.preventDefault();
            setMessage("");
            link.setAttribute("aria-busy", "true");

            try {
                const readUrl = (bell.dataset.readUrlTemplate || "").replace(
                    "__notification_id__",
                    encodeURIComponent(link.dataset.notificationId || ""),
                );
                const response = await fetch(readUrl, {
                    method: "POST",
                    credentials: "same-origin",
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": getCsrfToken(),
                        "X-Requested-With": "XMLHttpRequest",
                    },
                    body: JSON.stringify({}),
                });
                if (!response.ok) {
                    throw new Error(`Mark-read request failed with status ${response.status}.`);
                }
                const payload = await response.json();
                window.location.assign(safeUrl(payload.url, link.href));
            } catch (requestError) {
                console.error("Unable to mark notification as read.", requestError);
                link.removeAttribute("aria-busy");
                setMessage("Berita tidak dapat dibuka saat ini. Coba lagi.");
            }
        });

        panel.addEventListener("keydown", (event) => {
            if (!["ArrowDown", "ArrowUp"].includes(event.key)) {
                return;
            }
            const focusable = Array.from(panel.querySelectorAll('a[href], button:not(:disabled)'));
            if (focusable.length === 0) {
                return;
            }
            const currentIndex = focusable.indexOf(document.activeElement);
            const direction = event.key === "ArrowDown" ? 1 : -1;
            const nextIndex = currentIndex < 0
                ? (direction > 0 ? 0 : focusable.length - 1)
                : (currentIndex + direction + focusable.length) % focusable.length;
            event.preventDefault();
            focusable[nextIndex].focus();
        });

        document.addEventListener("click", (event) => {
            if (bell.classList.contains("is-open") && !bell.contains(event.target)) {
                closePanel();
            }
        });

        document.addEventListener("keydown", (event) => {
            if (event.key === "Escape" && bell.classList.contains("is-open")) {
                event.preventDefault();
                closePanel({ restoreFocus: true });
            }
        });

        document.addEventListener("visibilitychange", () => {
            if (document.visibilityState === "visible") {
                fetchNotifications();
                startPolling();
            } else {
                stopPolling();
            }
        });

        fetchNotifications().then(startPolling);
    });
});
