<div class="topstoriescontainer">
<div id="homepagetop">
	
<?php $loopcounter=0; $featurecount = get_theme_mod('featured-count'); if ($featurecount == '') { $featurecount = 4; } ?>

                    <div id="slider">
                    
                    
<div id="slideshow">
                    <?php query_posts('showposts='.$featurecount.'&cat='.get_theme_mod('featured-cat')); ?> 

                    <?php if (have_posts()) : while (have_posts()) : the_post();  ?>
		
		<?php $customlink=get_post_meta($post->ID, customlink, true); ?>

		<div class="cycle">
				<?php $mmcheck = get_option('msno'); $video=get_post_meta($post->ID, video, true); if ((get_theme_mod('top-stories-video')=="Yes") && ($video) && ($mmcheck == "msno402841m")) { ?>
				<?php $pattern = "/height=\"[0-9]*\"/"; $video = preg_replace($pattern, "height='300'", $video); $pattern = "/width=\"[0-9]*\"/"; $video = preg_replace($pattern, "width='608'", $video); ?><div style="float:left;width:608px;"><?php echo $video; ?></div>

			<?php } else { ?>
		
			<?php global $post; $feature_photo = get_post_meta($post->ID, feature_photo, true); if (has_post_thumbnail()) 
			{ the_post_thumbnail( 'topstories', array('class' => 'sliderimage'));  } ?>
			
			<?php } ?>
					
		<?php if (get_theme_mod('featured-scroll') == "Show") { ?>	
		<?php if ((get_theme_mod('top-stories-video-teaser') == "No") && ($video) && ($mmcheck == "msno402841m")) {} else { ?>
			<div class="desc">
				<h3><a href="<?php if (($customlink) && (get_theme_mod('top-stories-links')=="Yes")) { echo $customlink; } else { the_permalink(); } ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h3>
			</div>
		<?php } ?>		
		<?php } ?>		
			
		</div>
                    <?php endwhile; else: ?>
                    <?php endif; ?>

</div><!-- end of #slideshow -->

                        
                    </div> <!-- end slider -->

</div>

<?php if (get_theme_mod('top-stories-nav-buttons')!="Off") { ?>
<div id="slideshow_navigation"><div id="pager"></div></div>
<?php } ?>


<!-- end slideshow navigation -->
</div><div style="clear:both"></div>