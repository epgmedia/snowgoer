<?php
/*
 * Ad Code
 */

include( 'ads/class.dfp_ad_positions.php');

add_action( 'wp_enqueue_scripts', 'dfp_enqueue_scripts' );

function dfp_enqueue_scripts() {

	$script_name = 'dfp-ads';

	// Register Script
	wp_register_script(
		$script_name,
		get_template_directory_uri() . '/tools/ads/dfp.js'
	);

	$data = new DFP_Ad_Positions();

	// Localize Data
	wp_localize_script( $script_name, 'ad_data', $data->ad_positions );

	// Enqueue Script
	wp_enqueue_script( $script_name );

}

