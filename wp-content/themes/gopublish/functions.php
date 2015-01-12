<?php
include( TEMPLATEPATH . "/tools/theme-options.php" );
include( TEMPLATEPATH . "/tools/enews.php" );
include( TEMPLATEPATH . "/tools/snotext.php" );
include( TEMPLATEPATH . "/tools/audio.php" );
include( TEMPLATEPATH . "/tools/video.php" );
include( TEMPLATEPATH . "/tools/videoembed.php" );
include( TEMPLATEPATH . "/tools/advertisement.php" );
include( TEMPLATEPATH . "/tools/categorywidget.php" );
include( TEMPLATEPATH . "/tools/productshowcase.php" );
include( TEMPLATEPATH . "/tools/pagewidget.php" );

/** Ad Code is now managed in a seperate file */
include( get_template_directory() . '/tools/google-ads.php' );


add_option( "home_left_column", '280', '', 'yes' );
add_option( "home_center_column", '280', '', 'yes' );
add_option( "home_right_column", '300', '', 'yes' );
add_option( "home_narrow_column", '160', '', 'yes' );
add_option( "home_wide_column", '400', '', 'yes' );
add_option( "home_full_width_column", '590', '', 'yes' );
add_option( "non_home_right_column", '300', '', 'yes' );
add_option( "bsno", 'bsno837625', 'yes' );
update_option( "bsno", 'bsno837625b', 'yes' );
add_option( "bussno", 'bussno379657', 'yes' );
update_option( "bussno", 'bussno379657b', 'yes' );

add_theme_support( 'post-thumbnails' );

add_image_size( 'topstories', 608, 300, TRUE );
add_image_size( 'widesliderimage', 938, 300, TRUE );
add_image_size( 'home400', 400, 9999 );
add_image_size( 'permalink', 298, 9999 );
add_image_size( 'home260', 260, 260 );
add_image_size( 'home280', 278, 9999 );
add_image_size( 'archive', 200, 9999 );
add_image_size( 'home160', 158, 9999 );
add_image_size( 'homefeature', 158, 110, TRUE );
add_image_size( 'home120', 120, 9999 );
add_image_size( 'ae', 60, 90, TRUE );
add_image_size( 'homethumb', 70, 70, TRUE );
add_image_size( 'videothumb', 90, 60, TRUE );


add_filter( 'post_thumbnail_html', 'my_post_image_html', 10, 3 );

function my_post_image_html( $html, $post_id, $post_image_id ) {
	global $post;
	$customlink = get_post_meta( $post->ID, 'customlink', TRUE );
	$click      = get_post_meta( $post->ID, 'click_tracker_code', TRUE );
	if ( is_single() ) {
		$photolink = wp_get_attachment_image_src( get_post_thumbnail_id(), full );
		$html      = '<a id="single_image" href="' . $photolink[0] . '" title="'
		             . esc_attr( get_post_field( 'post_title', $post_id ) ) . '">' . $html
		             . '</a>';

		return $html;
	}
	if ( $customlink ) {
		$photolink = $customlink . $click;
		$target    = 'target="_blank" ';
	} else {
		$photolink = get_permalink( $post_id );
		$target    = '';
	}
	$html = '<a ' . $target . 'href="' . $photolink . '" title="'
	        . esc_attr( get_post_field( 'post_title', $post_id ) ) . '">' . $html . '</a>';

	return $html;
}

if ( ( get_theme_mod( 'sno-layout' ) == "Option 3" )
     || ( get_theme_mod( 'sno-layout' ) == "Option 6" )
) {
	if ( function_exists( 'register_sidebars' ) ) {
		register_sidebar( array(
			                  'name'          => 'Non-Home Sidebar',
			                  'before_widget' => '<div style="clear:both"></div><div class="widgetwrap"><div>',
			                  'after_widget'  => '</div><div class="widgetfooter"></div></div>',
			                  'before_title'  => '</div><div class="titlewrap300"><h2>',
			                  'after_title'   => '</h2></div><div class="widgetbody">',
		                  ) );
	}
	if ( function_exists( 'register_sidebars' ) ) {
		register_sidebar( array(
			                  'name'          => 'Home Main Column',
			                  'before_widget' => '<div style="clear:both"></div><div class="widgetwrap"><div>',
			                  'after_widget'  => '</div><div class="widgetfooter"></div></div>',
			                  'before_title'  => '</div><div class="titlewrap610"><h2>',
			                  'after_title'   => '</h2></div><div class="widgetbody">',
		                  ) );
	}
	if ( function_exists( 'register_sidebars' ) ) {
		register_sidebar( array(
			                  'name'          => 'Home Bottom Left',
			                  'before_widget' => '<div style="clear:both"></div><div class="widgetwrap"><div>',
			                  'after_widget'  => '</div><div class="widgetfooter"></div></div>',
			                  'before_title'  => '</div><div class="titlewrap280"><h2>',
			                  'after_title'   => '</h2></div><div class="widgetbody">',
		                  ) );
	}
	if ( function_exists( 'register_sidebars' ) ) {
		register_sidebar( array(
			                  'name'          => 'Home Bottom Right',
			                  'before_widget' => '<div style="clear:both"></div><div class="widgetwrap"><div>',
			                  'after_widget'  => '</div><div class="widgetfooter"></div></div>',
			                  'before_title'  => '</div><div class="titlewrap280"><h2>',
			                  'after_title'   => '</h2></div><div class="widgetbody">',
		                  ) );
	}
	if ( function_exists( 'register_sidebars' ) ) {
		register_sidebar( array(
			                  'name'          => 'Home Sidebar',
			                  'before_widget' => '<div style="clear:both"></div><div class="widgetwrap"><div>',
			                  'after_widget'  => '</div><div class="widgetfooter"></div></div>',
			                  'before_title'  => '</div><div class="titlewrap300"><h2>',
			                  'after_title'   => '</h2></div><div class="widgetbody">',
		                  ) );
	}
	if ( function_exists( 'register_sidebars' ) ) {
		register_sidebar( array(
			                  'name'          => 'Ads Sidebar',
			                  'before_widget' => '<div style="clear:both"></div><div class="widgetwrap"><div>',
			                  'after_widget'  => '</div><div class="widgetfooter"></div></div>',
			                  'before_title'  => '</div><div class="titlewrap160"><h2>',
			                  'after_title'   => '</h2></div><div class="widgetbody">',
		                  ) );
	}
} else {
	if ( function_exists( 'register_sidebars' ) ) {
		register_sidebar( array(
			                  'name'          => 'Non-Home Sidebar',
			                  'before_widget' => '<div style="clear:both"></div><div class="widgetwrap"><div>',
			                  'after_widget'  => '</div><div class="widgetfooter"></div></div>',
			                  'before_title'  => '</div><div class="titlewrap300"><h2>',
			                  'after_title'   => '</h2></div><div class="widgetbody">',
		                  ) );
	}
	if ( function_exists( 'register_sidebars' ) ) {
		register_sidebar( array(
			                  'name'          => 'Home Main Column',
			                  'before_widget' => '<div style="clear:both"></div><div class="widgetwrap"><div>',
			                  'after_widget'  => '</div><div class="widgetfooter"></div></div>',
			                  'before_title'  => '</div><div class="titlewrap610"><h2>',
			                  'after_title'   => '</h2></div><div class="widgetbody">',
		                  ) );
	}
	if ( function_exists( 'register_sidebars' ) ) {
		register_sidebar( array(
			                  'name'          => 'Home Bottom Narrow',
			                  'before_widget' => '<div style="clear:both"></div><div class="widgetwrap"><div>',
			                  'after_widget'  => '</div><div class="widgetfooter"></div></div>',
			                  'before_title'  => '</div><div class="titlewrap160"><h2>',
			                  'after_title'   => '</h2></div><div class="widgetbody">',
		                  ) );
	}
	if ( function_exists( 'register_sidebars' ) ) {
		register_sidebar( array(
			                  'name'          => 'Home Bottom Wide',
			                  'before_widget' => '<div style="clear:both"></div><div class="widgetwrap"><div>',
			                  'after_widget'  => '</div><div class="widgetfooter"></div></div>',
			                  'before_title'  => '</div><div class="titlewrap400"><h2>',
			                  'after_title'   => '</h2></div><div class="widgetbody">',
		                  ) );
	}
	if ( function_exists( 'register_sidebars' ) ) {
		register_sidebar( array(
			                  'name'          => 'Home Sidebar',
			                  'before_widget' => '<div style="clear:both"></div><div class="widgetwrap"><div>',
			                  'after_widget'  => '</div><div class="widgetfooter"></div></div>',
			                  'before_title'  => '</div><div class="titlewrap300"><h2>',
			                  'after_title'   => '</h2></div><div class="widgetbody">',
		                  ) );
	}
	if ( function_exists( 'register_sidebars' ) ) {
		register_sidebar( array(
			                  'name'          => 'Ads Sidebar',
			                  'before_widget' => '<div style="clear:both"></div><div class="widgetwrap"><div>',
			                  'after_widget'  => '</div><div class="widgetfooter"></div></div>',
			                  'before_title'  => '</div><div class="titlewrap160"><h2>',
			                  'after_title'   => '</h2></div><div class="widgetbody">',
		                  ) );
	}
}

//start widgetized-page code added by Nick 9/21/12

if ( function_exists( 'register_sidebars' ) ) {

	register_sidebars( 1,
	                   array(
		                   'name'          => 'showcases',
		                   'before_widget' => '<div id="%1$s" class="widget %2$s">',
		                   'after_widget'  => '</div>',
		                   'before_title'  => '<h2 class="widgettitle">',
		                   'after_title'   => '</h2>'
	                   )
	);

	register_sidebars( 1,
	                   array(
		                   'name'          => 'racing-challenge-ads',
		                   'before_widget' => '<div id="%1$s" class="widget %2$s">',
		                   'after_widget'  => '</div>',
		                   'before_title'  => '<h2 class="widgettitle">',
		                   'after_title'   => '</h2>'
	                   )
	);

	register_sidebars( 1,
	                   array(
		                   'name'          => 'racing-challenge-preview',
		                   'before_widget' => '<div id="%1$s" class="widget %2$s">',
		                   'after_widget'  => '</div>',
		                   'before_title'  => '<h2 class="widgettitle">',
		                   'after_title'   => '</h2>'
	                   )
	);

}
//end widgetized-page code added by Nick

// turns a category ID to a Name
function cat_id_to_name( $id ) {
	foreach ( (array) ( get_categories() ) as $category ) {
		if ( $id == $category->cat_ID ) {

			return $category->cat_name;
			break;
		}
	}
}

// turns a category ID to a Slug
function cat_id_to_slug( $id ) {
	$slug = get_category_link( $id );

	return $slug;
}

// turns a page ID to a Name
function page_id_to_name( $id ) {
	global $page;

	if ( $id == $page->page_ID ) {

		return $page->page_name;
	}
}

add_theme_support( 'nav-menus' );

function the_content_limit(
	$max_char, $more_link_text = '(more...)', $stripteaser = 0, $more_file = ''
) {
	$content = get_the_content( $more_link_text, $stripteaser, $more_file );
	$content = apply_filters( 'the_content', $content );
	$content = str_replace( ']]>', ']]&gt;', $content );
	$content = strip_tags( $content );

	if ( strlen( $_GET['p'] ) > 0 ) {
		echo "<p>";
		echo $content;
		echo "</p>";
	} else if ( ( strlen( $content ) > $max_char )
	            && ( $espacio = strpos( $content, " ", $max_char ) )
	) {
		$content = substr( $content, 0, $espacio );
		$content = $content;
		echo "<p>";
		echo $content;
		echo "...";
		echo "&nbsp;<a href='";
		the_permalink();
		echo "'>" . $more_link_text . "</a>";
		echo "</p>";
	} else {
		echo "<p>";
		echo $content;
		echo "</p>";
	}
}

function snowriter() {
	global $post;
	$writer   = get_post_meta( $post->ID, writer, TRUE );
	$jobtitle = get_post_meta( $post->ID, jobtitle, TRUE );
	if ( $writer != "" ) {
		$args          =
			array( 'meta_key' => 'name', 'meta_value' => $writer, 'numberposts' => 1 );
		$queried_posts = get_posts( $args );

		if ( $queried_posts ) {
			foreach ( $queried_posts as $queried_post ) {
				$thePostID = $queried_post->ID;
				$link      = get_permalink( $thePostID );
				echo '<a href="' . $link . '">' . $writer . '</a>';
				if ( $jobtitle ) {
					echo ', ' . $jobtitle;
				}
				echo '<br />';
			}
		} else {
			echo $writer;
			if ( $jobtitle ) {
				echo ', ' . $jobtitle;
			}
			echo '<br />';
		}
	}
}

function remove_admin_bar_links() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu( 'new-content' );
	$wp_admin_bar->remove_menu( 'updates' );
	$wp_admin_bar->remove_menu( 'appearance' );
	$wp_admin_bar->remove_menu( 'wp-logo' );
}

add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

function my_admin_bar_menu() {
	global $wp_admin_bar;
	if ( ! is_user_logged_in() || ! is_admin_bar_showing() ) {
		return;
	}
	$wp_admin_bar->add_menu( array(
		                         'id'    => 'custom_menu',
		                         'title' => __( 'GoPublish Framework' ),
		                         'href'  => FALSE
	                         ) );
	$wp_admin_bar->add_menu( array(
		                         'parent' => 'custom_menu',
		                         'title'  => __( 'Add a Story' ),
		                         'href'   => '/wp-admin/post-new.php?custom-write-panel-id=1'
	                         ) );
	$wp_admin_bar->add_menu( array(
		                         'parent' => 'custom_menu',
		                         'title'  => __( 'Add, Delete, or Rearrange Widgets' ),
		                         'href'   => '/wp-admin/widgets.php'
	                         ) );
	$wp_admin_bar->add_menu( array(
		                         'parent' => 'custom_menu',
		                         'title'  => __( 'Edit Navigation Menus' ),
		                         'href'   => '/wp-admin/nav-menus.php'
	                         ) );
	$wp_admin_bar->add_menu( array(
		                         'parent' => 'custom_menu',
		                         'title'  => __( 'Change Colors, Columns, or Appearance' ),
		                         'href'   => '/wp-admin/themes.php?page=theme-options'
	                         ) );
	$wp_admin_bar->add_menu( array(
		                         'id'    => 'custom_menu_help',
		                         'title' => __( 'GoPublish Help and Support' ),
		                         'href'  => FALSE
	                         ) );
	$wp_admin_bar->add_menu( array(
		                         'parent' => 'custom_menu_help',
		                         'title'  => __( 'Instruction Manual and Videos' ),
		                         'meta'   => array( 'target' => '_blank' ),
		                         'href'   => 'http://www.schoolnewspapersonline.com/instruction-manual-4-2/'
	                         ) );
	$wp_admin_bar->add_menu( array(
		                         'id'    => 'custom_menu_logout',
		                         'title' => __( 'Logout' ),
		                         'href'  => wp_logout_url( home_url() )
	                         ) );
}

function sno_dashboard_widget() {
	// Display whatever it is you want to show
	echo '<div class="alignright browser-icon" style="margin-top:-30px;"><a href="http://schoolwebworks.com"><img src="/wp-content/themes/enterprise/images/swwlogo.png" alt="" /></a></div>';
	include_once( ABSPATH . WPINC . '/rss.php' ); // path to include script
	$feed  =
		fetch_rss( 'http://sww.zendesk.com/forums/202259-announcements' ); // specify feed url
	$items = array_slice( $feed->items, 0, 2 ); // specify first and last item
	if ( ! empty( $items ) ) :
		foreach ( $items as $item ) :
			echo '<a style="font-size:15px;line-height:22px;" href="' . $item["link"] . '">'
			     . $item["title"]
			     . '</a><span style="margin-left:5px;font-size:10px;color:#666666;">'
			     . date( "F j, Y", strtotime( $item["pubdate"] ) ) . '</span>';
			$content = $item['description'];
			$content = apply_filters( 'the_content', $content );
			$content = str_replace( ']]>', ']]&gt;', $content );
			$content = strip_tags( $content );
			if ( ( strlen( $content ) > 350 )
			     && ( $espacio = strpos( $content, " ", 350 ) )
			) {
				$content = substr( $content, 0, $espacio );
				$content = $content;
				echo "<p style='margin-top:3px;font-size:12px;line-height:18px'>" . $content
				     . "...&nbsp;<a href='" . $item['link'] . "'>Read More</a>" . "</p>";
			} else {
				echo "<p>" . $content . "</p>";
			}
		endforeach;
	endif; ?>
	<br/>
	<p style="font-size:16px;margin:0px;">About This Site</p>
	<p style="margin-top:3px"><?php
		$theme_data = get_theme_data( ABSPATH . 'wp-content/themes/gopublish/style.css' );
		echo $theme_data['Author']; ?> <?php
		echo $theme_data['Name']; ?> Version <?php
		echo $theme_data['Version']; ?>
		<br/>Powered by WordPress Version <?php bloginfo( 'version' ); ?></p>
	<p style="font-size:16px;margin:0px;"><a target="_blank" href="http://sww.zendesk.com/">Submit
	                                                                                        a
	                                                                                        Support
	                                                                                        Request</a>
	</p>
<?php
}

function sno_add_dashboard_widgets() {
	wp_add_dashboard_widget( 'sno_announcements', 'News & Announcements from School Webworks',
	                         'sno_dashboard_widget' );
	global $wp_meta_boxes;
	$normal_dashboard  = $wp_meta_boxes['dashboard']['normal']['core'];
	$sno_widget_backup =
		array( 'sno_announcements' => $normal_dashboard['sno_announcements'] );
	unset( $normal_dashboard['sno_announcements'] );
	$sorted_dashboard                             =
		array_merge( $sno_widget_backup, $normal_dashboard );
	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
}

//add_action('admin_bar_menu', 'my_admin_bar_menu');
//add_action('wp_dashboard_setup', 'sno_add_dashboard_widgets' );

function sno_css() {
	$favicon = get_theme_mod( 'favicon' );
	echo '<link rel="Shortcut Icon" href="' . $favicon . '" type="image/x-icon" />
   <style type="text/css">
		#sno_announcements h3 { background:#990000; color:#ffffff;text-shadow:none;}
		#sno_announcements {border-color:#990000; -moz-box-shadow: 1px 1px 5px #888; -webkit-box-shadow: 1px 1px 5px #888; box-shadow: 1px 1px 5px #888;}
		#sno_announcements a {color:#990000;}
		#sno_announcements a:hover {color:#990000;text-decoration:underline;}
		.sno_options_page .postbox {border: 1px solid #777777; -moz-box-shadow: 1px 1px 5px #888; -webkit-box-shadow: 1px 1px 5px #888; box-shadow: 1px 1px 5px #888; }   
		.sno_options_page h3, .sno_options_page h3:hover { background:#777777; color:#ffffff;text-shadow:none;cursor:default;}
		.sno_options_page .divline {clear:both;border-top:1px solid #888888;margin:25px 0px;}
		.sno_options_page p {margin: 0 0 1em 0}
		#snocolorpicker { position:fixed;border:1px solid #aaaaaa;}
		input.save-button { position:fixed;margin-top:240px;margin-left:15px;font-size:18px!important;}
		.optionsbox {padding:10px;border:1px solid #aaaaaa;background:#ffffff;width:260px;float:left;margin-right:10px;}
		.optionsboxright {padding:10px;border:1px solid #aaaaaa;background:#ffffff;width:260px;float:left;}
		.headingtext { font-weight:bold;font-size:14px;}
		.glossymenu{ margin: 5px 0; padding: 0; border: 1px solid #cccccc; border-bottom-width: 0; }
		.glossymenu a.menuitem { background: black url(/wp-content/themes/gopublish/images/glossyback.gif) repeat-x bottom left; font: 18px "Lucida Grande", "Trebuchet MS", Verdana, Helvetica, sans-serif; color: white; display: block; position: relative; width: auto; padding: 6px 0; padding-left: 10px; text-decoration: none; }
		.glossymenu a.menuitem:visited, .glossymenu .menuitem:active { color: white; }
		.glossymenu a.menuitem .statusicon{ margin-right:10px; border: none; }
		.glossymenu a.menuitem:hover { background-image: url(/wp-content/themes/gopublish/images/glossyback2.gif); }
		.glossymenu div.submenu{ padding:10px 10px 10px 10px; background: #f5f5f5; }
	</style>';
}

add_action( 'admin_head', 'sno_css' );

function sno_admin_scripts() {
	wp_enqueue_script( 'media-upload' );
	wp_enqueue_script( 'thickbox' );
	wp_register_script( 'sno-upload', get_bloginfo( 'template_url' ) . '/tools/sno-script.js',
	                    array( 'jquery', 'media-upload', 'thickbox' ) );
	wp_enqueue_script( 'sno-upload' );
	wp_enqueue_script( 'jquery.js' );
}

function sno_admin_styles() {
	wp_enqueue_style( 'thickbox' );
}

if ( isset( $_GET['page'] ) && $_GET['page'] == 'theme-options' ) {
	add_action( 'admin_print_scripts', 'sno_admin_scripts' );
	add_action( 'admin_print_styles', 'sno_admin_styles' );
}

add_action( 'init', 'sno_farbtastic_script' );
function sno_farbtastic_script() {
	wp_enqueue_style( 'farbtastic' );
	wp_enqueue_script( 'farbtastic' );
}

add_action( 'init', 'sno_thickbox_script' );
function sno_thickbox_script() {
	wp_enqueue_style( 'thickbox' );
	wp_enqueue_script( 'thickbox' );
}

function add_admin_bar_link( $wp_admin_bar ) {
	$class = 'epg-media-link';
	$wp_admin_bar->add_menu( array(
		                         'id'    => 'epg-media-link',
		                         'title' => __( 'EPG Media, LLC' ),
		                         'href'  => __( 'http://www.epgmediallc.com' ),

	                         ) );
	$wp_admin_bar->add_menu( array(
		                         'parent' => 'epg-media-link',
		                         'id'     => 'epg-media-time-off',
		                         'title'  => __( 'Time Off Request' ),
		                         'href'   => __( 'http://www.epgmediallc.com/time-off-request/' ),
	                         ) );
	$wp_admin_bar->add_menu( array(
		                         'parent' => 'epg-media-link',
		                         'id'     => 'epg-media-support',
		                         'title'  => __( 'IT Request' ),
		                         'href'   => __( 'http://www.epgmediallc.com/it-request/' ),
	                         ) );

}

// Add EPG Media menu links
add_action( 'admin_bar_menu', 'add_admin_bar_link', 50 );

// Set max number of post revisions to hold
if ( ! defined( 'WP_POST_REVISIONS' ) ) {
	define( 'WP_POST_REVISIONS', 5 );
}
