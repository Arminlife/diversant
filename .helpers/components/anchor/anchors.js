import gsap from 'gsap';
import { ScrollToPlugin } from 'gsap/dist/ScrollToPlugin';
import { ScrollTrigger } from 'gsap/dist/ScrollTrigger';

gsap.registerPlugin(ScrollToPlugin, ScrollTrigger);

export function anchorScroll() {
	// const { gsap, ScrollTrigger, ScrollToPlugin } = window;
	const SELECTORS = {
		anchor: 'a',
		inner: '.js-horizontal-inner',
	};

	const CLASSNAMES = {
		redirectMod: 'js-anchor--redirect',
	};

	const KNOWN_HASHES = {
		contact: 'contact',
		home: 'home',
		hero: 'hero',
	};

	const $anchors = document.querySelectorAll(SELECTORS.anchor);
	let currentTween = null;

	const calcAdditionalOffset = ($target, { id }) => {
		const isHomeScroll = id === 'home' || id === 'hero';

		const homeYPosition = isHomeScroll ? 0 : null;
		const scrollPos = homeYPosition;

		return scrollPos;
	};

	const checkIsSameLocation = (target) => {
		const currentLocation = new URL(window.location.href);
		const currentLocationURL = currentLocation.origin + currentLocation.pathname;

		const targetLocation = new URL(target.href, window.location.href);
		const targetLocationURL = targetLocation.origin + targetLocation.pathname;

		const isSameLocation = currentLocationURL === targetLocationURL;

		return isSameLocation;
	};

	const goTo = (config) => {
		const { id, additionalOffset, e, instant } = config;

		const $target = document.querySelector(`[data-id="${id}"`);
		const isHomeScroll = id === KNOWN_HASHES.home || id === KNOWN_HASHES.hero;
		const isContact = id === KNOWN_HASHES.contact;

		if (!checkIsSameLocation(config)) {
			window.location.href = config.href;
			return;
		}

		if (!$target && !isHomeScroll) return;

		window.toggleMenu?.(false);
		document.body.click();

		const $inner = $target?.closest(SELECTORS.inner);
		const isHorScroll = $inner && window.innerWidth >= 1024;

		const customPosY = calcAdditionalOffset($target, config);

		const targetBounds = $target?.getBoundingClientRect() || {
			x: 0,
			y: 0,
		};

		const scrollPosition = isHorScroll ? window.scrollY + targetBounds.x : window.scrollY + targetBounds.y;

		const y = customPosY >= 0 ? customPosY ?? scrollPosition : scrollPosition;

		const duration = (Math.abs(window.scrollY - y) / 1000) * 0.5;

		ScrollTrigger.refresh();

		const createTween = () => {
			const scrollTween = gsap.timeline().to(window, {
				scrollTo: y + Number(additionalOffset || 0),
				duration: instant ? 0 : gsap.utils.clamp(0.4, 2, duration),
				ease: 'sine.inOut',
				onComplete: () => {
					if (isContact && !isHomeScroll) window.onContactClick?.();
					window.location.hash = '';
				},
			});

			if (!isContact && !isHomeScroll) {
				currentTween = scrollTween;
			}
		};

		createTween();

		if (!isHomeScroll) e?.preventDefault();
	};

	const checkInitialHash = () => {
		const hash = window.location.hash.substring(1);

		if (hash) {
			if (hash === KNOWN_HASHES.contact) {
				window.onContactClick?.();
			} else {
				goTo({ id: hash, href: window.location.href });
			}

			window.location.hash = '';
		}
	};

	const onAnchorClick = (e) => {
		const $link = e.target.closest('[href]');
		const href = $link?.getAttribute('href');

		if (!href) return;
		const hrefParts = href.split('#');
		const cleanHref = hrefParts?.[hrefParts.length - 1];
		const instant = $link.dataset.instantAnchor;

		goTo({ id: cleanHref, additionalOffset: $link.dataset.anchorOffset, e, instant, href });
	};

	$anchors.forEach(($anchor) => {
		const $link = $anchor.closest('[href]');
		const href = $link?.getAttribute('href');
		if (!href || !href.includes('#')) return;

		const redirectMod = $anchor.classList.contains(CLASSNAMES.redirectMod);
		$anchor.addEventListener('click', (e) => onAnchorClick(e, redirectMod));
	});

	const interruptAnimation = () => {
		if (currentTween) {
			currentTween.kill();
			currentTween = null;
		}
	};

	window.addEventListener('wheel', interruptAnimation);
	window.addEventListener('touchstart', interruptAnimation);

	checkInitialHash();
}

export default anchorScroll;
