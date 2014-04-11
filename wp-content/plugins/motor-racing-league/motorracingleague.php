<?php
/*
Plugin Name: Motor Racing League
Plugin URI: http://www.ianhaycox.com/f1/
Author URI: http://www.ianhaycox.com/
Description: This plugin manages a Motor Racing League allowing users to enter predictions for events, e.g. Formula 1, NASCAR, Moto GP etc. Users predictions are scored and displayed in a results widget.
Version: 1.9.5
Author: Ian Haycox

Copyright 2009-2014  Ian Haycox  (email : ian.haycox@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Sets up plugin configuration and routing based on names of plugin folder and files.

$plugin_version = '1.9.5';

$plugin_name = 'motorracingleague';
$plugin_file = $plugin_name.'.php';
$plugin_class = 'MotorRacingLeague';
$plugin_admin_class = 'MotorRacingLeagueAdmin';
$plugin_class_file = $plugin_name.'.class.php'; 
$plugin_admin_class_file = $plugin_name.'admin.class.php'; 
// define the plugin prefix we are going to use for naming all 
// classes, ids, actions etc... this is done to avoid conflicts with other plugins
$plugin_prefix = $plugin_name.'_'; 
$plugin_dir = get_bloginfo('wpurl').'/wp-content/plugins/motor-racing-league';

// Include the class file
if (!class_exists($plugin_class)) {		
	require_once(dirname(__FILE__).'/'.$plugin_class_file);
	require_once(dirname(__FILE__).'/mrl-widget.php');
	require_once(dirname(__FILE__).'/mrl-options.php');
	if (is_admin()) {
		require_once(dirname(__FILE__).'/'.$plugin_admin_class_file);
	}
}

//Create a new instance of the class file
if (class_exists($plugin_class)) {
      $mrl_plugin = new $plugin_class();
}

//Create a new instance of the class file
if (is_admin() && class_exists($plugin_admin_class)) {
      $mrl_admin_plugin = new $plugin_admin_class();
}

//Setup actions, hooks and filters
if(isset($mrl_plugin)){

	/**
	 * Routing plugin actions to class file
	 */
	
	global $wp_query;
	 
	add_action('init', array($mrl_plugin,'actionInit'),10);
	add_action('wp_enqueue_scripts', array($mrl_plugin, 'wp_enqueue_scripts')); 
	add_action('widgets_init', array($mrl_plugin, 'actionWidgetsInit'));
	add_action('wp_footer', array($mrl_plugin, 'actionWpFooter'));
	add_shortcode('motorracingleague', array($mrl_plugin, 'actionShortcode'));
	
	add_action('wp_ajax_motor_racing_league_save_entry', array($mrl_plugin,'save_entry'));
	add_action('wp_ajax_motor_racing_league_show_entries', array($mrl_plugin,'show_entries'));
	add_action('wp_ajax_motor_racing_league_get_prediction', array($mrl_plugin,'get_entry'));
	add_action('wp_ajax_motor_racing_league_get_stats', array($mrl_plugin,'get_stats'));
	
	add_action('wp_ajax_nopriv_motor_racing_league_save_entry', array($mrl_plugin,'save_entry'));
	add_action('wp_ajax_nopriv_motor_racing_league_show_entries', array($mrl_plugin,'show_entries'));
	add_action('wp_ajax_nopriv_motor_racing_league_get_prediction', array($mrl_plugin,'get_entry'));
	add_action('wp_ajax_nopriv_motor_racing_league_get_stats', array($mrl_plugin,'get_stats'));
	
	// Cron for reminders
	add_action('motorracingleague_hourly_event', array($mrl_plugin,'reminders'));
	
	if (is_admin()) {
		
		// Activation function
		register_activation_hook(__FILE__, array(&$mrl_admin_plugin, 'activate'));
		register_deactivation_hook(__FILE__, array(&$mrl_admin_plugin, 'deactivate'));
	
		add_action('admin_menu', array($mrl_admin_plugin, 'actionAdminMenu'));
		add_action('admin_enqueue_scripts', array($mrl_admin_plugin, 'admin_enqueue_scripts'));
		add_action('admin_init', array($mrl_admin_plugin, 'register_mysettings') );
		add_action('admin_init', array($mrl_admin_plugin, 'check_for_upgrade') );
	}
	
}
	
?>