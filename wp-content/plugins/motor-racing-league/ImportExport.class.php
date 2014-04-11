<?php

require_once (dirname(__FILE__).'/DataSource.php');

class ImportExport extends MotorRacingLeagueAdmin {

	private $checked_headers;
	private $data_valid = false;
	
	/**
	 * Construct ImportExport
	 * 
	 * @param string $pf The plugin prefix
	 * @param string $name The plugin name
	 * @param string $dir The plugin directory
	 * @param string $version Plugin version
	 * @return bool Successfully initialized
	 */
	function ImportExport($pf, $name, $dir, $version)
	{
		$this->pf = $pf;
		$this->name = $name;
		$this->dir = $dir;
		$this->version = $version;
		$this->checked_headers = false;
	}
	
	private function loadSummary($csv_data, $testrun, $champid) {
		
		global $wpdb;
		
		static $circuits = array();
		
		if (!$this->checked_headers) {
			/*
			 * For each of the race_id's in the header verify there is
			 * a corresponding race row in the database.
			 */
			$this->data_valid = false;
			$num_circuits = 0;
			if ($testrun) echo '<table width="100%"><tr><th align="left">Player</th><th align="left">Rank</th><th align="left">Best</th><th align="left">Total</th>';
			foreach ($csv_data as $key=>$elem) {
				if ($num_circuits > 3) {
					$race_id = $this->getRaceId($key, $champid);
					if ($race_id) {
						$circuits[$key] = $race_id;
						if ($testrun) echo '<th align="left">'.$key.'</th>';
					} else {
						if ($testrun) echo '<th  align="left" class="error">UNKNOWN<br />'.$key.'</th>';
					}
				}
				$num_circuits++;
			}
			
			if (count($circuits) == ($num_circuits - 4)) {   // Ignore first 3 columns of CSV file.
				$this->data_valid = true;
			}
			
			$this->checked_headers = true;
			if ($testrun) echo "</tr>\n";
		}
		
		if ($testrun) {
			echo '<tr>';
			foreach ($csv_data as $elem) {
				echo '<td>'.$elem.'</td>';
			}
			echo "</tr>\n";
		} else {
			if ($this->data_valid) {
				
				$num_circuits = 0;
				
				foreach ($csv_data as $circuit=>$points) {
					if ($num_circuits > 3) {
						$ok = $wpdb->query( $wpdb->prepare( "
								INSERT INTO ".$wpdb->prefix.$this->pf.'entry'."
								(player_name, email, race_id, points)
								VALUES ( %s, %s, %d, %d )", 
								$csv_data['Name'], '', $circuits[$circuit], $points) );
						if (!$ok) {
							$this->data_valid = false;
							break;
						}
					}
					$num_circuits++;
				}
			}
		}
		return (!$testrun) && $this->data_valid;
		
	}
	
	private function importSummary($champid, $file, $testrun = true) {

	    $csv = new File_CSV_DataSource;
		$this->checked_headers = false;
	    
		if (!$csv->load($file)) {
			$this->setMessage("File not loaded", true);
			$this->printMessage();
		} else {
			if (!$csv->isSymmetric()) {
				$error = 'Invalid CSV file: header length and/or row lengths do not match.';
				$this->setMessage($error, true);
				$this->printMessage();
			} else {
				
				$skipped = 0;
				$imported = 0;
				$message = '';
				foreach ($csv->connect() as $csv_data) {
					if ($this->loadSummary($csv_data, $testrun, $champid)) {
						$imported++;
					} else {
						$skipped++;
					}
					if (!$this->data_valid) {
						$message = "<p><b>Error importing data. Circuit names do not match defined races.</b></p>";
						if (!$testrun) break;
					}
				}

				if ($testrun) echo '</table>';
				
				if (file_exists($file)) {
					@unlink($file);
				}
		
				if ($skipped)
					$message .= "<p><b>Skipped {$skipped} results.</b></p>";
				$message .= "<p><b>Imported {$imported} results.</b></p>";
				$this->setMessage($message, !$this->data_valid);
				$this->printMessage();
			}
		}
	}
	
	function do_import() {
		
		$import_test = '1';
		$file = '';
		$champid = -1;
		
		if (isset($_POST[$this->pf.'submitimport'])) {
			check_admin_referer($this->pf . 'import-nonce');
			
			if (isset($_POST['mrl_championship'])) {
				$champid = $_POST['mrl_championship'];
			}
			
			if (!isset($_POST[$this->pf.'csv_import_testrun'])) {
		    	$import_test = '0'; //$_POST[$this->pf.'csv_import_testrun'];
		    }
			
			if (isset($_FILES[$this->pf.'csv_import'])) {
			
				$file = $_FILES[$this->pf.'csv_import']['tmp_name'];
			}		    
		}
?>
		<div class="wrap">
		
		<h2><?php _e('Motor Racing League Import', $this->name) ?></h2>
	
		<p><?php _e('Import summary results for past races.', $this->name) ?></p>
	

		<form method="post" enctype="multipart/form-data">
		<table class="form-table">
			<?php wp_nonce_field( $this->pf . 'import-nonce' ) ?>
			
	        <tr class="form-field form-required">
	            <th scope="row" valign="top"><label for="mrl_championship">Championship</label></th>
	            <td><?php echo $this->getChampionships($champid); ?></td>
	        </tr>
	        <tr class="form-field form-required">
	            <th scope="row" valign="top"><label for="<?php echo $this->pf;?>csv_import_testrun">Test run - no changes made</label></th>
	            <td><input name="<?php echo $this->pf;?>csv_import_testrun" id="<?php echo $this->pf;?>csv_import_testrun" type="checkbox" <?php if ('1' == $import_test): echo 'checked="checked"'; endif; ?> value="<?php echo $import_test;?>" /></td>
	        </tr>
			<tr class="form-field form-required">
				<th scope="row" valign="top"><label for="<?php echo $this->pf;?>csv_import">Upload file</label></th>
				<td><input name="<?php echo $this->pf;?>csv_import" id="<?php echo $this->pf;?>csv_import" type="file" value="" /></td>
			</tr>
		</table>
		<p class="submit"><input type="submit" class="button" name="<?php echo $this->pf;?>submitimport" value="Import" /></p>		
		</form>



		</div>
<?php
		if (!empty($file) && $champid != -1) {
			$this->importSummary($champid, $file, $import_test == '1');
		}

	}
	
	function do_export() {
?>
		<div class="wrap">
		
		<h2><?php _e('Motor Racing League Export', $this->name) ?></h2>
	
		<p>TODO</p>
	
		</div>
<?php				
	}
}

?>