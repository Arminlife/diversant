<?php
global $slidstvo_info;

//$journalists = the_terms( get_the_id(), 'journalists' );
?>

<div class="post-top">
    <div class="date">
        <?php echo get_the_date( '' ); ?>
    </div>
    <div class="bottom-social-article bottom-social">

        <?php echo do_shortcode('[easy-social-share buttons="facebook,twitter" sharebtn_style="icon" counters=0 style="icon" message="yes" point_type="simple"]'); ?>

        <?php if ( isset( $slidstvo_info['socials-contacts'] ) && is_array( $slidstvo_info['socials-contacts'] ) && ! empty( $slidstvo_info['socials-contacts'] ) ) : ?>

            <?php foreach ( $slidstvo_info['socials-contacts'] as $name => $url ) : ?>

                <?php if (( ! empty( $url ) ) && ( 'Telegram' == $name )) : ?>

                    <div class="right-block">
                        <a href="<?php echo $url; ?>" target="_blank"><i class="fab fa-telegram-plane"></i></a>
                        <div>
                            <?php esc_html_e( 'Join us', 'slidstvo-info-theme' ); ?>
                        </div>
                        <div class="g-ytsubscribe" data-channelid="UCjQb5B3c90fAKYd-LyWcXew" data-layout="default" data-count="default" class="youtube"></div>
                    </div>

                <?php endif; ?>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>
</div>

<div id="overlay">
    <div class="popup">
        <?php dynamic_sidebar('post-bottom-subscribe'); ?>
        <button class="close-modal" title="Закрыть"></button>
    </div>
</div>


