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
 * Init Slidstvo_Info_Worth_Knowing_Block
 * */
class Slidstvo_Info_Worth_Knowing_Block extends WPBakeryShortCode {

    /**
     * Constructor
     */
    function __construct() {

        add_action( 'init', [ &$this, 'showWorthKnowingBlock'] );
        add_shortcode( 'show_worth_knowing_block', [ &$this, 'shortcode'] );
    }

    /**
     * Init block.
     *
     * @return void.
     */
    public function showWorthKnowingBlock() {

        vc_map(
            [
                'name' 			=> esc_html__( 'Варто знати', 'slidstvo-info' ),
                'base' 			=> 'show_worth_knowing_block',
                'description' 	=> esc_html__( 'Show worth knowing block', 'slidstvo-info' ),
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
        // banner
        $our_successes_post  = (new WP_Query([
            'post_type' => 'news',
            'posts_per_page' => '1',
            'tax_query' => [
                [
                    'taxonomy' =>  'investigation_type',
                    'field' => 'slug',
                    'terms' => 'nashi-uspihi',
                ]
            ]
        ]))->get_posts()[0];

        $events_post  = (new WP_Query([
            'post_type' => 'news',
            'posts_per_page' => '1',
            'tax_query' => [
                [
                    'taxonomy' =>  'investigation_type',
                    'field' => 'slug',
                    'terms' => 'zahodi',
                ]
            ]
        ]))->get_posts()[0];

        $slidstvo_club_post  = (new WP_Query([
            'post_type' => 'news',
            'posts_per_page' => '1',
            'tax_query' => [
                [
                    'taxonomy' =>  'investigation_type',
                    'field' => 'slug',
                    'terms' => 'slidstvo-club',
                ]
            ]
        ]))->get_posts()[0];

        ob_start();

        ?>
	    <div class="container">
		    <div class="worth-knowing-block">
			    <div class="worth-knowing-item about-awards">
				    <a href="#">
					    <h2 class="block-title">Наші успіхи</h2>
				    </a>
				    <article class="worth-knowing-article">
					    <div class="image">
						    <a  href="<?= get_post_permalink($our_successes_post->ID) ?>">
							    <img src="<?= get_the_post_thumbnail_url($our_successes_post->ID) ?>" alt="Image-1">
						    </a>
					    </div>
					    <a href="<?= get_post_permalink($our_successes_post->ID) ?>">
					        <h3><?= get_the_title($our_successes_post->ID) ?></h3>
					    </a>
				    </article>
			    </div>
                <?php /*
			    <div class="worth-knowing-item about-events">
				    <a href="#">
					    <h2 class="block-title">Заходи</h2>
				    </a>
				    <article class="worth-knowing-article">
					    <div class="image">
						    <a  href="<?= get_post_permalink($events_post->ID) ?>">
							    <img src="<?= get_the_post_thumbnail_url($events_post->ID) ?>" alt="Image-1">
						    </a>
					    </div>
					    <a href="<?= get_post_permalink($events_post->ID) ?>">
					        <h3><?= get_the_title($events_post->ID) ?></h3>
					    </a>
				    </article>
			    </div>
                */ ?>
			    <div class="worth-knowing-item about-members">
				    <a href="#">
				        <h2 class="block-title">Слідство-Клуб</h2>
				    </a>
				    <article class="worth-knowing-article">
					    <div class="image">
						    <a  href="<?= get_post_permalink($slidstvo_club_post->ID) ?>">
							    <img src="<?= get_the_post_thumbnail_url($slidstvo_club_post->ID) ?>" alt="Image-1">
						    </a>
					    </div>
					    <a href="<?= get_post_permalink($slidstvo_club_post->ID) ?>">
					        <h3 class="worth-knowing-block-title"><?= get_the_title($slidstvo_club_post->ID) ?></h3>
					    </a>
				    </article>
			    </div>
		    </div>
	    </div>

        <?php

        $html = ob_get_contents();

        ob_end_clean();

        return $html;
    }
}

new Slidstvo_Info_Worth_Knowing_Block();

