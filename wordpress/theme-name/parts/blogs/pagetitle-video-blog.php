<?php if ( is_singular( ['blogs' ] ) ) : ?>

    <?php $thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>

        <div class="page-title-video-blog">
	        <div class="post-meta">
		        <div class="container">
			        <h1><?php CC_Functions::showPageTitle( $post ); ?></h1>
		        </div>
	        </div>

            <div class="video">
                <iframe src="https://www.youtube.com/embed/<?= get_field('blog_video_code', $post->ID ) ?>" frameborder="0"></iframe>
            </div>
	        <div class="container slidstvo-post-meta">
		        <div class="author">

                    <?php showAuthors(); ?>

		        </div>

		        <div class="date">

                    <?php echo get_the_date( '' ); ?>

		        </div>
	        </div>
        </div>
<?php elseif ( !is_page(  get_the_ID() ) ): ?>

    <div class="page-title">
        <div class="post-meta">
            <div class="container">
                <h1><?php CC_Functions::showPageTitle( $post ); ?></h1>
                <div class="social">
                    <?php echo do_shortcode('[easy-social-share buttons="facebook,twitter" sharebtn_style="icon" counters=0 style="icon" message="yes" point_type="simple"]'); ?>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>
