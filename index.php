<!doctype html>
<html lang="de">
    <head>
        <?php require __DIR__ . '/resources/head.php'; ?>
    </head>
    <body>
        <?php include __DIR__ . '/Resources/header.php'; ?>

        <main class="flex flex-col items-center px-[100px] py-[25px] max-[1260px]:px-[5px]">
            <div class="grid w-full grid-cols-[repeat(2,auto)] justify-evenly max-[1260px]:flex max-[1260px]:flex-wrap [&>*:last-child:nth-child(odd)]:col-span-full [&>*:last-child:nth-child(odd)]:justify-self-center max-[1260px]:[&>*:last-child:nth-child(odd)]:col-auto max-[1260px]:[&>*:last-child:nth-child(odd)]:justify-self-auto">
                <div class="m-2.5 flex w-[500px] flex-col rounded-[25px] bg-[var(--ContentBoxBackground)] p-2.5 shadow-[10px_10px_20px_black] max-[775px]:w-full">
                    <h2 class="mb-[15px] border-b-2 border-white p-2 text-center text-[28px] uppercase">Unsere Öffnungszeiten</h2>
                    <div class="flex h-full flex-col justify-center">
                        <div id="OpeningsTable" class="grid grid-cols-[1fr_10px_1fr]">
                            <p class="mb-2.5 whitespace-nowrap text-center text-[25px] max-[375px]:whitespace-normal">Montag</p>
                            <p class="mb-2.5 whitespace-nowrap text-center text-[25px] max-[375px]:whitespace-normal">|</p>
                            <p class="mb-2.5 whitespace-nowrap text-center text-[25px] max-[375px]:whitespace-normal">Geschlossen</p>

                            <p class="mb-2.5 whitespace-nowrap text-center text-[25px] max-[375px]:whitespace-normal">Dienstag</p>
                            <p class="mb-2.5 whitespace-nowrap text-center text-[25px] max-[375px]:whitespace-normal">|</p>
                            <p class="mb-2.5 whitespace-nowrap text-center text-[25px] max-[375px]:whitespace-normal">15:00 - 20:00</p>

                            <p class="mb-2.5 whitespace-nowrap text-center text-[25px] max-[375px]:whitespace-normal">Mittwoch</p>
                            <p class="mb-2.5 whitespace-nowrap text-center text-[25px] max-[375px]:whitespace-normal">|</p>
                            <p class="mb-2.5 whitespace-nowrap text-center text-[25px] max-[375px]:whitespace-normal">15:00 - 20:00</p>

                            <p class="mb-2.5 whitespace-nowrap text-center text-[25px] max-[375px]:whitespace-normal">Donnerstag</p>
                            <p class="mb-2.5 whitespace-nowrap text-center text-[25px] max-[375px]:whitespace-normal">|</p>
                            <p class="mb-2.5 whitespace-nowrap text-center text-[25px] max-[375px]:whitespace-normal">15:00 - 20:00</p>

                            <p class="mb-2.5 whitespace-nowrap text-center text-[25px] max-[375px]:whitespace-normal">Freitag</p>
                            <p class="mb-2.5 whitespace-nowrap text-center text-[25px] max-[375px]:whitespace-normal">|</p>
                            <p class="mb-2.5 whitespace-nowrap text-center text-[25px] max-[375px]:whitespace-normal">15:00 - 21:00</p>

                            <p class="mb-2.5 whitespace-nowrap text-center text-[25px] max-[375px]:whitespace-normal">Samstag</p>
                            <p class="mb-2.5 whitespace-nowrap text-center text-[25px] max-[375px]:whitespace-normal">|</p>
                            <p class="mb-2.5 whitespace-nowrap text-center text-[25px] max-[375px]:whitespace-normal">11:00 - 21:00</p>

                            <p class="mb-2.5 whitespace-nowrap text-center text-[25px] max-[375px]:whitespace-normal">Sonntag</p>
                            <p class="mb-2.5 whitespace-nowrap text-center text-[25px] max-[375px]:whitespace-normal">|</p>
                            <p class="mb-2.5 whitespace-nowrap text-center text-[25px] max-[375px]:whitespace-normal">11:00 - 20:00</p>
                        </div>
                        <p class="mt-5 flex w-full justify-center text-xl">Öffnungen nur auf Vorbuchungen</p>
                        <div class="mt-5 flex w-full justify-center text-xl">
                            <a class="Button_Book mx-2.5 my-2.5 self-center" href="/preise/">Jetzt Buchen</a>
                            <a class="Button_Book mx-2.5 my-2.5 self-center" href="/kontakt/">Kontakt</a>
                        </div>
                    </div>
                </div>
                <div class="m-2.5 flex w-[500px] flex-col rounded-[25px] bg-[var(--ContentBoxBackground)] p-2.5 text-xl shadow-[10px_10px_20px_black] max-[775px]:w-full">
                    <h2 class="mb-[15px] border-b-2 border-white p-2 text-center text-[28px] uppercase">!!! Umbauarbeiten !!!</h2>
                    <div class="pb-2.5 text-center">
                        <p>In den Sommerferien nutzen wir die Zeit, um unsere Lasertaghalle für euch noch besser zu machen.</p>
                        <br />
                        <p>Daher bleibt unsere Anlage</p>
                        <p>vom <b class="text-[22px]">02.07.26</b> bis <b class="text-[22px]">12.08.26</b></p>
                        <p>geschlossen</p>
                    </div>
                    <img src="Resources/renovieren.avif" alt="Renovieren" class="w-full" />
                </div>
                <div class="m-2.5 flex w-[500px] flex-col rounded-[25px] bg-[var(--ContentBoxBackground)] p-2.5 shadow-[10px_10px_20px_black] max-[775px]:w-full">
                    <h2 class="mb-[15px] border-b-2 border-white p-2 text-center text-[28px] uppercase">Unsere Technik</h2>
                    <img src="Resources/LaserForceBlasters.webp" alt="LaserForceBlasters" class="w-full" />
                    <img src="Resources/LaserForceGen8.webp" alt="LaserForceGen8" class="w-full" />
                </div>
            </div>
        </main>

        <?php include __DIR__ . '/Resources/footer.php'; ?>
    </body>
</html>
