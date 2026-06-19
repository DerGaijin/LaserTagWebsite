<!DOCTYPE html>
<?php
$section = 'w-full max-w-[1180px]';
$panel = 'rounded-[25px] bg-[var(--ContentBoxBackground)] shadow-[10px_10px_20px_black]';
$eyebrow = 'text-sm uppercase tracking-[0.24em] text-[#73ffff]';
$headline = 'mt-2 text-center text-[34px] leading-tight max-[775px]:text-[28px]';
$bodyText = 'font-[Arial,Helvetica,sans-serif] text-lg leading-7 text-white/90 max-[775px]:text-base';
$label = 'font-[Arial,Helvetica,sans-serif] text-sm uppercase tracking-[0.12em] text-white/70';
$field = 'mt-2 w-full rounded-xl border border-white/15 bg-black/35 px-4 py-3 font-[Arial,Helvetica,sans-serif] text-white outline-none';
$step = 'rounded-full border border-[#00aaaa] bg-black/35 px-3 py-1 font-[Arial,Helvetica,sans-serif] text-sm text-white/90';
?>
<html lang="de">
	<head>
		<?php require '../resources/head.php'; ?>
		<link rel="stylesheet" href="reservieren.css" />
	</head>
	<body>
		<?php $currentPage = 'reservieren'; include '../resources/header.php'; ?>

		<main class="flex flex-col items-center gap-8 px-[100px] py-[25px] max-[1260px]:px-[15px] max-[775px]:px-[5px]" data-booking-design>
			<section class="<?= $section ?> <?= $panel ?> overflow-hidden border border-[#00aaaa]/40">
				<div class="grid grid-cols-[1.1fr_0.9fr] gap-0 max-[920px]:grid-cols-1">
					<div class="p-8 max-[775px]:p-5">
						<p class="<?= $eyebrow ?>">Reservierung</p>
						<h1 class="<?= $headline ?> text-left max-[775px]:text-left">Termin und Konto bestaetigen</h1>
						<p class="<?= $bodyText ?> mt-4">
							Die Leistung wird auf der Preiseseite ausgewaehlt. Hier waehlt ihr den passenden Tag, das Zeitfenster und meldet euch zur Bestaetigung an oder erstellt ein Konto.
						</p>
					</div>
					<div class="flex min-h-[260px] items-center justify-center bg-gradient-to-br from-[#00aaaa]/25 via-black/20 to-[#73ffff]/10 p-8 max-[775px]:p-5">
						<div class="w-full rounded-[22px] border border-white/15 bg-black/35 p-5 text-center shadow-[0_0_35px_rgba(0,170,170,0.25)]">
							<p class="text-[52px] leading-none text-[#73ffff]">02 03</p>
							<p class="mt-2 text-[24px]">Termin, Konto</p>
							<p class="<?= $bodyText ?> mt-3 text-base">Schritt 1 passiert auf der Preiseseite, damit Angebote nicht doppelt gepflegt werden.</p>
						</div>
					</div>
				</div>
			</section>

			<form class="<?= $section ?> flex flex-col gap-8" action="#" method="post">
				<section class="<?= $panel ?> border border-white/10 p-6 max-[775px]:p-4" data-step="selected-service">
					<div class="grid grid-cols-[1fr_auto] items-center gap-5 max-[760px]:grid-cols-1">
						<div>
							<p class="<?= $eyebrow ?>">Schritt 1 erledigt</p>
							<h2 class="mt-2 text-[32px] leading-tight text-[#73ffff] max-[775px]:text-[26px]" data-service-title>Standardspiel 2 Stunden</h2>
							<p class="<?= $bodyText ?> mt-3" data-service-description>Ausgewaehlt auf der Preiseseite. Ihr koennt jederzeit zurueck wechseln.</p>
						</div>
						<a href="../preise/" class="Button_Book">Andere Leistung waehlen</a>
					</div>
					<div class="mt-5 grid grid-cols-3 gap-4 max-[760px]:grid-cols-1">
						<p class="rounded-2xl border border-white/10 bg-black/25 p-4"><span class="<?= $label ?> block">Dauer</span><span class="mt-2 block text-[24px]" data-service-duration>120 Minuten</span></p>
						<p class="rounded-2xl border border-white/10 bg-black/25 p-4"><span class="<?= $label ?> block">Preis</span><span class="mt-2 block text-[24px] text-[#73ffff]" data-service-price>36,00 EUR p.P.</span></p>
						<p class="rounded-2xl border border-white/10 bg-black/25 p-4"><span class="<?= $label ?> block">Service-ID</span><span class="mt-2 block font-[Arial,Helvetica,sans-serif] text-lg" data-service-id-label>standard-2h</span></p>
					</div>
					<input type="hidden" name="service_id" value="standard-2h" data-service-id />
				</section>

				<section class="<?= $panel ?> border border-white/10 p-6 max-[775px]:p-4" data-step="schedule">
					<div class="mb-6 flex items-center justify-between gap-4 max-[700px]:flex-col max-[700px]:items-start">
						<div>
							<p class="<?= $eyebrow ?>">Schritt 2</p>
							<h2 class="mt-2 text-[32px] leading-tight max-[775px]:text-[26px]">Wann wollt ihr spielen?</h2>
						</div>
						<span class="<?= $step ?>">Woche, Tag, Zeitfenster</span>
					</div>
					<input type="hidden" name="start_date" value="2026-07-25" data-start-date />
					<input type="hidden" name="start_time" value="14:00:00" data-start-time />

					<div class="rounded-[22px] border border-white/10 bg-black/25 p-4">
						<div class="flex items-center justify-between gap-4 max-[700px]:flex-col max-[700px]:items-start">
							<button class="rounded-full border border-white/15 px-4 py-2 text-white/70" type="button" data-week-prev>Vorige Woche</button>
							<div class="text-center max-[700px]:text-left">
								<p class="<?= $label ?>" data-week-number>Kalenderwoche 30</p>
								<p class="mt-1 text-[24px] text-[#73ffff]" data-week-range>22. Juli bis 28. Juli 2026</p>
							</div>
							<button class="rounded-full border border-[#00aaaa] px-4 py-2 text-[#73ffff]" type="button" data-week-next>Naechste Woche</button>
						</div>

						<div class="mt-5 grid grid-cols-7 gap-2 max-[760px]:grid-cols-4 max-[460px]:grid-cols-2" data-day-list>
							<button class="rounded-2xl border border-white/10 bg-black/30 p-4 text-white/70" type="button" data-date="2026-07-22" data-day-label="Mittwoch, 22. Juli">Mi<span class="mt-2 block font-[Arial,Helvetica,sans-serif] text-sm">22.07.</span><span class="mt-3 block text-sm text-white/45">3 Slots</span></button>
							<button class="rounded-2xl border border-white/10 bg-black/30 p-4 text-white/70" type="button" data-date="2026-07-23" data-day-label="Donnerstag, 23. Juli">Do<span class="mt-2 block font-[Arial,Helvetica,sans-serif] text-sm">23.07.</span><span class="mt-3 block text-sm text-white/45">4 Slots</span></button>
							<button class="rounded-2xl border border-white/10 bg-black/30 p-4 text-white/70" type="button" data-date="2026-07-24" data-day-label="Freitag, 24. Juli">Fr<span class="mt-2 block font-[Arial,Helvetica,sans-serif] text-sm">24.07.</span><span class="mt-3 block text-sm text-white/45">5 Slots</span></button>
							<button class="rounded-2xl border-2 border-[#00aaaa] bg-[#00aaaa]/20 p-4 text-[#73ffff] shadow-[0_0_22px_rgba(0,170,170,0.22)]" type="button" data-date="2026-07-25" data-day-label="Samstag, 25. Juli" aria-pressed="true">Sa<span class="mt-2 block font-[Arial,Helvetica,sans-serif] text-sm">25.07.</span><span class="mt-3 block text-sm text-white/80">aktiv</span></button>
							<button class="rounded-2xl border border-white/10 bg-black/30 p-4 text-white/70" type="button" data-date="2026-07-26" data-day-label="Sonntag, 26. Juli">So<span class="mt-2 block font-[Arial,Helvetica,sans-serif] text-sm">26.07.</span><span class="mt-3 block text-sm text-white/45">2 Slots</span></button>
							<button class="rounded-2xl border border-white/10 bg-black/30 p-4 text-white/70" type="button" data-date="2026-07-27" data-day-label="Montag, 27. Juli">Mo<span class="mt-2 block font-[Arial,Helvetica,sans-serif] text-sm">27.07.</span><span class="mt-3 block text-sm text-white/45">geschlossen</span></button>
							<button class="rounded-2xl border border-white/10 bg-black/30 p-4 text-white/70" type="button" data-date="2026-07-28" data-day-label="Dienstag, 28. Juli">Di<span class="mt-2 block font-[Arial,Helvetica,sans-serif] text-sm">28.07.</span><span class="mt-3 block text-sm text-white/45">3 Slots</span></button>
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
				</section>

				<section class="<?= $panel ?> border border-white/10 p-6 max-[775px]:p-4" data-step="account">
					<div class="mb-6 flex items-center justify-between gap-4 max-[700px]:flex-col max-[700px]:items-start">
						<div>
							<p class="<?= $eyebrow ?>">Schritt 3</p>
							<h2 class="mt-2 text-[32px] leading-tight max-[775px]:text-[26px]">Einloggen oder Konto erstellen</h2>
						</div>
						<span class="<?= $step ?>">Kundenkonto</span>
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
								<div>
									<label class="<?= $label ?>" for="login-email">E-Mail</label>
									<input id="login-email" class="<?= $field ?>" type="email" name="login_email" placeholder="kunde@example.de" />
								</div>
								<div>
									<label class="<?= $label ?>" for="login-password">Passwort</label>
									<input id="login-password" class="<?= $field ?>" type="password" placeholder="Passwort" />
								</div>
								<button class="Button_Book opacity-70" type="button" aria-disabled="true">Einloggen & bestaetigen</button>
							</div>
						</div>

						<div class="rounded-[22px] border border-white/10 bg-black/25 p-5 opacity-60" data-account-panel="register">
							<p class="text-[26px]">Konto erstellen</p>
							<p class="<?= $bodyText ?> mt-2 text-base">Neue Kunden registrieren sich, bevor der Termin verbindlich bestaetigt wird.</p>
							<div class="mt-5 grid grid-cols-2 gap-4 max-[520px]:grid-cols-1">
								<div>
									<label class="<?= $label ?>" for="register-name">Name</label>
									<input id="register-name" class="<?= $field ?>" type="text" name="client[name]" placeholder="Max Mustermann" />
								</div>
								<div>
									<label class="<?= $label ?>" for="register-phone">Telefon</label>
									<input id="register-phone" class="<?= $field ?>" type="tel" name="client[phone]" placeholder="0123 456789" />
								</div>
								<div class="col-span-2 max-[520px]:col-auto">
									<label class="<?= $label ?>" for="register-email">E-Mail</label>
									<input id="register-email" class="<?= $field ?>" type="email" name="client[email]" placeholder="max@example.de" />
								</div>
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
					"birthday-basis": {
						title: "Geburtstag Basis",
						description: "2 Stunden Geburtstagspaket mit Getraenkeflat und Slushy fuer das Geburtstagskind.",
						duration: "120 Minuten",
						price: "34,90 EUR p.P.",
					},
					"birthday-plus": {
						title: "Geburtstag Plus",
						description: "3 Stunden Geburtstagspaket mit Getraenkeflat, Membercard und Snackboxen.",
						duration: "180 Minuten",
						price: "39,90 EUR p.P.",
					},
					"family-flat": {
						title: "Family Flat",
						description: "Wochenend-Spielzeit von 10:00 bis 11:30 Uhr fuer Familien.",
						duration: "90 Minuten",
						price: "15,00 EUR p.P.",
					},
					"night-special": {
						title: "Night Special",
						description: "Drei Stunden Lasertag am Wochenende von 18:00 bis 21:00 Uhr.",
						duration: "180 Minuten",
						price: "27,00 EUR p.P.",
					},
					"standard-1h": {
						title: "Standardspiel 1 Stunde",
						description: "Eine Stunde Lasertag fuer kurze Matches und spontane Gruppen.",
						duration: "60 Minuten",
						price: "18,50 EUR p.P.",
					},
					"standard-2h": {
						title: "Standardspiel 2 Stunden",
						description: "Zwei Stunden Lasertag fuer Gruppen, Teams und laengere Spielrunden.",
						duration: "120 Minuten",
						price: "36,00 EUR p.P.",
					},
				};

				const params = new URLSearchParams(window.location.search);
				const serviceId = services[params.get("service")] ? params.get("service") : "standard-2h";
				const service = services[serviceId];

				document.querySelector("[data-service-title]").textContent = service.title;
				document.querySelector("[data-service-description]").textContent = service.description;
				document.querySelector("[data-service-duration]").textContent = service.duration;
				document.querySelector("[data-service-price]").textContent = service.price;
				document.querySelector("[data-service-id-label]").textContent = serviceId;
				document.querySelector("[data-service-id]").value = serviceId;

				const activate = (button, buttons) => {
					buttons.forEach((item) => {
						item.setAttribute("aria-pressed", "false");
						item.classList.remove("border-2", "border-[#00aaaa]", "bg-[#00aaaa]/20", "text-[#73ffff]", "shadow-[0_0_22px_rgba(0,170,170,0.22)]");
						item.classList.add("border", "border-white/10", "bg-black/30", "text-white/70");
					});
					button.setAttribute("aria-pressed", "true");
					button.classList.remove("border", "border-white/10", "bg-black/30", "text-white/70");
					button.classList.add("border-2", "border-[#00aaaa]", "bg-[#00aaaa]/20", "text-[#73ffff]", "shadow-[0_0_22px_rgba(0,170,170,0.22)]");
				};

				const dayButtons = Array.from(document.querySelectorAll("[data-date]"));
				dayButtons.forEach((button) => {
					button.addEventListener("click", () => {
						activate(button, dayButtons);
						document.querySelector("[data-start-date]").value = button.dataset.date;
						document.querySelector("[data-selected-day]").textContent = "am " + button.dataset.dayLabel.split(",")[0];
					});
				});

				const timeButtons = Array.from(document.querySelectorAll("[data-time]"));
				timeButtons.forEach((button) => {
					button.addEventListener("click", () => {
						activate(button, timeButtons);
						document.querySelector("[data-start-time]").value = button.dataset.time;
					});
				});

				const count = document.querySelector("[data-count]");
				document.querySelector("[data-count-down]").addEventListener("click", () => {
					count.value = Math.max(1, Number(count.value) - 1);
				});
				document.querySelector("[data-count-up]").addEventListener("click", () => {
					count.value = Number(count.value) + 1;
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

				let weekOffset = 0;
				const updateWeek = () => {
					document.querySelector("[data-week-number]").textContent = "Kalenderwoche " + (30 + weekOffset);
					document.querySelector("[data-week-range]").textContent = weekOffset === 0 ? "22. Juli bis 28. Juli 2026" : "Beispielwoche " + (30 + weekOffset);
				};
				document.querySelector("[data-week-prev]").addEventListener("click", () => {
					weekOffset -= 1;
					updateWeek();
				});
				document.querySelector("[data-week-next]").addEventListener("click", () => {
					weekOffset += 1;
					updateWeek();
				});
			});
		</script>

		<?php include '../resources/footer.php'; ?>
	</body>
</html>
