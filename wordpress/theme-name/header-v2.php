<?php
$social_links = get_field('header_social_links', 'option');
$logo = get_field('header_logo', 'option');
$buttons = get_field('header_buttons', 'option');
?>

<header class="header js-header">
	<div class="header__top section_in section_in--border_mod">
		<?php if (!empty($social_links)) : ?>
			<div class="header_social">
				<?php foreach ($social_links as $social) : ?>
					<li class="header_social__item">
						<a class="header_social__link" href="<?php echo esc_url($social['url']); ?>">
							<span class="icon icon--size_mod" data-sprite-icon="<?php echo esc_attr($social['icon']); ?>">
								<?php Utils::the_icon($social['icon']); ?>
							</span>
						</a>
					</li>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if (!empty($logo['image'])) : ?>
			<a class="header__logo" href="<?php echo !empty($logo['url']) ? esc_url($logo['url']) : esc_url(home_url('/')); ?>">
				<img class="header__logo_el" src="<?php echo esc_url($logo['image']['url']); ?>" alt="<?php echo esc_attr($logo['image']['alt']); ?>">
			</a>
		<?php endif; ?>

		<div class="header_search js-header-search">
			<a class="header_search__trigger js-header-search-trigger" href="#">
				<span class="icon icon--size_mod" data-sprite-icon="search">
					<?php Utils::the_icon('search'); ?>
				</span>
			</a>
		</div>

		<button class="header__menu_trigger js-header-menu-trigger" type="button">
			<span class="header__menu_trigger_el"></span>
		</button>
	</div>

	<div class="header__bottom section_in">
		<nav class="header_menu">
			<?php
			wp_nav_menu([
				'theme_location' => 'top-navigation',
				'container' => false,
				'menu_class' => 'header_menu__list',
				'walker' => new Header_Menu_Walker(),
				'fallback_cb' => false
			]);
			?>
		</nav>

		<?php if (!empty($buttons)) : ?>
			<div class="header_buttons">
				<?php foreach ($buttons as $button) : ?>
					<div class="header_buttons__item">
						<a class="btn_v2<?php echo !empty($button['style']) && $button['style'] === 'v2' ? ' btn_v2--v2_mod' : ''; ?>" href="<?php echo esc_url($button['url']); ?>">
							<div class="btn_v2__title"><?php echo esc_html($button['title']); ?></div>
							<div class="btn_v2__icon">
								<span class="icon icon--size_mod" data-sprite-icon="arrow">
									<?php Utils::the_icon('arrow'); ?>
								</span>
							</div>
						</a>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if (!empty($social_links)) : ?>
			<div class="header_social header_social--mobile_mod">
				<?php foreach ($social_links as $social) : ?>
					<li class="header_social__item">
						<a class="header_social__link" href="<?php echo esc_url($social['url']); ?>">
							<span class="icon icon--size_mod" data-sprite-icon="<?php echo esc_attr($social['icon']); ?>">
								<?php Utils::the_icon($social['icon']); ?>
							</span>
						</a>
					</li>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</header>