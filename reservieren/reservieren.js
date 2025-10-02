document.addEventListener("DOMContentLoaded", () => {
	SpecifyBookingURL();
	const iframe = document.getElementById("BookingFrame");
	const loader = document.getElementById("Loading");
	iframe.addEventListener("load", () => {
		loader.style.display = "none";
	});
});

function SpecifyBookingURL() {
	var Splitted = location.href.split("#");
	if (Splitted.length > 1) {
		var Extension = Splitted[1];
		document.getElementById("BookingFrame").src += Extension;
	}
}
