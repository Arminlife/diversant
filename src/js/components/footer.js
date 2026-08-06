const footer = () => {
	const SELECTORS = {
		scrollUp: '.js-footer-scrollup',
		copyBtn: '.js-copy-btn',
	};

	const $scrollUp = document.querySelectorAll(SELECTORS.scrollUp);

	$scrollUp.forEach((btn) => {
		btn.addEventListener('click', (e) => {
			e.preventDefault();
			window.scrollTo({ top: 0, behavior: 'smooth' });
		});
	});
};

export default footer;
