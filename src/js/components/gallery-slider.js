import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';

import 'swiper/css';

const SELECTORS = {
	slider: '[data-gallery-slider]',
	wrapper: '[data-gallery-section]',
	prevArrow: '[data-gallery-prev-arrow]',
	nextArrow: '[data-gallery-next-arrow]',
};

Swiper.use([Navigation]);

const gallerySlider = () => {
	const $sliderWrappers = document.querySelectorAll(SELECTORS.wrapper);

	if (!$sliderWrappers.length) return;

	$sliderWrappers.forEach(($wrapper) => {
		const $slider = $wrapper.querySelector(SELECTORS.slider);
		const $prevArrow = $wrapper.querySelector(SELECTORS.prevArrow);
		const $nextArrow = $wrapper.querySelector(SELECTORS.nextArrow);

		const sliderInstance = new Swiper($slider, {
			observer: true,
			observeParents: true,
			speed: 800,
			slidesPerView: 'auto',
			navigation: {
				prevEl: $prevArrow,
				nextEl: $nextArrow,
			},
		});
	});
};
window.initGallerySwiper = gallerySlider;
export default gallerySlider;
