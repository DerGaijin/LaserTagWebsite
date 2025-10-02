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
		// thumbnailDisplayTransition: "flipUp", // thumbnail display animation
		// thumbnailDisplayTransitionDuration: 400,
		// thumbnailDisplayInterval: 200,
		// thumbnailDisplayOrder: "rowByRow",

		// THUMBNAIL'S HOVER ANIMATION
		// thumbnailHoverEffect2: "toolsSlideUp|labelSlideDown",
		// touchAnimation: true,
		// touchAutoOpenDelay: -1,

		// GALLERY THEME
		// galleryTheme: {
		// 	thumbnail: { titleShadow: "none", descriptionShadow: "none", titleColor: "#fff", borderColor: "#fff" },
		// },
	});
});
