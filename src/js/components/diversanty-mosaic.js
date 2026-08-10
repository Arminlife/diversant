/**
 * Диверсанти — слайдер «Мозаїка матеріалів».
 * Кожен слайд = колонка з 2 карток. Десктоп: 3 колонки (=6 карток), гортання по 3.
 * Мобілка: 1 колонка (=2 картки), по 1.
 */
import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';

import 'swiper/css';

const SELECTORS = {
	section: '[data-diversanty-mosaic]',
	slider: '[data-diversanty-mosaic-slider]',
	prev: '[data-diversanty-mosaic-prev]',
	next: '[data-diversanty-mosaic-next]',
};

Swiper.use([Navigation]);

const diversantyMosaic = () => {
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
			spaceBetween: 0,
			navigation: {
				prevEl: $section.querySelector(SELECTORS.prev),
				nextEl: $section.querySelector(SELECTORS.next),
			},
			breakpoints: {
				768: {
					slidesPerView: 2,
					slidesPerGroup: 2,
					spaceBetween: 0,
				},
				1024: {
					slidesPerView: 3,
					slidesPerGroup: 3,
					spaceBetween: 0,
				},
			},
		});
	});
};

export default diversantyMosaic;
