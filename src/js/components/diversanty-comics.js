/**
 * Диверсанти — слайдер коміксу.
 * Десктоп: 2 слайди у в'юпорті, гортання по 2. Мобілка: 1 слайд, по 1.
 */
import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';

import 'swiper/css';

const SELECTORS = {
	section: '[data-diversanty-comics]',
	slider: '[data-diversanty-comics-slider]',
	prev: '[data-diversanty-comics-prev]',
	next: '[data-diversanty-comics-next]',
};

Swiper.use([Navigation]);

const diversantyComics = () => {
	const $sections = document.querySelectorAll(SELECTORS.section);
	if (!$sections.length) return;

	$sections.forEach(($section) => {
		const $slider = $section.querySelector(SELECTORS.slider);
		if (!$slider) return;

		// eslint-disable-next-line no-new
		new Swiper($slider, {
			observer: true,
			observeParents: true,
			speed: 600,
			slidesPerView: 1,
			slidesPerGroup: 1,
			spaceBetween: 20,
			navigation: {
				prevEl: $section.querySelector(SELECTORS.prev),
				nextEl: $section.querySelector(SELECTORS.next),
			},
			breakpoints: {
				768: {
					slidesPerView: 2,
					slidesPerGroup: 2,
					spaceBetween: 30,
				},
			},
		});
	});
};

export default diversantyComics;
