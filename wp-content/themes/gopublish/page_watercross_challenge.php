<?php
/*
Template Name: Watercross Challenge
*/

get_header();

?>

<div id="content">


    <div class="postarearacingchallenge">

        <?php
        //start widgetized-page code

        if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("racing-challenge-ads") ) :

        endif;

        //end widgetized-page code
        ?>

    </div>

    <div class="postarearacingchallenge">

        <div>

            <p style="font-size:16px">
                Welcome to <em>Snow Goer</em> magazine's fantasy Watercross Racing
                Challenge, where snowmobilers and snowmobile racing fans gain points
                and can win prizes based on predicting the finishing order in select
                snowmobile races. It's easy, fun and free,ì and you can earn some swag
                and bragging rights.
            </p>

        </div>

        <div style="float: left; width: 495px;">

            <hr />

            <h3>The Rules:</h3>

            <p>
                The six-round Watercross challenge will follow the Pro Open ovals class on the International Watercross Association tour. In each event, players will select the finishing order of the top five racers in that class for the Sunday afternoon final. Picks each week will be due at 10 a.m. central time on the Saturday of the event.
            </p>

            <p>
                If a player correctly selects the position of a racer (whether correctly
                selecting a given racer to finish first, third or sixth, for example)
                he or she will gain 20 points for that selection. If a racer finishes
                close to the predicted finishing position, the player will earn a varying
                amount of points based on this formula:
            </p>

            <ul>
                <li>Driver in correct position = 20 points</li>
                <li>Driver finishes 1 position off of the prediction = 15 points</li>
                <li>Driver finishes 2 positions off = 14 points</li>
                <li>Driver finishes 3 positions off = 13 points</li>
                <li>Driver finishes 4 positions off = 12 points </li>
                <li>Driver finishes 5 positions off = 11 points</li>
                <li>Driver finishes 6 or more positions off = 0 points</li>
            </ul>

            <p>
                Players only receive points for racers who finish in the Top 6 at the
                event, and once a player‚ picks for a given round are made, they are
                final; the player cannot go back in and change them.
            </p>

            <hr />

        </div>

        <div class="racingchallengeraces" style="float: right; width: 400px;">

            <h3>Race Schedule:</h3>

            <p>
                Here are the planned races.
            </p>

           
          <ul>
                <li>Moose Lake, MN, June 7-8</li>
<li>Brainerd, MN, June 14-15</li>
<li>Grantsburg, WI, July 18-20</li>
<li>Ely, MN, August 9-10</li>
<li>Superior, WI, August 16-17</li>
<li>Brainerd, MN September 20-21</li>
            </ul>

        </div>

        <div style="clear: both">

            <p>
                <i>Snow Goer</i> will recognize weekly winners as well as champions
                for the six races combined, the races combined and an overall high 
	     points season champion. These people will get a small prize package, 
                as will winners of select individual rounds.            </p>

            <p align="left">
                <strong>PLEASE NOTE: When you sign up each week to make your predictions,
                always make sure to use the same sign-in name and email address so your
                points can be added to your season total.</strong>
            </p>

        </div>

    </div>

	<div id="contentleft" style="overflow:hidden;">
	
		<div class="postarea">

            <?php
            if (have_posts()) : while (have_posts()) : the_post();

                edit_post_link('(Edit This Page)', '<p>', '</p>');

                the_content(__('[Read more]'));

                endwhile;

            else: ?>

                <p>
                    <?php _e('Sorry, no posts matched your criteria.'); ?>
                </p>

            <?php endif; ?>
									
		</div>
		
	</div>
	
    <?php include(TEMPLATEPATH."/racing-sidebar.php");?>

</div>

<!-- The main column ends  -->

<?php get_footer(); ?>