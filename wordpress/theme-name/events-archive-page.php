<?php
    /*
     * Template name: events-archive-page
     * */
    get_header();

    $queried_object = get_queried_object();
    $year = isset($_GET['event_year']) ? (int)$_GET['event_year'] : date('Y') ;
    $posts = EventFunctions::getAllArchiveByYear($year);

?>

<div class="container">
    <h1><?= $queried_object->post_title . " ". $year ?></h1>
</div>

<div class="container list">

    <?php if ( !empty($posts) ) : ?>

        <?php foreach ( $posts as $post) :  ?>

            <article id="post-<?= $post->ID; ?>" class="row post-<?= $post->ID; ?> status-<?= $post->post_status; ?> hentry">

                <?php if ( has_post_thumbnail($post) ):
                    $class = 'col-lg-9'?>

                    <div class="col-lg-3 col-md-12 p-lg-0 pb-sm-4">

                        <a href="<?= get_post_permalink($post) ?>">

                            <?= get_the_post_thumbnail($post, 'film-poster' ); ?>

                        </a>

                    </div>

                <?php else:
                    $class = 'col-lg-12';
                endif; ?>

                <div class="<?= $class; ?> col-md-12">

                    <a href="<?= get_post_permalink($post); ?>" title="<?= $post->post_title; ?>"><h2><?= $post->post_title ?></h2></a>

                    <p class="excerpt"><?= $post->post_excerpt ?></p>

                    <p class="post_date"><?= EventFunctions::format_event_date($post) ?></p>

                </div>

            </article>
            <br>
        <?php endforeach; ?>


    <?php endif; ?>
</div>

<?php get_footer(); ?>
