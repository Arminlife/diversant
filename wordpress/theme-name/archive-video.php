<?php get_header(); ?>

<?php /*
$queried_object = get_queried_object();
if ( isset( $queried_object->name ) ) {
	$main_post_type = get_posts(
		[
			'numberposts'	=> 1,
			'post_type'		=> $queried_object->name,
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

<?php if ( ! empty( $main_post_type ) && is_array( $main_post_type ) ) : ?>

<?php
	$year = get_post_meta( $main_post_type[0]->ID, 'wpcf-video-year', true );
	$long = get_post_meta( $main_post_type[0]->ID, 'wpcf-video-long', true );
	$authors = get_post_meta( $main_post_type[0]->ID, 'video_authors', true );

	if ( is_array( $authors ) ) {

		$authors = get_terms(
			[
				'taxonomy'      => 'journalists',
			//	'object_ids'    => null,
				'include'       => $authors,
				'fields'        => 'id=>name',
				'childless'     => false,
			]
		);
	}

	if ( ! empty( $authors ) ) {

		$_authors= [];

		foreach( $authors as $id => $name ) {

			$_authors[] = sprintf(
				'<a href="%s" title="%s">%s</a>',
				esc_url( get_term_link( $id, 'journalists' ) ),
				esc_html( $name ),
				esc_html( $name )
			);
		}
	}
?>

<div class="container only_mobile">
	<h1><?php echo $queried_object->label ?></h1>
</div>
<div class="important-post">

	<div class="container">

		<div class="row">

			<div class="col-md-5 col-sm-12 p-xs-0">

				<a href="<?php echo get_permalink( $main_post_type[0]->ID ); ?>" title="<?php echo get_the_title( $main_post_type[0] ); ?>" class="image_link">

					<?php echo get_the_post_thumbnail( $main_post_type[0]->ID ); ?>

				</a>

			</div>

			<div class="col-md-7 col-sm-12 post-text">

					<a href="<?php echo get_permalink( $main_post_type[0]->ID ); ?>" title="<?php echo get_the_title( $main_post_type[0] ); ?>"><h2><?php echo get_the_title( $main_post_type[0] ); ?></h2></a>

					<div class="video-meta">

						<?php if ( ! empty( $year ) ) : ?>

							<span class="video-meta-year"><?php echo esc_html( $year ) . ', '; ?></span>

						<?php endif; ?>

						<?php if ( ! empty( $year ) ) : ?>

							<span class="video-meta-long"><?php echo esc_html( $long ); ?> </span>

						<?php endif; ?>

						<?php if ( ! empty( $_authors ) ) : ?>

							<div class="credits">

								<p><?php echo implode( ', ', $_authors ) ?></p>

							</div>

						<?php endif; ?>

					</div>

					<p class="excerpt"><?php echo get_the_excerpt( $main_post_type[0]->ID ); ?></p>

					<a class="btn btn-primary" href="<?php echo get_permalink( $main_post_type[0]->ID ); ?>" title="<?php echo get_the_title( $main_post_type[0] ); ?>"><?php esc_html_e( 'View', 'slidstvo-info-theme' ); ?></a>

			</div>

		</div>

	</div>

</div>

<?php endif; */?>


<div class="container list other-videos">

	<script>
		jQuery(document).ready(function($) {
			$('article.col-lg-3').css('flex', '0 0 32%');
			$('article.col-lg-3').css('max-width', '32%');
		});
	</script>

	<?php
	// get "Blogs"
	$blogs = get_posts(
		[
			'numberposts'	=> 9,
			'post_type'		=> 'blogs',
		]
	);
	?>

	<?php // BLOGS section ?>

	<h2><?php esc_html_e( 'Блоги', 'slidstvo-info-theme' ); ?></h2>

	<div class="row" style="margin-bottom: 50px;">

		<?php foreach( $blogs as $blog_post ) { ?>

			<article id="post-<?php echo $blog_post->ID; ?>" class="col-lg-3 col-md-6 col-sm-6 post-<?php echo $blog_post->ID; ?> status-<?php echo get_post_status( $blog_post ); ?> hentry">

				<?php if ( has_post_thumbnail( $blog_post ) ) { ?>

					<a href="<?php the_permalink( $blog_post ); ?>" title="<?php the_title_attribute( $blog_post ); ?>" >

						<?php echo get_the_post_thumbnail( $blog_post, 'large' ); ?>

					</a>

				<?php } ?>

				<a href="<?php the_permalink( $blog_post ); ?>" title="<?php echo get_the_title( $blog_post ); ?>"><h2><?php echo get_the_title( $blog_post ); ?></h2></a>

				<?php
					$year = get_the_date( 'd.m.Y', $blog_post );
				?>

				<div class="video-meta">

					<?php if ( ! empty( $year ) ) : ?>

						<span class="video-meta-year"><?php echo esc_html( $year ); ?></span>

					<?php endif; ?>

				</div>

			</article>

		<?php } ?>

		<div class="more" style="position: relative; width: 100%; margin: -10px 50px 0px 0;">
			<a href="/blogs/" style="float: right;" class="btn btn-primary more-news"><?php esc_html_e( 'Всi блоги', 'slidstvo-info-theme' ); ?></a>
		</div>

	</div>

	<?php
	// get "VIDEOS"
	$videos = get_posts(
		[
			'numberposts'	=> 9,
			'post_type'		=> 'video',
			'tax_query'		=> [
	            [
	                'taxonomy'  => 'tags',
	                'field'     => 'slug',
	                'terms'     => [ 'spetsreportazh' ],
	                'operator'	=> 'NOT IN', // to exclude Special reports from Videos section
	            ]
	        ]
		]
	);
	
	//echo '<br>spec_reps:<pre>' . print_r( $spec_reps, true ) . '</pre>';
	?>
	<?php // VIDEOS section ?>
	<?php if ( $videos ) { ?>

		<h2><?php esc_html_e( 'Фiльми', 'slidstvo-info-theme' ); ?></h2>

		<div class="row">

			<?php foreach( $videos as $video_post ) { ?>

				<article id="post-<?php echo $video_post->ID; ?>" class="col-lg-3 col-md-6 col-sm-6 post-<?php echo $video_post->ID; ?> status-<?php echo get_post_status( $video_post ); ?> hentry">

					<?php if ( has_post_thumbnail( $video_post ) ) { ?>

						<a href="<?php the_permalink( $video_post ); ?>" title="<?php the_title_attribute( $video_post ); ?>" >

							<?php echo get_the_post_thumbnail( $video_post, 'large' ); ?>

						</a>

					<?php } ?>

					<a href="<?php the_permalink( $video_post ); ?>" title="<?php echo get_the_title( $video_post ); ?>"><h2><?php echo get_the_title( $video_post ); ?></h2></a>

					<?php
						$year = get_post_meta( $video_post->ID, 'wpcf-video-year', true );
						$long = get_post_meta( $video_post->ID, 'wpcf-video-long', true );
					?>

					<div class="video-meta">

						<?php if ( ! empty( $year ) ) : ?>

							<span class="video-meta-year"><?php echo esc_html( $year ) . ', '; ?></span>

						<?php endif; ?>

						<?php if ( ! empty( $year ) ) : ?>

							<span class="video-meta-long"><?php echo esc_html( $long ); ?> <?php esc_html_e( 'min', 'slidstvo-info-theme' ); ?></span>

						<?php endif; ?>

					</div>

				</article>

			<?php } ?>

			<div class="more" style="position: relative; width: 100%; margin: 10px 50px 30px 0;">
				<a href="/films/" style="float: right;" class="btn btn-primary more-news"><?php esc_html_e( 'Всi фiльми', 'slidstvo-info-theme' ); ?></a>
			</div>

		</div>

	<?php } ?>

	<?php
	// get "Special reports" first
	$spec_reps = get_posts(
		[
			'numberposts'	=> 9,
			'post_type'		=> 'video',
			'tax_query'		=> [
	            [
	                'taxonomy'  => 'tags',
	                'field'     => 'slug',
	                'terms'     => 'spetsreportazh'
	            ]
	        ]
		]
	);
	
	//echo '<br>spec_reps:<pre>' . print_r( $spec_reps, true ) . '</pre>';
	
	?>

	<?php // SPECREPORTAZHI section	?>

	<h2><?php esc_html_e( 'Спецрепортажi', 'slidstvo-info-theme' ); ?></h2>

	<div class="row" style="margin-bottom: 50px;">

		<?php foreach( $spec_reps as $specrep ) { ?>

			<article id="post-<?php echo $specrep->ID; ?>" class="col-lg-3 col-md-6 col-sm-6 post-<?php echo $specrep->ID; ?> status-<?php echo get_post_status( $specrep ); ?> hentry">

				<?php if ( has_post_thumbnail( $specrep ) ) { ?>

					<a href="<?php the_permalink( $specrep ); ?>" title="<?php the_title_attribute( $specrep ); ?>" >

						<?php echo get_the_post_thumbnail( $specrep, 'large' ); ?>

					</a>

				<?php } ?>

				<a href="<?php the_permalink( $specrep ); ?>" title="<?php echo get_the_title( $specrep ); ?>"><h2><?php echo get_the_title( $specrep ); ?></h2></a>

				<?php
					$year = get_post_meta( $specrep->ID, 'wpcf-video-year', true );
					$long = get_post_meta( $specrep->ID, 'wpcf-video-long', true );
				?>

				<div class="video-meta">

					<?php if ( ! empty( $year ) ) : ?>

						<span class="video-meta-year"><?php echo esc_html( $year ) . ', '; ?></span>

					<?php endif; ?>

					<?php if ( ! empty( $year ) ) : ?>

						<span class="video-meta-long"><?php echo esc_html( $long ); ?> <?php esc_html_e( 'min', 'slidstvo-info-theme' ); ?></span>

					<?php endif; ?>

				</div>

			</article>

		<?php } ?>

		<div class="more" style="position: relative; width: 100%; margin: -10px 50px 30px 0;">
			<a href="/specreportazhi/" style="float: right;" class="btn btn-primary more-news"><?php esc_html_e( 'Всi спецрепортажi', 'slidstvo-info-theme' ); ?></a>
		</div>

	</div>


</div>

<?php get_footer(); ?>
