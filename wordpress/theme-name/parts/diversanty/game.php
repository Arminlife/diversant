<?php
/**
 * Диверсанти — гра «Пройди вербувальника».
 * Чат рендериться з JS (components/diversanty-game.js) за сценаріями з JSON.
 * data-game-src → URL JSON (щоб не залежати від відносного './static').
 */
if (!defined('ABSPATH')) { exit; }

$title = get_query_var('dv_game_title') ?: 'Гра «Пройди вербувальника»';
$src   = get_query_var('dv_game_src');
$phone = diversanty_img('diversanty-phone.png');
?>
<section class="section diversanty_game" data-diversanty-game<?php echo $src ? ' data-game-src="' . esc_url($src) . '"' : ''; ?>>
	<div class="section_in">
		<h2 class="diversanty_game__title"><?php echo esc_html($title); ?></h2>
		<div class="diversanty_game__phone">
			<img class="diversanty_game__frame" src="<?php echo esc_url($phone); ?>" alt="" aria-hidden="true">
			<div class="diversanty_game__screen" data-game-screen>
				<div class="diversanty_game__chat" data-game-chat aria-live="polite"></div>
			</div>
		</div>
	</div>
</section>
