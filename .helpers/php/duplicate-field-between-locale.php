<?php

$cached_field_value = null;

function duplicate_acf_options_between_locales($field_names) {
	$option_key = 'acf_duplication';

	if (!function_exists('get_field') || !function_exists('update_field')) {
			return false;
	}

	$current_locale = function_exists('pll_current_language') ? pll_current_language() : '';

	if (empty($current_locale)) {
		return false;
	}

	$saved_fields = get_option($option_key) ?: [];


	$available_fields = acf_get_fields( 'group_66364290e4abd' );
	$current_post_id = 890;
	$target_post_id = 929;
	$fields_to_duplicate = [];

	if ($current_locale === 'en') {

		foreach ($available_fields as $field) {
			$fields_to_duplicate[$field['key']] = [
				'key' => $field['key'],
				'name' => $field['name'],
				'value' => get_field($field['name'], $current_post_id)
			];
		}

		$saved_fields = $fields_to_duplicate;

		update_option($option_key, $fields_to_duplicate);

	} elseif (!empty($saved_fields)) {
		foreach ($saved_fields as $key => $value) {
			update_field($value['name'], $value['value'] ?: '', $target_post_id);
		}
	} else {
		return false;
	}

	return true;
}


function example_usage() {
    // Поля для дублювання
    $fields_to_duplicate = [
        'hero_payments',
    ];

    // Дублюємо з української на англійську
    $result = duplicate_acf_options_between_locales(
        $fields_to_duplicate,
    );

}


add_action('wp', 'example_usage');