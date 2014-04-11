<?php
/*
Template Name: Full Width
*/
?>
<?php get_header(); ?>

<div id="content">

	<div id="contentleft" style="width:940px">
	
		<div class="postarea" style="width:920px">
				
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php $title=get_post_meta($post->ID, title, true); if (!$title) { ?><h1><?php the_title(); ?></h1><?php } ?>
				<?php edit_post_link('(Edit This Page)', '<p>', '</p>'); ?>
		
			<?php the_content(__('[Read more]'));?>
		 			
			<?php endwhile; else: ?>
			
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
						
		</div>
		
	</div>
	
</div>

<!-- The main column ends  -->

<?php get_footer(); ?>