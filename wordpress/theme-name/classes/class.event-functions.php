<?php
/**
 * Event Functions
 *
 * @package		slidstvo.info
 * @author		Tangram
 */

defined( 'ABSPATH' ) || die();

class EventFunctions
{
    public static function getAllPostMarkedLikeEvent()
    {
        $posts = (new WP_Query([
            'post_type' => ['articles', 'news'],
            'tax_query' => [
                [
                    'taxonomy' => 'investigation_type',
                    'field' => 'slug',
                    'terms' => 'events'
                ]
            ]
        ]));
        return $posts->get_posts();
    }

    public static function getAllEventYears()
    {
        global $wpdb;
        $result = array();

        $allPostsWithYears = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$wpdb->posts} p INNER JOIN {$wpdb->postmeta} pm ON p.id = pm.post_id  WHERE p.post_status = 'publish' AND p.post_type = 'events' AND pm.meta_key = 'wpcf-event_date' "
            ),
            ARRAY_A
        );

        $years = array();

        foreach ($allPostsWithYears as $postsWithYear) {
            $years[date('Y', $postsWithYear['meta_value'])] = null;
        }

        if (is_array($years) && count($years) > 0) {
            $result = array_keys($years);
        }
        return $result;
    }

    public static function getAllArchiveByYear($year)
    {
        return $posts = (new WP_Query(
            [
                'posts_per_page' => 350,
                'post_type' => 'events',
                'meta_query' => [
                    'relation' => 'AND',
                    [
                        'key' => 'wpcf-event_date',
                        'value' => $year . '0101',
                        'compare' => '>=',
                        'TYPE' => 'UNSIGNED'
                    ],
                    [
                        'key' => 'wpcf-event_date',
                        'value' => ($year + 1) . '0101',
                        'compare' => '<=',
                        'TYPE' => 'UNSIGNED'
                    ],
                ]
            ]
        ))->get_posts();
    }

    public static function getAllPartners()
    {
        return (new WP_Query([
            'post_type' => 'partners',
            'post_status' => 'publish'
        ]))->get_posts();
    }

    public static function getPreviousEvent()
    {
        return (new WP_Query([
            'post_type' => 'events',
            'meta_key' => 'wpcf-event_date',
            'orderby' => 'meta_key',
            'order' => 'desc',
            'meta_query' => [
                'key' => 'wpcf-event_date',
                'value' => date('Ymd', strtotime("-1 days")),
                'compare' => '<=',
                'type' => 'UNSIGNED'
            ]
        ]))->get_posts()[0];
    }

    public static function getCurrentEvent()
    {
        return (new WP_Query([
            'post_type' => 'events',
            'meta_key' => 'wpcf-event_date',
            'orderby' => 'meta_key',
            'order' => 'desc',
            'meta_query' => [
                'key' => 'wpcf-event_date',
                'value' => date("Ymd"),
                'compare' => '>=',
                'type' => 'UNSIGNED'
            ]
        ]))->get_posts()[0];
    }


    public static function getNextEvent()
    {
        return (new WP_Query([
            'post_type' => 'events',
            'meta_key' => 'wpcf-event_date',
            'orderby' => 'meta_key',
            'order' => 'asc',
            'meta_query' => [
                'key' => 'wpcf-event_date',
                'value' => date("Ymd"),
                'compare' => '>=',
                'type' => 'UNSIGNED'
            ]
        ]))->get_posts()[1];
    }

    public static function getAllMonthEvents()
    {
        return (new WP_Query([
            'post_type' => 'events',
            'meta_key' => 'wpcf-event_date',
            'orderby' => 'meta_key',
            'order' => 'asc',
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => 'wpcf-event_date',
                    'value' => date('Ymd', strtotime("first day of this month")),
                    'compare' => '>=',
                    'type' => 'UNSIGNED'
                ],
                [
                    'key' => 'wpcf-event_date',
                    'value' => date('Ymd', strtotime("first day of next month")),
                    'compare' => '<=',
                    'type' => 'UNSIGNED'
                ]
            ]
        ]))->get_posts();
    }

    public static function getNews($count)
    {
        // Get news
        return (new WP_Query([
            'posts_per_page' => $count,
            'post_type' => 'news',
        ]))->get_posts();
    }

    public static function format_event_tape_date($event)
    {
        $date = (new DateTime ($event->post_date))->format("d m Y, H:i");

        $_monthsList = array(
        " 01 " => " січня ",
        " 02 " => " лютого ",
        " 03 " => " березня ",
        " 04 " => " квітня ",
        " 05 " => " травня ",
        " 06 " => " червня ",
        " 07 " => " липня ",
        " 08 " => " серпня ",
        " 09 " => " вересня ",
        " 10 " => " жовтень ",
        " 11 " => " листопада ",
        " 12 " => " грудня "
        );
        $month = " ".explode(" ", $date)[1]. " ";
        return $date = str_replace($month, $_monthsList[$month], $date);
    }
    public static function format_event_date($event)
    {
        $event_date = date("Y m d", strtotime(get_field('wpcf-event_date', $event)));
        $_monthsList = array (
            " 01 " => " січня ",
            " 02 " => " лютого ",
            " 03 " => " березня ",
            " 04 " => " квітня ",
            " 05 " => " травня ",
            " 06 " => " червня ",
            " 07 " => " липня ",
            " 08 " => " серпня ",
            " 09 " => " вересня ",
            " 10 " => " жовтня ",
            " 11 " => " листопада ",
            " 12 " => " грудня "
        );
        $month = " ".explode(" ", $event_date)[1]. " ";
        $event_date = str_replace($month, $_monthsList[$month], $event_date);
        $event_date = explode(' ', $event_date);
        return $event_date[2] . " " . $event_date[1];
    }

    public static function getCurrentMonth()
    {
        $date = date("Y m d", time());
        $_monthsList = array (
            " 01 " => " Січень ",
            " 02 " => " Лютий ",
            " 03 " => " Березень ",
            " 04 " => " Квітнь ",
            " 05 " => " Травень ",
            " 06 " => " Червень ",
            " 07 " => " Липень ",
            " 08 " => " Серпень ",
            " 09 " => " Вересень ",
            " 10 " => " Жовтень ",
            " 11 " => " Листопад ",
            " 12 " => " Груднь "
        );
        $month = " ".explode(" ", $date)[1]. " ";
        $date = str_replace($month, $_monthsList[$month], $date);
        $date = explode(' ', $date);
        return $date[1] . " " . $date[0];
    }

    public static function getEventRelatedPosts($term_id)
    {
        return (new WP_Query(
        [
            'numberposts'	=> 3,
            'post_type'		=> [
                'post',
                'news',
                'articles',
                'video',
                'blogs'
            ],
            'tax_query' => [
                [
                    'taxonomy' => 'tags',
                    'field'    => 'term_id',
                    'terms'    => $term_id
                ]
            ]
//					'include'		=> $additional_materials,
        ]));
    }

}
