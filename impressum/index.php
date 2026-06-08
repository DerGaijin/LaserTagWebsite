<!DOCTYPE html>
<html lang="de">
	<head>
		<?php require __DIR__ . '/../resources/head.php'; ?>
	</head>
	<body>
		<?php include __DIR__ . '/../Resources/header.php'; ?>

		<main class="flex max-w-[900px] flex-col items-center justify-center justify-self-center px-[5px] py-[25px]">
			<div class="flex flex-col rounded-[25px] bg-[var(--ContentBoxBackground)] p-5 font-[Arial,Helvetica,sans-serif] shadow-[10px_10px_20px_black] [&_h2]:pb-2.5 [&_h2]:text-[26px] [&_h2]:font-bold [&_p]:pt-[5px]">
				<h2>Impressum</h2>
				<p>Lasertag Verden Debora Dobias</p>
				<p>Bernhard-Warnecke-Straße, 5 27283 Verden, Deutschland</p>
				<p>Telefon: +49 172 3834147</p>
				<p>Mail: allgemein@verden-lasertag.de</p>
				<p>Umsatzsteuer-Identifikationsnummer(n): DE357198234</p>
				<p>
					Die Europäische Kommission stellt eine Plattform zur Online-Streitbeilegung (OS) bereit, die Sie hier finden https://ec.europa.eu/consumers/odr/. Zur Teilnahme an einem
					Streitbeilegungsverfahren vor einer Verbraucherschlichtungsstelle sind wir nicht verpflichtet und nicht bereit.
				</p>
			</div>
		</main>

		<?php $currentFooter = 'impressum'; include __DIR__ . '/../Resources/footer.php'; ?>
	</body>
</html>
