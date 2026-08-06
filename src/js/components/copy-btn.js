const copyBtn = () => {
	const SELECTORS = {
		copyBtn: '.js-copy-btn',
	};

	const CLASS_NAMES = {
		copyBtnActive: 'active_mod',
	};

	const $copyBtn = document.querySelectorAll(SELECTORS.copyBtn);

	$copyBtn.forEach((btn) => {
		btn.addEventListener('click', (e) => {
			e.preventDefault();
			const textToCopy = btn.dataset.copy;
			window.navigator.clipboard.writeText(textToCopy);
			btn.classList.add(CLASS_NAMES.copyBtnActive);

			setTimeout(() => {
				btn.classList.remove(CLASS_NAMES.copyBtnActive);
			}, 300);
		});
	});
};

export default copyBtn;
