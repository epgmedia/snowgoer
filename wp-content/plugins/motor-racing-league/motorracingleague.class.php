<?php
/**
 * Main class for Wordpress plugin MotorRacingLeague
 * 
* @author    Ian Haycox
* @package	 MotorRacingLeague
* @copyright Copyright 2009-2013
*/
class MotorRacingLeague
{ 

	/**
	 * Plugin prefix
	 * @var string
	 */
	public $pf;
	
	/**
	 * Plugin name
	 * @var string
	 */
	public $name;
	
	/**
	 * Plugin directory
	 * @var string
	 */
	public $dir;
	
	/**
	 * Plugin version
	 * @var string
	 */
	public $version;
		
	/**
	 * error handling
	 *
	 * @var boolean
	 */
	private $error = false;
	
	/**
	 * message
	 *
	 * @var string
	 */
	private $message = '';
	
	/**
	 * current championship id
	 * 
	 * @var unknown_type
	 */
	protected $championship_id;
	

	/**
	 * Championship options
	 * 
	 * @var class reference to MotorRacingLeagueOptions
	 */
	
	protected $options;
	
	/**
	 * Initializes the Plugin class
	 *
	 * @return bool Successfully initialized
	 */
	function __construct()
	{
		$this->pf = 'motorracingleague_';
		$this->name = 'motorracingleague';
		$this->dir = get_bloginfo('wpurl').'/wp-content/plugins/motor-racing-league';
		$this->version = '1.9.4';
		$this->options = new MotorRacingLeagueOptions();  // Default options
			
		return true;
	}

	/**
	 * Routes plugin actions.
	 */
	function actionInit() {

		$this->setLanguage();
		
		
		// Respond to http://mrl/?mrl_cancel=1 to cancel future reminder emails
		
		if (isset($_GET['mrl_cancel'])) {
			
			$base64 = $_GET['mrl_cancel'];
			$data = unserialize(base64_decode($base64));
			
			if ($data !== false && isset($data[0]) && isset($data[1])) {
				list($id, $champ_id) = $data;
				
				if (is_numeric($id) && is_numeric($champ_id)) {
					
					
					$val = get_user_meta($id, 'motorracingleague_reminder_cancel_' . $champ_id, true);
					// Stop multiple confirmation.
					if (!$val) {
						update_user_meta($id, 'motorracingleague_reminder_cancel_' . $champ_id, 1);
						
						$user = get_user_by('id', $id);
						if ($user) {
							wp_mail($user->user_email, __('Reminders cancelled', $this->name), __('All future reminders for this Championship have been canceled.', $this->name));
						}
					}
					
				}
				
				wp_safe_redirect(get_bloginfo('wpurl'));
				die();
				
			}
		}
		
	}

	/**
	 * Action wp_enqueue_scripts
	 * 
	 * @return unknown_type
	 */
	function wp_enqueue_scripts() {
		wp_enqueue_style($this->pf.'style', WP_PLUGIN_URL . '/motor-racing-league/css/style.css');
		
		wp_enqueue_script($this->pf.'js', WP_PLUGIN_URL .'/motor-racing-league/js/motorracingleague.js', array( 'jquery' ));
		wp_localize_script($this->pf.'js', 'MotorRacingLeagueAjax', array( 'blogUrl' => admin_url( 'admin-ajax.php' )));
	}
	
	/**
	 * Action wp_footer
	 * 
	 * @return unknown_type
	 */
	function actionWpFooter() {
		if (get_option('motorracingleague_promo_link')) {
			echo '<p>Motor Racing League plugin by <a href="http://www.ianhaycox.com">Ian Haycox</a></p>';
		}
	}

	/**
	 * Initialize the plugin widgets
	 * 
	 */
	function actionWidgetsInit() {
		/*
		 * For the results table
		 */
		register_widget('MotorRacingLeagueWidget');
	}

	/**
	 * Handle shortcode
	 * 
	 * @param $attr - attributes
	 * @return unknown_type
	 */
	function actionShortcode($atts) {
		extract(shortcode_atts(array(
			'entry' => -1,			// Championship ID
			'results' => -1,		// Champid for results
			'race' => -1,			// raceid
			'limit' => 999999,		// Limit output to this many rows
			'full' => true,			// Show players predictions, or just points if false
			'style' => '',			// Apply this style to output tables
			'cols' => 100,			// Add player name to RHS of table if more than cols
			'stats' => 0,			// Show prediction statistics.
			'ignoredeadline' => 0,	// For statistics ignore 'entry_by' deadline
			'predictions' => 0,		// Show logged in users predictions
			'used_doubleups' => 0	// Show players who used a double up below results table
			), $atts));
			
			
		if (!empty($style)) {
			$style = 'style="'.$style.'"';
		}
		if ($stats) {
			return $this->showPredictionStatistics($stats, $ignoredeadline);
		} elseif ($entry != -1) {
			return $this->entry_form($entry, $style);
		} elseif ($results != -1) {
			return $this->championship_results($results, $style, $cols, $used_doubleups);
		} elseif ($race != -1) {
			return $this->race_results($race, $limit, $full, $style);
		} elseif ($predictions) {
			return $this->showPredictions($predictions, $style);
		}
	}

	/**
	 * Display the entry form for predictions
	 * 
	 * @param $champid
	 * @param $style
	 * @return unknown_type
	 */
	function entry_form($champid, $style) {
	    $this->championship_id = $champid;
		$this->options->load($champid);
	    
		$output = '<a href="#" name="mrlpaneltop"></a><div class="motorracingleague-post wrap">';
		$output .= '<div id="motorracingleague_notice">';
		
		if ($this->getFirstAvailableRaceId($champid) != -1 && $this->needsAuthorisation() && !$this->isAuthorised()) {
			$output .= '<p class="motorracingleague_error">' . __('You must be logged in', $this->name) . '</p>';
		}
		
		$output .= '</div>';
		
		/*
		 * If this user has already entered this competition then do not
		 * display the entry form again. Get the race id from the COOKIE.
		 */
		if ($this->hasPredicted($this->championship_id, $raceid)) {
			$output .= $this->showEntries($raceid, $this->championship_id, true);
		} else {
			/*
			 * Show entries if 'Show All predictions' clicked else display entry form
			 */
			if( isset( $wp_query->query_vars['motorracingleague_show_predictions'] )) {
				$output .= $this->showEntries($wp_query->query_vars['motorracingleague_show_predictions'], $this->championship_id, true);
			} else {
				$output .= $this->getEntryForm($this->championship_id, $style);
			}
		}
		$output .= '</div>';
		
		return $output;
	}
	
	/**
	 * Display the results of all predictions for past
	 * races in this championship
	 * 
	 * @param $champid
	 * @param $style Apply this style to the output table
	 * @param $limit Limit number of output rows
	 * 
	 * @return unknown_type
	 */
	function championship_results($champid, $style, $max_cols, $used_doubleups) {
		
	    $this->championship_id = $champid;
		$this->options->load($champid);
	    $output = '<div class="motorracingleague-results wrap">';
		$output .= '<h3>' . $this->getChampionshipName($this->championship_id) . '</h3>';
		$output .= $this->getAllStandings($this->championship_id, false, $style, $max_cols, $used_doubleups);
		$output .= '</div>';
		return $output;
	}
	
	/**
	 * Display players prediction results for a race
	 * 
	 * @param unknown_type $raceid
	 * @param unknown_type $limit
	 * @param unknown_type $full
	 * @param unknown_type $style
	 * @return unknown_type
	 */
	function race_results($raceid, $limit, $full, $style) {
		$output = '<div class="motorracingleague-race-results wrap">';
		$circuit = $this->getRaceHeading($raceid);
		$output .= '<h3>' . $circuit . '</h3>';
		$output .= $this->getRaceStandings($raceid, $limit, $full, $style);
		$output .= '</div>';
		return $output;
	}
	
	/**
	 * Returns the HTML for an entry form to gather a prediction
	 *
	 * @param int $champid chamionship_id
	 * @return string HTML output for widget
	 */
	function getEntryForm($champid, $style = '', $nextRaceId = -1) {
		global $wpdb;
		
		$player = $email = '';
		$disabled = '';
		$pole_lap_time = '';
		$optin = $rain = $safety_car = $dnf = $double_up = 0;
		$output = '';

		$numPredictions = $this->getChampionshipNumPredictions($champid);
		if ($numPredictions == 0) {
			return __('No championship defined', $this->name);
		}
		
		if ($nextRaceId == -1) {
			$nextRaceId = $this->getFirstAvailableRaceId($champid);
		}
		
		if ($nextRaceId != -1 && $this->qualify_by_expired($nextRaceId)) {
			
			$sql = "SELECT COUNT(*) FROM
						{$wpdb->prefix}{$this->pf}entry e,
						{$wpdb->prefix}{$this->pf}prediction p
					WHERE
						e.player_name = %s AND e.race_id = %d AND
						p.entry_id = e.id
					ORDER BY position ASC";
			$preds = $wpdb->get_var($wpdb->prepare($sql, $this->getPlayerName(), $nextRaceId));
			if (!$preds) {
				
				// Next race after this one because the user has no prediction
				// and it's after the qualifying deadline so they can't
				// enter a pole or pole lap time
				$nextRaceId = $this->getFirstAvailableRaceId($champid, $nextRaceId);
			} else {
				$info = __('Qualifying deadline has passed. Only changes to race predictions are allowed', $this->name);
				$output .= "<script>jQuery('#motorracingleague_notice').html('<p class=\'motorracingleague_info\'>$info</p>');</script>";
			}
		}
		
		$output .=  '<div '.$style.' id="motorracingleague_entry_form_'.$champid.'">';
		
		$output .= '<form id="motorracingleague_form" method="" action=""><fieldset>';
		$output .= '<legend>'.__('Entry for',$this->name).' ' . $this->getChampionshipName($champid) . '</legend>';
		// TODO add message to say entries must be in by datetime. In browser local time !!


		/*
		 * If there is a prediction deadline coming up display a Javascript
		 * countdown clock.
		 */
		$deadline = $this->getPredictionDateTime($champid);
		if ($deadline) {
			
			$output .= '<div class="motorracingleague_clock" id="motorracingleague_clock_'.$champid.'">Clock Error - Read the <a href="http://wordpress.org/extend/plugins/motor-racing-league/faq/">FAQ</a> more more information</div>';
			$output .= '<script type="text/javascript">
			<!--
			var mrl_cd'.$champid.' = new motorracingleague_countdown(\'mrl_cd'.$champid.'\');
			mrl_cd'.$champid.'.Div			= "motorracingleague_clock_'.$champid.'";
			mrl_cd'.$champid.'.TargetDate		= "'.$deadline['target'].'";
			mrl_cd'.$champid.'.ServerDate		= "'.$deadline['now'].'";
			mrl_cd'.$champid.'.DisplayFormat	= "'.__('Next prediction deadline in',$this->name).' %%D%%d, %%H%%h, %%M%%m, %%S%%s";
			mrl_cd'.$champid.'.FinishStr    	= "'.__('Too Late - Prediction deadline passed',$this->name).'";
			mrl_cd'.$champid.'.Setup();
			//-->
			</script>';
		} else {
			$output .= '<div class="motorracingleague_clock" id="motorracingleague_clock_'.$champid.'">' .
				__('No races available in this championship.', $this->name) . '</div>';
			$disabled = ' disabled ';
		}
		
		/*
		 * Create table with headings for number of predicable positions and
		 * user details.
		 */
		$output .= '<table class="motorracingleague_entry_table">';
		$output .= '<tr><td>Race:</td><td>'.$this->getRaceSelection($champid, false, $nextRaceId).'</td></tr>';
		
		/*
		 * If logged-in user already predicted, pre-fill dropdown boxes
		 */
		$predicted = array();
		if ($this->options->get_predict_fastest()) {
			$predicted[-1] = -1;
		}
		if ($this->options->get_predict_pole()) {
			$predicted[0] = -1;
		}
		for ($i = 1; $i <= $numPredictions; $i++) {
			$predicted[$i] = -1;
		}
		
		$doubled_up = false;
		$already_predicted = false;
		$qualify_by_expired = $this->qualify_by_expired($nextRaceId);
		
		if ($nextRaceId != -1 && $this->needsAuthorisation() && $this->isAuthorised()) {
			$sql = "SELECT pole_lap_time, position, participant_id, optin, rain, safety_car, dnf, double_up FROM
						{$wpdb->prefix}{$this->pf}entry e,
						{$wpdb->prefix}{$this->pf}prediction p
					WHERE
						e.player_name = %s AND e.race_id = %d AND
						p.entry_id = e.id
					ORDER BY position ASC";
			$results = $wpdb->get_results($wpdb->prepare($sql, $this->getPlayerName(), $nextRaceId));
			if ($results) {
				$already_predicted = true;
				$pole_lap_time = $this->from_laptime($results[0]->pole_lap_time);
				$optin = $results[0]->optin;
				$rain = $results[0]->rain;
				$safety_car = $results[0]->safety_car;
				$dnf = $results[0]->dnf;
				$double_up = $results[0]->double_up;
			}
			foreach ($results as $row) {
				$predicted[$row->position] = $row->participant_id;
			}
			
			// Used Double Up in another race ?
			$sql = "SELECT COUNT(*) FROM
						{$wpdb->prefix}{$this->pf}entry e,
						{$wpdb->prefix}{$this->pf}race r
					WHERE
						double_up = 1 AND e.player_name = %s AND e.race_id = r.id AND
						e.race_id <> %d AND r.championship_id = %d";
			$doubled_up = $wpdb->get_var($wpdb->prepare($sql, $this->getPlayerName(), $nextRaceId, $champid));
		}
		
 		if ($this->options->get_predict_pole_time()) {
			$output .= '<tr valign="top">';
			$tooltip = __('Enter the Pole Lap Time in mm:ss.ccc format, e.g. 01:31.213 for 1m 31.213s', $this->name);
			$output .= '<td><label title="'.$tooltip.'" for="'.$this->pf.'pole_lap_time">'.__( 'Pole Time', $this->name ).'</label></td>';
			if ($qualify_by_expired) {
				$output .= '<td><input class="mrl_disable" disabled="disabled" title="'.$tooltip.'" placeholder="mm:ss.ccc" type="text" name="'.$this->pf.'pole_lap_time" id="'.$this->pf.'pole_lap_time" value="'.$pole_lap_time.'" size="10" /></td>';
			} else {
				$output .= '<td><input class="mrl_disable" title="'.$tooltip.'" placeholder="mm:ss.ccc" type="text" name="'.$this->pf.'pole_lap_time" id="'.$this->pf.'pole_lap_time" value="'.$pole_lap_time.'" size="10" /></td>';
			}
			$output .= '</tr>';
 		}
		foreach ($predicted as $i=>$p) {
			if ($i == 0) {
				$position_str = __("Pole", $this->name);
			} elseif ($i == -1) {
				$position_str = $this->fl_label($this->options->get_predict_lapsled());
			} else {
				$position_str = __("Position", $this->name) . ' ' . $i;
			}
			if ($i == 0 && $qualify_by_expired) {
				$output .= '<tr><td>'.$position_str.'</td><td>'.$this->getParticipantSelection($champid, "participant[{$i}]", "", $predicted[$i], true).'</td></tr>';
			} else {
				$output .= '<tr><td>'.$position_str.'</td><td>'.$this->getParticipantSelection($champid, "participant[{$i}]", "", $predicted[$i]).'</td></tr>';
			}
		}
		
		if ($this->options->get_predict_rain()) {
			$output .= '<tr valign="top">';
			$tooltip = __('Predict if this race will be rain affected', $this->name);
			$output .= '<td><label title="'.$tooltip.'" for="'.$this->pf.'rain">'.__( 'Rain', $this->name ).'</label></td>';
			$output .= '<td><input title="'.$tooltip.'" type="checkbox" '.($rain ? 'checked' : '').' name="'.$this->pf.'rain" id="'.$this->pf.'rain" value="1" /></td>';
			$output .= '</tr>';
		}
		if ($this->options->get_predict_safety_car()) {
			$output .= '<tr valign="top">';
			$tooltip = __('Predict if the Safety Car will be deployed', $this->name);
			$output .= '<td><label  title="'.$tooltip.'" for="'.$this->pf.'safety_car">'.__( 'Safety Car', $this->name ).'</label></td>';
			$output .= '<td><input  title="'.$tooltip.'" type="checkbox" '.($safety_car ? 'checked' : '').' name="'.$this->pf.'safety_car" id="'.$this->pf.'safety_car" value="1" /></td>';
			$output .= '</tr>';
		}
		if ($this->options->get_predict_dnf()) {
			$output .= '<tr valign="top">';
			$tooltip = __('Predict the number of non finishers', $this->name);
			$output .= '<td><label  title="'.$tooltip.'" for="'.$this->pf.'dnf">'.__( 'DNF', $this->name ).'</label></td>';
			$output .= '<td><select  title="'.$tooltip.'" name="'.$this->pf.'dnf" id="'.$this->pf.'dnf">';
			$num_drivers = $this->getNumDrivers($champid);
			for ($i = 0; $i <= $num_drivers; $i++) {
				$output .= '<option '.($dnf == $i ? 'selected' : '').' value="'.$i.'">' . $i . '</option>';
			}
			$output .= '</select></td>';
			$output .= '</tr>';
		}
		if ($this->options->get_double_up() && !$doubled_up) {
			$output .= '<tr valign="top">';
			$tooltip = __('Choose one race to gain double points', $this->name);
			$output .= '<td><label  title="'.$tooltip.'" for="'.$this->pf.'double_up">'.__( 'Double Up', $this->name ).'</label></td>';
			if ($qualify_by_expired) {
				$output .= '<td>' . $this->tick($double_up) . '</td>';
			} else {
				$output .= '<td><input  title="'.$tooltip.'" type="checkbox" '.($double_up ? 'checked' : '').' name="'.$this->pf.'double_up" id="'.$this->pf.'double_up" value="1" /></td>';
			}
			$output .= '</tr>';
		}
		

		// User convienience - fill in player name and email from previous entry.
		if (isset($_COOKIE["motorracingleague"])) {
			foreach($_COOKIE["motorracingleague"] as $k=>$v) {
				$$k = $v;
			}
		}
		/*
		 * User must be logged in to predict ?
		 */
		if (!$this->needsAuthorisation()) {
			$output .= '<tr><td>'.__('Name',$this->name).':</td><td><input id="motorracingleague_player" name ="motorracingleague_player" value="'.$player.'" /></td></tr>';
			$output .= '<tr><td>'.__('Email',$this->name).':</td><td><input id="motorracingleague_email" name ="motorracingleague_email" value="'.$email.'" /></td></tr>';
		}
		
		$output .= '</table><input type="hidden" id="motorracingleague_comp_id" name="motorracingleague_comp_id" value="'.$champid.'" />';
		/*
		 * Save details via AJAX. After saving the hidden DIV is filled with the
		 * most recent prediction entries.
		 * Present button, if required, to display predictions for the next up and coming race. 
		 */
		if ($already_predicted) {
			$output .= '<input '.$disabled.' type="submit" id="motorracingleague-add" name="Submit" value="'. __("Update Prediction", $this->name) . '"/>';
		} else {
			$output .= '<input '.$disabled.' type="submit" id="motorracingleague-add" name="Submit" value="'. __("Add Prediction", $this->name) . '"/>';
		}
		if ($this->canShowPredictions() || $nextRaceId == -1) {
			$nextRaceId = $this->getNextAvailableRaceId($champid);
			if ($nextRaceId != -1) {
				$output .= '<input type="hidden" name ="motorracingleague_next_race" value="'.$nextRaceId.'" />
							<input type="button" id="motorracingleague_show_predictions" value="'. __("Show Predictions", $this->name) .'" />';
			}
		}
		// Ask unregistered users if we can use their email address
		if ($this->askOptIn()) {
			$output .= '<div class="motorracingleague_optin">
							<input style="vertical-align:middle" type="checkbox" '.($optin ? 'checked' : '').' name="motorracingleague_optin" id="motorracingleague_optin" />
							<label for="motorracingleague_optin">'.$this->optInQuestion().'</label>
						</div>';
		}
		$output .= '</fieldset></form></div><div style="display:none" id="motorracingleague_entry_results_'.$champid.'"></div>';
		// TODO - get next race id !
		return $output;
	}

	/**
	 * Determine if we are past the (optional) qualifying deadline.
	 * 
	 * @param unknown_type $nextRaceId
	 */
	function qualify_by_expired($nextRaceId) {
		global $wpdb;
		
		// Non-logged in users can't change predictions
		// so this is not applicable.
		
		if (!$this->needsAuthorisation()) {
			return false;
		}
		
		// If we don't need to predict pole or pole time then ignore qualify_by deadline
		if ($this->options->get_predict_pole() || $this->options->get_predict_pole_time()) {
			
			// 
			$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}{$this->pf}race WHERE
						id = %d AND qualify_by < NOW()";
			$count = $wpdb->get_var($wpdb->prepare($sql, $nextRaceId));
			
			return $count;
		}
		
		return false;
	}
	
	/**
	 * Should a mailing list opt-in check box be displayed.
	 */
	function askOptIn() {
		return get_option('motorracingleague_optin', false);
	}
	
	/**
	 * Opt-in to what ?
	 */
	function optInQuestion() {
		return get_option('motorracingleague_optin_message','');
	}
	
	/**
	 * Get the race id of the first available race
	 */
	function getFirstAvailableRaceId($champ_id, $race_id = 0) {
		global $wpdb;
		
		$sql = "SELECT id FROM {$wpdb->prefix}{$this->pf}race 
				WHERE championship_id = %d
				 AND NOW() < entry_by AND id <> %d
				 ORDER BY race_start LIMIT 1";
		$result = $wpdb->get_row($wpdb->prepare($sql, $champ_id, $race_id), OBJECT);
		if ($result) {
			return $result->id;
		}
		return -1;
	}
	
	/**
	 * Get the race id of the next available race that can be predicted. If none
	 * available return the first race.
	 * 
	 * @param $champ_id championship id
	 * @return int race_id or -1
	 */
	function getNextAvailableRaceId($champ_id) {
		global $wpdb;
		
		$sql = 'SELECT id FROM '.$wpdb->prefix.$this->pf.'race 
				WHERE championship_id = '.$champ_id.'
				 AND NOW() < entry_by
				 ORDER BY race_start LIMIT 1;';
		$result = $wpdb->get_row($sql, OBJECT);
		if ($result) {
			return $result->id;
		} else {
			/*
			 * No races left in the future, so choose the oldest.
			 */
			$sql = 'SELECT id FROM '.$wpdb->prefix.$this->pf.'race 
					WHERE championship_id = '.$champ_id.'
					 ORDER BY race_start ASC LIMIT 1;';
			$result = $wpdb->get_row($sql, OBJECT);
			if ($result) {
				return $result->id;
			} else {
				return -1;
			}
		}
	}
	
	/**
	 * Return a selection box with all the reces defined for this championship
	 * 
	 * @param $championship_id The required championship
	 * @param $oldraces show old races, i.e. those that have been completed
	 * @param $select_id make this race id as 'selected'
	 * @param $empty_option_str String for 'empty option'
	 * @param $javascript Javascript code for onchange event for example.
	 * @return string
	 */
	function getRaceSelection($championship_id, $oldraces = false, $select_id = null, $empty_option_str = null, $javascript = '') {
		global $wpdb;
		
		$sql = 'SELECT id,circuit, race_start, entry_by FROM '.$wpdb->prefix.$this->pf.'race 
				WHERE championship_id = %d';
		/*
		 * Admin functions need old races
		 */
		if (!$oldraces && !is_admin()) {
			$sql .= ' AND NOW() < entry_by';
		}
		$sql .= ' ORDER BY race_start;';
		$race = $wpdb->get_results( $wpdb->prepare($sql, $championship_id) , OBJECT );
		$output = "<select $javascript name='mrl_race' id='mrl_race'>";
		/*
		 * Add an empty entry for admin to force choosing the correct race.
		 */
		if ($oldraces && is_admin() && !is_null($empty_option_str)) {
			$output .= "<option value='-1'>$empty_option_str</option>";
		}
		foreach ($race as $row) {
			$output .= '<option ';
			if (isset($select_id) && $row->id == $select_id) {
				$output .= ' selected ';
			}
			$output .= " value='$row->id'>$row->circuit";
			$output .= '</option>';
		}
		$output .= "</select>";
		
		return $output;
	}
	
	/**
	 * Get the number of defined races in this championship
	 * 
	 * @param $championship_id championship id
	 * @param $oldraces Include old races (before entry deadline) in count
	 * @return int number of races
	 */
	function getNumRaces($championship_id, $oldraces = false) {
		global $wpdb;
		
		$sql = 'SELECT count(*) as "num" FROM '.$wpdb->prefix.$this->pf.'race 
				WHERE championship_id = '.$championship_id;
		/*
		 * Admin functions need old races
		 */
		if (!$oldraces && is_admin()) {
			$sql .= ' AND NOW() < entry_by';
		}
		$result = $wpdb->get_results( $sql , OBJECT );
		return $result[0]->num;
		
	}
	
	/**
	 * Display a list of drivers or riders for a championship
	 * 
	 * @param $championship_id the championship id
	 * @param $pos position for selection, e.g. pole, first - names select attributes
	 * @param $posstr value for empty selection option
	 * @param $select_id make this participant id as 'selected'
	 * @return unknown_type
	 */
	function getParticipantSelection($championship_id, $pos, $posstr, $select_id = null, $disabled = false) {
		global $wpdb;
		
		$idpos = str_replace('[','',str_replace(']','',$pos));
		$sql = 'SELECT id,name,shortcode FROM '.$wpdb->prefix.$this->pf.'participant WHERE championship_id = '.$championship_id.' order by name;';
		$participant = $wpdb->get_results( $sql , OBJECT );
		$output = '<select '.($pos == 'participant[0]' ? 'class="mrl_disable" ' : '').($disabled ? 'disabled="disabled"' : '').' name="mrl_' . $pos . '" id="mrl_' . $idpos . '"><option value="-1">'.$posstr.'</option>';
		foreach ($participant as $row) {
			$output .= '<option ';
			if (isset($select_id) && $row->id == $select_id) {
				$output .= ' selected ';
			}
			$output .= 'value="'.$row->id.'">'.$row->name;
			$output .= '</option>';
		}
		$output .= "</select><br />\n";
							
		return $output;
	}
		
	/**
	 * Get the Driver name
	 * 
	 * @param unknown_type $participant_id
	 */
	function getParticipant($participant_id) {
		global $wpdb;
		
		$sql = "SELECT name FROM {$wpdb->prefix}{$this->pf}participant WHERE id = %d";
		return $wpdb->get_var($wpdb->prepare($sql, $participant_id));
	}
	
	/**
	 * Return the number of participants (drivers/riders) for a race in this championship
	 * 
	 * @param $championship_id
	 * @return int number of participants
	 */
	function getNumParticipants($championship_id) {
		global $wpdb;
		
		$sql = 'SELECT count(*) as "num" FROM '.$wpdb->prefix.$this->pf.'participant 
				WHERE championship_id = '.$championship_id;
		$result = $wpdb->get_row( $sql , OBJECT );
		return (int)$result->num;
		
	}
	
	/**
	 * Return this championship name
	 * 
	 * @param $champid
	 * @return unknown_type
	 */
	function getChampionshipName($champid) {
		global $wpdb;
		
		$sql = 'SELECT description FROM '.$wpdb->prefix.$this->pf.'championship WHERE id = '.$champid.';';
		$result = $wpdb->get_row( $sql , OBJECT );
	    
		if (!$result) return '';
		return $result->description;			
	}
			
	/**
	 * Return the number of predictions for a race in this championship
	 * 
	 * @param $champid
	 * @return int
	 */
	function getChampionshipNumPredictions($champid) {
		global $wpdb;
		
		$sql = 'SELECT num_predictions FROM '.$wpdb->prefix.$this->pf.'championship WHERE id = '.$champid.';';
		$result = $wpdb->get_row( $sql , OBJECT );

		if (is_null($result)) {
			return 0;
		}
		return (int)$result->num_predictions;			
	}
			
	function getRaceHeading($raceid) {
		global $wpdb;
		
		$str = '';
		$sql = "SELECT CONCAT(c.description, ' - ', circuit) AS heading
				FROM
					{$wpdb->prefix}{$this->pf}race r,
					{$wpdb->prefix}{$this->pf}championship c
				WHERE c.id = r.championship_id AND r.id = %d";
		$result = $wpdb->get_row( $wpdb->prepare($sql, $raceid) , OBJECT );
	    if ($result) {
	    	$str = $result->heading;
	    }
		return $str;
	}
	
	/**
	 * Get the circuit name for this race
	 * 
	 * @param $raceid
	 * @return unknown_type
	 */
	function getRaceName($raceid) {
		global $wpdb;
		
		$circuit_name = null;
		$sql = 'SELECT circuit FROM '.$wpdb->prefix.$this->pf.'race WHERE id = '.$raceid.';';
		$result = $wpdb->get_row( $sql , OBJECT );
	    if ($result) {
	    	$circuit_name = $result->circuit;
	    }
		return $circuit_name;
	}
	
	/**
	 * Get the race id name for this circuit
	 * 
	 * @param $circuit
	 * @return unknown_type
	 */
	function getRaceId($circuit, $champid) {
		global $wpdb;
		
		$id = null;
		$sql = 'SELECT id FROM '.$wpdb->prefix.$this->pf.'race WHERE circuit = "'.$circuit.'" AND championship_id = '.$champid.';';
		$result = $wpdb->get_row( $sql , OBJECT );
	    if ($result) {
	    	$id = $result->id;
	    }
		return $id;
	}
	
	/**
	 * Does this championship exist?
	 * 
	 * @param $champid championship id
	 * @return boolean true if exists, else false
	 */
	function championshipExists($champid) {
		global $wpdb;
		
		if (!(isset($champid) && !empty($champid))) {
			return false;
		}
		$ret =  $wpdb->get_var('SELECT COUNT(*) FROM '.$wpdb->prefix.$this->pf.'championship WHERE id = '.$champid.';');
		return ($ret != 0);
	}
	
	/**
	 * Returns the dynamic data inside the widget.
	 * Either one selected championship or all championships.
	 *
	 * @param $champid Display summary results for this championship id
	 * @param $limit Limit output to this number of rows.
	 * @return string HTML output for widget
	 */
	function getResultsWidgetData($champid, $limit) {
		global $wpdb;
		
		$out = '';
		if ($this->championshipExists($champid)) {
			
			$out .= '<p>' . $this->getChampionshipName($champid) . '</p>';
			return $out.$this->getPredictionSummary($champid, $limit);
		}
		
		$sql = 'SELECT id FROM '.$wpdb->prefix.$this->pf.'championship;';
		$result = $wpdb->get_results( $sql , OBJECT );

		foreach ($result as $row) {
			$out .= '<p>' . $this->getChampionshipName($row->id) . '</p>';
			$out .= $this->getPredictionSummary($row->id, $limit);
		}
		
		return $out;
	}
	
	/**
	 * Sets the textdomain for .mo and .po language files for internationalization
	 * 
	 */
	function setLanguage() {
		load_plugin_textdomain( $this->name, WP_PLUGIN_DIR.'/motor-racing-league/lang', 'motor-racing-league/lang' );
	}

	/**
	 * Process AJAX request to show predictions
	 * @return unknown_type
	 */
	function show_entries() {
		$compid = $_POST[$this->pf.'comp_id'];
		if (!is_numeric($compid)) die("Bad Id");  // Should never happen unless some hacks the id.
		$this->options->load($compid);
		if (isset($_POST['mrl_race'])) {
			$raceid = $_POST['mrl_race'];
			if ($raceid == -1 && isset($_POST[$this->pf.'next_race'])) {
				$raceid = $_POST[$this->pf.'next_race'];
			}
		} else {
			$raceid = $_POST[$this->pf.'next_race'];
		}
		if (!is_numeric($raceid)) die("Bad Id");  // Should never happen unless some hacks the id.
		die($this->showEntries($raceid, $compid, true));
	}
	
	/**
	 * Get data for the (last 10) entries. Only used for non-logged in players.
	 * 
	 * We must validate carefully as someone could use firebug to fudge
	 * the form and force the display of future predictions by changing
	 * the race id. However there's nothing to stop someone creating
	 * a dummy junk entry - seeing all the predictions, deleting the
	 * cookie and then making a real entry. That's the penalty for
	 * allowing visitors to make predictions !!!
	 * 
	 * Really I should never have allowed the display of all predictions
	 * after submiting an entry, but it's too late to change now.
	 * 
	 * Make sure users must be logged in to avoid this hassle.
	 * 
	 * Same applies to show stats AJAX calls.
	 * 
	 * @param $race_id Race id
	 * @param $champ_id championship id
	 * @param $all_entries Show all entries or limit to config parameter.
	 * @return html content
	 */
	function showEntries($race_id, $champ_id, $all_entries) {
		global $wpdb;
		
		$wpdb->show_errors(false); // Turn off otherwise it can interfer with AJAX output.
		//
		// Limit recent predictions to _widget_max but we need to multiply by the number
		// of predicted positions per entry
		//
		$numPredictions = (int)$this->getChampionshipNumPredictions($champ_id);
		$extra = 0;
		if ($this->options->get_predict_fastest()) $extra++;
		if ($this->options->get_predict_pole()) $extra++;
		$circuit = $this->getRaceName($race_id);
		$limit_num = (int)get_option('motorracingleague_widget_max', 10) * ($numPredictions + $extra);
		
		$limit = '';
		if (!$all_entries) {
			$limit = ' LIMIT ' . $limit_num;
		}
		
		$output =  "<div id='motorracingleague_show_results_$champ_id'>";
		
		$sql = 'SELECT pole_lap_time, `when`, player_name, shortcode, p.name AS shortcode_name, position, e.id as "id",
						rain, dnf, safety_car, double_up FROM '.
				$wpdb->prefix.$this->pf.'entry e, '.
				$wpdb->prefix.$this->pf.'participant p, '.
				$wpdb->prefix.$this->pf.'prediction pr '.
				' WHERE e.race_id = %d'.
				' AND p.id=pr.participant_id AND pr.entry_id=e.id ORDER BY `when` DESC, e.id, pr.id, position ASC' . $limit;
		$result = $wpdb->get_results( $wpdb->prepare($sql, $race_id) , OBJECT );
		$points_breakdown = array();
		if ($result) {
			
			$output .= "<table class='motorracingleague' width='100%'><caption>";
			if ($all_entries) {
				$output .= __('Predictions for ',$this->name).$circuit;
			} else {
				$output .= __('Latest predictions for ',$this->name).$circuit;
			}
			$output .= "</caption>";
			$output .= "<tr><th>".__('Player',$this->name)."</th>";
			if ($this->options->get_predict_rain()) {
				$output .= '<th scope="col">'.__('Rain', $this->name).'</th>';
			}
			if ($this->options->get_predict_safety_car()) {
				$output .= '<th scope="col">'.__('SC', $this->name).'</th>';
			}
			if ($this->options->get_predict_dnf()) {
				$output .= '<th scope="col">'.__('DNF', $this->name).'</th>';
			}
			if ($this->options->get_double_up()) {
				$output .= '<th scope="col">'.__('Double', $this->name).'</th>';
			}
			if ($this->options->get_predict_pole_time()) {
				$output .= '<th scope="col">'.__('Pole Time', $this->name).'</th>';
			}
			if ($this->options->get_predict_fastest()) {
				$output .= '<th scope="col">'.$this->fl_label($this->options->get_predict_lapsled(), true).'</th>';
			}
			if ($this->options->get_predict_pole()) {
				$output .= '<th scope="col">'.__('Pole', $this->name).'</th>';
			}
			for ($i = 1; $i <= $numPredictions; $i++) {
				$output .= "<th>$i.</th>";
			}
			$output .= "<th>".__('When', $this->name)."</th></tr>";
			
			
			/*
			 * For each entry we get $this->getChampionshipNumPredictions() rows. One
			 * row for each predicted position.
			 */
			$group_id = '';
			$nextrow = false;
			$when = '';
			foreach ($result as $row) {
				if ($group_id != $row->id) {
					$group_id = $row->id;		// New row
					if ($nextrow) {
						$output .= "<td>$when</td></tr>";
					}
					$when = $row->when;
					$output .= "<tr>";
					$output .= "<td>" . $this->shorten($row->player_name) . "</td>";
					if ($this->options->get_predict_rain()) {
						$output .= '<td>'.$this->pts($this->tick($row->rain), __('Rain', $this->name), $points_breakdown, 'rain', false).'</td>';
					}
					if ($this->options->get_predict_safety_car()) {
						$output .= '<td>'.$this->pts($this->tick($row->safety_car), __('Safety Car', $this->name), $points_breakdown, 'safety_car', false).'</td>';
					}
					if ($this->options->get_predict_dnf()) {
						$output .= '<td>'.$this->pts($row->dnf, __('DNF', $this->name), $points_breakdown, 'dnf', false).'</td>';
					}
					if ($this->options->get_double_up()) {
						$output .= '<td>'.$this->pts($this->tick($row->double_up), __('Double Up', $this->name), $points_breakdown, 'double_up', false).'</td>';
					}
					if ($this->options->get_predict_pole_time()) {
						$output .= "<td>".$this->pts($this->from_laptime($row->pole_lap_time), __('Pole Time', $this->name), $points_breakdown, 'pole_lap_time', false)."</td>\n";
					}
					$output .= "<td>" . $this->pts($row->shortcode, $row->shortcode_name, $points_breakdown, $row->position, false) . "</td>";
				} else {
					$nextrow=true;
					$output .= "<td>" . $this->pts($row->shortcode, $row->shortcode_name, $points_breakdown, $row->position, false) . "</td>";
				}
			}
			
			if ($nextrow) {
				$output .= "<td>$when</td></tr>";
			}
			$output .= "</table>";
			
		} else {
			$output .= "<p class='motorracingleague_error'>".__('No predictions available.',$this->name). "</p>";
		}
		$wpdb->show_errors(true);
		
		$output .= "<form id='motorracingleague_entries' method='post' action='#mrlpaneltop'>";
		
		/*
		 * Present options to:
		 * 	1. View predictions for different races and optionally return to the entry form
		 *  2. Show all predictions from the summary.
		 */
		if ($all_entries) {
			$output .= $this->getRaceSelection($champ_id, true, $race_id, null, 
				"onchange='motorracingleague_show_entry($champ_id,this.options[this.selectedIndex].value)'"); 
			if (!$this->hasPredicted($champ_id, $x)) {
				$output .= "<input type='hidden' name ='motorracingleague_show_entry_form' value='$champ_id'>
					<input type='submit' value='". __("Show Entry Form", $this->name) ."' />";
			}
		} else {
			$nextRaceId = $this->getNextAvailableRaceId($champ_id);
			if ($nextRaceId != -1) {
				$output .= "<input type='hidden' name ='motorracingleague_show_predictions' value='$nextRaceId'>
					<input type='submit' value='". __("Show All Predictions", $this->name) ."' />";
			}
		}		
		return $output . "</form>
		</div>";
	}

	/**
	 * Shorten a string and return <span title="long">short</span>
	 * @param $str
	 * @return unknown_type
	 */
	function shorten($str, $class = '') {
		$str = stripslashes($str);
		if (strlen(html_entity_decode($str)) > 23) {
			$str = '<span class="'.$class.'" title="'.$str.'">' . substr($str, 0, 20) . '&hellip;</span>';
		}
		return '<span class="'.$class.'">' . $str . '</span>';
	}
	
	/**
	 * Process AJAX request to save an entry
	 * 
	 * @return unknown_type
	 */
	function save_entry() {
		ob_start();
		$ret = $this->saveEntry();
		if ($ret['id'] != -1) {
			$ret['label'] = __('Update Prediction', $this->name);
		}
		if ($ret['id'] != -1 && get_option('motorracingleague_email_prediction')) {
			/*
			 * Saved OK - So email confirmation
			 */
			$this->email_confirmation($ret['id']);  // Entry ID
		}
		$output = ob_get_contents();  // Discard echoed output to prevent json breakage. Append to $ret['message'] for debugging
		ob_end_clean();
		die(json_encode($ret));
	}
	
	/**
	 * Saves entry form to database for the prediction
	 * 
	 * @return array with inserted entry "id" and status "message"
	 */
	function saveEntry() {
		global $wpdb;
		
		$ret = array("id" => -1, "label" => __('Add Prediction', $this->name), "message" => "<p class='motorracingleague_info'>".__('Your entry has been saved',$this->name)."</p>");
		$compid = $_POST[$this->pf.'comp_id'];
		$this->options->load($compid);
		$raceid = $_POST['mrl_race'];
		$participants = $_POST['mrl_participant'];
		$player = $this->getPlayerName();
		$email = $this->getPlayerEmail();
		$this->championship_id = $compid;
		$pole_lap_time = (isset($_POST[$this->pf.'pole_lap_time']) ? $_POST[$this->pf.'pole_lap_time'] : '00:00.000');
		$ret['logged_in'] = $this->options->get_must_be_logged_in();
		$optin = (isset($_POST[$this->pf.'optin']) ? 1 : 0);
		$rain = (isset($_POST[$this->pf.'rain']) ? 1 : 0);
		$safety_car = (isset($_POST[$this->pf.'safety_car']) ? 1 : 0);
		$double_up = (isset($_POST[$this->pf.'double_up']) ? 1 : 0);
		$dnf = (isset($_POST[$this->pf.'dnf']) ? $_POST[$this->pf.'dnf'] : 0);
		
		/*
		 * Must be logged in ?
		 */
		if ($this->needsAuthorisation() && !$this->isAuthorised()) {
			$ret["message"] = "<p class='motorracingleague_error'>".__('You must be logged in', $this->name)."</p>";
			return $ret;
		}
		
		/*
		 * Have all the fields been selected ?
		 */
		if (in_array(-1, $participants) || $player == '' || $email == '') {
			$ret["message"] = "<p class='motorracingleague_error'>".__('Please select all fields', $this->name)."</p>";
			return $ret;
		}
		
		if (!is_email($email)) {
			$ret["message"] = "<p class='motorracingleague_error'>".__('Not a valid email address', $this->name)."</p>";
			return $ret;
		}
		
		if ($this->options->get_predict_pole_time() && !$this->is_laptime($pole_lap_time)) {
			$ret["message"] = "<p class='motorracingleague_error'>".__('Lap time must be MM:SS.ccc format', $this->name)."</p>";
			return $ret;
		}
		$pole = $this->to_laptime($pole_lap_time);
		
		if (!is_numeric($dnf)) {
			$ret["message"] = "<p class='motorracingleague_error'>".__('DNF must be numeric', $this->name)."</p>";
			return $ret;
		}
		
		$qualifying_expired = $this->qualify_by_expired($raceid);
		
		$numPred = $this->getChampionshipNumPredictions($compid);
		
		if (!$qualifying_expired) {
			if ($this->options->get_predict_pole()) {
				$numPred++;
			}
		}
		if ($this->options->get_predict_fastest()) {
			$numPred++;
		}
		
		if (count($participants) != $numPred) {
			
			if ($qualifying_expired) {
				$ret["message"] = "<p class='motorracingleague_error'>".__('Qualifying deadline passed. Your entry has not been saved.', $this->name)."</p>";
			} else {
				$ret["message"] = "<p class='motorracingleague_error'>".__('Not all drivers selected.', $this->name)."</p>";
			}
			
			return $ret;
		}
		
		
		/*
		 * Verify Double Up not already used
		 */
		if ($double_up) {
			$sql = "SELECT COUNT(*) FROM
						{$wpdb->prefix}{$this->pf}entry e,
						{$wpdb->prefix}{$this->pf}race r
					WHERE
						double_up = 1 AND e.player_name = %s AND e.race_id = r.id AND
						e.race_id <> %d AND r.championship_id = %d";
			$doubled_up = $wpdb->get_var($wpdb->prepare($sql, $player, $raceid, $compid));
			if ($doubled_up) {
				$ret["message"] = "<p class='motorracingleague_error'>".__('You have already used your Double Up this season', $this->name)."</p>";
				return $ret;
			}
		}
		
		/* 
		 * Check if previous entry for this user has a matching email address to
		 * prevent someone else 'stealing' another players entry.
		 * Not necessary if logged in.
		 */ 
		if (!$this->needsAuthorisation()) {
			$sql = 'SELECT email FROM '
				.$wpdb->prefix.$this->pf.'entry e, '
				.$wpdb->prefix.$this->pf.'race r 
					WHERE player_name = %s AND e.race_id = r.id and r.championship_id = %d';
			$result = $wpdb->get_results( $wpdb->prepare($sql, $player, (int)$compid)  , OBJECT );
			if (count($result) != 0) {
				// Here we have a problem. In previous versions of the plugin this
				// check did not exist, so we may have legitimate entries with
				// different email addresses. So we need to check all of them.
				// Eventually the problem will go away as championships run thier
				// course and only new distinct entries exist.
				$found = false;
				foreach ($result as $row) {
					if ($row->email == $email) {
						$found = true;
						break;
					}
				}
				if (!$found) {
					$ret["message"] = "<p class='motorracingleague_error'>".__('Email address does not match previous entry', $this->name)."</p>";
					return $ret;
				}
			}
		}

		
		/*
		 * Duplicate selections ?
		 */
		$drivers = $participants;
		if (isset($drivers[0])) unset($drivers[0]); // Remove pole
		if (isset($drivers[-1])) unset($drivers[-1]); // Remove fastest
		$unique_drivers = array_unique($drivers);
		if (count($drivers) > count($unique_drivers)) {
			$ret["message"] = "<p class='motorracingleague_error'>".__('Duplicate drivers', $this->name)."</p>";
			return $ret;
		}

		/*
		 * Is the entry too late ? Actually we don't really care because when
		 * calculating the results we (TODO optionally) ignore late entries.
		 */
		$wpdb->show_errors(false); // Turn off otherwise it can interfer with AJAX output.
		
		if ($this->lateEntry($raceid)) {
			$ret["message"] = "<p class='motorracingleague_error'>".__('This entry has not been saved because it is too late',$this->name)."</p>";
		} else {
			
			/* Only INSERT, not updates for non-logged-in players, because without authentication of the
			 * player someone else could change your entry */
			if ($this->needsAuthorisation() && $this->isAuthorised()) {
				
				$sql = "SELECT id, pole_lap_time, double_up FROM
							{$wpdb->prefix}{$this->pf}entry e
						WHERE
							player_name = %s AND race_id = %d";
				$row = $wpdb->get_row($wpdb->prepare($sql, $player, $raceid));
				if ($row) {
					$ret["id"] = $row->id;
					$ret["race_id"] = $raceid;
					if ($qualifying_expired) {
						$pole = $row->pole_lap_time;  // Use original data as pole time
						$double_up = $row->double_up; // double up cannot be changed after qualifying has started 
					}
					$ok = $wpdb->query($wpdb->prepare("
						UPDATE {$wpdb->prefix}{$this->pf}entry
							SET points = 0, `when` = NOW(), pole_lap_time = %d, optin = %d, rain = %d, safety_car = %d, dnf = %d, double_up = %d
						WHERE id = %d", $pole, $optin, $rain, $safety_car, $dnf, $double_up, $row->id));
					$this->setCookie($compid, $raceid, $player, $email);
					if ($ok !== false) {
						foreach ($participants as $key=>$participant) {
							if ($qualifying_expired && (int)$key == 0) continue;  // Don't update pole sitter
							$ok = $wpdb->query( $wpdb->prepare( "
									UPDATE {$wpdb->prefix}{$this->pf}prediction
									SET participant_id = %d
									WHERE entry_id = %d AND position = %d", 
									$participant, $ret["id"], $key) );
							if ($ok === false) {
								$ret["message"] = "<p class='motorracingleague_error'>".__('Your entry could not be saved to the database.',$this->name)."<br />" . addslashes($wpdb->last_error) . "</p>";
								break;
							}
						}
					} else {
						$ret["message"] = "<p class='motorracingleague_error'>".__('Your entry could not be saved to the database.',$this->name)."<br />" . addslashes($wpdb->last_error) . "</p>";
					}
				} else {
					$ret = $this->insertEntryDb($ret, $compid, $player, $email, $raceid, $participants, $pole, $optin, $rain, $safety_car, $dnf, $double_up);
				}
				
			} else {
				$ret = $this->insertEntryDb($ret, $compid, $player, $email, $raceid, $participants, $pole, $optin, $rain, $safety_car, $dnf, $double_up);
			}
		}
						
		$wpdb->show_errors(true);
		return $ret;
	}

	/**
	 * Setup a cookie to prevent showing the entry form again
	 * 
	 * @param $compid
	 * @param $raceid
	 * @param $player
	 * @param $email
	 * @return unknown_type
	 */
	function setCookie ($compid, $raceid, $player, $email) {
		$lifetime = $this->options->get_cookie_seconds();
		setcookie("motorracingleague_".$compid, $raceid, time()+$lifetime, '/');
		setcookie('motorracingleague[player]', $player, time()+(60*60*24*365), '/');
		setcookie('motorracingleague[email]', $email, time()+(60*60*24*365), '/');
	}
	
	function insertEntryDb($ret, $compid, $player, $email, $raceid, $participants, $pole_lap_time, $optin, $rain, $safety_car, $dnf, $double_up) {
		global $wpdb;
		
		if ($this->qualify_by_expired($raceid)) {
			$ret["message"] = "<p class='motorracingleague_error'>".__('Qualifying deadline passed. Your entry has not been saved.', $this->name)."</p>";
			return $ret;
		}
		
		
		$ok = $wpdb->query( $wpdb->prepare( "
				INSERT INTO {$wpdb->prefix}{$this->pf}entry
				(player_name, email, race_id, points, pole_lap_time, optin, rain, safety_car, dnf, double_up, points_breakdown)
				VALUES ( %s, %s, %d, %d, %d, %d, %d, %d, %d, %d, %s )", 
				$player, $email, $raceid, 0, $pole_lap_time, $optin, $rain, $safety_car, $dnf, $double_up, '') );
				
		if ($ok) {
			$ret["id"] = $wpdb->insert_id;
			$ret["race_id"] = $raceid;
			$this->setCookie($compid, $raceid, $player, $email);
			
			foreach ($participants as $key=>$participant) {
				$ok = $wpdb->query( $wpdb->prepare( "
						INSERT INTO {$wpdb->prefix}{$this->pf}prediction
						(entry_id, participant_id, position)
						VALUES ( %d, %d, %d )", 
						$ret["id"], $participant, $key) );
				if (!$ok) {
					$ret["message"] = "<p class='motorracingleague_error'>".__('Your entry could not be saved to the database.',$this->name)."<br />" . addslashes($wpdb->last_error) . "</p>";
					break;
				}
			}
			
		} else {
			$ret["message"] = "<p class='motorracingleague_error'>".__('Your entry could not be saved to the database.',$this->name)."<br />" . addslashes($wpdb->last_error) . "</p>";
		}
		return $ret;
	}
	
	/**
	 * Is this entry too late, i.e. after the entry deadline ?
	 * @param $raceid race id
	 * @return bool true if late, otherwise false.
	 */
	function lateEntry($raceid, $dt = null) {
		global $wpdb;

		if (is_null($dt)) {
			$dt = 'NOW()';
		} else {
			$dt = '"' . $dt . '"';
		}
		
		$sql = 'SELECT UNIX_TIMESTAMP('.$dt.') as "now", UNIX_TIMESTAMP(entry_by) as "deadline" FROM ' .
			$wpdb->prefix.$this->pf.'race WHERE id = '.$raceid;
		$result = $wpdb->get_row($sql, OBJECT);
		if ($result) {
			if ($result->now > $result->deadline) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Determines if user is visiting the plugin's configuration page
	 *
	 * @return bool Returns true if user is looking at plugin's configuration page
	 */
	function isPluginConfigPage() {
		$page= $this->name.'/'. str_replace('.php', '', basename(__FILE__));
		if (isset($_REQUEST['page'])) {
			if ($_REQUEST['page'] == $page) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Clean the input string of dangerous input.
	 * @param $str input string
	 * @return cleaned string.
	 */
	function clean($str) {
		$str = @trim(htmlentities($str));
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	
	/**
	 * set message
	 *
	 * @param string $message
	 * @param boolean $error triggers error message if true
	 * @return none
	 */
	function setMessage( $message, $error = false )
	{
		$type = 'success';
		if ( $error ) {
			$this->error = true;
			$type = 'error';
		}
		$this->message[$type] = $message;
	}
	
	
	/**
	 * return message
	 *
	 * @param none
	 * @return string
	 */
	function getMessage()
	{
		if ( $this->error )
			return $this->message['error'];
		else
			return $this->message['success'];
	}
	
	
	/**
	 * print formatted message
	 *
	 * @param none
	 * @return string
	 */
	function printMessage()
	{
		if ( $this->error )
			echo "<div class='error'><p>".$this->getMessage()."</p></div>";
		else
			echo "<div id='message' class='updated fade'><p><strong>".$this->getMessage()."</strong></p></div>";
	}
	
	/**
	 * Gets the current date and time from the server
	 * 
	 * @return MySQL format date/time string YYYY-MM-DD HH:MM:SS
	 */
	function getServerDateTime() {
		global $wpdb;
		
		$sql = 'SELECT now() as "now";';
		$result = $wpdb->get_results( $sql , OBJECT );
		return $result[0]->now;
		
	}
	
	/**
	 * Gets the current date and time from the server and the
	 * date and time of the next prediction deadline.
	 * 
	 * @return Javascript format date/time string MM/DD/YYYY HH:MM AM/PM
	 */
	function getPredictionDateTime($champid) {
		global $wpdb;
		$deadline = array();
		
//		$sql = "SELECT DATE_FORMAT(NOW(), '%%m/%%d/%%Y %%r') AS 'now', 
//			 DATE_FORMAT(LEAST(COALESCE(qualify_by, entry_by), entry_by), '%%m/%%d/%%Y %%r') AS 'target' FROM {$wpdb->prefix}{$this->pf}race
//			 WHERE championship_id=%d AND LEAST(COALESCE(qualify_by, entry_by), entry_by) > NOW() ORDER BY entry_by ASC LIMIT 1";

		$sql = "SELECT
					DATE_FORMAT(NOW(), '%%m/%%d/%%Y %%r') AS 'now',
					DATE_FORMAT(entry_by, '%%m/%%d/%%Y %%r') AS 'target',
					id
				FROM {$wpdb->prefix}{$this->pf}race
				WHERE championship_id=%d AND entry_by > NOW() ORDER BY entry_by ASC LIMIT 1";
		$result = $wpdb->get_row( $wpdb->prepare($sql, $champid) , OBJECT );
		
		if (is_null($result) || is_null($result->target)) {
			return null;
		}
		
		$deadline['now'] = $result->now;
		$deadline['target'] = $result->target;
		
		// If there is a qualifying deadline - use that.
		if (!$this->qualify_by_expired($result->id)) {
			$sql = "SELECT
						DATE_FORMAT(NOW(), '%%m/%%d/%%Y %%r') AS 'now',
						DATE_FORMAT(qualify_by, '%%m/%%d/%%Y %%r') AS 'target'
					FROM {$wpdb->prefix}{$this->pf}race
					WHERE id=%d AND qualify_by IS NOT NULL AND qualify_by > NOW()";
			$result = $wpdb->get_row( $wpdb->prepare($sql, $result->id) , OBJECT );
			if ($result) {
				$deadline['now'] = $result->now;
				$deadline['target'] = $result->target;
			}
		}
		
		return $deadline;
	}
	
	/**
	 * Return a summary table for all the race predictions in this championship with a total
	 * 
	 * @param $champid championship id
	 * @param $limit Limit output to this many rows.
	 * 
	 * @return string HTML table
	 */
	function getPredictionSummary($champid, $limit = 10) {
		global $wpdb;
		
		if (!is_numeric($limit)) $limit = 10;
		
		$sql = 'SELECT player_name, sum(points) as "total" FROM '
				.$wpdb->prefix.$this->pf.'entry e, '
				.$wpdb->prefix.$this->pf.'race r WHERE r.championship_id = '.$champid.' AND e.race_id = r.id
				GROUP BY player_name ORDER BY total DESC LIMIT '.$limit.';';
		$entry = $wpdb->get_results( $sql , OBJECT );

		$output = '<table class="motorracingleague motorracingleague_results"><thead>';
		$output .= "<tr><th class='motorracingleague_player'>".__('Player',$this->name)."</th>";
		$output .= "<th>".__('Rank',$this->name)."</th>";
		$output .= "<th scope='col'>".__('Total',$this->name)."</th></tr></thead>\n";
		$output .= "<tbody>";
		/*
		 * To calculate the rank of players we need to check the next
		 * item to see if it has the same total.
		 */
		$rank = 1;
		$rank_str = ''.$rank;
		$prev_total = -1;
		foreach ($entry as $row) {
			if ($prev_total != $row->total) {
				$rank_str = ''.$rank;
			}
			$output .= '<tr><th class="motorracingleague_player" scope="row">'.$this->shorten($row->player_name).'</th>';
			$output .= '<td>'.$rank_str.'</td>';
			$output .= "\n<td>".$row->total.'</td></tr>';
			$rank++;
			$prev_total = $row->total;
		}
		
		$output .= "\n</tbody></table>";
		
		return $output;
				
	}
	
	/**
	 * Display a summary of predictions for all races.
	 * 
	 * @param $champid championship id
	 * @param $future_races if true show races not yet completed
	 * @param $style Add this style to the HTML table
	 * @param $max_cols If greater then add player name to RHS of table for scrolling.
	 * @param $used_doubleups Display extra table of players who have used double ups.
	 * 
	 * @return unknown_type
	 */
	function getAllStandings($champid, $future_races = true, $style='', $max_cols = 10, $used_doubleups = false) {
		global $wpdb;
		
		$output = '';
		
		/*
		 * TODO - I should be able to do this with a single SQL statement but
		 * very annoyingly Wordpress supports MySQL 4.0+ which does not 
		 * support sub-queries.
		 * 
		 * I'd like to do something like (simplified) :-
		 * 
		 * SELECT p.player,COALESCE(e.points,0) points,r.race_id
		 * 		FROM (SELECT DISTINCT(player) FROM entry ORDER BY player) p 
		 * 			JOIN race r 
		 * 			LEFT JOIN entry e 
		 * 			ON e.race_id = r.race_id AND e.player = p.player;
		 * 
		 * But I can't, so it's a temporary table.
		 * 
		 */

		//$wpdb->show_errors(true);
		
		
		$args = func_get_args();
		if (!is_admin()) {
			// check for cached table
			$cache = get_transient($this->pf . 'standings_' . $champid);
			if ($cache !== false) {
				// If shortcode args have not changed
				if ($cache['args'] == $args) {
					return $cache['output'];
				}
			}
		}
		
		/*
		 * Admin panels want to see future races results
		 */
		$laterraces = '';
		if (!$future_races) {
			
			$laterraces = 'AND race_start < now()';
		}
		
		/*
		 * Create a couple of temporary tables with just the entries and races
		 * for this championship.
		 */
		$sql = "CREATE TEMPORARY TABLE player
					SELECT player_name, SUM(points) AS total, MAX(points) AS best_result, MIN(e.when) AS earliest_entry, MAX(double_up) AS doubled_up
					FROM 
						{$wpdb->prefix}{$this->pf}entry e, 
						{$wpdb->prefix}{$this->pf}race r
					WHERE
						r.championship_id = %d AND e.race_id = r.id
						$laterraces
					GROUP BY e.player_name";
				
		$wpdb->query( $wpdb->prepare($sql, $champid) );
		
//		echo '<pre>' . print_r($wpdb->get_results( "select * from player" , OBJECT ), true) . '</pre>';

		$sql = "CREATE TEMPORARY TABLE race
					SELECT id, circuit, race_start FROM 
						{$wpdb->prefix}{$this->pf}race
					WHERE
						championship_id = %d $laterraces ORDER BY race_start";
		$wpdb->query( $wpdb->prepare($sql, $champid) );
		
		/*
		 * Some table headers please.
		 */
		$esc = chr(27);  // Separator
		$sql = "SELECT race.id, circuit
				FROM 
					race
				ORDER BY
					race_start";
		$race = $wpdb->get_results( $sql , OBJECT_K );
		
//		echo '<pre>' . print_r($race, true) . '</pre>';
		
		/*
		 * Create a table thus:
		 * 
		 *          Rank  circuit1  circuit2  circuit3 ...   Total
		 * player1    1      5         0        15             20
		 * player2    2      0        10         5             15
		 * 
		 */
		
		$output = '<table class="motorracingleague motorracingleague_results" '.$style.'><thead>';
		$output .= "<tr><th class='motorracingleague_player'>".__('Player',$this->name)."</th>";
		$output .= "<th>".__('Rank',$this->name)."</th>";
		
		$cols = count($race);
		foreach ($race as $row) {
			$output .= "<th scope='col'><span title='$row->circuit'>".substr($row->circuit,0,3)."</span></th>";
		}
		$output .= "<th scope='col'>".__('Total',$this->name)."</th>";
		if ($cols > $max_cols) {
			$output .= "<th scope='col'>".__('Player',$this->name)."</th>";
		}
		$output .= "</tr></thead>";
		$output .= "<tbody>";
		
		/*
		 * Grab the points and predictions for each candidate entry and race.
		 */
		$sql = "SELECT p.player_name as player_name, COALESCE(e.points, 0) points, r.id as id,
						p.total as total, COALESCE(e.points_breakdown, '') AS points_breakdown, doubled_up,
						GROUP_CONCAT(CONCAT(pre.position, '\t', pt.name) ORDER BY pre.position SEPARATOR '$esc') AS prediction
				FROM 
					player p
				JOIN 
					race r
				LEFT JOIN 
					{$wpdb->prefix}{$this->pf}entry e
				ON 
					e.race_id = r.id AND e.player_name = p.player_name
				LEFT JOIN
					{$wpdb->prefix}{$this->pf}prediction pre
				ON
					e.id = pre.entry_id
				LEFT JOIN
					{$wpdb->prefix}{$this->pf}participant pt
				ON
					pre.participant_id = pt.id
				GROUP BY
					r.id, e.id, p.player_name 
				ORDER BY total DESC, best_result DESC, earliest_entry ASC, p.player_name, r.race_start ASC";
		$result = $wpdb->get_results( $sql , OBJECT );
		
//		echo '<pre>' . print_r($result, true) . '</pre>';
				
		$rank = 1;
		$rank_str = ''.$rank;
		$old_player = '';
		$old_doubled_up = '';
		$total = -1;  // Is $row->total in scope outside the foreach loop ? 
		
		/*
		 * SQL spits out x rows per player, where x is the number of candidate races.
		 * Write out the player_name when it changes, otherwise each of the points per race.
		 */
		foreach ($result as $row) {

			if ($row->player_name != $old_player) {
				if ($old_player != '') {
					$output .= "<td>$total</td>";
					if ($cols > $max_cols) {
						$output .= "<th>".$this->shorten($old_player, ($old_doubled_up ? $this->pf.'doubled '.$this->pf.'right' : ''))."</th>";
					}
					$output .= '</tr>';
				}
				if ($total != $row->total) {
					$rank_str = ''.$rank;
				}
				$output .= '<tr><th class="motorracingleague_player" scope="row">';
				$output .= $this->shorten($row->player_name, ($row->doubled_up ? $this->pf.'doubled '.$this->pf.'left' : ''))."</th><td>$rank_str</td>\n";
				$output .= '<td title="'.$this->get_points_summary($row->id, $row->points_breakdown, $row->prediction).'">'.$row->points.'</td>';
				$old_player = $row->player_name;
				$old_doubled_up = $row->doubled_up;
				$total = $row->total;
				$rank++;
			} else {
				$output .= '<td title="'.$this->get_points_summary($row->id, $row->points_breakdown, $row->prediction).'">'.$row->points.'</td>';
			}
		}
		
		if ($old_player != '') {
			$output .= "<td>$total</td>";
			if ($cols > $max_cols) {
				$output .= "<th>".$this->shorten($old_player, ($old_doubled_up ? $this->pf.'doubled '.$this->pf.'right' : ''))."</th>";
			}
			$output .= '</tr>';
		}
		
		$output .= '</tbody></table>';
		
		/*
		 * Show double up usage
		 */
		
		if ($used_doubleups) {
			
			$sql = "SELECT player_name, circuit, points_breakdown
					FROM
						race r
					LEFT JOIN 
						{$wpdb->prefix}{$this->pf}entry e
					ON
						e.race_id = r.id
					WHERE	
						 double_up = 1
					ORDER BY race_start";
			
			$dups = $wpdb->get_results( $wpdb->prepare($sql, $champid) );
			
			$output .= '<table class="motorracingleague motorracingleague_double_ups" '.$style.'><thead>';
			$output .= "<tr><th class='motorracingleague_player'>".__('Players already doubled up',$this->name)."</th>";
			$output .= "<th class='race_name'>".__('Race',$this->name)."</th>";
			$output .= "<th scope='col' class='extra_points'>".__('Extra points awarded',$this->name)."</th>";
			$output .= "</tr></thead>";
			$output .= "<tbody>";
			
			foreach ($dups as $row) {
				$output .= '<tr><td class="motorracingleague_player" scope="row">';
				$output .= $this->shorten($row->player_name)."</td>";
				$output .= '<td>'.stripslashes($row->circuit) . '</td>';
				$extra = 0;
				if (is_serialized($row->points_breakdown)) {
					$points_breakdown = unserialize($row->points_breakdown);
					if (isset($points_breakdown['double_up'])) {
						$extra = $points_breakdown['double_up'];
					}
				}
				$output .= '<td class="extra_points">'. $extra . '</td>';
			}
				
			$output .= '</tbody></table>';
		
		}
		
		$wpdb->query('DROP TEMPORARY TABLE IF EXISTS player, race;');
		
		/*
		 * Cache these results. Cache is trashed when scoring is re-calculated.
		*/
		if (!is_admin()) {
			set_transient($this->pf . 'standings_' . $champid,
					array('output' => $output, 'args' => $args), WEEK_IN_SECONDS);
		}
		
		return $output;
	}

	function get_points_summary($race_id, $points_breakdown, $prediction) {
		$points_list = array();
		$summary = '';
		$esc = chr(27);  // Separator
		
		if (is_serialized($points_breakdown)) {
			$points_breakdown = unserialize($points_breakdown);
			ksort($points_breakdown);
			
			$predicted_positions = array();
			$pp = explode($esc, $prediction);
			if (!empty($pp)) {
				foreach ($pp as $f) {
					list($position, $name) = explode("\t", $f);
					$predicted_positions[$position] = stripslashes($name);
				}
			}
			
//			echo '<pre>' . print_r($points_breakdown, true) . '</pre>';
			
			foreach ($points_breakdown as $key=>$apoint) {
				
				if ($apoint) {
					$name = '';
					switch ($key) {
						case '-1' : $name = $this->fl_label($this->options->get_predict_lapsled()); break;
						case '0' : $name = __('Pole', $this->name); break;
						case 'rain' : $name = __('Rain', $this->name); break;
						case 'safety_car' : $name = __('Safety Car', $this->name); break;
						case 'dnf' : $name = __('DNF', $this->name); break;
						case 'double_up' : $name = __('Double Up', $this->name); break;
						case 'pole_lap_time' : $name = __('Pole Time', $this->name); break;
						case 'bonus' : $name = __('Bonus', $this->name); break;
						case 'total' : break;
						default: {
							if (is_numeric($key) && isset($predicted_positions[$key])) {
								$name = $predicted_positions[$key];
							}
						}
					}
					if ($name) array_push($points_list, "$name +$apoint");
				}
			}
			$summary = implode(', ', $points_list);
		}
		
		return $summary;
	}
	
	/**
	 * Not implemented
	 * 
	 * @param $champid
	 * @param $ignoredeadline - Show prediction stats regardless
	 * @return unknown_type
	 */
	function showPredictionStatistics($champid, $ignoredeadline = 0) {
		global $wpdb;
		
		$race_id = -1;
		
		if (!is_numeric($ignoredeadline)) $ignoredeadline = 0;
		
		$sql = "SELECT id, circuit, race_start, entry_by FROM {$wpdb->prefix}{$this->pf}race 
				WHERE championship_id = %d AND (entry_by < NOW() OR %d = 1) ORDER BY race_start DESC";
		$result = $wpdb->get_results( $wpdb->prepare($sql, $champid, $ignoredeadline) , OBJECT );
		$output = __('Prediction statistics for:', $this->name) . ' <select name="mrl_stats_race" id="mrl_stats_race" champid="'.$champid.'" ignoredeadline="'.$ignoredeadline.'">';
		foreach ($result as $row) {
			if ($race_id == -1) $race_id = $row->id;
			$output .= '<option ';
			$output .= " value='$row->id'>$row->circuit";
			$output .= '</option>';
		}
		$output .= "</select>";
		
		$output .= '<div id="mrl_stats">';
		$output .= $this->get_prediction_stats($champid, $race_id, $ignoredeadline);
		$output .= '</div>';
		return $output;
		
	}
	
	/*
	 * Get a summary of prediction statistics for this race.
	 */
	function get_prediction_stats($champid, $raceid, $ignoredeadline = 0) {
		$output = '';
		
		$this->championship_id = $champid;
		$this->options->load($champid);
		$output .= $this->getRaceResult($champid, $raceid);
		$output .= $this->getPredictionStats($champid, $raceid, $ignoredeadline);
		
		return $output;
	}
	
	/*
	 * Process AJAX request
	 */
	function get_stats() {
		if (isset($_POST['champid']) && is_numeric($_POST['champid']) &&
			isset($_POST['raceid']) && is_numeric($_POST['raceid'])) {
			
			$ignoredeadline = 0;
			if (isset($_POST['ignoredeadline']) && is_numeric($_POST['ignoredeadline'])) {
				$ignoredeadline = $_POST['ignoredeadline'];
			}
			
			$output = $this->get_prediction_stats($_POST['champid'], $_POST['raceid'], $ignoredeadline);
		} else {
			$output = __('Statistics not available', $this->name);
		}
		die($output);
	}
	
	/*
	 * Get some prediction stats
	 * 
	 * We must validate carefully as someone could use firebug to fudge
	 * the form and force the display of future predictions by changing
	 * the race id.
	 * 
	 * Same applies to show predictions AJAX calls.
	 */
	function getPredictionStats($champid, $raceid, $ignoredeadline = 0) {
		global $wpdb;
		$total = 0;
		$this->options->load($champid);
		
		
		/*
		 * Total predictions
		 */
		$sql = "SELECT COUNT(*) AS total FROM
					{$wpdb->prefix}{$this->pf}entry e,
					{$wpdb->prefix}{$this->pf}race r
				WHERE r.id = %d AND (NOW() > entry_by OR %d = 1) AND e.race_id = r.id";
		$row = $wpdb->get_row($wpdb->prepare($sql, $raceid, $ignoredeadline));
		if (!$row || $row->total == 0) {
			return __('Statistics not available', $this->name);
		}
		
		
		$total = $row->total;
//		$output .= '<pre>' . print_r($row, true) . '</pre>';
		
		$output = '<table class="motorracingleague">';
		$output .= '<caption>'.__('Prediction Summary', $this->name).' &ndash; '.$total.' '.__('predictions', $this->name).'</caption>';
		
		/*
		 * Rain guesses
		 */
		if ($this->options->get_predict_rain()) {
			$sql = "SELECT COUNT(*) AS freq, rain FROM
						{$wpdb->prefix}{$this->pf}entry e
					WHERE
						e.race_id = %d
					GROUP BY
						rain
					ORDER BY
						rain
					LIMIT 5";
			$result = $wpdb->get_results($wpdb->prepare($sql, $raceid));
			//			$output .= '<pre>' . print_r($result, true) . '</pre>';
			$output .= '<tr><td>'.__('Rain', $this->name).'</td><td><table class="motorracingleague_stats">';
			foreach ($result as $row) {
				$perc = round($row->freq / $total  * 100, 2);
				$output .= "<tr><td>".$this->tick($row->rain)."</td><td style='text-align:right'>$row->freq</td><td>$perc%</td></tr>";
			}
			$output .= '</table></td></tr>';
		}
		
		/*
		 * Safety Car guesses
		*/
		if ($this->options->get_predict_safety_car()) {
			$sql = "SELECT COUNT(*) AS freq, safety_car FROM
						{$wpdb->prefix}{$this->pf}entry e
					WHERE
						e.race_id = %d
					GROUP BY
						safety_car
					ORDER BY
						safety_car
					LIMIT 5";
			$result = $wpdb->get_results($wpdb->prepare($sql, $raceid));
			//			$output .= '<pre>' . print_r($result, true) . '</pre>';
			$output .= '<tr><td>'.__('Safety Car', $this->name).'</td><td><table class="motorracingleague_stats">';
			foreach ($result as $row) {
				$perc = round($row->freq / $total  * 100, 2);
				$output .= "<tr><td>".$this->tick($row->safety_car)."</td><td style='text-align:right'>$row->freq</td><td>$perc%</td></tr>";
			}
			$output .= '</table></td></tr>';
		}
		
		/*
		 * DNF guesses
		*/
		if ($this->options->get_predict_dnf()) {
			$sql = "SELECT COUNT(*) AS freq, dnf FROM
						{$wpdb->prefix}{$this->pf}entry e
					WHERE
						e.race_id = %d
					GROUP BY
						dnf
					ORDER BY
						freq DESC
					LIMIT 5";
			$result = $wpdb->get_results($wpdb->prepare($sql, $raceid));
			//			$output .= '<pre>' . print_r($result, true) . '</pre>';
			$output .= '<tr><td>'.__('DNF', $this->name).'</td><td><table class="motorracingleague_stats">';
			foreach ($result as $row) {
				$perc = round($row->freq / $total  * 100, 2);
				$output .= "<tr><td>$row->dnf</td><td style='text-align:right'>$row->freq</td><td>$perc%</td></tr>";
			}
			$output .= '</table></td></tr>';
		}
		
		/*
		 * DNF guesses
		*/
		if ($this->options->get_double_up()) {
			$sql = "SELECT COUNT(*) AS freq, double_up FROM
						{$wpdb->prefix}{$this->pf}entry e
					WHERE
						e.race_id = %d
					GROUP BY
						double_up
					ORDER BY
						double_up
					LIMIT 5";
			$result = $wpdb->get_results($wpdb->prepare($sql, $raceid));
			//			$output .= '<pre>' . print_r($result, true) . '</pre>';
			$output .= '<tr><td>'.__('Double Up', $this->name).'</td><td><table class="motorracingleague_stats">';
			foreach ($result as $row) {
			$perc = round($row->freq / $total  * 100, 2);
			$output .= "<tr><td>".$this->tick($row->double_up)."</td><td style='text-align:right'>$row->freq</td><td>$perc%</td></tr>";
			}
			$output .= '</table></td></tr>';
		}
		
		
		/*
		 * Pole position guesses
		 */
		if ($this->options->get_predict_pole()) {
			$sql = "SELECT COUNT(*) AS freq, pt.shortcode FROM
						{$wpdb->prefix}{$this->pf}prediction p,
						{$wpdb->prefix}{$this->pf}participant pt,
						{$wpdb->prefix}{$this->pf}entry e
					WHERE
						p.participant_id = pt.id AND p.entry_id = e.id AND position = 0 AND e.race_id = %d
					GROUP BY
						participant_id
					ORDER BY
						freq DESC
					LIMIT 5";
			$result = $wpdb->get_results($wpdb->prepare($sql, $raceid));
//			$output .= '<pre>' . print_r($result, true) . '</pre>';
			$output .= '<tr><td>'.__('Pole Position', $this->name).'</td><td><table class="motorracingleague_stats">';
			foreach ($result as $row) {
				$perc = round($row->freq / $total  * 100, 2);
				$output .= "<tr><td>$row->shortcode</td><td style='text-align:right'>$row->freq</td><td>$perc%</td></tr>";
			}
			$output .= '</table></td></tr>';
		}
		
		/*
		 * Fastest lap guesses
		 */
		if ($this->options->get_predict_fastest()) {
			$sql = "SELECT COUNT(*) AS freq, pt.shortcode FROM
						{$wpdb->prefix}{$this->pf}prediction p,
						{$wpdb->prefix}{$this->pf}participant pt,
						{$wpdb->prefix}{$this->pf}entry e
					WHERE
						p.participant_id = pt.id AND p.entry_id = e.id AND position = -1 AND e.race_id = %d
					GROUP BY
						participant_id
					ORDER BY
						freq DESC
					LIMIT 5";
			$result = $wpdb->get_results($wpdb->prepare($sql, $raceid));
//			$output .= '<pre>' . print_r($result, true) . '</pre>';
			$output .= '<tr><td>'.$this->fl_label($this->options->get_predict_lapsled()).'</td><td><table class="motorracingleague_stats">';
			foreach ($result as $row) {
				$perc = round($row->freq / $total  * 100, 2);
				$output .= "<tr><td>$row->shortcode</td><td style='text-align:right'>$row->freq</td><td>$perc%</td></tr>";
			}
			$output .= '</table></td></tr>';
		}
		
		/*
		 * Win guesses
		 */
		if ($this->options->get_predict_pole()) {
			$sql = "SELECT COUNT(*) AS freq, pt.shortcode FROM
						{$wpdb->prefix}{$this->pf}prediction p,
						{$wpdb->prefix}{$this->pf}participant pt,
						{$wpdb->prefix}{$this->pf}entry e
					WHERE
						p.participant_id = pt.id AND p.entry_id = e.id AND position = 1 AND e.race_id = %d
					GROUP BY
						participant_id
					ORDER BY
						freq DESC
					LIMIT 5";
			$result = $wpdb->get_results($wpdb->prepare($sql, $raceid));
//			$output .= '<pre>' . print_r($result, true) . '</pre>';
			$output .= '<tr><td>'.__('Race Win', $this->name).'</td><td><table class="motorracingleague_stats">';
			foreach ($result as $row) {
				$perc = round($row->freq / $total  * 100, 2);
				$output .= "<tr><td>$row->shortcode</td><td style='text-align:right'>$row->freq</td><td>$perc%</td></tr>";
			}
			$output .= '</table></td></tr>';
		}
		
		/*
		 * Pole lap time guesses
		 */
		$pole_lap_time = 0;
		$participant = '';
		if ($this->options->get_predict_pole_time()) {
			$sql = "SELECT pole_lap_time, name FROM
						{$wpdb->prefix}{$this->pf}result r,
						{$wpdb->prefix}{$this->pf}race race,
						{$wpdb->prefix}{$this->pf}participant pt
					WHERE race.id = %d AND r.race_id = race.id AND r.position = 0 AND pt.id = r.participant_id";
			$row = $wpdb->get_row($wpdb->prepare($sql, $raceid));
			if ($row && $row->pole_lap_time != 0) {
			
//				$output .= '<pre>' . print_r($row, true) . '</pre>';
				$pole_lap_time = $row->pole_lap_time;
				$participant = $row->name;
			}
				
			$sql = "SELECT AVG(pole_lap_time) AS avg FROM
						{$wpdb->prefix}{$this->pf}entry e
					WHERE
						e.race_id = %d";
			$pole = $wpdb->get_row($wpdb->prepare($sql, $raceid));
			//$output .= '<pre>' . print_r($result, true) . '</pre>';
		
			$output .= '<tr><td>'.__('Pole Lap Time', $this->name).'<br />'.$this->from_laptime((int)$pole->avg).' ('.__('average', $this->name).')</td><td><table class="motorracingleague_stats">';
			
			$sql = "SELECT pole_lap_time, player_name FROM
						{$wpdb->prefix}{$this->pf}entry e
					WHERE
						e.race_id = %d AND pole_lap_time >= %d
					ORDER BY
						pole_lap_time ASC
					LIMIT 3";
			$result = $wpdb->get_results($wpdb->prepare($sql, $raceid, $pole_lap_time), ARRAY_A);
			//$output .= '<pre>' . print_r($result, true) . '</pre>';
			if ($result && $pole_lap_time != 0) {
				for ($i = count($result) - 1; $i >= 0; $i--) {
					$diff = ($pole_lap_time != 0 ? "(+" . $this->from_laptime((int)$result[$i]['pole_lap_time'] - $pole_lap_time) . ')' : '');
					$output .= "<tr><td>".$this->from_laptime($result[$i]['pole_lap_time'])."</td><td>{$result[$i]['player_name']} $diff</td></tr>";
				}
			}
			
			$sql = "SELECT pole_lap_time, player_name FROM
						{$wpdb->prefix}{$this->pf}entry e
					WHERE
						e.race_id = %d AND pole_lap_time < %d
					ORDER BY
						pole_lap_time DESC
					LIMIT 3";
			$result = $wpdb->get_results($wpdb->prepare($sql, $raceid, $pole_lap_time));
			if ($pole_lap_time != 0) $output .= "<tr><td><strong>".$this->from_laptime($pole_lap_time)."</td><td><strong>$participant</strong></td></tr>";
			foreach ($result as $row) {
				$diff = ($pole_lap_time != 0 ? "(-" . $this->from_laptime($pole_lap_time - $row->pole_lap_time) . ')' : '');
				$output .= "<tr><td>".$this->from_laptime($row->pole_lap_time)."</td><td>$row->player_name $diff</td></tr>";
			}
			$output .= '</table></td></tr>';
			//$output .= '<pre>' . print_r($result, true) . '</pre>';
		}
		
		/*
		 * Positional guesses. NOTE: Only Top 3 positions. After about 6 positions
		 * mySQL can go CPU bound for this query !!!!!
		 */
		$numPredictions = (int)$this->getChampionshipNumPredictions($champid);
		if (get_option('motorracingleague_max_stats')) {
			$numPredictions = get_option('motorracingleague_max_stats');
		}
		
		$tab = '';
		$where = '';
		$sel = '';
		$grp = array();
		for ($i = 1; $i <= $numPredictions; $i++) {
			$grp[] = "p$i.participant_id";
			$sel .= "pt$i.shortcode AS s$i, ";
			$tab .= "{$wpdb->prefix}{$this->pf}prediction p$i, {$wpdb->prefix}{$this->pf}participant pt$i,";
			$where .= "p$i.position = $i AND p$i.participant_id = pt$i.id AND p$i.entry_id = e.id AND ";
		}
		$grp = implode(',', $grp);
		$sql = "SELECT COUNT(*) AS freq, $sel e.id
				FROM {$tab} {$wpdb->prefix}{$this->pf}entry e
				WHERE $where e.race_id=%d
				GROUP BY $grp
				ORDER BY freq DESC
				LIMIT 10";
		
//		$output .= '<pre>' . $wpdb->prepare($sql, $raceid) . '</pre>';
		$result = $wpdb->get_results($wpdb->prepare($sql, $raceid), ARRAY_N);
//		$output .= '<pre>' . print_r($result, true) . '</pre>';
		
		$output .= '<tr><td>'.__('Most frequent podium predictions', $this->name).'</td><td><table class="motorracingleague_stats">';
		foreach ($result as $row) {
			$output .= '<tr>';
			for ($i = 0; $i <= $numPredictions; $i++) {
				$output .= "<td style='text-align:right'>$row[$i]</td>";
			}
			$output .= '</tr>';
		}
		$output .= '</table></td></tr>';
		
		$output .= '</table>';
		
		return $output;
	}
	
	/**
	 * Display the results of a race.
	 * 
	 * @param $champid Championship id
	 * @return html string.
	 */
	function getRaceResult($champid, $raceid) {
		global $wpdb;
		$cols = 0;
		
		$numPredictions = (int)$this->getChampionshipNumPredictions($champid);
		$sql = 'SELECT p.name AS pname, pole_lap_time, r.id as "id", r.circuit as "circuit", p.shortcode as "shortcode", res.position as "position", r.rain, r.safety_car, r.dnf FROM '
			.$wpdb->prefix.$this->pf.'participant p, '
			.$wpdb->prefix.$this->pf.'race r, '
			.$wpdb->prefix.$this->pf.'result res  WHERE r.id = '.$raceid. 
			' AND r.id = res.race_id AND res.participant_id = p.id 
				ORDER BY position';
		
		$res = $wpdb->get_results( $sql , OBJECT );
		
		
		$output = '<table class="motorracingleague"><caption>'.__('Race result', $this->name).'</caption><thead><tr>';
		if ($this->options->get_predict_rain()) {
			$cols++;
			$output .= '<th scope="col">'.__('Rain', $this->name).'</th>';
		}
		if ($this->options->get_predict_safety_car()) {
			$cols++;
			$output .= '<th scope="col">'.__('SC', $this->name).'</th>';
		}
		if ($this->options->get_predict_dnf()) {
			$cols++;
			$output .= '<th scope="col">'.__('DNF', $this->name).'</th>';
		}
		if ($this->options->get_predict_pole_time()) {
			$cols++;
			$output .= '<th scope="col">'.__('Pole Time', $this->name).'</th>';
		}
		if ($this->options->get_predict_fastest()) {
			$cols++;
			$output .= '<th scope="col">'.$this->fl_label($this->options->get_predict_lapsled(), true).'</th>';
		}
		if ($this->options->get_predict_pole()) {
			$cols++;
			$output .= '<th scope="col">'.__('Pole', $this->name).'</th>';
		}
		for ($i = 1; $i <= $numPredictions; $i++) {
			$output .= '<th scope="col">'.$i.'.</th>';
		}
		$output .= '</tr></thead>
		<tbody>';
		
		if (!$res) { // $numPredictions + $cols
			$output .= '<tr><td colspan="'.($numPredictions + $cols).'">' . __('Race Results not yet available', $this->name) . '</td></tr>';
		} else {
			$output .= '<tr>';
			
			if ($this->options->get_predict_rain()) {
				$output .= '<td>'.$this->tick($res[0]->rain).'</td>';
			}
			if ($this->options->get_predict_safety_car()) {
				$output .= '<td>'.$this->tick($res[0]->safety_car).'</td>';
			}
			if ($this->options->get_predict_dnf()) {
				$output .= '<td>'.$res[0]->dnf.'</td>';
			}
			if ($this->options->get_predict_pole_time()) {
				$output .= "<td>".$this->from_laptime($res[0]->pole_lap_time)."</td>\n";
			}
			foreach ($res as $row) {
					$output .= "<td title='$row->pname'>$row->shortcode</td>\n";
			}
			$output .= '</tr>';
		}
		
		return $output . '</tbody></table>';
	}
	
	/**
	 * Does the player have to be logged in to predict ?
	 * 
	 * @return bool true yes, false no
	 */
	function needsAuthorisation() {
		return $this->options->get_must_be_logged_in();
	}
	
	/**
	 * Is the player logged in with the correct rights ?
	 * 
	 * User must have 'predict' capability.
	 * 
	 * @return bool true yes, false no
	 */
	function isAuthorised() {
		return current_user_can('predict');
	}
	
	/**
	 * Return a string with user details
	 * @return string player name
	 */
	function getPlayerName() {
		
		global $current_user;
		
		if ($this->needsAuthorisation() && $this->isAuthorised()) {
			get_currentuserinfo();
			if (get_option('motorracingleague_display_name')) {
				return $current_user->display_name;
			} else {
				return $current_user->user_login;
			}
		} else {
			return $this->clean($_REQUEST[$this->pf.'player']);
		}
	}
	
	/**
	 * Return players' email address
	 * @return string email
	 */
	function getPlayerEmail() {
		
		global $current_user;
		
		if ($this->needsAuthorisation() && $this->isAuthorised()) {
			get_currentuserinfo();
			return $current_user->user_email;
		} else {
			return $this->clean($_REQUEST[$this->pf.'email']);
		}
	}
	
	/**
	 * Has user already made a prediction for this championship.
	 * 
	 * @param $champid championship id
	 * @param $raceid returned raceid if already predicted
	 * @return bool true if predicted, else false.
	 */
	function hasPredicted($champid, &$raceid) {
		
		/*
		 * For logged in users this is always false, otherwise
		 * they can predict - see the other players predictions
		 * then change their mind.
		 */
		if ($this->options->get_must_be_logged_in()) {
			return false;
		}
		
		if (isset($_COOKIE['motorracingleague_'.$champid])) {
			$raceid = $_COOKIE['motorracingleague_'.$champid];
			return true;
		}
		return false;
	}
	
	/**
	 * Can this user see other peoples predictions before submitting thier own ?
	 * @return bool true yes, false no
	 */
	function canShowPredictions() {
		return $this->options->get_can_see_predictions();
	}

	/**
	 * Display the current points position for all players for this race.
	 * 
	 * @param $raceid Race id
	 * @param $limit Only show top n results
	 * @param $full true/false show players predicitions + totals 
	 * @param $style Add this style to the output HTML table.
	 * @return html string
	 */
	function getRaceStandings($raceid, $limit = 10, $full = false, $style = '') {
		global $wpdb;
		$champid = -1;
		
		$sql = "SELECT c.id AS id
				FROM 
					{$wpdb->prefix}{$this->pf}championship c,
					{$wpdb->prefix}{$this->pf}race r
				WHERE
					c.id = r.championship_id AND r.id = %d";
		$row = $wpdb->get_row($wpdb->prepare($sql, $raceid));
		if ($row) {
			$champid = $row->id;
		} else {
			return __('No results available', $this->name);
		}

		$numPredictions = (int)$this->getChampionshipNumPredictions($champid);
		if (!is_numeric($limit)) $limit = 10;
		$this->options->load($champid);
		$extra = 0;
		if ($this->options->get_predict_fastest()) $extra++;
		if ($this->options->get_predict_pole()) $extra++;
		
		/*
		 * Display the prediction entries for a specified race.
		 */
		$sql = 'SELECT e.pole_lap_time, e.id as "id", player_name, p.shortcode as "shortcode", p.name AS shortcode_name,
						points, position, e.rain, e.safety_car, e.dnf, e.double_up, e.points_breakdown FROM '
				.$wpdb->prefix.$this->pf.'entry e, '
				.$wpdb->prefix.$this->pf.'race r, '
				.$wpdb->prefix.$this->pf.'participant p, '
				.$wpdb->prefix.$this->pf.'prediction pre WHERE e.race_id = %d 
					AND pre.entry_id = e.id AND p.id = pre.participant_id AND r.id = e.race_id
				ORDER BY e.points DESC, `when`, e.id, pre.position ASC
				LIMIT %d';
		$entry = $wpdb->get_results( $wpdb->prepare($sql, $raceid, $limit * ($numPredictions + $extra)) , OBJECT );
		if (count($entry) == 0) {
			return __('No results available', $this->name);
		}
		
		$output = '<table class="motorracingleague motorracingleague_results" '.$style.'><thead>
		<tr>
			<th class="motorracingleague_player" scope="col">'.__('Player', $this->name).'</th>';
		if ($full) {
			if ($this->options->get_predict_rain()) {
				$output .= '<th scope="col">'.__('Rain', $this->name).'</th>';
			}
			if ($this->options->get_predict_safety_car()) {
				$output .= '<th scope="col">'.__('SC', $this->name).'</th>';
			}
			if ($this->options->get_predict_dnf()) {
				$output .= '<th scope="col">'.__('DNF', $this->name).'</th>';
			}
			if ($this->options->get_double_up()) {
				$output .= '<th scope="col">'.__('Double', $this->name).'</th>';
			}
			if ($this->options->get_predict_pole_time()) {
				$output .= '<th scope="col">'.__('Pole Time', $this->name).'</th>';
			}
			if ($this->options->get_predict_fastest()) {
				$output .= '<th scope="col">'.$this->fl_label($this->options->get_predict_lapsled(), true).'</th>';
			}
			if ($this->options->get_predict_pole()) {
				$output .= '<th scope="col">'.__('Pole', $this->name).'</th>';
			}
			for ($i = 1; $i <= $numPredictions; $i++) {
				$output .= "<th>$i.</th>";
			}
		}
		$output .= '<th scope="col">Points</th></tr></thead>
		<tbody>';
		

		/*
		 * SQL returns groups of rows for each entry with the predicted driver positions.
		 * Cobble it together into a table.
		 */
		$group_id = '';
		$nextrow = false;
		$when = '';
		$points = 0;
		$points_breakdown = array();
		foreach ($entry as $row) {
			if ($group_id != $row->id) {
				$group_id = $row->id;		// New row
				if ($nextrow) {
					$output .= '<td>' . $this->pts($points, __('Bonus', $this->name), $points_breakdown, 'bonus') . '</td></tr>';
				}
				$points = $row->points;
				$points_breakdown = array();
				if (is_serialized($row->points_breakdown)) {
					$points_breakdown = unserialize($row->points_breakdown);
				}
				$output .= "<tr>";
				$output .= "<th scope='row' class='motorracingleague_player'>".$this->shorten($row->player_name)."</td>";
				if ($full) {
					if ($this->options->get_predict_rain()) {
						$output .= '<td>'.$this->pts($this->tick($row->rain), __('Rain', $this->name), $points_breakdown, 'rain').'</td>';
					}
					if ($this->options->get_predict_safety_car()) {
						$output .= '<td>'.$this->pts($this->tick($row->safety_car), __('Safety Car', $this->name), $points_breakdown, 'safety_car').'</td>';
					}
					if ($this->options->get_predict_dnf()) {
						$output .= '<td>'.$this->pts($row->dnf, __('DNF', $this->name), $points_breakdown, 'dnf').'</td>';
					}
					if ($this->options->get_double_up()) {
						$output .= '<td>'.$this->pts($this->tick($row->double_up), __('Double Up', $this->name), $points_breakdown, 'double_up').'</td>';
					}
					if ($this->options->get_predict_pole_time()) {
						$output .= "<td>".$this->pts($this->from_laptime($row->pole_lap_time), __('Pole Time', $this->name), $points_breakdown, 'pole_lap_time')."</td>\n";
					}
					$output .= "<td>" . $this->pts($row->shortcode, $row->shortcode_name, $points_breakdown, $row->position) . "</td>";
				}
			} else {
				$nextrow=true;
				if ($full) $output .= "<td>" . $this->pts($row->shortcode, $row->shortcode_name, $points_breakdown, $row->position) . "</td>";
			}
		}
		
		if ($nextrow) {
			$output .= '<td>' . $this->pts($points, __('Bonus', $this->name), $points_breakdown, 'bonus') . '</td>';
		}
	
		
		$output .= '</tbody></table>';
		
		return $output;
	}
	
	/**
	 * Return true if we want to only load the Javascript and CSS when
	 * a post or widget for this plugin is present.
	 * 
	 * @return unknown_type
	 */
	function conditionalJS() {
		return get_option('motorracingleague_conditional_javascript');
	}
	
	/**
	 * Filter the_posts
	 * 
	 * Check for the presence of a shortcode and if present
	 * enqueue the required CSS and Javascript files.
	 * 
	 * An attempt to reduce page load time as most pages will
	 * not have the shortcode on. However there is more backend
	 * processing and browser/server caching may make this
	 * pointless anyway.
	 * 
	 * @param unknown_type $posts
	 * @return unknown_type
	 */
	function conditionally_add_scripts_and_styles($posts){
		if (empty($posts) || !$this->conditionalJS()) return $posts;
		
		$shortcode_found = false;
		
		foreach ($posts as $post) {
			if (stripos($post->post_content, '[motorracingleague')) {
				$shortcode_found = true; // bingo!
				break;
			}
		}
	 
		if ($shortcode_found) {
			$this->addStyle();
			$this->addJavascript();
		} else {
			/*
			 * Just the widget, no JS needed
			 */
			$widget_found = is_active_widget(false, false, 'motor_racing_league');
			if ($widget_found) {
				$this->addStyle();
			}
		}
	 
		return $posts;
	}	


	/**
	 * Process AJAX request to get a prediction and return
	 * a json formatted array to load up the dropdowns
	 * on the form.
	 * 
	 * This only applied to logged in users.
	 * 
	 * @return unknown_type
	 */
	function get_entry() {
		global $wpdb;
		
		$ret = array('msg'=>'', '#motorracingleague_pole_lap_time'=>'', 'predictions'=>array());
		
		if (isset($_POST['mrl_race'])) {
			$raceid = $_POST['mrl_race'];
		} else {
			$ret['msg'] = __("Unknown race", $this->name);
			die(json_encode($ret));
		}
		if (isset($_POST[$this->pf.'comp_id'])) {
			$champid = $_POST[$this->pf.'comp_id'];
		} else {
			$ret['msg'] = __("Unknown championship", $this->name);
			die(json_encode($ret));
		}
		
		
		$this->options->load($champid);
		if ($this->options->get_predict_fastest()) $ret['predictions']['#mrl_participant-1'] = -1;
		if ($this->options->get_predict_pole()) $ret['predictions']['#mrl_participant0'] = -1;
//		if ($this->options->get_predict_pole_time()) $ret .= ',';
		$num = $this->getChampionshipNumPredictions($champid);
		$ret['#motorracingleague_pole_lap_time'] = '';
		$ret['#motorracingleague_rain'] = 0;
		$ret['#motorracingleague_safety_car'] = 0;
		$ret['#motorracingleague_dnf'] = 0;
		$ret['#motorracingleague_double_up'] = 0;
		for ($i = 1; $i <= $num; $i++) {
			$ret['predictions']['#mrl_participant'.$i] = -1;
		}
		$ret['label'] = __('Add Prediction', $this->name);
		
		$ret['mrl_disable'] = 0;
		if ($this->qualify_by_expired($raceid)) {
			$ret['mrl_disable'] = 1;
		}
		
		if ($this->needsAuthorisation() && $this->isAuthorised()) {
			$sql = "SELECT e.pole_lap_time, p.position, p.participant_id, e.rain, e.safety_car, e.dnf, e.double_up
				    FROM
						{$wpdb->prefix}{$this->pf}entry e,
						{$wpdb->prefix}{$this->pf}prediction p
					WHERE
						e.player_name = %s AND e.race_id = %d AND
						p.entry_id = e.id
					ORDER BY position ASC";
			$results = $wpdb->get_results($wpdb->prepare($sql, $this->getPlayerName(), $raceid));
			if ($results) {
				$ret['label'] = __('Update Prediction', $this->name);
				$ret['#motorracingleague_pole_lap_time'] = $this->from_laptime($results[0]->pole_lap_time);
				$ret['#motorracingleague_rain'] = $results[0]->rain;
				$ret['#motorracingleague_safety_car'] = $results[0]->safety_car;
				$ret['#motorracingleague_dnf'] = $results[0]->dnf;
				$ret['#motorracingleague_double_up'] = $results[0]->double_up;
			}
			foreach ($results as $row) {
				$ret['predictions']['#mrl_participant'.$row->position] = $row->participant_id;
			}
		}
		
//		die(print_r($ret,true));
		$ret = json_encode($ret);
		die($ret);
	}
	
	function is_laptime($d) {
		
		//if (empty($d) || strlen($d) != 9) return false;
		
		return (preg_match ("/(([0-9]{1,2}):([0-5]{1}[0-9]{1})\.([0-9]{3}))/", $d));
	}
	
	/**
	 * Convert string laptime MM:SS.ccc to milliseconds
	 * @param $t
	 * @return unknown_type
	 */
	function to_laptime($t) {
		if (!$this->is_laptime($t)) return 0;
		
		preg_match ("/([0-9]{1,2}):([0-5]{1}[0-9]{1})\.([0-9]{3})/", $t, $regs);
		
		$time = ((($regs[1] * 60) + $regs[2]) * 1000) + $regs[3];
		
		return $time;
	}
	
	/**
	 * Convert millseconds to laptime MM:SS.ccc
	 * 
	 * Seems to work - but very ugly. Most probable could use
	 * strftime or summit.
	 * 
	 * @param $msecs
	 * @return unknown_type
	 */
	function from_laptime($msecs) {
		
		if ($msecs < 0) $msecs = $msecs * -1;
		
		if ($msecs == 0) return "00:00.000";
		
		$secs = ($msecs - ($msecs % 1000)) / 1000;
		$ms = $msecs - ($secs * 1000);
		$mins = ($secs - ($secs % 60)) / 60;
		$secs = $secs - ($mins * 60);
		
		if ($ms < 100) $ms = '0'.$ms;
		if ($ms < 10) $ms = '0'.$ms;
		if ($mins < 10) $mins = '0'.$mins;
		if ($secs < 10) $secs = '0'.$secs;
		
		return "$mins:$secs.$ms";		
	}
	
	/**
	 * Display Fastest Lap or Most Laps Led label
	 * @param $toggle
	 * @param $abbr
	 * @return unknown_type
	 */
	function fl_label($toggle, $abbr = false) {
		if ($toggle) {
			return ($abbr ? __( 'Laps', $this->name ) : __( 'Most Laps Led', $this->name ));
		} else {
			return ($abbr ? __( 'Fastest', $this->name ) : __( 'Fastest Lap', $this->name ));
		}
	}
	
	/*
	 * Email a players predictions
	 */
	function email_confirmation($entry_id) {
		global $wpdb;
		
		$sql = "SELECT player_name, email, e.pole_lap_time, position, name, circuit, e.when,
					e.rain, e.safety_car, e.dnf, e.double_up FROM
					{$wpdb->prefix}{$this->pf}entry e,
					{$wpdb->prefix}{$this->pf}prediction p,
					{$wpdb->prefix}{$this->pf}participant pt,
					{$wpdb->prefix}{$this->pf}race r
				WHERE
					e.id = %d AND p.entry_id = e.id AND
					pt.id = p.participant_id AND r.id = e.race_id
				ORDER BY position ASC";
		$results = $wpdb->get_results($wpdb->prepare($sql, $entry_id));
		
		if ($results) {
		
			$user = $results[0]->player_name;
			$racename = $results[0]->circuit;
			$email = $results[0]->email;
			$when = $results[0]->when;
			
			$predictions = '<ul>';
			if ($this->options->get_predict_pole_time()) {
				$predictions .= '<li>' . __( 'Pole Time', $this->name ) . ' - ' . $this->from_laptime($results[0]->pole_lap_time) . '</li>';
			}
			foreach ($results as $row) {
				switch ($row->position) {
					case -1: $predictions .= '<li>' . $this->fl_label($this->options->get_predict_lapsled()) . ' - ' . $row->name . '</li>';
							 break;
					case  0: $predictions .= '<li>' . __("Pole", $this->name) . ' - ' . $row->name . '</li>';
							 break;
					default:
							 $predictions .= '<li>' . __( 'Position', $this->name ) . ' ' . $row->position . ' - ' . $row->name . '</li>';
				}
			}
			
			
			$yes = __('Yes', $this->name);
			$no = __('No', $this->name);
			if ($this->options->get_predict_rain()) {
				$predictions .= '<li>' . __("Rain", $this->name) . ' - ' . ($row->rain ? $yes : $no) . '</li>';
			}
			if ($this->options->get_predict_safety_car()) {
				$predictions .= '<li>' . __("Safety Car", $this->name) . ' - ' . ($row->safety_car ? $yes : $no) . '</li>';
			}
			if ($this->options->get_predict_dnf()) {
				$predictions .= '<li>' . __("DNF", $this->name) . ' - ' . $row->dnf . '</li>';
			}
			if ($this->options->get_double_up()) {
				$predictions .= '<li>' . __("Double Up", $this->name) . ' - ' . ($row->double_up ? $yes : $no) . '</li>';
			}
				
			$predictions .= '</ul>';
			
			$subject = get_option('motorracingleague_email_subject');
			$subject = str_replace('%%user%%', $user, $subject);
			$subject = str_replace('%%racename%%', $racename, $subject);
			
			$headers = "From: " . get_option("admin_email") . "\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=utf-8\r\n";
			
			$message = get_option('motorracingleague_email_body');
	
			$message = str_replace('%%when%%', $when, $message);
			$message = str_replace('%%user%%', $user, $message);
			$message = str_replace('%%predictions%%', $predictions, $message);
			$message = str_replace('%%racename%%', $racename, $message);
			
			$stat = wp_mail($email, $subject, $message, $headers);
			
			// Yeh - we ignore the status ! what we gonna do if it fails !
		}
	}
	
	/*
	 * Display all the predictions for this championship and logged-in player.
	 */
	function showPredictions($champid, $style) {
		global $current_user;
		global $wpdb;
		
		$output = '';
		
		if (!is_user_logged_in()) return '';

		get_currentuserinfo();
		
		$sql = "SELECT e.id, player_name, e.pole_lap_time, position, pt.name AS shortcode_name, pt.shortcode, circuit, points, e.rain, 
						e.safety_car, e.dnf, e.double_up, points_breakdown FROM
					{$wpdb->prefix}{$this->pf}entry e,
					{$wpdb->prefix}{$this->pf}prediction p,
					{$wpdb->prefix}{$this->pf}participant pt,
					{$wpdb->prefix}{$this->pf}race r
				WHERE
					e.email = %s AND p.entry_id = e.id AND r.championship_id = %d AND
					pt.id = p.participant_id AND r.id = e.race_id
				ORDER BY r.race_start, e.id, position ASC";
		$results = $wpdb->get_results($wpdb->prepare($sql, $current_user->user_email, $champid));
		
		$span = $numPredictions = (int)$this->getChampionshipNumPredictions($champid);
		$this->options->load($champid);
				
		$output = '<table class="motorracingleague motorracingleague_results" '.$style.'><thead>
		<tr>
		<th class="motorracingleague_player" scope="col">'.__('Race', $this->name).'</th>';
		if ($this->options->get_predict_rain()) {
			$output .= '<th scope="col">'.__('Rain', $this->name).'</th>';
			$span++;
		}
		if ($this->options->get_predict_safety_car()) {
			$output .= '<th scope="col">'.__('SC', $this->name).'</th>';
			$span++;
		}
		if ($this->options->get_predict_dnf()) {
			$output .= '<th scope="col">'.__('DNF', $this->name).'</th>';
			$span++;
		}
		if ($this->options->get_double_up()) {
			$output .= '<th scope="col">'.__('Double', $this->name).'</th>';
			$span++;
		}
		if ($this->options->get_predict_pole_time()) {
			$output .= '<th scope="col">'.__('Pole Time', $this->name).'</th>';
			$span++;
		}
		if ($this->options->get_predict_fastest()) {
			$output .= '<th scope="col">'.$this->fl_label($this->options->get_predict_lapsled(), true).'</th>';
			$span++;
		}
		if ($this->options->get_predict_pole()) {
			$output .= '<th scope="col">'.__('Pole', $this->name).'</th>';
			$span++;
		}
		for ($i = 1; $i <= $numPredictions; $i++) {
			$output .= "<th>$i.</th>";
		}
		$output .= '<th scope="col">Points</th></tr></thead>
		<tbody>';
		
		$group_id = '';
		$nextrow = false;
		$when = '';
		$points = 0;
		$total = 0;
		$points_breakdown = array();
		foreach ($results as $row) {
			if ($group_id != $row->id) {
				$group_id = $row->id;		// New row
				if ($nextrow) {
					$output .= '<td>' . $this->pts($points, __('Bonus', $this->name), $points_breakdown, 'bonus') . '</td></tr>';
					$total += $points;
				}
				$points = $row->points;
				$points_breakdown = array();
				if (is_serialized($row->points_breakdown)) {
					$points_breakdown = unserialize($row->points_breakdown);
				}
				$output .= "<tr>";
				$output .= "<th scope='row' class='motorracingleague_player'>".$row->circuit."</td>";
				if ($this->options->get_predict_rain()) {
					$output .= '<td>'.$this->pts($this->tick($row->rain), __('Rain', $this->name), $points_breakdown, 'rain').'</td>';
				}
				if ($this->options->get_predict_safety_car()) {
					$output .= '<td>'.$this->pts($this->tick($row->safety_car), __('Safety Car', $this->name), $points_breakdown, 'safety_car').'</td>';
				}
				if ($this->options->get_predict_dnf()) {
					$output .= '<td>'.$this->pts($row->dnf, __('DNF', $this->name), $points_breakdown, 'dnf').'</td>';
				}
				if ($this->options->get_double_up()) {
					$output .= '<td>'.$this->pts($this->tick($row->double_up), __('Double Up', $this->name), $points_breakdown, 'double_up').'</td>';
				}
				if ($this->options->get_predict_pole_time()) {
					$output .= "<td>".$this->pts($this->from_laptime($row->pole_lap_time), __('Pole Time', $this->name), $points_breakdown, 'pole_lap_time')."</td>\n";
				}
				$output .= "<td>" . $this->pts($row->shortcode, $row->shortcode_name, $points_breakdown, $row->position) . "</td>";
			} else {
				$nextrow=true;
				$output .= "<td>" . $this->pts($row->shortcode, $row->shortcode_name, $points_breakdown, $row->position) . "</td>";
			}
		}
		
		if ($nextrow) {
			$output .= "<td>$points</td></tr>";
			$total += $points;
		}
		
		$span++; // Points col
		$output .= "<tr>";
		$output .= "<th scope='row' class='motorracingleague_player'>".__('Total', $this->name)."</th>";
		$output .= "<td colspan='$span'>$total</td>";
		$output .= "</tr>";
		
				
		$output .= '</tbody></table>';
		
		return $output;
	}
	
	/**
	 * Process hourly cron job to send reminders.
	 * 
	 * NOTE - we could have used specific time events and scheduled
	 * a job for each race - but managing those schedules is painful.
	 * 
	 * Every time a race is added,modified,delete we need to find the
	 * correct schedule and reschedule or delete. Ugly and possible
	 * to miss events.
	 * 
	 * So every hour just check if a reminder is due.
	 * 
	 */
	function reminders() {
		global $wpdb;
		
		if (!get_option('motorracingleague_reminders')) {
			return;
		}

		$hours = get_option('motorracingleague_reminder_hours', 24);
		if (empty($hours) || !is_numeric($hours) || $hours < 1) {
			$hours = 24;
		}
		
		/*
		 * Find next race(s)
		 */
		$sql = "SELECT r.id, r.championship_id, circuit, MIN(entry_by) AS entry_by, NOW() AS server_date, TIMESTAMPDIFF(HOUR, NOW(), r.entry_by) AS hours_diff
				FROM
					{$wpdb->prefix}{$this->pf}race r,
					{$wpdb->prefix}{$this->pf}championship c
				WHERE
					r.championship_id = c.id AND
					r.entry_by > NOW() AND TIMESTAMPDIFF(HOUR, NOW(), r.entry_by) <= %d
				GROUP BY
					c.id";
		$results = $wpdb->get_results($wpdb->prepare($sql, $hours));
		
		foreach ($results as $row) {
			
			// Skip if all reminders send
			$done = get_option('motorracingleague_reminder_sent_' . $row->id);
			if ($done) {
				continue;
			}
			
			// Is this the first race of the season ?
			
			$sql = "SELECT id, entry_by FROM {$wpdb->prefix}{$this->pf}race WHERE championship_id = %d ORDER BY entry_by LIMIT 1";
			$race = $wpdb->get_row($wpdb->prepare($sql, $row->championship_id));

			//error_log("Process race id {$row->id} First race {$race->id}");
				
			
			$users = array();
			if ($race->id == $row->id) {
				
				// First race of the season - get a list of registered users, ignoring those who have already
				// predicted or opted-opt 
				
				$sql = "SELECT u.ID, user_email, display_name FROM {$wpdb->users} u
						WHERE
							NOT EXISTS (SELECT * FROM 
											{$wpdb->prefix}{$this->pf}entry e,
											{$wpdb->prefix}{$this->pf}race r
										WHERE e.race_id = r.id AND r.championship_id = %d AND u.user_email = e.email) AND
							NOT EXISTS (SELECT * FROM {$wpdb->usermeta} WHERE user_id = u.ID AND (meta_key = %s OR meta_key = %s))";
				$users = $wpdb->get_results($wpdb->prepare($sql, $row->championship_id,
										'motorracingleague_reminder_cancel_' . $row->championship_id,
										'motorracingleague_reminder_done_' . $row->id));
												
			} else {
				
				// Subsequent race - If a user didn't bother predicting the first race then tough luck
				// Only users who predicted as least one race in the past are considered candidates
				
				$sql = "SELECT DISTINCT u.ID, user_email, display_name FROM {$wpdb->users} u, {$wpdb->prefix}{$this->pf}entry e
						WHERE
							u.user_email = e.email AND
							NOT EXISTS (SELECT * FROM
											{$wpdb->prefix}{$this->pf}entry e
										WHERE e.race_id = %d AND u.user_email = e.email) AND
							NOT EXISTS (SELECT * FROM {$wpdb->usermeta} WHERE user_id = u.ID AND (meta_key = %s OR meta_key = %s))";				
				
				$users = $wpdb->get_results($wpdb->prepare($sql, $row->id,
												'motorracingleague_reminder_cancel_' . $row->championship_id,
												'motorracingleague_reminder_done_' . $row->id));
			}
			
			// OK we have a list of users that need reminding
			
			// Is it OK to send thousands of emails in one go ? Probably not - so send individually
			
			// See http://www.brilliantthinking.net/2006/04/29/is-it-ok-to-use-bcc-for-a-mailing-list/
			// it's an old article but concurs with other pages that suggest using To: instead of Bcc:
			
			$opt_subject = get_option('motorracingleague_reminder_email_subject');
			$opt_body = get_option('motorracingleague_reminder_email_body');
			$blog = get_bloginfo('wpurl');
			
			
			// For large numbers of users this may take a long time.
			// It's possible PHP will exceed it's execution time and kill the thread, so we
			// have a basic restart function built-in by virtue of the user meta data motorracingleague_reminder_done_'race_id'
			//
			// If the thread gets killed - Cron re-executes every hour so we process the remaining candidates
			// not marked as 'done'
			//
			foreach ($users as $user) {
				
				$optout =  $blog . '?mrl_cancel=' . base64_encode(serialize(array($user->ID, $row->championship_id)));
				$subject = str_replace('%%user%%', $user->display_name, $opt_subject);
				$subject = str_replace('%%racename%%', $row->circuit, $subject);
					
				$headers = "From: " . get_option("admin_email") . "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=utf-8\r\n";
					
				$message = str_replace('%%user%%', $user->display_name, $opt_body);
				$message = str_replace('%%optout%%', $optout, $message);
				$message = str_replace('%%racename%%', $row->circuit, $message);
					
				wp_mail($user->user_email, $subject, $message, $headers);
				
				// Sent reminder - don't do it again for this user and race
				update_user_meta($user->ID, 'motorracingleague_reminder_done_' . $row->id, 1);
				
			}
			
			// Mark all reminders as sent, Stop duplicates if WP-Cron goes nuts
			add_option('motorracingleague_reminder_sent_' . $row->id, 1);
					
			
		}
	}
	
	/**
	 * Display a tick or cross
	 * 
	 * @param unknown_type $tick
	 * @return string
	 */
	function tick($tick) {
		return ($tick ? '&#10004;' : '&#10006;');
	}
	
	/**
	 * Get number of particpants in this championship
	 * 
	 * @param unknown_type $champid
	 * @return Ambigous <string, NULL>
	 */
	function getNumDrivers($champid) {
		global $wpdb;
		
		return $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}{$this->pf}participant WHERE championship_id = %d", $champid));
	}

	/**
	 * Return a <span> with the points gained as the title attribute
	 * 
	 * @param unknown_type $str
	 * @param unknown_type $title
	 * @param unknown_type $points_breakdown
	 * @param unknown_type $key
	 * @return string
	 */
	function pts($str, $title, $points_breakdown, $key, $zero = true) {
		
		$str = stripslashes($str);
		if (is_array($points_breakdown) && key_exists($key, $points_breakdown)) {
			return sprintf('<span title="%s +%d">%s</span>', $title, $points_breakdown[$key], $str);
		} else {
			return sprintf('<span title="%s %s">%s</span>', $title, ($zero ? '+0' : ''), $str);
		}
	}
}

?>