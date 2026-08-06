<?php get_header(); ?>

<?php
$queried_object = get_queried_object();
if ( isset( $queried_object->name ) ) {
    $important_post = get_posts(
        [
            'numberposts'	=> 1,
            'post_type'		=> 'news',
            'meta_query' 	=> [
                [
                    'key' 	=> 'wpcf-main_post_type',
                    'value' => '1'
                ]
            ],
        ]
    );
}
?>
<div class="container only_mobile">
    <h1><?php echo $queried_object->label ?></h1>
</div>
<?php if ( ! empty( $important_post ) && is_array( $important_post ) ) : ?>

    <div class="important-post" style="background: #e8e8e8;">

        <div class="container">

            <div class="row">

                <div class="col-lg-6 col-md-12 p-0">

                    <a href="<?php echo get_permalink( $important_post[0]->ID ); ?>" title="<?php echo get_the_title( $important_post[0] ); ?>" class="image_link">

                        <span class="notice"><?php esc_html_e( 'Important', 'slidstvo-info-theme' ); ?></span>
                        <?php echo get_the_post_thumbnail( $important_post[0]->ID ); ?>

                    </a>

                </div>

                <div class="col-lg-6 col-md-12 post-text">

                    <a href="<?php echo get_permalink( $important_post[0]->ID ); ?>" title="<?php echo get_the_title( $important_post[0] ); ?>"><h2><?php echo get_the_title( $important_post[0] ); ?></h2></a>

                    <p class="excerpt"><?php echo get_the_excerpt( $important_post[0]->ID ); ?></p>

                    <p class="post_date"><?php echo get_the_date( '', $important_post[0] ); ?></p>


                </div>

            </div>

        </div>

    </div>

<?php endif; ?>

<div class="container list">

    <?php if ( have_posts() ) : ?>

        <?php while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" class="row post-<?php the_ID(); ?> status-<?php echo get_post_status(); ?> hentry">

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
