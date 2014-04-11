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
 * This calculator assumes number of predictions is 5 + pole for this championship.
 * 
Pole: two points

One driver in the top five correctly named: 1 point
Two drivers in the top five correctly named: 2 points
Three drivers in the top five correctly named: 3 points
Four drivers in the top five correctly named: 5 points
Five drivers in the top five correctly named: 8 points

One driver in the top five's finishing position correctly predicted: 2 points
Two drivers in the top five's finishing positions correctly predicted: 6 points
Three drivers in the top five's finishing positions correctly predicted: 14 points
Four drivers in the top five's finishing positions correctly predicted: 24 points
Five drivers in the top five's finishing positions correctly predicted: 40 points

Points accumulate so that, for example:
A player who names the pole sitter and top five exactly correct gets 2+8+40=50 points
A player who correctly predicts where two people will finish and gets one other name in the top five correct gets 0+3+6=9 points
A player who correctly predics the top five drivers but gets none of them in the correct positions scores 0+8+0=8 points

 * 
 * @param $raceid the race id.
 * @param $drivers array of driver ids, 0 = pole, 1..n finishing positions.
 * @param $predictions player predictions Array ('entry_id' => Array (('position'=>'participant')...))
 * @return array of entry ids and points to be awarded.
 */
function MotorRacingLeagueCalculatePoints($raceid, $drivers, $predictions) {
	$all_points = array();
		
	unset($drivers['pole_lap_time']);
	unset($drivers['rain']);
	unset($drivers['safety_car']);
	unset($drivers['dnf']);
	if (count($drivers) != 6) {
		die(__('Number of predictions is not 5 + pole !', 'motorracingleague'));
	}
	
	$top5 = array();
	for ($i = 1; $i <= 5; $i++) {
		$top5[] = $drivers[$i]['id'];
	}
	foreach ($predictions as $entry_id=>$entry) {
		
		$points = 0;
		
		if ($entry[0] == $drivers[0]['id']) {
			$all_points[$entry_id][0] = 2;
			$points += 2;		// Pole position correct
		}
		
		/*
		 * Check number of guesses in top 5
		 */
		$ntop5 = 0;
		for ($i = 1; $i <= 5; $i++) {
			if (in_array($entry[$i], $top5)) $ntop5++;
		}
		switch ($ntop5) {
			case 1: $points += 1; $all_points[$entry_id]['bonus'] = 1; break;
			case 2: $points += 2; $all_points[$entry_id]['bonus'] = 2; break;
			case 3: $points += 3; $all_points[$entry_id]['bonus'] = 3; break;
			case 4: $points += 5; $all_points[$entry_id]['bonus'] = 5; break;
			case 5: $points += 8; $all_points[$entry_id]['bonus'] = 8; break;
		}
		
		/*
		 * Check number of exact predictions.
		 */
		$nexact = 0;
		for ($i = 1; $i <= 5; $i++) {
			if ($entry[$i] == $drivers[$i]['id']) {
				$nexact++;
				switch ($nexact) {
					case 1: $all_points[$entry_id][$i] = 2; break;  // Accumulated driver points.  Best we can do.
					case 2: $all_points[$entry_id][$i] = 4; break;
					case 3: $all_points[$entry_id][$i] = 8; break;
					case 4: $all_points[$entry_id][$i] = 10; break;
					case 5: $all_points[$entry_id][$i] = 16; break;
				}
			}
		}
		switch ($nexact) {
			case 1: $points += 2; break;
			case 2: $points += 6; break;
			case 3: $points += 14; break;
			case 4: $points += 24; break;
			case 5: $points += 40; break;
		}
		
		// $all_points[$entry_id][-1] = $drivers[-1]['points'];

		$all_points[$entry_id]['total'] = $points;
	}
	return $all_points;						
}


?>