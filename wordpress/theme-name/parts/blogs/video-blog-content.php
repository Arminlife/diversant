<div id="single-video-blog-content">
    <div class="post-content">
        <article id="post-<?php the_ID(); ?>" class="post-<?php the_ID(); ?> status-publish hentry">
	        <div class="socials">
                <?php CC_Functions::showSocialProfiles(); ?>
	        </div>
	        <div class="content">
                <?php the_content() ?>
	        </div>
        </article>
        <?php get_template_part('parts/post-bottom-article')?>
	    <div class="support-team">
		    <a href="/pidtrymaty/">Підтримати команду Слідства.Інфо</a>
	    </div>
    </div>
</div>


