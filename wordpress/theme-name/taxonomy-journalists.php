<?php get_header(); ?>

<div class="container main-info">

	<div class="row">

		<?php
			$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            $photo = get_field('wpcf-photo', $term);
            $facebook_link = get_field('wpcf-facebook_link', $term);
            $instagram_link = get_field('wpcf-instagram_link', $term);
            $twitter_link = get_field('wpcf-twitter_link', $term);
            $telegram_link = get_field('wpcf-telegram_link', $term);
			$post = get_field( 'wpcf-post' , $term );
			$description = term_description();
		?>

		<div class="col-lg-4 col-md-6">

            <?php if( !empty( $photo ) ): ?>
                <div class="journalist-photo">
                    <img src="<?php echo esc_url($photo); ?>" alt="<?php echo $term->name; ?>" />
                </div>
            <?php endif; ?>

			<div class="journalist-socials">
				<?php if ( ! empty( $facebook_link ) ) : ?>
					<a href="<?php echo $facebook_link; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
				<?php endif; ?>

				<?php if ( ! empty( $instagram_link ) ) : ?>
					<a href="<?php echo $instagram_link;  ?>" target="_blank"><i class="fab fa-instagram"></i></a>
				<?php endif; ?>

				<?php if ( ! empty( $twitter_link ) ) : ?>
					<a href="<?php echo $twitter_link; ?>" target="_blank"><i class="fab fa-twitter"></i></a>
				<?php endif; ?>

				<?php if ( ! empty( $telegram_link ) ) : ?>
					<a href="<?php echo $telegram_link;  ?>" target="_blank"><i class="fab fa-telegram-plane"></i></a>
				<?php endif; ?>
			</div>

		</div>

		<div class="col-lg-8 col-md-6">

			<h1><?php echo $term->name; ?></h1>

			<?php if ( ! empty( $post ) ) : ?>

				<span class="journalist-post"><?php echo $post; ?></span>

			<?php endif; ?>

			<?php if ( ! empty( $description ) ) : ?>

				<div class="journalist-description"><?php echo $description; ?></div>

			<?php endif; ?>

		</div>

	</div>
</div>

		<?php if ( have_posts() ) : ?>
			<div class="container-fluid related-posts">
				<div class="container">
					<h2><?php esc_html_e( 'Author\'s materials', 'slidstvo-info-theme' ); ?></h2>
					<div class="row">

					<?php while ( have_posts() ) : the_post(); ?>

						<article class="col-lg-4 col-md-6">

							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="image_link">
									<div class="image">
										<?php if ( has_post_thumbnail() ) : ?>
											<?php the_post_thumbnail( 'thumbnails-vertical' ); ?>
										<?php endif; ?>
										<h2><?php the_title(); ?></h2>
									</div>

								<p class="excerpt"><?php echo the_excerpt_max_charlength( 250, $post->ID ); ?></p>

							</a>

						</article>

					<?php endwhile; ?>

				</div>

			<nav class="navigation pagination" role="navigation">

				<?php CC_Functions::showPagination(); ?>

			</nav>

		</div>
	</div>
		<?php endif; ?>

<?php get_footer(); ?>
