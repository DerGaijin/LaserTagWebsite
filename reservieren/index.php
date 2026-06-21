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

					<div class="grid grid-cols-[minmax(0,1fr)_minmax(340px,0.72fr)] gap-5 max-[980px]:grid-cols-1">
						<div class="rounded-[22px] border border-white/10 bg-black/25 p-4">
							<input type="hidden" name="month" value="2026-07" data-month-input />
							<div class="flex items-center justify-between gap-4 max-[560px]:flex-col max-[560px]:items-stretch">
								<button class="rounded-2xl border border-white/15 bg-black/30 px-4 py-3 text-white/80 hover:border-[#00aaaa] hover:text-[#73ffff]" type="button" data-calendar-prev>Zurueck</button>
								<div class="text-center">
									<p class="<?= $label ?>">Datum waehlen</p>
									<h3 class="mt-1 text-[30px] leading-none text-[#73ffff] max-[775px]:text-[24px]" data-calendar-title>Juli 2026</h3>
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
										<p class="mt-1 text-[24px] leading-tight text-[#73ffff]" data-selected-date-label>Samstag, 25.07.2026</p>
										<p class="<?= $bodyText ?> mt-1 text-base">Start: <span class="text-white" data-selected-time-label>14:00 Uhr</span></p>
									</div>
									<span class="<?= $stepPill ?>" data-availability-label>12 Zeitfenster verfuegbar</span>
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
									<button class="rounded-xl border border-white/15 bg-black/30 px-3 py-2 text-left hover:border-[#00aaaa]/70 hover:text-[#73ffff]" type="button" data-time="10:00:00"><span class="block text-[21px] leading-tight">10:00</span><span class="font-[Arial,Helvetica,sans-serif] text-xs text-white/60">2 Std.</span></button>
									<button class="rounded-xl border border-white/15 bg-black/30 px-3 py-2 text-left hover:border-[#00aaaa]/70 hover:text-[#73ffff]" type="button" data-time="10:30:00"><span class="block text-[21px] leading-tight">10:30</span><span class="font-[Arial,Helvetica,sans-serif] text-xs text-white/60">2 Std.</span></button>
									<button class="rounded-xl border border-white/15 bg-black/30 px-3 py-2 text-left hover:border-[#00aaaa]/70 hover:text-[#73ffff]" type="button" data-time="11:00:00"><span class="block text-[21px] leading-tight">11:00</span><span class="font-[Arial,Helvetica,sans-serif] text-xs text-white/60">2 Std.</span></button>
									<button class="rounded-xl border border-white/15 bg-black/30 px-3 py-2 text-left hover:border-[#00aaaa]/70 hover:text-[#73ffff]" type="button" data-time="11:30:00"><span class="block text-[21px] leading-tight">11:30</span><span class="font-[Arial,Helvetica,sans-serif] text-xs text-white/60">2 Std.</span></button>
									<button class="rounded-xl border border-white/15 bg-black/30 px-3 py-2 text-left hover:border-[#00aaaa]/70 hover:text-[#73ffff]" type="button" data-time="12:00:00"><span class="block text-[21px] leading-tight">12:00</span><span class="font-[Arial,Helvetica,sans-serif] text-xs text-white/60">2 Std.</span></button>
									<button class="rounded-xl border border-white/15 bg-black/30 px-3 py-2 text-left hover:border-[#00aaaa]/70 hover:text-[#73ffff]" type="button" data-time="12:30:00"><span class="block text-[21px] leading-tight">12:30</span><span class="font-[Arial,Helvetica,sans-serif] text-xs text-white/60">2 Std.</span></button>
									<button class="rounded-xl border border-white/15 bg-black/30 px-3 py-2 text-left hover:border-[#00aaaa]/70 hover:text-[#73ffff]" type="button" data-time="13:00:00"><span class="block text-[21px] leading-tight">13:00</span><span class="font-[Arial,Helvetica,sans-serif] text-xs text-white/60">2 Std.</span></button>
									<button class="rounded-xl border border-white/15 bg-black/30 px-3 py-2 text-left hover:border-[#00aaaa]/70 hover:text-[#73ffff]" type="button" data-time="13:30:00"><span class="block text-[21px] leading-tight">13:30</span><span class="font-[Arial,Helvetica,sans-serif] text-xs text-white/60">2 Std.</span></button>
									<button class="rounded-xl border-2 border-[#00aaaa] bg-[#00aaaa]/20 px-3 py-2 text-left text-[#73ffff] shadow-[0_0_22px_rgba(0,170,170,0.22)]" type="button" data-time="14:00:00" aria-pressed="true"><span class="block text-[21px] leading-tight">14:00</span><span class="font-[Arial,Helvetica,sans-serif] text-xs text-white/80">ausgewaehlt</span></button>
									<button class="rounded-xl border border-white/15 bg-black/30 px-3 py-2 text-left hover:border-[#00aaaa]/70 hover:text-[#73ffff]" type="button" data-time="14:30:00"><span class="block text-[21px] leading-tight">14:30</span><span class="font-[Arial,Helvetica,sans-serif] text-xs text-white/60">2 Std.</span></button>
									<button class="rounded-xl border border-white/15 bg-black/30 px-3 py-2 text-left hover:border-[#00aaaa]/70 hover:text-[#73ffff]" type="button" data-time="15:00:00"><span class="block text-[21px] leading-tight">15:00</span><span class="font-[Arial,Helvetica,sans-serif] text-xs text-white/60">2 Std.</span></button>
									<button class="rounded-xl border border-white/15 bg-black/30 px-3 py-2 text-left hover:border-[#00aaaa]/70 hover:text-[#73ffff]" type="button" data-time="15:30:00"><span class="block text-[21px] leading-tight">15:30</span><span class="font-[Arial,Helvetica,sans-serif] text-xs text-white/60">2 Std.</span></button>
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

				const monthNames = ["Januar", "Februar", "Maerz", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];
				const dayNames = ["Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag"];
				const availabilityByDay = [12, 0, 12, 12, 12, 12, 12];
				const calendarGrid = document.querySelector("[data-calendar-grid]");
				const calendarTitle = document.querySelector("[data-calendar-title]");
				const selectedDateLabel = document.querySelector("[data-selected-date-label]");
				const availabilityLabel = document.querySelector("[data-availability-label]");
				const selectedTimeLabel = document.querySelector("[data-selected-time-label]");
				const monthInput = document.querySelector("[data-month-input]");
				const today = new Date();
				today.setHours(0, 0, 0, 0);
				let selectedDate = new Date(document.querySelector("[data-start-date]").value + "T00:00:00");
				if (selectedDate < today) {
					selectedDate = new Date(today);
				}
				let visibleMonth = new Date(selectedDate.getFullYear(), selectedDate.getMonth(), 1);

				const padDatePart = (value) => String(value).padStart(2, "0");
				const toDateValue = (date) => date.getFullYear() + "-" + padDatePart(date.getMonth() + 1) + "-" + padDatePart(date.getDate());
				const toDisplayDate = (date) => dayNames[date.getDay()] + ", " + padDatePart(date.getDate()) + "." + padDatePart(date.getMonth() + 1) + "." + date.getFullYear();

				const updateSelectedDate = (date) => {
					selectedDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
					document.querySelector("[data-start-date]").value = toDateValue(selectedDate);
					document.querySelector("[data-selected-day]").textContent = "am " + dayNames[selectedDate.getDay()];
					selectedDateLabel.textContent = toDisplayDate(selectedDate);
					const slots = availabilityByDay[selectedDate.getDay()];
					availabilityLabel.textContent = slots === 0 ? "geschlossen" : slots + " Zeitfenster verfuegbar";
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
						const isSelected = toDateValue(date) === toDateValue(selectedDate);
						const isMondayClosed = date.getDay() === 1;
						const isPast = date < today;
						const isDisabled = isPast || isMondayClosed;
						const button = document.createElement("button");
						button.type = "button";
						button.className = "min-h-[76px] rounded-2xl border p-2 text-left transition max-[560px]:min-h-[58px]";
						button.className += isDisabled ? " border-white/5 bg-black/20 text-white/30" : isSelected ? " border-[#00aaaa] bg-[#00aaaa]/25 text-[#73ffff] shadow-[0_0_22px_rgba(0,170,170,0.22)]" : " border-white/10 bg-black/30 text-white/75 hover:border-[#00aaaa]/70 hover:text-[#73ffff]";
						button.disabled = isDisabled;
						button.innerHTML = '<span class="block text-[22px] leading-none max-[560px]:text-[18px]">' + day + '</span><span class="mt-2 block font-[Arial,Helvetica,sans-serif] text-xs ' + (isSelected ? 'text-white/85' : 'text-white/45') + '">' + (isPast ? 'vergangen' : isMondayClosed ? 'geschlossen' : availabilityByDay[date.getDay()] + ' Slots') + '</span>';
						if (!isDisabled) {
							button.addEventListener("click", () => {
								updateSelectedDate(date);
								renderCalendar();
							});
						}
						calendarGrid.appendChild(button);
					}
				};

				document.querySelector("[data-calendar-prev]").addEventListener("click", () => {
					visibleMonth = new Date(visibleMonth.getFullYear(), visibleMonth.getMonth() - 1, 1);
					renderCalendar();
				});
				document.querySelector("[data-calendar-next]").addEventListener("click", () => {
					visibleMonth = new Date(visibleMonth.getFullYear(), visibleMonth.getMonth() + 1, 1);
					renderCalendar();
				});
				updateSelectedDate(selectedDate);
				renderCalendar();

				const timeButtons = Array.from(document.querySelectorAll("[data-time]"));
				const formatTimeLabel = (value) => value.slice(0, 5) + " Uhr";
				timeButtons.forEach((button) => button.addEventListener("click", () => {
					activateChoice(button, timeButtons);
					document.querySelector("[data-start-time]").value = button.dataset.time;
					selectedTimeLabel.textContent = formatTimeLabel(button.dataset.time);
				}));

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
