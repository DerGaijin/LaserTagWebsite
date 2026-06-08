<!DOCTYPE html>
<?php
$cardList = 'flex flex-wrap self-center justify-center';
$card = 'm-2.5 grid max-w-[600px] grid-cols-2 rounded-[25px] bg-[var(--ContentBoxBackground)] p-2.5 shadow-[10px_10px_20px_black] max-[775px]:w-full';
$simpleCard = 'm-2.5 flex min-w-[400px] max-w-[600px] flex-col items-center rounded-[25px] bg-[var(--ContentBoxBackground)] p-2.5 shadow-[10px_10px_20px_black] max-[775px]:w-full max-[775px]:min-w-0';
$cardTitle = 'col-span-2 mb-2.5 w-full text-center text-2xl font-bold';
$infoBox = 'flex h-auto max-w-full flex-[1_1_100%] justify-center font-[Arial,Helvetica,sans-serif]';
$infoContent = 'm-2.5 flex max-w-[800px] flex-col items-center rounded-[25px] bg-[var(--ContentBoxBackground)] px-[10%] py-2.5 text-center shadow-[10px_10px_20px_black] max-[775px]:w-full';
$cardMedia = 'flex items-center justify-center p-[5px]';
$cardImage = 'aspect-square w-full max-w-[200px] rounded-full';
$cardDetails = 'flex flex-col justify-center p-2.5';
$cardText = 'pb-2.5';
$cardDate = $cardText . ' text-xl';
$cardPrice = $cardText . ' text-[22px]';
$cardNote = $cardText . ' text-sm';
?>
<html lang="de">
    <head>
        <?php require __DIR__ . '/../resources/head.php'; ?>
    </head>
    <body>
        <?php $currentPage = 'preise'; include __DIR__ . '/../Resources/header.php'; ?>

        <main class="flex max-w-[2000px] flex-col justify-self-center">
            <div class="<?= $infoBox ?>">
                <div class="<?= $infoContent ?>">
                    <h3 class="<?= $cardTitle ?>">Wichtig</h3>
                    <p class="pb-2.5 text-lg">Wir haben an folgenden Tagen geschlossen:</p>
                    <div class="grid grid-cols-2 gap-x-2.5 text-left">
                        <p class="text-right">24.12.25</p>
                        <p>Weihnachten</p>
                        <p class="text-right">25.12.25</p>
                        <p>1. Weihnachtstag</p>
                        <p class="text-right">26.12.25</p>
                        <p>2. Weihnachtstag</p>
                        <p class="text-right">31.12.25</p>
                        <p>Silvester</p>
                        <p class="text-right">01.01.26</p>
                        <p>Neujahr</p>
                    </div>
                </div>
            </div>

            <div class="<?= $infoBox ?>">
                <div class="<?= $infoContent ?>">
                    <h3 class="<?= $cardTitle ?>">Information</h3>
                    <p>Bitte beachten Sie, dass das Mitbringen von Speisen, Snacks und Getränken in unsere Arena grundsätzlich nicht gestattet ist. Im Rahmen unserer Geburtstagsangebote dürfen eigene Speisen mitgebracht werden; Getränke sind jedoch weiterhin ausgeschlossen.</p>
                </div>
            </div>

            <div class="<?= $cardList ?>">
                <div class="<?= $simpleCard ?>">
                    <h3 class="<?= $cardTitle ?>">1. Runde</h3>
                    <p class="<?= $cardPrice ?>">8,50 €</p>
                    <p class="<?= $cardNote ?>">(Member 7,50 €)</p>
                    <a href="/reservieren#/category/3/" class="Button_Book">Jetzt Buchen</a>
                </div>
                <div class="<?= $simpleCard ?>">
                    <h3 class="<?= $cardTitle ?>">3. Runden</h3>
                    <p class="<?= $cardPrice ?>">22,00 €</p>
                    <p class="<?= $cardNote ?>">(Member 20,00 €)</p>
                    <a href="/reservieren#/category/3/" class="Button_Book">Jetzt Buchen</a>
                </div>
                <div class="<?= $simpleCard ?>">
                    <h3 class="<?= $cardTitle ?>">5. Runden</h3>
                    <p class="<?= $cardPrice ?>">34,00 €</p>
                    <p class="<?= $cardNote ?>">(Member 30,00 €)</p>
                    <a href="/reservieren#/category/3/" class="Button_Book">Jetzt Buchen</a>
                </div>
            </div>
            <div class="<?= $cardList ?>">
                <div class="<?= $card ?>">
                    <h3 class="<?= $cardTitle ?>">Flatrate - Prime Time</h3>
                    <div class="<?= $cardMedia ?>">
                        <img src="../Resources/PrimeTimeIcon.webp" alt="PrimeTime" class="<?= $cardImage ?>" />
                    </div>
                    <div class="<?= $cardDetails ?>">
                        <p class="<?= $cardDate ?>">Dienstag - Freitag</p>
                        <p class="<?= $cardText ?>">15:00 - 18:00</p>
                        <p class="<?= $cardPrice ?>">22,00 €</p>
                        <p class="<?= $cardNote ?>">Inkl. ein kleines Getränk</p>
                        <a href="/reservieren#/category/1/" class="Button_Book">Jetzt Buchen</a>
                    </div>
                </div>
                <div class="<?= $card ?>">
                    <h3 class="<?= $cardTitle ?>">Flatrate - Night Special</h3>
                    <div class="<?= $cardMedia ?>">
                        <img src="../Resources/NightSpecialIcon.webp" alt="NightSpecial" class="<?= $cardImage ?>" />
                    </div>
                    <div class="<?= $cardDetails ?>">
                        <p class="<?= $cardDate ?>">Freitag - Samstag</p>
                        <p class="<?= $cardText ?>">18:00 - 21:00</p>
                        <p class="<?= $cardPrice ?>">22,00 €</p>
                        <p class="<?= $cardNote ?>">Inkl. ein kleines Getränk</p>
                        <a href="/reservieren#/category/1/" class="Button_Book">Jetzt Buchen</a>
                    </div>
                </div>
                <div class="<?= $card ?>">
                    <h3 class="<?= $cardTitle ?>">Flatrate - Early Hour</h3>
                    <div class="<?= $cardMedia ?>">
                        <img src="../Resources/EarlyHourIcon.webp" alt="EarlyHour" class="<?= $cardImage ?>" />
                    </div>
                    <div class="<?= $cardDetails ?>">
                        <p class="<?= $cardDate ?>">Sonntags</p>
                        <p class="<?= $cardText ?>">11:00 - 14:00</p>
                        <p class="<?= $cardPrice ?>">20,00 €</p>
                        <p class="<?= $cardNote ?>">Inkl. einem Kaffee, Tee oder Kakao</p>
                        <a href="/reservieren#/category/1/" class="Button_Book">Jetzt Buchen</a>
                    </div>
                </div>
                <div class="<?= $card ?>">
                    <h3 class="<?= $cardTitle ?>">Flatrate - Late Hour</h3>
                    <div class="<?= $cardMedia ?>">
                        <img src="../Resources/LateHourIcon.webp" alt="LateHour" class="<?= $cardImage ?>" />
                    </div>
                    <div class="<?= $cardDetails ?>">
                        <p class="<?= $cardDate ?>">Sonntags</p>
                        <p class="<?= $cardText ?>">17:00 - 19:00</p>
                        <p class="<?= $cardPrice ?>">18,00 €</p>
                        <a href="/reservieren#/category/1/" class="Button_Book">Jetzt Buchen</a>
                    </div>
                </div>
            </div>
            <div class="<?= $infoBox ?>">
                <div class="<?= $infoContent ?>">
                    <h3 class="<?= $cardTitle ?>">Was ist der Unterschied zwischen FLATS und GEBURTSTAGS ANGEBOTEN?</h3>
                    <p>Die Flat ist dafür da, soviel Runden wie möglich zu spielen und seine Skills zu verbessern. Das Geburtstagsangebot ist dafür da, um in Gesellschaft bei Snacks, Essen und ein bisschen spielen, sich feiern zu lassen.</p>
                </div>
            </div>
            <div class="<?= $cardList ?>">
                <div class="<?= $card ?>">
                    <h3 class="<?= $cardTitle ?>">Geburtstags Angebot - Small</h3>
                    <div class="<?= $cardMedia ?>">
                        <img src="../Resources/SmallIcon.webp" alt="Small" class="<?= $cardImage ?>" />
                    </div>
                    <div class="<?= $cardDetails ?>">
                        <p class="<?= $cardDate ?>">2 Runden</p>
                        <p class="<?= $cardText ?>">+ ein kleines Getränk</p>
                        <p class="<?= $cardText ?>">+ ein kleinen Slushy für das Geburtstagskind</p>
                        <p class="<?= $cardPrice ?>">18,00 €</p>
                        <a href="/reservieren#/category/2/" class="Button_Book">Jetzt Buchen</a>
                    </div>
                </div>
                <div class="<?= $card ?>">
                    <h3 class="<?= $cardTitle ?>">Geburtstags Angebot - Large</h3>
                    <div class="<?= $cardMedia ?>">
                        <img src="../Resources/LargeIcon.webp" alt="Large" class="<?= $cardImage ?>" />
                    </div>
                    <div class="<?= $cardDetails ?>">
                        <p class="<?= $cardDate ?>">4 Runden</p>
                        <p class="<?= $cardText ?>">+ ein kleines Getränk</p>
                        <p class="<?= $cardText ?>">+ ein kleinen Slushy und Memberkarte für das Geburtstagskind</p>
                        <p class="<?= $cardPrice ?>">27,00 €</p>
                        <a href="/reservieren#/category/2/" class="Button_Book">Jetzt Buchen</a>
                    </div>
                </div>
            </div>
        </main>

        <?php include __DIR__ . '/../Resources/footer.php'; ?>
    </body>
</html>
