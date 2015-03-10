<?php
/*
 * Ad Code
 */

include( 'ads/class.dfp_ad_positions.php');

add_filter( 'epg_ad_positions', 'epg_dfp_theme_ads', 40, 1 );

function epg_dfp_theme_ads($ad_data) {
	// Get the current positions
	$ad_position = new DFP_Ad_Positions();
	// Account ID
	$ad_data->account_id = $ad_position->account_id;
	// Position ID
	$ad_data->div_id = $ad_position->div_id;
	// Add in all the current positions
	foreach ( $ad_position->ad_positions as $position ) {
		$ad_data->positions[] = $position;
	}

	// Send it back
	return $ad_data;
}

