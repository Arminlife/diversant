<?php get_header(); ?>

<div class="container">
	<div class="row">
		<div class="col-lg-7 mr-lg-5">
			<?php get_template_part( 'parts/pagetitle-default' ); ?>
			<?php $video = get_post_meta( get_the_ID(), 'wpcf-video-url', true ); ?>

			<div id="single-article-content">

					<div class="post-content">
                        <?php if ( have_posts() ) : ?>

                            <?php while ( have_posts() ) : the_post(); ?>

								<article id="post-<?php the_ID(); ?>" class="post-<?php the_ID(); ?> status-publish hentry">

									<div class="socials">
                                        <?php if ( function_exists( 'pvc_get_post_views' ) ) { ?>
                                            <?php $post_views = pvc_get_post_views( get_the_ID() ); ?>
                                            <div class="post_views_front" style="font-size: 12px; margin-bottom: 10px;">
                                                <img style="width: 14px; margin-right: 2px; vertical-align: baseline;" src="<?php bloginfo('template_directory')?>/img/ico_eye.svg">
                                                <span class="post_views_quantity_front"><?php echo $post_views; ?></span>
                                            </div>
                                        <?php } ?>

                                        <?php CC_Functions::showSocialProfiles(); ?>
									</div>

                                    <?php if ( !empty($video) ) : ?>
										<script>
                                            jQuery(document).ready(function($) {
                                                // Find all YouTube videos
                                                var $allVideos = $("iframe[src^='//www.youtube.com']"),

                                                    // The element that is fluid width
                                                    $fluidEl = $("body");

                                                // Figure out and save aspect ratio for each video
                                                $allVideos.each(function() {

                                                    $(this)
                                                        .data('aspectRatio', this.height / this.width)

                                                        // and remove the hard coded width/height
                                                        .removeAttr('height')
                                                        .removeAttr('width');

                                                });

                                                // When the window is resized
                                                $(window).resize(function() {

                                                    var newWidth = $fluidEl.width();

                                                    // Resize all videos according to their own aspect ratio
                                                    $allVideos.each(function() {

                                                        var $el = $(this);
                                                        $el
                                                            .width(newWidth)
                                                            .height(newWidth * $el.data('aspectRatio'));

                                                    });

                                                    // Kick off one resize to fix all videos on page load
                                                }).resize();
                                            })
										</script>
										<div class="player">
                                            <?php
                                            $ytarray = explode( "/", $video );
                                            $ytendstring = end( $ytarray );
                                            $ytendarray = explode( "?v=", $ytendstring );
                                            $ytendstring = end( $ytendarray );
                                            $ytendarray = explode( "&", $ytendstring );
                                            $ytcode = $ytendarray[0];
                                            echo "<iframe width=\"420\" height=\"315\" src=\"http://www.youtube.com/embed/$ytcode\" frameborder=\"0\" allowfullscreen></iframe>";
                                            ?>
										</div>
                                    <?php endif; ?>
									<div class="content">
                                        <?php the_content(); ?>
									</div>

								</article>

                            <?php endwhile; ?>

                        <?php endif; ?>
                        <?php get_template_part( 'parts/post-bottom-article' ); ?>
                        <?php /*
						<div class="support-team">
							<a href="/pidtrymaty/">Підтримати команду Слідства.Інфо</a>
						</div>
                        */ ?>
					</div>

				</div>
		</div><!--//col-->
		<div class="col-lg-4 pr-lg-5">
			<aside class="single-post-sidebar">
                <?php get_sidebar('single-articles')?>
			</aside>
		</div><!--//col-->
	</div><!--//row-->
</div>


	<div class="related-post-block">
        <?php get_template_part( 'parts/related-posts' ); ?>
	</div>
<?php get_template_part('parts/forms-bottom');?>



<?php get_footer(); ?>
