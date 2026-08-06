/* eslint-disable prefer-template */
/* eslint-disable no-array-constructor */

export const ALLOWED_BOUNDS = {
	north: 50.7,
	east: 34.9,
	south: 50.1,
	west: 30.0,
};

export const BASE_COORDINATES = {
	lat: 50.4216678,
	lon: 30.5156999,
};

export const MARKER_ICONS = {
	active: window.shelterMapData.themeUrl + '/images/map/marker-active.svg',
	skhovyshche: window.shelterMapData.themeUrl + '/images/map/marker-location.svg',
	dual_purpose: window.shelterMapData.themeUrl + '/images/map/marker-location.svg',
	expensive_shelters: window.shelterMapData.themeUrl + '/images/map/marker-money.svg',
	child_death: window.shelterMapData.themeUrl + '/images/map/marker-horse.svg',
	destroyed_building: window.shelterMapData.themeUrl + '/images/map/marker-building.svg',
};

export const MARKER_ICONS_ACTIVE = {
	skhovyshche: window.shelterMapData.themeUrl + '/images/map/marker-active.svg',
	dual_purpose: window.shelterMapData.themeUrl + '/images/map/marker-active.svg',
	expensive_shelters: window.shelterMapData.themeUrl + '/images/map/marker-money-active.svg',
	child_death: window.shelterMapData.themeUrl + '/images/map/marker-horse-active.svg',
	destroyed_building: window.shelterMapData.themeUrl + '/images/map/marker-building-active.svg',
};

export const STATIC_MARKERS = [
	{
		...BASE_COORDINATES,
		id: 'logo',
		iconUrl: 'map/location.svg',
		name_uk: 'Atlantic Residences Kyiv',
		name_en: 'Atlantic Residences Kyiv',
		size: 'xl',
	},
	{
		lat: 50.43349805628438,
		lon: 30.521904425448366,
		id: 'nsc',
		iconUrl: 'map/location.svg',
		name_uk: 'НСК Олимпийский',
		name_en: 'NSC Olimpiyskiy',
		size: 'lg',
	},
	{
		lat: 50.41254307490904,
		lon: 30.52231622544705,
		id: 'plaza',
		iconUrl: 'map/location.svg',
		name_uk: 'Ocean Plaza',
		name_en: 'Ocean Plaza',
		size: 'lg',
	},
	{
		lat: 50.42236566994624,
		lon: 30.521026083118894,
		id: 'palace',
		iconUrl: 'map/location.svg',
		name_uk: 'Палац Україна',
		name_en: 'Ukraine Palace',
		size: 'lg',
	},
	{
		lat: 50.426935446255776,
		lon: 30.51757532359846,
		id: 'cathedral',
		type: 'cathedral',
		iconUrl: 'map/location.svg',
		name_uk: 'Костел Св. Николая',
		name_en: 'St. Nicholas Cathedral',
		size: 'lg',
	},
	{
		lat: 50.42544544951425,
		lon: 30.50661887037042,
		id: 'sportlife',
		type: 'sportlife',
		iconUrl: 'map/location.svg',
		name_uk: 'Sport Life',
		name_en: 'Sport Life',
		size: 'lg',
	},
];

export const ALWAYS_VISIBLE_MARKERS = ['logo'];

export const MAP_API_KEY = 'AIzaSyBrZNofhuwJ2QPvOjleVt53ytuDRrap5KM';
export const MAP_DATA = {
	0: {},
};

export const MAP_COLOR_THEME = [
	{
		elementType: 'geometry',
		stylers: [
			{
				color: '#1d2c4d',
			},
		],
	},
	{
		elementType: 'labels.text.fill',
		stylers: [
			{
				color: '#8ec3b9',
			},
		],
	},
	{
		elementType: 'labels.text.stroke',
		stylers: [
			{
				color: '#1a3646',
			},
		],
	},
	{
		featureType: 'administrative.country',
		elementType: 'geometry.stroke',
		stylers: [
			{
				color: '#4b6878',
			},
		],
	},
	{
		featureType: 'administrative.country',
		elementType: 'labels',
		stylers: [
			{
				visibility: 'off',
			},
		],
	},
	{
		featureType: 'administrative.land_parcel',
		elementType: 'labels',
		stylers: [
			{
				visibility: 'off',
			},
		],
	},
	{
		featureType: 'administrative.land_parcel',
		elementType: 'labels.text.fill',
		stylers: [
			{
				color: '#64779e',
			},
		],
	},
	{
		featureType: 'administrative.locality',
		elementType: 'labels',
		stylers: [
			{
				visibility: 'off',
			},
		],
	},
	{
		featureType: 'administrative.neighborhood',
		elementType: 'labels',
		stylers: [
			{
				visibility: 'off',
			},
		],
	},
	{
		featureType: 'administrative.province',
		elementType: 'geometry.stroke',
		stylers: [
			{
				color: '#eb6766',
			},
			{
				visibility: 'on',
			},
			{
				weight: 2.5,
			},
		],
	},
	{
		featureType: 'administrative.province',
		elementType: 'labels',
		stylers: [
			{
				visibility: 'off',
			},
		],
	},
	{
		featureType: 'landscape',
		elementType: 'labels',
		stylers: [
			{
				visibility: 'off',
			},
		],
	},
	{
		featureType: 'landscape.man_made',
		elementType: 'geometry',
		stylers: [
			{
				color: '#03213b',
			},
		],
	},
	{
		featureType: 'landscape.man_made',
		elementType: 'geometry.stroke',
		stylers: [
			{
				color: '#334e87',
			},
		],
	},
	{
		featureType: 'landscape.natural',
		elementType: 'geometry',
		stylers: [
			{
				color: '#03213b',
			},
		],
	},
	{
		featureType: 'poi',
		elementType: 'geometry',
		stylers: [
			{
				color: '#283d6a',
			},
		],
	},
	{
		featureType: 'poi',
		elementType: 'labels',
		stylers: [
			{
				visibility: 'off',
			},
		],
	},
	{
		featureType: 'poi',
		elementType: 'labels.text.fill',
		stylers: [
			{
				color: '#6f9ba5',
			},
		],
	},
	{
		featureType: 'poi',
		elementType: 'labels.text.stroke',
		stylers: [
			{
				color: '#1d2c4d',
			},
		],
	},
	{
		featureType: 'poi.park',
		elementType: 'geometry.fill',
		stylers: [
			{
				color: '#023e58',
			},
		],
	},
	{
		featureType: 'poi.park',
		elementType: 'labels.text.fill',
		stylers: [
			{
				color: '#3C7680',
			},
		],
	},
	{
		featureType: 'road',
		elementType: 'geometry',
		stylers: [
			{
				color: '#304a7d',
			},
		],
	},
	{
		featureType: 'road',
		elementType: 'labels',
		stylers: [
			{
				visibility: 'off',
			},
		],
	},
	{
		featureType: 'road',
		elementType: 'labels.text.fill',
		stylers: [
			{
				color: '#98a5be',
			},
		],
	},
	{
		featureType: 'road',
		elementType: 'labels.text.stroke',
		stylers: [
			{
				color: '#1d2c4d',
			},
		],
	},
	{
		featureType: 'road.highway',
		elementType: 'geometry',
		stylers: [
			{
				color: '#2c6675',
			},
		],
	},
	{
		featureType: 'road.highway',
		elementType: 'geometry.fill',
		stylers: [
			{
				color: '#a5b1ac',
			},
		],
	},
	{
		featureType: 'road.highway',
		elementType: 'geometry.stroke',
		stylers: [
			{
				color: '#255763',
			},
		],
	},
	{
		featureType: 'road.highway',
		elementType: 'labels.text.fill',
		stylers: [
			{
				color: '#b0d5ce',
			},
		],
	},
	{
		featureType: 'road.highway',
		elementType: 'labels.text.stroke',
		stylers: [
			{
				color: '#023e58',
			},
		],
	},
	{
		featureType: 'transit',
		elementType: 'labels',
		stylers: [
			{
				visibility: 'off',
			},
		],
	},
	{
		featureType: 'transit',
		elementType: 'labels.text.fill',
		stylers: [
			{
				color: '#98a5be',
			},
		],
	},
	{
		featureType: 'transit',
		elementType: 'labels.text.stroke',
		stylers: [
			{
				color: '#1d2c4d',
			},
		],
	},
	{
		featureType: 'transit.line',
		elementType: 'geometry.fill',
		stylers: [
			{
				color: '#283d6a',
			},
		],
	},
	{
		featureType: 'transit.station',
		elementType: 'geometry',
		stylers: [
			{
				color: '#3a4762',
			},
		],
	},
	{
		featureType: 'water',
		elementType: 'geometry',
		stylers: [
			{
				color: '#0e1626',
			},
		],
	},
	{
		featureType: 'water',
		elementType: 'geometry.fill',
		stylers: [
			{
				color: '#c8a30c',
			},
		],
	},
	{
		featureType: 'water',
		elementType: 'geometry.stroke',
		stylers: [
			{
				color: '#ffeb3b',
			},
		],
	},
	{
		featureType: 'water',
		elementType: 'labels.text.fill',
		stylers: [
			{
				color: '#4e6d70',
			},
		],
	},
];

export const MAP_COLOR_THEME_ACTIVE = [
	{
		featureType: 'all',
		elementType: 'labels.text.fill',
		stylers: [
			{
				saturation: 36,
			},
			{
				color: '#000000',
			},
			{
				lightness: 40,
			},
		],
	},
	{
		featureType: 'all',
		elementType: 'labels.text.stroke',
		stylers: [
			{
				visibility: 'on',
			},
			{
				color: '#000000',
			},
			{
				lightness: 16,
			},
		],
	},
	{
		featureType: 'all',
		elementType: 'labels.icon',
		stylers: [
			{
				visibility: 'off',
			},
		],
	},
	{
		featureType: 'administrative',
		elementType: 'geometry.fill',
		stylers: [
			{
				color: '#000000',
			},
			{
				lightness: 20,
			},
		],
	},
	{
		featureType: 'administrative',
		elementType: 'geometry.stroke',
		stylers: [
			{
				color: '#000000',
			},
			{
				lightness: 17,
			},
			{
				weight: 1.2,
			},
		],
	},
	{
		featureType: 'landscape',
		elementType: 'geometry',
		stylers: [
			{
				color: '#000000',
			},
			{
				lightness: 20,
			},
		],
	},
	{
		featureType: 'poi',
		elementType: 'geometry',
		stylers: [
			{
				color: '#000000',
			},
			{
				lightness: 21,
			},
		],
	},
	{
		featureType: 'road.highway',
		elementType: 'geometry.fill',
		stylers: [
			{
				color: '#000000',
			},
			{
				lightness: 17,
			},
		],
	},
	{
		featureType: 'road.highway',
		elementType: 'geometry.stroke',
		stylers: [
			{
				color: '#000000',
			},
			{
				lightness: 29,
			},
			{
				weight: 0.2,
			},
		],
	},
	{
		featureType: 'road.arterial',
		elementType: 'geometry',
		stylers: [
			{
				color: '#000000',
			},
			{
				lightness: 18,
			},
		],
	},
	{
		featureType: 'road.local',
		elementType: 'geometry',
		stylers: [
			{
				color: '#000000',
			},
			{
				lightness: 16,
			},
		],
	},
	{
		featureType: 'transit',
		elementType: 'geometry',
		stylers: [
			{
				color: '#000000',
			},
			{
				lightness: 19,
			},
		],
	},
	{
		featureType: 'water',
		elementType: 'geometry',
		stylers: [
			{
				color: '#0f252e',
			},
			{
				lightness: 17,
			},
		],
	},
];
