<?php if (get_theme_mod('featured-content')=="Display") { ?>
<div class="productshowcase">
<?php $customcolors = get_theme_mod('featured-colors'); if ($customcolors == "on") {

	echo '<div class="widgetwrap">';

			$instance['title'] = get_theme_mod('featured-title');
			$instance['header-color'] = get_theme_mod('widgetcolor-feature');
			$instance['header-text'] = get_theme_mod('widgetcolor-feature-text');
			$instance['border-thickness'] = get_theme_mod('widget-feature-thickness');
			$instance['widget-border'] = get_theme_mod('widgetborder-feature');
			$instance['widget-background'] = get_theme_mod('widgetbackground-feature');
			$instance['widget-style'] = get_theme_mod('widget-style-feature');

			include(TEMPLATEPATH . "/widgetstyles.php"); 

} else { ?>   		

       <div class="widgetwrap"><div class="titlewrap610"><h2><?php echo get_theme_mod('featured-title'); ?></h2></div>
       <div class="widgetbody">

<?php } ?>

    		<div class="homefeatured">
    			
    			<?php $category = get_theme_mod('featured-cat-1'); $count=0; query_posts('cat=' . $category . '&showposts=1'); if (have_posts()) : while (have_posts()) : the_post(); global $post; $count++; 
    			
    			if (($count==1) && (get_theme_mod('featured-hide-cat-1')=="No")) { ?><a href="<?php echo cat_id_to_slug($category); ?>"><p class="viewall"><?php echo cat_id_to_name($category); ?></p></a><?php  } ?>

				<?php if (has_post_thumbnail()) 
				{ the_post_thumbnail( 'homefeature', array('class' => 'featureimage')); } 
	else 
				{ global $wpdb; $attachment_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_parent = '$post->ID' AND post_status = 'inherit' AND post_type='attachment' ORDER BY post_date DESC LIMIT 1"); 
$attachment = wp_get_attachment_url($attachment_id); if ($attachment) { ?><a href="<?php the_permalink(); ?>"><img src="<?php echo $attachment; ?>" class="featureimage" style="width:180px" /></a><?php } } ?>

				<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><h3 class="homeheadline" style="font-size:14px;line-height:22px;"><?php the_title(); ?></h3></a>
  				<?php $teaser = get_theme_mod('featured-teaser-1'); 
  				if ($teaser) the_content_limit($teaser, "<br /><span class='readmore'>Read More</span>"); ?>

    			<?php endwhile; else: endif; ?>

    		</div>
    		
    		<div class="homefeatured">

    			<?php $category = get_theme_mod('featured-cat-2'); $count=0; query_posts('cat=' . $category . '&showposts=1'); if (have_posts()) : while (have_posts()) : the_post(); global $post; $count++; 
    			
    			if (($count==1) && (get_theme_mod('featured-hide-cat-2')=="No")) { ?><a href="<?php echo cat_id_to_slug($category); ?>"><p class="viewall"><?php echo cat_id_to_name($category); ?></p></a><?php  } ?>

				<?php if (has_post_thumbnail()) 
				{ the_post_thumbnail( 'homefeature', array('class' => 'featureimage')); } 
	else 
				{ global $wpdb; $attachment_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_parent = '$post->ID' AND post_status = 'inherit' AND post_type='attachment' ORDER BY post_date DESC LIMIT 1"); 
$attachment = wp_get_attachment_url($attachment_id); if ($attachment) { ?><a href="<?php the_permalink(); ?>"><img src="<?php echo $attachment; ?>" class="featureimage" style="width:180px" /></a><?php } } ?>

				<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><h3 class="homeheadline" style="font-size:14px;line-height:22px;"><?php the_title(); ?></h3></a>
  				<?php $teaser = get_theme_mod('featured-teaser-2'); 
  				if ($teaser) the_content_limit($teaser, "<br /><span class='readmore'>Read More</span>"); ?>

    			<?php endwhile; else: endif; ?>


    		</div>
    		
    		<div class="homefeaturedright">

    			<?php $category = get_theme_mod('featured-cat-3'); $count=0; query_posts('cat=' . $category . '&showposts=1'); if (have_posts()) : while (have_posts()) : the_post(); global $post; $count++; 
    			
    			if (($count==1) && (get_theme_mod('featured-hide-cat-3')=="No")) { ?><a href="<?php echo cat_id_to_slug($category); ?>"><p class="viewall"><?php echo cat_id_to_name($category); ?></p></a><?php  } ?>

				<?php if (has_post_thumbnail()) 
				{ the_post_thumbnail( 'homefeature', array('class' => 'featureimage')); } 
	else 
				{ global $wpdb; $attachment_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_parent = '$post->ID' AND post_status = 'inherit' AND post_type='attachment' ORDER BY post_date DESC LIMIT 1"); 
$attachment = wp_get_attachment_url($attachment_id); if ($attachment) { ?><a href="<?php the_permalink(); ?>"><img src="<?php echo $attachment; ?>" class="featureimage" style="width:180px" /></a><?php } } ?>

				<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><h3 class="homeheadline" style="font-size:14px;line-height:22px;"><?php the_title(); ?></h3></a>
  				<?php $teaser = get_theme_mod('featured-teaser-3'); 
  				if ($teaser) the_content_limit($teaser, "<br /><span class='readmore'>Read More</span>"); ?>

    			<?php endwhile; else: endif; ?>


    		</div>

		<div <?php if ($customcolors==on) { ?>style="background-color:<?php echo $instance['header-color']; ?> !important;"<?php } ?>class="widgetfooter<?php if ($instance['widget-style']=="Style 3") { ?>3<?php } else { ?>1<?php } ?>"></div></div>

</div></div>    
                  
<?php } ?>
