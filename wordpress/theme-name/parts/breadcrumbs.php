<?php $delimiter = '<span class="delimiter">&nbsp;&gt;&nbsp;</span>'; ?>
<div class="breadcrumbs">
	<div itemprop="breadcrumb" class="breadcrumbs_inner">

		<a href="/"><?php esc_html_e( 'Home', 'slidstvo-info-theme' ); ?></a><?php echo $delimiter; ?>

		<?php
			if ( is_page() ) {

				// Show parent pages
				CC_Functions::showParentPages( $post, $delimiter );

				// Show curent page title
				echo '<span class="current">' . esc_html( $post->post_title ) . '</span>';
			} elseif ( is_archive() ) {

				// Show archive title
				$queried_object = get_queried_object();

				if ( isset( $queried_object->label ) ) {

					echo '<span class="current">' . esc_html( $queried_object->label ) . '</span>';
				}
			} elseif( is_single() ) {

				// Get post type object
				$post_type = get_post_type_object( $post->post_type );

				// Show archive title
				if ( $post_type ) {

					echo '<a href="' . esc_url( get_post_type_archive_link( $post->post_type ) ) . '">' . esc_html( $post_type->labels->name ) . '</a>' . $delimiter;
				}

				// Show curent page title
				echo '<span class="current">' . esc_html( $post->post_title ) . '</span>';
			}
		?>

	</div>
</div>
