<?php

/**
 * AJAX handler to refresh posts based on taxonomy and sorting parameters.
 * This function retrieves posts according to the specified criteria and returns them in a JSON format.
 */
function ajax_refresh_posts() {
    $term_id = $_POST['term_id'] ?? '';
    $taxonomy = $_POST['taxonomy'] ?? '';
    $post_type = $_POST['post_type'] ?? 'post';
    $per_page = $_POST['per_page'] ?? 8;
    $sort_by = $_POST['sort_by'] ?? 'date';
    $sort_order = $_POST['sort_order'] ?? 'DESC';

    $args = array(
        'post_type' => $post_type,
        'post_status' => 'publish',
        'posts_per_page' => $per_page,
        'orderby' => $sort_by,
        'order' => $sort_order,
    );

    if (!empty($term_id) && !empty($taxonomy)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => $taxonomy,
                'field' => 'term_id',
                'terms' => $term_id,
            ),
        );
    }

    $query = new WP_Query($args);

    $main_taxonomy = $taxonomy;
    $terms = [];
    if ($main_taxonomy) {
        $terms = get_terms([
            'taxonomy' => $main_taxonomy,
            'hide_empty' => true,
        ]);
    }

    $listing_post_type = $post_type;
    $listing_posts_per_page = $per_page;
    $listing_show_load_more = true;
    $listing_load_more_text = 'Show more posts';

    ob_start();
    include get_template_directory() . '/template_parts/components/listing_tabs.php';
    $posts_html = ob_get_clean();

    wp_send_json([
        'posts_html' => $posts_html,
        'has_more' => $query->max_num_pages > 1,
        'total_posts' => $query->found_posts,
        'max_pages' => $query->max_num_pages
    ]);
}
add_action('wp_ajax_filter_posts', 'ajax_refresh_posts');
add_action('wp_ajax_nopriv_filter_posts', 'ajax_refresh_posts');
