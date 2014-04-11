<?php
/*
Plugin Name: GoPublish Product Showcase Widget
Description: This plugin/widget allows you to place a sports scrollbox widget on your site.
Author: School Newspapers Online
Author URI: http://www.schoolnewspapersonline.com/
Version: 1.0
*/
add_action('widgets_init', create_function('', "register_widget('sno_sports_scrollbox');"));
class sno_sports_scrollbox extends WP_Widget {

	function sno_sports_scrollbox() {
		$widget_ops = array( 'classname' => 'GoPublish Product Showcase', 'description' => 'Use this widget to display a product showcase' );
		$control_ops = array( 'width' => 500, 'height' => 250, 'id_base' => 'sportsscore' );
		$this->WP_Widget( 'sportsscore', 'GoPublish Product Showcase', $widget_ops, $control_ops );
	}

	function widget($args, $instance) {
		extract($args);

				$widget = $this->id; $sidebartest = get_option('sidebars_widgets'); 
				$columns = get_theme_mod('sno-layout'); 
					if (($columns == "Option 3") || ($columns == "Option 6")) { $columnwidth = "even"; } else { $columnwidth = "wide"; }
					
				foreach ($sidebartest["sidebar-1"] as $key => $value ) { 
					if ($widget == $value) {
						$instance['sidebarname'] = 'Non-Home Sidebar'; 
						$instance['photowidth'] = get_option('non_home_right_column');
						$photodisplaywidth = $instance['photowidth']; 
						$thumbnailsize="permalink";
						}
				}
				foreach ($sidebartest["sidebar-2"] as $key => $value ) { 
					if ($widget == $value) {
						$instance['sidebarname'] = 'Home Main Column'; 
						$instance['photowidth'] = get_option('home_full_width_column');
						$photodisplaywidth = $instance['photowidth']; 
						$thumbnailsize="permalink";
						}
				}
				foreach ($sidebartest["sidebar-3"] as $key => $value ) { 
					if (($widget == $value) && ($columnwidth == "even")) {
						$instance['sidebarname'] = 'Home Bottom Left'; 
						$instance['photowidth'] = get_option('home_left_column');
						$photodisplaywidth = $instance['photowidth']; 
						$thumbnailsize="home280";
						}
					if (($widget == $value) && ($columnwidth == "wide")) {
						$instance['sidebarname'] = 'Home Bottom Narrow';
						$instance['photowidth'] = get_option('home_narrow_column');
						$photodisplaywidth = $instance['photowidth']; 
						$thumbnailsize="home160";
						}
				}
				foreach ($sidebartest["sidebar-4"] as $key => $value ) { 
					if (($widget == $value) && ($columnwidth == "even")) {
						$instance['sidebarname'] = 'Home Bottom Right'; 
						$instance['photowidth'] = get_option('home_center_column');
						$photodisplaywidth = $instance['photowidth']; 
						$thumbnailsize="home280";
						}
					if (($widget == $value) && ($columnwidth == "wide")) {
						$instance['sidebarname'] = 'Home Bottom Wide';
						$instance['photowidth'] = get_option('home_wide_column');
						$photodisplaywidth = $instance['photowidth']; 
						$thumbnailsize="home400";
						}
				}
				foreach ($sidebartest["sidebar-5"] as $key => $value ) { 
					if ($widget == $value) {
						$instance['sidebarname'] = 'Home Sidebar'; 
						$instance['photowidth'] = get_option('home_right_column');
						$photodisplaywidth = $instance['photowidth']; 
						$thumbnailsize="permalink";
						}
				}
				foreach ($sidebartest["sidebar-6"] as $key => $value ) { 
					if ($widget == $value) {
						$instance['sidebarname'] = 'Ads Sidebar';
						$instance['photowidth'] = get_option('home_narrow_column');
						} 
				}
		
		echo '<div class="widgetwrap">'; ?>
			<?php $customcolors=$instance['custom-colors']; include(TEMPLATEPATH . "/widgetstyles.php"); ?>
			<?php $number = $this->number; ?>
			<div class="productshowcase">				
			<!--javascript controls for scrollbox-->
			
				<script type="text/javascript">
					$(function() {
					$(".newsticker-jcarousellite<?php echo $number; ?>").jCarouselLite({
        					visible: 1,
        					auto: 0,
        					speed: 666,
							btnNext: ".next<?php echo $number; ?>",
							btnPrev: ".prev<?php echo $number; ?>"
						    });
					});
				</script>
			
					<?php $productcount = $instance['sports-scrollbox']; if ($productcount == "") $productcount = 5;
                	$count=0; $recent = query_posts('cat=' . $instance['category'] . '&showposts=' . $productcount); if (have_posts()) : while (have_posts()) : the_post(); $count++; 
					global $post;
            		$width = $instance['photowidth'];

					if ($count==1) { $exitkey=6; ?>

    									<div id="newsticker-demo<?php echo $number; ?>" style="width:<?php echo $width; ?>px">    
        								<div class="newsticker-jcarousellite<?php echo $number; ?>" style="width:<?php echo $width; ?>px">
        								<ul>
								<?php } ?>
                							<li>
                							<div class="sportsscore" style="width:<?php echo $width; ?>px">

<?php if (has_post_thumbnail()) 
			{ the_post_thumbnail( $thumbnailsize, array('class' => 'catboxphoto'));} ?>
								<?php $link = get_post_meta($post->ID, 'customlink', true); $click = get_post_meta($post->ID, 'click_tracker_code', true); ?>
                    							<p class="homeheadline"><?php if ($link) echo '<a target="_blank" href="' . $link . $click .'">'; the_title(); if ($link) echo '</a>'; ?></p>
  												<div class="productteaser"><p><?php the_content_limit(50, ''); ?></p></div>

                    						</div>
                							<div class="clear"></div>
            								</li>

					<?php endwhile; else: endif; ?>

					<?php if ($exitkey==6) { $exitkey=0; ?>
								</ul>
									<button class="prev<?php echo $number; ?> leftarrow"></button>
									<button class="next<?php echo $number; ?> rightarrow"></button>
    							</div>
    							</div>

    				<?php } ?>
				
			</div>
			</div>
			
<div <?php if ($customcolors==on) { ?>style="background-color:<?php echo $instance['header-color']; ?> !important;"<?php } ?>class="widgetfooter<?php if ($instance['widget-style']=="Style 3") { ?>3<?php } else { ?>1<?php } ?>"></div></div>
		
  	<?php } 
		function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['school'] = strip_tags( $new_instance['school'] );
		$instance['sports-scrollbox'] = $new_instance['sports-scrollbox'];
		$instance['sports-scrollbox-visible'] = $new_instance['sports-scrollbox-visible'];
		$instance['sports-scrollbox-number'] = $new_instance['sports-scrollbox-number'];
		$instance['sports-scroll-style'] = $new_instance['sports-scroll-style'];
		$instance['sports-speed'] = $new_instance['sports-speed'];
		$instance['sports-transition'] = $new_instance['sports-transition'];
		$instance['widget-style'] = $new_instance['widget-style'];
 		$instance['custom-colors'] = ( isset( $new_instance['custom-colors'] ) ? on : "" );  
		$instance['header-color'] = $new_instance['header-color'];
		$instance['header-text'] = $new_instance['header-text'];
		$instance['widget-border'] = $new_instance['widget-border'];
		$instance['widget-background'] = $new_instance['widget-background'];
		$instance['border-thickness'] = $new_instance['border-thickness'];
		$instance['sidebarname'] = $new_instance['sidebarname'];
		$instance['photowidth'] = $new_instance['photowidth'];
		$instance['category'] = $new_instance['category'];
		return $instance;
	}

	function form($instance) { 
			$defaults = array( 'title' => 'Product Showcase', 'sports-scrollbox' => '10', 'sports-scroll-style' => 'horizontal', 'sports-speed' => '4000', 'sports-transition' => '666', 'widget-style' => get_theme_mod('widget-style'), 'header-color' => get_theme_mod('accentcolor-header'), 'header-text' => '#ffffff', 'widget-border' => '#aaaaaa', 'widget-background' => '#eeeeee', 'border-thickness' => '1px' );
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<?php 
		global $registered_sidebar; $sidebarname = $registered_sidebar['name']; 
		if ($sidebarname) { $instance['sidebarname'] = $sidebarname; } 
		if ($sidebarname == "Home Sidebar") { $photowidth=get_option('home_right_column'); } 
		if (($sidebarname == "Non-Home Sidebar") || ($sidebarname == "Sports Center Sidebar")) { $photowidth=get_option('non_home_right_column'); } 
		if ($sidebarname == "Home Bottom Narrow") { $photowidth=get_option('home_narrow_column'); }
		if ($sidebarname == "Home Bottom Wide") { $photowidth=get_option('home_wide_column'); }
		if ($sidebarname == "Home Main Column") { $photowidth=get_option('home_right_column'); }
		if ($sidebarname == "Home Bottom Left") { $photowidth=get_option('home_left_column'); }
		if ($sidebarname == "Home Bottom Right") { $photowidth=get_option('home_center_column'); } 
		if ($photowidth) { $instance['photowidth'] = $photowidth; }
		if ($sidebarname) { $instance['sidebarname'] = $sidebarname; } ?>


		<div style="float:left;width:230px;margin-right:20px;border-right:1px solid #aaaaaa;padding-right:10px;">
		<p style="font-weight:bold;text-decoration:underline">Widget Content</p>
		<input type="hidden" id="<?php echo $this->get_field_id('sidebarname'); ?>" name="<?php echo $this->get_field_name('sidebarname'); ?>" value="<?php echo $instance['sidebarname']; ?>" />
		<input type="hidden" id="<?php echo $this->get_field_id('photowidth'); ?>" name="<?php echo $this->get_field_name('photowidth'); ?>" value="<?php echo $instance['photowidth']; ?>" />
			
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e("Title"); ?>:</label><br />
			<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:95%;" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e("Select your showcase category:"); ?></label><br />		
		<?php wp_dropdown_categories(array('selected' => $instance['category'], 'name' => $this->get_field_name( 'category' ), 'orderby' => 'Name' , 'hierarchical' => 1, 'show_option_none' => __("None", 'studiopress'), 'hide_empty' => '0' )); ?>
		</p>
		<p>
			<input type="text" id="<?php echo $this->get_field_id('sports-scrollbox'); ?>" name="<?php echo $this->get_field_name('sports-scrollbox'); ?>" value="<?php echo $instance['sports-scrollbox']; ?>" size="2" /> Number of products to cycle through scrollbox? 
		</p>
		<p>
			<select id="<?php echo $this->get_field_id( 'sports-scroll-style' ); ?>" name="<?php echo $this->get_field_name( 'sports-scroll-style' ); ?>">
				<option value="vertical" <?php if ( 'vertical' == $instance['sports-scroll-style'] ) echo 'selected="selected"'; ?>>vertical</option>
				<option value="horizontal" <?php if ( 'horizontal' == $instance['sports-scroll-style'] ) echo 'selected="selected"'; ?>>horizontal</option>
			</select>
			<label for="<?php echo $this->get_field_id( 'sports-scroll-style' ); ?>">Slide Direction</label>
		<br />

			<select id="<?php echo $this->get_field_id( 'sports-speed' ); ?>" name="<?php echo $this->get_field_name( 'sports-speed' ); ?>">
				<option value="2000" <?php if ( '2000' == $instance['sports-speed'] ) echo 'selected="selected"'; ?>>2 Seconds</option>
				<option value="3000" <?php if ( '3000' == $instance['sports-speed'] ) echo 'selected="selected"'; ?>>3 Seconds</option>
				<option value="4000" <?php if ( '4000' == $instance['sports-speed'] ) echo 'selected="selected"'; ?>>4 Seconds</option>
				<option value="5000" <?php if ( '5000' == $instance['sports-speed'] ) echo 'selected="selected"'; ?>>5 Seconds</option>
				<option value="6000" <?php if ( '6000' == $instance['sports-speed'] ) echo 'selected="selected"'; ?>>6 Seconds</option>
				<option value="7000" <?php if ( '7000' == $instance['sports-speed'] ) echo 'selected="selected"'; ?>>7 Seconds</option>
				<option value="8000" <?php if ( '8000' == $instance['sports-speed'] ) echo 'selected="selected"'; ?>>8 Seconds</option>
			</select>
			<label for="<?php echo $this->get_field_id( 'sports-speed' ); ?>">Slide Duration</label>
		<br />
		
			<select id="<?php echo $this->get_field_id( 'sports-transition' ); ?>" name="<?php echo $this->get_field_name( 'sports-transition' ); ?>">
				<option value="333" <?php if ( '333' == $instance['sports-transition'] ) echo 'selected="selected"'; ?>>Fast</option>
				<option value="666" <?php if ( '666' == $instance['sports-transition'] ) echo 'selected="selected"'; ?>>Medium</option>
				<option value="1000" <?php if ( '1000' == $instance['sports-transition'] ) echo 'selected="selected"'; ?>>Slow</option>
			</select>
			<label for="<?php echo $this->get_field_id( 'sports-transition' ); ?>">Slide Transition Time</label>
		</p>

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
			<input class="colorwellscore<?php echo $number; ?>" id="<?php echo $this->get_field_id('header-color'); ?>" name="<?php echo $this->get_field_name('header-color'); ?>" type="text" maxlength="7" size="7" value="<?php echo $instance['header-color']; ?>" /> Header Bar <br />
			<input class="colorwellscore<?php echo $number; ?>" id="<?php echo $this->get_field_id('header-text'); ?>" name="<?php echo $this->get_field_name('header-text'); ?>" type="text" maxlength="7" size="7" value="<?php echo $instance['header-text']; ?>" /> Header Bar Text<br />
			<input class="colorwellscore<?php echo $number; ?>" id="<?php echo $this->get_field_id('widget-border'); ?>" name="<?php echo $this->get_field_name('widget-border'); ?>" type="text" maxlength="7" size="7" value="<?php echo $instance['widget-border']; ?>" /> Border<br />
			<input class="colorwellscore<?php echo $number; ?>" id="<?php echo $this->get_field_id('widget-background'); ?>" name="<?php echo $this->get_field_name('widget-background'); ?>" type="text" maxlength="7" size="7" value="<?php echo $instance['widget-background']; ?>" /> Background
		</p>
<script>
		  jQuery(document).ready(function() {
    var f = jQuery.farbtastic('#snocolorpickerscore<?php echo $number; ?>');
    var p = jQuery('#snocolorpickerscore<?php echo $number; ?>').css('opacity', 0.25);
    var selected;
    jQuery('.colorwellscore<?php echo $number; ?>')
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
    jQuery('#snocolorpickerscore<?php echo $number; ?>').hide();
    jQuery('#snocolorpickerscore<?php echo $number; ?>').farbtastic(".colorwellscore<?php echo $number; ?>");
    jQuery(".colorwellscore<?php echo $number; ?>").click(function(){jQuery('#snocolorpickerscore<?php echo $number; ?>').slideDown()});
  });
</script>
		<div id="snocolorpickerscore<?php echo $number; ?>"></div>
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