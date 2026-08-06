<?php if ( is_singular( ['news', 'investigations', 'special-projects', 'articles', 'blogs', 'animation', 'warnews', 'english-stories' ] ) ) : ?>
    <div class="page-title-default">
        <div class="post-meta">
	        <h1><?php CC_Functions::showPageTitle( $post ); ?></h1>
        </div>
        <div class="post-thumbnail">
            <?php /* <img src="<?= get_the_post_thumbnail_url($post->ID, 'thumbnails-vertical') ?>"  alt="<?php CC_Functions::showPageTitle( $post ); ?>"> */ ?>
            <img src="<?= get_the_post_thumbnail_url($post->ID, 'large') ?>"  alt="<?php CC_Functions::showPageTitle( $post );?>">
        </div>

        <?php
        // get main photo description
        $main_photo_description = get_post_meta( $post->ID, 'wpcf-main-photo-description', true );
        if ( @$_GET['test'] == 'photo' ) {
            echo "\n" . '<br>post meta:<pre>' . print_r( get_post_meta( $post->ID ), true ) . '</pre>' . "\n";
        }
        if ( $main_photo_description ) {
            ?>
            <div class="main_photo_description">
                <?php echo $main_photo_description; ?>
            </div>
            <?php
        }
        ?>

        <div class="container slidstvo-post-meta">
            <div class="author">

                <?php showAuthors(); ?>

            </div>

            <div class="date">

                <?php echo get_the_date( '' ); ?>

            </div>
        </div>
    </div>
<?php endif; ?>
