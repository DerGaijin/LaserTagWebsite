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
					<section class="<?= $section ?> mb-8">
						<div class="mb-4 flex items-end justify-between gap-4 max-[775px]:flex-col max-[775px]:items-start">
							<div>
								<p class="<?= $eyebrow ?>">Feiern</p>
								<h2 class="text-[30px] leading-tight max-[775px]:text-[25px]">Geburtstagspakete</h2>
							</div>
							<p class="<?= $meta ?>">ab 6 Gästen</p>
						</div>
						<div class="<?= $grid ?>">
							<article class="<?= $card ?>" data-offer-card="birthday-basis">
								<div class="<?= $cardHeader ?>">
									<div><p class="<?= $meta ?>">2 Stunden</p><h3 class="<?= $cardTitle ?> mt-3">Geburtstag Basis</h3></div>
									<p class="<?= $price ?>">34,90 €<span class="<?= $priceNote ?>">pro Gast</span></p>
								</div>
								<div class="<?= $cardContent ?>">
									<div class="<?= $details ?>"><p>Getränkeflat für die Gruppe ist enthalten.</p><p>Das Geburtstagskind bekommt einen Slushy dazu.</p></div>
									<button class="Button_Book self-start" type="button" data-select-offer="birthday-basis">Jetzt buchen</button>
								</div>
							</article>

							<article class="<?= $card ?>" data-offer-card="birthday-plus">
								<div class="<?= $cardHeader ?>">
									<div><p class="<?= $meta ?>">3 Stunden</p><h3 class="<?= $cardTitle ?> mt-3">Geburtstag Plus</h3></div>
									<p class="<?= $price ?>">39,90 €<span class="<?= $priceNote ?>">pro Gast</span></p>
								</div>
								<div class="<?= $cardContent ?>">
									<div class="<?= $details ?>"><p>Alle Leistungen aus dem 2-Stunden-Paket sind inklusive.</p><p>Zusätzlich erhält das Geburtstagskind eine Membercard; jeder Gast bekommt eine Snackbox.</p></div>
									<button class="Button_Book self-start" type="button" data-select-offer="birthday-plus">Jetzt buchen</button>
								</div>
							</article>
						</div>
					</section>

					<section class="<?= $section ?> mb-8">
						<div class="mb-4"><p class="<?= $eyebrow ?>">Aktionen</p><h2 class="text-[30px] leading-tight max-[775px]:text-[25px]">Flats am Wochenende</h2></div>
						<div class="<?= $grid ?>">
							<article class="<?= $card ?>" data-offer-card="family-flat">
								<div class="<?= $cardHeader ?>">
									<div><p class="<?= $meta ?>">Samstag & Sonntag</p><h3 class="<?= $cardTitle ?> mt-3">Family Flat</h3></div>
									<p class="<?= $price ?>">15,00 €<span class="<?= $priceNote ?>">pro Person</span></p>
								</div>
								<div class="<?= $cardContent ?>">
									<div class="<?= $details ?>"><p>Spielzeit von 10:00 bis 11:30 Uhr.</p><p>Erwachsene erhalten wahlweise Kaffee oder Tee.</p></div>
									<button class="Button_Book self-start" type="button" data-select-offer="family-flat">Jetzt buchen</button>
								</div>
							</article>

							<article class="<?= $card ?>" data-offer-card="night-special">
								<div class="<?= $cardHeader ?>">
									<div><p class="<?= $meta ?>">Samstag & Sonntag</p><h3 class="<?= $cardTitle ?> mt-3">Night Special</h3></div>
									<p class="<?= $price ?>">27,00 €<span class="<?= $priceNote ?>">pro Person</span></p>
								</div>
								<div class="<?= $cardContent ?>">
									<div class="<?= $details ?>"><p>Drei Stunden Lasertag von 18:00 bis 21:00 Uhr.</p><p>Ideal für Gruppen, die den Abend in der Arena verbringen möchten.</p></div>
									<button class="Button_Book self-start" type="button" data-select-offer="night-special">Jetzt buchen</button>
								</div>
							</article>
						</div>
					</section>

					<section class="<?= $section ?> mb-8">
						<div class="mb-4 flex items-end justify-between gap-4 max-[775px]:flex-col max-[775px]:items-start">
							<div><p class="<?= $eyebrow ?>">Spielzeit</p><h2 class="text-[30px] leading-tight max-[775px]:text-[25px]">Standardbuchungen</h2></div>
						</div>
						<div class="grid grid-cols-2 gap-5 max-[700px]:grid-cols-1">
							<article class="<?= $panel ?> border border-white/10 p-6 text-center" data-offer-card="standard-1h">
								<h3 class="text-[26px]">1 Stunde</h3><p class="mt-4 text-[34px] text-[#73ffff]">18,50 €</p><p class="<?= $bodyText ?> mt-2">pro Person</p>
								<button class="Button_Book mt-5 inline-block" type="button" data-select-offer="standard-1h">Jetzt buchen</button>
							</article>
							<article class="<?= $panel ?> border border-white/10 p-6 text-center" data-offer-card="standard-2h">
								<h3 class="text-[26px]">2 Stunden</h3><p class="mt-4 text-[34px] text-[#73ffff]">36,00 €</p><p class="<?= $bodyText ?> mt-2">pro Person</p>
								<button class="Button_Book mt-5 inline-block" type="button" data-select-offer="standard-2h">Jetzt buchen</button>
							</article>
						</div>
					</section>

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
							<p class="<?= $bodyText ?> mt-3">Ausgewaehlt: <span class="text-[#73ffff]" data-service-title>Standardspiel 2 Stunden</span></p>
						</div>
						<button class="Button_Book" type="button" data-go-step="offer">Angebot aendern</button>
					</div>

					<input type="hidden" name="service_id" value="standard-2h" data-service-id />
					<input type="hidden" name="start_date" value="2026-07-25" data-start-date />
					<input type="hidden" name="start_time" value="14:00:00" data-start-time />

					<div class="rounded-[22px] border border-white/10 bg-black/25 p-4">
						<div class="grid grid-cols-[1fr_1fr_auto] items-end gap-4 max-[760px]:grid-cols-1">
							<div>
								<label class="<?= $label ?>" for="booking-month">Monat</label>
								<select id="booking-month" class="<?= $field ?>" name="month" data-month-select>
									<option value="2026-07">Juli 2026</option>
									<option value="2026-08">August 2026</option>
									<option value="2026-09">September 2026</option>
								</select>
							</div>
							<div>
								<label class="<?= $label ?>" for="booking-week">Woche</label>
								<select id="booking-week" class="<?= $field ?>" name="week" data-week-select>
									<option value="0">22.07. bis 28.07.</option>
									<option value="1">29.07. bis 04.08.</option>
									<option value="2">05.08. bis 11.08.</option>
								</select>
							</div>
							<span class="<?= $stepPill ?>" data-week-summary>Kalenderwoche 30</span>
						</div>

						<div class="mt-5 grid grid-cols-7 gap-2 max-[760px]:grid-cols-4 max-[460px]:grid-cols-2" data-day-list>
							<button class="rounded-2xl border border-white/10 bg-black/30 p-4 text-white/70" type="button" data-date="2026-07-22" data-day-label="Mittwoch"><span>Mi</span><span class="mt-2 block font-[Arial,Helvetica,sans-serif] text-sm">22.07.</span><span class="mt-3 block text-sm text-white/45">3 Slots</span></button>
							<button class="rounded-2xl border border-white/10 bg-black/30 p-4 text-white/70" type="button" data-date="2026-07-23" data-day-label="Donnerstag"><span>Do</span><span class="mt-2 block font-[Arial,Helvetica,sans-serif] text-sm">23.07.</span><span class="mt-3 block text-sm text-white/45">4 Slots</span></button>
							<button class="rounded-2xl border border-white/10 bg-black/30 p-4 text-white/70" type="button" data-date="2026-07-24" data-day-label="Freitag"><span>Fr</span><span class="mt-2 block font-[Arial,Helvetica,sans-serif] text-sm">24.07.</span><span class="mt-3 block text-sm text-white/45">5 Slots</span></button>
							<button class="rounded-2xl border-2 border-[#00aaaa] bg-[#00aaaa]/20 p-4 text-[#73ffff] shadow-[0_0_22px_rgba(0,170,170,0.22)]" type="button" data-date="2026-07-25" data-day-label="Samstag" aria-pressed="true"><span>Sa</span><span class="mt-2 block font-[Arial,Helvetica,sans-serif] text-sm">25.07.</span><span class="mt-3 block text-sm text-white/80">aktiv</span></button>
							<button class="rounded-2xl border border-white/10 bg-black/30 p-4 text-white/70" type="button" data-date="2026-07-26" data-day-label="Sonntag"><span>So</span><span class="mt-2 block font-[Arial,Helvetica,sans-serif] text-sm">26.07.</span><span class="mt-3 block text-sm text-white/45">2 Slots</span></button>
							<button class="rounded-2xl border border-white/10 bg-black/30 p-4 text-white/70" type="button" data-date="2026-07-27" data-day-label="Montag"><span>Mo</span><span class="mt-2 block font-[Arial,Helvetica,sans-serif] text-sm">27.07.</span><span class="mt-3 block text-sm text-white/45">geschlossen</span></button>
							<button class="rounded-2xl border border-white/10 bg-black/30 p-4 text-white/70" type="button" data-date="2026-07-28" data-day-label="Dienstag"><span>Di</span><span class="mt-2 block font-[Arial,Helvetica,sans-serif] text-sm">28.07.</span><span class="mt-3 block text-sm text-white/45">3 Slots</span></button>
						</div>
					</div>

					<div class="mt-5 grid grid-cols-[0.75fr_1.25fr] gap-5 max-[900px]:grid-cols-1">
						<div class="rounded-[22px] border border-white/10 bg-black/25 p-4">
							<p class="<?= $label ?>">Teilnehmer</p>
							<div class="mt-3 flex items-center justify-between rounded-2xl border border-white/15 bg-black/30 p-3">
								<button class="h-10 w-10 rounded-full border border-white/20 text-xl" type="button" data-count-down>-</button>
								<input class="w-20 bg-transparent text-center text-[30px] text-[#73ffff] outline-none" type="number" name="count" value="8" min="1" data-count readonly />
								<button class="h-10 w-10 rounded-full border border-[#00aaaa] text-xl text-[#73ffff]" type="button" data-count-up>+</button>
							</div>
							<p class="<?= $bodyText ?> mt-3 text-base">Die Spieleranzahl kann spaeter fuer Verfuegbarkeit und Preisberechnung genutzt werden.</p>
						</div>
						<div class="rounded-[22px] border border-white/10 bg-black/25 p-4">
							<p class="<?= $label ?>">Zeitfenster <span data-selected-day>am Samstag</span></p>
							<div class="mt-3 grid grid-cols-2 gap-3 max-[520px]:grid-cols-1" data-time-list>
								<button class="rounded-2xl border border-white/15 bg-black/30 p-4 text-left" type="button" data-time="12:00:00"><span class="block text-[24px]">12:00</span><span class="font-[Arial,Helvetica,sans-serif] text-sm text-white/60">2 Stunden</span></button>
								<button class="rounded-2xl border-2 border-[#00aaaa] bg-[#00aaaa]/20 p-4 text-left text-[#73ffff] shadow-[0_0_22px_rgba(0,170,170,0.22)]" type="button" data-time="14:00:00" aria-pressed="true"><span class="block text-[24px]">14:00</span><span class="font-[Arial,Helvetica,sans-serif] text-sm text-white/80">ausgewaehlt</span></button>
								<button class="rounded-2xl border border-white/15 bg-black/30 p-4 text-left" type="button" data-time="16:00:00"><span class="block text-[24px]">16:00</span><span class="font-[Arial,Helvetica,sans-serif] text-sm text-white/60">2 Stunden</span></button>
								<button class="rounded-2xl border border-white/15 bg-black/30 p-4 text-left" type="button" data-time="18:00:00"><span class="block text-[24px]">18:00</span><span class="font-[Arial,Helvetica,sans-serif] text-sm text-white/60">2 Stunden</span></button>
							</div>
						</div>
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
				const services = {
					"birthday-basis": { title: "Geburtstag Basis", description: "2 Stunden Geburtstagspaket mit Getraenkeflat und Slushy fuer das Geburtstagskind." },
					"birthday-plus": { title: "Geburtstag Plus", description: "3 Stunden Geburtstagspaket mit Getraenkeflat, Membercard und Snackboxen." },
					"family-flat": { title: "Family Flat", description: "Wochenend-Spielzeit von 10:00 bis 11:30 Uhr fuer Familien." },
					"night-special": { title: "Night Special", description: "Drei Stunden Lasertag am Wochenende von 18:00 bis 21:00 Uhr." },
					"standard-1h": { title: "Standardspiel 1 Stunde", description: "Eine Stunde Lasertag fuer kurze Matches und spontane Gruppen." },
					"standard-2h": { title: "Standardspiel 2 Stunden", description: "Zwei Stunden Lasertag fuer Gruppen, Teams und laengere Spielrunden." },
				};
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
				const goToStep = (step) => {
					steps.forEach((item) => item.classList.toggle("hidden", item.dataset.wizardStep !== step));
					activateChoice(document.querySelector(`[data-wizard-tab="${step}"]`), tabs);
					window.scrollTo({ top: 0, behavior: "smooth" });
				};

				document.querySelectorAll("[data-go-step]").forEach((button) => button.addEventListener("click", () => goToStep(button.dataset.goStep)));
				tabs.forEach((tab) => tab.addEventListener("click", () => goToStep(tab.dataset.wizardTab)));

				const selectOffer = (serviceId) => {
					const service = services[serviceId] || services["standard-2h"];
					document.querySelector("[data-service-title]").textContent = service.title;
					document.querySelector("[data-service-id]").value = serviceId;
					document.querySelectorAll("[data-offer-card]").forEach((card) => {
						const isActive = card.dataset.offerCard === serviceId;
						card.classList.toggle("ring-2", isActive);
						card.classList.toggle("ring-[#73ffff]", isActive);
					});
					goToStep("schedule");
				};

				document.querySelectorAll("[data-select-offer]").forEach((button) => button.addEventListener("click", () => selectOffer(button.dataset.selectOffer)));

				const params = new URLSearchParams(window.location.search);
				if (services[params.get("service")]) {
					selectOffer(params.get("service"));
				}

				const dayButtons = Array.from(document.querySelectorAll("[data-date]"));
				dayButtons.forEach((button) => {
					button.addEventListener("click", () => {
						activateChoice(button, dayButtons);
						document.querySelector("[data-start-date]").value = button.dataset.date;
						document.querySelector("[data-selected-day]").textContent = "am " + button.dataset.dayLabel;
					});
				});

				const timeButtons = Array.from(document.querySelectorAll("[data-time]"));
				timeButtons.forEach((button) => button.addEventListener("click", () => {
					activateChoice(button, timeButtons);
					document.querySelector("[data-start-time]").value = button.dataset.time;
				}));

				const count = document.querySelector("[data-count]");
				document.querySelector("[data-count-down]").addEventListener("click", () => { count.value = Math.max(1, Number(count.value) - 1); });
				document.querySelector("[data-count-up]").addEventListener("click", () => { count.value = Number(count.value) + 1; });

				document.querySelector("[data-week-select]").addEventListener("change", (event) => {
					document.querySelector("[data-week-summary]").textContent = "Kalenderwoche " + (30 + Number(event.target.value));
				});

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
