<!doctype html>
<html lang="de">

<head>
    <?php require __DIR__ . '/resources/head.php'; ?>
</head>

<body>
    <?php include __DIR__ . '/Resources/header.php'; ?>

    <main class="mx-auto flex w-full max-w-[1180px] flex-col gap-8 px-6 py-8 max-[700px]:px-3">
        <section
            class="rounded-[24px] border-2 border-[#00aaaa] bg-[rgba(18,18,18,.94)] p-5 shadow-[0_12px_35px_rgba(0,0,0,.65)]">
            <div class="grid items-center gap-5 lg:grid-cols-[1fr_260px]">
                <div>
                    <p
                        class="mb-3 w-fit rounded-md bg-[#00aaaa] px-3 py-1 text-sm uppercase tracking-[.18em] text-black">
                        Aktuelle Info</p>
                    <h1 class="text-[36px] uppercase leading-tight text-white max-[700px]:text-[28px]">Wir bauen unsere
                        Arena um</h1>
                    <p class="mt-3 max-w-[760px] text-xl leading-snug text-white/90">Wir überarbeiten aktuell unsere
                        Lasertaghalle, damit euer nächstes Spiel noch besser wird.</p>
                    <p class="mt-3 text-2xl text-white max-[700px]:text-xl">Geschlossen vom <b>02.07.26</b> bis
                        <b>12.08.26</b></p>
                </div>
                <img src="Resources/renovieren.avif" alt="Renovieren"
                    class="max-h-[180px] w-full rounded-[18px] object-cover" />
            </div>
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
                    <div class="flex flex-wrap gap-3 text-xl">
                        <a class="Button_Book px-7 py-3" href="/preise/">Jetzt Buchen</a>
                        <a class="rounded-md border border-white/35 bg-white/10 px-7 py-3 text-white no-underline transition hover:bg-white/20"
                            href="/galerie/">Arena ansehen</a>
                    </div>
                </div>

                <div
                    class="relative rounded-[26px] border border-white/15 bg-black/35 p-4 shadow-[inset_0_0_35px_rgba(0,255,255,.12)]">
                    <img src="Resources/LaserForceBlasters.webp" alt="LaserForce Blaster"
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
                <h2 class="mb-5 border-b-2 border-[#00aaaa] pb-3 text-center text-[32px] uppercase">Öffnungszeiten</h2>
                <div id="OpeningsTable"
                    class="grid grid-cols-[1fr_auto] gap-x-4 gap-y-3 text-[23px] max-[520px]:text-lg">
                    <p class="rounded-l-xl bg-black/25 px-4 py-3">Montag</p>
                    <p class="rounded-r-xl bg-black/25 px-4 py-3 text-right">Geschlossen*</p>
                    <p class="rounded-l-xl bg-black/25 px-4 py-3">Dienstag</p>
                    <p class="rounded-r-xl bg-black/25 px-4 py-3 text-right">Geschlossen*</p>
                    <p class="rounded-l-xl bg-black/25 px-4 py-3">Mittwoch</p>
                    <p class="rounded-r-xl bg-black/25 px-4 py-3 text-right">Geschlossen*</p>
                    <p class="rounded-l-xl bg-[#00aaaa26] px-4 py-3">Donnerstag</p>
                    <p class="rounded-r-xl bg-[#00aaaa26] px-4 py-3 text-right">15:00 - 20:00</p>
                    <p class="rounded-l-xl bg-[#00aaaa26] px-4 py-3">Freitag</p>
                    <p class="rounded-r-xl bg-[#00aaaa26] px-4 py-3 text-right">15:00 - 20:00</p>
                    <p class="rounded-l-xl bg-[#23863636] px-4 py-3">Samstag</p>
                    <p class="rounded-r-xl bg-[#23863636] px-4 py-3 text-right">10:00 - 21:00</p>
                    <p class="rounded-l-xl bg-[#23863636] px-4 py-3">Sonntag</p>
                    <p class="rounded-r-xl bg-[#23863636] px-4 py-3 text-right">10:00 - 21:00</p>
                </div>
                <p class="mt-5 rounded-2xl border border-[#00ffff44] bg-black/25 p-4 text-center text-xl">*Montag bis
                    Mittwoch geschlossen, außer bei Buchung der Halle.</p>
                <div class="mt-5 flex flex-wrap justify-center gap-3 text-xl">
                    <a class="Button_Book" href="/reservieren/">Reservieren</a>
                    <a class="Button_Book" href="/kontakt/">Halle buchen</a>
                </div>
            </div>

            <div class="grid gap-6">
                <article
                    class="flex h-full flex-col rounded-[28px] border border-white/10 bg-[var(--ContentBoxBackground)] p-6 shadow-[0_18px_40px_rgba(0,0,0,.65)]">
                    <h2 class="mb-5 border-b-2 border-[#00aaaa] pb-3 text-center text-[32px] uppercase">Unsere Technik
                    </h2>
                    <div class="flex flex-1 flex-col gap-4">
                        <img src="Resources/LaserForceBlasters.webp" alt="LaserForceBlasters" class="ContentBoxImage" />
                        <img src="Resources/LaserForceGen8.webp" alt="LaserForceGen8" class="ContentBoxImage" />
                    </div>
                </article>
            </div>
        </section>
    </main>

    <?php include __DIR__ . '/Resources/footer.php'; ?>
</body>

</html>