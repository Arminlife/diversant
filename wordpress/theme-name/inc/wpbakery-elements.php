<?php

/**
 * WPBakery Custom Elements
 */

// Register custom WPBakery blocks that should be separated from main content
add_filter('custom_wpbakery_blocks', 'register_custom_wpbakery_blocks');
function register_custom_wpbakery_blocks($blocks) {
	return [
		'banner_block',
		'related_articles_block',
		'related_projects_block',
		'article_info_block',
		//'shelter_map_block',
		//'article_team_block',
	];
}

// Register Related Articles WPBakery Element
function register_related_articles_vc_element() {
	if (!function_exists('vc_map')) {
		return;
	}

	vc_map([
		'name' => 'Рекомендовані статті (Мапа укриттів)',
		'base' => 'related_articles_block',
		'category' => 'Content',
		'icon' => 'icon-wpb-posts-slider',
		'params' => [
			[
				'type' => 'autocomplete',
				'heading' => 'Виберіть статті',
				'param_name' => 'article_ids',
				'settings' => [
					'multiple' => true,
					'min_length' => 1,
					'unique_values' => true,
					'values' => [],
				],
				'description' => 'Виберіть до 3 статей. Якщо вибрано менше, решта заповняться автоматично останніми статтями.',
			],
			[
				'type' => 'textfield',
				'heading' => 'Текст кнопки деталей',
				'param_name' => 'details_text',
				'description' => 'Текст, який буде відображатись на кнопці деталей',
			],
		],
	]);
}
add_action('vc_before_init', 'register_related_articles_vc_element');

// Autocomplete callback for searching articles
add_filter('vc_autocomplete_related_articles_block_article_ids_callback', 'related_articles_autocomplete_callback', 10, 1);
function related_articles_autocomplete_callback($search_string) {
	$posts = get_posts([
		'post_type' => ['map-article', 'special-projects'],
		's' => $search_string,
		'posts_per_page' => 20,
		'orderby' => 'date',
		'order' => 'DESC',
	]);

	$results = [];
	foreach ($posts as $post) {
		$post_type_label = get_post_type_object($post->post_type)->labels->singular_name;
		$results[] = [
			'value' => $post->ID,
			'label' => $post->post_title . ' (' . $post_type_label . ')',
		];
	}

	return $results;
}

// Render callback for autocomplete field
add_filter('vc_autocomplete_related_articles_block_article_ids_render', 'related_articles_autocomplete_render', 10, 1);
function related_articles_autocomplete_render($data) {
	$value = isset($data['value']) ? $data['value'] : '';

	if (empty($value)) {
		return false;
	}

	$post = get_post($value);
	if (!$post) {
		return false;
	}

	return [
		'value' => $post->ID,
		'label' => $post->post_title,
	];
}

// Register shortcode for Related Articles
add_shortcode('related_articles_block', 'related_articles_block_shortcode');
function related_articles_block_shortcode($atts) {
	$atts = shortcode_atts([
		'article_ids' => '',
		'details_text' => '',
	], $atts);

	$article_ids = !empty($atts['article_ids']) ? explode(',', $atts['article_ids']) : [];
	$article_ids = array_filter(array_map('intval', $article_ids));

	set_query_var('wpb_related_articles_ids', $article_ids);
	set_query_var('wpb_related_articles_details_text', $atts['details_text']);

	ob_start();
	get_template_part('parts/map-related-articles');
	return ob_get_clean();
}

// Register Banner WPBakery Element
function register_banner_vc_element() {
	if (!function_exists('vc_map')) {
		return;
	}

	vc_map([
		'name' => 'Банер',
		'base' => 'banner_block',
		'category' => 'Content',
		'icon' => 'icon-wpb-single-image',
		'params' => [
			[
				'type' => 'attach_image',
				'heading' => 'Зображення',
				'param_name' => 'image',
				'description' => 'Виберіть зображення для банера',
			],
			[
				'type' => 'textarea',
				'heading' => 'Заголовок',
				'param_name' => 'title',
				'description' => 'Заголовок банера. Можна використовувати <br> для переносу рядка',
			],
			[
				'type' => 'textfield',
				'heading' => 'Текст кнопки',
				'param_name' => 'button_text',
				'description' => 'Текст на кнопці',
			],
			[
				'type' => 'vc_link',
				'heading' => 'Посилання кнопки',
				'param_name' => 'button_link',
				'description' => 'URL куди веде кнопка',
			],
		],
	]);
}
add_action('vc_before_init', 'register_banner_vc_element');

// Register shortcode for Banner
add_shortcode('banner_block', 'banner_block_shortcode');
function banner_block_shortcode($atts) {
	$atts = shortcode_atts([
		'image' => '',
		'title' => '',
		'button_text' => '',
		'button_link' => '',
	], $atts);

	$image_id = intval($atts['image']);
	$button_link = vc_build_link($atts['button_link']);

	set_query_var('wpb_banner_image_id', $image_id);
	set_query_var('wpb_banner_title', $atts['title']);
	set_query_var('wpb_banner_button_text', $atts['button_text']);
	set_query_var('wpb_banner_button_url', $button_link['url'] ?? '#');
	set_query_var('wpb_banner_button_target', $button_link['target'] ?? '_self');

	ob_start();
	get_template_part('parts/banner-v2');
	return ob_get_clean();
}

// Register Article Info WPBakery Element
function register_article_info_vc_element() {
	if (!function_exists('vc_map')) {
		return;
	}

	vc_map([
		'name' => 'Info block: Теги, кнопки для шерінгу',
		'base' => 'article_info_block',
		'category' => 'Content',
		'icon' => 'icon-wpb-single-post-slider',
		'description' => 'Теги та кнопки шерінгу статті',
		'params' => [],
	]);
}
add_action('vc_before_init', 'register_article_info_vc_element');

// Register shortcode for Article Info
add_shortcode('article_info_block', 'article_info_block_shortcode');
function article_info_block_shortcode($atts) {
	$post_id = get_the_ID();
	$tags = get_the_terms($post_id, 'map-article-tag');

	set_query_var('article_info_tags', $tags ?: []);
	set_query_var('article_info_url', get_permalink($post_id));
	set_query_var('article_info_title', get_the_title($post_id));

	ob_start();
	get_template_part('parts/article-info');
	return ob_get_clean();
}

// Register Shelter Map WPBakery Element
function register_shelter_map_vc_element() {
	if (!function_exists('vc_map')) {
		return;
	}

	vc_map([
		'name' => 'Мапа укриттів',
		'base' => 'shelter_map_block',
		'category' => 'Content',
		'icon' => 'icon-wpb-map-pin',
		'description' => 'Інтерактивна карта укриттів',
		'params' => [],
	]);
}
add_action('vc_before_init', 'register_shelter_map_vc_element');

// Register shortcode for Shelter Map
add_shortcode('shelter_map_block', 'shelter_map_block_shortcode');
function shelter_map_block_shortcode($atts) {
	return do_shortcode('[shelter_map]');
}



// Register Projects WPBakery Element
function register_projects_vc_element() {
	if (!function_exists('vc_map')) {
		return;
	}

	vc_map([
		'name' => 'Спецпроєкти (Мапа укриттів)',
		'base' => 'related_projects_block',
		'category' => 'Content',
		'icon' => 'icon-wpb-posts-slider',
		'params' => [
			[
				'type' => 'autocomplete',
				'heading' => 'Виберіть спецпроєкти',
				'param_name' => 'project_ids',
				'settings' => [
					'multiple' => true,
					'min_length' => 1,
					'unique_values' => true,
					'values' => [],
				],
				'description' => 'Виберіть до 2 спецпроектів',
			],
		],
	]);
}
add_action('vc_before_init', 'register_projects_vc_element');


// Autocomplete callback for searching projects
add_filter('vc_autocomplete_related_projects_block_project_ids_callback', 'related_projects_autocomplete_callback', 10, 1);
function related_projects_autocomplete_callback($search_string) {
	$posts = get_posts([
		'post_type' => 'special-projects',
		's' => $search_string,
		'posts_per_page' => 20,
		'orderby' => 'date',
		'order' => 'DESC',
	]);

	$results = [];
	foreach ($posts as $post) {
		$results[] = [
			'value' => $post->ID,
			'label' => $post->post_title,
		];
	}

	return $results;
}

// Render callback for autocomplete field
add_filter('vc_autocomplete_related_projects_block_project_ids_render', 'related_projects_autocomplete_render', 10, 1);
function related_projects_autocomplete_render($data) {
	$value = isset($data['value']) ? $data['value'] : '';

	if (empty($value)) {
		return false;
	}

	$post = get_post($value);
	if (!$post) {
		return false;
	}

	return [
		'value' => $post->ID,
		'label' => $post->post_title,
	];
}

// Register shortcode for Related Articles
add_shortcode('related_projects_block', 'related_projects_block_shortcode');
function related_projects_block_shortcode($atts) {
	$atts = shortcode_atts([
		'project_ids' => '',
		'details_text' => '',
	], $atts);

	$project_ids = !empty($atts['project_ids']) ? explode(',', $atts['project_ids']) : [];
	$project_ids = array_filter(array_map('intval', $project_ids));

	set_query_var('wpb_related_projects_ids', $project_ids);
	set_query_var('wpb_related_projects_details_text', $atts['details_text']);

	ob_start();
	get_template_part('parts/map-related-projects');
	return ob_get_clean();
}


// Register Article Team WPBakery Element
function register_article_team_vc_element() {
	if ( ! function_exists( 'vc_map' ) ) {
		return;
	}

	// Get journalists for dropdown
	$journalist_options = [ '-- Виберіть --' => '' ];

	$journalists = get_terms( [
		'taxonomy'   => 'journalists',
		'hide_empty' => false,
		'orderby'    => 'name',
		'order'      => 'ASC',
	] );

	if ( ! is_wp_error( $journalists ) && ! empty( $journalists ) ) {
		foreach ( $journalists as $journalist ) {
			$journalist_options[ $journalist->name ] = (string) $journalist->term_id;
		}
	}

	vc_map( [
		'name'        => 'Команда статті',
		'base'        => 'article_team_block',
		'category'    => 'Content',
		'icon'        => 'icon-wpb-users-slash-solid',
		'description' => 'Блок з авторами та командою статті',
		'params'      => [
			// Role 1
			[
				'type'       => 'textfield',
				'heading'    => 'Роль 1: Назва',
				'param_name' => 'role_1_title',
				'std'        => 'Авторка',
				'group'      => 'Автор',
			],
			[
				'type'        => 'dropdown',
				'heading'     => 'Журналіст 1 (з бази)',
				'param_name'  => 'role_1_j1',
				'value'       => $journalist_options,
				'group'       => 'Автор',
				'description' => 'Або виберіть з бази, або введіть вручну нижче',
			],
			[
				'type'        => 'textfield',
				'heading'     => 'Журналіст 1 (вручну): Ім\'я',
				'param_name'  => 'role_1_j1_name',
				'group'       => 'Автор',
				'description' => 'Якщо не вибрано з бази',
			],
			[
				'type'        => 'textfield',
				'heading'     => 'Журналіст 1 (вручну): Посилання',
				'param_name'  => 'role_1_j1_url',
				'group'       => 'Автор',
				'description' => 'Необов\'язково',
			],
			[
				'type'       => 'dropdown',
				'heading'    => 'Журналіст 2 (з бази)',
				'param_name' => 'role_1_j2',
				'value'      => $journalist_options,
				'group'      => 'Автор',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 2 (вручну): Ім\'я',
				'param_name' => 'role_1_j2_name',
				'group'      => 'Автор',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 2 (вручну): Посилання',
				'param_name' => 'role_1_j2_url',
				'group'      => 'Автор',
			],
			[
				'type'       => 'dropdown',
				'heading'    => 'Журналіст 3 (з бази)',
				'param_name' => 'role_1_j3',
				'value'      => $journalist_options,
				'group'      => 'Автор',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 3 (вручну): Ім\'я',
				'param_name' => 'role_1_j3_name',
				'group'      => 'Автор',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 3 (вручну): Посилання',
				'param_name' => 'role_1_j3_url',
				'group'      => 'Автор',
			],

			// Role 2
			[
				'type'       => 'textfield',
				'heading'    => 'Роль 2: Назва',
				'param_name' => 'role_2_title',
				'std'        => 'Редакторки',
				'group'      => 'Редактори',
			],
			[
				'type'       => 'dropdown',
				'heading'    => 'Журналіст 1 (з бази)',
				'param_name' => 'role_2_j1',
				'value'      => $journalist_options,
				'group'      => 'Редактори',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 1 (вручну): Ім\'я',
				'param_name' => 'role_2_j1_name',
				'group'      => 'Редактори',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 1 (вручну): Посилання',
				'param_name' => 'role_2_j1_url',
				'group'      => 'Редактори',
			],
			[
				'type'       => 'dropdown',
				'heading'    => 'Журналіст 2 (з бази)',
				'param_name' => 'role_2_j2',
				'value'      => $journalist_options,
				'group'      => 'Редактори',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 2 (вручну): Ім\'я',
				'param_name' => 'role_2_j2_name',
				'group'      => 'Редактори',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 2 (вручну): Посилання',
				'param_name' => 'role_2_j2_url',
				'group'      => 'Редактори',
			],
			[
				'type'       => 'dropdown',
				'heading'    => 'Журналіст 3 (з бази)',
				'param_name' => 'role_2_j3',
				'value'      => $journalist_options,
				'group'      => 'Редактори',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 3 (вручну): Ім\'я',
				'param_name' => 'role_2_j3_name',
				'group'      => 'Редактори',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 3 (вручну): Посилання',
				'param_name' => 'role_2_j3_url',
				'group'      => 'Редактори',
			],

			// Role 3
			[
				'type'       => 'textfield',
				'heading'    => 'Роль 3: Назва',
				'param_name' => 'role_3_title',
				'std'        => 'Журналістка',
				'group'      => 'Журналіст',
			],
			[
				'type'       => 'dropdown',
				'heading'    => 'Журналіст 1 (з бази)',
				'param_name' => 'role_3_j1',
				'value'      => $journalist_options,
				'group'      => 'Журналіст',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 1 (вручну): Ім\'я',
				'param_name' => 'role_3_j1_name',
				'group'      => 'Журналіст',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 1 (вручну): Посилання',
				'param_name' => 'role_3_j1_url',
				'group'      => 'Журналіст',
			],
			[
				'type'       => 'dropdown',
				'heading'    => 'Журналіст 2 (з бази)',
				'param_name' => 'role_3_j2',
				'value'      => $journalist_options,
				'group'      => 'Журналіст',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 2 (вручну): Ім\'я',
				'param_name' => 'role_3_j2_name',
				'group'      => 'Журналіст',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 2 (вручну): Посилання',
				'param_name' => 'role_3_j2_url',
				'group'      => 'Журналіст',
			],
			[
				'type'       => 'dropdown',
				'heading'    => 'Журналіст 3 (з бази)',
				'param_name' => 'role_3_j3',
				'value'      => $journalist_options,
				'group'      => 'Журналіст',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 3 (вручну): Ім\'я',
				'param_name' => 'role_3_j3_name',
				'group'      => 'Журналіст',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 3 (вручну): Посилання',
				'param_name' => 'role_3_j3_url',
				'group'      => 'Журналіст',
			],

			// Role 4
			[
				'type'       => 'textfield',
				'heading'    => 'Роль 4: Назва',
				'param_name' => 'role_4_title',
				'std'        => 'Оператор',
				'group'      => 'Оператор',
			],
			[
				'type'       => 'dropdown',
				'heading'    => 'Журналіст 1 (з бази)',
				'param_name' => 'role_4_j1',
				'value'      => $journalist_options,
				'group'      => 'Оператор',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 1 (вручну): Ім\'я',
				'param_name' => 'role_4_j1_name',
				'group'      => 'Оператор',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 1 (вручну): Посилання',
				'param_name' => 'role_4_j1_url',
				'group'      => 'Оператор',
			],
			[
				'type'       => 'dropdown',
				'heading'    => 'Журналіст 2 (з бази)',
				'param_name' => 'role_4_j2',
				'value'      => $journalist_options,
				'group'      => 'Оператор',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 2 (вручну): Ім\'я',
				'param_name' => 'role_4_j2_name',
				'group'      => 'Оператор',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 2 (вручну): Посилання',
				'param_name' => 'role_4_j2_url',
				'group'      => 'Оператор',
			],
			[
				'type'       => 'dropdown',
				'heading'    => 'Журналіст 3 (з бази)',
				'param_name' => 'role_4_j3',
				'value'      => $journalist_options,
				'group'      => 'Оператор',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 3 (вручну): Ім\'я',
				'param_name' => 'role_4_j3_name',
				'group'      => 'Оператор',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 3 (вручну): Посилання',
				'param_name' => 'role_4_j3_url',
				'group'      => 'Оператор',
			],

			// Role 5
			[
				'type'       => 'textfield',
				'heading'    => 'Роль 5: Назва',
				'param_name' => 'role_5_title',
				'std'        => 'Режисер монтажу',
				'group'      => 'Режисер монтажу',
			],
			[
				'type'       => 'dropdown',
				'heading'    => 'Журналіст 1 (з бази)',
				'param_name' => 'role_5_j1',
				'value'      => $journalist_options,
				'group'      => 'Режисер монтажу',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 1 (вручну): Ім\'я',
				'param_name' => 'role_5_j1_name',
				'group'      => 'Режисер монтажу',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 1 (вручну): Посилання',
				'param_name' => 'role_5_j1_url',
				'group'      => 'Режисер монтажу',
			],
			[
				'type'       => 'dropdown',
				'heading'    => 'Журналіст 2 (з бази)',
				'param_name' => 'role_5_j2',
				'value'      => $journalist_options,
				'group'      => 'Режисер монтажу',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 2 (вручну): Ім\'я',
				'param_name' => 'role_5_j2_name',
				'group'      => 'Режисер монтажу',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 2 (вручну): Посилання',
				'param_name' => 'role_5_j2_url',
				'group'      => 'Режисер монтажу',
			],
			[
				'type'       => 'dropdown',
				'heading'    => 'Журналіст 3 (з бази)',
				'param_name' => 'role_5_j3',
				'value'      => $journalist_options,
				'group'      => 'Режисер монтажу',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 3 (вручну): Ім\'я',
				'param_name' => 'role_5_j3_name',
				'group'      => 'Режисер монтажу',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 3 (вручну): Посилання',
				'param_name' => 'role_5_j3_url',
				'group'      => 'Режисер монтажу',
			],

			// Role 6
			[
				'type'       => 'textfield',
				'heading'    => 'Роль 6: Назва',
				'param_name' => 'role_6_title',
				'std'        => 'Дизайн',
				'group'      => 'Дизайн',
			],
			[
				'type'       => 'dropdown',
				'heading'    => 'Журналіст 1 (з бази)',
				'param_name' => 'role_6_j1',
				'value'      => $journalist_options,
				'group'      => 'Дизайн',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 1 (вручну): Ім\'я',
				'param_name' => 'role_6_j1_name',
				'group'      => 'Дизайн',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 1 (вручну): Посилання',
				'param_name' => 'role_6_j1_url',
				'group'      => 'Дизайн',
			],
			[
				'type'       => 'dropdown',
				'heading'    => 'Журналіст 2 (з бази)',
				'param_name' => 'role_6_j2',
				'value'      => $journalist_options,
				'group'      => 'Дизайн',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 2 (вручну): Ім\'я',
				'param_name' => 'role_6_j2_name',
				'group'      => 'Дизайн',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 2 (вручну): Посилання',
				'param_name' => 'role_6_j2_url',
				'group'      => 'Дизайн',
			],
			[
				'type'       => 'dropdown',
				'heading'    => 'Журналіст 3 (з бази)',
				'param_name' => 'role_6_j3',
				'value'      => $journalist_options,
				'group'      => 'Дизайн',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 3 (вручну): Ім\'я',
				'param_name' => 'role_6_j3_name',
				'group'      => 'Дизайн',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 3 (вручну): Посилання',
				'param_name' => 'role_6_j3_url',
				'group'      => 'Дизайн',
			],

			// Role 7
			[
				'type'       => 'textfield',
				'heading'    => 'Роль 7: Назва',
				'param_name' => 'role_7_title',
				'std'        => 'Розробка',
				'group'      => 'Розробка',
			],
			[
				'type'       => 'dropdown',
				'heading'    => 'Журналіст 1 (з бази)',
				'param_name' => 'role_7_j1',
				'value'      => $journalist_options,
				'group'      => 'Розробка',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 1 (вручну): Ім\'я',
				'param_name' => 'role_7_j1_name',
				'group'      => 'Розробка',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 1 (вручну): Посилання',
				'param_name' => 'role_7_j1_url',
				'group'      => 'Розробка',
			],
			[
				'type'       => 'dropdown',
				'heading'    => 'Журналіст 2 (з бази)',
				'param_name' => 'role_7_j2',
				'value'      => $journalist_options,
				'group'      => 'Розробка',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 2 (вручну): Ім\'я',
				'param_name' => 'role_7_j2_name',
				'group'      => 'Розробка',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 2 (вручну): Посилання',
				'param_name' => 'role_7_j2_url',
				'group'      => 'Розробка',
			],
			[
				'type'       => 'dropdown',
				'heading'    => 'Журналіст 3 (з бази)',
				'param_name' => 'role_7_j3',
				'value'      => $journalist_options,
				'group'      => 'Розробка',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 3 (вручну): Ім\'я',
				'param_name' => 'role_7_j3_name',
				'group'      => 'Розробка',
			],
			[
				'type'       => 'textfield',
				'heading'    => 'Журналіст 3 (вручну): Посилання',
				'param_name' => 'role_7_j3_url',
				'group'      => 'Розробка',
			],

		],
	] );
}

add_action( 'vc_before_init', 'register_article_team_vc_element' );

/**
 * Shortcode for Article Team - supports both dropdown and manual text
 */
add_shortcode('article_team_block', 'article_team_block_shortcode');
function article_team_block_shortcode($atts) {

	// Build defaults
	$defaults = [
		'role_1_title' => 'Авторка',
		'role_2_title' => 'Редакторки',
		'role_3_title' => 'Журналістка',
		'role_4_title' => 'Оператор',
		'role_5_title' => 'Режисер монтажу',
		'role_6_title' => 'Дизайн',
		'role_7_title' => 'Розробка',
	];

	// Add journalist fields for each role
	for ($i = 1; $i <= 7; $i++) {
		for ($j = 1; $j <= 3; $j++) {
			$defaults["role_{$i}_j{$j}"] = '';      // Dropdown value (term ID)
			$defaults["role_{$i}_j{$j}_name"] = ''; // Manual name
			$defaults["role_{$i}_j{$j}_url"] = '';  // Manual URL
		}
	}

	$atts = shortcode_atts($defaults, $atts);

	$processed_members = [];

	for ($i = 1; $i <= 7; $i++) {
		$title = trim($atts["role_{$i}_title"]);

		// Check if ANY journalist is selected/entered for this role
		$has_journalists = false;
		for ($j = 1; $j <= 3; $j++) {
			if (!empty($atts["role_{$i}_j{$j}"]) || !empty($atts["role_{$i}_j{$j}_name"])) {
				$has_journalists = true;
				break;
			}
		}

		if (!$has_journalists) {
			continue;
		}

		$journalists = [];

		for ($j = 1; $j <= 3; $j++) {
			$term_id = intval($atts["role_{$i}_j{$j}"]);
			$manual_name = trim($atts["role_{$i}_j{$j}_name"]);
			$manual_url = trim($atts["role_{$i}_j{$j}_url"]);

			// Priority: Dropdown selection > Manual entry
			if ($term_id > 0) {
				// From taxonomy
				$term = get_term($term_id, 'journalists');

				if ($term && !is_wp_error($term)) {
					$term_link = get_term_link($term);
					$journalists[] = [
						'id' => $term->term_id,
						'name' => $term->name,
						'url' => is_wp_error($term_link) ? '#' : $term_link,
					];
				}
			} elseif (!empty($manual_name)) {
				// Manual entry
				$journalists[] = [
					'id' => 0,
					'name' => $manual_name,
					'url' => !empty($manual_url) ? $manual_url : '#',
				];
			}
		}

		if (!empty($journalists)) {
			$processed_members[] = [
				'role' => $title,
				'journalists' => $journalists,
			];
		}
	}

	if (empty($processed_members)) {
		return '';
	}

	set_query_var('wpb_article_team_members', $processed_members);

	ob_start();
	get_template_part('parts/article-team');
	return ob_get_clean();
}
