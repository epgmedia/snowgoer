<?php
/*
Plugin Name: GoPublish Ad Widget
Description: This widget allows you to place an ad widget in one of your columns.
Author: School Newspapers Online
Author URI: http://www.schoolnewspapersonline.com/
Version: 1.1
*/

add_action( 'widgets_init', create_function( '', "register_widget('sno_rightad');" ) );

class sno_rightad extends WP_Widget {

	function sno_rightad() {
		$widget_ops  = array(
			'classname'   => 'GoPublish Ad Widget',
			'description' => 'Use this widget to display an ad in one of your columns.'
		);
		$control_ops = array( 'width' => 750, 'height' => 250, 'id_base' => 'rightad' );
		$this->WP_Widget( 'rightad', 'GoPublish Ad Widget', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$customcolors = $instance['custom-colors'];
		$showtitle    = $instance['show-title'];


		$widget      = $this->id;
		$sidebartest = get_option( 'sidebars_widgets' );
		$columns     = get_theme_mod( 'sno-layout' );
		if ( ( $columns == "Option 3" ) || ( $columns == "Option 6" ) ) {
			$columnwidth = "even";
		} else {
			$columnwidth = "wide";
		}

		foreach ( $sidebartest["sidebar-1"] as $key => $value ) {
			if ( $widget == $value ) {
				$instance['sidebarname'] = 'Non-Home Sidebar';
				$instance['photowidth']  = get_option( 'non_home_right_column' );
			}
		}
		foreach ( $sidebartest["sidebar-2"] as $key => $value ) {
			if ( $widget == $value ) {
				$instance['sidebarname'] = 'Home Main Column';
				$instance['photowidth']  = get_option( 'home_right_column' );
			}
		}
		foreach ( $sidebartest["sidebar-3"] as $key => $value ) {
			if ( ( $widget == $value ) && ( $columnwidth == "even" ) ) {
				$instance['sidebarname'] = 'Home Bottom Left';
				$instance['photowidth']  = get_option( 'home_left_column' );
			}
			if ( ( $widget == $value ) && ( $columnwidth == "wide" ) ) {
				$instance['sidebarname'] = 'Home Bottom Narrow';
				$instance['photowidth']  = get_option( 'home_narrow_column' );
			}
		}
		foreach ( $sidebartest["sidebar-4"] as $key => $value ) {
			if ( ( $widget == $value ) && ( $columnwidth == "even" ) ) {
				$instance['sidebarname'] = 'Home Bottom Right';
				$instance['photowidth']  = get_option( 'home_center_column' );
			}
			if ( ( $widget == $value ) && ( $columnwidth == "wide" ) ) {
				$instance['sidebarname'] = 'Home Bottom Wide';
				$instance['photowidth']  = get_option( 'home_wide_column' );
			}
		}
		foreach ( $sidebartest["sidebar-5"] as $key => $value ) {
			if ( $widget == $value ) {
				$instance['sidebarname'] = 'Home Sidebar';
				$instance['photowidth']  = get_option( 'home_right_column' );
			}
		}
		foreach ( $sidebartest["sidebar-6"] as $key => $value ) {
			if ( $widget == $value ) {
				$instance['sidebarname'] = 'Ads Sidebar';
				$instance['photowidth']  = get_option( 'home_narrow_column' );
			}
		}


		if ( $instance['sidebarname'] == "Ads Sidebar" ) {

			echo '<div class="widgetwrap" style="-moz-box-shadow: none !important; -webkit-box-shadow: none !important; box-shadow: none !important;">'; ?>
			<?php if ( $showtitle == on ) { ?>
				<h4 <?php if ($customcolors == on) { ?>style="
					background-color:<?php echo $instance['header-color']; ?> !important;
					color:<?php echo $instance['header-text']; ?> !important;
					"<?php } ?> class="widget3">
					<?php echo $instance['title']; ?>
				</h4>
			<?php } ?>
			<div class="widgetbody3"
			     style="background:none !important;padding:0px !important;">
				<?php

				if ( $instance['ad-type'] == "Ad Tag" ) {

					echo $instance['godengo-adtag'];

				} else if ( ! empty( $instance['link_url'] ) ) {
					?>

					<a target="_blank" href="<?php echo $instance['link_url']; ?>"><img
							src="<?php echo $instance['ad_url']; ?>"
							style="width:<?php echo $instance['adwidth']; ?>"/></a>

				<?php } else if ( ! empty( $instance['ad_url'] ) ) { ?>
					<img src="<?php echo $instance['ad_url']; ?>"/>

				<?php } ?>

			</div>

			<?php if ( $showtitle == on ) { ?>
				<div <?php if ($customcolors
				               == on) { ?>style="background-color:<?php echo $instance['header-color']; ?> !important;"
				     <?php } ?>class="widgetfooter3"></div>
			<?php } else { ?>
				<div class="widgetfooter"></div>
			<?php } ?>
			</div><?php

		} else {

			echo '<div class="widgetwrap">'; ?>
			<?php if ( $showtitle == on ) { ?>
				<h4 <?php if ($customcolors == on) { ?>style="
					background-color:<?php echo $instance['header-color']; ?> !important;
					color:<?php echo $instance['header-text']; ?> !important;
					"<?php } ?> class="widget3">
					<?php echo $instance['title']; ?>
				</h4>
			<?php } ?>
			<div class="widgetbody3" <?php if ( $customcolors == on ) { ?> style="
				background-color:<?php echo $instance['widget-background']; ?> !important;
				"<?php } ?>><?php


				if ( $instance['ad-type'] == "Ad Tag" ) {

					echo '<div class="adcenter">' . $instance['godengo-adtag'] . '</div>';

				} else if ( ! empty( $instance['link_url'] ) ) {
					?>

					<a target="_blank" href="<?php echo $instance['link_url']; ?>"><img
							src="<?php echo $instance['ad_url']; ?>"
							style="width:<?php echo $instance['adwidth']; ?>"/></a>

				<?php } else if ( ! empty( $instance['ad_url'] ) ) { ?>
					<img src="<?php echo $instance['ad_url']; ?>" class="center"/>

				<?php } ?>

			</div>

			<?php if ( $showtitle == on ) { ?>
				<div <?php if ($customcolors
				               == on) { ?>style="background-color:<?php echo $instance['header-color']; ?> !important;"
				     <?php } ?>class="widgetfooter3"></div>
			<?php } else { ?>
				<div class="widgetfooter"></div>
			<?php } ?>
			</div><?php


		}

	}

	function update( $new_instance, $old_instance ) {
		$instance                      = $old_instance;
		$instance['title']             = $new_instance['title'];
		$instance['text']              = $new_instance['text'];
		$instance['widget-style']      = $new_instance['widget-style'];
		$instance['custom-colors']     = ( isset( $new_instance['custom-colors'] ) ? on : "" );
		$instance['header-color']      = $new_instance['header-color'];
		$instance['header-text']       = $new_instance['header-text'];
		$instance['widget-border']     = $new_instance['widget-border'];
		$instance['widget-background'] = $new_instance['widget-background'];
		$instance['border-thickness']  = $new_instance['border-thickness'];
		$instance['sidebarname']       = $new_instance['sidebarname'];
		$instance['ad_url']            = $new_instance['ad_url'];
		$instance['link_url']          = $new_instance['link_url'];
		$instance['sidebarsize']       = $new_instance['sidebarsize'];
		$instance['adwidth']           = $new_instance['adwidth'];
		$instance['show-title']        = $new_instance['show-title'];
		$instance['godengo-adtag']     = $new_instance['godengo-adtag'];
		$instance['ad-type']           = $new_instance['ad-type'];

		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			'header-color'      => get_theme_mod( 'accentcolor-header' ),
			'header-text'       => '#ffffff',
			'widget-border'     => '#aaaaaa',
			'widget-background' => '#eeeeee'
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		global $registered_sidebar;
		$sidebarname = $registered_sidebar['name'];
		?>

		<?php
		if ( ( $sidebarname == "Home Sidebar" ) || ( $sidebarname == "Non-Home Sidebar" )
		     || ( $sidebarname == "Sports Center Sidebar" )
		) {
			$sidebarsize = "300px wide by 250px tall";
			$adwidth     = get_option( 'home_right_column' );
		}
		if ( $sidebarname == "Home Bottom Narrow" ) {
			$sidebarsize = "160px wide by 600px tall";
			$adwidth     = get_option( 'home_narrow_column' );
		}
		if ( $sidebarname == "Home Bottom Wide" ) {
			$sidebarsize = "custom 400px wide";
			$adwidth     = get_option( 'home_wide_column' );
		}
		if ( $sidebarname == "Home Main Column" ) {
			$sidebarsize = "custom 590px wide";
			$adwidth     = get_option( 'home_full_width_column' );
		}
		if ( ( $sidebarname == "Home Bottom Left" )
		     || ( $sidebarname == "Home Bottom Right" )
		) {
			$sidebarsize = "custom 280px wide";
			$adwidth     = get_option( 'home_left_column' );
		}
		if ( $sidebarsize ) {
			$instance['sidebarsize'] = $sidebarsize;
		}
		if ( $adwidth ) {
			$instance['adwidth'] = $adwidth;
		}
		if ( $sidebarname ) {
			$instance['sidebarname'] = $sidebarname;
		} ?>

		<?php $number = $this->number; ?>

		<div
			style="float:left;width:230px;margin-right:20px;border-right:1px solid #aaaaaa;padding-right:10px;">

			<p>
				<label
					for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( "Title" ); ?>
					:</label><br/>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>"
				       name="<?php echo $this->get_field_name( 'title' ); ?>"
				       value="<?php echo $instance['title']; ?>" style="width:95%;"/>
			</p>

			<p>
				<select id="<?php echo $this->get_field_id( 'ad-type' ); ?>"
				        name="<?php echo $this->get_field_name( 'ad-type' ); ?>">
					<option value="Static Ad" <?php if ( 'Static Ad' == $instance['ad-type']
					) {
						echo 'selected="selected"';
					} ?>>Static Ad
					</option>
					<option value="Ad Tag" <?php if ( 'Ad Tag' == $instance['ad-type'] ) {
						echo 'selected="selected"';
					} ?>>Ad Tag
					</option>
				</select>
				<label for="<?php echo $this->get_field_id( 'ad-type' ); ?>">Ad Type</label>
			</p>
			<br/>

			<p style="font-weight:bold;text-decoration:underline">Static Ad Options</p>

			<p>Upload your <strong><?php echo $instance['sidebarsize']; ?> ad</strong> by
			   clicking the button below. After the image uploads, make sure the "Full Size"
			   button is checked and then click "Insert into Post".
			</p>

			<p>
				<input class="upload_image_button_ad<?php echo $number; ?> button-primary"
				       type="button" value="Click to Upload Image"/>
				<input class="upload_image_ad<?php echo $number; ?>" type="text"
				       id="<?php echo $this->get_field_id( 'ad_url' ); ?>"
				       name="<?php echo $this->get_field_name( 'ad_url' ); ?>"
				       style="width: 95%;" value="<?php echo $instance['ad_url']; ?>"/>
			</p>

			<p>If you want the advertisement to link to another Website, add a link in the box
			   below.</p>

			<p>
				<label
					for="<?php echo $this->get_field_id( 'link_url' ); ?>"><?php _e( 'Advertisement Link' ); ?>
					:</label><br/>
				<input id="<?php echo $this->get_field_id( 'link_url' ); ?>"
				       name="<?php echo $this->get_field_name( 'link_url' ); ?>"
				       style="width: 95%;" value="<?php echo $instance['link_url']; ?>"/>
			</p>
			<input type="hidden" id="<?php echo $this->get_field_id( 'sidebarsize' ); ?>"
			       name="<?php echo $this->get_field_name( 'sidebarsize' ); ?>"
			       value="<?php echo $instance['sidebarsize']; ?>"/>
			<input type="hidden" id="<?php echo $this->get_field_id( 'adwidth' ); ?>"
			       name="<?php echo $this->get_field_name( 'adwidth' ); ?>"
			       value="<?php echo $instance['adwidth']; ?>"/>
			<input type="hidden" id="<?php echo $this->get_field_id( 'sidebarname' ); ?>"
			       name="<?php echo $this->get_field_name( 'sidebarname' ); ?>"
			       value="<?php echo $instance['sidebarname']; ?>"/>

		</div>

		<div
			style="float:left;width:230px;margin-right:20px;border-right:1px solid #aaaaaa;padding-right:10px;">


			<p style="font-weight:bold;text-decoration:underline">Ad Tag Options</p>

			<p>
				<label
					for="<?php echo $this->get_field_id( 'godengo-adtag' ); ?>"><?php _e( 'Paste Ad Tag Here' ); ?>
					:</label><br/>
				<textarea id="<?php echo $this->get_field_id( 'godengo-adtag' ); ?>"
				          name="<?php echo $this->get_field_name( 'godengo-adtag' ); ?>"
				          style="width: 95%;"
				          rows="9"><?php echo $instance['godengo-adtag']; ?></textarea>
			</p>

		</div>


		<div style="float:left;width:210px">
			<p style="font-weight:bold;text-decoration:underline;">Widget Appearance</p>

			<p>
				<input class="checkbox" type="checkbox" <?php if ( $instance['show-title']
				                                                   == on
				) {
					echo checked;
				} ?> id="<?php echo $this->get_field_id( 'show-title' ); ?>"
				       name="<?php echo $this->get_field_name( 'show-title' ); ?>"/>
				<label for="<?php echo $this->get_field_id( 'show-title' ); ?>">Show Title
				                                                                Bar</label>
			</p>

			<p>
				<input class="checkbox" type="checkbox" <?php if ( $instance['custom-colors']
				                                                   == on
				) {
					echo checked;
				} ?> id="<?php echo $this->get_field_id( 'custom-colors' ); ?>"
				       name="<?php echo $this->get_field_name( 'custom-colors' ); ?>"/>
				<label for="<?php echo $this->get_field_id( 'custom-colors' ); ?>">Turn on
				                                                                   Custom
				                                                                   Widget
				                                                                   Colors</label>
			</p>

			<p>Save this widget to make the color selector active.</p>

			<p>
				<input class="colorwellad<?php echo $number; ?>"
				       id="<?php echo $this->get_field_id( 'header-color' ); ?>"
				       name="<?php echo $this->get_field_name( 'header-color' ); ?>"
				       type="text" maxlength="7" size="7"
				       value="<?php echo $instance['header-color']; ?>"/> Header Bar <br/>
				<input class="colorwellad<?php echo $number; ?>"
				       id="<?php echo $this->get_field_id( 'header-text' ); ?>"
				       name="<?php echo $this->get_field_name( 'header-text' ); ?>" type="text"
				       maxlength="7" size="7" value="<?php echo $instance['header-text']; ?>"/>
				                                                          Header Bar Text<br/>
				<input class="colorwellad<?php echo $number; ?>"
				       id="<?php echo $this->get_field_id( 'widget-border' ); ?>"
				       name="<?php echo $this->get_field_name( 'widget-border' ); ?>"
				       type="text" maxlength="7" size="7"
				       value="<?php echo $instance['widget-border']; ?>"/> Border<br/>
				<input class="colorwellad<?php echo $number; ?>"
				       id="<?php echo $this->get_field_id( 'widget-background' ); ?>"
				       name="<?php echo $this->get_field_name( 'widget-background' ); ?>"
				       type="text" maxlength="7" size="7"
				       value="<?php echo $instance['widget-background']; ?>"/> Background
			</p>

			<script>
				jQuery(document).ready(function () {
					var f = jQuery.farbtastic('#snocolorpickerad<?php echo $number; ?>');
					var p = jQuery('#snocolorpickerad<?php echo $number; ?>').css('opacity', 0.25);
					var selected;
					jQuery('.colorwellad<?php echo $number; ?>')
						.each(function () {
							f.linkTo(this);
							jQuery(this).css('opacity', 0.75);
						})
						.focus(function () {
							if (selected) {
								jQuery(selected).css('opacity', 0.75).removeClass('colorwell-selected');
							}
							f.linkTo(this);
							p.css('opacity', 1);
							jQuery(selected = this).css('opacity', 1).addClass('colorwell-selected');
						});

				});


				jQuery(document).ready(function () {
					jQuery('#snocolorpickerad<?php echo $number; ?>').hide();
					jQuery('#snocolorpickerad<?php echo $number; ?>').farbtastic(".colorwellad<?php echo $number; ?>");
					jQuery(".colorwellad<?php echo $number; ?>").click(function () {
						jQuery('#snocolorpickerad<?php echo $number; ?>').slideDown()
					});
				});

				jQuery(document).ready(function () {
					jQuery('.upload_image_button_ad<?php echo $number; ?>').click(function () {
						formfield = jQuery(this).prev('.upload_image_ad<?php echo $number; ?>');
						tb_show('', 'media-upload.php?type=image&TB_iframe=true');
						window.send_to_editor = function (html) {
							if (jQuery(html).is("a")) {
								var imgurl = jQuery('img', html).attr('src');
							} else if (jQuery(html).is("img")) {
								var imgurl = jQuery(html).attr('src');
							}
							jQuery('.upload_image_ad<?php echo $number; ?>').val(imgurl);
							tb_remove();
						}
						return false;
					});
				});


			</script>
			<div id="snocolorpickerad<?php echo $number; ?>"></div>

			<div style="width:210px;border-bottom:1px solid #aaaaaa;margin-bottom:10px;"></div>
			<p style="font-weight:bold;text-decoration:underline;">Important Note</p>

			<p>You must save this widget before the image uploader will work.</p>


		</div>
		<div style="clear:both"></div>


	<?php
	}
}

?>