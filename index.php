<?php
$newsItems = [
    [
        'label' => 'Aktuelle News',
        'title' => 'Wir bauen unsere Arena um',
        'text' => 'Wir überarbeiten aktuell unsere Lasertaghalle, damit euer nächstes Spiel noch besser wird.',
        'highlight' => 'Geschlossen vom <b>02.07.26</b> bis <b>12.08.26</b>',
        'image' => 'resources/renovieren.avif',
        'imageAlt' => 'Renovieren',
    ],
    [
        'label' => 'Aktuelle News',
        'title' => 'Wir sind fertig mit dem Umbau',
        'text' => 'Unsere Arena ist frisch überarbeitet und bereit für eure nächsten Spiele.',
        'highlight' => 'Reservierungen sind wieder möglich.',
        'image' => 'resources/renovieren.avif',
        'imageAlt' => 'Renovierte Arena',
	],
];
$openingHours = [
	1 => ['Montag', 'Geschlossen*', null, null],
	2 => ['Dienstag', 'Geschlossen*', null, null],
	3 => ['Mittwoch', 'Geschlossen*', null, null],
	4 => ['Donnerstag', '15:00 - 20:00', '15:00', '20:00'],
	5 => ['Freitag', '15:00 - 20:00', '15:00', '20:00'],
	6 => ['Samstag', '10:00 - 21:00', '10:00', '21:00'],
	7 => ['Sonntag', '10:00 - 21:00', '10:00', '21:00'],
];
$now = new DateTimeImmutable('now', new DateTimeZone('Europe/Berlin'));
$todayIndex = (int) $now->format('N');
$todayHours = $openingHours[$todayIndex];
$isOpenNow = false;

if ($todayHours[2] && $todayHours[3]) {
	$openAt = new DateTimeImmutable($now->format('Y-m-d') . ' ' . $todayHours[2], new DateTimeZone('Europe/Berlin'));
	$closeAt = new DateTimeImmutable($now->format('Y-m-d') . ' ' . $todayHours[3], new DateTimeZone('Europe/Berlin'));
	$isOpenNow = $now >= $openAt && $now < $closeAt;
}

$openingStatus = $isOpenNow ? 'Jetzt geöffnet' : 'Heute geschlossen';
$openingStatusClass = $isOpenNow ? 'border-[#238636] bg-[#238636]/25 text-[#9dffad]' : 'border-[#00aaaa] bg-[#00aaaa]/15 text-[#73ffff]';

function openingRowClass(int $dayIndex, int $todayIndex): string
{
	if ($dayIndex === $todayIndex) {
		return 'bg-[#00aaaa44] text-[#73ffff] shadow-[0_0_18px_rgba(0,170,170,0.22)]';
	}

	return $dayIndex >= 4 ? 'bg-[#00aaaa26]' : 'bg-black/25';
}
?>
<!doctype html>
<html lang="de">

<head>
    <?php require 'resources/head.php'; ?>
</head>

<body>
    <?php include 'resources/header.php'; ?>

    <main class="mx-auto flex w-full max-w-[1180px] flex-col gap-8 px-6 py-8 max-[700px]:px-3">
        <section class="grid gap-4">
            <?php foreach ($newsItems as $newsItem): ?>
                <article
                    class="rounded-[24px] border-2 border-[#00aaaa] bg-[rgba(18,18,18,.94)] p-5 shadow-[0_12px_35px_rgba(0,0,0,.65)]">
                    <div class="grid items-center gap-5 lg:grid-cols-[1fr_260px]">
                        <div>
                            <p
                                class="mb-3 w-fit rounded-md bg-[#00aaaa] px-3 py-1 text-sm uppercase tracking-[.18em] text-black">
                                <?= htmlspecialchars($newsItem['label']) ?></p>
                            <h1 class="text-[36px] uppercase leading-tight text-white max-[700px]:text-[28px]">
                                <?= htmlspecialchars($newsItem['title']) ?></h1>
                            <p class="mt-3 max-w-[760px] text-xl leading-snug text-white/90">
                                <?= htmlspecialchars($newsItem['text']) ?></p>
                            <p class="mt-3 text-2xl text-white max-[700px]:text-xl"><?= $newsItem['highlight'] ?></p>
                        </div>
                        <img src="<?= htmlspecialchars($newsItem['image']) ?>" alt="<?= htmlspecialchars($newsItem['imageAlt']) ?>"
                            class="max-h-[180px] w-full rounded-[18px] object-cover" />
                    </div>
                </article>
            <?php endforeach; ?>
        </section>

        <section
            class="relative overflow-hidden rounded-[32px] border border-[#00ffff55] bg-[radial-gradient(circle_at_top_left,#00ffff33,transparent_34%),linear-gradient(135deg,rgba(8,8,12,.96),rgba(28,28,32,.9))] p-8 shadow-[0_20px_60px_rgba(0,0,0,.75)] max-[700px]:p-5">
            <div class="absolute right-[-90px] top-[-120px] h-[280px] w-[280px] rounded-full bg-[#00ffff22] blur-2xl">
            </div>
            <div class="absolute bottom-[-130px] left-[20%] h-[240px] w-[240px] rounded-full bg-[#23863666] blur-3xl">
            </div>

            <div class="relative grid items-center gap-8 lg:grid-cols-[1.15fr_.85fr]">
                <div class="flex flex-col gap-5">
                    <p
                        class="w-fit rounded-full border border-[#00ffff66] bg-black/35 px-4 py-2 text-sm uppercase tracking-[.22em] text-[#9fffff]">
                        LaserTag Verden</p>
                    <h2
                        class="text-[64px] uppercase leading-[.92] tracking-wide text-white drop-shadow-[0_0_18px_rgba(0,255,255,.45)] max-[700px]:text-[42px]">
                        Adrenalin im Arena-Modus</h2>
                    <p class="max-w-[640px] text-2xl leading-snug text-white/85 max-[700px]:text-xl">Taucht ein in
                        unsere Lasertaghalle mit LaserForce Gen8 Equipment, taktischen Runden und Action für Teams,
                        Geburtstage und Firmen.</p>
					<div class="grid grid-cols-3 gap-3 max-w-[640px] max-[620px]:grid-cols-1">
						<div class="rounded-2xl border border-white/10 bg-black/25 p-3 text-center"><span class="block text-[28px] text-[#73ffff]">400 m²</span><span class="font-[Arial,Helvetica,sans-serif] text-sm text-white/70">Arena</span></div>
						<div class="rounded-2xl border border-white/10 bg-black/25 p-3 text-center"><span class="block text-[28px] text-[#73ffff]">12 Min.</span><span class="font-[Arial,Helvetica,sans-serif] text-sm text-white/70">pro Runde</span></div>
						<div class="rounded-2xl border border-white/10 bg-black/25 p-3 text-center"><span class="block text-[28px] text-[#73ffff]">Gen8</span><span class="font-[Arial,Helvetica,sans-serif] text-sm text-white/70">Equipment</span></div>
					</div>
					<div class="flex flex-wrap gap-3 text-xl">
						<a class="Button_Book Pulse_CTA px-7 py-3" href="preise/">Jetzt Buchen</a>
						<a class="rounded-md border border-white/35 bg-white/10 px-7 py-3 text-white no-underline transition hover:bg-white/20"
							href="galerie/">Arena ansehen</a>
					</div>
                </div>

                <div
                    class="relative rounded-[26px] border border-white/15 bg-black/35 p-4 shadow-[inset_0_0_35px_rgba(0,255,255,.12)]">
                    <img src="resources/LaserForceBlasters.webp" alt="LaserForce Blaster"
                        class="w-full rounded-[18px]" />
                    <div class="mt-4 grid grid-cols-2 gap-3 text-center text-lg max-[420px]:grid-cols-1">
                        <div class="rounded-2xl bg-[#00aaaa22] p-3"><span
                                class="block text-[#9fffff]">Gen8</span>LaserForce</div>
                        <div class="rounded-2xl bg-[#23863633] p-3"><span
                                class="block text-[#9fffff]">Teamplay</span>Action pur</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-[.95fr_1.05fr]">
            <div
                class="rounded-[28px] border border-white/10 bg-[var(--ContentBoxBackground)] p-6 shadow-[0_18px_40px_rgba(0,0,0,.65)]">
				<div class="mb-5 flex items-center justify-between gap-4 border-b-2 border-[#00aaaa] pb-3 max-[520px]:flex-col">
					<h2 class="text-center text-[32px] uppercase">Öffnungszeiten</h2>
					<span class="rounded-full border px-3 py-1 text-xs uppercase tracking-[0.08em] whitespace-nowrap <?= $openingStatusClass ?>"><?= $openingStatus ?></span>
				</div>
				<div id="OpeningsTable"
					class="grid grid-cols-[1fr_auto] gap-x-4 gap-y-3 text-[23px] max-[520px]:text-lg">
					<?php foreach ($openingHours as $dayIndex => $hours): ?>
						<?php $rowClass = openingRowClass($dayIndex, $todayIndex); ?>
						<p class="rounded-l-xl px-4 py-3 <?= $rowClass ?>"><?= htmlspecialchars($hours[0]) ?><?= $dayIndex === $todayIndex ? ' <span class="text-sm uppercase tracking-[0.12em] text-white/70">Heute</span>' : '' ?></p>
						<p class="rounded-r-xl px-4 py-3 text-right <?= $rowClass ?>"><?= htmlspecialchars($hours[1]) ?></p>
					<?php endforeach; ?>
				</div>
                <p class="mt-5 rounded-2xl border border-[#00ffff44] bg-black/25 p-4 text-center text-xl">*Montag bis
                    Mittwoch geschlossen, außer bei Buchung der Halle.</p>
                <div class="mt-5 flex flex-wrap justify-center gap-3 text-xl">
                    <a class="Button_Book" href="reservieren/">Reservieren</a>
                    <a class="Button_Book" href="kontakt/">Halle buchen</a>
                </div>
            </div>

            <div class="grid gap-6">
                <article
                    class="flex h-full flex-col rounded-[28px] border border-white/10 bg-[var(--ContentBoxBackground)] p-6 shadow-[0_18px_40px_rgba(0,0,0,.65)]">
                    <h2 class="mb-5 border-b-2 border-[#00aaaa] pb-3 text-center text-[32px] uppercase">Unsere Technik
                    </h2>
                    <div class="flex flex-1 flex-col gap-4">
                        <img src="resources/LaserForceBlasters.webp" alt="LaserForceBlasters" class="ContentBoxImage" />
                        <img src="resources/LaserForceGen8.webp" alt="LaserForceGen8" class="ContentBoxImage" />
                    </div>
                </article>
            </div>
        </section>
    </main>

    <?php include 'resources/footer.php'; ?>
</body>

</html>
