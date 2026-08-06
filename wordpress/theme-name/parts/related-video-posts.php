<?php
global $post;
$term_id = wp_get_post_terms($post->ID, "tags", ['fields' => 'all'])[0]->term_id ;
$related_posts = CC_Functions::getVideoRelatedPosts( $term_id)->get_posts() ;


?>

<?php if ( ! empty( $main_additional_material ) && is_array( $main_additional_material ) ) : ?>

		<article class="main_additional_material">
				<div class="image">
					<a href="<?php echo get_permalink( $main_additional_material[0]->ID ); ?>" title="<?php echo get_the_title( $main_additional_material[0] ); ?>" class="image_link">
						<?php echo get_the_post_thumbnail( $main_additional_material[0]->ID, 'full' ); ?>
					</a>
					<div class="container-fluid">

							<div class="main_material_text">
								<a href="<?php echo get_permalink( $main_additional_material[0]->ID ); ?>" title="<?php echo get_the_title( $main_additional_material[0] ); ?>" class="image_link">
									<h2><?php echo get_the_title( $main_additional_material[0] ); ?></h2>
								</a>
								<p class="excerpt">
									<?php echo the_excerpt_max_charlength( 220, $main_additional_material[0]->ID ); ?>
								</p>
							</div>
					</div>
				</div>

		</article>

<?php endif; ?>
<?php if ( ! empty( $related_posts ) && is_array( $related_posts ) ) : ?>

	<div class="related-posts">

		<div class="container-fluid">

			<h2><?php esc_html_e( 'Related posts', 'slidstvo-info-theme' ); ?></h2>

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
	</div>

<?php endif; ?>
