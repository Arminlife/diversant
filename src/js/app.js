import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css';

import { calcViewportHeight, documentReady, onWindowResize, pageLoad } from './utils';

import Accordion from './components/accordion';
import mapInit from './components/map';
import gallerySlider from './components/gallery-slider';
import header from './components/header';
import imageUpload from './components/image-upload';
import footer from './components/footer';
import copyBtn from './components/copy-btn';
import audioplayer from './components/audioplayer';
import diversantyIntro from './components/diversanty-intro';
import diversantyComics from './components/diversanty-comics';
import diversantyFigures from './components/diversanty-figures';
import diversantyGame from './components/diversanty-game';
import diversantyMosaic from './components/diversanty-mosaic';

const app = () => {
	onWindowResize(() => {
		calcViewportHeight();
	});
	calcViewportHeight();

	pageLoad(() => {
		document.body.classList.add('body--loaded');
	});

	header();
	mapInit();
	gallerySlider();
	imageUpload();
	footer();
	copyBtn();
	audioplayer();
	diversantyIntro();
	diversantyComics();
	diversantyFigures();
	diversantyGame();
	diversantyMosaic();

	const accordion = Accordion({
		triggers: document.querySelectorAll('.js-map-accordion-trigger'),
		activeStateName: 'map_popup__filter--active-mod',
	});

	// window.markerClickHandler = (id) => {
	// 	console.log('MARKER CLICKED');
	// 	console.log(id);
	// };

	// # fix later
	Array.from(document.querySelectorAll('a'))
		.filter((el) => el.textContent.trim() === 'Спецпроекти')
		.forEach((el) => {
			el.textContent = 'Спецпроєкти';
		});

	document.querySelectorAll('[data-tooltip]').forEach((el) => {
		tippy(el, {
			content: el.getAttribute('data-tooltip') || '',
		});
	});

	// # videos posters
	const vsd = document.querySelectorAll('video.wp-video-shortcode');

	vsd.forEach((video) => {
		// Додаємо атрибут playsinline для iOS
		video.setAttribute('playsinline', '');

		const sources = video.querySelectorAll('source');

		sources.forEach((source) => {
			let src = source.getAttribute('src');

			if (src && !src.includes('#t=')) {
				source.setAttribute('src', src + '#t=0.001');
			}
		});

		video.load();
	});
};

documentReady(() => {
	app();
});
