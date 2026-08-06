<?php

// load classes
require_once( 'classes/class.functions.php' );
require_once( 'classes/class.event-functions.php' );
require_once( 'classes/class.shortcodes.php' );
require_once( 'classes/class.redux-framework.php' );
require_once( 'classes/class.wp-bootstrap-navwalker.php' );
require_once( 'classes/class.bootstrap_4_walker_nav_menu.php' );
require_once( 'classes/Header_Menu_Walker.php' );
require_once( 'inc/utils.php' );
require_once( 'inc/wpbakery-elements.php' );

Utils::init();

if( ! current_user_can('editor') && ! current_user_can('administrator') ) {

	//add_action( 'wp_print_styles', 'my_deregister_styles', 100 );

	function my_deregister_styles() {
		wp_deregister_style( 'dashicons' );
	}
}
//	Add theme support post formats
//    if( get_post_type() == 'success-histories' ) {

//    }

/**
 * Setup theme
 */
function cc_theme_setup() {
	//link dashicons
    function my_dashicons() {
        wp_enqueue_style( 'dashicons' );
    }
    add_action( 'wp_enqueue_scripts', 'my_dashicons' );



	// Add image sizes
	add_image_size( 'thumbnails-vertical', 600, 400, true );
	add_image_size( 'thumbnails-homepage', 454, 285, true );
	add_image_size( 'main-material-homepage', 730, 525, true );
	add_image_size( 'journalist-400', 400, 400, true, array( 'center', 'top' )  );
	add_image_size( 'film-poster', 300, 400, true, array( 'center', 'center' )  );
	add_image_size( 'movie-poster', 200, 300, true, array( 'center', 'center' )  );
	add_image_size( 'single-ss-post', 1728, 624, true, array( 'center', 'center' )  );
    add_image_size( 'medium_large', 768, 0 );
    add_image_size( '1536x1536', 1536, 1536 );
    add_image_size( '2048x2048', 2054, 2048 );
    add_image_size( 'big-size', 6000, 6000, true );

	// Add theme support for post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Post formats
	add_theme_support( 'post-formats', array( 'video' ) );

	load_theme_textdomain( 'slidstvo-info-theme', get_template_directory() . '/languages' );

	//  Registers menu positions
	register_nav_menus( [ 'top-navigation' 			=> __( 'Main Navigation', 'slidstvo-info-theme' ) ] );
	register_nav_menus( [ 'sub-header-navigation' 	=> __( 'Sub Menu', 'slidstvo-info-theme' ) ] );



	// Gutenberg
	add_theme_support( 'align-wide' );

	register_sidebar( [
		'name'          => __('Main sidebar'),
		'id'            => 'main-sidebar',
		'description'   => '',
		'class'         => 'main-sidebar',
		'before_widget' => '<div class="widget main-sidebar">',
		'after_widget'  => "</div>\n",
		'before_title'  => '<h4 class="widgettitle">',
		'after_title'   => "</h4>\n",
	]);

	register_sidebar( [
		'name'          => __('Footer-one'),
		'id'            => 'footer-one',
		'description'   => '',
		'class'         => 'footer-one',
		'before_widget' => '<div class="widget footer-widget footer-one">',
		'after_widget'  => "</div>\n",
		'before_title'  => '<h4 class="widgettitle">',
		'after_title'   => "</h4>\n",
	]);

	register_sidebar( [
		'name'          => __('Footer-two'),
		'id'            => 'footer-two',
		'description'   => '',
		'class'         => 'footer-two',
		'before_widget' => '<div class="widget footer-widget footer-two">',
		'after_widget'  => "</div>\n",
		'before_title'  => '<h4 class="widgettitle">',
		'after_title'   => "</h4>\n",
	]);

	register_sidebar( [
		'name'          => __('Footer-tree'),
		'id'            => 'footer-tree',
		'description'   => '',
		'class'         => 'footer-tree',
		'before_widget' => '<div class="widget footer-widget footer-tree">',
		'after_widget'  => "</div>\n",
		'before_title'  => '<h4 class="widgettitle">',
		'after_title'   => "</h4>\n",
	]);

	register_sidebar( [
		'name'          => __('Footer-bottom-one'),
		'id'            => 'footer-bottom-one',
		'description'   => '',
		'class'         => 'footer-bottom-one',
		'before_widget' => '<div class="widget footer-bottom footer-bottom-one">',
		'after_widget'  => "</div>\n",
		'before_title'  => '<h4 class="widgettitle">',
		'after_title'   => "</h4>\n",
	]);

	register_sidebar( [
        'name'          => __('Post bottom subscribe'),
        'id'            => 'post-bottom-subscribe',
        'description'   => '',
        'class'         => 'post-bottom-subscribe',
        'before_widget' => '<div class="widget post-bottom-subscribe">',
        'after_widget'  => "</div>\n",
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => "</h4>\n",
    ]);

    register_sidebar( [
        'name'          => __('Single article sidebar'),
        'id'            => 'single_article_sidebar',
        'description'   => '',
        'class'         => 'single_article_sidebar',
    ]);
}
add_action( 'after_setup_theme', 'cc_theme_setup' );
function get_short_title($maxchar = 70){
	$title = get_the_title();
	if( iconv_strlen($title, 'utf-8') < $maxchar )
		return $title;
	$title = iconv_substr( $title, 0, $maxchar, 'utf-8' );
	$title = preg_replace('@(.*)\s[^\s]*$@s', '\\1...', $title); //убираем последнее слово, ибо оно в 99% случаев неполное

	return $title;
}
add_action( 'wp_enqueue_scripts', 'my_scripts_method' );
function my_scripts_method() {
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js');
    wp_enqueue_script( 'jquery' );
}

function slidstvo_info_styles() {
	wp_register_style( 'bootstrap', get_template_directory_uri() . '/dist/css/bootstrap.css?v=11'  );
	wp_register_style( 'owl', get_template_directory_uri() . '/dist/css/owl.carousel.min.css'  );
	wp_enqueue_style( 'owl' );
    wp_register_style( 'owl-theme', get_template_directory_uri() . '/dist/css/owl.theme.default.min.css?v=11'  );
    wp_enqueue_style( 'owl-theme' );
	wp_register_style( 'percircle', get_template_directory_uri() . '/dist/css/percircle.css?v=11'  );	wp_enqueue_style( 'percircle' );

	wp_register_style( 'animate', get_template_directory_uri() . '/assets/css/animate.min.css?v=11' );
	wp_enqueue_style( 'animate' );

	wp_register_style( 'childstyle', get_template_directory_uri() . '/assets/css/main.min.css?v=151'  );
	//wp_deregister_style( 'js_composer_front' );
	wp_enqueue_style( 'bootstrap' );
	wp_enqueue_style( 'childstyle' , 'bootstrap' );
}
add_action( 'wp_enqueue_scripts', 'slidstvo_info_styles', 12 );

function slidstvo_info_scripts(){

    wp_register_script( 'owl-slider', get_template_directory_uri() . '/dist/js/owl.carousel.min.js', '' , 'null', true);
	wp_enqueue_script( 'owl-slider' , 'jquery' );
	wp_register_script( 'map-js', get_template_directory_uri() . '/dist/js/map.js?v=112', '' , 'null', true );
	wp_enqueue_script( 'map-js' , 'jquery' );
	wp_register_script( 'percircle', get_template_directory_uri() . '/dist/js/percircle.js?v=12' , '' , 'null', true);
	wp_enqueue_script( 'percircle' , 'jquery' );
    wp_register_script( 'js-cookie', get_template_directory_uri() . '/dist/js/jquery.cookie.js' , '' , 'null', true);
    wp_enqueue_script( 'js-cookie' , 'jquery' );

    wp_register_script( 'bootstrap-js', get_template_directory_uri() . '/dist/js/bootstrap.js?v=123', '' , 'null', true);
    wp_enqueue_script( 'bootstrap-js' , 'jquery' );

    // extra js with all edits, tweaks and improvements
    wp_register_script( 'extra-js', get_template_directory_uri() . '/extra.js?v=123', '' , 'null', true);
    wp_enqueue_script( 'extra-js' , 'jquery' );


    wp_enqueue_script('main.js', get_template_directory_uri() . '/dist/js/main.js?v=123', array('jquery'), filemtime(get_template_directory() . '/dist/js/main.js'), true);
    wp_localize_script('main.js', 'ajax_links', array(

            'url' => admin_url('admin-ajax.php')
    ));
  }
add_action( 'wp_enqueue_scripts' , 'slidstvo_info_scripts', 100 );


add_filter('rwd_image_sizes', 'my_rwd_image_sizes');
function my_rwd_image_sizes( $image_sizes ) {
	$slidstvo_image_sizes = array(
		'main-material' => array(
			array(
				array( 730, 445, true ),
				'picture' => '<img srcset="{src}" alt="{alt}">',
				'bg' => '', // main image, no media wrapper will be used.
				'srcset' => '1440w', // descriptor
				'sizes' => '(min-width: 1440px)', // condition
			),
			'main-material-medium' => array(
				array( 487, 297, true ),
				'picture' => '<img srcset="{src}" alt="{alt}">',
				'bg' => '',
				'srcset' => '960w',
				'sizes' => '(min-width: 960px) and (max-width: 1439px)',
			),
			'main-material-small' => array(
				array( 675, 410, true ),
				'picture' => '<img srcset="{src}" alt="{alt}">',
				'bg' => '',
				'srcset' => '720w',
				'sizes' => '(min-width: 720px) and (max-width: 959px)',
			),
			'main-material-extra-small' => array(
				array( 347, 206, true ),
				'picture' => '<img srcset="{src}" alt="{alt}">',
				'bg' => '',
				'srcset' => '320w',
				'sizes' => '(max-width: 719px)',
			),
		),
		'special-projects' => array(
			array(
				array( 460, 285, true ),
				'picture' => '<img srcset="{src}" alt="{alt}">',
				'bg' => '', // main image, no media wrapper will be used.
				'srcset' => '1440w', // descriptor
				'sizes' => '(min-width: 1440px) 1440px', // condition
			),
			'special-projects-medium' => array(
				array( 305, 190, true ),
				'picture' => '<img srcset="{src}" alt="{alt}">',
				'bg' => '',
				'srcset' => '960w',
				'sizes' => '(min-width: 960px) and (max-width: 1439px) 960px',
			),
			'special-projects-small' => array(
				array( 372, 233, true ),
				'picture' => '<img srcset="{src}" alt="{alt}">',
				'bg' => '',
				'srcset' => '720w',
				'sizes' => '(max-width: 959px) 720px',
			)
		),
		'additional-materials' => array(
			array(
				array( 400, 250, true ),
				'picture' => '<img srcset="{src}" alt="{alt}">',
				'bg' => '', // main image, no media wrapper will be used.
				'srcset' => '1440w', // descriptor
				'sizes' => '(min-width: 1440px) 1440px', // condition
			),
			'additional-materials-medium' => array(
				array( 267, 167, true ),
				'picture' => '<img srcset="{src}" alt="{alt}">',
				'bg' => '',
				'srcset' => '960w',
				'sizes' => '(min-width: 960px) and (max-width: 1439px) 960px',
			),
			'additional-materials-small' => array(
				array( 324, 203, true ),
				'picture' => '<img srcset="{src}" alt="{alt}">',
				'bg' => '',
				'srcset' => '720w',
				'sizes' => '(max-width: 959px) 720px',
			)
		),
	);
	return $slidstvo_image_sizes;
}

function get_excerpt( $count ) {
	$permalink = get_permalink($post->ID);
	$excerpt = get_the_content();
	$excerpt = strip_tags($excerpt);
	$excerpt = substr($excerpt, 0, $count);
	$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
	return $excerpt;
}

// exclude category main post from main query
function exclude_main_post( $query ) {

	if( ! is_admin() && $query->is_main_query() ) {

		if( $query->is_archive ) {

			$queried_object = get_queried_object();

			$main_post_type = get_posts(
				[
					'numberposts'	=> 1,
					'post_type'		=> $queried_object->name,
					'meta_query' 	=> [
						[
							'key' 	=> 'wpcf-main_post_type',
							'value' => '1'
						]
					],
				]
			);

			if ( ! empty( $main_post_type ) && is_array( $main_post_type ) ) {

				$query->set( 'post__not_in', [ $main_post_type[0]->ID ] );
			}
		}
	}

	return $query;
}
add_action( 'pre_get_posts', 'exclude_main_post' );

function change_journalists_archive( $query ) {

	if( ! is_admin() && $query->is_main_query() ) {

		if( $query->is_tax( 'journalists' ) ) {

			$query->set( 'posts_per_page', 6 );
		}
	}

	return $query;
}
add_action( 'pre_get_posts', 'change_journalists_archive' );

function set_posts_per_page_for_video_cpt( $query ) {

	if ( !is_admin() && $query->is_main_query() && is_post_type_archive( 'video' ) ) {

		$query->set( 'posts_per_page', '8' );
	}

	return $query;
}
add_action( 'pre_get_posts', 'set_posts_per_page_for_video_cpt' );

function removeOldMainPost ( $post_id, $post ) {

	global $pagenow;
	$post_type = get_post_type( $post_id );

	// Check page.
	if (  'post-new.php' === $pagenow ) {

		return null;
	}

	// Autosave, do nothing.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {

		return null;
	}

	// AJAX? Not used here.
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

		return null;
	}

	// Check user permissions.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {

		return null;
	}

	// Return if it's a post revision.
	if ( false !== wp_is_post_revision( $post_id ) ) {

		return null;
	}

	if ( ! isset( $_POST['wpcf'] ) ) {

		return null;
	}

	$meta_keys = [ 'main_post', 'main_post_type' ];

	foreach ( $_POST['wpcf'] as $meta_key => $meta_value ) {

		if ( in_array( $meta_key, $meta_keys, true ) && 1 == $meta_value ) {

			switch ( $meta_key ) {

				case 'main_post':
                    // disabled
				    return;
					$posts = get_posts(
						[
							'exclude'		=> $post_id,
							'numberposts'	=> -1,
							'post_status'	=> 'any',
							'post_type'		=> [ 'video', 'texts', 'news', 'investigations'],
							'meta_query'	=> [
								[
									'key' 		=> 'wpcf-main_post',
									'value' 	=> 1,
									'compare'	=> '=',
								]
							],
						]
					);

					if ( is_array( $posts ) && ! empty( $posts ) ) {

						foreach ( $posts as $post ) {

							delete_post_meta( $post->ID, 'wpcf-main_post' );
						}
					}

				case 'main_post_type':

					$posts = get_posts(
						[
							'exclude'		=> $post_id,
							'numberposts'	=> -1,
							'post_status'	=> 'any',
							'post_type'		=> $post_type,
							'meta_query'	=> [
								[
									'key' 		=> 'wpcf-main_post_type',
									'value' 	=> 1,
									'compare'	=> '=',
								]
							],
						]
					);

					if ( is_array( $posts ) && ! empty( $posts ) ) {

						foreach ( $posts as $post ) {

							delete_post_meta( $post->ID, 'wpcf-main_post_type' );
						}
					}
			}
		}
	}
}
add_action( 'save_post', 'removeOldMainPost', 10, 2 );

function the_excerpt_max_charlength( $charlength , $post_id  ){
	$excerpt = get_the_excerpt( $post_id );
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		} else {
			echo $subex;
		}
		echo '...';
	} else {
		echo $excerpt;
	}
}


add_action('admin_head', 'journalists_list_tune');

function journalists_list_tune() {
	echo '<style>
		.taxonomy-journalists .column-description,
		.taxonomy-journalists .column-wpseo-score,
		.taxonomy-journalists .column-wpseo-score-readability,
		.taxonomy-journalists .column-slug,
		.taxonomy-journalists .column-wpcf_field_photo,
		.taxonomy-journalists .column-wpcf_field_post,
		.taxonomy-journalists .column-wpcf_field_facebook_link{
			display: none;
		}
		.wpb_switch-to-gutenberg{
			display: none!important;
		}
	</style>';
}

//favicon both to admin and front areas
function add_favicon() {
  	$favicon_url = get_template_directory_uri() . '/favicon.ico';
	echo '<link rel="shortcut icon" type="image/png" href="' . $favicon_url . '" />';
}

add_action('wp_head', 'add_favicon');
add_action('admin_head', 'add_favicon');



/**
 * Init SlidstvoDonate
 * */

// Load libraries
include_once( 'libs/WayForPay/load.php' );

function generate_order() {
	global $slidstvo_info;
	// Way for pay credentials
	$wfp_user = esc_html ( $slidstvo_info['wfp_id'] );
	$wfp_secret = esc_html ( $slidstvo_info['wfp_secret'] );
	$wfp_domain = esc_html ( $slidstvo_info['wfp_domain'] );
	$product_name = esc_html ( $slidstvo_info['wfp_product_name'] );

	// generate random order ID
	$order_id = rand( 100, 100000 );

	// getting post params
	$amount = $_POST['amount'];
	$date = $_POST['date'];

	$order = new CreatePayment( $wfp_user, $wfp_secret );
	$order	->	addProduct( $product_name, $amount, 1 )
			->	setMerchantDomainName( $wfp_domain )
			->	setOrderReference( $order_id )
			->	setOrderDate( $date )
			->	setAmount( $amount )
			->	setCurrency( 'UAH' );
	$signature = $order -> generateMerchantSignature();

	$result = json_encode(array(
		'orderID' 	=> 	$order_id,
		'signature' => 	$signature,
		'date' 		=> 	$date,
		'amount' 	=> 	$amount,
		'name' 		=> 	$product_name,
		'merchant' 	=> 	$wfp_user,
		'domain'	=> 	$wfp_domain
	));
	echo  $result; //returning this value but still shows 0
	wp_die();
}

add_action( 'wp_ajax_nopriv_generate_order', 'generate_order' );
add_action( 'wp_ajax_generate_order', 'generate_order' );

function processDonation() {
    ?>
    <script id="widget-wfp-script" language="javascript" type="text/javascript" src="https://secure.wayforpay.com/server/pay-widget.js"></script>
    <script type="text/javascript">
        var generateOrder = function(data){

            // var clientName = jQuery("input[name='first_name']").val();
            // var clientSurname = jQuery("input[name='last_name']").val();
            // var clientEmail = jQuery("input[name='email']").val();
            // var clientPhone = jQuery("input[name='phone']").val();
            var amount = jQuery('input[name="amount"]').val();
            var period = jQuery("input[name='recurring']").val();

            // console.log(ValidatePhoneNumber(clientPhone));

            // if (( clientName == "" ) || ( clientSurname == "" ) || ( clientEmail == "" ) || ( clientPhone == "" ) || ( amount == "" ) || ( period == "" )){
            if (( amount == "" ) || ( period == "" )){
                jQuery("#form_errors").html("<?php esc_html_e( 'Please choose all payment options', 'slidstvo-info-theme' ); ?>");
            // } else if(!ValidateEmail(clientEmail)) {
            //     jQuery("#form_errors").html("Перевірте електронну пошту");
            // } else if(!ValidatePhoneNumber(clientPhone)) {
            //     jQuery("#form_errors").html("Перевірте номер телефону");
            } else {
                jQuery("#submit_donation").addClass("loading");
                jQuery("#form_errors").html("");
                $params = {
                    action 	: 'generate_order',
                    amount  : jQuery('input[name="amount"]').val(),
                    date 	: Date.now(),
                }
                jQuery.ajax({
                    type : "POST",
                    url : "<?php echo admin_url('admin-ajax.php'); ?>",
                    data : $params,
                    success: function(response) {
                        var params = JSON.parse(response)
                        donate(params);
                    }
                });
            }
        }

        var wayforpay = new Wayforpay();
        var donate = function ($data) {
            jQuery("#submit_donation").removeClass("loading");
            var Recurring = jQuery("input[name='recurring']").val();

            var clientName = jQuery("input[name='first_name']").val();
            var clientSurname = jQuery("input[name='last_name']").val();
            var clientEmail = jQuery("input[name='email']").val();
            var clientPhone = jQuery("input[name='phone']").val();

            if ( 'once' != Recurring ){
                var regularModeList = ['monthly', 'halfyearly', 'yearly'];
                var datePlusMonth = new Date().setMonth(new Date().getMonth() + 1);
                var dateNextMonth = new Date(datePlusMonth).toLocaleDateString();

                var day = new Date().getDay();
                var month = new Date().getMonth();
                var year = new Date().getFullYear();

                month += 1;

                if(month == 12){
                    month = 1;
                    year += 1;
                }else{
                    month += 1;
                }

                day = day < 10 ? '0' + day : day;
                month = month < 10 ? '0' + month : month;

                var dateNext = day + '.' + month + '.' + year;
                var dateEnd = day + '.' + month + '.' + (year + 10);

                var regularMode = Recurring;
                for(var i = 0; i < regularModeList.length; i++){
                    if(Recurring != regularModeList[i]){
                        regularMode += ';' + regularModeList[i];
                    }
                }

                wayforpay.run({
                        merchantAccount : $data['merchant'],
                        merchantDomainName : $data['domain'],
                        authorizationType : "SimpleSignature",
                        merchantSignature : $data['signature'],
                        orderReference : $data['orderID'],
                        orderDate : $data['date'],
                        amount : $data['amount'],
                        currency : "UAH",
                        productName : $data['name'],
                        productPrice : $data['amount'],
                        productCount : "1",
                        clientFirstName : clientName,
                        clientLastName : clientSurname,
                        clientEmail : clientEmail,
                        clientPhone : clientPhone,
                        language: "UA",
                        regularMode : regularMode,
                        dateNext: dateNext,
                        dateEnd: dateEnd,
                        requestType: 'CREATE',
                        regularOn : "1",
                    },
                    function (response) {
                        // on approved
                        console.log(response);
                    },
                    function (response) {
                        // on declined
                        console.log(response);
                    },
                    function (response) {
                        // on pending or in processing
                        console.log(response);
                    }
                );
            } else {
                wayforpay.run({
                        merchantAccount : $data['merchant'],
                        merchantDomainName : $data['domain'],
                        authorizationType : "SimpleSignature",
                        merchantSignature : $data['signature'],
                        orderReference : $data['orderID'],
                        orderDate : $data['date'],
                        amount : $data['amount'],
                        currency : "UAH",
                        productName : $data['name'],
                        productPrice : $data['amount'],
                        productCount : "1",
                        clientFirstName : clientName,
                        clientLastName : clientSurname,
                        clientEmail : clientEmail,
                        clientPhone : clientPhone,
                        language: "UA"
                    },
                    function (response) {
                        // on approved
                        console.log(response);
                    },
                    function (response) {
                        // on declined
                        console.log(response);
                    },
                    function (response) {
                        // on pending or in processing
                        console.log(response);
                    }
                );
            }
        }
    </script>
    <?php
}
add_action( 'wp_footer', 'processDonation' );

function turn_on_wpautop(){
  if(is_singular()){
    add_filter ('the_content', 'wpautop');
    add_filter ('the_excerpt', 'wpautop');
  }
}

add_action( 'template_redirect', 'turn_on_wpautop' );

add_action('nav_menu_css_class', 'add_current_nav_class', 10, 2 );

	function add_current_nav_class($classes, $item) {

		// Getting the current post details
		global $post;
		$current_term = get_queried_object();

		// Getting the post type of the current post
		$current_post_type = get_post_type_object(get_post_type($post->ID));

		$current_post_type_slug = $current_post_type->rewrite['slug'];

		// Getting the URL of the menu item
		$menu_slug = strtolower(trim($item->url));

		// If the menu item URL contains the current post types slug add the current-menu-item class
		if (strpos($menu_slug,$current_post_type_slug) !== false) {

		   $classes[] = 'current-menu-item';

		}
		if ( $current_term->taxonomy !== 'journalists' ){
			// Return the corrected set of classes to be added to the menu item
			return $classes;
		}

	}


function include_post_types_in_feed($qv) {
    if (isset($qv['feed']) && !isset($qv['post_type']))
        $qv['post_type'] = array('animation', 'video', 'articles', 'news' , 'special-projects', 'blogs');
    return $qv;
}
add_filter('request', 'include_post_types_in_feed');

add_action('init', 'customRSS');
function customRSS(){
    add_feed('ukrnet_feed', 'ukrnetRSS');
}

function ukrnetRSS(){
    /**
     * RSS2 Feed Template for displaying RSS2 Posts feed.
     *
     * @package WordPress
     */

    header( 'Content-Type: ' . feed_content_type( 'rss2' ) . '; charset=' . get_option( 'blog_charset' ), true );
    $more = 1;

    echo '<?xml version="1.0" encoding="' . get_option( 'blog_charset' ) . '"?' . '>';

    /**
     * Fires between the xml and rss tags in a feed.
     *
     * @since 4.0.0
     *
     * @param string $context Type of feed. Possible values include 'rss2', 'rss2-comments',
     *                        'rdf', 'atom', and 'atom-comments'.
     */
    do_action( 'rss_tag_pre', 'rss2' );
    ?>
    <rss version="2.0"
         xmlns:content="http://purl.org/rss/1.0/modules/content/"
         xmlns:wfw="http://wellformedweb.org/CommentAPI/"
         xmlns:dc="http://purl.org/dc/elements/1.1/"
         xmlns:atom="http://www.w3.org/2005/Atom"
         xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
         xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
        <?php
        /**
         * Fires at the end of the RSS root to add namespaces.
         *
         * @since 2.0.0
         */
        do_action( 'rss2_ns' );
        ?>
    >

        <channel>
            <title><?php wp_title_rss(); ?></title>
            <atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
            <link><?php bloginfo_rss( 'url' ); ?></link>
            <description><?php bloginfo_rss( 'description' ); ?></description>
            <lastBuildDate><?php echo mysql2date(
                    'D, d M Y H:i:s +3000',
                    date("Y-m-d H:i:s", strtotime(get_lastpostdate("GMT")) + strtotime("+3 hour", 0)),
                    false
                ) ?></lastBuildDate>
            <language><?php bloginfo_rss( 'language' ); ?></language>
            <sy:updatePeriod>
                <?php
                $duration = 'hourly';

                /**
                 * Filters how often to update the RSS feed.
                 *
                 * @since 2.1.0
                 *
                 * @param string $duration The update period. Accepts 'hourly', 'daily', 'weekly', 'monthly',
                 *                         'yearly'. Default 'hourly'.
                 */
                echo apply_filters( 'rss_update_period', $duration );
                ?>
            </sy:updatePeriod>
            <sy:updateFrequency>
                <?php
                $frequency = '1';

                /**
                 * Filters the RSS update frequency.
                 *
                 * @since 2.1.0
                 *
                 * @param string $frequency An integer passed as a string representing the frequency
                 *                          of RSS updates within the update period. Default '1'.
                 */
                echo apply_filters( 'rss_update_frequency', $frequency );
                ?>
            </sy:updateFrequency>
            <?php
            /**
             * Fires at the end of the RSS2 Feed Header.
             *
             * @since 2.0.0
             */
            do_action( 'rss2_head' );

			// Get main all news
			$all_posts = new WP_Query([
				'post_type' 	=> [ 'articles', 'news', 'success-stories', 'warnews', 'english-stories' ],
	            'posts_per_page' => 10
			]);

            while ( $all_posts->have_posts() ) :
                $all_posts->the_post();
                ?>
                <item>
                    <title><![CDATA[<?php the_title_rss(); ?>]]></title>
                    <link><?php the_permalink_rss(); ?></link>
                    <?php if ( get_comments_number() || comments_open() ) : ?>
                        <comments><?php comments_link_feed(); ?></comments>
                    <?php endif; ?>
                    <?php
                    // get UTC post date
                    $postDate = get_post_time( 'Y-m-d H:i:s', true );
                    // add local offset to time
                    $newDate = date('Y-m-d H:i:s',strtotime('+3 hours',strtotime($postDate)));
                    ?>
                    <pubDate><?php echo mysql2date( 'D, d M Y H:i:s +0300', $newDate, false ); ?></pubDate>
                    <dc:creator><![CDATA[<?php the_author(); ?>]]></dc:creator>
                    <?php the_category_rss( 'rss2' ); ?>

                    <guid isPermaLink="false"><?php the_guid(); ?></guid>
                    <?php if ( get_option( 'rss_use_excerpt' ) ) : ?>
                        <description><![CDATA[<?php the_excerpt(); ?>]]></description>
                    <?php else : ?>
                        <description><![CDATA[<?php the_excerpt(); ?>]]></description>
                        <?php $content = get_the_content_feed( 'rss2' ); ?>
                        <?php if ( strlen( $content ) > 0 ) : ?>
                            <fulltext><![CDATA[<?php
                                //echo $content;
                                $post_new = get_post( get_the_ID() );
                                echo $post_new->post_content;
                                // ?>]]></fulltext>
                        <?php else : ?>
                            <fulltext><![CDATA[<?php the_excerpt_rss(); ?>]]></fulltext>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if ( get_comments_number() || comments_open() ) : ?>
                        <wfw:commentRss><?php echo esc_url( get_post_comments_feed_link( null, 'rss2' ) ); ?></wfw:commentRss>
                        <slash:comments><?php echo get_comments_number(); ?></slash:comments>
                    <?php endif; ?>
                    <?php rss_enclosure(); ?>
                    <?php
                    /**
                     * Fires at the end of each RSS2 feed item.
                     *
                     * @since 2.0.0
                     */
                    do_action( 'rss2_item' );
                    ?>
                </item>
            <?php endwhile;

	        wp_reset_postdata(); ?>
        </channel>
    </rss>
    <?php
}
function showAuthors(){
	$author = get_the_terms( $post->ID , 'journalists' );
	$useCatLink = true;
	// If post has a category assigned.
	if ($author){
		$author_display = '';
		$author_link = '';
		$primary_journalist = '';
		if ( class_exists('WPSEO_Primary_Term') ){
			// Show the post's 'Primary' category, if this Yoast feature is available, & one is set
			$wpseo_primary_term = new WPSEO_Primary_Term( 'journalists', get_the_id() );
			$wpseo_primary_term = $wpseo_primary_term->get_primary_term();
			$term = get_term( $wpseo_primary_term );
			// print_r( $term);
			if (is_wp_error($term)) {
				// Default to first category (not Yoast) if an error is returned
				$author_display = $author[0]->name;
				$author_link = get_bloginfo('url');
			} else {
				$primary_journalist = $term->name;
				// Yoast Primary category
				$author_display = $term->name;
				$author_link = get_term_link( $term->term_id );
			}
		} else {
			// Default, display the first category in WP's list of assigned categories
			$author_display = $author[0]->name;
			$author_link = get_term_link( $author[0]->term_id );
		}
		// Display category
		if ( !empty($author_display) ){
		    if ( $useCatLink == true && !empty($author_link) ){
			echo '<a href="'.$author_link.'">'.$author_display.'</a>';
		    } else {
			echo '<span class="post-category">'.$author_display.'</span>';
		    }
		}
		foreach ($author as $item) {
			// code...
			if ( $item->name != $primary_journalist ){
				$author_link = get_term_link( $item->term_id );
				echo ', <a href="'.$author_link.'">'.$item->name.'</a>';
			}
		}
	}
}
add_filter( 'wp_title', 'wp_title_function', 100, 4 );
function wp_title_function( $title, $sep, $seplocation ) {
	$title = str_replace(" Архіви", "", $title);
    $title = str_replace(" Архів", "", $title);
    return $title;
}

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

function mb_ucfirst($string, $encoding = "UTF8")
{
    $strlen = mb_strlen($string, $encoding);
    $firstChar = mb_substr($string, 0, 1, $encoding);
    $then = mb_substr($string, 1, $strlen - 1, $encoding);
    return mb_strtoupper($firstChar, $encoding) . $then;
}

/****************************/
// hooks your functions into the correct filters
function wdm_add_mce_button() {
    // check user permissions
    if ( !current_user_can( 'edit_posts' ) &&  !current_user_can( 'edit_pages' ) ) {
        return;
    }
    // check if WYSIWYG is enabled
    if ( 'true' == get_user_option( 'rich_editing' ) ) {
        add_filter( 'mce_external_plugins', 'wdm_add_tinymce_plugin' );
        add_filter( 'mce_buttons', 'wdm_register_mce_button' );
    }
}
add_action('admin_head', 'wdm_add_mce_button');



// register new button in the editor
function wdm_register_mce_button( $buttons ) {
    array_push( $buttons, 'wdm_mce_button' );
    array_push( $buttons, 'wdm_mce_button_1' );
    array_push( $buttons, 'wdm_mce_button_2' );
    return $buttons;
}


// declare a script for the new button
// the script will insert the shortcode on the click event
function wdm_add_tinymce_plugin( $plugin_array ) {
    $path = get_stylesheet_directory_uri() .'/dist/js/editor_button.js';
    $plugin_array['wdm_mce_button'] = $path;
    $plugin_array['wdm_mce_button_1'] = $path;
    $plugin_array['wdm_mce_button_2'] = $path;
    return $plugin_array;
}


/* require */

    require 'inc/ajaxGetPosts.php';
    require 'inc/cpt.php';
    require 'inc/taxonomies.php';
    require 'inc/shelters.php';


// find "english stories" link in menu and a class to it. also some minor tweaks.
//add_action( 'wp_head', 'ozz_english_stories_black_button' ); // moved to extra.js
function ozz_english_stories_black_button() {
	?>
	<script>
		jQuery(document).ready(function($) {
			const englishStories = $('#menu-submenu .nav-link[href$="/english-stories/"]');
			if (englishStories.length) {
				englishStories.parent().addClass('english-stories');
				englishStories.parent().next().children().first().css('border-left', '1px solid #333');
			}
		});
	</script>
	<?php
}

// find "slidstvo club" link in menu and a class to it
//add_action( 'wp_head', 'ozz_slidctvo_club_black_button' ); // moved to extra.js
function ozz_slidctvo_club_black_button() {
	?>
	<script>
		jQuery(document).ready(function($) {
			const slidstvoClub = $('#menu-headermenu .nav-link[href$="/slidstvo_club/"]');
			if (slidstvoClub.length) {
				slidstvoClub.parent().addClass('specprojects-btn');
			}
		});
	</script>
	<?php
}

// find warnews link in menu and a class to it. also some minor tweaks.
//add_action( 'wp_head', 'ozz_warnews_red_button' ); // moved to extra.js
function ozz_warnews_red_button() {
	?>
	<script>
		jQuery(document).ready(function($) {
			const warnewsLink = $('#menu-submenu .nav-link[href="/warnews"]');
			if (warnewsLink.length) {
				warnewsLink.parent().addClass('warnews');
				warnewsLink.parent().next().children().first().css('border-left', '1px solid rgba(34,34,34,.3)');
			}
		});
	</script>
	<?php
}

//add_action( 'wp_head', 'ozz_wider_container' ); // moved to main.min.css
function ozz_wider_container() {
	?>
		<style>
			@media (min-width: 1440px) {
				.container {
				    max-width: 1480px;
				}
				.content img {
					/*min-width: 905px;*/
				}
				.row {
					margin-right: -140px;
				}
				.authors-list .row, article.row {
					margin-right: -15px;
				}
			}

			/* hack for dumbest browser */
			@media not all and (min-resolution:.001dpcm) { @media {
				.row .col-lg-7 {
					padding-left: 30px;
				}
			}}
			@media not all and (min-resolution:.001dpcm)
				{ @supports (-webkit-appearance:none) {
					.row .col-lg-7 {
						padding-left: 30px;
					}
				}
			}
		</style>
	<?php
}


// hide Judges' Blood
add_action( 'template_redirect', 'ozz_hide_judge_blood' );
function ozz_hide_judge_blood() {
    if ( is_single( 10806 ) ) { // 'https://www.slidstvo.info/special-projects/suddivska-krov/'
		wp_redirect( '/', 301 );
		exit;
    }
}

// prevent redirect from absent posts to images (apparently this happens because post's id now belongs to media image)
add_action( 'template_redirect', 'ozz_prevent_redirect_to_images', 0 );
function ozz_prevent_redirect_to_images() {
    global $post;

	// echo "\n" . '<br>post:<pre>' . print_r( $post, true ) . '</pre>' . "\n";
	// echo "\n" . '<br>post meta:<pre>' . print_r( get_post_meta( $post->ID ), true ) . '</pre>' . "\n";
	if ( @$post->post_type == 'attachment' ) {
		wp_redirect( '/', 301 );
		exit;
	}

}

// add Edit Tag button
add_action( 'submitpost_box', 'ozz_edit_tag_admin' );
function ozz_edit_tag_admin() {
	$delete_nonce	= wp_create_nonce( 'tag_delete_nonce' );
	$edit_nonce		= wp_create_nonce( 'tag_edit_nonce' );
	?>
	<script>
		jQuery.fn.textNodes = function() {
			return this.contents().filter(function() {
				return (this.nodeType === Node.TEXT_NODE && this.nodeValue.trim() !== "");
			});
		}

		jQuery(document).ready(function($) {
			console.log('Edit post');
			if ($('#tagschecklist').length) {

				const ajaxUrl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
				// get all tag names on the list in array
				const tagNames = $('#tagschecklist li label').map(function() {
					return $.trim($(this).text());
				}).get();

				$('#tagschecklist li').each(function(i,e) {
					$(e).children('label').after('<div class="tag_edit_inline_buttons_container"><div class="tag_action_inline edit_tag"><a title="Редагувати" href="javascript:void(0);">&#9998;</a></div><div class="tag_action_inline delete_tag"><a title="Видалити" href="javascript:void(0);">x</a></div></div>');
				});

				// event listener for Delete
				$('.tag_action_inline.delete_tag a').on('click', function() {
					const tagLi = $(this).parent().parent().parent();
					const tagName = tagLi.children('label').text();
					if (confirm('Видалити тег"'+tagName+'"?') == true) {
						// get tag id
						const tagId = tagLi.find('input[type="checkbox"]').val();
						// ajax delete tag
						jQuery.post(ajaxUrl, {
					    	tag_id: tagId,
					    	action: 'inline_delete_tag',
					    	nonce: '<?php echo $delete_nonce; ?>',
					    	function() {
					    		$(this).parent().parent().fadeOut(120); // hide tag at once
					    	}
					    });
					}
				});

				// event listener for Edit
				$('.tag_action_inline.edit_tag a').on('click', function() {
					const tagLi = $(this).parent().parent().parent();
					const tagName = $.trim(tagLi.children('label').text());
					// replace tag with input and buttons with "ok" and "cancel"
					tagLi.children().hide(); // hide existing elements
					tagLi.append('<input type="text" style="width: 80%;" id="tag_edit_inline" value="'+tagName+'">');
					tagLi.append('<span class="tag_edit_inline_buttons_container tag_edit_inline_buttons"><span id="tag_edit_inline_ok"><a href="javascript: void(0);">&#10004;</a></span><span id="tag_edit_inline_cancel"><a href="javascript: void(0);">&#10006;</a></span></span>');
					$('#tag_edit_inline').focus();
				});

				// event listeners for Edit buttons
				// OK
				$('body').on('click', '.tag_edit_inline_buttons_container.tag_edit_inline_buttons #tag_edit_inline_ok a', function() {
					const tagLi = $(this).parent().parent().parent();
					const tagId = tagLi.find('input[type="checkbox"]').val();
					const newName = tagLi.find('#tag_edit_inline').val();

					// check if new name already exists on the list
					if ($.inArray(newName, tagNames) !== -1) {
						console.log('name exists');
						if (confirm('Тег"'+newName+'" вже iснує. Бажаєте об\'єднати цi теги?') == true) {
							// get tag id of existing name
							let oldTag = tagLi.parent().find('li:contains("'+newName+'")');
							if (oldTag.length) {
								var oldTagId = oldTag.find('input[type="checkbox"]').val();
							} else {
								alert('Помилка: дублiкат iснує, але не може бути знайденим.');
								reverceEditTag();
								return false;
							}
							jQuery.post(ajaxUrl, {
						    	old_tag_id: oldTagId,
						    	tag_id: tagId,
						    	new_name: newName,
						    	action: 'inline_edit_tag',
						    	nonce: '<?php echo $edit_nonce; ?>',
						    	function() {
						    		//tagLi.find('label').textNodes().replaceWith(newName); // show new name
						    		tagLi.fadeOut(120); // hide duplicate
						    		reverceEditTag();
						    	}
						    });
						} else {
							reverceEditTag();
							return false;
						}
					}

					jQuery.post(ajaxUrl, {
				    	tag_id: tagId,
				    	new_name: newName,
				    	action: 'inline_edit_tag',
				    	nonce: '<?php echo $edit_nonce; ?>',
				    	function() {
				    		tagLi.find('label').textNodes().replaceWith(newName); // show new name
				    		reverceEditTag();
				    	}
				    });
				});
				// CANCEL
				$('body').on('click', '.tag_edit_inline_buttons_container.tag_edit_inline_buttons #tag_edit_inline_cancel a', function() {
					reverceEditTag();
				});

				// when in edit tag mode close this mode if clicked elsewhere
				$('body').on('click', function(e) {
					// find edit box
					let editBox = $('#tag_edit_inline');
					if (editBox.length) {
						let parentLi = editBox.parent().parent();
						if (!parentLi.find(e.target).length) {
							reverceEditTag();
						}
					}
				});

				// finds editing box for tag, removes it and shows default contents of tag li
				function reverceEditTag() {
					console.log('reverceEditTag clicked');
					// find editing box
					let editBox = $('#tag_edit_inline');
					if (editBox.length) {
						editBox.parent().children().show(); // show default li contents
						editBox.parent().find('.tag_edit_inline_buttons_container.tag_edit_inline_buttons').remove(); // remove buttons container
						editBox.remove(); // remove edit box
					}
				}

				// add tag search input
				$('#tagschecklist').parent().prepend('<div class="tag_search_wrapper"><input type="text" id="tag_search_input" placeholder="<?php esc_html_e( 'Пошук тегiв', 'slidstvo-info-theme' ); ?>"></div>');
				// add event listener for search input
				$('#tag_search_input').on('keyup', function () {
				    const search_text = $(this).val();

				    if (!!search_text) {
					    $('#tagschecklist li').each(function(i,e) {
				            const tag_text = $.trim($(e).find('label').textNodes().text());

				            if (tag_text.indexOf(search_text) === -1) {
				                $(e).addClass('hide_tag_li');
				            } else {
				                $(e).removeClass('hide_tag_li');
				            }
					    });
					} else {
						$('#tagschecklist li').removeClass('hide_tag_li');
					}
				});
			}
		});
	</script>
	<?php
}
add_action( 'admin_head', 'ozz_admin_styles' );
function ozz_admin_styles() {
	?>
	<style>
		.tag_edit_inline_buttons_container {
			float: right;
		}
		.tag_edit_inline_buttons_container a {
			text-decoration: none;
		}
		.tag_action_inline {
			display: inline-block;
		}
		.tag_action_inline a {
			color: #80808085;
		}
		.tag_action_inline a:hover {
			color: #56566e;
		}
		.tag_action_inline.delete_tag a {
			font-weight: 700;
		    font-size: 25px;
		    line-height: 14px;
		    max-height: 14px;
		    overflow: hidden;
		}
		.tag_action_inline.edit_tag a {
			font-size: 18px;
			line-height: 20px;
		}
		.tag_edit_inline_buttons_container span {
		    font-size: 17px;
		    line-height: 26px;
		    margin-left: 2px;
		    font-weight: 900;
		}
		.tag_edit_inline_buttons_container.tag_edit_inline_buttons #tag_edit_inline_cancel a {
			color: #973f3f91;
		}
		.tag_edit_inline_buttons_container.tag_edit_inline_buttons #tag_edit_inline_cancel a:hover {
			color: #973f3f;
		}
		.tag_edit_inline_buttons_container.tag_edit_inline_buttons #tag_edit_inline_ok a {
			color: #3e913eab;
		}
		.tag_edit_inline_buttons_container.tag_edit_inline_buttons #tag_edit_inline_ok a:hover {
			color: #3e913e;
		}
		#tag_search_input {
			width: 100%;
			margin-top: 4px;
		}
		.hide_tag_li {
			display: none;
		}
		div[data-wpt-id="wpcf-main_post_type"]{
			display:none;
		}
	</style>
	<?php
}
// handlers for ajax Edit and Delete tag
add_action( 'wp_ajax_inline_delete_tag', 'ozz_backend_inline_delete_tag' );
function ozz_backend_inline_delete_tag() {
	// check nonce
	if ( ! wp_verify_nonce( $_POST['nonce'], 'tag_delete_nonce' ) ) {
		die( 'Unauthorized attempt');
	}

	if ( !empty( $_POST['tag_id'] ) ) {
		$tag_id	= absint( $_POST['tag_id'] );
		$tag	= get_term_by( 'id', $tag_id, 'tags');
		if ( !empty( $tag ) ) {
			// delete this tag
			if ( wp_delete_term( $tag_id, 'tags' ) ) {
				wp_send_json_success( 'Tag deleted: ' . $tag_id );
				exit;
			} else {
				wp_send_json_error( 'Failed to delete tag: ' . $tag_id );
			}
		} else {
			wp_send_json_error( 'No tag found' );
		}
	} else {
		wp_send_json_error( 'No tag found' );
	}
}
add_action( 'wp_ajax_inline_edit_tag', 'ozz_backend_inline_edit_tag' );
function ozz_backend_inline_edit_tag() {
	// check nonce
	if ( !wp_verify_nonce( $_POST['nonce'], 'tag_edit_nonce' ) ) {
		die( 'Unauthorized attempt');
	}

	if ( !empty( $_POST['tag_id'] ) and !empty( $_POST['new_name'] ) ) {
		$new_name	= sanitize_text_field( $_POST['new_name'] );
		$tag_id		= absint( $_POST['tag_id'] );
		$tag		= get_term_by( 'id', $tag_id, 'tags');
		if ( !empty( $tag ) ) {
			// check if new name already exists
			if ( $_POST['old_tag_id'] ) {
				$old_tag_id	= absint( $_POST['old_tag_id'] );
				// combine two tags into one by reassigning posts with current tag to old tag
				$args = [
					'post_type' => 'any',
					'tax_query' => [[
						'taxonomy'	=> 'tags',
						'field'		=> 'term_id',
						'terms'		=> $tag_id
					]]
				];
				$current_tag_posts = get_posts( $args );
				// remove current tag
				$remove_current_tag = wp_delete_term( $tag_id, 'tags' );
				if ( $remove_current_tag ) {
					// assign old tag to these posts
					foreach( $current_tag_posts as $post ) {
						$post_set_term_result = wp_set_object_terms( $post->ID, [ (int) $old_tag_id ], 'tags', true );
						if ( !$post_set_term_result or is_wp_error( $post_set_term_result ) ) {
							wp_send_json_error( 'Failed to set tag: ' . $old_tag_id . ' to the post: ' . $post->ID );
						}
					}
					wp_send_json_success( 'Tags combined: ' . $tag_id . ' -> ' . $old_tag_id );
					exit;
				} else {
					wp_send_json_error( 'Failed to delete tag: ' . $tag_id );
				}
			} else {
				// rename this tag
				$update = wp_update_term( $tag_id, 'tags', [
				    'name' => $new_name
				]);
				if ( $update ) {
					wp_send_json_success( 'Tag renamed: ' . $tag_id );
					exit;
				} else {
					wp_send_json_error( 'Failed to rename tag: ' . $tag_id );
				}
			}
		}
	} else {
		wp_send_json_error( 'No tag found' );
	}
}


// make all three news columns on main page of equal height
add_action( 'wp_head', 'ozz_equalize_news_columns_heights_in_home' );
function ozz_equalize_news_columns_heights_in_home() {
	if ( is_front_page() ) {
		?>
		<script>
			jQuery(window).ready(function() {
				setTimeout(function() {
					const columns = {
						'firstColumn':	jQuery('.news-block-main-news'),
						'secondColumn':	jQuery('.news-block-articles-list'),
						//'thirdColumn':	jQuery('.news-video-block')
					};
					var columnHeights = {
						'firstColumn':	columns['firstColumn'].height(),
						'secondColumn':	jQuery('.news-block-articles-list').outerHeight(true) + jQuery('.news-block-articles').children('.more-news').height() + 10,
						//'thirdColumn':	columns['thirdColumn'].height()
					};

					// define which height is bigger
					const sortedColumnHeights = Object.fromEntries(
					    Object.entries(columnHeights).sort(([,a],[,b]) => a-b)
					);
					const columnsNames		= Object.keys(sortedColumnHeights);
					const columnsHeights	= Object.values(sortedColumnHeights);
					const normHeight		= Object.values(sortedColumnHeights).pop();

					for (const [key, value] of Object.entries(sortedColumnHeights)) {
						// skip the longest column
						if (value == normHeight) {
							continue;
						}

						// define how many children there are in shorty
						const shortyChildren = columns[key].children().length;
						// define height difference
						const heightDiff = Math.abs(normHeight - value);
						// now spread this difference between children' margins
						const singleDiff = Math.round( heightDiff / (shortyChildren - 1) );
						// add this diff to margin-top to every child except first one
						const newMarginTop = parseInt(columns[key].children().css('margin-top')) + singleDiff;
						// equalize columns
						columns[key].children().not(':first').css('margin-top', newMarginTop+'px');
					}

					// cut the bottom of war banner to match the normal height
					const thirdColumnHeight = jQuery('.news-video-block').height();
					if (thirdColumnHeight > normHeight) {
						const thirdColumnDiff	= thirdColumnHeight - normHeight;
						const bannerHeight		= $('#war_banner img').height();
						const newBannerHeight	= bannerHeight - thirdColumnDiff;
						$('#war_banner').css('height', newBannerHeight+'px');
					}
				}, 500);

				// bring the next block, movies, a bit higher
				$('.movies-block').parent().parent().css('padding-top', '0');
			});
		</script>
		<?php
	}
}

// remove rel="nofollow" from social media links 496px height
//add_action( 'wp_head', 'ozz_remove_nofollow_from_social' ); // moved to extra.js
function ozz_remove_nofollow_from_social() {
	?>
		<script>
			jQuery(document).ready(function($) {
				$('.main-nav .social a').removeAttr('rel');
			});
		</script>
	<?php
}


// add <h1> where it's absent
// add_action( 'wp_head', 'ozz_add_h1' );
function ozz_add_h1() {
	if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( '', false );
    } elseif ( is_tax() ) {
        $title = single_term_title( '', false );
    } else {
		global $post;

		$title = $post->post_title;
	}

	if ( !empty( $title ) ) {
		//echo "\n" . '<br>post:<pre>' . print_r( $post, true ) . '</pre>' . "\n";
		//echo "\n" . '<br>title:<pre>' . print_r( $title, true ) . '</pre>' . "\n";
		?>
			<script>
				jQuery(document).ready(function($) {
					if (!$('h1').length) {
						console.log('no h1');
						$('main').prepend('<h1><?php echo $title; ?></h1>');
					}
				});
			</script>
		<?php
	}
}


// replace normal link to post with outer URL of this post if set
add_filter( 'post_type_link', 'ozz_get_outer_url', 10, 4 );
function ozz_get_outer_url( $post_link, $post, $leavename, $sample ) {
	$outer_url = get_post_meta( $post->ID, 'wpcf-outer_url', true );
	if ( empty( $outer_url ) ) {
		return $post_link;
	} else {
		return $outer_url;
	}

	// if ( @$_GET['test'] == 'outer_url' ) {
	// 	echo "\n" . '<br>outer_url:<pre>' . print_r( $outer_url, true ) . '<br>';
	// }
}

// Customize mce editor font sizes
add_filter( 'tiny_mce_before_init', 'ozz_mce_font_sizes' );
function ozz_mce_font_sizes( $initArray ) {
    $initArray['fontsize_formats'] = '9px 10px 12px 13px 14px 16px 18px 21px 24px 28px 32px 36px';
    return $initArray;
}

// GA4 views counter
add_action( 'wp_head', 'ga4_views_counter' );
function ga4_views_counter() {
	$page_title	= get_the_title();
	$page_url	= get_page_link();
	?>
	<script type="text/javascript">
		gtag('config', 'G-JE760KM5ER', {
		  page_title: '<?php echo $page_title; ?>',
		  page_location: '<?php echo $page_url; ?>' // Include the full URL
		});
	</script>
	<?php
}

// Post views counter update on front after ajax update call
add_action('pvc_after_count_visit', 'ozz_echo_current_count');
function ozz_echo_current_count( $id ) {
	$post_views = pvc_get_post_views( $id );
	echo $post_views;
}

// resize youtube player for different screen sizes
add_action( 'wp_head', 'ozz_youtube_player_resize' );
function ozz_youtube_player_resize() {
	?>
	<script>
		jQuery(() => {
		    function setAspectRatio() {
		      jQuery('iframe').each(function() {
		        jQuery(this).css('height', jQuery(this).width() * 9/16);
		      });
		    }

		    setAspectRatio();
		    jQuery(window).resize(setAspectRatio);
		});
	</script>
	<?php
}

add_filter( 'manage_edit-journalists_columns', 'true_add_columns');

function true_add_columns( $my_columns ) {

    $my_columns[ 'aboutuscolumn' ] = 'На сторінці Про Нас';
    return $my_columns;

}

add_action( 'admin_head', function() {

    echo '<style>
	#aboutuscolumn {
	    text-align: center;
		width: 100px; /* уменьшаем ширину колонки до 58px */
	}
	.aboutuscolumn {
	    text-align: center;
	}

	</style>';

} );

add_filter( 'manage_journalists_custom_column', 'true_fill_columns', 25, 3 );

function true_fill_columns( $out, $column_name, $term_id ) {

    switch ( $column_name ) {

        case 'aboutuscolumn': {
            $show_about = get_term_meta( $term_id, 'wpcf-show-in-list', true );
            if( $show_about ) {
                $out .= '<img draggable="false" role="img" class="emoji" alt="✔" src="https://s.w.org/images/core/emoji/14.0.0/svg/2714.svg">';
            } else {
                $out .= '';
            }
            break;
        }

    }

    return $out;

}

// Allow SVG
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
  global $wp_version;
  if ( $wp_version !== '4.7.1' ) {
     return $data;
  }
  $filetype = wp_check_filetype( $filename, $mimes );
  return [
      'ext'             => $filetype['ext'],
      'type'            => $filetype['type'],
      'proper_filename' => $data['proper_filename']
  ];
}, 10, 4 );

function slidstvo_mime_types( $mimes ){
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter( 'upload_mimes', 'slidstvo_mime_types' );

function fix_svg() {
  echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
}
add_action( 'admin_head', 'fix_svg' );

add_filter( 'acf/the_field/escape_html_optin', '__return_true' );



