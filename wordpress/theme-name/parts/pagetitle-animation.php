<div class="page-title-default">
	<div class="post-meta">
		<div class="container">
			<h1><?php CC_Functions::showPageTitle( $post ); ?></h1>
		</div>
	</div>
	<div class="post-thumbnail-animation">
        <?php
            $video_code = get_field("animation_video_code", get_the_ID());
            if (isset($video_code)) {
        ?>
            <div class="video">
                <iframe src="https://www.youtube.com/embed/<?= get_field('animation_video_code', $post->ID ) ?>" frameborder="0" width="100%" height="460"></iframe>
            </div>
        <?php
            } else {
        ?>
                <img src="<?= get_the_post_thumbnail_url($post->ID) ?>"  alt="<?php CC_Functions::showPageTitle( $post ); ?>">
        <?php
            }
        ?>
	</div>
	<div class="container slidstvo-post-meta">
		<div class="post-meta-wrapper">
			<div class="author">

                <?php showAuthors(); ?>

			</div>

			<div class="date">

                <?php echo get_the_date( '' ); ?>

			</div>
		</div>
	</div>
</div>
