<?php
/*
Plugin Name: GoPublish Text Widget
Description: This plugin/widget allows you to place a text widget in one of your widget areas.
Author: School Newspapers Online
Author URI: http://www.schoolnewspapersonline.com/
Version: 1.1
*/

add_action('widgets_init', create_function('', "register_widget('sno_text');"));
class sno_text extends WP_Widget {

	function sno_text() {
		$widget_ops = array( 'classname' => 'sno_text', 'description' => 'Display arbitrary text or html.' );
		$control_ops = array( 'width' => 500, 'height' => 250, 'id_base' => 'sno_text' );
		$this->WP_Widget( 'sno_text', 'GoPublish Text Widget', $widget_ops, $control_ops );
	}

	function widget($args, $instance) {
		extract($args);
		echo '<div class="widgetwrap">'; ?>
			<?php 
				$widget = $this->id; $sidebartest = get_option('sidebars_widgets'); 
				$columns = get_theme_mod('sno-layout'); 
					if (($columns == "Option 3") || ($columns == "Option 6")) { $columnwidth = "even"; } else { $columnwidth = "wide"; }
					
				foreach ($sidebartest["sidebar-1"] as $key => $value ) { 
					if ($widget == $value) $instance['sidebarname'] = 'Non-Home Sidebar'; 
				}
				foreach ($sidebartest["sidebar-2"] as $key => $value ) { 
					if ($widget == $value) $instance['sidebarname'] = 'Home Main Column'; 
				}
				foreach ($sidebartest["sidebar-3"] as $key => $value ) { 
					if (($widget == $value) && ($columnwidth == "even")) $instance['sidebarname'] = 'Home Bottom Left'; 
					if (($widget == $value) && ($columnwidth == "wide")) $instance['sidebarname'] = 'Home Bottom Narrow';
				}
				foreach ($sidebartest["sidebar-4"] as $key => $value ) { 
					if (($widget == $value) && ($columnwidth == "even")) $instance['sidebarname'] = 'Home Bottom Right'; 
					if (($widget == $value) && ($columnwidth == "wide")) $instance['sidebarname'] = 'Home Bottom Wide';
				}
				foreach ($sidebartest["sidebar-5"] as $key => $value ) { 
					if ($widget == $value) $instance['sidebarname'] = 'Home Sidebar'; 
				}
				foreach ($sidebartest["sidebar-6"] as $key => $value ) { 
					if ($widget == $value) $instance['sidebarname'] = 'Ads Sidebar'; 
					}
			?>							

			<?php $customcolors=$instance['custom-colors']; include(TEMPLATEPATH . "/widgetstyles.php"); ?>
					
			<?php echo wpautop($instance['text']); ?>
							
			</div>
			
<div <?php if ($customcolors==on) { ?>style="background-color:<?php echo $instance['header-color']; ?> !important;"<?php } ?>class="widgetfooter<?php if ($instance['widget-style']=="Style 3") { ?>3<?php } else { ?>1<?php } ?>"></div></div>
<?php	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['text'] = $new_instance['text'];
		$instance['widget-style'] = $new_instance['widget-style'];
 		$instance['custom-colors'] = ( isset( $new_instance['custom-colors'] ) ? on : "" );  
		$instance['header-color'] = $new_instance['header-color'];
		$instance['header-text'] = $new_instance['header-text'];
		$instance['widget-border'] = $new_instance['widget-border'];
		$instance['widget-background'] = $new_instance['widget-background'];
		$instance['border-thickness'] = $new_instance['border-thickness'];
		$instance['sidebarname'] = $new_instance['sidebarname'];
		return $instance;
	}

	function form($instance) { 
			$defaults = array( 'title' => 'Title', 'widget-style' => get_theme_mod('widget-style'), 'header-color' => get_theme_mod('accentcolor-header'), 'header-text' => '#ffffff', 'widget-border' => '#aaaaaa', 'widget-background' => '#eeeeee', 'border-thickness' => '1px' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<?php 
		global $registered_sidebar; $sidebarname = $registered_sidebar['name']; 
		if ($sidebarname) { $instance['sidebarname'] = $sidebarname; } ?>

		<div style="float:left;width:230px;margin-right:20px;border-right:1px solid #aaaaaa;padding-right:10px;">

		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e("Title"); ?>:</label><br />
		<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:95%;" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text To Show'); ?>:</label><br />
		<textarea id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" style="width: 95%;" rows="9"><?php echo $instance['text']; ?></textarea>
		</p>

		<input type="hidden" id="<?php echo $this->get_field_id('sidebarname'); ?>" name="<?php echo $this->get_field_name('sidebarname'); ?>" value="<?php echo $instance['sidebarname']; ?>" />

		</div>		
		<div style="float:left;width:210px">
		<p style="font-weight:bold;text-decoration:underline;">Widget Appearance</p>
		<p>
			<select id="<?php echo $this->get_field_id( 'widget-style' ); ?>" name="<?php echo $this->get_field_name( 'widget-style' ); ?>">
				<option value="Style 1" <?php if ( 'Style 1' == $instance['widget-style'] ) echo 'selected="selected"'; ?>>Style 1</option>
				<option value="Style 2" <?php if ( 'Style 2' == $instance['widget-style'] ) echo 'selected="selected"'; ?>>Style 2</option>
				<option value="Style 3" <?php if ( 'Style 3' == $instance['widget-style'] ) echo 'selected="selected"'; ?>>Style 3</option>
				<option value="Style 4" <?php if ( 'Style 4' == $instance['widget-style'] ) echo 'selected="selected"'; ?>>Style 4</option>
				<option value="Style 5" <?php if ( 'Style 5' == $instance['widget-style'] ) echo 'selected="selected"'; ?>>Style 5</option>
				<option value="Style 6" <?php if ( 'Style 6' == $instance['widget-style'] ) echo 'selected="selected"'; ?>>Style 6</option>
				<option value="Style 7" <?php if ( 'Style 7' == $instance['widget-style'] ) echo 'selected="selected"'; ?>>Style 7</option>
			</select>
			<label for="<?php echo $this->get_field_id( 'widget-style' ); ?>">Widget Style</label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php if ($instance['custom-colors'] == on) echo checked; ?> id="<?php echo $this->get_field_id( 'custom-colors' ); ?>" name="<?php echo $this->get_field_name( 'custom-colors' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'custom-colors' ); ?>">Turn on Custom Widget Colors</label>			
		</p>
		<p>Save this widget to make the color selector active.</p>
<?php $number = $this->number; ?>

		<p>
			<input class="colorwelltext<?php echo $number; ?>" id="<?php echo $this->get_field_id('header-color'); ?>" name="<?php echo $this->get_field_name('header-color'); ?>" type="text" maxlength="7" size="7" value="<?php echo $instance['header-color']; ?>" /> Header Bar <br />
			<input class="colorwelltext<?php echo $number; ?>" id="<?php echo $this->get_field_id('header-text'); ?>" name="<?php echo $this->get_field_name('header-text'); ?>" type="text" maxlength="7" size="7" value="<?php echo $instance['header-text']; ?>" /> Header Bar Text<br />
			<input class="colorwelltext<?php echo $number; ?>" id="<?php echo $this->get_field_id('widget-border'); ?>" name="<?php echo $this->get_field_name('widget-border'); ?>" type="text" maxlength="7" size="7" value="<?php echo $instance['widget-border']; ?>" /> Border<br />
			<input class="colorwelltext<?php echo $number; ?>" id="<?php echo $this->get_field_id('widget-background'); ?>" name="<?php echo $this->get_field_name('widget-background'); ?>" type="text" maxlength="7" size="7" value="<?php echo $instance['widget-background']; ?>" /> Background
		</p>
<script>
		  jQuery(document).ready(function() {
    var f = jQuery.farbtastic('#snocolorpickertext<?php echo $number; ?>');
    var p = jQuery('#snocolorpickertext<?php echo $number; ?>').css('opacity', 0.25);
    var selected;
    jQuery('.colorwelltext<?php echo $number; ?>')
      .each(function () { f.linkTo(this); jQuery(this).css('opacity', 0.75); })
      .focus(function() {
        if (selected) {
          jQuery(selected).css('opacity', 0.75).removeClass('colorwell-selected');          
        }
        f.linkTo(this);
        p.css('opacity', 1);
        jQuery(selected = this).css('opacity', 1).addClass('colorwell-selected');
      });

  });

 
  jQuery(document).ready(function() {
    jQuery('#snocolorpickertext<?php echo $number; ?>').hide();
    jQuery('#snocolorpickertext<?php echo $number; ?>').farbtastic(".colorwelltext<?php echo $number; ?>");
    jQuery(".colorwelltext<?php echo $number; ?>").click(function(){jQuery('#snocolorpickertext<?php echo $number; ?>').slideDown()});
  });
</script>
		<div id="snocolorpickertext<?php echo $number; ?>"></div>
        <p>
			<select id="<?php echo $this->get_field_id( 'border-thickness' ); ?>" name="<?php echo $this->get_field_name( 'border-thickness' ); ?>">
				<option value="0px" <?php if ( '0px' == $instance['border-thickness'] ) echo 'selected="selected"'; ?>>0px</option>
				<option value="1px" <?php if ( '1px' == $instance['border-thickness'] ) echo 'selected="selected"'; ?>>1px</option>
				<option value="2px" <?php if ( '2px' == $instance['border-thickness'] ) echo 'selected="selected"'; ?>>2px</option>
				<option value="3px" <?php if ( '3px' == $instance['border-thickness'] ) echo 'selected="selected"'; ?>>3px</option>
				<option value="4px" <?php if ( '4px' == $instance['border-thickness'] ) echo 'selected="selected"'; ?>>4px</option>
				<option value="5px" <?php if ( '5px' == $instance['border-thickness'] ) echo 'selected="selected"'; ?>>5px</option>
				<option value="6px" <?php if ( '6px' == $instance['border-thickness'] ) echo 'selected="selected"'; ?>>6px</option>
				<option value="7px" <?php if ( '7px' == $instance['border-thickness'] ) echo 'selected="selected"'; ?>>7px</option>
				<option value="8px" <?php if ( '8px' == $instance['border-thickness'] ) echo 'selected="selected"'; ?>>8px</option>
				<option value="9px" <?php if ( '9px' == $instance['border-thickness'] ) echo 'selected="selected"'; ?>>9px</option>
				<option value="10px" <?php if ( '10px' == $instance['border-thickness'] ) echo 'selected="selected"'; ?>>10px</option>
			</select>
			<label for="<?php echo $this->get_field_id( 'border-thickness' ); ?>"> Border Thickness</label>

		</div><div style="clear:both"></div>

		
	<?php 
	}
}
?>