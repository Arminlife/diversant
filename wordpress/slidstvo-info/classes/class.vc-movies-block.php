<?php
/**
 * VC Movies
 *
 * @file
 * @package		Slidstvo info
 * @author		Andrew Skochelias
 */

defined( 'ABSPATH' ) || die();

/**
 * Init Slidstvo_Info_Movies_Block
 * */
class Slidstvo_Info_Movies_Block extends WPBakeryShortCode {

    /**
     * Constructor
     */
    function __construct() {

        add_action( 'init', [ &$this, 'showMoviesBlock'] );
        add_shortcode( 'show_movies_block', [ &$this, 'shortcode'] );
    }

    /**
     * Init block.
     *
     * @return void.
     */
    public function showMoviesBlock() {

        vc_map(
            [
                'name' 			=> esc_html__( 'Movies Block', 'slidstvo-info' ),
                'base' 			=> 'show_movies_block',
                'description' 	=> esc_html__( 'Show movies block', 'slidstvo-info' ),
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
                    'video',
                ],
            ],
            $atts
        );

        // Get posts
        $all_posts = get_posts( $atts );
        $posts = array_slice($all_posts, 0, 20);


        ob_start();

        ?>
        <div class="movies-block">
	        <div class="container">
		        <h2 class="block-title"><?php esc_html_e( 'Фільми', 'slidstvo-info' ); ?></h2>
	        </div>
	        <div class="container">
		        <div id="owl-video-carousel" class="owl-carousel owl-theme">
                    <?php foreach( $posts as $post ) : ?>
				        <div class="movie-item">
					        <a href="<?php the_permalink( $post->ID ); ?>" class="movie-link"><?php echo get_the_post_thumbnail( $post->ID, 'film-poster' ); ?></a>
				        </div>
                    <?php endforeach; ?>
		        </div>
	        </div>
        </div>
        <?php

        $html = ob_get_contents();

        ob_end_clean();

        return $html;
    }
}

new Slidstvo_Info_Movies_Block();
