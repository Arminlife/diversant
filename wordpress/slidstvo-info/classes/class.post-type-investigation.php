<?php
/**
 * Investigation Post type
 *
 * @file
 * @package		Slidstvo info
 * @author		Andrew Skochelias
 */

defined( 'ABSPATH' ) || die();

/**
 * Class WBL_Investigation_Post_Type.
 */
class WBL_Investigation_Post_Type {

	/**
	 * Constructor
	 */
	function __construct() {

		// Register post type
		add_action( 'init', [ &$this, 'registerPostType' ] );
	}

	/**
	 * Register post type
	 *
	 * @return void.
	 */
	function registerPostType() {

		$labels = array(
			'name'               	=> __( 'Investigations', 'post type general name', 	'slidstvo-info' ),
			'singular_name'      	=> __( 'Investigation', 'post type singular name', 	'slidstvo-info' ),
			'menu_name'          	=> __( 'Investigations', 'admin menu', 				'slidstvo-info' ),
			'name_admin_bar'     	=> __( 'Investigation', 'add new on admin bar',		'slidstvo-info' ),
			'add_new'            	=> __( 'Add New', 'Investigation', 					'slidstvo-info' ),
			'add_new_item'       	=> __( 'Add New Investigation',						'slidstvo-info' ),
			'new_item'           	=> __( 'New Investigation', 						'slidstvo-info' ),
			'edit_item'          	=> __( 'Edit Investigation', 						'slidstvo-info' ),
			'view_item'          	=> __( 'View Investigation', 						'slidstvo-info' ),
			'all_items'          	=> __( 'All Investigations', 						'slidstvo-info' ),
			'search_items'       	=> __( 'Search Investigation', 						'slidstvo-info' ),
			'parent_item_colon'  	=> __( 'Parent Investigation', 						'slidstvo-info' ),
			'not_found'          	=> __( 'No Investigations found.',					'slidstvo-info' ),
			'not_found_in_trash'	=> __( 'No Investigations found in Trash.',			'slidstvo-info' ),
		);

		$args = array(
			'labels'				=> $labels,
			'public'				=> true,
			'show_ui' 				=> true,
			'menu_icon'    			=> 'dashicons-welcome-view-site',
			'publicly_queryable'	=> true,
			'menu_position'			=> 30,
			'show_in_menu'			=> true,
			'query_var' 			=> true,
			'rewrite'            	=> [ 'slug' => 'investigations' ],
			'capability_type' 		=> 'post',
			'has_archive' 			=> true,
			'hierarchical' 			=> false,
			'supports' 				=> [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions', 'page-attributes', 'post-formats' ],
		);

		register_post_type( 'wbl_investigation', $args );
	}
}

new WBL_Investigation_Post_Type();
