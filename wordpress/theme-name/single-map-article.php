<?php
get_header();

while (have_posts()) : the_post();
	$post_id = get_the_ID();
	$post_title = get_the_title();
	$post_date = get_the_date('j F Y, G:i');
	$post_content_raw = get_the_content();

	$custom_blocks = '';
	$main_content = $post_content_raw;

	// Отримуємо список кастомних блоків через фільтр
	$custom_shortcodes = apply_filters('custom_wpbakery_blocks', []);

	if (!empty($custom_shortcodes)) {
		$pattern = '/\[(' . implode('|', $custom_shortcodes) . ')[^\]]*\](?:[^\[]*\[\/\1\])?/s';

		if (preg_match_all($pattern, $post_content_raw, $matches)) {
			$custom_blocks = implode('', $matches[0]);
			foreach ($matches[0] as $shortcode) {
				$main_content = str_replace($shortcode, '', $main_content);
			}
		}
	}

	$featured_image_id = get_post_thumbnail_id($post_id);
	$featured_image_url = get_the_post_thumbnail_url($post_id, 'full');
	$featured_image_alt = get_post_meta($featured_image_id, '_wp_attachment_image_alt', true);

	$terms = get_the_terms($post_id, 'map-article-category');

	$category_name = '';
	if ($terms && !is_wp_error($terms)) {
		$category_name = $terms[0]->name;
	}
?>

<?php
	$tags = get_the_terms($post_id, 'map-article-tag');
	set_query_var('article_info_tags', $tags ?: []);
	set_query_var('article_info_url', get_permalink($post_id));
	set_query_var('article_info_title', $post_title);
?>


<section class="section article article--indent_mod">
	<div class="section_in section_in--border_mod">
		<div class="article__head">
			<?php if (!empty($category_name)) : ?>
				<div class="article__label"><?php echo esc_html($category_name); ?></div>
			<?php endif; ?>
			<div class="article__date"><?php echo esc_html($post_date); ?></div>
		</div>
		<h1 class="article__title"><?php echo esc_html($post_title); ?></h1>
		<?php if (!empty($featured_image_url)) : ?>
			<div class="article__poster">
				<picture class="article__poster_img">
					<img class="article__poster_el" src="<?php echo esc_url($featured_image_url); ?>"
						alt="<?php echo esc_attr($featured_image_alt ?: $post_title); ?>" loading="lazy">
				</picture>
			</div>
		<?php endif; ?>
		<div class="article__content">
			<?php echo do_shortcode(apply_filters('the_content', $main_content)); ?>
			<!-- < ?php echo apply_filters('the_content', $main_content); ? > -->
		</div>
	</div>
</section>


<?php if (!empty($custom_blocks)) : ?>
	<?php echo do_shortcode($custom_blocks); ?>
<?php endif; ?>

<?php
endwhile;

get_footer();
