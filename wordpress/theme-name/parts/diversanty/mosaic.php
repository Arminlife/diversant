<?php
/**
 * Диверсанти — «Мозаїка матеріалів»: слайдер карток.
 * Swiper: десктоп 3 колонки × 2 картки (по 2 в слайді) / мобілка 1.
 * Поведінка — components/diversanty-mosaic.js.
 */
if (!defined('ABSPATH')) { exit; }

$title = get_query_var('dv_mosaic_title') ?: 'Мозаїка матеріалів';
$cards = get_query_var('dv_mosaic_cards');
$cards = is_array($cards) ? $cards : [];

// демо-картки (фаза верстки) — плейсхолдери з дзеркала білда
if (empty($cards)) {
	$demo = [
		['title' => 'Школярка, яку підозрюють у вбивстві військового на замовлення спецслужб РФ, також фігурує у справах про збут наркотиків', 'date' => '6 червня 2026, 10:00', 'img' => 'mosaic/mosaic1.webp', 'url' => '#'],
		['title' => 'Від графіті до вибухівки: як «Пінгвін» у Telegram завербував двох ліцеїстів і ледь не підвів їх здійснити теракт', 'date' => '1 червня 2026, 16:13', 'img' => 'mosaic/mosaic2.webp', 'url' => '#'],
		['title' => 'Дівчина захопилася хлопцем із застосунку та ледве не підірвала військкомат', 'date' => '10 березня 2026, 13:00', 'img' => 'mosaic/mosaic3.webp', 'url' => '#'],
		['title' => 'Неповнолітня захопилась «Рембо» і ледь не підірвала ТЦК: як росіяни залучають українців до терактів через додатки для знайомств', 'date' => '9 березня 2026, 06:00', 'img' => 'mosaic/mosaic4.webp', 'url' => '#'],
		['title' => '«Помітив напис «СБУ» і зрозумів, що це кінець»: як українського підлітка підштовхнули на диверсію з підпалу на «Укрзалізниці»', 'date' => '15 січня 2025, 06:00', 'img' => 'mosaic/mosaic5.webp', 'url' => '#'],
		['title' => 'Як підлітків втягують у підпали релейних шаф на залізниці — розслідування «Слідства.Інфо»', 'date' => '15 січня 2025, 06:00', 'img' => 'mosaic/mosaic5.webp', 'url' => '#'],
	];
	foreach ($demo as $d) {
		$d['img'] = diversanty_img($d['img']);
		$cards[] = $d;
	}
	// демо: дублюємо, щоб слайдер було чим гортати
	$cards = array_merge($cards, $cards);
}

// один рендер картки
$render_card = function ($card) {
	$img = isset($card['img']) ? $card['img'] : '';
	?>
	<a class="diversanty_mosaic__card" href="<?php echo esc_url($card['url']); ?>">
		<div class="diversanty_mosaic__media">
			<?php if ($img) : ?>
				<img class="diversanty_mosaic__img" src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($card['title']); ?>" loading="lazy">
			<?php endif; ?>
		</div>
		<span class="diversanty_mosaic__badge">СІ</span>
		<div class="diversanty_mosaic__body">
			<h3 class="diversanty_mosaic__card_title"><?php echo esc_html($card['title']); ?></h3>
			<div class="diversanty_mosaic__meta">
				<time class="diversanty_mosaic__date"><?php echo esc_html($card['date']); ?></time>
			</div>
		</div>
	</a>
	<?php
};
?>
<section class="section diversanty_mosaic" data-diversanty-mosaic>
	<div class="section_in">
		<h2 class="diversanty_mosaic__title"><?php echo esc_html($title); ?></h2>

		<div class="diversanty_mosaic__box">
			<div class="diversanty_mosaic__slider swiper" data-diversanty-mosaic-slider>
				<div class="swiper-wrapper">
					<?php for ($i = 0, $n = count($cards); $i < $n; $i += 2) : ?>
						<div class="swiper-slide diversanty_mosaic__slide">
							<?php
							$render_card($cards[$i]);
							if (isset($cards[$i + 1])) {
								$render_card($cards[$i + 1]);
							}
							?>
						</div>
					<?php endfor; ?>
				</div>
			</div>
		</div>

		<div class="diversanty_mosaic__nav">
			<button class="diversanty_mosaic__arrow diversanty_mosaic__arrow--prev_mod" type="button" aria-label="Попередні матеріали" data-diversanty-mosaic-prev><?php echo diversanty_chevron(); ?></button>
			<button class="diversanty_mosaic__arrow diversanty_mosaic__arrow--next_mod" type="button" aria-label="Наступні матеріали" data-diversanty-mosaic-next><?php echo diversanty_chevron(); ?></button>
		</div>
	</div>
</section>
