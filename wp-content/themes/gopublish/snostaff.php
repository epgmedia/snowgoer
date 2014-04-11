<?php
/*
Template Name: SNO Staff
*/
?>
<?php get_header(); ?>

<!--set season variable to limit following queries to current year-->	
<?php $currentyear = date("Y"); $currentmonth = date("m");  if ($currentmonth >= 7) {$spring = $currentyear +1; $seasoncheck = "$currentyear" . "-" . "$spring"; } else {$fall = $currentyear - 1; $seasoncheck = "$fall" . "-" . "$currentyear";} ?>

<div id="content">

	<div id="contentleft">
	
		<div class="postarea">
	
		<?php include(TEMPLATEPATH."/breadcrumb.php");?>
			
<?php
 $querystr = "
SELECT * FROM $wpdb->posts
JOIN $wpdb->postmeta AS schoolyear ON(
$wpdb->posts.ID = schoolyear.post_id
AND schoolyear.meta_key = 'schoolyear'
AND schoolyear.meta_value != ''
)
JOIN $wpdb->postmeta AS name ON(
$wpdb->posts.ID = name.post_id
AND name.meta_key = 'name'
)
AND $wpdb->posts.post_status = 'publish'
ORDER BY post_date DESC
";

 $pageposts = $wpdb->get_results($querystr, OBJECT);

?>
 <?php if ($pageposts): ?>
  <?php foreach ($pageposts as $post): ?>
    <?php setup_postdata($post); ?>

<?php $namekey=0; $schoolyear = get_post_meta($post->ID, schoolyear, true); if (is_array($schoolyear)) { if(in_array($seasoncheck, $schoolyear)) $namekey=5; } if ($seasoncheck==$schoolyear) $namekey=5; if ($namekey==5) { ?>


<?php $feature_photo = get_post_meta($post->ID, feature_photo, true); if (has_post_thumbnail()) 
			{ the_post_thumbnail( 'archive', array('class' => 'categoryimage')); global $post; } 
	else if ($feature_photo) { ?><a href="<?php the_permalink(); ?>"><img src="<?php echo $feature_photo; ?>" class="categoryimage" style="width:200px" /></a><?php } 
	else 
			{ global $wpdb; $attachment_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_parent = '$post->ID' AND post_status = 'inherit' AND post_type='attachment' ORDER BY post_date DESC LIMIT 1"); 
$attachment = wp_get_attachment_url($attachment_id); if ($attachment) { ?><a href="<?php the_permalink(); ?>"><img src="<?php echo $attachment; ?>" class="categoryimage" style="width:200px" /></a><?php } } ?>

		<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

		<?php the_content();?><?php edit_post_link('(Edit)', '', ''); ?>
		

                <?php $name = get_post_meta($post->ID, name, true); ?><h3 style="margin-top:15px;margin-bottom:30px"><a href="<?php the_permalink(); ?>">Read all stories written by <?php echo $name; ?></a></h3>


                <div style="clear:both"></div>

			<div class="postmeta2" style="padding-bottom:20px">

			</div>
			

<?php } ?>

  <?php endforeach; ?>  
  <?php else : ?>
 <?php endif; ?>

		
		</div>
		
	</div>
	
<?php include(TEMPLATEPATH."/sidebar.php");?>
		
</div>

<!-- The main column ends  -->

<?php get_footer(); ?>