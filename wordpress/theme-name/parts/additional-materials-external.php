<?php
global $post;
$additional_materials = CC_Functions::getAdditionalMaterials( $post->ID );
?>

<?php if ( ! empty( $additional_materials ) && is_array( $additional_materials ) ) : ?>


		<div class="related-posts">

			<div class="container-fluid">

				<div class="row">

					<?php foreach ( $additional_materials as $additional_material ) : ?>

						<article class="col-lg-4 col-md-6">

							<a href="<?php echo get_permalink( $additional_material->ID ); ?>" title="<?php echo get_the_title( $additional_material ); ?>" class="image_link">

								<div class="image">
									<?php echo get_the_post_thumbnail( $additional_material->ID, 'thumbnails-vertical' ); ?>
									<h2><?php echo get_the_title( $additional_material ); ?></h2>
								</div>


								<p class="excerpt"><?php echo the_excerpt_max_charlength( 120, $additional_material->ID ); ?></p>

							</a>

						</article>

				<?php endforeach; ?>

			</div>

		</div>

	<?php endif; ?>
