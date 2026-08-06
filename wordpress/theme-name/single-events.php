<?php
global $wp, $post;
set_query_var('post', $post);

$news = EventFunctions::getNews(11);
$partners = EventFunctions::getAllPartners();
$month_events = EventFunctions::getAllMonthEvents();
$formated_month = EventFunctions::getCurrentMonth();

$current_url = home_url(add_query_arg(array($_GET), $wp->request));
$form_data = CC_Functions::processPartnerForm();
if ($form_data['success'] === true) {
    wp_redirect($current_url . '#partner-form-success');
    exit;
}

$event_date_timestamp = strtotime(get_field('wpcf-event_date', $post));

get_header();
?>
<div class="container">
	<div class="row">
		<div class="col-xl-8 col-lg-8">
			<div class="single-event-block">
				<div class="single-event-left-col">
					<h3><?= get_the_title() ?></h3>
					<div class="single-event-poster">
						<img src="<?= get_the_post_thumbnail_url() ?>" alt="">
					</div>
					<div class="event-text-block">
						<div class="date"><span> Час: </span><?= get_field('wpcf-event_time', $post) ?></div>
						<div class="place"><span>Місце: </span><?= get_field('wpcf-event_place', $post) ?></div>
						<div class="event-description">
							<p><span>Опис події: </span>
                                <?= htmlspecialchars_decode(get_field('wpcf-event_description', $post)) ?></p>
                            <?php if ( $event_date_timestamp > time() ) : ?>
							    <div class="price"><span>Ціна квитка: </span><?= get_field('wpcf-event_price', $post) ?></div>
                            <?php endif; ?>
						</div>
                        <?php if ( $event_date_timestamp > time() ) : ?>
                            <div class="google-form-links">
                                <a href="<?= get_field('wpcf-event_registration_form_url', $post) ?>">Зареєструватися</a>
                                <a href="<?= get_field('wpcf-event_sponsor_form_url', $post) ?>">Спонсорам</a>
                            </div>
                        <?php endif; ?>
                        <div class="events-share-buttons">
							<span>Поділитися подією: </span>
							<ul>
                                <?php echo do_shortcode('[easy-social-share buttons="facebook,telegram" sharebtn_style="icon" counters=0 style="icon" point_type="simple"]'); ?>
							</ul>
						</div>
					</div>
				</div>
				<div class="single-event-right-col">
					<div class="event-map">
                        <?= get_field('wpcf-event_map', $post) ?>
					</div>
					<div class="location">
						<div>
							<a href="#" class="place"><?= get_field('wpcf-event_place', $post) ?></a>
							<a href="#" class="address"><?= get_field('wpcf-event_address', $post) ?></a>
						</div>
					</div>

					<div class="event-calendar">
                        <?php if (!empty($month_events)) : ?>
						<h3>Інші події</h3>
						<div class="events-list">
                            <?php foreach ($month_events as $month_event) : ?>
                                <div class="event-wrapper">
                                    <div class="event-date"><?= EventFunctions::format_event_date($month_event) ?></div>
                                    <div class="event-title">
                                        <a href="<?= get_post_permalink($month_event->ID) ?>"><?= $month_event->post_title ?></a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
						</div>

                        <?php endif; ?>
					</div>
                    <?php if ( $event_date_timestamp > time() ) : ?>
                        <div class="bottom-btn-block">
                            <a href="<?= get_field('wpcf-event_url', $post) ?>" target="_blank" class="purchase-btn">Квитки</a>
                        </div>
                    <?php endif; ?>
				</div>
			</div>
		</div>




		<div class="col-xl-4 col-lg-4">
			<div class="events-news">
				<h2>Новини</h2>
				<div class="events-article-list">
                    <?php foreach( $news as $post ) : ?>
                        <article id="" class="events-news-block-article news-id">
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
                                    " 10 " => " жовтня ",
                                    " 11 " => " листопада ",
                                    " 12 " => " грудня "
                                );
                                $month = " ".explode(" ", $date)[1]. " ";
                                echo $date = str_replace($month, $_monthsList[$month], $date);
                                ?>
                            </span>
                            <a href="<?= get_post_permalink($post->ID) ?>" title="<?= get_the_title($post->ID) ?>">
                                <h3><?= get_the_title($post->ID) ?></h3>
                            </a>
                        </article>
                    <?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
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
		<div class="row">
			<div class="col-xl-7 col-md-7">
				<div class="become-partner">
					<a href="#partner-form">Стати партнером</a>
				</div>
                <?php get_template_part('templates/partner-form-modal', null, $form_data); ?>
			</div>
		</div>
	</div>
</div>
<?php get_template_part('parts/related-event-posts') ?>
<?php get_footer(); ?>
