<?php
/*
Plugin Name: GoPublish Category Display Widget
Description: This plugin/widget allows you to place a category box in your sidebar.
Author: School Newspapers Online
Author URI: http://www.schoolnewspapersonline.com/
Version: 1.1
*/

add_action('widgets_init', create_function('', "register_widget('sno_category');"));
class sno_category extends WP_Widget {

	function sno_category() {
		$widget_ops = array( 'classname' => 'GoPublish Category Widget', 'description' => 'Use this widget to add a Category Display box.' );
		$control_ops = array( 'width' => 500, 'height' => 250, 'id_base' => 'category' );
		$this->WP_Widget( 'category', 'GoPublish Category Widget', $widget_ops, $control_ops );
	}

	function widget($args, $instance) {
		extract($args);
 		$totalstories=$instance['number']+$instance['number-headlines'];		
		if (($instance['category'] == -1) || ($totalstories <= 0)) {} else {
		echo '<div class="widgetwrap">';


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

		$categoryslug = cat_id_to_slug($instance['category']); $categoryname = cat_id_to_name($instance['category']);$customcolors=$instance['custom-colors'];


			include(TEMPLATEPATH . "/widgetstyles.php"); ?>

					<!--start of category loop and display-->
			<?php if((!is_int($totalstories)) || ($totalstories==0)) $totalstories=1; $storydivider = $instance['number']+1; $count=0;	
            query_posts('cat=' . $instance['category'] . '&showposts=' . $totalstories); if (have_posts()) : while (have_posts()) : the_post(); global $post; $count++; 
            if ($count <= $instance['number']) {              
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
						
					
					if ($instance['show-caption']==on) {
                		$photographer=get_post_meta($post->ID, photographer, true); if ($photographer) { ?><p class="photocredit">Photo Credit: <?php echo $photographer; ?></p>
                		<?php } 
                    	$caption=get_post_meta($post->ID, caption, true); ?><p class="photocaption" style="padding-bottom:8px !important"><?php echo $caption; ?></p>
						<?php }
				if (($marginkey != 3) && ($photocheck == 5)) { ?></div><?php }
			
			$headlinesize = $instance['headline-size']; $headlineheight = floor($headlinesize * 1.5); ?>
			<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><h3 class="homeheadline" style="font-size:<?php echo $headlinesize; ?>px; line-height:<?php echo $headlineheight; ?>px;"><?php the_title(); ?></h3></a>
            <?php $writer = get_post_meta($post->ID, writer, true); if (($writer) && ($instance['show-writer']==on)) { ?><p class="writer"><?php snowriter(); ?></p> <?php } 
  			$teaser = $instance['category-teaser']; 
  			if ($teaser) the_content_limit($teaser, "<span class='readmore'>read story</span>");
  			if (($instance['show-date']==on) || ((get_theme_mod('comments')=="Enable") && ($instance['show-comments']==on)) || (is_user_logged_in())) { ?><p class="datetime"><?php
            if ($instance['show-date']==on) { ?><?php the_time('F j, Y '); }
            if (($instance['show-date']==on) && ((get_theme_mod('comments')=="Enable") && ($instance['show-comments']==on))) echo ' &bull; '; 
            if ((get_theme_mod('comments')=="Enable") && ($instance['show-comments']==on)) { comments_popup_link(' 0 comments', ' 1 comment', ' % comments'); } 
    		edit_post_link('Edit this story', ' &bull; ', ''); ?></p><?php } 
    		?>

			<?php if (($count >= 1) && ($count < $totalstories) && ($totalstories!=1)) { ?><?php if ($instance['dividing-line']==on) { ?><div class="storybottom"></div><?php } else { ?><div class="storybottomnoline"></div><?php } ?><?php } ?>

                 <?php } else { ?><!--end of first time through loop-->
				<?php if (($count==$storydivider) && ($instance['headline-header'] == on)) { ?>
						<a href="/<?php echo $categoryslug; ?>"><p class="sectionhead" style="font-size:14px;margin-top:15px;margin-bottom:7px;font-weight:bold;">Recent <?php echo $categoryname; ?> Stories</p></a>
				<?php } ?>

				<?php if ($instance['bullet-list']==on) { ?>
				<?php if ($exitkey != 5) { echo '<ul>'; $exitkey=5; } ?>
                  	<li><a class="homeheadline" href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php if ($instance['teaser-date']==on) { ?><?php the_time(' F j, Y'); ?><?php } ?></li>
				<?php } else { ?>


                  <?php if($instance['teaser-thumb']==on) { 
                  $thumbplacement=$instance['teaser-thumb-placement']; ?>
                  
<?php global $post; $feature_photo = get_post_meta($post->ID, feature_photo, true); if (has_post_thumbnail()) 
			{ the_post_thumbnail( 'homethumb', array('class' => 'catboxthumb', 'style' => 'margin-bottom:10px; float:'.$thumbplacement.'; margin-'.$thumbplacement.':0px;'));} 
	else if ($feature_photo) { ?><a href="<?php the_permalink(); ?>"><img src="<?php echo $feature_photo; ?>" class="catboxthumb" style="float:<?php echo $thumbplacement; ?>;margin-bottom:10px;margin-<?php echo $thumbplacement; ?>:0px;width:70px" /></a><?php } 
	else 
			{ global $wpdb; $attachment_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_parent = '$post->ID' AND post_status = 'inherit' AND post_type='attachment' ORDER BY post_date DESC LIMIT 1"); 
$attachment = wp_get_attachment_url($attachment_id); if ($attachment) { ?><a href="<?php the_permalink(); ?>"><img src="<?php echo $attachment; ?>" class="catboxthumb" style="float:<?php echo $thumbplacement; ?>;margin-bottom:10px;margin-<?php echo $thumbplacement; ?>:0px;width:70px" /></a><?php } } ?>

					<?php } ?>
                  <p><a class="homeheadline" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p><?php if ($instance['teaser-date']==on) { ?><p><?php the_time(' F j, Y'); ?></p><?php } ?>

                  <?php $teaser = $instance['headline-teaser']; if ($teaser) the_content_limit($teaser, "Read more &raquo;"); ?>
				<div style="clear:both;margin-top:15px"></div>
                 <?php }}        

        endwhile; else: endif;
        
        if ($exitkey == 5) { ?></ul><?php $exitkey = 0; }

        if ($instance['view-all']==on) { ?>
			<?php if ($instance['dividing-line']==on) { ?><div class="storybottom"></div><?php } else { ?><div class="storybottomnoline"></div><?php } ?>
					<a href="<?php echo cat_id_to_slug($instance['category']); ?>"><p class="viewall">View All <span class="arrows"> &raquo;</span></p></a>
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
		$instance['category'] = $new_instance['category'];
		$instance['number'] = $new_instance['number'];
		$instance['number-headlines'] = $new_instance['number-headlines'];
		$instance['category-photo-placement'] = $new_instance['category-photo-placement'];
		$instance['teaser-thumb-placement'] = $new_instance['teaser-thumb-placement'];
		$instance['category-photo-size'] = $new_instance['category-photo-size'];
		$instance['photowidth'] = $new_instance['photowidth'];
		$instance['sidebarname'] = $new_instance['sidebarname'];
		$instance['category-teaser'] = $new_instance['category-teaser'];
		$instance['headline-teaser'] = $new_instance['headline-teaser'];
		$instance['headline-size'] = $new_instance['headline-size'];
 		$instance['show-writer'] = ( isset( $new_instance['show-writer'] ) ? on : "" );  
 		$instance['show-date'] = ( isset( $new_instance['show-date'] ) ? on : "" );  
 		$instance['show-comments'] = ( isset( $new_instance['show-comments'] ) ? on : "" );  
 		$instance['show-caption'] = ( isset( $new_instance['show-caption'] ) ? on : "" );  
 		$instance['view-all'] = ( isset( $new_instance['view-all'] ) ? on : "" );  
 		$instance['teaser-thumb'] = ( isset( $new_instance['teaser-thumb'] ) ? on : "" );  
 		$instance['teaser-date'] = ( isset( $new_instance['teaser-date'] ) ? on : "" );  
 		$instance['dividing-line'] = ( isset( $new_instance['dividing-line'] ) ? on : "" );  
 		$instance['headline-header'] = ( isset( $new_instance['headline-header'] ) ? on : "" );  
 		$instance['bullet-list'] = ( isset( $new_instance['bullet-list'] ) ? on : "" );  
		return $instance;
	}

	function form($instance) { 
		$defaults = array( 'number' => '1', 'number-headlines' => '3', 'headline-size' => '18', 'category-photo-placement' => 'Left', 'category-photo-size' => 'Medium', 'border-thickness' => '1px','category-teaser' => '170','headline-teaser' => '0', 'show-writer' => 'on', 'view-all' => 'on', 'show-date' => 'on', 'show-comments' => 'on', 'show-caption' => '', 'teaser-date' => 'on', 'teaser-thumb' => 'on', 'teaser-thumb-placement' => 'Left', 'widget-style'=>get_theme_mod('widget-style'), 'bullet-list' => 'on', 'header-color' => get_theme_mod('accentcolor-header'), 'header-text' => '#ffffff', 'widget-border' => '#aaaaaa', 'widget-background' => '#eeeeee', 'border-thickness' => '1px' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<div style="float:left;width:230px;margin-right:20px;border-right:1px solid #aaaaaa;padding-right:10px;">
		<p style="font-weight:bold;text-decoration:underline">Widget Content</p>
		<p>Select your category.<br />
			<?php wp_dropdown_categories(array('selected' => $instance['category'], 'name' => $this->get_field_name( 'category' ), 'orderby' => 'Name' , 'hierarchical' => 1, 'show_option_none' => __("None", 'studiopress'), 'hide_empty' => '0' )); ?>
		</p>
		<?php $categorytitle = cat_id_to_name($instance['category']); ?><input type="hidden" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $categorytitle; ?>" />
				<div style="width:210px;border-bottom:1px solid #aaaaaa;margin-bottom:10px;"></div>

		<p>
			<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" maxlength="1" size="1" value="<?php echo $instance['number']; ?>" />
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of Stories'); ?></label>
		<br />
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
			<input class="checkbox" type="checkbox" <?php if ($instance['show-caption'] == on) echo checked; ?> id="<?php echo $this->get_field_id( 'show-caption' ); ?>" name="<?php echo $this->get_field_name( 'show-caption' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show-caption' ); ?>">Show Caption</label>			
		<br />

			<input class="checkbox" type="checkbox" <?php if ($instance['show-writer'] == on) echo checked; ?> id="<?php echo $this->get_field_id( 'show-writer' ); ?>" name="<?php echo $this->get_field_name( 'show-writer' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show-writer' ); ?>">Show Byline</label>			
		<br />

			<input class="checkbox" type="checkbox" <?php if ($instance['show-date'] == on) echo checked; ?> id="<?php echo $this->get_field_id( 'show-date' ); ?>" name="<?php echo $this->get_field_name( 'show-date' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show-date' ); ?>">Show Date</label>			
		<br />

			<input class="checkbox" type="checkbox" <?php if ($instance['show-comments'] == on) echo checked; ?> id="<?php echo $this->get_field_id( 'show-comments' ); ?>" name="<?php echo $this->get_field_name( 'show-comments' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show-comments' ); ?>">Show Comments Link?</label>			
		<br />

			<select id="<?php echo $this->get_field_id( 'headline-size' ); ?>" name="<?php echo $this->get_field_name( 'headline-size' ); ?>">
				<option value="14" <?php if ( '14' == $instance['headline-size'] ) echo 'selected="selected"'; ?>>14</option>
				<option value="16" <?php if ( '16' == $instance['headline-size'] ) echo 'selected="selected"'; ?>>16</option>
				<option value="18" <?php if ( '18' == $instance['headline-size'] ) echo 'selected="selected"'; ?>>18</option>
				<option value="20" <?php if ( '20' == $instance['headline-size'] ) echo 'selected="selected"'; ?>>20</option>
				<option value="22" <?php if ( '22' == $instance['headline-size'] ) echo 'selected="selected"'; ?>>22</option>
				<option value="24" <?php if ( '24' == $instance['headline-size'] ) echo 'selected="selected"'; ?>>24</option>
				<option value="26" <?php if ( '26' == $instance['headline-size'] ) echo 'selected="selected"'; ?>>26</option>
			</select>
			<label for="<?php echo $this->get_field_id( 'headline-size' ); ?>">Headline Size</label>
		<br />
		<input id="<?php echo $this->get_field_id('category-teaser'); ?>" name="<?php echo $this->get_field_name('category-teaser'); ?>" type="text" maxlength="3" size="3" value="<?php echo $instance['category-teaser']; ?>" />
		<label for="<?php echo $this->get_field_id('category-teaser'); ?>">Teaser Length (characters)</label>
		<br />
		<input class="checkbox" type="checkbox" <?php if ($instance['dividing-line'] == on) echo checked; ?> id="<?php echo $this->get_field_id( 'dividing-line' ); ?>" name="<?php echo $this->get_field_name( 'dividing-line' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'dividing-line' ); ?>"> Show Dividing Lines</label>
		</p>
		<div style="width:210px;border-bottom:1px solid #aaaaaa;margin-bottom:10px;"></div>

			<p>
			<input class="checkbox" type="checkbox" <?php if ($instance['headline-header'] == on) echo checked; ?> id="<?php echo $this->get_field_id( 'headline-header' ); ?>" name="<?php echo $this->get_field_name( 'headline-header' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'headline-header' ); ?>"> Show Recent Headlines Header</label><br />

			<input class="checkbox" type="checkbox" <?php if ($instance['bullet-list'] == on) echo checked; ?> id="<?php echo $this->get_field_id( 'bullet-list' ); ?>" name="<?php echo $this->get_field_name( 'bullet-list' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'bullet-list' ); ?>"> Show as Bullet List</label><br />
			
			<input id="<?php echo $this->get_field_id('number-headlines'); ?>" name="<?php echo $this->get_field_name('number-headlines'); ?>" type="text" maxlength="1" size="1" value="<?php echo $instance['number-headlines']; ?>" />
	        <label for="<?php echo $this->get_field_id('number-headlines'); ?>"><?php _e('Number of Extra Headlines'); ?></label><br />
			<input id="<?php echo $this->get_field_id('headline-teaser'); ?>" name="<?php echo $this->get_field_name('headline-teaser'); ?>" type="text" maxlength="3" size="3" value="<?php echo $instance['headline-teaser']; ?>" />
			<label for="<?php echo $this->get_field_id('headline-teaser'); ?>">Teaser Length (characters)</label><br />

			<input class="checkbox" type="checkbox" <?php if ($instance['teaser-thumb'] == on) echo checked; ?> id="<?php echo $this->get_field_id( 'teaser-thumb' ); ?>" name="<?php echo $this->get_field_name( 'teaser-thumb' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'teaser-thumb' ); ?>"> Show Thumbnails</label><br />

			<select id="<?php echo $this->get_field_id( 'teaser-thumb-placement' ); ?>" name="<?php echo $this->get_field_name( 'teaser-thumb-placement' ); ?>">
				<option value="left" <?php if ( 'left' == $instance['teaser-thumb-placement'] ) echo 'selected="selected"'; ?>>Left</option>
				<option value="right" <?php if ( 'right' == $instance['teaser-thumb-placement'] ) echo 'selected="selected"'; ?>>Right</option>
			</select>
			<label for="<?php echo $this->get_field_id( 'teaser-thumb-placement' ); ?>">Thumbnail Placement</label><br />
			
			<input class="checkbox" type="checkbox" <?php if ($instance['teaser-date'] == on) echo checked; ?> id="<?php echo $this->get_field_id( 'teaser-date' ); ?>" name="<?php echo $this->get_field_name( 'teaser-date' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'teaser-date' ); ?>"> Show Date</label><br />

			<input class="checkbox" type="checkbox" <?php if ($instance['view-all'] == on) echo checked; ?> id="<?php echo $this->get_field_id( 'view-all' ); ?>" name="<?php echo $this->get_field_name( 'view-all' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'view-all' ); ?>"> Show "View All" Link</label>
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
			<label for="<?php echo $this->get_field_id( 'category-photo-size' ); ?>">Widget Style</label>
		</p>

		<p>
			<input class="checkbox" type="checkbox" <?php if ($instance['custom-colors'] == on) echo checked; ?> id="<?php echo $this->get_field_id( 'custom-colors' ); ?>" name="<?php echo $this->get_field_name( 'custom-colors' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'custom-colors' ); ?>">Turn on Custom Widget Colors</label>			
		</p>
		<p>Save this widget to make the color selector active.</p>
<?php $number = $this->number; ?>

		<p>
			<input class="colorwellcat<?php echo $number; ?>" id="<?php echo $this->get_field_id('header-color'); ?>" name="<?php echo $this->get_field_name('header-color'); ?>" type="text" maxlength="7" size="7" value="<?php echo $instance['header-color']; ?>" /> Header Bar <br />
			<input class="colorwellcat<?php echo $number; ?>" id="<?php echo $this->get_field_id('header-text'); ?>" name="<?php echo $this->get_field_name('header-text'); ?>" type="text" maxlength="7" size="7" value="<?php echo $instance['header-text']; ?>" /> Header Bar Text<br />
			<input class="colorwellcat<?php echo $number; ?>" id="<?php echo $this->get_field_id('widget-border'); ?>" name="<?php echo $this->get_field_name('widget-border'); ?>" type="text" maxlength="7" size="7" value="<?php echo $instance['widget-border']; ?>" /> Border<br />
			<input class="colorwellcat<?php echo $number; ?>" id="<?php echo $this->get_field_id('widget-background'); ?>" name="<?php echo $this->get_field_name('widget-background'); ?>" type="text" maxlength="7" size="7" value="<?php echo $instance['widget-background']; ?>" /> Background
		</p>
<script>
		  jQuery(document).ready(function() {
    var f = jQuery.farbtastic('#snocolorpickercat<?php echo $number; ?>');
    var p = jQuery('#snocolorpickercat<?php echo $number; ?>').css('opacity', 0.25);
    var selected;
    jQuery('.colorwellcat<?php echo $number; ?>')
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
    jQuery('#snocolorpickercat<?php echo $number; ?>').hide();
    jQuery('#snocolorpickercat<?php echo $number; ?>').farbtastic(".colorwellcat<?php echo $number; ?>");
    jQuery(".colorwellcat<?php echo $number; ?>").click(function(){jQuery('#snocolorpickercat<?php echo $number; ?>').slideDown()});
  });
</script>
		<div id="snocolorpickercat<?php echo $number; ?>"></div>
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