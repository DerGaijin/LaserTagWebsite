<!DOCTYPE html>
<html lang="de">
	<head>
		<?php require '../resources/head.php'; ?>
		<link rel="stylesheet" href="reservieren.css" />
		<script src="reservieren.js"></script>
	</head>
	<body>
		<?php $currentPage = 'reservieren'; include '../resources/header.php'; ?>

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

		<?php include '../resources/footer.php'; ?>
	</body>
</html>
