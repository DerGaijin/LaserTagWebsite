<!DOCTYPE html>
<?php
$section = 'w-full max-w-[1180px]';
$panel = 'rounded-[28px] border border-white/10 bg-[var(--ContentBoxBackground)] shadow-[10px_10px_20px_black]';
$eyebrow = 'text-sm uppercase tracking-[0.24em] text-[#73ffff]';
$headline = 'mt-2 text-[42px] uppercase leading-tight max-[775px]:text-[32px]';
$bodyText = 'font-[Arial,Helvetica,sans-serif] text-lg leading-7 text-white/90 max-[775px]:text-base';
$card = $panel . ' p-6 max-[775px]:p-4';
$gameLink = 'mt-5 inline-flex rounded-md border border-[#73ffff]/60 px-4 py-2 font-[Arial,Helvetica,sans-serif] text-sm uppercase tracking-[0.14em] text-[#73ffff] no-underline transition hover:bg-[#73ffff]/10';
$list = 'space-y-3 font-[Arial,Helvetica,sans-serif] text-lg leading-7 text-white/90 max-[775px]:text-base';
$minimumAge = 'ab 6 Jahren';
$ageNote = 'mt-2 font-[Arial,Helvetica,sans-serif] text-sm text-white/60';
?>
<html lang="de">

<head>
    <?php require '../resources/head.php'; ?>
</head>

<body>
    <?php $currentPage = 'infos';
    include '../resources/header.php'; ?>

    <main class="flex flex-col items-center gap-8 px-[100px] py-[25px] max-[1260px]:px-[15px] max-[775px]:px-[5px]">

        <section class="<?= $section ?> <?= $panel ?> p-6 max-[775px]:p-4">
            <p class="<?= $eyebrow ?>">Die Arena</p>
            <h1 class="<?= $headline ?>">Große Indoor-Arena mit viel Platz für Action</h1>
            <div class="mt-5 grid grid-cols-3 gap-4 max-[900px]:grid-cols-1">
                <div class="rounded-2xl bg-black/25 p-4 text-center">
                    <p class="text-[30px] text-[#73ffff]">400 m²</p>
                    <p class="<?= $bodyText ?> mt-2">Arenafläche</p>
                </div>
                <div class="rounded-2xl bg-black/25 p-4 text-center">
                    <p class="text-[30px] text-[#73ffff]">Laserforce</p>
                    <p class="<?= $bodyText ?> mt-2">Gen8 Ausrüstung</p>
                </div>
                <div class="rounded-2xl bg-black/25 p-4 text-center">
                    <p class="text-[30px] text-[#73ffff]">12 Minuten</p>
                    <p class="<?= $bodyText ?> mt-2">pro Runde</p>
                </div>
            </div>
            <p class="<?= $bodyText ?> mt-5">
                Unsere Arena ist dunkel, atmosphärisch und auf Bewegung, Deckung und Teamplay ausgelegt. Zwischen
                Hindernissen, Lichteffekten und Musik entsteht jede Runde ein eigenes Spielgefühl.
            </p>
        </section>

		<section class="<?= $section ?> flex flex-col gap-5">
			<article class="<?= $card ?>">
				<p class="<?= $eyebrow ?>">Ablauf</p>
				<h2 class="mt-2 text-[32px] leading-tight">So läuft euer Besuch ab</h2>
				<div class="mt-6 grid gap-0 font-[Arial,Helvetica,sans-serif] text-white/90">
					<?php foreach ([
						['Ankommen', 'Meldet euch vor Ort an und plant etwas Zeit vor der ersten Runde ein.'],
						['Einweisung', 'Wir erklären euch Ausrüstung, Regeln und Sicherheit in der Arena.'],
						['Spielen', 'Eine Runde dauert 12 Minuten. Zwischen den Runden könnt ihr kurz durchatmen und eure Punkte ansehen.'],
						['Wiederholen', 'Je nach Paket spielt ihr mehrere Runden oder nutzt eure gebuchte Zeit flexibel aus.'],
					] as $index => $step): ?>
						<div class="grid grid-cols-[54px_1fr] gap-4 <?= $index < 3 ? 'pb-5' : '' ?>">
							<div class="relative flex justify-center">
								<?php if ($index < 3): ?><span class="absolute top-11 h-full w-px bg-[#00aaaa]/45"></span><?php endif; ?>
								<span class="Timeline_Marker relative z-[1] flex h-11 w-11 items-center justify-center rounded-full border-2 border-[#73ffff] bg-[#00aaaa]/20 text-[#73ffff]"><?= $index + 1 ?></span>
							</div>
							<div class="rounded-2xl border border-white/10 bg-black/25 p-4">
								<p class="text-[22px] font-bold text-[#73ffff]"><?= htmlspecialchars($step[0]) ?></p>
								<p class="mt-2 text-lg leading-7 max-[775px]:text-base"><?= htmlspecialchars($step[1]) ?></p>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</article>
		</section>

        <section class="<?= $section ?> flex flex-col gap-5">
			<div>
				<p class="<?= $eyebrow ?>">Laserforce Spielmodi</p>
				<h2 class="mt-2 text-[34px] leading-tight max-[775px]:text-[28px]">Unsere Spiele kurz erklärt</h2>
				<p class="<?= $bodyText ?> mt-3 max-w-[900px]">
					Bei uns spielt ihr nicht nur eine Variante. Je nach Gruppe, Erfahrung und Stimmung entscheidet ihr,
					welchen Modus ihr spielen möchtet. Die Regeln erklären wir euch vor jeder Runde direkt vor Ort.
				</p>
				<nav class="mt-5 flex flex-wrap gap-2" aria-label="Spielmodi direkt anwählen">
					<?php foreach ([
						['#spiel-color-conquest', 'Color Conquest'],
						['#spiel-laserball', 'Laserball'],
						['#spiel-tag', 'Tag'],
						['#spiel-challange-royal', 'Challange Royal'],
						['#spiel-shadows', 'Shadows'],
						['#spiel-standard', 'Standard'],
					] as $mode): ?>
						<a class="rounded-full border border-[#73ffff]/45 bg-black/30 px-4 py-2 font-[Arial,Helvetica,sans-serif] text-sm text-[#73ffff] no-underline transition hover:bg-[#73ffff]/10" href="<?= $mode[0] ?>"><?= htmlspecialchars($mode[1]) ?></a>
					<?php endforeach; ?>
				</nav>
			</div>

            <div class="grid grid-cols-2 gap-5 max-[900px]:grid-cols-1">
                <article id="spiel-color-conquest" class="<?= $card ?> scroll-mt-32">
                    <img src="../resources/PrimeTimeIcon.webp" alt="Color Conquest Spielmodus"
                        class="mb-5 h-44 w-full rounded-2xl bg-black/25 object-contain p-4" />
                    <p class="<?= $eyebrow ?>">Gebiete sichern</p>
                    <h3 class="mt-2 text-[30px] leading-tight">Color Conquest</h3>
                    <p class="<?= $ageNote ?>">Mindestalter: <?= $minimumAge ?></p>
                    <p class="<?= $bodyText ?> mt-4">Teams kämpfen um farbige Zonen und versuchen, möglichst viel
                        Kontrolle in der Arena zu halten. Wer nur Treffer sammelt, lässt wichtige Punkte liegen.</p>
                    <a class="<?= $gameLink ?>" href="https://www.iplaylaserforce.com/games/colour-conquest/"
                        target="_blank" rel="noopener noreferrer">Offizielle Beschreibung</a>
                </article>

                <article id="spiel-laserball" class="<?= $card ?> scroll-mt-32">
                    <img src="../resources/LargeIcon.webp" alt="Laserball Spielmodus"
                        class="mb-5 h-44 w-full rounded-2xl bg-black/25 object-contain p-4" />
                    <p class="<?= $eyebrow ?>">Teamziel</p>
                    <h3 class="mt-2 text-[30px] leading-tight">Laserball</h3>
                    <p class="<?= $ageNote ?>">Mindestalter: <?= $minimumAge ?></p>
                    <p class="<?= $bodyText ?> mt-4">Hier zählt Zusammenspiel: Sichert euch den Ball, bringt ihn in die
                        richtige Position und schützt eure Mitspieler gegen das gegnerische Team.</p>
                    <a class="<?= $gameLink ?>" href="https://www.iplaylaserforce.com/games/laserball/"
                        target="_blank" rel="noopener noreferrer">Offizielle Beschreibung</a>
                </article>

                <article id="spiel-tag" class="<?= $card ?> scroll-mt-32">
                    <img src="../resources/LaserForceBlasters.webp" alt="Tag Spielmodus"
                        class="mb-5 h-44 w-full rounded-2xl bg-black/25 object-contain p-4" />
                    <p class="<?= $eyebrow ?>">Schnelle Duelle</p>
                    <h3 class="mt-2 text-[30px] leading-tight">Tag</h3>
                    <p class="<?= $ageNote ?>">Mindestalter: <?= $minimumAge ?></p>
                    <p class="<?= $bodyText ?> mt-4">Der direkte Lasertag-Modus: Bewegen, zielen, treffen und wieder in
                        Deckung. Ideal zum Reinkommen und für schnelle, intensive Runden.</p>
                    <a class="<?= $gameLink ?>" href="https://www.iplaylaserforce.com/games/tag/" target="_blank"
                        rel="noopener noreferrer">Offizielle Beschreibung</a>
                </article>

                <article id="spiel-challange-royal" class="<?= $card ?> scroll-mt-32">
                    <img src="../resources/Stud.png" alt="Challange Royal Spielmodus"
                        class="mb-5 h-44 w-full rounded-2xl bg-black/25 object-contain p-4" />
                    <p class="<?= $eyebrow ?>">Alle gegen alle</p>
                    <h3 class="mt-2 text-[30px] leading-tight">Challange Royal</h3>
                    <p class="<?= $ageNote ?>">Mindestalter: <?= $minimumAge ?></p>
                    <p class="<?= $bodyText ?> mt-4">Ein intensiver Wettkampfmodus, in dem jede Entscheidung zählt. Wer
                        clever spielt, die Arena nutzt und ruhig bleibt, hat am Ende die besten Chancen.</p>
                    <a class="<?= $gameLink ?>" href="https://www.iplaylaserforce.com/games/individual/"
                        target="_blank" rel="noopener noreferrer">Offizielle Beschreibung</a>
                </article>

                <article id="spiel-shadows" class="<?= $card ?> scroll-mt-32">
                    <img src="../resources/NightSpecialIcon.webp" alt="Shadows Spielmodus"
                        class="mb-5 h-44 w-full rounded-2xl bg-black/25 object-contain p-4" />
                    <p class="<?= $eyebrow ?>">Tarnung</p>
                    <h3 class="mt-2 text-[30px] leading-tight">Shadows</h3>
                    <p class="<?= $ageNote ?>">Mindestalter: ab 14 Jahren</p>
                    <p class="<?= $bodyText ?> mt-4">In diesem Modus wird es taktischer: Spieler sind schwerer zu
                        erkennen und müssen mehr auf Geräusche, Bewegung und Positionen achten.</p>
                    <a class="<?= $gameLink ?>" href="https://www.iplaylaserforce.com/games/shadows/" target="_blank"
                        rel="noopener noreferrer">Offizielle Beschreibung</a>
                </article>

                <article id="spiel-standard" class="<?= $card ?> scroll-mt-32">
                    <img src="../resources/LaserForceGen8.webp" alt="Standard Spielmodus"
                        class="mb-5 h-44 w-full rounded-2xl bg-black/25 object-contain p-4" />
                    <p class="<?= $eyebrow ?>">Klassiker</p>
                    <h3 class="mt-2 text-[30px] leading-tight">Standard</h3>
                    <p class="<?= $ageNote ?>">Mindestalter: <?= $minimumAge ?></p>
                    <p class="<?= $bodyText ?> mt-4">Der klassische Modus für neue und erfahrene Spieler. Ziel ist es,
                        Treffer zu landen, Punkte zu sammeln und als Team oder solo oben zu stehen.</p>
                    <a class="<?= $gameLink ?>" href="https://www.iplaylaserforce.com/type/standard/" target="_blank"
                        rel="noopener noreferrer">Offizielle Beschreibung</a>
                </article>
            </div>
        </section>

        <section class="<?= $section ?> flex flex-col gap-5">
            <article class="<?= $card ?>">
                <p class="<?= $eyebrow ?>">Wichtig</p>
                <h2 class="mt-2 text-[32px] leading-tight">Jugendschutz und Begleitung</h2>
                <div class="<?= $list ?> mt-5">
                    <p>Für minderjährige Gäste gelten besondere Regeln, wenn sie ohne erziehungsberechtigte Person zu
                        uns kommen.</p>
                    <p>Bitte bringt bei Bedarf den ausgefüllten Muttizettel mit. Das Formular findet ihr direkt auf
                        unserer Website.</p>
                    <p><b>Wichtig:</b> Minderjährige benötigen einen vollständig ausgefüllten und unterschriebenen
                        Muttizettel sowie die darauf eingetragene Begleitperson vor Ort. Ohne Muttizettel oder ohne
                        eingetragene Begleitperson ist keine Teilnahme erlaubt.</p>
                    <p>Bei Geburtstagen, Schulklassen oder größeren Jugendgruppen empfehlen wir, die Rahmenbedingungen
                        vor der Buchung kurz mit uns abzustimmen.</p>
                </div>
                <div class="mt-6 flex flex-wrap gap-3 text-xl">
                    <a class="Button_Book" href="../muttizettel/">Zum Muttizettel</a>
                    <a class="rounded-md border border-white/35 bg-white/10 px-5 py-2 text-white no-underline transition hover:bg-white/20"
                        href="../kontakt/">Kontakt aufnehmen</a>
                </div>
            </article>
        </section>

        <section class="<?= $section ?> <?= $panel ?> p-6 max-[775px]:p-4">
            <div class="grid items-center gap-5 lg:grid-cols-[1fr_auto]">
                <div>
                    <p class="<?= $eyebrow ?>">Noch Fragen?</p>
                    <h2 class="mt-2 text-[30px] leading-tight">Wir helfen euch bei Planung, Buchung und Gruppengröße.
                    </h2>
                    <p class="<?= $bodyText ?> mt-3">Wenn ihr unsicher seid, welches Paket passt oder welche Regeln für
                        eure Gruppe gelten, meldet euch einfach vor der Reservierung.</p>
                </div>
                <a class="Button_Book justify-self-start px-7 py-3" href="../preise/">Preise ansehen</a>
            </div>
        </section>
    </main>

    <?php include '../resources/footer.php'; ?>
</body>

</html>
