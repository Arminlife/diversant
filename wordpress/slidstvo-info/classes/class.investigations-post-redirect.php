<?php
/**
 * Investigations Post redirect
 *
 * @file
 * @package		Slidstvo info
 * @author		Andrew Skochelias
 */

defined( 'ABSPATH' ) || die();

/**
 * Class Investigations_Post_Redirect.
 */
class Investigations_Post_Redirect {

	/**
	 * Constructor
	 */
	function __construct() {

		add_action( 'template_redirect', [ &$this, 'postRedirect' ] );
	}

	/**
	 * Post redirect
	 *
	 * @return void.
	 */
	public function postRedirect() {

		global $wp_query;

		if( is_404() && ! is_admin() && isset( $wp_query->query['name'] ) ) {

			$args = [
				'name'        => $wp_query->query['name'],
				'post_type'   => [ 'video', 'texts', 'news' ],
				'post_status' => 'publish',
				'numberposts' => 1
			];

			$posts = get_posts( $args );

			if ( isset( $posts[0]->ID ) ) {

				wp_redirect( get_permalink( $posts[0]->ID ), 301 );
				exit();
			}
		}
	}
}

new Investigations_Post_Redirect();
