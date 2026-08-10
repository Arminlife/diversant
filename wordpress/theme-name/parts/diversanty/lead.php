<?php
/**
 * Диверсанти — лід: 2 колонки (текст + мокап телефона з Telegram-чатом).
 */
if (!defined('ABSPATH')) { exit; }

$title = get_query_var('dv_lead_title');
$text  = get_query_var('dv_lead_text');
$chat  = get_query_var('dv_lead_chat');

// демо-фолбеки (фаза верстки)
if (!$title) {
	$title = 'Школярка, яку підозрюють у вбивстві військового на замовлення спецслужб РФ';
}
if (!$text) {
	$text = '<p>Журналісти «Слідства.Інфо» встановили, що дівчина також є фігуранткою кримінальних справ щодо незаконного збуту наркотичних речовин, а також підготовки теракту із використанням саморобної вибухівки або вогнепальної зброї.</p>'
		. '<p>Про це повідомляє «Слідство.Інфо».</p>'
		. '<p>Правоохоронці підозрюють 17-річну дівчину з Бердичева, що на Житомирщині, у вбивстві 27-річного військовослужбовця ЗСУ.</p>';
}
$phone = diversanty_img('diversanty-phone.png');
if (!$chat) {
	$chat = diversanty_img('diversanty-chat.jpg');
}
?>
<section class="section diversanty_lead">
	<div class="section_in">
		<div class="diversanty_lead__grid">
			<div class="diversanty_lead__body">
				<h2 class="diversanty_lead__title"><?php echo esc_html($title); ?></h2>
				<div class="diversanty_lead__text"><?php echo $text; ?></div>
			</div>
			<div class="diversanty_lead__media">
				<div class="diversanty_lead__phone">
					<img class="diversanty_lead__phone_frame" src="<?php echo esc_url($phone); ?>" alt="" aria-hidden="true">
					<div class="diversanty_lead__phone_screen" data-diversanty-phone-screen>
						<img class="diversanty_lead__phone_chat" src="<?php echo esc_url($chat); ?>" alt="Скриншот Telegram-переписки вербувальника про «роботу»" loading="lazy">
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
