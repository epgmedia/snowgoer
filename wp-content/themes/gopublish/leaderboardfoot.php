<div style="clear:both;"></div>
<div id="leaderboardfooter">
	<?php if (get_theme_mod('leaderad-type-footer')=="Static Image") { 
		 $leaderurl=get_theme_mod('leader-url-footer'); $leaderimage=get_theme_mod('leader-image-footer'); 
		 if ($leaderurl) echo '<a target="_blank" href="'.$leaderurl.'">'; if ($leaderimage) echo '<img src="'.$leaderimage.'" class="leaderimage" />'; if ($leaderurl) echo '</a>'; 
	 } else if (get_theme_mod('leaderad-type-footer')=="Ad Tag") { 		
		 echo get_theme_mod('openx-code-footer'); 
	 } ?>
</div>

