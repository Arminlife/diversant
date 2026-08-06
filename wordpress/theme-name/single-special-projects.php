<?php get_header(); ?>
<?php $external_link = get_post_meta( get_the_ID(), 'wpcf-external-link', true );?>
<?php

	// if external project – do not show post top meta
?>
<?php
if ( empty( $external_link ) ) {
	get_template_part( 'parts/pagetitle' );
} else {
	get_template_part( 'parts/pagetitle-external' );
}
?>

<?php
	$is_map_project = get_field('is_map_project');
?>

<?php if (!$is_map_project) : ?>
<br>
<div class="container narrow-container">
<?php endif; ?>

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php
			$custom_blocks = '';
			$main_content = get_the_content();

			if ($is_map_project) {
				$custom_shortcodes = apply_filters('custom_wpbakery_blocks', []);

				if (!empty($custom_shortcodes)) {
					$pattern = '/\[(' . implode('|', $custom_shortcodes) . ')[^\]]*\](?:[^\[]*\[\/\1\])?/s';

					if (preg_match_all($pattern, $main_content, $matches)) {
						$custom_blocks = implode('', $matches[0]);
						foreach ($matches[0] as $shortcode) {
							$main_content = str_replace($shortcode, '', $main_content);
						}
					}
				}
			}
			?>

			<article id="post-<?php the_ID(); ?>" class="post-<?php the_ID(); ?> status-publish hentry">
				<?php
					// if external project – do not show post summary
				?>
				<?php if ( empty( $external_link ) ) : ?>
					<p>
						<i><?php showAuthors(); ?></i>
					</p>
				<?php endif; ?>
				<?php if ($is_map_project) : ?>
					<?php echo do_shortcode(apply_filters('the_content', $main_content)); ?>
				<?php else : ?>
					<?php the_content(); ?>
				<?php endif; ?>

			</article>

			<?php if ($is_map_project && !empty($custom_blocks)) : ?>
				<?php echo do_shortcode($custom_blocks); ?>
			<?php endif; ?>

		<?php endwhile; ?>

	<?php endif; ?>

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
        //echo esc_html( 'Теги: ', 'slidstvo-info-theme' ) . $pop_tags_output;
        echo $pop_tags_output;
        echo '</div>';
    }
    ?>

	<?php if ( ! empty( $external_link ) ) : ?>

		<div class="external-link">

			<a href="<?php echo esc_url( $external_link ); ?>" class="btn btn-primary" target="_blank"><?php esc_html_e( 'Visit project site', 'slidstvo-info-theme' ); ?></a>

		</div>

	<?php endif; ?>
	<?php
		// if external project – do not show bottom post meta
	?>
	<?php if ( empty( $external_link ) ) : ?>
		<?php get_template_part( 'parts/post-bottom' ); ?>
	<?php endif; ?>

<?php if (!$is_map_project) : ?>
</div>
<?php endif; ?>

<?php // echo do_shortcode( '[show_donation_form]' ); ?>

<br>

<?php
if ( !$is_map_project ) {
	if ( empty( $external_link ) or 2 > 1 ){
		get_template_part( 'parts/related-posts-special-projects' );
	} else {
		get_template_part( 'parts/additional-materials-external' );
	}
}
?>

<?php get_footer(); ?>
