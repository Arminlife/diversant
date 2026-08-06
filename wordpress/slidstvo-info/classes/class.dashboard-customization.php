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
 * Class Slidstvo_Dashboard_Customization.
 */
class Slidstvo_Dashboard_Customization {

	/**
	 * Constructor
	 */
	function __construct() {

		// Register post type
		add_action( 'admin_footer', [ &$this, 'hideCustomFields' ] );
	}

	/**
	 * Hide Custom Fields
	 *
	 * @return void
	 */
	public function hideCustomFields() {

		if ( 'video' !== $this->getPostType() ) {
			?>
				<script>
					jQuery( document ).ready(function($){
						$('div[data-wpt-id="wpcf-video-year"]').remove();
						$('div[data-wpt-id="wpcf-video-long"]').remove();
					});
				</script>
			<?php
		}
	}

	/**
	 * Get post type
	 *
	 * @return string
	 */
	public function getPostType() {

		global $post;
		global $pagenow;

		// Check page.
		if ( 'post.php' !== $pagenow && 'post-new.php' !== $pagenow && 'edit.php' === $pagenow ) {

			return false;
		}

		// Check post type.
		if ( isset( $post->post_type ) ) {

			return $post->post_type;
		}

		return false;
	}
}

new Slidstvo_Dashboard_Customization();
