<?php
$wpb_article_ids = get_query_var('wpb_related_articles_ids', []);
$details_text = get_query_var('wpb_related_articles_details_text', 'Детальніше');
$articles = [];

if (!empty($wpb_article_ids)) {
	$articles = array_map('get_post', $wpb_article_ids);
	$articles = array_filter($articles);
}

if (count($articles) < 3) {
	$needed = 3 - count($articles);
	$exclude_ids = !empty($articles) ? wp_list_pluck($articles, 'ID') : [];
	$exclude_ids[] = get_the_ID();

	$latest_articles = get_posts([
		'post_type' => ['map-article', 'special-projects'],
		'posts_per_page' => $needed,
		'exclude' => $exclude_ids,
		'orderby' => 'date',
		'order' => 'DESC'
	]);

	$articles = array_merge($articles, $latest_articles);
}

$articles = array_slice($articles, 0, 3);
?>

<?php if (!empty($articles)) : ?>
<section class="section news section--border_mod">
	<div class="section_in section_in--border_mod">
		<ul class="news__list">
			<?php foreach ($articles as $article) :
				$article_id = $article->ID;
				$article_title = get_the_title($article_id);
				$article_excerpt = get_the_excerpt($article_id);
				$article_permalink = get_permalink($article_id);
				$article_post_type = get_post_type($article_id);

				if ($article_post_type === 'special-projects') {
					$listing_thumbnail = get_field('listing_thumbnail', $article_id);
					$article_image_url = !empty($listing_thumbnail) ? $listing_thumbnail['url'] : '';
					$article_image_alt = !empty($listing_thumbnail) ? $listing_thumbnail['alt'] : '';
				} else {
					$article_image_id = get_post_thumbnail_id($article_id);
					$article_image_url = get_the_post_thumbnail_url($article_id, 'large');
					$article_image_alt = get_post_meta($article_image_id, '_wp_attachment_image_alt', true);
				}
			?>
			<li class="news__item">
				<a class="news__link" href="<?php echo esc_url($article_permalink); ?>">
					<div class="news__poster">
						<div class="news__details">
							<?php echo esc_html($details_text); ?>
							<div class="news__details__icon">
								<span class="icon icon--size_mod" data-sprite-icon="arrow">
									<?php echo Utils::the_icon('arrow'); ?>
								</span>
							</div>
						</div>
						<?php if (!empty($article_image_url)) : ?>
						<picture class="news__image">
							<img class="news__image_el" src="<?php echo esc_url($article_image_url); ?>"
								alt="<?php echo esc_attr($article_image_alt ?: $article_title); ?>" loading="lazy">
						</picture>
						<?php endif; ?>
					</div>
					<?php if (!empty($article_title)) : ?>
					<div class="news__title"><?php echo esc_html($article_title); ?></div>
					<?php endif; ?>
					<!-- < ?php if (!empty($article_excerpt) && $article_post_type !== 'special-projects') : ?> -->
					<!-- <div class="news__text">< ?php echo esc_html($article_excerpt); ?></div> -->
					<!-- < ?php endif; ?> -->
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
<?php endif; ?>
