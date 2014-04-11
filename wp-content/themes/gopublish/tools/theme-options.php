<?php
/*
Plugin Name: Theme Options
Author: School Newspapers Online
Author URI: http://www.schoolnewspapersonline.com/

*/
$settings = 'theme_mods_gopublish'; // do not change!

$defaults = array( // define our defaults
		'featured-content' => 'Display',
		'leaderboard-location' => 'Above Header',
		'header_blog_title' => 'Text',
		'top-stories-scrollbox' => 'Display',
		'header-image' => '',
		'header-width' => '960',
		'header-height' => '100',
		'header-background' => 'Transparent',
        'show-links' => 'Quick Links',
		'favicon' => 'http://www.schoolnewspapersonline.com/wp-content/uploads/2008/11/reddot.png',
		'background-tile' => 'Yes',
		'featured-cat' => 11,
		'featured-count' => 5,
		'featured-scroll' => 'Show',
		'featured-transition' => 1000,
		'featured-slidelength' => 8000,
		'advertisementtop' => 'http://www.schoolnewspapersonline.com/wp-content/uploads/2009/06/avw-1.jpg',
		'advertisementtopurl' => 'http://www.schoolnewspapersonline.com',
		'display-ads1' => Yes,
		'video-cat' => 13,
		'video-count' => 5,
		'audio-cat' => 3,
		'audio-count' => 5,
		'staff-cat' => 11,
		'sports-scrollbox' => 10,
		'sports-speed' => 3000,
		'sports-transition' => 666,
		'sports-count' => 3,
		'sports-scrollbox-visible' => 1,
		'sports-scroll-style' => vertical,
		'sports-scrollbox-number' => 1,
		'sports-scrollbox-visible' => 1,
		'breakingnews-scrollbox' => 10,
		'breakingnews-location' => 'Off',
		'breakingnews-speed' => 3000,
		'breakingnews-transition' => 2000,
		'breaking-scroll-number' => 1,
		'breaking-visible' => 1,
		'breaking-scroll-style' => 'horizontal',
		'sports-gallery-id' => 2,
		'sports-gallery' => 'Thumbnail Gallery',
		'recent-results' => 20,
		'upcoming-games' => 20,
		'sports-cat' => 15,
		'sports-cat-count' => 3,
		'sports-sidebar-count' => 6,
		'featured-athlete-cat' => 15,
		'featured-athlete-count' => 5,
		'top-stories-wide' => 'Style 3',
		'top-stories-transition' => 'fade',
		'top-stories-automate' => 'On',
		'top-stories-speed' => '5000',
		'top-stories-trans-speed' => '666',
		'top-stories-nav-buttons' => 'Bottom',
		'top-stories-hide-cat' => 'Yes',
		'top-stories-hide-date' => 'No',
		'top-stories-teaser' => '150',
		'top-stories-video' => 'Yes',
		'top-stories-video-teaser' => 'No',
		'top-stories-links' => 'No',
		'top-stories-shadow' => 'On',
		'widget-shadows' => 'On',
		'outer-shadows' => 'On',
		'wrap-margin' => '0px',
		'show-breadcrumb' => 'Yes',
		'display-leader' => 'No',
		'leaderboard-background' => '#dddddd',
		'leaderboard-background-on' => 'Transparent',
		'leaderad-type' => 'Static Image',
		'leader-image' => '',
		'leader-url' => '',
		'openx-code' => '',
		'ae-cat1' => '',
		'ae-cat2' => '',
		'ae-cat3' => '',
		'ae-cat4' => '',
		'ae-cat1-count' => '2',
		'ae-cat2-count' => '3',
		'ae-cat3-count' => '3',
		'ae-cat4-count' => '3',
		'mm-featured' => '',
		'mm-cat1' => '',
		'mm-cat2' => '',
		'mm-cat3' => '',
		'mm-cat4' => '',
		'mm-display' => 'Above Story',
		'mm-cat1-count' => '5',
		'mm-cat2-count' => '5',
		'mm-cat3-count' => '5',
		'mm-cat4-count' => '5',
		'mm-width' => '750',
		'mm-height' => '550',
		'colorpicker' => 'Enabled',
		'accentcolor1' => '#990000',
		'accentcolor2' => '#393939',
		'accentcolor3' => '#990000',
		'accentcolor4' => '#990000',
		'accentcolor5' => '#990000',
		'accentcolor6' => '#990000',
		'navbar-borders' => '#aaaaaa',
		'accentcolor1-text' => '#ffffff',
		'accentcolor2-text' => '#ffffff',
		'accentcolor3-text' => '#ffffff',
		'accentcolor4-text' => '#ffffff',
		'accentcolor5-text' => '#ffffff',
		'accentcolor6-text' => '#ffffff',
		'breakingnews-color' => '#ffffff',
		'breakingnews-text' => '#990000',
		'footer-text' => '#dddddd',
		'topstoriesborder' => '#aaaaaa',
		'topstoriesbackground' => '#eeeeee',
		'accentcolor-links' => '#990000',
		'accentcolor-headlines' => '#990000',
		'accentcolor-header' => '#303030',
		'accentcolor-header2' => '#303030',
		'footerborder' => '#393939',
		'accentcolor-header-text' => '#dddddd',
		'innerbackground' => '#dddddd',
		'backgroundwidth' => 'On',
		'postareaborder' => 'Off',
		'sno-layout' => 'Option 3',
		'bottomnav' => 'Show',
		'openx' => 'No',
		'comments' => 'Enabled',
		'background' => 'On',
		'analytics' => 'Yes',
		'widget-style' => 'Style 1',
		'widgetborder1' => '#cccccc',
		'widgetbackground1' => '#ffffff',
		'widgetcolor1' => '#990000',
		'widgetcolor1-text' => '#ffffff',		
		'widget1-thickness' => '1px',		
		'widgetborder2' => '#cccccc',
		'widgetbackground2' => '#ffffff',
		'widgetcolor2' => '#990000',
		'widgetcolor2-text' => '#ffffff',
		'widget2-thickness' => '1px',		
		'widgetborder3' => '#cccccc',
		'widgetbackground3' => '#eeeeee',
		'widgetcolor3' => '#990000',
		'widgetcolor3-text' => '#ffffff',
		'widget3-thickness' => '0px',
		'widgetborder4' => '#cccccc',
		'widgetbackground4' => '#ffffff',
		'widgetcolor4' => '#990000',
		'widgetcolor4-text' => '#ffffff',
		'widget4-thickness' => '1px',
		'widgetborder5' => '#aaaaaa',
		'widgetbackground5' => '#eeeeee',
		'widgetcolor5' => '#990000',
		'widgetcolor5-text' => '#000000',
		'widget5-thickness' => '1px',
		'widgetborder6' => '#aaaaaa',
		'widgetbackground6' => '#eeeeee',
		'widgetcolor6' => '#dddddd',
		'widgetcolor6-text' => '#990000',
		'widget6-thickness' => '1px',
		'widgetborder7' => '#990000',
		'widgetbackground7' => '#eeeeee',
		'widgetcolor7' => '#aaaaaa',
		'widgetcolor7-text' => '#ffffff',
		'widget7-thickness' => '5px',
		'mm-display' => 'On Page'			 // <-- no comma after the last option
);

//	push the defaults to the options database,
//	if options don't yet exist there.
add_option($settings, $defaults, '', 'yes');


/*
///////////////////////////////////////////////
This section hooks the proper functions
to the proper actions in WordPress
\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
*/
//	this function registers our settings in the db
add_action('admin_init', 'register_theme_settings');
function register_theme_settings() {
	global $settings;
	register_setting($settings, $settings );
}
//	this function adds the settings page to the Appearance tab
add_action('admin_menu', 'add_theme_options_menu');
function add_theme_options_menu() {
	add_submenu_page('themes.php', 'GoPublish '.__('Theme Options','sno'), 'GoPublish '.__('Theme Options','sno'), 'manage_options', 'theme-options', 'theme_settings_admin');
}

/*
///////////////////////////////////////////////
This section handles all the admin page
output (forms, update notifications, etc.)
\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
*/
function theme_settings_admin() { ?>
<?php theme_options_css_js(); ?>
<div class="wrap">
<div class="sno_options_page">
<?php
	// display the proper notification if Saved/Reset
	global $settings, $defaults;
	if(get_theme_mod('reset')) {
		echo '<div class="updated fade" id="message"><p>'.__('Theme Options', 'sno').' <strong>'.__('RESET TO DEFAULTS', 'sno').'</strong></p></div>';
		update_option($settings, $defaults);
	} elseif($_REQUEST['settings-updated'] == 'true') {
		echo '<div class="updated fade" id="message"><p>'.__('Theme Options', 'sno').' <strong>'.__('SAVED', 'sno').'</strong></p></div>';
	}
	// display icon next to page title
	screen_icon('options-general');
?>
	<h2><?php echo get_current_theme() . ' '; _e('Theme Options', 'sno'); ?></h2>
	<form method="post" action="options.php">
	<?php settings_fields($settings); // important! ?>

	<?php // first column ?>

    <div class="sno_options_page" style="width:820px">
	<div class="metabox-holder" style="width:600px">
                

<div class="glossymenu">

<a class="menuitem submenuheader" href="http://www.schoolnewspapersonline.com/">Home Page Layout</a>
<div class="submenu">
	<div class="inside">

			<div class="optionsbox" style="width:350px"><img style="margin:10px 0px 0px 10px;width:325px;" src="<?php bloginfo('template_url');?>/images/options.gif" /></div>

				<p><?php _e("Select one of the column structures for your homepage layout.  You can populate the various columns by clicking on Widgets under the Appearance tab.", 'sno'); ?><br /><br />
				<select name="<?php echo $settings; ?>[sno-layout]">
					<option style="padding-right:10px;" value="Option 1" <?php selected('Option 1', get_theme_mod('sno-layout')); ?>><?php _e("Option 1", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Option 2" <?php selected('Option 2', get_theme_mod('sno-layout')); ?>><?php _e("Option 2", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Option 3" <?php selected('Option 3', get_theme_mod('sno-layout')); ?>><?php _e("Option 3", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Option 4" <?php selected('Option 4', get_theme_mod('sno-layout')); ?>><?php _e("Option 4", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Option 5" <?php selected('Option 5', get_theme_mod('sno-layout')); ?>><?php _e("Option 5", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Option 6" <?php selected('Option 6', get_theme_mod('sno-layout')); ?>><?php _e("Option 6", 'sno'); ?></option>

				</select></p>
				

			<div style="clear:both"></div>

	</div>
</div>


<a class="menuitem submenuheader" href="http://www.schoolnewspapersonline.com/">Nav Bar Colors, Link Colors, & General Appearance</a>
<div class="submenu">
	<div class="inside">
<div class="optionsbox">

<p>

 <select name="<?php echo $settings; ?>[postareaborder]">
					<option style="padding-right:10px;" value="On" <?php selected('On', get_theme_mod('postareaborder')); ?>><?php _e("On", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Off" <?php selected('Off', get_theme_mod('postareaborder')); ?>><?php _e("Off", 'sno'); ?></option>
</select> Non-Homepage Story Area Border<br />



 <select name="<?php echo $settings; ?>[bottomnav]">
					<option style="padding-right:10px;" value="Show" <?php selected('Show', get_theme_mod('bottomnav')); ?>><?php _e("Show", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Hide" <?php selected('Hide', get_theme_mod('bottomnav')); ?>><?php _e("Hide", 'sno'); ?></option>
</select> Bottom Navigation Bar<br />


 <select name="<?php echo $settings; ?>[show-breadcrumb]">
					<option style="padding-right:10px;" value="Yes" <?php selected('Yes', get_theme_mod('show-breadcrumb')); ?>><?php _e("Yes", 'sno'); ?></option>
					<option style="padding-right:10px;" value="No" <?php selected('No', get_theme_mod('show-breadcrumb')); ?>><?php _e("No", 'sno'); ?></option>
</select> Show Breadcrumb Area</p>

</div>

<div class="optionsboxright">
				<p><?php _e("Click on a color box below to activate the color selector.", 'sno'); ?></p>
<p>
<input type="text" id="accentcolor1" name="<?php echo $settings; ?>[accentcolor1]; ?>" value="<?php echo get_theme_mod('accentcolor1'); ?>" maxlength="7" size="7" class="colorwell" /> Top Nav Bar <br />
<input type="text" id="accentcolor1-text" name="<?php echo $settings; ?>[accentcolor1-text]; ?>" value="<?php echo get_theme_mod('accentcolor1-text'); ?>" maxlength="7" size="7" class="colorwell" /> Top Nav Bar Text <br />
<input type="text" id="accentcolor2" name="<?php echo $settings; ?>[accentcolor2]; ?>" value="<?php echo get_theme_mod('accentcolor2'); ?>" maxlength="7" size="7" class="colorwell" /> Bottom Nav Bar <br />
<input type="text" id="accentcolor2-text" name="<?php echo $settings; ?>[accentcolor2-text]; ?>" value="<?php echo get_theme_mod('accentcolor2-text'); ?>" maxlength="7" size="7" class="colorwell" /> Bottom Nav Bar Text<br />
<input type="text" id="navbar-borders" name="<?php echo $settings; ?>[navbar-borders]; ?>" value="<?php echo get_theme_mod('navbar-borders'); ?>" maxlength="7" size="7" class="colorwell" /> Nav Bar Borders<br />


<input type="text" id="footerborder" name="<?php echo $settings; ?>[footerborder]; ?>" value="<?php echo get_theme_mod('footerborder'); ?>" maxlength="7" size="7" class="colorwell" /> Footer Border <br />
<input type="text" id="footer-text" name="<?php echo $settings; ?>[footer-text]; ?>" value="<?php echo get_theme_mod('footer-text'); ?>" maxlength="7" size="7" class="colorwell" /> Footer Text <br />

<input type="text" id="accentcolor-headlines" name="<?php echo $settings; ?>[accentcolor-headlines]; ?>" value="<?php echo get_theme_mod('accentcolor-headlines'); ?>" maxlength="7" size="7" class="colorwell" /> Headline Links <br />

<input type="text" id="accentcolor-links" name="<?php echo $settings; ?>[accentcolor-links]; ?>" value="<?php echo get_theme_mod('accentcolor-links'); ?>" maxlength="7" size="7" class="colorwell" /> Links </p>

</div>


<div style="clear:both"></div>
	</div>
</div>


<a class="menuitem submenuheader" href="http://www.schoolnewspapersonline.com/">Background and Header Appearance</a>
<div class="submenu">
	<div class="inside">

<div class="optionsbox">
<p class="headingtext">Background</p>


<p><select name="<?php echo $settings; ?>[wrap-margin]">
					<option style="padding-right:10px;" value="0px" <?php selected('0px', get_theme_mod('wrap-margin')); ?>><?php _e("0px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="10px" <?php selected('10px', get_theme_mod('wrap-margin')); ?>><?php _e("10px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="20px" <?php selected('20px', get_theme_mod('wrap-margin')); ?>><?php _e("20px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="30px" <?php selected('30px', get_theme_mod('wrap-margin')); ?>><?php _e("30px", 'sno'); ?></option>
				</select> Top Page Margin
				</p>
				
				<p>
				<select name="<?php echo $settings; ?>[background]">
					<option style="padding-right:10px;" value="On" <?php selected('On', get_theme_mod('background')); ?>><?php _e("Gradient Overlay", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Pattern" <?php selected('Pattern', get_theme_mod('background')); ?>><?php _e("Pattern/Image", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Off" <?php selected('Off', get_theme_mod('background')); ?>><?php _e("Solid Color", 'sno'); ?></option>
				</select> Outer Background<br />
				</p>

				<p>
				<select name="<?php echo $settings; ?>[outer-shadows]">
					<option style="padding-right:10px;" value="On" <?php selected('On', get_theme_mod('outer-shadows')); ?>><?php _e("On", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Off" <?php selected('Off', get_theme_mod('outer-shadows')); ?>><?php _e("Off", 'sno'); ?></option>
				</select> Outer Wrap Drop Shadow<br />
				</p>
				
				<p>
				<input type="text" id="innerbackground" name="<?php echo $settings; ?>[innerbackground]; ?>" value="<?php echo get_theme_mod('innerbackground'); ?>" maxlength="7" size="7" class="colorwell" /> Inner Background Color<br />

				<input type="text" id="accentcolor-header" name="<?php echo $settings; ?>[accentcolor-header]; ?>" value="<?php echo get_theme_mod('accentcolor-header'); ?>" maxlength="7" size="7" class="colorwell" /> Background
				</p>

<p>For background pattern and gradient tools, click <a href="http://schoolnewspapersonline.com/tools" target="_blank">here</a>.  Use the button below to upload your image. After upload is completed, click "Insert into Post".</p>
<p>
				<input class="upload_image_button button-primary" type="button" value="Click to Upload Background Image"/>
				<input class="upload_image" type="text" name="<?php echo $settings; ?>[background-pattern]" value="<?php echo get_theme_mod('background-pattern'); ?>" size="32" /> 
</p>

<p>
<select name="<?php echo $settings; ?>[background-tile]">
					<option style="padding-right:10px;" value="Yes" <?php selected('Yes', get_theme_mod('background-tile')); ?>><?php _e("Yes", 'sno'); ?></option>
					<option style="padding-right:10px;" value="No" <?php selected('No', get_theme_mod('background-tile')); ?>><?php _e("No", 'sno'); ?></option>
</select> Tile Background Image</p>


</div>
<div class="optionsboxright">
<p class="headingtext">Header</p>

				<p><?php _e("Choose from the following for your main header", 'sno'); ?><br />
				<select name="<?php echo $settings; ?>[header_blog_title]">
					<option style="padding-right:10px;" value="Image" <?php selected('Image', get_theme_mod('header_blog_title')); ?>><?php _e("Use an image logo", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Text" <?php selected('Text', get_theme_mod('header_blog_title')); ?>><?php _e("Use website name and tagline", 'sno'); ?></option>
				</select></p>

				<p>Upload your header by clicking the button below. After the image uploads, click "Insert into Post".</p>
				<p>
				<input class="upload_image_button2 button-primary" type="button" value="Click to Upload Header Image"/>
				<input class="upload_image2" type="text" name="<?php echo $settings; ?>[header-image]" value="<?php echo get_theme_mod('header-image'); ?>" size="32" /> </p>

				<p>
				<select name="<?php echo $settings; ?>[header-background]">
					<option style="padding-right:10px;" value="Gradient" <?php selected('Gradient', get_theme_mod('header-background')); ?>><?php _e("Gradient Overlay", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Transparent" <?php selected('Transparent', get_theme_mod('header-background')); ?>><?php _e("Transparent", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Color" <?php selected('Color', get_theme_mod('header-background')); ?>><?php _e("Solid Color", 'sno'); ?></option>
</select> Header Background
				</p>

				<p>
				<input type="text" id="accentcolor-header2" name="<?php echo $settings; ?>[accentcolor-header2]; ?>" value="<?php echo get_theme_mod('accentcolor-header2'); ?>" maxlength="7" size="7" class="colorwell" /> Header<br />
<input type="text" id="accentcolor-header-text" name="<?php echo $settings; ?>[accentcolor-header-text]; ?>" value="<?php echo get_theme_mod('accentcolor-header-text'); ?>" maxlength="7" size="7" class="colorwell" /> Header Text
				</p>
				<p><?php _e("Header image dimensions in pixels (Width x Height.  Max width is 960px.  Recommended height is 100px.)", 'sno'); ?><br />
				<input type="text" name="<?php echo $settings; ?>[header-width]" value="<?php echo get_theme_mod('header-width'); ?>" size="3" /> x <input type="text" name="<?php echo $settings; ?>[header-height]" value="<?php echo get_theme_mod('header-height'); ?>" size="3" /></p>

</div>


<div style="clear:both"></div>
	</div>
</div>


<a class="menuitem submenuheader" href="http://www.schoolnewspapersonline.com/">Top Stories Box on Home Page</a>
<div class="submenu">
	<div class="inside">

<div class="optionsbox">
	<p class="headingtext">Content</p>
				<p>
				<select name="<?php echo $settings; ?>[top-stories-scrollbox]">
					<option style="padding-right:10px;" value="Display" <?php selected('Display', get_theme_mod('top-stories-scrollbox')); ?>><?php _e("Display", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Hide" <?php selected('Hide', get_theme_mod('top-stories-scrollbox')); ?>><?php _e("Hide", 'sno'); ?></option>
				</select> Top Stories Scrollbox</p>
				
				<p><?php _e("Category to be displayed", 'sno'); ?><br />
    			<?php wp_dropdown_categories(array('selected' => get_theme_mod('featured-cat'), 'name' => $settings.'[featured-cat]', 'orderby' => 'Name' , 'hierarchical' => 1, 'hide_empty' => '0' )); ?></p>

<p><select name="<?php echo $settings; ?>[featured-count]">
					<option style="padding-right:10px;" value="1" <?php selected('1', get_theme_mod('featured-count')); ?>><?php _e("1", 'sno'); ?></option>
					<option style="padding-right:10px;" value="2" <?php selected('2', get_theme_mod('featured-count')); ?>><?php _e("2", 'sno'); ?></option>
					<option style="padding-right:10px;" value="3" <?php selected('3', get_theme_mod('featured-count')); ?>><?php _e("3", 'sno'); ?></option>
					<option style="padding-right:10px;" value="4" <?php selected('4', get_theme_mod('featured-count')); ?>><?php _e("4", 'sno'); ?></option>
					<option style="padding-right:10px;" value="5" <?php selected('5', get_theme_mod('featured-count')); ?>><?php _e("5", 'sno'); ?></option>
					<option style="padding-right:10px;" value="6" <?php selected('6', get_theme_mod('featured-count')); ?>><?php _e("6", 'sno'); ?></option>
					<option style="padding-right:10px;" value="7" <?php selected('7', get_theme_mod('featured-count')); ?>><?php _e("7", 'sno'); ?></option>
					<option style="padding-right:10px;" value="8" <?php selected('8', get_theme_mod('featured-count')); ?>><?php _e("8", 'sno'); ?></option>
					<option style="padding-right:10px;" value="9" <?php selected('9', get_theme_mod('featured-count')); ?>><?php _e("9", 'sno'); ?></option>
					<option style="padding-right:10px;" value="10" <?php selected('10', get_theme_mod('featured-count')); ?>><?php _e("10", 'sno'); ?></option>
				</select> Number of Stories<br />

				<select name="<?php echo $settings; ?>[featured-scroll]">
					<option style="padding-right:10px;" value="Show" <?php selected('Show', get_theme_mod('featured-scroll')); ?>><?php _e("Show", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Hide" <?php selected('Hide', get_theme_mod('featured-scroll')); ?>><?php _e("Hide", 'sno'); ?></option>
				</select> Teaser Text (Style 1 & 2 Only)<br />

                <select name="<?php echo $settings; ?>[top-stories-teaser]">
                    <option style="padding-right:10px;" value="100" <?php selected('100', get_theme_mod('top-stories-teaser')); ?>><?php _e("100", 'sno'); ?></option>
					<option style="padding-right:10px;" value="125" <?php selected('125', get_theme_mod('top-stories-teaser')); ?>><?php _e("125", 'sno'); ?></option>
					<option style="padding-right:10px;" value="150" <?php selected('150', get_theme_mod('top-stories-teaser')); ?>><?php _e("150", 'sno'); ?></option>
					<option style="padding-right:10px;" value="175" <?php selected('175', get_theme_mod('top-stories-teaser')); ?>><?php _e("175", 'sno'); ?></option>
					<option style="padding-right:10px;" value="200" <?php selected('200', get_theme_mod('top-stories-teaser')); ?>><?php _e("200", 'sno'); ?></option>
					<option style="padding-right:10px;" value="225" <?php selected('225', get_theme_mod('top-stories-teaser')); ?>><?php _e("225", 'sno'); ?></option>
					<option style="padding-right:10px;" value="250" <?php selected('250', get_theme_mod('top-stories-teaser')); ?>><?php _e("250", 'sno'); ?></option>
					<option style="padding-right:10px;" value="275" <?php selected('275', get_theme_mod('top-stories-teaser')); ?>><?php _e("275", 'sno'); ?></option>
					<option style="padding-right:10px;" value="300" <?php selected('300', get_theme_mod('top-stories-teaser')); ?>><?php _e("300", 'sno'); ?></option>
					<option style="padding-right:10px;" value="325" <?php selected('325', get_theme_mod('top-stories-teaser')); ?>><?php _e("325", 'sno'); ?></option>
					<option style="padding-right:10px;" value="350" <?php selected('350', get_theme_mod('top-stories-teaser')); ?>><?php _e("350", 'sno'); ?></option>
					<option style="padding-right:10px;" value="375" <?php selected('375', get_theme_mod('top-stories-teaser')); ?>><?php _e("375", 'sno'); ?></option>
					<option style="padding-right:10px;" value="400" <?php selected('400', get_theme_mod('top-stories-teaser')); ?>><?php _e("400", 'sno'); ?></option>
					<option style="padding-right:10px;" value="425" <?php selected('425', get_theme_mod('top-stories-teaser')); ?>><?php _e("425", 'sno'); ?></option>
					<option style="padding-right:10px;" value="450" <?php selected('450', get_theme_mod('top-stories-teaser')); ?>><?php _e("450", 'sno'); ?></option>
				</select> Teaser Length (Style 3 Only)<br />

              	<select name="<?php echo $settings; ?>[top-stories-hide-cat]">
                    <option style="padding-right:10px;" value="Yes" <?php selected('Yes', get_theme_mod('top-stories-hide-cat')); ?>><?php _e("Yes", 'sno'); ?></option>
					<option style="padding-right:10px;" value="No" <?php selected('No', get_theme_mod('top-stories-hide-cat')); ?>><?php _e("No", 'sno'); ?></option>
				</select> Hide Category Name (Style 3 Only)<br />
				
				<select name="<?php echo $settings; ?>[top-stories-hide-date]">
                    <option style="padding-right:10px;" value="Yes" <?php selected('Yes', get_theme_mod('top-stories-hide-date')); ?>><?php _e("Yes", 'sno'); ?></option>
					<option style="padding-right:10px;" value="No" <?php selected('No', get_theme_mod('top-stories-hide-date')); ?>><?php _e("No", 'sno'); ?></option>
				</select> Hide Date (Style 3 Only)
				
				</p>
<div class="divline"></div>                
<?php $buscheck = get_option('bussno'); if ($buscheck == "bussno379657b") { ?>

              	<p><select name="<?php echo $settings; ?>[top-stories-links]">
                    <option style="padding-right:10px;" value="Yes" <?php selected('Yes', get_theme_mod('top-stories-links')); ?>><?php _e("Yes", 'sno'); ?></option>
					<option style="padding-right:10px;" value="No" <?php selected('No', get_theme_mod('top-stories-links')); ?>><?php _e("No", 'sno'); ?></option>
				</select> Enable custom links for slides</p>
<?php } ?>


</div>
<div class="optionsboxright">
<p class="headingtext">Appearance</p>
<select name="<?php echo $settings; ?>[top-stories-wide]">
					<option style="padding-right:10px;" value="Style 1" <?php selected('Style 1', get_theme_mod('top-stories-wide')); ?>><?php _e("Style 1", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Style 2" <?php selected('Style 2', get_theme_mod('top-stories-wide')); ?>><?php _e("Style 2", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Style 3" <?php selected('Style 3', get_theme_mod('top-stories-wide')); ?>><?php _e("Style 3", 'sno'); ?></option>
				</select> Slider Style<br />
				
                <select name="<?php echo $settings; ?>[top-stories-nav-buttons]">
                    <option style="padding-right:10px;" value="Top" <?php selected('Top', get_theme_mod('top-stories-nav-buttons')); ?>><?php _e("Top", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Bottom" <?php selected('Bottom', get_theme_mod('top-stories-nav-buttons')); ?>><?php _e("Bottom", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Below" <?php selected('Below', get_theme_mod('top-stories-nav-buttons')); ?>><?php _e("Below", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Off" <?php selected('Off', get_theme_mod('top-stories-nav-buttons')); ?>><?php _e("Off", 'sno'); ?></option>
				</select> Navigation Button Position<br />
				<select name="<?php echo $settings; ?>[top-stories-shadow]">
					<option style="padding-right:10px;" value="On" <?php selected('On', get_theme_mod('top-stories-shadow')); ?>><?php _e("On", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Off" <?php selected('Off', get_theme_mod('top-stories-shadow')); ?>><?php _e("Off", 'sno'); ?></option>
				</select> Top Story Box Drop Shadow
				</p>
			
<p>
<input type="text" id="topstoriesborder" name="<?php echo $settings; ?>[topstoriesborder]; ?>" value="<?php echo get_theme_mod('topstoriesborder'); ?>" maxlength="7" size="7" class="colorwell" /> Top Scrollbox Border <br />
<input type="text" id="topstoriesbackground" name="<?php echo $settings; ?>[topstoriesbackground]; ?>" value="<?php echo get_theme_mod('topstoriesbackground'); ?>" maxlength="7" size="7" class="colorwell" /> Top Scrollbox Background <br />
</p>				

<div class="divline"></div>
<p class="headingtext">Javascript Controls</p>
<p><select name="<?php echo $settings; ?>[top-stories-transition]">
					<option style="padding-right:10px;" value="fade" <?php selected('fade', get_theme_mod('top-stories-transition')); ?>><?php _e("Fade", 'sno'); ?></option>
					<option style="padding-right:10px;" value="scrollHorz" <?php selected('scrollHorz', get_theme_mod('top-stories-transition')); ?>><?php _e("Horizontal", 'sno'); ?></option>
					<option style="padding-right:10px;" value="scrollVert" <?php selected('scrollVert', get_theme_mod('top-stories-transition')); ?>><?php _e("Vertical", 'sno'); ?></option>
				</select> Transition Style<br />

				<select name="<?php echo $settings; ?>[top-stories-automate]">
					<option style="padding-right:10px;" value="On" <?php selected('On', get_theme_mod('top-stories-automate')); ?>><?php _e("On", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Off" <?php selected('Off', get_theme_mod('top-stories-automate')); ?>><?php _e("Off", 'sno'); ?></option>
				</select> Auto Scroll<br />

             	<select name="<?php echo $settings; ?>[top-stories-speed]">
					<option style="padding-right:10px;" value="4000" <?php selected('4000', get_theme_mod('top-stories-speed')); ?>><?php _e("4 Seconds", 'sno'); ?></option>
                    <option style="padding-right:10px;" value="5000" <?php selected('5000', get_theme_mod('top-stories-speed')); ?>><?php _e("5 Seconds", 'sno'); ?></option>
					<option style="padding-right:10px;" value="6000" <?php selected('6000', get_theme_mod('top-stories-speed')); ?>><?php _e("6 Seconds", 'sno'); ?></option>
					<option style="padding-right:10px;" value="7000" <?php selected('7000', get_theme_mod('top-stories-speed')); ?>><?php _e("7 Seconds", 'sno'); ?></option>
					<option style="padding-right:10px;" value="8000" <?php selected('8000', get_theme_mod('top-stories-speed')); ?>><?php _e("8 Seconds", 'sno'); ?></option>
					<option style="padding-right:10px;" value="9000" <?php selected('9000', get_theme_mod('top-stories-speed')); ?>><?php _e("9 Seconds", 'sno'); ?></option>
					<option style="padding-right:10px;" value="10000" <?php selected('10000', get_theme_mod('top-stories-speed')); ?>><?php _e("10 Seconds", 'sno'); ?></option>
					<option style="padding-right:10px;" value="11000" <?php selected('11000', get_theme_mod('top-stories-speed')); ?>><?php _e("11 Seconds", 'sno'); ?></option>
					<option style="padding-right:10px;" value="12000" <?php selected('12000', get_theme_mod('top-stories-speed')); ?>><?php _e("12 Seconds", 'sno'); ?></option>
				</select> Slide Duration<br />

            	<select name="<?php echo $settings; ?>[top-stories-trans-speed]">
                    <option style="padding-right:10px;" value="333" <?php selected('333', get_theme_mod('top-stories-trans-speed')); ?>><?php _e("Fast", 'sno'); ?></option>
					<option style="padding-right:10px;" value="666" <?php selected('666', get_theme_mod('top-stories-trans-speed')); ?>><?php _e("Medium", 'sno'); ?></option>
                    <option style="padding-right:10px;" value="1000" <?php selected('1000', get_theme_mod('top-stories-trans-speed')); ?>><?php _e("Slow", 'sno'); ?></option>
				</select> Slide Transition Time
				</p>

</div>


<div style="clear:both"></div>

	</div>
</div>

<a class="menuitem submenuheader" href="http://www.schoolnewspapersonline.com/">Featured Content Box on Home Page</a>
<div class="submenu">
	<div class="inside">

<div class="optionsbox">
				<p>
				<select name="<?php echo $settings; ?>[featured-content]">
					<option style="padding-right:10px;" value="Display" <?php selected('Display', get_theme_mod('featured-content')); ?>><?php _e("Display", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Hide" <?php selected('Hide', get_theme_mod('featured-content')); ?>><?php _e("Hide", 'sno'); ?></option>
				</select> Featured Content Area</p>

				<p>
				<input type="text" id="featured-title" name="<?php echo $settings; ?>[featured-title]; ?>" value="<?php echo get_theme_mod('featured-title'); ?>" size="30" /> Title 
				</p>

<div class="divline"></div>


			<p class="headingtext">Left Category</p>
				
				<p>
    			<?php wp_dropdown_categories(array('selected' => get_theme_mod('featured-cat-1'), 'name' => $settings.'[featured-cat-1]', 'orderby' => 'Name' , 'hierarchical' => 1, 'hide_empty' => '0' )); ?></p>

				<p>
                <select name="<?php echo $settings; ?>[featured-teaser-1]">
                    <option style="padding-right:10px;" value="0" <?php selected('0', get_theme_mod('featured-teaser-1')); ?>><?php _e("0", 'sno'); ?></option>
					<option style="padding-right:10px;" value="25" <?php selected('25', get_theme_mod('featured-teaser-1')); ?>><?php _e("25", 'sno'); ?></option>
                    <option style="padding-right:10px;" value="50" <?php selected('50', get_theme_mod('featured-teaser-1')); ?>><?php _e("50", 'sno'); ?></option>
					<option style="padding-right:10px;" value="75" <?php selected('75', get_theme_mod('featured-teaser-1')); ?>><?php _e("75", 'sno'); ?></option>
                    <option style="padding-right:10px;" value="100" <?php selected('100', get_theme_mod('featured-teaser-1')); ?>><?php _e("100", 'sno'); ?></option>
					<option style="padding-right:10px;" value="125" <?php selected('125', get_theme_mod('featured-teaser-1')); ?>><?php _e("125", 'sno'); ?></option>
					<option style="padding-right:10px;" value="150" <?php selected('150', get_theme_mod('featured-teaser-1')); ?>><?php _e("150", 'sno'); ?></option>
					<option style="padding-right:10px;" value="175" <?php selected('175', get_theme_mod('featured-teaser-1')); ?>><?php _e("175", 'sno'); ?></option>
					<option style="padding-right:10px;" value="200" <?php selected('200', get_theme_mod('featured-teaser-1')); ?>><?php _e("200", 'sno'); ?></option>
					<option style="padding-right:10px;" value="225" <?php selected('225', get_theme_mod('featured-teaser-1')); ?>><?php _e("225", 'sno'); ?></option>
					<option style="padding-right:10px;" value="250" <?php selected('250', get_theme_mod('featured-teaser-1')); ?>><?php _e("250", 'sno'); ?></option>
				</select> Teaser Length<br />

              	<select name="<?php echo $settings; ?>[featured-hide-cat-1]">
                    <option style="padding-right:10px;" value="Yes" <?php selected('Yes', get_theme_mod('featured-hide-cat-1')); ?>><?php _e("Yes", 'sno'); ?></option>
					<option style="padding-right:10px;" value="No" <?php selected('No', get_theme_mod('featured-hide-cat-1')); ?>><?php _e("No", 'sno'); ?></option>
				</select> Hide Category Name<br />
				
								</p>

<div class="divline"></div>

			<p class="headingtext">Center Category</p>
				
				<p>
    			<?php wp_dropdown_categories(array('selected' => get_theme_mod('featured-cat-2'), 'name' => $settings.'[featured-cat-2]', 'orderby' => 'Name' , 'hierarchical' => 1, 'hide_empty' => '0' )); ?></p>

				<p>
                <select name="<?php echo $settings; ?>[featured-teaser-2]">
                    <option style="padding-right:10px;" value="0" <?php selected('0', get_theme_mod('featured-teaser-2')); ?>><?php _e("0", 'sno'); ?></option>
					<option style="padding-right:10px;" value="25" <?php selected('25', get_theme_mod('featured-teaser-2')); ?>><?php _e("25", 'sno'); ?></option>
                    <option style="padding-right:10px;" value="50" <?php selected('50', get_theme_mod('featured-teaser-2')); ?>><?php _e("50", 'sno'); ?></option>
					<option style="padding-right:10px;" value="75" <?php selected('75', get_theme_mod('featured-teaser-2')); ?>><?php _e("75", 'sno'); ?></option>
                    <option style="padding-right:10px;" value="100" <?php selected('100', get_theme_mod('featured-teaser-2')); ?>><?php _e("100", 'sno'); ?></option>
					<option style="padding-right:10px;" value="125" <?php selected('125', get_theme_mod('featured-teaser-2')); ?>><?php _e("125", 'sno'); ?></option>
					<option style="padding-right:10px;" value="150" <?php selected('150', get_theme_mod('featured-teaser-2')); ?>><?php _e("150", 'sno'); ?></option>
					<option style="padding-right:10px;" value="175" <?php selected('175', get_theme_mod('featured-teaser-2')); ?>><?php _e("175", 'sno'); ?></option>
					<option style="padding-right:10px;" value="200" <?php selected('200', get_theme_mod('featured-teaser-2')); ?>><?php _e("200", 'sno'); ?></option>
					<option style="padding-right:10px;" value="225" <?php selected('225', get_theme_mod('featured-teaser-2')); ?>><?php _e("225", 'sno'); ?></option>
					<option style="padding-right:10px;" value="250" <?php selected('250', get_theme_mod('featured-teaser-2')); ?>><?php _e("250", 'sno'); ?></option>
				</select> Teaser Length<br />

              	<select name="<?php echo $settings; ?>[featured-hide-cat-2]">
                    <option style="padding-right:10px;" value="Yes" <?php selected('Yes', get_theme_mod('featured-hide-cat-2')); ?>><?php _e("Yes", 'sno'); ?></option>
					<option style="padding-right:10px;" value="No" <?php selected('No', get_theme_mod('featured-hide-cat-2')); ?>><?php _e("No", 'sno'); ?></option>
				</select> Hide Category Name<br />
				</p>
<div class="divline"></div>

			<p class="headingtext">Right Category</p>
				
				<p>
    			<?php wp_dropdown_categories(array('selected' => get_theme_mod('featured-cat-3'), 'name' => $settings.'[featured-cat-3]', 'orderby' => 'Name' , 'hierarchical' => 1, 'hide_empty' => '0' )); ?></p>

				<p>
                <select name="<?php echo $settings; ?>[featured-teaser-3]">
                    <option style="padding-right:10px;" value="0" <?php selected('0', get_theme_mod('featured-teaser-3')); ?>><?php _e("0", 'sno'); ?></option>
					<option style="padding-right:10px;" value="25" <?php selected('25', get_theme_mod('featured-teaser-3')); ?>><?php _e("25", 'sno'); ?></option>
                    <option style="padding-right:10px;" value="50" <?php selected('50', get_theme_mod('featured-teaser-3')); ?>><?php _e("50", 'sno'); ?></option>
					<option style="padding-right:10px;" value="75" <?php selected('75', get_theme_mod('featured-teaser-3')); ?>><?php _e("75", 'sno'); ?></option>
                    <option style="padding-right:10px;" value="100" <?php selected('100', get_theme_mod('featured-teaser-3')); ?>><?php _e("100", 'sno'); ?></option>
					<option style="padding-right:10px;" value="125" <?php selected('125', get_theme_mod('featured-teaser-3')); ?>><?php _e("125", 'sno'); ?></option>
					<option style="padding-right:10px;" value="150" <?php selected('150', get_theme_mod('featured-teaser-3')); ?>><?php _e("150", 'sno'); ?></option>
					<option style="padding-right:10px;" value="175" <?php selected('175', get_theme_mod('featured-teaser-3')); ?>><?php _e("175", 'sno'); ?></option>
					<option style="padding-right:10px;" value="200" <?php selected('200', get_theme_mod('featured-teaser-3')); ?>><?php _e("200", 'sno'); ?></option>
					<option style="padding-right:10px;" value="225" <?php selected('225', get_theme_mod('featured-teaser-3')); ?>><?php _e("225", 'sno'); ?></option>
					<option style="padding-right:10px;" value="250" <?php selected('250', get_theme_mod('featured-teaser-3')); ?>><?php _e("250", 'sno'); ?></option>
				</select> Teaser Length<br />

              	<select name="<?php echo $settings; ?>[featured-hide-cat-3]">
                    <option style="padding-right:10px;" value="Yes" <?php selected('Yes', get_theme_mod('featured-hide-cat-3')); ?>><?php _e("Yes", 'sno'); ?></option>
					<option style="padding-right:10px;" value="No" <?php selected('No', get_theme_mod('featured-hide-cat-3')); ?>><?php _e("No", 'sno'); ?></option>
				</select> Hide Category Name<br />
				
				
				</p>

</div>

<div class="optionsboxright">
<p class="headingtext">Appearance</p>
<p>Assign the Featured Content Box to one of the seven widget styles below.</p>
<p><select name="<?php echo $settings; ?>[widget-style-feature]">
					<option style="padding-right:10px;" value="Style 1" <?php selected('Style 1', get_theme_mod('widget-style-feature')); ?>><?php _e("Style 1", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Style 2" <?php selected('Style 2', get_theme_mod('widget-style-feature')); ?>><?php _e("Style 2", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Style 3" <?php selected('Style 3', get_theme_mod('widget-style-feature')); ?>><?php _e("Style 3", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Style 4" <?php selected('Style 4', get_theme_mod('widget-style-feature')); ?>><?php _e("Style 4", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Style 5" <?php selected('Style 5', get_theme_mod('widget-style-feature')); ?>><?php _e("Style 5", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Style 6" <?php selected('Style 6', get_theme_mod('widget-style-feature')); ?>><?php _e("Style 6", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Style 7" <?php selected('Style 7', get_theme_mod('widget-style-feature')); ?>><?php _e("Style 7", 'sno'); ?></option>
				</select></p>

				<p><?php _e("Enable custom colors for this widget?", 'sno'); ?>
				<select name="<?php echo $settings; ?>[featured-colors]">
					<option style="padding-right:10px;" value="on" <?php selected('on', get_theme_mod('featured-colors')); ?>>Enable</option>
					<option style="padding-right:10px;" value="Disable" <?php selected('Disable', get_theme_mod('featured-colors')); ?>>Disable</option>
				</select></p>

<p>
<input type="text" id="widgetcolor-feature" name="<?php echo $settings; ?>[widgetcolor-feature]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetcolor-feature'); ?>" class="colorwell" /> Title Bar<br />
<input type="text" id="widgetcolor-feature-text" name="<?php echo $settings; ?>[widgetcolor-feature-text]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetcolor-feature-text'); ?>" class="colorwell" /> Title Bar Text <br />
<input type="text" id="widgetborder-feature" name="<?php echo $settings; ?>[widgetborder-feature]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetborder-feature'); ?>" class="colorwell" /> Border <br />
<input type="text" id="widgetbackground-feature" name="<?php echo $settings; ?>[widgetbackground-feature]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetbackground-feature'); ?>" class="colorwell" /> Background <br />
<select name="<?php echo $settings; ?>[widget-feature-thickness]">
					<option style="padding-right:10px;" value="0px" <?php selected('0px', get_theme_mod('widget-feature-thickness')); ?>><?php _e("0px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="1px" <?php selected('1px', get_theme_mod('widget-feature-thickness')); ?>><?php _e("1px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="2px" <?php selected('2px', get_theme_mod('widget-feature-thickness')); ?>><?php _e("2px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="3px" <?php selected('3px', get_theme_mod('widget-feature-thickness')); ?>><?php _e("3px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="4px" <?php selected('4px', get_theme_mod('widget-feature-thickness')); ?>><?php _e("4px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="5px" <?php selected('5px', get_theme_mod('widget-feature-thickness')); ?>><?php _e("5px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="6px" <?php selected('6px', get_theme_mod('widget-feature-thickness')); ?>><?php _e("6px", 'sno'); ?></option>
					
				</select> Border Thickness</p>

</div>

<div style="clear:both"></div>

	</div>
</div>


<a class="menuitem submenuheader" href="http://www.schoolnewspapersonline.com/">Product Showcase Box on Home Page</a>
<div class="submenu">
	<div class="inside">

<div class="optionsbox">
				<p>
				<select name="<?php echo $settings; ?>[product-content]">
					<option style="padding-right:10px;" value="Display" <?php selected('Display', get_theme_mod('product-content')); ?>><?php _e("Display", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Hide" <?php selected('Hide', get_theme_mod('product-content')); ?>><?php _e("Hide", 'sno'); ?></option>
				</select> Product Showcase Area</p>

				<p>
				<input type="text" id="product-title" name="<?php echo $settings; ?>[product-title]; ?>" value="<?php echo get_theme_mod('product-title'); ?>" size="30" /> Title 
				</p>

<div class="divline"></div>


			<p class="headingtext">Left Product Category</p>
				
				<p>
    			<?php wp_dropdown_categories(array('selected' => get_theme_mod('product-cat-1'), 'name' => $settings.'[product-cat-1]', 'orderby' => 'Name' , 'hierarchical' => 1, 'hide_empty' => '0' )); ?>
    			</p>


				<p>
				<select name="<?php echo $settings; ?>[product-count-1]">
					<option style="padding-right:10px;" value="1" <?php selected('1', get_theme_mod('product-count-1')); ?>><?php _e("1", 'sno'); ?></option>
					<option style="padding-right:10px;" value="2" <?php selected('2', get_theme_mod('product-count-1')); ?>><?php _e("2", 'sno'); ?></option>
					<option style="padding-right:10px;" value="3" <?php selected('3', get_theme_mod('product-count-1')); ?>><?php _e("3", 'sno'); ?></option>
					<option style="padding-right:10px;" value="4" <?php selected('4', get_theme_mod('product-count-1')); ?>><?php _e("4", 'sno'); ?></option>
					<option style="padding-right:10px;" value="5" <?php selected('5', get_theme_mod('product-count-1')); ?>><?php _e("5", 'sno'); ?></option>
					<option style="padding-right:10px;" value="6" <?php selected('6', get_theme_mod('product-count-1')); ?>><?php _e("6", 'sno'); ?></option>
					<option style="padding-right:10px;" value="7" <?php selected('7', get_theme_mod('product-count-1')); ?>><?php _e("7", 'sno'); ?></option>
					<option style="padding-right:10px;" value="8" <?php selected('8', get_theme_mod('product-count-1')); ?>><?php _e("8", 'sno'); ?></option>
					<option style="padding-right:10px;" value="9" <?php selected('9', get_theme_mod('product-count-1')); ?>><?php _e("9", 'sno'); ?></option>
					<option style="padding-right:10px;" value="10" <?php selected('10', get_theme_mod('product-count-1')); ?>><?php _e("10", 'sno'); ?></option>
				</select> Number of Products
				</p>


<div class="divline"></div>

			<p class="headingtext">Center Product Category</p>
				
				<p>
    			<?php wp_dropdown_categories(array('selected' => get_theme_mod('product-cat-2'), 'name' => $settings.'[product-cat-2]', 'orderby' => 'Name' , 'hierarchical' => 1, 'hide_empty' => '0' )); ?>
    			</p>

				<p>
				<select name="<?php echo $settings; ?>[product-count-2]">
					<option style="padding-right:10px;" value="1" <?php selected('1', get_theme_mod('product-count-2')); ?>><?php _e("1", 'sno'); ?></option>
					<option style="padding-right:10px;" value="2" <?php selected('2', get_theme_mod('product-count-2')); ?>><?php _e("2", 'sno'); ?></option>
					<option style="padding-right:10px;" value="3" <?php selected('3', get_theme_mod('product-count-2')); ?>><?php _e("3", 'sno'); ?></option>
					<option style="padding-right:10px;" value="4" <?php selected('4', get_theme_mod('product-count-2')); ?>><?php _e("4", 'sno'); ?></option>
					<option style="padding-right:10px;" value="5" <?php selected('5', get_theme_mod('product-count-2')); ?>><?php _e("5", 'sno'); ?></option>
					<option style="padding-right:10px;" value="6" <?php selected('6', get_theme_mod('product-count-2')); ?>><?php _e("6", 'sno'); ?></option>
					<option style="padding-right:10px;" value="7" <?php selected('7', get_theme_mod('product-count-2')); ?>><?php _e("7", 'sno'); ?></option>
					<option style="padding-right:10px;" value="8" <?php selected('8', get_theme_mod('product-count-2')); ?>><?php _e("8", 'sno'); ?></option>
					<option style="padding-right:10px;" value="9" <?php selected('9', get_theme_mod('product-count-2')); ?>><?php _e("9", 'sno'); ?></option>
					<option style="padding-right:10px;" value="10" <?php selected('10', get_theme_mod('product-count-2')); ?>><?php _e("10", 'sno'); ?></option>
				</select> Number of Products
				</p>


<div class="divline"></div>

			<p class="headingtext">Right Product Category</p>
				
				<p>
    			<?php wp_dropdown_categories(array('selected' => get_theme_mod('product-cat-3'), 'name' => $settings.'[product-cat-3]', 'orderby' => 'Name' , 'hierarchical' => 1, 'hide_empty' => '0' )); ?>
    			</p>

				<p>
				<select name="<?php echo $settings; ?>[product-count-3]">
					<option style="padding-right:10px;" value="1" <?php selected('1', get_theme_mod('product-count-3')); ?>><?php _e("1", 'sno'); ?></option>
					<option style="padding-right:10px;" value="2" <?php selected('2', get_theme_mod('product-count-3')); ?>><?php _e("2", 'sno'); ?></option>
					<option style="padding-right:10px;" value="3" <?php selected('3', get_theme_mod('product-count-3')); ?>><?php _e("3", 'sno'); ?></option>
					<option style="padding-right:10px;" value="4" <?php selected('4', get_theme_mod('product-count-3')); ?>><?php _e("4", 'sno'); ?></option>
					<option style="padding-right:10px;" value="5" <?php selected('5', get_theme_mod('product-count-3')); ?>><?php _e("5", 'sno'); ?></option>
					<option style="padding-right:10px;" value="6" <?php selected('6', get_theme_mod('product-count-3')); ?>><?php _e("6", 'sno'); ?></option>
					<option style="padding-right:10px;" value="7" <?php selected('7', get_theme_mod('product-count-3')); ?>><?php _e("7", 'sno'); ?></option>
					<option style="padding-right:10px;" value="8" <?php selected('8', get_theme_mod('product-count-3')); ?>><?php _e("8", 'sno'); ?></option>
					<option style="padding-right:10px;" value="9" <?php selected('9', get_theme_mod('product-count-3')); ?>><?php _e("9", 'sno'); ?></option>
					<option style="padding-right:10px;" value="10" <?php selected('10', get_theme_mod('product-count-3')); ?>><?php _e("10", 'sno'); ?></option>
				</select> Number of Products
				</p>



</div>

<div class="optionsboxright">
<p class="headingtext">Appearance</p>
<p>Assign the Featured Content Box to one of the seven widget styles below.</p>
<p><select name="<?php echo $settings; ?>[widget-style-product]">
					<option style="padding-right:10px;" value="Style 1" <?php selected('Style 1', get_theme_mod('widget-style-product')); ?>><?php _e("Style 1", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Style 2" <?php selected('Style 2', get_theme_mod('widget-style-product')); ?>><?php _e("Style 2", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Style 3" <?php selected('Style 3', get_theme_mod('widget-style-product')); ?>><?php _e("Style 3", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Style 4" <?php selected('Style 4', get_theme_mod('widget-style-product')); ?>><?php _e("Style 4", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Style 5" <?php selected('Style 5', get_theme_mod('widget-style-product')); ?>><?php _e("Style 5", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Style 6" <?php selected('Style 6', get_theme_mod('widget-style-product')); ?>><?php _e("Style 6", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Style 7" <?php selected('Style 7', get_theme_mod('widget-style-product')); ?>><?php _e("Style 7", 'sno'); ?></option>
				</select></p>

				<p><?php _e("Enable custom colors for this widget?", 'sno'); ?>
				<select name="<?php echo $settings; ?>[product-colors]">
					<option style="padding-right:10px;" value="on" <?php selected('on', get_theme_mod('product-colors')); ?>>Enable</option>
					<option style="padding-right:10px;" value="Disable" <?php selected('Disable', get_theme_mod('product-colors')); ?>>Disable</option>
				</select></p>

<p>
<input type="text" id="widgetcolor-product" name="<?php echo $settings; ?>[widgetcolor-product]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetcolor-product'); ?>" class="colorwell" /> Title Bar<br />
<input type="text" id="widgetcolor-product-text" name="<?php echo $settings; ?>[widgetcolor-product-text]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetcolor-product-text'); ?>" class="colorwell" /> Title Bar Text <br />
<input type="text" id="widgetborder-product" name="<?php echo $settings; ?>[widgetborder-product]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetborder-product'); ?>" class="colorwell" /> Border <br />
<input type="text" id="widgetbackground-product" name="<?php echo $settings; ?>[widgetbackground-product]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetbackground-product'); ?>" class="colorwell" /> Background <br />
<select name="<?php echo $settings; ?>[widget-product-thickness]">
					<option style="padding-right:10px;" value="0px" <?php selected('0px', get_theme_mod('widget-product-thickness')); ?>><?php _e("0px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="1px" <?php selected('1px', get_theme_mod('widget-product-thickness')); ?>><?php _e("1px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="2px" <?php selected('2px', get_theme_mod('widget-product-thickness')); ?>><?php _e("2px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="3px" <?php selected('3px', get_theme_mod('widget-product-thickness')); ?>><?php _e("3px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="4px" <?php selected('4px', get_theme_mod('widget-product-thickness')); ?>><?php _e("4px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="5px" <?php selected('5px', get_theme_mod('widget-product-thickness')); ?>><?php _e("5px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="6px" <?php selected('6px', get_theme_mod('widget-product-thickness')); ?>><?php _e("6px", 'sno'); ?></option>
					
				</select> Border Thickness</p>

</div>

<div style="clear:both"></div>

	</div>
</div>





<a class="menuitem submenuheader" href="http://www.schoolnewspapersonline.com/">Widget Styles</a>
<div class="submenu">
	<div class="inside">
	<div class="optionsbox" style="width:200px">
		<p class="headingtext">Set Default Widget Style</p>
		<p>Each widget on your site can be assigned to one of seven widget styles.  Use the choices on the right to define your seven widget styles.</p>
		<p>Each SNO widget has an option that allows you to assign the widget to one of the seven styles.  In addition, SNO widgets can each be assigned a custom color scheme.  <a href="/wp-admin/widgets.php">Click here</a> to view the widget control panel.</p>
		<p>All non-SNO widgets will be assigned to the style selected below.</p>
<p><select name="<?php echo $settings; ?>[widget-style]">
					<option style="padding-right:10px;" value="Style 1" <?php selected('Style 1', get_theme_mod('widget-style')); ?>><?php _e("Style 1", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Style 2" <?php selected('Style 2', get_theme_mod('widget-style')); ?>><?php _e("Style 2", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Style 3" <?php selected('Style 3', get_theme_mod('widget-style')); ?>><?php _e("Style 3", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Style 4" <?php selected('Style 4', get_theme_mod('widget-style')); ?>><?php _e("Style 4", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Style 5" <?php selected('Style 5', get_theme_mod('widget-style')); ?>><?php _e("Style 5", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Style 6" <?php selected('Style 6', get_theme_mod('widget-style')); ?>><?php _e("Style 6", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Style 7" <?php selected('Style 7', get_theme_mod('widget-style')); ?>><?php _e("Style 7", 'sno'); ?></option>
				</select></p>
<p> 
<select name="<?php echo $settings; ?>[widget-shadows]">
					<option style="padding-right:10px;" value="On" <?php selected('On', get_theme_mod('widget-shadows')); ?>><?php _e("On", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Off" <?php selected('Off', get_theme_mod('widget-shadows')); ?>><?php _e("Off", 'sno'); ?></option>
</select> Widget Drop Shadows
</p>

</div>
<div class="optionsboxright" style="width:320px">


<p class="headingtext">Widget Style 1</p>

<div style="width:140px;float:right;">
<div style="padding:6px;color:<?php echo get_theme_mod('widgetcolor1-text'); ?>; background: <?php echo get_theme_mod('widgetcolor1'); ?> url(<?php bloginfo('template_url'); ?>/images/navbg.png) repeat-x !important;border-top: <?php echo get_theme_mod('widget1-thickness'); ?> solid <?php echo get_theme_mod('widgetborder1'); ?>; border-left: <?php echo get_theme_mod('widget1-thickness'); ?> solid <?php echo get_theme_mod('widgetborder1'); ?>;border-right: <?php echo get_theme_mod('widget1-thickness'); ?> solid <?php echo get_theme_mod('widgetborder1'); ?>">Widget Title</div>
<div style="padding:10px;background:<?php echo get_theme_mod('widgetbackground1'); ?>;border-bottom: <?php echo get_theme_mod('widget1-thickness'); ?> solid <?php echo get_theme_mod('widgetborder1'); ?>; border-left: <?php echo get_theme_mod('widget1-thickness'); ?> solid <?php echo get_theme_mod('widgetborder1'); ?>;border-right: <?php echo get_theme_mod('widget1-thickness'); ?> solid <?php echo get_theme_mod('widgetborder1'); ?>">Click "Save Settings" Below to Update Appearance</div>
</div>

<p>
<input type="text" id="widgetcolor1" name="<?php echo $settings; ?>[widgetcolor1]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetcolor1'); ?>" class="colorwell" /> Title Bar<br />
<input type="text" id="widgetcolor1-text" name="<?php echo $settings; ?>[widgetcolor1-text]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetcolor1-text'); ?>" class="colorwell" /> Title Bar Text <br />
<input type="text" id="widgetborder1" name="<?php echo $settings; ?>[widgetborder1]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetborder1'); ?>" class="colorwell" /> Border <br />
<input type="text" id="widgetbackground1" name="<?php echo $settings; ?>[widgetbackground1]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetbackground1'); ?>" class="colorwell" /> Background <br />
<select name="<?php echo $settings; ?>[widget1-thickness]">
					<option style="padding-right:10px;" value="0px" <?php selected('0px', get_theme_mod('widget1-thickness')); ?>><?php _e("0px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="1px" <?php selected('1px', get_theme_mod('widget1-thickness')); ?>><?php _e("1px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="2px" <?php selected('2px', get_theme_mod('widget1-thickness')); ?>><?php _e("2px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="3px" <?php selected('3px', get_theme_mod('widget1-thickness')); ?>><?php _e("3px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="4px" <?php selected('4px', get_theme_mod('widget1-thickness')); ?>><?php _e("4px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="5px" <?php selected('5px', get_theme_mod('widget1-thickness')); ?>><?php _e("5px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="6px" <?php selected('6px', get_theme_mod('widget1-thickness')); ?>><?php _e("6px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="7px" <?php selected('7px', get_theme_mod('widget1-thickness')); ?>><?php _e("7px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="8px" <?php selected('8px', get_theme_mod('widget1-thickness')); ?>><?php _e("8px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="9px" <?php selected('9px', get_theme_mod('widget1-thickness')); ?>><?php _e("9px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="10px" <?php selected('10px', get_theme_mod('widget1-thickness')); ?>><?php _e("10px", 'sno'); ?></option>
					
				</select> Border Thickness</p>



<div class="divline"></div>
<p class="headingtext">Widget Style 2</p>

<div style="width:140px;float:right;">
<div style="padding:6px;color:<?php echo get_theme_mod('widgetcolor2-text'); ?>;background:<?php echo get_theme_mod('widgetcolor2'); ?> url(<?php bloginfo('template_url'); ?>/images/navbg.png) repeat-x !important;">Widget Title</div>
<div style="padding:10px;background:<?php echo get_theme_mod('widgetbackground2'); ?>;border-bottom: <?php echo get_theme_mod('widget2-thickness'); ?> solid <?php echo get_theme_mod('widgetborder2'); ?>; border-left: <?php echo get_theme_mod('widget2-thickness'); ?> solid <?php echo get_theme_mod('widgetborder2'); ?>;border-right: <?php echo get_theme_mod('widget2-thickness'); ?> solid <?php echo get_theme_mod('widgetborder2'); ?>">Click "Save Settings" Below to Update Appearance</div>
</div>


<p>

<input type="text" id="widgetcolor2" name="<?php echo $settings; ?>[widgetcolor2]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetcolor2'); ?>" class="colorwell" /> Title Bar <br />
<input type="text" id="widgetcolor2-text" name="<?php echo $settings; ?>[widgetcolor2-text]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetcolor2-text'); ?>" class="colorwell" /> Title Bar Text <br />
<input type="text" id="widgetborder2" name="<?php echo $settings; ?>[widgetborder2]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetborder2'); ?>" class="colorwell" /> Border<br />
<input type="text" id="widgetbackground2" name="<?php echo $settings; ?>[widgetbackground2]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetbackground2'); ?>" class="colorwell" /> Background<br />
<select name="<?php echo $settings; ?>[widget2-thickness]">
					<option style="padding-right:10px;" value="0px" <?php selected('0px', get_theme_mod('widget2-thickness')); ?>><?php _e("0px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="1px" <?php selected('1px', get_theme_mod('widget2-thickness')); ?>><?php _e("1px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="2px" <?php selected('2px', get_theme_mod('widget2-thickness')); ?>><?php _e("2px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="3px" <?php selected('3px', get_theme_mod('widget2-thickness')); ?>><?php _e("3px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="4px" <?php selected('4px', get_theme_mod('widget2-thickness')); ?>><?php _e("4px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="5px" <?php selected('5px', get_theme_mod('widget2-thickness')); ?>><?php _e("5px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="6px" <?php selected('6px', get_theme_mod('widget2-thickness')); ?>><?php _e("6px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="7px" <?php selected('7px', get_theme_mod('widget2-thickness')); ?>><?php _e("7px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="8px" <?php selected('8px', get_theme_mod('widget2-thickness')); ?>><?php _e("8px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="9px" <?php selected('9px', get_theme_mod('widget2-thickness')); ?>><?php _e("9px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="10px" <?php selected('10px', get_theme_mod('widget2-thickness')); ?>><?php _e("10px", 'sno'); ?></option>
					
				</select> Border Thickness</p>

<div class="divline"></div>

<p class="headingtext">Widget Style 3</p>

<div style="width:140px;float:right;">
<div style="padding:2px; font-size:10px;text-transform:uppercase;text-align:center;line-height:11px;color:<?php echo get_theme_mod('widgetcolor3-text'); ?>;background:<?php echo get_theme_mod('widgetcolor3'); ?> url(<?php bloginfo('template_url'); ?>/images/navbg.png) repeat-x !important;">Widget Title</div>
<div style="padding:10px;background:<?php echo get_theme_mod('widgetbackground3'); ?>;border-left: <?php echo get_theme_mod('widget3-thickness'); ?> solid <?php echo get_theme_mod('widgetborder3'); ?>;border-right: <?php echo get_theme_mod('widget3-thickness'); ?> solid <?php echo get_theme_mod('widgetborder3'); ?>">Click "Save Settings" Below to Update Appearance</div>
<div style="display:block;height:15px;background:<?php echo get_theme_mod('widgetcolor3'); ?> url(<?php bloginfo('template_url'); ?>/images/navbg.png) repeat-x !important;"></div>

</div>

<p>

<input type="text" id="widgetcolor3" name="<?php echo $settings; ?>[widgetcolor3]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetcolor3'); ?>" class="colorwell" /> Title Bar<br />
<input type="text" id="widgetcolor3-text" name="<?php echo $settings; ?>[widgetcolor3-text]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetcolor3-text'); ?>" class="colorwell" /> Title Bar Text <br />
<input type="text" id="widgetborder3" name="<?php echo $settings; ?>[widgetborder3]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetborder3'); ?>" class="colorwell" /> Border<br />
<input type="text" id="widgetbackground3" name="<?php echo $settings; ?>[widgetbackground3]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetbackground3'); ?>" class="colorwell" /> Background<br />
<select name="<?php echo $settings; ?>[widget3-thickness]">
					<option style="padding-right:10px;" value="0px" <?php selected('0px', get_theme_mod('widget3-thickness')); ?>><?php _e("0px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="1px" <?php selected('1px', get_theme_mod('widget3-thickness')); ?>><?php _e("1px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="2px" <?php selected('2px', get_theme_mod('widget3-thickness')); ?>><?php _e("2px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="3px" <?php selected('3px', get_theme_mod('widget3-thickness')); ?>><?php _e("3px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="4px" <?php selected('4px', get_theme_mod('widget3-thickness')); ?>><?php _e("4px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="5px" <?php selected('5px', get_theme_mod('widget3-thickness')); ?>><?php _e("5px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="6px" <?php selected('6px', get_theme_mod('widget3-thickness')); ?>><?php _e("6px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="7px" <?php selected('7px', get_theme_mod('widget3-thickness')); ?>><?php _e("7px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="8px" <?php selected('8px', get_theme_mod('widget3-thickness')); ?>><?php _e("8px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="9px" <?php selected('9px', get_theme_mod('widget3-thickness')); ?>><?php _e("9px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="10px" <?php selected('10px', get_theme_mod('widget3-thickness')); ?>><?php _e("10px", 'sno'); ?></option>
					
				</select> Border Thickness</p>

<div class="divline"></div>

<p class="headingtext">Widget Style 4</p>


<div style="width:140px;float:right;margin-bottom:10px;">
<div style="border-top: <?php echo get_theme_mod('widget4-thickness'); ?> solid <?php echo get_theme_mod('widgetborder4'); ?>; border-left: <?php echo get_theme_mod('widget4-thickness'); ?> solid <?php echo get_theme_mod('widgetborder4'); ?>;border-right: <?php echo get_theme_mod('widget4-thickness'); ?> solid <?php echo get_theme_mod('widgetborder4'); ?>;padding:10px;background: <?php echo get_theme_mod('widgetbackground4'); ?>;">
<div style="padding:2px;font-size:11px;line-height:13px;text-transform:uppercase;color:<?php echo get_theme_mod('widgetcolor4-text'); ?>;background:<?php echo get_theme_mod('widgetcolor4'); ?> url(<?php bloginfo('template_url'); ?>/images/navbg.png) repeat-x !important;">Widget Title</div>
</div>

<div style="margin-bottom:10px;padding:0px 10px 10px;background:<?php echo get_theme_mod('widgetbackground4'); ?>;border-left: <?php echo get_theme_mod('widget4-thickness'); ?> solid <?php echo get_theme_mod('widgetborder4'); ?>;border-right: <?php echo get_theme_mod('widget4-thickness'); ?> solid <?php echo get_theme_mod('widgetborder4'); ?>; border-bottom: <?php echo get_theme_mod('widget4-thickness'); ?> solid <?php echo get_theme_mod('widgetborder4'); ?>">Click "Save Settings" Below to Update Appearance</div>
</div>


<p>

<input type="text" id="widgetcolor4" name="<?php echo $settings; ?>[widgetcolor4]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetcolor4'); ?>" class="colorwell" /> Title Bar<br />
<input type="text" id="widgetcolor4-text" name="<?php echo $settings; ?>[widgetcolor4-text]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetcolor4-text'); ?>" class="colorwell" /> Title Bar Text <br />
<input type="text" id="widgetborder4" name="<?php echo $settings; ?>[widgetborder4]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetborder4'); ?>" class="colorwell" /> Border<br />
</p>

<div class="divline"></div>

<p class="headingtext">Widget Style 5</p>

<div style="width:140px;float:right;">
<div style="border-top:10px solid <?php echo get_theme_mod('widgetcolor5'); ?>; text-transform:capitalize;padding:5px 10px;color:<?php echo get_theme_mod('widgetcolor5-text'); ?>;background: <?php echo get_theme_mod('widgetbackground5'); ?>;font-weight:bold;">Widget Title</div>
<div style="padding:5px 10px 10px;background:<?php echo get_theme_mod('widgetbackground5'); ?>;">Click "Save Settings" Below to Update Appearance</div>
<div style="border-top:<?php echo get_theme_mod('widget5-thickness'); ?> solid <?php echo get_theme_mod('widgetborder5'); ?>;"></div>

</div>


<p>

<input type="text" id="widgetcolor5" name="<?php echo $settings; ?>[widgetcolor5]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetcolor5'); ?>" class="colorwell" /> Title Bar<br />
<input type="text" id="widgetcolor5-text" name="<?php echo $settings; ?>[widgetcolor5-text]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetcolor5-text'); ?>" class="colorwell" /> Title Bar Text <br />
<input type="text" id="widgetborder5" name="<?php echo $settings; ?>[widgetborder5]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetborder5'); ?>" class="colorwell" /> Border<br />
<input type="text" id="widgetbackground5" name="<?php echo $settings; ?>[widgetbackground5]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetbackground5'); ?>" class="colorwell" /> Background<br />
<select name="<?php echo $settings; ?>[widget5-thickness]">
					<option style="padding-right:10px;" value="0px" <?php selected('0px', get_theme_mod('widget5-thickness')); ?>><?php _e("0px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="1px" <?php selected('1px', get_theme_mod('widget5-thickness')); ?>><?php _e("1px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="2px" <?php selected('2px', get_theme_mod('widget5-thickness')); ?>><?php _e("2px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="3px" <?php selected('3px', get_theme_mod('widget5-thickness')); ?>><?php _e("3px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="4px" <?php selected('4px', get_theme_mod('widget5-thickness')); ?>><?php _e("4px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="5px" <?php selected('5px', get_theme_mod('widget5-thickness')); ?>><?php _e("5px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="6px" <?php selected('6px', get_theme_mod('widget5-thickness')); ?>><?php _e("6px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="7px" <?php selected('7px', get_theme_mod('widget5-thickness')); ?>><?php _e("7px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="8px" <?php selected('8px', get_theme_mod('widget5-thickness')); ?>><?php _e("8px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="9px" <?php selected('9px', get_theme_mod('widget5-thickness')); ?>><?php _e("9px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="10px" <?php selected('10px', get_theme_mod('widget5-thickness')); ?>><?php _e("10px", 'sno'); ?></option>
					
				</select> Border Thickness</p>

<div class="divline"></div>

<p class="headingtext">Widget Style 6</p>

<div style="width:140px;float:right;">
<div style="padding:6px;color:<?php echo get_theme_mod('widgetcolor6-text'); ?>;background:<?php echo get_theme_mod('widgetcolor6'); ?> url(<?php bloginfo('template_url'); ?>/images/navbg.png) repeat-x !important;border:<?php echo get_theme_mod('widget6-thickness'); ?> solid <?php echo get_theme_mod('widgetborder6'); ?>;">Widget Title</div>
<div style="padding:10px;background:<?php echo get_theme_mod('widgetbackground6'); ?>;border-left: <?php echo get_theme_mod('widget6-thickness'); ?> solid <?php echo get_theme_mod('widgetborder6'); ?>;border-right: <?php echo get_theme_mod('widget6-thickness'); ?> solid <?php echo get_theme_mod('widgetborder6'); ?>;border-bottom: <?php echo get_theme_mod('widget6-thickness'); ?> solid <?php echo get_theme_mod('widgetborder6'); ?>;">Click "Save Settings" Below to Update Appearance</div>

</div>

<p>
<input type="text" id="widgetcolor6" name="<?php echo $settings; ?>[widgetcolor6]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetcolor6'); ?>" class="colorwell" /> Title Bar<br />
<input type="text" id="widgetcolor6-text" name="<?php echo $settings; ?>[widgetcolor6-text]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetcolor6-text'); ?>" class="colorwell" /> Title Bar Text <br />
<input type="text" id="widgetborder6" name="<?php echo $settings; ?>[widgetborder6]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetborder6'); ?>" class="colorwell" /> Border<br />
<input type="text" id="widgetbackground6" name="<?php echo $settings; ?>[widgetbackground6]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetbackground6'); ?>" class="colorwell" /> Background<br />
<select name="<?php echo $settings; ?>[widget6-thickness]">
					<option style="padding-right:10px;" value="0px" <?php selected('0px', get_theme_mod('widget6-thickness')); ?>><?php _e("0px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="1px" <?php selected('1px', get_theme_mod('widget6-thickness')); ?>><?php _e("1px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="2px" <?php selected('2px', get_theme_mod('widget6-thickness')); ?>><?php _e("2px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="3px" <?php selected('3px', get_theme_mod('widget6-thickness')); ?>><?php _e("3px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="4px" <?php selected('4px', get_theme_mod('widget6-thickness')); ?>><?php _e("4px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="5px" <?php selected('5px', get_theme_mod('widget6-thickness')); ?>><?php _e("5px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="6px" <?php selected('6px', get_theme_mod('widget6-thickness')); ?>><?php _e("6px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="7px" <?php selected('7px', get_theme_mod('widget6-thickness')); ?>><?php _e("7px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="8px" <?php selected('8px', get_theme_mod('widget6-thickness')); ?>><?php _e("8px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="9px" <?php selected('9px', get_theme_mod('widget6-thickness')); ?>><?php _e("9px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="10px" <?php selected('10px', get_theme_mod('widget6-thickness')); ?>><?php _e("10px", 'sno'); ?></option>
					
				</select> Border Thickness</p>

<div class="divline"></div>

<p class="headingtext">Widget Style 7</p>

<div style="width:140px;float:right;">
<div style="padding:8px;color:<?php echo get_theme_mod('widgetcolor7-text'); ?>;background:<?php echo get_theme_mod('widgetcolor7'); ?>;border-bottom:<?php echo get_theme_mod('widget7-thickness'); ?> solid <?php echo get_theme_mod('widgetborder7'); ?>;">Widget Title</div>
<div style="padding:10px;background:<?php echo get_theme_mod('widgetbackground7'); ?>;">Click "Save Settings" Below to Update Appearance</div>

</div>

<p>
<input type="text" id="widgetcolor7" name="<?php echo $settings; ?>[widgetcolor7]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetcolor7'); ?>" class="colorwell" /> Title Bar<br />
<input type="text" id="widgetcolor7-text" name="<?php echo $settings; ?>[widgetcolor7-text]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetcolor7-text'); ?>" class="colorwell" /> Title Bar Text <br />
<input type="text" id="widgetborder7" name="<?php echo $settings; ?>[widgetborder7]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetborder7'); ?>" class="colorwell" /> Border<br />
<input type="text" id="widgetbackground7" name="<?php echo $settings; ?>[widgetbackground7]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('widgetbackground7'); ?>" class="colorwell" /> Background<br />
<select name="<?php echo $settings; ?>[widget7-thickness]">
					<option style="padding-right:10px;" value="0px" <?php selected('0px', get_theme_mod('widget7-thickness')); ?>><?php _e("0px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="1px" <?php selected('1px', get_theme_mod('widget7-thickness')); ?>><?php _e("1px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="2px" <?php selected('2px', get_theme_mod('widget7-thickness')); ?>><?php _e("2px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="3px" <?php selected('3px', get_theme_mod('widget7-thickness')); ?>><?php _e("3px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="4px" <?php selected('4px', get_theme_mod('widget7-thickness')); ?>><?php _e("4px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="5px" <?php selected('5px', get_theme_mod('widget7-thickness')); ?>><?php _e("5px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="6px" <?php selected('6px', get_theme_mod('widget7-thickness')); ?>><?php _e("6px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="7px" <?php selected('7px', get_theme_mod('widget7-thickness')); ?>><?php _e("7px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="8px" <?php selected('8px', get_theme_mod('widget7-thickness')); ?>><?php _e("8px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="9px" <?php selected('9px', get_theme_mod('widget7-thickness')); ?>><?php _e("9px", 'sno'); ?></option>
					<option style="padding-right:10px;" value="10px" <?php selected('10px', get_theme_mod('widget7-thickness')); ?>><?php _e("10px", 'sno'); ?></option>
					
				</select> Border Thickness</p>
</div>


<div style="clear:both"></div>

	</div>
</div>


<a class="menuitem submenuheader" href="http://www.schoolnewspapersonline.com/">Leaderboard Ad Area</a>
<div class="submenu">
	<div class="inside">
<div class="optionsbox">
	<p class="headingtext">Appearance</p>
		      <p>
				<select name="<?php echo $settings; ?>[display-leader]">
					<option style="padding-right:10px;" value="No" <?php selected('No', get_theme_mod('display-leader')); ?>><?php _e("No", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Yes" <?php selected('Yes', get_theme_mod('display-leader')); ?>><?php _e("Yes", 'sno'); ?></option>
				</select> Display Leaderboard Ad Area?
				</p>

				<p>
				<select name="<?php echo $settings; ?>[leaderboard-location]">
					<option style="padding-right:10px;" value="Above Header" <?php selected('Above Header', get_theme_mod('leaderboard-location')); ?>><?php _e("Above Header", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Below Header" <?php selected('Below Header', get_theme_mod('leaderboard-location')); ?>><?php _e("Below Header", 'sno'); ?></option>
				</select> Leaderboard Location
				</p>

				<p>
				<select name="<?php echo $settings; ?>[leaderboard-background-on]">
					<option style="padding-right:10px;" value="Transparent" <?php selected('Transparent', get_theme_mod('leaderboard-background-on')); ?>><?php _e("Transparent", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Color" <?php selected('Color', get_theme_mod('leaderboard-background-on')); ?>><?php _e("Color", 'sno'); ?></option>
				</select> Leaderboard Background
				</p>
				
				<p>
				<input type="text" id="leaderboard-background" name="<?php echo $settings; ?>[leaderboard-background]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('leaderboard-background'); ?>" class="colorwell" /> Leaderboard Background Color<br />
				
				</p>

<div class="divline"></div>

				<p class="headingtext">Type of Ad Space</p>
				<p>
				<select name="<?php echo $settings; ?>[leaderad-type]">
					<option style="padding-right:10px;" value="Static Image" <?php selected('Static Image', get_theme_mod('leaderad-type')); ?>><?php _e("Static Image", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Ad Tag" <?php selected('Ad Tag', get_theme_mod('leaderad-type')); ?>><?php _e("Ad Serving", 'sno'); ?></option>
				</select>
				</p>

<div class="divline"></div>

				<p class="headingtext">Top Right Image Space</p>
				<p>The top right space of the Leaderboard Ad area is designed for a static image 220px wide by 90px tall. Upload your image blow and after the upload is completed, click "Insert into Post".</p>

				<input class="upload_image_button6 button-primary" type="button" value="Click to Upload Ad Image"/>
				<input class="upload_image6" type="text" name="<?php echo $settings; ?>[leader-image-small]" value="<?php echo get_theme_mod('leader-image-small'); ?>" size="32" /> </p>
				<p>Image Link<br /><input type="text" name="<?php echo $settings; ?>[leader-url-small]" value="<?php echo get_theme_mod('leader-url-small'); ?>" size="32" /> </p>


</div>
<div class="optionsboxright">
<p class="headingtext">Options for Static Ad Image</p>
<p>The Leaderboard Ad area is designed for an ad image 728px wide by 90px tall. Upload your image blow and after the upload is completed, click "Insert into Post".</p>

				<input class="upload_image_button3 button-primary" type="button" value="Click to Upload Ad Image"/>
				<input class="upload_image3" type="text" name="<?php echo $settings; ?>[leader-image]" value="<?php echo get_theme_mod('leader-image'); ?>" size="32" /> </p>
				<p>Leaderboard Advertisement Link<br /><input type="text" name="<?php echo $settings; ?>[leader-url]" value="<?php echo get_theme_mod('leader-url'); ?>" size="32" /> </p>
<div class="divline"></div>
<p class="headingtext">Ad Serving Code</p>
				<p>Only use this option if you have subscribed to a third-party ad-server like OpenX or DFP.  Paste the ad tag they provide in the box below.
					<textarea name="<?php echo $settings; ?>[openx-code]" cols=33 rows=5><?php echo stripslashes(get_theme_mod('openx-code')); ?></textarea></p>

</div>


<div style="clear:both"></div>
	</div>
</div>
<a class="menuitem submenuheader" href="http://www.schoolnewspapersonline.com/">Footer Ad Area</a>
<div class="submenu">
	<div class="inside">
<div class="optionsbox">
	<p class="headingtext">Appearance</p>
		      <p>
				<select name="<?php echo $settings; ?>[display-leader-footer]">
					<option style="padding-right:10px;" value="No" <?php selected('No', get_theme_mod('display-leader-footer')); ?>><?php _e("No", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Yes" <?php selected('Yes', get_theme_mod('display-leader-footer')); ?>><?php _e("Yes", 'sno'); ?></option>
				</select> Display Footer Ad Area?
				</p>

				<p>
				<select name="<?php echo $settings; ?>[leaderboard-background-on-footer]">
					<option style="padding-right:10px;" value="Transparent" <?php selected('Transparent', get_theme_mod('leaderboard-background-on-footer')); ?>><?php _e("Transparent", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Color" <?php selected('Color', get_theme_mod('leaderboard-background-on-footer')); ?>><?php _e("Color", 'sno'); ?></option>
				</select> Footer Ad Background
				</p>
				
				<p>
				<input type="text" id="leaderboard-background-footer" name="<?php echo $settings; ?>[leaderboard-background-footer]; ?>" maxlength="7" size="7" value="<?php echo get_theme_mod('leaderboard-background-footer'); ?>" class="colorwell" /> Footer Ad Background Color<br />
				
				</p>

<div class="divline"></div>

				<p class="headingtext">Type of Ad Space</p>
				<p>
				<select name="<?php echo $settings; ?>[leaderad-type-footer]">
					<option style="padding-right:10px;" value="Static Image" <?php selected('Static Image', get_theme_mod('leaderad-type-footer')); ?>><?php _e("Static Image", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Ad Tag" <?php selected('Ad Tag', get_theme_mod('leaderad-type-footer')); ?>><?php _e("Ad Serving", 'sno'); ?></option>
				</select>
				</p>
</div>
<div class="optionsboxright">
<p class="headingtext">Options for Static Ad Image</p>
<p>The Footer Ad area is designed for an ad image 728px wide by 90px tall. Upload your image blow and after the upload is completed, click "Insert into Post".</p>

				<input class="upload_image_button7 button-primary" type="button" value="Click to Upload Ad Image"/>
				<input class="upload_image7" type="text" name="<?php echo $settings; ?>[leader-image-footer]" value="<?php echo get_theme_mod('leader-image-footer'); ?>" size="32" /> </p>
				<p>Footer Advertisement Link<br /><input type="text" name="<?php echo $settings; ?>[leader-url-footer]" value="<?php echo get_theme_mod('leader-url-footer'); ?>" size="32" /> </p>
<div class="divline"></div>
<p class="headingtext">Ad Serving Code</p>
				<p>Only use this option if you have subscribed to a third-party ad-server like OpenX or DFP.  Paste the ad tag they provide in the box below.
					<textarea name="<?php echo $settings; ?>[openx-code-footer]" cols=33 rows=5><?php echo stripslashes(get_theme_mod('openx-code-footer')); ?></textarea></p>

</div>


<div style="clear:both"></div>
	</div>
</div>


<a class="menuitem submenuheader" href="http://www.schoolnewspapersonline.com/">Favicon and Bullet Point Image</a>
<div class="submenu">
	<div class="inside">
	
	<div class="optionsbox">
		<p class="headingtext">Favicon</p>
				<p>A favicon is a small graphic that is associated with a website and that is displayed in the browser URL window as well as on the browser tab. To add a custom favicon, create a .png or .ico image that is 16px by 16px. After upload is completed, click "Insert into Post".</p>
				<input class="upload_image_button4 button-primary" type="button" value="Click to Upload Favicon Image"/>
				<input class="upload_image4" type="text" name="<?php echo $settings; ?>[favicon]" value="<?php echo get_theme_mod('favicon'); ?>" size="32" /> </p>
				<p>For an image generator tool, click <a target="_blank" href="http://schoolnewspapersonline.com/tools">here</a>.</p>
	</div>

	<div class="optionsboxright">
		<p class="headingtext">Bullet Point Image</p>

				<p>To add a custom bullet point image to replace the default black arrow, create a .png image that is 16px by 16px and upload it below. After upload is completed, click "Insert into Post".</p>
				<input class="upload_image_button5 button-primary" type="button" value="Click to Upload Bullet Point Image"/>
				<input class="upload_image5" type="text" name="<?php echo $settings; ?>[bullet-point]" value="<?php echo get_theme_mod('bullet-point'); ?>" size="32" /> </p>
				<p>For an image generator tool, click <a target="_blank" href="http://schoolnewspapersonline.com/tools">here</a>.</p>
	</div>
	

	<div style="clear:both"></div>

	</div>
</div>

<a class="menuitem submenuheader" href="http://www.schoolnewspapersonline.com/">Comments</a>
<div class="submenu">
	<div class="inside">

	<div class="optionsbox">
				<p><?php _e("Enable comments on your site?", 'sno'); ?>
				<select name="<?php echo $settings; ?>[comments]">
					<option style="padding-right:10px;" value="Enable" <?php selected('Enable', get_theme_mod('comments')); ?>>Enable</option>
					<option style="padding-right:10px;" value="Disable" <?php selected('Disable', get_theme_mod('comments')); ?>>Disable</option>
				</select></p>
				<p>Click on Discussion under the Settings tab to adjust the default WordPress settings for comments and comment approval.</p>
	</div>
	<div class="optionsboxright">
				<p class="headingtext">Comments Policy</p>
				<p>
		<textarea id="<?php echo $settings; ?>[comments-policy]" name="<?php echo $settings; ?>[comments-policy]" cols="33" rows="6"><?php echo get_theme_mod('comments-policy'); ?></textarea></p>
		<p>Any text entered above will be displayed just above the comments box on each story's page.</p>
	</div>
	<div style="clear:both"></div>


	</div>
</div>


<a class="menuitem submenuheader" href="http://www.schoolnewspapersonline.com/">GoPublish Breaking News Scrollbox</a>
<div class="submenu">
	<div class="inside">


<div class="optionsbox">
<p class="headingtext">Content and Appearance</p>
				<p><select name="<?php echo $settings; ?>[breakingnews-location]">
					<option style="padding-right:10px;" value="Header" <?php selected('Header', get_theme_mod('breakingnews-location')); ?>><?php _e("On", 'sno'); ?></option>
					<option style="padding-right:10px;" value="Off" <?php selected('Off', get_theme_mod('breakingnews-location')); ?>><?php _e("Off", 'sno'); ?></option>
				</select> Breaking News Scrollbox</p>
				
				<p>Set the category to <strong>Breaking News</strong>.<br />
    			        <?php wp_dropdown_categories(array('selected' => get_theme_mod('breakingnews-cat'), 'name' => $settings.'[breakingnews-cat]', 'orderby' => 'Name' , 'hierarchical' => 1, 'show_option_none' => __("None", 'sno'), 'hide_empty' => '0' )); ?>
    			</p>
				<p>
						<input type="text" name="<?php echo $settings; ?>[breakingnews-scrollbox]" value="<?php echo get_theme_mod('breakingnews-scrollbox'); ?>" size="2" /> Number of Headlines to Display
				</p>
				<p>
						<input type="text" id="breakingnews-color" name="<?php echo $settings; ?>[breakingnews-color]; ?>" value="<?php echo get_theme_mod('breakingnews-color'); ?>" maxlength="7" size="7" class="colorwell" /> Background Color <br />

						<input type="text" id="breakingnews-text" name="<?php echo $settings; ?>[breakingnews-text]; ?>" value="<?php echo get_theme_mod('breakingnews-text'); ?>" maxlength="7" size="7" class="colorwell" /> Text Color 

 </p>

 </div>

 <div class="optionsboxright">
 <p class="headingtext">Javascript Controls</p>                       
					<p>
                        <select name="<?php echo $settings; ?>[breaking-scroll-style]">
                         <option style="padding-right:10px;" value="vertical" <?php selected('vertical', get_theme_mod('breaking-scroll-style')); ?>><?php _e("vertical", 'sno'); ?></option>
					<option style="padding-right:10px;" value="horizontal" <?php selected('horizontal', get_theme_mod('breaking-scroll-style')); ?>><?php _e("horizontal", 'sno'); ?></option>
</select> Slide Direction<br />

                        <select name="<?php echo $settings; ?>[breakingnews-speed]">
                     <option style="padding-right:10px;" value="1000" <?php selected('1000', get_theme_mod('breakingnews-speed')); ?>><?php _e("1 Seconds", 'sno'); ?></option>
					<option style="padding-right:10px;" value="2000" <?php selected('2000', get_theme_mod('breakingnews-speed')); ?>><?php _e("2 Seconds", 'sno'); ?></option>
                    <option style="padding-right:10px;" value="3000" <?php selected('3000', get_theme_mod('breakingnews-speed')); ?>><?php _e("3 Seconds", 'sno'); ?></option>
					<option style="padding-right:10px;" value="4000" <?php selected('4000', get_theme_mod('breakingnews-speed')); ?>><?php _e("4 Seconds", 'sno'); ?></option>
                    <option style="padding-right:10px;" value="5000" <?php selected('5000', get_theme_mod('breakingnews-speed')); ?>><?php _e("5 Seconds", 'sno'); ?></option>
					<option style="padding-right:10px;" value="6000" <?php selected('6000', get_theme_mod('breakingnews-speed')); ?>><?php _e("6 Seconds", 'sno'); ?></option>
					<option style="padding-right:10px;" value="7000" <?php selected('7000', get_theme_mod('breakingnews-speed')); ?>><?php _e("7 Seconds", 'sno'); ?></option>
					<option style="padding-right:10px;" value="8000" <?php selected('8000', get_theme_mod('breakingnews-speed')); ?>><?php _e("8 Seconds", 'sno'); ?></option>
					<option style="padding-right:10px;" value="9000" <?php selected('9000', get_theme_mod('breakingnews-speed')); ?>><?php _e("9 Seconds", 'sno'); ?></option>
					<option style="padding-right:10px;" value="10000" <?php selected('10000', get_theme_mod('breakingnews-speed')); ?>><?php _e("10 Seconds", 'sno'); ?></option>
					<option style="padding-right:10px;" value="11000" <?php selected('11000', get_theme_mod('breakingnews-speed')); ?>><?php _e("11 Seconds", 'sno'); ?></option>
					<option style="padding-right:10px;" value="12000" <?php selected('12000', get_theme_mod('breakingnews-speed')); ?>><?php _e("12 Seconds", 'sno'); ?></option>

</select> Slide Duration<br />

                         <select name="<?php echo $settings; ?>[breakingnews-transition]">
                                        <option style="padding-right:10px;" value="666" <?php selected('666', get_theme_mod('breakingnews-transition')); ?>><?php _e("Fast", 'sno'); ?></option>
					<option style="padding-right:10px;" value="1300" <?php selected('1300', get_theme_mod('breakingnews-transition')); ?>><?php _e("Medium", 'sno'); ?></option>
                                        <option style="padding-right:10px;" value="2000" <?php selected('2000', get_theme_mod('breakingnews-transition')); ?>><?php _e("Slow", 'sno'); ?></option>
                                        <option style="padding-right:10px;" value="10000" <?php selected('10000', get_theme_mod('breakingnews-transition')); ?>><?php _e("Very Slow", 'sno'); ?></option>
</select> Slide Transition Time
				</p>

</div>


	
	<div style="clear:both"></div>
	</div>
</div>

<a class="menuitem submenuheader" href="http://www.schoolnewspapersonline.com/">Feedburner and Google Analytics</a>
<div class="submenu">
			<div class="inside">

			<div class="optionsbox">
			<p class="headingtext">Feedburner</p>
                
				<p><?php _e("Enter your Feedburner ID:", 'sno'); ?>
				<input type="text" name="<?php echo $settings; ?>[feedburner-code]" value="<?php echo get_theme_mod('feedburner-code'); ?>" size="10" /></p>

			</div>
			<div class="optionsboxright">
			<p class="headingtext">Google Analytics</p>
				<p><?php _e("Do you want to activate Google Analytics?", 'sno'); ?><br />
				<select name="<?php echo $settings; ?>[analytics]">
					<option style="padding-right:10px;" value="Yes" <?php selected('Yes', get_theme_mod('analytics')); ?>>Yes</option>
					<option style="padding-right:10px;" value="No" <?php selected('No', get_theme_mod('analytics')); ?>>No</option>
				</select></p>
                
				<p><?php _e("Enter your Google Anayltics UA code:", 'sno'); ?>
		<input type="text" name="<?php echo $settings; ?>[analytics_code]" value="<?php echo get_theme_mod('analytics_code'); ?>" size="10" /></p>
			</div>


			<div style="clear:both"></div>
            </div>
</div>
<a class="menuitem submenuheader" href="http://www.schoolnewspapersonline.com/">Footer Link</a>		
<div class="submenu" style="border-bottom:1px solid #cccccc;">
			<div class="inside">

			<div class="optionsboxright" style="width:555px">
                
				<p><?php _e("Footer Link:", 'sno'); ?>
				<input type="text" name="<?php echo $settings; ?>[google-apps]" value="<?php echo get_theme_mod('google-apps'); ?>" size="35" /></p>
				<p>The name of your Web site in the footer will link to the URL you've entered in the box above.  Make sure the link begins with <strong>http://</strong>.</p>
			</div>


			<div style="clear:both"></div>
            </div>
</div>


</div>



</div>

	<div class="metabox-holder" style="width:200px">

		<div id="snocolorpicker"></div>
		<p><input type="submit" class="button-primary save-button" value="<?php _e('Save All Settings') ?>" /></p>
	
	</div>        


    </div>
	    
	</form>

</div>
<?php }

// add CSS and JS if necessary
function theme_options_css_js() {
echo <<<CSS

<style type="text/css">
	.metabox-holder { 
		width: 350px; float: left;
		margin: 0px; padding: 0px 10px 0px 0px;
	}
	.metabox-holder .postbox .inside {
		padding: 0px 10px 0px 10px;
	}
</style>

CSS;
echo <<<JS

<script type="text/javascript">
jQuery(document).ready(function($) {
	$(".fade").fadeIn(1000).fadeTo(1000, 1).fadeOut(1000);
});
</script>

JS;
}
?>
