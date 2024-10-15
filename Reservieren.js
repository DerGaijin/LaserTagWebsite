document.addEventListener("DOMContentLoaded", SpecifyBookingURL);

function SpecifyBookingURL() {
  var Splitted = location.href.split("#");
  if (Splitted.length > 1) {
    var Extension = Splitted[1];
    document.getElementById("BookingFrame").src += Extension;
    console.log(Extension);
  }
}
