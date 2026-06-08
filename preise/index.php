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
?>
<html lang="de">
    <head>
        <?php require __DIR__ . '/../resources/head.php'; ?>
    </head>
    <body>
        <?php $currentPage = 'preise'; include __DIR__ . '/../Resources/header.php'; ?>

        <main class="flex flex-col items-center gap-8 px-[100px] py-[25px] max-[1260px]:px-[15px] max-[775px]:px-[5px]">
            <section class="<?= $section ?> <?= $panel ?> px-8 py-7 text-center max-[775px]:px-4">
                <p class="<?= $eyebrow ?>">Preise & Pakete</p>
                <h1 class="<?= $headline ?>">Lasertag für kurze Matches, lange Abende und Geburtstagsrunden</h1>
                <p class="<?= $bodyText ?> mt-4">
                    Wählt die passende Spielzeit und reserviert euren Termin direkt online. Für Geburtstage gilt eine Mindestgruppe von 6 Personen.
                </p>
            </section>

            <section class="<?= $section ?>">
                <div class="mb-4 flex items-end justify-between gap-4 max-[775px]:flex-col max-[775px]:items-start">
                    <div>
                        <p class="<?= $eyebrow ?>">Spielzeit</p>
                        <h2 class="text-[30px] leading-tight max-[775px]:text-[25px]">Standardbuchungen</h2>
                    </div>
                    <a href="/reservieren/#/category/3/" class="Button_Book">Termin wählen</a>
                </div>
                <div class="grid grid-cols-2 gap-5 max-[700px]:grid-cols-1">
                    <article class="<?= $panel ?> border border-white/10 p-6 text-center">
                        <h3 class="text-[26px]">1 Stunde</h3>
                        <p class="mt-4 text-[34px] text-[#73ffff]">18,50 €</p>
                        <p class="<?= $bodyText ?> mt-2">pro Person</p>
                    </article>
                    <article class="<?= $panel ?> border border-white/10 p-6 text-center">
                        <h3 class="text-[26px]">2 Stunden</h3>
                        <p class="mt-4 text-[34px] text-[#73ffff]">36,00 €</p>
                        <p class="<?= $bodyText ?> mt-2">pro Person</p>
                    </article>
                </div>
            </section>

            <section class="<?= $section ?>">
                <div class="mb-4">
                    <p class="<?= $eyebrow ?>">Aktionen</p>
                    <h2 class="text-[30px] leading-tight max-[775px]:text-[25px]">Flats am Wochenende</h2>
                </div>
                <div class="<?= $grid ?>">
                    <article class="<?= $card ?>">
                        <div class="<?= $cardHeader ?>">
                            <div>
                                <p class="<?= $meta ?>">Samstag & Sonntag</p>
                                <h3 class="<?= $cardTitle ?> mt-3">Family Flat</h3>
                            </div>
                            <p class="<?= $price ?>">15,00 €<span class="<?= $priceNote ?>">pro Person</span></p>
                        </div>
                        <div class="<?= $cardContent ?>">
                            <div class="<?= $details ?>">
                                <p>Spielzeit von 10:00 bis 11:30 Uhr.</p>
                                <p>Erwachsene erhalten wahlweise Kaffee oder Tee.</p>
                            </div>
                            <a href="/reservieren/#/category/1/" class="Button_Book self-start">Jetzt buchen</a>
                        </div>
                    </article>

                    <article class="<?= $card ?>">
                        <div class="<?= $cardHeader ?>">
                            <div>
                                <p class="<?= $meta ?>">Samstag & Sonntag</p>
                                <h3 class="<?= $cardTitle ?> mt-3">Night Special</h3>
                            </div>
                            <p class="<?= $price ?>">27,00 €<span class="<?= $priceNote ?>">pro Person</span></p>
                        </div>
                        <div class="<?= $cardContent ?>">
                            <div class="<?= $details ?>">
                                <p>Drei Stunden Lasertag von 18:00 bis 21:00 Uhr.</p>
                                <p>Ideal für Gruppen, die den Abend in der Arena verbringen möchten.</p>
                            </div>
                            <a href="/reservieren/#/category/1/" class="Button_Book self-start">Jetzt buchen</a>
                        </div>
                    </article>
                </div>
            </section>

            <section class="<?= $section ?>">
                <div class="mb-4 flex items-end justify-between gap-4 max-[775px]:flex-col max-[775px]:items-start">
                    <div>
                        <p class="<?= $eyebrow ?>">Feiern</p>
                        <h2 class="text-[30px] leading-tight max-[775px]:text-[25px]">Geburtstagspakete</h2>
                    </div>
                    <p class="<?= $meta ?>">ab 6 Gästen</p>
                </div>
                <div class="<?= $grid ?>">
                    <article class="<?= $card ?>">
                        <div class="<?= $cardHeader ?>">
                            <div>
                                <p class="<?= $meta ?>">2 Stunden</p>
                                <h3 class="<?= $cardTitle ?> mt-3">Geburtstag Basis</h3>
                            </div>
                            <p class="<?= $price ?>">34,90 €<span class="<?= $priceNote ?>">pro Gast</span></p>
                        </div>
                        <div class="<?= $cardContent ?>">
                            <div class="<?= $details ?>">
                                <p>Getränkeflat für die Gruppe ist enthalten.</p>
                                <p>Das Geburtstagskind bekommt einen Slushy dazu.</p>
                            </div>
                            <a href="/reservieren/#/category/2/" class="Button_Book self-start">Geburtstag buchen</a>
                        </div>
                    </article>

                    <article class="<?= $card ?>">
                        <div class="<?= $cardHeader ?>">
                            <div>
                                <p class="<?= $meta ?>">3 Stunden</p>
                                <h3 class="<?= $cardTitle ?> mt-3">Geburtstag Plus</h3>
                            </div>
                            <p class="<?= $price ?>">39,90 €<span class="<?= $priceNote ?>">pro Gast</span></p>
                        </div>
                        <div class="<?= $cardContent ?>">
                            <div class="<?= $details ?>">
                                <p>Alle Leistungen aus dem 2-Stunden-Paket sind inklusive.</p>
                                <p>Zusätzlich erhält das Geburtstagskind eine Membercard; jeder Gast bekommt eine Snackbox.</p>
                            </div>
                            <a href="/reservieren/#/category/2/" class="Button_Book self-start">Geburtstag buchen</a>
                        </div>
                    </article>
                </div>
            </section>

            <section class="<?= $section ?> <?= $panel ?> border border-white/10 p-6 max-[775px]:p-4">
                <div class="grid grid-cols-[auto_1fr_auto] items-center gap-5 max-[850px]:grid-cols-1">
                    <div class="flex h-20 w-20 items-center justify-center rounded-full border-2 border-[#00aaaa] text-[28px] text-[#73ffff]">+</div>
                    <div>
                        <p class="<?= $eyebrow ?>">Optional</p>
                        <h2 class="text-[28px] leading-tight max-[775px]:text-[24px]">Getränkeflat</h2>
                        <p class="<?= $bodyText ?> mt-2">
                            Für 9,90 € pro Person sind kleine Getränke sowie 1-Liter-Wasserflaschen dabei. Cola, Fanta und Sprite sind davon ausgenommen.
                        </p>
                    </div>
                    <!-- <a href="/kontakt/" class="Button_Book">Nachfragen</a> -->
                </div>
            </section>
        </main>

        <?php include __DIR__ . '/../Resources/footer.php'; ?>
    </body>
</html>
