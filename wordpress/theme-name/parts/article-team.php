<?php
$team_members = get_query_var('wpb_article_team_members', []);

if (empty($team_members)) {
  return;
}
?>

<div class="article__team">
  <?php foreach ($team_members as $member) : ?>
    <div class="article__team_item">
      <div class="article__team_title"><?php echo esc_html($member['role']); ?>:</div>
      <div class="article__team_list">
        <?php
        $count = count($member['journalists']);
        foreach ($member['journalists'] as $index => $journalist) :
          $is_last = ($index === $count - 1);
          $url = $journalist['url'];
          $has_link = !empty($url) && $url !== '#';
          ?>
          <?php if ($has_link) : ?>
          <a class="article__item_name" href="<?php echo esc_url($url); ?>"><?php echo esc_html($journalist['name']); ?></a>
        <?php else : ?>
          <span class="article__item_name"><?php echo esc_html($journalist['name']); ?></span>
        <?php endif; ?>
          <?php if (!$is_last) : ?>,&nbsp;<?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>