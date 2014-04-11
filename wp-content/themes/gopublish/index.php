<?php get_header(); ?>

           <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
           <?php $teamschedulecheck = get_post_meta($post->ID, opponent, true); $staffposition = get_post_meta($post->ID, name, true); ?>
           <?php endwhile; else: ?>
           
           <?php endif; ?>

<?php if ($staffposition) { include(TEMPLATEPATH."/staff.php"); } else { ?>
<?php if ($teamschedulecheck) { include(TEMPLATEPATH."/teamschedule.php"); } else { ?>


<div id="content">

   <div id="contentleft">
   
       <div class="postarea">
       

       <?php include(TEMPLATEPATH."/breadcrumb.php");?>

           <?php if (have_posts()) : while (have_posts()) : the_post(); 
           
           		 	$photographer = get_post_meta($post->ID, photographer, true); 
            		$caption = get_post_meta($post->ID, caption, true); 
            		$video = get_post_meta($post->ID, video, true); 
            		$slideshowcredit = get_post_meta($post->ID, slideshowcredit, true); 
            		$jobtitle = get_post_meta($post->ID, jobtitle, true); 
            		$writer = get_post_meta($post->ID, writer, true); 
            		$related = get_post_meta($post->ID, related, true);
             		$featured = get_post_meta($post->ID, featured, true); 
            		$videographer = get_post_meta($post->ID, videographer, true); ?>

			<?php if ($video) { ?>
				<?php $pattern = "/height=\"[0-9]*\"/"; $video1 = preg_replace($pattern, "height='400'", $video); $pattern = "/width=\"[0-9]*\"/"; $video1 = preg_replace($pattern, "width='590'", $video1); ?>
				<div style="margin-bottom:15px">
				<?php echo $video1; ?>
					<?php if ($videographer) { ?><p class="photocredit" style="padding-bottom:0px">Video Credit: <?php echo $videographer; ?></p><?php } ?>
				</div> 
			<?php } ?>
			
           <h1 style="line-height:40px"><?php the_title(); ?></h1>

                   <div id="permalinkphotobox">


                        <?php if ($audio) { $audioplayer = "[audio:" . $audio . "]"; if (function_exists('insert_audio_player')) { insert_audio_player($audioplayer); } ?><div style="margin-bottom:15px"></div><?php } ?>

                                        
                        <?php if ($slideshow) { $showalbum = "[slideshow id =" . $slideshow . " w=302 h=200]"; echo do_shortcode($showalbum); ?><div style="margin-bottom:15px"></div><?php } ?>
                        
                        <?php if ($gallery) { $showalbum = "[nggallery id =" . $gallery . " w=50 h=50]"; echo do_shortcode($showalbum); ?><?php } ?>

                       <?php if ($slideshowcredit) { ?><p class="photocredit">Credit: <?php echo $slideshowcredit; ?></p><?php } ?>

						<?php if ($featured != "No") { ?>

							<?php if (has_post_thumbnail()) 
								{ the_post_thumbnail( 'permalink', array('class' => 'permalinkimage')); } ?>

                        	<?php if ($photographer) { ?><p class="photocredit">Photo Credit: <?php echo $photographer; ?></p><?php } ?>
                      		<?php if ($caption) { ?><p class="photocaption"><?php echo $caption; ?></p><?php } ?>

                        <?php } ?>
                        


                   </div>


                    <p><?php snowriter(); ?><?php the_time('F j, Y'); ?>  <?php edit_post_link('(Edit)', '', ''); ?> <br /> Filed under <?php the_category(', ') ?></p>

            <?php the_content(__('Read more'));?><div style="clear:both;"></div>

                        <?php $related = get_post_meta($post->ID, related, true); if ($related != "No") { ?>
                             <div style="clear:both;margin-bottom:15px;"></div>						
                             			<div class="widgetwrap"><div class="titlewrap610"><h2>Related Content</h2></div>

                             <div id="permalinksidebar">
                                  <?php if (function_exists('ddop_show_posts') ) { echo ddop_show_posts(); } ?>
                                  <h3>Other stories that might interest you...</h3>
                                  <?php if ( function_exists('similar_posts')) { similar_posts (); } ?>

                             </div><div class="widgetfooter"></div></div>
                        <?php } ?>   

            <div class="postmeta">
                <?php the_tags('<p><span class="tags">Tags: ', ', ', '</span></p>'); ?> 
            </div>
  

           <?php endwhile; else: ?>
           
           <p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
           
       </div>

   		<div style="clear:both;"></div>
   		
   		<?php if (get_theme_mod('comments')=="Enable") { ?>
   		
           <div class="widgetwrap"><div class="titlewrap610"><h2>Comments</h2></div>
       <div class="widgetbody">
			<?php $commentspolicy = get_theme_mod('comments-policy'); if ($commentspolicy) echo '<p>'.$commentspolicy.'</p>'; ?>

           	<?php comments_template(); // Get wp-comments.php template ?>
           
       </div><div class="widgetfooter"></div></div>
       
       <?php } ?>
       
   </div>



   
<?php include(TEMPLATEPATH."/sidebar.php");?>
       


</div>

<!-- The main column ends  -->

<?php }} ?><!--end of else from sports schedule check and staff check at top-->

<?php get_footer(); ?>