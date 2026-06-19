<!DOCTYPE html>
<?php
$section = 'w-full max-w-[1180px]';
$panel = 'rounded-[28px] border border-white/10 bg-[var(--ContentBoxBackground)] shadow-[10px_10px_20px_black]';
$eyebrow = 'text-sm uppercase tracking-[0.24em] text-[#73ffff]';
$headline = 'mt-2 text-[42px] uppercase leading-tight max-[775px]:text-[32px]';
$bodyText = 'font-[Arial,Helvetica,sans-serif] text-lg leading-7 text-white/90 max-[775px]:text-base';
$card = $panel . ' p-6 max-[775px]:p-4';
$list = 'space-y-3 font-[Arial,Helvetica,sans-serif] text-lg leading-7 text-white/90 max-[775px]:text-base';
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
                <div class="<?= $list ?> mt-5">
                    <p><b>1. Ankommen:</b> Meldet euch vor Ort an und plant etwas Zeit vor der ersten Runde ein.</p>
                    <p><b>2. Einweisung:</b> Wir erklären euch Ausrüstung, Regeln und Sicherheit in der Arena.</p>
                    <p><b>3. Spielen:</b> Eine Runde dauert 12 Minuten. Zwischen den Runden könnt ihr kurz durchatmen
                        und eure Punkte ansehen.</p>
                    <p><b>4. Wiederholen:</b> Je nach Paket spielt ihr mehrere Runden oder nutzt eure gebuchte Zeit
                        flexibel aus.</p>
                </div>
            </article>
        </section>

        <section class="<?= $section ?> flex flex-col gap-5">
            <div>
                <p class="<?= $eyebrow ?>">Laserforce Spielmodi</p>
                <h2 class="mt-2 text-[34px] leading-tight max-[775px]:text-[28px]">Unsere Spiele kurz erklärt</h2>
                <p class="<?= $bodyText ?> mt-3 max-w-[900px]">
                    Laserforce bietet viele unterschiedliche Spielvarianten. Welche Modi wir in eurer Runde spielen,
                    hängt von Gruppe, Erfahrung und Buchung ab. Vor dem Start erklären wir euch die Regeln direkt vor
                    Ort.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-5 max-[900px]:grid-cols-1">
                <article id="spiel-standard" class="<?= $card ?> scroll-mt-32">
                    <img src="../resources/LaserForceBlasters.webp" alt="Laserforce Blaster"
                        class="mb-5 h-44 w-full rounded-2xl bg-black/25 object-contain p-4" />
                    <p class="<?= $eyebrow ?>">Klassiker</p>
                    <h3 class="mt-2 text-[30px] leading-tight">Standard Solo</h3>
                    <p class="<?= $bodyText ?> mt-4">Jeder spielt für sich. Ziel ist es, möglichst viele Treffer zu
                        landen und am Ende die höchste Punktzahl zu erreichen.</p>
                    <a class="Button_Book mt-5 inline-block" href="../resources/anleitungen/standard-solo.pdf"
                        download>Anleitung downloaden</a>
                </article>

                <article id="spiel-team" class="<?= $card ?> scroll-mt-32">
                    <img src="../resources/LaserForceGen8.webp" alt="Laserforce Gen8 Ausrüstung"
                        class="mb-5 h-44 w-full rounded-2xl bg-black/25 object-contain p-4" />
                    <p class="<?= $eyebrow ?>">Teamplay</p>
                    <h3 class="mt-2 text-[30px] leading-tight">Teamspiel</h3>
                    <p class="<?= $bodyText ?> mt-4">Mehrere Teams treten gegeneinander an. Kommunikation, Deckung und
                        gemeinsame Angriffe bringen hier mehr als reines Draufhalten.</p>
                    <a class="Button_Book mt-5 inline-block" href="../resources/anleitungen/teamspiel.pdf"
                        download>Anleitung downloaden</a>
                </article>

                <article id="spiel-highlander" class="<?= $card ?> scroll-mt-32">
                    <img src="../resources/LargeIcon.webp" alt="Highlander Spielmodus"
                        class="mb-5 h-44 w-full rounded-2xl bg-black/25 object-contain p-4" />
                    <p class="<?= $eyebrow ?>">Power-Spieler</p>
                    <h3 class="mt-2 text-[30px] leading-tight">Highlander</h3>
                    <p class="<?= $bodyText ?> mt-4">Ein starker Spieler tritt gegen den Rest an. Der Highlander hält
                        mehr aus und ist schwerer zu stoppen, muss aber gegen viele Gegner bestehen.</p>
                    <a class="Button_Book mt-5 inline-block" href="../resources/anleitungen/highlander.pdf"
                        download>Anleitung downloaden</a>
                </article>

                <article id="spiel-shadows" class="<?= $card ?> scroll-mt-32">
                    <img src="../resources/NightSpecialIcon.webp" alt="Shadows Spielmodus"
                        class="mb-5 h-44 w-full rounded-2xl bg-black/25 object-contain p-4" />
                    <p class="<?= $eyebrow ?>">Tarnung</p>
                    <h3 class="mt-2 text-[30px] leading-tight">Shadows</h3>
                    <p class="<?= $bodyText ?> mt-4">In diesem Modus wird es taktischer: Spieler sind schwerer zu
                        erkennen und müssen mehr auf Geräusche, Bewegung und Positionen achten.</p>
                    <a class="Button_Book mt-5 inline-block" href="../resources/anleitungen/shadows.pdf"
                        download>Anleitung downloaden</a>
                </article>

                <article id="spiel-zombies" class="<?= $card ?> scroll-mt-32">
                    <img src="../resources/Stud.png" alt="Zombies Spielmodus"
                        class="mb-5 h-44 w-full rounded-2xl bg-black/25 object-contain p-4" />
                    <p class="<?= $eyebrow ?>">Überleben</p>
                    <h3 class="mt-2 text-[30px] leading-tight">Zombies</h3>
                    <p class="<?= $bodyText ?> mt-4">Eine Gruppe versucht zu überleben, während Zombies immer mehr
                        Spieler auf ihre Seite ziehen. Das Spiel kippt oft kurz vor Schluss.</p>
                    <a class="Button_Book mt-5 inline-block" href="../resources/anleitungen/zombies.pdf"
                        download>Anleitung downloaden</a>
                </article>

                <article id="spiel-bases" class="<?= $card ?> scroll-mt-32">
                    <img src="../resources/PrimeTimeIcon.webp" alt="Bases Spielmodus"
                        class="mb-5 h-44 w-full rounded-2xl bg-black/25 object-contain p-4" />
                    <p class="<?= $eyebrow ?>">Ziele</p>
                    <h3 class="mt-2 text-[30px] leading-tight">Bases</h3>
                    <p class="<?= $bodyText ?> mt-4">Zusätzlich zu Treffern auf Spieler werden Basen oder Ziele in der
                        Arena wichtig. Wer nur Gegner jagt, lässt Punkte liegen.</p>
                    <a class="Button_Book mt-5 inline-block" href="../resources/anleitungen/bases.pdf"
                        download>Anleitung downloaden</a>
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
                    <p>Bei Geburtstagen, Schulklassen oder größeren Jugendgruppen empfehlen wir, die Rahmenbedingungen
                        vor der Buchung kurz mit uns abzustimmen.</p>
                    <p>Vor Ort achten wir auf eine klare Einweisung, faires Spiel und einen sicheren Ablauf in der
                        Arena.</p>
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