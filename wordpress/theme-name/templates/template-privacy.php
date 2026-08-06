<?php
/*
 * Template Name: Text page
 * Template Post Type: page
 */

get_header();
?>
	<section class="section article">
		<div class="section__decor"><span></span></div>
		<div class="section_in">
			<div class="article__content">
				<h1 class="article__title"><?php echo the_title(); ?></h1>
				<?php
				while ( have_posts() ) : the_post();
					the_content();
				endwhile;
				?>
			</div>
		</div>
	</section>
<?php
get_footer();
