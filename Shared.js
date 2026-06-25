(function () {
	const MAX_W = 150; // px at the very top
	const MIN_W = 100; // px when fully shrunk
	const RANGE = 200; // px of scroll needed to reach MIN_W

	let ticking = false;

	function clamp(n, min, max) {
		return Math.max(min, Math.min(max, n));
	}

	function update() {
		const y = window.scrollY || window.pageYOffset;
		const p = clamp(y / RANGE, 0, 1);
		const w = Math.round(MAX_W - (MAX_W - MIN_W) * p);
		document.documentElement.style.setProperty("--logo-w", w + "px");
		ticking = false;
	}

	window.addEventListener(
		"scroll",
		() => {
			if (!ticking) {
				ticking = true;
				requestAnimationFrame(update);
			}
		},
		{ passive: true }
	);

	update();
})();

function ToggleMainHeader() {
	document.getElementById("FixedHeaderContent").classList.toggle("!translate-y-0");
	document.getElementById("HeaderToggleIcon").classList.toggle("!translate-y-[4px]");
	document.getElementById("HeaderToggleIcon").classList.toggle("!-rotate-[135deg]");
}

document.addEventListener("click", (event) => {
	var MainHeader = document.getElementById("MainHeader");
	if (!MainHeader.contains(event.target)) {
		document.getElementById("FixedHeaderContent").classList.remove("!translate-y-0");
		document.getElementById("HeaderToggleIcon").classList.remove("!translate-y-[4px]");
		document.getElementById("HeaderToggleIcon").classList.remove("!-rotate-[135deg]");
	}
});

document.addEventListener("DOMContentLoaded", () => {
	const nav = document.getElementById("HeaderNavigation");
	if (nav) {
		const links = Array.from(nav.querySelectorAll(".Nav_Link"));
		const active = nav.querySelector(".Nav_Link.is-active");

		const moveUnderline = (link) => {
			if (!link) {
				nav.style.setProperty("--nav-underline-width", "0px");
				return;
			}
			const navBox = nav.getBoundingClientRect();
			const linkBox = link.getBoundingClientRect();
			nav.style.setProperty("--nav-underline-left", linkBox.left - navBox.left + "px");
			nav.style.setProperty("--nav-underline-width", linkBox.width + "px");
		};

		links.forEach((link) => {
			link.addEventListener("mouseenter", () => moveUnderline(link));
			link.addEventListener("focus", () => moveUnderline(link));
		});

		nav.addEventListener("mouseleave", () => moveUnderline(active));
		window.addEventListener("resize", () => moveUnderline(active));
		moveUnderline(active);
	}

	document.querySelectorAll("[data-copy-value]").forEach((button) => {
		const originalText = button.textContent;
		button.addEventListener("click", async () => {
			try {
				await navigator.clipboard.writeText(button.dataset.copyValue);
				button.textContent = "kopiert";
				button.classList.add("text-[#73ffff]", "border-[#73ffff]");
				window.setTimeout(() => {
					button.textContent = originalText;
					button.classList.remove("text-[#73ffff]", "border-[#73ffff]");
				}, 1400);
			} catch (error) {
				button.textContent = "nicht kopiert";
				window.setTimeout(() => (button.textContent = originalText), 1400);
			}
		});
	});
});
