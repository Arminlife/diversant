<?php

$latest_posts = (new WP_Query([
    'post_type'         => 'english-stories',
    'offset'            => '1',
    'posts_per_page'    => '12',
]))->get_posts();

?>

<div class="recent-articles">
    <!--<h2><?php esc_html_e( 'Other posts', 'slidstvo-info-theme' ); ?></h2>-->

    <?php foreach ($latest_posts as $latest_post) : ?>
        <article>
            <div class="img-wrap">
                <a href="<?= get_post_permalink($latest_post->ID) ?>">
                    <img src="<?= get_the_post_thumbnail_url($latest_post->ID, 'thumbnails-vertical') ?> ">
                </a>
            </div>
            <h3><a href="<?= get_post_permalink($latest_post->ID) ?>"><?= get_the_title($latest_post->ID) ?></a></h3>
        </article>
    <?php endforeach; ?>

</div>
