<!DOCTYPE html>
<?php
$section = 'w-full max-w-[1180px]';
$panel = 'rounded-[25px] bg-[var(--ContentBoxBackground)] shadow-[10px_10px_20px_black]';
$eyebrow = 'text-sm uppercase tracking-[0.24em] text-[#73ffff]';
$headline = 'mt-2 text-center text-[34px] leading-tight max-[775px]:text-[28px]';
$bodyText = 'font-[Arial,Helvetica,sans-serif] text-lg leading-7 text-white/90 max-[775px]:text-base';
$grid = 'grid grid-cols-2 gap-5 max-[900px]:grid-cols-1';
$card = $panel . ' flex min-h-[250px] flex-col overflow-hidden border border-white/10';
$cardHeader = 'flex items-start justify-between gap-4 border-b border-white/10 p-5 max-[520px]:flex-col';
$cardTitle = 'text-[26px] leading-tight max-[775px]:text-[22px]';
$price = 'whitespace-nowrap text-right text-[30px] leading-none text-[#73ffff] max-[520px]:text-left';
$priceNote = 'mt-1 block text-base text-white/80';
$cardContent = 'flex flex-1 flex-col justify-between gap-5 p-5';
$details = 'space-y-2 font-[Arial,Helvetica,sans-serif] text-lg leading-7 text-white/90 max-[775px]:text-base';
$meta = 'inline-flex w-fit rounded-full border border-[#00aaaa] px-3 py-1 font-[Arial,Helvetica,sans-serif] text-sm text-white/90';
$label = 'font-[Arial,Helvetica,sans-serif] text-sm uppercase tracking-[0.12em] text-white/70';
$field = 'mt-2 w-full rounded-xl border border-white/15 bg-black/35 px-4 py-3 font-[Arial,Helvetica,sans-serif] text-white outline-none';
$stepPill = 'rounded-full border border-[#00aaaa] bg-black/35 px-3 py-1 font-[Arial,Helvetica,sans-serif] text-sm text-white/90';
$offerSections = [
	[
		'eyebrow' => 'Feiern',
		'title' => 'Geburtstagspakete',
		'badge' => 'ab 6 Gästen',
		'layout' => 'cards',
		'offers' => [
			[
				'id' => 1,
				'duration' => '2 Stunden',
				'title' => 'Geburtstag Basis',
				'price' => '34,90 €',
				'priceNote' => 'pro Gast',
				'details' => ['Getränkeflat für die Gruppe ist enthalten.', 'Das Geburtstagskind bekommt einen Slushy dazu.'],
				'description' => '2 Stunden Geburtstagspaket mit Getraenkeflat und Slushy fuer das Geburtstagskind.',
			],
			[
				'id' => 2,
				'duration' => '3 Stunden',
				'title' => 'Geburtstag Plus',
				'price' => '39,90 €',
				'priceNote' => 'pro Gast',
				'details' => ['Alle Leistungen aus dem 2-Stunden-Paket sind inklusive.', 'Zusätzlich erhält das Geburtstagskind eine Membercard; jeder Gast bekommt eine Snackbox.'],
				'description' => '3 Stunden Geburtstagspaket mit Getraenkeflat, Membercard und Snackboxen.',
			],
		],
	],
	[
		'eyebrow' => 'Aktionen',
		'title' => 'Flats am Wochenende',
		'layout' => 'cards',
		'offers' => [
			[
				'id' => 3,
				'duration' => 'Samstag & Sonntag',
				'title' => 'Family Flat',
				'price' => '15,00 €',
				'priceNote' => 'pro Person',
				'details' => ['Spielzeit von 10:00 bis 11:30 Uhr.', 'Erwachsene erhalten wahlweise Kaffee oder Tee.'],
				'description' => 'Wochenend-Spielzeit von 10:00 bis 11:30 Uhr fuer Familien.',
			],
			[
				'id' => 4,
				'duration' => 'Samstag & Sonntag',
				'title' => 'Night Special',
				'price' => '27,00 €',
				'priceNote' => 'pro Person',
				'details' => ['Drei Stunden Lasertag von 18:00 bis 21:00 Uhr.', 'Ideal für Gruppen, die den Abend in der Arena verbringen möchten.'],
				'description' => 'Drei Stunden Lasertag am Wochenende von 18:00 bis 21:00 Uhr.',
			],
		],
	],
	[
		'eyebrow' => 'Spielzeit',
		'title' => 'Standardbuchungen',
		'layout' => 'compact',
		'offers' => [
			[
				'id' => 5,
				'title' => '1 Stunde',
				'serviceTitle' => 'Standardspiel 1 Stunde',
				'price' => '18,50 €',
				'priceNote' => 'pro Person',
				'description' => 'Eine Stunde Lasertag fuer kurze Matches und spontane Gruppen.',
			],
			[
				'id' => 6,
				'title' => '2 Stunden',
				'serviceTitle' => 'Standardspiel 2 Stunden',
				'price' => '36,00 €',
				'priceNote' => 'pro Person',
				'description' => 'Zwei Stunden Lasertag fuer Gruppen, Teams und laengere Spielrunden.',
			],
		],
	],
];
$offersById = [];
foreach ($offerSections as $sectionData) {
	foreach ($sectionData['offers'] as $offer) {
		$offersById[(string) $offer['id']] = [
			'title' => $offer['serviceTitle'] ?? $offer['title'],
			'description' => $offer['description'],
		];
	}
}
$defaultOfferId = 6;
$defaultDate = (new DateTimeImmutable('today'))->format('Y-m-d');
$defaultMonth = (new DateTimeImmutable('today'))->format('Y-m');
?>
<html lang="de">
	<head>
		<?php require '../resources/head.php'; ?>
	</head>
	<body>
		<?php $currentPage = 'reservieren'; include '../resources/header.php'; ?>

		<main class="flex flex-col items-center gap-8 px-[100px] py-[25px] max-[1260px]:px-[15px] max-[775px]:px-[5px]" data-booking-wizard>
			<nav class="<?= $section ?> grid grid-cols-3 gap-3 max-[700px]:grid-cols-1" aria-label="Buchungsschritte">
				<button class="rounded-2xl border-2 border-[#00aaaa] bg-[#00aaaa]/20 p-4 text-left text-[#73ffff] shadow-[0_0_22px_rgba(0,170,170,0.22)]" type="button" data-wizard-tab="offer" aria-pressed="true">
					<span class="<?= $label ?> block">Schritt 1</span>
					<span class="mt-1 block text-[24px]">Angebot</span>
				</button>
				<button class="rounded-2xl border border-white/10 bg-black/30 p-4 text-left text-white/70" type="button" data-wizard-tab="schedule">
					<span class="<?= $label ?> block">Schritt 2</span>
					<span class="mt-1 block text-[24px]">Termin</span>
				</button>
				<button class="rounded-2xl border border-white/10 bg-black/30 p-4 text-left text-white/70" type="button" data-wizard-tab="account">
					<span class="<?= $label ?> block">Schritt 3</span>
					<span class="mt-1 block text-[24px]">Konto</span>
				</button>
			</nav>

			<form class="<?= $section ?> flex flex-col gap-8" action="#" method="post">
				<section data-wizard-step="offer">
					<?php foreach ($offerSections as $offerSection): ?>
						<section class="<?= $section ?> mb-8">
							<div class="mb-4 flex items-end justify-between gap-4 max-[775px]:flex-col max-[775px]:items-start">
								<div><p class="<?= $eyebrow ?>"><?= htmlspecialchars($offerSection['eyebrow']) ?></p><h2 class="text-[30px] leading-tight max-[775px]:text-[25px]"><?= htmlspecialchars($offerSection['title']) ?></h2></div>
								<?php if (!empty($offerSection['badge'])): ?><p class="<?= $meta ?>"><?= htmlspecialchars($offerSection['badge']) ?></p><?php endif; ?>
							</div>
							<div class="<?= $offerSection['layout'] === 'compact' ? 'grid grid-cols-2 gap-5 max-[700px]:grid-cols-1' : $grid ?>">
								<?php foreach ($offerSection['offers'] as $offer): ?>
									<?php if ($offerSection['layout'] === 'compact'): ?>
										<article class="<?= $panel ?> border border-white/10 p-6 text-center" data-offer-card="<?= $offer['id'] ?>">
											<h3 class="text-[26px]"><?= htmlspecialchars($offer['title']) ?></h3><p class="mt-4 text-[34px] text-[#73ffff]"><?= htmlspecialchars($offer['price']) ?></p><p class="<?= $bodyText ?> mt-2"><?= htmlspecialchars($offer['priceNote']) ?></p>
											<button class="Button_Book mt-5 inline-block" type="button" data-select-offer="<?= $offer['id'] ?>">Jetzt buchen</button>
										</article>
									<?php else: ?>
										<article class="<?= $card ?>" data-offer-card="<?= $offer['id'] ?>">
											<div class="<?= $cardHeader ?>">
												<div><p class="<?= $meta ?>"><?= htmlspecialchars($offer['duration']) ?></p><h3 class="<?= $cardTitle ?> mt-3"><?= htmlspecialchars($offer['title']) ?></h3></div>
												<p class="<?= $price ?>"><?= htmlspecialchars($offer['price']) ?><span class="<?= $priceNote ?>"><?= htmlspecialchars($offer['priceNote']) ?></span></p>
											</div>
											<div class="<?= $cardContent ?>">
												<div class="<?= $details ?>"><?php foreach ($offer['details'] as $detail): ?><p><?= htmlspecialchars($detail) ?></p><?php endforeach; ?></div>
												<button class="Button_Book self-start" type="button" data-select-offer="<?= $offer['id'] ?>">Jetzt buchen</button>
											</div>
										</article>
									<?php endif; ?>
								<?php endforeach; ?>
							</div>
						</section>
					<?php endforeach; ?>

					<section class="<?= $section ?> <?= $panel ?> border border-white/10 p-6 max-[775px]:p-4">
						<div class="grid grid-cols-[auto_1fr] items-center gap-5 max-[850px]:grid-cols-1">
							<div class="flex h-20 w-20 items-center justify-center rounded-full border-2 border-[#00aaaa] text-[28px] text-[#73ffff]">+</div>
							<div><p class="<?= $eyebrow ?>">Optional</p><h2 class="text-[28px] leading-tight max-[775px]:text-[24px]">Getränkeflat</h2><p class="<?= $bodyText ?> mt-2">Für 9,90 € pro Person sind kleine Getränke sowie 1-Liter-Wasserflaschen dabei. Cola, Fanta und Sprite sind davon ausgenommen.</p></div>
						</div>
					</section>
				</section>

				<section class="<?= $panel ?> hidden border border-white/10 p-6 max-[775px]:p-4" data-wizard-step="schedule">
					<div class="mb-6 flex items-start justify-between gap-4 max-[760px]:flex-col">
						<div>
							<p class="<?= $eyebrow ?>">Schritt 2</p>
							<h2 class="mt-2 text-[32px] leading-tight max-[775px]:text-[26px]">Wann wollt ihr spielen?</h2>
							<p class="<?= $bodyText ?> mt-3">Ausgewaehlt: <span class="text-[#73ffff]" data-offer-title>Standardspiel 2 Stunden</span></p>
						</div>
						<button class="Button_Book" type="button" data-go-step="offer">Angebot aendern</button>
					</div>

					<input type="hidden" name="offer_id" value="" data-offer-id />
					<input type="hidden" name="start_date" value="<?= htmlspecialchars($defaultDate) ?>" data-start-date />
					<input type="hidden" name="start_time" value="" data-start-time />

					<div class="grid grid-cols-[minmax(0,1fr)_minmax(340px,0.72fr)] gap-5 max-[980px]:grid-cols-1">
						<div class="rounded-[22px] border border-white/10 bg-black/25 p-4">
							<input type="hidden" name="month" value="<?= htmlspecialchars($defaultMonth) ?>" data-month-input />
							<div class="flex items-center justify-between gap-4 max-[560px]:flex-col max-[560px]:items-stretch">
								<button class="rounded-2xl border border-white/15 bg-black/30 px-4 py-3 text-white/80 hover:border-[#00aaaa] hover:text-[#73ffff]" type="button" data-calendar-prev>Zurueck</button>
								<div class="text-center">
									<p class="<?= $label ?>">Datum waehlen</p>
									<h3 class="mt-1 text-[30px] leading-none text-[#73ffff] max-[775px]:text-[24px]" data-calendar-title></h3>
								</div>
								<button class="rounded-2xl border border-white/15 bg-black/30 px-4 py-3 text-white/80 hover:border-[#00aaaa] hover:text-[#73ffff]" type="button" data-calendar-next>Weiter</button>
							</div>

							<div class="mt-5 grid grid-cols-7 gap-2 text-center font-[Arial,Helvetica,sans-serif] text-sm uppercase tracking-[0.08em] text-white/50">
								<span>Mo</span><span>Di</span><span>Mi</span><span>Do</span><span>Fr</span><span>Sa</span><span>So</span>
							</div>
							<div class="mt-2 grid grid-cols-7 gap-2" data-calendar-grid></div>

							<div class="mt-5 rounded-2xl border border-[#00aaaa]/35 bg-[#00aaaa]/10 p-4">
								<div class="flex items-start justify-between gap-4 max-[700px]:flex-col">
									<div>
										<p class="<?= $label ?>">Ausgewaehlter Termin</p>
										<p class="mt-1 text-[24px] leading-tight text-[#73ffff]" data-selected-date-label></p>
										<p class="<?= $bodyText ?> mt-1 text-base">Start: <span class="text-white" data-selected-time-label>Bitte waehlen</span></p>
									</div>
									<span class="<?= $stepPill ?>" data-availability-label>Lade Zeiten...</span>
								</div>
							</div>
						</div>

						<aside class="flex flex-col gap-5">
							<div class="rounded-[22px] border border-white/10 bg-black/25 p-4">
							<p class="<?= $label ?>">Teilnehmer</p>
							<div class="mt-3 flex items-center justify-between rounded-2xl border border-white/15 bg-black/30 p-3">
								<button class="h-10 w-10 rounded-full border border-white/20 text-xl" type="button" data-count-down>-</button>
								<input class="w-20 bg-transparent text-center text-[30px] text-[#73ffff] outline-none" type="number" name="count" value="8" min="1" data-count readonly />
								<button class="h-10 w-10 rounded-full border border-[#00aaaa] text-xl text-[#73ffff]" type="button" data-count-up>+</button>
							</div>
						</div>

							<div class="rounded-[22px] border border-white/10 bg-black/25 p-4">
								<div class="flex items-end justify-between gap-3 max-[520px]:flex-col max-[520px]:items-start">
									<div>
										<p class="<?= $label ?>">Zeitfenster <span data-selected-day>am Samstag</span></p>
										<p class="<?= $bodyText ?> mt-1 text-base">Kompakte Auswahl fuer Tage mit vielen Startzeiten.</p>
									</div>
									<span class="font-[Arial,Helvetica,sans-serif] text-sm text-white/55">scrollen</span>
								</div>
								<div class="mt-3 grid max-h-[360px] grid-cols-3 gap-2 overflow-y-auto pr-1 max-[1200px]:grid-cols-2 max-[520px]:grid-cols-1" data-time-list>
									<p class="col-span-full font-[Arial,Helvetica,sans-serif] text-sm text-white/60">Bitte zuerst ein Angebot auswaehlen.</p>
							</div>
						</div>
						</aside>
					</div>
					<div class="mt-6 flex justify-end"><button class="Button_Book" type="button" data-go-step="account">Weiter zum Konto</button></div>
				</section>

				<section class="<?= $panel ?> hidden border border-white/10 p-6 max-[775px]:p-4" data-wizard-step="account">
					<div class="mb-6 flex items-center justify-between gap-4 max-[700px]:flex-col max-[700px]:items-start">
						<div><p class="<?= $eyebrow ?>">Schritt 3</p><h2 class="mt-2 text-[32px] leading-tight max-[775px]:text-[26px]">Einloggen oder Konto erstellen</h2></div>
						<span class="<?= $stepPill ?>">Kundenkonto</span>
					</div>

					<div class="mb-5 flex gap-3 max-[520px]:flex-col">
						<button class="rounded-full border border-[#00aaaa] bg-[#00aaaa]/20 px-5 py-2 text-[#73ffff]" type="button" data-account-tab="login" aria-pressed="true">Einloggen</button>
						<button class="rounded-full border border-white/15 px-5 py-2 text-white/70" type="button" data-account-tab="register">Konto erstellen</button>
					</div>

					<div class="grid grid-cols-[1fr_1fr] gap-5 max-[900px]:grid-cols-1">
						<div class="rounded-[22px] border-2 border-[#00aaaa] bg-[#00aaaa]/10 p-5" data-account-panel="login">
							<p class="text-[26px] text-[#73ffff]">Einloggen</p>
							<p class="<?= $bodyText ?> mt-2 text-base">Bestehende Kunden bestaetigen schneller mit gespeicherten Daten.</p>
							<div class="mt-5 space-y-4">
								<div><label class="<?= $label ?>" for="login-email">E-Mail</label><input id="login-email" class="<?= $field ?>" type="email" name="login_email" placeholder="kunde@example.de" /></div>
								<div><label class="<?= $label ?>" for="login-password">Passwort</label><input id="login-password" class="<?= $field ?>" type="password" placeholder="Passwort" /></div>
								<button class="Button_Book opacity-70" type="button" aria-disabled="true">Einloggen & bestaetigen</button>
							</div>
						</div>

						<div class="rounded-[22px] border border-white/10 bg-black/25 p-5 opacity-60" data-account-panel="register">
							<p class="text-[26px]">Konto erstellen</p>
							<p class="<?= $bodyText ?> mt-2 text-base">Neue Kunden registrieren sich, bevor der Termin verbindlich bestaetigt wird.</p>
							<div class="mt-5 grid grid-cols-2 gap-4 max-[520px]:grid-cols-1">
								<div><label class="<?= $label ?>" for="register-name">Name</label><input id="register-name" class="<?= $field ?>" type="text" name="client[name]" placeholder="Max Mustermann" /></div>
								<div><label class="<?= $label ?>" for="register-phone">Telefon</label><input id="register-phone" class="<?= $field ?>" type="tel" name="client[phone]" placeholder="0123 456789" /></div>
								<div class="col-span-2 max-[520px]:col-auto"><label class="<?= $label ?>" for="register-email">E-Mail</label><input id="register-email" class="<?= $field ?>" type="email" name="client[email]" placeholder="max@example.de" /></div>
							</div>
							<button class="Button_Book mt-5 opacity-70" type="button" aria-disabled="true">Konto erstellen & bestaetigen</button>
						</div>
					</div>

					<div class="mt-5 rounded-2xl border border-[#73ffff]/30 bg-[#73ffff]/10 p-4">
						<p class="<?= $bodyText ?> text-base">Design-only: Login, Registrierung und Terminbestaetigung sind UI-Elemente. Es wird keine echte Buchung erstellt.</p>
					</div>
				</section>
			</form>
		</main>

		<script>
			document.addEventListener("DOMContentLoaded", () => {
				const offers = <?= json_encode($offersById, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
				const defaultOfferId = "<?= $defaultOfferId ?>";
				const activateChoice = (button, buttons) => {
					buttons.forEach((item) => {
						item.setAttribute("aria-pressed", "false");
						item.classList.remove("border-2", "border-[#00aaaa]", "bg-[#00aaaa]/20", "text-[#73ffff]", "shadow-[0_0_22px_rgba(0,170,170,0.22)]");
						item.classList.add("border", "border-white/10", "bg-black/30", "text-white/70");
					});
					button.setAttribute("aria-pressed", "true");
					button.classList.remove("border", "border-white/10", "bg-black/30", "text-white/70");
					button.classList.add("border-2", "border-[#00aaaa]", "bg-[#00aaaa]/20", "text-[#73ffff]", "shadow-[0_0_22px_rgba(0,170,170,0.22)]");
				};

				const tabs = Array.from(document.querySelectorAll("[data-wizard-tab]"));
				const steps = Array.from(document.querySelectorAll("[data-wizard-step]"));
				let loadAvailability = () => {};
				const goToStep = (step) => {
					steps.forEach((item) => item.classList.toggle("hidden", item.dataset.wizardStep !== step));
					activateChoice(document.querySelector(`[data-wizard-tab="${step}"]`), tabs);
					window.scrollTo({ top: 0, behavior: "smooth" });
				};

				document.querySelectorAll("[data-go-step]").forEach((button) => button.addEventListener("click", () => goToStep(button.dataset.goStep)));
				tabs.forEach((tab) => tab.addEventListener("click", () => goToStep(tab.dataset.wizardTab)));

				const setOfferUrl = (offerId) => {
					const url = new URL(window.location.href);
					url.searchParams.set("id", offerId);
					window.history.pushState({ offerId }, "", url);
				};

				const selectOffer = (offerId, updateUrl = true) => {
					offerId = offers[offerId] ? offerId : defaultOfferId;
					const offer = offers[offerId];
					document.querySelector("[data-offer-title]").textContent = offer.title;
					document.querySelector("[data-offer-id]").value = offerId;
					document.querySelectorAll("[data-offer-card]").forEach((card) => {
						const isActive = card.dataset.offerCard === offerId;
						card.classList.toggle("ring-2", isActive);
						card.classList.toggle("ring-[#73ffff]", isActive);
					});
					if (updateUrl) {
						setOfferUrl(offerId);
					}
					goToStep("schedule");
					loadAvailability();
				};

				document.querySelectorAll("[data-select-offer]").forEach((button) => button.addEventListener("click", () => selectOffer(button.dataset.selectOffer)));

				const params = new URLSearchParams(window.location.search);
				if (offers[params.get("id")]) {
					selectOffer(params.get("id"), false);
				}

				const monthNames = ["Januar", "Februar", "Maerz", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];
				const dayNames = ["Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag"];
				const calendarGrid = document.querySelector("[data-calendar-grid]");
				const calendarTitle = document.querySelector("[data-calendar-title]");
				const selectedDateLabel = document.querySelector("[data-selected-date-label]");
				const availabilityLabel = document.querySelector("[data-availability-label]");
				const selectedTimeLabel = document.querySelector("[data-selected-time-label]");
				const selectedTimeInput = document.querySelector("[data-start-time]");
				const selectedDateInput = document.querySelector("[data-start-date]");
				const offerIdInput = document.querySelector("[data-offer-id]");
				const timeList = document.querySelector("[data-time-list]");
				const monthInput = document.querySelector("[data-month-input]");
				const today = new Date();
				today.setHours(0, 0, 0, 0);
				let selectedDate = new Date(selectedDateInput.value + "T00:00:00");
				if (selectedDate < today) {
					selectedDate = new Date(today);
				}
				let visibleMonth = new Date(selectedDate.getFullYear(), selectedDate.getMonth(), 1);
				let availabilityByDate = {};
				let isLoadingAvailability = false;
				let availabilityError = "";

				const padDatePart = (value) => String(value).padStart(2, "0");
				const toDateValue = (date) => date.getFullYear() + "-" + padDatePart(date.getMonth() + 1) + "-" + padDatePart(date.getDate());
				const toDisplayDate = (date) => dayNames[date.getDay()] + ", " + padDatePart(date.getDate()) + "." + padDatePart(date.getMonth() + 1) + "." + date.getFullYear();
				const formatTimeLabel = (value) => value.slice(0, 5) + " Uhr";
				const getSelectedTimes = () => availabilityByDate[toDateValue(selectedDate)] || [];
				const showTimeMessage = (message) => {
					timeList.innerHTML = "";
					const text = document.createElement("p");
					text.className = "col-span-full font-[Arial,Helvetica,sans-serif] text-sm text-white/60";
					text.textContent = message;
					timeList.appendChild(text);
				};

				const selectTime = (time) => {
					selectedTimeInput.value = time;
					selectedTimeLabel.textContent = time ? formatTimeLabel(time) : "Bitte waehlen";
					renderTimes();
				};

				const renderTimes = () => {
					const times = getSelectedTimes();
					timeList.innerHTML = "";

					if (!offerIdInput.value) {
						availabilityLabel.textContent = "Angebot auswaehlen";
						showTimeMessage("Bitte zuerst ein Angebot auswaehlen.");
						return;
					}

					if (isLoadingAvailability) {
						showTimeMessage("Zeiten werden geladen...");
						return;
					}

					if (availabilityError) {
						availabilityLabel.textContent = availabilityError;
						showTimeMessage(availabilityError);
						return;
					}

					availabilityLabel.textContent = times.length === 0 ? "keine Zeiten verfuegbar" : times.length + " Zeitfenster verfuegbar";

					if (times.length === 0) {
						showTimeMessage("Fuer diesen Tag sind keine Zeiten frei.");
						return;
					}

					times.forEach((time) => {
						const isSelected = selectedTimeInput.value === time;
						const button = document.createElement("button");
						button.type = "button";
						button.dataset.time = time;
						button.setAttribute("aria-pressed", isSelected ? "true" : "false");
						button.className = isSelected ? "rounded-xl border-2 border-[#00aaaa] bg-[#00aaaa]/20 px-3 py-2 text-left text-[#73ffff] shadow-[0_0_22px_rgba(0,170,170,0.22)]" : "rounded-xl border border-white/15 bg-black/30 px-3 py-2 text-left hover:border-[#00aaaa]/70 hover:text-[#73ffff]";
						button.innerHTML = '<span class="block text-[21px] leading-tight">' + time.slice(0, 5) + '</span><span class="font-[Arial,Helvetica,sans-serif] text-xs ' + (isSelected ? 'text-white/80' : 'text-white/60') + '">' + (isSelected ? 'ausgewaehlt' : 'frei') + '</span>';
						button.addEventListener("click", () => selectTime(time));
						timeList.appendChild(button);
					});
				};

				const updateSelectedDate = (date) => {
					selectedDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
					selectedDateInput.value = toDateValue(selectedDate);
					document.querySelector("[data-selected-day]").textContent = "am " + dayNames[selectedDate.getDay()];
					selectedDateLabel.textContent = toDisplayDate(selectedDate);
					const times = getSelectedTimes();

					// Keep a valid selected time, or automatically choose the first free slot for the day.
					if (!times.includes(selectedTimeInput.value)) {
						selectedTimeInput.value = times[0] || "";
						selectedTimeLabel.textContent = selectedTimeInput.value ? formatTimeLabel(selectedTimeInput.value) : "Bitte waehlen";
					}

					renderTimes();
				};

				const renderCalendar = () => {
					calendarGrid.innerHTML = "";
					calendarTitle.textContent = monthNames[visibleMonth.getMonth()] + " " + visibleMonth.getFullYear();
					monthInput.value = visibleMonth.getFullYear() + "-" + padDatePart(visibleMonth.getMonth() + 1);
					const firstDay = new Date(visibleMonth.getFullYear(), visibleMonth.getMonth(), 1);
					const lastDay = new Date(visibleMonth.getFullYear(), visibleMonth.getMonth() + 1, 0);
					const leadingDays = (firstDay.getDay() + 6) % 7;

					for (let i = 0; i < leadingDays; i++) {
						calendarGrid.appendChild(document.createElement("span"));
					}

					for (let day = 1; day <= lastDay.getDate(); day++) {
						const date = new Date(visibleMonth.getFullYear(), visibleMonth.getMonth(), day);
						const dateValue = toDateValue(date);
						const slots = (availabilityByDate[dateValue] || []).length;
						const isSelected = toDateValue(date) === toDateValue(selectedDate);
						const isPast = date < today;
						const isDisabled = isPast || isLoadingAvailability || slots === 0;
						const button = document.createElement("button");
						button.type = "button";
						button.className = "min-h-[76px] rounded-2xl border p-2 text-left transition max-[560px]:min-h-[58px]";
						button.className += isDisabled ? " border-white/5 bg-black/20 text-white/30" : isSelected ? " border-[#00aaaa] bg-[#00aaaa]/25 text-[#73ffff] shadow-[0_0_22px_rgba(0,170,170,0.22)]" : " border-white/10 bg-black/30 text-white/75 hover:border-[#00aaaa]/70 hover:text-[#73ffff]";
						button.disabled = isDisabled;
						button.innerHTML = '<span class="block text-[22px] leading-none max-[560px]:text-[18px]">' + day + '</span><span class="mt-2 block font-[Arial,Helvetica,sans-serif] text-xs ' + (isSelected ? 'text-white/85' : 'text-white/45') + '">' + (isPast ? 'vergangen' : isLoadingAvailability ? 'laden...' : slots === 0 ? 'belegt' : slots + ' Slots') + '</span>';
						if (!isDisabled) {
							button.addEventListener("click", () => {
								updateSelectedDate(date);
								renderCalendar();
							});
						}
						calendarGrid.appendChild(button);
					}
				};

				const firstAvailableDate = () => {
					for (let day = 1; day <= new Date(visibleMonth.getFullYear(), visibleMonth.getMonth() + 1, 0).getDate(); day++) {
						const date = new Date(visibleMonth.getFullYear(), visibleMonth.getMonth(), day);

						if (date >= today && (availabilityByDate[toDateValue(date)] || []).length > 0) {
							return date;
						}
					}

					const firstOfVisibleMonth = new Date(visibleMonth.getFullYear(), visibleMonth.getMonth(), 1);

					return firstOfVisibleMonth < today ? new Date(today) : firstOfVisibleMonth;
				};

				loadAvailability = async () => {
					if (!offerIdInput.value) {
						availabilityByDate = {};
						availabilityError = "";
						isLoadingAvailability = false;
						renderCalendar();
						renderTimes();
						return;
					}

					const monthValue = visibleMonth.getFullYear() + "-" + padDatePart(visibleMonth.getMonth() + 1);
					isLoadingAvailability = true;
					availabilityError = "";
					availabilityLabel.textContent = "Lade Zeiten...";
					renderCalendar();
					renderTimes();

					try {
						const response = await fetch("availability.php?offer_id=" + encodeURIComponent(offerIdInput.value) + "&month=" + encodeURIComponent(monthValue));
						const responseText = await response.text();
						let data = {};

						try {
							data = JSON.parse(responseText);
						} catch (parseError) {
							const plainResponse = responseText.replace(/<[^>]*>/g, " ").replace(/\s+/g, " ").trim();
							throw new Error(plainResponse ? plainResponse.slice(0, 180) : "Zeiten konnten nicht geladen werden. Serverantwort war kein JSON.");
						}

						if (!response.ok || data.error) {
							throw new Error(data.error || "Zeiten konnten nicht geladen werden.");
						}

						availabilityByDate = data.dates || {};
						selectedDate = firstAvailableDate();
					} catch (error) {
						availabilityByDate = {};
						availabilityError = error.message;
					} finally {
						isLoadingAvailability = false;
						updateSelectedDate(selectedDate);
						renderCalendar();
					}
				};

				document.querySelector("[data-calendar-prev]").addEventListener("click", () => {
					visibleMonth = new Date(visibleMonth.getFullYear(), visibleMonth.getMonth() - 1, 1);
					loadAvailability();
				});
				document.querySelector("[data-calendar-next]").addEventListener("click", () => {
					visibleMonth = new Date(visibleMonth.getFullYear(), visibleMonth.getMonth() + 1, 1);
					loadAvailability();
				});
				updateSelectedDate(selectedDate);
				loadAvailability();

				const count = document.querySelector("[data-count]");
				document.querySelector("[data-count-down]").addEventListener("click", () => { count.value = Math.max(1, Number(count.value) - 1); });
				document.querySelector("[data-count-up]").addEventListener("click", () => { count.value = Number(count.value) + 1; });

				const accountTabs = Array.from(document.querySelectorAll("[data-account-tab]"));
				const accountPanels = Array.from(document.querySelectorAll("[data-account-panel]"));
				accountTabs.forEach((tab) => {
					tab.addEventListener("click", () => {
						accountTabs.forEach((item) => {
							item.setAttribute("aria-pressed", "false");
							item.classList.remove("border-[#00aaaa]", "bg-[#00aaaa]/20", "text-[#73ffff]");
							item.classList.add("border-white/15", "text-white/70");
						});
						tab.setAttribute("aria-pressed", "true");
						tab.classList.remove("border-white/15", "text-white/70");
						tab.classList.add("border-[#00aaaa]", "bg-[#00aaaa]/20", "text-[#73ffff]");

						accountPanels.forEach((panel) => {
							const isActive = panel.dataset.accountPanel === tab.dataset.accountTab;
							panel.classList.toggle("border-2", isActive);
							panel.classList.toggle("border-[#00aaaa]", isActive);
							panel.classList.toggle("bg-[#00aaaa]/10", isActive);
							panel.classList.toggle("border", !isActive);
							panel.classList.toggle("border-white/10", !isActive);
							panel.classList.toggle("bg-black/25", !isActive);
							panel.classList.toggle("opacity-60", !isActive);
						});
					});
				});
			});
		</script>

		<?php include '../resources/footer.php'; ?>
	</body>
</html>
