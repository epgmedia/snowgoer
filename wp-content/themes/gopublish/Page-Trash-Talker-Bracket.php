<?php
/*
Template Name: Trash Talker Madness

*/
?>
<?php get_header(); ?>

<div id="content">




<div class="postarearacingchallenge">
<div>
<p style="text-align: center;"><font size="5">Vote in the 2013 Trasher Bracket Championship</font></p><br />
<font size="4"><p>Yep, March Madness is here – who will rise above the rest and enjoy their “One Shining Moment”… as the 2013 Trasher Bracket Champion?<p>
<p>For the first time, <em>Snow Goer</em> is having its own bracket challenge, featuring 64 of the most domineering personalities from the <a href="http://forums.snowgoer.com/Index.cfm/fuseaction/listings/forum/53.cfm">Trash Talkers forum</a>. Much like the NCAA basketball tournament, the field will quickly narrow, and soon the 2013 Trasher Bracket Champion will be named.</p>
<p>Our exclusive and elusive selection committee not only selected the 64 participants, it also seeded and placed them in brackets. The committee’s process and reasoning for those selections and seeds will forever be secret. While the committee’s wisdom is beyond reproach, its judgment is definitely questionable.   </p>
<p>The work of the committee, however, is done. Now it’s up to you. The readers of <em>SnowGoer.com</em> and the folks who either participate or lurk on the message boards will decide which Trashers advance in each round. </p>
</font> <br /></div>
</div>

<div class="postarearacingchallenge">  
<?php //start widgetized-page code  ?>
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("racing-challenge-ads") ) : ?>
<?php endif; ?>
<?php //end widgetized-page code  ?>  
</div>

<div class="postareatrashtalkers">
<table width="940" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><a href="http://www.snowgoer.com/trash-talker-madness-north/"><img src="http://www.snowgoer.com/wp-content/uploads/2013/04/vote-now-float.png" width="920" height="610"></a></td>
    </tr>
 </table>

</div>

<div class="postarearacingchallenge">
<div><font size="4">
<p style="text-align: left;">Here’s how it works:</p>
&nbsp;
<p style="text-align: left;">Select head-to-head matchups between Trashers will be announced on <em>SnowGoer.com</em>.  Look for <font color="red"><b>> Vote Now <</b></font> in red. Anybody who wants to vote can simply select which Trasher they think should advance in each matchup. Each round will go quickly – you’ll generally only have about two days to vote in each competition, so check back often. You can check out each Trasher's recent post by clicking on their name when voting. </p>
&nbsp;
<p style="text-align: left;">When each new set of matchups is posted, the results from the previous rounds will be shown and the brackets will be updated. Aside from a traveling trophy, which we will create, there will be no formal prizes – other than pride. This keeps it legal, simple and fun.</p>
&nbsp;
<p style="text-align: left;">Vote early and often (and as much as you want), and help determine the Trasher Bracket Champion for this year. Also, feel free to click on the individual brackets to see future matchups.</p>
</font> <br /></div>
</div>



</div>




	<div id="contentleft" style="overflow:hidden; width:940px;">
	
		<div class="postarea" style="width:920px;">
	
			
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
				<?php edit_post_link('(Edit This Page)', '<p>', '</p>'); ?>
		
			<?php the_content(__('[Read more]'));?>
		 			
			<?php endwhile; else: ?>
			
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
									
		</div>
		
	</div>
	

</div>

<!-- The main column ends  -->

<?php get_footer(); ?>