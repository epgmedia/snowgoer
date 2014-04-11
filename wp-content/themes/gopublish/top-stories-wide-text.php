<div class="topstoriescontainer">
		<div id="homepagefull">


		
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
			<?php if (has_post_thumbnail()) 
			{ the_post_thumbnail( 'topstories', array('class' => 'sliderimage'));  } ?>
			<?php } ?>
			
			<div class="insert">

				<div class="contentbox">
					<?php if (get_theme_mod('top-stories-hide-cat')=="No") { ?>
						<p style="margin-bottom:0px"><a href="<?php echo cat_id_to_slug(get_theme_mod('featured-cat')); ?>" class="sectionhead" style="font-size:16px"><?php echo cat_id_to_name(get_theme_mod('featured-cat')); ?> <span class="arrows" style="font-size:24px"> &raquo;&raquo;</span></a></p>
					<?php } ?>
					<h3><a href="<?php if (($customlink) && (get_theme_mod('top-stories-links')=="Yes")) { echo $customlink; } else { the_permalink(); } ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h3>

					<?php $writercheck=get_post_meta($post->ID, writer, true); if ($writercheck) { ?>
						<p class="writer" style="font-size:12px;line-height:20px;"><?php snowriter(); ?></p>
					<?php } ?>
						
					<?php if (get_theme_mod('top-stories-hide-date')=="No") { ?>
						<p class="datetime" style="font-size:12px;padding-bottom:6px;line-height:12px;"><?php the_time('F j, Y'); ?></p>
					<?php } ?>

					<?php $contentteaser = get_theme_mod('top-stories-teaser'); ?>
					<?php if ($customlink) { the_content_limit($contentteaser, ""); } else { the_content_limit($contentteaser, "READ MORE <span style='font-size:24px;line-height:11px'>&raquo;&raquo;</span>"); } ?>
				</div>
				                
					<?php $caption=get_post_meta($post->ID, caption, true); if ($caption) { ?><div class="captionbox"><p>Caption: <?php echo $caption; ?></p></div><?php } ?>
				
			</div>
			
			<div class="desc" style="background:none;">

			</div>
			
		</div>
                    <?php endwhile; else: ?>
                    <?php endif; ?>

</div><!-- end of #slideshow -->

                        
                    </div> <!-- end slider -->

					</div>


<?php if (get_theme_mod('top-stories-nav-buttons')!="Off") { ?>
<div id="slideshow_navigation"><div id="pager"></div></div>
<?php } ?>

</div>
<div style="clear:both"></div>