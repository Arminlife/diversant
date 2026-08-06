<?php get_header(); ?>

<?php
	$year = get_post_meta( get_the_ID(), 'wpcf-video-year', true );
	$long = get_post_meta( get_the_ID(), 'wpcf-video-long', true );
	$authors = get_post_meta( get_the_ID(), 'video_authors', true );

	if ( is_array( $authors ) ) {

		$authors = get_terms(
			[
				'taxonomy'      => 'journalists',
			//	'object_ids'    => null,
				'include'       => $authors,
				'fields'        => 'id=>name',
				'childless'     => false,
			]
		);
	}

	if ( ! empty( $authors ) ) {

		$_authors= [];

		foreach( $authors as $id => $name ) {

			$_authors[] = sprintf(
				'<a href="%s" title="%s">%s</a>',
				esc_url( get_term_link( $id, 'journalists' ) ),
				esc_html( $name ),
				esc_html( $name )
			);
		}
	}
?>

<div class="container">

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" class="post-<?php the_ID(); ?> status-publish hentry">
				<div class="row post-content">
					<div class="col-xl-3 col-lg-4 col-md-5 film-poster">
						<?php echo get_the_post_thumbnail( ); ?>
					</div>
					<div class="col-xl-9 col-lg-8 col-md-7 post-text">
						<div class="video-title">
							<h1><?php the_title(); ?></h1>

							<div class="video-meta">

								<?php if ( ! empty( $year ) ) : ?>

									<span class="video-meta-year"><?php echo esc_html( $year ) . ', '; ?></span>

								<?php endif; ?>

								<?php if ( ! empty( $year ) ) : ?>

									<span class="video-meta-long"><?php echo esc_html( $long ); ?> <?php esc_html_e( 'min', 'slidstvo-info-theme' ); ?></span>

								<?php endif; ?>

								<?php if ( ! empty( $_authors ) ) : ?>

									<div class="credits">

										<p><?php echo implode( ', ', $_authors ) ?></p>

									</div>

								<?php endif; ?>
								<div class="video_description">
									<?php the_content(); ?>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-12">
						<?php get_template_part( 'parts/embed-video' ); ?>
					</div>
				</div>
			</article>

		<?php endwhile; ?>

	<?php endif; ?>

	<?php get_template_part( 'parts/video-bottom' ); ?>

</div>


<?php
get_template_part( 'parts/related-video-posts' );
?>
<div class="video_donate container">
	<?php echo do_shortcode( '[show_donation_form]' ); ?>
</div>


<?php get_footer(); ?>
