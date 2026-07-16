<!DOCTYPE html>
<?php
$section = 'w-full max-w-[1180px]';
$panel = 'rounded-[25px] bg-[var(--ContentBoxBackground)] shadow-[10px_10px_20px_black]';
$eyebrow = 'text-sm uppercase tracking-[0.24em] text-[#73ffff]';
$headline = 'mt-2 text-center text-[34px] leading-tight max-[775px]:text-[28px]';
$bodyText = 'font-[Arial,Helvetica,sans-serif] text-lg leading-7 text-white/90 max-[775px]:text-base';
$meta = 'inline-flex w-fit rounded-full border border-[#00aaaa] px-3 py-1 font-[Arial,Helvetica,sans-serif] text-sm text-white/90';
$label = 'font-[Arial,Helvetica,sans-serif] text-sm uppercase tracking-[0.12em] text-white/70';
$field = 'mt-2 w-full rounded-xl border border-white/15 bg-black/35 px-4 py-3 font-[Arial,Helvetica,sans-serif] text-white outline-none';
$stepPill = 'rounded-full border border-[#00aaaa] bg-black/35 px-3 py-1 font-[Arial,Helvetica,sans-serif] text-sm text-white/90';
$defaultOfferId = 21;
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
			<aside class="<?= $section ?> sticky top-[120px] z-[3] hidden rounded-[22px] border border-[#00aaaa]/35 bg-[#151515]/95 p-4 shadow-[0_12px_30px_rgba(0,0,0,.45)] backdrop-blur lg:grid lg:grid-cols-4 lg:gap-4" data-booking-summary>
				<div><p class="<?= $label ?>">Angebot</p><p class="mt-1 text-[#73ffff]" data-summary-offer>Bitte wählen</p></div>
				<div><p class="<?= $label ?>">Termin</p><p class="mt-1 text-[#73ffff]" data-summary-date>Bitte wählen</p></div>
				<div><p class="<?= $label ?>">Start</p><p class="mt-1 text-[#73ffff]" data-summary-time>Bitte wählen</p></div>
				<div><p class="<?= $label ?>">Spieler</p><p class="mt-1 text-[#73ffff]"><span data-summary-count>8</span> Personen</p></div>
			</aside>

			<nav class="<?= $section ?> grid grid-cols-4 gap-3 max-[900px]:grid-cols-2 max-[520px]:grid-cols-1" aria-label="Buchungsschritte">
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
				<button class="rounded-2xl border border-white/10 bg-black/30 p-4 text-left text-white/70" type="button" data-wizard-tab="confirm">
					<span class="<?= $label ?> block">Schritt 4</span>
					<span class="mt-1 block text-[24px]">Bestätigen</span>
				</button>
			</nav>

			<form class="<?= $section ?> flex flex-col gap-8" action="book.php" method="post" data-booking-form>
				<section data-wizard-step="offer">
					<div class="mb-5 flex items-center gap-3 rounded-2xl border border-[#00aaaa]/35 bg-[#00aaaa]/10 p-4 font-[Arial,Helvetica,sans-serif] text-sm text-[#73ffff]" data-services-loading role="status">
						<span class="inline-block h-4 w-4 animate-spin rounded-full border-2 border-[#73ffff]/30 border-t-[#73ffff]"></span>
						Angebote werden aktualisiert...
					</div>
					<div class="hidden" data-offer-sections hidden>
					</div>

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
							<p class="<?= $bodyText ?> mt-3">Ausgewählt: <span class="text-[#73ffff]" data-offer-title>Bitte Angebot wählen</span></p>
						</div>
						<button class="Button_Book" type="button" data-go-step="offer">Angebot ändern</button>
					</div>

					<input type="hidden" name="offer_id" value="" data-offer-id />
					<input type="hidden" name="start_date" value="<?= htmlspecialchars($defaultDate) ?>" data-start-date />
					<input type="hidden" name="start_time" value="" data-start-time />
					<input type="hidden" name="client_id" value="" data-client-id />

					<div class="grid grid-cols-[minmax(0,1fr)_minmax(340px,0.72fr)] gap-5 max-[980px]:grid-cols-1">
						<div class="rounded-[22px] border border-white/10 bg-black/25 p-4">
							<input type="hidden" name="month" value="<?= htmlspecialchars($defaultMonth) ?>" data-month-input />
							<div class="flex items-center justify-between gap-4 max-[560px]:flex-col max-[560px]:items-stretch">
								<button class="rounded-2xl border border-white/15 bg-black/30 px-4 py-3 text-white/80 hover:border-[#00aaaa] hover:text-[#73ffff]" type="button" data-calendar-prev>Zurück</button>
								<div class="text-center">
									<p class="<?= $label ?>">Datum wählen</p>
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
										<p class="<?= $label ?>">Ausgewählter Termin</p>
										<p class="mt-1 text-[24px] leading-tight text-[#73ffff]" data-selected-date-label></p>
										<p class="<?= $bodyText ?> mt-1 text-base">Start: <span class="text-white" data-selected-time-label>Bitte wählen</span></p>
									</div>
									<span class="<?= $stepPill ?>" data-availability-label>Angebot auswählen</span>
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
										<p class="<?= $bodyText ?> mt-1 text-base">Kompakte Auswahl für Tage mit vielen Startzeiten.</p>
									</div>
								</div>
								<div class="mt-3 grid max-h-[360px] gap-1.5 overflow-y-auto pr-1" data-time-list>
									<div class="col-span-full rounded-xl border border-white/10 bg-black/25 p-4 font-[Arial,Helvetica,sans-serif] text-sm text-white/70">Wählt zuerst ein Angebot aus, danach prüfen wir die freien Startzeiten.</div>
							</div>
						</div>
						</aside>
					</div>
					<div class="mt-6 flex justify-end"><button class="Button_Book" type="button" data-go-step="account">Weiter zum Konto</button></div>
				</section>

				<section class="<?= $panel ?> hidden overflow-hidden border border-white/10 p-0" data-wizard-step="account">
					<div class="grid grid-cols-[0.78fr_1fr] max-[980px]:grid-cols-1">
						<aside class="border-r border-white/10 bg-[radial-gradient(circle_at_top_left,rgba(0,170,170,0.24),transparent_42%),rgba(0,0,0,0.22)] p-6 max-[775px]:p-4 max-[980px]:border-r-0 max-[980px]:border-b">
							<p class="<?= $eyebrow ?>">Schritt 3</p>
							<h2 class="mt-2 text-[34px] leading-tight text-[#73ffff] max-[775px]:text-[28px]">Wer bucht?</h2>
							<p class="<?= $bodyText ?> mt-3 text-base">Wählt aus, ob ihr ein bestehendes Konto nutzen oder ein neues Konto erstellen wollt.</p>

							<div class="mt-6 grid gap-3">
								<button class="rounded-[22px] border border-[#00aaaa] bg-[#00aaaa]/20 p-4 text-left text-[#73ffff] transition hover:border-[#73ffff]" type="button" data-account-tab="login" aria-pressed="true">
									<span class="<?= $label ?> block">Bestehendes Konto</span>
									<span class="mt-1 block text-[24px] leading-tight">Einloggen</span>
									<span class="mt-2 block font-[Arial,Helvetica,sans-serif] text-sm text-white/65">Schnell weiter mit gespeicherten Kundendaten.</span>
								</button>
								<button class="rounded-[22px] border border-white/15 bg-black/25 p-4 text-left text-white/70 transition hover:border-[#00aaaa]/70 hover:text-[#73ffff]" type="button" data-account-tab="register">
									<span class="<?= $label ?> block">Neu bei uns</span>
									<span class="mt-1 block text-[24px] leading-tight">Konto erstellen</span>
									<span class="mt-2 block font-[Arial,Helvetica,sans-serif] text-sm text-white/65">Einmal registrieren und die Buchung direkt abschließen.</span>
								</button>
							</div>
						</aside>

						<div class="grid gap-5 p-6 max-[775px]:p-4">
							<div class="rounded-[26px] border-2 border-[#00aaaa] bg-[#00aaaa]/10 p-5 shadow-[0_0_28px_rgba(0,170,170,0.16)]" data-account-panel="login">
								<div class="flex items-start justify-between gap-4 max-[600px]:flex-col">
									<div>
										<p class="<?= $label ?>">Login</p>
										<p class="mt-1 text-[28px] leading-tight text-[#73ffff]">Willkommen zurück</p>
									</div>
								</div>
								<p class="<?= $bodyText ?> mt-3 text-base">Nutzt euer SimplyBook-Konto, um den Termin ohne erneute Dateneingabe zu bestätigen.</p>

								<div class="mt-5 grid grid-cols-2 gap-4 max-[700px]:grid-cols-1" data-login-form>
									<div><label class="<?= $label ?>" for="login-email">E-Mail</label><input id="login-email" class="<?= $field ?>" type="email" name="login_email" placeholder="kunde@example.de" autocomplete="email" data-login-email /></div>
									<div><label class="<?= $label ?>" for="login-password">Passwort</label><input id="login-password" class="<?= $field ?>" type="password" placeholder="Passwort" autocomplete="current-password" data-login-password /></div>
									<p class="hidden rounded-xl border border-white/10 bg-black/25 p-3 font-[Arial,Helvetica,sans-serif] text-sm max-[700px]:col-auto" data-login-message></p>
									<div class="flex items-end"><button class="Button_Book w-full" type="button" data-login-submit>Einloggen</button></div>
								</div>

								<div class="mt-5 hidden rounded-2xl border border-[#00aaaa]/40 bg-black/25 p-4" data-logged-in-panel>
									<p class="<?= $label ?>">Eingeloggt als</p>
									<p class="mt-2 text-[24px] leading-tight text-[#73ffff]" data-client-name></p>
									<p class="<?= $bodyText ?> mt-1 text-base" data-client-email></p>
									<p class="<?= $bodyText ?> mt-1 hidden text-base" data-client-phone></p>
									<div class="mt-5 flex flex-wrap gap-3">
										<button class="Button_Book" type="button" data-go-step="confirm">Weiter zur Bestätigung</button>
										<button class="rounded-2xl border border-white/15 bg-black/30 px-4 py-3 text-white/80 hover:border-[#00aaaa] hover:text-[#73ffff]" type="button" data-login-logout>Anderes Konto nutzen</button>
									</div>
								</div>
							</div>

							<div class="hidden rounded-[26px] border border-white/10 bg-black/25 p-5 opacity-60" data-account-panel="register">
								<div>
									<p class="<?= $label ?>">Registrierung</p>
									<p class="mt-1 text-[28px] leading-tight">Neues Kundenkonto</p>
									<p class="<?= $bodyText ?> mt-3 text-base">Erstellt ein Konto für diese und spätere Reservierungen.</p>
								</div>
								<div class="mt-5 grid grid-cols-2 gap-4 max-[700px]:grid-cols-1" data-register-form>
									<div><label class="<?= $label ?>" for="register-name">Name</label><input id="register-name" class="<?= $field ?>" type="text" name="client[name]" placeholder="Max Mustermann" autocomplete="name" data-register-name /></div>
									<div><label class="<?= $label ?>" for="register-phone">Telefon</label><input id="register-phone" class="<?= $field ?>" type="tel" name="client[phone]" placeholder="0123 456789" autocomplete="tel" data-register-phone /></div>
									<div class="col-span-2 max-[700px]:col-auto"><label class="<?= $label ?>" for="register-email">E-Mail</label><input id="register-email" class="<?= $field ?>" type="email" name="client[email]" placeholder="max@example.de" autocomplete="email" data-register-email /></div>
									<div><label class="<?= $label ?>" for="register-password">Passwort</label><input id="register-password" class="<?= $field ?>" type="password" autocomplete="new-password" data-register-password /></div>
									<div><label class="<?= $label ?>" for="register-password-confirm">Passwort wiederholen</label><input id="register-password-confirm" class="<?= $field ?>" type="password" autocomplete="new-password" data-register-password-confirm /></div>
								</div>
								<p class="mt-4 hidden rounded-xl border border-white/10 bg-black/25 p-3 font-[Arial,Helvetica,sans-serif] text-sm" data-register-message></p>
								<button class="Button_Book mt-5" type="button" data-register-submit>Konto erstellen</button>
							</div>
						</div>
					</div>
				</section>

				<section class="<?= $panel ?> hidden border border-white/10 p-6 max-[775px]:p-4" data-wizard-step="confirm">
					<div class="mb-6 flex items-center justify-between gap-4 max-[700px]:flex-col max-[700px]:items-start">
						<div><p class="<?= $eyebrow ?>">Schritt 4</p><h2 class="mt-2 text-[32px] leading-tight max-[775px]:text-[26px]">Buchung prüfen und bestätigen</h2></div>
						<span class="<?= $stepPill ?>">Letzter Schritt</span>
					</div>

					<div class="grid grid-cols-[1fr_0.72fr] gap-5 max-[900px]:grid-cols-1">
						<div class="rounded-[22px] border border-[#00aaaa]/35 bg-[#00aaaa]/10 p-5">
							<p class="text-[26px] text-[#73ffff]">Eure Auswahl</p>
							<div class="mt-5 grid grid-cols-2 gap-4 font-[Arial,Helvetica,sans-serif] max-[560px]:grid-cols-1">
								<div class="rounded-2xl border border-white/10 bg-black/25 p-4"><p class="<?= $label ?>">Angebot</p><p class="mt-2 text-lg" data-confirm-offer>Bitte Angebot wählen</p></div>
								<div class="rounded-2xl border border-white/10 bg-black/25 p-4"><p class="<?= $label ?>">Teilnehmer</p><p class="mt-2 text-lg"><span data-confirm-count>8</span> Personen</p></div>
								<div class="rounded-2xl border border-white/10 bg-black/25 p-4"><p class="<?= $label ?>">Datum</p><p class="mt-2 text-lg" data-confirm-date></p></div>
								<div class="rounded-2xl border border-white/10 bg-black/25 p-4"><p class="<?= $label ?>">Startzeit</p><p class="mt-2 text-lg" data-confirm-time>Bitte wählen</p></div>
								<div class="col-span-2 rounded-2xl border border-white/10 bg-black/25 p-4 max-[560px]:col-auto">
									<p class="<?= $label ?>">Kundenkonto</p>
									<p class="mt-2 text-lg text-[#73ffff]" data-confirm-client-name>Nicht eingeloggt</p>
									<p class="mt-1 text-sm text-white/70" data-confirm-client-email>Bitte in Schritt 3 einloggen.</p>
									<p class="mt-1 hidden text-sm text-white/70" data-confirm-client-phone></p>
								</div>
							</div>
						</div>

						<aside class="rounded-[22px] border border-white/10 bg-black/25 p-5">
							<p class="text-[26px]">Bereit?</p>
							<p class="<?= $bodyText ?> mt-2 text-base">Prüft die Angaben ein letztes Mal. Danach kann die Buchung bestätigt werden.</p>
							<div class="mt-5 flex flex-col gap-3">
								<button class="Button_Book" type="submit" data-booking-submit>Buchung bestätigen</button>
								<button class="rounded-2xl border border-white/15 bg-black/30 px-4 py-3 text-white/80 hover:border-[#00aaaa] hover:text-[#73ffff]" type="button" data-go-step="schedule">Termin ändern</button>
							</div>
						</aside>
					</div>

					<div class="mt-5 hidden rounded-2xl border border-white/10 bg-black/25 p-4" data-booking-message>
						<p class="<?= $bodyText ?> text-base"></p>
					</div>
				</section>
			</form>

			<div class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 px-4 backdrop-blur-sm" data-booking-success>
				<section class="w-full max-w-[680px] rounded-[30px] border-2 border-[#00aaaa] bg-[var(--ContentBoxBackground)] p-8 text-center text-white shadow-[0_0_55px_rgba(0,170,170,0.45)] max-[560px]:p-5" role="dialog" aria-modal="true" aria-labelledby="booking-success-title">
					<div class="Success_Check mx-auto flex h-20 w-20 items-center justify-center rounded-full border-2 border-[#73ffff] bg-[#00aaaa]/25 text-[42px] text-[#73ffff] shadow-[0_0_28px_rgba(115,255,255,0.35)]">✓</div>
					<p class="<?= $eyebrow ?> mt-6 justify-self-center">Reservierung erfolgreich</p>
					<h2 id="booking-success-title" class="mt-2 text-[38px] leading-tight text-[#73ffff] max-[560px]:text-[30px]">Euer Termin ist gebucht</h2>
					<p class="<?= $bodyText ?> mt-4">Die Buchung wurde verbindlich in unserem System hinterlegt. Bitte achtet auf eure E-Mails für weitere Informationen.</p>
					<div class="mt-6 grid grid-cols-3 gap-3 font-[Arial,Helvetica,sans-serif] max-[620px]:grid-cols-1" data-success-summary></div>
					<div class="mt-7 flex justify-center gap-3 max-[520px]:flex-col">
						<a class="Button_Book" href="./">Neue Reservierung</a>
						<a class="rounded-2xl border border-white/15 bg-black/30 px-5 py-3 text-white/80 hover:border-[#00aaaa] hover:text-[#73ffff]" href="../">Zur Startseite</a>
					</div>
				</section>
			</div>
		</main>

		<script>
			document.addEventListener("DOMContentLoaded", () => {
				const offers = {};
				const defaultOfferId = "<?= $defaultOfferId ?>";
				const servicesLoading = document.querySelector("[data-services-loading]");
				const offerSections = document.querySelector("[data-offer-sections]");
				const createElement = (tag, className, text) => {
					const element = document.createElement(tag);
					element.className = className;
					if (text) {
						element.textContent = text;
					}
					return element;
				};
				const renderOffers = (services, categories) => {
					const groupedServices = new Map();
					services.forEach((service) => {
						offers[service.id] = { title: service.title || "Angebot", description: service.description || "" };
						const category = categories[service.category] ? service.category : "other";
						groupedServices.set(category, [...(groupedServices.get(category) || []), service]);
					});

					offerSections.replaceChildren();
					Object.entries(categories).forEach(([categoryId, category]) => {
						const categoryServices = groupedServices.get(categoryId) || [];
						if (!categoryServices.length) {
							return;
						}
						const section = createElement("section", "w-full max-w-[1180px] mb-8");
						const heading = createElement("div", "mb-4");
						heading.append(createElement("p", "text-sm uppercase tracking-[0.24em] text-[#73ffff]", category.eyebrow));
						heading.append(createElement("h2", "text-[30px] leading-tight max-[775px]:text-[25px]", category.title));
						section.append(heading);
						const grid = createElement("div", "grid grid-cols-2 gap-5 max-[900px]:grid-cols-1");
						categoryServices.forEach((service) => {
							const card = createElement("article", "flex min-h-[250px] flex-col overflow-hidden rounded-[25px] border border-white/10 bg-[var(--ContentBoxBackground)] shadow-[10px_10px_20px_black]");
							card.dataset.offerCard = service.id;
							const header = createElement("div", "flex items-start justify-between gap-4 border-b border-white/10 p-5 max-[520px]:flex-col");
							const titleArea = document.createElement("div");
							const label = service.label || service.duration;
							if (label) {
								titleArea.append(createElement("p", "inline-flex w-fit rounded-full border border-[#00aaaa] px-3 py-1 font-[Arial,Helvetica,sans-serif] text-sm text-white/90", label));
							}
							titleArea.append(createElement("h3", "mt-3 text-[26px] leading-tight max-[775px]:text-[22px]", service.title || "Angebot"));
							header.append(titleArea);
							if (service.price) {
								const price = createElement("p", "whitespace-nowrap text-right text-[30px] leading-none text-[#73ffff] max-[520px]:text-left", service.price);
								if (service.priceNote) {
									price.append(createElement("span", "mt-1 block text-base text-white/80", service.priceNote));
								}
								header.append(price);
							}
							card.append(header);
							const content = createElement("div", "flex flex-1 flex-col justify-between gap-5 p-5");
							if (service.description) {
								const description = createElement("div", "space-y-2 font-[Arial,Helvetica,sans-serif] text-lg leading-7 text-white/90 max-[775px]:text-base");
								description.innerHTML = service.description;
								content.append(description);
							}
							const actions = createElement("div", "mt-auto flex flex-col gap-3");
							if (service.note) {
								actions.append(createElement("p", "w-full rounded-xl border border-[#73ffff]/35 bg-[#73ffff]/10 p-3 font-[Arial,Helvetica,sans-serif] text-sm leading-6 text-white/90", "Hinweis: " + service.note));
							}
							const button = createElement("button", "Button_Book self-start", "Jetzt buchen");
							button.type = "button";
							button.dataset.selectOffer = service.id;
							actions.append(button);
							content.append(actions);
							card.append(content);
							grid.append(card);
						});
						section.append(grid);
						offerSections.append(section);
					});
				};

				fetch("services.php?request=" + Date.now(), { cache: "no-store" })
					.then(async (response) => {
						const responseText = await response.text();
						let data;
						try {
							data = JSON.parse(responseText);
						} catch (error) {
							throw new Error("Service-Antwort ist kein JSON (HTTP " + response.status + "): " + responseText.replace(/<[^>]*>/g, " ").replace(/\s+/g, " ").trim().slice(0, 180));
						}
						console.group(data.debug?.cached ? "SimplyBook services (cached)" : "SimplyBook services");
						console.log("HTTP status:", response.status);
						console.log("Services returned:", data.debug?.serviceCount ?? data.services?.length ?? 0);
						console.table(data.services || []);
						(data.debug?.apiCalls || []).forEach((call) => console.log(call.method, call));
						console.groupEnd();
						if (!response.ok || data.error) {
							throw new Error(data.error || "Angebote konnten nicht aktualisiert werden (HTTP " + response.status + ").");
						}
						const services = data.services || [];
						renderOffers(services, data.categories || {});
						if (!services.length) {
							throw new Error("SimplyBook hat keine buchbaren Angebote zurückgegeben.");
						}
						offerSections.hidden = false;
						offerSections.classList.remove("hidden");
						servicesLoading.remove();
						const requestedOfferId = new URLSearchParams(window.location.search).get("id");
						if (requestedOfferId && offers[requestedOfferId]) {
							selectOffer(requestedOfferId, false);
						}
					})
					.catch((error) => {
						console.error("SimplyBook service loading failed:", error);
						servicesLoading.textContent = "Angebote konnten nicht aktualisiert werden: " + error.message;
						servicesLoading.classList.remove("border-[#00aaaa]/35", "bg-[#00aaaa]/10", "text-[#73ffff]");
						servicesLoading.classList.add("border-red-400/50", "bg-red-950/30", "text-red-100");
					});
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
				steps.forEach((step) => step.classList.add("Booking_Step"));
				tabs.forEach((tab) => {
					if (!tab.querySelector("[data-step-check]")) {
						const check = document.createElement("span");
						check.dataset.stepCheck = "";
						check.className = "mt-3 hidden rounded-full border border-[#73ffff]/60 px-2 py-1 text-xs uppercase tracking-[0.14em] text-[#73ffff]";
						check.textContent = "✓ erledigt";
						tab.appendChild(check);
					}
				});
				let loadAvailability = () => {};
				let updateConfirmationSummary = () => {};
				let updateWizardTabAvailability = () => {};
				let canOpenWizardStep = () => true;
				let currentStep = "offer";
				const initialStep = steps.find((item) => item.dataset.wizardStep === currentStep);
				if (initialStep) {
					initialStep.classList.add("is-visible");
				}
				const goToStep = (step) => {
					currentStep = step;
					updateConfirmationSummary();
					steps.forEach((item) => {
						const isActive = item.dataset.wizardStep === step;
						item.classList.toggle("hidden", !isActive);
						item.classList.toggle("is-visible", false);
						item.classList.toggle("is-entering", isActive);
						if (isActive) {
							requestAnimationFrame(() => {
								item.classList.remove("is-entering");
								item.classList.add("is-visible");
							});
						}
					});
					activateChoice(document.querySelector(`[data-wizard-tab="${step}"]`), tabs);
					updateWizardTabAvailability();
					window.scrollTo({ top: 0, behavior: "smooth" });
				};
				const requestStep = (step) => {
					if (canOpenWizardStep(step)) {
						goToStep(step);
					}
				};

				document.querySelectorAll("[data-go-step]").forEach((button) => button.addEventListener("click", () => requestStep(button.dataset.goStep)));
				tabs.forEach((tab) => tab.addEventListener("click", () => requestStep(tab.dataset.wizardTab)));

				const setOfferUrl = (offerId) => {
					const url = new URL(window.location.href);
					url.searchParams.set("id", offerId);
					window.history.pushState({ offerId }, "", url);
				};

				const selectOffer = (offerId, updateUrl = true) => {
					offerId = offers[offerId] ? offerId : (offers[defaultOfferId] ? defaultOfferId : Object.keys(offers)[0]);
					const offer = offers[offerId];
					if (!offer) {
						return;
					}
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

				offerSections.addEventListener("click", (event) => {
					const button = event.target.closest("[data-select-offer]");
					if (button) {
						selectOffer(button.dataset.selectOffer);
					}
				});

				const monthNames = ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];
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
				const count = document.querySelector("[data-count]");
				const confirmOffer = document.querySelector("[data-confirm-offer]");
				const confirmCount = document.querySelector("[data-confirm-count]");
				const confirmDate = document.querySelector("[data-confirm-date]");
				const confirmTime = document.querySelector("[data-confirm-time]");
				const summaryOffer = document.querySelector("[data-summary-offer]");
				const summaryDate = document.querySelector("[data-summary-date]");
				const summaryTime = document.querySelector("[data-summary-time]");
				const summaryCount = document.querySelector("[data-summary-count]");
				const clientIdInput = document.querySelector("[data-client-id]");
				const confirmClientName = document.querySelector("[data-confirm-client-name]");
				const confirmClientEmail = document.querySelector("[data-confirm-client-email]");
				const confirmClientPhone = document.querySelector("[data-confirm-client-phone]");
				const bookingForm = document.querySelector("[data-booking-form]");
				const bookingSubmit = document.querySelector("[data-booking-submit]");
				const bookingMessage = document.querySelector("[data-booking-message]");
				const bookingSuccess = document.querySelector("[data-booking-success]");
				const successSummary = document.querySelector("[data-success-summary]");
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
				let availabilityRequest = null;
				let availabilityRequestId = 0;
				let countChangeTimer = null;

				const padDatePart = (value) => String(value).padStart(2, "0");
				const toDateValue = (date) => date.getFullYear() + "-" + padDatePart(date.getMonth() + 1) + "-" + padDatePart(date.getDate());
				const toDisplayDate = (date) => dayNames[date.getDay()] + ", " + padDatePart(date.getDate()) + "." + padDatePart(date.getMonth() + 1) + "." + date.getFullYear();
				const formatTimeLabel = (value) => value.slice(0, 5) + " Uhr";
				updateConfirmationSummary = () => {
					const offer = offers[offerIdInput.value] || offers[defaultOfferId];
					confirmOffer.textContent = offer?.title || "Bitte Angebot wählen";
					confirmCount.textContent = count.value;
					confirmDate.textContent = toDisplayDate(selectedDate);
					confirmTime.textContent = selectedTimeInput.value ? formatTimeLabel(selectedTimeInput.value) : "Bitte wählen";
					summaryOffer.textContent = offerIdInput.value && offer ? offer.title : "Bitte wählen";
					summaryDate.textContent = selectedDateInput.value ? toDisplayDate(selectedDate) : "Bitte wählen";
					summaryTime.textContent = selectedTimeInput.value ? formatTimeLabel(selectedTimeInput.value) : "Bitte wählen";
					summaryCount.textContent = count.value;
					updateWizardTabAvailability();
				};
				const wizardStepOrder = ["offer", "schedule", "account", "confirm"];
				canOpenWizardStep = (step) => {
					const targetIndex = wizardStepOrder.indexOf(step);
					const currentIndex = wizardStepOrder.indexOf(currentStep);

					if (targetIndex === -1) {
						return false;
					}

					if (targetIndex <= currentIndex) {
						return true;
					}

					if (step === "schedule") {
						return Boolean(offerIdInput.value);
					}

					if (step === "account") {
						return Boolean(offerIdInput.value && selectedTimeInput.value);
					}

					if (step === "confirm") {
						return Boolean(offerIdInput.value && selectedTimeInput.value && clientIdInput.value);
					}

					return false;
				};
				updateWizardTabAvailability = () => {
					tabs.forEach((tab) => {
						const canOpen = canOpenWizardStep(tab.dataset.wizardTab);
						const isCompleted = wizardStepOrder.indexOf(tab.dataset.wizardTab) < wizardStepOrder.indexOf(currentStep);
						tab.disabled = !canOpen;
						tab.setAttribute("aria-disabled", canOpen ? "false" : "true");
						tab.classList.toggle("cursor-not-allowed", !canOpen);
						tab.classList.toggle("opacity-50", !canOpen);
						tab.classList.toggle("shadow-[0_0_22px_rgba(115,255,255,0.22)]", isCompleted);
						tab.classList.toggle("border-[#73ffff]", isCompleted);
						const check = tab.querySelector("[data-step-check]");
						if (check) {
							check.classList.toggle("hidden", !isCompleted);
						}
					});
				};
				updateWizardTabAvailability();
				const getSelectedTimes = () => availabilityByDate[toDateValue(selectedDate)] || [];
				const getSlotTime = (slot) => typeof slot === "string" ? slot : slot.time;
				const getAvailabilityLabel = (slot) => {
					if (typeof slot === "string" || !slot.count) {
						return "frei";
					}

					return "verfügbar für " + slot.count + " Personen";
				};
				const showTimeMessage = (message, title = "Hinweis", isLoading = false) => {
					timeList.innerHTML = "";
					const card = document.createElement("div");
					card.className = "col-span-full rounded-xl border border-white/10 bg-black/25 p-4 font-[Arial,Helvetica,sans-serif] text-white/80";

					const heading = document.createElement("p");
					heading.className = "flex items-center gap-3 text-sm font-bold uppercase tracking-[0.12em] text-[#73ffff]";

					if (isLoading) {
						const spinner = document.createElement("span");
						spinner.className = "inline-block h-3 w-3 animate-spin rounded-full border-2 border-[#73ffff]/30 border-t-[#73ffff]";
						heading.appendChild(spinner);
					}

					heading.appendChild(document.createTextNode(title));

					const text = document.createElement("p");
					text.className = "mt-2 text-sm leading-6 text-white/65";
					text.textContent = message;

					card.appendChild(heading);
					card.appendChild(text);
					timeList.appendChild(card);

					if (isLoading) {
						for (let i = 0; i < 4; i++) {
							const skeleton = document.createElement("div");
							skeleton.className = "Availability_Skeleton";
							timeList.appendChild(skeleton);
						}
					}
				};

				const selectTime = (slot) => {
					const time = getSlotTime(slot);
					selectedTimeInput.value = time;
					selectedTimeLabel.textContent = time ? formatTimeLabel(time) : "Bitte wählen";
					updateConfirmationSummary();
					renderTimes();
				};

				const renderTimes = () => {
					const times = getSelectedTimes();
					timeList.innerHTML = "";

					if (!offerIdInput.value) {
						availabilityLabel.textContent = "Angebot auswählen";
						showTimeMessage("Wählt zuerst ein Angebot aus, danach prüfen wir die freien Startzeiten.", "Noch kein Angebot");
						return;
					}

					if (isLoadingAvailability) {
						showTimeMessage("Wir fragen gerade die freien Startzeiten für " + toDisplayDate(selectedDate) + " ab.", "Verfügbarkeit wird geprüft", true);
						return;
					}

					if (availabilityError) {
						availabilityLabel.textContent = availabilityError;
						showTimeMessage(availabilityError);
						return;
					}

					availabilityLabel.textContent = times.length === 0 ? "keine Zeiten verfügbar" : times.length + " Zeitfenster verfügbar";

					if (times.length === 0) {
						showTimeMessage("Für diesen Tag sind aktuell keine Startzeiten frei. Wählt bitte ein anderes Datum.", "Keine freien Zeiten");
						return;
					}

					times.forEach((slot) => {
						const time = getSlotTime(slot);
						const isSelected = selectedTimeInput.value === time;
						const button = document.createElement("button");
						button.type = "button";
						button.dataset.time = time;
						button.setAttribute("aria-pressed", isSelected ? "true" : "false");
						button.className = isSelected ? "flex items-center justify-between gap-3 rounded-xl border-2 border-[#00aaaa] bg-[#00aaaa]/20 px-3 py-2 text-left text-[#73ffff] shadow-[0_0_16px_rgba(0,170,170,0.2)]" : "flex items-center justify-between gap-3 rounded-xl border border-white/15 bg-black/30 px-3 py-2 text-left hover:border-[#00aaaa]/70 hover:text-[#73ffff]";
						button.innerHTML = '<span class="text-[18px] leading-none">' + time.slice(0, 5) + '</span><span class="font-[Arial,Helvetica,sans-serif] text-xs ' + (isSelected ? 'text-white/80' : 'text-white/60') + '">' + getAvailabilityLabel(slot) + '</span>';
						button.addEventListener("click", () => selectTime(slot));
						timeList.appendChild(button);
					});
				};

				const updateSelectedDate = (date) => {
					selectedDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());
					selectedDateInput.value = toDateValue(selectedDate);
					document.querySelector("[data-selected-day]").textContent = "am " + dayNames[selectedDate.getDay()];
					selectedDateLabel.textContent = toDisplayDate(selectedDate);
					updateConfirmationSummary();
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
						const dateKey = toDateValue(date);
						const daySlots = availabilityByDate[dateKey] || [];
						const isSelected = toDateValue(date) === toDateValue(selectedDate);
						const isPast = date < today;
						const isDisabled = isPast || isLoadingAvailability || isSelected;
						const button = document.createElement("button");
						button.type = "button";
						button.className = "min-h-[76px] rounded-2xl border p-2 text-center transition max-[560px]:min-h-[58px]";
						const availabilityClass = daySlots.length >= 5 ? " border-[#238636]/70 bg-[#238636]/20 text-[#9dffad]" : daySlots.length > 0 ? " border-[#d8b94a]/70 bg-[#d8b94a]/15 text-[#ffe58a]" : " border-white/10 bg-black/30 text-white/75";
						button.className += isSelected ? " border-[#00aaaa] bg-[#00aaaa]/25 text-[#73ffff] shadow-[0_0_22px_rgba(0,170,170,0.22)] cursor-default" : isDisabled ? " border-white/5 bg-black/20 text-white/30" : availabilityClass + " hover:border-[#00aaaa]/70 hover:text-[#73ffff]";
						button.disabled = isDisabled;
						button.innerHTML = '<span class="block text-[22px] leading-none max-[560px]:text-[18px]">' + day + '</span>';
						if (!isDisabled) {
							button.addEventListener("click", () => {
								updateSelectedDate(date);
								renderCalendar();
								loadAvailability();
							});
						}
						calendarGrid.appendChild(button);
					}
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

					const dateValue = toDateValue(selectedDate);
					const requestId = ++availabilityRequestId;

					if (availabilityRequest) {
						availabilityRequest.abort();
					}

					availabilityRequest = new AbortController();
					isLoadingAvailability = true;
					availabilityError = "";
					selectedTimeInput.value = "";
					selectedTimeLabel.textContent = "Bitte wählen";
					availabilityLabel.textContent = "Prüfe Verfügbarkeit";
					renderCalendar();
					renderTimes();

					try {
						const response = await fetch("availability.php?offer_id=" + encodeURIComponent(offerIdInput.value) + "&date=" + encodeURIComponent(dateValue) + "&count=" + encodeURIComponent(count.value), { signal: availabilityRequest.signal });
						const responseText = await response.text();
						let data = {};

						if (requestId !== availabilityRequestId) {
							return;
						}

						try {
							data = JSON.parse(responseText);
						} catch (parseError) {
							const plainResponse = responseText.replace(/<[^>]*>/g, " ").replace(/\s+/g, " ").trim();
							throw new Error(plainResponse ? plainResponse.slice(0, 180) : "Zeiten konnten nicht geladen werden. Serverantwort war kein JSON.");
						}

						if (!response.ok || data.error) {
							throw new Error(data.error || "Zeiten konnten nicht geladen werden.");
						}

						if (data.apiCalls) {
							console.group(data.cached ? "SimplyBook API results (cached)" : "SimplyBook API results");
							data.apiCalls.forEach((call) => console.log(call.method, call));
							console.groupEnd();
						}

						availabilityByDate = data.dates || {};
						const times = getSelectedTimes();
						selectedTimeInput.value = times[0] ? getSlotTime(times[0]) : "";
						selectedTimeLabel.textContent = selectedTimeInput.value ? formatTimeLabel(selectedTimeInput.value) : "Bitte wählen";
					} catch (error) {
						if (error.name === "AbortError") {
							return;
						}

						if (requestId !== availabilityRequestId) {
							return;
						}

						availabilityByDate = {};
						availabilityError = error.message;
					} finally {
						if (requestId !== availabilityRequestId) {
							return;
						}

						isLoadingAvailability = false;
						availabilityRequest = null;
						updateSelectedDate(selectedDate);
						renderCalendar();
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
				loadAvailability();

				const updateCount = (value) => {
					const nextValue = Math.max(1, value);

					if (Number(count.value) === nextValue) {
						return;
					}

					count.value = nextValue;
					updateConfirmationSummary();

					if (offerIdInput.value) {
						clearTimeout(countChangeTimer);
						countChangeTimer = setTimeout(loadAvailability, 450);
					}
				};
				document.querySelector("[data-count-down]").addEventListener("click", () => updateCount(Number(count.value) - 1));
				document.querySelector("[data-count-up]").addEventListener("click", () => updateCount(Number(count.value) + 1));

				const accountTabs = Array.from(document.querySelectorAll("[data-account-tab]"));
				const accountPanels = Array.from(document.querySelectorAll("[data-account-panel]"));
				accountTabs.forEach((tab) => {
					tab.addEventListener("click", () => {
						accountTabs.forEach((item) => {
							item.setAttribute("aria-pressed", "false");
							item.classList.remove("border-[#00aaaa]", "bg-[#00aaaa]/20", "text-[#73ffff]", "shadow-[0_0_22px_rgba(0,170,170,0.22)]");
							item.classList.add("border-white/15", "bg-black/25", "text-white/70");
						});
						tab.setAttribute("aria-pressed", "true");
						tab.classList.remove("border-white/15", "bg-black/25", "text-white/70");
						tab.classList.add("border-[#00aaaa]", "bg-[#00aaaa]/20", "text-[#73ffff]", "shadow-[0_0_22px_rgba(0,170,170,0.22)]");

						accountPanels.forEach((panel) => {
							const isActive = panel.dataset.accountPanel === tab.dataset.accountTab;
							panel.classList.toggle("hidden", !isActive);
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

				const loginEmail = document.querySelector("[data-login-email]");
				const loginPassword = document.querySelector("[data-login-password]");
				const loginSubmit = document.querySelector("[data-login-submit]");
				const loginMessage = document.querySelector("[data-login-message]");
				const loginForm = document.querySelector("[data-login-form]");
				const loggedInPanel = document.querySelector("[data-logged-in-panel]");
				const clientName = document.querySelector("[data-client-name]");
				const clientEmail = document.querySelector("[data-client-email]");
				const clientPhone = document.querySelector("[data-client-phone]");
				const loginLogout = document.querySelector("[data-login-logout]");
				const registerName = document.querySelector("[data-register-name]");
				const registerPhone = document.querySelector("[data-register-phone]");
				const registerEmail = document.querySelector("[data-register-email]");
				const registerPassword = document.querySelector("[data-register-password]");
				const registerPasswordConfirm = document.querySelector("[data-register-password-confirm]");
				const registerSubmit = document.querySelector("[data-register-submit]");
				const registerMessage = document.querySelector("[data-register-message]");
				let currentClient = null;

				const showLoginMessage = (message, isError = false) => {
					loginMessage.textContent = message;
					loginMessage.classList.remove("hidden", "border-red-400/40", "bg-red-950/30", "text-red-100", "border-[#00aaaa]/40", "bg-[#00aaaa]/10", "text-[#73ffff]");
					loginMessage.classList.add(isError ? "border-red-400/40" : "border-[#00aaaa]/40", isError ? "bg-red-950/30" : "bg-[#00aaaa]/10", isError ? "text-red-100" : "text-[#73ffff]");
				};

				const showRegisterMessage = (message, isError = false) => {
					registerMessage.textContent = message;
					registerMessage.classList.remove("hidden", "border-red-400/40", "bg-red-950/30", "text-red-100", "border-[#00aaaa]/40", "bg-[#00aaaa]/10", "text-[#73ffff]");
					registerMessage.classList.add(isError ? "border-red-400/40" : "border-[#00aaaa]/40", isError ? "bg-red-950/30" : "bg-[#00aaaa]/10", isError ? "text-red-100" : "text-[#73ffff]");
				};

				const showBookingMessage = (message, isError = false) => {
					bookingMessage.querySelector("p").textContent = message;
					bookingMessage.classList.remove("hidden", "border-red-400/40", "bg-red-950/30", "text-red-100", "border-[#00aaaa]", "bg-[#00aaaa]/20", "text-[#73ffff]", "shadow-[0_0_30px_rgba(0,170,170,0.35)]");
					bookingMessage.classList.add(isError ? "border-red-400/40" : "border-[#00aaaa]", isError ? "bg-red-950/30" : "bg-[#00aaaa]/20", isError ? "text-red-100" : "text-[#73ffff]");

						if (!isError) {
							bookingMessage.classList.add("shadow-[0_0_30px_rgba(0,170,170,0.35)]");
						}
					};

				const setLoggedInClient = (client) => {
					currentClient = client;
					clientIdInput.value = client.id || "";
					clientName.textContent = client.name || client.email || "Kundenkonto";
					clientEmail.textContent = client.email || "";
					clientPhone.textContent = client.phone ? "Telefon: " + client.phone : "";
					clientPhone.classList.toggle("hidden", !client.phone);
					confirmClientName.textContent = client.name || client.email || "Kundenkonto";
					confirmClientEmail.textContent = client.email || "";
					confirmClientPhone.textContent = client.phone ? "Telefon: " + client.phone : "";
					confirmClientPhone.classList.toggle("hidden", !client.phone);
					loginForm.classList.add("hidden");
					loggedInPanel.classList.remove("hidden");
					updateWizardTabAvailability();
				};

				const resetLoggedInClient = () => {
					currentClient = null;
					clientIdInput.value = "";
					loginPassword.value = "";
					confirmClientName.textContent = "Nicht eingeloggt";
					confirmClientEmail.textContent = "Bitte in Schritt 3 einloggen.";
					confirmClientPhone.textContent = "";
					confirmClientPhone.classList.add("hidden");
					loginMessage.classList.add("hidden");
					loggedInPanel.classList.add("hidden");
					loginForm.classList.remove("hidden");
					updateWizardTabAvailability();
				};

				const readJsonResponse = async (response) => {
					const responseText = await response.text();

					try {
						return JSON.parse(responseText);
					} catch (error) {
						const plainResponse = responseText.replace(/<[^>]*>/g, " ").replace(/\s+/g, " ").trim();
						throw new Error(plainResponse ? plainResponse.slice(0, 180) : "Serverantwort war kein JSON.");
					}
				};

				const showSuccessScreen = () => {
					const offer = offers[offerIdInput.value] || offers[defaultOfferId];
					const items = [
						["Angebot", offer.title],
						["Datum", toDisplayDate(selectedDate)],
						["Start", formatTimeLabel(selectedTimeInput.value)],
					];

					successSummary.innerHTML = "";
					items.forEach(([label, value]) => {
						const item = document.createElement("div");
						item.className = "rounded-2xl border border-white/10 bg-black/30 p-4";
						item.innerHTML = '<p class="text-xs uppercase tracking-[0.14em] text-white/55">' + label + '</p><p class="mt-2 text-lg text-[#73ffff]">' + value + '</p>';
						successSummary.appendChild(item);
					});

					bookingSuccess.classList.remove("hidden");
					bookingSuccess.classList.add("flex");
				};

				const submitRegister = async () => {
					const name = registerName.value.trim();
					const phone = registerPhone.value.trim();
					const email = registerEmail.value.trim();
					const password = registerPassword.value;
					const passwordConfirm = registerPasswordConfirm.value;

					if (!name || !email || password.length < 6) {
						showRegisterMessage("Bitte Name, E-Mail und ein Passwort mit mindestens 6 Zeichen eingeben.", true);
						return;
					}

					if (password !== passwordConfirm) {
						showRegisterMessage("Die Passwörter stimmen nicht überein.", true);
						return;
					}

					registerSubmit.disabled = true;
					registerSubmit.textContent = "Konto wird erstellt...";
					showRegisterMessage("Wir legen euer Kundenkonto bei SimplyBook an.");

					try {
						const formData = new FormData();
						formData.append("name", name);
						formData.append("phone", phone);
						formData.append("email", email);
						formData.append("password", password);

						const response = await fetch("register.php", { method: "POST", body: formData });
						const data = await readJsonResponse(response);

						if (!response.ok || data.error) {
							throw new Error((data.error || "Registrierung fehlgeschlagen.") + (data.request_id ? " (Request: " + data.request_id + ")" : ""));
						}

						setLoggedInClient(data.client || {});
						registerPassword.value = "";
						registerPasswordConfirm.value = "";
						accountTabs.find((tab) => tab.dataset.accountTab === "login").click();
					} catch (error) {
						showRegisterMessage(error.message || "Registrierung fehlgeschlagen.", true);
					} finally {
						registerSubmit.disabled = false;
						registerSubmit.textContent = "Konto erstellen";
					}
				};

				const submitLogin = async () => {
					const email = loginEmail.value.trim();
					const password = loginPassword.value;

					if (!email || !password) {
						showLoginMessage("Bitte E-Mail und Passwort eingeben.", true);
						return;
					}

					loginSubmit.disabled = true;
					loginSubmit.textContent = "Login wird geprüft...";
					showLoginMessage("Wir prüfen eure Zugangsdaten bei SimplyBook.");

					try {
						const formData = new FormData();
						formData.append("email", email);
						formData.append("password", password);

						const response = await fetch("login.php", { method: "POST", body: formData });
						const data = await readJsonResponse(response);

						if (!response.ok || data.error) {
							throw new Error(data.error || "Login fehlgeschlagen.");
						}

						setLoggedInClient(data.client || {});
					} catch (error) {
						clientIdInput.value = "";
						showLoginMessage(error.message || "Login fehlgeschlagen.", true);
					} finally {
						loginSubmit.disabled = false;
						loginSubmit.textContent = "Einloggen";
					}
				};

				const submitBooking = async (event) => {
					event.preventDefault();

					if (!offerIdInput.value || !selectedDateInput.value || !selectedTimeInput.value) {
						showBookingMessage("Bitte zuerst Angebot, Datum und Startzeit auswählen.", true);
						goToStep("schedule");
						return;
					}

					if (!currentClient || !clientIdInput.value) {
						showBookingMessage("Bitte vor der Buchung einloggen oder ein Konto erstellen.", true);
						goToStep("account");
						return;
					}

					bookingSubmit.disabled = true;
					bookingSubmit.textContent = "Buchung wird gesendet...";
					showBookingMessage("Wir senden eure Buchung jetzt an SimplyBook.");

					try {
						const formData = new FormData(bookingForm);
						formData.append("client_name", currentClient.name || currentClient.email || "Kundenkonto");
						formData.append("client_email", currentClient.email || "");
						formData.append("client_phone", currentClient.phone || "");

						const response = await fetch("book.php", { method: "POST", body: formData });
						const data = await readJsonResponse(response);

						if (!response.ok || data.error) {
							throw new Error(data.error || "Buchung fehlgeschlagen.");
						}

						showSuccessScreen();
						bookingSubmit.textContent = "Buchung bestätigt";
					} catch (error) {
						showBookingMessage(error.message || "Buchung fehlgeschlagen.", true);
						bookingSubmit.disabled = false;
						bookingSubmit.textContent = "Buchung bestätigen";
					}
				};

				bookingForm.addEventListener("submit", submitBooking);
				loginSubmit.addEventListener("click", submitLogin);
				loginLogout.addEventListener("click", resetLoggedInClient);
				registerSubmit.addEventListener("click", submitRegister);
				loginPassword.addEventListener("keydown", (event) => {
					if (event.key === "Enter") {
						event.preventDefault();
						submitLogin();
					}
				});
			});
		</script>

		<?php include '../resources/footer.php'; ?>
	</body>
</html>
