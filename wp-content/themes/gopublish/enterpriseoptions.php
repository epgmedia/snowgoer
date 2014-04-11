<?php

class SNOEnterprise {

	function addOptions () {

		if (isset($_POST['revchrome_reset'])) { SNOEnterprise::initOptions(true); }

		if (isset($_POST['revchrome_save'])) {

			$aOptions = SNOEnterprise::initOptions(false);
			$aOptions['excluded'] = $_POST['excluded'];
			$aOptions['header'] = $_POST['header'];
			$aOptions['header-width'] = $_POST['header-width'];
			$aOptions['header-height'] = $_POST['header-height'];
			$aOptions['favicon'] = $_POST['favicon'];
			$aOptions['email'] = $_POST['email'];
			$aOptions['featured-cat'] = $_POST['featured-cat'];
			$aOptions['featured-count'] = $_POST['featured-count'];
			$aOptions['staff-cat'] = $_POST['staff-cat'];	
			$aOptions['audio-cat'] = $_POST['audio-cat'];	
			$aOptions['audio-count'] = $_POST['audio-count'];	
			$aOptions['homebox-cat'] = $_POST['homebox-cat'];
			$aOptions['video-cat'] = $_POST['video-cat'];
			$aOptions['footer-text'] = stripslashes($_POST['footer-text']);
			$aOptions['maincat1'] = $_POST['maincat1'];
			$aOptions['maincat1-count'] = $_POST['maincat1-count'];
			$aOptions['maincat1-name'] = stripslashes($_POST['maincat1-name']);
			$aOptions['maincat1-slug'] = stripslashes($_POST['maincat1-slug']);
			$aOptions['maincat1-photo'] = stripslashes($_POST['maincat1-photo']);
			$aOptions['maincat2'] = $_POST['maincat2'];
			$aOptions['maincat2-count'] = $_POST['maincat2-count'];
			$aOptions['maincat2-name'] = stripslashes($_POST['maincat2-name']);
			$aOptions['maincat2-slug'] = stripslashes($_POST['maincat2-slug']);
			$aOptions['maincat2-photo'] = stripslashes($_POST['maincat2-photo']);
			$aOptions['maincat3'] = $_POST['maincat3'];
			$aOptions['maincat3-count'] = $_POST['maincat3-count'];
			$aOptions['maincat3-name'] = stripslashes($_POST['maincat3-name']);
			$aOptions['maincat3-slug'] = stripslashes($_POST['maincat3-slug']);
			$aOptions['maincat3-photo'] = stripslashes($_POST['maincat3-photo']);
			$aOptions['maincat4'] = $_POST['maincat4'];
			$aOptions['maincat4-count'] = $_POST['maincat4-count'];
			$aOptions['maincat4-name'] = stripslashes($_POST['maincat4-name']);
			$aOptions['maincat4-slug'] = stripslashes($_POST['maincat4-slug']);
			$aOptions['maincat4-photo'] = stripslashes($_POST['maincat4-photo']);
			$aOptions['maincat5'] = $_POST['maincat5'];
			$aOptions['maincat5-count'] = $_POST['maincat5-count'];
			$aOptions['maincat5-name'] = stripslashes($_POST['maincat5-name']);
			$aOptions['maincat5-slug'] = stripslashes($_POST['maincat5-slug']);
			$aOptions['maincat5-photo'] = stripslashes($_POST['maincat5-photo']);
			$aOptions['maincat6'] = $_POST['maincat6'];
			$aOptions['maincat6-count'] = $_POST['maincat6-count'];
			$aOptions['maincat6-name'] = stripslashes($_POST['maincat6-name']);
			$aOptions['maincat6-slug'] = stripslashes($_POST['maincat6-slug']);
			$aOptions['maincat6-photo'] = stripslashes($_POST['maincat6-photo']);
			$aOptions['videoembed'] = stripslashes($_POST['videoembed']);
			$aOptions['feedburner'] = stripslashes($_POST['feedburner']);
			$aOptions['advertisementright'] = stripslashes($_POST['advertisementright']);
			$aOptions['advertisementrightsite'] = stripslashes($_POST['advertisementrightsite']);
			$aOptions['advertisementright2'] = stripslashes($_POST['advertisementright2']);
			$aOptions['advertisementrightsite2'] = stripslashes($_POST['advertisementrightsite2']);
			$aOptions['advertisementtop'] = stripslashes($_POST['advertisementtop']);
			$aOptions['advertisementtopsite'] = stripslashes($_POST['advertisementtopsite']);
			update_option('revchrome_theme', $aOptions);

		}
		
		add_theme_page("Enterprise Homepage Options", "Enterprise Homepage Options", 'edit_themes', basename(__FILE__), array('SNOEnterprise', 'displayOptions'));

	}
	
	function initOptions ($bReset) {
		$aOptions = get_option('revchrome_theme');
		if (!is_array($aOptions) || $bReset) {
			$aOptions['excluded'] = '1,3,10,11,12,13';
			$aOptions['header'] = 'http://www.schoolnewspapersonline.com/wp-content/uploads/2009/12/enterpriselogo.png';
			$aOptions['header-width'] = '340';
			$aOptions['header-height'] = '100';
			$aOptions['favicon'] = 'http://www.schoolnewspapersonline.com/wp-content/uploads/2008/11/reddot.png';
			$aOptions['email'] = 'adviser@email.com';
			$aOptions['video-cat'] = '13';
			$aOptions['staff-cat'] = '11';
			$aOptions['audio-cat'] = '3';
			$aOptions['audio-count'] = '4';
			$aOptions['featured-cat'] = '12';
			$aOptions['featured-count'] = '5';
			$aOptions['maincat1'] = '4';
			$aOptions['maincat1-count'] = '4';
			$aOptions['maincat1-name'] = 'Category1';
			$aOptions['maincat1-slug'] = 'category1';
			$aOptions['maincat1-photo'] = 'right';
			$aOptions['maincat2'] = '5';
			$aOptions['maincat2-count'] = '4';
			$aOptions['maincat2-name'] = 'Category2';
			$aOptions['maincat2-slug'] = 'category2';
			$aOptions['maincat2-photo'] = 'left';
			$aOptions['maincat3'] = '6';
			$aOptions['maincat3-count'] = '4';
			$aOptions['maincat3-name'] = 'Category3';
			$aOptions['maincat3-slug'] = 'category3';
			$aOptions['maincat3-photo'] = 'right';
			$aOptions['maincat4'] = '7';
			$aOptions['maincat4-count'] = '4';
			$aOptions['maincat4-name'] = 'Category4';
			$aOptions['maincat4-slug'] = 'category4';
			$aOptions['maincat4-photo'] = 'left';
			$aOptions['maincat5'] = '8';
			$aOptions['maincat5-count'] = '4';
			$aOptions['maincat5-name'] = 'Category5';
			$aOptions['maincat5-slug'] = 'category5';
			$aOptions['maincat5-photo'] = 'left';
			$aOptions['maincat6'] = '9';
			$aOptions['maincat6-count'] = '4';
			$aOptions['maincat6-name'] = 'Category6';
			$aOptions['maincat6-slug'] = 'category6';
			$aOptions['maincat6-photo'] = 'left';
			$aOptions['advertisementright'] = 'http://www.schoolnewspapersonline.com/wp-content/uploads/2009/06/avw.jpg';
			$aOptions['advertisementrightsite'] = 'http://www.schoolnewspapersonline.com';
			$aOptions['advertisementright2'] = 'http://www.schoolnewspapersonline.com/wp-content/uploads/2009/06/avw.jpg';
			$aOptions['advertisementrightsite2'] = 'http://www.schoolnewspapersonline.com';
			$aOptions['advertisementtop'] = 'http://www.schoolnewspapersonline.com/wp-content/uploads/2009/06/avw-1.jpg';
			$aOptions['advertisementtopsite'] = 'http://www.schoolnewspapersonline.com';
			update_option('revchrome_theme', $aOptions);
		}
		return $aOptions;
	}

	function displayOptions () {
		$aOptions = SNOEnterprise::initOptions(false);
?>

<div class="wrap">
	<h2>Enterprise Design Options</h2>	
    <div style="margin-left:0px;">
    <form action="#" method="post" enctype="multipart/form-data" name="massive_form" id="massive_form">
		<fieldset name="general_options" class="options">
        
        <h3 style="margin-bottom:0px;">Home Page "Top Story Box" Options</h3>        
        <p style="margin-top:0px;">Use the field below to edit your top story box options.</p>
		
        Top Stories Category ID Number:<br />
		<div style="margin:0;padding:0;">
        <input name="featured-cat" type="text" id="featured-cat" value="<?php echo($aOptions['featured-cat']); ?>" size="2" /> 
        </div><br />

        Number of Top Stories to Display:<br />
		<div style="margin:0;padding:0;">
        <input name="featured-count" type="text" id="featured-count" value="<?php echo($aOptions['featured-count']); ?>" size="2" /> 
        </div><br />


        <h3 style="margin-bottom:0px;">Home Page Column 1 Category #1 Options:</h3>
        <p style="margin-top:0px;">Use the field below to select the category you wish to use do display posts within the first main section of your homepage.</p>

<table>
<tr>
<td width=100>
        Category ID<br />
		<div style="margin:0;padding:0;">
        <input name="maincat1" id="maincat1" value="<?php echo($aOptions['maincat1']); ?>" size="2" ></input>   
        </div><br /> 
</td>
<td width=150>
        # of Stories<br />
		<div style="margin:0;padding:0;">
        <input name="maincat1-count" id="maincat1-count" value="<?php echo($aOptions['maincat1-count']); ?>" size="2" ></input>   
        </div><br /> 
</td>
<td width=200>
        Category Name<br />
		<div style="margin:0;padding:0;">
        <input name="maincat1-name" id="maincat1-name" value="<?php echo($aOptions['maincat1-name']); ?>" size="20" ></input>   
        </div><br /> 
</td> 
<td width=200>       
        Category Slug<br />
		<div style="margin:0;padding:0;">
        <input name="maincat1-slug" id="maincat1-slug" value="<?php echo($aOptions['maincat1-slug']); ?>" size="20" ></input>   
        </div><br /> 
</td>
</tr>
</table>
        <h3 style="margin-bottom:0px;">Home Page Column 1 Category #2 Options:</h3>
        <p style="margin-top:0px;">Use the field below to select the category you wish to use do display posts within the second main section of your homepage.</p>

<table>
<tr>
<td width=100>

        Category ID<br />
		<div style="margin:0;padding:0;">
        <input name="maincat2" id="maincat2" value="<?php echo($aOptions['maincat2']); ?>" size="2" ></input>   
        </div><br /> 
</td>
<td width=150>

        # of Stories<br />
		<div style="margin:0;padding:0;">
        <input name="maincat2-count" id="maincat2-count" value="<?php echo($aOptions['maincat2-count']); ?>" size="2" ></input>   
        </div><br /> 
        
</td>
<td width=200>
        Category Name<br />
		<div style="margin:0;padding:0;">
        <input name="maincat2-name" id="maincat2-name" value="<?php echo($aOptions['maincat2-name']); ?>" size="20" ></input>   
        </div><br /> 

</td> 
<td width=200>       
        Category Slug<br />

		<div style="margin:0;padding:0;">
        <input name="maincat2-slug" id="maincat2-slug" value="<?php echo($aOptions['maincat2-slug']); ?>" size="20" ></input>   
        </div><br /> 

</td>
</tr>
</table>

        <h3 style="margin-bottom:0px;">Home Page Column 1 Category #3 Options:</h3>
        <p style="margin-top:0px;">Use the field below to select the category you wish to use do display posts within the third main section of your homepage.</p>


<table>
<tr>
<td width=100>
        Category ID<br />
		<div style="margin:0;padding:0;">
        <input name="maincat3" id="maincat3" value="<?php echo($aOptions['maincat3']); ?>" size="2" ></input>   
        </div><br /> 

</td>
<td width=150>
        # of Stories<br />

		<div style="margin:0;padding:0;">
        <input name="maincat3-count" id="maincat3-count" value="<?php echo($aOptions['maincat3-count']); ?>" size="2" ></input>   
        </div><br /> 
        
</td>
<td width=200>
        Category Name<br />

		<div style="margin:0;padding:0;">
        <input name="maincat3-name" id="maincat3-name" value="<?php echo($aOptions['maincat3-name']); ?>" size="20" ></input>   
        </div><br /> 

</td> 
<td width=200>       
        Category Slug<br />

		<div style="margin:0;padding:0;">
        <input name="maincat3-slug" id="maincat3-slug" value="<?php echo($aOptions['maincat3-slug']); ?>" size="20" ></input>   
        </div><br /> 

</td>
</tr>
</table>
        <h3 style="margin-bottom:0px;">Home Page Column 2 Category #1 Options:</h3>
        <p style="margin-top:0px;">Use the field below to select the category you wish to use do display posts within the fourth main section of your homepage.</p>


<table>
<tr>
<td width=100>
        Category ID<br />
		<div style="margin:0;padding:0;">
        <input name="maincat4" id="maincat4" value="<?php echo($aOptions['maincat4']); ?>" size="2" ></input>   
        </div><br /> 

</td>
<td width=150>
        # of Stories<br />

		<div style="margin:0;padding:0;">
        <input name="maincat4-count" id="maincat4-count" value="<?php echo($aOptions['maincat4-count']); ?>" size="2" ></input>   
        </div><br /> 

</td>
<td width=200>
        Category Name<br />

		<div style="margin:0;padding:0;">
        <input name="maincat4-name" id="maincat4-name" value="<?php echo($aOptions['maincat4-name']); ?>" size="20" ></input>   
        </div><br /> 
        
</td> 
<td width=200>       
        Category Slug<br />

		<div style="margin:0;padding:0;">
        <input name="maincat4-slug" id="maincat4-slug" value="<?php echo($aOptions['maincat4-slug']); ?>" size="20" ></input>   
        </div><br /> 

</td>
</tr>
</table>
        <h3 style="margin-bottom:0px;">Home Page Column 2 Category #2 Options:</h3>
        <p style="margin-top:0px;">Use the field below to select the category you wish to use do display posts within the fifth main section of your homepage.</p>


<table>
<tr>
<td width=100>
        Category ID<br />
		<div style="margin:0;padding:0;">
        <input name="maincat5" id="maincat5" value="<?php echo($aOptions['maincat5']); ?>" size="2" ></input>   
        </div><br /> 

</td>
<td width=150>
        # of Stories<br />
		<div style="margin:0;padding:0;">
        <input name="maincat5-count" id="maincat5-count" value="<?php echo($aOptions['maincat5-count']); ?>" size="2" ></input>   
        </div><br /> 

</td>
<td width=200>
        Category Name<br />
		<div style="margin:0;padding:0;">
        <input name="maincat5-name" id="maincat5-name" value="<?php echo($aOptions['maincat5-name']); ?>" size="20" ></input>   
        </div><br /> 
        
</td> 
<td width=200>       
        Category Slug<br />
		<div style="margin:0;padding:0;">
        <input name="maincat5-slug" id="maincat5-slug" value="<?php echo($aOptions['maincat5-slug']); ?>" size="20" ></input>   
        </div><br /> 

</td>
</tr>
</table>
        <h3 style="margin-bottom:0px;">Home Page Column 2 Category #3 Options:</h3>
        <p style="margin-top:0px;">Use the field below to select the category you wish to use do display posts within the sixth main section of your homepage.</p>


<table>
<tr>
<td width=100>
        Category ID<br />
		<div style="margin:0;padding:0;">
        <input name="maincat6" id="maincat6" value="<?php echo($aOptions['maincat6']); ?>" size="2" ></input>   
        </div><br /> 

</td>
<td width=150>
        # of Stories<br />
		<div style="margin:0;padding:0;">
        <input name="maincat6-count" id="maincat6-count" value="<?php echo($aOptions['maincat6-count']); ?>" size="2" ></input>   
        </div><br /> 
        
</td>
<td width=200>
        Category Name<br />
		<div style="margin:0;padding:0;">
        <input name="maincat6-name" id="maincat6-name" value="<?php echo($aOptions['maincat6-name']); ?>" size="20" ></input>   
        </div><br /> 

</td> 
<td width=200>       
        Category Slug<br />

		<div style="margin:0;padding:0;">
        <input name="maincat6-slug" id="maincat6-slug" value="<?php echo($aOptions['maincat6-slug']); ?>" size="20" ></input>   
        </div><br /> 

</td>
</tr>
</table>



        <h3 style="margin-bottom:0px;">Home Page Sidebar Advertisement #1:</h3>
        <p style="margin-top:0px;">Use the fields below to add a 300x250 advertisement to the right sidebar. DO NOT CHANGE THE CODE BELOW IF YOU HAVE SIGNED UP FOR THE AD-SERVING PACKAGE.</p>


<table>
<tr>
<td width=375>
        URL of Uploaded Advertisement<br />
		<div style="margin:0;padding:0;">
        <input name="advertisementright" id="advertisementright" value="<?php echo($aOptions['advertisementright']); ?>" size="35" ></input>   
        </div><br /> 

</td>
<td width=375>
        URL of Advertiser's Web site<br />
		<div style="margin:0;padding:0;">
        <input name="advertisementrightsite" id="advertisementrightsite" value="<?php echo($aOptions['advertisementrightsite']); ?>" size="35" ></input>   
        </div><br /> 
        
</td>

</tr>
</table>



        <h3 style="margin-bottom:0px;">Home Page Sidebar Advertisement #2:</h3>
        <p style="margin-top:0px;">Use the fields below to add a second 300x250 advertisement to the right sidebar. DO NOT CHANGE THE CODE BELOW IF YOU HAVE SIGNED UP FOR THE AD-SERVING PACKAGE.</p>


<table>
<tr>
<td width=375>
        URL of Uploaded Advertisement<br />
		<div style="margin:0;padding:0;">
        <input name="advertisementright2" id="advertisementright2" value="<?php echo($aOptions['advertisementright2']); ?>" size="35" ></input>   
        </div><br /> 

</td>
<td width=375>
        URL of Advertiser's Web site<br />
		<div style="margin:0;padding:0;">
        <input name="advertisementrightsite2" id="advertisementrightsite2" value="<?php echo($aOptions['advertisementrightsite2']); ?>" size="35" ></input>   
        </div><br /> 
        
</td>

</tr>
</table>


        <h3 style="margin-bottom:0px;">Permalink Page Banner Advertisement:</h3>
        <p style="margin-top:0px;">Use the fields below to add a banner ad beneath every story on its permalink page. DO NOT CHANGE THE CODE BELOW IF YOU HAVE SIGNED UP FOR THE AD-SERVING PACKAGE.</p>


<table>
<tr>
<td width=375>
        URL of Uploaded Advertisement<br />
		<div style="margin:0;padding:0;">
        <input name="advertisementtop" id="advertisementtop" value="<?php echo($aOptions['advertisementtop']); ?>" size="35" ></input>   
        </div><br /> 

</td>
<td width=375>
        URL of Advertiser's Web site<br />
		<div style="margin:0;padding:0;">
        <input name="advertisementtopsite" id="advertisementtopsite" value="<?php echo($aOptions['advertisementtopsite']); ?>" size="35" ></input>   
        </div><br /> 
        
</td>

</tr>
</table>

        <h3 style="margin-bottom:0px;">Navigation Bar Options:</h3>
        <p style="margin-top:0px;">Use the field below to exclude specific categories from your navigation bar.  Type a comma-separated list of category ID numbers that you'd like excluded from navigation.  NOTE:  Do not put spaces between the numbers. </p>

<table>
<tr>

        List of Excluded Categories<br />
		<div style="margin:0;padding:0;">
        <input name="excluded" id="excluded" value="<?php echo($aOptions['excluded']); ?>" size="35" ></input>   
        </div><br /> 
</tr>
</table>

        <h3 style="margin-bottom:0px;">Header Image:</h3>
        <p style="margin-top:0px;">Use the fields below to add a new header image to your site.  NOTE:  Your site will look best if you upload a header with a transparent background saved as a .png file. </p>

<table>
<tr>

        URL of Uploaded Header Image<br />
		<div style="margin:0;padding:0;">
        <input name="header" id="header" value="<?php echo($aOptions['header']); ?>" size="35" ></input>   
        </div><br /> 
</tr>
<tr>

        Header Width (in pixels)  Use numbers only.  Maximum width of 600 pixels. <br />
		<div style="margin:0;padding:0;">
        <input name="header-width" id="header-width" value="<?php echo($aOptions['header-width']); ?>" size="5" ></input>   
        </div><br /> 
        
</tr>
<tr>

        Header Height (in pixels).  Use numbers only.  Maximum height of 100 pixels. <br />
		<div style="margin:0;padding:0;">
        <input name="header-height" id="header-height" value="<?php echo($aOptions['header-height']); ?>" size="5" ></input>   
        </div><br /> 

</tr>
</table>

        <h3 style="margin-bottom:0px;">Favicon Image:</h3>
        <p style="margin-top:0px;">Use the field below to add a new favicon image to your site.  NOTE:  This image must be 16 pixels wide by 16 pixels tall and must be saved as a .ico or .png file. </p>

<table>
<tr>

        URL of Uploaded Favicon Image<br />
		<div style="margin:0;padding:0;">
        <input name="favicon" id="favicon" value="<?php echo($aOptions['favicon']); ?>" size="35" ></input>   
        </div><br /> 
</tr>
</table>

        <h3 style="margin-bottom:0px;">Adviser Email Address:</h3>
        <p style="margin-top:0px;">Use the field below to enter the adviser's email address.  This will be linked to the mail icon on the homepage. </p>

<table>
<tr>

        Email address:<br />
		<div style="margin:0;padding:0;">
        <input name="email" id="email" value="<?php echo($aOptions['email']); ?>" size="35" ></input>   
        </div><br /> 
</tr>
</table>

<table>
<tr>
<td width=375>
        Staff Category ID number<br />
		<div style="margin:0;padding:0;">
        <input name="staff-cat" id="staff-cat" value="<?php echo($aOptions['staff-cat']); ?>" size="5" ></input>   
        </div><br /> 

</tr>
</table>

        <h3 style="margin-bottom:0px;">Home Page Sidebar Video Options:</h3>
        <p style="margin-top:0px;">Use the fields below to edit your featured video options.</p>
 
        Video Category ID Number:<br />
		<div style="margin:0;padding:0;">
        <input name="video-cat" id="video-cat" value="<?php echo($aOptions['video-cat']); ?>" size="2" ></input>   
        </div><br /> 


        <h3 style="margin-bottom:0px;">Home Page Sidebar Podcast/Audio Options:</h3>
        <p style="margin-top:0px;">Use the fields below to edit your featured podcast/audio options.</p>
 
        Podcast/Audio Category ID Number:<br />
		<div style="margin:0;padding:0;">
        <input name="audio-cat" id="audio-cat" value="<?php echo($aOptions['audio-cat']); ?>" size="2" ></input>   
        </div><br /> 

        Number of Recent Podcast/Audio Files to Display:<br />
		<div style="margin:0;padding:0;">
        <input name="audio-count" id="audio-count" value="<?php echo($aOptions['audio-count']); ?>" size="2" ></input>   
        </div><br /> 


		</fieldset>

		<p class="submit"><input type="submit" name="revchrome_save" value="Save" /></p>
		<p class="submit"><input type="submit" name="revchrome_reset" value="Reset" /></p>
	</form>      
</div>
<?php
	}
}

// Register functions
add_action('admin_menu', array('SNOEnterprise', 'addOptions'));



?>