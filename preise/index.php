<!DOCTYPE html>
<?php
$section = 'w-full max-w-[1180px]';
$panel = 'rounded-[25px] border border-white/10 bg-[var(--ContentBoxBackground)] shadow-[10px_10px_20px_black]';
$eyebrow = 'text-sm uppercase tracking-[0.24em] text-[#73ffff]';
$bodyText = 'font-[Arial,Helvetica,sans-serif] text-lg leading-7 text-white/90 max-[775px]:text-base';

?>
<html lang="de">
	<head>
		<?php require '../resources/head.php'; ?>
	</head>
	<body>
		<?php $currentPage = 'preise'; include '../resources/header.php'; ?>

		<main class="flex flex-col items-center gap-8 px-[100px] py-[25px] max-[1260px]:px-[15px] max-[775px]:px-[5px]">
			<section class="<?= $section ?> <?= $panel ?> overflow-hidden">
				<div class="bg-[radial-gradient(circle_at_top_left,rgba(0,170,170,0.28),transparent_48%),rgba(0,0,0,0.18)] p-6 max-[775px]:p-4">
					<p class="<?= $eyebrow ?>">Preise & Angebote</p>
					<h1 class="mt-2 text-[42px] leading-tight max-[775px]:text-[32px]">Unsere Angebote</h1>
					<p class="<?= $bodyText ?> mt-4 max-w-[780px]">Wählt das passende Angebot für eure Gruppe und startet anschließend direkt mit der Reservierung.</p>
				</div>
			</section>

			<div class="<?= $section ?> flex items-center gap-3 rounded-2xl border border-[#00aaaa]/35 bg-[#00aaaa]/10 p-4 font-[Arial,Helvetica,sans-serif] text-sm text-[#73ffff]" data-services-loading role="status">
				<span class="inline-block h-4 w-4 animate-spin rounded-full border-2 border-[#73ffff]/30 border-t-[#73ffff]"></span>
				Angebote werden aktualisiert...
			</div>
			<div class="<?= $section ?> hidden" data-offer-sections hidden></div>
		</main>

		<?php include '../resources/footer.php'; ?>
		<script>
			document.addEventListener("DOMContentLoaded", () => {
				const loading = document.querySelector("[data-services-loading]");
				const sections = document.querySelector("[data-offer-sections]");
				const element = (tag, className, text) => {
					const node = document.createElement(tag);
					node.className = className;
					if (text) node.textContent = text;
					return node;
				};

				const renderOffers = (services, categories) => {
					const grouped = new Map();
					services.forEach((service) => {
						const category = categories[service.category] ? service.category : "other";
						grouped.set(category, [...(grouped.get(category) || []), service]);
					});
					sections.replaceChildren();
					Object.entries(categories).forEach(([categoryId, category]) => {
						const offers = grouped.get(categoryId) || [];
						if (!offers.length) return;
						const section = element("section", "mb-8 w-full");
						const heading = element("div", "mb-4");
						heading.append(element("p", "text-sm uppercase tracking-[0.24em] text-[#73ffff]", category.eyebrow));
						heading.append(element("h2", "text-[30px] leading-tight max-[775px]:text-[25px]", category.title));
						section.append(heading);
						const grid = element("div", "grid grid-cols-2 gap-5 max-[900px]:grid-cols-1");
						offers.forEach((service) => {
							const card = element("article", "flex min-h-[250px] flex-col overflow-hidden rounded-[25px] border border-white/10 bg-[var(--ContentBoxBackground)] shadow-[10px_10px_20px_black]");
							const header = element("div", "flex items-start justify-between gap-4 border-b border-white/10 p-5 max-[520px]:flex-col");
							const title = document.createElement("div");
							const label = service.label || service.duration;
							if (label) title.append(element("p", "inline-flex w-fit rounded-full border border-[#00aaaa] px-3 py-1 font-[Arial,Helvetica,sans-serif] text-sm text-white/90", label));
							title.append(element("h3", "mt-3 text-[26px] leading-tight max-[775px]:text-[22px]", service.title || "Angebot"));
							header.append(title);
							if (service.price) {
								const price = element("p", "whitespace-nowrap text-right text-[30px] leading-none text-[#73ffff] max-[520px]:text-left", service.price);
								if (service.priceNote) price.append(element("span", "mt-1 block text-base text-white/80", service.priceNote));
								header.append(price);
							}
							card.append(header);
							const content = element("div", "flex flex-1 flex-col justify-between gap-5 p-5");
							if (service.description) {
								const description = element("div", "space-y-2 font-[Arial,Helvetica,sans-serif] text-lg leading-7 text-white/90 max-[775px]:text-base");
								description.innerHTML = service.description;
								content.append(description);
							}
							const actions = element("div", "mt-auto flex flex-col gap-3");
							if (service.note) actions.append(element("p", "w-full rounded-xl border border-[#73ffff]/35 bg-[#73ffff]/10 p-3 font-[Arial,Helvetica,sans-serif] text-sm leading-6 text-white/90", "Hinweis: " + service.note));
							const book = element("a", "Button_Book self-start", "Jetzt buchen");
							book.href = "../reservieren/?id=" + encodeURIComponent(service.id);
							actions.append(book);
							content.append(actions);
							card.append(content);
							grid.append(card);
						});
						section.append(grid);
						sections.append(section);
					});
				};

				fetch("services.php?request=" + Date.now(), { cache: "no-store" })
					.then(async (response) => {
						const data = JSON.parse(await response.text());
						if (!response.ok || data.error) throw new Error(data.error || "Angebote konnten nicht aktualisiert werden.");
						if (!data.services?.length) throw new Error("Es sind aktuell keine Angebote verfügbar.");
						renderOffers(data.services, data.categories || {});
						sections.hidden = false;
						sections.classList.remove("hidden");
						loading.remove();
					})
					.catch((error) => {
						loading.textContent = "Angebote konnten nicht aktualisiert werden: " + error.message;
						loading.classList.remove("border-[#00aaaa]/35", "bg-[#00aaaa]/10", "text-[#73ffff]");
						loading.classList.add("border-red-400/50", "bg-red-950/30", "text-red-100");
					});
			});
		</script>
	</body>
</html>
