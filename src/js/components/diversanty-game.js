/**
 * Диверсанти — гра «Пройди вербувальника».
 * Дата-керований чат-квест. Увесь флоу (сценарії, репліки, розгалуження, фінали)
 * лежить у ./static/diversanty-game.json — редагується без ребілду коду.
 *
 * Формат JSON: { start: "<id>", nodes: { "<id>": {...} } }
 *   вузол-крок:  { image?, messages: [], choices: [{ text, next }] }
 *   вузол-фінал: { result: "good" | "bad", messages: [] }
 */

const DATA_URL = './static/diversanty-game.json';

const diversantyGame = () => {
	const $root = document.querySelector('[data-diversanty-game]');
	if (!$root) return;

	const $screen = $root.querySelector('[data-game-screen]');
	const $chat = $root.querySelector('[data-game-chat]');
	if (!$screen || !$chat) return;

	const scrollToEnd = () => {
		$screen.scrollTop = $screen.scrollHeight;
	};

	const makeEl = (className, html) => {
		const el = document.createElement('div');
		el.className = className;
		if (html != null) el.innerHTML = html;
		return el;
	};

	const addImage = (src) => {
		const $wrap = makeEl('diversanty_game__image');
		const $img = document.createElement('img');
		$img.src = src;
		$img.alt = '';
		$img.loading = 'lazy';
		$wrap.appendChild($img);
		$chat.appendChild($wrap);
		scrollToEnd();
	};

	const addMessage = (text) => {
		$chat.appendChild(makeEl('diversanty_game__msg', `<span>${text}</span>`));
		scrollToEnd();
	};

	const addReply = (text) => {
		$chat.appendChild(makeEl('diversanty_game__reply', `<span>${text}</span>`));
		scrollToEnd();
	};

	let $choices = null;
	const clearChoices = () => {
		if ($choices) {
			$choices.remove();
			$choices = null;
		}
	};

	const run = (data) => {
		const nodes = data && data.nodes;
		if (!nodes) return;

		const renderChoices = (choices) => {
			clearChoices();
			$choices = makeEl('diversanty_game__choices');
			choices.forEach((choice) => {
				const $btn = document.createElement('button');
				$btn.type = 'button';
				$btn.className = 'diversanty_game__choice';
				$btn.textContent = choice.text;
				$btn.addEventListener('click', () => {
					clearChoices();
					addReply(choice.text);
					goTo(choice.next);
				});
				$choices.appendChild($btn);
			});
			$chat.appendChild($choices);
			scrollToEnd();
		};

		const renderOutcome = (node) => {
			$chat.appendChild(
				makeEl(
					`diversanty_game__outcome diversanty_game__outcome--${node.result}_mod`,
					`<span>${(node.messages || []).join('<br>')}</span>`,
				),
			);

			const $restart = document.createElement('button');
			$restart.type = 'button';
			$restart.className = 'diversanty_game__restart';
			$restart.textContent = 'Спробувати ще раз';
			$restart.addEventListener('click', start);
			$chat.appendChild($restart);
			scrollToEnd();
		};

		function goTo(id) {
			const node = nodes[id];
			if (!node) return;

			if (node.image) addImage(node.image);

			if (node.result) {
				// фінал: текст лише в кольоровому боксі (без дубля білими баблами)
				renderOutcome(node);
			} else {
				(node.messages || []).forEach(addMessage);
				if (node.choices) renderChoices(node.choices);
			}
		}

		function start() {
			clearChoices();
			$chat.innerHTML = '';
			goTo(data.start);
		}

		start();
	};

	fetch(DATA_URL)
		.then((res) => (res.ok ? res.json() : Promise.reject(res.status)))
		.then(run)
		.catch((err) => {
			// eslint-disable-next-line no-console
			console.warn('diversanty-game: не вдалося завантажити флоу', DATA_URL, err);
		});
};

export default diversantyGame;
