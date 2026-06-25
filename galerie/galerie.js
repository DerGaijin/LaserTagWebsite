document.addEventListener("DOMContentLoaded", () => {
	jQuery("#ImageGallery").nanogallery2({
		dataProvider: "/",

		// GALLERY AND THUMBNAIL LAYOUT
		thumbnailHeight: "500",
		thumbnailWidth: "auto",
		thumbnailAlignment: "fillWidth",
		thumbnailL1GutterWidth: 20,
		thumbnailL1GutterHeight: 20,
		thumbnailBorderHorizontal: 0,
		thumbnailBorderVertical: 0,

		// DISPLAY ANIMATION
		thumbnailDisplayTransition: "flipUp",
		thumbnailDisplayTransitionDuration: 400,
		thumbnailDisplayInterval: 120,
		thumbnailDisplayOrder: "rowByRow",

		// THUMBNAIL'S HOVER ANIMATION
		thumbnailHoverEffect2: "imageScale150|imageSepiaOff|toolsSlideUp|labelSlideDown|borderLighter",
		touchAnimation: true,
		touchAutoOpenDelay: -1,

		// GALLERY THEME
		galleryTheme: {
			thumbnail: { titleShadow: "none", descriptionShadow: "none", titleColor: "#fff", borderColor: "#73ffff" },
		},
	});
});
