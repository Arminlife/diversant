<?php
/**
 * Диверсанти — fullpage-інтро (рендериться ПЕРЕД хедером, через wp_body_open).
 * Хедер/футер сайту не чіпаємо. Поведінка — components/diversanty-intro.js.
 */
if (!defined('ABSPATH')) { exit; }

$doll = diversanty_img('diversanty-doll.webp');
?>
<section class="diversanty_intro" data-diversanty-intro>
	<div class="diversanty_intro__sticky">
		<div class="diversanty_intro__stage">
			<p class="diversanty_intro__line" data-diversanty-frame="0">Привіт, робота цікавить?</p>
			<p class="diversanty_intro__line" data-diversanty-frame="1">Нічого складного,<br>платимо 1000 доларів</p>
			<p class="diversanty_intro__line" data-diversanty-frame="2">Будь-яке місто України,<br>в офісі сидіти не треба</p>
			<p class="diversanty_intro__line diversanty_intro__line--ru_mod" data-diversanty-frame="3">Работа непыльная</p>

			<figure class="diversanty_intro__photo" data-diversanty-photo>
				<img class="diversanty_intro__photo_img" src="<?php echo esc_url($doll); ?>" alt="Дитяча лялька серед руїн зруйнованого будинку" width="1366" height="800">
				<span class="diversanty_intro__veil" aria-hidden="true"></span>
			</figure>

			<h1 class="diversanty_intro__title" data-diversanty-title>Завербовані діти</h1>
		</div>

		<div class="diversanty_intro__hint" data-diversanty-hint aria-hidden="true">
			<span class="diversanty_intro__hint_text">Прокрутіть</span>
			<span class="diversanty_intro__hint_arrow"></span>
		</div>
	</div>
</section>
