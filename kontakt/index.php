<!DOCTYPE html>
<html lang="de">
    <head>
        <?php require '../resources/head.php'; ?>
    </head>
    <body>
        <?php $currentPage = 'kontakt'; include '../resources/header.php'; ?>

        <main class="grid max-w-[1200px] grid-cols-3 grid-rows-[0fr_1fr] gap-2.5 justify-self-center px-[5px] py-[25px] max-[850px]:grid-cols-1 max-[850px]:grid-rows-[1fr_1fr_1fr_2fr] max-[850px]:justify-self-auto">
            <div class="flex flex-col items-center rounded-[15px] bg-[#2a2a2a] p-2.5 text-center">
                <img src="../resources/LocationIcon.webp" alt="Location" class="w-[50px]" />
                <h2 class="p-2.5 pt-5 text-[24px] font-bold">Adresse</h2>
                <p class="flex items-center p-[5px] font-[Arial,Helvetica,sans-serif] text-inherit no-underline">Bernhard-Warnecke-Straße 5</p>
                <p class="flex items-center p-[5px] font-[Arial,Helvetica,sans-serif] text-inherit no-underline">27283 Verden</p>
            </div>
            <div class="flex flex-col items-center rounded-[15px] bg-[#2a2a2a] p-2.5 text-center">
                <img src="../resources/BlackPhoneIcon.webp" alt="Phone" class="w-[50px] invert" />
                <h2 class="p-2.5 pt-5 text-[24px] font-bold">Kontakt</h2>
                <a href="tel:+491723834147" class="flex items-center p-[5px] font-[Arial,Helvetica,sans-serif] text-inherit no-underline">
                    <p>Telefon: <b class="underline">+49 172 3834147</b></p>
                    <img src="../resources/PhoneIcon.webp" alt="PhoneIcon" class="ml-[5px] h-[25px] w-[25px]" />
                </a>
                <a href="https://wa.me/+491723834147" class="flex items-center p-[5px] font-[Arial,Helvetica,sans-serif] text-inherit no-underline">
                    <p>Auch gerne per <b class="underline">Whatsapp</b></p>
                    <img src="../resources/WhatsappIcon.webp" alt="WhatsappIcon" class="ml-[5px] h-[25px] w-[25px]" />
                </a>
                <a href="mailto:allgemein@verden-lasertag.de" class="flex items-center p-[5px] font-[Arial,Helvetica,sans-serif] text-inherit no-underline">
                    <p>E-Mail: <b class="underline">allgemein@verden-lasertag.de</b></p>
                    <img src="../resources/email.png" alt="EMailIcon" class="ml-[5px] h-[25px] w-[25px]" />
                </a>
            </div>
            <div class="flex flex-col items-center rounded-[15px] bg-[#2a2a2a] p-2.5 text-center">
                <img src="../resources/ClockIcon.webp" alt="Time" class="w-[50px] invert" />
                <h2 class="p-2.5 pt-5 text-[24px] font-bold">Telefonische<br />Erreichbarkeit</h2>
                <div id="TimingTable" class="grid grid-cols-2">
                    <p class="flex items-center p-[5px] font-[Arial,Helvetica,sans-serif] text-inherit no-underline">Dienstag-Freitag:</p>
                    <p class="flex items-center p-[5px] font-[Arial,Helvetica,sans-serif] text-inherit no-underline">13:00-18:00</p>
                    <p class="flex items-center p-[5px] font-[Arial,Helvetica,sans-serif] text-inherit no-underline">Samstag & Sonntag:</p>
                    <!-- <p class="flex items-center p-[5px] font-[Arial,Helvetica,sans-serif] text-inherit no-underline">10:30-18:00</p> -->
                    <p class="flex items-center p-[5px] font-[Arial,Helvetica,sans-serif] text-inherit no-underline">13:00-18:00</p>
                </div>
            </div>

            <iframe
                class="col-span-3 flex flex-col items-center rounded-[15px] bg-[#2a2a2a] p-2.5 text-center max-[850px]:col-span-1"
                data-cmp-vendor="s1104"
                data-cmp-src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2405.870322787447!2d9.2389109!3d52.914761899999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47b0e4cd17fe60cd%3A0xc61486b665dfc8c!2sBernhard-Warnecke-Stra%C3%9Fe%205%2C%2027283%20Verden%20(Aller)%2C%20Deutschland!5e0!3m2!1sde!2s!4v1701259019377!5m2!1sde!2s"
                width="100%"
                height="100%"
                style="border: 0"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                data-cmp-done="1"
                data-cmp-ab="1"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2405.870322787447!2d9.2389109!3d52.914761899999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47b0e4cd17fe60cd%3A0xc61486b665dfc8c!2sBernhard-Warnecke-Stra%C3%9Fe%205%2C%2027283%20Verden%20(Aller)%2C%20Deutschland!5e0!3m2!1sde!2s!4v1701259019377!5m2!1sde!2s"
                data-cmp-activated="1"
            ></iframe>
        </main>

        <?php include '../resources/footer.php'; ?>
    </body>
</html>
