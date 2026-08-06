<div class="main-nav " style="">
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
    <div class="right_block">

        <form id="searchform" method="get" action="<?php echo home_url('/'); ?>">
            <input type="text" class="search-field" name="s" placeholder="<?php esc_html_e( 'Search', 'slidstvo-info-theme' ); ?>" value="<?php the_search_query(); ?>">
            <input type="submit" value="Search" hidden>
            <a href="#" class="search-toggler"></a>
        </form>
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

        <?php if ( function_exists( 'pll_the_languages' ) ) : ?>
        <?php if (1 == $slidstvo_info['show_language_switcher']): ?>

        <ul class="lang-switcher"><?php pll_the_languages( array( 'hide_if_empty' => 0 ) );?></ul>

        <?php endif; ?>
        <?php endif; ?>

        <div class="social">
            <?php CC_Functions::showSocialProfiles(); ?>
        </div>
    </div>

