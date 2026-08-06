<?php

/**
 * Header
 *
 * @file
 * @package		slidstvo.info
 * @author		Andrew Skochelias
 */

global $slidstvo_info;

$spec_projects  = (new WP_Query([
    'post_type' => 'special-projects',
    'posts_per_page' => '3',
]))->get_posts();

$is_map_project = get_field('is_map_project');

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5S3V7H8');</script>
<!-- End Google Tag Manager -->


	<meta name="facebook-domain-verification" content="whbb8ewgt1cdeh6q6gqoin8d21a39v" />
	<title>
        <?php
        if ( is_404() ) {
            esc_html_e( 'Page not found', 'slidstvo-info-theme' );
        } else {
            wp_title();
        }
        ?>
	</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="https://gmpg.org/xfn/11" />
    <?php wp_head(); ?>

	<?php if (!$is_map_project) : ?>
	<script defer data-search-pseudo-elements src="https://use.fontawesome.com/releases/v5.7.2/js/all.js" integrity="sha384-0pzryjIRos8mFBWMzSSZApWtPl/5++eIfzYmTgBBmXYdhvxPc+XcFEk+zJwDgWbP" crossorigin="anonymous"></script>
	<?php endif; ?>
	<script>
        function isMobile( param ){
            // var viewportWidth = window.innerWidth || document.documentElement.clientWidth;
            var viewportWidth = document.body.clientWidth;
            var width = 0;
            var response;
            if ( param == "xs" ){
                width = 720;
            } else {
                width = 960;
            }
            if (viewportWidth < width) {
                // Mobile state
                return true;
            } else {
                // Not mobile state
                return false;
            }

        }
	</script>
  <script>
    window.shelterMapData = {
      themeUrl: '<?php echo get_template_directory_uri() . '/assets' ?>',
      ajaxUrl: '<?php echo admin_url('admin-ajax.php') ?>',
      nonce: '<?php echo wp_create_nonce('shelter_map_nonce'); ?>',
      home: '<?php echo home_url() ?>/wp-json/shelters/v1/list'
    };

  </script>
	<?php

	if ( $is_map_project ) {

		function custom_body_class( $classes ) {
			$classes[] = 'map-page'; // Add your desired class name here
			return $classes;
		}
		add_filter( 'body_class', 'custom_body_class' );

	$theme_uri = get_template_directory_uri() . '/assets';

		// Enqueue scripts and styles only when shortcode is used
		wp_enqueue_style('shelter-map-css', $theme_uri . '/css/app.css', array(), '1.0.52');

		wp_enqueue_script('shelter-map-js', $theme_uri . '/js/app.js', array('jquery'), '1.0.51', true);

		// Localize script to pass theme directory URL to JavaScript
//		wp_localize_script('shelter-map-js', 'shelterMapData', array(
//			'themeUrl' => $theme_uri,
//			'ajaxUrl' => admin_url('admin-ajax.php'),
//			'nonce' => wp_create_nonce('shelter_map_nonce'),
//      'home' => home_url('/wp-json/shelters/v1/list')
//		));
	}

	?>

</head>

<body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5S3V7H8"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<!-- Facebook Pixel Code -->
<script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window,document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '2007972122642620');
    fbq('track', 'PageView');
</script>
<noscript>
	<img height="1" width="1"
	     src="https://www.facebook.com/tr?id=2007972122642620&ev=PageView
		&noscript=1"/>
</noscript>
<!-- Fixed navbar -->
<script>
    jQuery(document).ready(function($){
        if (isMobile()){
            let searchForm = $("#searchform");
            let rightBlock = $("nav.navbar .mobile-right");
            let subHeader = $(".sub-header");
            let collapsedMenu = $("#navbarCollapse");
            let collapsedMenuPosition = $("nav.navbar").outerHeight(true);
            let socials = $(".right_block");
            let langSwitcher = $(".lang-switcher").removeClass("lang-switcher").addClass("lang-switcher-mobile");
            let secondaryMenu = $(".secondary-menu");
            let mobileContainer = $(".sub-header .container");

            $("#navbarCollapse").css('top' , collapsedMenuPosition);
            rightBlock.prepend(searchForm);
            collapsedMenu.append(subHeader);
            subHeader.append(socials);
            //subHeader.prepend(secondaryMenu);
        }
    })
</script>
<!-- End Facebook Pixel Code -->
<?php if ( $is_map_project ) : ?>
		<?php get_template_part( 'parts/header-v2' ); ?>
<?php else : ?>

<header class="site-header">
    <?php if ( ( function_exists( 'the_ad_placement' ) ) && ( placement_has_ads( 'top-header-ad' ) ) ) : ?>
		<div class="container-fluid slidstvo_header_ad">
			<div class="container">
                <?php the_ad_placement('top-header-ad');  ?>
			</div>
		</div>
    <?php endif; ?>
	<div class="nav-main-nav">
		<div class="site-branding container">
			<nav class="navbar">
			<?php if ( is_front_page() ) { ?>
				<div class="navbar-brand" href="/">
					<img class="site-logo" src="<?php echo esc_url( $slidstvo_info['logo']['url'] ); ?>" alt="<?php echo esc_html( $slidstvo_info['logo']['alt'] ); ?>" title="<?php echo esc_html( $slidstvo_info['logo']['title'] ); ?>">
					<img class="site-logo mobile" src="<?php echo esc_url( $slidstvo_info['logo_mobile']['url'] ); ?>" alt="<?php echo esc_html( $slidstvo_info['logo_mobile']['alt'] ); ?>" title="<?php echo esc_html( $slidstvo_info['logo_mobile']['title'] ); ?>">
				</div>
			<?php } else { ?>
				<a class="navbar-brand" href="/">
					<img class="site-logo" src="<?php echo esc_url( $slidstvo_info['logo']['url'] ); ?>" alt="<?php echo esc_html( $slidstvo_info['logo']['alt'] ); ?>" title="<?php echo esc_html( $slidstvo_info['logo']['title'] ); ?>">
					<img class="site-logo mobile" src="<?php echo esc_url( $slidstvo_info['logo_mobile']['url'] ); ?>" alt="<?php echo esc_html( $slidstvo_info['logo_mobile']['alt'] ); ?>" title="<?php echo esc_html( $slidstvo_info['logo_mobile']['title'] ); ?>">
				</a>
			<?php } ?>
			</nav>
			<div class="menu-right">
				<div class="right_block">
					<div class="form-inline secondary-menu">
                        <?php
                        wp_nav_menu(
                            [
                                'theme_location' 	=> 'top-navigation',
                                'depth'          	=> 2,
                                'container' 		=> false,
                                'menu_class'    	=> '',
                                'fallback_cb'     	=> '__return_false',
                                'items_wrap'     	=> '<ul id="%1$s" class="navbar-nav mt-sm-0 %2$s">%3$s</ul>',
                                'walker' 			=> new bootstrap_4_walker_nav_menu(),
                            ]
                        );
                        ?>
					</div>
					<form id="searchform" method="get" action="<?php echo home_url('/'); ?>" class="mobile">
						<input type="text" class="search-field" name="s" placeholder="<?php esc_html_e( 'Search', 'slidstvo-info-theme' ); ?>" value="<?php the_search_query(); ?>">
						<input type="submit" value="Search" hidden>
						<a href="#" class="search-toggler"></a>
					</form>
				</div>
				<div class="mobile-right">
					<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
				</div>
			</div>
		</div>
		<div class="main-nav-wrapper">
			<div class="container">
				<div class="main-nav" style="">
					<div class="social">
                        <?php CC_Functions::showSocialProfiles(); ?>
					</div>
					<div class="main-navigation">
						<div class="secondary-nav mobile">
                            <?php
                            wp_nav_menu(
                                [
                                    'theme_location' 	=> 'top-navigation',
                                    'depth'          	=> 2,
                                    'container' 		=> false,
                                    'menu_class'    	=> '',
                                    'fallback_cb'     	=> '__return_false',
                                    'items_wrap'     	=> '<ul id="%1$s" class="navbar-nav mt-sm-0 %2$s">%3$s</ul>',
                                    'walker' 			=> new bootstrap_4_walker_nav_menu(),
                                ]
                            );
                            ?>
						</div>
						<div class="specprojects-btn mobile">
							<a href="/special-projects/">Спецпроєкти</a>
						</div>
                        <?php
                        wp_nav_menu(
                            [
                                'theme_location' 	=> 'sub-header-navigation',
                                'depth'          	=> 2,
                                'container' 		=> false,
                                'menu_class'    	=> '',
                                'fallback_cb'     	=> '__return_false',
                                'items_wrap'     	=> '<ul id="%1$s" class="navbar-nav">%3$s</ul>',
                                'walker' 			=> new bootstrap_4_walker_nav_menu(),
                            ]
                        ); ?>
						<div class="social mobile">
                            <?php CC_Functions::showSocialProfiles(); ?>
						</div>
					</div>
					<div class="main-nav-right">
						<form id="searchform" method="get" action="<?php echo home_url('/'); ?>" class="desktop">
							<input type="text" class="search-field" name="s" placeholder="<?php esc_html_e( 'Search', 'slidstvo-info-theme' ); ?>" value="<?php the_search_query(); ?>">
							<input type="submit" value="Search" hidden>
							<a href="#" class="search-toggler"></a>
						</form>
                        <?php /*
						<div class="specprojects-btn">
							<a href="/slidstvo_club/"><?php esc_html_e( 'Слiдство-клуб', 'slidstvo-info-theme' ); ?></a>
						</div>
                        */ ?>
					</div>
				</div>
			</div>
		</div>
</header>

<?php endif; ?>

<main>
    <?php if ( !is_front_page() ) { ?>
        <div class="breadcrumbs-wrap">
            <div class="container breadcrumbs">
                <?php
                if ( function_exists('yoast_breadcrumb') ) {
                    yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
                }
                ?>
            </div>
        </div>
    <?php } ?>
