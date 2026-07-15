document.addEventListener("DOMContentLoaded", () => {
    const STEP_ORDER = ["offer", "schedule", "account", "confirm"];
    const TIMES = ["10:00 Uhr", "12:00 Uhr", "14:00 Uhr", "16:00 Uhr", "18:00 Uhr"];
    const MONTH_NAMES = ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];
    const DAY_NAMES = ["Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag"];
    const ACTIVE_STEP_CLASSES = "booking-tab rounded-xl border-2 border-[#00aaaa] bg-[#00aaaa]/20 px-3 py-2 text-left text-[#73ffff] shadow-[0_0_16px_rgba(0,170,170,0.18)]";
    const INACTIVE_STEP_CLASSES = "booking-tab rounded-xl border border-white/10 bg-black/30 px-3 py-2 text-left text-white/70";
    const ACTIVE_TIME_CLASSES = "rounded-xl border-2 border-[#00aaaa] bg-[#00aaaa]/20 px-3 py-2 text-left text-[#73ffff]";
    const INACTIVE_TIME_CLASSES = "rounded-xl border border-white/15 bg-black/30 px-3 py-2 text-left hover:border-[#00aaaa]";
    const ACTIVE_DATE_CLASSES = "min-h-[52px] rounded-2xl border-2 border-[#00aaaa] bg-[#00aaaa]/25 p-2 text-center text-[22px] text-[#73ffff]";
    const INACTIVE_DATE_CLASSES = "min-h-[52px] rounded-2xl border border-white/10 bg-black/30 p-2 text-center text-[22px] hover:border-[#00aaaa]";
    const ACTIVE_ACCOUNT_CLASSES = "account-tab rounded-[22px] border border-[#00aaaa] bg-[#00aaaa]/20 p-4 text-left text-[#73ffff] shadow-[0_0_22px_rgba(0,170,170,0.22)]";
    const INACTIVE_ACCOUNT_CLASSES = "account-tab rounded-[22px] border border-white/15 bg-black/25 p-4 text-left text-white/70";

    // Keep DOM access concise while collecting the stable elements once.
    const $ = (selector) => document.querySelector(selector);
    const $$ = (selector) => [...document.querySelectorAll(selector)];
    const steps = $$('[data-booking-step]');
    const stepTabs = $$('[data-step-target]');
    let offerCards = [];
    const urlParameters = new URLSearchParams(window.location.search);
    // This is the single source of truth for the current reservation.
    const state = {
        offer: "",
        offerId: "",
        date: getDateParameter(urlParameters.get("date")) || new Date(),
        time: "",
        count: 8
    };
    const elements = {
        calendarGrid: $('[data-calendar-grid]'),
        calendarTitle: $('[data-calendar-title]'),
        timeList: $('[data-time-list]'),
        successDialog: $('[data-booking-success]'),
        successSummary: $('[data-success-summary]'),
        servicesList: $('[data-services-list]'),
        servicesStatus: $('[data-services-status]')
    };
    let currentStep = "offer";
    let visibleMonth = new Date(state.date.getFullYear(), state.date.getMonth(), 1);

    function getDateParameter(value) {
        if (!/^\d{4}-\d{2}-\d{2}$/.test(value || "")) {
            return null;
        }

        const [year, month, day] = value.split("-").map(Number);
        const date = new Date(year, month - 1, day);

        return date.getFullYear() === year && date.getMonth() === month - 1 && date.getDate() === day ? date : null;
    }

    function formatDate(date) {
        return `${DAY_NAMES[date.getDay()]}, ${String(date.getDate()).padStart(2, "0")}.${String(date.getMonth() + 1).padStart(2, "0")}.${date.getFullYear()}`;
    }

    function toDateParameter(date) {
        return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, "0")}-${String(date.getDate()).padStart(2, "0")}`;
    }

    // Keep a shareable URL in sync with the choices that identify a time slot.
    function updateUrl() {
        const url = new URL(window.location.href);
        const parameters = [
            ["id", state.offerId],
            ["date", state.offer ? toDateParameter(state.date) : ""],
            ["time", state.time.replace(" Uhr", "")]
        ];

        parameters.forEach(([name, value]) => {
            if (value) {
                url.searchParams.set(name, value);
            } else {
                url.searchParams.delete(name);
            }
        });

        window.history.replaceState(null, "", url);
    }

    function updateSummary() {
        // The same reservation data is displayed in the sticky, schedule, and confirmation views.
        const values = {
            "[data-summary-offer]": state.offer || "Bitte wählen",
            "[data-summary-date]": state.offer ? formatDate(state.date) : "Bitte wählen",
            "[data-summary-time]": state.time || "Bitte wählen",
            "[data-selected-offer]": state.offer || "Bitte Angebot wählen",
            "[data-selected-date]": formatDate(state.date),
            "[data-selected-time]": state.time || "Bitte wählen",
            "[data-confirm-offer]": state.offer || "Bitte wählen",
            "[data-confirm-date]": state.offer ? formatDate(state.date) : "Bitte wählen",
            "[data-confirm-time]": state.time || "Bitte wählen"
        };

        Object.entries(values).forEach(([selector, value]) => {
            $(selector).textContent = value;
        });
        $$('[data-summary-count], [data-count], [data-confirm-count]').forEach((element) => {
            element.textContent = state.count;
        });
    }

    function showStep(stepName) {
        currentStep = stepName;
        const currentIndex = STEP_ORDER.indexOf(currentStep);

        // Completed steps remain available; later steps stay disabled until they are reached.
        steps.forEach((step) => {
            step.classList.toggle("hidden", step.dataset.bookingStep !== currentStep);
        });
        stepTabs.forEach((tab) => {
            const isActive = tab.dataset.stepTarget === currentStep;
            const isFutureStep = STEP_ORDER.indexOf(tab.dataset.stepTarget) > currentIndex;

            tab.disabled = isFutureStep;
            tab.setAttribute("aria-disabled", String(isFutureStep));
            tab.className = isActive ? ACTIVE_STEP_CLASSES : INACTIVE_STEP_CLASSES;
            tab.classList.toggle("cursor-not-allowed", isFutureStep);
            tab.classList.toggle("opacity-50", isFutureStep);
        });

        updateSummary();
        window.scrollTo({ top: 0, behavior: "smooth" });
    }

    function renderTimes() {
        // Rebuild the list so the selected style always matches the current state.
        elements.timeList.replaceChildren();

        TIMES.forEach((time) => {
            const button = document.createElement("button");
            button.type = "button";
            button.textContent = time;
            button.className = time === state.time ? ACTIVE_TIME_CLASSES : INACTIVE_TIME_CLASSES;
            button.addEventListener("click", () => {
                state.time = time;
                renderTimes();
                updateSummary();
                updateUrl();
            });
            elements.timeList.append(button);
        });
    }

    function renderCalendar() {
        const year = visibleMonth.getFullYear();
        const month = visibleMonth.getMonth();
        const firstDay = new Date(year, month, 1);
        const lastDate = new Date(year, month + 1, 0).getDate();

        elements.calendarGrid.replaceChildren();
        elements.calendarTitle.textContent = `${MONTH_NAMES[month]} ${year}`;

        // The calendar headings start on Monday, while Date#getDay starts on Sunday.
        const leadingDays = (firstDay.getDay() + 6) % 7;
        for (let index = 0; index < leadingDays; index += 1) {
            elements.calendarGrid.append(document.createElement("span"));
        }

        for (let day = 1; day <= lastDate; day += 1) {
            const date = new Date(year, month, day);
            const button = document.createElement("button");
            button.type = "button";
            button.textContent = day;
            button.className = date.toDateString() === state.date.toDateString() ? ACTIVE_DATE_CLASSES : INACTIVE_DATE_CLASSES;
            button.addEventListener("click", () => selectDate(date));
            elements.calendarGrid.append(button);
        }
    }

    function formatDuration(value) {
        const duration = String(value || "").trim();
        if (!duration) {
            return "Spielzeit laut Angebot";
        }

        let totalMinutes;
        if (/^\d+(?:\.\d+)?$/.test(duration)) {
            const numericDuration = Number(duration);
            // SimplyBook commonly returns minutes; longer numeric values are seconds.
            totalMinutes = numericDuration > 480 ? numericDuration / 60 : numericDuration;
        } else if (/^\d{1,2}:\d{2}(?::\d{2})?$/.test(duration)) {
            const [hours, minutes] = duration.split(":").map(Number);
            totalMinutes = hours * 60 + minutes;
        } else {
            return duration;
        }

        totalMinutes = Math.round(totalMinutes);
        const hours = Math.floor(totalMinutes / 60);
        const minutes = totalMinutes % 60;
        const parts = [];

        if (hours > 0) {
            parts.push(`${hours} ${hours === 1 ? "Stunde" : "Stunden"}`);
        }
        if (minutes > 0) {
            parts.push(`${minutes} Minuten`);
        }

        return parts.join(" ") || "0 Minuten";
    }

    function createOfferCard(service) {
        const card = document.createElement("article");
        const header = document.createElement("div");
        const serviceInfo = document.createElement("div");
        const duration = document.createElement("p");
        const title = document.createElement("h2");
        const price = document.createElement("p");
        const content = document.createElement("div");
        const details = document.createElement("div");
        const actions = document.createElement("div");
        const button = document.createElement("button");

        card.className = "offer-card flex flex-col overflow-hidden rounded-[25px] border border-white/10 bg-[var(--ContentBoxBackground)] shadow-[10px_10px_20px_black]";
        card.dataset.offer = service.name;
        card.dataset.offerId = service.id;
        header.className = "flex items-start justify-between gap-4 border-b border-white/10 p-5";
        duration.className = "w-fit rounded-full border border-[#00aaaa] px-3 py-1 font-[Arial,Helvetica,sans-serif] text-sm text-white/90";
        duration.textContent = service.label || formatDuration(service.duration);
        title.className = "mt-3 text-[26px]";
        title.textContent = service.name;
        price.className = "shrink-0 text-right text-[30px] leading-none text-[#73ffff]";
        price.textContent = service.price || "Preis auf Anfrage";
        if (service.priceNote) {
            const priceNote = document.createElement("span");
            priceNote.className = "mt-1 block text-base text-white/80";
            priceNote.textContent = service.priceNote;
            price.append(priceNote);
        }
        content.className = "flex flex-1 flex-col justify-between gap-5 p-5";
        details.className = "space-y-3 font-[Arial,Helvetica,sans-serif] text-lg leading-7 text-white/90";
        if (service.description) {
            const description = document.createElement("p");
            description.innerHTML = service.description;
            details.append(description);
        }
        actions.className = "mt-auto flex flex-col gap-3";
        if (service.note) {
            const note = document.createElement("p");
            const label = document.createElement("span");
            note.className = "w-full rounded-xl border border-[#73ffff]/35 bg-[#73ffff]/10 p-3 text-sm leading-6 text-white/90";
            label.className = "font-bold text-[#73ffff]";
            label.textContent = "Hinweis: ";
            note.append(label, service.note);
            actions.append(note);
        }
        button.className = "Button_Book self-start";
        button.type = "button";
        button.dataset.selectOffer = "";
        button.textContent = "Jetzt buchen";
        serviceInfo.append(duration, title);
        header.append(serviceInfo, price);
        actions.append(button);
        content.append(details, actions);
        card.append(header, content);

        return card;
    }

    function renderServices(services) {
        const groups = new Map();
        services.forEach((service) => {
            const category = service.category || { eyebrow: "Weitere Angebote", title: "Weitere Spielzeiten" };
            const key = `${category.eyebrow}:${category.title}`;
            if (!groups.has(key)) {
                groups.set(key, { category, services: [] });
            }
            groups.get(key).services.push(service);
        });

        const sections = [...groups.values()].map(({ category, services }) => {
            const section = document.createElement("section");
            const heading = document.createElement("div");
            const eyebrow = document.createElement("p");
            const title = document.createElement("h2");
            const grid = document.createElement("div");

            section.className = "mb-8 last:mb-0";
            heading.className = "mb-4";
            eyebrow.className = "text-sm uppercase tracking-[.24em] text-[#73ffff]";
            eyebrow.textContent = category.eyebrow;
            title.className = "text-[30px] leading-tight max-[775px]:text-[25px]";
            title.textContent = category.title;
            grid.className = "grid grid-cols-2 gap-5 max-[900px]:grid-cols-1";
            heading.append(eyebrow, title);
            grid.append(...services.map(createOfferCard));
            section.append(heading, grid);

            return section;
        });

        elements.servicesList.replaceChildren(...sections);
        offerCards = $$('[data-offer]');
        elements.servicesStatus.classList.add("hidden");
    }

    function selectOffer(offerCard) {
        state.offer = offerCard.dataset.offer;
        state.offerId = offerCard.dataset.offerId;

        offerCards.forEach((card) => {
            const isSelected = card === offerCard;
            card.classList.toggle("ring-2", isSelected);
            card.classList.toggle("ring-[#73ffff]", isSelected);
        });
    }

    function selectDate(date) {
        // A different date invalidates a previously selected start time.
        state.date = date;
        state.time = "";
        renderCalendar();
        renderTimes();
        updateSummary();
        updateUrl();
    }

    function addConfirmationAccountCard() {
        // The account card is shared content that does not need to be duplicated in the page markup.
        const confirmationGrid = $('[data-confirm-time]').closest(".grid");
        const accountCard = document.createElement("div");
        const heading = document.createElement("p");
        const status = document.createElement("p");
        const hint = document.createElement("p");

        accountCard.className = "col-span-2 rounded-2xl border border-white/10 bg-black/25 p-4 max-[560px]:col-auto";
        heading.className = "text-sm uppercase tracking-[.12em] text-white/70";
        heading.textContent = "Kundenkonto";
        status.className = "mt-2 text-lg text-[#73ffff]";
        status.textContent = "Nicht eingeloggt";
        hint.className = "mt-1 text-sm text-white/70";
        hint.textContent = "Bitte in Schritt 3 einloggen.";
        accountCard.append(heading, status, hint);
        confirmationGrid.append(accountCard);
    }

    function createSuccessSummaryItem(label, value) {
        const item = document.createElement("div");
        const labelElement = document.createElement("p");
        const valueElement = document.createElement("p");

        item.className = "rounded-2xl border border-white/10 bg-black/30 p-4";
        labelElement.className = "text-xs uppercase tracking-[.14em] text-white/55";
        labelElement.textContent = label;
        valueElement.className = "mt-2 text-lg text-[#73ffff]";
        valueElement.textContent = value;
        item.append(labelElement, valueElement);

        return item;
    }

    function showSuccessDialog() {
        const summaryItems = [
            ["Angebot", state.offer || "Bitte wählen"],
            ["Datum", formatDate(state.date)],
            ["Start", state.time || "Bitte wählen"]
        ];

        elements.successSummary.replaceChildren(...summaryItems.map(([label, value]) => createSuccessSummaryItem(label, value)));
        elements.successDialog.classList.replace("hidden", "flex");
    }

    // Register all user interactions after the rendering functions are available.
    elements.servicesList.addEventListener("click", (event) => {
        const button = event.target.closest('[data-select-offer]');
        if (button) {
            selectOffer(button.closest("[data-offer]"));
            updateUrl();
            showStep("schedule");
        }
    });
    stepTabs.forEach((tab) => {
        tab.addEventListener("click", () => {
            if (!tab.disabled) {
                showStep(tab.dataset.stepTarget);
            }
        });
    });
    $$('[data-go-step]').forEach((button) => {
        button.addEventListener("click", () => showStep(button.dataset.goStep));
    });
    $('[data-count-down]').addEventListener("click", () => {
        state.count = Math.max(1, state.count - 1);
        updateSummary();
    });
    $('[data-count-up]').addEventListener("click", () => {
        state.count += 1;
        updateSummary();
    });
    $('[data-calendar-prev]').addEventListener("click", () => {
        visibleMonth = new Date(visibleMonth.getFullYear(), visibleMonth.getMonth() - 1, 1);
        renderCalendar();
    });
    $('[data-calendar-next]').addEventListener("click", () => {
        visibleMonth = new Date(visibleMonth.getFullYear(), visibleMonth.getMonth() + 1, 1);
        renderCalendar();
    });
    $$('[data-account]').forEach((tab) => {
        tab.addEventListener("click", () => {
            $$('[data-account-panel]').forEach((panel) => {
                panel.classList.toggle("hidden", panel.dataset.accountPanel !== tab.dataset.account);
            });
            $$('[data-account]').forEach((button) => {
                button.className = button === tab ? ACTIVE_ACCOUNT_CLASSES : INACTIVE_ACCOUNT_CLASSES;
            });
        });
    });
    $('[data-demo-submit]').addEventListener("click", showSuccessDialog);

    addConfirmationAccountCard();

    renderCalendar();
    renderTimes();
    updateSummary();

    async function loadServices() {
        try {
            const response = await fetch("services.php", { headers: { Accept: "application/json" } });
            const payload = await response.json();
            if (!response.ok || !Array.isArray(payload.services)) {
                throw new Error(payload.error || "Die Angebote konnten nicht geladen werden.");
            }
            if (payload.services.length === 0) {
                elements.servicesStatus.textContent = "Zurzeit sind keine Angebote verfügbar.";
                return;
            }

            renderServices(payload.services);
            const selectedOfferCard = offerCards.find((card) => card.dataset.offerId === urlParameters.get("id"));
            if (selectedOfferCard) {
                selectOffer(selectedOfferCard);
            }
            const timeParameter = urlParameters.get("time");
            if (state.offer && TIMES.some((time) => time === `${timeParameter} Uhr`)) {
                state.time = `${timeParameter} Uhr`;
            }
            updateSummary();
            showStep(state.offer ? "schedule" : "offer");
        } catch (error) {
            elements.servicesStatus.textContent = error instanceof Error ? error.message : "Die Angebote konnten nicht geladen werden.";
            showStep("offer");
        }
    }

    loadServices();
});
