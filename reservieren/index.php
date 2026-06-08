<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Lasertag Verden</title>
		<link rel="icon" type="image/png" sizes="32x32" href="../Resources/favicon-32x32.png" />
		<link rel="icon" type="image/png" sizes="16x16" href="../Resources/favicon-16x16.png" />
		<link rel="stylesheet" href="../Shared.css" />
		<link rel="stylesheet" href="reservieren.css" />
		<script src="../Shared.js"></script>
		<script src="reservieren.js"></script>
	</head>
	<body>
		<?php $currentPage = 'reservieren'; include __DIR__ . '/../Resources/header.php'; ?>

		<main>
			<!-- src="https://buchung.verden-lasertag.de/v2/?widget-type=iframe&timeline=modern_week&datepicker=top_calendar#book" -->
			<span id="Loading" class="loader"></span>
			<iframe
				id="BookingFrame"
				scrolling="yes"
				class="sb-widget-iframe"
				width="100%"
				src="https://buchung.verden-lasertag.de/v2/?widget-type=iframe&theme=Concise&timeline=modern_week&datepicker=top_calendar#book"
				frameborder="0"
				title="Buchungen"
			></iframe>
		</main>

		<?php include __DIR__ . '/../Resources/footer.php'; ?>
	</body>
</html>
