<?php
$previous_blogs = (new WP_Query([
    'post_type' => 'animation',
    'posts_per_page' => '3',
    'offset' => '1',
]))->get_posts();
?>


<div class="previous-animations">
    <div class="container-fluid">

        <h2><?php esc_html_e("Previous animations", "slidstvo-info-theme") ?></h2>

        <div class="row">
            <?php foreach ($previous_blogs as $previous_blog): ?>
                <article class="col-lg-4 col-md-6">
                    <a href="<?= get_post_permalink($previous_blog->ID) ?>" class="image_link">
                        <div class="image">
                            <img src="<?= get_the_post_thumbnail_url($previous_blog->ID, 'thumbnails-vertical') ?>" alt="<?= get_the_title($previous_blog->ID) ?>" >
                            <h2><?= get_the_title($previous_blog->ID) ?></h2>
                        </div>
                        <p class="excerpt"><?= the_excerpt_max_charlength(120, $previous_blog->ID) ?></p>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>

    </div>
</div>

