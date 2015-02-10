<?php
/*
Template Name: racing-challenge
*/

get_header();

?>

<div id="content">

    <img src="http://www.snowgoer.com/wp-content/uploads/2014/11/racing-challenge-Top-Graphic-2015.jpg" style="width:100%; margin: auto;">

    <div class="postarearacingchallenge">

        <?php
        if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("racing-challenge-ads") ) :
        endif;
        ?>

    </div>

    <div class="postarearacingchallenge">

        <div>

            <p style="font-size:16px;">
                Welcome to <em>Snow Goer</em> magazine’s fantasy Snowmobile Racing
                Challenge, where snowmobilers and snowmobile racing fans gain points
                and can win prizes based on predicting the finishing order in select
                snowmobile races.
            </p>

            <p style="font-size:16px;">
                It’s easy, fun and free – and you can earn some swag and bragging rights.
            </p>

        </div>

        <div style="float: left; width: 495px;">

            <hr />
            <h3>The Rules:</h3>
            <p>
	            The <em>Snow Goer</em> Snowmobile Racing Challenge game presented by Amsoil is
	            back for the 2014-15 racing season. It’s easy to understand, easy to play and
	            it is free – the only thing it costs you is a few minutes to make your
	            predictions, and you can win prizes and bragging rights.
            </p>
	        <p>
		        The game will again have several different rounds of competition, based on
		        various forms of snowmobile racing – Snocross, Cross-Country and Ovals.
		        Separate points will be kept in each form of racing, and there will be a
		        champion for each – play one, or play them all. New presenting sponsor Amsoil
		        is promising prizes for segment winners, to include Amsoil Interceptor oil
		        and Amsoil swap.
	        </p>
			<p>
	            For each race, players will select the top six finishing order, based on a
	            pull-down window that lists the names of the racers who race in that are
	            expected to compete in the chosen race. Players will select a winner as well
	            as each of the next five finishing positions.
			</p>
	        <p>
	            If a player correctly selects the position of a racer (whether correctly
	            selecting a given racer to finish first, third or sixth, for example) he or
	            she will gain 20 points for that selection. If a racer finishes close to the
	            predicted finishing position, the player will earn a varying amount of points
	            based on this formula:
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
	            Players only receive points for racers who finish in the Top 6 at the event,
	            and once a player’s picks for a given round are made, they are final; the
	            player cannot go back in and change them.
            </p>
            <hr />

        </div>

        <div class="racingchallengeraces" style="float: right; width: 400px;">

            <h3>Race Schedule:</h3>
            <p>
                Here are the planned races.
            </p>
            <p>
                For snocross, the focus will be the Pro Open class.
            </p>
            <p>
                For oval races, it will be Pro Champ 440.
            </p>
            <h4>Snocross</h4>
            <ul>
                <li>Nov. 30, Duluth, Minnesota</li>
	            <li>Dec. 13, Fargo, North Dakota</li>
	            <li>Jan. 10, Shakopee, Minnesota</li>
	            <li>Jan. 23, X Games Aspen</li>
	            <li>Jan. 31, Deadwood, South Dakota</li>
	            <li>Feb. 7, Salamanca, New York</li>
	            <li>Feb. 21, Chicago, Illinois</li>
	            <li>Feb. 28, Mt. Pleasant, Michigan</li>
	            <li>March 15, Lake Geneva, Wisconsin</li>
            </ul>
            <h4>Ovals</h4>
            <ul>
                <li>Jan. 18, Eagle River, Wisconsin</li>
                <li>Jan. 25, Wausau, Wisconsin</li>
                <li>Jan. 31, Alexandria, Minnesota</li>
                <li>Feb. 8, Francis Creek, Wisconsin</li>
                <li>Feb. 15, Weyauwega, Wisconsin</li>
            </ul>
            <h4>Cross-Country</h4>
            <ul>
                <li>Jan. 17, Grafton, ND</li>
                <li>Feb. 1, Park Rapids, MN</li>
                <li>Feb. 11, I-500 Winnipeg to Willmar</li>
                <li>Feb. 28, Thief River Falls, MN</li>
                <li>March 7, Warroad, MN</li>
            </ul>

        </div>

	    <div style="width:410px;float:right;">
		    <img src="http://www.snowgoer.com/wp-content/uploads/2014/11/SG-LOGO-e1416970489982.jpg" width="410" style="margin:auto;display:block;" />
		    <img src="http://www.snowgoer.com/wp-content/uploads/2014/11/AMSOIL_RGB_wTag-e1416970477302.jpg" width="410" style="margin:auto;display:block;" />
	    </div>

        <div style="clear: both">

            <p>
	            <em>Snow Goer</em> will recognize weekly winners as well as champions for the
				nine snocross races combined, the various oval/enduro races combined and an
				overall high points season champion. There will be occasional prize packages
				available during the season, depending on program sponsorship.
            </p>

            <p>
                <strong>PLEASE NOTE: When you sign up each week to make your predictions,
                        always make sure to use the same sign-in name and email address so
                        your points can be added to your season total.</strong>
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