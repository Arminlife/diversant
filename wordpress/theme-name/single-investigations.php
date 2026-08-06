<?php get_header(); ?>

<?php get_template_part( 'parts/pagetitle' ); ?>

<div class="container narrow-container">

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" class="post-<?php the_ID(); ?> status-publish hentry">

				<?php the_content(); ?>

			</article>

		<?php endwhile; ?>

	<?php endif; ?>

	<?php get_template_part( 'parts/post-bottom-news' ); ?>


</div>
<?php echo do_shortcode( '[show_donation_form]' ); ?>
<?php get_template_part( 'parts/related-posts' ); ?>

<?php get_footer(); ?>
