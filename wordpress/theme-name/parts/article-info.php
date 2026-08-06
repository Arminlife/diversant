<?php
$tags = get_query_var('article_info_tags', []);
$post_url = get_query_var('article_info_url', '');
$post_title = get_query_var('article_info_title', '');
$post_url_encoded = urlencode($post_url);
$post_title_encoded = urlencode($post_title);
?>

<section class="section info section--border_mod">
	<div class="section_in section_in--border_mod">
		<div class="info__cols">
			<div class="info__col">
				<div class="info__col_content">
					<div class="info__col_title">Теги:</div>
					<?php if (!empty($tags)) : ?>
						<ul class="info__tags">
							<?php foreach ($tags as $tag) : ?>
								<li class="info__tags_item">
							<div class="info__tag">
										<?php echo esc_html($tag->name); ?>
							</div>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			</div>
			<div class="info__col">
				<div class="info__col_content">
					<div class="info__col_title">Поширити публікацію:</div>
					<div class="info__share">
						<ul class="info__share_list">
							<?php
							$share_links = [
								[
									'icon' => 'facebook',
									'url' => "https://www.facebook.com/sharer/sharer.php?u={$post_url_encoded}",
									'data_attr' => ''
								],
								[
									'icon' => 'telegram',
									'url' => "https://t.me/share/url?url={$post_url_encoded}&text={$post_title_encoded}",
									'data_attr' => ''
								],
								[
									'icon' => 'x',
									'url' => "https://twitter.com/intent/tweet?url={$post_url_encoded}&text={$post_title_encoded}",
									'data_attr' => ''
								],
								[
									'icon' => 'whatsapp',
									'url' => "https://wa.me/?text={$post_title_encoded}%20{$post_url_encoded}",
									'data_attr' => ''
								],
								[
									'icon' => 'copy',
									'url' => '#',
									'data_attr' => 'data-copy="' . esc_attr($post_url) . '"',
									"mod" => 'js-copy-btn'
								]
							];

							foreach ($share_links as $link) :
							?>
								<li class="info__share_item">
									<a class="info__share_link <?php echo isset($link['mod']) ? esc_attr($link['mod']) : ''; ?>" href="<?php echo esc_url($link['url']); ?>" <?php echo $link['data_attr']; ?> target="_blank" rel="noopener noreferrer">
										<span class="icon icon--size_mod" data-sprite-icon="<?php echo esc_attr($link['icon']); ?>">
											<?php echo Utils::the_icon($link['icon']); ?>
										</span>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
