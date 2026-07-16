document.addEventListener("DOMContentLoaded", () => {
	SpecifyBookingURL();
	const iframe = document.getElementById("BookingFrame");
	const loader = document.getElementById("Loading");
	iframe.addEventListener("load", () => {
		loader.style.display = "none";
	});
});

function SpecifyBookingURL() {
	const offerId = new URLSearchParams(window.location.search).get("id");
	if (!offerId || !/^\d+$/.test(offerId)) return;

	const iframe = document.getElementById("BookingFrame");
	iframe.src = `${iframe.src.split("#")[0]}#book/service/${offerId}`;
}
