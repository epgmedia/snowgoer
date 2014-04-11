<?php

/**
 * Points calculation for http://www.f1fanatic.co.uk/
 * 
 * @author    Ian Haycox
 * @package	  MotorRacingLeague
 * @copyright Copyright 2009
 */


/**
 * Calculate the points awarded for each prediction.
 * 
 * This calculator assumes number of predictions is 4 for this championship.
 * 
 * a. ten points for correctly guessing the pole sitter
 * b. ten points for naming one of the top three in their correct position,
 * 		25 for naming two of the top three and
 * 		50 for naming the whole top three correctly
 * c. five points for correctly naming any other driver in the top three (but not in the correct position)
 * 
 * @param $raceid the race id.
 * @param $drivers array of driver ids, 0 = pole, 1..n finishing positions.
 * @param $predictions player predictions Array ('entry_id' => Array (('position'=>'participant')...))
 * @return array of entry ids and points to be awarded.
 */
function MotorRacingLeagueCalculatePoints($raceid, $drivers, $predictions) {
	$all_points = array();
		
	if (count($drivers) != 4) {
		die(__('Number of predictions is not 4 !', 'motorracingleague'));
	}
	
	foreach ($predictions as $entry_id=>$entry) {
		
		$points = 0;
		
		if ($entry[0] == $drivers[0]['id']) $points += 10;		// Pole position correct
		/*
		 * Top 3 spot-on 50 points
		 */
		if ($entry[1] == $drivers[1]['id'] && 
			$entry[2] == $drivers[2]['id'] &&
			$entry[3] == $drivers[3]['id']) {
				$points += 50;
		/*
		 * Two right 25 points
		 */
		} elseif (($entry[1] == $drivers[1]['id'] && $entry[2] == $drivers[2]['id']) ||
				  ($entry[1] == $drivers[1]['id'] && $entry[3] == $drivers[3]['id']) ||
				  ($entry[2] == $drivers[2]['id'] && $entry[3] == $drivers[3]['id'])) {
				$points += 25;
		} elseif (($entry[1] == $drivers[1]['id']) ||
				  ($entry[2] == $drivers[2]['id']) ||
				  ($entry[3] == $drivers[3]['id'])) {
			/*
			 * One correct 10 points
			 */
				$points += 10;
		}
		/*
		 * None spot on but if in the top three then add 5 points. Ugly code !
		 */
		for ($i = 1; $i < 4; $i++) {
			switch ($i) {
				case 1:
					if ($drivers[1]['id'] == $entry[2] || $drivers[1]['id'] == $entry[3]) {
						$points +=5;
					}
					break;
				case 2:
					if ($drivers[2]['id'] == $entry[1] || $drivers[2]['id'] == $entry[3]) {
						$points +=5;
					}
					break;
				case 3:
					if ($drivers[3]['id'] == $entry[2] || $drivers[3]['id'] == $entry[1]) {
						$points +=5;
					}
					break;
			}
		}
		
		$all_points[$entry_id] = $points;
	}
	return $all_points;						
}


?>