<?php
/**
 * WPBakery Custom Elements — спецпроєкт «Диверсанти».
 *
 * Кожен елемент віддає ТУ САМУ BEM-розмітку, що й pug-верстка в Bun-проєкті
 * (slidstvo/src/pug/blocks/diversanty-*), без жодного inline-стилю.
 * Стилі й поведінка тягнуться з білда (app.css / app.js), який дзеркалиться
 * у тему в /diversanty. Тобто правки SCSS/JS у Bun-проєкті підхоплюються
 * простим ре-синком, PHP чіпати не треба.
 *
 * ── ІНТЕГРАЦІЯ (разово) ────────────────────────────────────────────────
 * 1. Підключити цей файл: у functions.php додати
 *      require_once( 'inc/wpbakery-diversanty.php' );
 * 2. Залити ассети білда в тему (дзеркало build/ → diversanty/):
 *      rsync -a /шлях/slidstvo/build/ wp-content/themes/<тема>/diversanty/
 *    (перезапускати цю команду щоразу після `bun run build` — стилі оновляться,
 *     бо enqueue має filemtime-cache-busting)
 * 3. На пості спецпроєкту (CPT special-projects):
 *      • ACF-прапорець "is_map_project" = так  → блоки рендеряться на всю ширину
 *        (single-special-projects.php уже так робить для custom_wpbakery_blocks);
 *      • додати блоки диверсантів через WPBakery у потрібному порядку.
 * 4. Інтро-перед-хедером (fullpage): працює через хук wp_body_open.
 *    Якщо header.php ще не викликає wp_body_open() — додати один рядок одразу
 *    після <body ...>:  <?php wp_body_open(); ?>  (стандарт WP, розмітку не змінює).
 * ───────────────────────────────────────────────────────────────────────
 */

if (!defined('ABSPATH')) {
	exit;
}

/** Безпечний розгортач WYSIWYG-контенту (не фаталити без WPBakery). */
function diversanty_unautop($content) {
	if (function_exists('wpb_js_remove_wpautop')) {
		return wpb_js_remove_wpautop($content, true);
	}
	return function_exists('wpautop') ? wpautop($content) : $content;
}

/* ============================================================
 *  Хелпери ассетів
 * ============================================================ */

/** Базовий URL дзеркала білда всередині теми. */
function diversanty_assets_uri() {
	return get_template_directory_uri() . '/diversanty';
}

/** Базовий шлях (файлова система) дзеркала білда. */
function diversanty_assets_dir() {
	return get_template_directory() . '/diversanty';
}

/** URL картинки блоку: diversanty/images/<rel>. */
function diversanty_img($rel) {
	return diversanty_assets_uri() . '/images/' . ltrim($rel, '/');
}

/**
 * Іконка-шеврон (єдина іконка в блоках). Повторює вивід pug-мікcіна +icon:
 * span.icon > inline svg. currentColor → колір бере з кнопки (.diversanty_*__arrow).
 */
function diversanty_chevron() {
	return '<span class="icon icon--size_mod" data-sprite-icon="chevron-right">'
		. '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">'
		. '<path d="M2 15H27.9999M14.9999 2.00007L27.9999 15L14.9999 27.9999" stroke="currentColor"/>'
		. '</svg></span>';
}

/** Перелік base-ідентифікаторів блоків диверсантів. */
function diversanty_block_bases() {
	return [
		'diversanty_head',
		'diversanty_lead',
		'diversanty_comics',
		'diversanty_game',
		'diversanty_figures',
		'diversanty_mosaic',
	];
}

/** Чи активний спецпроєкт на поточній сторінці (є хоч один блок у контенті). */
function diversanty_is_active() {
	if (!is_singular()) {
		return false;
	}
	$post = get_post();
	if (!$post) {
		return false;
	}
	foreach (diversanty_block_bases() as $base) {
		if (has_shortcode($post->post_content, $base)) {
			return true;
		}
	}
	return false;
}

/* ============================================================
 *  Реєстрація у списку повноширинних блоків
 *  (single-special-projects.php виносить їх поза вузький контейнер)
 * ============================================================ */
add_filter('custom_wpbakery_blocks', 'diversanty_register_fullwidth_blocks');
function diversanty_register_fullwidth_blocks($blocks) {
	return array_merge((array) $blocks, diversanty_block_bases());
}

/* ============================================================
 *  Ассети: підключаємо app.css / app.js лише на сторінці спецпроєкту
 * ============================================================ */
add_action('wp_enqueue_scripts', 'diversanty_enqueue_assets', 20);
function diversanty_enqueue_assets() {
	if (!diversanty_is_active()) {
		return;
	}
	$dir = diversanty_assets_dir();
	$uri = diversanty_assets_uri();

	$css = $dir . '/css/app.css';
	if (file_exists($css)) {
		wp_enqueue_style('diversanty-app', $uri . '/css/app.css', [], filemtime($css));
	}

	$js = $dir . '/js/app.js';
	if (file_exists($js)) {
		wp_enqueue_script('diversanty-app', $uri . '/js/app.js', [], filemtime($js), true);
		// Шлях до JSON гри — щоб компонент гри не був прив'язаний до відносного './static'.
		wp_localize_script('diversanty-app', 'diversantyData', [
			'gameSrc'   => $uri . '/static/diversanty-game.json',
			'assetsUri' => $uri,
		]);
	}
}

/** Клас body для сторінки спецпроєкту (як body_class:'diversanty_page' у pug). */
add_filter('body_class', 'diversanty_body_class');
function diversanty_body_class($classes) {
	if (diversanty_is_active()) {
		$classes[] = 'diversanty_page';
	}
	return $classes;
}

/** Fullpage-інтро перед хедером (через стандартний хук wp_body_open). */
add_action('wp_body_open', 'diversanty_render_intro');
function diversanty_render_intro() {
	if (!diversanty_is_active()) {
		return;
	}
	// За потреби вимкнути інтро на конкретному пості: ACF true/false "diversanty_no_intro".
	if (function_exists('get_field') && get_field('diversanty_no_intro')) {
		return;
	}
	get_template_part('parts/diversanty/intro');
}

/* ============================================================
 *  vc_map — реєстрація елементів у редакторі WPBakery
 * ============================================================ */
add_action('vc_before_init', 'diversanty_register_vc_elements');
function diversanty_register_vc_elements() {
	if (!function_exists('vc_map')) {
		return;
	}

	$cat = 'Диверсанти';

	// 1) Шапка + кредити
	vc_map([
		'name'     => 'Диверсанти: Шапка + кредити',
		'base'     => 'diversanty_head',
		'category' => $cat,
		'icon'     => 'icon-wpb-single-post-slider',
		'params'   => [
			[
				'type'        => 'textfield',
				'heading'     => 'Заголовок (H1)',
				'param_name'  => 'title',
				'description' => 'Якщо порожньо — заголовок береться з шаблону single. Заповніть, щоб перекрити.',
			],
			[
				'type'        => 'textarea_html',
				'heading'     => 'Кредити',
				'param_name'  => 'content',
				'description' => 'Список авторів/редакторів. Кожен рядок — окремий пункт (обгортайте в <li> або просто рядки).',
			],
		],
	]);

	// 2) Лід: 2 колонки + мокап телефона з чатом
	vc_map([
		'name'     => 'Диверсанти: Лід (текст + телефон)',
		'base'     => 'diversanty_lead',
		'category' => $cat,
		'icon'     => 'icon-wpb-single-image',
		'params'   => [
			[
				'type'       => 'textarea',
				'heading'    => 'Заголовок ліду',
				'param_name' => 'title',
			],
			[
				'type'       => 'textarea_html',
				'heading'    => 'Текст ліду',
				'param_name' => 'content',
			],
			[
				'type'        => 'attach_image',
				'heading'     => 'Скрін чату (в екрані телефона)',
				'param_name'  => 'chat_image',
				'description' => 'Вертикальний скрін Telegram-переписки — скролиться всередині екрана.',
			],
		],
	]);

	// 3) Комікс-слайдер (перевикористовуваний)
	vc_map([
		'name'     => 'Диверсанти: Комікс-слайдер',
		'base'     => 'diversanty_comics',
		'category' => $cat,
		'icon'     => 'icon-wpb-posts-slider',
		'params'   => [
			[
				'type'       => 'textfield',
				'heading'    => 'Назва коміксу',
				'param_name' => 'title',
			],
			[
				'type'       => 'textarea',
				'heading'    => 'Підпис (під слайдером)',
				'param_name' => 'caption',
			],
			[
				'type'        => 'attach_images',
				'heading'     => 'Кадри коміксу',
				'param_name'  => 'images',
				'description' => 'Слайди по порядку. Десктоп гортає по 2, мобілка по 1.',
			],
		],
	]);

	// 4) Гра «Пройди вербувальника»
	vc_map([
		'name'        => 'Диверсанти: Гра «Пройди вербувальника»',
		'base'        => 'diversanty_game',
		'category'    => $cat,
		'icon'        => 'icon-wpb-single-post-slider',
		'description' => 'Telegram-чат у мокапі айфона. Сценарії — з JSON (diversanty-game.json).',
		'params'      => [
			[
				'type'        => 'textfield',
				'heading'     => 'Заголовок',
				'param_name'  => 'title',
				'value'       => 'Гра «Пройди вербувальника»',
			],
			[
				'type'        => 'textfield',
				'heading'     => 'URL JSON зі сценаріями',
				'param_name'  => 'game_src',
				'description' => 'Порожньо → тема/diversanty/static/diversanty-game.json',
			],
		],
	]);

	// 5) Фігурки (інфографіка вироків)
	vc_map([
		'name'     => 'Диверсанти: Фігурки (вироки)',
		'base'     => 'diversanty_figures',
		'category' => $cat,
		'icon'     => 'icon-wpb-map-pin',
		'params'   => [
			[
				'type'        => 'textarea',
				'heading'     => 'Текст-вступ',
				'param_name'  => 'content',
				'value'       => 'Перед вами 3504 вироки. Наведіть на елемент, щоб дізнатися подробиці, або клікніть двічі, якщо хочете прочитати матеріали справи.',
			],
			[
				'type'        => 'textfield',
				'heading'     => 'К-сть фігурок (демо-рендер)',
				'param_name'  => 'count',
				'value'       => '800',
				'description' => 'Скільки силуетів малювати у сітці (у проді — з CPT).',
			],
		],
	]);

	// 6) Мозаїка матеріалів
	vc_map([
		'name'     => 'Диверсанти: Мозаїка матеріалів',
		'base'     => 'diversanty_mosaic',
		'category' => $cat,
		'icon'     => 'icon-wpb-posts-slider',
		'params'   => [
			[
				'type'       => 'textfield',
				'heading'    => 'Заголовок',
				'param_name' => 'title',
				'value'      => 'Мозаїка матеріалів',
			],
			[
				'type'        => 'autocomplete',
				'heading'     => 'Матеріали (картки)',
				'param_name'  => 'post_ids',
				'settings'    => [
					'multiple'      => true,
					'min_length'    => 1,
					'unique_values' => true,
					'values'        => [],
				],
				'description' => 'Оберіть статті/розслідування. Порожньо → демо-картки.',
			],
		],
	]);
}

/* ============================================================
 *  Shortcodes → шаблони parts/diversanty/*
 * ============================================================ */

add_shortcode('diversanty_head', 'diversanty_head_shortcode');
function diversanty_head_shortcode($atts, $content = '') {
	$atts = shortcode_atts(['title' => ''], $atts);
	set_query_var('dv_head_title', $atts['title']);
	set_query_var('dv_head_credits', $content ? diversanty_unautop($content) : '');
	ob_start();
	get_template_part('parts/diversanty/head');
	return ob_get_clean();
}

add_shortcode('diversanty_lead', 'diversanty_lead_shortcode');
function diversanty_lead_shortcode($atts, $content = '') {
	$atts = shortcode_atts([
		'title'      => '',
		'chat_image' => '',
	], $atts);

	$chat_url = '';
	if (!empty($atts['chat_image'])) {
		$chat_url = wp_get_attachment_image_url(intval($atts['chat_image']), 'large');
	}

	set_query_var('dv_lead_title', $atts['title']);
	set_query_var('dv_lead_text', $content ? diversanty_unautop($content) : '');
	set_query_var('dv_lead_chat', $chat_url);
	ob_start();
	get_template_part('parts/diversanty/lead');
	return ob_get_clean();
}

add_shortcode('diversanty_comics', 'diversanty_comics_shortcode');
function diversanty_comics_shortcode($atts) {
	$atts = shortcode_atts([
		'title'   => 'Назва коміксу',
		'caption' => '',
		'images'  => '',
	], $atts);

	$slides = [];
	if (!empty($atts['images'])) {
		$ids = array_filter(array_map('intval', explode(',', $atts['images'])));
		foreach ($ids as $id) {
			$src = wp_get_attachment_image_url($id, 'large');
			if ($src) {
				$slides[] = ['src' => $src, 'alt' => get_the_title($id) ?: $atts['title']];
			}
		}
	}

	set_query_var('dv_comics_title', $atts['title']);
	set_query_var('dv_comics_caption', $atts['caption']);
	set_query_var('dv_comics_slides', $slides);
	ob_start();
	get_template_part('parts/diversanty/comics');
	return ob_get_clean();
}

add_shortcode('diversanty_game', 'diversanty_game_shortcode');
function diversanty_game_shortcode($atts) {
	$atts = shortcode_atts([
		'title'    => 'Гра «Пройди вербувальника»',
		'game_src' => '',
	], $atts);

	$src = $atts['game_src'] ?: (diversanty_assets_uri() . '/static/diversanty-game.json');

	set_query_var('dv_game_title', $atts['title']);
	set_query_var('dv_game_src', $src);
	ob_start();
	get_template_part('parts/diversanty/game');
	return ob_get_clean();
}

add_shortcode('diversanty_figures', 'diversanty_figures_shortcode');
function diversanty_figures_shortcode($atts, $content = '') {
	$atts = shortcode_atts([
		'count' => 800,
	], $atts);

	set_query_var('dv_figures_count', max(0, intval($atts['count'])));
	set_query_var('dv_figures_text', $content ? wp_strip_all_tags($content) : 'Перед вами 3504 вироки. Наведіть на елемент, щоб дізнатися подробиці, або клікніть двічі, якщо хочете прочитати матеріали справи.');
	ob_start();
	get_template_part('parts/diversanty/figures');
	return ob_get_clean();
}

add_shortcode('diversanty_mosaic', 'diversanty_mosaic_shortcode');
function diversanty_mosaic_shortcode($atts) {
	$atts = shortcode_atts([
		'title'    => 'Мозаїка матеріалів',
		'post_ids' => '',
	], $atts);

	$cards = [];
	if (!empty($atts['post_ids'])) {
		$ids = array_filter(array_map('intval', explode(',', $atts['post_ids'])));
		foreach ($ids as $id) {
			$post = get_post($id);
			if (!$post) {
				continue;
			}
			$cards[] = [
				'title' => get_the_title($id),
				'date'  => get_the_date('j F Y, H:i', $id),
				'url'   => get_permalink($id),
				'img'   => get_the_post_thumbnail_url($id, 'large') ?: '',
			];
		}
	}

	set_query_var('dv_mosaic_title', $atts['title']);
	set_query_var('dv_mosaic_cards', $cards);
	ob_start();
	get_template_part('parts/diversanty/mosaic');
	return ob_get_clean();
}

/* Автокомпліт для «Мозаїки»: пошук статей/спецпроєктів/розслідувань */
add_filter('vc_autocomplete_diversanty_mosaic_post_ids_callback', 'diversanty_mosaic_autocomplete_callback', 10, 1);
function diversanty_mosaic_autocomplete_callback($search_string) {
	$posts = get_posts([
		'post_type'      => ['post', 'special-projects', 'map-article'],
		's'              => $search_string,
		'posts_per_page' => 20,
		'orderby'        => 'date',
		'order'          => 'DESC',
	]);
	$results = [];
	foreach ($posts as $post) {
		$results[] = ['value' => $post->ID, 'label' => $post->post_title];
	}
	return $results;
}

add_filter('vc_autocomplete_diversanty_mosaic_post_ids_render', 'diversanty_mosaic_autocomplete_render', 10, 1);
function diversanty_mosaic_autocomplete_render($data) {
	$value = isset($data['value']) ? $data['value'] : '';
	if (empty($value)) {
		return false;
	}
	$post = get_post($value);
	if (!$post) {
		return false;
	}
	return ['value' => $post->ID, 'label' => $post->post_title];
}
