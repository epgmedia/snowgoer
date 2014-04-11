<?php if (get_theme_mod('display-leader')=="Yes") { ?>

	<div id="leaderboard">
	
	<div style="float: left;"><?php if (get_theme_mod('leaderad-type')=="Static Image") { 
	
		 $leaderurl=get_theme_mod('leader-url'); $leaderimage=get_theme_mod('leader-image'); 
		 if ($leaderurl) echo '<a target="_blank" href="'.$leaderurl.'">'; if ($leaderimage) echo '<img src="'.$leaderimage.'" class="leaderimage" />'; if ($leaderurl) echo '</a>'; 

	 } else if (get_theme_mod('leaderad-type')=="Ad Tag") { 		
	
		 echo get_theme_mod('openx-code'); 
	
	 } ?></div>

	<div id="leaderboardright">


<?php $leaderurlsmall=get_theme_mod('leader-url-small'); $leaderimagesmall=get_theme_mod('leader-image-small'); 
		 if ($leaderurlsmall) echo '<a target="_blank" href="'.$leaderurlsmall.'">'; if ($leaderimagesmall) echo '<img src="'.$leaderimagesmall.'" class="leaderimageright" />'; if ($leaderurlsmall) echo '</a>'; ?>



	</div>

	</div>



<?php } ?>