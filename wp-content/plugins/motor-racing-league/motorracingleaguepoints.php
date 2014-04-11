<?php

/**
 * 
 * Example points calculator for Wordpress plugin MotorRacingLeague
 * 
 * DO NOT modify this file, it will be replaced on upgrade. Instead
 * take a copy of this modify it to your needs.
 * 
 * To use your customized points calculator place your copy in the
 * root directory of this plugin (i.e. the same directory as this
 * file) and enter your filename as the calculator option when
 * defining a championship in the plugin options.
 * 
 * @author    Ian Haycox
 * @package	  MotorRacingLeague
 * @copyright Copyright 2009-2013
 */


/**
 * Calculate the points awarded for each prediction.
 * 
 * a. ten points for correctly guessing the pole sitter
 * b. ten points for naming a driver in their correct position
 * 
 * @param $raceid the race id.
 * @param $drivers array of driver ids, 0 = pole, 1..n finishing positions.
 * @param $predictions player predictions Array ('entry_id' => Array (('position'=>'participant')...))
 * @return array of entry ids and points to be awarded.
 * 
 * Example data for championship with 4 guesses, fastest lap [-1], and pole time.
 * 
 * $drivers = Array (
    [pole_lap_time] => Array([id] => 62101, [points] => 0)		// milliseconds, e.g. 01:02.101
    [-1] => Array([id] => 99, [points] => 10)					// fastest lap
    [0] => Array([id] => 87, [points] => 10)					// pole
    [1] => Array([id] => 91, [points] => 8)						// first...
    [2] => Array([id] => 97, [points] => 6)
    [3] => Array([id] => 92, [points] => 4)
    [4] => Array([id] => 86, [points] => 3)
    [5] => Array([id] => 101, [points] => 2)					// Positions 5 to 8 in this case
    [6] => Array([id] => 81, [points] => 1)						// are the 'Additional' results added
    [7] => Array([id] => 98, [points] => 0)						// Can be used to award points for 'out of position'
    [8] => Array([id] => 89, [points] => 0)						// guesses. E.g. Player guessed driver id 101 in 4th
)																// but came 5th.

$predictions = Array
(
    [4507] => Array					// Entry id
        (
            [-1] => 99				// Participant (driver) id
            [pole_lap_time] => 62101
            [0] => 84				// Number of predictions == 4
            [1] => 34
            [2] => 105
            [3] => 56
            [4] => 101
        )
    [4509] => Array					// Entry id
        (
			.....
)

 * 
 */
function MotorRacingLeagueCalculatePoints($raceid, $drivers, $predictions) {
	$all_points = array();
		

//	echo '<pre>'; print_r($drivers); echo '</pre>';
//	echo '<pre>'; print_r($predictions);  echo '</pre>';
	
	foreach ($predictions as $entry_id=>$entry) {
		
		$points = 0;
		
		/*
		 * Note this example only assigns points for exact matches - that includes
		 * pole lap time.  See motorracingleaguescoring.php for examples of
		 * close matches.
		 */
		foreach ($entry as $key=>$guess) {
			if ($guess == $drivers[$key]['id']) {				// Good guess on finishing position.
					$points += 10;								// or $points += $drivers[$key]['points']
					$all_points[$entry_id][$drivers[$key]['id']] = 10;
			}
		}
		
		$all_points[$entry_id]['total'] = $points;
	}
	
	
	
	return $all_points;						
}


?>