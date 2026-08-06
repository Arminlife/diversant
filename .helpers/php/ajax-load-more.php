<?php
/**
 * AJAX handler to load more posts.
 * This function retrieves posts based on the provided parameters and returns them in a JSON format.
 */
function ajax_load_more_posts() {
    $paged = intval($_POST['page'] ?? 1);
    $per_page = intval($_POST['per_page'] ?? 8);
    $post_type = sanitize_text_field($_POST['post_type'] ?? 'post');
    $term_id = sanitize_text_field($_POST['term_id'] ?? '');
    $taxonomy = sanitize_text_field($_POST['taxonomy'] ?? '');
    $sort_by = sanitize_text_field($_POST['sort_by'] ?? 'date');
    $sort_order = sanitize_text_field($_POST['sort_order'] ?? 'DESC');

    $args = array(
        'post_type' => $post_type,
        'post_status' => 'publish',
        'posts_per_page' => $per_page,
        'paged' => $paged,
        'orderby' => $sort_by,
        'order' => $sort_order,
    );

    if (!empty($term_id) && !empty($taxonomy) && $term_id !== '0') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => $taxonomy,
                'field' => 'term_id',
                'terms' => intval($term_id),
            ),
        );
    }

    $query = new WP_Query($args);

    ob_start();
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $post_id = get_the_ID();
						$post_type = get_post_type();
            $full_mod = get_field('case_full_mod', $post_id);
            $item_classes = ['listing__articles_item'];
            if ($full_mod) {
                $item_classes[] = 'listing__articles_item--full_mod';
            }
						echo '<li class="' . esc_attr(implode(' ', $item_classes)) . '">';

						if ($post_type == 'case') {
							include get_template_directory() . '/template_parts/components/case_card.php';
						} else if ($post_type == 'blog-article') {
							include get_template_directory() . '/template_parts/components/article_card.php';
						}

            echo '</li>';
        endwhile;
        wp_reset_postdata();
    endif;
    $posts_html = ob_get_clean();

    wp_send_json([
        'posts_html' => $posts_html,
        'has_more' => $paged < $query->max_num_pages,
        'current_page' => $paged,
        'max_pages' => $query->max_num_pages,
    ]);
}


add_action('wp_ajax_load_more_posts', 'ajax_load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'ajax_load_more_posts');
