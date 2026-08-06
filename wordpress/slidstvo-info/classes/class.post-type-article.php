<?php
/**
 * Article Post type
 *
 * @file
 * @package		Slidstvo info
 * @author		Andrew Skochelias
 */

defined( 'ABSPATH' ) || die();

/**
 * Class WBL_Article_Post_Type.
 */
class WBL_Article_Post_Type {

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
            'name'               	=> __( 'Articles', 'post type general name', 	'slidstvo-info' ),
            'singular_name'      	=> __( 'Article', 'post type singular name', 	'slidstvo-info' ),
            'menu_name'          	=> __( 'Articles', 'admin menu', 				'slidstvo-info' ),
            'name_admin_bar'     	=> __( 'Article', 'add new on admin bar',		'slidstvo-info' ),
            'add_new'            	=> __( 'Add New', 'Article', 					'slidstvo-info' ),
            'add_new_item'       	=> __( 'Add New Article',						'slidstvo-info' ),
            'new_item'           	=> __( 'New Article', 						'slidstvo-info' ),
            'edit_item'          	=> __( 'Edit Article', 						'slidstvo-info' ),
            'view_item'          	=> __( 'View Article', 						'slidstvo-info' ),
            'all_items'          	=> __( 'All Articles', 						'slidstvo-info' ),
            'search_items'       	=> __( 'Search Article', 						'slidstvo-info' ),
            'parent_item_colon'  	=> __( 'Parent Article', 						'slidstvo-info' ),
            'not_found'          	=> __( 'No Articles found.',					'slidstvo-info' ),
            'not_found_in_trash'	=> __( 'No Articles found in Trash.',			'slidstvo-info' ),
        );

        $args = array(
            'labels'				=> $labels,
            'public'				=> true,
            'show_ui' 				=> true,
            'menu_icon'    			=> 'dashicons-text',
            'publicly_queryable'	=> true,
            'menu_position'			=> 30,
            'show_in_menu'			=> true,
            'query_var' 			=> true,
            'rewrite'            	=> [ 'slug' => 'articles' ],
            'capability_type' 		=> 'post',
            'has_archive' 			=> true,
            'hierarchical' 			=> false,
            'supports' 				=> [ 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions', 'page-attributes', 'post-formats' ],
        );

        register_post_type( 'wbl_article', $args );
    }
}

new WBL_Article_Post_Type();
