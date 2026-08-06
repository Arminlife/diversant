<?php
/**
 * Functions
 *
 * @file
 * @package		slidstvo.info
 * @author		Andrew Skochelias
 */
defined( 'ABSPATH' ) || die();

/**
 * Class Functions.
 */
class CC_Functions {

	public static function showParentPages( $post, $delimiter, $parents = [] ) {

		if ( 0 === $post->post_parent ) {

			// Show parent pages
			if ( ! empty( $parents ) ) {

				foreach ( $parents as $parent ) {

					echo '<a href="' . $parent['url'] . '">' . $parent['title'] . '</a>' . $delimiter;
				}
			}

			return;
		}

		// Get parent post
		$parent = get_post( $post->post_parent );

		array_unshift(
			$parents,
			[
				'url' 	=> esc_url( get_permalink( $parent->ID ) ),
				'title' => esc_html( $parent->post_title ),
			]
		);

		self::showParentPages( $parent, $delimiter, $parents );
	}

	public static function getPageTitle( $post ) {

		$queried_object = get_queried_object();

		if ( isset( $queried_object->label ) ) {

			return $queried_object->label;
		} elseif ( isset( $queried_object->post_title ) ) {

			return $queried_object->post_title;
		}
	}

	public static function showPageTitle( $post ) {

		echo esc_html( self::getPageTitle( $post ) );
	}

    public static function getAdditionalMaterialsPravosyllya( $post_id ) {

        // Get post additional materials ID`s
        $additional_materials = get_post_meta( $post_id);

        if ( is_array( $additional_materials ) && ! empty( $additional_materials ) ) {

            // Return additional materials
            return self::getPosts(
                [
                    'numberposts'	=> 150,
                    'post_type'		=> [
                        'articles', 'news'
                    ],
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'investigation_type',
                            'field'    => 'id',
                            'terms'    => 1375
                        )
                    )
//					'include'		=> $additional_materials,
                ]
            );
        }
    }

	public static function getAdditionalMaterials( $post_id ) {

		// Get post additional materials ID`s
		$additional_materials = get_post_meta( $post_id);

		if ( is_array( $additional_materials ) && ! empty( $additional_materials ) ) {

			// Return additional materials
			return self::getPosts(
				[
					'numberposts'	=> 3,
					'post_type'		=> [
						'post',
						'news',
						'articles',
						'video',
					],
//					'include'		=> $additional_materials,
				]
			);
		}
	}

	public static function getAdditionalMaterialsSpecialProjects( $post_id ) {

		// Get post additional materials ID`s
		$additional_materials = get_post_meta( $post_id);

		if ( is_array( $additional_materials ) && ! empty( $additional_materials ) ) {

			// Return additional materials
			return self::getPosts(
				[
					'numberposts'	=> 3,
					'post_type'		=> [
						'special-projects'
					],
//					'include'		=> $additional_materials,
				]
			);
		}
	}

	public static function getMainAdditionalMaterial( $post_id ) {

		// Get post additional materials ID`s
		$main_additional_material = get_post_meta( $post_id, 'main_additional_material', true );

		if ( is_array( $main_additional_material ) && ! empty( $main_additional_material ) ) {

			// Return additional materials
			return self::getPosts(
				[
					'numberposts'	=> 1,
					'post_type'		=> [
						'texts',
					],
					'include'		=> $main_additional_material,
				]
			);
		}
	}

	public static function getPosts( $args = [] ) {

		// Merge atts
		$atts = shortcode_atts(
			[
				'post_status'	=> 'publish',
				'post_type'		=> 'post',
				'orderby'		=> 'date',
				'order'			=> 'DESC',
				'include'		=> [],
				'exclude'		=> [],
			],
			$atts
		);

		return get_posts( $args );
	}
	public static function showPagination() {

		the_posts_pagination([
			'show_all'     => false,
			'end_size'     => 1,
			'mid_size'     => 1,
			'prev_next'    => true,
			'prev_text'    => esc_html__( 'Previous', 'slidstvo-info-theme' ),
			'next_text'    => esc_html__( 'Next', 'slidstvo-info-theme' ),
			'add_args'     => false,
			'add_fragment' => '',
		//	'screen_reader_text' => __( 'Posts navigation' ),
			'screen_reader_text' => __( ' ' ),
		]);
	}

	/**
	 * Show Social Profiles
	 *
	 * @return void.
	 */
	public static function showSocialProfiles( $mode = '' ) {

		global $slidstvo_info;

		$networks = [
			'default'		=> 'fa-globe',
			'Twitter'		=> 'fa-twitter fa-fw',
			'Facebook'		=> 'fa-facebook-f fa-fw',
			'Google+'		=> 'fa-google-plus-square',
			'Skype'			=> 'fa-skype',
			'LinkedIn'		=> 'fa-linkedin-square',
			'Youtube'		=> 'fa-youtube-square',
			'Vimeo'			=> 'fa-vimeo-square',
			'Instagram'		=> 'fa-instagram fa-fw',
			'Flickr'		=> 'fa-flickr',
			'Pinterest'		=> 'fa-pinterest-square',
			'Tumblr'		=> 'fa-tumblr-square',
			'Telegram'		=> 'fa-telegram-plane fa-fw',
			'Viber'		    => 'fa-viber',
			'TikTok'		=> 'fa-tiktok',
		];

		if ( isset( $slidstvo_info['socials-contacts'] ) && is_array( $slidstvo_info['socials-contacts'] ) && ! empty( $slidstvo_info['socials-contacts'] ) ) {

			foreach ( $slidstvo_info['socials-contacts'] as $name => $url ) {

				if ( ! empty( $url ) ) {

					$icon = isset( $networks[ $name ] ) ? $networks[ $name ] : $networks['default'];
					if ( 'footer' == $mode ){
						if($icon == 'fa-tiktok') {
							echo '<a href="'.$url.'" class="tiktok-link"><svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 30 30" width="30px" height="30px">    <path d="M24,4H6C4.895,4,4,4.895,4,6v18c0,1.105,0.895,2,2,2h18c1.105,0,2-0.895,2-2V6C26,4.895,25.104,4,24,4z M22.689,13.474 c-0.13,0.012-0.261,0.02-0.393,0.02c-1.495,0-2.809-0.768-3.574-1.931c0,3.049,0,6.519,0,6.577c0,2.685-2.177,4.861-4.861,4.861 C11.177,23,9,20.823,9,18.139c0-2.685,2.177-4.861,4.861-4.861c0.102,0,0.201,0.009,0.3,0.015v2.396c-0.1-0.012-0.197-0.03-0.3-0.03 c-1.37,0-2.481,1.111-2.481,2.481s1.11,2.481,2.481,2.481c1.371,0,2.581-1.08,2.581-2.45c0-0.055,0.024-11.17,0.024-11.17h2.289 c0.215,2.047,1.868,3.663,3.934,3.811V13.474z"/></svg></a>';
						} else {
							printf( '
							<a href="%s"><i class="fab %s fa-lg" aria-hidden="true"></i>%s</a>',
							esc_url( $url ),
							esc_html( $icon ),
							esc_html( $name )
						);
						}
					} else {
						if($icon == 'fa-tiktok') {
							echo '<a href="'.$url.'" class="tiktok-link"><svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 30 30" width="30px" height="30px">    <path d="M24,4H6C4.895,4,4,4.895,4,6v18c0,1.105,0.895,2,2,2h18c1.105,0,2-0.895,2-2V6C26,4.895,25.104,4,24,4z M22.689,13.474 c-0.13,0.012-0.261,0.02-0.393,0.02c-1.495,0-2.809-0.768-3.574-1.931c0,3.049,0,6.519,0,6.577c0,2.685-2.177,4.861-4.861,4.861 C11.177,23,9,20.823,9,18.139c0-2.685,2.177-4.861,4.861-4.861c0.102,0,0.201,0.009,0.3,0.015v2.396c-0.1-0.012-0.197-0.03-0.3-0.03 c-1.37,0-2.481,1.111-2.481,2.481s1.11,2.481,2.481,2.481c1.371,0,2.581-1.08,2.581-2.45c0-0.055,0.024-11.17,0.024-11.17h2.289 c0.215,2.047,1.868,3.663,3.934,3.811V13.474z"/></svg></a>';
						} else {
							printf( '
							<a href="%s"><i class="fab %s fa-lg" aria-hidden="true"></i></a>',
							esc_url( $url ),
							esc_html( $icon )
						);
						}
					}
				}
			}
		}

	}

	/**
	 * Show Contacts
	 *
	 * @return void.
	 */
	public static function showContacts( $types = [ 'phones', 'email' ] ) {

		global $slidstvo_info;

		if ( ! empty( $types ) && is_array( $types ) ) {

			foreach( $types as $type ) {

				if ( isset( $slidstvo_info[ $type ] ) ) {

					if ( is_array( $slidstvo_info[ $type ] ) ) {

						foreach ( $slidstvo_info[ $type ] as $item ) {
							if ( 'phones' == $type ){
								printf( '
									<a class="contacts-%s" href="tel:%s">%s</a>',
									$type,
									$item,
									$item
								);
							} else {
								printf( '
									<a class="contacts-%s" href="mailto:%s">%s</a>',
									$type,
									$item,
									$item
								);
							}
						}
					} else {

						printf( '
							<span class="contacts-%s">%s</span>',
							$type,
							$slidstvo_info[ $type ]
						);
					}
				}
			}
		}
	}

    public static function getVideoRelatedPosts($term_id)
    {
        return (new WP_Query(
            [
                'posts_per_page'	=> 3,
                'post_type'		=> [
                    'post',
                    'news',
                    'articles',
                    'video',
                    'blogs'
                ],
                'tax_query' => [
                    [
                        'taxonomy' => 'tags',
                        'field'    => 'term_id',
                        'terms'    => $term_id
                    ]
                ]
//					'include'		=> $additional_materials,
            ]));
    }

    public static function processPartnerForm()
    {
        $success = false;

        $captcha_error = false;
        $captcha_instance = new ReallySimpleCaptcha();
        $captcha_word = $captcha_instance->generate_random_word();
        $captcha_prefix = mt_rand();
        $image_url =
            plugins_url('really-simple-captcha/tmp/') .
            $captcha_instance->generate_image( $captcha_prefix, $captcha_word );

        if (!empty($_POST) ) {
            $prefix = sanitize_text_field($_POST['prefix']);
            $code = sanitize_text_field($_POST['code']);
            $captcha_error = !$captcha_instance->check($prefix, $code);
            if (!$captcha_error) {
                $captcha_instance->remove($prefix);

                $user_name = sanitize_text_field($_POST['user_name']);
                $user_surname = sanitize_text_field($_POST['user_surname']);
                $email = sanitize_text_field($_POST['email']);
                $number = sanitize_text_field($_POST['number']);
                $offer = sanitize_text_field($_POST['offer']);
                mail(
                    'v.kryzhnii@protonmail.com',//get_bloginfo('admin_email'),
                    'Партнерська пропозиція',
                    "Ім'я: {$user_name} <br>Прізвище: {$user_surname} <br>Пошта: {$email} <br>Телефон: {$number} <br>Пропозиція: {$offer}",
                    "Content-type: text/html; charset=UTF-8\r\n"
                );

                $success = true;
            }
        }

        return [
            'image_url' => $image_url,
            'captcha_error' => $captcha_error,
            'captcha_prefix' => $captcha_prefix,
            'success' => $success,
        ];
    }

}

new CC_Functions();
