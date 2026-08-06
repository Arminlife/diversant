<?php
/**
 * VC Authors List
 *
 * @file
 * @package		Slidstvo info
 * @author		Andrew Skochelias
 */

defined( 'ABSPATH' ) || die();

/**
 * Init Slidstvo_Info_Authors_List
 * */
class Slidstvo_Info_Authors_List extends WPBakeryShortCode {

	/**
	 * Constructor
	*/
    function __construct() {

        add_action( 'init', [ &$this, 'showAuthorsList'] );
        add_shortcode( 'show_authors_list', [ &$this, 'shortcode'] );
    }

	/**
	 * Init block.
	 *
	 * @return void.
	 */
    public function showAuthorsList() {

		vc_map(
			[
				'name' 			=> esc_html__( 'Authors List', 'slidstvo-info' ),
				'base' 			=> 'show_authors_list',
				'description' 	=> esc_html__( 'Show authors List', 'slidstvo-info' ),
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
				'hide_empty'  	=> false,
//				'orderby'		=> 'name',
                'meta_key'      => 'position',
                'orderby'		=> 'meta_value_num',
				'order'		   	=> 'ASC',
				'taxonomy'   	=> 'journalists',
				'pad_counts' 	=> true,
				'number'		=> 999999,
			],
			$atts
		);

		// Get authors
		$authors = get_terms( $atts );

		ob_start();

		if ( is_array( $authors ) && ! empty( $authors ) ) :

			?>
				<div class="authors-list">

					<div class="row">

						<?php foreach ( $authors as $author ) : ?>

							<?php $term = get_term_by( 'slug', $author->slug, $author->taxonomy ); ?>

                            <?php $show_in_list = get_field( 'wpcf-show-in-list', $term ); ?>

                            <?php if ( ( ! empty( $show_in_list ) ) && ( $show_in_list == true ) ) : ?>

                                <div class="col">

    								<a href="<?php echo esc_url( get_term_link( $author, 'journalists' ) ); ?>" alt="<?php echo esc_html( $author->name ); ?>" title="<?php echo esc_html( $author->name ); ?>">

                                        <?php
										$photo = get_field( 'wpcf-photo', $term );

                                        if( ! empty( $photo ) ): ?>
                                            <?php if(is_array($photo)): ?>
                                                <div class="journalist-photo">
                                                    <img src="<?php echo $photo['url']; ?>" alt="<?php echo $author->name; ?>" />
                                                </div>
                                            <?php else: ?>
                                                <div class="journalist-photo">
                                                    <img src="<?php echo $photo; ?>" alt="<?php echo $author->name; ?>" />
                                                </div>
                                            <?php endif; ?>


                                        <?php endif; ?>

    									<h2 class="journalist-name"><?php echo esc_html( $author->name ); ?></h2>

    									<?php
                                        $post = get_field( 'wpcf-post', $author );

                                        if ( ! empty( $post ) ) : ?>

    										<h3 class="journalist-post"><?php echo $post; ?></h3>

    									<?php endif; ?>

    								</a>

    							</div>
                            <?php endif; ?>
						<?php endforeach; ?>

					</div>

				</div>

			<?php

		endif;

		$html = ob_get_contents();

		ob_end_clean();

		return $html;
	}
}

new Slidstvo_Info_Authors_List();