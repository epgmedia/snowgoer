<?php
/*
Template Name: showcases-showcase
*/
?>
<?php get_header(); get_sidebar(); ?>

<div id="content">

	<div id="contentleft">
	
		<div class="postarea">
	
<div class="breadcrumb">
<a href="http://www.snowgoer.com/" title="Go to Home.">Home</a>
&gt;
<a href="" title="Reload the current page.">Showcases</a>
</div>
			


<h1> Showcases</h1>

<p>It's like a showcase showcase, woah.</p>
            
            
 
<?php //start widgetized-page code  ?>
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("showcases") ) : ?>
<?php endif; ?>
<?php //end widgetized-page code  ?>           
            
            
            
            
            
				<?php edit_post_link('(Edit This Page)', '<p>', '</p>'); ?>
		

			

						
		</div>
		
	</div>
	


</div>

<!-- The main column ends  -->

<?php get_footer(); ?>