<?php
/*
 * Template name: slidstvo-club
 * */
?>
<?php get_header(); ?>
<?php $slImage = get_field('sl-image');  ?>
<div style='background-image: url("<?php echo $slImage['url']; ?>")'
     class="sclub-top">
    <div class="sclub-top__content">
        <h1><?php echo wp_kses_post(get_field('sl-header')); ?></h1>
        <a href="#"><?php echo get_field('sl-btn-text'); ?></a>
    </div>
</div>

<div class="sclub-members s-section">
    <div class="container">
        <div class="sclub-members__wrapper">
            <h2 class="s-header"><?php echo get_field('members-header'); ?></h2>

            <div class="sclub-members-items">

                <div class="sclub-members-item"><?php echo wp_kses_post(get_field('members-left')); ?>
                </div>
                <div class="sclub-members-item"><?php echo wp_kses_post(get_field('members-right')); ?>
                </div>
                <!--                <p class="read-more"><a href="#" class="button">Read More</a></p>-->

            </div>


<!--            <a target="_blank" class="btn read-more" href="/slidstvo_club/member-club/">Читати більше  <span><i class="fas fa-chevron-right"></i></span>  </a>-->

        </div>
    </div>

</div>

<div class="sclub-feed s-section">
    <div class="container">
        <div class="sclub-feed__wrapper">
            <h2 class="s-header"> <?php echo get_field('feed-header'); ?> </h2>
            <?php if (have_rows('members-items')): ?>

                <div class="owl-members owl-theme">
                    <?php while (have_rows('members-items')) : the_row(); ?>
                        <div class="owl-members__content">
                            <?php
                            $name = get_sub_field('member-name');
                            $text = get_sub_field('member-text');
                            $image = get_sub_field('member-image');
                            ?>
                            <div class="owl-members__group">
                                <img src="<?php echo $image['url'] ?>" alt="<?php echo $name; ?>">
                                <h4><?php echo $name; ?></h4>
                            </div>
                            <p>
                                <?php echo $text; ?>
                            </p>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<div id="sclub-payment" class="sclub-payment">
    <?php if(get_field('m-background-image')): ?>
    <div style="background-image: url(<?php echo get_field('m-background-image')['url']; ?>)" class="sclub-payment__bg"></div>
    <?php endif; ?>
    <div class="sclub-payment__content s-section">
        <h2 class="s-header"><?php echo get_field('payment-header'); ?></h2>
        <?php echo do_shortcode('[show_donation_form]'); ?>
    </div>
</div>

<div class="sclub-patreon">
    <div class="sclub-patreon__content">
        <h2>Долучитися до <br/> спільноти на BuyMeaCoffee</h2>
        <a target="_blank" href="https://www.buymeacoffee.com/slidstvo.info">
            <img src="/wp-content/uploads/2023/06/photo_2023-06-09_12-03-25.jpg">
        </a>
    </div>
</div>

<div class="slidstvo-club-content">
    <div class="container">
        <div class="slidstvo-club-pages">
            <div class="slidstvo-club-item">
                <?php
                $chapter1 = get_field('chapter-1');
                $chapter2 = get_field('chapter-2');
                $chapter3 = get_field('chapter-3');
                ?>
                <div class="image">
                    <a href="/pro-nas/">
                        <img src="<?php echo $chapter1['url'] ?>" alt="">
                    </a>
                </div>
                <a class="link" href="/pro-nas/">
                    <h2 class="block-title">Відверто про нас</h2>
                </a>
            </div>
            <div class="slidstvo-club-item">

                <div class="image">
                    <a href="/slidstvo_club/victory">
                        <img src="<?php echo $chapter2['url'] ?>" alt="">
                    </a>
                </div>
                <a class="link" href="/slidstvo_club/victory">
                    <h2 class="block-title">Наші перемоги</h2>
                </a>
            </div>
            <div class="slidstvo-club-item">

                <div class="image">
                    <a href="/funding/">
                        <img src="<?php echo $chapter3['url'] ?>" alt="">
                    </a>
                </div>
                <a class="link" href="/funding/">
                    <h2 class="block-title">Фінансові питання</h2>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="thanks">
    <h2 class="s-header"><?php echo get_field('support-title'); ?></h2>
    <?php if (have_rows('support-top')): ?>
        <ul id="thanks-ticker" class="thanks-ticker">
            <?php while (have_rows('support-top')) : the_row(); ?>
            <li> <?php echo get_sub_field('support-top-name') ?></li>
            <?php endwhile; ?>
        </ul>
    <?php endif; ?>
    <!--    <ul id="thanks-ticker-second" class="ticker">-->
    <!--        --><?php //while (have_rows('support-bottom')) : the_row(); ?>
    <!--            <li class="victories-outline"> -->
    <?php //echo get_sub_field('support-bottom-name') ?><!-- <span></span></li>-->
    <!--        --><?php //endwhile; ?>
    <!--    </ul>-->
</div>

<?php get_footer(); ?>
