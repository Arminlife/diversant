<?php
$copyright_text = get_field('footer_copyright_text', 'option');
$copyright_year = get_field('footer_copyright_year', 'option');
$privacy_link = get_field('footer_privacy_link', 'option');
$contacts = get_field('footer_contacts', 'option');
$scroll_button = get_field('footer_scroll_button', 'option');
$created_by = get_field('footer_created_by', 'option');
?>

<footer class="footer">
	<div class="section_in section_in--border_mod">
		<div class="footer__cols">
			<div class="footer__col">
				<?php if (!empty($copyright_text)) : ?>
					<div class="footer__text"><?php echo wp_kses_post($copyright_text); ?></div>
				<?php endif; ?>

				<div class="footer__info">
					<?php if (!empty($copyright_year)) : ?>
						<div class="footer__copyright"><?php echo esc_html($copyright_year); ?></div>
					<?php endif; ?>

					<?php if (!empty($privacy_link['url'])) : ?>
						<a class="footer__link" href="<?php echo esc_url($privacy_link['url']); ?>"><?php echo esc_html($privacy_link['title']); ?></a>
					<?php endif; ?>
				</div>
			</div>

			<?php if (!empty($contacts)) : ?>
				<?php
				$contact_cols = array_chunk($contacts, 2);
				foreach ($contact_cols as $col_contacts) :
				?>
					<div class="footer__col">
						<?php foreach ($col_contacts as $contact) : ?>
							<div class="footer_data">
								<?php if (!empty($contact['title'])) : ?>
									<div class="footer_data__title"><?php echo esc_html($contact['title']); ?></div>
								<?php endif; ?>

								<?php if (!empty($contact['content'])) : ?>
									<div class="footer_data__content">
										<?php if ($contact['type'] === 'email') : ?>
											<a class="footer_data__item" href="mailto:<?php echo esc_attr($contact['content']); ?>">
												<?php echo esc_html($contact['content']); ?>
											</a>
											<div class="footer_data__btn js-copy-btn" data-copy="<?php echo esc_attr($contact['content']); ?>">
												<span class="icon icon--size_mod" data-sprite-icon="copy">
													<?php Utils::the_icon('copy'); ?>
												</span>
												<span class="icon icon--size_mod" data-sprite-icon="chevron-right">
													<?php Utils::the_icon('chevron-right'); ?>
												</span>
											</div>
										<?php elseif ($contact['type'] === 'phone') : ?>
											<a class="footer_data__item" href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $contact['content'])); ?>">
												<?php echo esc_html($contact['content']); ?>
											</a>
										<?php else : ?>
											<div class="footer_data__item"><?php echo wp_kses_post($contact['content']); ?></div>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>

			<div class="footer__col">
				<?php if (!empty($scroll_button['text'])) : ?>
					<div class="footer__btn">
						<a class="btn_v2 js-footer-scrollup" href="#">
							<div class="btn_v2__title"><?php echo esc_html($scroll_button['text']); ?></div>
							<div class="btn_v2__icon">
								<span class="icon icon--size_mod" data-sprite-icon="up">
									<?php Utils::the_icon('up'); ?>
								</span>
							</div>
						</a>
					</div>
				<?php endif; ?>

				<?php if (!empty($created_by['title']) || !empty($created_by['logo'])) : ?>
					<div class="footer__created">
						<?php if (!empty($created_by['title'])) : ?>
							<div class="footer__created_title"><?php echo esc_html($created_by['title']); ?></div>
						<?php endif; ?>

						<?php if (!empty($created_by['logo'])) : ?>
							<div class="footer__created_logo">
								<img class="footer__created_logo_el" src="<?php echo esc_url($created_by['logo']['url']); ?>" alt="<?php echo esc_attr($created_by['logo']['alt']); ?>">
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</footer>