<?php

/**
 * Widgets
 * 
 * Widget class for Wordpress plugin MotorRacingLeague
 * 
 * @author    Ian Haycox
 * @package	  MotorRacingLeague
 * @copyright Copyright 2009-2013
 *
 */
class MotorRacingLeagueWidget extends WP_Widget {

	function MotorRacingLeagueWidget() {
		$widget_ops = array('classname' => 'widget_motor_racing_league', 'description' => __('Display prediction results for the Motor Racing League', 'motorracingleague') );
		$this->WP_Widget('motor_racing_league', __('Motor Racing League', 'motorracingleague'), $widget_ops);
	}

	function widget($args, $instance) {
		// prints the widget
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$championship = $instance['championship'];
		$race = $instance['race'];
		$max = $instance['max'];
		$url = $instance['url'];
		$name = $instance['name'];
		$predictions = $instance['predictions'];
		
		echo $before_widget;
		if ( $title )
		echo $before_title . $title . $after_title;

		$mrl = new MotorRacingLeague();
		
		if ($race == -1) {
			echo $mrl->getResultsWidgetData($championship, $max);
		} else {
			echo $mrl->getRaceStandings($race, $max, $predictions);
		}
		
		if (!empty($url) && !empty($name)) {
			echo '<p><a href="'.$url.'">'.$name.'</a></p>';
		}
				
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		//save the widget
		$instance = $old_instance;
		$new_instance = wp_parse_args((array) $new_instance, array( 'title' => ''));
		$instance['title'] = strip_tags($new_instance['title']);
		$new_instance = wp_parse_args((array) $new_instance, array( 'championship' => -1));
		$instance['championship'] = strip_tags($new_instance['championship']);
		$new_instance = wp_parse_args((array) $new_instance, array( 'race' => -1));
		$instance['race'] = strip_tags($new_instance['race']);
		$new_instance = wp_parse_args((array) $new_instance, array( 'predictions' => false));
		$instance['predictions'] = strip_tags($new_instance['predictions']);
		$new_instance = wp_parse_args((array) $new_instance, array( 'max' => 10));
		$instance['max'] = strip_tags($new_instance['max']);
		$new_instance = wp_parse_args((array) $new_instance, array( 'url' => ''));
		$instance['url'] = strip_tags($new_instance['url']);
		$new_instance = wp_parse_args((array) $new_instance, array( 'name' => 'Full results'));
		$instance['name'] = strip_tags($new_instance['name']);
		
		return $instance;
	}

	function form($instance) {
		
		global $wpdb;
		
		//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'championship' => -1, 'race' => -1,  'max' => 10, 'url' => '', 'name' => 'Full results', 'predictions' => false) );
		$title = $instance['title'];
		$championship = $instance['championship'];
		$race = $instance['race'];
		$max = $instance['max'];
		if (!is_numeric($max)) $max = 10;
		$url = $instance['url'];
		$name = $instance['name'];
		$predictions = $instance['predictions'];
		
		$sql = "SELECT id, CONCAT(season, ' - ', description) AS description FROM {$wpdb->prefix}motorracingleague_championship ORDER BY id";
		$champs = $wpdb->get_results( $sql , OBJECT );
		
		$sql = "SELECT r.id AS id, CONCAT(season, ' - ', circuit) AS race FROM
					{$wpdb->prefix}motorracingleague_championship c,
					{$wpdb->prefix}motorracingleague_race r
				WHERE
					c.id = r.championship_id
				ORDER BY season, r.race_start";
		$races = $wpdb->get_results( $sql , OBJECT );
		
?>
		<p><?php _e('Display prediction result totals for a championship or an individual race.', 'motorracingleague'); ?></p>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'motorracingleague'); ?>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>

		<p><label for="<?php echo $this->get_field_id('championship'); ?>"><?php _e('Championship:', 'motorracingleague'); ?>
		<select id="<?php echo $this->get_field_id('championship'); ?>" name="<?php echo $this->get_field_name('championship'); ?>">
			<option value="-1"></option>
			<?php foreach ($champs as $row) { ?>
			<option <?php if ($championship == $row->id) echo "selected"; ?> value="<?php echo $row->id; ?>"><?php echo $row->description; ?></option>
			<?php } ?>
		</select></label></p>

		<p><label for="<?php echo $this->get_field_id('race'); ?>"><?php _e('Race:', 'motorracingleague'); ?><br />
		<select id="<?php echo $this->get_field_id('race'); ?>" name="<?php echo $this->get_field_name('race'); ?>">
			<option value="-1"><?php _e("All races", 'motorracingleague'); ?></option>
			<?php foreach ($races as $row) { ?>
			<option <?php if ($race == $row->id) echo "selected"; ?> value="<?php echo $row->id; ?>"><?php echo $row->race; ?></option>
			<?php } ?>
		</select></label></p>
		
		<p><label for="<?php echo $this->get_field_id('predictions'); ?>"><?php _e('Show predictions for race:', 'motorracingleague'); ?>
		<input type="checkbox" class="widefat" id="<?php echo $this->get_field_id('predictions'); ?>" name="<?php echo $this->get_field_name('predictions'); ?>" value="1" <?php if ($predictions): echo ' checked '; endif; ?> /></label></p>
		
		<p><label for="<?php echo $this->get_field_id('max'); ?>"><?php _e('Maximum Results:', 'motorracingleague'); ?>
		<input class="widefat" id="<?php echo $this->get_field_id('max'); ?>" name="<?php echo $this->get_field_name('max'); ?>" type="text" value="<?php echo esc_attr($max); ?>" /></label></p>
		
		<p><label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('Full results page URL:', 'motorracingleague'); ?>
		<input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo esc_attr($url); ?>" /></label></p>
		
		<p><label for="<?php echo $this->get_field_id('name'); ?>"><?php _e('Full results link name:', 'motorracingleague'); ?>
		<input class="widefat" id="<?php echo $this->get_field_id('name'); ?>" name="<?php echo $this->get_field_name('name'); ?>" type="text" value="<?php echo esc_attr($name); ?>" /></label></p>

<?php
	}


}

?>