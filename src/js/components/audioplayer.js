/* eslint-disable no-undef */
/* eslint-disable no-plusplus */
const audioplayer = () => {
	const SELECTORS = {
		block: '.js-audioplayer',
		play: '.js-audioplayer-play',
		mute: '.js-audioplayer-mute',
		volumeInput: '.js-audioplayer-volume-input',
		canvas: '.js-audioplayer-canvas',
		audio: '.js-audioplayer-audio',
	};

	const CLASS_NAMES = {
		isPlaying: 'audioplayer--playing_state',
		isMuted: 'audioplayer--muted_state',
	};

	const $blocks = document.querySelectorAll(SELECTORS.block);
	const $allAudios = document.querySelectorAll(SELECTORS.audio);

	const WIDTH = 1440;
	const HEIGHT = (WIDTH * 2) / 3;
	const DEFAULT_BAR_HEIGHT = 50;
	const INITIAL_VOLUME = 0.65; // Початкова гучність

	$blocks.forEach((block) => {
		const canvas = block.querySelector(SELECTORS.canvas);
		const audio = block.querySelector(SELECTORS.audio);
		const playBtn = block.querySelector(SELECTORS.play);
		const muteBtn = block.querySelector(SELECTORS.mute);
		const volumeInput = block.querySelector(SELECTORS.volumeInput);

		audio.volume = INITIAL_VOLUME;
		if (volumeInput) {
			volumeInput.value = INITIAL_VOLUME;
		}

		canvas.width = WIDTH;
		canvas.height = HEIGHT;
		const canvasCtx = canvas.getContext('2d');

		let audioCtx = null;
		let analyser = null;
		let dataArray = null;
		let bufferLength = 1024;

		const draw = () => {
			requestAnimationFrame(draw);

			if (analyser && !audio.paused) {
				analyser.getByteFrequencyData(dataArray);
			}

			canvasCtx.fillStyle = '#fff';
			canvasCtx.fillRect(0, 0, WIDTH, HEIGHT);

			const barWidth = (WIDTH / bufferLength) * 3;
			let spacing = 0;
			let x = 0;

			const progress = audio.currentTime / audio.duration || 0;
			const progressThreshold = WIDTH * progress;

			for (let i = 0; i < bufferLength; i++) {
				let barHeight = DEFAULT_BAR_HEIGHT;

				if (dataArray && !audio.paused) {
					const rawHeight = (dataArray[i] / 12) ** 2;
					barHeight = Math.max(rawHeight, 2);
					spacing = 5;
				}

				canvasCtx.fillStyle = x < progressThreshold ? 'rgb(175 17 22)' : 'rgb(242 170 170)';
				canvasCtx.fillRect(x, HEIGHT / 2 - barHeight, barWidth, barHeight * 2);

				x += barWidth + spacing;

				if (x > WIDTH) break;
			}
		};

		const initializeAudio = () => {
			audioCtx = new (window.AudioContext || window.webkitAudioContext)();
			analyser = audioCtx.createAnalyser();
			const source = audioCtx.createMediaElementSource(audio);
			source.connect(analyser);
			analyser.connect(audioCtx.destination);
			analyser.fftSize = 2048;
			bufferLength = analyser.frequencyBinCount;
			dataArray = new Uint8Array(bufferLength);
		};

		volumeInput.addEventListener('input', (e) => {
			const value = e.target.value;
			audio.volume = value;
			audio.muted = value === '0';
		});

		canvas.addEventListener('click', (e) => {
			const rect = canvas.getBoundingClientRect();
			const clickX = e.clientX - rect.left;
			const clickPercent = clickX / rect.width;
			if (!isNaN(audio.duration)) {
				audio.currentTime = clickPercent * audio.duration;
			}
		});

		playBtn.addEventListener('click', () => {
			if (audio.paused) {
				$allAudios.forEach((otherAudio) => {
					if (otherAudio !== audio) otherAudio.pause();
				});
				audio.play();
			} else {
				audio.pause();
			}
		});

		muteBtn.addEventListener('click', () => {
			audio.muted = !audio.muted;
			volumeInput.value = audio.muted ? 0 : audio.volume;
		});

		audio.addEventListener('play', () => {
			block.classList.add(CLASS_NAMES.isPlaying);
			if (!audioCtx) initializeAudio();
		});

		audio.addEventListener('pause', () => {
			block.classList.remove(CLASS_NAMES.isPlaying);
		});

		audio.addEventListener('volumechange', () => {
			block.classList.toggle(CLASS_NAMES.isMuted, audio.muted || audio.volume === 0);
		});

		draw();
	});
};

export default audioplayer;
