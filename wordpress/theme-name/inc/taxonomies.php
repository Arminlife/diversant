<?php

add_action( 'init', 'slidstvo_taxonomy_init' );
function slidstvo_taxonomy_init() {
    register_taxonomy('tags',
        array (
            0 => 'investigations',
            1 => 'important',
            2 => 'news',
            3 => 'video',
            4 => 'special-projects',
            5 => 'blogs',
            6 => 'articles',
            7 => 'events',
            8 => 'warnews',
            9 => 'english-stories',
        ),
        array (
            'labels' =>
                array (
                    'name' => 'Теги',
                    'singular_name' => 'Тег',
                    'search_items' => 'Search Теги',
                    'popular_items' => 'Popular Теги',
                    'all_items' => 'All Теги',
                    'parent_item' => 'Parent Тег',
                    'parent_item_colon' => 'Parent Тег:',
                    'edit_item' => 'Edit Тег',
                    'update_item' => 'Update Тег',
                    'add_new_item' => 'Add New Тег',
                    'new_item_name' => 'New Тег Name',
                    'separate_items_with_commas' => 'Separate Теги with commas',
                    'add_or_remove_items' => 'Add or remove Теги',
                    'choose_from_most_used' => 'Choose from the most used Теги',
                    'menu_name' => 'Теги',
                ),
            'slug' => 'tags',
            'public' => true,
            'hierarchical' => true,
            'supports' =>
                array (
                    'investigations' => '1',
                    'important' => '1',
                    'news' => 1,
                    'video' => 1,
                    'special-projects' => 1,
                    'blogs' => 1,
                    'articles' => 1,
                    'events' => 1,
                ),
            'rewrite' =>
                array (
                    'enabled' => '1',
                    'slug' => 'tags',
                    'with_front' => true,
                    'hierarchical' => true,
                ),
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => '1',
            'query_var_enabled' => '1',
            'query_var' => true,
            'name' => 'tags',
            'id' => 'tags',
        ));

    register_taxonomy('regions',
        array (
            0 => 'investigations',
            1 => 'news',
            2 => 'video',
            3 => 'special-projects',
            4 => 'articles',
            5 => 'events',
            6 => 'warnews',
            7 => 'english-stories',
        ),
        array (
            'labels' =>
                array (
                    'name' => 'Регіони',
                    'singular_name' => 'Регіон',
                    'search_items' => 'Search Регіони',
                    'popular_items' => 'Popular Регіони',
                    'all_items' => 'All Регіони',
                    'parent_item' => 'Parent Регіон',
                    'parent_item_colon' => 'Parent Регіон:',
                    'edit_item' => 'Edit Регіон',
                    'update_item' => 'Update Регіон',
                    'add_new_item' => 'Add New Регіон',
                    'new_item_name' => 'New Регіон Name',
                    'separate_items_with_commas' => 'Separate Регіони with commas',
                    'add_or_remove_items' => 'Add or remove Регіони',
                    'choose_from_most_used' => 'Choose from the most used Регіони',
                    'menu_name' => 'Регіони',
                ),
            'slug' => 'regions',
            'public' => true,
            'hierarchical' => true,
            'supports' =>
                array (
                    'investigations' => '1',
                    'news' => 1,
                    'video' => 1,
                    'special-projects' => 1,
                    'articles' => 1,
                    'events' => 1,
                ),
            'rewrite' =>
                array (
                    'enabled' => '1',
                    'slug' => 'regions',
                    'with_front' => true,
                    'hierarchical' => true,
                ),
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => '1',
            'query_var_enabled' => '1',
            'query_var' => true,
            'name' => 'regions',
            'id' => 'regions',
        ));

    register_taxonomy('journalists',
        array (
            0 => 'blogs',
            1 => 'news',
            2 => 'special-projects',
            3 => 'articles',
            4 => 'video',
            5 => 'success-stories',
            6 => 'warnews',
            7 => 'english-stories',
        ),
        array (
            'icon' => 'admin-post',
            'labels' =>
                array (
                    'name' => 'Журналісти',
                    'singular_name' => 'Журналіст',
                    'search_items' => 'Search Журналісти',
                    'popular_items' => 'Popular Журналісти',
                    'all_items' => 'All Журналісти',
                    'parent_item' => 'Parent Журналіст',
                    'parent_item_colon' => 'Parent Журналіст:',
                    'edit_item' => 'Edit Журналіст',
                    'update_item' => 'Update Журналіст',
                    'add_new_item' => 'Add New Журналіст',
                    'new_item_name' => 'New Журналіст Name',
                    'separate_items_with_commas' => 'Separate Журналісти with commas',
                    'add_or_remove_items' => 'Add or remove Журналісти',
                    'choose_from_most_used' => 'Choose from the most used Журналісти',
                    'menu_name' => 'Журналісти',
                ),
            'slug' => 'journalists',
            'public' => true,
            'hierarchical' => true,
            'supports' =>
                array (
                    'blogs' => 1,
                    'news' => 1,
                    'special-projects' => 1,
                    'articles' => 1,
                    'video' => 1,
                    'success-stories' => 1,
                ),
            'rewrite' =>
                array (
                    'enabled' => '1',
                    'slug' => 'journalists',
                    'with_front' => true,
                    'hierarchical' => true,
                ),
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => '1',
            'query_var_enabled' => '1',
            'query_var' => true,
            'rest_base' => '',
            'name' => 'journalists',
            'id' => 'journalists',
        ));

    register_taxonomy('investigation_type',
        array (
            0 => 'investigations',
            1 => 'articles',
            2 => 'news',
            3 => 'warnews',
            4 => 'english-stories',
        ), array (
            'labels' =>
                array (
                    'name' => 'Види контенту',
                    'singular_name' => 'Вид контенту',
                    'search_items' => 'Search Види контенту',
                    'popular_items' => 'Popular Види контенту',
                    'all_items' => 'All Види контенту',
                    'parent_item' => 'Parent Вид контенту',
                    'parent_item_colon' => 'Parent Вид контенту:',
                    'edit_item' => 'Edit Вид контенту',
                    'update_item' => 'Update Вид контенту',
                    'add_new_item' => 'Add New Вид контенту',
                    'new_item_name' => 'New Вид контенту Name',
                    'separate_items_with_commas' => 'Separate Види контенту with commas',
                    'add_or_remove_items' => 'Add or remove Види контенту',
                    'choose_from_most_used' => 'Choose from the most used Види контенту',
                    'menu_name' => 'Види контенту',
                ),
            'slug' => 'investigation_type',
            'public' => true,
            'hierarchical' => true,
            'supports' =>
                array (
                    'investigations' => '1',
                    'articles' => 1,
                    'news' => 1,
                ),
            'rewrite' =>
                array (
                    'enabled' => '1',
                    'slug' => 'investigation_type',
                    'with_front' => true,
                    'hierarchical' => true,
                ),
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => '1',
            'query_var_enabled' => '1',
            'query_var' => true,
            'name' => 'investigation_type',
            'id' => 'investigation_type',
        ));

    register_taxonomy('success-stories-category',
        array (
            0 => 'success-stories',
        ),
        array (
            'labels' =>
                array (
                    'name' => 'Категорії',
                    'singular_name' => 'Категорія',
                    'search_items' => 'Search Категорії',
                    'popular_items' => 'Popular Категорії',
                    'all_items' => 'All Категорії',
                    'parent_item' => 'Parent Категорія',
                    'parent_item_colon' => 'Parent Категорія:',
                    'edit_item' => 'Edit Категорія',
                    'update_item' => 'Update Категорія',
                    'add_new_item' => 'Add New Категорія',
                    'new_item_name' => 'New Категорія Name',
                    'separate_items_with_commas' => 'Separate Категорії with commas',
                    'add_or_remove_items' => 'Add or remove Категорії',
                    'choose_from_most_used' => 'Choose from the most used Категорії',
                    'menu_name' => 'Категорії',
                ),
            'slug' => 'success-stories-category',
            'public' => true,
            'hierarchical' => true,
            'supports' =>
                array (
                    'success-stories' => 1,
                ),
            'rewrite' =>
                array (
                    'enabled' => '1',
                    'slug' => 'success-stories-category',
                    'with_front' => true,
                    'hierarchical' => true,
                ),
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => '1',
            'query_var_enabled' => '1',
            'query_var' => true,
            'rest_base' => '',
            'name' => 'success-stories-category',
            'id' => 'success-stories-category',
        ));
}


/**
 * Register Custom Taxonomies for Shelter Post Type
 */

function register_shelter_taxonomies() {

	$post_type = 'shelters';

	$taxonomies = array(
		// ✅ SHOW in admin columns
		array(
			'slug'              => 'shelter-district',
			'singular'          => 'Район',
			'plural'            => 'Район',
			'hierarchical'      => true,
			'show_admin_column' => true,  // ← Show
		),
		array(
			'slug'              => 'shelter-type',
			'singular'          => 'Тип укриття',
			'plural'            => 'Тип укриття',
			'hierarchical'      => true,
			'show_admin_column' => true,  // ← Show
		),


		// ❌ HIDE from admin columns
		array(
			'slug'              => 'status',
			'singular'          => 'Статус',
			'plural'            => 'Статус',
			'hierarchical'      => true,
			'show_admin_column' => false,  // ← Show
		),
		array(
			'slug'              => 'condition',
			'singular'          => 'Стан укриття',
			'plural'            => 'Стан укриття',
			'hierarchical'      => true,
			'show_admin_column' => false,  // ← Show
		),
		array(
			'slug'              => 'shelter-category',
			'singular'          => 'Вид укриття',
			'plural'            => 'Вид укриття',
			'hierarchical'      => true,
			'show_admin_column' => false, // ← Hidden
		),
		array(
			'slug'              => 'building-type',
			'singular'          => 'Тип будівлі',
			'plural'            => 'Тип будівлі',
			'hierarchical'      => true,
			'show_admin_column' => false, // ← Hidden
		),
		array(
			'slug'              => 'owner',
			'singular'          => 'Власник',
			'plural'            => 'Власник',
			'hierarchical'      => false,
			'show_admin_column' => false, // ← Hidden
		),
		array(
			'slug'              => 'additional-info',
			'singular'          => 'Додаткова інформація',
			'plural'            => 'Додаткова інформація',
			'hierarchical'      => false,
			'show_admin_column' => false, // ← Hidden
		),
		array(
			'slug'              => 'owner-form',
			'singular'          => 'Форма власності',
			'plural'            => 'Форми власності',
			'hierarchical'      => true,
			'show_admin_column' => false, // ← Hidden
		),
		array(
			'slug'              => 'phone',
			'singular'          => 'Телефон',
			'plural'            => 'Телефон',
			'hierarchical'      => true,
			'show_admin_column' => false, // ← Hidden
		),
		array(
			'slug'              => 'inclusivity',
			'singular'          => 'Інклюзивність',
			'plural'            => 'Інклюзивність',
			'hierarchical'      => true,
			'show_admin_column' => false, // ← Hidden
		),
		array(
			'slug'              => 'seats',
			'singular'          => 'Місця для сидіння',
			'plural'            => 'Місця для сидіння',
			'hierarchical'      => true,
			'show_admin_column' => false, // ← Hidden
		),
		array(
			'slug'              => 'wc',
			'singular'          => 'Вбиральня',
			'plural'            => 'Вбиральня',
			'hierarchical'      => true,
			'show_admin_column' => false, // ← Hidden
		),
		array(
			'slug'              => 'water',
			'singular'          => 'Вода',
			'plural'            => 'Вода',
			'hierarchical'      => true,
			'show_admin_column' => false, // ← Hidden
		),
		array(
			'slug'              => 'capacity',
			'singular'          => 'Місткість (осіб)',
			'plural'            => 'Місткість (осіб)',
			'hierarchical'      => true,
			'show_admin_column' => false, // ← Hidden
		),
		array(
			'slug'              => 'area',
			'singular'          => 'Площа (м2)',
			'plural'            => 'Площа (м2)',
			'hierarchical'      => true,
			'show_admin_column' => false, // ← Hidden
		),
	);

	foreach ( $taxonomies as $taxonomy ) {

		$labels = array(
			'name'          => $taxonomy['plural'],
			'singular_name' => $taxonomy['singular'],
			'menu_name'     => $taxonomy['plural'],
			'all_items'     => 'Всі ' . $taxonomy['plural'],
			'add_new_item'  => 'Додати ' . $taxonomy['singular'],
			'edit_item'     => 'Редагувати ' . $taxonomy['singular'],
			'search_items'  => 'Шукати ' . $taxonomy['plural'],
			'not_found'     => 'Не знайдено',
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => $taxonomy['hierarchical'],
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => $taxonomy['show_admin_column'], // ← Dynamic
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => $taxonomy['slug'] ),
		);

		register_taxonomy( $taxonomy['slug'], array( $post_type ), $args );
	}
}
add_action( 'init', 'register_shelter_taxonomies', 0 );