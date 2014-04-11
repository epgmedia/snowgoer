<?php
/*
Plugin Name: GoPublish Page Teaser Display
Description: This plugin/widget allows you to place a teaser widget for one of your pages in any of your widget areas.
Author: School Newspapers Online
Author URI: http://www.schoolnewspapersonline.com/
Version: 1.1
*/

add_action('widgets_init', create_function('', "register_widget('sno_page');"));
class sno_page extends WP_Widget {

	function sno_page() {
		$widget_ops = array( 'classname' => 'GoPublish Page Widget', 'description' => 'Use this widget to add a teaser box for one of your pages.' );
		$control_ops = array( 'width' => 500, 'height' => 250, 'id_base' => 'page' );
		$this->WP_Widget( 'page', 'GoPublish Page Widget', $widget_ops, $control_ops );
	}

	function widget($args, $instance) {
		extract($args);
 		$totalstories=$instance['number']+$instance['number-headlines'];		
		if ($instance['page'] == "") {} else {

				$widget = $this->id; $sidebartest = get_option('sidebars_widgets'); 
				$columns = get_theme_mod('sno-layout'); 
					if (($columns == "Option 3") || ($columns == "Option 6")) { $columnwidth = "even"; } else { $columnwidth = "wide"; }
					
				foreach ($sidebartest["sidebar-1"] as $key => $value ) { 
					if ($widget == $value) {
						$instance['sidebarname'] = 'Non-Home Sidebar'; 
						$instance['photowidth'] = get_option('non_home_right_column');
						}
				}
				foreach ($sidebartest["sidebar-2"] as $key => $value ) { 
					if ($widget == $value) {
						$instance['sidebarname'] = 'Home Main Column'; 
						$instance['photowidth'] = get_option('home_right_column');
						}
				}
				foreach ($sidebartest["sidebar-3"] as $key => $value ) { 
					if (($widget == $value) && ($columnwidth == "even")) {
						$instance['sidebarname'] = 'Home Bottom Left'; 
						$instance['photowidth'] = get_option('home_left_column');
						}
					if (($widget == $value) && ($columnwidth == "wide")) {
						$instance['sidebarname'] = 'Home Bottom Narrow';
						$instance['photowidth'] = get_option('home_narrow_column');
						}
				}
				foreach ($sidebartest["sidebar-4"] as $key => $value ) { 
					if (($widget == $value) && ($columnwidth == "even")) {
						$instance['sidebarname'] = 'Home Bottom Right'; 
						$instance['photowidth'] = get_option('home_center_column');
						}
					if (($widget == $value) && ($columnwidth == "wide")) {
						$instance['sidebarname'] = 'Home Bottom Wide';
						$instance['photowidth'] = get_option('home_wide_column');
						}
				}
				foreach ($sidebartest["sidebar-5"] as $key => $value ) { 
					if ($widget == $value) {
						$instance['sidebarname'] = 'Home Sidebar'; 
						$instance['photowidth'] = get_option('home_right_column');
						}
				}
				foreach ($sidebartest["sidebar-6"] as $key => $value ) { 
					if ($widget == $value) {
						$instance['sidebarname'] = 'Ads Sidebar';
						$instance['photowidth'] = get_option('home_narrow_column');
						} 
				}

		echo '<div class="widgetwrap">';
		$customcolors=$instance['custom-colors']; $categoryname = get_the_title($instance['page']); $categoryslug = get_permalink($instance['page']); $pageid=$instance['page'];


			include(TEMPLATEPATH . "/widgetstyles.php"); ?>

					<!--start of category loop and display-->
			<?php $the_query = new WP_Query( 'page_id=' . $instance['page'] );
while ( $the_query->have_posts() ) : $the_query->the_post(); 

				$homewidecolumn = get_option('home_wide_column');
				if (($instance['category-photo-size'] == "Large") && ($instance['sidebarname'] == "Home Bottom Wide")) { $photodisplaywidth = $instance['photowidth']; $thumbnailsize="home400"; }
				else if (($instance['category-photo-size'] == "Large") && ($instance['sidebarname'] == "Home Main Column")) { $photodisplaywidth = $instance['photowidth']; $thumbnailsize="permalink"; }
				else if ((($instance['category-photo-size'] == "Large") && ($instance['sidebarname'] == "Home Bottom Right")) || (($instance['category-photo-size'] == "Large") && ($instance['sidebarname'] == "Home Bottom Left"))){ $photodisplaywidth = $instance['photowidth']; $thumbnailsize="home280"; }
				else if (($instance['category-photo-size'] == "Large") && ($instance['sidebarname'] == "Home Bottom Narrow")) { $photodisplaywidth = $instance['photowidth']; $thumbnailsize="home160"; }
				else if ((($instance['category-photo-size'] == "Large") && ($instance['sidebarname'] == "Home Sidebar")) || (($instance['category-photo-size'] == "Large") && ($instance['sidebarname'] == "Non-Home Sidebar")) || (($instance['category-photo-size'] == "Large") && ($instance['sidebarname'] == "Sports Center Sidebar"))) { $photodisplaywidth = $instance['photowidth']; $thumbnailsize="permalink"; }
				
				if (($instance['category-photo-size'] == "Small") && ($instance['sidebarname'] == "Home Bottom Wide")) { $photodisplaywidth = get_option('home_narrow_column'); $thumbnailsize="home160"; } 
				else if (($instance['category-photo-size'] == "Small") && ($instance['sidebarname'] == "Home Main Column")) { $photodisplaywidth = get_option('home_narrow_column'); $thumbnailsize="home160"; } 
				else if (($instance['category-photo-size'] == "Small") && ($instance['sidebarname'] == "Home Bottom Narrow")) { $photodisplaywidth = get_option('home_narrow_column'); $thumbnailsize="home160"; } 
				else if ($instance['category-photo-size'] == "Small") { $photodisplaywidth = 120; $thumbnailsize="home120"; } 
				
				if (($instance['category-photo-size'] == "Medium") && ($instance['sidebarname'] == "Home Bottom Wide")) { $photodisplaywidth = 200; $thumbnailsize="archive"; } 
				else if (($instance['category-photo-size'] == "Medium") && ($instance['sidebarname'] == "Home Main Column")) { $photodisplaywidth = 200; $thumbnailsize="archive"; } 
				else if ($instance['category-photo-size'] == "Medium") { $photodisplaywidth = get_option('home_narrow_column'); $thumbnailsize="home160"; }
				
				if ($photodisplaywidth=="") { $photodisplaywidth = get_option('home_narrow_column'); $thumbnailsize="home160"; } 
				
				if (($photodisplaywidth==get_option('home_right_column')) && ($instance['sidebarname']=="Home Sidebar")) { $marginkey = 3; }
				if (($photodisplaywidth==get_option('home_narrow_column')) && ($instance['sidebarname']=="Home Bottom Narrow")) { $marginkey = 3; }
				if (($photodisplaywidth==get_option('non_home_right_column')) && ($instance['sidebarname']=="Non-Home Sidebar")) { $marginkey = 3; }
				if (($photodisplaywidth==get_option('non_home_right_column')) && ($instance['sidebarname']=="Sports Center Sidebar")) { $marginkey = 3; }
				if (($photodisplaywidth==get_option('home_left_column')) && ($instance['sidebarname']=="Home Bottom Left")) { $marginkey = 3; }
				if (($photodisplaywidth==get_option('home_center_column')) && ($instance['sidebarname']=="Home Bottom Right")) { $marginkey = 3; }
				if (($photodisplaywidth==get_option('home_wide_column')) && ($instance['sidebarname']=="Home Bottom Wide")) { $marginkey = 3; }

				$photocheck = 0; if (has_post_thumbnail()) $photocheck = 5;
				if (($marginkey != 3) && ($photocheck == 5)) { ?>

					<div class="catboxthumbnail" style="float:<?php echo $instance['category-photo-placement']; ?>; width: <?php echo $photodisplaywidth; ?>px !important; margin-<?php echo $instance['category-photo-placement']; ?>:0px;">

				<?php } 
						$photodisplaywidth-=2; ?>
						
<?php if (($instance['category-photo-size'] == "Large") && (has_post_thumbnail())) { $catimage =   wp_get_attachment_image_src( get_post_thumbnail_id(), 'home400'); ?><a href="<?php the_permalink(); ?>"><img src="<?php echo $catimage[0]; ?>" style="width:100%" class="catboxphoto" alt="<?php the_title(); ?>" /></a><?php }

	else if (has_post_thumbnail()) 
			{ the_post_thumbnail( $thumbnailsize, array('class' => 'catboxphoto'));} 
						
					
			 if (($marginkey != 3) && ($photocheck == 5)) { ?></div><?php }
			
			$headlinesize = $instance['headline-size']; $headlineheight = floor($headlinesize * 1.5); ?>
  			<span style="font-size:<?php echo $headlinesize; ?>px; line-height:<?php echo $headlineheight; ?>px;"><?php $teaser = $instance['category-teaser']; 
  			if ($teaser) the_content_limit($teaser, "<span class='readmore'>Read More</span>"); ?></span>
   	 		<?php edit_post_link('Edit this page', '', ''); ?>
			<div style="clear:both"></div>

        <?php endwhile;
                 
        if ($instance['view-all']==on) { ?>
			<?php if ($instance['dividing-line']==on) { ?><div class="storybottom"></div><?php } else { ?><div class="storybottomnoline"></div><?php } ?>
					<a href="<?php echo cat_id_to_slug($instance['category']); ?>"><p class="viewall">View Page <span class="arrows"> &raquo;</span></p></a>
		<?php } ?>

	    </div>
		<!--end of category display-->
				
		<div <?php if ($customcolors==on) { ?>style="background-color:<?php echo $instance['header-color']; ?> !important;"<?php } ?>class="widgetfooter<?php if ($instance['widget-style']=="Style 3") { ?>3<?php } else { ?>1<?php } ?>"></div></div>

<?php } ?>

<?php	}
	

		function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['widget-style'] = $new_instance['widget-style'];
 		$instance['custom-colors'] = ( isset( $new_instance['custom-colors'] ) ? on : "" );  
		$instance['header-color'] = $new_instance['header-color'];
		$instance['header-text'] = $new_instance['header-text'];
		$instance['widget-border'] = $new_instance['widget-border'];
		$instance['widget-background'] = $new_instance['widget-background'];
		$instance['border-thickness'] = $new_instance['border-thickness'];
		$instance['page'] = $new_instance['page'];
		$instance['category-photo-placement'] = $new_instance['category-photo-placement'];
		$instance['category-photo-size'] = $new_instance['category-photo-size'];
		$instance['photowidth'] = $new_instance['photowidth'];
		$instance['sidebarname'] = $new_instance['sidebarname'];
		$instance['category-teaser'] = $new_instance['category-teaser'];
		$instance['headline-size'] = $new_instance['headline-size'];
 		$instance['dividing-line'] = ( isset( $new_instance['dividing-line'] ) ? on : "" );  
 		$instance['view-all'] = ( isset( $new_instance['view-all'] ) ? on : "" );  
		return $instance;
	}

	function form($instance) { 
		$defaults = array( 'headline-size' => '18', 'category-photo-placement' => 'Left', 'category-photo-size' => 'Large', 'border-thickness' => '1px','category-teaser' => '170', 'widget-style'=>get_theme_mod('widget-style'), 'header-color' => get_theme_mod('accentcolor-header'), 'header-text' => '#ffffff', 'widget-border' => '#aaaaaa', 'widget-background' => '#eeeeee', 'border-thickness' => '1px' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<?php 
		global $registered_sidebar; $sidebarname = $registered_sidebar['name']; 
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
		<p>Select your page.<br />
			<?php wp_dropdown_pages(array('selected' => $instance['page'], 'name' => $this->get_field_name( 'page' ), 'orderby' => 'Name' , 'show_option_none' => __("None", 'studiopress') )); ?>
		</p>

				<div style="width:210px;border-bottom:1px solid #aaaaaa;margin-bottom:10px;"></div>

		<p>
			<select id="<?php echo $this->get_field_id( 'category-photo-placement' ); ?>" name="<?php echo $this->get_field_name( 'category-photo-placement' ); ?>">
				<option value="Left" <?php if ( 'Left' == $instance['category-photo-placement'] ) echo 'selected="selected"'; ?>>Left</option>
				<option value="Right" <?php if ( 'Right' == $instance['category-photo-placement'] ) echo 'selected="selected"'; ?>>Right</option>
			</select>
			<label for="<?php echo $this->get_field_id( 'category-photo-placement' ); ?>">Photo Placement</label>
		<br />
			<select id="<?php echo $this->get_field_id( 'category-photo-size' ); ?>" name="<?php echo $this->get_field_name( 'category-photo-size' ); ?>">
				<option value="Small" <?php if ( 'Small' == $instance['category-photo-size'] ) echo 'selected="selected"'; ?>>Small</option>
				<option value="Medium" <?php if ( 'Medium' == $instance['category-photo-size'] ) echo 'selected="selected"'; ?>>Medium</option>
				<option value="Large" <?php if ( 'Large' == $instance['category-photo-size'] ) echo 'selected="selected"'; ?>>Large</option>
			</select>
			<label for="<?php echo $this->get_field_id( 'category-photo-size' ); ?>">Photo Size</label>
		<br />


			<select id="<?php echo $this->get_field_id( 'headline-size' ); ?>" name="<?php echo $this->get_field_name( 'headline-size' ); ?>">
				<option value="12" <?php if ( '12' == $instance['headline-size'] ) echo 'selected="selected"'; ?>>12</option>
				<option value="14" <?php if ( '14' == $instance['headline-size'] ) echo 'selected="selected"'; ?>>14</option>
				<option value="16" <?php if ( '16' == $instance['headline-size'] ) echo 'selected="selected"'; ?>>16</option>
				<option value="18" <?php if ( '18' == $instance['headline-size'] ) echo 'selected="selected"'; ?>>18</option>
				<option value="20" <?php if ( '20' == $instance['headline-size'] ) echo 'selected="selected"'; ?>>20</option>
				<option value="22" <?php if ( '22' == $instance['headline-size'] ) echo 'selected="selected"'; ?>>22</option>
			</select>
			<label for="<?php echo $this->get_field_id( 'headline-size' ); ?>">Text Size</label>
		<br />
		<input id="<?php echo $this->get_field_id('category-teaser'); ?>" name="<?php echo $this->get_field_name('category-teaser'); ?>" type="text" maxlength="3" size="3" value="<?php echo $instance['category-teaser']; ?>" />
		<label for="<?php echo $this->get_field_id('category-teaser'); ?>">Teaser Length (characters)</label>

		<br />
		<input class="checkbox" type="checkbox" <?php if ($instance['dividing-line'] == on) echo checked; ?> id="<?php echo $this->get_field_id( 'dividing-line' ); ?>" name="<?php echo $this->get_field_name( 'dividing-line' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'dividing-line' ); ?>"> Show Dividing Line</label><br />

			<input class="checkbox" type="checkbox" <?php if ($instance['view-all'] == on) echo checked; ?> id="<?php echo $this->get_field_id( 'view-all' ); ?>" name="<?php echo $this->get_field_name( 'view-all' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'view-all' ); ?>"> Show "View Page" Link</label>

		</p>

		
		<input type="hidden" id="<?php echo $this->get_field_id('photowidth'); ?>" name="<?php echo $this->get_field_name('photowidth'); ?>" value="<?php echo $instance['photowidth']; ?>" />
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
			<label for="<?php echo $this->get_field_id( 'category-photo-size' ); ?>">Widget Style</label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php if ($instance['custom-colors'] == on) echo checked; ?> id="<?php echo $this->get_field_id( 'custom-colors' ); ?>" name="<?php echo $this->get_field_name( 'custom-colors' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'custom-colors' ); ?>">Turn on Custom Widget Colors</label>			
		</p>
		<p>Save this widget to make the color selector active.</p>
<?php $number = $this->number; ?>

		<p>
			<input class="colorwellpage<?php echo $number; ?>" id="<?php echo $this->get_field_id('header-color'); ?>" name="<?php echo $this->get_field_name('header-color'); ?>" type="text" maxlength="7" size="7" value="<?php echo $instance['header-color']; ?>" /> Header Bar <br />
			<input class="colorwellpage<?php echo $number; ?>" id="<?php echo $this->get_field_id('header-text'); ?>" name="<?php echo $this->get_field_name('header-text'); ?>" type="text" maxlength="7" size="7" value="<?php echo $instance['header-text']; ?>" /> Header Bar Text<br />
			<input class="colorwellpage<?php echo $number; ?>" id="<?php echo $this->get_field_id('widget-border'); ?>" name="<?php echo $this->get_field_name('widget-border'); ?>" type="text" maxlength="7" size="7" value="<?php echo $instance['widget-border']; ?>" /> Border<br />
			<input class="colorwellpage<?php echo $number; ?>" id="<?php echo $this->get_field_id('widget-background'); ?>" name="<?php echo $this->get_field_name('widget-background'); ?>" type="text" maxlength="7" size="7" value="<?php echo $instance['widget-background']; ?>" /> Background
		</p>
<script>
		  jQuery(document).ready(function() {
    var f = jQuery.farbtastic('#snocolorpickerpage<?php echo $number; ?>');
    var p = jQuery('#snocolorpickerpage<?php echo $number; ?>').css('opacity', 0.25);
    var selected;
    jQuery('.colorwellpage<?php echo $number; ?>')
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
    jQuery('#snocolorpickerpage<?php echo $number; ?>').hide();
    jQuery('#snocolorpickerpage<?php echo $number; ?>').farbtastic(".colorwellpage<?php echo $number; ?>");
    jQuery(".colorwellpage<?php echo $number; ?>").click(function(){jQuery('#snocolorpickerpage<?php echo $number; ?>').slideDown()});
  });
</script>
		<div id="snocolorpickerpage<?php echo $number; ?>"></div>
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

		</div>
		<div style="clear:both"></div>
	<?php 
	}
}
?>