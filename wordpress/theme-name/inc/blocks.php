<?php


class Blocks
{
	static $path = TEMPLATEPATH . '/template_parts/blocks/';

	/**
	 * Get block name without prefix
	 */
	public static function get_block_name($block)
	{
		$block_name = str_replace('acf/', '', $block['name']);
		return $block_name;
	}

	public static function register_blocks()
	{
		add_filter('block_categories_all', array(__CLASS__, 'set_block_categories'), 10);
		add_action('admin_enqueue_scripts', array(__CLASS__, 'load_admin_styles'));

		if ( is_dir( self::$path ) ) {
			if ( $blocks = opendir( self::$path ) ) {
				while ( ( $block = readdir( $blocks ) ) !== false ) {
					if ( $block != '.' && $block != '..' && $block[0] != '.' ) {
						register_block_type( self::$path . $block );
					}
				}
			}
		}
	}

	/**
	 * Load styles for blocks in the admin area
	 */
	static function load_admin_styles()
	{
		// wp_enqueue_style('admin_gutenstyles', get_template_directory_uri() . '/assets/css/app.css', false, '1.0.0');
	}

	/**
	 * Register new category for Theme blocks
	 */
	static function set_block_categories($categories)
	{
		return array_merge(
			array(
				array(
					'slug' => 'casey-blocks',
					'title' => 'La Casey Blocks',
					'icon'  => 'block-default',
				),
			),
			$categories
		);
	}

	static function set_block_icon($block)
	{
		$file = get_template_directory_uri() . '/template_parts/blocks/' . $block . '/icon.svg';

		if (!file_exists($file)) {
			return file_get_contents($file);
		} else {
			return 'block-default';
		}
	}

	static function get_block_preview($block)
	{
		$block_preview = $block['data']['preview_img'];
		if ($block_preview) {
			return <<<BlockPreview
				<img class="block-preview-image" src="$block_preview" />
BlockPreview;
		} else {
			return false;
		}
	}

}

// Initialization
//Blocks::register_blocks();
