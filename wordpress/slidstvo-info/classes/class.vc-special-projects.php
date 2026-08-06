<?php
/**
 * VC Special Projects
 *
 * @file
 * @package		Slidstvo info
 * @author		Andrew Skochelias
 */

defined( 'ABSPATH' ) || die();

/**
 * Init Slidstvo_Info_Special_Projects
 * */
class Slidstvo_Info_Special_Projects extends WPBakeryShortCode {

	/**
	 * Constructor
	*/
	function __construct() {

		add_action( 'init', [ &$this, 'showSpecialProjects'] );
		add_shortcode( 'show_special_projects', [ &$this, 'shortcode'] );
	}

	/**
	 * Init block.
	 *
	 * @return void.
	 */
	public function showSpecialProjects() {

		vc_map(
			[
				'name' 			=> esc_html__( 'Special projects', 'slidstvo-info' ),
				'base' 			=> 'show_special_projects',
				'description' 	=> esc_html__( 'Show special projects', 'slidstvo-info' ),
				'category' 		=> 'Slidstvo',
				'params' 		=> []
			]
		);
	}

	/**
	 * Shortcode.
	 *
	 * @return void.
	 */
	public function shortcode( $atts ) {

		// Merge atts
		$atts = shortcode_atts(
			[
				'numberposts'	=> -1,
				'post_type' 	=> [
					'special-projects',
				],
			],
			$atts
		);

		// Get posts
		$all_posts = get_posts( $atts );
		$posts = array_slice($all_posts, 0, 3);

		ob_start();
		?>
			<script>
				jQuery(document).ready(function($){
					if (isMobile("xs")){
						setTimeout(function () {
							$(".special-projects article").each(function(){
								let width = $(this).outerWidth(true);
								let ratioHeight = (width / 4) * 3;
								$(this).css("min-height" , ratioHeight);
							})
						}, 0);
					}
				});
			</script>
		<div class="container">
			<div class="special-projects">
				<div class="container">
					<h2 class="block-title"><?php esc_html_e( 'Special Projects', 'slidstvo-info' ); ?></h2>
				</div>
                <?php foreach( $posts as $post ) : ?>
					<article class="special-project-<?php echo $post->ID; ?>" id="special-project-<?php echo $post->ID; ?>">
						<div class="background image">
                            <?php echo get_the_post_thumbnail( $post->ID , 'thumbnails-homepage' ); ?>
						</div>

						<a href="<?php the_permalink( $post->ID ); ?>" title="<?php echo $post->post_title; ?>"><h2><?php echo $post->post_title; ?></h2></a>
					</article>
                <?php endforeach; ?>
                <?php if ( sizeof($posts) < sizeof($all_posts) ): ?>
					<div class="container all-projects">
						<a href="/special-projects/" class="btn btn-primary"><?php esc_html_e( 'More special projects', 'slidstvo-info' ); ?></a>
					</div>
                <?php endif; ?>
			</div>
		</div>

		<?php

		$html = ob_get_contents();

		ob_end_clean();

		return $html;
	}
}

new Slidstvo_Info_Special_Projects();
