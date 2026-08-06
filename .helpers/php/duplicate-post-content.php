<?php
function duplicate_post_content_to_all_posts($source_post_id, $post_type = 'service') {
    $source_post = get_post($source_post_id);
    if (!$source_post) return;

    $content = $source_post->post_content;
    $content = str_replace('u0022', '"', $content);

    $posts = get_posts([
        'post_type' => $post_type,
        'numberposts' => -1,
        'post_status' => 'publish',
        'exclude' => [$source_post_id],
    ]);

		echo 'Posts count: ';
    var_dump(count($posts));

    foreach ($posts as $post) {
        wp_update_post([
            'ID' => $post->ID,
            'post_content' => $content,
        ]);
    }
}

// Приклад використання:
add_action('acf/init', function(): void {
    duplicate_post_content_to_all_posts( 842, 'service');
});

