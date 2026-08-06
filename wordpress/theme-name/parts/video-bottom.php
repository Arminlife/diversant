<div class="post-bottom">
	<?php
    // get three main tags for this post
    $popular_tags = wp_get_object_terms( get_the_ID(), 'tags', [
        'orderby'   => 'count',
        'order'     => 'DESC',
        'number'     => 3
    ] );
    if ( $popular_tags ) {
        echo '<div class="popular_tags_wrapper" style="font-size: 20px;">';
        $pop_tags_output = [];
        foreach ( $popular_tags as $term ) {
            $pop_tags_output[] = '<a class="popular_tags_link" style="color: #b3292d;" href="/tags/' . $term->slug . '">' . $term->name . '</a>';
        }
        $pop_tags_output = implode( ', ', $pop_tags_output );
        echo esc_html( 'Теги: ', 'slidstvo-info-theme' ) . $pop_tags_output;
        echo '</div>';
    }
    ?>
    <div class="bottom-social">
        <?php echo do_shortcode('[easy-social-share buttons="facebook,twitter" sharebtn_style="icon" counters=0 style="icon" message="yes" point_type="simple"]'); ?>
    </div>
</div>
<?php dynamic_sidebar('post-bottom-subscribe'); ?>
