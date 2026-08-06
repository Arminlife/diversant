<?php
$image_id = get_query_var('wpb_banner_image_id', 0);
$title = get_query_var('wpb_banner_title', '');
$button_text = get_query_var('wpb_banner_button_text', '');
$button_url = get_query_var('wpb_banner_button_url', '#');
$button_target = get_query_var('wpb_banner_button_target', '_self');

$image_url = '';
$image_alt = '';

if ($image_id) {
	$image_url = wp_get_attachment_image_url($image_id, 'full');
	$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
}
?>

<?php if (!empty($image_url)) : ?>
<section class="section banner section--border_mod">
	<div class="section_in section_in--border_mod">
		<div class="banner__content">
			<picture class="banner__image">
				<img class="banner__image_el" src="<?php echo esc_url($image_url); ?>"
					alt="<?php echo esc_attr($image_alt); ?>" loading="lazy">
			</picture>
			<?php if (!empty($title)) : ?>
			<h3 class="banner__title"><?php echo wp_kses_post($title); ?></h3>
			<?php endif; ?>
			<?php if (!empty($button_text)) : ?>
			<div class="banner__button">
				<a class="button" href="<?php echo esc_url($button_url); ?>" target="<?php echo esc_attr($button_target); ?>">
					<div class="button__title"><?php echo esc_html($button_text); ?></div>
					<div class="button__icon">
						<span class="icon icon--size_mod" data-sprite-icon="arrow">
							<?php echo Utils::the_icon('arrow'); ?>
						</span>
					</div>
				</a>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php endif; ?>
