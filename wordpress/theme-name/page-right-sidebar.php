<?php
/*
 Template Name: Page with right sidebar
 */
?>

<?php get_header(); ?>

	<?php if ( ! is_front_page() ) : ?>

		<?php get_template_part( 'parts/pagetitle' ); ?>

	<?php endif; ?>

	<div class="container">
		<div class="row">
			<div class="col-sm-9">
				<?php
					/* Start the Loop */
					while ( have_posts() ) :

						the_post();

						the_content();

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}

					endwhile; // End of the loop.
				?>
			</div>

			<div class="col-sm-3">
				<?php dynamic_sidebar( 'main-sidebar' ); ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>
