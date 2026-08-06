<?php get_header('story') ?>
<?php
$format = get_post_format();
if (false === $format)
    $format = 'standard';
?>
<article class="single-story">
    <div class="single-story__primary single-story-primary">
        <div class="single-story-primary__container">
            <?php
            if ($format === 'video') {
            ?>
                <div class="single-story-primary__video animate__animated animate__zoomIn">
                    <?php echo wp_kses_post(get_field('single-primary-video')); ?>
                </div>
            <?php
            } else {
            ?>
                <div class="single-story-primary__image animate__animated animate__zoomIn">
                    <div class="single-story-primary__bg" style="background-image: url('<?php the_post_thumbnail_url(); ?>')"></div>

                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <div class="single-story__content single-story-content">
        <div class="single-story-content-top">
            <div class="single-story-content-top__col">
                <h1 class="single-story-content-top__title animate__animated animate__fadeInLeft">
                    <?php the_title(); ?>
                </h1>
            </div>
            <div class="single-story-content-top__col">
                <div class="single-story-content-top__share single-story-content-top-share">
                    <span>Поділитися: </span>
                    <?php echo do_shortcode('[easy-social-share buttons="facebook,twitter" sharebtn_style="icon" counters=0 style="icon" message="yes" point_type="simple"]'); ?>
                </div>
            </div>
        </div>
        <div class="single-story-content__row">
            <div class="single-story-content__col">
                <div class="story-content">
                    <div class="story-content__top">
                        <div class="story-content__author">
                            <span>АВТОР: </span>
                            <!-- <?php the_author_posts_link() ?> -->
                            <span><?php showAuthors(); ?></span>
                        </div>
                        <div class="story-content__date">
                            <span><?php the_date(); ?></span>
                        </div>
                    </div>
                    <div class="story-content__body story-content-body">
                        <?php the_content(); ?>
                    </div>

                </div>
                <div class="story-content-subs">
                    <div class="story-content-subs__row">
                        <div class="story-content-subs__col">
                            <div class="story-content-subs__left subs-left">
                                <div class="subs-left__title story-content-subs--title">
                                    Слідкуйте за новинами в соціальних мережах
                                </div>
                                <div class="subs-left__social">
                                    <?php CC_Functions::showSocialProfiles(); ?>
                                </div>
                            </div>
                        </div>
                        <div class="story-content-subs__col">
                            <div class="story-content-subs__right subs-right">
                                <div class="subs-right__title story-content-subs--title">
                                    Підпишіться на розсилку «Слідство.Інфо»
                                </div>
                                <div class="subs-right__form">
                                    <?php dynamic_sidebar('post-bottom-subscribe'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single-story-content__col">
                <?php
                $curTerm = get_the_terms( get_the_ID(),'success-stories-category')[0]->term_id;
                $argsStories = array(
                    'posts_per_page' => 5,
                    'post_type' => 'success-stories',
                    'order' => 'DESC',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'success-stories-category',
                            'field' => 'term_id',
                            'terms' => $curTerm,
                        )
                    )
                );
                $queryStories = new WP_Query($argsStories);
                ?>

                <div class="single-story-content__sidebar story-sidebar">
                    <h5 class="story-sidebar__title">
                        ОСТАННІ НОВИНИ
                    </h5>
                    <ul class="story-sidebar__list">
                        <?php
                        // Цикл
                        if ($queryStories->have_posts()) {
                            while ($queryStories->have_posts()) {
                                $queryStories->the_post();
                        ?>
                                <li class="story-sidebar__item story-sidebar-item">
                                    <a href="<?php the_permalink() ?>" class="sidebar-thumbnails-wrap"><?php the_post_thumbnail()?></a>
                                    <a href="<?php the_permalink() ?>" class="story-sidebar-item__title"><?php echo get_short_title(80) ?></a>
                                    <p class="story-sidebar-item__date"><?php the_time("d F Y H:m"); ?></p>
                                </li>
                        <?php
                            }
                        } else {
                            // Постов не найдено
                        }

                        wp_reset_postdata();
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="single-story-same">
        <div class="single-story-same__container">
            <h4 class="single-story-same__title">
                СХОЖІ МАТЕРІАЛИ
            </h4>
            <div class="s-stories-posts">
                <?php
                $sameStories = array(
                    'posts_per_page' => 3,
                    'post_type' => 'success-stories',
                );
                $querySame = new WP_Query($sameStories);

                if ($querySame->have_posts()) {
                    while ($querySame->have_posts()) {
                        $querySame->the_post();
                        get_template_part('templates/success-stories-post');
                    }
                } else {
                    // Постов не найдено
                }
                // Возвращаем оригинальные данные поста. Сбрасываем $post.
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>
</article>

<?php get_template_part("templates/s-stories-popup")?>

<?php get_footer() ?>