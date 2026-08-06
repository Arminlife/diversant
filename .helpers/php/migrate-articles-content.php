<?php


function migrate_gutenberg_blocks_from_scheme($migration_scheme, $post_type = 'service', $post_ids) {
	if (empty($migration_scheme) || !is_array($migration_scheme)) return;

    $args = [
        'post_type' => 'service',
        'posts_per_page' => -1,
        'post_status' => 'any',
    ];


    $posts = get_posts($args);


    foreach ($posts as $post) {
				$post_id = $post->ID;

				if (!in_array($post_id, $post_ids)) continue;

        $content = $post->post_content;

        $blocks = parse_blocks($content);
  		  // echo ' Processing post ID: ' . $post->ID . PHP_EOL;

        $scheme = $migration_scheme;
        $used_keys = [];

        foreach ($blocks as &$block) {
            if (empty($block['attrs']['name']) && empty($block['blockName'])) continue;

            if (!empty($block['attrs']['data'])) {
                migrate_block_fields($block, $scheme, $used_keys);
            }

            if (!empty($block['innerBlocks'])) {
                $block['innerBlocks'] = migrate_gutenberg_inner_blocks($block['innerBlocks'], $scheme, $used_keys);
            }
        }

        wp_update_post([
            'ID' => $post->ID,
            'post_content' => serialize_blocks($blocks),
        ]);

        // Обробляємо ACF поля (з флагом option)
        foreach ($scheme as $item) {
            if (!empty($item['option']) && !empty($item['key']) && empty($used_keys[$item['key']])) {
                if (!empty($item['items']) && is_array($item['items'])) {
                    update_field($item['key'], $item['items'], $post->ID);
                } elseif (!empty($item['text'])) {
                    update_field($item['key'], $item['text'], $post->ID);
                }

                if (isset($item['url'])) {
                    update_field($item['key'] . '_url', $item['url'], $post->ID);
                }
                $used_keys[$item['key']] = true;
            }
        }
    }
}

function migrate_block_fields(&$block, $scheme, &$used_keys, $scheme_index = 0) {
    $current_scheme_index = $scheme_index;

    // Спочатку обробляємо репітери
    for ($i = $current_scheme_index; $i < count($scheme); $i++) {
        $item = $scheme[$i];

        if (!empty($item['option'])) continue;
        if (!empty($used_keys['scheme_' . $i])) continue; // Перевіряємо чи цей елемент схеми вже використаний

        // Якщо знайшли репітер поле в блоці
        if (!empty($item['items']) && is_array($item['items']) && array_key_exists($item['key'], $block['attrs']['data'])) {
            populate_repeater_field($block, $item['key'], $item['items']);
            $used_keys['scheme_' . $i] = true; // Помічаємо цей елемент схеми як використаний
            $current_scheme_index = $i + 1;
            break;
        }
    }

    // Потім обробляємо звичайні поля
    foreach ($block['attrs']['data'] as $field_key => &$field_value) {
        // Пропускаємо системні поля ACF (які починаються з _)
        if (strpos($field_key, '_') === 0) {
            continue;
        }

        // Пропускаємо підполя репітерів (які містять цифри)
        if (preg_match('/_\d+_/', $field_key)) {
            continue;
        }

        // Шукаємо відповідний елемент схеми починаючи з current_scheme_index
        for ($i = $current_scheme_index; $i < count($scheme); $i++) {
            $item = $scheme[$i];

            if (!empty($item['option'])) continue;
            if (!empty($used_keys['scheme_' . $i])) continue; // Перевіряємо чи цей елемент схеми вже використаний
            if ($item['key'] !== $field_key) continue;

            if (!empty($item['text'])) {
                $field_value = decode_html_unicode($item['text']);
                $used_keys['scheme_' . $i] = true; // Помічаємо цей елемент схеми як використаний
                $current_scheme_index = $i + 1;
                break;
            } elseif (!empty($item['title'])) {
                // Обробляємо title для лінків
                if (is_array($field_value) && isset($field_value['title'])) {
                    $field_value['title'] = decode_html_unicode($item['title']);
                } else {
                    $field_value = decode_html_unicode($item['title']);
                }
                $used_keys['scheme_' . $i] = true;
                $current_scheme_index = $i + 1;
                break;
            } elseif (isset($item['url'])) {
                // Обробляємо URL для лінків

                echo $item['url'];

                if (is_array($field_value)) {
                    $field_value['url'] = $item['url'];
                } else {
                    $block['attrs']['data'][$field_key . '_url'] = $item['url'];
                }
                $used_keys['scheme_' . $i] = true;
                $current_scheme_index = $i + 1;
                break;
            }
        }
    }

    return $current_scheme_index;
}

function populate_repeater_field(&$block, $base_field_key, $items) {
    $block['attrs']['data'][$base_field_key] = count($items);

    foreach ($items as $index => $item_data) {
        if (!is_array($item_data)) continue;

        foreach ($item_data as $sub_field => $sub_value) {
            $full_key = $base_field_key . '_' . $index . '_' . $sub_field;

            if (is_array($sub_value)) {
                if (isset($sub_value['url'])) {
                    $attachment_id = get_attachment_id_by_url($sub_value['url']);

                    if ($attachment_id) {
                        $block['attrs']['data'][$full_key] = $attachment_id;
                    } else {
                        $block['attrs']['data'][$full_key] = [
                            'ID' => 0,
                            'url' => $sub_value['url'],
                            'alt' => $sub_value['alt'] ?? '',
                            'title' => $sub_value['title'] ?? '',
                            'caption' => $sub_value['caption'] ?? '',
                            'description' => $sub_value['description'] ?? ''
                        ];
                    }
                } else {
                    $block['attrs']['data'][$full_key] = $sub_value;
                }
            } else {
                $block['attrs']['data'][$full_key] = decode_html_unicode($sub_value);
            }
        }
    }
}

function get_attachment_id_by_url($url) {
    if (empty($url)) return false;

    global $wpdb;

    // Спочатку шукаємо точний збіг URL
    $attachment_id = $wpdb->get_var($wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND guid = %s",
        $url
    ));

    if ($attachment_id) {
        return intval($attachment_id);
    }

    // Якщо не знайшли, шукаємо по частині URL
    $filename = basename(parse_url($url, PHP_URL_PATH));
    $attachment_id = $wpdb->get_var($wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND guid LIKE %s",
        '%' . $filename
    ));

    if ($attachment_id) {
        return intval($attachment_id);
    }

    // Якщо все ще не знайшли, створюємо заглушку
    return create_image_placeholder($url);
}

function create_image_placeholder($url) {
    if (empty($url)) return false;

    // Створюємо attachment запис з зовнішнім URL
    $filename = basename(parse_url($url, PHP_URL_PATH));
    $post_data = [
        'post_title' => $filename,
        'post_content' => '',
        'post_status' => 'inherit',
        'post_type' => 'attachment',
        'post_mime_type' => 'image/svg+xml',
        'guid' => $url
    ];

    $attachment_id = wp_insert_post($post_data);

    if (!is_wp_error($attachment_id)) {
        // Додаємо мета-дані
        update_post_meta($attachment_id, '_wp_attached_file', $filename);
        update_post_meta($attachment_id, '_wp_attachment_metadata', [
            'file' => $filename,
            'width' => 0,
            'height' => 0,
            'external_url' => $url
        ]);

        return $attachment_id;
    }

    return false;
}

function update_single_field(&$block, $field_key, $scheme_item) {
    if (strpos($field_key, '_') === 0) {
        return false;
    }

    if (preg_match('/_\d+_/', $field_key)) {
        return false;
    }

    $field_value = &$block['attrs']['data'][$field_key];

    if (!empty($scheme_item['text'])) {
        $field_value = decode_html_unicode($scheme_item['text']);
        return true;
    }
    elseif (!empty($scheme_item['title'])) {
        if (is_array($field_value) && isset($field_value['title'])) {
            $field_value['title'] = decode_html_unicode($scheme_item['title']);
        } else {
            $field_value = decode_html_unicode($scheme_item['title']);
        }
        return true;
    }
    elseif (isset($scheme_item['url'])) {
        // Перевіряємо чи це зображення
        if (strpos($field_key, 'image') !== false || strpos($field_key, 'bg_image') !== false) {
            $attachment_id = get_attachment_id_by_url($scheme_item['url']);
            if ($attachment_id) {
                $field_value = $attachment_id;
            } else {
                $field_value = [
                    'ID' => 0,
                    'url' => $scheme_item['url'],
                    'alt' => '',
                    'title' => '',
                    'caption' => '',
                    'description' => ''
                ];
            }
        } else {
            if (is_array($field_value)) {
                $field_value['url'] = $scheme_item['url'];
            } else {
                $block['attrs']['data'][$field_key . '_url'] = $scheme_item['url'];
            }
        }
        return true;
    }

    return false;
}

function migrate_gutenberg_inner_blocks($blocks, &$scheme, &$used_keys) {
    foreach ($blocks as &$block) {
        if (!empty($block['attrs']['data'])) {
            migrate_block_fields($block, $scheme, $used_keys);
        }

        if (!empty($block['innerBlocks'])) {
            $block['innerBlocks'] = migrate_gutenberg_inner_blocks($block['innerBlocks'], $scheme, $used_keys);
        }
    }
    return $blocks;
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