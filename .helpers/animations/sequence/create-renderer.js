import { onWindowWidthResize } from '../../utils';

/* eslint-disable no-param-reassign */
export function createRenderer(canvas) {
	if (!canvas)
		return {
			render: () => {},
		};

	const dpr = 2;
	const context = canvas.getContext('2d');
	let lastFrame = null;

	const resizeCanvas = () => {
		const displayWidth = window.innerWidth;
		const displayHeight = window.innerHeight;
		canvas.style.width = `${displayWidth}px`;
		canvas.style.height = `${displayHeight}px`;
		canvas.width = Math.floor(displayWidth * dpr);
		canvas.height = Math.floor(displayHeight * dpr);
		context.scale(dpr, dpr);
	};

	resizeCanvas();

	const render = (frame) => {
		if (!frame) return;
		window.requestAnimationFrame(() => {
			context.clearRect(0, 0, canvas.width / dpr, canvas.height / dpr);
			context.drawImage(frame, 0, 0, canvas.width / dpr, canvas.height / dpr);
			lastFrame = frame;
		});
	};

	onWindowWidthResize(() => {
		resizeCanvas();
		render(lastFrame);
	});

	return {
		render,
	};
}

export default createRenderer;
