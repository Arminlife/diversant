<?php

/*
* Template name: archive-success-stories
* */
get_header();
$customPageID = get_page_by_path( 'success-stories-page' );
?>
<?php $sstoriesImg = get_field('sstoriesImg', $customPageID);
?>

<div class="s-stories">
    <div class="s-stories__top" style='background-image: url("<?php echo $sstoriesImg['url']; ?>")'>
        <div class="container">
            <div class="s-stories__headline">
                <h1 class="s-stories__title animate__animated animate__bounceInDown">ІСТОРІЇ УСПІХУ</h1>
                <p class="s-stories__slogan one active animate__animated animate__fadeInLeft"><?php echo get_field('sstories_slogan_vdalosya', $customPageID) ?></p>
                <p class="s-stories__slogan two"><?php echo get_field('sstories_slogan_vdastsa', $customPageID) ?></p>
                <p class="s-stories__slogan two"><?php echo get_field('sstories_slogan_hto-dopomozhe', $customPageID) ?></p>
            </div>

            <?php
                $cat_args = array(
                    'orderby'       => 'term_id',
                    'order'         => 'DESC',
                    'hide_empty'    => true,
                );
                $terms = get_terms('success-stories-category', $cat_args);
//                var_dump($terms); ?>


            <ul class="s-stories__tabs">
                <?php
                $index  = 0;
                foreach($terms as $taxonomy){
                    $term_slug = $taxonomy->slug;
                    $term_name = $taxonomy->name;
                    $term_id = $taxonomy->term_id;
                    ?>
                <li class="s-stories__tab">
                    <a href="" class="s-stories__tab-link <?php
                        if($index == 0) {
                            echo 'active';
                        } else {
                            echo '';
                        }
                    ?>" data-slug="<?php echo $term_slug?>" data-index="<?php echo $index;?>" data-id="<?php echo $term_id?>"><?php echo $term_name?></a>
                </li>
                <?php $index++; } ?>
            </ul>

        </div>
    </div>
    <?php
    $firstTerm;
    foreach($terms as $taxonomy) {
        $firstTerm = $taxonomy->term_id;
        break;
    }
    $posts_array = new WP_Query (
        array(
            'posts_per_page' => 6,
            'post_type' => 'success-stories',
            'post_status'    => 'publish',
            'paged' => 1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'success-stories-category',
                    'field' => 'term_id',
                    'terms' => $firstTerm,
                )
            )
        )
    );
    ?>


        <div class="s-stories-posts" data-id="<?php echo $term_id?>">
        <?php
            if($posts_array->have_posts()) {
                while ( $posts_array->have_posts() ) {
                    $posts_array->the_post();
                    get_template_part('templates/success-stories-post');
                } wp_reset_postdata();
            } else {
                echo '';
            }
        ?>

        </div>


    <a href="#" data-id="2174" class="load-more-btn s-stories-posts__load-more-btn">ПОКАЗАТИ БІЛЬШЕ ІСТОРІЙ</a>

    <div class="s-stories-bottom-block">
        <div class="container">
            <div class="s-stories-bottom-block__wrapper">
                <div class="s-stories-bottom-block__logos">
                    <h2 class="s-stories-bottom-block__stn-title"><?php echo get_field('section_title_about_project', $customPageID) ?></h2>
                    <?php if (have_rows('logotypes', $customPageID)): ?>
                    <?php while (have_rows('logotypes', $customPageID)) : the_row(); ?>
                            <?php $logo_image = get_sub_field('logo-image'); ?>
                            <div class="s-stories-bottom-block__logo">
                                <img src="<?php echo $logo_image ?>" alt="">
                            </div>
                    <?php endwhile; endif; ?>
                </div>
                <div class="s-stories-bottom-block__content">
                    <h3 class="s-stories-bottom-block__headline"><?php echo get_field('about_subheading', $customPageID) ?></h3>
                    <div class="s-stories-bottom-block__text"><?php echo get_field('about-text', $customPageID) ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="s-stories-bottom-block">
        <div class="container">
            <div class="s-stories-bottom-block__wrapper">
                <div class="s-stories-bottom-block__contacts">
                    <h2 class="s-stories-bottom-block__headline contacts-headline">Залишилися питання?</h2>
                    <div class="s-stories-bottom-block__phone">
                        <span class="s-stories-bottom-block__labels">Телефон</span>
                        <a href="tel:<?php echo get_field('phone_number', $customPageID) ?>" class="s-stories-bottom-block__contacts-link"><?php echo get_field('phone_number', $customPageID) ?></a>
                    </div>
                    <div class="s-stories-bottom-block__email">
                        <span class="s-stories-bottom-block__labels">Поштова скринька</span>
                        <a href="mailto:<?php echo get_field('s-stories-email', $customPageID) ?>" class="s-stories-bottom-block__contacts-link"><?php echo get_field('s-stories-email', $customPageID) ?></a>
                    </div>
                </div>
                <div class="s-stories-bottom-block__content">
                    <h3 class="s-stories-bottom-block__stn-title">Інструкції як подати свою історію</h3>
                    <div class="s-stories-bottom-block__text">
                        <?php echo get_field('s-stories-instructions', $customPageID) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="s-stories-bottom-block">
        <div class="container">
            <div class="s-stories-bottom-block__wrapper">
                <div class="s-stories-bottom-block__wwh-contact">
                    <h2 class="s-stories-bottom-block__stn-title"><?php echo get_field('section_title_who_will_help', $customPageID) ?></h2>
                    <div class="s-stories-bottom-block__phone">
                        <span class="s-stories-bottom-block__labels">Телефон</span>
                        <a href="tel:<?php echo get_field('phone_number', $customPageID) ?>" class="s-stories-bottom-block__contacts-link"><?php echo get_field('phone_number', $customPageID) ?></a>
                    </div>
                    <div class="s-stories-bottom-block__email">
                        <span class="s-stories-bottom-block__labels">Поштова скринька</span>
                        <a href="mailto:<?php echo get_field('s-stories-email', $customPageID) ?>" class="s-stories-bottom-block__contacts-link"><?php echo get_field('s-stories-email', $customPageID) ?></a>
                    </div>
                </div>
                <div class="s-stories-bottom-block__content initiatives">
                    <h3 class="s-stories-bottom-block__headline"><?php echo get_field('who_will_help_subheading', $customPageID) ?></h3>
                    <div class="s-stories-bottom-block__text"><?php echo get_field('s_stories_initiatives', $customPageID) ?></div>
                </div>
            </div>
            <div class="s-stories-bottom-block__wrapper the-second-block">
                <div class="s-stories-bottom-block__logos">
                    <h2 class="s-stories-bottom-block__stn-title"><?php echo get_field('section_title_about_project', $customPageID) ?></h2>
                    <?php if (have_rows('logotypes',$customPageID)): ?>
                        <?php while (have_rows('logotypes', $customPageID)) : the_row(); ?>
                            <?php $logo_image = get_sub_field('logo-image'); ?>
                            <div class="s-stories-bottom-block__logo">
                                <img src="<?php echo $logo_image ?>" alt="">
                            </div>
                        <?php endwhile; endif; ?>
                </div>
                <div class="s-stories-bottom-block__content">
                    <h3 class="s-stories-bottom-block__headline"><?php echo get_field('about_subheading', $customPageID) ?></h3>
                    <div class="s-stories-bottom-block__text"><?php echo get_field('about-text', $customPageID) ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_template_part("templates/s-stories-popup")?>

<?php get_footer()?>
