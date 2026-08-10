<?php
/**
 * Диверсанти — шапка + кредити.
 * Заголовок/хлібні крихти у WP зазвичай ідуть із single-header; тут — кредити.
 */
if (!defined('ABSPATH')) { exit; }

$title   = get_query_var('dv_head_title');
$credits = get_query_var('dv_head_credits');

// WYSIWYG → пункти списку .diversanty_head__credit
$credits_html = '';
if ($credits) {
	if (strpos($credits, '<p') !== false) {
		$credits_html = preg_replace('/<p[^>]*>/', '<li class="diversanty_head__credit">', $credits);
		$credits_html = str_replace('</p>', '</li>', $credits_html);
	} else {
		foreach (preg_split('/\r\n|\r|\n/', trim($credits)) as $line) {
			$line = trim($line);
			if ($line !== '') {
				$credits_html .= '<li class="diversanty_head__credit">' . $line . '</li>';
			}
		}
	}
	// посилання без класу → додати .diversanty_head__name
	$credits_html = preg_replace('/<a\b(?![^>]*class=)/', '<a class="diversanty_head__name"', $credits_html);
}

// демо-фолбек (фаза верстки)
if (!$credits_html) {
	$credits_html =
		'<li class="diversanty_head__credit">Авторка: <a class="diversanty_head__name" href="#">Ім\'я Прізвище</a></li>' .
		'<li class="diversanty_head__credit">Редактори: <a class="diversanty_head__name" href="#">Ім\'я Прізвище</a>, <a class="diversanty_head__name" href="#">Ім\'я Прізвище</a></li>' .
		'<li class="diversanty_head__credit">Журналістка: <a class="diversanty_head__name" href="#">Ім\'я Прізвище</a>. Оператор: <a class="diversanty_head__name" href="#">Ім\'я Прізвище</a></li>' .
		'<li class="diversanty_head__credit">Дизайн: <a class="diversanty_head__name" href="#">Данило Маліков</a>. Розробка: <a class="diversanty_head__name" href="#">Михайло Каліченко</a></li>';
}
?>
<section class="section diversanty_head">
	<div class="section_in">
		<?php if ($title) : ?>
			<h1 class="diversanty_head__title"><?php echo esc_html($title); ?></h1>
		<?php endif; ?>
		<ul class="diversanty_head__credits"><?php echo $credits_html; ?></ul>
	</div>
</section>
