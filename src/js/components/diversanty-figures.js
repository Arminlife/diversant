/**
 * Диверсанти — «фігурки»: фільтр за віком + тултіп деталей справи + подвійний клік на матеріали.
 * Тултіпи — через tippy.delegate (один інстанс на всю сітку, щоб не створювати сотні інстансів).
 */
import tippy, { delegate } from 'tippy.js';
import 'tippy.js/dist/tippy.css';

const SELECTORS = {
	section: '[data-diversanty-figures]',
	grid: '[data-figures-grid]',
	filterBtn: '[data-figures-filter]',
	item: '[data-figures-type]',
};

const esc = (s) => (s || '').replace(/[&<>"]/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));

const buildTip = (el) => {
	const d = el.dataset;
	const row = (label, val) => (val ? `<p><b>${label}:</b> ${esc(val)}</p>` : '');
	return `<div class="diversanty_figures__tip">${
		row('Злочин', d.crime) +
		row('Дата вироку', d.date) +
		row('Суд', d.court) +
		row('Покарання', d.punishment) +
		row('Регіон', d.region)
	}</div>`;
};

const diversantyFigures = () => {
	const $section = document.querySelector(SELECTORS.section);
	if (!$section) return;

	const $grid = $section.querySelector(SELECTORS.grid);
	const $btns = Array.from($section.querySelectorAll(SELECTORS.filterBtn));
	const $items = Array.from($section.querySelectorAll(SELECTORS.item));

	// тултіп деталей справи (делегування — один інстанс на всю сітку)
	if ($grid) {
		delegate($grid, {
			target: SELECTORS.item,
			content: (ref) => buildTip(ref),
			allowHTML: true,
			theme: 'diversanty',
			placement: 'top',
			appendTo: () => document.body,
			maxWidth: 360,
		});

		// подвійний клік → матеріали справи
		$grid.addEventListener('dblclick', (e) => {
			const $item = e.target.closest(SELECTORS.item);
			if (!$item) return;
			const url = $item.dataset.url;
			if (url && url !== '#') window.open(url, '_blank', 'noopener');
		});
	}

	// фільтр за віком
	$btns.forEach(($btn) => {
		$btn.addEventListener('click', () => {
			const filter = $btn.dataset.figuresFilter;
			$btns.forEach(($b) => $b.classList.toggle('is-active', $b === $btn));
			$items.forEach(($item) => {
				const match = filter === 'all' || $item.dataset.figuresType === filter;
				$item.classList.toggle('is-dimmed', !match);
			});
		});
	});
};

export default diversantyFigures;
