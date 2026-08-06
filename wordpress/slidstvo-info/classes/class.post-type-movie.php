<?php
/**
 * Movie Post type
 *
 * @file
 * @package		Slidstvo info
 * @author		Andrew Skochelias
 */

defined( 'ABSPATH' ) || die();

/**
 * Class WBL_Movie_Post_Type.
 */
class WBL_Movie_Post_Type {

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
			'name'               	=> __( 'Movies', 'post type general name', 	'slidstvo-info' ),
			'singular_name'      	=> __( 'Movie', 'post type singular name', 	'slidstvo-info' ),
			'menu_name'          	=> __( 'Movies', 'admin menu', 				'slidstvo-info' ),
			'name_admin_bar'     	=> __( 'Movie', 'add new on admin bar',		'slidstvo-info' ),
			'add_new'            	=> __( 'Add New', 'Movie', 					'slidstvo-info' ),
			'add_new_item'       	=> __( 'Add New Movie',						'slidstvo-info' ),
			'new_item'           	=> __( 'New Movie', 						'slidstvo-info' ),
			'edit_item'          	=> __( 'Edit Movie', 						'slidstvo-info' ),
			'view_item'          	=> __( 'View Movie', 						'slidstvo-info' ),
			'all_items'          	=> __( 'All Movies', 						'slidstvo-info' ),
			'search_items'       	=> __( 'Search Movie', 						'slidstvo-info' ),
			'parent_item_colon'  	=> __( 'Parent Movie', 						'slidstvo-info' ),
			'not_found'          	=> __( 'No Movies found.',					'slidstvo-info' ),
			'not_found_in_trash'	=> __( 'No Movies found in Trash.',			'slidstvo-info' ),
		);

		$args = array(
			'labels'				=> $labels,
			'public'				=> true,
			'show_ui' 				=> true,
			'menu_icon'    			=> 'dashicons-format-video',
			'publicly_queryable'	=> true,
			'menu_position'			=> 30,
			'show_in_menu'			=> true,
			'query_var' 			=> true,
			'rewrite'            	=> [ 'slug' => 'movies' ],
			'capability_type' 		=> 'post',
			'has_archive' 			=> true,
			'hierarchical' 			=> false,
			'supports' 				=> [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions', 'page-attributes', 'post-formats' ],
		);

		register_post_type( 'wbl_movie', $args );
	}
}

new WBL_Movie_Post_Type();
