<?php
/*
Template Name: Email Confirmation
*/
?>
            
       <?php get_header(); ?>


<div id="content">

	<div id="contentleft">
	
		<div class="postarea">
	
		<?php include(TEMPLATEPATH."/breadcrumb.php");?>

<div id="throbber" style="margin-left: 280px;"><img src="http://www.rv.net/SharedContent/ajax/activity_indicators/indicator_medium.gif"></div>
			
<div id="iframediv" style="display: none;">

<?php
$email = $_GET['email'];
$id = $_GET['id'];
if (isset($email) && isset($id)) {
                 echo '<iframe src="https://www.rv.net/email/preferences/index.cfm?email='.$email.'&id='.$id.'&source=snow%20goer%20magazine" scrolling="no" width="510" height="1200" frameborder="0" id="confirmemailframe"></iframe>';
 }
?>

</div>

<script>
                $('iframe').load(function () {
                        $('#throbber').hide();
                        $('#iframediv').show();
    });
</script>
						
		</div>
		
	</div>
	
<?php include(TEMPLATEPATH."/sidebar.php");?>

</div>

<!-- The main column ends  -->

<?php get_footer(); ?>
