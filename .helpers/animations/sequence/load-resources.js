/* eslint-disable no-param-reassign */
const FORMAT = 'webp';
// const FORMAT = 'jpg';

const getAssetLocation = (index, assetsLocation, prefix) => {
	const img = `${assetsLocation}${prefix}${index.toString().padStart(4, '0')}.${FORMAT}`;
	return img;
};

export function loadResources({ assetsLocation, prefix, count, fromIndex = 0 }) {
	const loadingPromises = [];
	const sprite = [];

	const loadIteration = (image, resolve, reject) => {
		image.onload = () => resolve(image);
		image.onerror = () => {
			resolve(image);
			console.error(`Error loading image: ${image.src}. Retrying...`);
			setTimeout(() => {
				const newSrc = new URL(image.src);
				newSrc.searchParams.set('retry', Date.now());
				image.src = newSrc.href;
				loadIteration(image, resolve, reject);
			}, 1000);
		};
	};

	for (let i = 0; i < count; i += 1) {
		const img = new window.Image();

		const imagePromise = new Promise(loadIteration.bind(null, img));

		loadingPromises.push(imagePromise);
		img.src = getAssetLocation(i + fromIndex, assetsLocation, prefix);
		sprite.push(img);
	}

	return {
		loadingPromise: Promise.all(loadingPromises),
		imagesLib: sprite,
	};
}

export default loadResources;
