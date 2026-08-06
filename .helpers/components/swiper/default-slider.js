import Swiper from 'swiper';
import { Pagination } from 'swiper/modules';

import 'swiper/css';

const SELECTORS = {
	slider: '[data-services-slider]',
	wrapper: '[data-services-section]',
	pagination: '[data-services-pagination]',
};

Swiper.use([Pagination]);

const servicesSlider = () => {
	const $sliderWrappers = document.querySelectorAll(SELECTORS.wrapper);

	if (!$sliderWrappers.length) return;

	$sliderWrappers.forEach(($wrapper) => {
		const $slider = $wrapper.querySelector(SELECTORS.slider);
		const $pagination = $wrapper.querySelector(SELECTORS.pagination);

		const sliderInstance = new Swiper($slider, {
			observer: true,
			observeParents: true,
			speed: 800,
			pagination: {
				el: $pagination,
				type: 'bullets',
				clickable: true,
			},

			breakpoints: {
				320: {
					slidesPerView: 1,
				},
				1023: {
					slidesPerView: 3,
				},
			},
		});
	});
};

export default servicesSlider;
