<?php
/*
Plugin Name: Slidstvo info
Plugin URI: http://webolatory.com/
Update URI: false
Description: Slidstvo info plugin
Author: Andrew Skochelias
Author URI: http://skoch.com.ua/
Text Domain: slidstvo-info
Version: 1.1.0
*/

defined( 'ABSPATH' ) || die;

/**
 * Init Slidstvo_Info
 * */
class Slidstvo_Info {

	/**
	 * Constructor
	*/
	function __construct() {

		// Load textdomain
		add_action( 'plugins_loaded', [ &$this, 'loadTextdomain' ] );

		// Register post types
		/*
		require_once( 'classes/class.p2p-connections.php' );
		require_once( 'classes/class.post-type-movie.php' );
		require_once( 'classes/class.post-type-author.php' );
		require_once( 'classes/class.post-type-article.php' );
		require_once( 'classes/class.post-type-investigation.php' );		*/
        

		require_once( 'classes/class.investigations-post-redirect.php' );
		require_once( 'classes/class.dashboard-customization.php' );

		// Load VC elements
		if ( defined( 'WPB_VC_VERSION' ) ) {

			require_once( 'classes/class.vc-news-block.php' );
            require_once( 'classes/class.vc-banner-main-page.php' );
			require_once ( 'classes/class.vc-movies-block.php');
			require_once ( 'classes/class.vc-worth-knowing-block.php');
			require_once( 'classes/class.vc-authors-list.php' );
			require_once( 'classes/class.vc-special-projects.php' );
			require_once( 'classes/class.vc-additional-materials.php' );
		}
	}

	/**
	 * Load textdomain.
	 *
	 * @return void.
	 */
	public function loadTextdomain() {

		// Load translate
		load_plugin_textdomain( 'slidstvo-info', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
}

new Slidstvo_Info();
