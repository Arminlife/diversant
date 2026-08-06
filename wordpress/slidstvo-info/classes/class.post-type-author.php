<?php
/**
 * Author Post type
 *
 * @file
 * @package		Slidstvo info
 * @author		Andrew Skochelias
 */

defined( 'ABSPATH' ) || die();

/**
 * Class WBL_Author_Post_Type.
 */
class WBL_Author_Post_Type {

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
			'name'               	=> __( 'Authors', 'post type general name', 	'slidstvo-info' ),
			'singular_name'      	=> __( 'Author', 'post type singular name', 	'slidstvo-info' ),
			'menu_name'          	=> __( 'Authors', 'admin menu', 				'slidstvo-info' ),
			'name_admin_bar'     	=> __( 'Author', 'add new on admin bar',		'slidstvo-info' ),
			'add_new'            	=> __( 'Add New', 'Author', 					'slidstvo-info' ),
			'add_new_item'       	=> __( 'Add New Author',						'slidstvo-info' ),
			'new_item'           	=> __( 'New Author', 							'slidstvo-info' ),
			'edit_item'          	=> __( 'Edit Author', 						'slidstvo-info' ),
			'view_item'          	=> __( 'View Author', 						'slidstvo-info' ),
			'all_items'          	=> __( 'All Authors', 						'slidstvo-info' ),
			'search_items'       	=> __( 'Search Author', 						'slidstvo-info' ),
			'parent_item_colon'  	=> __( 'Parent Author', 						'slidstvo-info' ),
			'not_found'          	=> __( 'No Authors found.',					'slidstvo-info' ),
			'not_found_in_trash'	=> __( 'No Authors found in Trash.',			'slidstvo-info' ),
		);

		$args = array(
			'labels'				=> $labels,
			'public'				=> true,
			'show_ui' 				=> true,
			'menu_icon'    			=> 'dashicons-admin-users',
			'publicly_queryable'	=> true,
			'menu_position'			=> 30,
			'show_in_menu'			=> true,
			'query_var' 			=> true,
			'rewrite'            	=> [ 'slug' => 'author' ],
			'capability_type' 		=> 'post',
			'has_archive' 			=> true,
			'hierarchical' 			=> false,
			'supports' 				=> [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions', 'page-attributes', 'post-formats' ],
		);

		register_post_type( 'wbl_author', $args );
	}
}

new WBL_Author_Post_Type();
