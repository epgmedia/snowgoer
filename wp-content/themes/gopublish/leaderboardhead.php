<?php if (get_theme_mod('display-leader')=="Yes") { ?>

	<div id="leaderboard">
	
	<div style="float: left;">
		<?php
		if ( get_theme_mod('leaderad-type') == "Static Image") {
	
		    $leaderurl = get_theme_mod('leader-url');
			$leaderimage = get_theme_mod('leader-image');
		 if ($leaderurl) echo '<a target="_blank" href="'.$leaderurl.'">'; if ($leaderimage) echo '<img src="'.$leaderimage.'" class="leaderimage" />'; if ($leaderurl) echo '</a>'; 

	 } else if (get_theme_mod('leaderad-type')=="Ad Tag") { 		
	
		 echo get_theme_mod('openx-code'); 
	
	 } ?></div>

	<div id="leaderboardright">

		<!-- SNG_ROS_HeaderButton -->
		<div id='div-gpt-ad-1423865222092-0' style='width:220px; height:90px;'>
			<script type='text/javascript'>
				googletag.cmd.push(function() { googletag.display('div-gpt-ad-1423865222092-0'); });
			</script>
		</div>

	</div>

	</div>



<?php } ?>