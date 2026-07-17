<?php

$newsItems = [
    [
        'label' => 'Wichtige Information',
        'title' => 'Arena-Modernisierung',
        'text' => 'Unsere Lasertag-Arena wird modernisiert und bleibt während der Arbeiten geschlossen. Zur Wiedereröffnung erhaltet ihr 15 % Rabatt auf alle Spielpakete.',
        'highlight' => 'Geschlossen: <b>02.07.26 - 12.08.26</b>',
        'image' => 'resources/renovieren.avif',
        'imageAlt' => 'Modernisierung der Lasertag-Arena',
        'showOnHome' => true,
        'showOnPrices' => true,
        'discountPercent' => 15,
        'startDate' => '2026-07-02',
        'endDate' => '2026-08-12',
    ],
    [
        'label' => 'Wiedereröffnung',
        'title' => 'Wiedereröffnung am 13. August',
        'text' => 'Der Umbau ist abgeschlossen und unsere Arena wieder für euch geöffnet. Sichert euch 15 % Rabatt auf alle Spielpakete.',
        'highlight' => 'Gültig bis <b>21.08.2026</b>',
        'image' => 'resources/renovieren.avif',
        'imageAlt' => 'Renovierte Lasertag Arena',
        'showOnHome' => true,
        'showOnPrices' => true,
        'discountPercent' => 15,
        'startDate' => '2026-08-13',
        'endDate' => '2026-08-31',
    ],
];

function activeNewsForPage(string $page): array
{
    global $newsItems;

    $now = new DateTimeImmutable('today', new DateTimeZone('Europe/Berlin'));
    $displayKey = $page === 'home' ? 'showOnHome' : 'showOnPrices';

    return array_values(array_filter($newsItems, static function (array $newsItem) use ($now, $displayKey): bool {
        $startDate = new DateTimeImmutable($newsItem['startDate'], new DateTimeZone('Europe/Berlin'));
        $endDate = new DateTimeImmutable($newsItem['endDate'], new DateTimeZone('Europe/Berlin'));

        return $newsItem[$displayKey] && $now >= $startDate && $now <= $endDate;
    }));
}

function renderNews(array $newsItems, string $assetPath = ''): void
{
    foreach ($newsItems as $newsItem):
        $startDate = new DateTimeImmutable($newsItem['startDate']);
        $endDate = new DateTimeImmutable($newsItem['endDate']);
        ?>
        <article
            class="relative overflow-hidden rounded-[28px] border border-[#00ffff66] bg-[linear-gradient(125deg,rgba(0,170,170,.2),rgba(18,18,22,.97)_42%,rgba(35,134,54,.16))] p-1 shadow-[0_18px_45px_rgba(0,0,0,.68)]">
            <div class="grid items-stretch gap-0 overflow-hidden rounded-[24px] bg-[#101114]/90 lg:grid-cols-[1fr_300px]">
                <div class="p-6 max-[700px]:p-5">
                    <div class="flex flex-wrap items-center gap-3">
                        <p
                            class="rounded-full border border-[#00ffff80] bg-[#00aaaa22] px-3 py-1 text-xs uppercase tracking-[.2em] text-[#9fffff]">
                            <?= htmlspecialchars($newsItem['label']) ?>
                        </p>
                    </div>
                    <h2 class="mt-4 text-[36px] uppercase leading-[.95] text-white max-[700px]:text-[29px]">
                        <?= htmlspecialchars($newsItem['title']) ?>
                    </h2>
                    <p
                        class="mt-4 max-w-[720px] font-[Arial,Helvetica,sans-serif] text-xl leading-snug text-white/90 max-[700px]:text-lg">
                        <?= htmlspecialchars($newsItem['text']) ?>
                    </p>
                    <?php if (isset($newsItem['highlight'])): ?>
                        <p class="mt-4 text-lg text-[#9fffff]"><?= $newsItem['highlight'] ?></p>
                    <?php endif; ?>
                </div>
                <div class="relative min-h-[190px] max-[700px]:min-h-[145px]">
                    <img src="<?= htmlspecialchars($assetPath . $newsItem['image']) ?>"
                        alt="<?= htmlspecialchars($newsItem['imageAlt']) ?>" class="h-full w-full object-cover" />
                    <div
                        class="absolute inset-0 bg-[linear-gradient(90deg,rgba(16,17,20,.8),transparent_50%)] max-[700px]:bg-[linear-gradient(0deg,rgba(16,17,20,.7),transparent_60%)]">
                    </div>
                </div>
            </div>
        </article>
        <?php
    endforeach;
}
