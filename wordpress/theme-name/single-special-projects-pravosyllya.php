<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package slidstvo
 */

get_header(); ?>

	<div class="container-fluid p-0">

			<?php get_template_part( 'parts/pagetitle-pravosyllia' ); ?>

			<section class="container innernews pravosyllya-content">
			    <?php the_content(); ?>
			</section>

			<section class="institution-map">
				<div class="container wrapper wrapper_filters">
					<div class="institution-map-filters">
						<div class="map-filters-button">
							<div class="map-filters-button__value">
								Фільтр карти
							</div>
							<svg class="more-items-icon">
								<use xlink:href="#more-items-icon"></use>
							</svg>
							<svg class="filter-check-icon">
								<use xlink:href="#check-icon"></use>
							</svg>
						</div>
						<ul class="map-filters-list">
							<li class="map-filters-item all-filter active" data-type="">
								Всі
							</li>
							<li class="map-filters-item" data-type="slidchyy_izolyator">
								<svg class="map-filter-icon map-filter-icon_1">
									<use xlink:href="#filter-icon_1"></use>
								</svg>
								Слідчий ізолятор
							</li>
							<li class="map-filters-item" data-type="vypravna_koloniya">
								<svg class="map-filter-icon map-filter-icon_2">
									<use xlink:href="#filter-icon_2"></use>
								</svg>
								Виправна колонія
							</li>
							<li class="map-filters-item" data-type="vykhovna_koloniya">
								<svg class="map-filter-icon map-filter-icon_3">
									<use xlink:href="#filter-icon_3"></use>
								</svg>
								Виховна колонія
							</li>
							<li class="map-filters-item" data-type="vykonannya_pokaran">
								<svg class="map-filter-icon map-filter-icon_4">
									<use xlink:href="#filter-icon_4"></use>
								</svg>
								Установа виконання покарань
							</li>
							<li class="map-filters-item" data-type="vypravnyy_tsentr">
								<svg class="map-filter-icon map-filter-icon_5">
									<use xlink:href="#filter-icon_5"></use>
								</svg>
								Виправний центр
							</li>
							<li class="map-filters-item" data-type="likuvalnyy_zaklad">
								<svg class="map-filter-icon map-filter-icon_6">
									<use xlink:href="#filter-icon_6"></use>
								</svg>
								Лікувальний заклад
							</li>
						</ul>
					</div>
				</div>
				<div id="institution-map">

				</div>
			</section>

			<section class="institution-counter">
				<div class="wrapper">
					<div class="institution-counter-wrap">
						<div class="institution-counter__item institution-counter-item institution-counter-item_1">
							<div class="institution-counter-item__value institution-counter_count">
								12 000
							</div>
							<div class="institution-counter-item__text">
								кількість закладів
							</div>
						</div>
						<div class="institution-counter__item institution-counter-item institution-counter-item_2">
							<div class="institution-counter-item__value institution-counter_prisoners">
								140 000
							</div>
							<div class="institution-counter-item__text">
								кількість засуджених та взятих під варту
							</div>
						</div>
						<div class="institution-counter__item institution-counter-item institution-counter-item_3">
							<div class="institution-counter-item__value institution-counter_percentage">
								<div id="pinkcircle" data-percent="74"></div>
							</div>
							<div class="institution-counter-item__text">
								відсоток наповненості закладів
							</div>
						</div>
					</div>
					<div class="institution-counter-description">
						*За даними ДКВС України станом на 01.01.2019 без урахування даних з непідконтрольних Україні територій
					</div>
				</div>
			</section>

			<section class="torture-schedule-section">
				<div class="wrapper container">
					<h2 class="torture-schedule-section__title">
						КАТУВАННЯ УВ’ЯЗНЕНИХ ЗА ОСТАННІ 5 РОКІВ*
					</h2>
					<div class="torture-schedule-wrap">
						<div class="torture-schedule">
							<div class="torture-schedule_line torture-schedule_line_0">
								<span>0</span>
							</div>
							<div class="torture-schedule_line torture-schedule_line_50">
								<span>50</span>
							</div>
							<div class="torture-schedule_line torture-schedule_line_100">
								<span>100</span>
							</div>
							<div class="torture-schedule_line torture-schedule_line_150">
								<span>150</span>
							</div>
							<div class="torture-schedule_line torture-schedule_line_200">
								<span>200</span>
							</div>
							<div class="torture-schedule_line torture-schedule_line_250">
								<span>250</span>
							</div>
							<div class="torture-schedule-infografic torture-schedule-infografic_1">
								<div class="torture-schedule-infografic__title">
									відкрито кримінальних справ щодо злочинів пенітенціарників
								</div>
								<div class="torture-schedule-infografic__value">
									211
								</div>
							</div>
							<div class="torture-schedule-infografic torture-schedule-infografic_2">
								<div class="torture-schedule-infografic__title">
									передано до суду
								</div>
								<div class="torture-schedule-infografic__value">
									8
								</div>
							</div>
						</div>
						<div class="torture-schedule-statistic">
							<div class="torture-schedule-statistic-wrap">
								<div class="torture-schedule-statistic__item torture-schedule-statistic-item">
									<div class="torture-schedule-statistic-item__text">
										Кількість скарг, виграних за цей час в Європейському суді:
									</div>
									<div class="torture-schedule-statistic-item__value">
										73
									</div>
								</div>
								<div class="torture-schedule-statistic__item torture-schedule-statistic-item">
									<div class="torture-schedule-statistic-item__text">
										Витрачено з державного бюджету на компенсацію:
									</div>
									<div class="torture-schedule-statistic-item__value">
										800 тис. євро
									</div>
								</div>
							</div>
							<div class="torture-schedule-statistic__description">
								*Включає справи щодо катувань та іншого жорстокого поводження  - ст. 127, ст. 364, ст. 365, ст. 367 ст. 373 ККУ порушених за період 2014 - 9 місяців 2018 року
								<span>Джерело: ГЕНЕРАЛЬНА ПРОКУРАТУРА УКРАЇНИ</span>
							</div>
						</div>
					</div>
				</div>
			</section>


    </div><!-- #primary -->

	<?php get_template_part( 'parts/related-posts-pravosyllia' ); ?>
	<?php
    $investigations_arr = [];

	$args = array(
	    'post_type'  		=> 'investigations',
	    'tax_query' => array(
			array(
				'taxonomy' => 'investigation_type',
				'field'    => 'id',
				'terms'    => 1375
			)
		)
	);

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) : ?>
		<?php while ( $query->have_posts() ) :  $query->the_post();

			$institution_id = get_post_meta( $post->ID, 'wpcf-institution-id', true);

			$investigations_arr[$institution_id][] = get_permalink();

		endwhile; ?>
	<?php
	wp_reset_postdata();
	endif; ?>
	<script>window.investigationsArr = JSON.parse('<?php echo json_encode($investigations_arr)?>');

	</script>

	<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCc5re6rYOn-69EPNPbX3YPjhaHkWvKL6Y&language=uk&callback=initial">
	</script>

<?php
get_footer();
?>
<svg style="display:none;">
        <symbol id="grille-icon" viewBox="0 0 49 45">
            <path d="M13.848.26V45M36.217.26V45M49 11.978H0M49 32.217H0" stroke="#fff" stroke-width="7" stroke-miterlimit="10"></path>
        </symbol>
        <symbol id="filter-icon_1" viewBox="0 0 17 16">
            <path d="M2.822 0v15.107M8.183 0v15.107M13.826 0v15.107M16.154 2.148H0M16.154 12.53H0M16.154 7.518H0" stroke-miterlimit="10" fill="none"></path>
        </symbol>
        <symbol id="filter-icon_2" viewBox="0 0 18 21">
            <path d="M13.818 20.019c-2.585.336-5.303-.067-7.623-1.211-.928-.471-1.79-1.01-2.586-1.75-1.657-1.614-2.651-3.902-2.585-6.257 0-.942.199-1.884.464-2.759.53-1.951 1.59-3.903 3.314-4.98 1.591-1.008 3.713-1.076 5.503-.47 1.79.605 3.248 2.018 4.242 3.633.862 1.413 1.393 3.095 1.26 4.778-.133 1.682-1.06 3.297-2.52 4.037-.596.336-1.325.47-2.054.605-1.194.202-2.453.202-3.646-.201-2.188-.74-3.646-2.961-3.845-5.316-.2-2.355.729-4.643 2.254-6.392 1.193-1.413 2.85-2.49 4.706-2.557 1.127 0 2.254.404 3.249 1.01.994.605 1.856 1.412 2.651 2.22M13.288 6.764L17 8.042M14.547 9.455l1.127-3.835M7.52 14.165l3.116 2.422M7.852 17.125l2.32-3.23M2.416 9.32l3.116 2.423M2.747 12.281l2.32-3.297M1.886 3.4l1.458 3.633M.692 6.09l3.646-1.614M2.084 16.856L5.797 18M3.41 19.48l.995-3.902" stroke-miterlimit="10" fill="none"></path>
        </symbol>
        <symbol id="filter-icon_3" viewBox="0 0 19 15">
            <path d="M5.009 3.419h-3.11v4.82h3.11V3.42zM9.327 3.419h-3.11v4.82h3.11V3.42zM5.009 9.379h-3.11V14.2h3.11V9.379zM9.327 9.379h-3.11V14.2h3.11V9.379zM17.358 3.419h-6.995v10.693h6.995V3.42zM18.567 0H0v2.279h18.567V0z" stroke="none"></path>
        </symbol>
        <symbol id="filter-icon_4" viewBox="0 0 13 21">
            <path d="M9.769 6.56H6.913v2.898H9.77V6.559zM6.162 2.975H3.306v2.822h2.856V2.975zM6.162 6.56H3.306v2.898h2.856V6.559zM9.769 2.975H6.913v2.822H9.77V2.975z" stroke="none"></path>
            <path d="M0 0v20.746h13V0H0zm10.445 9.84v.38h-7.89V2.212h7.89v7.627z" stroke="none"></path>
        </symbol>
        <symbol id="filter-icon_5" viewBox="0 0 15 17">
            <path d="M15 6.114H0L7.8 0 15 6.114zM.6 7.031h3v4.279h-3zM4.2 7.031h3v4.279h-3zM7.8 7.031h3v4.279h-3zM11.4 7.031h3v4.279h-3zM11.4 11.921h3V16.2h-3zM7.8 11.921h3V16.2h-3zM4.2 11.921h3V16.2h-3zM.6 11.921h3V16.2h-3z" stroke="none"></path>
        </symbol>
        <symbol id="filter-icon_6" viewBox="0 0 15 15">
            <path d="M0 4.952h4.953V0h5.094v4.952H15v5.168h-4.953V15H5.094v-4.88H0V4.952z" stroke="none"></path>
        </symbol>
        <symbol id="map-info-window-close" viewBox="0 0 50 50">
            <circle cx="25" cy="25" r="25"></circle>
            <path d="M38.158 13.158L25.658 25l-12.5-11.842M13.158 36.842L25.658 25l12.5 11.842" stroke="#fff" stroke-width="2" fill="none"></path>
        </symbol>
        <symbol id="map-stories-icon" viewBox="0 0 40 40">
            <circle cx="20" cy="20" r="19.5" stroke="#3878C7" stroke-opacity=".5"></circle>
            <path d="M19.986 19.27c2.335 0 4.228-2.299 4.228-5.135S23.593 9 19.986 9c-3.606 0-4.228 2.3-4.228 5.135 0 2.836 1.893 5.135 4.228 5.135zM12 27.111c0-.173 0-.049 0 0zM27.971 27.246c.003-.047.001-.328 0 0zM27.962 26.904c-.078-4.94-.723-6.349-5.66-7.24 0 0-.696.886-2.316.886-1.62 0-2.315-.886-2.315-.886-4.884.882-5.568 2.269-5.658 7.08-.008.392-.01.413-.012.367v.52S13.177 30 19.986 30c6.81 0 7.985-2.37 7.985-2.37v-.384c-.001.029-.004-.026-.009-.342z" fill="currentColor"></path>
        </symbol>
        <symbol id="more-items-icon" viewBox="0 0 28 16">
            <path d="M27 1L14 14 1 1" stroke="#BCBCBC" stroke-width="2" fill="none"></path>
        </symbol>
        <symbol id="check-icon" viewBox="0 0 19 15">
            <path d="M1 6l7 7 9.5-12" stroke="#B9463C" stroke-width="2" fill="none"></path>
        </symbol>
    </svg>
<script>

	jQuery(document).ready(function($){
		//circle-progress bar in counter section
		jQuery("#pinkcircle").percircle({
			progressBarColor: '#B9463C',
			text: jQuery('#pinkcircle').data('percent'),
		});

		jQuery('.map-filters-button').click(function(){
			jQuery(this).parent('.institution-map-filters').toggleClass('active');
		});

	});
</script>
