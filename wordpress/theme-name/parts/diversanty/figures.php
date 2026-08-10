<?php
/**
 * Диверсанти — інтерактивні «фігурки» (вироки).
 * Фільтр за віком (легенда) + тултіп (tippy) + подвійний клік → матеріали справи.
 * Поведінка — components/diversanty-figures.js. У проді дані — з CPT.
 */
if (!defined('ABSPATH')) { exit; }

$count = intval(get_query_var('dv_figures_count'));
if ($count <= 0) { $count = 800; }
$text = get_query_var('dv_figures_text') ?: 'Перед вами 3504 вироки. Наведіть на елемент, щоб дізнатися подробиці, або клікніть двічі, якщо хочете прочитати матеріали справи.';

// Категорії за віком (легенда/фільтр) — як у pug
$FIG_TYPES = [
	'minors'  => ['color' => '#E4705C', 'label' => 'неповнолітні'],
	'age18'   => ['color' => '#AF1116', 'label' => '18-21 рік'],
	'over21'  => ['color' => '#231F20', 'label' => 'понад 21 року'],
	'unknown' => ['color' => '#8A8A8A', 'label' => 'невідомий вік'],
];
$FIG_ORDER = ['minors', 'age18', 'over21', 'unknown'];

// Приклади справ (у проді — з CPT)
$FIG_CASES = [
	['crime' => 'Колабораційна діяльність', 'date' => '15.09.2022', 'court' => 'Київський районний суд м. Харкова', 'punishment' => 'звільнили від покарання', 'region' => 'Харківська область'],
	['crime' => 'Державна зрада', 'date' => '03.11.2023', 'court' => 'Приморський районний суд м. Одеси', 'punishment' => '5 років позбавлення волі', 'region' => 'Одеська область'],
	['crime' => 'Диверсія', 'date' => '21.02.2024', 'court' => 'Шевченківський районний суд м. Києва', 'punishment' => '8 років позбавлення волі', 'region' => 'Київська область'],
	['crime' => 'Пособництво державі-агресору', 'date' => '07.06.2023', 'court' => 'Галицький районний суд м. Львова', 'punishment' => 'умовний строк', 'region' => 'Львівська область'],
];
$FIG_PATTERN = [2, 0, 1, 3, 0, 2, 3, 1, 2, 1, 0, 3, 1, 3, 2, 0, 2, 3, 0, 1];
$pat_len = count($FIG_PATTERN);
?>
<section class="section diversanty_figures" data-diversanty-figures>
	<svg class="diversanty_figures__symbol" width="0" height="0" aria-hidden="true" focusable="false">
		<symbol id="diversanty-figure" viewBox="0 0 37 37">
			<path fill="currentColor" d="M18.5 8.09375C20.735 8.09375 22.5469 6.2819 22.5469 4.04688C22.5469 1.81185 20.735 0 18.5 0C16.265 0 14.4531 1.81185 14.4531 4.04688C14.4531 6.2819 16.265 8.09375 18.5 8.09375Z"></path>
			<path fill="currentColor" d="M21.9688 9.25H15.0312C13.8057 9.25362 12.6315 9.74206 11.7649 10.6086C10.8983 11.4752 10.4099 12.6495 10.4062 13.875V21.645C10.4062 22.4291 11.0154 23.0961 11.7988 23.1243C11.9929 23.1314 12.1865 23.0992 12.368 23.0298C12.5494 22.9604 12.715 22.8552 12.8548 22.7203C12.9947 22.5855 13.1059 22.4238 13.1818 22.245C13.2578 22.0662 13.2969 21.8739 13.2969 21.6797V14.4726C13.295 14.3235 13.3497 14.1792 13.4498 14.0686C13.5499 13.958 13.6881 13.8894 13.8367 13.8764C13.9158 13.8712 13.9951 13.8823 14.0697 13.909C14.1443 13.9356 14.2127 13.9774 14.2705 14.0316C14.3283 14.0858 14.3743 14.1514 14.4058 14.2241C14.4372 14.2969 14.4533 14.3753 14.4531 14.4546V35.3379C14.4531 35.7787 14.6282 36.2015 14.9399 36.5132C15.2517 36.8249 15.6744 37 16.1152 37C16.5561 37 16.9788 36.8249 17.2905 36.5132C17.6022 36.2015 17.7773 35.7787 17.7773 35.3379V25.0285C17.7748 24.8419 17.8428 24.6612 17.9679 24.5226C18.0929 24.384 18.2657 24.2978 18.4516 24.2812C18.5505 24.2746 18.6497 24.2884 18.743 24.3217C18.8364 24.355 18.9219 24.4072 18.9942 24.475C19.0665 24.5428 19.1241 24.6247 19.1634 24.7157C19.2027 24.8067 19.2229 24.9048 19.2227 25.0039V35.3379C19.2227 35.7787 19.3978 36.2015 19.7095 36.5132C20.0212 36.8249 20.4439 37 20.8848 37C21.3256 37 21.7483 36.8249 22.0601 36.5132C22.3718 36.2015 22.5469 35.7787 22.5469 35.3379V14.4726C22.545 14.3235 22.5997 14.1792 22.6998 14.0686C22.7999 13.958 22.9381 13.8894 23.0867 13.8764C23.1658 13.8712 23.2451 13.8823 23.3197 13.909C23.3943 13.9356 23.4627 13.9774 23.5205 14.0316C23.5783 14.0858 23.6243 14.1514 23.6558 14.2241C23.6872 14.2969 23.7033 14.3753 23.7031 14.4546V21.6464C23.7031 22.4305 24.3123 23.0975 25.0957 23.1257C25.2899 23.1328 25.4836 23.1007 25.6652 23.0312C25.8467 22.9617 26.0124 22.8563 26.1522 22.7213C26.2921 22.5863 26.4033 22.4244 26.4791 22.2455C26.555 22.0665 26.594 21.8741 26.5938 21.6797V13.875C26.5901 12.6495 26.1017 11.4752 25.2351 10.6086C24.3685 9.74206 23.1943 9.25362 21.9688 9.25Z"></path>
		</symbol>
	</svg>

	<div class="section_in">
		<div class="diversanty_figures__head">
			<h2 class="diversanty_figures__title">“Фігурки різного кольору”</h2>
			<p class="diversanty_figures__text"><?php echo esc_html($text); ?></p>

			<div class="diversanty_figures__filter" role="group" aria-label="Фільтр за віком">
				<button class="diversanty_figures__filter_btn is-active" type="button" data-figures-filter="all">Усі</button>
				<?php foreach ($FIG_ORDER as $key) : ?>
					<button class="diversanty_figures__filter_btn" type="button" data-figures-filter="<?php echo esc_attr($key); ?>" style="--figure-color: <?php echo esc_attr($FIG_TYPES[$key]['color']); ?>">
						<svg class="diversanty_figures__filter_icon" viewBox="0 0 37 37" aria-hidden="true"><use href="#diversanty-figure"></use></svg>
						<span><?php echo esc_html($FIG_TYPES[$key]['label']); ?></span>
					</button>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="diversanty_figures__grid" data-figures-grid>
			<?php for ($i = 0; $i < $count; $i++) :
				$key = $FIG_ORDER[$FIG_PATTERN[$i % $pat_len]];
				$c   = $FIG_CASES[($i * 3 + $FIG_PATTERN[$i % $pat_len]) % count($FIG_CASES)];
				$color = $FIG_TYPES[$key]['color'];
			?>
				<button class="diversanty_figures__item" type="button"
					data-figures-type="<?php echo esc_attr($key); ?>"
					data-crime="<?php echo esc_attr($c['crime']); ?>"
					data-date="<?php echo esc_attr($c['date']); ?>"
					data-court="<?php echo esc_attr($c['court']); ?>"
					data-punishment="<?php echo esc_attr($c['punishment']); ?>"
					data-region="<?php echo esc_attr($c['region']); ?>"
					data-url="#"
					style="--figure-color: <?php echo esc_attr($color); ?>"
					aria-label="Вирок">
					<svg class="diversanty_figures__icon" viewBox="0 0 37 37" aria-hidden="true"><use href="#diversanty-figure"></use></svg>
				</button>
			<?php endfor; ?>
		</div>
	</div>
</section>
