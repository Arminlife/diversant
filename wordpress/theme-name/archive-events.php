<?php
global $wp;
$current_url = home_url(add_query_arg(array($_GET), $wp->request));

$form_data = CC_Functions::processPartnerForm();
if ($form_data['success'] === true) {
    wp_redirect($current_url . '#partner-form-success');
    exit;
}

get_header();

$years = EventFunctions::getAllEventYears();

$previous_event = EventFunctions::getPreviousEvent();
$current_event = EventFunctions::getCurrentEvent();
$next_event = EventFunctions::getNextEvent();
$partners = EventFunctions::getAllPartners();
$event_posts = EventFunctions::getAllPostMarkedLikeEvent();
if(!$current_event){
	$current_event = $previous_event;
}

?>

<div class="container">
	<div class="row">
		<div class="col-xl-6 col-lg-7">
			<div class="events-block">
				<!--<h2>Події</h2>-->

				<div class="main-event-block">
					<div class="main-event-poster">
						<a href="<?= get_post_permalink($current_event->ID) ?>">
							<img src="<?=  wp_get_attachment_image_url(get_post_thumbnail_id($current_event->ID), 'full') ?>" alt="">

						</a>
					</div>
					<div class="event-data-block">
						<a href="<?= get_post_permalink($current_event->ID) ?>">
							<h3><?=  $current_event->post_title ?></h3>
						</a>
						<span class="event-data date"><?= EventFunctions::format_event_date($current_event) ?></span>
						<span class="event-data time"><?= get_field('wpcf-event_time', $current_event->ID) ?></span>
						<span class="event-data price"><?= get_field('wpcf-event_price', $current_event->ID) ?></span>
						<div class="event-data location">
							<div>
								<a href="#" class="place"><?= get_field('wpcf-event_place', $current_event->ID) ?></a>
								<a href="#" class="address"><?= get_field('wpcf-event_address', $current_event->ID) ?></a>
							</div>
						</div>
						<div class="bottom-btn-block">
							<a href="<?= get_field('wpcf-event_url', $current_event->ID) ?>" target="_blank" class="purchase-btn">Квитки</a>
							<a href="<?= get_post_permalink($current_event->ID) ?>"class="more-info">Детальніше</a>
						</div>
					</div>
				</div>
				<div class="more-events-block">
					<div class="closest-event">
						<div class="previous-event">
							<div class="event-poster">
								<a href="<?= get_post_permalink($previous_event->ID) ?>"><img src="<?= wp_get_attachment_image_url(get_post_thumbnail_id($previous_event->ID), 'full' ) ?>" alt=""></a>
								<div class="event-data-block">
									<a href="<?= get_post_permalink($previous_event->ID) ?>">
										<h3><?= $previous_event->post_title ?></h3>
										<span class="event-data date"><?= EventFunctions::format_event_date($previous_event) ?></span>
										<span class="event-data time"><?= get_field('wpcf-event_time', $previous_event) ?></span>
										<span class="event-data location"><?= get_field('wpcf-event_place', $previous_event) ?></span>
										<span class="event-data price"><?= get_field('wpcf-event_price', $previous_event) ?></span>
                                        <div class="bottom-btn-block">
                                            <a href="<?= get_field('wpcf-event_url', $previous_event->ID) ?>" class="purchase-btn">Квитки</a>
                                        </div>
									</a>
								</div>
							</div>
						</div>
					</div>
                    <?php if ( !is_null($next_event) ) : ?>
					<div class="closest-event">
						<div class="next-event">
							<div class="event-poster">
								<a href="<?= get_post_permalink($next_event->ID) ?>"><img src="<?= wp_get_attachment_image_url(get_post_thumbnail_id($next_event->ID), 'full' ) ?>" alt=""></a>
								<div class="event-data-block">
									<a href="<?= get_post_permalink($next_event->ID) ?>">
										<h3><?= $next_event->post_title ?></h3>
                                        <span class="event-data date"><?= EventFunctions::format_event_date($next_event) ?></span>
                                        <span class="event-data time"><?= get_field('wpcf-event_time', $next_event) ?></span>
                                        <span class="event-data location"><?= get_field('wpcf-event_place', $next_event) ?></span>
                                        <span class="event-data price"><?= get_field('wpcf-event_price', $next_event) ?></span>
										<div class="bottom-btn-block">
											<a href="<?= get_field('wpcf-event_url', $current_event->ID) ?>" class="purchase-btn">Квитки</a>
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>
                    <?php endif; ?>
				</div>
			</div>
			<div class="become-partner">
				<a href="#partner-form">Стати партнером</a>
			</div>
			<?php get_template_part('templates/partner-form-modal', null, $form_data); ?>
		</div>

        <?php

        $new_posts = (new WP_Query([
            'post_type' => ['news', 'articles', 'blogs', 'animation'],
            'posts_per_page' => '10',
            'post__not_in' => [get_the_ID()],
        ]))->get_posts();
        ?>

        <div class="col-xl-6 pl-xl-5 col-lg-5">
			<div class="events-right-col">
				<div class="events-archive-block">
					<h2>Архів подій</h2>
					<div class="archive-links">
                        <?php for ($i = 0; $i < count($years); $i++ ) : ?>
						    <a href="<?= "/events-archive?event_year=". $years[$i] ?>"><?= $years[$i]  ?></a>
                        <?php endfor; ?>
					</div>
				</div>
				<div class="events-news">
                    <h2><?php esc_html_e( 'Новини', 'slidstvo-info-theme' ); ?></h2>
					<div class="events-article-list">
                        <?php foreach ($event_posts as $event_post) : ?>
                            <article id="" class="events-news-block-article news-id">
                                <span class="date"><?= EventFunctions::format_event_tape_date($event_post) ?></span>
                                <a href="<?= get_post_permalink($event_post->ID) ?>" title="">
                                    <h3><?= get_the_title($event_post->ID) ?></h3>
                                </a>
                            </article>
                        <?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<!--<div class="newsletter-signup-block">
		<h4>Підписатися на ньюзлеттер</h4>
		<label for="newsletter-email">Електронна пошта</label>
		<input type="email" placeholder="Ваш email">
		<input type="submit" value="Підписатися">
	</div>-->
	<div class="subscription">
        <?php dynamic_sidebar('post-bottom-subscribe'); ?>
	</div>
	<div class="partners">
		<h2>Партнери сайту</h2>
		<div class="js-partners-carousel" class="owl-carousel">
            <?php foreach ($partners as $partner) : ?>
                <div class="slide-item">
                    <img src="<?= wp_get_attachment_image_url(get_post_thumbnail_id($partner) ) ?>" alt="">
                </div>
            <?php endforeach; ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
