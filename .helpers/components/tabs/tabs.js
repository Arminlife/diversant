/* eslint-disable prefer-template */
/**
 * Default Tabs contructor
 * Functionallity:
 * toggle active state between multiple tabs/list items
 * @param {string} trigger - trigger js-selector
 * @param {string} content - content js-selector
 * @param {string} triggerClass - trigger markup selector
 * @param {string} contentClass - content markup selector
 */
function tabs({ wrapper = document, trigger, content, triggerClass, contentClass, onChange }) {
	let triggerSelector = wrapper.querySelectorAll(trigger);
	let blockSelector = wrapper.querySelectorAll(content);

	const activeTriggerClass = `${triggerClass}-active`;
	const activeContentClass = `${contentClass}-active`;

	const handActiveTab = (id) => {
		const prevTab = wrapper.querySelector(`.${activeContentClass}`);
		const prevTrigger = wrapper.querySelector(`.${activeTriggerClass}`);
		prevTab?.classList.remove(activeContentClass);
		prevTab?.style.setProperty('display', 'none');
		prevTrigger?.classList.remove(activeTriggerClass);
		// prevTrigger?.children[0]?.classList.remove(activeTriggerClass + '-child');

		const nextTab = wrapper.querySelector(`.${contentClass}[data-tab="${id}"]`);
		const nextTrigger = wrapper.querySelector(`.${triggerClass}[data-tab="${id}"]`);
		nextTab?.classList.add(activeContentClass);
		nextTab?.style.setProperty('display', 'block');
		nextTrigger?.classList.add(activeTriggerClass);
		// nextTrigger?.children[0]?.classList.remove(activeTriggerClass + '-child');

		onChange?.(id);
	};

	// set active tab from hash
	// const hash = window.location.hash.substring(1);
	// if (hash) {
	// 	handActiveTab(hash);
	// }

	if (triggerSelector.length && blockSelector.length) {
		const contents = wrapper.querySelectorAll(`.${contentClass}`);

		contents.forEach((item, index) => {
			if (index === 0) {
				item.classList.add(activeContentClass);
				return;
			}
			item.style.setProperty('display', 'none');
		});

		triggerSelector.forEach((item) => {
			item.addEventListener('click', (e) => {
				e.preventDefault();
				let id = item.getAttribute('data-tab');
				handActiveTab(id);
			});
		});
	}
}

export default tabs;


/* ------------ ** USAGE ** ------------ */

const SELECTORS = {
	tabsTrigger: '.js-section-tab-trigger',
	tabsContent: '.js-section-tab-content',
};

const classNames = {
	tabTriggerClass: 'section__tabs_button',
	tabContentClass: 'section__tabs_content',
};

tabs({
	trigger: SELECTORS.tabsTrigger,
	content: SELECTORS.tabsContent,
	triggerClass: classNames.tabTriggerClass,
	contentClass: classNames.tabContentClass,
});
