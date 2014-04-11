<?php
/*
Template Name: X-Country racing-challenge
*/

get_header();

?>

<div id="content">

    <img src="http://www.snowgoer.com/wp-content/uploads/2012/10/Top-Graphic-2014.jpg">

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
                Welcome to <em>Snow Goer</em> magazine's fantasy Snowmobile Racing
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
                There will be three different series in the 2013-14 <i>Snow Goer</i>
                Snowmobile Racing Challenge: One 9-round series dedicated to the Pro
                Open class on national snocross racing scene (8 ISOC races plus the X
                Games Aspen) and one five-series dedicated to Upper Midwestern Oval
                Sprint Racing in the Champ 440 class and one four-round series
                dedicated to cross-country racing in the pro 660 class.
            </p>

            <p>
                For each race, players will select the top six finishing order, based
                on a pull-down window that lists the names of the racers who race in
                that are expected to compete in the chosen race. Players will select
                a winner as well as each of the next five finishing positions.
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
                event, and once a player‚Äôs picks for a given round are made, they are
                final; the player cannot go back in and change them.
            </p>

            <hr />

        </div>

        <div class="racingchallengeraces" style="float: right; width: 400px;">

            <h3>Race Schedule:</h3>

            <p>
                Here are the planned races.
            </p>

            <p>
                For cross country, the focus will be the Pro 660 class.
            </p>

            <h4>Cross Country</h4>

            <ul>
                <li> Dec. 15, Pine Lake, Minnesota</li>
                <li>Jan. 18, Willmar, Minnesota</li>
                <li>Feb. 6-8, Thief River Falls, Minnesota</li>
                <li>March 8, Walker, Minnesota</li>
            </ul>

        </div>

        <div style="clear: both">

            <p>
                <i>Snow Goer</i> will recognize weekly winners as well as champions
                for the seven snocross races combined, the four oval/enduro races
                combined and an overall high points season champion. These people will
                get a small prize package, as will winners of select individual rounds,
                including the Duluth Snocross opener, both I-500 races (cross-country
                and enduro) and the Eagle River World Championship.
            </p>

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