var _0 = /iPhone/i,
	d0 = /iPod/i,
	t0 = /iPad/i,
	n0 = /\biOS-universal(?:.+)Mac\b/i,
	M0 = /\bAndroid(?:.+)Mobile\b/i,
	l0 = /Android/i,
	i = /(?:SD4930UR|\bSilk(?:.+)Mobile\b)/i,
	j0 = /Silk/i,
	d = /Windows Phone/i,
	w0 = /\bWindows(?:.+)ARM\b/i,
	a0 = /BlackBerry/i,
	p0 = /BB10/i,
	i0 = /Opera Mini/i,
	r0 = /\b(CriOS|Chrome)(?:.+)Mobile/i,
	s0 = /Mobile(?:.+)Firefox\b/i,
	e0 = function (f) {
		return (
			typeof f !== 'undefined' &&
			f.platform === 'MacIntel' &&
			typeof f.maxTouchPoints === 'number' &&
			f.maxTouchPoints > 1 &&
			typeof MSStream === 'undefined'
		);
	};
function Ef(f) {
	return function ($) {
		return $.test(f);
	};
}
function y0(f) {
	var $ = { userAgent: '', platform: '', maxTouchPoints: 0 };
	if (!f && typeof navigator !== 'undefined')
		$ = {
			userAgent: navigator.userAgent,
			platform: navigator.platform,
			maxTouchPoints: navigator.maxTouchPoints || 0,
		};
	else if (typeof f === 'string') $.userAgent = f;
	else if (f && f.userAgent)
		$ = { userAgent: f.userAgent, platform: f.platform, maxTouchPoints: f.maxTouchPoints || 0 };
	var q = $.userAgent,
		J = q.split('[FBAN');
	if (typeof J[1] !== 'undefined') q = J[0];
	if (((J = q.split('Twitter')), typeof J[1] !== 'undefined')) q = J[0];
	var Q = Ef(q),
		U = {
			apple: {
				phone: Q(_0) && !Q(d),
				ipod: Q(d0),
				tablet: !Q(_0) && (Q(t0) || e0($)) && !Q(d),
				universal: Q(n0),
				device: (Q(_0) || Q(d0) || Q(t0) || Q(n0) || e0($)) && !Q(d),
			},
			amazon: { phone: Q(i), tablet: !Q(i) && Q(j0), device: Q(i) || Q(j0) },
			android: {
				phone: (!Q(d) && Q(i)) || (!Q(d) && Q(M0)),
				tablet: !Q(d) && !Q(i) && !Q(M0) && (Q(j0) || Q(l0)),
				device: (!Q(d) && (Q(i) || Q(j0) || Q(M0) || Q(l0))) || Q(/\bokhttp\b/i),
			},
			windows: { phone: Q(d), tablet: Q(w0), device: Q(d) || Q(w0) },
			other: {
				blackberry: Q(a0),
				blackberry10: Q(p0),
				opera: Q(i0),
				firefox: Q(s0),
				chrome: Q(r0),
				device: Q(a0) || Q(p0) || Q(i0) || Q(s0) || Q(r0),
			},
			any: !1,
			phone: !1,
			tablet: !1,
		};
	return (
		(U.any = U.apple.device || U.android.device || U.windows.device || U.other.device),
		(U.phone = U.apple.phone || U.android.phone || U.windows.phone),
		(U.tablet = U.apple.tablet || U.android.tablet || U.windows.tablet),
		U
	);
}
function uf(f, $) {
	let q;
	return function J(...Q) {
		clearTimeout(q),
			(q = setTimeout(() => {
				$?.apply?.(this, Q);
			}, f));
	};
}
var mf = () => {
		return (
			'ontouchstart' in window || window.navigator.maxTouchPoints > 0 || window.navigator.msMaxTouchPoints > 0
		);
	},
	L0 = () => {
		let f = y0(),
			$ = f.apple.phone,
			q = f.android.phone,
			J = f.seven_inch;
		if ($ || q || J || mf()) {
			let Q = window.innerHeight * 0.01;
			document.documentElement.style.setProperty('--vh', `${Q}px`);
		}
	};
function O0(f) {
	return f instanceof Function;
}
var A0 = (f) => {
	if (!f && !O0(f)) return;
	let $ = () => {
		f();
	};
	window.addEventListener('resize', uf($, 15)), $();
};
var ff = (f) => {
		if (!f && !O0(f)) return;
		document.addEventListener('DOMContentLoaded', f);
	},
	qf = (f) => {
		if (!f && !O0(f)) return;
		window.addEventListener('load', () => {
			(window.loaded = !0),
				f(),
				window.onWindowLoadCallbacks?.forEach(($) => {
					if (!$ && !O0($)) return;
					$();
				}),
				(window.onWindowLoadCallbacks = []);
		});
	};
var of = ({ triggers: f, activeStateName: $ }) => {
		let q = { defaultActiveState: 'accordion__item--active-mod' },
			J = f || null,
			Q = !0,
			U = () => Q,
			K = () => {
				if (U())
					J.forEach((y) => {
						if (y.parentNode.classList.contains($)) {
							let A = y.nextElementSibling;
							A.style.maxHeight = `${A.scrollHeight}px`;
						}
					});
			},
			j = (y, N) => {
				y.classList.remove($), (N.style.maxHeight = null);
			},
			Z = () => {
				J.forEach((y) => {
					j(y.parentNode, y.nextElementSibling);
				});
			},
			O = (y, N) => {
				setTimeout(() => {
					Z(), y.classList.add($), (N.style.maxHeight = `${N.scrollHeight}px`);
				}, 100);
			},
			V = (y) => {
				if (Q) {
					if (!y) return;
					let { parentNode: N, nextElementSibling: A } = y;
					if (N.classList.contains($)) j(N, A);
					else O(N, A);
				}
			};
		if (J)
			A0(K),
				J.forEach((y) => {
					let N = y.parentNode;
					if (N.classList.contains($) && U()) {
						let A = y.nextElementSibling;
						O(N, A);
					}
					y.addEventListener('click', () => {
						V(y);
					});
				});
	},
	$f = of;
function df(f, $, q, J) {
	function Q(U) {
		return U instanceof q
			? U
			: new q(function (K) {
					K(U);
			  });
	}
	return new (q || (q = Promise))(function (U, K) {
		function j(V) {
			try {
				O(J.next(V));
			} catch (y) {
				K(y);
			}
		}
		function Z(V) {
			try {
				O(J.throw(V));
			} catch (y) {
				K(y);
			}
		}
		function O(V) {
			V.done ? U(V.value) : Q(V.value).then(j, Z);
		}
		O((J = J.apply(f, $ || [])).next());
	});
}
function tf(f) {
	return f && f.__esModule && Object.prototype.hasOwnProperty.call(f, 'default') ? f.default : f;
}
var G0, Jf;
function nf() {
	if (Jf) return G0;
	return (
		(Jf = 1),
		(G0 = function f($, q) {
			if ($ === q) return !0;
			if ($ && q && typeof $ == 'object' && typeof q == 'object') {
				if ($.constructor !== q.constructor) return !1;
				var J, Q, U;
				if (Array.isArray($)) {
					if (((J = $.length), J != q.length)) return !1;
					for (Q = J; Q-- !== 0; ) if (!f($[Q], q[Q])) return !1;
					return !0;
				}
				if ($.constructor === RegExp) return $.source === q.source && $.flags === q.flags;
				if ($.valueOf !== Object.prototype.valueOf) return $.valueOf() === q.valueOf();
				if ($.toString !== Object.prototype.toString) return $.toString() === q.toString();
				if (((U = Object.keys($)), (J = U.length), J !== Object.keys(q).length)) return !1;
				for (Q = J; Q-- !== 0; ) if (!Object.prototype.hasOwnProperty.call(q, U[Q])) return !1;
				for (Q = J; Q-- !== 0; ) {
					var K = U[Q];
					if (!f($[K], q[K])) return !1;
				}
				return !0;
			}
			return $ !== $ && q !== q;
		}),
		G0
	);
}
var lf = nf(),
	wf = tf(lf),
	Qf = '__googleMapsScriptId',
	r;
(function (f) {
	(f[(f.INITIALIZED = 0)] = 'INITIALIZED'),
		(f[(f.LOADING = 1)] = 'LOADING'),
		(f[(f.SUCCESS = 2)] = 'SUCCESS'),
		(f[(f.FAILURE = 3)] = 'FAILURE');
})(r || (r = {}));
class l {
	constructor({
		apiKey: f,
		authReferrerPolicy: $,
		channel: q,
		client: J,
		id: Q = Qf,
		language: U,
		libraries: K = [],
		mapIds: j,
		nonce: Z,
		region: O,
		retries: V = 3,
		url: y = 'https://maps.googleapis.com/maps/api/js',
		version: N,
	}) {
		if (
			((this.callbacks = []),
			(this.done = !1),
			(this.loading = !1),
			(this.errors = []),
			(this.apiKey = f),
			(this.authReferrerPolicy = $),
			(this.channel = q),
			(this.client = J),
			(this.id = Q || Qf),
			(this.language = U),
			(this.libraries = K),
			(this.mapIds = j),
			(this.nonce = Z),
			(this.region = O),
			(this.retries = V),
			(this.url = y),
			(this.version = N),
			l.instance)
		) {
			if (!wf(this.options, l.instance.options))
				throw new Error(
					`Loader must not be called again with different options. ${JSON.stringify(
						this.options,
					)} !== ${JSON.stringify(l.instance.options)}`,
				);
			return l.instance;
		}
		l.instance = this;
	}
	get options() {
		return {
			version: this.version,
			apiKey: this.apiKey,
			channel: this.channel,
			client: this.client,
			id: this.id,
			libraries: this.libraries,
			language: this.language,
			region: this.region,
			mapIds: this.mapIds,
			nonce: this.nonce,
			url: this.url,
			authReferrerPolicy: this.authReferrerPolicy,
		};
	}
	get status() {
		if (this.errors.length) return r.FAILURE;
		if (this.done) return r.SUCCESS;
		if (this.loading) return r.LOADING;
		return r.INITIALIZED;
	}
	get failed() {
		return this.done && !this.loading && this.errors.length >= this.retries + 1;
	}
	createUrl() {
		let f = this.url;
		if (((f += '?callback=__googleMapsCallback&loading=async'), this.apiKey)) f += `&key=${this.apiKey}`;
		if (this.channel) f += `&channel=${this.channel}`;
		if (this.client) f += `&client=${this.client}`;
		if (this.libraries.length > 0) f += `&libraries=${this.libraries.join(',')}`;
		if (this.language) f += `&language=${this.language}`;
		if (this.region) f += `&region=${this.region}`;
		if (this.version) f += `&v=${this.version}`;
		if (this.mapIds) f += `&map_ids=${this.mapIds.join(',')}`;
		if (this.authReferrerPolicy) f += `&auth_referrer_policy=${this.authReferrerPolicy}`;
		return f;
	}
	deleteScript() {
		let f = document.getElementById(this.id);
		if (f) f.remove();
	}
	load() {
		return this.loadPromise();
	}
	loadPromise() {
		return new Promise((f, $) => {
			this.loadCallback((q) => {
				if (!q) f(window.google);
				else $(q.error);
			});
		});
	}
	importLibrary(f) {
		return this.execute(), google.maps.importLibrary(f);
	}
	loadCallback(f) {
		this.callbacks.push(f), this.execute();
	}
	setScript() {
		var f, $;
		if (document.getElementById(this.id)) {
			this.callback();
			return;
		}
		let q = {
			key: this.apiKey,
			channel: this.channel,
			client: this.client,
			libraries: this.libraries.length && this.libraries,
			v: this.version,
			mapIds: this.mapIds,
			language: this.language,
			region: this.region,
			authReferrerPolicy: this.authReferrerPolicy,
		};
		if (
			(Object.keys(q).forEach((Q) => !q[Q] && delete q[Q]),
			!(($ =
				(f = window === null || window === void 0 ? void 0 : window.google) === null || f === void 0
					? void 0
					: f.maps) === null || $ === void 0
				? void 0
				: $.importLibrary))
		)
			((Q) => {
				let U,
					K,
					j,
					Z = 'The Google Maps JavaScript API',
					O = 'google',
					V = 'importLibrary',
					y = '__ib__',
					N = document,
					A = window;
				A = A[O] || (A[O] = {});
				let F = A.maps || (A.maps = {}),
					R = new Set(),
					W = new URLSearchParams(),
					H = () =>
						U ||
						(U = new Promise((X, Y) =>
							df(this, void 0, void 0, function* () {
								var _;
								yield (K = N.createElement('script')), (K.id = this.id), W.set('libraries', [...R] + '');
								for (j in Q)
									W.set(
										j.replace(/[A-Z]/g, (L) => '_' + L[0].toLowerCase()),
										Q[j],
									);
								W.set('callback', O + '.maps.' + y),
									(K.src = this.url + '?' + W),
									(F[y] = X),
									(K.onerror = () => (U = Y(Error(Z + ' could not load.')))),
									(K.nonce =
										this.nonce ||
										((_ = N.querySelector('script[nonce]')) === null || _ === void 0 ? void 0 : _.nonce) ||
										''),
									N.head.append(K);
							}),
						));
				F[V]
					? console.warn(Z + ' only loads once. Ignoring:', Q)
					: (F[V] = (X, ...Y) => R.add(X) && H().then(() => F[V](X, ...Y)));
			})(q);
		let J = this.libraries.map((Q) => this.importLibrary(Q));
		if (!J.length) J.push(this.importLibrary('core'));
		Promise.all(J).then(
			() => this.callback(),
			(Q) => {
				let U = new ErrorEvent('error', { error: Q });
				this.loadErrorCallback(U);
			},
		);
	}
	reset() {
		this.deleteScript(),
			(this.done = !1),
			(this.loading = !1),
			(this.errors = []),
			(this.onerrorEvent = null);
	}
	resetIfRetryingFailed() {
		if (this.failed) this.reset();
	}
	loadErrorCallback(f) {
		if ((this.errors.push(f), this.errors.length <= this.retries)) {
			let $ = this.errors.length * Math.pow(2, this.errors.length);
			console.error(`Failed to load Google Maps script, retrying in ${$} ms.`),
				setTimeout(() => {
					this.deleteScript(), this.setScript();
				}, $);
		} else (this.onerrorEvent = f), this.callback();
	}
	callback() {
		(this.done = !0),
			(this.loading = !1),
			this.callbacks.forEach((f) => {
				f(this.onerrorEvent);
			}),
			(this.callbacks = []);
	}
	execute() {
		if ((this.resetIfRetryingFailed(), this.loading)) return;
		if (this.done) this.callback();
		else {
			if (window.google && window.google.maps && window.google.maps.version) {
				console.warn(
					'Google Maps already loaded outside @googlemaps/js-api-loader. This may result in undesirable behavior as options and script parameters may not match.',
				),
					this.callback();
				return;
			}
			(this.loading = !0), this.setScript();
		}
	}
}
var Uf = { north: 50.7, east: 34.9, south: 50.1, west: 30 },
	V0 = { lat: 50.4216678, lon: 30.5156999 },
	s = {
		active: shelterMapData.themeUrl + '/images/map/marker-active.svg',
		skhovyshche: shelterMapData.themeUrl + '/images/map/marker-location.svg',
		dual_purpose: shelterMapData.themeUrl + '/images/map/marker-location.svg',
		expensive_shelters: shelterMapData.themeUrl + '/images/map/marker-money.svg',
		child_death: shelterMapData.themeUrl + '/images/map/marker-horse.svg',
		destroyed_building: shelterMapData.themeUrl + '/images/map/marker-building.svg',
	},
	Zf = {
		skhovyshche: shelterMapData.themeUrl + '/images/map/marker-active.svg',
		dual_purpose: shelterMapData.themeUrl + '/images/map/marker-active.svg',
		expensive_shelters: shelterMapData.themeUrl + '/images/map/marker-money-active.svg',
		child_death: shelterMapData.themeUrl + '/images/map/marker-horse-active.svg',
		destroyed_building: shelterMapData.themeUrl + '/images/map/marker-building-active.svg',
	},
	B5 = [
		{
			...V0,
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
var Kf = 'AIzaSyBrZNofhuwJ2QPvOjleVt53ytuDRrap5KM';
var B0 = [
		{ elementType: 'geometry', stylers: [{ color: '#1d2c4d' }] },
		{ elementType: 'labels.text.fill', stylers: [{ color: '#8ec3b9' }] },
		{ elementType: 'labels.text.stroke', stylers: [{ color: '#1a3646' }] },
		{
			featureType: 'administrative.country',
			elementType: 'geometry.stroke',
			stylers: [{ color: '#4b6878' }],
		},
		{ featureType: 'administrative.country', elementType: 'labels', stylers: [{ visibility: 'off' }] },
		{ featureType: 'administrative.land_parcel', elementType: 'labels', stylers: [{ visibility: 'off' }] },
		{
			featureType: 'administrative.land_parcel',
			elementType: 'labels.text.fill',
			stylers: [{ color: '#64779e' }],
		},
		{ featureType: 'administrative.locality', elementType: 'labels', stylers: [{ visibility: 'off' }] },
		{ featureType: 'administrative.neighborhood', elementType: 'labels', stylers: [{ visibility: 'off' }] },
		{
			featureType: 'administrative.province',
			elementType: 'geometry.stroke',
			stylers: [{ color: '#eb6766' }, { visibility: 'on' }, { weight: 2.5 }],
		},
		{ featureType: 'administrative.province', elementType: 'labels', stylers: [{ visibility: 'off' }] },
		{ featureType: 'landscape', elementType: 'labels', stylers: [{ visibility: 'off' }] },
		{ featureType: 'landscape.man_made', elementType: 'geometry', stylers: [{ color: '#03213b' }] },
		{ featureType: 'landscape.man_made', elementType: 'geometry.stroke', stylers: [{ color: '#334e87' }] },
		{ featureType: 'landscape.natural', elementType: 'geometry', stylers: [{ color: '#03213b' }] },
		{ featureType: 'poi', elementType: 'geometry', stylers: [{ color: '#283d6a' }] },
		{ featureType: 'poi', elementType: 'labels', stylers: [{ visibility: 'off' }] },
		{ featureType: 'poi', elementType: 'labels.text.fill', stylers: [{ color: '#6f9ba5' }] },
		{ featureType: 'poi', elementType: 'labels.text.stroke', stylers: [{ color: '#1d2c4d' }] },
		{ featureType: 'poi.park', elementType: 'geometry.fill', stylers: [{ color: '#023e58' }] },
		{ featureType: 'poi.park', elementType: 'labels.text.fill', stylers: [{ color: '#3C7680' }] },
		{ featureType: 'road', elementType: 'geometry', stylers: [{ color: '#304a7d' }] },
		{ featureType: 'road', elementType: 'labels', stylers: [{ visibility: 'off' }] },
		{ featureType: 'road', elementType: 'labels.text.fill', stylers: [{ color: '#98a5be' }] },
		{ featureType: 'road', elementType: 'labels.text.stroke', stylers: [{ color: '#1d2c4d' }] },
		{ featureType: 'road.highway', elementType: 'geometry', stylers: [{ color: '#2c6675' }] },
		{ featureType: 'road.highway', elementType: 'geometry.fill', stylers: [{ color: '#a5b1ac' }] },
		{ featureType: 'road.highway', elementType: 'geometry.stroke', stylers: [{ color: '#255763' }] },
		{ featureType: 'road.highway', elementType: 'labels.text.fill', stylers: [{ color: '#b0d5ce' }] },
		{ featureType: 'road.highway', elementType: 'labels.text.stroke', stylers: [{ color: '#023e58' }] },
		{ featureType: 'transit', elementType: 'labels', stylers: [{ visibility: 'off' }] },
		{ featureType: 'transit', elementType: 'labels.text.fill', stylers: [{ color: '#98a5be' }] },
		{ featureType: 'transit', elementType: 'labels.text.stroke', stylers: [{ color: '#1d2c4d' }] },
		{ featureType: 'transit.line', elementType: 'geometry.fill', stylers: [{ color: '#283d6a' }] },
		{ featureType: 'transit.station', elementType: 'geometry', stylers: [{ color: '#3a4762' }] },
		{ featureType: 'water', elementType: 'geometry', stylers: [{ color: '#0e1626' }] },
		{ featureType: 'water', elementType: 'geometry.fill', stylers: [{ color: '#c8a30c' }] },
		{ featureType: 'water', elementType: 'geometry.stroke', stylers: [{ color: '#ffeb3b' }] },
		{ featureType: 'water', elementType: 'labels.text.fill', stylers: [{ color: '#4e6d70' }] },
	],
	jf = [
		{
			featureType: 'all',
			elementType: 'labels.text.fill',
			stylers: [{ saturation: 36 }, { color: '#000000' }, { lightness: 40 }],
		},
		{
			featureType: 'all',
			elementType: 'labels.text.stroke',
			stylers: [{ visibility: 'on' }, { color: '#000000' }, { lightness: 16 }],
		},
		{ featureType: 'all', elementType: 'labels.icon', stylers: [{ visibility: 'off' }] },
		{
			featureType: 'administrative',
			elementType: 'geometry.fill',
			stylers: [{ color: '#000000' }, { lightness: 20 }],
		},
		{
			featureType: 'administrative',
			elementType: 'geometry.stroke',
			stylers: [{ color: '#000000' }, { lightness: 17 }, { weight: 1.2 }],
		},
		{ featureType: 'landscape', elementType: 'geometry', stylers: [{ color: '#000000' }, { lightness: 20 }] },
		{ featureType: 'poi', elementType: 'geometry', stylers: [{ color: '#000000' }, { lightness: 21 }] },
		{
			featureType: 'road.highway',
			elementType: 'geometry.fill',
			stylers: [{ color: '#000000' }, { lightness: 17 }],
		},
		{
			featureType: 'road.highway',
			elementType: 'geometry.stroke',
			stylers: [{ color: '#000000' }, { lightness: 29 }, { weight: 0.2 }],
		},
		{
			featureType: 'road.arterial',
			elementType: 'geometry',
			stylers: [{ color: '#000000' }, { lightness: 18 }],
		},
		{
			featureType: 'road.local',
			elementType: 'geometry',
			stylers: [{ color: '#000000' }, { lightness: 16 }],
		},
		{ featureType: 'transit', elementType: 'geometry', stylers: [{ color: '#000000' }, { lightness: 19 }] },
		{ featureType: 'water', elementType: 'geometry', stylers: [{ color: '#0f252e' }, { lightness: 17 }] },
	];
/*! *****************************************************************************
Copyright (c) Microsoft Corporation.

Permission to use, copy, modify, and/or distribute this software for any
purpose with or without fee is hereby granted.

THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES WITH
REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF MERCHANTABILITY
AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT,
INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM
LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR
OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR
PERFORMANCE OF THIS SOFTWARE.
***************************************************************************** */ var T0 = function (f, $) {
	return (
		(T0 =
			Object.setPrototypeOf ||
			({ __proto__: [] } instanceof Array &&
				function (q, J) {
					q.__proto__ = J;
				}) ||
			function (q, J) {
				for (var Q in J) if (J.hasOwnProperty(Q)) q[Q] = J[Q];
			}),
		T0(f, $)
	);
};
function yf(f, $) {
	T0(f, $);
	function q() {
		this.constructor = f;
	}
	f.prototype = $ === null ? Object.create($) : ((q.prototype = $.prototype), new q());
}
var a = function () {
	return (
		(a =
			Object.assign ||
			function f($) {
				for (var q, J = 1, Q = arguments.length; J < Q; J++) {
					q = arguments[J];
					for (var U in q) if (Object.prototype.hasOwnProperty.call(q, U)) $[U] = q[U];
				}
				return $;
			}),
		a.apply(this, arguments)
	);
};
function af(f, $) {
	for (var q in $.prototype) f.prototype[q] = $.prototype[q];
}
var Of = (function () {
	function f() {
		af(f, google.maps.OverlayView);
	}
	return f;
})();
function D0(f) {
	return Object.keys(f)
		.reduce(function ($, q) {
			if (f[q]) $.push(q + ':' + f[q]);
			return $;
		}, [])
		.join(';');
}
function E(f) {
	return f ? f + 'px' : void 0;
}
var pf = (function (f) {
		yf($, f);
		function $(q, J) {
			var Q = f.call(this) || this;
			return (
				(Q.cluster_ = q),
				(Q.styles_ = J),
				(Q.center_ = null),
				(Q.div_ = null),
				(Q.sums_ = null),
				(Q.visible_ = !1),
				(Q.style = null),
				Q.setMap(q.getMap()),
				Q
			);
		}
		return (
			($.prototype.onAdd = function () {
				var q = this,
					J,
					Q,
					U = this.cluster_.getMarkerClusterer(),
					K = google.maps.version.split('.'),
					j = K[0],
					Z = K[1],
					O = parseInt(j, 10) * 100 + parseInt(Z, 10);
				if (((this.div_ = document.createElement('div')), this.visible_)) this.show();
				if (
					(this.getPanes().overlayMouseTarget.appendChild(this.div_),
					(this.boundsChangedListener_ = google.maps.event.addListener(
						this.getMap(),
						'bounds_changed',
						function () {
							Q = J;
						},
					)),
					google.maps.event.addDomListener(this.div_, 'mousedown', function () {
						(J = !0), (Q = !1);
					}),
					google.maps.event.addDomListener(this.div_, 'contextmenu', function () {
						google.maps.event.trigger(U, 'contextmenu', q.cluster_);
					}),
					O >= 332)
				)
					google.maps.event.addDomListener(this.div_, 'touchstart', function (V) {
						V.stopPropagation();
					});
				google.maps.event.addDomListener(this.div_, 'click', function (V) {
					if (((J = !1), !Q)) {
						if (
							(google.maps.event.trigger(U, 'click', q.cluster_),
							google.maps.event.trigger(U, 'clusterclick', q.cluster_),
							U.getZoomOnClick())
						) {
							var y = U.getMaxZoom(),
								N = q.cluster_.getBounds();
							U.getMap().fitBounds(N),
								setTimeout(function () {
									if ((U.getMap().fitBounds(N), y !== null && U.getMap().getZoom() > y))
										U.getMap().setZoom(y + 1);
								}, 100);
						}
						if (((V.cancelBubble = !0), V.stopPropagation)) V.stopPropagation();
					}
				}),
					google.maps.event.addDomListener(this.div_, 'mouseover', function () {
						google.maps.event.trigger(U, 'mouseover', q.cluster_);
					}),
					google.maps.event.addDomListener(this.div_, 'mouseout', function () {
						google.maps.event.trigger(U, 'mouseout', q.cluster_);
					});
			}),
			($.prototype.onRemove = function () {
				if (this.div_ && this.div_.parentNode)
					this.hide(),
						google.maps.event.removeListener(this.boundsChangedListener_),
						google.maps.event.clearInstanceListeners(this.div_),
						this.div_.parentNode.removeChild(this.div_),
						(this.div_ = null);
			}),
			($.prototype.draw = function () {
				if (this.visible_) {
					var q = this.getPosFromLatLng_(this.center_);
					(this.div_.style.top = q.y + 'px'), (this.div_.style.left = q.x + 'px');
				}
			}),
			($.prototype.hide = function () {
				if (this.div_) this.div_.style.display = 'none';
				this.visible_ = !1;
			}),
			($.prototype.show = function () {
				if (this.div_) {
					if (
						((this.div_.className = this.className_),
						(this.div_.style.cssText = this.createCss_(this.getPosFromLatLng_(this.center_))),
						(this.div_.innerHTML =
							(this.style.url ? this.getImageElementHtml() : '') + this.getLabelDivHtml()),
						typeof this.sums_.title === 'undefined' || this.sums_.title === '')
					)
						this.div_.title = this.cluster_.getMarkerClusterer().getTitle();
					else this.div_.title = this.sums_.title;
					this.div_.style.display = '';
				}
				this.visible_ = !0;
			}),
			($.prototype.getLabelDivHtml = function () {
				var q = this.cluster_.getMarkerClusterer(),
					J = q.ariaLabelFn(this.sums_.text),
					Q = {
						position: 'absolute',
						top: E(this.anchorText_[0]),
						left: E(this.anchorText_[1]),
						color: this.style.textColor,
						'font-size': E(this.style.textSize),
						'font-family': this.style.fontFamily,
						'font-weight': this.style.fontWeight,
						'font-style': this.style.fontStyle,
						'text-decoration': this.style.textDecoration,
						'text-align': 'center',
						width: E(this.style.width),
						'line-height': E(this.style.textLineHeight),
					};
				return `
<div aria-label="`
					.concat(J, '" style="')
					.concat(
						D0(Q),
						`" tabindex="0">
  <span aria-hidden="true">`,
					)
					.concat(
						this.sums_.text,
						`</span>
</div>
`,
					);
			}),
			($.prototype.getImageElementHtml = function () {
				var q = (this.style.backgroundPosition || '0 0').split(' '),
					J = parseInt(q[0].replace(/^\s+|\s+$/g, ''), 10),
					Q = parseInt(q[1].replace(/^\s+|\s+$/g, ''), 10),
					U = {};
				if (this.cluster_.getMarkerClusterer().getEnableRetinaIcons())
					U = { width: E(this.style.width), height: E(this.style.height) };
				else {
					var K = [-1 * Q, -1 * J + this.style.width, -1 * Q + this.style.height, -1 * J],
						j = K[0],
						Z = K[1],
						O = K[2],
						V = K[3];
					U = { clip: 'rect('.concat(j, 'px, ').concat(Z, 'px, ').concat(O, 'px, ').concat(V, 'px)') };
				}
				var y = this.sums_.url ? { width: '100%', height: '100%' } : {},
					N = D0(a(a({ position: 'absolute', top: E(Q), left: E(J) }, U), y));
				return '<img alt="'
					.concat(this.sums_.text, '" aria-hidden="true" src="')
					.concat(this.style.url, '" style="')
					.concat(N, '"/>');
			}),
			($.prototype.useStyle = function (q) {
				this.sums_ = q;
				var J = Math.max(0, q.index - 1);
				(J = Math.min(this.styles_.length - 1, J)),
					(this.style = this.sums_.url
						? a(a({}, this.styles_[J]), { url: this.sums_.url })
						: this.styles_[J]),
					(this.anchorText_ = this.style.anchorText || [0, 0]),
					(this.anchorIcon_ = this.style.anchorIcon || [
						Math.floor(this.style.height / 2),
						Math.floor(this.style.width / 2),
					]),
					(this.className_ =
						this.cluster_.getMarkerClusterer().getClusterClass() +
						' ' +
						(this.style.className || 'cluster-' + J));
			}),
			($.prototype.setCenter = function (q) {
				this.center_ = q;
			}),
			($.prototype.createCss_ = function (q) {
				return D0({
					'z-index': ''.concat(this.cluster_.getMarkerClusterer().getZIndex()),
					top: E(q.y),
					left: E(q.x),
					width: E(this.style.width),
					height: E(this.style.height),
					cursor: 'pointer',
					position: 'absolute',
					'-webkit-user-select': 'none',
					'-khtml-user-select': 'none',
					'-moz-user-select': 'none',
					'-o-user-select': 'none',
					'user-select': 'none',
				});
			}),
			($.prototype.getPosFromLatLng_ = function (q) {
				var J = this.getProjection().fromLatLngToDivPixel(q);
				return (
					(J.x = Math.floor(J.x - this.anchorIcon_[1])), (J.y = Math.floor(J.y - this.anchorIcon_[0])), J
				);
			}),
			$
		);
	})(Of),
	rf = (function () {
		function f($) {
			(this.markerClusterer_ = $),
				(this.map_ = this.markerClusterer_.getMap()),
				(this.minClusterSize_ = this.markerClusterer_.getMinimumClusterSize()),
				(this.averageCenter_ = this.markerClusterer_.getAverageCenter()),
				(this.markers_ = []),
				(this.center_ = null),
				(this.bounds_ = null),
				(this.clusterIcon_ = new pf(this, this.markerClusterer_.getStyles()));
		}
		return (
			(f.prototype.getSize = function () {
				return this.markers_.length;
			}),
			(f.prototype.getMarkers = function () {
				return this.markers_;
			}),
			(f.prototype.getCenter = function () {
				return this.center_;
			}),
			(f.prototype.getMap = function () {
				return this.map_;
			}),
			(f.prototype.getMarkerClusterer = function () {
				return this.markerClusterer_;
			}),
			(f.prototype.getBounds = function () {
				var $ = new google.maps.LatLngBounds(this.center_, this.center_),
					q = this.getMarkers();
				for (var J = 0; J < q.length; J++) $.extend(q[J].getPosition());
				return $;
			}),
			(f.prototype.remove = function () {
				this.clusterIcon_.setMap(null), (this.markers_ = []), delete this.markers_;
			}),
			(f.prototype.addMarker = function ($) {
				if (this.isMarkerAlreadyAdded_($)) return !1;
				if (!this.center_) (this.center_ = $.getPosition()), this.calculateBounds_();
				else if (this.averageCenter_) {
					var q = this.markers_.length + 1,
						J = (this.center_.lat() * (q - 1) + $.getPosition().lat()) / q,
						Q = (this.center_.lng() * (q - 1) + $.getPosition().lng()) / q;
					(this.center_ = new google.maps.LatLng(J, Q)), this.calculateBounds_();
				}
				($.isAdded = !0), this.markers_.push($);
				var U = this.markers_.length,
					K = this.markerClusterer_.getMaxZoom();
				if (K !== null && this.map_.getZoom() > K) {
					if ($.getMap() !== this.map_) $.setMap(this.map_);
				} else if (U < this.minClusterSize_) {
					if ($.getMap() !== this.map_) $.setMap(this.map_);
				} else if (U === this.minClusterSize_) for (var j = 0; j < U; j++) this.markers_[j].setMap(null);
				else $.setMap(null);
				return !0;
			}),
			(f.prototype.isMarkerInClusterBounds = function ($) {
				return this.bounds_.contains($.getPosition());
			}),
			(f.prototype.calculateBounds_ = function () {
				var $ = new google.maps.LatLngBounds(this.center_, this.center_);
				this.bounds_ = this.markerClusterer_.getExtendedBounds($);
			}),
			(f.prototype.updateIcon = function () {
				var $ = this.markers_.length,
					q = this.markerClusterer_.getMaxZoom();
				if (q !== null && this.map_.getZoom() > q) {
					this.clusterIcon_.hide();
					return;
				}
				if ($ < this.minClusterSize_) {
					this.clusterIcon_.hide();
					return;
				}
				var J = this.markerClusterer_.getStyles().length,
					Q = this.markerClusterer_.getCalculator()(this.markers_, J);
				this.clusterIcon_.setCenter(this.center_), this.clusterIcon_.useStyle(Q), this.clusterIcon_.show();
			}),
			(f.prototype.isMarkerAlreadyAdded_ = function ($) {
				if (this.markers_.indexOf) return this.markers_.indexOf($) !== -1;
				else for (var q = 0; q < this.markers_.length; q++) if ($ === this.markers_[q]) return !0;
				return !1;
			}),
			f
		);
	})(),
	F0 = function (f, $, q) {
		if (f[$] !== void 0) return f[$];
		else return q;
	},
	Af = (function (f) {
		yf($, f);
		function $(q, J, Q) {
			if (J === void 0) J = [];
			if (Q === void 0) Q = {};
			var U = f.call(this) || this;
			if (
				((U.options = Q),
				(U.markers_ = []),
				(U.clusters_ = []),
				(U.listeners_ = []),
				(U.activeMap_ = null),
				(U.ready_ = !1),
				(U.ariaLabelFn =
					U.options.ariaLabelFn ||
					function () {
						return '';
					}),
				(U.zIndex_ = U.options.zIndex || Number(google.maps.Marker.MAX_ZINDEX) + 1),
				(U.gridSize_ = U.options.gridSize || 60),
				(U.minClusterSize_ = U.options.minimumClusterSize || 2),
				(U.maxZoom_ = U.options.maxZoom || null),
				(U.styles_ = U.options.styles || []),
				(U.title_ = U.options.title || ''),
				(U.zoomOnClick_ = F0(U.options, 'zoomOnClick', !0)),
				(U.averageCenter_ = F0(U.options, 'averageCenter', !1)),
				(U.ignoreHidden_ = F0(U.options, 'ignoreHidden', !1)),
				(U.enableRetinaIcons_ = F0(U.options, 'enableRetinaIcons', !1)),
				(U.imagePath_ = U.options.imagePath || $.IMAGE_PATH),
				(U.imageExtension_ = U.options.imageExtension || $.IMAGE_EXTENSION),
				(U.imageSizes_ = U.options.imageSizes || $.IMAGE_SIZES),
				(U.calculator_ = U.options.calculator || $.CALCULATOR),
				(U.batchSize_ = U.options.batchSize || $.BATCH_SIZE),
				(U.batchSizeIE_ = U.options.batchSizeIE || $.BATCH_SIZE_IE),
				(U.clusterClass_ = U.options.clusterClass || 'cluster'),
				navigator.userAgent.toLowerCase().indexOf('msie') !== -1)
			)
				U.batchSize_ = U.batchSizeIE_;
			return U.setupStyles_(), U.addMarkers(J, !0), U.setMap(q), U;
		}
		return (
			($.prototype.onAdd = function () {
				var q = this;
				(this.activeMap_ = this.getMap()),
					(this.ready_ = !0),
					this.repaint(),
					(this.prevZoom_ = this.getMap().getZoom()),
					(this.listeners_ = [
						google.maps.event.addListener(this.getMap(), 'zoom_changed', function () {
							var J = q.getMap(),
								Q = J.minZoom || 0,
								U = Math.min(J.maxZoom || 100, J.mapTypes[J.getMapTypeId()].maxZoom),
								K = Math.min(Math.max(q.getMap().getZoom(), Q), U);
							if (q.prevZoom_ != K) (q.prevZoom_ = K), q.resetViewport_(!1);
						}),
						google.maps.event.addListener(this.getMap(), 'idle', function () {
							q.redraw_();
						}),
					]);
			}),
			($.prototype.onRemove = function () {
				for (var q = 0; q < this.markers_.length; q++)
					if (this.markers_[q].getMap() !== this.activeMap_) this.markers_[q].setMap(this.activeMap_);
				for (var q = 0; q < this.clusters_.length; q++) this.clusters_[q].remove();
				this.clusters_ = [];
				for (var q = 0; q < this.listeners_.length; q++) google.maps.event.removeListener(this.listeners_[q]);
				(this.listeners_ = []), (this.activeMap_ = null), (this.ready_ = !1);
			}),
			($.prototype.draw = function () {}),
			($.prototype.setupStyles_ = function () {
				if (this.styles_.length > 0) return;
				for (var q = 0; q < this.imageSizes_.length; q++) {
					var J = this.imageSizes_[q];
					this.styles_.push(
						$.withDefaultStyle({
							url: this.imagePath_ + (q + 1) + '.' + this.imageExtension_,
							height: J,
							width: J,
						}),
					);
				}
			}),
			($.prototype.fitMapToMarkers = function (q) {
				var J = this.getMarkers(),
					Q = new google.maps.LatLngBounds();
				for (var U = 0; U < J.length; U++)
					if (J[U].getVisible() || !this.getIgnoreHidden()) Q.extend(J[U].getPosition());
				this.getMap().fitBounds(Q, q);
			}),
			($.prototype.getGridSize = function () {
				return this.gridSize_;
			}),
			($.prototype.setGridSize = function (q) {
				this.gridSize_ = q;
			}),
			($.prototype.getMinimumClusterSize = function () {
				return this.minClusterSize_;
			}),
			($.prototype.setMinimumClusterSize = function (q) {
				this.minClusterSize_ = q;
			}),
			($.prototype.getMaxZoom = function () {
				return this.maxZoom_;
			}),
			($.prototype.setMaxZoom = function (q) {
				this.maxZoom_ = q;
			}),
			($.prototype.getZIndex = function () {
				return this.zIndex_;
			}),
			($.prototype.setZIndex = function (q) {
				this.zIndex_ = q;
			}),
			($.prototype.getStyles = function () {
				return this.styles_;
			}),
			($.prototype.setStyles = function (q) {
				this.styles_ = q;
			}),
			($.prototype.getTitle = function () {
				return this.title_;
			}),
			($.prototype.setTitle = function (q) {
				this.title_ = q;
			}),
			($.prototype.getZoomOnClick = function () {
				return this.zoomOnClick_;
			}),
			($.prototype.setZoomOnClick = function (q) {
				this.zoomOnClick_ = q;
			}),
			($.prototype.getAverageCenter = function () {
				return this.averageCenter_;
			}),
			($.prototype.setAverageCenter = function (q) {
				this.averageCenter_ = q;
			}),
			($.prototype.getIgnoreHidden = function () {
				return this.ignoreHidden_;
			}),
			($.prototype.setIgnoreHidden = function (q) {
				this.ignoreHidden_ = q;
			}),
			($.prototype.getEnableRetinaIcons = function () {
				return this.enableRetinaIcons_;
			}),
			($.prototype.setEnableRetinaIcons = function (q) {
				this.enableRetinaIcons_ = q;
			}),
			($.prototype.getImageExtension = function () {
				return this.imageExtension_;
			}),
			($.prototype.setImageExtension = function (q) {
				this.imageExtension_ = q;
			}),
			($.prototype.getImagePath = function () {
				return this.imagePath_;
			}),
			($.prototype.setImagePath = function (q) {
				this.imagePath_ = q;
			}),
			($.prototype.getImageSizes = function () {
				return this.imageSizes_;
			}),
			($.prototype.setImageSizes = function (q) {
				this.imageSizes_ = q;
			}),
			($.prototype.getCalculator = function () {
				return this.calculator_;
			}),
			($.prototype.setCalculator = function (q) {
				this.calculator_ = q;
			}),
			($.prototype.getBatchSizeIE = function () {
				return this.batchSizeIE_;
			}),
			($.prototype.setBatchSizeIE = function (q) {
				this.batchSizeIE_ = q;
			}),
			($.prototype.getClusterClass = function () {
				return this.clusterClass_;
			}),
			($.prototype.setClusterClass = function (q) {
				this.clusterClass_ = q;
			}),
			($.prototype.getMarkers = function () {
				return this.markers_;
			}),
			($.prototype.getTotalMarkers = function () {
				return this.markers_.length;
			}),
			($.prototype.getClusters = function () {
				return this.clusters_;
			}),
			($.prototype.getTotalClusters = function () {
				return this.clusters_.length;
			}),
			($.prototype.addMarker = function (q, J) {
				if ((this.pushMarkerTo_(q), !J)) this.redraw_();
			}),
			($.prototype.addMarkers = function (q, J) {
				for (var Q in q) if (Object.prototype.hasOwnProperty.call(q, Q)) this.pushMarkerTo_(q[Q]);
				if (!J) this.redraw_();
			}),
			($.prototype.pushMarkerTo_ = function (q) {
				var J = this;
				if (q.getDraggable())
					google.maps.event.addListener(q, 'dragend', function () {
						if (J.ready_) (q.isAdded = !1), J.repaint();
					});
				(q.isAdded = !1), this.markers_.push(q);
			}),
			($.prototype.removeMarker = function (q, J) {
				var Q = this.removeMarker_(q);
				if (!J && Q) this.repaint();
				return Q;
			}),
			($.prototype.removeMarkers = function (q, J) {
				var Q = !1;
				for (var U = 0; U < q.length; U++) {
					var K = this.removeMarker_(q[U]);
					Q = Q || K;
				}
				if (!J && Q) this.repaint();
				return Q;
			}),
			($.prototype.removeMarker_ = function (q) {
				var J = -1;
				if (this.markers_.indexOf) J = this.markers_.indexOf(q);
				else
					for (var Q = 0; Q < this.markers_.length; Q++)
						if (q === this.markers_[Q]) {
							J = Q;
							break;
						}
				if (J === -1) return !1;
				return q.setMap(null), this.markers_.splice(J, 1), !0;
			}),
			($.prototype.clearMarkers = function () {
				this.resetViewport_(!0), (this.markers_ = []);
			}),
			($.prototype.repaint = function () {
				var q = this.clusters_.slice();
				(this.clusters_ = []),
					this.resetViewport_(!1),
					this.redraw_(),
					setTimeout(function () {
						for (var J = 0; J < q.length; J++) q[J].remove();
					}, 0);
			}),
			($.prototype.getExtendedBounds = function (q) {
				var J = this.getProjection(),
					Q = new google.maps.LatLng(q.getNorthEast().lat(), q.getNorthEast().lng()),
					U = new google.maps.LatLng(q.getSouthWest().lat(), q.getSouthWest().lng()),
					K = J.fromLatLngToDivPixel(Q);
				(K.x += this.gridSize_), (K.y -= this.gridSize_);
				var j = J.fromLatLngToDivPixel(U);
				(j.x -= this.gridSize_), (j.y += this.gridSize_);
				var Z = J.fromDivPixelToLatLng(K),
					O = J.fromDivPixelToLatLng(j);
				return q.extend(Z), q.extend(O), q;
			}),
			($.prototype.redraw_ = function () {
				this.createClusters_(0);
			}),
			($.prototype.resetViewport_ = function (q) {
				for (var J = 0; J < this.clusters_.length; J++) this.clusters_[J].remove();
				this.clusters_ = [];
				for (var J = 0; J < this.markers_.length; J++) {
					var Q = this.markers_[J];
					if (((Q.isAdded = !1), q)) Q.setMap(null);
				}
			}),
			($.prototype.distanceBetweenPoints_ = function (q, J) {
				var Q = 6371,
					U = ((J.lat() - q.lat()) * Math.PI) / 180,
					K = ((J.lng() - q.lng()) * Math.PI) / 180,
					j =
						Math.sin(U / 2) * Math.sin(U / 2) +
						Math.cos((q.lat() * Math.PI) / 180) *
							Math.cos((J.lat() * Math.PI) / 180) *
							Math.sin(K / 2) *
							Math.sin(K / 2),
					Z = 2 * Math.atan2(Math.sqrt(j), Math.sqrt(1 - j));
				return Q * Z;
			}),
			($.prototype.isMarkerInBounds_ = function (q, J) {
				return J.contains(q.getPosition());
			}),
			($.prototype.addToClosestCluster_ = function (q) {
				var J = 40000,
					Q = null;
				for (var U = 0; U < this.clusters_.length; U++) {
					var K = this.clusters_[U],
						j = K.getCenter();
					if (j) {
						var Z = this.distanceBetweenPoints_(j, q.getPosition());
						if (Z < J) (J = Z), (Q = K);
					}
				}
				if (Q && Q.isMarkerInClusterBounds(q)) Q.addMarker(q);
				else {
					var K = new rf(this);
					K.addMarker(q), this.clusters_.push(K);
				}
			}),
			($.prototype.createClusters_ = function (q) {
				var J = this;
				if (!this.ready_) return;
				if (q === 0) {
					if (
						(google.maps.event.trigger(this, 'clusteringbegin', this),
						typeof this.timerRefStatic !== 'undefined')
					)
						clearTimeout(this.timerRefStatic), delete this.timerRefStatic;
				}
				var Q = new google.maps.LatLngBounds(
						this.getMap().getBounds().getSouthWest(),
						this.getMap().getBounds().getNorthEast(),
					),
					U = this.getExtendedBounds(Q),
					K = Math.min(q + this.batchSize_, this.markers_.length);
				for (var j = q; j < K; j++) {
					var Z = this.markers_[j];
					if (!Z.isAdded && this.isMarkerInBounds_(Z, U)) {
						if (!this.ignoreHidden_ || (this.ignoreHidden_ && Z.getVisible())) this.addToClosestCluster_(Z);
					}
				}
				if (K < this.markers_.length)
					this.timerRefStatic = window.setTimeout(function () {
						J.createClusters_(K);
					}, 0);
				else {
					delete this.timerRefStatic, google.maps.event.trigger(this, 'clusteringend', this);
					for (var j = 0; j < this.clusters_.length; j++) this.clusters_[j].updateIcon();
				}
			}),
			($.CALCULATOR = function (q, J) {
				var Q = 0,
					U = q.length,
					K = U;
				while (K !== 0) (K = Math.floor(K / 10)), Q++;
				return (Q = Math.min(Q, J)), { text: U.toString(), index: Q, title: '' };
			}),
			($.withDefaultStyle = function (q) {
				return a(
					{
						textColor: 'black',
						textSize: 11,
						textDecoration: 'none',
						textLineHeight: q.height,
						fontWeight: 'bold',
						fontStyle: 'normal',
						fontFamily: 'Arial,sans-serif',
						backgroundPosition: '0 0',
					},
					q,
				);
			}),
			($.BATCH_SIZE = 2000),
			($.BATCH_SIZE_IE = 500),
			($.IMAGE_PATH = '../images/m'),
			($.IMAGE_EXTENSION = 'png'),
			($.IMAGE_SIZES = [53, 56, 66, 78, 90]),
			$
		);
	})(Of);
var sf = (f, $) => {
		let q = s[`cluster_${$}`] || s[$] || s.active;
		return {
			styles: [
				{ url: f + q, height: 50, width: 50, textColor: 'transparent', textSize: 12, anchorText: [15, 0] },
			],
		};
	},
	Vf = ({ google: f, config: $, $map: q, assetsUrl: J, lang: Q }) => {
		let U = {
				...$,
				maxZoom: 30,
				mapTypeControl: !1,
				center: { lat: V0.lat, lng: V0.lon },
				restriction: { latLngBounds: Uf, strictBounds: !0 },
				styles: B0,
			},
			K = new f.maps.Map(q, {
				...U,
				mapTypeControl: !1,
				zoomControl: !1,
				streetViewControl: !1,
				rotateControl: !1,
				fullscreenControl: !1,
			});
		(window.resetToInitialState = () => {
			K.setOptions({ styles: B0 }), K.setZoom(11);
		}),
			(window.setMapActiveBackground = () => {
				K.setOptions({ styles: jf });
			}),
			(window.currentlyActiveMarker = null),
			(window.currentlyDefaultMarker = null);
		let j = [],
			Z = ({ lat: N, lon: A, type: F, name_uk: R, name_en: W, iconUrl: H, size: X = 'md', id: Y, ..._ }) => {
				if (!s[F] && !H) return null;
				let L = { lg: 50, md: 40, xl: 70 },
					D = { url: J + (s[F] || H), size: L[X] || L.md },
					T = { url: J + (Zf[F] || H), size: L.xl || L.md },
					B = {
						url: D.url,
						anchor: new f.maps.Point(D.size / 2, D.size),
						scaledSize: new f.maps.Size(D.size, D.size),
						border: { width: 2, color: '#000000' },
					},
					P = {
						url: T.url,
						anchor: new f.maps.Point(T.size / 2, T.size),
						scaledSize: new f.maps.Size(T.size, T.size),
						border: { width: 2, color: '#000000' },
					},
					G = new f.maps.Marker({
						map: null,
						position: new f.maps.LatLng(N, A),
						className: `marker-${F}`,
						icon: D ? B : null,
					});
				G.addListener('click', (M) => {
					j.forEach((m) => {
						m.close(null);
					}),
						(j = [...j]),
						M.domEvent?.preventDefault(),
						M.domEvent?.stopPropagation(),
						document.querySelector('.js-map-marker-popup').classList.add('map_popup--open_state');
					let h = G.getPosition(),
						b = h.lng() + 0.01,
						g = { lat: h.lat(), lng: b };
					if (
						(K.setCenter(g),
						K.setZoom(15),
						window.currentlyActiveMarker && window.currentlyActiveMarker !== G)
					)
						window.currentlyActiveMarker.setIcon(window.currentlyDefaultMarker);
					(window.currentlyDefaultMarker = B),
						G.setIcon(P),
						window.setMapActiveBackground(),
						(window.currentlyActiveMarker = G),
						q.closest('.js-map-section').classList.add('map--open_mod'),
						window.markerClickHandler(Y);
				}),
					(G.id = Y),
					(G.type = F);
				for (let M in _) if (Object.hasOwnProperty.call(_, M)) G[M] = _[M];
				return G;
			},
			O = $.markers.map(Z).filter((N) => N),
			V = O.reduce((N, A) => {
				let F = A.type;
				if (!N[F]) N[F] = [];
				return N[F].push(A), N;
			}, {}),
			y = {};
		for (let N in V)
			if (V[N].length > 0) {
				let A = sf(J, N);
				y[N] = new Af(K, V[N], A);
			}
		return (window.markerClusterers = y), { map: K, markers: O };
	};
var ef = () => {
		let f = {
				filterOpenBtn: '.js-map-filters-trigger',
				filterPopup: '.js-map-filters-popup',
				markerPopup: '.js-map-marker-popup',
				popupClose: '.js-map-popup-close',
				clearFilters: '.js-clear-filters',
				filtersBlock: '.js-filter-block',
				reviewBtn: '.js-map-review-add',
				reviewBack: '.js-map-review-back',
				map: '.js-map',
				mapSection: '.js-map-section',
				filterTrigger: '.js-filter-trigger',
			},
			$ = {
				popupOpenState: 'map_popup--open_state',
				mapActiveMarkerState: 'map--open_mod',
				popupReviewState: 'map_popup--review_mod',
			},
			q = new l({ apiKey: Kf, version: 'weekly', libraries: ['places'] }),
			J = document.querySelectorAll(f.mapSection),
			Q = document.querySelector(f.filterOpenBtn),
			U = document.querySelector(f.filterPopup),
			K = document.querySelector(f.markerPopup),
			j = document.querySelectorAll(f.popupClose),
			Z = document.querySelector(f.reviewBtn),
			O = document.querySelectorAll(f.reviewBack),
			V = null;
		Z.addEventListener('click', () => {
			K.classList.add($.popupReviewState);
		}),
			O.forEach((H) => {
				H.addEventListener('click', () => {
					K.classList.remove($.popupReviewState);
				});
			}),
			Q.addEventListener('click', () => {
				U.classList.add($.popupOpenState), window.setMapActiveBackground();
			}),
			j.forEach((H) => {
				H.addEventListener('click', () => {
					if (
						(U.classList.remove($.popupOpenState),
						K.classList.remove($.popupOpenState),
						H.closest(f.mapSection).classList.remove($.mapActiveMarkerState),
						window.resetToInitialState(),
						window.currentlyActiveMarker)
					)
						window.currentlyActiveMarker.setIcon(window.currentlyDefaultMarker),
							(window.currentlyActiveMarker = null);
				});
			});
		let y = {},
			N = document.querySelectorAll('.js-filter-checkbox'),
			A = () => {
				V?.markers?.forEach((H, X) => {
					if (
						(H.setVisible(!0),
						!Object.keys(y).every((L) => {
							let D = y[L];
							if (L === 'district') {
								if (D.length > 0) return D.includes(H.district);
								return !0;
							}
							if (D === !0) {
								let T = H[L];
								if (typeof T === 'boolean') return T === !0;
								if (Array.isArray(T)) return T.length > 0;
								return !!T;
							}
							return !0;
						}))
					)
						H.setVisible(!1);
				});
			},
			F = (H, X, Y) => {
				if (H === 'district')
					if (Y) {
						if (!y[H]) y[H] = [];
						if (!y[H].includes(X)) y[H].push(X);
					} else y[H] = y[H].filter((_) => _ !== X);
				else y[H] = Y;
				A(), console.log('filters::'), console.log(y);
			},
			R = document.querySelector(f.clearFilters),
			W = () => {
				N.forEach((H) => {
					H.checked = !1;
				}),
					Object.keys(y).forEach((H) => {
						y[H] = H === 'district' ? [] : !1;
					}),
					A();
			};
		R?.addEventListener('click', W),
			N.forEach((H) => {
				H.addEventListener('change', (X) => {
					let Y = X.target.checked,
						_ = H.dataset.filter,
						L = H.dataset.key,
						D = H.closest(f.filtersBlock),
						T = D.querySelectorAll('.js-filter-checkbox:not([data-filter="all"])');
					if (_ === 'all')
						T.forEach((B) => {
							(B.checked = Y), F(B.dataset.filter, B.dataset.key, Y);
						});
					else {
						let B = D.querySelector('[data-filter="all"]'),
							P = Array.from(T).every((G) => G.checked);
						(B.checked = P), F(_, L, Y);
					}
				});
			}),
			fetch(shelterMapData.home + '/wp-json/shelters/v1/list')
				.then((H) => H.json())
				.then((H) => {
					q.load()
						.then((X) => {
							J.forEach((Y) => {
								let _ = Y.querySelector(f.map);
								(V = Vf({
									google: X,
									config: { markers: H, zoom: 11 },
									$map: _,
									prevInstance: V,
									assetsUrl: Y.dataset.assetsUrl || '',
									lang: Y.dataset.lang || 'en',
								})),
									A();
							});
						})
						.catch((X) => {
							console.log(X);
						});
				})
				.catch((H) => {
					console.error('Error loading markers:', H);
				});
	},
	Ff = ef;
function Nf(f) {
	return f !== null && typeof f === 'object' && 'constructor' in f && f.constructor === Object;
}
function h0(f = {}, $ = {}) {
	let q = ['__proto__', 'constructor', 'prototype'];
	Object.keys($)
		.filter((J) => q.indexOf(J) < 0)
		.forEach((J) => {
			if (typeof f[J] === 'undefined') f[J] = $[J];
			else if (Nf($[J]) && Nf(f[J]) && Object.keys($[J]).length > 0) h0(f[J], $[J]);
		});
}
var Hf = {
	body: {},
	addEventListener() {},
	removeEventListener() {},
	activeElement: { blur() {}, nodeName: '' },
	querySelector() {
		return null;
	},
	querySelectorAll() {
		return [];
	},
	getElementById() {
		return null;
	},
	createEvent() {
		return { initEvent() {} };
	},
	createElement() {
		return {
			children: [],
			childNodes: [],
			style: {},
			setAttribute() {},
			getElementsByTagName() {
				return [];
			},
		};
	},
	createElementNS() {
		return {};
	},
	importNode() {
		return null;
	},
	location: {
		hash: '',
		host: '',
		hostname: '',
		href: '',
		origin: '',
		pathname: '',
		protocol: '',
		search: '',
	},
};
function v() {
	let f = typeof document !== 'undefined' ? document : {};
	return h0(f, Hf), f;
}
var f1 = {
	document: Hf,
	navigator: { userAgent: '' },
	location: {
		hash: '',
		host: '',
		hostname: '',
		href: '',
		origin: '',
		pathname: '',
		protocol: '',
		search: '',
	},
	history: { replaceState() {}, pushState() {}, go() {}, back() {} },
	CustomEvent: function f() {
		return this;
	},
	addEventListener() {},
	removeEventListener() {},
	getComputedStyle() {
		return {
			getPropertyValue() {
				return '';
			},
		};
	},
	Image() {},
	Date() {},
	screen: {},
	setTimeout() {},
	clearTimeout() {},
	matchMedia() {
		return {};
	},
	requestAnimationFrame(f) {
		if (typeof setTimeout === 'undefined') return f(), null;
		return setTimeout(f, 0);
	},
	cancelAnimationFrame(f) {
		if (typeof setTimeout === 'undefined') return;
		clearTimeout(f);
	},
};
function C() {
	let f = typeof window !== 'undefined' ? window : {};
	return h0(f, f1), f;
}
function Rf(f = '') {
	return f
		.trim()
		.split(' ')
		.filter(($) => !!$.trim());
}
function Yf(f) {
	let $ = f;
	Object.keys($).forEach((q) => {
		try {
			$[q] = null;
		} catch (J) {}
		try {
			delete $[q];
		} catch (J) {}
	});
}
function e(f, $ = 0) {
	return setTimeout(f, $);
}
function p() {
	return Date.now();
}
function q1(f) {
	let $ = C(),
		q;
	if ($.getComputedStyle) q = $.getComputedStyle(f, null);
	if (!q && f.currentStyle) q = f.currentStyle;
	if (!q) q = f.style;
	return q;
}
function z0(f, $ = 'x') {
	let q = C(),
		J,
		Q,
		U,
		K = q1(f);
	if (q.WebKitCSSMatrix) {
		if (((Q = K.transform || K.webkitTransform), Q.split(',').length > 6))
			Q = Q.split(', ')
				.map((j) => j.replace(',', '.'))
				.join(', ');
		U = new q.WebKitCSSMatrix(Q === 'none' ? '' : Q);
	} else
		(U =
			K.MozTransform ||
			K.OTransform ||
			K.MsTransform ||
			K.msTransform ||
			K.transform ||
			K.getPropertyValue('transform').replace('translate(', 'matrix(1, 0, 0, 1,')),
			(J = U.toString().split(','));
	if ($ === 'x')
		if (q.WebKitCSSMatrix) Q = U.m41;
		else if (J.length === 16) Q = parseFloat(J[12]);
		else Q = parseFloat(J[4]);
	if ($ === 'y')
		if (q.WebKitCSSMatrix) Q = U.m42;
		else if (J.length === 16) Q = parseFloat(J[13]);
		else Q = parseFloat(J[5]);
	return Q || 0;
}
function J0(f) {
	return (
		typeof f === 'object' &&
		f !== null &&
		f.constructor &&
		Object.prototype.toString.call(f).slice(8, -1) === 'Object'
	);
}
function $1(f) {
	if (typeof window !== 'undefined' && typeof window.HTMLElement !== 'undefined')
		return f instanceof HTMLElement;
	return f && (f.nodeType === 1 || f.nodeType === 11);
}
function c(...f) {
	let $ = Object(f[0]),
		q = ['__proto__', 'constructor', 'prototype'];
	for (let J = 1; J < f.length; J += 1) {
		let Q = f[J];
		if (Q !== void 0 && Q !== null && !$1(Q)) {
			let U = Object.keys(Object(Q)).filter((K) => q.indexOf(K) < 0);
			for (let K = 0, j = U.length; K < j; K += 1) {
				let Z = U[K],
					O = Object.getOwnPropertyDescriptor(Q, Z);
				if (O !== void 0 && O.enumerable)
					if (J0($[Z]) && J0(Q[Z]))
						if (Q[Z].__swiper__) $[Z] = Q[Z];
						else c($[Z], Q[Z]);
					else if (!J0($[Z]) && J0(Q[Z]))
						if ((($[Z] = {}), Q[Z].__swiper__)) $[Z] = Q[Z];
						else c($[Z], Q[Z]);
					else $[Z] = Q[Z];
			}
		}
	}
	return $;
}
function f0(f, $, q) {
	f.style.setProperty($, q);
}
function C0({ swiper: f, targetPosition: $, side: q }) {
	let J = C(),
		Q = -f.translate,
		U = null,
		K,
		j = f.params.speed;
	(f.wrapperEl.style.scrollSnapType = 'none'), J.cancelAnimationFrame(f.cssModeFrameID);
	let Z = $ > Q ? 'next' : 'prev',
		O = (y, N) => {
			return (Z === 'next' && y >= N) || (Z === 'prev' && y <= N);
		},
		V = () => {
			if (((K = new Date().getTime()), U === null)) U = K;
			let y = Math.max(Math.min((K - U) / j, 1), 0),
				N = 0.5 - Math.cos(y * Math.PI) / 2,
				A = Q + N * ($ - Q);
			if (O(A, $)) A = $;
			if ((f.wrapperEl.scrollTo({ [q]: A }), O(A, $))) {
				(f.wrapperEl.style.overflow = 'hidden'),
					(f.wrapperEl.style.scrollSnapType = ''),
					setTimeout(() => {
						(f.wrapperEl.style.overflow = ''), f.wrapperEl.scrollTo({ [q]: A });
					}),
					J.cancelAnimationFrame(f.cssModeFrameID);
				return;
			}
			f.cssModeFrameID = J.requestAnimationFrame(V);
		};
	V();
}
function I(f, $ = '') {
	let q = C(),
		J = [...f.children];
	if (q.HTMLSlotElement && f instanceof HTMLSlotElement) J.push(...f.assignedElements());
	if (!$) return J;
	return J.filter((Q) => Q.matches($));
}
function J1(f, $) {
	let q = [$];
	while (q.length > 0) {
		let J = q.shift();
		if (f === J) return !0;
		q.push(
			...J.children,
			...(J.shadowRoot ? J.shadowRoot.children : []),
			...(J.assignedElements ? J.assignedElements() : []),
		);
	}
}
function Xf(f, $) {
	let q = C(),
		J = $.contains(f);
	if (!J && q.HTMLSlotElement && $ instanceof HTMLSlotElement) {
		if (((J = [...$.assignedElements()].includes(f)), !J)) J = J1(f, $);
	}
	return J;
}
function Q0(f) {
	try {
		console.warn(f);
		return;
	} catch ($) {}
}
function o(f, $ = []) {
	let q = document.createElement(f);
	return q.classList.add(...(Array.isArray($) ? $ : Rf($))), q;
}
function Wf(f, $) {
	let q = [];
	while (f.previousElementSibling) {
		let J = f.previousElementSibling;
		if ($) {
			if (J.matches($)) q.push(J);
		} else q.push(J);
		f = J;
	}
	return q;
}
function _f(f, $) {
	let q = [];
	while (f.nextElementSibling) {
		let J = f.nextElementSibling;
		if ($) {
			if (J.matches($)) q.push(J);
		} else q.push(J);
		f = J;
	}
	return q;
}
function t(f, $) {
	return C().getComputedStyle(f, null).getPropertyValue($);
}
function U0(f) {
	let $ = f,
		q;
	if ($) {
		q = 0;
		while (($ = $.previousSibling) !== null) if ($.nodeType === 1) q += 1;
		return q;
	}
	return;
}
function Z0(f, $) {
	let q = [],
		J = f.parentElement;
	while (J) {
		if ($) {
			if (J.matches($)) q.push(J);
		} else q.push(J);
		J = J.parentElement;
	}
	return q;
}
function N0(f, $, q) {
	let J = C();
	if (q)
		return (
			f[$ === 'width' ? 'offsetWidth' : 'offsetHeight'] +
			parseFloat(
				J.getComputedStyle(f, null).getPropertyValue($ === 'width' ? 'margin-right' : 'margin-top'),
			) +
			parseFloat(
				J.getComputedStyle(f, null).getPropertyValue($ === 'width' ? 'margin-left' : 'margin-bottom'),
			)
		);
	return f.offsetWidth;
}
function u(f) {
	return (Array.isArray(f) ? f : [f]).filter(($) => !!$);
}
function q0(f, $ = '') {
	if (typeof trustedTypes !== 'undefined')
		f.innerHTML = trustedTypes.createPolicy('html', { createHTML: (q) => q }).createHTML($);
	else f.innerHTML = $;
}
var P0;
function Q1() {
	let f = C(),
		$ = v();
	return {
		smoothScroll: $.documentElement && $.documentElement.style && 'scrollBehavior' in $.documentElement.style,
		touch: !!('ontouchstart' in f || (f.DocumentTouch && $ instanceof f.DocumentTouch)),
	};
}
function Tf() {
	if (!P0) P0 = Q1();
	return P0;
}
var k0;
function U1({ userAgent: f } = {}) {
	let $ = Tf(),
		q = C(),
		J = q.navigator.platform,
		Q = f || q.navigator.userAgent,
		U = { ios: !1, android: !1 },
		K = q.screen.width,
		j = q.screen.height,
		Z = Q.match(/(Android);?[\s\/]+([\d.]+)?/),
		O = Q.match(/(iPad)(?!\1).*OS\s([\d_]+)/),
		V = Q.match(/(iPod)(.*OS\s([\d_]+))?/),
		y = !O && Q.match(/(iPhone\sOS|iOS)\s([\d_]+)/),
		N = J === 'Win32',
		A = J === 'MacIntel',
		F = [
			'1024x1366',
			'1366x1024',
			'834x1194',
			'1194x834',
			'834x1112',
			'1112x834',
			'768x1024',
			'1024x768',
			'820x1180',
			'1180x820',
			'810x1080',
			'1080x810',
		];
	if (!O && A && $.touch && F.indexOf(`${K}x${j}`) >= 0) {
		if (((O = Q.match(/(Version)\/([\d.]+)/)), !O)) O = [0, 1, '13_0_0'];
		A = !1;
	}
	if (Z && !N) (U.os = 'android'), (U.android = !0);
	if (O || y || V) (U.os = 'ios'), (U.ios = !0);
	return U;
}
function hf(f = {}) {
	if (!k0) k0 = U1(f);
	return k0;
}
var I0;
function Z1() {
	let f = C(),
		$ = hf(),
		q = !1;
	function J() {
		let j = f.navigator.userAgent.toLowerCase();
		return j.indexOf('safari') >= 0 && j.indexOf('chrome') < 0 && j.indexOf('android') < 0;
	}
	if (J()) {
		let j = String(f.navigator.userAgent);
		if (j.includes('Version/')) {
			let [Z, O] = j
				.split('Version/')[1]
				.split(' ')[0]
				.split('.')
				.map((V) => Number(V));
			q = Z < 16 || (Z === 16 && O < 2);
		}
	}
	let Q = /(iPhone|iPod|iPad).*AppleWebKit(?!.*Safari)/i.test(f.navigator.userAgent),
		U = J(),
		K = U || (Q && $.ios);
	return { isSafari: q || U, needPerspectiveFix: q, need3dFix: K, isWebView: Q };
}
function zf() {
	if (!I0) I0 = Z1();
	return I0;
}
function K1({ swiper: f, on: $, emit: q }) {
	let J = C(),
		Q = null,
		U = null,
		K = () => {
			if (!f || f.destroyed || !f.initialized) return;
			q('beforeResize'), q('resize');
		},
		j = () => {
			if (!f || f.destroyed || !f.initialized) return;
			(Q = new ResizeObserver((V) => {
				U = J.requestAnimationFrame(() => {
					let { width: y, height: N } = f,
						A = y,
						F = N;
					if (
						(V.forEach(({ contentBoxSize: R, contentRect: W, target: H }) => {
							if (H && H !== f.el) return;
							(A = W ? W.width : (R[0] || R).inlineSize), (F = W ? W.height : (R[0] || R).blockSize);
						}),
						A !== y || F !== N)
					)
						K();
				});
			})),
				Q.observe(f.el);
		},
		Z = () => {
			if (U) J.cancelAnimationFrame(U);
			if (Q && Q.unobserve && f.el) Q.unobserve(f.el), (Q = null);
		},
		O = () => {
			if (!f || f.destroyed || !f.initialized) return;
			q('orientationchange');
		};
	$('init', () => {
		if (f.params.resizeObserver && typeof J.ResizeObserver !== 'undefined') {
			j();
			return;
		}
		J.addEventListener('resize', K), J.addEventListener('orientationchange', O);
	}),
		$('destroy', () => {
			Z(), J.removeEventListener('resize', K), J.removeEventListener('orientationchange', O);
		});
}
function j1({ swiper: f, extendParams: $, on: q, emit: J }) {
	let Q = [],
		U = C(),
		K = (O, V = {}) => {
			let N = new (U.MutationObserver || U.WebkitMutationObserver)((A) => {
				if (f.__preventObserver__) return;
				if (A.length === 1) {
					J('observerUpdate', A[0]);
					return;
				}
				let F = function R() {
					J('observerUpdate', A[0]);
				};
				if (U.requestAnimationFrame) U.requestAnimationFrame(F);
				else U.setTimeout(F, 0);
			});
			N.observe(O, {
				attributes: typeof V.attributes === 'undefined' ? !0 : V.attributes,
				childList: f.isElement || (typeof V.childList === 'undefined' ? !0 : V).childList,
				characterData: typeof V.characterData === 'undefined' ? !0 : V.characterData,
			}),
				Q.push(N);
		},
		j = () => {
			if (!f.params.observer) return;
			if (f.params.observeParents) {
				let O = Z0(f.hostEl);
				for (let V = 0; V < O.length; V += 1) K(O[V]);
			}
			K(f.hostEl, { childList: f.params.observeSlideChildren }), K(f.wrapperEl, { attributes: !1 });
		},
		Z = () => {
			Q.forEach((O) => {
				O.disconnect();
			}),
				Q.splice(0, Q.length);
		};
	$({ observer: !1, observeParents: !1, observeSlideChildren: !1 }), q('init', j), q('destroy', Z);
}
var y1 = {
	on(f, $, q) {
		let J = this;
		if (!J.eventsListeners || J.destroyed) return J;
		if (typeof $ !== 'function') return J;
		let Q = q ? 'unshift' : 'push';
		return (
			f.split(' ').forEach((U) => {
				if (!J.eventsListeners[U]) J.eventsListeners[U] = [];
				J.eventsListeners[U][Q]($);
			}),
			J
		);
	},
	once(f, $, q) {
		let J = this;
		if (!J.eventsListeners || J.destroyed) return J;
		if (typeof $ !== 'function') return J;
		function Q(...U) {
			if ((J.off(f, Q), Q.__emitterProxy)) delete Q.__emitterProxy;
			$.apply(J, U);
		}
		return (Q.__emitterProxy = $), J.on(f, Q, q);
	},
	onAny(f, $) {
		let q = this;
		if (!q.eventsListeners || q.destroyed) return q;
		if (typeof f !== 'function') return q;
		let J = $ ? 'unshift' : 'push';
		if (q.eventsAnyListeners.indexOf(f) < 0) q.eventsAnyListeners[J](f);
		return q;
	},
	offAny(f) {
		let $ = this;
		if (!$.eventsListeners || $.destroyed) return $;
		if (!$.eventsAnyListeners) return $;
		let q = $.eventsAnyListeners.indexOf(f);
		if (q >= 0) $.eventsAnyListeners.splice(q, 1);
		return $;
	},
	off(f, $) {
		let q = this;
		if (!q.eventsListeners || q.destroyed) return q;
		if (!q.eventsListeners) return q;
		return (
			f.split(' ').forEach((J) => {
				if (typeof $ === 'undefined') q.eventsListeners[J] = [];
				else if (q.eventsListeners[J])
					q.eventsListeners[J].forEach((Q, U) => {
						if (Q === $ || (Q.__emitterProxy && Q.__emitterProxy === $)) q.eventsListeners[J].splice(U, 1);
					});
			}),
			q
		);
	},
	emit(...f) {
		let $ = this;
		if (!$.eventsListeners || $.destroyed) return $;
		if (!$.eventsListeners) return $;
		let q, J, Q;
		if (typeof f[0] === 'string' || Array.isArray(f[0])) (q = f[0]), (J = f.slice(1, f.length)), (Q = $);
		else (q = f[0].events), (J = f[0].data), (Q = f[0].context || $);
		return (
			J.unshift(Q),
			(Array.isArray(q) ? q : q.split(' ')).forEach((K) => {
				if ($.eventsAnyListeners && $.eventsAnyListeners.length)
					$.eventsAnyListeners.forEach((j) => {
						j.apply(Q, [K, ...J]);
					});
				if ($.eventsListeners && $.eventsListeners[K])
					$.eventsListeners[K].forEach((j) => {
						j.apply(Q, J);
					});
			}),
			$
		);
	},
};
function O1() {
	let f = this,
		$,
		q,
		J = f.el;
	if (typeof f.params.width !== 'undefined' && f.params.width !== null) $ = f.params.width;
	else $ = J.clientWidth;
	if (typeof f.params.height !== 'undefined' && f.params.height !== null) q = f.params.height;
	else q = J.clientHeight;
	if (($ === 0 && f.isHorizontal()) || (q === 0 && f.isVertical())) return;
	if (
		(($ = $ - parseInt(t(J, 'padding-left') || 0, 10) - parseInt(t(J, 'padding-right') || 0, 10)),
		(q = q - parseInt(t(J, 'padding-top') || 0, 10) - parseInt(t(J, 'padding-bottom') || 0, 10)),
		Number.isNaN($))
	)
		$ = 0;
	if (Number.isNaN(q)) q = 0;
	Object.assign(f, { width: $, height: q, size: f.isHorizontal() ? $ : q });
}
function A1() {
	let f = this;
	function $(G, M) {
		return parseFloat(G.getPropertyValue(f.getDirectionLabel(M)) || 0);
	}
	let q = f.params,
		{ wrapperEl: J, slidesEl: Q, rtlTranslate: U, wrongRTL: K } = f,
		j = f.virtual && q.virtual.enabled,
		Z = j ? f.virtual.slides.length : f.slides.length,
		O = I(Q, `.${f.params.slideClass}, swiper-slide`),
		V = j ? f.virtual.slides.length : O.length,
		y = [],
		N = [],
		A = [],
		F = q.slidesOffsetBefore;
	if (typeof F === 'function') F = q.slidesOffsetBefore.call(f);
	let R = q.slidesOffsetAfter;
	if (typeof R === 'function') R = q.slidesOffsetAfter.call(f);
	let W = f.snapGrid.length,
		H = f.slidesGrid.length,
		X = f.size - F - R,
		Y = q.spaceBetween,
		_ = -F,
		L = 0,
		D = 0;
	if (typeof X === 'undefined') return;
	if (typeof Y === 'string' && Y.indexOf('%') >= 0) Y = (parseFloat(Y.replace('%', '')) / 100) * X;
	else if (typeof Y === 'string') Y = parseFloat(Y);
	if (
		((f.virtualSize = -Y - F - R),
		O.forEach((G) => {
			if (U) G.style.marginLeft = '';
			else G.style.marginRight = '';
			(G.style.marginBottom = ''), (G.style.marginTop = '');
		}),
		q.centeredSlides && q.cssMode)
	)
		f0(J, '--swiper-centered-offset-before', ''), f0(J, '--swiper-centered-offset-after', '');
	let T = q.grid && q.grid.rows > 1 && f.grid;
	if (T) f.grid.initSlides(O);
	else if (f.grid) f.grid.unsetSlides();
	let B,
		P =
			q.slidesPerView === 'auto' &&
			q.breakpoints &&
			Object.keys(q.breakpoints).filter((G) => {
				return typeof q.breakpoints[G].slidesPerView !== 'undefined';
			}).length > 0;
	for (let G = 0; G < V; G += 1) {
		B = 0;
		let M = O[G];
		if (M) {
			if (T) f.grid.updateSlide(G, M, O);
			if (t(M, 'display') === 'none') continue;
		}
		if (j && q.slidesPerView === 'auto') {
			if (q.virtual.slidesPerViewAutoSlideSize) B = q.virtual.slidesPerViewAutoSlideSize;
			if (B && M) {
				if (q.roundLengths) B = Math.floor(B);
				M.style[f.getDirectionLabel('width')] = `${B}px`;
			}
		} else if (q.slidesPerView === 'auto') {
			if (P) M.style[f.getDirectionLabel('width')] = '';
			let h = getComputedStyle(M),
				b = M.style.transform,
				g = M.style.webkitTransform;
			if (b) M.style.transform = 'none';
			if (g) M.style.webkitTransform = 'none';
			if (q.roundLengths) B = f.isHorizontal() ? N0(M, 'width', !0) : N0(M, 'height', !0);
			else {
				let m = $(h, 'width'),
					o0 = $(h, 'padding-left'),
					w = $(h, 'padding-right'),
					z = $(h, 'margin-left'),
					k = $(h, 'margin-right'),
					x = h.getPropertyValue('box-sizing');
				if (x && x === 'border-box') B = m + z + k;
				else {
					let { clientWidth: n, offsetWidth: gf } = M;
					B = m + o0 + w + z + k + (gf - n);
				}
			}
			if (b) M.style.transform = b;
			if (g) M.style.webkitTransform = g;
			if (q.roundLengths) B = Math.floor(B);
		} else {
			if (((B = (X - (q.slidesPerView - 1) * Y) / q.slidesPerView), q.roundLengths)) B = Math.floor(B);
			if (M) M.style[f.getDirectionLabel('width')] = `${B}px`;
		}
		if (M) M.swiperSlideSize = B;
		if ((A.push(B), q.centeredSlides)) {
			if (((_ = _ + B / 2 + L / 2 + Y), L === 0 && G !== 0)) _ = _ - X / 2 - Y;
			if (G === 0) _ = _ - X / 2 - Y;
			if (Math.abs(_) < 0.001) _ = 0;
			if (q.roundLengths) _ = Math.floor(_);
			if (D % q.slidesPerGroup === 0) y.push(_);
			N.push(_);
		} else {
			if (q.roundLengths) _ = Math.floor(_);
			if ((D - Math.min(f.params.slidesPerGroupSkip, D)) % f.params.slidesPerGroup === 0) y.push(_);
			N.push(_), (_ = _ + B + Y);
		}
		(f.virtualSize += B + Y), (L = B), (D += 1);
	}
	if (
		((f.virtualSize = Math.max(f.virtualSize, X) + R),
		U && K && (q.effect === 'slide' || q.effect === 'coverflow'))
	)
		J.style.width = `${f.virtualSize + Y}px`;
	if (q.setWrapperSize) J.style[f.getDirectionLabel('width')] = `${f.virtualSize + Y}px`;
	if (T) f.grid.updateWrapperSize(B, y);
	if (!q.centeredSlides) {
		let G = [];
		for (let M = 0; M < y.length; M += 1) {
			let h = y[M];
			if (q.roundLengths) h = Math.floor(h);
			if (y[M] <= f.virtualSize - X) G.push(h);
		}
		if (((y = G), Math.floor(f.virtualSize - X) - Math.floor(y[y.length - 1]) > 1)) y.push(f.virtualSize - X);
	}
	if (j && q.loop) {
		let G = A[0] + Y;
		if (q.slidesPerGroup > 1) {
			let M = Math.ceil((f.virtual.slidesBefore + f.virtual.slidesAfter) / q.slidesPerGroup),
				h = G * q.slidesPerGroup;
			for (let b = 0; b < M; b += 1) y.push(y[y.length - 1] + h);
		}
		for (let M = 0; M < f.virtual.slidesBefore + f.virtual.slidesAfter; M += 1) {
			if (q.slidesPerGroup === 1) y.push(y[y.length - 1] + G);
			N.push(N[N.length - 1] + G), (f.virtualSize += G);
		}
	}
	if (y.length === 0) y = [0];
	if (Y !== 0) {
		let G = f.isHorizontal() && U ? 'marginLeft' : f.getDirectionLabel('marginRight');
		O.filter((M, h) => {
			if (!q.cssMode || q.loop) return !0;
			if (h === O.length - 1) return !1;
			return !0;
		}).forEach((M) => {
			M.style[G] = `${Y}px`;
		});
	}
	if (q.centeredSlides && q.centeredSlidesBounds) {
		let G = 0;
		A.forEach((h) => {
			G += h + (Y || 0);
		}),
			(G -= Y);
		let M = G > X ? G - X : 0;
		y = y.map((h) => {
			if (h <= 0) return -F;
			if (h > M) return M + R;
			return h;
		});
	}
	if (q.centerInsufficientSlides) {
		let G = 0;
		A.forEach((h) => {
			G += h + (Y || 0);
		}),
			(G -= Y);
		let M = (F || 0) + (R || 0);
		if (G + M < X) {
			let h = (X - G - M) / 2;
			y.forEach((b, g) => {
				y[g] = b - h;
			}),
				N.forEach((b, g) => {
					N[g] = b + h;
				});
		}
	}
	if (
		(Object.assign(f, { slides: O, snapGrid: y, slidesGrid: N, slidesSizesGrid: A }),
		q.centeredSlides && q.cssMode && !q.centeredSlidesBounds)
	) {
		f0(J, '--swiper-centered-offset-before', `${-y[0]}px`),
			f0(J, '--swiper-centered-offset-after', `${f.size / 2 - A[A.length - 1] / 2}px`);
		let G = -f.snapGrid[0],
			M = -f.slidesGrid[0];
		(f.snapGrid = f.snapGrid.map((h) => h + G)), (f.slidesGrid = f.slidesGrid.map((h) => h + M));
	}
	if (V !== Z) f.emit('slidesLengthChange');
	if (y.length !== W) {
		if (f.params.watchOverflow) f.checkOverflow();
		f.emit('snapGridLengthChange');
	}
	if (N.length !== H) f.emit('slidesGridLengthChange');
	if (q.watchSlidesProgress) f.updateSlidesOffset();
	if ((f.emit('slidesUpdated'), !j && !q.cssMode && (q.effect === 'slide' || q.effect === 'fade'))) {
		let G = `${q.containerModifierClass}backface-hidden`,
			M = f.el.classList.contains(G);
		if (V <= q.maxBackfaceHiddenSlides) {
			if (!M) f.el.classList.add(G);
		} else if (M) f.el.classList.remove(G);
	}
}
function V1(f) {
	let $ = this,
		q = [],
		J = $.virtual && $.params.virtual.enabled,
		Q = 0,
		U;
	if (typeof f === 'number') $.setTransition(f);
	else if (f === !0) $.setTransition($.params.speed);
	let K = (j) => {
		if (J) return $.slides[$.getSlideIndexByData(j)];
		return $.slides[j];
	};
	if ($.params.slidesPerView !== 'auto' && $.params.slidesPerView > 1)
		if ($.params.centeredSlides)
			($.visibleSlides || []).forEach((j) => {
				q.push(j);
			});
		else
			for (U = 0; U < Math.ceil($.params.slidesPerView); U += 1) {
				let j = $.activeIndex + U;
				if (j > $.slides.length && !J) break;
				q.push(K(j));
			}
	else q.push(K($.activeIndex));
	for (U = 0; U < q.length; U += 1)
		if (typeof q[U] !== 'undefined') {
			let j = q[U].offsetHeight;
			Q = j > Q ? j : Q;
		}
	if (Q || Q === 0) $.wrapperEl.style.height = `${Q}px`;
}
function F1() {
	let f = this,
		$ = f.slides,
		q = f.isElement ? (f.isHorizontal() ? f.wrapperEl.offsetLeft : f.wrapperEl.offsetTop) : 0;
	for (let J = 0; J < $.length; J += 1)
		$[J].swiperSlideOffset =
			(f.isHorizontal() ? $[J].offsetLeft : $[J].offsetTop) - q - f.cssOverflowAdjustment();
}
var Mf = (f, $, q) => {
	if ($ && !f.classList.contains(q)) f.classList.add(q);
	else if (!$ && f.classList.contains(q)) f.classList.remove(q);
};
function N1(f = (this && this.translate) || 0) {
	let $ = this,
		q = $.params,
		{ slides: J, rtlTranslate: Q, snapGrid: U } = $;
	if (J.length === 0) return;
	if (typeof J[0].swiperSlideOffset === 'undefined') $.updateSlidesOffset();
	let K = -f;
	if (Q) K = f;
	($.visibleSlidesIndexes = []), ($.visibleSlides = []);
	let j = q.spaceBetween;
	if (typeof j === 'string' && j.indexOf('%') >= 0) j = (parseFloat(j.replace('%', '')) / 100) * $.size;
	else if (typeof j === 'string') j = parseFloat(j);
	for (let Z = 0; Z < J.length; Z += 1) {
		let O = J[Z],
			V = O.swiperSlideOffset;
		if (q.cssMode && q.centeredSlides) V -= J[0].swiperSlideOffset;
		let y = (K + (q.centeredSlides ? $.minTranslate() : 0) - V) / (O.swiperSlideSize + j),
			N = (K - U[0] + (q.centeredSlides ? $.minTranslate() : 0) - V) / (O.swiperSlideSize + j),
			A = -(K - V),
			F = A + $.slidesSizesGrid[Z],
			R = A >= 0 && A <= $.size - $.slidesSizesGrid[Z],
			W = (A >= 0 && A < $.size - 1) || (F > 1 && F <= $.size) || (A <= 0 && F >= $.size);
		if (W) $.visibleSlides.push(O), $.visibleSlidesIndexes.push(Z);
		Mf(O, W, q.slideVisibleClass),
			Mf(O, R, q.slideFullyVisibleClass),
			(O.progress = Q ? -y : y),
			(O.originalProgress = Q ? -N : N);
	}
}
function H1(f) {
	let $ = this;
	if (typeof f === 'undefined') {
		let V = $.rtlTranslate ? -1 : 1;
		f = ($ && $.translate && $.translate * V) || 0;
	}
	let q = $.params,
		J = $.maxTranslate() - $.minTranslate(),
		{ progress: Q, isBeginning: U, isEnd: K, progressLoop: j } = $,
		Z = U,
		O = K;
	if (J === 0) (Q = 0), (U = !0), (K = !0);
	else {
		Q = (f - $.minTranslate()) / J;
		let V = Math.abs(f - $.minTranslate()) < 1,
			y = Math.abs(f - $.maxTranslate()) < 1;
		if (((U = V || Q <= 0), (K = y || Q >= 1), V)) Q = 0;
		if (y) Q = 1;
	}
	if (q.loop) {
		let V = $.getSlideIndexByData(0),
			y = $.getSlideIndexByData($.slides.length - 1),
			N = $.slidesGrid[V],
			A = $.slidesGrid[y],
			F = $.slidesGrid[$.slidesGrid.length - 1],
			R = Math.abs(f);
		if (R >= N) j = (R - N) / F;
		else j = (R + F - A) / F;
		if (j > 1) j -= 1;
	}
	if (
		(Object.assign($, { progress: Q, progressLoop: j, isBeginning: U, isEnd: K }),
		q.watchSlidesProgress || (q.centeredSlides && q.autoHeight))
	)
		$.updateSlidesProgress(f);
	if (U && !Z) $.emit('reachBeginning toEdge');
	if (K && !O) $.emit('reachEnd toEdge');
	if ((Z && !U) || (O && !K)) $.emit('fromEdge');
	$.emit('progress', Q);
}
var b0 = (f, $, q) => {
	if ($ && !f.classList.contains(q)) f.classList.add(q);
	else if (!$ && f.classList.contains(q)) f.classList.remove(q);
};
function R1() {
	let f = this,
		{ slides: $, params: q, slidesEl: J, activeIndex: Q } = f,
		U = f.virtual && q.virtual.enabled,
		K = f.grid && q.grid && q.grid.rows > 1,
		j = (y) => {
			return I(J, `.${q.slideClass}${y}, swiper-slide${y}`)[0];
		},
		Z,
		O,
		V;
	if (U)
		if (q.loop) {
			let y = Q - f.virtual.slidesBefore;
			if (y < 0) y = f.virtual.slides.length + y;
			if (y >= f.virtual.slides.length) y -= f.virtual.slides.length;
			Z = j(`[data-swiper-slide-index="${y}"]`);
		} else Z = j(`[data-swiper-slide-index="${Q}"]`);
	else if (K)
		(Z = $.find((y) => y.column === Q)),
			(V = $.find((y) => y.column === Q + 1)),
			(O = $.find((y) => y.column === Q - 1));
	else Z = $[Q];
	if (Z) {
		if (!K) {
			if (((V = _f(Z, `.${q.slideClass}, swiper-slide`)[0]), q.loop && !V)) V = $[0];
			if (((O = Wf(Z, `.${q.slideClass}, swiper-slide`)[0]), q.loop && !O === 0)) O = $[$.length - 1];
		}
	}
	$.forEach((y) => {
		b0(y, y === Z, q.slideActiveClass), b0(y, y === V, q.slideNextClass), b0(y, y === O, q.slidePrevClass);
	}),
		f.emitSlidesClasses();
}
var H0 = (f, $) => {
		if (!f || f.destroyed || !f.params) return;
		let q = () => (f.isElement ? 'swiper-slide' : `.${f.params.slideClass}`),
			J = $.closest(q());
		if (J) {
			let Q = J.querySelector(`.${f.params.lazyPreloaderClass}`);
			if (!Q && f.isElement)
				if (J.shadowRoot) Q = J.shadowRoot.querySelector(`.${f.params.lazyPreloaderClass}`);
				else
					requestAnimationFrame(() => {
						if (J.shadowRoot) {
							if (((Q = J.shadowRoot.querySelector(`.${f.params.lazyPreloaderClass}`)), Q)) Q.remove();
						}
					});
			if (Q) Q.remove();
		}
	},
	v0 = (f, $) => {
		if (!f.slides[$]) return;
		let q = f.slides[$].querySelector('[loading="lazy"]');
		if (q) q.removeAttribute('loading');
	},
	c0 = (f) => {
		if (!f || f.destroyed || !f.params) return;
		let $ = f.params.lazyPreloadPrevNext,
			q = f.slides.length;
		if (!q || !$ || $ < 0) return;
		$ = Math.min($, q);
		let J = f.params.slidesPerView === 'auto' ? f.slidesPerViewDynamic() : Math.ceil(f.params.slidesPerView),
			Q = f.activeIndex;
		if (f.params.grid && f.params.grid.rows > 1) {
			let K = Q,
				j = [K - $];
			j.push(
				...Array.from({ length: $ }).map((Z, O) => {
					return K + J + O;
				}),
			),
				f.slides.forEach((Z, O) => {
					if (j.includes(Z.column)) v0(f, O);
				});
			return;
		}
		let U = Q + J - 1;
		if (f.params.rewind || f.params.loop)
			for (let K = Q - $; K <= U + $; K += 1) {
				let j = ((K % q) + q) % q;
				if (j < Q || j > U) v0(f, j);
			}
		else
			for (let K = Math.max(Q - $, 0); K <= Math.min(U + $, q - 1); K += 1)
				if (K !== Q && (K > U || K < Q)) v0(f, K);
	};
function Y1(f) {
	let { slidesGrid: $, params: q } = f,
		J = f.rtlTranslate ? f.translate : -f.translate,
		Q;
	for (let U = 0; U < $.length; U += 1)
		if (typeof $[U + 1] !== 'undefined') {
			if (J >= $[U] && J < $[U + 1] - ($[U + 1] - $[U]) / 2) Q = U;
			else if (J >= $[U] && J < $[U + 1]) Q = U + 1;
		} else if (J >= $[U]) Q = U;
	if (q.normalizeSlideIndex) {
		if (Q < 0 || typeof Q === 'undefined') Q = 0;
	}
	return Q;
}
function X1(f) {
	let $ = this,
		q = $.rtlTranslate ? $.translate : -$.translate,
		{ snapGrid: J, params: Q, activeIndex: U, realIndex: K, snapIndex: j } = $,
		Z = f,
		O,
		V = (A) => {
			let F = A - $.virtual.slidesBefore;
			if (F < 0) F = $.virtual.slides.length + F;
			if (F >= $.virtual.slides.length) F -= $.virtual.slides.length;
			return F;
		};
	if (typeof Z === 'undefined') Z = Y1($);
	if (J.indexOf(q) >= 0) O = J.indexOf(q);
	else {
		let A = Math.min(Q.slidesPerGroupSkip, Z);
		O = A + Math.floor((Z - A) / Q.slidesPerGroup);
	}
	if (O >= J.length) O = J.length - 1;
	if (Z === U && !$.params.loop) {
		if (O !== j) ($.snapIndex = O), $.emit('snapIndexChange');
		return;
	}
	if (Z === U && $.params.loop && $.virtual && $.params.virtual.enabled) {
		$.realIndex = V(Z);
		return;
	}
	let y = $.grid && Q.grid && Q.grid.rows > 1,
		N;
	if ($.virtual && Q.virtual.enabled && Q.loop) N = V(Z);
	else if (y) {
		let A = $.slides.find((R) => R.column === Z),
			F = parseInt(A.getAttribute('data-swiper-slide-index'), 10);
		if (Number.isNaN(F)) F = Math.max($.slides.indexOf(A), 0);
		N = Math.floor(F / Q.grid.rows);
	} else if ($.slides[Z]) {
		let A = $.slides[Z].getAttribute('data-swiper-slide-index');
		if (A) N = parseInt(A, 10);
		else N = Z;
	} else N = Z;
	if (
		(Object.assign($, {
			previousSnapIndex: j,
			snapIndex: O,
			previousRealIndex: K,
			realIndex: N,
			previousIndex: U,
			activeIndex: Z,
		}),
		$.initialized)
	)
		c0($);
	if (
		($.emit('activeIndexChange'), $.emit('snapIndexChange'), $.initialized || $.params.runCallbacksOnInit)
	) {
		if (K !== N) $.emit('realIndexChange');
		$.emit('slideChange');
	}
}
function W1(f, $) {
	let q = this,
		J = q.params,
		Q = f.closest(`.${J.slideClass}, swiper-slide`);
	if (!Q && q.isElement && $ && $.length > 1 && $.includes(f))
		[...$.slice($.indexOf(f) + 1, $.length)].forEach((j) => {
			if (!Q && j.matches && j.matches(`.${J.slideClass}, swiper-slide`)) Q = j;
		});
	let U = !1,
		K;
	if (Q) {
		for (let j = 0; j < q.slides.length; j += 1)
			if (q.slides[j] === Q) {
				(U = !0), (K = j);
				break;
			}
	}
	if (Q && U)
		if (((q.clickedSlide = Q), q.virtual && q.params.virtual.enabled))
			q.clickedIndex = parseInt(Q.getAttribute('data-swiper-slide-index'), 10);
		else q.clickedIndex = K;
	else {
		(q.clickedSlide = void 0), (q.clickedIndex = void 0);
		return;
	}
	if (J.slideToClickedSlide && q.clickedIndex !== void 0 && q.clickedIndex !== q.activeIndex)
		q.slideToClickedSlide();
}
var _1 = {
	updateSize: O1,
	updateSlides: A1,
	updateAutoHeight: V1,
	updateSlidesOffset: F1,
	updateSlidesProgress: N1,
	updateProgress: H1,
	updateSlidesClasses: R1,
	updateActiveIndex: X1,
	updateClickedSlide: W1,
};
function M1(f = this.isHorizontal() ? 'x' : 'y') {
	let $ = this,
		{ params: q, rtlTranslate: J, translate: Q, wrapperEl: U } = $;
	if (q.virtualTranslate) return J ? -Q : Q;
	if (q.cssMode) return Q;
	let K = z0(U, f);
	if (((K += $.cssOverflowAdjustment()), J)) K = -K;
	return K || 0;
}
function L1(f, $) {
	let q = this,
		{ rtlTranslate: J, params: Q, wrapperEl: U, progress: K } = q,
		j = 0,
		Z = 0,
		O = 0;
	if (q.isHorizontal()) j = J ? -f : f;
	else Z = f;
	if (Q.roundLengths) (j = Math.floor(j)), (Z = Math.floor(Z));
	if (((q.previousTranslate = q.translate), (q.translate = q.isHorizontal() ? j : Z), Q.cssMode))
		U[q.isHorizontal() ? 'scrollLeft' : 'scrollTop'] = q.isHorizontal() ? -j : -Z;
	else if (!Q.virtualTranslate) {
		if (q.isHorizontal()) j -= q.cssOverflowAdjustment();
		else Z -= q.cssOverflowAdjustment();
		U.style.transform = `translate3d(${j}px, ${Z}px, ${O}px)`;
	}
	let V,
		y = q.maxTranslate() - q.minTranslate();
	if (y === 0) V = 0;
	else V = (f - q.minTranslate()) / y;
	if (V !== K) q.updateProgress(f);
	q.emit('setTranslate', q.translate, $);
}
function G1() {
	return -this.snapGrid[0];
}
function B1() {
	return -this.snapGrid[this.snapGrid.length - 1];
}
function D1(f = 0, $ = this.params.speed, q = !0, J = !0, Q) {
	let U = this,
		{ params: K, wrapperEl: j } = U;
	if (U.animating && K.preventInteractionOnTransition) return !1;
	let Z = U.minTranslate(),
		O = U.maxTranslate(),
		V;
	if (J && f > Z) V = Z;
	else if (J && f < O) V = O;
	else V = f;
	if ((U.updateProgress(V), K.cssMode)) {
		let y = U.isHorizontal();
		if ($ === 0) j[y ? 'scrollLeft' : 'scrollTop'] = -V;
		else {
			if (!U.support.smoothScroll) return C0({ swiper: U, targetPosition: -V, side: y ? 'left' : 'top' }), !0;
			j.scrollTo({ [y ? 'left' : 'top']: -V, behavior: 'smooth' });
		}
		return !0;
	}
	if ($ === 0) {
		if ((U.setTransition(0), U.setTranslate(V), q))
			U.emit('beforeTransitionStart', $, Q), U.emit('transitionEnd');
	} else {
		if ((U.setTransition($), U.setTranslate(V), q))
			U.emit('beforeTransitionStart', $, Q), U.emit('transitionStart');
		if (!U.animating) {
			if (((U.animating = !0), !U.onTranslateToWrapperTransitionEnd))
				U.onTranslateToWrapperTransitionEnd = function y(N) {
					if (!U || U.destroyed) return;
					if (N.target !== this) return;
					if (
						(U.wrapperEl.removeEventListener('transitionend', U.onTranslateToWrapperTransitionEnd),
						(U.onTranslateToWrapperTransitionEnd = null),
						delete U.onTranslateToWrapperTransitionEnd,
						(U.animating = !1),
						q)
					)
						U.emit('transitionEnd');
				};
			U.wrapperEl.addEventListener('transitionend', U.onTranslateToWrapperTransitionEnd);
		}
	}
	return !0;
}
var T1 = { getTranslate: M1, setTranslate: L1, minTranslate: G1, maxTranslate: B1, translateTo: D1 };
function h1(f, $) {
	let q = this;
	if (!q.params.cssMode)
		(q.wrapperEl.style.transitionDuration = `${f}ms`),
			(q.wrapperEl.style.transitionDelay = f === 0 ? '0ms' : '');
	q.emit('setTransition', f, $);
}
function Cf({ swiper: f, runCallbacks: $, direction: q, step: J }) {
	let { activeIndex: Q, previousIndex: U } = f,
		K = q;
	if (!K)
		if (Q > U) K = 'next';
		else if (Q < U) K = 'prev';
		else K = 'reset';
	if ((f.emit(`transition${J}`), $ && K === 'reset')) f.emit(`slideResetTransition${J}`);
	else if ($ && Q !== U)
		if ((f.emit(`slideChangeTransition${J}`), K === 'next')) f.emit(`slideNextTransition${J}`);
		else f.emit(`slidePrevTransition${J}`);
}
function z1(f = !0, $) {
	let q = this,
		{ params: J } = q;
	if (J.cssMode) return;
	if (J.autoHeight) q.updateAutoHeight();
	Cf({ swiper: q, runCallbacks: f, direction: $, step: 'Start' });
}
function C1(f = !0, $) {
	let q = this,
		{ params: J } = q;
	if (((q.animating = !1), J.cssMode)) return;
	q.setTransition(0), Cf({ swiper: q, runCallbacks: f, direction: $, step: 'End' });
}
var P1 = { setTransition: h1, transitionStart: z1, transitionEnd: C1 };
function k1(f = 0, $, q = !0, J, Q) {
	if (typeof f === 'string') f = parseInt(f, 10);
	let U = this,
		K = f;
	if (K < 0) K = 0;
	let {
		params: j,
		snapGrid: Z,
		slidesGrid: O,
		previousIndex: V,
		activeIndex: y,
		rtlTranslate: N,
		wrapperEl: A,
		enabled: F,
	} = U;
	if ((!F && !J && !Q) || U.destroyed || (U.animating && j.preventInteractionOnTransition)) return !1;
	if (typeof $ === 'undefined') $ = U.params.speed;
	let R = Math.min(U.params.slidesPerGroupSkip, K),
		W = R + Math.floor((K - R) / U.params.slidesPerGroup);
	if (W >= Z.length) W = Z.length - 1;
	let H = -Z[W];
	if (j.normalizeSlideIndex)
		for (let T = 0; T < O.length; T += 1) {
			let B = -Math.floor(H * 100),
				P = Math.floor(O[T] * 100),
				G = Math.floor(O[T + 1] * 100);
			if (typeof O[T + 1] !== 'undefined') {
				if (B >= P && B < G - (G - P) / 2) K = T;
				else if (B >= P && B < G) K = T + 1;
			} else if (B >= P) K = T;
		}
	if (U.initialized && K !== y) {
		if (
			!U.allowSlideNext &&
			(N ? H > U.translate && H > U.minTranslate() : H < U.translate && H < U.minTranslate())
		)
			return !1;
		if (!U.allowSlidePrev && H > U.translate && H > U.maxTranslate()) {
			if ((y || 0) !== K) return !1;
		}
	}
	if (K !== (V || 0) && q) U.emit('beforeSlideChangeStart');
	U.updateProgress(H);
	let X;
	if (K > y) X = 'next';
	else if (K < y) X = 'prev';
	else X = 'reset';
	let Y = U.virtual && U.params.virtual.enabled;
	if (!(Y && Q) && ((N && -H === U.translate) || (!N && H === U.translate))) {
		if ((U.updateActiveIndex(K), j.autoHeight)) U.updateAutoHeight();
		if ((U.updateSlidesClasses(), j.effect !== 'slide')) U.setTranslate(H);
		if (X !== 'reset') U.transitionStart(q, X), U.transitionEnd(q, X);
		return !1;
	}
	if (j.cssMode) {
		let T = U.isHorizontal(),
			B = N ? H : -H;
		if ($ === 0) {
			if (Y) (U.wrapperEl.style.scrollSnapType = 'none'), (U._immediateVirtual = !0);
			if (Y && !U._cssModeVirtualInitialSet && U.params.initialSlide > 0)
				(U._cssModeVirtualInitialSet = !0),
					requestAnimationFrame(() => {
						A[T ? 'scrollLeft' : 'scrollTop'] = B;
					});
			else A[T ? 'scrollLeft' : 'scrollTop'] = B;
			if (Y)
				requestAnimationFrame(() => {
					(U.wrapperEl.style.scrollSnapType = ''), (U._immediateVirtual = !1);
				});
		} else {
			if (!U.support.smoothScroll) return C0({ swiper: U, targetPosition: B, side: T ? 'left' : 'top' }), !0;
			A.scrollTo({ [T ? 'left' : 'top']: B, behavior: 'smooth' });
		}
		return !0;
	}
	let D = zf().isSafari;
	if (Y && !Q && D && U.isElement) U.virtual.update(!1, !1, K);
	if (
		(U.setTransition($),
		U.setTranslate(H),
		U.updateActiveIndex(K),
		U.updateSlidesClasses(),
		U.emit('beforeTransitionStart', $, J),
		U.transitionStart(q, X),
		$ === 0)
	)
		U.transitionEnd(q, X);
	else if (!U.animating) {
		if (((U.animating = !0), !U.onSlideToWrapperTransitionEnd))
			U.onSlideToWrapperTransitionEnd = function T(B) {
				if (!U || U.destroyed) return;
				if (B.target !== this) return;
				U.wrapperEl.removeEventListener('transitionend', U.onSlideToWrapperTransitionEnd),
					(U.onSlideToWrapperTransitionEnd = null),
					delete U.onSlideToWrapperTransitionEnd,
					U.transitionEnd(q, X);
			};
		U.wrapperEl.addEventListener('transitionend', U.onSlideToWrapperTransitionEnd);
	}
	return !0;
}
function I1(f = 0, $, q = !0, J) {
	if (typeof f === 'string') f = parseInt(f, 10);
	let Q = this;
	if (Q.destroyed) return;
	if (typeof $ === 'undefined') $ = Q.params.speed;
	let U = Q.grid && Q.params.grid && Q.params.grid.rows > 1,
		K = f;
	if (Q.params.loop)
		if (Q.virtual && Q.params.virtual.enabled) K = K + Q.virtual.slidesBefore;
		else {
			let j;
			if (U) {
				let R = K * Q.params.grid.rows;
				j = Q.slides.find((W) => W.getAttribute('data-swiper-slide-index') * 1 === R).column;
			} else j = Q.getSlideIndexByData(K);
			let Z = U ? Math.ceil(Q.slides.length / Q.params.grid.rows) : Q.slides.length,
				{ centeredSlides: O, slidesOffsetBefore: V, slidesOffsetAfter: y } = Q.params,
				N = O || !!V || !!y,
				A = Q.params.slidesPerView;
			if (A === 'auto') A = Q.slidesPerViewDynamic();
			else if (((A = Math.ceil(parseFloat(Q.params.slidesPerView, 10))), N && A % 2 === 0)) A = A + 1;
			let F = Z - j < A;
			if (N) F = F || j < Math.ceil(A / 2);
			if (J && N && Q.params.slidesPerView !== 'auto' && !U) F = !1;
			if (F) {
				let R = N
					? j < Q.activeIndex
						? 'prev'
						: 'next'
					: j - Q.activeIndex - 1 < Q.params.slidesPerView
					? 'next'
					: 'prev';
				Q.loopFix({
					direction: R,
					slideTo: !0,
					activeSlideIndex: R === 'next' ? j + 1 : j - Z + 1,
					slideRealIndex: R === 'next' ? Q.realIndex : void 0,
				});
			}
			if (U) {
				let R = K * Q.params.grid.rows;
				K = Q.slides.find((W) => W.getAttribute('data-swiper-slide-index') * 1 === R).column;
			} else K = Q.getSlideIndexByData(K);
		}
	return (
		requestAnimationFrame(() => {
			Q.slideTo(K, $, q, J);
		}),
		Q
	);
}
function b1(f, $ = !0, q) {
	let J = this,
		{ enabled: Q, params: U, animating: K } = J;
	if (!Q || J.destroyed) return J;
	if (typeof f === 'undefined') f = J.params.speed;
	let j = U.slidesPerGroup;
	if (U.slidesPerView === 'auto' && U.slidesPerGroup === 1 && U.slidesPerGroupAuto)
		j = Math.max(J.slidesPerViewDynamic('current', !0), 1);
	let Z = J.activeIndex < U.slidesPerGroupSkip ? 1 : j,
		O = J.virtual && U.virtual.enabled;
	if (U.loop) {
		if (K && !O && U.loopPreventsSliding) return !1;
		if (
			(J.loopFix({ direction: 'next' }),
			(J._clientLeft = J.wrapperEl.clientLeft),
			J.activeIndex === J.slides.length - 1 && U.cssMode)
		)
			return (
				requestAnimationFrame(() => {
					J.slideTo(J.activeIndex + Z, f, $, q);
				}),
				!0
			);
	}
	if (U.rewind && J.isEnd) return J.slideTo(0, f, $, q);
	return J.slideTo(J.activeIndex + Z, f, $, q);
}
function v1(f, $ = !0, q) {
	let J = this,
		{ params: Q, snapGrid: U, slidesGrid: K, rtlTranslate: j, enabled: Z, animating: O } = J;
	if (!Z || J.destroyed) return J;
	if (typeof f === 'undefined') f = J.params.speed;
	let V = J.virtual && Q.virtual.enabled;
	if (Q.loop) {
		if (O && !V && Q.loopPreventsSliding) return !1;
		J.loopFix({ direction: 'prev' }), (J._clientLeft = J.wrapperEl.clientLeft);
	}
	let y = j ? J.translate : -J.translate;
	function N(X) {
		if (X < 0) return -Math.floor(Math.abs(X));
		return Math.floor(X);
	}
	let A = N(y),
		F = U.map((X) => N(X)),
		R = Q.freeMode && Q.freeMode.enabled,
		W = U[F.indexOf(A) - 1];
	if (typeof W === 'undefined' && (Q.cssMode || R)) {
		let X;
		if (
			(U.forEach((Y, _) => {
				if (A >= Y) X = _;
			}),
			typeof X !== 'undefined')
		)
			W = R ? U[X] : U[X > 0 ? X - 1 : X];
	}
	let H = 0;
	if (typeof W !== 'undefined') {
		if (((H = K.indexOf(W)), H < 0)) H = J.activeIndex - 1;
		if (Q.slidesPerView === 'auto' && Q.slidesPerGroup === 1 && Q.slidesPerGroupAuto)
			(H = H - J.slidesPerViewDynamic('previous', !0) + 1), (H = Math.max(H, 0));
	}
	if (Q.rewind && J.isBeginning) {
		let X =
			J.params.virtual && J.params.virtual.enabled && J.virtual
				? J.virtual.slides.length - 1
				: J.slides.length - 1;
		return J.slideTo(X, f, $, q);
	} else if (Q.loop && J.activeIndex === 0 && Q.cssMode)
		return (
			requestAnimationFrame(() => {
				J.slideTo(H, f, $, q);
			}),
			!0
		);
	return J.slideTo(H, f, $, q);
}
function S1(f, $ = !0, q) {
	let J = this;
	if (J.destroyed) return;
	if (typeof f === 'undefined') f = J.params.speed;
	return J.slideTo(J.activeIndex, f, $, q);
}
function x1(f, $ = !0, q, J = 0.5) {
	let Q = this;
	if (Q.destroyed) return;
	if (typeof f === 'undefined') f = Q.params.speed;
	let U = Q.activeIndex,
		K = Math.min(Q.params.slidesPerGroupSkip, U),
		j = K + Math.floor((U - K) / Q.params.slidesPerGroup),
		Z = Q.rtlTranslate ? Q.translate : -Q.translate;
	if (Z >= Q.snapGrid[j]) {
		let O = Q.snapGrid[j],
			V = Q.snapGrid[j + 1];
		if (Z - O > (V - O) * J) U += Q.params.slidesPerGroup;
	} else {
		let O = Q.snapGrid[j - 1],
			V = Q.snapGrid[j];
		if (Z - O <= (V - O) * J) U -= Q.params.slidesPerGroup;
	}
	return (U = Math.max(U, 0)), (U = Math.min(U, Q.slidesGrid.length - 1)), Q.slideTo(U, f, $, q);
}
function c1() {
	let f = this;
	if (f.destroyed) return;
	let { params: $, slidesEl: q } = f,
		J = $.slidesPerView === 'auto' ? f.slidesPerViewDynamic() : $.slidesPerView,
		Q = f.getSlideIndexWhenGrid(f.clickedIndex),
		U,
		K = f.isElement ? 'swiper-slide' : `.${$.slideClass}`,
		j = f.grid && f.params.grid && f.params.grid.rows > 1;
	if ($.loop) {
		if (f.animating) return;
		if (((U = parseInt(f.clickedSlide.getAttribute('data-swiper-slide-index'), 10)), $.centeredSlides))
			f.slideToLoop(U);
		else if (Q > (j ? (f.slides.length - J) / 2 - (f.params.grid.rows - 1) : f.slides.length - J))
			f.loopFix(),
				(Q = f.getSlideIndex(I(q, `${K}[data-swiper-slide-index="${U}"]`)[0])),
				e(() => {
					f.slideTo(Q);
				});
		else f.slideTo(Q);
	} else f.slideTo(Q);
}
var g1 = {
	slideTo: k1,
	slideToLoop: I1,
	slideNext: b1,
	slidePrev: v1,
	slideReset: S1,
	slideToClosest: x1,
	slideToClickedSlide: c1,
};
function E1(f, $) {
	let q = this,
		{ params: J, slidesEl: Q } = q;
	if (!J.loop || (q.virtual && q.params.virtual.enabled)) return;
	let U = () => {
			I(Q, `.${J.slideClass}, swiper-slide`).forEach((F, R) => {
				F.setAttribute('data-swiper-slide-index', R);
			});
		},
		K = () => {
			let A = I(Q, `.${J.slideBlankClass}`);
			if (
				(A.forEach((F) => {
					F.remove();
				}),
				A.length > 0)
			)
				q.recalcSlides(), q.updateSlides();
		},
		j = q.grid && J.grid && J.grid.rows > 1;
	if (J.loopAddBlankSlides && (J.slidesPerGroup > 1 || j)) K();
	let Z = J.slidesPerGroup * (j ? J.grid.rows : 1),
		O = q.slides.length % Z !== 0,
		V = j && q.slides.length % J.grid.rows !== 0,
		y = (A) => {
			for (let F = 0; F < A; F += 1) {
				let R = q.isElement
					? o('swiper-slide', [J.slideBlankClass])
					: o('div', [J.slideClass, J.slideBlankClass]);
				q.slidesEl.append(R);
			}
		};
	if (O) {
		if (J.loopAddBlankSlides) {
			let A = Z - (q.slides.length % Z);
			y(A), q.recalcSlides(), q.updateSlides();
		} else
			Q0(
				'Swiper Loop Warning: The number of slides is not even to slidesPerGroup, loop mode may not function properly. You need to add more slides (or make duplicates, or empty slides)',
			);
		U();
	} else if (V) {
		if (J.loopAddBlankSlides) {
			let A = J.grid.rows - (q.slides.length % J.grid.rows);
			y(A), q.recalcSlides(), q.updateSlides();
		} else
			Q0(
				'Swiper Loop Warning: The number of slides is not even to grid.rows, loop mode may not function properly. You need to add more slides (or make duplicates, or empty slides)',
			);
		U();
	} else U();
	let N = J.centeredSlides || !!J.slidesOffsetBefore || !!J.slidesOffsetAfter;
	q.loopFix({ slideRealIndex: f, direction: N ? void 0 : 'next', initial: $ });
}
function u1({
	slideRealIndex: f,
	slideTo: $ = !0,
	direction: q,
	setTranslate: J,
	activeSlideIndex: Q,
	initial: U,
	byController: K,
	byMousewheel: j,
} = {}) {
	let Z = this;
	if (!Z.params.loop) return;
	Z.emit('beforeLoopFix');
	let { slides: O, allowSlidePrev: V, allowSlideNext: y, slidesEl: N, params: A } = Z,
		{ centeredSlides: F, slidesOffsetBefore: R, slidesOffsetAfter: W, initialSlide: H } = A,
		X = F || !!R || !!W;
	if (((Z.allowSlidePrev = !0), (Z.allowSlideNext = !0), Z.virtual && A.virtual.enabled)) {
		if ($) {
			if (!X && Z.snapIndex === 0) Z.slideTo(Z.virtual.slides.length, 0, !1, !0);
			else if (X && Z.snapIndex < A.slidesPerView)
				Z.slideTo(Z.virtual.slides.length + Z.snapIndex, 0, !1, !0);
			else if (Z.snapIndex === Z.snapGrid.length - 1) Z.slideTo(Z.virtual.slidesBefore, 0, !1, !0);
		}
		(Z.allowSlidePrev = V), (Z.allowSlideNext = y), Z.emit('loopFix');
		return;
	}
	let Y = A.slidesPerView;
	if (Y === 'auto') Y = Z.slidesPerViewDynamic();
	else if (((Y = Math.ceil(parseFloat(A.slidesPerView, 10))), X && Y % 2 === 0)) Y = Y + 1;
	let _ = A.slidesPerGroupAuto ? Y : A.slidesPerGroup,
		L = X ? Math.max(_, Math.ceil(Y / 2)) : _;
	if (L % _ !== 0) L += _ - (L % _);
	(L += A.loopAdditionalSlides), (Z.loopedSlides = L);
	let D = Z.grid && A.grid && A.grid.rows > 1;
	if (O.length < Y + L || (Z.params.effect === 'cards' && O.length < Y + L * 2))
		Q0(
			'Swiper Loop Warning: The number of slides is not enough for loop mode, it will be disabled or not function properly. You need to add more slides (or make duplicates) or lower the values of slidesPerView and slidesPerGroup parameters',
		);
	else if (D && A.grid.fill === 'row')
		Q0('Swiper Loop Warning: Loop mode is not compatible with grid.fill = `row`');
	let T = [],
		B = [],
		P = D ? Math.ceil(O.length / A.grid.rows) : O.length,
		G = U && P - H < Y && !X,
		M = G ? H : Z.activeIndex;
	if (typeof Q === 'undefined') Q = Z.getSlideIndex(O.find((z) => z.classList.contains(A.slideActiveClass)));
	else M = Q;
	let h = q === 'next' || !q,
		b = q === 'prev' || !q,
		g = 0,
		m = 0,
		w = (D ? O[Q].column : Q) + (X && typeof J === 'undefined' ? -Y / 2 + 0.5 : 0);
	if (w < L) {
		g = Math.max(L - w, _);
		for (let z = 0; z < L - w; z += 1) {
			let k = z - Math.floor(z / P) * P;
			if (D) {
				let x = P - k - 1;
				for (let n = O.length - 1; n >= 0; n -= 1) if (O[n].column === x) T.push(n);
			} else T.push(P - k - 1);
		}
	} else if (w + Y > P - L) {
		if (((m = Math.max(w - (P - L * 2), _)), G)) m = Math.max(m, Y - P + H + 1);
		for (let z = 0; z < m; z += 1) {
			let k = z - Math.floor(z / P) * P;
			if (D)
				O.forEach((x, n) => {
					if (x.column === k) B.push(n);
				});
			else B.push(k);
		}
	}
	if (
		((Z.__preventObserver__ = !0),
		requestAnimationFrame(() => {
			Z.__preventObserver__ = !1;
		}),
		Z.params.effect === 'cards' && O.length < Y + L * 2)
	) {
		if (B.includes(Q)) B.splice(B.indexOf(Q), 1);
		if (T.includes(Q)) T.splice(T.indexOf(Q), 1);
	}
	if (b)
		T.forEach((z) => {
			(O[z].swiperLoopMoveDOM = !0), N.prepend(O[z]), (O[z].swiperLoopMoveDOM = !1);
		});
	if (h)
		B.forEach((z) => {
			(O[z].swiperLoopMoveDOM = !0), N.append(O[z]), (O[z].swiperLoopMoveDOM = !1);
		});
	if ((Z.recalcSlides(), A.slidesPerView === 'auto')) Z.updateSlides();
	else if (D && ((T.length > 0 && b) || (B.length > 0 && h)))
		Z.slides.forEach((z, k) => {
			Z.grid.updateSlide(k, z, Z.slides);
		});
	if (A.watchSlidesProgress) Z.updateSlidesOffset();
	if ($) {
		if (T.length > 0 && b) {
			if (typeof f === 'undefined') {
				let z = Z.slidesGrid[M],
					x = Z.slidesGrid[M + g] - z;
				if (j) Z.setTranslate(Z.translate - x);
				else if ((Z.slideTo(M + Math.ceil(g), 0, !1, !0), J))
					(Z.touchEventsData.startTranslate = Z.touchEventsData.startTranslate - x),
						(Z.touchEventsData.currentTranslate = Z.touchEventsData.currentTranslate - x);
			} else if (J) {
				let z = D ? T.length / A.grid.rows : T.length;
				Z.slideTo(Z.activeIndex + z, 0, !1, !0), (Z.touchEventsData.currentTranslate = Z.translate);
			}
		} else if (B.length > 0 && h)
			if (typeof f === 'undefined') {
				let z = Z.slidesGrid[M],
					x = Z.slidesGrid[M - m] - z;
				if (j) Z.setTranslate(Z.translate - x);
				else if ((Z.slideTo(M - m, 0, !1, !0), J))
					(Z.touchEventsData.startTranslate = Z.touchEventsData.startTranslate - x),
						(Z.touchEventsData.currentTranslate = Z.touchEventsData.currentTranslate - x);
			} else {
				let z = D ? B.length / A.grid.rows : B.length;
				Z.slideTo(Z.activeIndex - z, 0, !1, !0);
			}
	}
	if (((Z.allowSlidePrev = V), (Z.allowSlideNext = y), Z.controller && Z.controller.control && !K)) {
		let z = { slideRealIndex: f, direction: q, setTranslate: J, activeSlideIndex: Q, byController: !0 };
		if (Array.isArray(Z.controller.control))
			Z.controller.control.forEach((k) => {
				if (!k.destroyed && k.params.loop)
					k.loopFix({ ...z, slideTo: k.params.slidesPerView === A.slidesPerView ? $ : !1 });
			});
		else if (Z.controller.control instanceof Z.constructor && Z.controller.control.params.loop)
			Z.controller.control.loopFix({
				...z,
				slideTo: Z.controller.control.params.slidesPerView === A.slidesPerView ? $ : !1,
			});
	}
	Z.emit('loopFix');
}
function m1() {
	let f = this,
		{ params: $, slidesEl: q } = f;
	if (!$.loop || !q || (f.virtual && f.params.virtual.enabled)) return;
	f.recalcSlides();
	let J = [];
	f.slides.forEach((Q) => {
		let U =
			typeof Q.swiperSlideIndex === 'undefined'
				? Q.getAttribute('data-swiper-slide-index') * 1
				: Q.swiperSlideIndex;
		J[U] = Q;
	}),
		f.slides.forEach((Q) => {
			Q.removeAttribute('data-swiper-slide-index');
		}),
		J.forEach((Q) => {
			q.append(Q);
		}),
		f.recalcSlides(),
		f.slideTo(f.realIndex, 0);
}
var o1 = { loopCreate: E1, loopFix: u1, loopDestroy: m1 };
function d1(f) {
	let $ = this;
	if (!$.params.simulateTouch || ($.params.watchOverflow && $.isLocked) || $.params.cssMode) return;
	let q = $.params.touchEventsTarget === 'container' ? $.el : $.wrapperEl;
	if ($.isElement) $.__preventObserver__ = !0;
	if (((q.style.cursor = 'move'), (q.style.cursor = f ? 'grabbing' : 'grab'), $.isElement))
		requestAnimationFrame(() => {
			$.__preventObserver__ = !1;
		});
}
function t1() {
	let f = this;
	if ((f.params.watchOverflow && f.isLocked) || f.params.cssMode) return;
	if (f.isElement) f.__preventObserver__ = !0;
	if (((f[f.params.touchEventsTarget === 'container' ? 'el' : 'wrapperEl'].style.cursor = ''), f.isElement))
		requestAnimationFrame(() => {
			f.__preventObserver__ = !1;
		});
}
var n1 = { setGrabCursor: d1, unsetGrabCursor: t1 };
function l1(f, $ = this) {
	function q(J) {
		if (!J || J === v() || J === C()) return null;
		if (J.assignedSlot) J = J.assignedSlot;
		let Q = J.closest(f);
		if (!Q && !J.getRootNode) return null;
		return Q || q(J.getRootNode().host);
	}
	return q($);
}
function Lf(f, $, q) {
	let J = C(),
		{ params: Q } = f,
		U = Q.edgeSwipeDetection,
		K = Q.edgeSwipeThreshold;
	if (U && (q <= K || q >= J.innerWidth - K)) {
		if (U === 'prevent') return $.preventDefault(), !0;
		return !1;
	}
	return !0;
}
function w1(f) {
	let $ = this,
		q = v(),
		J = f;
	if (J.originalEvent) J = J.originalEvent;
	let Q = $.touchEventsData;
	if (J.type === 'pointerdown') {
		if (Q.pointerId !== null && Q.pointerId !== J.pointerId) return;
		Q.pointerId = J.pointerId;
	} else if (J.type === 'touchstart' && J.targetTouches.length === 1)
		Q.touchId = J.targetTouches[0].identifier;
	if (J.type === 'touchstart') {
		Lf($, J, J.targetTouches[0].pageX);
		return;
	}
	let { params: U, touches: K, enabled: j } = $;
	if (!j) return;
	if (!U.simulateTouch && J.pointerType === 'mouse') return;
	if ($.animating && U.preventInteractionOnTransition) return;
	if (!$.animating && U.cssMode && U.loop) $.loopFix();
	let Z = J.target;
	if (U.touchEventsTarget === 'wrapper') {
		if (!Xf(Z, $.wrapperEl)) return;
	}
	if ('which' in J && J.which === 3) return;
	if ('button' in J && J.button > 0) return;
	if (Q.isTouched && Q.isMoved) return;
	let O = !!U.noSwipingClass && U.noSwipingClass !== '',
		V = J.composedPath ? J.composedPath() : J.path;
	if (O && J.target && J.target.shadowRoot && V) Z = V[0];
	let y = U.noSwipingSelector ? U.noSwipingSelector : `.${U.noSwipingClass}`,
		N = !!(J.target && J.target.shadowRoot);
	if (U.noSwiping && (N ? l1(y, Z) : Z.closest(y))) {
		$.allowClick = !0;
		return;
	}
	if (U.swipeHandler) {
		if (!Z.closest(U.swipeHandler)) return;
	}
	(K.currentX = J.pageX), (K.currentY = J.pageY);
	let { currentX: A, currentY: F } = K;
	if (!Lf($, J, A)) return;
	if (
		(Object.assign(Q, {
			isTouched: !0,
			isMoved: !1,
			allowTouchCallbacks: !0,
			isScrolling: void 0,
			startMoving: void 0,
		}),
		(K.startX = A),
		(K.startY = F),
		(Q.touchStartTime = p()),
		($.allowClick = !0),
		$.updateSize(),
		($.swipeDirection = void 0),
		U.threshold > 0)
	)
		Q.allowThresholdMove = !1;
	let R = !0;
	if (Z.matches(Q.focusableElements)) {
		if (((R = !1), Z.nodeName === 'SELECT')) Q.isTouched = !1;
	}
	if (
		q.activeElement &&
		q.activeElement.matches(Q.focusableElements) &&
		q.activeElement !== Z &&
		(J.pointerType === 'mouse' || (J.pointerType !== 'mouse' && !Z.matches(Q.focusableElements)))
	)
		q.activeElement.blur();
	let W = R && $.allowTouchMove && U.touchStartPreventDefault;
	if ((U.touchStartForcePreventDefault || W) && !Z.isContentEditable) J.preventDefault();
	if (U.freeMode && U.freeMode.enabled && $.freeMode && $.animating && !U.cssMode) $.freeMode.onTouchStart();
	$.emit('touchStart', J);
}
function a1(f) {
	let $ = v(),
		q = this,
		J = q.touchEventsData,
		{ params: Q, touches: U, rtlTranslate: K, enabled: j } = q;
	if (!j) return;
	if (!Q.simulateTouch && f.pointerType === 'mouse') return;
	let Z = f;
	if (Z.originalEvent) Z = Z.originalEvent;
	if (Z.type === 'pointermove') {
		if (J.touchId !== null) return;
		if (Z.pointerId !== J.pointerId) return;
	}
	let O;
	if (Z.type === 'touchmove') {
		if (
			((O = [...Z.changedTouches].find((D) => D.identifier === J.touchId)), !O || O.identifier !== J.touchId)
		)
			return;
	} else O = Z;
	if (!J.isTouched) {
		if (J.startMoving && J.isScrolling) q.emit('touchMoveOpposite', Z);
		return;
	}
	let { pageX: V, pageY: y } = O;
	if (Z.preventedByNestedSwiper) {
		(U.startX = V), (U.startY = y);
		return;
	}
	if (!q.allowTouchMove) {
		if (!Z.target.matches(J.focusableElements)) q.allowClick = !1;
		if (J.isTouched)
			Object.assign(U, { startX: V, startY: y, currentX: V, currentY: y }), (J.touchStartTime = p());
		return;
	}
	if (Q.touchReleaseOnEdges && !Q.loop) {
		if (q.isVertical()) {
			if (
				(y < U.startY && q.translate <= q.maxTranslate()) ||
				(y > U.startY && q.translate >= q.minTranslate())
			) {
				(J.isTouched = !1), (J.isMoved = !1);
				return;
			}
		} else if (
			K &&
			((V > U.startX && -q.translate <= q.maxTranslate()) ||
				(V < U.startX && -q.translate >= q.minTranslate()))
		)
			return;
		else if (
			!K &&
			((V < U.startX && q.translate <= q.maxTranslate()) || (V > U.startX && q.translate >= q.minTranslate()))
		)
			return;
	}
	if (
		$.activeElement &&
		$.activeElement.matches(J.focusableElements) &&
		$.activeElement !== Z.target &&
		Z.pointerType !== 'mouse'
	)
		$.activeElement.blur();
	if ($.activeElement) {
		if (Z.target === $.activeElement && Z.target.matches(J.focusableElements)) {
			(J.isMoved = !0), (q.allowClick = !1);
			return;
		}
	}
	if (J.allowTouchCallbacks) q.emit('touchMove', Z);
	(U.previousX = U.currentX), (U.previousY = U.currentY), (U.currentX = V), (U.currentY = y);
	let N = U.currentX - U.startX,
		A = U.currentY - U.startY;
	if (q.params.threshold && Math.sqrt(N ** 2 + A ** 2) < q.params.threshold) return;
	if (typeof J.isScrolling === 'undefined') {
		let D;
		if ((q.isHorizontal() && U.currentY === U.startY) || (q.isVertical() && U.currentX === U.startX))
			J.isScrolling = !1;
		else if (N * N + A * A >= 25)
			(D = (Math.atan2(Math.abs(A), Math.abs(N)) * 180) / Math.PI),
				(J.isScrolling = q.isHorizontal() ? D > Q.touchAngle : 90 - D > Q.touchAngle);
	}
	if (J.isScrolling) q.emit('touchMoveOpposite', Z);
	if (typeof J.startMoving === 'undefined') {
		if (U.currentX !== U.startX || U.currentY !== U.startY) J.startMoving = !0;
	}
	if (J.isScrolling || (Z.type === 'touchmove' && J.preventTouchMoveFromPointerMove)) {
		J.isTouched = !1;
		return;
	}
	if (!J.startMoving) return;
	if (((q.allowClick = !1), !Q.cssMode && Z.cancelable)) Z.preventDefault();
	if (Q.touchMoveStopPropagation && !Q.nested) Z.stopPropagation();
	let F = q.isHorizontal() ? N : A,
		R = q.isHorizontal() ? U.currentX - U.previousX : U.currentY - U.previousY;
	if (Q.oneWayMovement) (F = Math.abs(F) * (K ? 1 : -1)), (R = Math.abs(R) * (K ? 1 : -1));
	if (((U.diff = F), (F *= Q.touchRatio), K)) (F = -F), (R = -R);
	let W = q.touchesDirection;
	(q.swipeDirection = F > 0 ? 'prev' : 'next'), (q.touchesDirection = R > 0 ? 'prev' : 'next');
	let H = q.params.loop && !Q.cssMode,
		X =
			(q.touchesDirection === 'next' && q.allowSlideNext) ||
			(q.touchesDirection === 'prev' && q.allowSlidePrev);
	if (!J.isMoved) {
		if (H && X) q.loopFix({ direction: q.swipeDirection });
		if (((J.startTranslate = q.getTranslate()), q.setTransition(0), q.animating)) {
			let D = new window.CustomEvent('transitionend', {
				bubbles: !0,
				cancelable: !0,
				detail: { bySwiperTouchMove: !0 },
			});
			q.wrapperEl.dispatchEvent(D);
		}
		if (((J.allowMomentumBounce = !1), Q.grabCursor && (q.allowSlideNext === !0 || q.allowSlidePrev === !0)))
			q.setGrabCursor(!0);
		q.emit('sliderFirstMove', Z);
	}
	let Y;
	if (
		(new Date().getTime(),
		Q._loopSwapReset !== !1 &&
			J.isMoved &&
			J.allowThresholdMove &&
			W !== q.touchesDirection &&
			H &&
			X &&
			Math.abs(F) >= 1)
	) {
		Object.assign(U, { startX: V, startY: y, currentX: V, currentY: y, startTranslate: J.currentTranslate }),
			(J.loopSwapReset = !0),
			(J.startTranslate = J.currentTranslate);
		return;
	}
	q.emit('sliderMove', Z), (J.isMoved = !0), (J.currentTranslate = F + J.startTranslate);
	let _ = !0,
		L = Q.resistanceRatio;
	if (Q.touchReleaseOnEdges) L = 0;
	if (F > 0) {
		if (
			H &&
			X &&
			!Y &&
			J.allowThresholdMove &&
			J.currentTranslate >
				(Q.centeredSlides
					? q.minTranslate() -
					  q.slidesSizesGrid[q.activeIndex + 1] -
					  (Q.slidesPerView !== 'auto' && q.slides.length - Q.slidesPerView >= 2
							? q.slidesSizesGrid[q.activeIndex + 1] + q.params.spaceBetween
							: 0) -
					  q.params.spaceBetween
					: q.minTranslate())
		)
			q.loopFix({ direction: 'prev', setTranslate: !0, activeSlideIndex: 0 });
		if (J.currentTranslate > q.minTranslate()) {
			if (((_ = !1), Q.resistance))
				J.currentTranslate = q.minTranslate() - 1 + (-q.minTranslate() + J.startTranslate + F) ** L;
		}
	} else if (F < 0) {
		if (
			H &&
			X &&
			!Y &&
			J.allowThresholdMove &&
			J.currentTranslate <
				(Q.centeredSlides
					? q.maxTranslate() +
					  q.slidesSizesGrid[q.slidesSizesGrid.length - 1] +
					  q.params.spaceBetween +
					  (Q.slidesPerView !== 'auto' && q.slides.length - Q.slidesPerView >= 2
							? q.slidesSizesGrid[q.slidesSizesGrid.length - 1] + q.params.spaceBetween
							: 0)
					: q.maxTranslate())
		)
			q.loopFix({
				direction: 'next',
				setTranslate: !0,
				activeSlideIndex:
					q.slides.length -
					(Q.slidesPerView === 'auto'
						? q.slidesPerViewDynamic()
						: Math.ceil(parseFloat(Q.slidesPerView, 10))),
			});
		if (J.currentTranslate < q.maxTranslate()) {
			if (((_ = !1), Q.resistance))
				J.currentTranslate = q.maxTranslate() + 1 - (q.maxTranslate() - J.startTranslate - F) ** L;
		}
	}
	if (_) Z.preventedByNestedSwiper = !0;
	if (!q.allowSlideNext && q.swipeDirection === 'next' && J.currentTranslate < J.startTranslate)
		J.currentTranslate = J.startTranslate;
	if (!q.allowSlidePrev && q.swipeDirection === 'prev' && J.currentTranslate > J.startTranslate)
		J.currentTranslate = J.startTranslate;
	if (!q.allowSlidePrev && !q.allowSlideNext) J.currentTranslate = J.startTranslate;
	if (Q.threshold > 0)
		if (Math.abs(F) > Q.threshold || J.allowThresholdMove) {
			if (!J.allowThresholdMove) {
				(J.allowThresholdMove = !0),
					(U.startX = U.currentX),
					(U.startY = U.currentY),
					(J.currentTranslate = J.startTranslate),
					(U.diff = q.isHorizontal() ? U.currentX - U.startX : U.currentY - U.startY);
				return;
			}
		} else {
			J.currentTranslate = J.startTranslate;
			return;
		}
	if (!Q.followFinger || Q.cssMode) return;
	if ((Q.freeMode && Q.freeMode.enabled && q.freeMode) || Q.watchSlidesProgress)
		q.updateActiveIndex(), q.updateSlidesClasses();
	if (Q.freeMode && Q.freeMode.enabled && q.freeMode) q.freeMode.onTouchMove();
	q.updateProgress(J.currentTranslate), q.setTranslate(J.currentTranslate);
}
function p1(f) {
	let $ = this,
		q = $.touchEventsData,
		J = f;
	if (J.originalEvent) J = J.originalEvent;
	let Q;
	if (!(J.type === 'touchend' || J.type === 'touchcancel')) {
		if (q.touchId !== null) return;
		if (J.pointerId !== q.pointerId) return;
		Q = J;
	} else if (
		((Q = [...J.changedTouches].find((L) => L.identifier === q.touchId)), !Q || Q.identifier !== q.touchId)
	)
		return;
	if (['pointercancel', 'pointerout', 'pointerleave', 'contextmenu'].includes(J.type)) {
		if (!(['pointercancel', 'contextmenu'].includes(J.type) && ($.browser.isSafari || $.browser.isWebView)))
			return;
	}
	(q.pointerId = null), (q.touchId = null);
	let { params: K, touches: j, rtlTranslate: Z, slidesGrid: O, enabled: V } = $;
	if (!V) return;
	if (!K.simulateTouch && J.pointerType === 'mouse') return;
	if (q.allowTouchCallbacks) $.emit('touchEnd', J);
	if (((q.allowTouchCallbacks = !1), !q.isTouched)) {
		if (q.isMoved && K.grabCursor) $.setGrabCursor(!1);
		(q.isMoved = !1), (q.startMoving = !1);
		return;
	}
	if (K.grabCursor && q.isMoved && q.isTouched && ($.allowSlideNext === !0 || $.allowSlidePrev === !0))
		$.setGrabCursor(!1);
	let y = p(),
		N = y - q.touchStartTime;
	if ($.allowClick) {
		let L = J.path || (J.composedPath && J.composedPath());
		if (
			($.updateClickedSlide((L && L[0]) || J.target, L),
			$.emit('tap click', J),
			N < 300 && y - q.lastClickTime < 300)
		)
			$.emit('doubleTap doubleClick', J);
	}
	if (
		((q.lastClickTime = p()),
		e(() => {
			if (!$.destroyed) $.allowClick = !0;
		}),
		!q.isTouched ||
			!q.isMoved ||
			!$.swipeDirection ||
			(j.diff === 0 && !q.loopSwapReset) ||
			(q.currentTranslate === q.startTranslate && !q.loopSwapReset))
	) {
		(q.isTouched = !1), (q.isMoved = !1), (q.startMoving = !1);
		return;
	}
	(q.isTouched = !1), (q.isMoved = !1), (q.startMoving = !1);
	let A;
	if (K.followFinger) A = Z ? $.translate : -$.translate;
	else A = -q.currentTranslate;
	if (K.cssMode) return;
	if (K.freeMode && K.freeMode.enabled) {
		$.freeMode.onTouchEnd({ currentPos: A });
		return;
	}
	let F = A >= -$.maxTranslate() && !$.params.loop,
		R = 0,
		W = $.slidesSizesGrid[0];
	for (let L = 0; L < O.length; L += L < K.slidesPerGroupSkip ? 1 : K.slidesPerGroup) {
		let D = L < K.slidesPerGroupSkip - 1 ? 1 : K.slidesPerGroup;
		if (typeof O[L + D] !== 'undefined') {
			if (F || (A >= O[L] && A < O[L + D])) (R = L), (W = O[L + D] - O[L]);
		} else if (F || A >= O[L]) (R = L), (W = O[O.length - 1] - O[O.length - 2]);
	}
	let H = null,
		X = null;
	if (K.rewind) {
		if ($.isBeginning)
			X = K.virtual && K.virtual.enabled && $.virtual ? $.virtual.slides.length - 1 : $.slides.length - 1;
		else if ($.isEnd) H = 0;
	}
	let Y = (A - O[R]) / W,
		_ = R < K.slidesPerGroupSkip - 1 ? 1 : K.slidesPerGroup;
	if (N > K.longSwipesMs) {
		if (!K.longSwipes) {
			$.slideTo($.activeIndex);
			return;
		}
		if ($.swipeDirection === 'next')
			if (Y >= K.longSwipesRatio) $.slideTo(K.rewind && $.isEnd ? H : R + _);
			else $.slideTo(R);
		if ($.swipeDirection === 'prev')
			if (Y > 1 - K.longSwipesRatio) $.slideTo(R + _);
			else if (X !== null && Y < 0 && Math.abs(Y) > K.longSwipesRatio) $.slideTo(X);
			else $.slideTo(R);
	} else {
		if (!K.shortSwipes) {
			$.slideTo($.activeIndex);
			return;
		}
		if (!($.navigation && (J.target === $.navigation.nextEl || J.target === $.navigation.prevEl))) {
			if ($.swipeDirection === 'next') $.slideTo(H !== null ? H : R + _);
			if ($.swipeDirection === 'prev') $.slideTo(X !== null ? X : R);
		} else if (J.target === $.navigation.nextEl) $.slideTo(R + _);
		else $.slideTo(R);
	}
}
function Gf() {
	let f = this,
		{ params: $, el: q } = f;
	if (q && q.offsetWidth === 0) return;
	if ($.breakpoints) f.setBreakpoint();
	let { allowSlideNext: J, allowSlidePrev: Q, snapGrid: U } = f,
		K = f.virtual && f.params.virtual.enabled;
	(f.allowSlideNext = !0), (f.allowSlidePrev = !0), f.updateSize(), f.updateSlides(), f.updateSlidesClasses();
	let j = K && $.loop;
	if (
		($.slidesPerView === 'auto' || $.slidesPerView > 1) &&
		f.isEnd &&
		!f.isBeginning &&
		!f.params.centeredSlides &&
		!j
	)
		f.slideTo(f.slides.length - 1, 0, !1, !0);
	else if (f.params.loop && !K) f.slideToLoop(f.realIndex, 0, !1, !0);
	else f.slideTo(f.activeIndex, 0, !1, !0);
	if (f.autoplay && f.autoplay.running && f.autoplay.paused)
		clearTimeout(f.autoplay.resizeTimeout),
			(f.autoplay.resizeTimeout = setTimeout(() => {
				if (f.autoplay && f.autoplay.running && f.autoplay.paused) f.autoplay.resume();
			}, 500));
	if (((f.allowSlidePrev = Q), (f.allowSlideNext = J), f.params.watchOverflow && U !== f.snapGrid))
		f.checkOverflow();
}
function i1(f) {
	let $ = this;
	if (!$.enabled) return;
	if (!$.allowClick) {
		if ($.params.preventClicks) f.preventDefault();
		if ($.params.preventClicksPropagation && $.animating) f.stopPropagation(), f.stopImmediatePropagation();
	}
}
function r1() {
	let f = this,
		{ wrapperEl: $, rtlTranslate: q, enabled: J } = f;
	if (!J) return;
	if (((f.previousTranslate = f.translate), f.isHorizontal())) f.translate = -$.scrollLeft;
	else f.translate = -$.scrollTop;
	if (f.translate === 0) f.translate = 0;
	f.updateActiveIndex(), f.updateSlidesClasses();
	let Q,
		U = f.maxTranslate() - f.minTranslate();
	if (U === 0) Q = 0;
	else Q = (f.translate - f.minTranslate()) / U;
	if (Q !== f.progress) f.updateProgress(q ? -f.translate : f.translate);
	f.emit('setTranslate', f.translate, !1);
}
function s1(f) {
	let $ = this;
	if ((H0($, f.target), $.params.cssMode || ($.params.slidesPerView !== 'auto' && !$.params.autoHeight)))
		return;
	$.update();
}
function e1() {
	let f = this;
	if (f.documentTouchHandlerProceeded) return;
	if (((f.documentTouchHandlerProceeded = !0), f.params.touchReleaseOnEdges)) f.el.style.touchAction = 'auto';
}
var Pf = (f, $) => {
	let q = v(),
		{ params: J, el: Q, wrapperEl: U, device: K } = f,
		j = !!J.nested,
		Z = $ === 'on' ? 'addEventListener' : 'removeEventListener',
		O = $;
	if (!Q || typeof Q === 'string') return;
	if (
		(q[Z]('touchstart', f.onDocumentTouchStart, { passive: !1, capture: j }),
		Q[Z]('touchstart', f.onTouchStart, { passive: !1 }),
		Q[Z]('pointerdown', f.onTouchStart, { passive: !1 }),
		q[Z]('touchmove', f.onTouchMove, { passive: !1, capture: j }),
		q[Z]('pointermove', f.onTouchMove, { passive: !1, capture: j }),
		q[Z]('touchend', f.onTouchEnd, { passive: !0 }),
		q[Z]('pointerup', f.onTouchEnd, { passive: !0 }),
		q[Z]('pointercancel', f.onTouchEnd, { passive: !0 }),
		q[Z]('touchcancel', f.onTouchEnd, { passive: !0 }),
		q[Z]('pointerout', f.onTouchEnd, { passive: !0 }),
		q[Z]('pointerleave', f.onTouchEnd, { passive: !0 }),
		q[Z]('contextmenu', f.onTouchEnd, { passive: !0 }),
		J.preventClicks || J.preventClicksPropagation)
	)
		Q[Z]('click', f.onClick, !0);
	if (J.cssMode) U[Z]('scroll', f.onScroll);
	if (J.updateOnWindowResize)
		f[O](K.ios || K.android ? 'resize orientationchange observerUpdate' : 'resize observerUpdate', Gf, !0);
	else f[O]('observerUpdate', Gf, !0);
	Q[Z]('load', f.onLoad, { capture: !0 });
};
function f5() {
	let f = this,
		{ params: $ } = f;
	if (
		((f.onTouchStart = w1.bind(f)),
		(f.onTouchMove = a1.bind(f)),
		(f.onTouchEnd = p1.bind(f)),
		(f.onDocumentTouchStart = e1.bind(f)),
		$.cssMode)
	)
		f.onScroll = r1.bind(f);
	(f.onClick = i1.bind(f)), (f.onLoad = s1.bind(f)), Pf(f, 'on');
}
function q5() {
	Pf(this, 'off');
}
var $5 = { attachEvents: f5, detachEvents: q5 },
	Bf = (f, $) => {
		return f.grid && $.grid && $.grid.rows > 1;
	};
function J5() {
	let f = this,
		{ realIndex: $, initialized: q, params: J, el: Q } = f,
		U = J.breakpoints;
	if (!U || (U && Object.keys(U).length === 0)) return;
	let K = v(),
		j = J.breakpointsBase === 'window' || !J.breakpointsBase ? J.breakpointsBase : 'container',
		Z =
			['window', 'container'].includes(J.breakpointsBase) || !J.breakpointsBase
				? f.el
				: K.querySelector(J.breakpointsBase),
		O = f.getBreakpoint(U, j, Z);
	if (!O || f.currentBreakpoint === O) return;
	let y = (O in U ? U[O] : void 0) || f.originalParams,
		N = Bf(f, J),
		A = Bf(f, y),
		F = f.params.grabCursor,
		R = y.grabCursor,
		W = J.enabled;
	if (N && !A)
		Q.classList.remove(`${J.containerModifierClass}grid`, `${J.containerModifierClass}grid-column`),
			f.emitContainerClasses();
	else if (!N && A) {
		if (
			(Q.classList.add(`${J.containerModifierClass}grid`),
			(y.grid.fill && y.grid.fill === 'column') || (!y.grid.fill && J.grid.fill === 'column'))
		)
			Q.classList.add(`${J.containerModifierClass}grid-column`);
		f.emitContainerClasses();
	}
	if (F && !R) f.unsetGrabCursor();
	else if (!F && R) f.setGrabCursor();
	['navigation', 'pagination', 'scrollbar'].forEach((D) => {
		if (typeof y[D] === 'undefined') return;
		let T = J[D] && J[D].enabled,
			B = y[D] && y[D].enabled;
		if (T && !B) f[D].disable();
		if (!T && B) f[D].enable();
	});
	let H = y.direction && y.direction !== J.direction,
		X = J.loop && (y.slidesPerView !== J.slidesPerView || H),
		Y = J.loop;
	if (H && q) f.changeDirection();
	c(f.params, y);
	let _ = f.params.enabled,
		L = f.params.loop;
	if (
		(Object.assign(f, {
			allowTouchMove: f.params.allowTouchMove,
			allowSlideNext: f.params.allowSlideNext,
			allowSlidePrev: f.params.allowSlidePrev,
		}),
		W && !_)
	)
		f.disable();
	else if (!W && _) f.enable();
	if (((f.currentBreakpoint = O), f.emit('_beforeBreakpoint', y), q)) {
		if (X) f.loopDestroy(), f.loopCreate($), f.updateSlides();
		else if (!Y && L) f.loopCreate($), f.updateSlides();
		else if (Y && !L) f.loopDestroy();
	}
	f.emit('breakpoint', y);
}
function Q5(f, $ = 'window', q) {
	if (!f || ($ === 'container' && !q)) return;
	let J = !1,
		Q = C(),
		U = $ === 'window' ? Q.innerHeight : q.clientHeight,
		K = Object.keys(f).map((j) => {
			if (typeof j === 'string' && j.indexOf('@') === 0) {
				let Z = parseFloat(j.substr(1));
				return { value: U * Z, point: j };
			}
			return { value: j, point: j };
		});
	K.sort((j, Z) => parseInt(j.value, 10) - parseInt(Z.value, 10));
	for (let j = 0; j < K.length; j += 1) {
		let { point: Z, value: O } = K[j];
		if ($ === 'window') {
			if (Q.matchMedia(`(min-width: ${O}px)`).matches) J = Z;
		} else if (O <= q.clientWidth) J = Z;
	}
	return J || 'max';
}
var U5 = { setBreakpoint: J5, getBreakpoint: Q5 };
function Z5(f, $) {
	let q = [];
	return (
		f.forEach((J) => {
			if (typeof J === 'object')
				Object.keys(J).forEach((Q) => {
					if (J[Q]) q.push($ + Q);
				});
			else if (typeof J === 'string') q.push($ + J);
		}),
		q
	);
}
function K5() {
	let f = this,
		{ classNames: $, params: q, rtl: J, el: Q, device: U } = f,
		K = Z5(
			[
				'initialized',
				q.direction,
				{ 'free-mode': f.params.freeMode && q.freeMode.enabled },
				{ autoheight: q.autoHeight },
				{ rtl: J },
				{ grid: q.grid && q.grid.rows > 1 },
				{ 'grid-column': q.grid && q.grid.rows > 1 && q.grid.fill === 'column' },
				{ android: U.android },
				{ ios: U.ios },
				{ 'css-mode': q.cssMode },
				{ centered: q.cssMode && q.centeredSlides },
				{ 'watch-progress': q.watchSlidesProgress },
			],
			q.containerModifierClass,
		);
	$.push(...K), Q.classList.add(...$), f.emitContainerClasses();
}
function j5() {
	let f = this,
		{ el: $, classNames: q } = f;
	if (!$ || typeof $ === 'string') return;
	$.classList.remove(...q), f.emitContainerClasses();
}
var y5 = { addClasses: K5, removeClasses: j5 };
function O5() {
	let f = this,
		{ isLocked: $, params: q } = f,
		{ slidesOffsetBefore: J } = q;
	if (J) {
		let Q = f.slides.length - 1,
			U = f.slidesGrid[Q] + f.slidesSizesGrid[Q] + J * 2;
		f.isLocked = f.size > U;
	} else f.isLocked = f.snapGrid.length === 1;
	if (q.allowSlideNext === !0) f.allowSlideNext = !f.isLocked;
	if (q.allowSlidePrev === !0) f.allowSlidePrev = !f.isLocked;
	if ($ && $ !== f.isLocked) f.isEnd = !1;
	if ($ !== f.isLocked) f.emit(f.isLocked ? 'lock' : 'unlock');
}
var A5 = { checkOverflow: O5 },
	Df = {
		init: !0,
		direction: 'horizontal',
		oneWayMovement: !1,
		swiperElementNodeName: 'SWIPER-CONTAINER',
		touchEventsTarget: 'wrapper',
		initialSlide: 0,
		speed: 300,
		cssMode: !1,
		updateOnWindowResize: !0,
		resizeObserver: !0,
		nested: !1,
		createElements: !1,
		eventsPrefix: 'swiper',
		enabled: !0,
		focusableElements: 'input, select, option, textarea, button, video, label',
		width: null,
		height: null,
		preventInteractionOnTransition: !1,
		userAgent: null,
		url: null,
		edgeSwipeDetection: !1,
		edgeSwipeThreshold: 20,
		autoHeight: !1,
		setWrapperSize: !1,
		virtualTranslate: !1,
		effect: 'slide',
		breakpoints: void 0,
		breakpointsBase: 'window',
		spaceBetween: 0,
		slidesPerView: 1,
		slidesPerGroup: 1,
		slidesPerGroupSkip: 0,
		slidesPerGroupAuto: !1,
		centeredSlides: !1,
		centeredSlidesBounds: !1,
		slidesOffsetBefore: 0,
		slidesOffsetAfter: 0,
		normalizeSlideIndex: !0,
		centerInsufficientSlides: !1,
		watchOverflow: !0,
		roundLengths: !1,
		touchRatio: 1,
		touchAngle: 45,
		simulateTouch: !0,
		shortSwipes: !0,
		longSwipes: !0,
		longSwipesRatio: 0.5,
		longSwipesMs: 300,
		followFinger: !0,
		allowTouchMove: !0,
		threshold: 5,
		touchMoveStopPropagation: !1,
		touchStartPreventDefault: !0,
		touchStartForcePreventDefault: !1,
		touchReleaseOnEdges: !1,
		uniqueNavElements: !0,
		resistance: !0,
		resistanceRatio: 0.85,
		watchSlidesProgress: !1,
		grabCursor: !1,
		preventClicks: !0,
		preventClicksPropagation: !0,
		slideToClickedSlide: !1,
		loop: !1,
		loopAddBlankSlides: !0,
		loopAdditionalSlides: 0,
		loopPreventsSliding: !0,
		rewind: !1,
		allowSlidePrev: !0,
		allowSlideNext: !0,
		swipeHandler: null,
		noSwiping: !0,
		noSwipingClass: 'swiper-no-swiping',
		noSwipingSelector: null,
		passiveListeners: !0,
		maxBackfaceHiddenSlides: 10,
		containerModifierClass: 'swiper-',
		slideClass: 'swiper-slide',
		slideBlankClass: 'swiper-slide-blank',
		slideActiveClass: 'swiper-slide-active',
		slideVisibleClass: 'swiper-slide-visible',
		slideFullyVisibleClass: 'swiper-slide-fully-visible',
		slideNextClass: 'swiper-slide-next',
		slidePrevClass: 'swiper-slide-prev',
		wrapperClass: 'swiper-wrapper',
		lazyPreloaderClass: 'swiper-lazy-preloader',
		lazyPreloadPrevNext: 0,
		runCallbacksOnInit: !0,
		_emitClasses: !1,
	};
function V5(f, $) {
	return function q(J = {}) {
		let Q = Object.keys(J)[0],
			U = J[Q];
		if (typeof U !== 'object' || U === null) {
			c($, J);
			return;
		}
		if (f[Q] === !0) f[Q] = { enabled: !0 };
		if (Q === 'navigation' && f[Q] && f[Q].enabled && !f[Q].prevEl && !f[Q].nextEl) f[Q].auto = !0;
		if (['pagination', 'scrollbar'].indexOf(Q) >= 0 && f[Q] && f[Q].enabled && !f[Q].el) f[Q].auto = !0;
		if (!(Q in f && 'enabled' in U)) {
			c($, J);
			return;
		}
		if (typeof f[Q] === 'object' && !('enabled' in f[Q])) f[Q].enabled = !0;
		if (!f[Q]) f[Q] = { enabled: !1 };
		c($, J);
	};
}
var S0 = {
		eventsEmitter: y1,
		update: _1,
		translate: T1,
		transition: P1,
		slide: g1,
		loop: o1,
		grabCursor: n1,
		events: $5,
		breakpoints: U5,
		checkOverflow: A5,
		classes: y5,
	},
	x0 = {};
class S {
	constructor(...f) {
		let $, q;
		if (f.length === 1 && f[0].constructor && Object.prototype.toString.call(f[0]).slice(8, -1) === 'Object')
			q = f[0];
		else [$, q] = f;
		if (!q) q = {};
		if (((q = c({}, q)), $ && !q.el)) q.el = $;
		let J = v();
		if (q.el && typeof q.el === 'string' && J.querySelectorAll(q.el).length > 1) {
			let j = [];
			return (
				J.querySelectorAll(q.el).forEach((Z) => {
					let O = c({}, q, { el: Z });
					j.push(new S(O));
				}),
				j
			);
		}
		let Q = this;
		if (
			((Q.__swiper__ = !0),
			(Q.support = Tf()),
			(Q.device = hf({ userAgent: q.userAgent })),
			(Q.browser = zf()),
			(Q.eventsListeners = {}),
			(Q.eventsAnyListeners = []),
			(Q.modules = [...Q.__modules__]),
			q.modules && Array.isArray(q.modules))
		)
			Q.modules.push(...q.modules);
		let U = {};
		Q.modules.forEach((j) => {
			j({
				params: q,
				swiper: Q,
				extendParams: V5(q, U),
				on: Q.on.bind(Q),
				once: Q.once.bind(Q),
				off: Q.off.bind(Q),
				emit: Q.emit.bind(Q),
			});
		});
		let K = c({}, Df, U);
		if (
			((Q.params = c({}, K, x0, q)),
			(Q.originalParams = c({}, Q.params)),
			(Q.passedParams = c({}, q)),
			Q.params && Q.params.on)
		)
			Object.keys(Q.params.on).forEach((j) => {
				Q.on(j, Q.params.on[j]);
			});
		if (Q.params && Q.params.onAny) Q.onAny(Q.params.onAny);
		if (
			(Object.assign(Q, {
				enabled: Q.params.enabled,
				el: $,
				classNames: [],
				slides: [],
				slidesGrid: [],
				snapGrid: [],
				slidesSizesGrid: [],
				isHorizontal() {
					return Q.params.direction === 'horizontal';
				},
				isVertical() {
					return Q.params.direction === 'vertical';
				},
				activeIndex: 0,
				realIndex: 0,
				isBeginning: !0,
				isEnd: !1,
				translate: 0,
				previousTranslate: 0,
				progress: 0,
				velocity: 0,
				animating: !1,
				cssOverflowAdjustment() {
					return Math.trunc(this.translate / 8388608) * 8388608;
				},
				allowSlideNext: Q.params.allowSlideNext,
				allowSlidePrev: Q.params.allowSlidePrev,
				touchEventsData: {
					isTouched: void 0,
					isMoved: void 0,
					allowTouchCallbacks: void 0,
					touchStartTime: void 0,
					isScrolling: void 0,
					currentTranslate: void 0,
					startTranslate: void 0,
					allowThresholdMove: void 0,
					focusableElements: Q.params.focusableElements,
					lastClickTime: 0,
					clickTimeout: void 0,
					velocities: [],
					allowMomentumBounce: void 0,
					startMoving: void 0,
					pointerId: null,
					touchId: null,
				},
				allowClick: !0,
				allowTouchMove: Q.params.allowTouchMove,
				touches: { startX: 0, startY: 0, currentX: 0, currentY: 0, diff: 0 },
				imagesToLoad: [],
				imagesLoaded: 0,
			}),
			Q.emit('_swiper'),
			Q.params.init)
		)
			Q.init();
		return Q;
	}
	getDirectionLabel(f) {
		if (this.isHorizontal()) return f;
		return {
			width: 'height',
			'margin-top': 'margin-left',
			'margin-bottom ': 'margin-right',
			'margin-left': 'margin-top',
			'margin-right': 'margin-bottom',
			'padding-left': 'padding-top',
			'padding-right': 'padding-bottom',
			marginRight: 'marginBottom',
		}[f];
	}
	getSlideIndex(f) {
		let { slidesEl: $, params: q } = this,
			J = I($, `.${q.slideClass}, swiper-slide`),
			Q = U0(J[0]);
		return U0(f) - Q;
	}
	getSlideIndexByData(f) {
		return this.getSlideIndex(this.slides.find(($) => $.getAttribute('data-swiper-slide-index') * 1 === f));
	}
	getSlideIndexWhenGrid(f) {
		if (this.grid && this.params.grid && this.params.grid.rows > 1) {
			if (this.params.grid.fill === 'column') f = Math.floor(f / this.params.grid.rows);
			else if (this.params.grid.fill === 'row') f = f % Math.ceil(this.slides.length / this.params.grid.rows);
		}
		return f;
	}
	recalcSlides() {
		let f = this,
			{ slidesEl: $, params: q } = f;
		f.slides = I($, `.${q.slideClass}, swiper-slide`);
	}
	enable() {
		let f = this;
		if (f.enabled) return;
		if (((f.enabled = !0), f.params.grabCursor)) f.setGrabCursor();
		f.emit('enable');
	}
	disable() {
		let f = this;
		if (!f.enabled) return;
		if (((f.enabled = !1), f.params.grabCursor)) f.unsetGrabCursor();
		f.emit('disable');
	}
	setProgress(f, $) {
		let q = this;
		f = Math.min(Math.max(f, 0), 1);
		let J = q.minTranslate(),
			U = (q.maxTranslate() - J) * f + J;
		q.translateTo(U, typeof $ === 'undefined' ? 0 : $), q.updateActiveIndex(), q.updateSlidesClasses();
	}
	emitContainerClasses() {
		let f = this;
		if (!f.params._emitClasses || !f.el) return;
		let $ = f.el.className.split(' ').filter((q) => {
			return q.indexOf('swiper') === 0 || q.indexOf(f.params.containerModifierClass) === 0;
		});
		f.emit('_containerClasses', $.join(' '));
	}
	getSlideClasses(f) {
		let $ = this;
		if ($.destroyed) return '';
		return f.className
			.split(' ')
			.filter((q) => {
				return q.indexOf('swiper-slide') === 0 || q.indexOf($.params.slideClass) === 0;
			})
			.join(' ');
	}
	emitSlidesClasses() {
		let f = this;
		if (!f.params._emitClasses || !f.el) return;
		let $ = [];
		f.slides.forEach((q) => {
			let J = f.getSlideClasses(q);
			$.push({ slideEl: q, classNames: J }), f.emit('_slideClass', q, J);
		}),
			f.emit('_slideClasses', $);
	}
	slidesPerViewDynamic(f = 'current', $ = !1) {
		let q = this,
			{ params: J, slides: Q, slidesGrid: U, slidesSizesGrid: K, size: j, activeIndex: Z } = q,
			O = 1;
		if (typeof J.slidesPerView === 'number') return J.slidesPerView;
		if (J.centeredSlides) {
			let V = Q[Z] ? Math.ceil(Q[Z].swiperSlideSize) : 0,
				y;
			for (let N = Z + 1; N < Q.length; N += 1)
				if (Q[N] && !y) {
					if (((V += Math.ceil(Q[N].swiperSlideSize)), (O += 1), V > j)) y = !0;
				}
			for (let N = Z - 1; N >= 0; N -= 1)
				if (Q[N] && !y) {
					if (((V += Q[N].swiperSlideSize), (O += 1), V > j)) y = !0;
				}
		} else if (f === 'current') {
			for (let V = Z + 1; V < Q.length; V += 1) if ($ ? U[V] + K[V] - U[Z] < j : U[V] - U[Z] < j) O += 1;
		} else for (let V = Z - 1; V >= 0; V -= 1) if (U[Z] - U[V] < j) O += 1;
		return O;
	}
	update() {
		let f = this;
		if (!f || f.destroyed) return;
		let { snapGrid: $, params: q } = f;
		if (q.breakpoints) f.setBreakpoint();
		[...f.el.querySelectorAll('[loading="lazy"]')].forEach((U) => {
			if (U.complete) H0(f, U);
		}),
			f.updateSize(),
			f.updateSlides(),
			f.updateProgress(),
			f.updateSlidesClasses();
		function J() {
			let U = f.rtlTranslate ? f.translate * -1 : f.translate,
				K = Math.min(Math.max(U, f.maxTranslate()), f.minTranslate());
			f.setTranslate(K), f.updateActiveIndex(), f.updateSlidesClasses();
		}
		let Q;
		if (q.freeMode && q.freeMode.enabled && !q.cssMode) {
			if ((J(), q.autoHeight)) f.updateAutoHeight();
		} else {
			if ((q.slidesPerView === 'auto' || q.slidesPerView > 1) && f.isEnd && !q.centeredSlides) {
				let U = f.virtual && q.virtual.enabled ? f.virtual.slides : f.slides;
				Q = f.slideTo(U.length - 1, 0, !1, !0);
			} else Q = f.slideTo(f.activeIndex, 0, !1, !0);
			if (!Q) J();
		}
		if (q.watchOverflow && $ !== f.snapGrid) f.checkOverflow();
		f.emit('update');
	}
	changeDirection(f, $ = !0) {
		let q = this,
			J = q.params.direction;
		if (!f) f = J === 'horizontal' ? 'vertical' : 'horizontal';
		if (f === J || (f !== 'horizontal' && f !== 'vertical')) return q;
		if (
			(q.el.classList.remove(`${q.params.containerModifierClass}${J}`),
			q.el.classList.add(`${q.params.containerModifierClass}${f}`),
			q.emitContainerClasses(),
			(q.params.direction = f),
			q.slides.forEach((Q) => {
				if (f === 'vertical') Q.style.width = '';
				else Q.style.height = '';
			}),
			q.emit('changeDirection'),
			$)
		)
			q.update();
		return q;
	}
	changeLanguageDirection(f) {
		let $ = this;
		if (($.rtl && f === 'rtl') || (!$.rtl && f === 'ltr')) return;
		if ((($.rtl = f === 'rtl'), ($.rtlTranslate = $.params.direction === 'horizontal' && $.rtl), $.rtl))
			$.el.classList.add(`${$.params.containerModifierClass}rtl`), ($.el.dir = 'rtl');
		else $.el.classList.remove(`${$.params.containerModifierClass}rtl`), ($.el.dir = 'ltr');
		$.update();
	}
	mount(f) {
		let $ = this;
		if ($.mounted) return !0;
		let q = f || $.params.el;
		if (typeof q === 'string') q = document.querySelector(q);
		if (!q) return !1;
		if (
			((q.swiper = $),
			q.parentNode &&
				q.parentNode.host &&
				q.parentNode.host.nodeName === $.params.swiperElementNodeName.toUpperCase())
		)
			$.isElement = !0;
		let J = () => {
				return `.${($.params.wrapperClass || '').trim().split(' ').join('.')}`;
			},
			U = (() => {
				if (q && q.shadowRoot && q.shadowRoot.querySelector) return q.shadowRoot.querySelector(J());
				return I(q, J())[0];
			})();
		if (!U && $.params.createElements)
			(U = o('div', $.params.wrapperClass)),
				q.append(U),
				I(q, `.${$.params.slideClass}`).forEach((K) => {
					U.append(K);
				});
		return (
			Object.assign($, {
				el: q,
				wrapperEl: U,
				slidesEl: $.isElement && !q.parentNode.host.slideSlots ? q.parentNode.host : U,
				hostEl: $.isElement ? q.parentNode.host : q,
				mounted: !0,
				rtl: q.dir.toLowerCase() === 'rtl' || t(q, 'direction') === 'rtl',
				rtlTranslate:
					$.params.direction === 'horizontal' &&
					(q.dir.toLowerCase() === 'rtl' || t(q, 'direction') === 'rtl'),
				wrongRTL: t(U, 'display') === '-webkit-box',
			}),
			!0
		);
	}
	init(f) {
		let $ = this;
		if ($.initialized) return $;
		if ($.mount(f) === !1) return $;
		if (($.emit('beforeInit'), $.params.breakpoints)) $.setBreakpoint();
		if (($.addClasses(), $.updateSize(), $.updateSlides(), $.params.watchOverflow)) $.checkOverflow();
		if ($.params.grabCursor && $.enabled) $.setGrabCursor();
		if ($.params.loop && $.virtual && $.params.virtual.enabled)
			$.slideTo($.params.initialSlide + $.virtual.slidesBefore, 0, $.params.runCallbacksOnInit, !1, !0);
		else $.slideTo($.params.initialSlide, 0, $.params.runCallbacksOnInit, !1, !0);
		if ($.params.loop) $.loopCreate(void 0, !0);
		$.attachEvents();
		let J = [...$.el.querySelectorAll('[loading="lazy"]')];
		if ($.isElement) J.push(...$.hostEl.querySelectorAll('[loading="lazy"]'));
		return (
			J.forEach((Q) => {
				if (Q.complete) H0($, Q);
				else
					Q.addEventListener('load', (U) => {
						H0($, U.target);
					});
			}),
			c0($),
			($.initialized = !0),
			c0($),
			$.emit('init'),
			$.emit('afterInit'),
			$
		);
	}
	destroy(f = !0, $ = !0) {
		let q = this,
			{ params: J, el: Q, wrapperEl: U, slides: K } = q;
		if (typeof q.params === 'undefined' || q.destroyed) return null;
		if ((q.emit('beforeDestroy'), (q.initialized = !1), q.detachEvents(), J.loop)) q.loopDestroy();
		if ($) {
			if ((q.removeClasses(), Q && typeof Q !== 'string')) Q.removeAttribute('style');
			if (U) U.removeAttribute('style');
			if (K && K.length)
				K.forEach((j) => {
					j.classList.remove(
						J.slideVisibleClass,
						J.slideFullyVisibleClass,
						J.slideActiveClass,
						J.slideNextClass,
						J.slidePrevClass,
					),
						j.removeAttribute('style'),
						j.removeAttribute('data-swiper-slide-index');
				});
		}
		if (
			(q.emit('destroy'),
			Object.keys(q.eventsListeners).forEach((j) => {
				q.off(j);
			}),
			f !== !1)
		) {
			if (q.el && typeof q.el !== 'string') q.el.swiper = null;
			Yf(q);
		}
		return (q.destroyed = !0), null;
	}
	static extendDefaults(f) {
		c(x0, f);
	}
	static get extendedDefaults() {
		return x0;
	}
	static get defaults() {
		return Df;
	}
	static installModule(f) {
		if (!S.prototype.__modules__) S.prototype.__modules__ = [];
		let $ = S.prototype.__modules__;
		if (typeof f === 'function' && $.indexOf(f) < 0) $.push(f);
	}
	static use(f) {
		if (Array.isArray(f)) return f.forEach(($) => S.installModule($)), S;
		return S.installModule(f), S;
	}
}
Object.keys(S0).forEach((f) => {
	Object.keys(S0[f]).forEach(($) => {
		S.prototype[$] = S0[f][$];
	});
});
S.use([K1, j1]);
function R0(f, $, q, J) {
	if (f.params.createElements)
		Object.keys(J).forEach((Q) => {
			if (!q[Q] && q.auto === !0) {
				let U = I(f.el, `.${J[Q]}`)[0];
				if (!U) (U = o('div', J[Q])), (U.className = J[Q]), f.el.append(U);
				(q[Q] = U), ($[Q] = U);
			}
		});
	return q;
}
var If =
	'<svg class="swiper-navigation-icon" width="11" height="20" viewBox="0 0 11 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.38296 20.0762C0.111788 19.805 0.111788 19.3654 0.38296 19.0942L9.19758 10.2796L0.38296 1.46497C0.111788 1.19379 0.111788 0.754138 0.38296 0.482966C0.654131 0.211794 1.09379 0.211794 1.36496 0.482966L10.4341 9.55214C10.8359 9.9539 10.8359 10.6053 10.4341 11.007L1.36496 20.0762C1.09379 20.3474 0.654131 20.3474 0.38296 20.0762Z" fill="currentColor"/></svg>';
function g0({ swiper: f, extendParams: $, on: q, emit: J }) {
	$({
		navigation: {
			nextEl: null,
			prevEl: null,
			addIcons: !0,
			hideOnClick: !1,
			disabledClass: 'swiper-button-disabled',
			hiddenClass: 'swiper-button-hidden',
			lockClass: 'swiper-button-lock',
			navigationDisabledClass: 'swiper-navigation-disabled',
		},
	}),
		(f.navigation = { nextEl: null, prevEl: null, arrowSvg: If });
	function Q(A) {
		let F;
		if (A && typeof A === 'string' && f.isElement) {
			if (((F = f.el.querySelector(A) || f.hostEl.querySelector(A)), F)) return F;
		}
		if (A) {
			if (typeof A === 'string') F = [...document.querySelectorAll(A)];
			if (
				f.params.uniqueNavElements &&
				typeof A === 'string' &&
				F &&
				F.length > 1 &&
				f.el.querySelectorAll(A).length === 1
			)
				F = f.el.querySelector(A);
			else if (F && F.length === 1) F = F[0];
		}
		if (A && !F) return A;
		return F;
	}
	function U(A, F) {
		let R = f.params.navigation;
		(A = u(A)),
			A.forEach((W) => {
				if (W) {
					if ((W.classList[F ? 'add' : 'remove'](...R.disabledClass.split(' ')), W.tagName === 'BUTTON'))
						W.disabled = F;
					if (f.params.watchOverflow && f.enabled) W.classList[f.isLocked ? 'add' : 'remove'](R.lockClass);
				}
			});
	}
	function K() {
		let { nextEl: A, prevEl: F } = f.navigation;
		if (f.params.loop) {
			U(F, !1), U(A, !1);
			return;
		}
		U(F, f.isBeginning && !f.params.rewind), U(A, f.isEnd && !f.params.rewind);
	}
	function j(A) {
		if ((A.preventDefault(), f.isBeginning && !f.params.loop && !f.params.rewind)) return;
		f.slidePrev(), J('navigationPrev');
	}
	function Z(A) {
		if ((A.preventDefault(), f.isEnd && !f.params.loop && !f.params.rewind)) return;
		f.slideNext(), J('navigationNext');
	}
	function O() {
		let A = f.params.navigation;
		if (
			((f.params.navigation = R0(f, f.originalParams.navigation, f.params.navigation, {
				nextEl: 'swiper-button-next',
				prevEl: 'swiper-button-prev',
			})),
			!(A.nextEl || A.prevEl))
		)
			return;
		let F = Q(A.nextEl),
			R = Q(A.prevEl);
		Object.assign(f.navigation, { nextEl: F, prevEl: R }), (F = u(F)), (R = u(R));
		let W = (H, X) => {
			if (H) {
				if (A.addIcons && H.matches('.swiper-button-next,.swiper-button-prev') && !H.querySelector('svg')) {
					let Y = document.createElement('div');
					q0(Y, If), H.appendChild(Y.querySelector('svg')), Y.remove();
				}
				H.addEventListener('click', X === 'next' ? Z : j);
			}
			if (!f.enabled && H) H.classList.add(...A.lockClass.split(' '));
		};
		F.forEach((H) => W(H, 'next')), R.forEach((H) => W(H, 'prev'));
	}
	function V() {
		let { nextEl: A, prevEl: F } = f.navigation;
		(A = u(A)), (F = u(F));
		let R = (W, H) => {
			W.removeEventListener('click', H === 'next' ? Z : j),
				W.classList.remove(...f.params.navigation.disabledClass.split(' '));
		};
		A.forEach((W) => R(W, 'next')), F.forEach((W) => R(W, 'prev'));
	}
	q('init', () => {
		if (f.params.navigation.enabled === !1) N();
		else O(), K();
	}),
		q('toEdge fromEdge lock unlock', () => {
			K();
		}),
		q('destroy', () => {
			V();
		}),
		q('enable disable', () => {
			let { nextEl: A, prevEl: F } = f.navigation;
			if (((A = u(A)), (F = u(F)), f.enabled)) {
				K();
				return;
			}
			[...A, ...F].filter((R) => !!R).forEach((R) => R.classList.add(f.params.navigation.lockClass));
		}),
		q('click', (A, F) => {
			let { nextEl: R, prevEl: W } = f.navigation;
			(R = u(R)), (W = u(W));
			let H = F.target,
				X = W.includes(H) || R.includes(H);
			if (f.isElement && !X) {
				let Y = F.path || (F.composedPath && F.composedPath());
				if (Y) X = Y.find((_) => R.includes(_) || W.includes(_));
			}
			if (f.params.navigation.hideOnClick && !X) {
				if (
					f.pagination &&
					f.params.pagination &&
					f.params.pagination.clickable &&
					(f.pagination.el === H || f.pagination.el.contains(H))
				)
					return;
				let Y;
				if (R.length) Y = R[0].classList.contains(f.params.navigation.hiddenClass);
				else if (W.length) Y = W[0].classList.contains(f.params.navigation.hiddenClass);
				if (Y === !0) J('navigationShow');
				else J('navigationHide');
				[...R, ...W].filter((_) => !!_).forEach((_) => _.classList.toggle(f.params.navigation.hiddenClass));
			}
		});
	let y = () => {
			f.el.classList.remove(...f.params.navigation.navigationDisabledClass.split(' ')), O(), K();
		},
		N = () => {
			f.el.classList.add(...f.params.navigation.navigationDisabledClass.split(' ')), V();
		};
	Object.assign(f.navigation, { enable: y, disable: N, update: K, init: O, destroy: V });
}
var X0 = {
	slider: '[data-gallery-slider]',
	wrapper: '[data-gallery-section]',
	prevArrow: '[data-gallery-prev-arrow]',
	nextArrow: '[data-gallery-next-arrow]',
};
S.use([g0]);
var W0 = new Map(),
	Sf = () => {
		let f = document.querySelectorAll(X0.wrapper);
		if (!f.length) return;
		f.forEach(($) => {
			let q = $.querySelector(X0.slider),
				J = $.querySelector(X0.prevArrow),
				Q = $.querySelector(X0.nextArrow);
			if (!q) return;
			if (W0.has(q)) W0.get(q).destroy(!0, !0), W0.delete(q);
			if (q.swiper) q.swiper.destroy(!0, !0);
			let U = new S(q, {
				observer: !0,
				observeParents: !0,
				speed: 800,
				slidesPerView: 'auto',
				navigation: { prevEl: J, nextEl: Q },
			});
			W0.set(q, U);
		});
	};
window.initGallerySwiper = Sf;
var xf = Sf;
var F5 = () => {
		let f = {
				field: '.js-image-upload',
				input: '.js-image-upload-input',
				gallery: '.js-image-upload-gallery',
			},
			$ = document.querySelector(f.input),
			q = document.querySelector(f.gallery);
		console.log($),
			$.addEventListener('change', (J) => {
				q.innerHTML = '';
				let Q = J.target.files;
				if (Q.length > 0)
					Array.from(Q).forEach((U) => {
						if (U.type.startsWith('image/')) {
							let K = new window.FileReader();
							(K.onload = (j) => {
								let Z = document.createElement('img');
								(Z.src = j.target.result),
									Z.classList.add('image-preview'),
									(Z.alt = `Загруженне зображення: ${U.name}`),
									q.appendChild(Z);
							}),
								K.readAsDataURL(U);
						}
					});
			});
	},
	cf = F5;
var N5 = () => {
	A0(() => {
		L0();
	}),
		L0(),
		qf(() => {
			document.body.classList.add('body--loaded');
		}),
		Ff(),
		xf(),
		cf();
	let f = $f({
		triggers: document.querySelectorAll('.js-map-accordion-trigger'),
		activeStateName: 'map_popup__filter--active-mod',
	});
	window.markerClickHandler = ($) => {
		console.log('MARKER CLICKED'), console.log($), window.updateShelterPopupData($);
	};
};
ff(() => {
	N5();
});
