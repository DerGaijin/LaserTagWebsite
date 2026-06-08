<!doctype html>
<html lang="de">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Lasertag Verden</title>
        <link rel="icon" type="image/png" sizes="32x32" href="Resources/favicon-32x32.png" />
        <link rel="icon" type="image/png" sizes="16x16" href="Resources/favicon-16x16.png" />
        <link rel="stylesheet" href="Shared.css" />
        <link rel="stylesheet" href="index.css" />
        <script src="Shared.js"></script>
    </head>
    <body>
        <?php include __DIR__ . '/Resources/header.php'; ?>

        <main>
            <div class="ContentBoxList">
                <div class="ContentBox">
                    <h2 class="ContentBoxTitle">Unsere Öffnungszeiten</h2>
                    <div class="CenterBox">
                        <div id="OpeningsTable">
                            <p class="OpeningsTableItem">Montag</p>
                            <p class="OpeningsTableItem">|</p>
                            <p class="OpeningsTableItem">Geschlossen</p>

                            <p class="OpeningsTableItem">Dienstag</p>
                            <p class="OpeningsTableItem">|</p>
                            <p class="OpeningsTableItem">15:00 - 20:00</p>

                            <p class="OpeningsTableItem">Mittwoch</p>
                            <p class="OpeningsTableItem">|</p>
                            <p class="OpeningsTableItem">15:00 - 20:00</p>

                            <p class="OpeningsTableItem">Donnerstag</p>
                            <p class="OpeningsTableItem">|</p>
                            <p class="OpeningsTableItem">15:00 - 20:00</p>

                            <p class="OpeningsTableItem">Freitag</p>
                            <p class="OpeningsTableItem">|</p>
                            <p class="OpeningsTableItem">15:00 - 21:00</p>

                            <p class="OpeningsTableItem">Samstag</p>
                            <p class="OpeningsTableItem">|</p>
                            <p class="OpeningsTableItem">11:00 - 21:00</p>

                            <p class="OpeningsTableItem">Sonntag</p>
                            <p class="OpeningsTableItem">|</p>
                            <p class="OpeningsTableItem">11:00 - 20:00</p>
                        </div>
                        <p class="Note">Öffnungen nur auf Vorbuchungen</p>
                        <div class="Note">
                            <a class="NoteButton Button_Book" href="/preise/">Jetzt Buchen</a>
                            <a class="NoteButton Button_Book" href="/kontakt/">Kontakt</a>
                        </div>
                    </div>
                </div>
                <div class="ContentBox" style="font-size: 20px">
                    <h2 class="ContentBoxTitle">!!! Umbauarbeiten !!!</h2>
                    <div style="text-align: center; padding-bottom: 10px">
                        <p>In den Sommerferien nutzen wir die Zeit, um unsere Lasertaghalle für euch noch besser zu machen.</p>
                        <br />
                        <p>Daher bleibt unsere Anlage</p>
                        <p>vom <b style="font-size: 22px">02.07.26</b> bis <b style="font-size: 22px">12.08.26</b></p>
                        <p>geschlossen</p>
                    </div>
                    <img src="Resources/renovieren.avif" alt="Renovieren" class="ContentBoxImage" />
                </div>
                <div class="ContentBox">
                    <h2 class="ContentBoxTitle">Unsere Technik</h2>
                    <img src="Resources/LaserForceBlasters.webp" alt="LaserForceBlasters" class="ContentBoxImage" />
                    <img src="Resources/LaserForceGen8.webp" alt="LaserForceGen8" class="ContentBoxImage" />
                </div>
            </div>
        </main>

        <?php include __DIR__ . '/Resources/footer.php'; ?>
    </body>
</html>
