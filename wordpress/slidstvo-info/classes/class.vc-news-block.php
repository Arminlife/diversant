<?php
/**
 * VC News Block
 *
 * @file
 * @package		Slidstvo info
 * @author		Andrew Skochelias
 */

defined( 'ABSPATH' ) || die();

/**
 * Init Slidstvo_News_Block
 * */
class Slidstvo_News_Block extends WPBakeryShortCode {

	/**
	 * Constructor
	*/
    function __construct() {

        add_action( 'init', [ &$this, 'selectNewsBlock'] );
        add_shortcode( 'show_news_block', [ &$this, 'shortcode'] );
    }

	/**
	 * Init block.
	 *
	 * @return void.
	 */
    public function selectNewsBlock() {

		vc_map(
			[
				'name' 			=> esc_html__( 'Show news block', 'slidstvo-info' ),
				'base' 			=> 'show_news_block',
				'description' 	=> esc_html__( 'Show news block', 'slidstvo-info' ),
				'category' 		=> 'Slidstvo',
				'params' 		=> []
			]
		);
    }

	/**
	 * Shortcode.
	 *
	 * @return void.
	 */
    public function shortcode( $atts ) {

		// Get main news
        $top_posts = (new WP_Query([
            'post_type'     => [ 'articles', 'news', 'success-stories', 'warnews', 'english-stories' ],
            'meta_query'    => [
                [
                    'key'   => 'wpcf-main_post',
                    'value' => 1,
                ]
            ],
            'posts_per_page' => 3
        ]))->get_posts();

        // add kupyansk post to main top posts
        $kupyansk_id    = 38131;
        $kupyansk_post  = get_post( $kupyansk_id );

        // sort this array by post date
        foreach( $top_posts as $i => $post ) {
            // if post is older than kupyansk
            if ( get_the_date( 'U', $post ) < get_the_date( 'U', $kupyansk_post ) ) {
                array_splice( $top_posts, $i, 0, [ $kupyansk_post ] ); // insert kupyansk in that place
                unset( $top_posts[3] ); // remove last (4th) post
                break;
            }
        }

		// Get news
		$news = (new WP_Query( [
            'posts_per_page'    => 12,
			'post_type' 	    => 'news',
            'post_status'       => 'publish'
		]))->get_posts();

        // Get videos
        $video_posts = (new WP_Query([
            'posts_per_page'    => 3,
            'post_type' 	=> ['animation', 'video', 'blogs'],
            'meta_query'	=> [
                [
                    'key'	=> 'wpcf-main_post',
                    'value'	=> 1,
                ]
            ],
        ]))->get_posts();

        // banner
        $banner  = (new WP_Query([
            'name' => 'banner2',
            'post_status' => 'publish',
            'post_type' => 'banners',
            'posts_per_page' => '1',
        ]))->get_posts();

        $spec_projects  = (new WP_Query([
            'post_type' => 'special-projects',
            'posts_per_page' => '3',
        ]))->get_posts();

        ob_start();

		?>
            <script>
                jQuery(document).ready(function($){
                    setTimeout(function () {
                        // let mainArticle = $(".news-block-main-article .background");
                        // let width = mainArticle.outerWidth(true);
                        // let mainRatioHeight = (width / 4) * 3;
                        // mainArticle.css("height" , mainRatioHeight);
                        //
                        // let articleList = $(".news-block-articles-list");
                        // let buttonHeight = $(".btn-primary.more-news").outerHeight(true);
                        // let articleListEqualHeight = mainRatioHeight - 27 - buttonHeight;
                        // articleList.css("height" , articleListEqualHeight);
                        let articleList = $(".news-block-articles-list");
                        let buttonHeight = $(".btn-primary.more-news").outerHeight(true);
                        let articleListHeight = articleList.outerHeight(true) + 27 + buttonHeight;
                        let mainArticleRatioWidht =  articleListHeight / 3 * 4;
                        // $(".news-block-main-news").css("width" , mainArticleRatioWidht);

                    }, 0);

                });
            </script>

	    </script>

<div class="news-block">
    <div class="news-block-main-news">
		<?php /* <h1 class="news-block-title">Головне</h1> */ ?>
        <?php $i = 0; ?>

        <?php if ( @$_GET['test'] == 'kupyansk' ) { ?>
            <article id="news-<?php echo $kupyansk_id; ?>" class="news-block-main-article main-news-id-<?php echo $kupyansk_id; ?>">
                <div class="background">
                    <div class="image">
                        <a href="<?php the_permalink( $kupyansk_id ); ?>" title="<?php the_title_attribute( [ 'post' => $kupyansk_post ] ); ?>">
                            <?php echo get_the_post_thumbnail( $kupyansk_id, 'large' ); ?>
                        </a>
                    </div>
                </div>
                <a href="<?php the_permalink( $kupyansk_id ); ?>" title="<?php the_title_attribute( [ 'post' => $kupyansk_post ] ); ?>">
                    <h2><?php the_title_attribute( [ 'post' => $kupyansk_post ] ); ?></h2>
                    <p class="post_excerpt"><?php echo get_the_excerpt( $kupyansk_id ); ?></p>
                </a>
            </article>
            <?php $i++; ?>
        <?php } ?>

        <?php foreach( $top_posts as $post ) : ?>
            <?php //if ($i === 0) : ?>
            <?php if ($i < 3) : ?>
                <article id="news-<?= $post->ID; ?>" class="news-block-main-article main-news-id-<?= $post->ID; ?>">
                    <div class="background">
                        <div class="image">
                            <a href="<?= get_post_permalink($post->ID) ?>" title="Image<?= $post->ID; ?>">
                                <img src="<?= get_the_post_thumbnail_url($post->ID, 'large') ?>" alt="">
                            </a>
                        </div>
                    </div>
                    <a href="<?= get_post_permalink($post->ID) ?>" title="<?= $post->ID; ?>">
                        <h2><?= get_the_title($post->ID) ?></h2>
                        <p class="post_excerpt"><?= get_the_excerpt( $post ); ?></p>
                    </a>
                </article>
                <?php $i++; ?>
                <?php /* <div class='news-block-top-three'> */ ?>
            <?php else: ?>
                <article id="news-<?= get_post_permalink($post->ID) ?>">
                    <div class="top-three-item">
                        <div class="img-wrap">
                            <a href="<?= get_post_permalink($post->ID) ?>">
                                <img src="<?= get_the_post_thumbnail_url($post->ID, 'large') ?>" alt="Top-<?= get_post_permalink($post->ID) ?>">
                            </a>
                        </div>
                        <div class="top-three-text">
                            <a href="<?= get_post_permalink($post->ID) ?>" >
                                <h3 class="top-news-title"><?= get_the_title($post->ID) ?></h3>
                                <p class="post_excerpt"><?= mb_substr(get_the_excerpt( $post ),0 , 90); ?>..</p>
                            </a>
                        </div>
                    </div>
                </article>
            <?php endif; ?>
        <?php endforeach; ?>
            <div style="margin-top: 10px;">
                <a href="/top-temy" class="btn btn-primary more-news">Читати більше</a>
            </div>
		<?php /* </div> */ ?>
    </div>


	<div class="news-block-right-col">
		<div class="news-block-articles">
			<?php /* <h1 class="news-block-title">Новини</h1> */ ?>
			<div class="news-block-articles-list">
                <?php foreach( $news as $post ) : ?>
                    <article id="news-<?= $post->ID; ?>" class="news-block-article news-id-<?= $post->ID; ?>">
                        <span class="date">
                            <?php
                                $date = (new DateTime ($post->post_date))->format("d m Y, H:i");

                                $_monthsList = array (
                                    " 01 " => " січня ",
                                    " 02 " => " лютого ",
                                    " 03 " => " березня ",
                                    " 04 " => " квітня ",
                                    " 05 " => " травня ",
                                    " 06 " => " червня ",
                                    " 07 " => " липня ",
                                    " 08 " => " серпня ",
                                    " 09 " => " вересня ",
                                    " 10 " => " жовтень ",
                                    " 11 " => " листопада ",
                                    " 12 " => " грудня "
                                );
                                $month = " ".explode(" ", $date)[1]. " ";
                                echo $date = str_replace($month, $_monthsList[$month], $date);
                            ?>
                        </span>
                        <a href="<?= get_post_permalink($post->ID) ?>" title="<?= get_the_title($post->ID) ?>">
                            <h2><?= get_the_title($post->ID) ?></h2>
                        </a>
                    </article>
                <?php endforeach; ?>
			</div>
			<a href="/news" class="btn btn-primary more-news">Читати більше</a>
		</div>

		<div class="news-video-block">
			<?php /* <h1 class="news-block-title">Відео</h1> */ ?>
            <?php $i = 0; ?>
            <?php foreach( $video_posts as $post ) : ?>
                <?php //if ($i === 0) : ?>
                <div class="video-block-main">
                    <div class="video-thumb">
                        <a href="<?= get_post_permalink($post->ID) ?>"><img src="<?= get_the_post_thumbnail_url($post->ID, 'medium_large') ?>" alt="Top-<?= $post->ID; ?>"></a>
                    </div>
                        <a href="<?= get_post_permalink($post->ID) ?>">
							<h2><?= get_the_title($post->ID) ?></h2>
                            <p class="post_excerpt"><?= mb_substr(get_the_excerpt( $post ),0 , 200); ?></p>
                        </a>
                </div>
                <?php $i++; ?>
                <?php /* else:  ?>
                <div class="video-blocks">
                    <div class="video-thumb">
                        <a href="<?= get_post_permalink($post->ID) ?>"><img src="<?= get_the_post_thumbnail_url($post->ID) ?>" alt="Top-<?= $post->ID; ?>"></a>
                    </div>
                    <h3><a href="<?= get_post_permalink($post->ID) ?>"><?= get_the_title($post->ID) ?></a></h3>
                </div>
                <?php endif;*/ ?>
            <?php endforeach; ?>

            <div>
                <a style="margin-bottom: 30px; margin-top: -20px;" href="/video/" class="btn btn-primary more-news">Дивитися більше</a>
            </div>

            <?php if ( $banner[0]->ID ) { ?>
			<div class="banner" id="war_banner" style="overflow: hidden;">
				<a href="<?= get_field("banner_url", $banner[0]->ID) ?>">
					<img src="<?= get_the_post_thumbnail_url($banner[0]->ID) ?>" alt="Pidtrimati">
				</a>
			</div>
            <?php } ?>

            <?php /*
			<div class="specprojects-right-block">
				<h1 class="news-block-title">Спецпроекти</h1>
				<div id="js-specproject-slider" class="owl-carousel-1 owl-carousel owl-theme">
                    <?php foreach ($spec_projects as $post) : ?>
                        <article class="special-project" id="special-project-<?= $post->ID ?>">
                            <div class="background image">
                                <img src="<?= get_the_post_thumbnail_url($post->ID) ?>" alt="Posipaki">
                            </div>
                            <a href="<?= get_post_permalink($post->ID) ?>" title="Посіпаки"><h2><?= get_the_title($post->ID) ?></h2></a>
                        </article>
					<?php endforeach; ?>
				</div>
			</div>
            */ ?>

		</div>
	</div>
</div>






        <?php

		$html = ob_get_contents();

		ob_end_clean();

		return $html;
	}
}

new Slidstvo_News_Block();