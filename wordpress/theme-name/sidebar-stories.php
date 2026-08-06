<?php
$argsStories = array(
  'posts_per_page' => 5,
  'post_type' => 'success-stories',
  'order' => 'DESC'
);
$queryStories = new WP_Query($argsStories);
?>

<div class="single-story-content__sidebar story-sidebar">
  <!--<h5 class="story-sidebar__title">
    ОСТАННІ НОВИНИ
  </h5>-->
  <ul class="story-sidebar__list">
    <?php
    // Цикл
    if ($queryStories->have_posts()) {
      while ($queryStories->have_posts()) {
        $queryStories->the_post();
    ?>
        <li class="story-sidebar__item story-sidebar-item">
          <a href="<?php the_permalink() ?>" class="story-sidebar-item__title"><?php echo get_short_title(80) ?></a>
          <p class="story-sidebar-item__date"><?php the_date(); ?></p>
        </li>
    <?php
      }
    } else {
      // Постов не найдено
    }

    wp_reset_postdata();
    ?>
  </ul>
</div>