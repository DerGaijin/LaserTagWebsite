document.addEventListener("DOMContentLoaded", () => {
	const icons = document.querySelectorAll(".MH_Burger");
	icons.forEach((icon) => {
		icon.addEventListener("click", (event) => {
			icon.classList.toggle("MH_Burger_Open");
		});
	});

	const MH_MenuToggle = document.getElementById("MH_MenuToggle");
	MH_MenuToggle.addEventListener("click", (event) => {
		const MainHeader = document.getElementById("MainHeader");
		MainHeader.classList.toggle("MainHeader_Open");
	});

	icons.forEach((icon) => {
		icon.addEventListener("click", (event) => {
			icon.classList.toggle("open");
		});
	});
});
