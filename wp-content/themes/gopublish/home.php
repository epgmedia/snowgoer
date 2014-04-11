<?php get_header(); ?>

<div id="homepage">

<?php if ((get_theme_mod('top-stories-wide')=="Style 2") && (get_theme_mod('top-stories-scrollbox')=="Display")) include(TEMPLATEPATH . "/top-stories-wide.php"); ?>
<?php if ((get_theme_mod('top-stories-wide')=="Style 3") && (get_theme_mod('top-stories-scrollbox')=="Display")) include(TEMPLATEPATH . "/top-stories-wide-text.php"); ?>

<!--start right column-->
	<div id="sidebar" style="<?php if ((get_theme_mod('sno-layout') == "Option 4") || (get_theme_mod('sno-layout') == "Option 5") || (get_theme_mod('sno-layout') == "Option 6")) { ?>float:left;margin-left:10px;margin-right:0px<?php } else { ?>float:right;<?php } ?>">

		<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(5) ) : else : ?>
		<?php endif; ?>

	</div>

<!-- end right column -->

	<div id="hpleft">

<?php if (get_theme_mod('top-stories-scrollbox') == "Display") { ?>
<?php if (get_theme_mod('top-stories-wide') == "Style 1") { ?>

			<?php include(TEMPLATEPATH . "/top-stories-scrollbox.php"); ?>

<?php } ?>		
<?php } ?>
	
		<div class="homepagemaincolumn">
			
		<div id="homepagewide">	
			<?php include(TEMPLATEPATH . "/featured-content.php"); ?>			
			<?php include(TEMPLATEPATH . "/product-showcase.php"); ?>			
			<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(2) ) : else : endif; ?>
		</div>

<?php if ((get_theme_mod('sno-layout') == "Option 3") || (get_theme_mod('sno-layout') == "Option 6")) { ?>

	<div id="homepageleft" style="width:300px;float:left;">	
		<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(3) ) : else : endif; ?>

	</div>
	<div id="homepageright" style="width:300px;float:right;">
		<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(4) ) : else : endif; ?>
	</div>

<?php } ?><!--end option 1-->


<?php if ((get_theme_mod('sno-layout') == "Option 2") || (get_theme_mod('sno-layout') == "Option 5")) { ?>

	<div id="homepageleft" style="float:right">	

		<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(3) ) : else : endif; ?>

	</div>
	<div id="homepageright" style="float:left">
		<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(4) ) : else : endif; ?>
	</div>


<?php } ?><!--end option 2-->
		

		
<?php if ((get_theme_mod('sno-layout') == "Option 1") || (get_theme_mod('sno-layout') == "Option 4")) { ?>

	<div id="homepageleft">	
		<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(3) ) : else : endif; ?>

	</div>
	<div id="homepageright">
		<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(4) ) : else : endif; ?>
	</div>

<?php } ?><!--end option 3-->


	</div><!--end of homepagemaincolumn-->

	</div>  <!--hpleft-->
	
		
</div>  <!--homepage-->

<!-- The main column ends  -->

<?php get_footer(); ?>


