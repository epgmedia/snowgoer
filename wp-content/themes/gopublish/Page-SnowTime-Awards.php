<?php
/*
Template Name: SnowTime Awards
*/

get_header();

?>

<div id="content">

    <img src="http://www.snowgoer.com/wp-content/uploads/2013/03/top-graphic-mockup1.jpg" width="960">

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
                Welcome to the 2013 <em>Snow Goer</em> SnowTime Tourism Awards. It asks
                regular riders like yourself to pick the best of the best when it comes
                to snowmobiling and snowmobile riding.
            </p>

        </div>

        <div style="float: left; width: 495px;">

            <hr />

            <h3>Round 1</h3>

            <p>
                In round one, we asked readers and viewers to name the Best Trail Riding
                Destination and the Best Trailside Pitstop. You can still vote in those
                categories by clicking <a href="#week1">HERE</a>.
            </p>

            <p>
                In Round 2, we wanted participants to name their Dream Snowmobiling
                Destination, and the Best Hotel or Resort Catering To Snowmobilers.
                You can still vote in those categories by clicking <a href="#week2">HERE</a>.
            </p>

            <p>
                And remember, we’ll randomly select one name to win a $25 gift certificate
                from sponsor Hi Performance Engineering, which helps make the SnowTime
                Awards possible.
            </p>

            <br />

            <hr />

        </div>

        <div class="racingchallengeraces" style="float: right; width: 400px;">

            <h3>Previous Winners or Prize/Sponsor Information</h3>

            <p>
                Take a look at last year's winners!
            </p>

            <ul>
                <li>Category 1<br />&nbsp;Winner1</li>
                <li>Category 1<br />&nbsp;Winner1</li>
                <li>Category 1<br />&nbsp;Winner1</li>
                <li>Category 1<br />&nbsp;Winner1</li>
                <li>Category 1<br />&nbsp;Winner1</li>
                <li>Category 1<br />&nbsp;Winner1</li>
                <li>Category 1<br />&nbsp;Winner1</li>
            </ul>

        </div>

        <div style="clear: both">

            <p>
                <i>Snow Goer</i> will recognize weekly winners as well as champions for
                the seven snocross races combined, the four oval/enduro races combined
                and an overall high points season champion. These people will get a small
                prize package, as will winners of select individual rounds, including the
                Duluth Snocross opener, both I-500 races (cross-country and enduro) and the
                Eagle River World Championship.
            </p>

            <p align="left">
                <strong>PLEASE NOTE: When you sign up each week to make your predictions,
                always make sure to use the same sign-in name and email address so your points
                can be added to your season total.</strong>
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