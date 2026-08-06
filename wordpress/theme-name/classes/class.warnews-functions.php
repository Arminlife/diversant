<?php
/**
 * Warnews Functions
 *
 * @package		slidstvo.info
 * @author		Tangram
 */

defined( 'ABSPATH' ) || die();

class WarnewsFunctions
{
    public static function getAllPostMarkedLikeWarnews()
    {
        $posts = (new WP_Query([
            'post_type' => ['articles', 'news'],
            'tax_query' => [
                [
                    'taxonomy' => 'investigation_type',
                    'field' => 'slug',
                    'terms' => 'warnews'
                ]
            ]
        ]));
        return $posts->get_posts();
    }

    public static function getAllWarnewsYears()
    {
        global $wpdb;
        $result = array();

        $allPostsWithYears = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$wpdb->posts} p INNER JOIN {$wpdb->postmeta} pm ON p.id = pm.post_id  WHERE p.post_status = 'publish' AND p.post_type = 'warnews' AND pm.meta_key = 'wpcf-warnews_date' "
            ),
            ARRAY_A
        );

        $years;

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
                'post_type' => 'warnews',
                'meta_query' => [
                    'relation' => 'AND',
                    [
                        'key' => 'wpcf-warnews_date',
                        'value' => strtotime($year . '/01/01'),
                        'compare' => '>=',
                        'TYPE' => 'UNSIGNED'
                    ],
                    [
                        'key' => 'wpcf-warnews_date',
                        'value' => strtotime($year + 1 . '/01/01'),
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

    public static function getPreviousWarnews()
    {
        return (new WP_Query([
            'post_type' => 'warnews',
            'meta_key' => 'wpcf-warnews_date',
            'orderby' => 'meta_key',
            'order' => 'desc',
            'meta_query' => [
                'key' => 'wpcf-warnews_date',
                'value' => time(),
                'compare' => '<=',
                'type' => 'UNSIGNED'
            ]
        ]))->get_posts()[0];
    }

    public static function getCurrentWarnews()
    {
        return (new WP_Query([
            'post_type' => 'warnews',
            'meta_key' => 'wpcf-warnews_date',
            'orderby' => 'meta_key',
            'order' => 'asc',
            'meta_query' => [
                'key' => 'wpcf-warnews_date',
                'value' => strtotime("today"),
                'compare' => '>=',
                'type' => 'UNSIGNED'
            ]
        ]))->get_posts()[0];
    }


    public static function getNextWarnews()
    {
        return (new WP_Query([
            'post_type' => 'warnews',
            'meta_key' => 'wpcf-warnews_date',
            'orderby' => 'meta_key',
            'order' => 'asc',
            'meta_query' => [
                'key' => 'wpcf-warnews_date',
                'value' => strtotime("today"),
                'compare' => '>=',
                'type' => 'UNSIGNED'
            ]
        ]))->get_posts()[1];
    }

    public static function getAllMonthWarnews()
    {
        return (new WP_Query([
            'post_type' => 'warnews',
            'meta_key' => 'wpcf-warnews_date',
            'orderby' => 'meta_key',
            'order' => 'asc',
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => 'wpcf-warnews_date',
                    'value' => strtotime("first day of this month"),
                    'compare' => '>=',
                    'type' => 'UNSIGNED'
                ],
                [
                    'key' => 'wpcf-warnews_date',
                    'value' => strtotime("first day of next month"),
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

    public static function format_warnews_tape_date($warnews)
    {
        $date = (new DateTime ($warnews->post_date))->format("d m Y, H:i");

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
    public static function format_warnews_date($warnews)
    {
        $warnews_date = gmdate("Y m d", get_field('wpcf-warnews_date', $warnews->ID));
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
        $month = " ".explode(" ", $warnews_date)[1]. " ";
        $warnews_date = str_replace($month, $_monthsList[$month], $warnews_date);
        $warnews_date = explode(' ', $warnews_date);
        return $warnews_date[2] . " " . $warnews_date[1];
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

    public static function getWarnewsRelatedPosts($term_id)
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
