<?php

// <!-- copy sections on elementor -->
add_action('init', function () {
		$target_locale = 'uk';
		$main_page_id = 4409;
		$section_id_from = '09c2186'; // Section ID to copy
		$section_id_to = '9419';      // ID to assign to the new section

		// Find main page translation for target locale
		$source_page_id = $main_page_id;
		if (function_exists('pll_get_post_translations')) {
			$translations = pll_get_post_translations($main_page_id);
			if (isset($translations[$target_locale])) {
				$source_page_id = $translations[$target_locale];
			} else {
				error_log("Main page translation not found for locale: {$target_locale}");
				return;
			}
		}

		$main_content = get_post_meta($source_page_id, '_elementor_data', true);
		$main_content_arr = json_decode($main_content, true);

		if (empty($main_content_arr)) {
			error_log("Main page content is empty for ID: {$source_page_id}");
			return;
		}

		// Recursive function to find section
		$find_section = function ($arr, $section_id) use (&$find_section) {
			foreach ($arr as $section) {
				if (isset($section['id']) && $section['id'] === $section_id) {
					return $section;
				}
				if (!empty($section['elements'])) {
					$found = $find_section($section['elements'], $section_id);
					if ($found) return $found;
				}
			}
			return null;
		};

		// Recursive function to replace section
		$replace_section = function (&$arr, $section_id, $new_section) use (&$replace_section) {
			foreach ($arr as $key => &$section) {
				if (isset($section['id']) && $section['id'] === $section_id) {
					$arr[$key] = $new_section;
					return true;
				}
				if (!empty($section['elements'])) {
					if ($replace_section($section['elements'], $section_id, $new_section)) {
						return true;
					}
				}
			}
			return false;
		};

		$main_section = $find_section($main_content_arr, $section_id_from);
		if (!$main_section) {
			error_log("Section with ID {$section_id_from} not found on main page ID: {$source_page_id} (locale: {$target_locale})");
			return;
		}

		// Change section ID to new one
		$main_section['id'] = $section_id_to;

		$args = [
			'post_type' => 'page',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'meta_query' => [
				[
					'key' => '_elementor_data',
					'compare' => 'EXISTS'
				]
			]
		];

		$pages = get_posts($args);
		$updated_pages = 0;

		foreach ($pages as $page) {
			// Check page locale
			if (function_exists('pll_get_post_language')) {
				$page_locale = pll_get_post_language($page->ID);
				if ($page_locale !== $target_locale) {
					continue;
				}
			}

			// Skip main page (original and translations)
			if (function_exists('pll_get_post_translations')) {
				$page_translations = pll_get_post_translations($page->ID);
				if (in_array($main_page_id, $page_translations) || in_array($source_page_id, $page_translations) || $page->ID == $source_page_id) {
					continue;
				}
			} else {
				if ($page->ID == $main_page_id || $page->ID == $source_page_id) {
					continue;
				}
			}

			$content = get_post_meta($page->ID, '_elementor_data', true);
			$content_arr = json_decode($content, true);

			if (empty($content_arr)) {
				continue;
			}

			// Replace section with original or new ID
			$section_replaced = $replace_section($content_arr, $section_id_from, $main_section);

			// If section with original ID not found, try to replace section with new ID
			if (!$section_replaced) {
				$section_replaced = $replace_section($content_arr, $section_id_to, $main_section);
			}

			// If no section replaced, add new section to the end
			if (!$section_replaced) {
				$content_arr[] = $main_section;
				$section_replaced = true;
				error_log("Section added to the end on page ID: {$page->ID}");
			}

			if ($section_replaced) {
				// Update page content
				$updated_content = wp_slash(json_encode($content_arr));
				update_post_meta($page->ID, '_elementor_data', $updated_content);

				// Clear Elementor cache for this page
				if (class_exists('\Elementor\Plugin')) {
					\Elementor\Plugin::$instance->files_manager->clear_cache();
				}

				$updated_pages++;
				error_log("Section updated on page ID: {$page->ID}");
			}
		}

		error_log("Process finished. Updated {$updated_pages} pages.");
});