<?php

add_action( 'wp_ajax_ajax_filter_stories', 'ajax_filter_stories_callback' );
add_action( 'wp_ajax_nopriv_ajax_filter_stories', 'ajax_filter_stories_callback' );

function ajax_filter_stories_callback() {
    $termId = $_GET['terms'];
    $posts_array = new WP_Query (
        array(
            'posts_per_page' => 6,
            'post_type' => 'success-stories',
            'paged' => 1,
            'post_status'    => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'success-stories-category',
                    'field' => 'term_id',
                    'terms' => $termId,
                )
            )
        )
    );

    if($posts_array->have_posts()) {
        while ( $posts_array->have_posts() ) {
            $posts_array->the_post();
            get_template_part('templates/success-stories-post');
        } wp_reset_postdata();
    } else {
        echo '';
    }
    wp_die();
}

add_action( 'wp_ajax_ajax_load_stories', 'ajax_load_stories_callback' );
add_action( 'wp_ajax_nopriv_ajax_load_stories', 'ajax_load_stories_callback' );

function ajax_load_stories_callback() {
    $termId = $_GET['terms'];
    $paged = $_GET['paged'];
    $posts_array = new WP_Query (
        array(
            'posts_per_page' => 6,
            'post_type' => 'success-stories',
            'paged' => $paged,
            'post_status'    => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'success-stories-category',
                    'field' => 'term_id',
                    'terms' => $termId,
                )
            )
        )
    );

    $test_array = new WP_Query (
        array(
            'posts_per_page' => 6,
            'post_type' => 'success-stories',
            'paged' => $paged + 1,
            'post_status'    => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'success-stories-category',
                    'field' => 'term_id',
                    'terms' => $termId,
                )
            )
        )
    );
    ob_start();
    if($posts_array->have_posts()) {
        while ( $posts_array->have_posts() ) {
            $posts_array->the_post();
            get_template_part('templates/success-stories-post');
        } wp_reset_postdata();
    } else {
        echo '';
    }
    $data = array([
        'html' => ob_get_clean(),
        'foundPosts' => $test_array->found_posts
    ]);

    wp_send_json($data);
    wp_die();
}
