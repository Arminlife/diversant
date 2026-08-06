<?php
/**
 * VC Additional materials
 *
 * @file
 * @package		Slidstvo info
 * @author		Andrew Skochelias
 */

defined( 'ABSPATH' ) || die();

/**
 * Init Slidstvo_Info_Additional_Materials
 * */
class Slidstvo_Info_Additional_Materials extends WPBakeryShortCode {

	/**
	 * Constructor
	*/
    function __construct() {

        add_action( 'init', [ &$this, 'selectAdditionalMaterialsBlock'] );
        add_shortcode( 'show_additional_materials', [ &$this, 'shortcode'] );
    }

	/**
	 * Init block.
	 *
	 * @return void.
	 */
    public function selectAdditionalMaterialsBlock() {

		$values = [];
		$post_types = [];

		$posts = get_posts(
			[
				'numberposts'	=> -1,
				'post_type' 	=> [
					'post',
					'news',
					'texts',
					'video',
                    'investigations',
				],
			]
		);

		if ( is_array( $posts ) && ! empty( $posts ) ) {

			foreach( $posts as $post ) {

				$values[] = [
					'label'	=> $post->post_title . ' (' . $post->post_type . ')',
					'value'	=> $post->ID,
					'group'	=> 'posts',
				];
			}
		}

		vc_map(
			[
				'name' 			=> esc_html__( 'Additional materials', 'slidstvo-info' ),
				'base' 			=> 'show_additional_materials',
				'description' 	=> esc_html__( 'News, Articles, Movies', 'slidstvo-info' ),
				'category' 		=> 'Slidstvo',
				'params' 		=> [

					[
						'type'        => 'autocomplete',
						'heading'     => __( 'Select content', 'slidstvo-info' ),
						'param_name'  => 'include',
						'settings'    => [
							'multiple' 			=> true,
							'sortable' 			=> true,
							'min_length' 		=> 1,
							'unique_values' 	=> true,
							'display_inline' 	=> false,
							'values'   			=> $values,
						],
					],
					[
						'type'        	=> 'dropdown',
						'heading'     	=> __( 'Columns', 'slidstvo-info' ),
						'param_name' 	=> 'columns',
						'admin_label' 	=> true,
						'value'   			=> [
							1	=> 1,
							2	=> 2,
							3	=> 3,
							4	=> 4,
							6	=> 6,
							8	=> 8,
						],
					],
				]
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
				'include'   	=> [],
				'columns'   	=> 4,
			],
			$atts
		);

		// Get posts
		$posts = get_posts( [
			'include'   	=> $atts['include'],
			'numberposts'	=> -1,
			'post_type' 	=> [
				'post',
				'news',
				'texts',
				'video',
                'investigations',
			],
		] );

		// Set width
		$width = 12 / $atts['columns'];

		ob_start();
		?>
            <script>
                jQuery(document).ready(function($){
                    if ( isMobile("xs") ){
                        let articles = $('.additional-materials article');
                        for (let i = 0; i < articles.length; i += 2) {
                            articles.slice(i, i + 2).wrapAll("<div class='owl-wrapper'></div>");
                        }

                        let owlSlider = $('.additional-materials');
                        owlSlider.owlCarousel({
                            items : 1,
                            dots : true,
                            loop : true,
                            autoHeight : false,
                            margin : 20
                        });

                        owlSlider.on('drag.owl.carousel', function(event) {
                            $('body').css('overflow', 'hidden');
                            console.log("Drag");
                        });

                        owlSlider.on('dragged.owl.carousel', function(event) {
                            $('body').css('overflow', 'auto');
                            console.log("Dragged");
                        });
                    }
                    if (isMobile("xs")){
                        // setTimeout(function () {
                        //     $(".additional-materials .background").each(function(){
                        //         let width = $(this).outerWidth(true);
                        //         let ratioHeight = (width / 4) * 3;
                        //         $(this).css("min-height" , ratioHeight);
                        //     })
                        // }, 0);
                    }

                });
            </script>
			<div class="container additional-materials grid-<?php echo $atts['columns']; ?> ">
				<?php foreach( $posts as $post ) : ?>
					<article class="<?php echo $post->post_type; ?>-<?php echo $post->ID; ?>" id="additional-material-<?php echo $post->ID; ?>" >
                        <div class="background">
                            <?php echo get_the_post_thumbnail( $post->ID , 'thumbnails-homepage' ); ?>
                            <a href="<?php the_permalink( $post->ID ); ?>" title="<?php echo $post->post_title; ?>"><h2><?php echo $post->post_title; ?></h2></a>
                        </div>
                        <p class="post_excerpt"><?php echo get_the_excerpt( $post ); ?></p>
					</article>

				<?php endforeach; ?>
			</div>
		<?php

		$html = ob_get_contents();

		ob_end_clean();

		return $html;
	}
}

new Slidstvo_Info_Additional_Materials();
