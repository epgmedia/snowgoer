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

	$data   = new StdClass();
	$ad_div_id = 'div-gpt-ad-1375829763909';
	$acct_id = '/35190362/';

	$data->positions = array(
		array(
			'ad_name' => 'SNG_ROS_Leaderboard',
			'position_tag' => $ad_div_id . '-12',
			'sizes' => [728, 90],
			'out_of_page' => false
		),
		array(
			'ad_name' => 'SNG_ROS_Footerboard',
			'position_tag' => $ad_div_id . '-11',
			'sizes' => [
				[468, 60],
				[728, 90]
			],
			'out_of_page' => false
		),
		array(
			'ad_name' => 'SNG_ROS_160_SB1',
			'position_tag' => $ad_div_id . '-0',
			'sizes' => [
				[120, 240],
				[125, 125],
				[120, 600],
				[160, 160],
				[160, 240],
				[160, 600]
			],
			'out_of_page' => false
		),
		array(
			'ad_name' => 'SNG_ROS_160_SB2',
			'position_tag' => $ad_div_id . '-1',
			'sizes' => [
				[120, 240],
				[125, 125],
				[120, 600],
				[160, 160],
				[160, 240],
				[160, 600]
			],
			'out_of_page' => false
		),
		array(
			'ad_name' => 'SNG_ROS_160_SB3',
			'position_tag' => $ad_div_id . '-2',
			'sizes' => [
				[120, 240],
				[125, 125],
				[120, 600],
				[160, 160],
				[160, 240],
				[160, 600]
			],
			'out_of_page' => false
		),
		array(
			'ad_name' => 'SNG_ROS_160_SB4',
			'position_tag' => $ad_div_id . '-3',
			'sizes' => [
				[120, 240],
				[125, 125],
				[120, 600],
				[160, 160],
				[160, 240],
				[160, 600]
			],
			'out_of_page' => false
		),
		array(
			'ad_name' => 'SNG_ROS_160_SB5',
			'position_tag' => $ad_div_id . '-4',
			'sizes' => [
				[120, 240],
				[125, 125],
				[120, 600],
				[160, 160],
				[160, 240],
				[160, 600]
			],
			'out_of_page' => false
		),
		array(
			'ad_name' => 'SNG_ROS_160_SB6',
			'position_tag' => $ad_div_id . '-5',
			'sizes' => [
				[120, 240],
				[125, 125],
				[120, 600],
				[160, 160],
				[160, 240],
				[160, 600]
			],
			'out_of_page' => false
		),
		array(
			'ad_name' => 'SNG_ROS_160_SB7',
			'position_tag' => $ad_div_id . '-6',
			'sizes' => [
				[120, 240],
				[125, 125],
				[120, 600],
				[160, 160],
				[160, 240],
				[160, 600]
			],
			'out_of_page' => false
		),
		array(
			'ad_name' => 'SNG_ROS_300_LR',
			'position_tag' => $ad_div_id . '-7',
			'sizes' => [300, 250],
			'out_of_page' => false
		),
		array(
			'ad_name' => 'SNG_ROS_300_Mid',
			'position_tag' => $ad_div_id . '-8',
			'sizes' => [300, 250],
			'out_of_page' => false
		),
		array(
			'ad_name' => 'SNG_ROS_300_Mid2',
			'position_tag' => $ad_div_id . '-9',
			'sizes' => [300, 250],
			'out_of_page' => false
		),
		array(
			'ad_name' => 'SNG_ROS_300_UR',
			'position_tag' => $ad_div_id . '-10',
			'sizes' => [300, 250],
			'out_of_page' => false
		),
		array(
			'ad_name' => 'SNG_ROS_middle468',
			'position_tag' => $ad_div_id . '-13',
			'sizes' => [468, 60],
			'out_of_page' => false
		),
		array(
			'ad_name' => 'SNG_ROS_middle468_2',
			'position_tag' => $ad_div_id . '-14',
			'sizes' => [468, 60],
			'out_of_page' => false
		),
		array(
			'ad_name' => 'SNG_ROS_Wallpaper',
			'position_tag' => 'div-gpt-ad-1392153511566-0',
			'sizes' => [1, 1],
			'out_of_page' => true
		),
		array(
			'ad_name' => 'SNG_SRC_728',
			'position_tag' => 'div-gpt-ad-1385159664501-0',
			'sizes' => [[728, 90], [970, 90]],
			'out_of_page' => false
		)
	);

	$data = new DFP_Ad_Positions();

	// Localize Data
	wp_localize_script( $script_name, 'ad_data', $data->ad_positions );

	// Enqueue Script
	wp_enqueue_script( $script_name );

}

