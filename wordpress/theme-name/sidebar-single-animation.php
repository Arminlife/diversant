<?php

$video_blogs = (new WP_Query([
    'post_type' => [ 'blogs'],
    'posts_per_page' => '100',
    'meta_query'	=> [
		'relation'		=> 'AND',
		[
			'key'	 	=> 'blog_type',
			'value'	  	=> array('1'),
			'compare' 	=> 'NOT IN',
		],
	]
]))->get_posts();

$videos = (new WP_Query([
    'post_type' => [ 'video'],
    'posts_per_page' => '100',
]))->get_posts();

$posts = new WP_Query();
$posts->posts = array_merge( $video_blogs, $videos );
$posts = array_slice($posts->posts, 0 , 12);


//var_dump($posts->get_posts());
?>

<div class="recent-animations">
    <!--<h2><?php esc_html_e( 'Video blogs and videos', 'slidstvo-info-theme' ); ?></h2>-->
    <?php foreach ($posts as $post) : ?>
    <article>
        <div class="img-wrap">
            <a href="<?= get_post_permalink($post->ID) ?>">
                <img src="<?= get_the_post_thumbnail_url($post->ID) ?>">
            </a>
        </div>
        <h3><a href="<?= get_post_permalink($post->ID) ?>"><?= get_the_title($post->ID) ?></a></h3>
    </article>
    <?php endforeach; ?>
    <?php wp_reset_query() ?>
</div>
