<?php
global $post;
$additional_materials = CC_Functions::getAdditionalMaterials( $post->ID );
?>

<?php if ( ! empty( $additional_materials ) && is_array( $additional_materials ) ) : ?>

<?php $additional_materials = array_slice($additional_materials, 0, 3); ?>

	<div class="additional-materials">

		<div class="container-fluid">

			<h2><?php esc_html_e( 'Additional materials', 'slidstvo-info-theme' ); ?></h2>

			<div class="row">

				<?php foreach ( $additional_materials as $additional_material ) : ?>

					<article class="col-md-4">

						<a href="<?php echo get_permalink( $additional_material->ID ); ?>" title="<?php echo get_the_title( $additional_material ); ?>" class="image_link">

							<h2><?php echo get_the_title( $additional_material ); ?></h2>

							<p class="excerpt"><?php echo the_excerpt_max_charlength( 95, $additional_material->ID ); ?></p>

							<p class="post_date"><?php echo get_the_date( '', $additional_material ); ?></p>

						</a>

					</article>

			<?php endforeach; ?>

			</div>

		</div>

	</div>

<?php endif; ?>
