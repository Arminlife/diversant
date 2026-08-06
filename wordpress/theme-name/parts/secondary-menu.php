<div class="form-inline mt-md-0 secondary-menu">
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
