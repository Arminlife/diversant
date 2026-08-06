<?php

/**
 * Render Gutenberg ACF blocks with specific handling for excluded blocks.
 * Excluding basic blocks like lists and paragraphs.
 *
 * @param array $blocks Array of block data.
 * @param array $excluded_blocks Array of block names to exclude from rendering.
 * @return string Rendered HTML output of the blocks.
 */

function render_gutenberg_acf_blocks($blocks, $excluded_blocks = []) {
	if (empty($blocks) || !is_array($blocks)) {
		return '';
	}
	$output = '';
	foreach ($blocks as $block) {
		if (
			isset($block['blockName']) &&
			strpos($block['blockName'], 'acf/') !== false &&
			!in_array($block['blockName'], $excluded_blocks)
		) {
			$output .= render_block($block);
		}
	}
	return $output;
}
