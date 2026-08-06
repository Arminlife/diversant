<?php
/**
 * VC News Block
 *
 * @file
 * @package		Slidstvo info
 * @author		Andrew Skochelias
 */

defined( 'ABSPATH' ) || die();

/**
 * Init Slidstvo_News_Block
 * */
class Slidstvo_Banner_Main_Page_Block extends WPBakeryShortCode {
	/**
	 * Constructor
	*/
    function __construct() {
        add_action( 'init', [ &$this, 'selectBanner3Block'] );
        add_shortcode( 'show_banner3_block', [ &$this, 'shortcode'] );
    }

	/**
	 * Init block.
	 *
	 * @return void.
	 */
    public function selectBanner3Block() {

		vc_map(
			[
				'name' 			=> esc_html__( 'Show banner main page block', 'slidstvo-info' ),
				'base' 			=> 'show_banner3_block',
				'description' 	=> esc_html__( 'Show banner main page block', 'slidstvo-info' ),
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
        $banner  = (new WP_Query([
            'name' => 'banner3',
            'post_type' => 'banners',
            'posts_per_page' => '1',
        ]))->get_posts();

        ob_start();
		?>

<div id="banner" data-vc-full-width="true" data-vc-full-width-init="true" data-vc-stretch-content="true" style="position: relative;  box-sizing: border-box; width: 100%;">
    <div class="wpb_column vc_column_container vc_col-sm-12">
        <div class="wpb_wrapper">
            <div class="wpb_single_image wpb_content_element vc_align_left">
                <figure class="wpb_wrapper vc_figure">
                    <a href="<?= get_field("banner_url", $banner[0]->ID)  ?>" target="_blank" class="vc_single_image-wrapper   vc_box_border_grey">
                        <noscript>
                        <img width="2048" height="640" src="<?= get_the_post_thumbnail_url($banner[0]->ID) ?>" class="vc_single_image-img attachment-full" alt="" srcset="<?= get_the_post_thumbnail_url($banner[0]->ID) ?> 2048w, <?= get_the_post_thumbnail_url($banner[0]->ID) ?> 300w, <?= get_the_post_thumbnail_url($banner[0]->ID) ?> 768w, <?= get_the_post_thumbnail_url($banner[0]->ID) ?> 1024w" sizes="(max-width: 2048px) 100vw, 2048px" /></noscript><img src="<?= get_the_post_thumbnail_url($banner[0]->ID) ?>"  width="2048" height="640">
                    </a>
                </figure>
            </div>
        </div>
    </div>
</div>






        <?php

		$html = ob_get_contents();

		ob_end_clean();

		return $html;
	}
}

new Slidstvo_Banner_Main_Page_Block();
