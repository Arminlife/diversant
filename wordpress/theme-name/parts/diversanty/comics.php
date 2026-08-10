<?php
/**
 * Диверсанти — комікс-слайдер (swiper: десктоп 2 / мобілка 1, гортання по 2).
 * Поведінка — components/diversanty-comics.js (data-diversanty-comics*).
 */
if (!defined('ABSPATH')) { exit; }

$title   = get_query_var('dv_comics_title') ?: 'Назва коміксу';
$caption = get_query_var('dv_comics_caption');
$slides  = get_query_var('dv_comics_slides');
$slides  = is_array($slides) ? $slides : [];
?>
<section class="section diversanty_comics" data-diversanty-comics>
	<div class="section_in">
		<h2 class="diversanty_comics__title"><?php echo esc_html($title); ?></h2>

		<div class="diversanty_comics__slider swiper" data-diversanty-comics-slider>
			<div class="swiper-wrapper">
				<?php if (!empty($slides)) : ?>
					<?php foreach ($slides as $i => $slide) : ?>
						<div class="swiper-slide diversanty_comics__slide">
							<picture class="diversanty_comics__panel">
								<img class="diversanty_comics__img" src="<?php echo esc_url($slide['src']); ?>" alt="<?php echo esc_attr($slide['alt']); ?>" loading="lazy">
							</picture>
						</div>
					<?php endforeach; ?>
				<?php else : ?>
					<?php for ($i = 1; $i <= 4; $i++) : ?>
						<div class="swiper-slide diversanty_comics__slide">
							<div class="diversanty_comics__panel">
								<span class="diversanty_comics__panel_label">Комікс <?php echo $i; ?></span>
							</div>
						</div>
					<?php endfor; ?>
				<?php endif; ?>
			</div>
		</div>

		<div class="diversanty_comics__foot">
			<?php if ($caption) : ?>
				<p class="diversanty_comics__caption"><?php echo esc_html($caption); ?></p>
			<?php endif; ?>
			<div class="diversanty_comics__nav">
				<button class="diversanty_comics__arrow diversanty_comics__arrow--prev_mod" type="button" aria-label="Попередній слайд" data-diversanty-comics-prev><?php echo diversanty_chevron(); ?></button>
				<button class="diversanty_comics__arrow diversanty_comics__arrow--next_mod" type="button" aria-label="Наступний слайд" data-diversanty-comics-next><?php echo diversanty_chevron(); ?></button>
			</div>
		</div>
	</div>
</section>
