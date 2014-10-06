<?php
/*
Plugin Name: GoPublish Video Display Widget
Description: This plugin/widget allows you to place a video display widget in your sidebar.
Author: School Newspapers Online
Author URI: http://www.schoolnewspapersonline.com/
Version: 1.1
*/

add_action( 'widgets_init', create_function( '', "register_widget('sno_video');" ) );

class sno_video extends WP_Widget {

	function sno_video() {
		$widget_ops  = array(
			'classname'   => 'GoPublish Video Category Display',
			'description' => 'Use this widget to add a Video Display box for a category of videos.'
		);
		$control_ops = array( 'width' => 500, 'height' => 250, 'id_base' => 'video' );
		$this->WP_Widget( 'video', 'GoPublish Video Category Display', $widget_ops,
		                  $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$totalvideos = $instance['number'] + $instance['number-headlines'];
		if ( ! empty( $totalvideos ) ) {

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
					$instance['videowidth']  = get_option( 'non_home_right_column' );
				}
			}
			foreach ( $sidebartest["sidebar-2"] as $key => $value ) {
				if ( $widget == $value ) {
					$instance['sidebarname'] = 'Home Main Column';
					$instance['videowidth']  = get_option( 'home_full_width_column' );
				}
			}
			foreach ( $sidebartest["sidebar-3"] as $key => $value ) {
				if ( ( $widget == $value ) && ( $columnwidth == "even" ) ) {
					$instance['sidebarname'] = 'Home Bottom Left';
					$instance['videowidth']  = get_option( 'home_left_column' );
				}
				if ( ( $widget == $value ) && ( $columnwidth == "wide" ) ) {
					$instance['sidebarname'] = 'Home Bottom Narrow';
					$instance['videowidth']  = get_option( 'home_narrow_column' );
				}
			}
			foreach ( $sidebartest["sidebar-4"] as $key => $value ) {
				if ( ( $widget == $value ) && ( $columnwidth == "even" ) ) {
					$instance['sidebarname'] = 'Home Bottom Right';
					$instance['videowidth']  = get_option( 'home_center_column' );
				}
				if ( ( $widget == $value ) && ( $columnwidth == "wide" ) ) {
					$instance['sidebarname'] = 'Home Bottom Wide';
					$instance['videowidth']  = get_option( 'home_wide_column' );
				}
			}
			foreach ( $sidebartest["sidebar-5"] as $key => $value ) {
				if ( $widget == $value ) {
					$instance['sidebarname'] = 'Home Sidebar';
					$instance['videowidth']  = get_option( 'home_right_column' );
				}
			}
			foreach ( $sidebartest["sidebar-6"] as $key => $value ) {
				if ( $widget == $value ) {
					$instance['sidebarname'] = 'Ads Sidebar';
					$instance['videowidth']  = get_option( 'home_narrow_column' );
				}
			}

			echo '<div class="widgetwrap">'; ?>
			<?php $videotitle = $instance['title'];
			$categoryslug     = cat_id_to_slug( $instance['category'] );
			$customcolors     = $instance['custom-colors'];
			include( TEMPLATEPATH . "/widgetstyles.php" ); ?>


			<!--start of sidebar video-->
			<?php $totalvideos = $instance['number'] + $instance['number-headlines'];
			if ( ( ! is_int( $totalvideos ) ) || ( $totalvideos == 0 ) ) {
				$totalvideos = 1;
			}
			$videodivider = $instance['number'] + 1; ?>
			<?php $videowidth = $instance['videowidth'];
			if ( $videowidth == "" ) {
				$videowidth = get_option( 'home_left_column' );
			}
			$videoheight = $videowidth * .75;
			$videoheight = floor( $videoheight ); ?>
			<?php $videocount = 0;
			$recent           =
				query_posts( 'cat=' . $instance['category'] . '&showposts=' . $totalvideos );
			if ( have_posts() ) : while ( have_posts() ) : the_post();
				$videocount ++; ?>
				<?php global $post; ?>

				<?php if ( $videocount <= $instance['number'] ) { ?>

					<?php $video = get_post_meta( $post->ID, video, TRUE );
					if ( $video ) { ?><?php $pattern = "/height=\"[0-9]*\"/";
						$video                       =
							preg_replace( $pattern, "height='$videoheight'", $video );
						$pattern                     = "/width=\"[0-9]*\"/";
						$video                       =
							preg_replace( $pattern, "width='100%'", $video );
						echo $video; ?>

						<div style="<?php if ( ( ( $instance['show-headline'] == on )
						                         || ( $instance['show-teaser'] == on )
						                         || ( $instance['show-date'] == on )
						                         || ( $instance['show-comments'] == on )
						                         || ( $instance['show-writer'] )
						                         || ( is_user_logged_in() ) )
						                       && ( $instance['remove-padding'] == on )
						) { ?>padding:5px 10px 0px 10px;<?php } ?>">

							<?php if ( $instance['show-writer'] == "on" ) {
								$videographer = get_post_meta( $post->ID, videographer, TRUE );
								if ( $videographer ) {
									?><p class="photocredit">Video
								                             Credit: <?php echo $videographer; ?></p><?php } ?>
							<?php } ?>

							<?php if ( $instance['show-headline'] == "on" ) {
								$headlinesize   = $instance['headline-size'];
								$headlineheight = floor( $headlinesize * 1.5 ); ?>
								<a href="<?php the_permalink() ?>" rel="bookmark"
								   title="Permanent Link to <?php the_title(); ?>"><h3
										class="homeheadline"
										style="font-size:<?php echo $headlinesize; ?>px; line-height:<?php echo $headlineheight; ?>px;margin-top:0px"><?php the_title(); ?></h3>
								</a>
							<?php } ?>

							<?php if ( $instance['show-teaser'] == "on" ) { ?>
								<?php the_content_limit( 200 ); ?>
							<?php } ?>
							<?php
							if ( ( $instance['show-date'] == on )
							     || ( ( get_theme_mod( 'comments' ) == "Enable" )
							          && ( $instance['show-comments'] == on ) )
							     || ( is_user_logged_in() )
							) {
								?><p class="datetime"><?php
								if ( $instance['show-date'] == on ) {
									?><?php the_time( 'F j, Y ' );
								}
								if ( ( $instance['show-date'] == on )
								     && ( ( get_theme_mod( 'comments' ) == "Enable" )
								          && ( $instance['show-comments'] == on ) )
								) {
									echo ' &bull; ';
								}
								if ( ( get_theme_mod( 'comments' ) == "Enable" )
								     && ( $instance['show-comments'] == on )
								) {
									comments_popup_link( ' 0 comments', ' 1 comment',
									                     ' % comments' );
								}
								edit_post_link( 'Edit this story', ' &bull; ', '' ); ?></p>
							<?php } ?>

						</div>

						<?php if ( ( $videocount >= 1 ) && ( $videocount < $totalvideos )
						           && ( $totalvideos != 1 )
						) { ?><?php if ( $instance['dividing-line'] == on ) { ?>
							<div class="storybottom" <?php if ( $instance['remove-padding']
							                                    == on ) { ?>style="margin-left: 10px; margin-right: 10px;"<?php } ?>></div><?php } else { ?>
							<div class="storybottomnoline"></div><?php } ?><?php } ?>


					<?php } ?>
				<?php } else { ?>
					<div<?php if ( $instance['remove-padding'] == on
					) { ?> style="padding-left:10px;padding-right:10px"<?php } ?>>
						<?php if ( ( $videocount == $videodivider )
						           && ( $instance['headline-header'] == on )
						) { ?>
							<a href="/<?php echo $categoryslug; ?>"><p class="sectionhead"
							                                           style="font-size:16px;padding-top:15px;margin-bottom:7px;font-weight:bold;">
									Recent Videos</p></a>
						<?php } else { ?>
							<div style="margin-top:10px"></div><?php } ?>
						<?php if ( $instance['teaser-thumb'] == on ) {
							$thumbplacement = $instance['teaser-thumb-placement']; ?>


							<?php if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'videothumb', array(
										'class' => 'catboxthumb',
										'style' =>
											'margin-bottom:10px; float:' . $thumbplacement
											. '; margin-' . $thumbplacement . ':0px;'
									) );
							}


						} ?>
						<p><a class="homeheadline"
						      href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</p><?php if ( $instance['teaser-date'] == on ) { ?>
							<p><?php the_time( ' F j, Y' ); ?></p><?php } ?>
						<div style="clear:both;margin-top:15px"></div>
					</div>
				<?php } ?>
			<?php endwhile;
			else: endif; ?>

			<?php if ( $instance['view-all'] == on ) { ?>
				<?php if ( $instance['dividing-line'] == on ) { ?>
					<div
					class="storybottom" <?php if ( $instance['remove-padding'] ) { ?>style="margin-left:10px;margin-right:10px;"<?php } ?>></div><?php } else { ?>
					<div class="storybottomnoline"></div><?php } ?>
				<a href="<?php echo cat_id_to_slug( $instance['category'] ); ?>"><p
						class="viewall"
						<?php if ($instance['remove-padding']) { ?>style="margin-left:10px;margin-right:10px;padding-bottom:5px"<?php } ?>>
						View All <span class="arrows"> &raquo;</span></p></a>
			<?php } ?>

			<!--end of video-->


			</div>

			<div <?php if ($customcolors
			               == on) { ?>style="background-color:<?php echo $instance['header-color']; ?> !important;"
			     <?php } ?>class="widgetfooter<?php if ( $instance['widget-style']
			                                             == "Style 3"
			     ) { ?>3<?php } else { ?>1<?php } ?>"></div></div>

		<?php
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title']                  = strip_tags( $new_instance['title'] );
		$instance['number']                 = $new_instance['number'];
		$instance['number-headlines']       = $new_instance['number-headlines'];
		$instance['category']               = $new_instance['category'];
		$instance['videowidth']             = $new_instance['videowidth'];
		$instance['show-teaser']            =
			( isset( $new_instance['show-teaser'] ) ? on : "" );
		$instance['show-headline']          =
			( isset( $new_instance['show-headline'] ) ? on : "" );
		$instance['show-date']              =
			( isset( $new_instance['show-date'] ) ? on : "" );
		$instance['show-comments']          =
			( isset( $new_instance['show-comments'] ) ? on : "" );
		$instance['show-writer']            =
			( isset( $new_instance['show-writer'] ) ? on : "" );
		$instance['remove-padding']         =
			( isset( $new_instance['remove-padding'] ) ? on : "" );
		$instance['dividing-line']          =
			( isset( $new_instance['dividing-line'] ) ? on : "" );
		$instance['view-all']               = ( isset( $new_instance['view-all'] ) ? on : "" );
		$instance['headline-size']          = $new_instance['headline-size'];
		$instance['widget-style']           = $new_instance['widget-style'];
		$instance['custom-colors']          =
			( isset( $new_instance['custom-colors'] ) ? on : "" );
		$instance['header-color']           = $new_instance['header-color'];
		$instance['header-text']            = $new_instance['header-text'];
		$instance['widget-border']          = $new_instance['widget-border'];
		$instance['widget-background']      = $new_instance['widget-background'];
		$instance['border-thickness']       = $new_instance['border-thickness'];
		$instance['sidebarname']            = $new_instance['sidebarname'];
		$instance['teaser-thumb-placement'] = $new_instance['teaser-thumb-placement'];
		$instance['teaser-thumb']           =
			( isset( $new_instance['teaser-thumb'] ) ? on : "" );
		$instance['teaser-date']            =
			( isset( $new_instance['teaser-date'] ) ? on : "" );
		$instance['headline-header']        =
			( isset( $new_instance['headline-header'] ) ? on : "" );

		return $instance;
	}

	function form( $instance ) {
		$defaults = array(
			'title'             => 'Recent Videos',
			'number'            => '1',
			'number-headlines'  => '3',
			'show-teaser'       => 'on',
			'show-headline'     => 'on',
			'category-teaser'   => '150',
			'widget-style'      => get_theme_mod( 'widget-style' ),
			'view-all'          => 'on',
			'teaser-thumb'      => 'on',
			'header-color'      => get_theme_mod( 'accentcolor-header' ),
			'header-text'       => '#ffffff',
			'widget-border'     => '#aaaaaa',
			'widget-background' => '#eeeeee',
			'border-thickness'  => '1px'
		);
		$instance = wp_parse_args( (array) $instance, $defaults );


		global $registered_sidebar;
		$sidebarname = $registered_sidebar['name']; ?>

		<?php if ( $sidebarname == "Home Sidebar" ) {
			$videowidth = get_option( 'home_right_column' );
		} ?>
		<?php if ( ( $sidebarname == "Non-Home Sidebar" )
		           || ( $sidebarname == "Sports Center Sidebar" )
		) {
			$videowidth = get_option( 'non_home_right_column' );
		} ?>
		<?php if ( $sidebarname == "Home Bottom Narrow" ) {
			$videowidth = get_option( 'home_narrow_column' );
		} ?>
		<?php if ( $sidebarname == "Home Bottom Wide" ) {
			$videowidth = get_option( 'home_wide_column' );
		} ?>
		<?php if ( $sidebarname == "Home Main Column" ) {
			$videowidth = get_option( 'home_full_width_column' );
		} ?>
		<?php if ( $sidebarname == "Home Bottom Left" ) {
			$videowidth = get_option( 'home_left_column' );
		} ?>
		<?php if ( $sidebarname == "Home Bottom Right" ) {
			$videowidth = get_option( 'home_center_column' );
		} ?>
		<?php if ( $videowidth ) {
			$instance['videowidth'] = $videowidth;
		} ?>
		<?php if ( $sidebarname ) {
			$instance['sidebarname'] = $sidebarname;
		} ?>

		<div
			style="float:left;width:230px;margin-right:20px;border-right:1px solid #aaaaaa;padding-right:10px;">
			<p style="font-weight:bold;text-decoration:underline">Widget Content</p>

			<p>
				<label
					for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( "Widget Title:" ); ?></label><br/>
				<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>"
				       name="<?php echo $this->get_field_name( 'title' ); ?>"
				       value="<?php echo $instance['title']; ?>" style="width:95%;"/>
			</p>

			<p>
				<label
					for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( "Select your video category:" ); ?></label><br/>
				<?php wp_dropdown_categories( array(
					                              'selected'         => $instance['category'],
					                              'name'             => $this->get_field_name( 'category' ),
					                              'orderby'          => 'Name',
					                              'hierarchical'     => 1,
					                              'show_option_none' => __( "None",
					                                                        'studiopress' ),
					                              'hide_empty'       => '0'
				                              ) ); ?>
			</p>

			<div
				style="clear:both;border-bottom:1px solid #aaaaaa;padding-top:10px;margin-bottom:10px"></div>
			<p>
				<input id="<?php echo $this->get_field_id( 'number' ); ?>"
				       name="<?php echo $this->get_field_name( 'number' ); ?>" type="text"
				       maxlength="1" size="1" value="<?php echo $instance['number']; ?>"/>
				<label
					for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of Videos' ); ?></label>
			</p>

			<p>

				<input class="checkbox" type="checkbox" <?php if ( $instance['show-headline']
				                                                   == on
				) {
					echo checked;
				} ?> id="<?php echo $this->get_field_id( 'show-headline' ); ?>"
				       name="<?php echo $this->get_field_name( 'show-headline' ); ?>"/>
				<label for="<?php echo $this->get_field_id( 'show-headline' ); ?>">Show
				                                                                   Headline</label>
				<br/>

				<select id="<?php echo $this->get_field_id( 'headline-size' ); ?>"
				        name="<?php echo $this->get_field_name( 'headline-size' ); ?>">
					<option value="14" <?php if ( '14' == $instance['headline-size'] ) {
						echo 'selected="selected"';
					} ?>>14
					</option>
					<option value="16" <?php if ( '16' == $instance['headline-size'] ) {
						echo 'selected="selected"';
					} ?>>16
					</option>
					<option value="18" <?php if ( '18' == $instance['headline-size'] ) {
						echo 'selected="selected"';
					} ?>>18
					</option>
					<option value="20" <?php if ( '20' == $instance['headline-size'] ) {
						echo 'selected="selected"';
					} ?>>20
					</option>
					<option value="22" <?php if ( '22' == $instance['headline-size'] ) {
						echo 'selected="selected"';
					} ?>>22
					</option>
					<option value="24" <?php if ( '24' == $instance['headline-size'] ) {
						echo 'selected="selected"';
					} ?>>24
					</option>
					<option value="26" <?php if ( '26' == $instance['headline-size'] ) {
						echo 'selected="selected"';
					} ?>>26
					</option>
				</select>
				<label for="<?php echo $this->get_field_id( 'headline-size' ); ?>">Headline
				                                                                   Size</label>
			</p>

			<p>
				<input class="checkbox" type="checkbox" <?php if ( $instance['show-teaser']
				                                                   == on
				) {
					echo checked;
				} ?> id="<?php echo $this->get_field_id( 'show-teaser' ); ?>"
				       name="<?php echo $this->get_field_name( 'show-teaser' ); ?>"/>
				<label for="<?php echo $this->get_field_id( 'show-teaser' ); ?>">Show
				                                                                 Teaser</label>
				<br/>

				<input id="<?php echo $this->get_field_id( 'category-teaser' ); ?>"
				       name="<?php echo $this->get_field_name( 'category-teaser' ); ?>"
				       type="text" maxlength="3" size="3"
				       value="<?php echo $instance['category-teaser']; ?>"/>
				<label for="<?php echo $this->get_field_id( 'category-teaser' ); ?>">Teaser
				                                                                     Length
				                                                                     (characters)</label>
			</p>

			<p>
				<input class="checkbox" type="checkbox" <?php if ( $instance['show-writer']
				                                                   == on
				) {
					echo checked;
				} ?> id="<?php echo $this->get_field_id( 'show-writer' ); ?>"
				       name="<?php echo $this->get_field_name( 'show-writer' ); ?>"/>
				<label for="<?php echo $this->get_field_id( 'show-writer' ); ?>"> Show Video
				                                                                  Credit</label>
				<br/>

				<input class="checkbox" type="checkbox" <?php if ( $instance['show-date']
				                                                   == on
				) {
					echo checked;
				} ?> id="<?php echo $this->get_field_id( 'show-date' ); ?>"
				       name="<?php echo $this->get_field_name( 'show-date' ); ?>"/>
				<label for="<?php echo $this->get_field_id( 'show-date' ); ?>"> Show
				                                                                Date</label>
				<br/>

				<input class="checkbox" type="checkbox" <?php if ( $instance['show-comments']
				                                                   == on
				) {
					echo checked;
				} ?> id="<?php echo $this->get_field_id( 'show-comments' ); ?>"
				       name="<?php echo $this->get_field_name( 'show-comments' ); ?>"/>
				<label for="<?php echo $this->get_field_id( 'show-comments' ); ?>"> Show
				                                                                    Comments
				                                                                    Link</label>
			</p>

			<p>
				<input class="checkbox" type="checkbox" <?php if ( $instance['remove-padding']
				                                                   == on
				) {
					echo checked;
				} ?> id="<?php echo $this->get_field_id( 'remove-padding' ); ?>"
				       name="<?php echo $this->get_field_name( 'remove-padding' ); ?>"/>
				<label for="<?php echo $this->get_field_id( 'remove-padding' ); ?>"> Remove
				                                                                     padding
				                                                                     around
				                                                                     video</label>
				<br/>
				<input class="checkbox" type="checkbox" <?php if ( $instance['dividing-line']
				                                                   == on
				) {
					echo checked;
				} ?> id="<?php echo $this->get_field_id( 'dividing-line' ); ?>"
				       name="<?php echo $this->get_field_name( 'dividing-line' ); ?>"/>
				<label for="<?php echo $this->get_field_id( 'dividing-line' ); ?>"> Show
				                                                                    Dividing
				                                                                    Lines</label>

			</p>

			<div style="width:210px;border-bottom:1px solid #aaaaaa;margin-bottom:10px;"></div>

			<p>
				<input class="checkbox" type="checkbox" <?php if ( $instance['headline-header']
				                                                   == on
				) {
					echo checked;
				} ?> id="<?php echo $this->get_field_id( 'headline-header' ); ?>"
				       name="<?php echo $this->get_field_name( 'headline-header' ); ?>"/>
				<label for="<?php echo $this->get_field_id( 'headline-header' ); ?>"> Show
				                                                                      Recent
				                                                                      Headlines
				                                                                      Header</label><br/>

				<input id="<?php echo $this->get_field_id( 'number-headlines' ); ?>"
				       name="<?php echo $this->get_field_name( 'number-headlines' ); ?>"
				       type="text" maxlength="1" size="1"
				       value="<?php echo $instance['number-headlines']; ?>"/>
				<label
					for="<?php echo $this->get_field_id( 'number-headlines' ); ?>"><?php _e( 'Additional Video Headlines' ); ?></label><br/>
				<input class="checkbox" type="checkbox" <?php if ( $instance['teaser-thumb']
				                                                   == on
				) {
					echo checked;
				} ?> id="<?php echo $this->get_field_id( 'teaser-thumb' ); ?>"
				       name="<?php echo $this->get_field_name( 'teaser-thumb' ); ?>"/>
				<label for="<?php echo $this->get_field_id( 'teaser-thumb' ); ?>"> Show
				                                                                   Thumbnail
				                                                                   Images</label><br/>

				<select id="<?php echo $this->get_field_id( 'teaser-thumb-placement' ); ?>"
				        name="<?php echo $this->get_field_name( 'teaser-thumb-placement' ); ?>">
					<option value="left" <?php if ( 'left'
					                                == $instance['teaser-thumb-placement']
					) {
						echo 'selected="selected"';
					} ?>>Left
					</option>
					<option value="right" <?php if ( 'right'
					                                 == $instance['teaser-thumb-placement']
					) {
						echo 'selected="selected"';
					} ?>>Right
					</option>
				</select>
				<label for="<?php echo $this->get_field_id( 'teaser-thumb-placement' ); ?>">Thumbnail
				                                                                            Placement</label><br/>
				<input class="checkbox" type="checkbox" <?php if ( $instance['teaser-date']
				                                                   == on
				) {
					echo checked;
				} ?> id="<?php echo $this->get_field_id( 'teaser-date' ); ?>"
				       name="<?php echo $this->get_field_name( 'teaser-date' ); ?>"/>
				<label for="<?php echo $this->get_field_id( 'teaser-date' ); ?>"> Show
				                                                                  Date</label>

			</p>
			<div
				style="clear:both;border-bottom:1px solid #aaaaaa;padding-top:10px;margin-bottom:10px"></div>
			<p>
				<input class="checkbox" type="checkbox" <?php if ( $instance['view-all']
				                                                   == on
				) {
					echo checked;
				} ?> id="<?php echo $this->get_field_id( 'view-all' ); ?>"
				       name="<?php echo $this->get_field_name( 'view-all' ); ?>"/>
				<label for="<?php echo $this->get_field_id( 'view-all' ); ?>"> Show "View All"
				                                                               Link</label>
			</p>
			<input type="hidden" id="<?php echo $this->get_field_id( 'videowidth' ); ?>"
			       name="<?php echo $this->get_field_name( 'videowidth' ); ?>"
			       value="<?php echo $instance['videowidth']; ?>"/>
			<input type="hidden" id="<?php echo $this->get_field_id( 'sidebarname' ); ?>"
			       name="<?php echo $this->get_field_name( 'sidebarname' ); ?>"
			       value="<?php echo $instance['sidebarname']; ?>"/>

		</div>
		<div style="float:left;width:210px">
			<p style="font-weight:bold;text-decoration:underline;">Widget Appearance</p>

			<p>
				<select id="<?php echo $this->get_field_id( 'widget-style' ); ?>"
				        name="<?php echo $this->get_field_name( 'widget-style' ); ?>">
					<option value="Style 1" <?php if ( 'Style 1' == $instance['widget-style']
					) {
						echo 'selected="selected"';
					} ?>>Style 1
					</option>
					<option value="Style 2" <?php if ( 'Style 2' == $instance['widget-style']
					) {
						echo 'selected="selected"';
					} ?>>Style 2
					</option>
					<option value="Style 3" <?php if ( 'Style 3' == $instance['widget-style']
					) {
						echo 'selected="selected"';
					} ?>>Style 3
					</option>
					<option value="Style 4" <?php if ( 'Style 4' == $instance['widget-style']
					) {
						echo 'selected="selected"';
					} ?>>Style 4
					</option>
					<option value="Style 5" <?php if ( 'Style 5' == $instance['widget-style']
					) {
						echo 'selected="selected"';
					} ?>>Style 5
					</option>
					<option value="Style 6" <?php if ( 'Style 6' == $instance['widget-style']
					) {
						echo 'selected="selected"';
					} ?>>Style 6
					</option>
					<option value="Style 7" <?php if ( 'Style 7' == $instance['widget-style']
					) {
						echo 'selected="selected"';
					} ?>>Style 7
					</option>
				</select>
				<label for="<?php echo $this->get_field_id( 'widget-style' ); ?>">Widget
				                                                                  Style</label>
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
			<?php $number = $this->number; ?>

			<p>
				<input class="colorwellvideo<?php echo $number; ?>"
				       id="<?php echo $this->get_field_id( 'header-color' ); ?>"
				       name="<?php echo $this->get_field_name( 'header-color' ); ?>"
				       type="text" maxlength="7" size="7"
				       value="<?php echo $instance['header-color']; ?>"/> Header Bar <br/>
				<input class="colorwellvideo<?php echo $number; ?>"
				       id="<?php echo $this->get_field_id( 'header-text' ); ?>"
				       name="<?php echo $this->get_field_name( 'header-text' ); ?>" type="text"
				       maxlength="7" size="7" value="<?php echo $instance['header-text']; ?>"/>
				                                                          Header Bar Text<br/>
				<input class="colorwellvideo<?php echo $number; ?>"
				       id="<?php echo $this->get_field_id( 'widget-border' ); ?>"
				       name="<?php echo $this->get_field_name( 'widget-border' ); ?>"
				       type="text" maxlength="7" size="7"
				       value="<?php echo $instance['widget-border']; ?>"/> Border<br/>
				<input class="colorwellvideo<?php echo $number; ?>"
				       id="<?php echo $this->get_field_id( 'widget-background' ); ?>"
				       name="<?php echo $this->get_field_name( 'widget-background' ); ?>"
				       type="text" maxlength="7" size="7"
				       value="<?php echo $instance['widget-background']; ?>"/> Background
			</p>
			<script>
				jQuery(document).ready(function () {
					var f = jQuery.farbtastic('#snocolorpickervideo<?php echo $number; ?>');
					var p = jQuery('#snocolorpickervideo<?php echo $number; ?>').css('opacity', 0.25);
					var selected;
					jQuery('.colorwellvideo<?php echo $number; ?>')
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
					jQuery('#snocolorpickervideo<?php echo $number; ?>').hide();
					jQuery('#snocolorpickervideo<?php echo $number; ?>').farbtastic(".colorwellvideo<?php echo $number; ?>");
					jQuery(".colorwellvideo<?php echo $number; ?>").click(function () {
						jQuery('#snocolorpickervideo<?php echo $number; ?>').slideDown()
					});
				});
			</script>
			<div id="snocolorpickervideo<?php echo $number; ?>"></div>

			<p>
				<select id="<?php echo $this->get_field_id( 'border-thickness' ); ?>"
				        name="<?php echo $this->get_field_name( 'border-thickness' ); ?>">
					<option value="0px" <?php if ( '0px' == $instance['border-thickness'] ) {
						echo 'selected="selected"';
					} ?>>0px
					</option>
					<option value="1px" <?php if ( '1px' == $instance['border-thickness'] ) {
						echo 'selected="selected"';
					} ?>>1px
					</option>
					<option value="2px" <?php if ( '2px' == $instance['border-thickness'] ) {
						echo 'selected="selected"';
					} ?>>2px
					</option>
					<option value="3px" <?php if ( '3px' == $instance['border-thickness'] ) {
						echo 'selected="selected"';
					} ?>>3px
					</option>
					<option value="4px" <?php if ( '4px' == $instance['border-thickness'] ) {
						echo 'selected="selected"';
					} ?>>4px
					</option>
					<option value="5px" <?php if ( '5px' == $instance['border-thickness'] ) {
						echo 'selected="selected"';
					} ?>>5px
					</option>
					<option value="6px" <?php if ( '6px' == $instance['border-thickness'] ) {
						echo 'selected="selected"';
					} ?>>6px
					</option>
					<option value="7px" <?php if ( '7px' == $instance['border-thickness'] ) {
						echo 'selected="selected"';
					} ?>>7px
					</option>
					<option value="8px" <?php if ( '8px' == $instance['border-thickness'] ) {
						echo 'selected="selected"';
					} ?>>8px
					</option>
					<option value="9px" <?php if ( '9px' == $instance['border-thickness'] ) {
						echo 'selected="selected"';
					} ?>>9px
					</option>
					<option value="10px" <?php if ( '10px' == $instance['border-thickness'] ) {
						echo 'selected="selected"';
					} ?>>10px
					</option>
				</select>
				<label for="<?php echo $this->get_field_id( 'border-thickness' ); ?>"> Border
				                                                                       Thickness</label>
			<div
				style="clear:both;border-bottom:1px solid #aaaaaa;padding-top:10px;margin-bottom:10px"></div>
			<p style="font-weight:bold;text-decoration:underline;">Important Note</p>

			<p>This widget will display the embed code from the video custom field from stories
			   assigned to the selected category.</p>

		</div>
		<div style="clear:both"></div>

	<?php
	}
}

?>