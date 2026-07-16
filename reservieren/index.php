<!DOCTYPE html>
<html lang="de">

<head>
    <?php require '../resources/head.php'; ?>
    <link rel="stylesheet" href="reservieren.css" />
</head>

<body>
    <?php $currentPage = 'reservieren'; include '../resources/header.php'; ?>

    <main class="flex w-full flex-col items-center px-[100px] py-[25px] max-[1260px]:px-[15px] max-[775px]:px-[5px]">
        <section class="relative flex w-full max-w-[1180px] items-center justify-center overflow-hidden rounded-[28px] border border-white/10 bg-[var(--ContentBoxBackground)] shadow-[10px_10px_20px_black]">
            <span id="Loading" class="loader" aria-label="Buchung wird geladen"></span>
            <iframe
                id="BookingFrame"
                scrolling="yes"
                class="sb-widget-iframe w-full border-0"
                src="https://buchung.verden-lasertag.de/v2/?widget-type=iframe&theme=Concise&timeline=modern_week&datepicker=top_calendar#book"
                title="Buchungen"
            ></iframe>
        </section>
    </main>

    <?php include '../resources/footer.php'; ?>
    <script src="reservieren.js"></script>
</body>

</html>
