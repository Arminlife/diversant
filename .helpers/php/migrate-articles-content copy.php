<?php



function migrate_gutenberg_blocks_from_scheme($migration_scheme, $post_type = 'service', $post_ids) {
    if (empty($migration_scheme) || !is_array($migration_scheme)) return;

    $args = [
        'post_type' => 'service',
        'posts_per_page' => -1,
        'post_status' => 'any',
    ];

    $posts = get_posts($args);
    echo 'posts count: ' . count($posts) . PHP_EOL;

    foreach ($posts as $post) {
        $post_id = $post->ID;
        echo $post_id;

        if (!in_array($post_id, $post_ids)) continue;
        echo '3';

        $content = $post->post_content;
        $blocks = parse_blocks($content);
        echo ' Processing post ID: ' . $post->ID . PHP_EOL;

        $scheme = $migration_scheme;
        $used_keys = [];

        // Обробляємо блоки по порядку схеми
        migrate_blocks_sequentially($blocks, $scheme, $used_keys);

        wp_update_post([
            'ID' => $post->ID,
            'post_content' => serialize_blocks($blocks),
        ]);

        // Обробляємо ACF поля (з флагом option)
        foreach ($scheme as $index => $item) {
            if (!empty($item['option']) && !empty($item['key']) && empty($used_keys['scheme_' . $index])) {
                if (!empty($item['items']) && is_array($item['items'])) {
                    update_field($item['key'], $item['items'], $post->ID);
                } elseif (!empty($item['text'])) {
                    update_field($item['key'], $item['text'], $post->ID);
                }

                if (isset($item['url'])) {
                    update_field($item['key'] . '_url', $item['url'], $post->ID);
                }
                $used_keys['scheme_' . $index] = true;
            }
        }
    }
}

function migrate_blocks_sequentially(&$blocks, $scheme, &$used_keys) {
    // Проходимо по схемі послідовно
    foreach ($scheme as $scheme_index => $scheme_item) {
        // Пропускаємо option поля - вони обробляються окремо
        if (!empty($scheme_item['option'])) continue;

        // Пропускаємо вже використані елементи схеми
        if (!empty($used_keys['scheme_' . $scheme_index])) continue;

        $field_key = $scheme_item['key'];

        // Шукаємо поле в блоках
        $field_found = find_and_update_field_in_blocks($blocks, $field_key, $scheme_item, $used_keys, $scheme_index);

        if ($field_found) {
            $used_keys['scheme_' . $scheme_index] = true;
        }
    }
}

function find_and_update_field_in_blocks(&$blocks, $field_key, $scheme_item, &$used_keys, $scheme_index) {
    $field_found = false;

    foreach ($blocks as &$block) {
        if (!empty($block['attrs']['data'])) {
            // Перевіряємо чи є потрібне поле в цьому блоці
            if (array_key_exists($field_key, $block['attrs']['data'])) {
                // Якщо це репітер
                if (!empty($scheme_item['items']) && is_array($scheme_item['items'])) {
                    populate_repeater_field($block, $field_key, $scheme_item['items']);
                    $field_found = true;
                    break;
                }
                // Якщо це звичайне поле
                else {
                    $field_found = update_single_field($block, $field_key, $scheme_item);
                    if ($field_found) break;
                }
            }
        }

        // Рекурсивно обробляємо inner blocks
        if (!empty($block['innerBlocks'])) {
            $inner_found = find_and_update_field_in_blocks($block['innerBlocks'], $field_key, $scheme_item, $used_keys, $scheme_index);
            if ($inner_found && !$field_found) {
                $field_found = true;
            }
        }
    }

    return $field_found;
}

function update_single_field(&$block, $field_key, $scheme_item) {
    // Пропускаємо системні поля ACF (які починаються з _)
    if (strpos($field_key, '_') === 0) {
        return false;
    }

    // Пропускаємо підполя репітерів (які містять цифри)
    if (preg_match('/_\d+_/', $field_key)) {
        return false;
    }

    $field_value = &$block['attrs']['data'][$field_key];

    if (!empty($scheme_item['text'])) {
        $field_value = decode_html_unicode($scheme_item['text']);
        return true;
    }
    elseif (!empty($scheme_item['title'])) {
        // Обробляємо title для лінків
        if (is_array($field_value) && isset($field_value['title'])) {
            $field_value['title'] = decode_html_unicode($scheme_item['title']);
        } else {
            $field_value = decode_html_unicode($scheme_item['title']);
        }
        return true;
    }
    elseif (isset($scheme_item['url'])) {
        // Обробляємо URL для лінків та зображень
        if (is_array($field_value)) {
            $field_value['url'] = $scheme_item['url'];
        } else {
            $block['attrs']['data'][$field_key . '_url'] = $scheme_item['url'];
        }
        return true;
    }

    return false;
}

function populate_repeater_field(&$block, $base_field_key, $items) {
    // Встановлюємо кількість елементів репітера
    $block['attrs']['data'][$base_field_key] = count($items);

    // Заповнюємо підполя репітера
    foreach ($items as $index => $item_data) {
        if (!is_array($item_data)) continue;

        foreach ($item_data as $sub_field => $sub_value) {
            $full_key = $base_field_key . '_' . $index . '_' . $sub_field;

            // Обробляємо вкладені об'єкти (наприклад, зображення)
            if (is_array($sub_value)) {
                // Якщо це об'єкт з url (наприклад, зображення)
                if (isset($sub_value['url'])) {
                    // Спробуємо знайти зображення в медіабібліотеці по URL
                    $attachment_id = get_attachment_id_by_url($sub_value['url']);

                    if ($attachment_id) {
                        // Якщо знайшли зображення, зберігаємо його ID
                        $block['attrs']['data'][$full_key] = $attachment_id;
                    } else {
                        // Якщо не знайшли, створюємо об'єкт зображення для ACF
                        $image_data = [
                            'ID' => 0,
                            'url' => $sub_value['url'],
                            'alt' => '',
                            'title' => '',
                            'caption' => '',
                            'description' => ''
                        ];
                        $block['attrs']['data'][$full_key] = $image_data;
                    }
                } else {
                    // Якщо масив не містить URL, зберігаємо як є
                    $block['attrs']['data'][$full_key] = $sub_value;
                }
            } else {
                $block['attrs']['data'][$full_key] = decode_html_unicode($sub_value);
            }
        }
    }
}

/**
 * Знаходить ID attachment по URL
 */
function get_attachment_id_by_url($url) {
    // Видаляємо домен з URL для пошуку
    $parsed_url = parse_url($url);
    $path = $parsed_url['path'];

    // Видаляємо /wp-content/uploads/ з початку шляху
    $upload_dir = wp_upload_dir();
    $upload_path = parse_url($upload_dir['baseurl'], PHP_URL_PATH);

    if (strpos($path, $upload_path) === 0) {
        $relative_path = substr($path, strlen($upload_path));
        $relative_path = ltrim($relative_path, '/');

        // Шукаємо attachment по відносному шляху
        global $wpdb;
        $attachment_id = $wpdb->get_var($wpdb->prepare(
            "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND guid LIKE %s",
            '%' . $relative_path
        ));

        return $attachment_id ? intval($attachment_id) : false;
    }

    return false;
}

add_action('acf/init', function() {
    $all_schemes = json_decode(file_get_contents(get_template_directory() . '/migration-output.json'), true);

    if (!is_array($all_schemes)) return;

    foreach ($all_schemes as $entry) {
        if (!empty($entry['files']) && is_array($entry['files'])) {
            foreach ($entry['files'] as $file) {
                if (!empty($file['post_id']) && !empty($file['scheme']) && is_array($file['scheme'])) {
                    migrate_gutenberg_blocks_from_scheme($file['scheme'], 'service', [$file['post_id']]);
                }
                if (!empty($file['post_id']) && !empty($file['seo']) && is_array($file['seo'])) {
                    update_yoast_seo_fields($file['post_id'], $file['seo']);
                }
            }
        }
    }
});

/**
 * Оновлення Yoast SEO полів для поста
 */
function update_yoast_seo_fields($post_id, $seo_data) {
    if (empty($post_id) || empty($seo_data) || !is_array($seo_data)) return;

    if (!empty($seo_data['title'])) {
        update_post_meta($post_id, '_yoast_wpseo_title', $seo_data['title']);
    }
    if (!empty($seo_data['description'])) {
        update_post_meta($post_id, '_yoast_wpseo_metadesc', $seo_data['description']);
    }
    if (!empty($seo_data['ogTitle'])) {
        update_post_meta($post_id, '_yoast_wpseo_opengraph-title', $seo_data['ogTitle']);
    }
    if (!empty($seo_data['ogDescription'])) {
        update_post_meta($post_id, '_yoast_wpseo_opengraph-description', $seo_data['ogDescription']);
    }
}