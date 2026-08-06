<?php
/*
 * Template name: our-victory-page
 * */

?>

<?php get_header(); ?>

<?php $bgImage = get_field('awards-background-image'); ?>
<div style="background-image: url(<?php echo $bgImage['url'] ?>)" class="victories-bg">
    <?php $awardsHeader = get_field('awards-header'); ?>
    <h4 class="victories-bg__header"><?php echo $awardsHeader; ?></h4>
</div>


<div class="victories">
    <div class="container">
        <div class="victories-wrapper">
            <div class="victories-items">
                <?php if (have_rows('awards')): ?>
                    <?php while (have_rows('awards')) : the_row(); ?>
                        <div class="victories-item">
                            <?php
                            $title = get_sub_field('award-title');
                            $image = get_sub_field('award-image');
                            $description = get_sub_field('award-description');
                            ?>
                            <div
                                    class="victories-item__bg">
                                <img src="<?php echo $image['url']; ?>" alt="">
                            </div>
                            <div class="victories-item__description">
                                <h4> <?php echo $title; ?> </h4>
                                <p><?php echo $description; ?></p>
                            </div>

                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
