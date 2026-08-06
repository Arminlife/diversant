<?php
	global $post;
	$related_posts = CC_Functions::getAdditionalMaterialsSpecialProjects( $post->ID );
	?>

	<?php if ( ! empty( $related_posts ) && is_array( $related_posts ) ) : ?>

	<div class="related-posts">

		<div class="container-fluid">

			<h2><?php esc_html_e( 'Other important materials', 'slidstvo-info-theme' ); ?></h2>

			<div class="row">

				<?php foreach ( $related_posts as $related_post ) : ?>

					<article class="col-lg-4 col-md-6">

						<a href="<?php echo get_permalink( $related_post->ID ); ?>" title="<?php echo get_the_title( $related_post ); ?>" class="image_link">

							<div class="image">
								<?php echo get_the_post_thumbnail( $related_post->ID, 'thumbnails-vertical' ); ?>
								<h2><?php echo get_the_title( $related_post ); ?></h2>
							</div>


							<p class="excerpt"><?php echo the_excerpt_max_charlength( 120, $related_post->ID ); ?></p>

						</a>

					</article>

			<?php endforeach; ?>

		</div>

	</div>

<?php endif; ?>
