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
	document.getElementById("MainHeader").classList.toggle("MainHeader_Open");
}

document.addEventListener("click", (event) => {
	var MainHeader = document.getElementById("MainHeader");
	if (!MainHeader.contains(event.target)) {
		MainHeader.classList.remove("MainHeader_Open");
	}
});
