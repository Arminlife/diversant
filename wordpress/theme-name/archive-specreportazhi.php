<?php

/*
* Template name: archive-specreportazhi
* */
get_header();
?>

<?php
// get "Special reports"
$spec_reps = get_posts(
	[
		'numberposts'	=> -1,
		'post_type'		=> 'video',
		'tax_query'		=> [
            [
                'taxonomy'  => 'tags',
                'field'     => 'slug',
                'terms'     => 'spetsreportazh'
            ]
        ]
	]
);
//echo '<br>spec reps:<pre>' . print_r( $spec_reps, true ) . '</pre>';
?>

<?php // set neccessary classes to body tag ?>
<script>
	jQuery(document).ready(function($) {
		$('body').addClass('archive post-type-archive post-type-archive-video');
	});
</script>



<div class="container list other-videos ">

	<?php if ( $spec_reps ) { ?>

		<h2><?php esc_html_e( 'Спецрепортажi', 'slidstvo-info-theme' ); ?></h2>

		<div class="row">

			<?php foreach( $spec_reps as $specrep ) { ?>

				<article id="post-<?php echo $specrep->ID; ?>" class="col-lg-3 col-md-6 col-sm-6 post-<?php echo $specrep->ID; ?> status-<?php echo get_post_status( $specrep ); ?> hentry">

					<?php if ( has_post_thumbnail( $specrep ) ) { ?>

						<a href="<?php the_permalink( $specrep ); ?>" title="<?php the_title_attribute( $specrep ); ?>" >

							<?php echo get_the_post_thumbnail( $specrep, 'film-poster' ); ?>

						</a>

					<?php } ?>

					<a href="<?php the_permalink( $specrep ); ?>" title="<?php echo get_the_title( $specrep ); ?>"><h2><?php echo get_the_title( $specrep ); ?></h2></a>

					<?php
						$year = get_post_meta( $specrep->ID, 'wpcf-video-year', true );
						$long = get_post_meta( $specrep->ID, 'wpcf-video-long', true );
					?>

					<div class="video-meta">

						<?php if ( ! empty( $year ) ) : ?>

							<span class="video-meta-year"><?php echo esc_html( $year ) . ', '; ?></span>

						<?php endif; ?>

						<?php if ( ! empty( $year ) ) : ?>

							<span class="video-meta-long"><?php echo esc_html( $long ); ?> <?php esc_html_e( 'min', 'slidstvo-info-theme' ); ?></span>

						<?php endif; ?>

					</div>

				</article>

			<?php } ?>

		</div>

		<nav class="navigation pagination" role="navigation">

			<?php CC_Functions::showPagination(); ?>

		</nav>

	<?php } ?>
</div>

<?php get_footer(); ?>