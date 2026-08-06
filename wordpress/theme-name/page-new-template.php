<?php /* Template Name: New Template */ ?>
<?php get_header(); ?>

<?php if ( ! is_front_page() ) : ?>

    <?php get_template_part( 'parts/pagetitle' ); ?>

<?php endif; ?>

<div class="container">

    <?php
    /* Start the Loop */
    while ( have_posts() ) :
        $params = [ 'param1' => get_field('new_template') ];

        the_post();

        the_content();

        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) {
            comments_template();
        }

    endwhile; // End of the loop.
    ?>

</div>
<div class="single">
    <div class="related-post-block">
        <?php get_template_part( 'parts/related-posts-new-template', null, $params ); ?>
    </div>
</div>

<?php get_footer(); ?>
