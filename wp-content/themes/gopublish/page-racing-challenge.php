<?php
/*
Template Name: snowmobile-racing-challenge
*/

get_header();

get_sidebar();

?>

<div id="content">

    <div id="contentleft">
	
        <div class="postarea">
	
            <div class="breadcrumb">

                <a href="/" title="Go to Home.">Home</a> &gt;
                <a href="" title="Reload the current page.">Snow Goer Racing Challenge</a>

            </div>

            <h1>Snow Goer 2013 Racing Challenge</h1>

            <p>
                It's like a showcase showcase, woah.
            </p>

            <?php
            //start widgetized-page code

            if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("racing-challenge-ads") ) :

            endif;

            //end widgetized-page code
            ?>

            gggggggggggggg

            <?php edit_post_link('(Edit This Page)', '<p>', '</p>'); ?>

        </div>

    </div>

</div>

<!-- The main column ends  -->

<?php get_footer(); ?>