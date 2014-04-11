<?php
/**
 * Scoring class for Wordpress plugin MotorRacingLeague
 * 
 * This file uses the championship definitions for scoring to calculate scores.
 * 
 * For your own custom scoring module - see motorracingleaguepoints.php.
 * 
 * @author    Ian Haycox
 * @package	 MotorRacingLeague
 * @copyright Copyright 2013
 */


/**
 * Calculate points for predictions
 * 
 * @param $options Championship and scoring settings
 * @param $drivers Array of drivers results
 * @param $predictions Players guesses
 * @return Array of points to assign to entry_id's
 */
function MotorRacingLeagueCalculatePoints($options, $drivers, $predictions) {
	$all_points = array();
		

	$scoring = $options->get_scoring();
	
//	echo '<pre>'; print_r($drivers); echo '</pre>';
//	echo '<pre>'; print_r($predictions);  echo '</pre>';
	
	$pole = isset($scoring['pole']) ? $scoring['pole'] : 0;
	$fastest = isset($scoring['fastest']) ? $scoring['fastest'] : 0;
	$poletime = isset($scoring['poletime']) ? $scoring['poletime'] : array();
	$position = isset($scoring['points']) ? $scoring['points'] : array();
	$bonus = isset($scoring['bonus']) ? $scoring['bonus'] : array();
	$use_race_points = isset($scoring['use_race_points']) ? $scoring['use_race_points'] : false;
	$rain = isset($scoring['rain']) ? $scoring['rain'] : 0;
	$dnf = isset($scoring['dnf']) ? $scoring['dnf'] : 0;
	$safety_car = isset($scoring['safety_car']) ? $scoring['safety_car'] : 0;
	
	foreach ($predictions as $entry_id=>$entry) {
		
		$points = 0;
		$num_correct = 0;
		
		foreach ($entry as $key=>$guess) {
			
			
			if ($options->get_predict_pole() && $key == 0 && isset($drivers[0]) && $guess == $drivers[0]['id']) {
				if ($use_race_points) {
					$points += $drivers[0]['points'];
					$all_points[$entry_id][0] = $drivers[0]['points'];
				} else {
					$points += $pole;
					$all_points[$entry_id][0] = $pole;
				}
			}
			if ($options->get_predict_fastest() && $key == -1 && isset($drivers[-1]) && $guess == $drivers[-1]['id']) {
				if ($use_race_points) {
					$points += $drivers[-1]['points'];
					$all_points[$entry_id][-1] = $drivers[-1]['points'];
				} else {
					$points += $fastest;
					$all_points[$entry_id][-1] = $fastest;
				}
			}
			if ($options->get_predict_pole_time() && is_string($key) && $key == 'pole_lap_time' && isset($drivers['pole_lap_time'])) {
				//
				// We have an array ('percent'=>0.25, 'points' => 10 )
				//
				foreach ($poletime as $pt) {
					$target = $drivers['pole_lap_time']['id'];  // Really lap time in milliseconds
					$diff = $target / 100 * $pt['percent'];
					$low = $target - $diff;
					$high = $target + $diff;
					if ($guess >= $low && $guess <= $high) {
						$points += $pt['points'];
						$all_points[$entry_id]['pole_lap_time'] = $pt['points'];
						break;
					}
				}
			}
			if ($options->get_predict_rain() && is_string($key) && $key == 'rain' && isset($drivers['rain']) && $guess == $drivers['rain']['id']) {
				$points += $rain;
				$all_points[$entry_id]['rain'] = $rain;
			}
			if ($options->get_predict_dnf() && is_string($key) && $key == 'dnf' && isset($drivers['dnf']) && $guess == $drivers['dnf']['id']) {
				$points += $dnf;
				$all_points[$entry_id]['dnf'] = $dnf;
			}
			if ($options->get_predict_safety_car() && is_string($key) && $key == 'safety_car' && isset($drivers['safety_car']) && $guess == $drivers['safety_car']['id']) {
				$points += $safety_car;
				$all_points[$entry_id]['safety_car'] = $safety_car;
			}
				
			/*
			 * Finishing positions 1..n
			 */
			if (is_int($key) && $key > 0) {
				foreach ($drivers as $i=>$d) {
					if (is_int($i) && $i > 0) {
						if ($guess == $drivers[$i]['id']) {
							
							if ($use_race_points) {
								if ($i == $key) {
									$points += $drivers[$i]['points'];
									$all_points[$entry_id][$key] = $drivers[$i]['points'];
								}
							} else {
								/*
								 * Players guess matches a finishing position, so assign
								 * points based on how close they are.
								 */
								$x = isset($position[abs($key-$i)]) ? $position[abs($key-$i)] : 0;
								$points += $x;
								$all_points[$entry_id][$key] = $x;
							}
							if ($i == $key) $num_correct++;  // Spot on
							break;
						}
					}
				}
			}
		}
		
		/*
		 * Bonus points
		 */
		if ($num_correct > 0) {
			$x = isset($bonus[$num_correct]) ? $bonus[$num_correct] : 0;
			$points += $x;
			$all_points[$entry_id]['bonus'] = $x;
		}
		
		/*
		 * Double up
		 */
		$all_points[$entry_id]['double_up'] = 0;
		if ($options->get_double_up() && isset($entry['double_up']) && $entry['double_up']) {
			$all_points[$entry_id]['double_up'] = $points;
			$points *= 2;
		}
		
		$all_points[$entry_id]['total'] = $points;
		
	}
	//echo '<pre>' . print_r($all_points, true) . '</pre>';
	return $all_points;						
}
?>