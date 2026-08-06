<?php
/*
 * Template name: funding-page
 * */
?>
<?php get_header(); ?>


<?php $fbgImage = get_field('funding_background_image'); ?>
<div style="background-image: url(<?php echo $fbgImage['url'] ?>)" class="funding-bg">
    <?php $fundingHeader = get_field('funding_header'); ?>
    <div class="container">
        <h4 class="funding-bg__header"><?php echo $fundingHeader; ?></h4>
    </div>
</div>
<div class="container">
    <div class="funding">
        <?php $title = get_field('funding_items_title'); ?>
        <div class="funding-header">
            <h3><?php echo $title; ?></h3>
        </div>


        <div class="funding-items">
            <div class="funding-item">
                <?php $text = get_field('funding_text'); ?>
                <?php echo $text; ?>
            </div>
        </div>

        <!--		<div class="funding-items">-->
        <!--        --><?php //if (have_rows('funding')): ?>
        <!--            --><?php //while (have_rows('funding')) : the_row(); ?>
        <!--					<div class="funding-item">-->
        <!--                        --><?php //$text = get_sub_field('funding_text'); ?>
        <!--						<div class="funding-item__text">-->
        <!--							<p> --><?php //echo $text; ?><!--</p>-->
        <!--						</div>-->
        <!--					</div>-->
        <!--			--><?php //endwhile;?>
        <!--		</div>-->
        <!--		--><?php //endif;?>

        <div class="partners">
            <div class="funding-header">
                <h3>Наші партнери</h3>
            </div>
            <?php if (have_rows('partners-items')): ?>
                <div class="partners-items">
                    <?php while (have_rows('partners-items')) : the_row(); ?>
                        <?php $image = get_sub_field('partners-item'); ?>
                        <?php $link = get_sub_field('partners-link'); ?>
                        <div class="partners-item">
                            <a target="_blank" href="<?php echo $link ?>"> <img src="<?php echo $image['url'] ?>"
                                                                                alt=""> </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php get_footer(); ?>
