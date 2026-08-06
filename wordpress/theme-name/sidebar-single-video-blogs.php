<?php
    $posts = (new WP_Query([
        'post_type'     => 'blogs',
        'posts_per_page' => '3',
        'post__not_in' => [get_the_ID()],
    ]))->get_posts();
?>

<div class="previous-blog-sidebar">
    <!--<h2><?php esc_html_e( 'Previous blogs', 'slidstvo-info-theme' ); ?></h2>-->
    <?php foreach($posts as $post): ?>
	<article class="new-material-article">
		<div class="img-wrap">
			<a href="<?= get_post_permalink($post->ID) ?>">
				<img src="<?= get_the_post_thumbnail_url($post->ID) ?>">
			</a>
		</div>
		<h3><a href="<?= get_post_permalink( $post->ID ) ?>"><?= $post->post_title ?></a></h3>
		<span class="date"><?= date("d.m.Y", strtotime($post->post_date)) ?></span>
	</article>
    <?php endforeach; ?>
</div>
