<?php
/*
 * Template name: Top topics
 * */
?>

<?php get_header(); ?>

<?php
    global $wp_query;
    $wp_query = new WP_Query(
        [
            'posts_per_page'	=> 10,
            'post_type'		=> ['news', 'articles', 'warnews', 'english-stories'],
	        'paged' => get_query_var('paged') ? get_query_var('paged') : 1, // страница пагинации
            'meta_query' 	=> [
                [
                    'key' 	=> 'wpcf-main_post',
                    'value' => '1'
                ]
            ],
        ]
    );
?>

<div class="container list">

    <?php if ( have_posts() ) : ?>

        <?php while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" class="row post-<?php the_ID(); ?> status-<?php echo get_post_status(); ?> hentry" style="margin-bottom: 30px;">

                <?php if ( has_post_thumbnail() ):
                    $class = 'col-lg-9'?>

                    <div class="col-lg-3 col-md-12 p-0">

                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >

                            <?php the_post_thumbnail( 'thumbnails-vertical' ); ?>

                        </a>

                    </div>

                <?php else:
                    $class = 'col-lg-12';
                endif; ?>

                <div class="<?php echo $class; ?> col-md-12">

                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><h2><?php the_title(); ?></h2></a>

                    <p class="excerpt"><?php echo get_the_excerpt( $post->ID ); ?></p>

                    <p class="post_date"><?php echo get_the_date(); ?></p>

                </div>

            </article>

        <?php endwhile; ?>

        <nav class="navigation pagination" role="navigation">

            <?php CC_Functions::showPagination(); ?>

        </nav>

    <?php endif; ?>
</div>

<?php get_footer(); ?>

