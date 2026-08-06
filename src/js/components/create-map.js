/* eslint-disable */
import {
	BASE_COORDINATES,
	MARKER_ICONS,
	MARKER_ICONS_ACTIVE,
	MAP_COLOR_THEME,
	MAP_COLOR_THEME_ACTIVE,
	ALLOWED_BOUNDS,
} from './constants';

export const createMap = ({ google, config, $map, assetsUrl, lang }) => {
	const mapOptions = {
		...config,
		maxZoom: 30,
		mapTypeControl: false,
		center: {
			lat: BASE_COORDINATES.lat,
			lng: BASE_COORDINATES.lon,
		},
		restriction: {
			latLngBounds: ALLOWED_BOUNDS,
			strictBounds: true,
		},
		styles: MAP_COLOR_THEME,
	};

	const map = new google.maps.Map($map, {
		...mapOptions,
		mapTypeControl: false,
		zoomControl: false,
		streetViewControl: false,
		rotateControl: false,
		fullscreenControl: false,
	});

	let activeExitMarkers = [];

	window.clearExitMarkers = () => {
		activeExitMarkers.forEach((m) => m.setMap(null));
		activeExitMarkers = [];
		if (window.currentlyActiveMarker) {
			window.currentlyActiveMarker.setMap(map);
			window.currentlyActiveMarker.setIcon(window.currentlyDefaultMarker);
		}
	};

	window.resetToInitialState = () => {
		map.setOptions({ styles: MAP_COLOR_THEME });
		map.setZoom(11);
		window.clearExitMarkers();
	};

	window.setMapActiveBackground = () => {
		map.setOptions({ styles: MAP_COLOR_THEME_ACTIVE });
	};

	window.currentlyActiveMarker = null;
	window.currentlyDefaultMarker = null;
	let openMarkers = [];

	const processMarkers = ({
		lat,
		lon: lng,
		type,
		name_uk,
		name_en,
		iconUrl,
		size = 'md',
		id,
		exits,
		...rest
	}) => {
		if (!MARKER_ICONS[type] && !iconUrl) return null;

		const sizes = {
			lg: 50,
			md: 40,
			xl: 70,
		};

		const markerImage = {
			url: MARKER_ICONS[type] || assetsUrl + iconUrl,
			size: sizes[size] || sizes.md,
		};

		const markerActive = {
			url: MARKER_ICONS_ACTIVE[type] || assetsUrl + iconUrl,
			size: sizes['xl'] || sizes.md,
		};

		const defaultIcon = {
			url: markerImage.url,
			anchor: new google.maps.Point(markerImage.size / 2, markerImage.size / 2),
			scaledSize: new google.maps.Size(markerImage.size, markerImage.size),
		};

		const activeIcon = {
			url: markerActive.url,
			anchor: new google.maps.Point(markerActive.size / 2, markerActive.size / 2),
			scaledSize: new google.maps.Size(markerActive.size, markerActive.size),
		};

		const marker = new google.maps.Marker({
			position: new google.maps.LatLng(lat, lng),
			className: `marker-${type}`,
			icon: markerImage ? defaultIcon : null,
		});

		marker.addListener('click', (e) => {
			window.clearExitMarkers();

			openMarkers.forEach((marker) => {
				// marker.close(null);
			});
			openMarkers = [...openMarkers];
			e.domEvent?.preventDefault();
			e.domEvent?.stopPropagation();

			document.querySelector('.js-map-marker-popup').classList.add('map_popup--open_state');
			const currentPosition = marker.getPosition();

			const newCenterLng = window.innerWidth > 768 ? currentPosition.lng() + 0.012 : currentPosition.lng();
			const newCenter = { lat: currentPosition.lat(), lng: newCenterLng };

			map.setZoom(15);
			map.setCenter(newCenter);

			if (window.currentlyActiveMarker && window.currentlyActiveMarker !== marker) {
				window.currentlyActiveMarker.setIcon(window.currentlyDefaultMarker);
			}

			window.currentlyDefaultMarker = defaultIcon;

			marker.setIcon(activeIcon);

			console.log(exits); //!

			if (exits?.length && Array.isArray(exits)) {
				marker.setMap(null);
				exits.forEach((exit) => {
					const exitMarker = new google.maps.Marker({
						position: new google.maps.LatLng(exit.lat, exit.lon),
						map: map,
						icon: activeIcon,
						zIndex: 99,
					});
					activeExitMarkers.push(exitMarker);
				});
			}

			window.setMapActiveBackground?.();
			window.currentlyActiveMarker = marker;

			$map.closest('.js-map-section').classList.add('map--open_mod');

			window.markerClickHandler?.(id);
		});

		marker.id = id;
		marker.type = type;
		marker.exits = exits;

		for (const key in rest) {
			if (Object.hasOwnProperty.call(rest, key)) {
				marker[key] = rest[key];
			}
		}

		return marker;
	};

	const markers = config.markers.map(processMarkers).filter((marker) => marker);

	return { map, markers };
};
