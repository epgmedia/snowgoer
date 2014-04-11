<?php
/**
 * 
 * Admin class and Interface for Wordpress plugin MotorRacingLeague
 * 
 * @author    Ian Haycox
 * @package	  MotorRacingLeague
 * @copyright Copyright 2009-2013
 */


class MotorRacingLeagueAdmin extends MotorRacingLeague
{

	private $protected = '';  // disable some fields.
	
	// Plugin database table version
	private $db_version = "0.6";
	
	/**
	 * Initializes the Admin Plugin class
	 *
	 * @return bool Successfully initialized
	 */
	function __construct()
	{
		global $wpdb;
		
		parent::__construct();
		
		$wpdb->show_errors(true);
		
		if (!isset ($_SESSION)) {
			session_start();
		}
		
		return true;
	}

	/**
	 * Performs plugin installation actions upon activation in Wordpress plugin menu
	 *
	 * @return bool Successfully activated
	 */
	function activate() {
		
		global $wpdb;
		
		$charset_collate = '';
		if ( $wpdb->has_cap( 'collation' ) ) {
			if ( ! empty($wpdb->charset) )
				$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
			if ( ! empty($wpdb->collate) )
				$charset_collate .= " COLLATE $wpdb->collate";
		}
		/*
		 * Championship for a season consists of a number of races.
		 * .e.g '2009', 'Formula One World Championship'
		 */
		$champ_sql = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."motorracingleague_championship` (
					  `id` int(11) NOT NULL auto_increment,
					  `season` varchar(32) NOT NULL,
					  `description` varchar(255) NOT NULL,
					  `num_predictions` int(11) NOT NULL,
					  `calculator` varchar(255) NOT NULL,
					  `options` longtext NOT NULL,
					  PRIMARY KEY  (`id`),
					  UNIQUE KEY `season` (`season`)
					) ENGINE=InnoDB $charset_collate;";
		
		/*
		 * Each race in the championship takes place at a circuit and time. May have
		 * more than one race at same circuit in a season
		 * Players must make a prediction by entry_by date/time
		 */
		$race_sql = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."motorracingleague_race` (
					  `id` int(11) NOT NULL auto_increment,
					  `circuit` varchar(64) NOT NULL,
					  `championship_id` int(11) NOT NULL,
					  `race_start` datetime NOT NULL,
					  `entry_by` datetime NOT NULL,
					  `qualify_by` datetime NULL DEFAULT NULL,
					  `pole_lap_time` int(11) NOT NULL DEFAULT 0,
					  `pole_lap_time_points` int(11) NOT NULL DEFAULT 0,
					  `rain` BOOL NOT NULL DEFAULT 0,
					  `dnf` int(11) NOT NULL DEFAULT 0,
					  `safety_car` BOOL NOT NULL DEFAULT 0,
					  PRIMARY KEY  (`id`),
					  UNIQUE KEY `circuit` (`circuit`,`championship_id`,`race_start`),
					  KEY `championship_fk` (`championship_id`),
					  FOREIGN KEY (`championship_id`) REFERENCES `".$wpdb->prefix."motorracingleague_championship` (`id`)
					) ENGINE=InnoDB $charset_collate;";
					  
		/*
		 * Race participants - e.g. drivers, riders, rally crews, cyclists
		 * e.g. 'MSC', 'Michael Schumacher'
		 */
		$part_sql = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."motorracingleague_participant` (
					  `id` int(11) NOT NULL auto_increment,
					  `shortcode` varchar(8) NOT NULL,
					  `name` varchar(64) NOT NULL,
					  `championship_id` int(11) NOT NULL,
					  PRIMARY KEY  (`id`),
					  UNIQUE KEY `unq_shortcode` (`shortcode`, `championship_id`),
					  UNIQUE KEY `unq_name` (`name`, `championship_id`),
					  KEY `championship_fk2` (`championship_id`),
					  FOREIGN KEY (`championship_id`) REFERENCES `".$wpdb->prefix."motorracingleague_championship` (`id`)
					) ENGINE=InnoDB $charset_collate;";
					  
		/*
		 * A players prediction for the game.
		 * Points awarded for correct predictions after race completion.
		 * MySQL 4.0 does not support  "default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP" for
		 * the when column !!!!
		 */
		$entry_sql = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."motorracingleague_entry` (
					  `id` int(11) NOT NULL auto_increment,
					  `player_name` varchar(64) NOT NULL,
					  `email` varchar(255) NOT NULL,
					  `race_id` int(11) NOT NULL,
					  `when` timestamp NOT NULL,
					  `points` int(11) NOT NULL,
					  `points_breakdown` TEXT NOT NULL,
					  `pole_lap_time` int(11) NOT NULL DEFAULT 0,
					  `optin` BOOL NOT NULL DEFAULT '0',
					  `rain` BOOL NOT NULL DEFAULT 0,
					  `dnf` int(11) NOT NULL DEFAULT 0,
					  `safety_car` BOOL NOT NULL DEFAULT 0,
					  `double_up` BOOL NOT NULL DEFAULT 0,
					  PRIMARY KEY  (`id`),
					  UNIQUE KEY `player` (`player_name`,`race_id`),
					  KEY `race_fk` (`race_id`),
					  FOREIGN KEY (`race_id`) REFERENCES `".$wpdb->prefix."motorracingleague_race` (`id`)
					) ENGINE=InnoDB $charset_collate;";
		
		/*
		 * Holds the predictions for each entry. Position -1 = Fastest Lap, 0 = pole, 1..n race finishing positions. 
		 */
		$pred_sql = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."motorracingleague_prediction` (
					  `id` int(11) NOT NULL auto_increment,
					  `entry_id` int(11) NOT NULL,
					  `participant_id` int(11) NOT NULL,
					  `position` int(11) NOT NULL,
					  PRIMARY KEY  (`id`),
					  UNIQUE KEY `entry_id` (`entry_id`,`participant_id`,`position`),
					  KEY `entry_id_2` (`entry_id`),
					  KEY `participant_id` (`participant_id`),
					  FOREIGN KEY (`participant_id`) REFERENCES `".$wpdb->prefix."motorracingleague_participant` (`id`),
					  FOREIGN KEY (`entry_id`) REFERENCES `".$wpdb->prefix."motorracingleague_entry` (`id`)
					) ENGINE=InnoDB $charset_collate;";
					  
		/*
		 * The result of a race once complete. The position of the participant.
		 * -- Special cases, position = -1 fastest lap, position 0 == pole position during qualifying.
		 */
		$result_sql = "CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."motorracingleague_result` (
					  `id` int(11) NOT NULL auto_increment,
					  `race_id` int(11) NOT NULL,
					  `participant_id` int(11) NOT NULL,
					  `position` int(11) NOT NULL,
					  `race_points` int(11) NOT NULL DEFAULT 0,
					  PRIMARY KEY  (`id`),
					  UNIQUE KEY `race_id` (`race_id`,`participant_id`,`position`),
					  KEY `participant` (`participant_id`),
					  FOREIGN KEY (`race_id`) REFERENCES `".$wpdb->prefix."motorracingleague_race` (`id`),
					  FOREIGN KEY (`participant_id`) REFERENCES `".$wpdb->prefix."motorracingleague_participant` (`id`)
					) ENGINE=InnoDB $charset_collate;";
	
		$ret = $wpdb->query($champ_sql);
		if ($ret === false) {
			error_log($wpdb->last_error);
		}
		$ret = $wpdb->query($champ_sql);
		if ($ret === false) {
			error_log($wpdb->last_error);
		}
		$ret = $wpdb->query($race_sql);
		if ($ret === false) {
			error_log($wpdb->last_error);
		}
		$ret = $wpdb->query($part_sql);
		if ($ret === false) {
			error_log($wpdb->last_error);
		}
		$ret = $wpdb->query($entry_sql);
		if ($ret === false) {
			error_log($wpdb->last_error);
		}
		$ret = $wpdb->query($pred_sql);
		if ($ret === false) {
			error_log($wpdb->last_error);
		}
		$ret = $wpdb->query($result_sql);
		if ($ret === false) {
			error_log($wpdb->last_error);
		}
		
		add_option('motorracingleague_title',__('Motor Racing League', 'motorracingleague'));
        add_option('motorracingleague_widget_max',10);  // Show up to 10 results in widget
		add_option('motorracingleague_promo_link', 1);  // Show a promotion link to author.
		add_option('motorracingleague_display_name', 0);  // Experimental - Use display_name rather than login_name from users profile
		add_option('motorracingleague_optin', false);  // Mailing list optin
		add_option('motorracingleague_max_stats', 3); // Maximum positional guesses for stats
		add_option('motorracingleague_email_prediction' , 0);  // Email prediction confirmation
		add_option('motorracingleague_email_subject' , __('Prediction subject', $this->name) );  // Email prediction confirmation
		add_option('motorracingleague_email_body' , __('Your predictions<br>%%predictions%%', $this->name) );  // Email prediction confirmation
		
		add_option('motorracingleague_reminders' , 0);  // Email reminders
		add_option('motorracingleague_reminder_hours' , 24);  // Email reminders this many hours before race deadline
		add_option('motorracingleague_reminder_email_subject' , __('Predictions due for %%racename%%', $this->name) );  // Reminder email subject
		add_option('motorracingleague_reminder_email_body' , __('Hello %%user%%<br>Predictions are due for %%racename%%<br>If you wish to stop receiving all future reminders click on this link %%optout%%', $this->name) );  // Reminder email body
		
		add_option($this->pf.'donated', 0);
		add_option($this->pf.'nag', 10);
		
		if (!wp_next_scheduled('motorracingleague_hourly_event')) {
  			wp_schedule_event( time(), 'hourly', 'motorracingleague_hourly_event');
		}
		
		/*
		 * Set Capabilities
		*/
		$role = get_role('administrator');
		$role->add_cap('predict');

		$role = get_role('author');
		$role->add_cap('predict');
		
		$role = get_role('contributor');
		$role->add_cap('predict');
		
		$role = get_role('editor');
		$role->add_cap('predict');
		
		$role = get_role('subscriber');
		$role->add_cap('predict');
		
		return true;
	}

	/**
	 * Deactivation hook
	 */
	function deactivate() {
		wp_clear_scheduled_hook('motorracingleague_hourly_event');
		error_log('Deactivate');
		return true;
	}
	
	/**
	 * Check if database schema needs updating or
	 * new options etc.
	 */
	function check_for_upgrade() {
		global $wpdb;
		
		if (!is_admin() || defined('DOING_AJAX')) return;
		
		// Installed plugin database table version
		$installed_ver = get_option('motorracingleague_db_version');
		
		// If the database has changed, update the structure while preserving data
		if (empty($installed_ver) || $this->db_version != $installed_ver) {
		
			error_log(sprintf('Upgrading Motor Racing League from %s to %s.', $installed_ver, $this->db_version));
			
			$wpdb->show_errors(true);
			/*
			 * Alter unique indexes to prevent duplicate drivers from dev branches.
			*/
			if (!empty($installed_ver) && $installed_ver == "0.2") {
				$wpdb->query('DROP INDEX `shortcode` ON '.$wpdb->prefix.'motorracingleague_participant');
				$wpdb->query('DROP INDEX `unq_shortcode` ON '.$wpdb->prefix.'motorracingleague_participant');
				$wpdb->query('DROP INDEX `unq_name` ON '.$wpdb->prefix.'motorracingleague_participant');
				$wpdb->query('CREATE UNIQUE INDEX `unq_shortcode` ON '.
						$wpdb->prefix.'motorracingleague_participant (`shortcode`,`championship_id`)');
				$wpdb->query('CREATE UNIQUE INDEX `unq_name` ON '.
						$wpdb->prefix.'motorracingleague_participant (`name`,`championship_id`)');
				update_option('motorracingleague_db_version', '0.3');
				$installed_ver = "0.3";
			}
				
				
			/*
			 * Add championship specific options for pole time/fastest lap options
			*/
			if (!empty($installed_ver) && $installed_ver == "0.3") {
				$wpdb->query('ALTER TABLE '.$wpdb->prefix.'motorracingleague_championship ADD
						COLUMN (`options` longtext NOT NULL)');
				$wpdb->query('UPDATE '.$wpdb->prefix.'motorracingleague_championship
						SET num_predictions = num_predictions - 1 WHERE options = ""');
				$wpdb->query('ALTER TABLE '.$wpdb->prefix.'motorracingleague_entry ADD
						COLUMN (`pole_lap_time` INT(11) NOT NULL DEFAULT 0)');
				$wpdb->query('ALTER TABLE '.$wpdb->prefix.'motorracingleague_race ADD
						COLUMN (`pole_lap_time` INT(11) NOT NULL DEFAULT 0)');
				$wpdb->query('ALTER TABLE '.$wpdb->prefix.'motorracingleague_race ADD
						COLUMN (`pole_lap_time_points` INT(11) NOT NULL DEFAULT 0)');
				$wpdb->query('ALTER TABLE '.$wpdb->prefix.'motorracingleague_result ADD
						COLUMN (`race_points` INT(11) NOT NULL DEFAULT 0)');
				$opts = new MotorRacingLeagueOptions();
				$opts->upgrade_03_04();
				update_option('motorracingleague_notice',
						__('<br/>Note: This updated version has changes to the shortcodes and scoring system.<br />Please read the help and release notes.',''));
				update_option('motorracingleague_db_version', '0.4');
				$installed_ver = "0.4";
			}
		
			/*
			 * Add mailing list opt-in feature
			*/
			if (!empty($installed_ver) && $installed_ver == "0.4") {
				$wpdb->query('ALTER TABLE '.$wpdb->prefix.'motorracingleague_entry ADD
						COLUMN (`optin` bool NOT NULL DEFAULT 0)');
				update_option('motorracingleague_db_version', '0.5');
				$installed_ver = "0.5";
			}
				
			/*
			 * Add Safety Car, DNF, Rain and Double Up features
			*/
			if (!empty($installed_ver) && $installed_ver == "0.5") {
				$ret = $wpdb->query('ALTER TABLE '.$wpdb->prefix.'motorracingleague_entry ADD
						COLUMN (`rain` BOOL NOT NULL DEFAULT 0,
						`dnf` int(11) NOT NULL DEFAULT 0,
						`safety_car` BOOL NOT NULL DEFAULT 0,
						`double_up` BOOL NOT NULL DEFAULT 0,
						`points_breakdown` TEXT NOT NULL)');
				if ($ret === false) {
					error_log($wpdb->last_error);
				}
				$ret = $wpdb->query('ALTER TABLE '.$wpdb->prefix.'motorracingleague_race ADD
						COLUMN (`qualify_by` datetime NULL DEFAULT NULL,
						`rain` BOOL NOT NULL DEFAULT 0,
						`dnf` int(11) NOT NULL DEFAULT 0,
						`safety_car` BOOL NOT NULL DEFAULT 0)');
				if ($ret === false) {
					error_log($wpdb->last_error);
				}
				
				add_option('motorracingleague_reminders' , 0);  // Email reminders
				add_option('motorracingleague_reminder_hours' , 24);  // Email reminders this many hours before race deadline
				add_option('motorracingleague_reminder_email_subject' , __('Predictions due for %%racename%%', $this->name) );  // Reminder email subject
				add_option('motorracingleague_reminder_email_body' , __('Hello %%user%%<br>Predictions are due for %%racename%%<br>If you wish to stop receiving all future reminders click on this link %%optout%%', $this->name) );  // Reminder email body
				
				add_option($this->pf.'donated', 0);
				add_option($this->pf.'nag', 10);
				
				if (!wp_next_scheduled('motorracingleague_hourly_event')) {
					wp_schedule_event( time(), 'hourly', 'motorracingleague_hourly_event');
				}
				
				update_option('motorracingleague_db_version', '0.6');
				$installed_ver = "0.6";
			}
				
			$wpdb->show_errors(false);
		
			update_option('motorracingleague_db_version', $this->db_version);
		}
		
		return true;
	}
	
	
	/**
	 * Lists the plugin configuration page under the Settings menu in Wordpress Admin
	 * 
	 * @param none
	 */
	function actionAdminMenu() {
		add_menu_page(__('Motor Racing', $this->name), __('Motor Racing', $this->name), 'manage_options', $this->pf.'championship', array(&$this, 'championship'),$this->dir.'/images/flag.png');
		add_submenu_page($this->pf.'championship' ,__('Motor Racing', $this->name), __('Championship', $this->name), 'manage_options', $this->pf.'championship' , array(&$this, 'championship'));
		add_submenu_page($this->pf.'championship' ,__('Motor Racing Settings', $this->name), __('Settings', $this->name), 'manage_options', $this->pf.'settings' , array(&$this, 'settings'));
		add_submenu_page($this->pf.'championship' ,__('Motor Racing Race Results', $this->name), __('Race Results', $this->name), 'manage_options', $this->pf.'results' , array(&$this, 'results'));
		add_submenu_page($this->pf.'championship' ,__('Motor Racing Predictions', $this->name), __('Predictions', $this->name), 'manage_options', $this->pf.'predictions' , array(&$this, 'predictions'));
		add_submenu_page($this->pf.'championship' ,__('Motor Racing Help', $this->name), __('Help', $this->name), 'manage_options', $this->pf.'help' , array(&$this, 'help'));
	}

	/**
	 * Route to the appropriate menu option page.
	 * 
	 * @param none
	 */
	function championship() {
		if (isset($_GET['subpage'])) {
			if ($_GET['subpage'] == $this->pf.'participants') {
				$this->participants();
				return;
			}
		}
		$this->config();
	}
	
	/**
	 * Display the initial configuration page to create a championship.
	 * 
	 * @return none
	 */
	function config() {
		global $wpdb;

		$_SESSION['motorracingleague_warn'] = 'Y';
		
		if (isset($_POST[$this->pf.'addChamp'])) {
			check_admin_referer($this->pf . 'add-champ');
			$this->addChampionship();
			$this->printMessage();
		}
		
		if (isset($_POST[$this->pf.'delete'])) {
			check_admin_referer($this->pf . 'list-champ');
			if (isset($_POST[$this->pf.'champ'])) {
				foreach ($_POST[$this->pf.'champ'] as $id) {
					$this->deleteChampionship($id);
					$this->printMessage();
				}
			}
		}
		$str = 	get_option('motorracingleague_notice','');
?>
		<div class="wrap">
		
		<?php if (!empty($str)) {
			update_option('motorracingleague_notice','');
			echo "<p class='updated fade'>$str</p>";
		}
		?>

		<h2><?php _e( 'Championships', $this->name ) ?></h2>
		<form name="listchamp" method="post" action="">
		<?php wp_nonce_field( $this->pf . 'list-champ' ) ?>
		<table class="motorracingleague"><thead>
		<tr>
			<th scope="col"><?php _e( 'Delete', $this->name ) ?></th>
			<th scope="col"><?php _e( 'ID', $this->name ) ?></th>
			<th scope="col"><?php _e( 'Season', $this->name ) ?></th>
			<th scope="col"><?php _e( 'Predict', $this->name ) ?></th>
			<th scope="col"><?php _e( 'Rain', $this->name ) ?></th>
			<th scope="col"><?php _e( 'SC', $this->name ) ?></th>
			<th scope="col"><?php _e( 'DNF', $this->name ) ?></th>
			<th scope="col"><?php _e( 'Dbl', $this->name ) ?></th>
			<th scope="col"><?php _e( 'Pole', $this->name ) ?></th>
			<th scope="col"><?php _e( 'Time', $this->name ) ?></th>
			<th scope="col"><?php echo $this->fl_label($this->options->get_predict_lapsled(), true); ?></th>
			<th scope="col"><?php _e( 'Description', $this->name ) ?></th>
			<th scope="col"><?php _e( 'Calculator', $this->name ) ?></th>
		</tr></thead>
		<tbody>
<?php
		$opts = new MotorRacingLeagueOptions();
		$sql = 'SELECT id,season,description,num_predictions,calculator,options FROM '.$wpdb->prefix.$this->pf.'championship ORDER BY id;';
		$result = $wpdb->get_results( $sql , OBJECT );
		foreach ($result as $row) {
			$opts->set($row->options);
			echo '<tr><td><input type="checkbox" value="'.$row->id.'" name ="'.$this->pf.'champ['.$row->id.']"/></td>';
			echo '<td>'.$row->id.'</td><td><a title="'.__('Create drivers and races for this championship',$this->name).'" href="'.admin_url('admin.php?page=motorracingleague_championship').'&amp;subpage='.$this->pf.'participants&amp;'.$this->pf.'championship_id='.$row->id.'">'.$row->season.'</a></td>
				<td>'.$row->num_predictions.'</td>
				<td><input '.($opts->get_predict_rain() ? ' checked ' : ''). ' disabled type="checkbox"  /></td>
				<td><input '.($opts->get_predict_safety_car() ? ' checked ' : ''). ' disabled type="checkbox"  /></td>
				<td><input '.($opts->get_predict_dnf() ? ' checked ' : ''). ' disabled type="checkbox"  /></td>
				<td><input '.($opts->get_double_up() ? ' checked ' : ''). ' disabled type="checkbox"  /></td>
				<td><input '.($opts->get_predict_pole() ? ' checked ' : ''). ' disabled type="checkbox"  /></td>
				<td><input '.($opts->get_predict_pole_time() ? ' checked ' : ''). ' disabled type="checkbox"  /></td>
				<td><input '.($opts->get_predict_fastest() ? ' checked ' : ''). ' disabled type="checkbox"  /></td>
				<td>'.$row->description.'</td>
				<td>'.$row->calculator;
			echo "</td></tr>";
		}
?>
		</tbody>
		</table>		
		<input type="submit" name="<?php echo $this->pf; ?>delete" value="<?php _e( 'Delete Selected', $this->name ); ?>" class="button" />
		</form>
		<br />
		<br />

		<a name="champ"></a>
		<h3><?php _e( 'Add Championship', $this->name ) ?></h3>
		<p><?php _e( 'Create a new championship season. Once created click on the Season link above to enter Races, Drivers, etc.', $this->name ) ?></p>
		<p><?php _e( 'Season is a short name for the championship, e.g. 2009 or Winter', $this->name ) ?></p>
		<p><?php _e( 'Description is the long name for the championship, e.g. Formula One World Drivers Championship', $this->name ) ?></p>
		<p><?php _e( 'Number of Predictions is the number of places to predict. E.g. 3 would be the top three.', $this->name ) ?></p>
		<p><?php _e( 'Calculator is an optional user specified points calculation function. Leave this blank to use the built-in Scoring system. See README for more details.', $this->name ) ?></p>
		

		<form action="" method="post" class="form-table motorracingleague-form">
			<?php wp_nonce_field( $this->pf . 'add-champ' ) ?>
			<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>season"><?php _e( 'Season', $this->name ) ?></label></th>
				<td><input type="text" name="<?php echo $this->pf;?>season" id="<?php echo $this->pf;?>season" value="" size="10" style="margin-bottom: 1em;" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>description"><?php _e( 'Description', $this->name ) ?></label></th>
				<td><input type="text" name="<?php echo $this->pf;?>description" id="<?php echo $this->pf;?>description" value="" size="60" style="margin-bottom: 1em;"/></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>numpredictions"><?php _e( 'Number of Predictions', $this->name ) ?></label></th>
				<td><input type="text" name="<?php echo $this->pf;?>numpredictions" id="<?php echo $this->pf;?>numpredictions" value="" size="2" style="margin-bottom: 1em;" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>calculator"><?php _e( 'PHP Filename of calculator function (Optional). Leave blank to use the built-in Scoring features.', $this->name ) ?></label></th>
				<td><input type="text" name="<?php echo $this->pf;?>calculator" id="<?php echo $this->pf;?>calculator" value="" size="60" style="margin-bottom: 1em;" /></td>
			</tr>
			</table>
			<p class="submit"><input type="submit" name="<?php echo $this->pf;?>addChamp" value="<?php _e( 'Add Championship', $this->name ) ?>" class="button-primary" /></p>
		</form>

		</div>		
<?php
	}
	
	/**
	 * Register global option settings.
	 * 
	 * @param none
	 * @return unknown_type
	 */
	function register_mysettings() { // whitelist options
		register_setting( $this->pf.'option-group', 'motorracingleague_widget_max' );
		register_setting( $this->pf.'option-group', 'motorracingleague_promo_link' );
		register_setting( $this->pf.'option-group', 'motorracingleague_optin' );
		register_setting( $this->pf.'option-group', 'motorracingleague_optin_message' );
		register_setting( $this->pf.'option-group', 'motorracingleague_max_stats' );
		register_setting( $this->pf.'option-group', 'motorracingleague_display_name' );
		register_setting( $this->pf.'option-group', 'motorracingleague_email_prediction' );
		register_setting( $this->pf.'option-group', 'motorracingleague_email_subject' );
		register_setting( $this->pf.'option-group', 'motorracingleague_email_body' );
		register_setting( $this->pf.'option-group', 'motorracingleague_reminders' );
		register_setting( $this->pf.'option-group', 'motorracingleague_reminder_hours' );
		register_setting( $this->pf.'option-group', 'motorracingleague_reminder_email_subject' );
		register_setting( $this->pf.'option-group', 'motorracingleague_reminder_email_body' );
		
		if (isset($_POST[$this->pf.'already_donated'])) {
			update_option($this->pf.'donated', 1);
		}
		
		if (isset($_REQUEST['page']) && stripos($_REQUEST['page'], 'motorracingleague') !== false) {
			$donated = get_option($this->pf.'donated', 0);
			if (!$donated) {
				$count = (int)get_option($this->pf.'nag', 10) - 1;
				if ($count <= 0) {
					add_action('admin_notices', array(&$this, 'nag'));
					$count = 20;
				}
				update_option($this->pf.'nag', $count);
			}
		}
	}
	
	/**
	 * Be a pest
	 */
	function nag() {
		echo '<div class="updated">
		<form method="post">
		<p>'.sprintf(__('Are you enjoying this plugin?  Please consider donating. If you can\'t donate please consider adding a link to %s Thank you.', $this->name), 'http://ianhaycox.com/').'</p>
		<p><a href="http://www.ianhaycox.com/donate"><img style="vertical-align:bottom" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" /></a>' .
		'  <input class="button-secondary" type="submit" name="'.$this->pf.'already_donated" value="'.__('Already donated', $this->name).'" />
		</p>
		</form>
		</div>';
	}
	
	/**
	 * Global plugin settings
	 * 
	 * @param none
	 * @return unknown_type
	 */
	function settings() {
?>		
	<div class="wrap">
	
	<h2><?php _e('Motor Racing League Options', $this->name) ?></h2>
	
	<form method="post" action="options.php">
	
	<?php settings_fields( $this->pf.'option-group' );?>
	
	<table class="form-table motorracingleague-form">
	
	<tr valign="top">
	<th style="width:300px;" scope="row"><?php _e('Max results in widget', $this->name) ?></th>
	<td><input type="text" size="3" name="motorracingleague_widget_max" value="<?php echo get_option('motorracingleague_widget_max'); ?>" /></td>
	</tr>
	<tr valign="top">
	<th scope="row"><?php _e('Display plugin link in footer', $this->name) ?></th>
	<td><input type="checkbox" name="motorracingleague_promo_link" value="1" <?php echo get_option('motorracingleague_promo_link') ? ' checked ' : ''; ?> /></td>
	</tr>
	<tr valign="top">
	<th scope="row"><?php _e('Show display_name instead of login_name from profile (experimental)', $this->name) ?></th>
	<td><input type="checkbox" name="motorracingleague_display_name" value="1" <?php echo get_option('motorracingleague_display_name') ? ' checked ' : ''; ?> /></td>
	</tr>
	<tr valign="top">
	<th scope="row"><?php _e('Ask users to Opt-in to mailing list', $this->name) ?></th>
	<td><input type="checkbox" name="motorracingleague_optin" value="1" <?php echo get_option('motorracingleague_optin') ? ' checked ' : ''; ?> /></td>
	</tr>
	<tr valign="top">
	<th scope="row"><?php _e('Opt-in mailing list message', $this->name) ?></th>
	<td><input type="text" size="60" name="motorracingleague_optin_message" value="<?php echo get_option('motorracingleague_optin_message'); ?>" /></td>
	</tr>
	<tr valign="top">
	<th scope="row"><?php _e('Max statistical positions - zero is all', $this->name) ?></th>
	<td><input type="text" size="3" name="motorracingleague_max_stats" value="<?php echo get_option('motorracingleague_max_stats'); ?>" /></td>
	</tr>
	<tr valign="top">
	<td colspan="2"><hr></td>
	</tr>
	<tr valign="top">
	<th scope="row"><?php _e('Send prediction confirmation email', $this->name) ?></th>
	<td><input type="checkbox" name="motorracingleague_email_prediction" value="1" <?php echo get_option('motorracingleague_email_prediction') ? ' checked ' : ''; ?> /></td>
	</tr>
	<tr valign="top">
	<th scope="row"><?php _e('Email confirmation subject', $this->name) ?></th>
	<td><input type="text" size="60" name="motorracingleague_email_subject" value="<?php echo get_option('motorracingleague_email_subject'); ?>" /></td>
	</tr>
	<tr valign="top">
	<th scope="row"><?php _e('Email confirmation body', $this->name) ?></th>
	<td><p><?php _e('You can use HTML in the email body and the following substitution codes', $this->name); ?></p>
	<ul>
	<li>%%user%% - <?php _e('Players name', $this->name); ?></li>
	<li>%%racename%% - <?php _e('Race name', $this->name); ?></li>
	<li>%%predictions%% - <?php _e('HTML prediction list', $this->name); ?></li>
	<li>%%when%% - <?php _e('Date and time of prediction', $this->name); ?></li>
	</ul>
	<textarea rows="10" cols="60" name="motorracingleague_email_body"><?php echo get_option('motorracingleague_email_body'); ?></textarea></td>
	</tr>
	<tr valign="top">
	<td colspan="2"><hr></td>
	</tr>
	
	
	<tr valign="top">
	<th scope="row"><?php _e('Send reminder email', $this->name); ?></th>
	<td><input type="checkbox" name="motorracingleague_reminders" value="1" <?php echo get_option('motorracingleague_reminders') ? ' checked ' : ''; ?> /></td>
	</tr>
	<tr valign="top">
	<th scope="row"><?php _e('Send hours before the entry deadline', $this->name); ?>
			<br /><?php _e('Ensure this is before any optional qualifying deadline.', $this->name); ?></th>
	<td><input type="text" size="4" name="motorracingleague_reminder_hours" value="<?php echo get_option('motorracingleague_reminder_hours'); ?>" /></td>
	</tr>
	<tr valign="top">
	<th scope="row"><?php _e('Reminder email subject', $this->name) ?></th>
	<td><input type="text" size="60" name="motorracingleague_reminder_email_subject" value="<?php echo get_option('motorracingleague_reminder_email_subject'); ?>" /></td>
	</tr>
	<tr valign="top">
	<th scope="row"><?php _e('Reminder email body', $this->name) ?></th>
	<td><p><?php _e('You can use HTML in the email body and the following substitution codes', $this->name); ?></p>
	<ul>
	<li>%%user%% - <?php _e('Players name', $this->name); ?></li>
	<li>%%racename%% - <?php _e('Race name', $this->name); ?></li>
	<li>%%optout%% - <?php _e('Reminder opt-out link', $this->name); ?></li>
	</ul>
	<textarea rows="10" cols="60" name="motorracingleague_reminder_email_body"><?php echo get_option('motorracingleague_reminder_email_body'); ?></textarea></td>
	</tr>
	
	
	
	
	
	</table>
	
	
	<p class="submit">
	<input type="submit" class="button-primary" value="<?php _e('Save Changes', $this->name) ?>" />
	</p>
	</form>
	</div>

		
<?php		
	}	
	

	/**
	 * Create a player prediction. Useful for adding users who may
	 * have emailed a prediction rather than using the form.
	 * 
	 * @return unknown_type
	 */
	function createPrediction() {
		$champid = -1;
		$raceid = -1;
		$mrl_p = array();
		$mrl_player = '';
		$mrl_when = '2009-01-01 10:00:00';
		$mrl_email = '';
		$mrl_pole_lap_time = '';
		$rain = $safety_car = $dnf = $double_up = 0;
		
		if (isset($_POST['mrl_championship'])) {
			$champid = $_POST['mrl_championship'];
			$numPredictions = (int)$this->getChampionshipNumPredictions($champid);
			if ($this->options->get_predict_fastest()) {
				$mrl_p[-1] = -1;
			}
			if ($this->options->get_predict_pole()) {
				$mrl_p[0] = -1;
			}
			for ($i = 1; $i <= $numPredictions; $i++) {
				$mrl_p[$i] = -1;
			}
			$rain = $safety_car = $dnf = $double_up = 0;
		}
		if (isset($_POST['mrl_p'])) {
			$mrl_p = $_POST['mrl_p'];
		}
		if (isset($_POST['mrl_race'])) {
			$raceid = $_POST['mrl_race'];
		}
		if (isset($_POST[$this->pf.'mrl_player'])) {
			$mrl_player = $_POST[$this->pf.'mrl_player'];
		}
		if (isset($_POST[$this->pf.'mrl_email'])) {
			$mrl_email = $_POST[$this->pf.'mrl_email'];
		}
		if (isset($_POST[$this->pf.'mrl_when'])) {
			$mrl_when = $_POST[$this->pf.'mrl_when'];
		}
		if (isset($_POST[$this->pf.'pole_lap_time'])) {
			$mrl_pole_lap_time = $_POST[$this->pf.'pole_lap_time'];
		}
		if (isset($_POST[$this->pf.'rain'])) {
			$rain = $_POST[$this->pf.'rain'];
		}
		if (isset($_POST[$this->pf.'safety_car'])) {
			$safety_car = $_POST[$this->pf.'safety_car'];
		}
		if (isset($_POST[$this->pf.'dnf'])) {
			$dnf = $_POST[$this->pf.'dnf'];
		}
		if (isset($_POST[$this->pf.'double_up'])) {
			$double_up = $_POST[$this->pf.'double_up'];
		}
		?>
		<div class="wrap">
		
		<h2><?php _e('Create a player prediction entry.', $this->name) ?></h2>

		<form name="prediction" action="<?php echo admin_url('admin.php?page=motorracingleague_predictions'); ?>" method="post" class="form-table motorracingleague-form">
		<fieldset>
			<legend><?php _e('Entry for',$this->name); ?> <?php echo $this->getChampionshipName($champid); ?></legend>
		
			<?php wp_nonce_field( $this->pf . 'create-prediction', '_wpnonce2' ) ?>
			<?php wp_nonce_field( $this->pf . 'select-race' ) ?>
			<input type="hidden" value="<?php echo $champid; ?>" name="mrl_championship"></input>
			
			<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="mrl_championship"><?php _e( 'Championship:', $this->name ) ?></label></th>
				<td><?php echo $this->getChampionships($champid,'disabled'); ?></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="mrl_race"><?php _e( 'Race:', $this->name ) ?></label></th>
				<td><?php echo $this->getRaceSelection($champid, true, $raceid, ' '); ?></td>
			</tr>
<?php 		if ($this->options->get_predict_pole_time()) { ?>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>pole_lap_time"><?php _e( 'Pole time:', $this->name ) ?></label></th>
				<td><input placeholder="hh:mm.ccc" type="text" name="<?php echo $this->pf;?>pole_lap_time" id="<?php echo $this->pf;?>pole_lap_time" value="<?php echo $mrl_pole_lap_time;?>" size="10" /></td>
			</tr>
<?php 		} ?>
			<?php foreach ($mrl_p as $i=>$p) {?>
			<tr valign="top">
				<th scope="row"><label for="<?php echo "mrl_p[$i]"; ?>">
				<?php if ($i == 0) {
					_e( 'Pole', $this->name );
				} elseif ($i == -1) {
					echo $this->fl_label($this->options->get_predict_lapsled());
				} else {
					echo "$i:";
				} ?>
				</label></th>
				<td><?php echo $this->getParticipantSelection($champid, "p[$i]", "", $mrl_p[$i]); ?>
				</td>
			</tr>
			<?php }
			$output = '';
			if ($this->options->get_predict_rain()) {
				$output .= '<tr valign="top">';
				$tooltip = __('Rain affected ?', $this->name);
				$output .= '<td><label title="'.$tooltip.'" for="'.$this->pf.'rain">'.__( 'Rain', $this->name ).'</label></td>';
				$output .= '<td><input title="'.$tooltip.'" type="checkbox" '.($rain ? 'checked' : '').' name="'.$this->pf.'rain" id="'.$this->pf.'rain" value="1" /></td>';
				$output .= '</tr>';
			}
			if ($this->options->get_predict_safety_car()) {
				$output .= '<tr valign="top">';
				$tooltip = __('Safety Car deployed ?', $this->name);
				$output .= '<td><label  title="'.$tooltip.'" for="'.$this->pf.'safety_car">'.__( 'Safety Car', $this->name ).'</label></td>';
				$output .= '<td><input  title="'.$tooltip.'" type="checkbox" '.($safety_car ? 'checked' : '').' name="'.$this->pf.'safety_car" id="'.$this->pf.'safety_car" value="1" /></td>';
				$output .= '</tr>';
			}
			if ($this->options->get_predict_dnf()) {
				$output .= '<tr valign="top">';
				$tooltip = __('Number of non finishers', $this->name);
				$output .= '<td><label  title="'.$tooltip.'" for="'.$this->pf.'dnf">'.__( 'DNF', $this->name ).'</label></td>';
				$output .= '<td><select  title="'.$tooltip.'" name="'.$this->pf.'dnf" id="'.$this->pf.'dnf">';
				$num_drivers = $this->getNumDrivers($champid);
				for ($i = 0; $i <= $num_drivers; $i++) {
					$output .= '<option '.($dnf == $i ? 'selected' : '').' value="'.$i.'">' . $i . '</option>';
				}
				$output .= '</select></td>';
				$output .= '</tr>';
			}
			if ($this->options->get_double_up()) {
				$output .= '<tr valign="top">';
				$tooltip = __('Double Up ?', $this->name);
				$output .= '<td><label  title="'.$tooltip.'" for="'.$this->pf.'double_up">'.__( 'Double Up', $this->name ).'</label></td>';
				$output .= '<td><input  title="'.$tooltip.'" type="checkbox" '.($double_up ? 'checked' : '').' name="'.$this->pf.'double_up" id="'.$this->pf.'double_up" value="1" /></td>';
				$output .= '</tr>';
			}
		
			echo $output;
			?>
			<?php if ($this->needsAuthorisation()) { ?>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf; ?>mrl_player"><?php _e( 'Player:', $this->name ) ?></label></th>
				<td><?php echo $this->getUsers($mrl_player); ?></td>
			</tr>
			<?php } else { ?>			
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>mrl_player"><?php _e( 'Player:', $this->name ) ?></label></th>
				<td><input type="text" name="<?php echo $this->pf;?>mrl_player" id="<?php echo $this->pf;?>mrl_player" value="<?php echo $mrl_player;?>" size="30" style="margin-bottom: 1em;" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>mrl_email"><?php _e( 'Email:', $this->name ) ?></label></th>
				<td><input type="text" name="<?php echo $this->pf;?>mrl_email" id="<?php echo $this->pf;?>mrl_email" value="<?php echo $mrl_email;?>" size="30" style="margin-bottom: 1em;" /></td>
			</tr>
			<?php } ?>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>mrl_when"><?php _e( 'Entry Datetime:', $this->name ) ?></label></th>
				<td><input placeholder="YYYY-MM-DD HH:MM:SS" type="text" name="<?php echo $this->pf;?>mrl_when" id="<?php echo $this->pf;?>mrl_when" value="<?php echo $mrl_when;?>" size="30" style="margin-bottom: 1em;" /></td>
			</tr>
			</table>
			<p class="submit"><input type="submit" name="<?php echo $this->pf;?>createPrediction" value="<?php _e( 'Add Prediction', $this->name ) ?>" class="button-primary" />
						<input type="submit" name="<?php echo $this->pf;?>selectRace" value="<?php _e( 'Cancel', $this->name ) ?>" class="button" /></p>
		</fieldset>
		</form>
	</div>
<?php		
	}
	
	
	function mrl_debug($str) {
		
		echo "<pre>" . $str . "</pre>";
	}
	
	/**
	 * Get a list of registered users in a dropdown select box
	 * 
	 * 	TODO Check status and capabilities
	 * 
	 * @param $player - Preselect this user
	 */
	function getUsers($player) {
		global $wpdb;
		
		if (get_option('motorracingleague_display_name')) {
			
			$sql = 'SELECT display_name FROM '.$wpdb->users.' ORDER BY display_name';
			
			$users = $wpdb->get_results( $sql , OBJECT );
			
			$output = "<select name=\"{$this->pf}mrl_player\" id=\"{$this->pf}mrl_player\">";
			$output .= '<option value = ""></option>';
	
			foreach ($users as $row) {
				$output .= "<option ";
				if (!is_null($player) && $player == $row->display_name) {
					$output .= " selected ";
				}
				$output .= "value=\"$row->display_name\">$row->display_name</option>";
			}
			$output .= "</select>";
		} else {
			$sql = 'SELECT user_login FROM '.$wpdb->users.' ORDER BY user_login';
			
			$users = $wpdb->get_results( $sql , OBJECT );
			
			$output = "<select name=\"{$this->pf}mrl_player\" id=\"{$this->pf}mrl_player\">";
			$output .= '<option value = ""></option>';
	
			foreach ($users as $row) {
				$output .= "<option ";
				if (!is_null($player) && $player == $row->user_login) {
					$output .= " selected ";
				}
				$output .= "value=\"$row->user_login\">$row->user_login</option>";
			}
			$output .= "</select>";
		}
		
		return $output;
	}
	
	/**
	 * Manage the predictions made for a championship.
	 * 
	 * @param none
	 * @return unknown_type
	 */
	function predictions() {

		$champid = -1;
		$raceid = -1;
		$mrl_player = $mrl_email = $mrl_when = $mrl_pole_lap_time = '';
		$mrl_p = array();
		$rain = $safety_car = $dnf = $double_up = 0;
				
		if (isset($_POST['mrl_championship'])) {
			$champid = $_POST['mrl_championship'];
			$this->options->load($champid);
			$numPredictions = (int)$this->getChampionshipNumPredictions($champid);
			if ($this->options->get_predict_fastest()) {
				$mrl_p[-1] = -1;
			}
			if ($this->options->get_predict_pole()) {
				$mrl_p[0] = -1;
			}
			for ($i = 1; $i <= $numPredictions; $i++) {
				$mrl_p[$i] = -1;
			}
			$rain = $safety_car = $dnf = $double_up = 0;
		}
			
		if (isset($_POST[$this->pf.'selectChamp'])) {
			check_admin_referer($this->pf . 'select-champ');
		}
		
		if (isset($_POST[$this->pf.'addPrediction'])) {
			check_admin_referer($this->pf . 'select-race');
			$this->createPrediction();
			return;
		}
		
		if (isset($_POST[$this->pf.'createPrediction'])) {
			check_admin_referer($this->pf . 'create-prediction', '_wpnonce2');
			if (isset($_POST['mrl_race'])) {
				$raceid = $_POST['mrl_race'];
			}
			if (isset($_POST[$this->pf.'mrl_player'])) {
				$mrl_player = $_POST[$this->pf.'mrl_player'];
			}
			if (isset($_POST[$this->pf.'mrl_email'])) {
				$mrl_email = $_POST[$this->pf.'mrl_email'];
			}
			if (isset($_POST[$this->pf.'mrl_when'])) {
				$mrl_when = $_POST[$this->pf.'mrl_when'];
			}
			if (isset($_POST[$this->pf.'pole_lap_time'])) {
				$mrl_pole_lap_time = $_POST[$this->pf.'pole_lap_time'];
			}
			if (isset($_POST['mrl_p'])) {
				$mrl_p = $_POST['mrl_p'];
			}
			if (isset($_POST[$this->pf.'rain'])) {
				$rain = $_POST[$this->pf.'rain'];
			}
			if (isset($_POST[$this->pf.'safety_car'])) {
				$safety_car = $_POST[$this->pf.'safety_car'];
			}
			if (isset($_POST[$this->pf.'dnf'])) {
				$dnf = $_POST[$this->pf.'dnf'];
			}
			if (isset($_POST[$this->pf.'double_up'])) {
				$double_up = $_POST[$this->pf.'double_up'];
			}
			$ret = $this->addPrediction($raceid, $mrl_player, $mrl_email, $mrl_p, $mrl_when, $mrl_pole_lap_time, $rain, $safety_car, $dnf, $double_up);
			$this->printMessage();
			if (!$ret) {
				$this->createPrediction();  // Try again - bad input
				return;
			}
		}
		
		if (isset($_POST[$this->pf.'modifyPrediction'])) {
			check_admin_referer($this->pf . 'modify-prediction', '_wpnonce2');
			if (isset($_POST['mrl_championship'])) {
				$champid = $_POST['mrl_championship'];
				$calculator = $this->getChampionshipCalculator($champid);	
			}
			if (isset($_POST['mrl_race'])) {
				$raceid = $_POST['mrl_race'];
			}
			if (isset($_POST['mrl_entry'])) {
				$entryid = $_POST['mrl_entry'];
			}
			if (isset($_POST[$this->pf.'mrl_player'])) {
				$mrl_player = $_POST[$this->pf.'mrl_player'];
			}
			if (isset($_POST[$this->pf.'mrl_email'])) {
				$mrl_email = $_POST[$this->pf.'mrl_email'];
			}
			if (isset($_POST[$this->pf.'mrl_when'])) {
				$mrl_when = $_POST[$this->pf.'mrl_when'];
			}
			if (isset($_POST[$this->pf.'pole_lap_time'])) {
				$mrl_pole_lap_time = $_POST[$this->pf.'pole_lap_time'];
			}
			if (isset($_POST['mrl_p'])) {
				$mrl_p = $_POST['mrl_p'];
			}
			if (isset($_POST[$this->pf.'rain'])) {
				$rain = $_POST[$this->pf.'rain'];
			}
			if (isset($_POST[$this->pf.'safety_car'])) {
				$safety_car = $_POST[$this->pf.'safety_car'];
			}
			if (isset($_POST[$this->pf.'dnf'])) {
				$dnf = $_POST[$this->pf.'dnf'];
			}
			if (isset($_POST[$this->pf.'double_up'])) {
				$double_up = $_POST[$this->pf.'double_up'];
			}
			$ret = $this->updatePrediction($entryid, $raceid, $mrl_player, $mrl_email, $mrl_p, $mrl_when, $mrl_pole_lap_time, $rain, $safety_car, $dnf, $double_up);
			$this->printMessage();
			if ($ret) {
				$this->updateStandings($raceid, $this->getDriverPositions($raceid),
							$this->getPredictions($raceid), $calculator);
				$this->printMessage();
			} else {
				$this->modifyPrediction($raceid, $champid, $entryid);
				return;
			}
		}
		
		if (isset($_GET['raceid']) && isset($_GET['champid']) && isset($_GET[$this->pf.'modifyPrediction'])) {
			$raceid = $_GET['raceid'];
			$champid = $_GET['champid'];
			$entryid = $_GET[$this->pf.'modifyPrediction'];
			$this->modifyPrediction($raceid, $champid, $entryid);
			return;
		}
				
		if (isset($_POST[$this->pf.'selectRace'])) {
			check_admin_referer($this->pf . 'select-race');
			if (isset($_POST['mrl_championship'])) {
				$champid = $_POST['mrl_championship'];
			}
			if (isset($_POST['mrl_race'])) {
				$raceid = $_POST['mrl_race'];
			}
		}
		
		if (isset($_POST[$this->pf.'deleteEntry'])) {
			check_admin_referer($this->pf . 'delete-entry');
			if (isset($_POST['mrl_championship'])) {
				$champid = $_POST['mrl_championship'];
			}
			if (isset($_POST['mrl_race'])) {
				$raceid = $_POST['mrl_race'];
			}
			if (isset($_POST[$this->pf.'entry'])) {
				foreach ($_POST[$this->pf.'entry'] as $id) {
					$this->deleteEntry($id);
					$this->printMessage();
				}
			}
		}
		
		if (isset($_POST[$this->pf.'mailinglist'])) {
			check_admin_referer($this->pf . 'select-race');
			if (isset($_POST['mrl_championship'])) {
				$champid = $_POST['mrl_championship'];
			}
			$this->mailingList($champid);
			return;
		}
		
		
?>
		<div class="wrap">
		
		<h2><?php _e('Motor Racing League Predictions', $this->name) ?></h2>


<?php 
		if ($this->getNumChampionships() == 0) {
			echo '<p class="error">'.__('No championships defined. Use the Championship option to create some.', $this->name).'</p>';
			echo '</div>';
			return;			
		}

?>		
		<form action="" method="post" style="margin-top: 1em;">
			<?php wp_nonce_field( $this->pf . 'select-champ' ) ?>
			<?php echo $this->getChampionships($champid); ?>
			<p class="submit"><input type="submit" name="<?php echo $this->pf;?>selectChamp" value="<?php _e( 'Select Championship', $this->name ) ?>" class="button" /></p>
		</form>


<?php
		$quit = false;
		if ($champid == -1) {
			$quit = true;
		} else {
			if ($this->getNumRaces($champid, true) == 0) {
				echo '<p class="error">'.__('No races defined. Use the Championship option to create some.', $this->name).'</p>';
				$quit = true;
			}
		}
		if ($quit) {
			echo '</div>';
			return;
		}
?>
		
		<h3><?php _e('Current points standing for player entries.', $this->name); ?> </h3>

		<form action="" method="post" style="margin-top: 1em;">
			<?php wp_nonce_field( $this->pf . 'select-race' ) ?>
			<?php wp_nonce_field( $this->pf . 'create-prediction', '_wpnonce2') ?>
			<?php echo $this->getRaceSelection($champid, true, $raceid, __("All Races ", $this->name)); ?>
			<input type="hidden" value="<?php echo $champid; ?>" name="mrl_championship"></input>
			<p class="submit"><input type="submit" name="<?php echo $this->pf;?>selectRace" value="<?php _e( 'Select Race', $this->name ) ?>" class="button" />
				<input type="submit" name="<?php echo $this->pf;?>addPrediction" value="<?php _e( 'Create Prediction', $this->name ) ?>" class="button" />
				<?php if ($this->askOptIn()) { ?>
				<input type="submit" name="<?php echo $this->pf;?>mailinglist" value="<?php _e( 'Opt-in List', $this->name ) ?>" class="button" />
				<?php } ?>
			</p>
		</form>
		
<?php 
		if ($raceid == -1) {
			echo $this->getAllStandings($champid, true, '', 30, true);
		} else {
			
			echo $this->getRaceResult($champid, $raceid);
			
?>
			<hr />
			<form action="" method="post" style="margin-top: 1em;">
				<?php wp_nonce_field( $this->pf . 'delete-entry' ) ?>
				<?php echo $this->getStandings($champid, $raceid); ?>
				<input type="hidden" value="<?php echo $champid; ?>" name="mrl_championship"></input>
				<input type="hidden" value="<?php echo $raceid; ?>" name="mrl_race"></input>
				<input type="submit" name="<?php echo $this->pf;?>deleteEntry" class="button" value="<?php _e('Delete Selected') ?>" />
			</form>
<?php
		}
?>
	</div>
<?php				
	}	

	
	/**
	 * Display a list of email addresses for opted-in users
	 */
	function mailingList($champid) {
		global $wpdb;
		
		$sql = "SELECT DISTINCT player_name, email
				FROM
					{$wpdb->prefix}{$this->pf}entry e,
					{$wpdb->prefix}{$this->pf}race r,
					{$wpdb->prefix}{$this->pf}championship c
				WHERE
					c.id = %d AND
					r.championship_id = c.id AND
					e.race_id = r.id AND
					optin = 1
				ORDER BY
					player_name";
		$results = $wpdb->get_results($wpdb->prepare($sql, $champid));
		
?>
		<div class="wrap">
		
		<h2><?php _e('Mailing List', $this->name) ?></h2>
<pre>
<?php
	foreach ($results as $row) {
		echo "$row->player_name, $row->email\n";
	}
?>
</pre>				
		</div>
<?php
	}
	
	/**
	 * Manage results for a championship
	 * 
	 * @param none
	 * @return unknown_type
	 */
	function results() {

		global $wpdb;
		$champid = -1;
		$raceid = -1;
		$resultid = -1;
		$mrl_p = array();
		$mrl_points = array();
		$disabled = '';		// Make race dropdown readonly during modification
		$pole_lap_time = '';
		$pole_lap_time_points = 0;
		$rain = $safety_car = $dnf = 0;
		
		
		if (isset($_POST['mrl_championship'])) {
			$champid = $_POST['mrl_championship'];
			$this->options->load($champid);
			$numPredictions = (int)$this->getChampionshipNumPredictions($champid);
			$numPredictions += $this->options->get_additional_race_results();
			if ($this->options->get_predict_fastest()) {
				$mrl_p[-1] = -1;
				$mrl_points[-1] = 0;
			}
			if ($this->options->get_predict_pole()) {
				$mrl_p[0] = -1;
				$mrl_points[0] = 0;
			}
			for ($i = 1; $i <= $numPredictions; $i++) {
				$mrl_p[$i] = -1;
				$mrl_points[$i] = 0;
			}
			$rain = $safety_car = $dnf = 0;
		}
				
		
		if (isset($_GET[$this->pf.'modifyresultid']) && isset($_GET[$this->pf.'champid'])) {
			$champid = $_GET[$this->pf.'champid'];
			$this->options->load($champid);
			$raceid = $_GET[$this->pf.'modifyresultid'];
			$resultid = $raceid;
			$disabled = ' disabled ';
			$sql = 'SELECT pole_lap_time, pole_lap_time_points, position, participant_id, race_points, rain, dnf, safety_car
					FROM '.$wpdb->prefix.$this->pf.'result, '.$wpdb->prefix.$this->pf.'race r
				WHERE r.id = '.$raceid.' AND r.id=race_id ORDER BY position';
			$result = $wpdb->get_results( $sql , OBJECT );
			foreach ($result as $row) {
				$mrl_p[$row->position] = $row->participant_id;
				$mrl_points[$row->position] = $row->race_points;
			}
			$pole_lap_time = $this->from_laptime($result[0]->pole_lap_time);  // convert to HMM:SS.ccc fingers crossed !
			$pole_lap_time_points = $result[0]->pole_lap_time_points;
			$rain = $result[0]->rain;
			$safety_car = $result[0]->safety_car;
			$dnf = $result[0]->dnf;
		}
		
		if (isset($_POST[$this->pf.'cancelResults'])) {
		}
		
		if (isset($_POST[$this->pf.'selectChamp'])) {
			check_admin_referer($this->pf . 'select-champ');
		}
		
		if (isset($_POST[$this->pf.'deleteResults'])) {
			check_admin_referer($this->pf . 'list-results');
			if (isset($_POST[$this->pf.'result'])) {
				foreach ($_POST[$this->pf.'result'] as $race_id) {
					$this->deleteResult($race_id);
					$this->printMessage();
				}
			}
		}
		
		if (isset($_POST[$this->pf.'updateResults'])) {
			check_admin_referer($this->pf . 'list-results');
			$calculator = $this->getChampionshipCalculator($champid);	
			if (isset($_POST[$this->pf.'result'])) {
				foreach ($_POST[$this->pf.'result'] as $race_id) {
					$this->updateStandings($race_id, $this->getDriverPositions($race_id),
								$this->getPredictions($race_id), $calculator);
					$this->printMessage();
				}
			}
		}
		
		if (isset($_POST[$this->pf.'saveResults'])) {
			check_admin_referer($this->pf . 'results-form');
			$calculator = $this->getChampionshipCalculator($champid);	
			if (isset($_POST['mrl_race'])) {
				$raceid = $_POST['mrl_race'];
			}
			if (isset($_POST[$this->pf.'pole_time'])) {
				$pole_lap_time = $_POST[$this->pf.'pole_time'];
			}
			if (isset($_POST[$this->pf.'pole_time_points'])) {
				$pole_lap_time_points = $_POST[$this->pf.'pole_time_points'];
			}
			if (isset($_POST['mrl_p'])) {
				$mrl_p = $_POST['mrl_p'];
			}
			if (isset($_POST[$this->pf.'race_points'])) {
				$mrl_points = $_POST[$this->pf.'race_points'];
			}
			if (isset($_POST[$this->pf.'rain'])) {
				$rain = $_POST[$this->pf.'rain'];
			}
			if (isset($_POST[$this->pf.'safety_car'])) {
				$safety_car = $_POST[$this->pf.'safety_car'];
			}
			if (isset($_POST[$this->pf.'dnf'])) {
				$dnf = $_POST[$this->pf.'dnf'];
			}
			$ret = $this->saveResults($raceid, $mrl_p, $pole_lap_time, $pole_lap_time_points, $mrl_points, $rain, $safety_car, $dnf);
			$this->printMessage();
			if ($ret) {
				$this->updateStandings($raceid, $this->getDriverPositions($raceid), $this->getPredictions($raceid), $calculator);
				$this->printMessage();
				$raceid = -1;
				$pole_lap_time = '';
				$pole_lap_time_points = 0;
				foreach ($mrl_p as $key=>$p) {
					$mrl_p[$key] = -1;
				}
				foreach ($mrl_points as $key=>$p) {
					$mrl_points[$key] = 0;
				}
				$rain = $safety_car = $dnf = 0;
			}
			
		}
		
		if (isset($_POST[$this->pf.'modifyResults'])) {
			check_admin_referer($this->pf . 'results-form');
			
			$calculator = $this->getChampionshipCalculator($champid);
			
			if (isset($_POST['mrl_resultid'])) {
				$resultid = $_POST['mrl_resultid'];
			}
			if (isset($_POST[$this->pf.'pole_time'])) {
				$pole_lap_time = $_POST[$this->pf.'pole_time'];
			}
			if (isset($_POST[$this->pf.'pole_time_points'])) {
				$pole_lap_time_points = $_POST[$this->pf.'pole_time_points'];
			}
			if (isset($_POST['mrl_p'])) {
				$mrl_p = $_POST['mrl_p'];
			}
			if (isset($_POST[$this->pf.'race_points'])) {
				$mrl_points = $_POST[$this->pf.'race_points'];
			}
			if (isset($_POST[$this->pf.'rain'])) {
				$rain = $_POST[$this->pf.'rain'];
			}
			if (isset($_POST[$this->pf.'safety_car'])) {
				$safety_car = $_POST[$this->pf.'safety_car'];
			}
			if (isset($_POST[$this->pf.'dnf'])) {
				$dnf = $_POST[$this->pf.'dnf'];
			}
			$disabled = ' disabled ';
			$raceid = $resultid;
			$ret = $this->updateResult($raceid, $mrl_p, $pole_lap_time, $pole_lap_time_points, $mrl_points, $rain, $safety_car, $dnf);
			$this->printMessage();
			if ($ret) {
				$this->updateStandings($raceid, $this->getDriverPositions($raceid), $this->getPredictions($raceid), $calculator);
				$this->printMessage();
				$disabled = '';
				$raceid = -1;
				$resultid = -1;
				$pole_lap_time = '';
				$pole_lap_time_points = 0;
				foreach ($mrl_p as $key=>$p) {
					$mrl_p[$key] = -1;
				}
				foreach ($mrl_points as $key=>$p) {
					$mrl_points[$key] = 0;
				}
				$rain = $safety_car = $dnf = 0;
			}
		}
?>
		<div class="wrap">
		<h2><?php _e('Enter Race Results', $this->name) ?></h2>
		
		<p><?php _e('Once the race has finished enter the finishing positions to calculate the players points totals.', $this->name) ?></p>
		<p><?php _e('If you delete a race result then re-enter the details the prediction points will be re-calculated.', $this->name) ?></p>
		
<?php 
		if ($this->getNumChampionships() == 0) {
			echo '<p class="error">'.__('No championships defined. Use the Championship option to create some.', $this->name).'</p>';
			echo '</div>';
			return;			
		}

?>		
		<form action="<?php echo admin_url('admin.php?page=motorracingleague_results'); ?>" method="post" style="margin-top: 1em;">
			<?php wp_nonce_field( $this->pf . 'select-champ' ) ?>
			<?php echo $this->getChampionships($champid); ?>
			<p class="submit"><input type="submit" name="<?php echo $this->pf;?>selectChamp" value="<?php _e( 'Select Championship', $this->name ) ?>" class="button" /></p>
		</form>

<?php 
		$quit = false;
		if ($champid == -1) {
			$quit = true;
		} else {
			if ($this->getNumRaces($champid, true) == 0) {
				echo '<p class="error">'.__('No races defined. Use the Championship option to create some.', $this->name).'</p>';
				$quit = true;
			}
			if ($this->getNumParticipants($champid) == 0) {
				echo '<p class="error">'.__('No drivers defined. Use the Championship option to create some.', $this->name).'</p>';
				$quit = true;
			}
		}
		if ($quit) {
			echo '</div>';
			return;
		}
?>
		<div id="motorracingleague_racepoints_info" title="<?php _e("Points", $this->name); ?>">
		<p><?php _e('Points for race results are optional, unless the Scoring option "Use Race Points" is checked.', $this->name); ?></p>
		<p><?php _e('When "Use Race Points" is checked, players are awarded race result points for each prediction that matches. For example, player predicts Driver1 in second place. If Driver1 finishes fifth, then the player gains points for the fifth place finish.', $this->name); ?></p>
		</div>
		
		<form action="<?php echo admin_url('admin.php?page=motorracingleague_results'); ?>" method="post" class="form-table motorracingleague-form">
			<?php wp_nonce_field( $this->pf . 'results-form' ) ?>
			<input type="hidden" value="<?php echo $champid; ?>" name="mrl_championship"></input>
			<table class="form-table">
			
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>mrl_race"><?php _e( 'Race:', $this->name ) ?></label></th>
				<td><?php echo $this->getRaceSelection($champid, true, $raceid, ' ', $disabled); ?></td>
				<th scope="col"><?php _e('Points', $this->name); echo $this->info('motorracingleague_racepoints'); ?></th>
			</tr>
<?php 		if ($this->options->get_predict_pole_time()) { ?>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>pole_time"><?php _e( 'Pole time:', $this->name ) ?></label></th>
				<td><input placeholder="hh:mm.ccc" type="text" name="<?php echo $this->pf;?>pole_time" id="<?php echo $this->pf;?>pole_time" value="<?php echo $pole_lap_time;?>" size="10" /></td>
				<td><input type="text" name="<?php echo $this->pf;?>pole_time_points" id="<?php echo $this->pf;?>pole_time_points" value="<?php echo $pole_lap_time_points;?>" size="3" /></td>
			</tr>
<?php 		} ?>

			<?php foreach ($mrl_p as $i=>$p) {?>
			<tr valign="top">
				<th scope="row"><label for="<?php echo "mrl_p[$i]"; ?>">
				<?php if ($i == 0) {
					_e( 'Pole', $this->name );
				} elseif ($i == -1) {
					echo $this->fl_label($this->options->get_predict_lapsled());
				} else {
					echo "$i:";
				} ?>
				</label></th>
				<td><?php echo $this->getParticipantSelection($champid, "p[$i]", "", $mrl_p[$i]); ?>
				</td>
				<td><input type="text" name="<?php echo $this->pf;?>race_points[<?php echo $i; ?>]" id="<?php echo $this->pf;?>race_points<?php echo $i; ?>" value="<?php echo $mrl_points[$i]; ?>" size="3" /></td>
			</tr>
			<?php }
			$output = '';
			if ($this->options->get_predict_rain()) {
				$output .= '<tr valign="top">';
				$tooltip = __('Rain affected ?', $this->name);
				$output .= '<td><label title="'.$tooltip.'" for="'.$this->pf.'rain">'.__( 'Rain', $this->name ).'</label></td>';
				$output .= '<td><input title="'.$tooltip.'" type="checkbox" '.($rain ? 'checked' : '').' name="'.$this->pf.'rain" id="'.$this->pf.'rain" value="1" /></td>';
				$output .= '</tr>';
			}
			if ($this->options->get_predict_safety_car()) {
				$output .= '<tr valign="top">';
				$tooltip = __('Safety Car deployed ?', $this->name);
				$output .= '<td><label  title="'.$tooltip.'" for="'.$this->pf.'safety_car">'.__( 'Safety Car', $this->name ).'</label></td>';
				$output .= '<td><input  title="'.$tooltip.'" type="checkbox" '.($safety_car ? 'checked' : '').' name="'.$this->pf.'safety_car" id="'.$this->pf.'safety_car" value="1" /></td>';
				$output .= '</tr>';
			}
			if ($this->options->get_predict_dnf()) {
				$output .= '<tr valign="top">';
				$tooltip = __('Number of non finishers', $this->name);
				$output .= '<td><label  title="'.$tooltip.'" for="'.$this->pf.'dnf">'.__( 'DNF', $this->name ).'</label></td>';
				$output .= '<td><select  title="'.$tooltip.'" name="'.$this->pf.'dnf" id="'.$this->pf.'dnf">';
				$num_drivers = $this->getNumDrivers($champid);
				for ($i = 0; $i <= $num_drivers; $i++) {
					$output .= '<option '.($dnf == $i ? 'selected' : '').' value="'.$i.'">' . $i . '</option>';
				}
				$output .= '</select></td>';
				$output .= '</tr>';
			}
			echo $output;
			?> </table>
			<?php if ($resultid == -1) { ?>
				<p class="submit">
				<input type="submit" name="<?php echo $this->pf;?>saveResults" class="button-primary" value="<?php _e('Save Results', $this->name) ?>" />
				</p>
			<?php } else { ?>
				<p class="submit">
				<input type="hidden" value="<?php echo $resultid; ?>" name="mrl_resultid"></input>
				<input type="submit" name="<?php echo $this->pf;?>modifyResults" class="button-primary" value="<?php _e('Modify Results', $this->name) ?>" />
				<input type="submit" name="<?php echo $this->pf;?>cancelResults" class="button" value="<?php _e('Cancel', $this->name) ?>" />
				</p>
			<?php } ?>
		</form>
		
		<form action="" method="post" style="margin-top: 1em;">
			<?php wp_nonce_field( $this->pf . 'list-results' ) ?>
			<?php echo $this->getResults($champid); ?>
			<input type="hidden" value="<?php echo $champid; ?>" name="mrl_championship"></input>
			<input type="submit" name="<?php echo $this->pf;?>deleteResults" class="button" value="<?php _e('Delete Selected', $this->name) ?>" />
			<input type="submit" name="<?php echo $this->pf;?>updateResults" class="button" value="<?php _e('Recalculate Points for Selected', $this->name) ?>" />
		</form>
		
		</div>
<?php
	}	
	
	/**
	 * Manage the participants for a championship.
	 * 
	 * Add/delete drivers/riders
	 * 
	 * @param none
	 * @return unknown_type
	 */
	function participants() {
		global $wpdb;

		if (isset($_REQUEST[$this->pf.'championship_id'])) {
			$championship_id = $_REQUEST[$this->pf.'championship_id'];
			$this->options->load($championship_id);
		} else {
			$this->setMessage(__('You must select a championship first', $this->name), true);
			$this->printMessage();
			return;
		}
		
		if (isset($_POST[$this->pf.'updateChamp'])) {
			check_admin_referer($this->pf . 'update-champ');
			if (!isset($_POST[$this->pf.'numpred'])) {
				$n = $this->getChampionshipNumPredictions($championship_id);
			} else {
				$n = $_POST[$this->pf.'numpred'];
			}
			$this->updateChampionship($championship_id, $_POST[$this->pf.'season'], 
				$_POST[$this->pf.'champ_desc'], $n, $_POST[$this->pf.'calculator']);
			$this->printMessage();
		}
		
		if (isset($_POST[$this->pf.'copyDrivers'])) {
			check_admin_referer($this->pf . 'update-champ');
			$this->copyDrivers($_POST['mrl_championship'], $championship_id);
			$this->printMessage();
		}
		
		/*
		 * If any race results or predictions are defined for this championship
		 * disable some fields. E.g. changing number of predictions half-way through
		 * a competition.  
		 */
		$sql = "SELECT COUNT(*) AS num FROM
					{$wpdb->prefix}{$this->pf}result res,
					{$wpdb->prefix}{$this->pf}race r
				WHERE
					r.championship_id = %d AND res.race_id = r.id";
		$inuse = $wpdb->get_row($wpdb->prepare($sql, $championship_id));
		$sql = "SELECT COUNT(*) AS num FROM
					{$wpdb->prefix}{$this->pf}entry e,
					{$wpdb->prefix}{$this->pf}race r
				WHERE
					r.championship_id = %d AND e.race_id = r.id";
		$inuse2 = $wpdb->get_row($wpdb->prepare($sql, $championship_id));
		if (($inuse->num + $inuse2->num) > 0) {
			$this->protected = " disabled ";
			if (isset($_SESSION['motorracingleague_warn']) &&  $_SESSION['motorracingleague_warn'] == 'Y') {
				$this->setMessage(__('Some options can not be changed whilst there are predictions or race results', $this->name));
				$this->printMessage();
				$_SESSION['motorracingleague_warn'] = 'N';
			}
		}
		
		/*
		 * What championships have we got ?
		 */
		$sql = 'SELECT season, description, num_predictions, calculator FROM '.$wpdb->prefix.$this->pf.'championship WHERE id = '.$championship_id;
		$result = $wpdb->get_row( $sql , OBJECT );
		$season = $result->season;
		$champ_desc = $result->description;
		$num_predictions = $result->num_predictions;
		$calculator = $result->calculator;
		
?>
		<div class="wrap">
		<div id="motor-racing-league-champ-tabs">
		<h2><?php echo $season . ' - ' . $champ_desc; ?></h2>
		
		<ul>
			<li><a href="#motor-racing-league-champ-tabs-1"><?php _e("Championship")?></a></li>
			<li><a href="#motor-racing-league-champ-tabs-2"><?php _e("Participants")?></a></li>
			<li><a href="#motor-racing-league-champ-tabs-3"><?php _e("Races")?></a></li>
			<li><a href="#motor-racing-league-champ-tabs-4"><?php _e("Options")?></a></li>
			<li><a href="#motor-racing-league-champ-tabs-5"><?php _e("Scoring")?></a></li>
		</ul>
		
		<div id="motor-racing-league-champ-tabs-1">
		<form method="post" action="" class="form-table motorracingleague-form">
		<?php wp_nonce_field( $this->pf . 'update-champ' ) ?>
			<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>season"><?php _e( 'Season', $this->name ) ?></label></th>
				<td><input type="text" name="<?php echo $this->pf;?>season" id="<?php echo $this->pf;?>season" value="<?php echo $season;?>" size="10" style="margin-bottom: 1em;" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>champ_desc"><?php _e( 'Description', $this->name ) ?></label></th>
				<td><input type="text" name="<?php echo $this->pf;?>champ_desc" id="<?php echo $this->pf;?>champ_desc" value="<?php echo $champ_desc;?>" size="60" style="margin-bottom: 1em;" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>numpred"><?php _e( 'Number of Predictions', $this->name ) ?></label></th>
				<td><input <?php echo $this->protected; ?> type="text" name="<?php echo $this->pf;?>numpred" id="<?php echo $this->pf;?>numpred" value="<?php echo $num_predictions;?>" size="2" style="margin-bottom: 1em;" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>calculator"><?php _e( 'Calculator', $this->name ) ?></label></th>
				<td><input type="text" name="<?php echo $this->pf;?>calculator" id="<?php echo $this->pf;?>calculator" value="<?php echo $calculator;?>" size="60" style="margin-bottom: 1em;" /></td>
			</tr>
			</table>
			<input type="hidden" name="<?php echo $this->pf;?>championship_id" value="<?php echo $championship_id; ?>" />
			<p class="submit">
				<input type="submit" style="margin-right:3em;" name="<?php echo $this->pf;?>updateChamp" value="<?php _e( 'Update Championship', $this->name ) ?>" class="button-primary" />
				<?php _e('Copy drivers from ', $this->name); echo $this->getChampionships(-1); ?>
				<input type="submit" name="<?php echo $this->pf;?>copyDrivers" value="<?php _e( 'Go', $this->name ) ?>" class="button" /></p>
		</form>
		
		</div>
		
		<div id="motor-racing-league-champ-tabs-2">
		
		<?php $this->drivers($championship_id); ?>
		</div>
		
		<div id="motor-racing-league-champ-tabs-3">
		<?php $this->races($championship_id) ?>
		</div>
		
		<div id="motor-racing-league-champ-tabs-4">
		<?php $this->options($championship_id) ?>
		</div>
		
		<div id="motor-racing-league-champ-tabs-5">
		<?php $this->scoring($championship_id, $calculator) ?>
		</div>
		
		</div>

		</div>
<?php
	}
	
	/**
	 * Set to current JQuery tab
	 * 
	 * @param int $i tab number indexed from 0
	 * @return none
	 */
	function selectTab($i) {
?>
		<script type="text/javascript">
		jQuery(function($) {
		  	$("#motor-racing-league-champ-tabs").tabs('option', 'active', <?php echo $i; ?>);
		});
		</script>
<?php 
	}

	
	/**
	 * Manage championship options
	 * 
	 * @param $championship_id Chapionship Id
	 * @return none
	 */
	function options($championship_id) {
		global $wpdb;
		
		if (isset($_POST[$this->pf.'updateOptions'])) {
			check_admin_referer($this->pf . 'option-form');
			
			$extra = isset($_POST[$this->pf.'moreresults']) ? $_POST[$this->pf.'moreresults'] : 0;
			$secs = $_POST[$this->pf.'cookie'];
			if (!is_numeric($extra) || !is_numeric($secs)) {
				$this->setMessage(__("Additional Results and Delay must be numbers", $this->name), true);
			} else {
			
				if (empty($this->protected)) {
					$this->options->set_predict_pole(isset($_POST[$this->pf.'predictpole']));
					$this->options->set_predict_pole_time(isset($_POST[$this->pf.'predictpoletime']));
					$this->options->set_predict_fastest(isset($_POST[$this->pf.'predictfastest']));
					$this->options->set_additional_race_results($_POST[$this->pf.'moreresults']);
				}
				$this->options->set_predict_lapsled(isset($_POST[$this->pf.'predictlapsled']));
				$this->options->set_predict_rain(isset($_POST[$this->pf.'predictrain']));
				$this->options->set_predict_safety_car(isset($_POST[$this->pf.'predictsafetycar']));
				$this->options->set_predict_dnf(isset($_POST[$this->pf.'predictdnf']));
				$this->options->set_double_up(isset($_POST[$this->pf.'doubleup']));
				$this->options->set_can_see_predictions(isset($_POST[$this->pf.'predictview']));
				$this->options->set_must_be_logged_in(isset($_POST[$this->pf.'registered']));
				$this->options->set_cookie_seconds($_POST[$this->pf.'cookie']);
				$this->options->save($championship_id);
				$this->setMessage(__("Updated options", $this->name));
			}
			$this->printMessage();
			$this->selectTab(3);
		}
		
		if (isset($_POST[$this->pf.'cancelOptions'])) {
			$this->selectTab(3);
		}
		
?>
		<div id="motorracingleague_moreresults_info" title="<?php _e( 'Additional race results', $this->name ); ?>">
		<p><?php _e('Add entries of extra finishing positions for a race result above the number of predictions defined.', $this->name); ?></p>
		<p><?php _e('This option allows you to assign points to players whose prediction did not match the drivers finishing position.', $this->name); ?></p>
		<p><?php _e('For example, if the number of predictions is 3, entering 5 here will allow the assignment of points
to a player if the prediction was outside the top three finishers but within the top eight. See the Scoring tab for point assignments.', $this->name); ?></p>
		</div>
		
		<div id="motorracingleague_viewpredictions_info" title="<?php _e( 'View predictions before predicting', $this->name ); ?>">
		<p><?php _e('If checked players can see the predictions of other players before making their own.', $this->name); ?></p>
		</div>
		
		<div id="motorracingleague_cookie_info" title="<?php _e( 'Delay in seconds between predictions', $this->name ); ?>">
		<p><?php _e('Once a player has make a prediction, a cookie is created with a lifetime as the number of seconds entered.', $this->name); ?></p>
		<p><?php _e('The prediction entry form will not be displayed again until this time has expired. This is to prevent multiple entries by the same user,
particuarly for those that are not required to login.', $this->name); ?></p>
		<p><?php _e('A delay of 500,000 seconds is approximately 6 days. For logged in users you may wish to set this number very low, e.g. -1 seconds, to allow users to modify their entry immediately.', $this->name); ?></p>
		</div>
		
		<form action="<?php echo admin_url('admin.php?page=motorracingleague_championship&subpage=motorracingleague_participants'); ?>" method="post" class="form-table motorracingleague-form">
			<?php wp_nonce_field( $this->pf . 'option-form' ) ?>
			<table class="form-table motorracingleague_wider">
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>moreresults"><?php _e( 'Additional race results', $this->name ); ?></label><?php echo $this->info('motorracingleague_moreresults'); ?></th>
				<td><input type="text" name="<?php echo $this->pf;?>moreresults" id="<?php echo $this->pf;?>moreresults" <?php echo $this->protected; ?> value="<?php echo $this->options->get_additional_race_results(); ?>" size="3" style="margin-bottom: 1em;" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>predictpole"><?php _e( 'Predict Pole', $this->name ) ?></label></th>
				<td><input <?php echo $this->options->get_predict_pole() ? ' checked ' : ''; ?> type="checkbox" <?php echo $this->protected; ?> name="<?php echo $this->pf;?>predictpole" id="<?php echo $this->pf;?>predictpole" value="1" style="margin-bottom: 1.5em;" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>predictpoletime"><?php _e( 'Predict Pole Time', $this->name ) ?></label></th>
				<td><input <?php echo $this->options->get_predict_pole_time() ? ' checked ' : ''; ?> type="checkbox" <?php echo $this->protected; ?> name="<?php echo $this->pf;?>predictpoletime" id="<?php echo $this->pf;?>predictpoletime" value="1" style="margin-bottom: 1.5em;" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>predictfastest"><?php _e( 'Predict Fastest Lap/Most Laps Led', $this->name ) ?></label></th>
				<td><input <?php echo $this->options->get_predict_fastest() ? ' checked ' : ''; ?> type="checkbox" <?php echo $this->protected; ?> name="<?php echo $this->pf;?>predictfastest" id="<?php echo $this->pf;?>predictfastest" value="1" style="margin-bottom: 1.5em;" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>predictlapsled"><?php _e( 'Display "Fastest Lap" as "Most Laps Led"', $this->name ) ?></label></th>
				<td><input <?php echo $this->options->get_predict_lapsled() ? ' checked ' : ''; ?> type="checkbox" name="<?php echo $this->pf;?>predictlapsled" id="<?php echo $this->pf;?>predictlapsled" value="1" style="margin-bottom: 1.5em;" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>predictrain"><?php _e( 'Predict if it will rain', $this->name ) ?></label></th>
				<td><input <?php echo $this->options->get_predict_rain() ? ' checked ' : ''; ?> type="checkbox" name="<?php echo $this->pf;?>predictrain" id="<?php echo $this->pf;?>predictrain" value="1" style="margin-bottom: 1.5em;" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>predictsafetycar"><?php _e( 'Predict if a Safety Car is used', $this->name ) ?></label></th>
				<td><input <?php echo $this->options->get_predict_safety_car() ? ' checked ' : ''; ?> type="checkbox" name="<?php echo $this->pf;?>predictsafetycar" id="<?php echo $this->pf;?>predictsafetycar" value="1" style="margin-bottom: 1.5em;" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>predictdnf"><?php _e( 'Predict number of DNFs', $this->name ) ?></label></th>
				<td><input <?php echo $this->options->get_predict_dnf() ? ' checked ' : ''; ?> type="checkbox" name="<?php echo $this->pf;?>predictdnf" id="<?php echo $this->pf;?>predictdnf" value="1" style="margin-bottom: 1.5em;" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>doubleup"><?php _e( 'Allow user to Double Up points for one race', $this->name ) ?></label></th>
				<td><input <?php echo $this->options->get_double_up() ? ' checked ' : ''; ?> type="checkbox" name="<?php echo $this->pf;?>doubleup" id="<?php echo $this->pf;?>doubleup" value="1" style="margin-bottom: 1.5em;" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>predictview"><?php _e( 'View predictions before predicting', $this->name ) ?></label><?php echo $this->info('motorracingleague_viewpredictions'); ?></th>
				<td><input <?php echo $this->options->get_can_see_predictions() ? ' checked ' : ''; ?> type="checkbox" name="<?php echo $this->pf;?>predictview" id="<?php echo $this->pf;?>predictview" value="1" style="margin-bottom: 1.5em;" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>registered"><?php _e( 'Must be logged in', $this->name ) ?></label></th>
				<td><input <?php echo $this->options->get_must_be_logged_in() ? ' checked ' : ''; ?> type="checkbox" name="<?php echo $this->pf;?>registered" id="<?php echo $this->pf;?>registered" value="1" style="margin-bottom: 1.5em;" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>cookie"><?php _e( 'Delay in seconds between predictions', $this->name ) ?></label><?php echo $this->info('motorracingleague_cookie'); ?></th>
				<td><input type="text" name="<?php echo $this->pf;?>cookie" id="<?php echo $this->pf;?>cookie" value="<?php echo $this->options->get_cookie_seconds(); ?>" size="10" style="margin-bottom: 1em;" /></td>
			</tr>
			</table>
			<input type="hidden" name="<?php echo $this->pf;?>championship_id" value="<?php echo $championship_id; ?>" />
			<p class="submit"><input type="submit" name="<?php echo $this->pf;?>updateOptions" value="<?php _e( 'Save Changes', $this->name ) ?>" class="button-primary" />
			<input type="submit" name="<?php echo $this->pf;?>cancelOptions" value="<?php _e( 'Cancel', $this->name ) ?>" class="button" /></p>
		</form>
		
<?php 		
	}
	
		
	/**
	 * Manage championship scoring
	 * 
	 * @param $championship_id Chapionship Id
	 * @return none
	 */
	function scoring($championship_id, $calculator) {
		global $wpdb;
		
		$disabled = '';
		$numPredictions = $this->getChampionshipNumPredictions($championship_id);		
//		echo '<pre>'; print_r($_POST[$this->pf.'poletime']); echo '</pre>';
		
		if (isset($_POST[$this->pf.'updateScore'])) {
			check_admin_referer($this->pf . 'score-form');
			$scoring = $this->options->get_scoring();
			
			$valid = true;
			foreach ($_POST[$this->pf.'poletime'] as $p) {
				$valid = $valid && is_numeric($p['percent']);
				$valid = $valid && is_numeric($p['points']);
			}
			foreach ($_POST[$this->pf.'bonus'] as $p) {
				$valid = $valid && is_numeric($p);
			}
			if (!isset($_POST[$this->pf.'racepoints'])) {
				foreach ($_POST[$this->pf.'points'] as $p) {
					$valid = $valid && is_numeric($p);
				}
				$valid = $valid && is_numeric($_POST[$this->pf.'fastestpoints']) && is_numeric($_POST[$this->pf.'polepoints']);
			}
			if (!$valid) {
				$this->setMessage(__("Numbers please !", $this->name), true);
			} else {
				$scoring['poletime'] = $_POST[$this->pf.'poletime'];  // TODO Sort poletime lowest percent first !
				if (!isset($_POST[$this->pf.'racepoints'])) {
					$scoring['fastest'] = $_POST[$this->pf.'fastestpoints'];
					$scoring['pole'] = $_POST[$this->pf.'polepoints'];
					$scoring['points'] = $_POST[$this->pf.'points'];
				}
				$scoring['rain'] = $_POST[$this->pf.'rainpoints'];
				$scoring['safety_car'] = $_POST[$this->pf.'safety_carpoints'];
				$scoring['dnf'] = $_POST[$this->pf.'dnfpoints'];
				$scoring['use_race_points'] = isset($_POST[$this->pf.'racepoints']);
				$scoring['bonus'] = $_POST[$this->pf.'bonus'];
				$this->options->set_scoring($scoring);
				$this->options->save($championship_id);
				$this->setMessage(__("Updated scoring", $this->name));
			}
			$this->printMessage();
			$this->selectTab(4);
		}
		
		if (isset($_POST[$this->pf.'cancelScore'])) {
			$this->selectTab(4);
		}
		
		$scoring = $this->options->get_scoring();
//		echo '<pre>'; print_r($this->options); echo '</pre>';
//		echo '<pre>'; var_dump($scoring); echo '</pre>';
		
		if (!empty($calculator)) {
			$disabled = ' disabled ';
			echo '<p class="error">' . __('Points calculation performed by', $this->name) . ' ' . $calculator . '</p>';
		} else {
			echo '<h3>' . __('Assign points for predictions', $this->name) . '</h3>';
		}
?>
		<div id="motorracingleague_poletimedialog_info" title="<?php _e( 'Pole time within', $this->name ); ?>">
		<p><?php _e('Assign points based on the accuracy of the pole position time.', $this->name); ?></p>
		<p><?php _e('Add a percentage of 0% to assign points for an exact match. For a lap time of 1:30.000 a percentage of 0.25% gives a margin of error of 0.225 seconds either way.', $this->name); ?></p>
		</div>
		
		<div id="motorracingleague_correctposition_info" title="<?php _e( 'Driver in correct position', $this->name ); ?>">
		<p><?php _e('Players whose prediction is incorrect by one or more places can be assigned points depending on how close the prediction is.', $this->name); ?></p>
		<p><?php _e('In order to assign points for positions outside the allowed number of predictions you will need to alter the option - Additional Race Results.', $this->name); ?></p>
		</div>
		
		<div id="motorracingleague_racepoints_info" title="<?php _e( 'Use race points', $this->name ); ?>">
		<p><?php _e('If checked, points are assigned using the values from race results.', $this->name); ?></p>
		<p><?php _e('Predictions that match a finishing driver in the results are awarded those points.', $this->name); ?></p>
		</div>

		<form action="<?php echo admin_url('admin.php?page=motorracingleague_championship&subpage=motorracingleague_participants'); ?>" method="post" class="form-table motorracingleague-form">
			<?php wp_nonce_field( $this->pf . 'score-form' ) ?>
			<fieldset style="padding-bottom:1em;border:1px solid #A6C9E2;margin-top:1em;">
			<table class="form-table" id="motorracingleague_poletimetable" >
			<?php foreach ($scoring['poletime'] as $i=>$poletime) { ?>
				<tr valign="top">
					<th scope="row"><label><?php _e( 'Pole time within', $this->name ) ?></label><?php if ($i==0) echo $this->info('motorracingleague_poletimedialog'); ?></th>
					<td><input <?php echo $disabled; ?> type="text" name="<?php echo $this->pf;?>poletime[<?php echo $i; ?>][percent]" value="<?php echo isset($scoring['poletime'][$i]['percent']) ? $scoring['poletime'][$i]['percent'] : 0; ?>" size="2" style="margin-bottom: 1em;" />%&nbsp;
					<input <?php echo $disabled; ?> type="text" name="<?php echo $this->pf;?>poletime[<?php echo $i; ?>][points]" value="<?php echo isset($scoring['poletime'][$i]['points']) ? $scoring['poletime'][$i]['points'] : 0; ?>" size="5" style="margin-bottom: 0.5em;margin-right:2em;" /><span><?php _e('Points', $this->name); echo "<br />" . $this->time_diffs(isset($scoring['poletime'][$i]['percent']) ? $scoring['poletime'][$i]['percent'] : 0); ?></span></td>
				</tr>
			<?php } ?>
			</table>
			<p class="submit" style="margin-left:1em;">
				<input type="button" id="motorracingleague_poletimetable_add" value="<?php _e( 'Add more...', $this->name ) ?>" />
				<input type="button" id="motorracingleague_poletimetable_remove" value="<?php _e( 'Remove last...', $this->name ) ?>" />
			</p>
			</fieldset>
			
			<fieldset style="padding-bottom:1em;border:1px solid #A6C9E2;margin-top:1em;padding-top:1em;">
			<span>
				<input <?php echo $disabled; ?> <?php echo $scoring['use_race_points'] ? ' checked ' : ''; ?> type="checkbox" name="<?php echo $this->pf;?>racepoints" id="<?php echo $this->pf;?>toggleinputs" value="1" style="margin-left: 1em" />
				<?php _e('Use race points', $this->name); ?>
				<?php echo $this->info('motorracingleague_racepoints'); ?>
			</span>
<?php 
			$disabled2 = '';
			if (!empty($disabled)) {
				$disabled2 = $disabled;
			} else {
				if ($scoring['use_race_points']) {
					$disabled2 = ' disabled ';
				}
			}
?>
			<table id="motorracingleague_inputs" class="form-table motorracingleague_wider">
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>polepoints"><?php _e( 'Pole', $this->name ) ?></label></th>
				<td><input <?php echo $disabled2; ?> type="text" name="<?php echo $this->pf;?>polepoints" id="<?php echo $this->pf;?>polepoints" value="<?php echo $scoring['pole']; ?>" size="5" style="margin-bottom: 0.5em;margin-right:2em;" /><span><?php _e('Points', $this->name); ?></span></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>fastestpoints"><?php echo $this->fl_label($this->options->get_predict_lapsled()); ?></label></th>
				<td><input <?php echo $disabled2; ?> type="text" name="<?php echo $this->pf;?>fastestpoints" id="<?php echo $this->pf;?>fastestpoints" value="<?php echo $scoring['fastest']; ?>" size="5" style="margin-bottom: 0.5em;margin-right:2em;" /><span><?php _e('Points', $this->name); ?></span></td>
			</tr>
			<?php for ($i = 0; $i < $numPredictions + $this->options->get_additional_race_results(); $i++) { ?>
				<tr valign="top">
					<th scope="row"><label for="<?php echo $this->pf;?>points<?php echo $i; ?>"><?php 
					
							if ($i == 0) _e( 'Driver in correct position', $this->name ); else _e("Driver finishes $i off position"); ?>
							
					</label><?php if ($i==0) echo $this->info('motorracingleague_correctposition'); ?></th>
					<td><input <?php echo $disabled2; ?> type="text" name="<?php echo $this->pf;?>points[<?php echo $i; ?>]" id="<?php echo $this->pf;?>points<?php echo $i; ?>" value="<?php echo isset($scoring['points'][$i]) ? $scoring['points'][$i] : '0'; ?>" size="5" style="margin-bottom: 0.5em;margin-right:2em;" /><span><?php _e('Points', $this->name); ?></span></td>
				</tr>
			<?php } ?>
			</table>
			</fieldset>
			
			<fieldset style="padding-bottom:1em;border:1px solid #A6C9E2;margin-top:1em;">
			<table class="form-table motorracingleague_wider">
			<?php for ($i = $numPredictions; $i > 1; $i--) { ?>
				<tr valign="top">
					<th scope="row"><label for="<?php echo $this->pf;?>bonus<?php echo $i; ?>"><?php 
					
							if ($i == ($numPredictions)) _e( 'Bonus points for correct finishing order', $this->name ); else _e("Bonus points for $i correct"); ?>
							
					</label></th>
					<td><input <?php echo $disabled; ?> type="text" name="<?php echo $this->pf;?>bonus[<?php echo $i; ?>]" id="<?php echo $this->pf;?>bonus<?php echo $i; ?>" value="<?php echo isset($scoring['bonus'][$i]) ? $scoring['bonus'][$i] : '0'; ?>" size="5" style="margin-bottom: 0.5em;margin-right:2em;" /><span><?php _e('Points', $this->name); ?></span></td>
				</tr>
			<?php } ?>
			</table>
			</fieldset>
			<fieldset style="padding-bottom:1em;border:1px solid #A6C9E2;margin-top:1em;">
			<table class="form-table motorracingleague_wider">
			
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>rainpoints"><?php _e( 'Rain', $this->name ) ?></label></th>
				<td><input <?php echo $disabled; ?> type="text" name="<?php echo $this->pf;?>rainpoints" id="<?php echo $this->pf;?>rainpoints" value="<?php echo $scoring['rain']; ?>" size="5" style="margin-bottom: 0.5em;margin-right:2em;" /><span><?php _e('Points', $this->name); ?></span></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>safety_carpoints"><?php _e( 'Safety Car', $this->name ) ?></label></th>
				<td><input <?php echo $disabled; ?> type="text" name="<?php echo $this->pf;?>safety_carpoints" id="<?php echo $this->pf;?>safety_carpoints" value="<?php echo $scoring['safety_car']; ?>" size="5" style="margin-bottom: 0.5em;margin-right:2em;" /><span><?php _e('Points', $this->name); ?></span></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>dnfpoints"><?php _e( 'DNF', $this->name ) ?></label></th>
				<td><input <?php echo $disabled; ?> type="text" name="<?php echo $this->pf;?>dnfpoints" id="<?php echo $this->pf;?>dnfpoints" value="<?php echo $scoring['dnf']; ?>" size="5" style="margin-bottom: 0.5em;margin-right:2em;" /><span><?php _e('Points', $this->name); ?></span></td>
			</tr>
			
			
			</table>
			</fieldset>
			<input type="hidden" name="<?php echo $this->pf;?>championship_id" value="<?php echo $championship_id; ?>" />
			<p class="submit"><input <?php echo $disabled; ?>  type="submit" name="<?php echo $this->pf;?>updateScore" value="<?php _e( 'Save Changes', $this->name ) ?>" class="button-primary" />
			<input type="submit" name="<?php echo $this->pf;?>cancelScore" value="<?php _e( 'Cancel', $this->name ) ?>" class="button" /></p>
		</form>
		
<?php 		
	}
	
	function time_diffs($percent) {
		
		$ex = '01:30.000';
		$a = $this->to_laptime($ex);
		$b = $a / 100 * $percent;
		
		$str1 = "$percent% " . __('of', $this->name) . " $ex = " . $this->from_laptime($b);
		
		return $str1;
	}
	
	/**
	 * Manage races
	 * 
	 * @param $championship_id Championship Id
	 * @return none
	 */
	function races($championship_id) {
		global $wpdb;
		
		$enable_qualify_by = true;
		
		$circuit = $race_start = $entry_by = $qualify_by = "";
		$race_id = -1;
		
		if (isset($_POST[$this->pf.'addRace'])) {
			check_admin_referer($this->pf . 'race-form');
			$circuit = $_POST[$this->pf.'circuit'];
			$race_start = $_POST[$this->pf.'race_start'];
			$entry_by = $_POST[$this->pf.'entry_by'];
			if (isset($_POST[$this->pf.'qualify_by'])) {
				$qualify_by = $_POST[$this->pf.'qualify_by'];
			}
			if ($this->addRace($circuit, $championship_id, $race_start, $entry_by, $qualify_by)) {
				$circuit = $race_start = $entry_by = $qualify_by = "";
				$race_id = -1;
			}
			$this->printMessage();
			$this->selectTab(2);
		}
		
		
		if (isset($_GET[$this->pf.'modifyraceid'])) {
			$race_id = $_GET[$this->pf.'modifyraceid'];
			$sql = 'SELECT circuit, race_start, entry_by, qualify_by FROM '.$wpdb->prefix.$this->pf.'race WHERE id = '.$race_id;
			$result = $wpdb->get_row( $sql , OBJECT );
			$circuit = $result->circuit;
			$race_start = $result->race_start;
			$entry_by = $result->entry_by;
			$qualify_by = $result->qualify_by;
			$this->selectTab(2);
		}
		
		if (isset($_POST[$this->pf.'modifyRace'])) {
			check_admin_referer($this->pf . 'race-form');
			$race_id = $_POST[$this->pf.'race_id'];
			$circuit = $_POST[$this->pf.'circuit'];
			$race_start = $_POST[$this->pf.'race_start'];
			$entry_by = $_POST[$this->pf.'entry_by'];
			if (isset($_POST[$this->pf.'qualify_by'])) {
				$qualify_by = $_POST[$this->pf.'qualify_by'];
			}
			if ($this->updateRace($race_id, $circuit, $race_start, $entry_by, $qualify_by) === true) {
				$circuit = $race_start = $entry_by = $qualify_by = "";
				$race_id = -1;
			}
			$this->printMessage();
			$this->selectTab(2);
		}
		
		if (isset($_POST[$this->pf.'cancelRace'])) {
			$this->selectTab(2);
		}
		
		if (isset($_POST[$this->pf.'deleteRace'])) {
			check_admin_referer($this->pf . 'list-race');
			if (isset($_POST[$this->pf.'race'])) {
				foreach ($_POST[$this->pf.'race'] as $id) {
					$this->deleteRace($id);
					$this->printMessage();
				}
			}
			$this->selectTab(2);
		}
		
?>
		
		<form action="<?php echo admin_url('admin.php?page=motorracingleague_championship&subpage=motorracingleague_participants'); ?>" method="post" class="form-table motorracingleague-form">
			<?php wp_nonce_field( $this->pf . 'race-form' ) ?>
			<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>circuit"><?php _e( 'Circuit', $this->name ) ?></label></th>
				<td><input type="text" name="<?php echo $this->pf;?>circuit" id="<?php echo $this->pf;?>circuit" value="<?php echo $circuit; ?>" size="20" style="margin-bottom: 1em;" /></td>
				<td><?php _e('Circuit is the name of the race track, e.g. Indianapolis, or, Italian Grand Prix - Monza', $this->name); ?></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>race_start"><?php _e( 'Race Start', $this->name ); ?></label></th>
				<td><input placeholder="YYYY-MM-DD HH:MM:SS" type="text" name="<?php echo $this->pf;?>race_start" id="<?php echo $this->pf;?>race_start" value="<?php echo $race_start; ?>" size="20" style="margin-bottom: 1em;" /></td>
				<td><?php _e('Race Start is the race start date and time based on <strong>server time</strong>.', $this->name); ?></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>entry_by"><?php _e( 'Entries By', $this->name ); ?></label></th>
				<td><input placeholder="YYYY-MM-DD HH:MM:SS" type="text" name="<?php echo $this->pf;?>entry_by" id="<?php echo $this->pf;?>entry_by" value="<?php echo $entry_by; ?>" size="20" style="margin-bottom: 1em;" /></td>
				<td><?php _e('Entries By is the date and time, <strong>server time</strong>, before when a player must predict their finishing results.', $this->name); ?></td>
			</tr>
			
<?php if ($enable_qualify_by) { ?>			
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>qualify_by"><?php _e( 'Qualify By (optional)', $this->name ); ?></label></th>
				<td><input placeholder="YYYY-MM-DD HH:MM:SS" type="text" name="<?php echo $this->pf;?>qualify_by" id="<?php echo $this->pf;?>qualify_by" value="<?php echo $qualify_by; ?>" size="20" style="margin-bottom: 1em;" /></td>
				<td><?php _e('Qualify By is the date and time, <strong>server time</strong>, before when a player must predict their Pole Time and Pole driver. Only applies if users must be logged in to predict.', $this->name); ?></td>
			</tr>
<?php } ?>
			</table>

<?php if ($enable_qualify_by) { ?>			
			
			<table style="table-layout:fixed; border-collapse: collapse; background-color: lightgrey; border: 1px solid black; margin:1em 0; padding:0">
			<caption><strong><?php _e('Entering a value for Qualify By allows logged in users to change their predictions for the race after qualifying has finished but before the start of the race (Entries By). Leave Qualify By blank to require that all predictions are entered before the Entries By deadline.', $this->name); ?></strong></caption>
			<tr><td colspan="5"><?php _e('Time &hellip; &hellip; &hellip;', $this->name); ?></td></tr>
			<tr>
				<td style="border-top: 1px solid black; background-color: #5FFB17;"><?php _e( 'Users can predict Pole, Pole Time and Race Results', $this->name ); ?></td>
				<td style="background-color: lightgrey;"><strong><?php _e( 'Qualify By', $this->name ); ?></strong></td>
				<td style="background-color: #FFFF32;"><?php _e('Users can modify Race Predictions (Pole and Pole Time is locked)', $this->name); ?></td>
				<td style="background-color: lightgrey;"><strong><?php _e( 'Entries By', $this->name ); ?></strong></td>
				<td style="background-color: #FF6464;"><?php _e( 'Predictions not allowed', $this->name ); ?></td>
			</tr>
			</table>
<?php } ?>			
			
			<input type="hidden" name="<?php echo $this->pf;?>championship_id" value="<?php echo $championship_id; ?>" />
			<?php if ($race_id == -1) { ?>
				<p class="submit"><input type="submit" name="<?php echo $this->pf;?>addRace" value="<?php _e( 'Add Race', $this->name ) ?>" class="button-primary" /></p>
			<?php } else { ?>
				<input type="hidden" name="<?php echo $this->pf;?>race_id" value="<?php echo $race_id; ?>" />
				<p class="submit"><input type="submit" name="<?php echo $this->pf;?>modifyRace" value="<?php _e( 'Update Race', $this->name ) ?>" class="button-primary" />
				<input type="submit" name="<?php echo $this->pf;?>cancelRace" value="<?php _e( 'Cancel', $this->name ) ?>" class="button" /></p>
			<?php } ?>
		</form>
		
		<p class="updated"><?php _e('The current server time is ', $this->name); ?><strong><?php echo $this->getServerDateTime(); ?></strong> <?php _e('If this is different from race local time then
		you must make an adjustment for the difference. If you do not then players may be able to enter predictions after knowing the result of a race.
		Don\'t forget daylight savings times in other time zones.', $this->name); ?></p>
		
		
		<form name="listrace" method="post" action="">
		<?php wp_nonce_field( $this->pf . 'list-race' ) ?>
		<input type="hidden" name="<?php echo $this->pf;?>championship_id" value="<?php echo $championship_id; ?>" />
		<table class="motorracingleague"><thead>
		<tr>
			<th scope="col"><?php _e('Delete', $this->name ) ?></th>
			<th scope="col"><?php _e('ID', $this->name ) ?></th>
			<th scope="col"><?php _e('Circuit', $this->name ) ?></th>
			<th scope="col"><?php _e('Race Start', $this->name ) ?></th>
			<th scope="col"><?php _e('Entries By', $this->name ) ?></th>
<?php if ($enable_qualify_by) { ?>			<th scope="col"><?php _e('Qualify By', $this->name ) ?></th> <?php } ?>
			</tr></thead>
		<tbody>
<?php
		$sql = 'SELECT id,circuit,race_start, entry_by, qualify_by FROM '.$wpdb->prefix.$this->pf.'race WHERE championship_id = '.$championship_id.' ORDER BY race_start;';
		$result = $wpdb->get_results( $sql , OBJECT );
		foreach ($result as $row) {
			echo '<tr><td><input type="checkbox" value="'.$row->id.'" name ="'.$this->pf.'race['.$row->id.']"/></td>';
			echo '<td><a title="'.__('Modify this race',$this->name).'" href="'.admin_url('admin.php').'?page='.$this->pf.'championship'.'&amp;'.$this->pf.'championship_id='.$championship_id.'&amp;subpage='.$this->pf.'participants&amp;'.$this->pf.'modifyraceid='.$row->id.'">'.$row->id.'</a></td>';
			echo '<td>'.$row->circuit.'</td><td>'.$row->race_start.'</td><td>'.$row->entry_by .'</td>';
if ($enable_qualify_by) {	echo '<td>'.$row->qualify_by . '</td>'; }
			echo "</tr>";
		}
?>
		</tbody>
		</table>		
		<input type="submit" name="<?php echo $this->pf; ?>deleteRace" value="<?php _e( 'Delete Selected', $this->name); ?>" class="button" />
		</form>

<?php 		
	}
	
	
	/**
	 * Manage drivers
	 * 
	 * @param $championship_id - Championship Id
	 * @return none
	 */
	function drivers($championship_id) {
		global $wpdb;
		
		$name = $shortcode = '';
		$driver_id = -1;
		
		if (isset($_POST[$this->pf.'addDriver'])) {
			check_admin_referer($this->pf . 'driver-form');
			$name = $_POST[$this->pf.'name'];
			$shortcode = $_POST[$this->pf.'shortcode'];
			if ($this->addParticipant($shortcode, $name, $championship_id)) {
				$name = $shortcode = '';
				$driver_id = -1;
			}
			$this->printMessage();
			$this->selectTab(1);
		}
		
		if (isset($_GET[$this->pf.'modifydriverid'])) {
			$driver_id = $_GET[$this->pf.'modifydriverid'];
			$sql = 'SELECT shortcode, name FROM '.$wpdb->prefix.$this->pf.'participant WHERE id = '.$driver_id;
			$result = $wpdb->get_row( $sql , OBJECT );
			$shortcode = $result->shortcode;
			$name = $result->name;		
			$this->selectTab(1);
		}
		
		if (isset($_POST[$this->pf.'modifyDriver'])) {
			check_admin_referer($this->pf . 'driver-form');
			$name = $_POST[$this->pf.'name'];
			$shortcode = $_POST[$this->pf.'shortcode'];
			$driver_id = $_POST[$this->pf.'driver_id'];
			if ($this->updateParticipant($driver_id, $shortcode, $name) === true) {
				$name = $shortcode = '';
				$driver_id = -1;
			}
			$this->printMessage();
			$this->selectTab(1);
		}
		
		if (isset($_POST[$this->pf.'cancelDriver'])) {
			$this->selectTab(1);
		}
		
		if (isset($_POST[$this->pf.'deleteDriver'])) {
			check_admin_referer($this->pf . 'list-driver');
			if (isset($_POST[$this->pf.'driver'])) {
				foreach ($_POST[$this->pf.'driver'] as $id) {
					$this->deleteParticipant($id);
					$this->printMessage();
				}
			}
			$this->selectTab(1);
		}

?>		
		<form action="<?php echo admin_url('admin.php?page=motorracingleague_championship&subpage=motorracingleague_participants'); ?>" method="post" class="form-table motorracingleague-form">
			<?php wp_nonce_field( $this->pf . 'driver-form' ) ?>
			<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>shortcode"><?php _e( 'Shortcode', $this->name ) ?></label></th>
				<td><input type="text" name="<?php echo $this->pf;?>shortcode" id="<?php echo $this->pf;?>shortcode" value="<?php echo $shortcode; ?>" size="10" style="margin-bottom: 1em;" /></td>
				<td><?php _e('Shortcode is a short name for the driver, e.g. MSC', $this->name ) ?></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>name"><?php _e( 'Name', $this->name ) ?></label></th>
				<td><input type="text" name="<?php echo $this->pf;?>name" id="<?php echo $this->pf;?>name" value="<?php echo $name; ?>" size="30" style="margin-bottom: 1em;" /></td>
				<td><?php _e('Name is the driver\'s name, e.g. Michael Schumacher, or Schumacher, Michael', $this->name ) ?></td>
			</tr>
			</table>
			<input type="hidden" name="<?php echo $this->pf;?>championship_id" value="<?php echo $championship_id; ?>" />
			<?php if ($driver_id == -1) { ?>
				<p class="submit"><input type="submit" name="<?php echo $this->pf;?>addDriver" value="<?php _e( 'Add Driver', $this->name ) ?>" class="button-primary" /></p>
			<?php } else { ?>
				<input type="hidden" name="<?php echo $this->pf;?>driver_id" value="<?php echo $driver_id; ?>" />
				<p class="submit"><input type="submit" name="<?php echo $this->pf;?>modifyDriver" value="<?php _e( 'Update Driver', $this->name ) ?>" class="button-primary" />
 				   <input type="submit" name="<?php echo $this->pf;?>cancelDriver" value="<?php _e( 'Cancel', $this->name ) ?>" class="button" /></p>
			<?php } ?>
		</form>
		
		<form name="listdriver" method="post" action="">
		<?php wp_nonce_field( $this->pf . 'list-driver' ) ?>
		<input type="hidden" name="<?php echo $this->pf;?>championship_id" value="<?php echo $championship_id; ?>" />
		<table class="motorracingleague"><thead>
		<tr>
			<th scope="col"><?php _e('Delete', $this->name) ?></th>
			<th scope="col"><?php _e('ID', $this->name) ?></th>
			<th scope="col"><?php _e('Short Code', $this->name) ?></th>
			<th scope="col"><?php _e('Name', $this->name) ?></th>
		</tr></thead>
		<tbody>
<?php
		$sql = 'SELECT id,shortcode,name FROM '.$wpdb->prefix.$this->pf.'participant WHERE championship_id = '.$championship_id.' ORDER BY id;';
		$result = $wpdb->get_results( $sql , OBJECT );
		foreach ($result as $row) {
			echo '<tr><td><input type="checkbox" value="'.$row->id.'" name ="'.$this->pf.'driver['.$row->id.']"/></td>';
			echo '<td><a title="'.__('Modify this driver',$this->name).'" href="'.admin_url('admin.php').'?page='.$this->pf.'championship'.'&amp;'.$this->pf.'championship_id='.$championship_id.'&amp;subpage='.$this->pf.'participants&amp;'.$this->pf.'modifydriverid='.$row->id.'">'.$row->id.'</a></td>';
			echo '<td>'.$row->shortcode.'</td><td>'.$row->name;
			echo "</td></tr>";
		}
?>
		</tbody>
		</table>		
		<input type="submit" name="<?php echo $this->pf; ?>deleteDriver" value="<?php _e( 'Delete Selected', $this->name ); ?>" class="button" />
		</form>

<?php 
	}
	
	
	/**
	 * Adds a championship to the database
	 * 
	 * @return insert database id  or -1 if error
	 */
	function addChampionship() {
		global $wpdb;
		$id = -1;
		$options = new MotorRacingLeagueOptions();

		$season = $_POST[$this->pf.'season'];
		$description = $_POST[$this->pf.'description'];
		$num_predictions = $_POST[$this->pf.'numpredictions'];
		$calculator = $_POST[$this->pf.'calculator'];
		
		if (empty($season) || empty($description) || empty($num_predictions)) {
			$this->setMessage(__("Please supply all fields", $this->name), true);
			return -1;
		}
		
		if (!is_numeric($num_predictions)) {
			$this->setMessage(__("Number of Predictions must be a number", $this->name), true);
			return -1;
		}
				
		if ($wpdb->query( $wpdb->prepare( "
				INSERT INTO ".$wpdb->prefix.$this->pf."championship
				(season, description, num_predictions, calculator, options)
				VALUES ( %s, %s, %d, %s, %s )", 
				$season, $description, $num_predictions, $calculator, $options->get() ) ) ) {
		
			$id = $wpdb->insert_id;
			$this->setMessage(__("Added Championship", $this->name));
		} else {
			$this->setMessage($wpdb->last_error, true);
		}
		
		return $id;
	}
	
	/**
	 * Updates a championship to the database
	 * 
	 * @param $championship_id championship id
	 * @param $season Championship season name, e.g. 2009
	 * @param $description Long description of championship
	 * @param $calculator PHP filename of the points calculator function
	 */
	function updateChampionship($championship_id, $season, $description, $num_predictions, $calculator) {
		global $wpdb;
		
		if (empty($season) || empty($description)) {
			$this->setMessage(__("Please supply all fields", $this->name), true);
			return -1;
		}
		
		$ret = $wpdb->query( $wpdb->prepare( "
				UPDATE ".$wpdb->prefix.$this->pf."championship
				SET season = %s, description = %s, calculator = %s, num_predictions = %d
				WHERE id = %d", 
				$season, $description, $calculator, $num_predictions, $championship_id ) );

		if (is_bool($ret) && !$ret) {
			$this->setMessage($wpdb->last_error, true);
		} else {
			$this->setMessage(__("Updated Championship", $this->name));
		}
	}
	
	/**
	 * Deletes a championship from the database
	 * 
	 * @param $id championship id
	 * @return none
	 */
	function deleteChampionship($id) {
		global $wpdb;
		
		$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}{$this->pf}participant WHERE championship_id = %d";
		$count = $wpdb->get_var($wpdb->prepare($sql, $id));
		if (!$count) {
			$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}{$this->pf}participant WHERE championship_id = %d";
			$count = $wpdb->get_var($wpdb->prepare($sql, $id));
		}
		
		if ($count) {
			$this->setMessage(__("Can not delete a Championship with Races or Participants", $this->name), true);
			return false;
		}
		
		
		if ($wpdb->query( $wpdb->prepare( "
				DELETE FROM ".$wpdb->prefix.$this->pf."championship
					WHERE id=%d", 
					$id ) ) ) {
		
			$this->setMessage(__("Deleted Championship", $this->name));
		} else {
			$this->setMessage($wpdb->last_error, true);
		}
	}
	
	/**
	 * Create a driver/rider for a championship
	 * 
	 * @param $shortcode drivers code, e.g. MSC
	 * @param $name drivers name, e.g. Michael Schumacher
	 * @param $champ_id will participate in this championship.
	 * @return insert database id  or -1 if error
	 */
	function addParticipant($shortcode, $name, $champ_id) {
		global $wpdb;
		$id = -1;
		
		if (empty($shortcode) || empty($name) || empty($champ_id)) {
			$this->setMessage(__("Please supply all fields", $this->name), true);
			return false;
		}
		
		if ($wpdb->query( $wpdb->prepare( "
				INSERT INTO ".$wpdb->prefix.$this->pf."participant
				(shortcode, name, championship_id)
				VALUES ( %s, %s, %d )", 
				$shortcode, $name , (int)$champ_id) ) ) {
		
			$id = $wpdb->insert_id;
			$this->setMessage(__("Added Championship Participant", $this->name));
		} else {
			$this->setMessage($wpdb->last_error, true);
			return false;
		}
		
		return $id;
	}
	
	function copyDrivers($old_champ_id, $new_champ_id) {
		global $wpdb;
		
		if ($old_champ_id == -1) {
			$this->setMessage(__("Please supply all fields", $this->name), true);
			return -1;
		}
		
		$sql = "INSERT INTO ".$wpdb->prefix.$this->pf."participant
				(shortcode, name, championship_id)
					SELECT p2.shortcode, p2.name, %d FROM {$wpdb->prefix}{$this->pf}participant p2
					WHERE p2.championship_id = %d AND NOT EXISTS
						(SELECT * FROM {$wpdb->prefix}{$this->pf}participant p3
							WHERE p3.shortcode = p2.shortcode AND p3.name=p2.name AND p3.championship_id=%d)";
		
		if ($wpdb->query( $wpdb->prepare( $sql, (int)$new_champ_id, (int)$old_champ_id, (int)$new_champ_id )) !== false) {
			$this->setMessage(__("Copied drivers", $this->name));
		} else {
			$this->setMessage($wpdb->last_error, true);
		}
		
		return true;
	}
	
	/**
	 * Modify a driver/rider for a championship
	 * 
	 * @param $participant_id id of driver who will participate in this championship.
	 * @param $shortcode drivers code, e.g. MSC
	 * @param $name drivers name, e.g. Michael Schumacher
	 * @return true success, false failure
	 */
	function updateParticipant($participant_id, $shortcode, $name) {
		global $wpdb;
		
		if (empty($shortcode) || empty($name) || empty($participant_id)) {
			$this->setMessage(__("Please supply all fields", $this->name), true);
			return false;
		}
		
		if ($wpdb->query( $wpdb->prepare( "
				UPDATE ".$wpdb->prefix.$this->pf."participant
				SET shortcode=%s, name=%s WHERE id=%d", 
				$shortcode, $name , (int)$participant_id) ) === false) {
		
			$this->setMessage($wpdb->last_error, true);
			return false;
		} else {
			$this->setMessage(__("Updated Championship Participant", $this->name));
		}
		
		return true;
	}
	
	/**
	 * Delete a driver/rider from the database
	 * @param $id - driver/participant id
	 * @return none
	 */
	function deleteParticipant($id) {
		global $wpdb;
		
		$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}{$this->pf}result WHERE participant_id = %d";
		$count = $wpdb->get_var($wpdb->prepare($sql, $id));
		if (!$count) {
			$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}{$this->pf}prediction WHERE participant_id = %d";
			$count = $wpdb->get_var($wpdb->prepare($sql, $id));
		}
		
		if ($count) {
			$this->setMessage(__("Can not delete a Participant with Results or Predictions", $this->name), true);
			return false;
		}
		
		if ($wpdb->query( $wpdb->prepare( "
				DELETE FROM ".$wpdb->prefix.$this->pf."participant
					WHERE id=%s", 
					$id ) ) ) {
		
			$this->setMessage(__("Deleted Participant", $this->name));
		} else {
			$this->setMessage($wpdb->last_error, true);
		}
	}
	
	/**
	 * Create a race for participants in a championship
	 * 
	 * @param $circuit name of racetrack
	 * @param $champ_id championship id
	 * @param $race_start race start time
	 * @param $entry_by player entries must be before this time.
	 * @return insert database id  or -1 if error
	 */
	function addRace($circuit, $champ_id, $race_start, $entry_by, $qualify_by) {
		global $wpdb;
		$id = -1;
		
		if (empty($circuit) || empty($race_start) || empty($entry_by) || empty($champ_id)) {
			$this->setMessage(__("Please supply all fields", $this->name), true);
			return false;
		}
		
		if (!$this->is_datetime($race_start) || !$this->is_datetime($entry_by)) {
			$this->setMessage(__("Date/time must be YYYY-MM-DD HH:MM:SS", $this->name), true);
			return false;
		}
		
		if (!empty($qualify_by) && !$this->is_datetime($qualify_by)) {
			$this->setMessage(__("Qualify By must be YYYY-MM-DD HH:MM:SS or leave blank", $this->name), true);
			return false;
		}
		
		// OK to string compare ISO dates
		if (!empty($qualify_by) && $qualify_by > $entry_by) {
			$this->setMessage(__("Qualify By must be earlier than Entry By or left blank", $this->name), true);
			return false;
		}
		
		$ret = false;
		if (empty($qualify_by)) {
			// Shitty NULL handling by WP !
			$ret = $wpdb->query( $wpdb->prepare( "
					INSERT INTO ".$wpdb->prefix.$this->pf."race
					(circuit, championship_id, race_start, entry_by)
					VALUES ( %s, %d, %s, %s )",
					$circuit, (int)$champ_id, $race_start, $entry_by ) );
		} else {
			$ret = $wpdb->query( $wpdb->prepare( "
					INSERT INTO ".$wpdb->prefix.$this->pf."race
					(circuit, championship_id, race_start, entry_by, qualify_by)
					VALUES ( %s, %d, %s, %s, %s )",
					$circuit, (int)$champ_id, $race_start, $entry_by, $qualify_by ) );
		}
			
			
		if ($ret) {
			$id = $wpdb->insert_id;
			$this->setMessage(__("Added Race", $this->name));
		} else {
			$this->setMessage($wpdb->last_error, true);
			return false;
		}
		
		return $id;
	}
	
	/**
	 * Update a race for participants in a championship
	 * 
	 * @param $race_id id of race
	 * @param $circuit name of racetrack
	 * @param $race_start race start time
	 * @param $entry_by player entries must be before this time.
	 * @return true success, false failure
	 */
	function updateRace($race_id, $circuit, $race_start, $entry_by, $qualify_by) {
		global $wpdb;
		
		if (empty($circuit) || empty($race_start) || empty($entry_by) || empty($race_id)) {
			$this->setMessage(__("Please supply all fields", $this->name), true);
			return false;
		}
		
		if (!$this->is_datetime($race_start) || !$this->is_datetime($entry_by)) {
			$this->setMessage(__("Date/time must be YYYY-MM-DD HH:MM:SS", $this->name), true);
			return false;
		}
		
			if (!empty($qualify_by) && !$this->is_datetime($qualify_by)) {
			$this->setMessage(__("Qualify By must be YYYY-MM-DD HH:MM:SS or leave blank", $this->name), true);
			return false;
		}
		
		// OK to string compare ISO dates
		if (!empty($qualify_by) && $qualify_by > $entry_by) {
			$this->setMessage(__("Qualify By must be earlier than Entry By or left blank", $this->name), true);
			return false;
		}
		
		$ret = false;
		if (empty($qualify_by)) {
			$ret = $wpdb->query( $wpdb->prepare( "
				UPDATE ".$wpdb->prefix.$this->pf."race
				SET circuit=%s, race_start=%s, entry_by=%s, qualify_by = NULL WHERE id=%d", 
				$circuit, $race_start, $entry_by, (int)$race_id ) );
		} else {
			$ret = $wpdb->query( $wpdb->prepare( "
				UPDATE ".$wpdb->prefix.$this->pf."race
				SET circuit=%s, race_start=%s, entry_by=%s, qualify_by=%s WHERE id=%d", 
				$circuit, $race_start, $entry_by, $qualify_by, (int)$race_id ) );
		}
		if ($ret === false) {
		
			$this->setMessage($wpdb->last_error, true);
			return false;
		} else {
			$this->setMessage(__("Updated Race", $this->name));
		}
		
		return true;
	}
	
	/**
	 * Delete a race from the database
	 * 
	 * @param $raceid - race id
	 * @return none
	 */
	function deleteRace($raceid) {
		global $wpdb;
		
		$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}{$this->pf}entry WHERE race_id = %d";
		$count = $wpdb->get_var($wpdb->prepare($sql, $raceid));
		if (!$count) {
			$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}{$this->pf}result WHERE race_id = %d";
			$count = $wpdb->get_var($wpdb->prepare($sql, $raceid));
		}
		
		if ($count) {
			$this->setMessage(__("Can not delete a Race with Results or Predictions", $this->name), true);
			return false;
		}
		
		if ($wpdb->query( $wpdb->prepare( "
				DELETE FROM ".$wpdb->prefix.$this->pf."race
					WHERE id=%d", 
					$raceid ) ) ) {
		
			$this->setMessage(__("Deleted Race", $this->name));
		} else {
			$this->setMessage($wpdb->last_error, true);
		}
	}
	
	/**
	 * Return a list of defined championships
	 * 
	 * @param $select_champ_id id to preselect option.
	 * @return html string <select></select>
	 */
	function getChampionships($select_champ_id, $disabled='') {
		global $wpdb;
		
		$sql = 'SELECT id,season,description FROM '.$wpdb->prefix.$this->pf.'championship ORDER BY id;';
		$champ = $wpdb->get_results( $sql , OBJECT );
		$output = '<select '.$disabled.' name="mrl_championship" id="mrl_championship"><option value="-1"></option>';
		foreach ($champ as $row) {
			$output .= '<option ';
			if (isset($select_champ_id) && $row->id == $select_champ_id) {
				$output .= ' selected ';
			}
			$output .= 'value="'.$row->id.'">'.$row->season.' - '.$row->description;
			$output .= "</option>\n";
		}
		$output .= "</select>\n";
							
		return $output;
	}

	/**
	 * Return the number of defined championships.
	 * 
	 * @return unknown_type
	 */
	function getNumChampionships() {
		global $wpdb;
		
		$sql = 'SELECT count(*) as "num" FROM '.$wpdb->prefix.$this->pf.'championship';
		$result = $wpdb->get_row( $sql , OBJECT );
		return $result->num;
		
	}
	
	/**
	 * Get the PHP filename of the calculator function
	 * 
	 * @param $champid Championship id
	 * @return string filename
	 */
	function getChampionshipCalculator($champid) {
		global $wpdb;
		
		$sql = 'SELECT calculator FROM '.$wpdb->prefix.$this->pf.'championship WHERE id = '.$champid.';';
		$result = $wpdb->get_row( $sql , OBJECT );
	    
		return $result->calculator;			
	}
			
	/**
	 * Display the results of a race.
	 * 
	 * @param $champid Championship id
	 * @return html string.
	 */
	function getResults($champid) {
		global $wpdb;
		
		$numPredictions = (int)$this->getChampionshipNumPredictions($champid);
		$numPredictions += $this->options->get_additional_race_results();
		$sql = 'SELECT p.name AS pname, pole_lap_time, r.id as "id", r.circuit as "circuit", p.shortcode as "shortcode",
					res.position as "position", r.rain, r.safety_car, r.dnf FROM '
			.$wpdb->prefix.$this->pf.'participant p, '
			.$wpdb->prefix.$this->pf.'race r, '
			.$wpdb->prefix.$this->pf.'championship c, '
			.$wpdb->prefix.$this->pf.'result res  WHERE c.id = '.$champid. 
			' AND r.championship_id = c.id AND r.id = res.race_id AND res.participant_id = p.id 
				ORDER BY r.race_start, position';
		
		$res = $wpdb->get_results( $sql , OBJECT );
		$output = '<table class="motorracingleague"><thead>
		<tr>
			<th scope="col"></th>
			<th scope="col">'.__('Select', $this->name).'</th>
			<th scope="col">'.__('Id', $this->name).'</th>';
		if ($this->options->get_predict_rain()) {
			$output .= '<th scope="col">'.__('Rain', $this->name).'</th>';
		}
		if ($this->options->get_predict_safety_car()) {
			$output .= '<th scope="col">'.__('SC', $this->name).'</th>';
		}
		if ($this->options->get_predict_dnf()) {
			$output .= '<th scope="col">'.__('DNF', $this->name).'</th>';
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
			$output .= '<th scope="col">'.$i.'.</th>';
		}
		$output .= '</tr></thead>
		<tbody>';
		
		/*
		 * SQL returns rows grouped by circuit.
		 */
		$lcircuit = '';
		$newrow = false;
		foreach ($res as $row) {
			if ($lcircuit != $row->circuit) {
				if ($newrow) {
					$output .= "</tr>\n";
				}
				$output .= "<tr><th scope='row'>$row->circuit</th>\n";
				$output .= '<td><input type="checkbox" value="'.$row->id.'" name ="'.$this->pf.'result['.$row->id.']"/></td>';
				$output .= '<td><a title="'.__('Modify this race result',$this->name).'" href="'.admin_url('admin.php').'?page='.$this->pf.'results&amp;'.$this->pf.'modifyresultid='.$row->id.'&amp;'.$this->pf.'champid='.$champid.'">'.$row->id."</a></td>\n";
				if ($this->options->get_predict_rain()) {
					$output .= '<td>'.$this->tick($row->rain).'</td>';
				}
				if ($this->options->get_predict_safety_car()) {
					$output .= '<td>'.$this->tick($row->safety_car).'</td>';
				}
				if ($this->options->get_predict_dnf()) {
					$output .= '<td>'.$row->dnf.'</td>';
				}
				if ($this->options->get_predict_pole_time()) {
					$output .= "<td>".$this->from_laptime($row->pole_lap_time)."</td>\n";
				}
				$output .= "<td title='$row->pname'>$row->shortcode</td>\n";
				$lcircuit = $row->circuit;
			} else {
				$output .= "<td title='$row->pname'>$row->shortcode</td>\n";
				$newrow = true;
			}
			
		}
		
		$output .= '</tr></tbody></table>';
		
		return $output;
	}
	
	/**
	 * Save the results to the database.
	 * 
	 * @param $champid championship id
	 * @param $raceid race id
	 * @param $drivers array of driver(participant) ids. 0 = pole, 1..n positions 1..n
	 * @param $points array of race points
	 * @return none
	 */
	function saveResults($raceid, $drivers, $pole_lap_time, $pole_lap_time_points, $points, $rain, $safety_car, $dnf) {
		global $wpdb;
		
		if (in_array(-1, $drivers)) {
			$this->setMessage(__("Please select all options", $this->name), true);
			return false;
		}
		
		foreach ($points as $p) {
			if (!is_numeric($p)) {
				$this->setMessage(__("Points must be numeric", $this->name), true);
				return false;
			}
		}
		if (!is_numeric($pole_lap_time_points)) {
			$this->setMessage(__("Points must be numeric", $this->name), true);
			return false;
		}
		
		if ($this->options->get_predict_pole_time() && !$this->is_laptime($pole_lap_time)) {
			$this->setMessage(__("Lap time must be MM:SS.ccc format", $this->name), true);
			return false;
		}
		
		$pole = $this->to_laptime($pole_lap_time);
		
		$d = $drivers;
		if (isset($d[0])) unset($d[0]); // Remove pole
		if (isset($d[-1])) unset($d[-1]); // Remove fastest
		$unique_drivers = array_unique($d);
		if (count($d) > count($unique_drivers)) {
			$this->setMessage(__("Duplicate drivers", $this->name), true);
			return false;
		}
		
		/*
		 * Finally we can consider saving our results.
		 */
		if ($raceid == -1) {
			$this->setMessage(__("No race or championship selected", $this->name), true);
			return false;
		}
		
		$sql = "UPDATE {$wpdb->prefix}{$this->pf}race
				SET pole_lap_time = %d, pole_lap_time_points = %d,
					rain = %d, safety_car = %d, dnf = %d
				WHERE id = %d";
		$ret = $wpdb->query($wpdb->prepare($sql, $pole, $pole_lap_time_points, $rain, $safety_car, $dnf, $raceid));
		if ($ret === false) {
			$this->setMessage($wpdb->last_error, true);
			return false;
		}
		
		foreach ($drivers as $i=>$d) {
			if (!$wpdb->query( $wpdb->prepare( "
					INSERT INTO ".$wpdb->prefix.$this->pf."result
					(race_id, participant_id, position, race_points)
					VALUES ( %d, %d, %d, %d )", 
					(int)$raceid, (int)$drivers[$i], (int)$i, (int)$points[$i] ) ) ) {
			
				$this->setMessage($wpdb->last_error, true);
				return false;
			}
		}
		$this->setMessage(__("Race results saved. Check 'predictions' option for player prediction results", $this->name));
		return true;
	}
	
	/**
	 * Save the results to the database.
	 * 
	 * @param $champid championship id
	 * @param $raceid race id
	 * @param $drivers array of driver(participant) ids. 0 = pole, 1..n positions 1..n
	 * @param $points array of race points
	 * @return none
	 */
	function updateResult($raceid, $drivers, $pole_lap_time, $pole_lap_time_points, $points, $rain, $safety_car, $dnf) {
		global $wpdb;
		
		if (in_array(-1, $drivers)) {
			$this->setMessage(__("Please select all options", $this->name), true);
			return false;
		}
		
		foreach ($points as $p) {
			if (!is_numeric($p)) {
				$this->setMessage(__("Points must be numeric", $this->name), true);
				return false;
			}
		}
		if (!is_numeric($pole_lap_time_points)) {
			$this->setMessage(__("Points must be numeric", $this->name), true);
			return false;
		}
		
		if ($this->options->get_predict_pole_time() && !$this->is_laptime($pole_lap_time)) {
			$this->setMessage(__("Lap time must be MM:SS.ccc format", $this->name), true);
			return false;
		}
		$pole = $this->to_laptime($pole_lap_time);
		
		$d = $drivers;
		if (isset($d[0])) unset($d[0]); // Remove pole
		if (isset($d[-1])) unset($d[-1]); // Remove fastest
		$unique_drivers = array_unique($d);
		if (count($d) > count($unique_drivers)) {
			$this->setMessage(__("Duplicate drivers", $this->name), true);
			return false;
		}
		
		/*
		 * Finally we can consider saving our results.
		 */
		if ($raceid == -1) {
			$this->setMessage(__("No race or championship selected", $this->name), true);
			return false;
		}

		$sql = "UPDATE {$wpdb->prefix}{$this->pf}race
				SET pole_lap_time = %d, pole_lap_time_points = %d,
					rain = %d, safety_car = %d, dnf = %d
				WHERE id = %d";
		$ret = $wpdb->query($wpdb->prepare($sql, $pole, $pole_lap_time_points, $rain, $safety_car, $dnf, $raceid));
		if ($ret === false) {
			$this->setMessage($wpdb->last_error, true);
			return false;
		}
		
		foreach ($drivers as $i=>$d) {
			if ($wpdb->query( $wpdb->prepare( "
					UPDATE ".$wpdb->prefix.$this->pf."result
					SET participant_id = %d, race_points = %d WHERE race_id=%d AND position=%d", 
					(int)$drivers[$i], (int)$points[$i], (int)$raceid, (int)$i ) ) === false)
			{
				$this->setMessage($wpdb->last_error, true);
				return false;
			}
		}
		$this->setMessage(__("Race results updated. Check 'predictions' option for player prediction results", $this->name));
		return true;
	}
	
	/**
	 * Delete a race result
	 * 
	 * @param $race_id Race id
	 * @return none
	 */
	function deleteResult($race_id) {
		global $wpdb;
		
		if ($wpdb->query( $wpdb->prepare( "
				DELETE FROM ".$wpdb->prefix.$this->pf."result
					WHERE race_id=%s", 
					$race_id ) ) ) {
			$wpdb->query( $wpdb->prepare( "
				UPDATE ".$wpdb->prefix.$this->pf."entry SET points = 0, `when` = `when`
					WHERE race_id=%s", 
					$race_id ) );
			$this->setMessage(__("Deleted Result", $this->name));
		} else {
			$this->setMessage($wpdb->last_error, true);
		}
	}
	
	/**
	 * Delete a prediction entry.
	 * 
	 * @param $entry_id Entry id
	 * @return none
	 */
	function deleteEntry($entry_id) {
		global $wpdb;
		
		if ($wpdb->query( $wpdb->prepare( "
				DELETE FROM ".$wpdb->prefix.$this->pf."prediction
					WHERE entry_id=%s", 
					$entry_id ) ) ) {
			if ($wpdb->query( $wpdb->prepare( "
					DELETE FROM ".$wpdb->prefix.$this->pf."entry
						WHERE id=%s", 
						$entry_id ) ) ) {
				$this->setMessage(__("Deleted Entry", $this->name));
			} else {
				$this->setMessage($wpdb->last_error, true);
			}
		} else {
			$this->setMessage($wpdb->last_error, true);
		}
	}
	
	/**
	 * Get the finishing positions of the drivers in this race.
	 * 
	 * @param $raceid Race it
	 * @return array of driver ids, positions and points scored
	 */
	function getDriverPositions($raceid) {
		global $wpdb;
		$drivers = array();
		
		/*
		 * Get the finishing positions of the drivers in this race.
		 */
		$sql = 'SELECT race_points, position, participant_id FROM '.$wpdb->prefix.$this->pf.'result WHERE race_id = '.$raceid.' ORDER BY position';
		$result = $wpdb->get_results( $sql , OBJECT );
		foreach ($result as $driver) {
			$drivers[(int)$driver->position] = array('id'=>(int)$driver->participant_id, 'points'=>(int)$driver->race_points);
		}
		$sql = 'SELECT pole_lap_time, pole_lap_time_points, rain, safety_car, dnf FROM '.$wpdb->prefix.$this->pf.'race WHERE id = '.$raceid;
		$row = $wpdb->get_row( $sql , OBJECT );
		$drivers['pole_lap_time'] = array('id'=>(int)$row->pole_lap_time, 'points'=>(int)$row->pole_lap_time_points);
		$drivers['rain'] = array('id'=>(int)$row->rain, 'points'=>0);
		$drivers['safety_car'] = array('id'=>(int)$row->safety_car, 'points'=>0);
		$drivers['dnf'] = array('id'=>(int)$row->dnf, 'points'=>0);
		
		return $drivers;
	}
	
	/**
	 * Get the player predictions for this race
	 * 
	 * Returns an Array ('entry_id' => Array (('position'=>'participant')...))
	 * 
	 * TODO - Allow calculations for late entries ?
	 * 
	 * 
	 * @param $raceid the requested race id
	 * @return array 
	 */
	function getPredictions($raceid) {
		global $wpdb;
		$predictions = array();
		
		$sql = 'SELECT UNIX_TIMESTAMP(entry_by) AS "entry_by" FROM '.$wpdb->prefix.$this->pf.'race WHERE id = '.$raceid;
		$entry = $wpdb->get_row( $sql , OBJECT );
		$entry_by = $entry->entry_by;
		
		
		$sql = 'SELECT e.id as "id", pole_lap_time, rain, safety_car, dnf, double_up, participant_id, position FROM '.$wpdb->prefix.$this->pf.'entry e, '
					.$wpdb->prefix.$this->pf.'prediction p WHERE e.race_id = '.$raceid.' 
					AND p.entry_id = e.id AND UNIX_TIMESTAMP(`when`) < '.$entry_by.' ORDER BY e.id, p.position';
		$prediction = $wpdb->get_results( $sql , OBJECT );
		$lastid = -1;
		foreach ($prediction as $row) {
			if ($row->id != $lastid) {
				$predictions[$row->id] = array($row->position => (int)$row->participant_id);
				$predictions[$row->id]['pole_lap_time'] = $row->pole_lap_time;
				$predictions[$row->id]['rain'] = $row->rain;
				$predictions[$row->id]['safety_car'] = $row->safety_car;
				$predictions[$row->id]['dnf'] = $row->dnf;
				$predictions[$row->id]['double_up'] = $row->double_up;
				$lastid = (int)$row->id;
			} else {
				$predictions[$row->id][$row->position] = (int)$row->participant_id;
			}
		}
		
		return $predictions;
	}
	
	/**
	 * Update the players points based on their predictions and the
	 * actual finishing order of the race.
	 * 
	 * The function to calculate the points can overridden by supplying
	 * a new function in Championship settings. Signature
	 * 
	 * @param $raceid the race in question
	 * @param $drivers array of driver id's and race points. 0 == pole, 1..n finsihing positions.
	 * 					see motorracingleaguepoints.php for more detail.
	 * @param $predictions player predictions Array ('entry_id' => Array (('position'=>'participant')...))
	 * @param $calculator User supplied filename with points calculator.
	 * @return none
	 */
	function updateStandings($raceid, $drivers, $predictions, $calculator) {
		global $wpdb;
		
		$this->setMessage(__('Prediction points updated',$this->name));
		
		if (count($drivers) == 0) { 	// No race results
			$sql = 'UPDATE '.$wpdb->prefix.$this->pf.'entry 
						SET points = 0, points_breakdown = %s, `when` = `when` WHERE race_id = %d';
			$ret = $wpdb->query($wpdb->prepare($sql, '', $raceid));
			return;
		}
		$race_id = $raceid;  // Fudge below !
		
		/*
		 * Should we use a user specified calculation function ?
		 */
		if (empty($calculator)) {
			/*
			 * Score according to championship definition.
			 */
			$calculator = "motorracingleaguescoring.php";
			$raceid = $this->options;  // Fudge - pass championship definition and scoring assignments.
		}
		require_once dirname(__FILE__).'/'.$calculator;
		
		$points = MotorRacingLeagueCalculatePoints($raceid, $drivers, $predictions);
		
		foreach ($points as $entryid=>$point) {
			
			// Note - `when` = `when` does not update timestamp
			$sql = 'UPDATE '.$wpdb->prefix.$this->pf.'entry 
						SET points = %d, points_breakdown = %s, `when` = `when` WHERE id = %d';
			$ret = $wpdb->query($wpdb->prepare($sql,$point['total'], serialize($point), $entryid));
			if ($ret === false) {
				echo $wpdb->last_error . PHP_EOL;
				break;
			}
		}
		
		$sql = "SELECT championship_id FROM {$wpdb->prefix}{$this->pf}race WHERE id = %d";
		$champ_id = $wpdb->get_var($wpdb->prepare($sql, $race_id));
		
		if ($champ_id) {
			// Clear cache
			delete_transient($this->pf . 'standings_' . $champ_id);
		}
		
	}

	/**
	 * Display the current points position for all players for this race.
	 * 
	 * @param $champid Championship id
	 * @param $raceid Race id
	 * @return html string
	 */
	function getStandings($champid, $raceid) {
		global $wpdb;
		
		$numPredictions = (int)$this->getChampionshipNumPredictions($champid);
		
		/*
		 * Display the prediction entries for a specified race.
		 */
		$sql = 'SELECT pole_lap_time, e.id as "id", player_name, email, p.shortcode as "shortcode", 
						p.name AS shortcode_name, points, position, `when`,
						rain, safety_car, dnf, double_up, points_breakdown FROM '
				.$wpdb->prefix.$this->pf.'entry e, '
				.$wpdb->prefix.$this->pf.'participant p, '
				.$wpdb->prefix.$this->pf.'prediction pre WHERE e.race_id = '.$raceid.' 
					AND pre.entry_id = e.id AND p.id = pre.participant_id ORDER BY e.points DESC, `when`, e.id, pre.position ASC';
		$entry = $wpdb->get_results( $sql , OBJECT );
		
		$output = '<table class="motorracingleague"><thead>
		<tr>
			<th scope="col">'.__('Del', $this->name).'</th>
			<th scope="col">'.__('Id', $this->name).'</th>
			<th scope="col">'.__('Name', $this->name).'</th>
			<th scope="col">'.__('Email', $this->name).'</th>';
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
			$output .= '<th scope="col">'.$i.'.</th>';
		}
		$output .= '<th scope="col">Points</th>
			<th scope="col">'.__('When', $this->name).'</th>
			</tr></thead>
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
					$output .= '<td>' . $this->pts($points, __('Bonus', $this->name), $points_breakdown, 'bonus') . '</td>';
					$output .= "<td>$when</td></tr>";
				}
				$when = $row->when;
				$points = $row->points;
				$points_breakdown = array();
				if (is_serialized($row->points_breakdown)) {
					$points_breakdown = unserialize($row->points_breakdown);
				}
				$output .= "<tr>";
				$output .= '<td><input type="checkbox" value="'.$row->id.'" name ="'.$this->pf.'entry['.$row->id.']"/></td>';
				$output .= '<td><a title="'.__('Modify this prediction',$this->name).'" href="'.admin_url('admin.php').'?page='.$this->pf.'predictions&amp;'.$this->pf.'modifyPrediction='.$row->id.'&amp;raceid='.$raceid.'&amp;champid='.$champid.'">'.$row->id."</a></td>
					<td>".$this->shorten($row->player_name)."</td>
					<td><a href='mail:$row->email'>".substr($row->email,0,10)."</a></td>";
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
			$output .= '<td>' . $this->pts($points, __('Bonus', $this->name), $points_breakdown, 'bonus') . '</td>';
			$output .= "<td>$when</td></tr>";
		}
	
		
		$output .= '</tbody></table>';
		
		return $output;
	}

	
	function getEmail($player, $email) {
		global $wpdb;
		
		if (!$this->needsAuthorisation()) {
			return $email;
		}
		
		if (get_option('motorracingleague_display_name')) {
				$sql = "SELECT user_email FROM {$wpdb->users} WHERE display_name = %s";
		} else {
				$sql = "SELECT user_email FROM {$wpdb->users} WHERE user_login = %s";
		}
		$row = $wpdb->get_row($wpdb->prepare($sql, $player));
		if ($row) {
			return $row->user_email;
		} else {
			return "";
		}
		
	}
	
	/**
	 * Doubled up in another race ?
	 */
	function already_doubled($raceid, $player) {
		global $wpdb;
		
		$sql = "SELECT COUNT(*) FROM
					{$wpdb->prefix}{$this->pf}entry e,
					{$wpdb->prefix}{$this->pf}race r
				WHERE
					double_up = 1 AND e.player_name = %s AND e.race_id = r.id AND
					e.race_id <> %d AND r.championship_id = 
						(SELECT c.id
						 FROM
						 	{$wpdb->prefix}{$this->pf}championship c,
							{$wpdb->prefix}{$this->pf}race r2
						 WHERE r2.id = %d AND c.id = r2.championship_id)";
		$doubled_up = $wpdb->get_var($wpdb->prepare($sql, $player, $raceid, $raceid));
		
		return $doubled_up;
	}
	
	function addPrediction($raceid, $player, $email, $participants, $when, $pole_lap_time, $rain, $safety_car, $dnf, $double_up) {
		global $wpdb;
		
		$this->setMessage(__('Your entry has been saved', $this->name));
		
		$email = $this->getEmail($player, $email);
		
		if ($raceid == -1 || in_array(-1, $participants) || empty($player) || empty($email) || empty($when)) {
			$this->setMessage(__("Please select all fields", $this->name), true);
			return false;
		}
		
		if ($double_up && $this->already_doubled($raceid, $player)) {
			$this->setMessage(__("Double Up already used", $this->name), true);
			return false;
		}
		
		if ($this->options->get_predict_pole_time() && !$this->is_laptime($pole_lap_time)) {
			$this->setMessage(__("Lap time must be MM:SS.ccc format", $this->name), true);
			return false;
		}
		
		$pole = $this->to_laptime($pole_lap_time);
		
		$drivers = $participants;
		if (isset($drivers[0])) unset($drivers[0]); // Remove pole
		if (isset($drivers[-1])) unset($drivers[-1]); // Remove fastest
		$unique_drivers = array_unique($drivers);
		if (count($drivers) > count($unique_drivers)) {
			$this->setMessage(__("Duplicate drivers", $this->name), true);
			return false;
		}
		
		if ($this->lateEntry($raceid, $when)) {
			$this->setMessage(__('Your entry has been saved but may not be counted as it is too late', $this->name));
		}
		
		$table = $wpdb->prefix.$this->pf.'entry';
		
		$ok = $wpdb->query( $wpdb->prepare( "
				INSERT INTO $table
				(player_name, email, race_id, points, `when`, pole_lap_time, rain, safety_car, dnf, double_up, points_breakdown)
				VALUES ( %s, %s, %d, %d, %s, %d, %d, %d, %d, %d, %s )", 
				$player, $email, $raceid, 0, $when, $pole, $rain, $safety_car, $dnf, $double_up, '') );
				
		if ($ok) {
			$id = $wpdb->insert_id;
			$table = $wpdb->prefix.$this->pf.'prediction';
			foreach ($participants as $key=>$participant) {
				$ok = $wpdb->query( $wpdb->prepare( "
						INSERT INTO $table
						(entry_id, participant_id, position)
						VALUES ( %d, %d, %d )", 
						$id, $participant, $key) );
				if (!$ok) {
					$this->setMessage(__('Your entry could not be saved to the database.',$this->name)."<br />" . addslashes($wpdb->last_error), true);
					return false;
				}
			}
			
		} else {
			$this->setMessage(__('Your entry could not be saved to the database.',$this->name)."<br />" . addslashes($wpdb->last_error), true);
			return false;
		}
		
		return true;
	}
	
	function updatePrediction($entryid, $raceid, $player, $email, $participants, $when, $pole_lap_time, $rain, $safety_car, $dnf, $double_up) {
		global $wpdb;
		
		$email = $this->getEmail($player, $email);
		
		$this->setMessage(__('Updated prediction', $this->name));
		
		if ($this->options->get_predict_pole_time() && !$this->is_laptime($pole_lap_time)) {
			$this->setMessage(__("Lap time must be MM:SS.ccc format", $this->name), true);
			return false;
		}
		
		if ($double_up && $this->already_doubled($raceid, $player)) {
			$this->setMessage(__("Double Up already used", $this->name), true);
			return false;
		}
		
		$pole = $this->to_laptime($pole_lap_time);
		
		if ($raceid == -1 || in_array(-1, $participants) || empty($player) || empty($email) || empty($when)) {
			$this->setMessage(__("Please select all fields", $this->name), true);
			return false;
		} else {
			$drivers = $participants;
			if (isset($drivers[0])) unset($drivers[0]); // Remove pole
			if (isset($drivers[-1])) unset($drivers[-1]); // Remove fastest
			$unique_drivers = array_unique($drivers);
			if (count($drivers) > count($unique_drivers)) {
				$this->setMessage(__("Duplicate drivers", $this->name), true);
				return false;
			}
		}
		
		if ($this->lateEntry($raceid, $when)) {
			$this->setMessage(__('Your entry has been saved but may not be counted as it is too late', $this->name));
		}
		
		$table = $wpdb->prefix.$this->pf.'entry';
		
		/* Only INSERT, not updates because without authentication of the player someone else could change your entry */
		$ok = $wpdb->query( $wpdb->prepare( "
				UPDATE $table
				SET player_name=%s, email=%s, race_id=%d, points=%d, `when`='%s', pole_lap_time = %d,
					rain = %d, safety_car = %d, dnf = %d, double_up = %d
				WHERE id=%d",
				$player, $email, (int)$raceid, 0, $when, $pole, $rain, $safety_car, $dnf, $double_up, $entryid) );
				
		if ($ok === false) {
			$this->setMessage(__('Your entry could not be saved to the database.',$this->name)."<br />" . addslashes($wpdb->last_error), true);
			return false;
		} else {
			foreach ($participants as $i=>$p) {
				if ($wpdb->query( $wpdb->prepare( "
						UPDATE ".$wpdb->prefix.$this->pf."prediction
						SET participant_id = %d WHERE entry_id=%d AND position=%d", 
						(int)$participants[$i], (int)$entryid, (int)$i ) ) === false) {
				
					$this->setMessage($wpdb->last_error, true);
					return false;
				}
			}			
		}
		return true;
	}
	
	function modifyPrediction($raceid, $champid, $entryid) {
		global $wpdb;
		$mrl_p = array();
		
		$this->options->load($champid);
		$sql = 'SELECT pole_lap_time, position, p.participant_id as "participant_id", e.when as "when",
						e.player_name as "player_name", e.email as "email",
						rain, safety_car, dnf, double_up
				FROM '
				.$wpdb->prefix.$this->pf.'entry e, '
				.$wpdb->prefix.$this->pf.'prediction p 
					WHERE e.id = '.$entryid.' AND p.entry_id = e.id ORDER BY position';
		$result = $wpdb->get_results( $sql , OBJECT );
		$pole_lap_time = $this->from_laptime($result[0]->pole_lap_time);  // convert to HMM:SS.ccc fingers crossed !
		$rain = $result[0]->rain;
		$safety_car = $result[0]->safety_car;
		$dnf = $result[0]->dnf;
		$double_up = $result[0]->double_up;
		foreach ($result as $row) {
			$mrl_when = $row->when;
			$mrl_email = $row->email;
			$mrl_player = $row->player_name;
			$mrl_p[$row->position] = $row->participant_id;
		}
				
?>
		<div class="wrap">
		
		<h2><?php _e('Modify a player prediction entry.', $this->name) ?></h2>

		<form name="prediction" action="<?php echo admin_url('admin.php?page=motorracingleague_predictions'); ?>" method="post" class="form-table motorracingleague-form">
		<fieldset>
			<legend><?php _e('Entry for',$this->name); ?> <?php echo $this->getChampionshipName($champid); ?></legend>
			<?php wp_nonce_field( $this->pf . 'select-race' ) ?>
			<?php wp_nonce_field( $this->pf . 'modify-prediction', '_wpnonce2' ) ?>
			<input type="hidden" value="<?php echo $champid; ?>" name="mrl_championship"></input>
			<input type="hidden" value="<?php echo $raceid; ?>" name="mrl_race"></input>
			<input type="hidden" value="<?php echo $entryid; ?>" name="mrl_entry"></input>
			
			<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="mrl_championship"><?php _e( 'Championship:', $this->name ) ?></label></th>
				<td><?php echo $this->getChampionships($champid,'disabled'); ?></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="mrl_race"><?php _e( 'Race:', $this->name ) ?></label></th>
				<td><?php echo $this->getRaceSelection($champid, true, $raceid, null, ' disabled '); ?></td>
			</tr>
<?php 		if ($this->options->get_predict_pole_time()) { ?>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>pole_lap_time"><?php _e( 'Pole time:', $this->name ) ?></label></th>
				<td><input type="text" name="<?php echo $this->pf;?>pole_lap_time" id="<?php echo $this->pf;?>pole_lap_time" value="<?php echo $pole_lap_time;?>" size="10" /></td>
			</tr>
<?php 		} ?>
			<?php foreach ($mrl_p as $i=>$p) {?>
			<tr valign="top">
				<th scope="row"><label for="<?php echo "mrl_p[$i]"; ?>">
				<?php if ($i == 0) {
					_e( 'Pole', $this->name );
				} elseif ($i == -1) {
					echo $this->fl_label($this->options->get_predict_lapsled());
				} else {
					echo "$i:";
				} ?>
				</label></th>
				<td><?php echo $this->getParticipantSelection($champid, "p[$i]", "", $mrl_p[$i]); ?>
				</td>
			</tr>
			<?php }
			
			$output = '';
			if ($this->options->get_predict_rain()) {
				$output .= '<tr valign="top">';
				$tooltip = __('Rain affected ?', $this->name);
				$output .= '<td><label title="'.$tooltip.'" for="'.$this->pf.'rain">'.__( 'Rain', $this->name ).'</label></td>';
				$output .= '<td><input title="'.$tooltip.'" type="checkbox" '.($rain ? 'checked' : '').' name="'.$this->pf.'rain" id="'.$this->pf.'rain" value="1" /></td>';
				$output .= '</tr>';
			}
			if ($this->options->get_predict_safety_car()) {
				$output .= '<tr valign="top">';
				$tooltip = __('Safety Car deployed ?', $this->name);
				$output .= '<td><label  title="'.$tooltip.'" for="'.$this->pf.'safety_car">'.__( 'Safety Car', $this->name ).'</label></td>';
				$output .= '<td><input  title="'.$tooltip.'" type="checkbox" '.($safety_car ? 'checked' : '').' name="'.$this->pf.'safety_car" id="'.$this->pf.'safety_car" value="1" /></td>';
				$output .= '</tr>';
			}
			if ($this->options->get_predict_dnf()) {
				$output .= '<tr valign="top">';
				$tooltip = __('Number of non finishers', $this->name);
				$output .= '<td><label  title="'.$tooltip.'" for="'.$this->pf.'dnf">'.__( 'DNF', $this->name ).'</label></td>';
				$output .= '<td><select  title="'.$tooltip.'" name="'.$this->pf.'dnf" id="'.$this->pf.'dnf">';
				$num_drivers = $this->getNumDrivers($champid);
				for ($i = 0; $i <= $num_drivers; $i++) {
					$output .= '<option '.($dnf == $i ? 'selected' : '').' value="'.$i.'">' . $i . '</option>';
				}
				$output .= '</select></td>';
				$output .= '</tr>';
			}
			if ($this->options->get_double_up()) {
				$output .= '<tr valign="top">';
				$tooltip = __('Double Up ?', $this->name);
				$output .= '<td><label  title="'.$tooltip.'" for="'.$this->pf.'double_up">'.__( 'Double Up', $this->name ).'</label></td>';
				$output .= '<td><input  title="'.$tooltip.'" type="checkbox" '.($double_up ? 'checked' : '').' name="'.$this->pf.'double_up" id="'.$this->pf.'double_up" value="1" /></td>';
				$output .= '</tr>';
			}
			echo $output;
			
			?>
			<?php if ($this->needsAuthorisation()) { ?>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf; ?>mrl_player"><?php _e( 'Player:', $this->name ) ?></label></th>
				<td><?php echo $this->getUsers($mrl_player); ?></td>
			</tr>
			<?php } else { ?>			
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>mrl_player"><?php _e( 'Player:', $this->name ) ?></label></th>
				<td><input type="text" name="<?php echo $this->pf;?>mrl_player" id="<?php echo $this->pf;?>mrl_player" value="<?php echo $mrl_player;?>" size="30" style="margin-bottom: 1em;" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>mrl_email"><?php _e( 'Email:', $this->name ) ?></label></th>
				<td><input type="text" name="<?php echo $this->pf;?>mrl_email" id="<?php echo $this->pf;?>mrl_email" value="<?php echo $mrl_email;?>" size="30" style="margin-bottom: 1em;" /></td>
			</tr>
			<?php } ?>
			<tr valign="top">
				<th scope="row"><label for="<?php echo $this->pf;?>mrl_when"><?php _e( 'Entry Datetime:', $this->name ) ?></label></th>
				<td><input type="text" name="<?php echo $this->pf;?>mrl_when" id="<?php echo $this->pf;?>mrl_when" value="<?php echo $mrl_when;?>" size="30" style="margin-bottom: 1em;" /></td>
			</tr>
			</table>
			<p class="submit"><input type="submit" name="<?php echo $this->pf;?>modifyPrediction" value="<?php _e( 'Modify Prediction', $this->name ) ?>" class="button-primary" />
					<input type="submit" name="<?php echo $this->pf;?>selectRace" value="<?php _e( 'Cancel', $this->name ) ?>" class="button" />
			</p>
		</fieldset>
		</form>
		</div>
<?php		
	}
	
	function is_datetime($d) {
		return (preg_match ("/([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/", $d));
	}
	
	function info($id) {
		return '<img style="margin-left:1em;" src="'.WP_PLUGIN_URL .'/motor-racing-league/images/info.png" id="'.$id.'"/>';
	}
	
	function help() {
		require_once(dirname(__FILE__).'/mrl-help.php');
		motorracingleague_help();
	}
	
	/**
	 * Add Js and CSS to head
	 */
	function admin_enqueue_scripts() {
		wp_enqueue_style($this->pf.'jquery_ui_style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/smoothness/jquery-ui.css');
		wp_enqueue_style($this->pf.'style', WP_PLUGIN_URL . '/motor-racing-league/css/style.css');
		wp_enqueue_style($this->pf.'admin_style', WP_PLUGIN_URL . '/motor-racing-league/css/admin-style.css');
		wp_enqueue_script($this->pf.'js', WP_PLUGIN_URL .'/motor-racing-league/js/motorracingleague-admin.js', array( 'jquery', 'jquery-ui-tabs', 'jquery-ui-dialog' ));
	}
}
