/**
 * Диверсанти — fullpage-інтро.
 * Прогрес скролу по секції (0..1) керує проявленням кадрів:
 * текстові кадри (кросфейд впритул) → фото ляльки → заголовок «Завербовані діти».
 */

// Вікна кадрів ВПРИТУЛ (кінець одного = початок наступного): без чорних пауз між текстами.
const LINE_WINDOWS = [
	null, // кадр 0 — видимий одразу, лише згасає
	[0.12, 0.25],
	[0.25, 0.38],
	[0.38, 0.51],
];
const LINE0_OUT = [0.04, 0.12];
const LINE_FADE = 0.3;
const PHOTO_IN = [0.53, 0.68];
const TITLE_IN = [0.72, 0.84];

const clamp = (value, min, max) => (value < min ? min : value > max ? max : value);

const smoothstep = (a, b, x) => {
	if (a === b) return x < a ? 0 : 1;
	const t = clamp((x - a) / (b - a), 0, 1);
	return t * t * (3 - 2 * t);
};

// Трапеція: 0 → 1 (тримає) → 0 у межах вікна [a, b]
const trapezoid = (p, a, b, fade) => {
	if (p <= a || p >= b) return 0;
	const up = smoothstep(a, a + (b - a) * fade, p);
	const down = 1 - smoothstep(b - (b - a) * fade, b, p);
	return Math.min(up, down);
};

const diversantyIntro = () => {
	const root = document.querySelector('[data-diversanty-intro]');
	if (!root) return;

	const lines = Array.from(root.querySelectorAll('[data-diversanty-frame]'));
	const photo = root.querySelector('[data-diversanty-photo]');
	const title = root.querySelector('[data-diversanty-title]');
	const hint = root.querySelector('[data-diversanty-hint]');

	let ticking = false;

	const render = () => {
		ticking = false;

		const scrollable = root.offsetHeight - window.innerHeight;
		if (scrollable <= 0) return;
		const scrolled = clamp(-root.getBoundingClientRect().top, 0, scrollable);
		const p = scrolled / scrollable;

		// текстові кадри
		lines.forEach((line, i) => {
			let op;
			if (i === 0) {
				op = 1 - smoothstep(LINE0_OUT[0], LINE0_OUT[1], p);
			} else {
				const [a, b] = LINE_WINDOWS[i];
				op = trapezoid(p, a, b, LINE_FADE);
			}
			line.style.opacity = op.toFixed(3);
			line.style.transform = `translate(-50%, calc(-50% + ${((1 - op) * 14).toFixed(1)}px))`;
		});

		// фото: проявляється й лишається, легкий зум 1.06 → 1.0
		if (photo) {
			const pIn = smoothstep(PHOTO_IN[0], PHOTO_IN[1], p);
			photo.style.opacity = pIn.toFixed(3);
			photo.style.transform = `scale(${(1.06 - 0.06 * pIn).toFixed(4)})`;
		}

		// заголовок: проявляється поверх фото й лишається
		if (title) {
			const tIn = smoothstep(TITLE_IN[0], TITLE_IN[1], p);
			title.style.opacity = tIn.toFixed(3);
			title.style.transform = `translate(-50%, calc(-50% + ${((1 - tIn) * 22).toFixed(1)}px))`;
		}

		// підказка «прокрутіть» — зникає одразу після початку скролу
		if (hint) hint.style.opacity = (1 - smoothstep(0, 0.06, p)).toFixed(3);
	};

	const onScroll = () => {
		if (ticking) return;
		ticking = true;
		window.requestAnimationFrame(render);
	};

	window.addEventListener('scroll', onScroll, { passive: true });
	window.addEventListener('resize', onScroll);
	render();
};

export default diversantyIntro;
