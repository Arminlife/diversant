<?php if ( is_singular( ['news', 'investigations', 'special-projects', 'articles', 'blogs', 'warnews', 'english-stories'] ) ) : ?>

	<?php $thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>
	<script>
		jQuery(document).ready(function($){
			var titleTop = $(".page-title").offset();
			$(".page-title").css('height' , 'calc(80vh - ' + titleTop.top + 'px)');
		})
	</script>
	<div class="page-title">
		<?php the_post_thumbnail( 'full' ); ?>
		<div class="post-meta">
			<div class="container">
				<h1><?php CC_Functions::showPageTitle( $post ); ?></h1>
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
