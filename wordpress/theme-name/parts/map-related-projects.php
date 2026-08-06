<?php

$wpb_projects_ids = get_query_var('wpb_related_projects_ids', []);
$details_text = get_query_var('wpb_related_projects_details_text', 'Детальніше');
$projects = [];

if (!empty($wpb_projects_ids)) {
	$projects = array_map('get_post', $wpb_projects_ids);
	$projects = array_filter($projects);
}

if (count($projects) < 2) {
	$needed = 2 - count($projects);
	$exclude_ids = !empty($projects) ? wp_list_pluck($projects, 'ID') : [];
	$exclude_ids[] = get_the_ID();

	$latest_projects = get_posts([
		'post_type' => 'special-projects',
		'posts_per_page' => $needed,
		'exclude' => $exclude_ids,
		'orderby' => 'date',
		'order' => 'DESC'
	]);

	$projects = array_merge($projects, $latest_projects);
}

$projects = array_slice($projects, 0, 2);


?>

<?php if (!empty($projects)) : ?>

	<section class="section projects section--border_mod">
		<div class="section_in section_in--border_mod">
			<div class="projects__head">
				<div class="projects__title">інші спецпроєкти</div>
				<div class="projects__button"><a class="button button--v2_mod" href="<?php home_url('/special-projects') ?>">
						<div class="button__title">Усі спецпроєкти</div>
						<div class="button__icon">
							<span class="icon icon--size_mod" data-sprite-icon="arrow">
									<?php echo Utils::the_icon('arrow'); ?>
								</span>
						</div>
					</a></div>
			</div>
			<ul class="news__list news__list--v2_mod">
				<?php foreach ($projects as $project) :
					$project_id = $project->ID;
					$project_title = get_the_title($project_id);
					$project_excerpt = get_the_excerpt($project_id);
					$project_permalink = get_permalink($project_id);
					$project_image_id = get_post_thumbnail_id($project_id);
					$project_image_url = get_the_post_thumbnail_url($project_id, 'large');
					$project_image_alt = get_post_meta($project_image_id, '_wp_attachment_image_alt', true);
					?>
					<li class="news__item">
						<a class="news__link" href="<?php echo esc_url($project_permalink); ?>">
							<?php if (!empty($project_image_url)) : ?>
								<picture class="news__image">
									<img class="news__image_el" src="<?php echo esc_url($project_image_url); ?>"
											 alt="<?php echo esc_attr($project_image_alt ?: $project_title); ?>" loading="lazy">
								</picture>
							<?php endif; ?>
							<?php if (!empty($project_title)) : ?>
								<div class="news__title"><?php echo esc_html($project_title); ?></div>
							<?php endif; ?>
							<?php if (!empty($project_excerpt)) : ?>
								<div class="news__text"><?php echo esc_html($project_excerpt); ?></div>
							<?php endif; ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
<?php endif; ?>
