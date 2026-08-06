<?php

/**
 * Render Gutenberg blocks with specific handling for ACF blocks and lists.
 *
 * @param array $blocks Array of block data.
 * @param array $excluded_blocks Array of block names to exclude from rendering.
 * @return string Rendered HTML output of the blocks.
 */


function render_gutenberg_blocks($blocks, $excluded_blocks = []) {
	if (empty($blocks) || !is_array($blocks)) {
		return '';
	}
	$output = '';
	foreach ($blocks as $block) {
		if (
			isset($block['blockName']) &&
			strpos($block['blockName'], 'acf/') !== false &&
			in_array($block['blockName'], $excluded_blocks)
		) {
			$output .= render_block($block);
			continue;
		}

		if (
			isset($block['blockName']) &&
			in_array($block['blockName'], ['core/list', 'core/ul', 'core/ol'])
		) {
			$is_ordered = false;
			if (
				isset($block['blockName']) &&
				($block['blockName'] === 'core/list') &&
				!empty($block['attrs']['ordered'])
			) {
				$is_ordered = true;
			}

			$tag = $is_ordered || $block['blockName'] === 'core/ol' ? 'ol' : 'ul';
			$class = '';
			if (!empty($block['attrs']['className'])) {
				$class = ' class="' . esc_attr($block['attrs']['className']) . '"';
			} elseif (!empty($block['attrs']['anchor'])) {
				$class = ' id="' . esc_attr($block['attrs']['anchor']) . '"';
			} elseif (preg_match('/class="([^"]+)"/', $block['innerHTML'], $m)) {
				$class = ' class="' . esc_attr($m[1]) . '"';
			}
			$output .= "<$tag$class>";
			if (!empty($block['innerBlocks'])) {
				$output .= render_gutenberg_blocks($block['innerBlocks'], $excluded_blocks);
			} elseif (!empty($block['innerHTML'])) {
				// fallback, якщо немає innerBlocks
				$output .= $block['innerHTML'];
			}
			$output .= "</$tag>";
			continue;
		}

		if (!empty($block['innerBlocks'])) {
			$output .= render_gutenberg_blocks($block['innerBlocks'], $excluded_blocks);
			continue;
		}

		if (
			strpos($block['blockName'], 'acf/') === false &&
			!in_array($block['blockName'], $excluded_blocks)

		) {
			if (isset($block['blockName'])) {
				$output .= render_block($block);
			} else {
				$output .= $block['innerHTML'] ?? '';
			}
		}
	}
	return $output;
}
