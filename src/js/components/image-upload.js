const imageUpload = () => {
	const SELECTORS = {
		field: '.js-image-upload',
		input: '.js-image-upload-input',
		gallery: '.js-image-upload-gallery',
	};
	const fileInput = document.querySelector(SELECTORS.input);
	const gallery = document.querySelector(SELECTORS.gallery);

	if (!fileInput || !gallery) return;

	fileInput?.addEventListener('change', (event) => {
		gallery.innerHTML = '';

		const files = event.target.files;

		if (files.length > 0) {
			Array.from(files).forEach((file) => {
				if (file.type.startsWith('image/')) {
					const reader = new window.FileReader();

					reader.onload = (e) => {
						const img = document.createElement('img');
						img.src = e.target.result;
						img.classList.add('image-preview');
						img.alt = `Загруженне зображення: ${file.name}`;

						gallery.appendChild(img);
					};

					reader.readAsDataURL(file);
				}
			});
		}
	});
};

export default imageUpload;
