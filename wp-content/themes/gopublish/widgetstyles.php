<!--style choices for customized widget headers and backgrounds-->

<?php if ($instance['widget-style']=="Style 1") { ?>

	<h4 class="widget1" <?php if ($customcolors==on) { ?>style="
		background-color:<?php echo $instance['header-color']; ?> !important; 
		color:<?php echo $instance['header-text']; ?> !important; 
		border-left:<?php echo $instance['border-thickness']; ?> solid <?php echo $instance['widget-border']; ?> !important; 
		border-right:<?php echo $instance['border-thickness']; ?> solid <?php echo $instance['widget-border']; ?> !important; 
		border-top:<?php echo $instance['border-thickness']; ?> solid <?php echo $instance['widget-border']; ?> !important; 
	"<?php } ?>>
		<?php if ($categoryslug) { ?>
		<a <?php if ($customcolors==on) { ?>style="color: <?php echo $instance['header-text']; ?> !important;"<?php } ?> href="<?php echo $categoryslug; ?>">
		<?php if ($videotitle) { echo $videotitle; } else { echo $categoryname; } ?>
		</a>
		<?php } else { 
		echo $instance['title'];
		} ?>
	</h4> 
	<div class="widgetbody1" style="
	<?php if ($instance['remove-padding']==on) { ?>
		padding:0px !important;
	<?php } ?>
	<?php if ($customcolors==on) { ?>
		background-color:<?php echo $instance['widget-background']; ?> !important; 
		border-right:<?php echo $instance['border-thickness']; ?> solid <?php echo $instance['widget-border']; ?> !important; 
		border-left:<?php echo $instance['border-thickness']; ?> solid <?php echo $instance['widget-border']; ?> !important; 
		border-bottom:<?php echo $instance['border-thickness']; ?> solid <?php echo $instance['widget-border']; ?> !important;
	<?php } ?>">

<?php } else if ($instance['widget-style']=="Style 2") { ?>

	<h4 class="widget2" <?php if ($customcolors==on) { ?>style="
		background-color: <?php echo $instance['header-color']; ?> !important; 
		color: <?php echo $instance['header-text']; ?> !important;
	"<?php } ?>>
		<?php if ($categoryslug) { ?>
		<a <?php if ($customcolors==on) { ?>style="color: <?php echo $instance['header-text']; ?> !important;"<?php } ?> href="<?php echo $categoryslug; ?>">
		<?php if ($videotitle) { echo $videotitle; } else { echo $categoryname; } ?>
		</a>
		<?php } else { 
		echo $instance['title'];
		} ?>
	</h4> 
	<div class="widgetbody2" style="
	<?php if ($instance['remove-padding']==on) { ?>
		padding:0px !important;
	<?php } ?>	
	<?php if ($customcolors==on) { ?>
		background-color:<?php echo $instance['widget-background']; ?> !important; 
		border-bottom:<?php echo $instance['border-thickness']; ?> solid <?php echo $instance['widget-border']; ?> !important;
		border-left:<?php echo $instance['border-thickness']; ?> solid <?php echo $instance['widget-border']; ?> !important;
		border-right:<?php echo $instance['border-thickness']; ?> solid <?php echo $instance['widget-border']; ?> !important;
	<?php } ?>">

<?php } else if ($instance['widget-style']=="Style 3") { ?>

	<h4 <?php if ($customcolors==on) { ?>style="
		background-color:<?php echo $instance['header-color']; ?> !important; 
		color:<?php echo $instance['header-text']; ?> !important;
	"<?php } ?> class="widget3">
		<?php if ($categoryslug) { ?>
		<a <?php if ($customcolors==on) { ?>style="color: <?php echo $instance['header-text']; ?> !important;"<?php } ?> href="<?php echo $categoryslug; ?>">
		<?php if ($videotitle) { echo $videotitle; } else { echo $categoryname; } ?>
		</a>
		<?php } else { 
		echo $instance['title'];
		} ?>
	</h4>
	<div class="widgetbody3" style="
	<?php if ($instance['remove-padding']==on) { ?>
		padding:0px !important;
	<?php } ?>	
	<?php if ($customcolors==on) { ?> 
		background-color:<?php echo $instance['widget-background']; ?> !important; 
		border-right:<?php echo $instance['border-thickness']; ?> solid <?php echo $instance['widget-border']; ?> !important; 
		border-left:<?php echo $instance['border-thickness']; ?> solid <?php echo $instance['widget-border']; ?> !important;
	<?php } ?>">

<?php } else if ($instance['widget-style']=="Style 4") { 

 	if (($instance['sidebarname']=="Home Bottom Left") || ($instance['sidebarname']=="Home Bottom Right")) 
		{ $wrap="homecolumntop.gif"; $wrapwidth="280px"; } 
	else if (($instance['sidebarname']=="Home Sidebar") || ($instance['sidebarname']=="Non-Home Sidebar") || ($instance['sidebarname']=="Sports Center Sidebar") )
		{ $wrap="sidebartop.gif"; $wrapwidth="300px";  }
	else if ($instance['sidebarname']=="Home Wide Column")
		{ $wrap="featuredtop420.gif"; $wrapwidth="400px"; }
	else if ($instance['sidebarname']=="Home Narrow Column")
		{ $wrap="featuredtop176.gif"; $wrapwidth="160px"; }
	else if ($instance['sidebarname']=="Home Full Width")
		{ $wrap="homepagetop.gif"; $wrapwidth="590px"; }
	else
		{ $wrap="homepagetop.gif"; $wrapwidth="590px"; } ?>
		
	<div style="
		background: #ffffff url(<?php bloginfo('template_url'); ?>/images/<?php echo $wrap; ?>) top no-repeat; 
		float: left; 
		width: <?php echo $wrapwidth; ?>;
		margin: 0px 0px 0px 0px; 
		padding: 10px 9px 0px 9px;  
		overflow: hidden; 
	<?php if ($customcolors==on) { ?> 
		border-left:1px solid <?php echo $instance['widget-border']; ?>; 
		border-right:1px solid <?php echo $instance['widget-border']; ?>; 
		border-top:1px solid <?php echo $instance['widget-border']; ?>;
	<?php } else { ?> 
		border-left: 1px solid <?php echo get_theme_mod('widgetborder4'); ?>; 
		border-right: 1px solid <?php echo get_theme_mod('widgetborder4'); ?>; 
		border-top: 1px solid <?php echo get_theme_mod('widgetborder4'); ?>; 
	<?php } ?>
	">
		<h4 class="widget4" <?php if ($customcolors==on) { ?>style="background-color: <?php echo $instance['header-color']; ?> !important; color: <?php echo $instance['header-text']; ?> !important;"<?php } ?>>
			<?php if ($categoryslug) { ?>
			<a <?php if ($customcolors==on) { ?>style="color: <?php echo $instance['header-text']; ?> !important;"<?php } ?> href="<?php echo $categoryslug; ?>"><?php if ($videotitle) { echo $videotitle; } else { echo $categoryname; } ?>

			</a>
			<?php } else { echo $instance['title']; } ?>
		</h4>
	</div> 
	<div class="widgetbody4" style="
	<?php if ($instance['remove-padding']==on) { ?>
		padding:0px !important;
	<?php } ?>	
	<?php if ($customcolors==on) { ?> 
		background-color:#ffffff !important; 
		border-right:1px solid <?php echo $instance['widget-border']; ?> !important; 
		border-left:1px solid <?php echo $instance['widget-border']; ?> !important; 
		border-bottom:1px solid <?php echo $instance['widget-border']; ?> !important;
	<?php } else { ?> 
		border-left: 1px solid <?php echo get_theme_mod('widgetborder4'); ?>; 
		border-right: 1px solid <?php echo get_theme_mod('widgetborder4'); ?>; 
		border-bottom: 1px solid <?php echo get_theme_mod('widgetborder4'); ?>; 
	<?php } ?>">

<?php } else if ($instance['widget-style']=="Style 5") { ?>

	<h4 class="widget5" <?php if ($customcolors==on) { ?>style="
		background-color: <?php echo $instance['widget-background']; ?> !important; 
		color: <?php echo $instance['header-text']; ?> !important; 
		border-top: 10px solid <?php echo $instance['header-color']; ?> !important; 
	"<?php } ?>>
		<?php if ($categoryslug) { ?>
		<a <?php if ($customcolors==on) { ?>style="color: <?php echo $instance['header-text']; ?> !important;"<?php } ?> href="<?php echo $categoryslug; ?>">
		<?php if ($videotitle) { echo $videotitle; } else { echo $categoryname; } ?>
		</a>
		<?php } else { 
		echo $instance['title'];
		} ?>
	</h4> 
	<div class="widgetbody5" style="
	<?php if ($instance['remove-padding']==on) { ?>
		padding:0px !important;
	<?php } ?>	
	<?php if ($customcolors==on) { ?> 
		background-color:<?php echo $instance['widget-background']; ?> !important; 
		border-bottom:<?php echo $instance['border-thickness']; ?> solid <?php echo $instance['widget-border']; ?> !important;
	<?php } ?>">

<?php } else if ($instance['widget-style']=="Style 6") { ?>

	<h4 class="widget6" <?php if ($customcolors==on) { ?>style="
		border:<?php echo $instance['border-thickness']; ?> solid <?php echo $instance['widget-border']; ?> !important;
		background-color: <?php echo $instance['header-color']; ?> !important; 
		color: <?php echo $instance['header-text']; ?> !important;
	"<?php } ?>>
		<?php if ($categoryslug) { ?>
		<a <?php if ($customcolors==on) { ?>style="color: <?php echo $instance['header-text']; ?> !important;"<?php } ?> href="<?php echo $categoryslug; ?>">
		<?php if ($videotitle) { echo $videotitle; } else { echo $categoryname; } ?>
		</a>
		<?php } else { 
		echo $instance['title'];
		} ?>
	</h4> 
	<div class="widgetbody6" style="
	<?php if ($instance['remove-padding']==on) { ?>
		padding:0px !important;
	<?php } ?>	
	<?php if ($customcolors==on) { ?> 
		background-color:<?php echo $instance['widget-background']; ?> !important; 
		border-right:<?php echo $instance['border-thickness']; ?> solid <?php echo $instance['widget-border']; ?> !important; 
		border-left:<?php echo $instance['border-thickness']; ?> solid <?php echo $instance['widget-border']; ?> !important; 
		border-bottom:<?php echo $instance['border-thickness']; ?> solid <?php echo $instance['widget-border']; ?> !important;
	<?php } ?>">

<?php } else if ($instance['widget-style']=="Style 7") { ?>

	<h4 class="widget7" <?php if ($customcolors==on) { ?>style="
		background-color: <?php echo $instance['header-color']; ?> !important; 
		color: <?php echo $instance['header-text']; ?> !important; 
		border-bottom: <?php echo $instance['border-thickness']; ?> solid <?php echo $instance['widget-border']; ?> !important;
	"<?php } ?>>
		<?php if ($categoryslug) { ?>
		<a <?php if ($customcolors==on) { ?>style="color: <?php echo $instance['header-text']; ?> !important;"<?php } ?> href="<?php echo $categoryslug; ?>">
		<?php if ($videotitle) { echo $videotitle; } else { echo $categoryname; } ?>
		</a>
		<?php } else { 
		echo $instance['title'];
		} ?>
	</h4> 
	<div class="widgetbody7" style="
	<?php if ($instance['remove-padding']==on) { ?>
		padding:0px !important;
	<?php } ?>	
	<?php if ($customcolors==on) { ?> 
		background-color:<?php echo $instance['widget-background']; ?> !important;
		border:none!important;
	<?php } ?>">

<?php } ?>