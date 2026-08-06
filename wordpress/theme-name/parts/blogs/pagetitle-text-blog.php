<?php if ( is_singular( ['news', 'investigations', 'special-projects', 'articles', 'blogs' ] ) ) : ?>


	<div class="page-title-text-blog">
		<div class="post-meta">
			<div class="container">
				<h1><?php CC_Functions::showPageTitle( $post ); ?></h1>
			</div>
		</div>
		<div class="post-thumbnail">
			<img src="<?= get_the_post_thumbnail_url($post->ID) ?>"  alt="<?php CC_Functions::showPageTitle( $post ); ?>">
		</div>
		<div class="container slidstvo-post-meta">
			<div class="author">

                <?php showAuthors(); ?>

			</div>

			<div class="date">

                <?php echo get_the_date( '' ); ?>

			</div>
		</div>
	</div>

<?php endif; ?>
