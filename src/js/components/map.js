/* eslint-disable */

import { Loader } from '@googlemaps/js-api-loader';
import { MARKER_ICONS, MAP_API_KEY } from './constants';
import { createMap } from './create-map';

const mapInit = () => {
	const SELECTORS = {
		filterOpenBtn: '.js-map-filters-trigger',
		filterPopup: '.js-map-filters-popup',
		markerPopup: '.js-map-marker-popup',
		popupClose: '.js-map-popup-close',
		clearFilters: '.js-clear-filters',
		filtersBlock: '.js-filter-block',

		allReviewsBtn: '.js-map-reviews-all',

		reviewBtn: '.js-map-review-add',
		reviewBack: '.js-map-review-back',

		map: '.js-map',
		mapSection: '.js-map-section',
		filterTrigger: '.js-filter-trigger',
	};

	const CLASS_NAMES = {
		popupOpenState: 'map_popup--open_state',
		mapActiveMarkerState: 'map--open_mod',
		popupReviewState: 'map_popup--review_mod',
		showAllReviews: 'map_popup--show_all_state',
		submitted: 'map_popup--submitted_mod',
	};

	const loader = new Loader({
		apiKey: MAP_API_KEY,
		version: 'weekly',
		libraries: ['places'],
	});
	const $mapSections = document.querySelectorAll(SELECTORS.mapSection);
	if (!$mapSections.length) return;
	const $filterOpenBtn = document.querySelector(SELECTORS.filterOpenBtn);
	const $filterPopup = document.querySelector(SELECTORS.filterPopup);
	const $markerPopup = document.querySelector(SELECTORS.markerPopup);
	const $popupClose = document.querySelectorAll(SELECTORS.popupClose);
	const $allReviewsBtn = document.querySelectorAll(SELECTORS.allReviewsBtn);

	const $reviewBtn = document.querySelectorAll(SELECTORS.reviewBtn);
	const $reviewBack = document.querySelectorAll(SELECTORS.reviewBack);

	let mapInstance = null;

	$allReviewsBtn.forEach((item) => {
		item.addEventListener('click', () => {
			$markerPopup.classList.add(CLASS_NAMES.showAllReviews);
		});
	});

	$reviewBtn.forEach((btn) => {
		btn.addEventListener('click', () => {
			$markerPopup.classList.add(CLASS_NAMES.popupReviewState);
			$markerPopup.classList.remove(CLASS_NAMES.submitted);
		});
	});

	$reviewBack.forEach((btn) => {
		btn.addEventListener('click', () => {
			$markerPopup.classList.remove(CLASS_NAMES.popupReviewState);
		});
	});

	$filterOpenBtn.addEventListener('click', () => {
		$filterPopup.classList.add(CLASS_NAMES.popupOpenState);
		window.setMapActiveBackground();
	});

	const closeHandler = (btn) => {
		$filterPopup.classList.remove(CLASS_NAMES.popupOpenState);
		$markerPopup.classList.remove(CLASS_NAMES.popupOpenState);

		$markerPopup.classList.remove(CLASS_NAMES.popupReviewState);
		$markerPopup.classList.remove(CLASS_NAMES.showAllReviews);

		$markerPopup.classList.remove(CLASS_NAMES.submitted);

		if (btn) {
			btn.closest(SELECTORS.mapSection).classList.remove(CLASS_NAMES.mapActiveMarkerState);
		} else {
			document.querySelectorAll(SELECTORS.mapSection).forEach(($section) => {
				$section.classList.remove(CLASS_NAMES.mapActiveMarkerState);
			});
		}

		window.resetToInitialState();

		if (window.currentlyActiveMarker) {
			window.currentlyActiveMarker.setIcon(window.currentlyDefaultMarker);
			window.currentlyActiveMarker = null;
		}
	};

	document.addEventListener('keydown', (event) => {
		if (event.key === 'Escape') {
			closeHandler();
		}
	});

	$popupClose.forEach((btn) => {
		btn.addEventListener('click', () => {
			closeHandler(btn);
		});
	});

	const filters = {};
	const $filterTriggers = document.querySelectorAll('.js-filter-checkbox');

	const udapteMarkers = () => {
		if (!mapInstance) return;

		const allFilteredMarkers = mapInstance.markers.filter((marker) => {
			const filterKeys = Object.keys(filters);

			const passesAllFilters = filterKeys.every((key) => {
				const filterValue = filters[key];

				if (!filterValue || (Array.isArray(filterValue) && filterValue.length === 0)) {
					return true;
				}

				if (key === 'district') {
					return filterValue.includes(marker.district);
				}

				if (key === 'type') {
					if (filterValue.length > 0) {
						// filterValue може містити елементи з комами, наприклад 'skhovyshche,dual_purpose'
						// marker.type має співпасти з будь-яким із значень
						return filterValue.some((filterKey) => {
							if (typeof filterKey === 'string' && filterKey.includes(',')) {
								const splitKeys = filterKey.split(',').map((k) => k.trim());
								return splitKeys.includes(marker.type);
							}
							return filterKey === marker.type;
						});
					}
					return true;
				}

				if (key === 'fullday') {
					return marker[key] === 'Цілодобово';
				}

				const markerField = marker[key];
				if (typeof markerField === 'boolean') {
					return markerField === true;
				}
				if (Array.isArray(markerField)) {
					return markerField.length > 0;
				}

				return !!markerField;
			});

			return passesAllFilters;
		});

		mapInstance.markers.forEach((marker) => {
			const isVisible = allFilteredMarkers.includes(marker);
			marker.setVisible(isVisible);
		});
	};

	const updateFilters = (filter, key, isChecked) => {
		if (filter === 'district' || filter === 'type') {
			if (isChecked) {
				if (!filters[filter]) {
					filters[filter] = [];
				}
				if (!filters[filter].includes(key)) {
					filters[filter].push(key);
				}
			} else {
				filters[filter] = filters[filter].filter((item) => item !== key);
			}
		} else {
			filters[filter] = isChecked;
		}

		udapteMarkers();
	};

	const $clearFiltersBtn = document.querySelector(SELECTORS.clearFilters);

	const clearAllFilters = () => {
		$filterTriggers.forEach((checkbox) => {
			checkbox.checked = false;
		});
		Object.keys(filters).forEach((key) => {
			filters[key] = key === 'district' ? [] : false;
		});
		udapteMarkers();
	};

	$clearFiltersBtn?.addEventListener('click', clearAllFilters);

	$filterTriggers.forEach((item) => {
		item.addEventListener('change', (e) => {
			const isChecked = e.target.checked;
			const filter = item.dataset.filter;
			const key = item.dataset.key;
			const $filterBlock = item.closest(SELECTORS.filtersBlock);
			const $checkboxes = $filterBlock.querySelectorAll('.js-filter-checkbox:not([data-filter="all"])');

			if (filter === 'all') {
				$checkboxes.forEach((checkbox) => {
					checkbox.checked = isChecked;
					updateFilters(checkbox.dataset.filter, checkbox.dataset.key, isChecked);
				});
			} else {
				const $allCheckbox = $filterBlock.querySelector('[data-filter="all"]');
				const allChecked = Array.from($checkboxes).every((checkbox) => checkbox.checked);
				$allCheckbox.checked = allChecked;
				updateFilters(filter, key, isChecked);
			}
		});
	});

	fetch(shelterMapData.home)
		.then((response) => response.json())
		.then((data) => {
			loader
				.load()
				.then((google) => {
					$mapSections.forEach(($mapSection) => {
						const $map = $mapSection.querySelector(SELECTORS.map);
						const assetsUrl = $mapSection.dataset.assetsUrl || './';

						const mapData = {
							markers: data,
							zoom: 11,
						};
						let sessionConfig = mapData;

						mapInstance = createMap({
							google,
							config: sessionConfig,
							$map,
							prevInstance: mapInstance,
							assetsUrl: assetsUrl,
							lang: $mapSection.dataset.lang || 'en',
						});

						mapInstance.markers.forEach((marker) => {
							marker.setMap(mapInstance.map);
						});
					});
				})
				.catch((e) => {
					console.log(e);
				});
		})
		.catch((error) => {
			console.error('Error loading markers:', error);
		});
};

export default mapInit;
