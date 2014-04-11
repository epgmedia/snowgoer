<?php
/**
 * Options class for Wordpress plugin MotorRacingLeague
 * 
* @author    Ian Haycox
* @package	 MotorRacingLeague
* @copyright Copyright 2010-2013
*/
class MotorRacingLeagueOptions
{ 
	private $options;
	
	private $scoring = array('pole' => 10,					// Default points for predictions
							 'fastest' => 10,
							 'use_race_points' => false,
							 'poletime' => array(0 => array('percent'=>0.0, 'points'=>10)),
							 'rain' => 0,
							 'dnf' => 0,
							 'safety_car' => 0
							);
	
	/**
	 * Construct class and setup some defaults
	 * 
	 * @return unknown_type
	 */
	function __construct() {
		$this->options = array (
			'predict_pole' => true,
			'predict_pole_time' => false,
			'predict_fastest' => false,
			'cookie_seconds' => 0, 			// 500000,		Just under a week.
			'can_see_predictions' => false,
			'must_be_logged_in' => true,
			'additional_race_results' => 0,
			'predict_lapsled' => false,		// Change label Fastest Lap to Most Laps Led
			'scoring' => $this->scoring,
			'predict_rain' => false,
			'predict_dnf' => false,
			'predict_safety_car' => false,
			'double_up' => false
		);
	}

	
	function get_predict_pole() {
		return isset($this->options['predict_pole']) ? $this->options['predict_pole'] : true;
	}

	function set_predict_pole($pole) {
		$this->options['predict_pole'] = $pole;
	}


	function get_predict_pole_time() {
		return isset($this->options['predict_pole_time']) ? $this->options['predict_pole_time'] : false;
	}

	function set_predict_pole_time($pole_time) {
		$this->options['predict_pole_time'] = $pole_time;
	}
	

	function get_predict_lapsled() {
		return isset($this->options['predict_lapsled']) ? $this->options['predict_lapsled'] : false;
	}

	function set_predict_lapsled($lapsled) {
		$this->options['predict_lapsled'] = $lapsled;
	}
	

	function get_predict_fastest() {
		return isset($this->options['predict_fastest']) ? $this->options['predict_fastest'] : false;
	}

	function set_predict_fastest($fastest) {
		$this->options['predict_fastest'] = $fastest;
	}
	
	
	function get_cookie_seconds() {
		return isset($this->options['cookie_seconds']) ? $this->options['cookie_seconds'] : 50000;
	}

	function set_cookie_seconds($seconds) {
		$this->options['cookie_seconds'] = $seconds;
	}
	

	function get_can_see_predictions() {
		return isset($this->options['can_see_predictions']) ? $this->options['can_see_predictions'] : true;
	}

	function set_can_see_predictions($view_predictions) {
		$this->options['can_see_predictions'] = $view_predictions;
	}
	

	function get_must_be_logged_in() {
		return isset($this->options['must_be_logged_in']) ? $this->options['must_be_logged_in'] : false;
	}

	function set_must_be_logged_in($logged_in) {
		$this->options['must_be_logged_in'] = $logged_in;
	}

	function get_additional_race_results() {
		return isset($this->options['additional_race_results']) ? $this->options['additional_race_results'] : 0;
	}

	function set_additional_race_results($num) {
		$this->options['additional_race_results'] = $num;
	}
	
	function get_scoring() {
		$scoring = isset($this->options['scoring']) ? $this->options['scoring'] : $this->scoring;
		// Fix up defaults as these as new scoring options for V1.8
		if (!isset($scoring['rain'])) {
			$scoring['rain'] = $this->scoring['rain'];
		}
		if (!isset($scoring['safety_car'])) {
			$scoring['safety_car'] = $this->scoring['safety_car'];
		}
		if (!isset($scoring['dnf'])) {
			$scoring['dnf'] = $this->scoring['dnf'];
		}
		return $scoring;
	}

	function set_scoring($scoring) {
		$this->options['scoring'] = $scoring;
	}
	
	function get_predict_rain() {
		return isset($this->options['predict_rain']) ? $this->options['predict_rain'] : false;
	}
	
	function set_predict_rain($pole) {
		$this->options['predict_rain'] = $pole;
	}
	
	function get_predict_safety_car() {
		return isset($this->options['predict_safety_car']) ? $this->options['predict_safety_car'] : false;
	}
	
	function set_predict_safety_car($pole) {
		$this->options['predict_safety_car'] = $pole;
	}
	
	function get_predict_dnf() {
		return isset($this->options['predict_dnf']) ? $this->options['predict_dnf'] : false;
	}
	
	function set_predict_dnf($pole) {
		$this->options['predict_dnf'] = $pole;
	}
	
	function get_double_up() {
		return isset($this->options['double_up']) ? $this->options['double_up'] : false;
	}
	
	function set_double_up($pole) {
		$this->options['double_up'] = $pole;
	}
	
	
	
	/**
	 * Set the options from a serialized string
	 * 
	 */
	function set($data) {
		$this->options = unserialize($data);
	}
	
	/**
	 * Get serialized options
	 * 
	 * @return unknown_type
	 */
	function get() {
		return serialize($this->options);
	}
	
	/**
	 * Load up the options
	 * 
	 * @param $champid
	 * @return unknown_type
	 */
	function load($champid) {
		global $wpdb;
		
		$sql = "SELECT options FROM {$wpdb->prefix}motorracingleague_championship WHERE id = %d";
		$row = $wpdb->get_row($wpdb->prepare($sql, $champid));
		if ($row) {
			$this->options = unserialize($row->options);
		}
	}
	
	/**
	 * Save the current options
	 * 
	 * @param $champid
	 * @return unknown_type
	 */
	function save($champid) {
		global $wpdb;
		
		$data = serialize($this->options);
		
		$sql = "UPDATE {$wpdb->prefix}motorracingleague_championship SET options = %s WHERE id = %d";
		$wpdb->query($wpdb->prepare($sql, $data, $champid));
	}
	
	/**
	 * Upgrade championship options for database version
	 * 0.3 to 0.4
	 * 
	 * Prior to 0.4 all options where global so we need to
	 * create a set of defaults based on the global settings.
	 * 
	 * @return unknown_type
	 */
	function upgrade_03_04() {
		
		global $wpdb;
		
		$opts = array (
			'predict_pole' => true,
			'predict_pole_time' => false,
			'predict_fastest' => false,
			'additional_race_results' => 0,
			'cookie_seconds' => (int)get_option('motorracingleague_cookie_seconds',500000),
			'can_see_predictions' => (strtolower(get_option('motorracingleague_can_show_predictions_before_entry','y')) == 'y'),
			'must_be_logged_in' => (strtolower(get_option('motorracingleague_needs_authorisation','N')) == 'y'),
			'predict_lapsled' => false,
			'scoring' => $this->scoring
		);
		
		$data = serialize($opts);
		
		$sql = "UPDATE {$wpdb->prefix}motorracingleague_championship SET options = %s";
		$wpdb->query($wpdb->prepare($sql, $data));
		
	}
	
}