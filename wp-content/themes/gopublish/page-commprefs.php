<?php
/*
Template Name: Comm Preferences
*/
?>
            
       <?php get_header(); ?>

<div id="content">

	<div id="contentleft">
	
		<div class="postarea">
	
		<?php include(TEMPLATEPATH."/breadcrumb.php");?>
			
			            
<?php
              
$email = $_GET['email'];
$id = $_GET['id'];
if (isset($email) && isset($id)) {
                 echo '<iframe src="https://www.rv.net/email/preferences/index.cfm?email='.$email.'&id='.$id.'&source=snow%20goer%20magazine" scrolling="no" width="510" height="1200" frameborder="0" id="confirmemailframe"></iframe>';
 }
?>
				
		</div>
		
	</div>
	
<?php include(TEMPLATEPATH."/sidebar.php");?>

</div>

<!-- The main column ends  -->

<?php get_footer(); ?>
