<?php

    $new_posts = (new WP_Query([
            'post_type' => ['news', 'articles', 'blogs', 'animation'],
            'posts_per_page' => '15',
            'post__not_in' => [get_the_ID()],
    ]))->get_posts();
?>

<div class="new-materials">
    <!--<h2><?php esc_html_e( 'New posts', 'slidstvo-info-theme' ); ?></h2>-->

    <?php foreach ($new_posts as $new_post) : ?>

    <article class="new-material-article">
        <h2><a href="<?= get_post_permalink($new_post->ID) ?>"><?= get_the_title($new_post->ID) ?></a></h2>
	    <span class="date"><?= get_the_date("d.m.Y", $new_post->ID) ?></span>
    </article>
    <?php endforeach; ?>
</div>
