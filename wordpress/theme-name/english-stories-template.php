<?php

/*
* Template name: english-stories
* */
get_header();
?>

<?php // set neccessary classes to body tag ?>
<script>
	jQuery(document).ready(function($) {
		$('body').addClass('archive post-type-archive post-type-archive-articles');
	});
</script>

<?php
// get "English stories"
$args = [
	'limit'				=> -1,
	'posts_per_page'	=> 10,
	'post_type'			=> 'articles',
	'tax_query'			=> [
        [
            'taxonomy'  => 'tags',
            'field'     => 'slug',
            'terms'     => 'english-stories'
        ]
    ]
];
$english_stories	= get_posts( $args );
$query				= new WP_Query( $args );
//echo '<br>english_stories:<pre>' . print_r( $english_stories, true ) . '</pre>';
?>

<div class="container list">

    <?php if ( $english_stories ) { ?>

        <?php //foreach( $english_stories as $story ) { ?>
        <?php while ( $query->have_posts() ) { $query->the_post(); ?>

            <article id="post-<?php echo $story->ID; ?>" class="row post-<?php echo $story->ID; ?> status-<?php echo get_post_status( $story ); ?> hentry">

                <?php if ( has_post_thumbnail( $story ) ) {
                    $class = 'col-lg-9'; ?>

                    <div class="col-lg-3 col-md-12 p-lg-0 pb-sm-4">

                        <a href="<?php the_permalink( $story ); ?>" title="<?php the_title_attribute( $story ); ?>" >

                            <?php echo get_the_post_thumbnail( $story, 'thumbnails-vertical' ); ?>

                        </a>

                    </div>

                <?php } else {
                    $class = 'col-lg-12';
                } ?>

                <div class="<?php echo $class; ?> col-md-12">

                    <a href="<?php the_permalink( $story ); ?>" title="<?php echo get_the_title( $story ); ?>"><h2><?php echo get_the_title( $story ); ?></h2></a>

                    <p class="excerpt"><?php echo get_the_excerpt( $story->ID ); ?></p>

                    <p class="post_date"><?php echo get_the_date( 'd.m.Y', $story ); ?></p>

                </div>

            </article>

        <?php } ?>

        <nav class="navigation pagination" role="navigation">

            <?php
            $GLOBALS['wp_query']->max_num_pages = $query->max_num_pages; // to make pagination work in template 
            CC_Functions::showPagination(); 
            ?>

        </nav>

    <?php } ?>

</div>

<?php get_footer(); ?>