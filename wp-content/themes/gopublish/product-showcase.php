<?php if (get_theme_mod('product-content')=="Display") { ?>				
<div class="productshowcase">
<?php $customcolors = get_theme_mod('product-colors'); if ($customcolors == "on") {

	echo '<div class="widgetwrap">';

			$instance['title'] = get_theme_mod('product-title');
			$instance['header-color'] = get_theme_mod('widgetcolor-product');
			$instance['header-text'] = get_theme_mod('widgetcolor-product-text');
			$instance['border-thickness'] = get_theme_mod('widget-product-thickness');
			$instance['widget-border'] = get_theme_mod('widgetborder-product');
			$instance['widget-background'] = get_theme_mod('widgetbackground-product');
			$instance['widget-style'] = get_theme_mod('widget-style-product');

			include(TEMPLATEPATH . "/widgetstyles.php"); 

} else { ?>   		

       <div class="widgetwrap"><div class="titlewrap610"><h2><?php echo get_theme_mod('product-title'); ?></h2></div>
       <div class="widgetbody">

<?php } ?>

    		<div class="homefeatured">

				<script type="text/javascript">
					$(function() {
					$(".newsticker-jcarouselliteps1").jCarouselLite({
        					visible: 1,
        					auto: 4000,
        					speed: 666,
							btnNext: ".nextps1",
							btnPrev: ".prevps1"
						    });
					});

				</script>
    			
    			<?php $count = 0; $category = get_theme_mod('product-cat-1'); $productcount = get_theme_mod('product-count-1'); query_posts('cat=' . $category . '&showposts='. $productcount); if (have_posts()) : while (have_posts()) : the_post(); global $post; $count++; 
    			



					if ($count==1) { $exitkey=6; ?>

    									<div id="newsticker-demops1" style="width:160px">    
        								<div class="newsticker-jcarouselliteps1" style="width:160px">
        								<ul>
								<?php } ?>
                							<li>
                							<div class="sportsscore" style="width:160px">

								<?php if (has_post_thumbnail()) 
									{ the_post_thumbnail( 'homefeature', array('class' => 'featureimage'));} ?>
								<?php $link = get_post_meta($post->ID, 'customlink', true); $click = get_post_meta($post->ID, 'click_tracker_code', true); ?>
                    							<p class="homeheadline"><?php if ($link) echo '<a target="_blank" href="' . $link . $click .'">'; the_title(); if ($link) echo '</a>'; ?></p>
  												<div class="productteaser"><p><?php the_content_limit(50, ''); ?></p></div>

                    						</div>
                							<div class="clear"></div>
            								</li>

					<?php endwhile; else: endif; ?>

					<?php if ($exitkey==6) { $exitkey=0; ?>
								</ul>
									<button class="prevps1 leftarrow"></button>
									<button class="nextps1 rightarrow"></button>
    							</div>
    							</div>

    				<?php } ?>


    		</div>
    		
    		<div class="homefeatured">

				<script type="text/javascript">
					$(function() {
					$(".newsticker-jcarouselliteps2").jCarouselLite({
        					visible: 1,
        					auto: 4000,
        					speed: 666,
							btnNext: ".nextps2",
							btnPrev: ".prevps2"
						    });
					});

				</script>

    			<?php $count = 0; $category = get_theme_mod('product-cat-2'); $productcount = get_theme_mod('product-count-2'); query_posts('cat=' . $category . '&showposts='. $productcount); if (have_posts()) : while (have_posts()) : the_post(); global $post; $count++; 
    			



					if ($count==1) { $exitkey=6; ?>

    									<div id="newsticker-demops2" style="width:160px">    
        								<div class="newsticker-jcarouselliteps2" style="width:160px">
        								<ul>
								<?php } ?>
                							<li>
                							<div class="sportsscore" style="width:160px">

								<?php if (has_post_thumbnail()) 
									{ the_post_thumbnail( 'homefeature', array('class' => 'featureimage'));} ?>
								<?php $link = get_post_meta($post->ID, 'customlink', true); $click = get_post_meta($post->ID, 'click_tracker_code', true); ?>
                    							<p class="homeheadline"><?php if ($link) echo '<a target="_blank" href="' . $link . $click .'">'; the_title(); if ($link) echo '</a>'; ?></p>
  												<div class="productteaser"><p><?php the_content_limit(50, ''); ?></p></div>

                    						</div>
                							<div class="clear"></div>
            								</li>

					<?php endwhile; else: endif; ?>

					<?php if ($exitkey==6) { $exitkey=0; ?>
								</ul>
									<button class="prevps2 leftarrow"></button>
									<button class="nextps2 rightarrow"></button>
    							</div>
    							</div>

    				<?php } ?>

    		</div>
    		
    		<div class="homefeaturedright">

				<script type="text/javascript">
					$(function() {
					$(".newsticker-jcarouselliteps3").jCarouselLite({
        					visible: 1,
        					auto: 4000,
        					speed: 666,
							btnNext: ".nextps3",
							btnPrev: ".prevps3"
						    });
					});

				</script>

    			<?php $count = 0; $category = get_theme_mod('product-cat-3'); $productcount = get_theme_mod('product-count-3'); query_posts('cat=' . $category . '&showposts='. $productcount); if (have_posts()) : while (have_posts()) : the_post(); global $post; $count++; 
    			



					if ($count==1) { $exitkey=6; ?>

    									<div id="newsticker-demops3" style="width:160px">    
        								<div class="newsticker-jcarouselliteps3" style="width:160px">
        								<ul>
								<?php } ?>
                							<li>
                							<div class="sportsscore" style="width:160px">

								<?php if (has_post_thumbnail()) 
									{ the_post_thumbnail( 'homefeature', array('class' => 'featureimage'));} ?>
								<?php $link = get_post_meta($post->ID, 'customlink', true); $click = get_post_meta($post->ID, 'click_tracker_code', true); ?>
                    							<p class="homeheadline"><?php if ($link) echo '<a target="_blank" href="' . $link . $click .'">'; the_title(); if ($link) echo '</a>'; ?></p>
  												<div class="productteaser"><p><?php the_content_limit(50, ''); ?></p></div>

                    						</div>
                							<div class="clear"></div>
            								</li>

					<?php endwhile; else: endif; ?>

					<?php if ($exitkey==6) { $exitkey=0; ?>
								</ul>
									<button class="prevps3 leftarrow"></button>
									<button class="nextps3 rightarrow"></button>
    							</div>
    							</div>

    				<?php } ?>


    		</div>

		<div <?php if ($customcolors==on) { ?>style="background-color:<?php echo $instance['header-color']; ?> !important;"<?php } ?>class="widgetfooter<?php if ($instance['widget-style']=="Style 3") { ?>3<?php } else { ?>1<?php } ?>"></div></div>

</div></div>
                  
<?php } ?>
