<!DOCTYPE html>
<html lang="de">
	<head>
		<?php require '../resources/head.php'; ?>
	</head>
	<body>
		<?php $currentPage = 'uber-uns'; include '../resources/header.php'; ?>

		<main class="mx-auto flex w-full max-w-[1000px] flex-col gap-6 px-[15px] py-[25px]">
			<section class="rounded-[28px] border border-[#00aaaa]/45 bg-[var(--ContentBoxBackground)] p-7 shadow-[10px_10px_20px_black] max-[700px]:p-5">
				<p class="text-sm uppercase tracking-[0.24em] text-[#73ffff]">Über uns</p>
				<h1 class="mt-2 text-[42px] uppercase leading-tight max-[700px]:text-[32px]">LaserTag Verden</h1>
				<p class="mt-4 font-[Arial,Helvetica,sans-serif] text-xl leading-8 text-white/90 max-[700px]:text-lg">
					Wir sind Teil der Laserforce Familie und bringen moderne Lasertag-Action nach Verden. Bei uns geht es um Bewegung, Teamplay und Runden, die sich jedes Mal anders anfühlen.
				</p>
			</section>

			<section class="grid grid-cols-3 gap-5 max-[850px]:grid-cols-1">
				<article class="rounded-[24px] border border-white/10 bg-[#2a2a2a] p-5 shadow-[10px_10px_20px_black]">
					<h2 class="text-[28px] text-[#73ffff]">Für Gruppen</h2>
					<p class="mt-3 font-[Arial,Helvetica,sans-serif] text-lg leading-7 text-white/85">Freunde, Familien, Schulklassen, Vereine und Firmen finden bei uns ein aktives Erlebnis statt Standardprogramm.</p>
				</article>
				<article class="rounded-[24px] border border-white/10 bg-[#2a2a2a] p-5 shadow-[10px_10px_20px_black]">
					<h2 class="text-[28px] text-[#73ffff]">Für Events</h2>
					<p class="mt-3 font-[Arial,Helvetica,sans-serif] text-lg leading-7 text-white/85">Geburtstage, Weihnachtsfeiern, Junggesellenabschiede oder Teamtage können nach Absprache auch außerhalb der Öffnungszeiten stattfinden.</p>
				</article>
				<article class="rounded-[24px] border border-white/10 bg-[#2a2a2a] p-5 shadow-[10px_10px_20px_black]">
					<h2 class="text-[28px] text-[#73ffff]">Für Action</h2>
					<p class="mt-3 font-[Arial,Helvetica,sans-serif] text-lg leading-7 text-white/85">Laserforce bietet verschiedene Spielmodi. Ihr spielt taktisch, bewegt euch durch die Arena und verbessert Runde für Runde eure Skills.</p>
				</article>
			</section>

			<section class="rounded-[28px] border border-white/10 bg-[var(--ContentBoxBackground)] p-7 text-center shadow-[10px_10px_20px_black] max-[700px]:p-5">
				<h2 class="text-[34px] leading-tight">Bereit für eure Runde?</h2>
				<p class="mx-auto mt-3 max-w-[720px] font-[Arial,Helvetica,sans-serif] text-lg leading-7 text-white/85">Wenn ihr Fragen zur Gruppengröße, Buchung oder passenden Spielmodi habt, meldet euch gern. Team LaserTag Verden freut sich auf euch.</p>
				<div class="mt-6 flex flex-wrap justify-center gap-3 text-xl">
					<a class="rounded-md border border-white/35 bg-white/10 px-7 py-3 text-white no-underline transition hover:bg-white/20" href="../infos/#spiel-color-conquest">Spielmodi ansehen</a>
					<a class="Button_Book Pulse_CTA px-7 py-3" href="../kontakt/">Halle buchen</a>
				</div>
			</section>
		</main>

		<?php include '../resources/footer.php'; ?>
	</body>
</html>
