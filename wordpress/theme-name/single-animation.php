<?php

/*
* Template name: single-animation-blog
* */?>

<?php
    get_header();
?>

<div class="container">
	<div class="row">
		<div class="col-lg-8">
			<div class="pagetitle">
                <?php get_template_part( 'parts/pagetitle-animation' ); ?>
			</div>

			<div id="single-animation-content">
				<div  class="post-content">
                    <article id="post-<?php the_ID(); ?>" class="post-<?php the_ID(); ?> status-publish hentry">
	                    <div class="socials">
                            <?php CC_Functions::showSocialProfiles(); ?>
	                    </div>
	                    <div class="content">
                            <?php the_content(); ?>
	                    </div>
                    </article>
                    <?php get_template_part('parts/post-bottom-article')?>
                    <?php /*
					<div class="support-team">
						<a href="/pidtrymaty/">Підтримати команду Слідства.Інфо</a>
					</div>
					*/ ?>
				</div>
			</div>
		</div>
		<div class="col-lg-4 pl-lg-5">
			<aside class="single-post-sidebar">
                <?php get_sidebar('single-animation')?>
			</aside>
		</div>
	</div>
</div>
<?php get_template_part('parts/previous-animations' ); ?>
<?php get_template_part('parts/forms-bottom');?>

<?php get_footer(); ?>

