<?php
/*
Plugin Name: Other Posts From Cat
Plugin URI: http://www.dagondesign.com/articles/other-posts-from-cat-plugin-for-wordpress/
Description: At the bottom of every post, links are shown for the last X posts from the current category.
Author: Dagon Design
Version: 1.6
Author URI: http://www.dagondesign.com
*/

$ddop_ver = '1.6';


// Setup defaults if options do not exist
add_option('ddop_all_posts', FALSE);
add_option('ddop_num', 5);
add_option('ddop_header', '<h2>Last 5 stories in %C</h2>');
add_option('ddop_show_date', TRUE);
add_option('ddop_date_format', 'F j, Y');
add_option('ddop_inc_current', FALSE);
add_option('ddop_newest_first', TRUE);
add_option('ddop_other_cats', FALSE);
add_option('ddop_sep_cats', FALSE);
add_option('ddop_exclude', '');



function ddop_add_option_pages() {
	if (function_exists('add_options_page')) {
		add_options_page('Other Posts from Cat', 'DDOtherPostsFromCat', 8, __FILE__, 'ddop_options_page');
	}		
}



function ddop_options_page() {

	global $ddop_ver;

	if (isset($_POST['set_defaults'])) {
		echo '<div id="message" class="updated fade"><p><strong>';

		update_option('ddop_all_posts', FALSE);
		update_option('ddop_num', 5);
		update_option('ddop_header', '<h2>Last 5 stories in %C</h2>');
		update_option('ddop_show_date', TRUE);
		update_option('ddop_date_format', 'F j, Y');
		update_option('ddop_inc_current', FALSE);
		update_option('ddop_newest_first', TRUE);
		update_option('ddop_other_cats', FALSE);
		update_option('ddop_sep_cats', FALSE);
		update_option('ddop_exclude', '');

		echo 'Default Options Loaded!';
		echo '</strong></p></div>';

	} else if (isset($_POST['info_update'])) {

		echo '<div id="message" class="updated fade"><p><strong>';

		update_option('ddop_all_posts', (bool) $_POST["ddop_all_posts"]);
		update_option('ddop_num', (int) $_POST["ddop_num"]);
		update_option('ddop_header', (string) $_POST["ddop_header"]);
		update_option('ddop_show_date', (bool) $_POST["ddop_show_date"]);
		update_option('ddop_date_format', (string) $_POST["ddop_date_format"]);
		update_option('ddop_inc_current', (bool) $_POST["ddop_inc_current"]);
		update_option('ddop_newest_first', (bool) $_POST["ddop_newest_first"]);
		update_option('ddop_other_cats', (bool) $_POST["ddop_other_cats"]);
		update_option('ddop_sep_cats', (bool) $_POST["ddop_sep_cats"]);
		update_option('ddop_exclude', (string) $_POST["ddop_exclude"]);
			
		echo 'Configuration Updated!';
		echo '</strong></p></div>';

	} ?>

	<div class=wrap>

	<h2>Other Posts from Cat v<?php echo $ddop_ver; ?></h2>

	<p>For information and updates, please visit:<br />
	<a href="http://www.dagondesign.com/articles/other-posts-from-cat-plugin-for-wordpress/">http://www.dagondesign.com/articles/other-posts-from-cat-plugin-for-wordpress/</a></p>

	<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
	<input type="hidden" name="info_update" id="info_update" value="true" />


	<fieldset class="options"> 
	<legend>Display</legend>
	<table width="100%" border="0" cellspacing="0" cellpadding="6">

	<tr valign="top"><td width="35%" align="right">
		Show at the bottom of every post
	</td><td align="left">
		<input type="checkbox" name="ddop_all_posts" value="checkbox" <?php if (get_option('ddop_all_posts')) echo "checked='checked'"; ?>/>
		<br />
		<br />If you prefer, you can manually generate the list by 
		<br />typing <b>&lt;!-- ddpostsfromcat --&gt;</b> in a post.
	</td></tr>


	</table>
	</fieldset>


	<fieldset class="options"> 
	<legend>Options</legend>
	<table width="100%" border="0" cellspacing="0" cellpadding="6">

	<tr valign="top"><td width="35%" align="right">
		Check all categories that current post is in
	</td><td align="left">
		<input type="checkbox" name="ddop_other_cats" value="checkbox" <?php if (get_option('ddop_other_cats')) echo "checked='checked'"; ?>/>
		( If disabled, it will just show other posts from the first category this post is found in )
	</td></tr>

	<tr valign="top"><td width="35%" align="right">
		Split categories into separate lists
	</td><td align="left">
		<input type="checkbox" name="ddop_sep_cats" value="checkbox" <?php if (get_option('ddop_sep_cats')) echo "checked='checked'"; ?>/>
		( Only applies if checking all categories )
	</td></tr>

	<tr valign="top"><td width="35%" align="right">
		Number of posts to show from this category
	</td><td align="left">
		<input name="ddop_num" type="text" size="10" value="<?php echo get_option('ddop_num') ?>"/>
	</td></tr>

	<tr valign="top"><td width="35%" align="right">
		Text to show before list
	</td><td align="left">
		<input name="ddop_header" type="text" size="40" value="<?php echo get_option('ddop_header') ?>"/>
		<br />( To show the categories name, use %C )
	</td></tr>

	<tr valign="top"><td width="35%" align="right">
		Show date after listed posts
	</td><td align="left">
		<input type="checkbox" name="ddop_show_date" value="checkbox" <?php if (get_option('ddop_show_date')) echo "checked='checked'"; ?>/>
	</td></tr>

	<tr valign="top"><td width="35%" align="right">
		Date format
	</td><td align="left">
		<input name="ddop_date_format" type="text" size="30" value="<?php echo get_option('ddop_date_format') ?>"/>
		<br />( Use the standard <a href="http://us3.php.net/date">PHP date() format</a> )
	</td></tr>

	<tr valign="top"><td width="35%" align="right">
		Include current post in list
	</td><td align="left">
		<input type="checkbox" name="ddop_inc_current" value="checkbox" <?php if (get_option('ddop_inc_current')) echo "checked='checked'"; ?>/>
		( If it is one of the last X posts )
	</td></tr>

	<tr valign="top"><td width="35%" align="right">
		Show newest posts first
	</td><td align="left">
		<input type="checkbox" name="ddop_newest_first" value="checkbox" <?php if (get_option('ddop_newest_first')) echo "checked='checked'"; ?>/>
		( Otherwise oldest posts will be shown first )
	</td></tr>

	<tr valign="top"><td width="35%" align="right">
		Excluded Categories
	</td><td align="left">
		<input name="ddop_exclude" type="text" size="40" value="<?php echo get_option('ddop_exclude') ?>"/>
		<br />(comma separated list of category names - not case sensitive)
	</td></tr>

	</table>
	</fieldset>

	<div class="submit">
		<input type="submit" name="set_defaults" value="<?php _e('Load Default Options'); ?> &raquo;" />
		<input type="submit" name="info_update" value="<?php _e('Update options'); ?> &raquo;" />
	</div>

	</form>
	</div><?php
}


function ddop_show_posts() {

	global $wpdb, $post, $wp_version;

	$ver = (float)$wp_version;
	
	$tp = $wpdb->prefix;

	$ddop_num = get_option('ddop_num');
	$ddop_header = get_option('ddop_header');
	$ddop_show_date = get_option('ddop_show_date');
	$ddop_date_format = get_option('ddop_date_format');
	$ddop_inc_current = get_option('ddop_inc_current');
	$ddop_newest_first = get_option('ddop_newest_first');
	$ddop_excluded_cats = get_option('ddop_excluded_cats');
	$ddop_other_cats = get_option('ddop_other_cats');
	$ddop_sep_cats = get_option('ddop_sep_cats');
	$ddop_exclude = get_option('ddop_exclude');

	// Generate list of excluded categories
	$ddop_exclude = explode(',', $ddop_exclude);
	foreach ($ddop_exclude as $key=>$value) { 
		$ddop_exclude[$key] = strtolower(trim($value)); 
	} 

	$c_post = $post->ID;
	$c_cat = get_the_category(); 
	$c_cat = $c_cat[0];

	$cat_title = strtolower($c_cat->cat_name);

	if (in_array($cat_title, $ddop_exclude) !== FALSE) {
		return '';
	}


	$the_output = NULL;

	if ($ddop_other_cats) {

		// get list of cats this post is in	

		if ($ver < 2.3) {

			$cat_list = (array)$wpdb->get_results("
				SELECT cat_ID, cat_name
				FROM {$tp}post2cat, {$tp}categories
				WHERE post_id = {$c_post} 
				AND {$tp}categories.cat_ID = {$tp}post2cat.category_id
				ORDER BY cat_name 
			");

		} else { // post 2.3

			$cat_list = (array)$wpdb->get_results("
				SELECT {$tp}terms.term_id as cat_ID, 
					{$tp}terms.name as cat_name
				FROM {$tp}term_relationships, {$tp}terms, {$tp}term_taxonomy 
				WHERE {$tp}term_relationships.object_id = {$c_post} 
				AND {$tp}term_taxonomy.taxonomy = 'category' 
				AND {$tp}term_relationships.term_taxonomy_id = {$tp}term_taxonomy.term_taxonomy_id
				AND {$tp}term_taxonomy.term_id = {$tp}terms.term_id
				ORDER BY cat_name 
			");

		}	


		if (count($cat_list) == 0) {
			$ddop_other_cats = FALSE;
		}

	}

	
	



	// ------------------------------------


	$category_check = '';

	if (!$ddop_other_cats) {

		// show single cat

		$curr_cat_id = $c_cat->cat_ID;

		if ($ver < 2.3) {
			$category_check = " WHERE category_id = " . $curr_cat_id . " ";
		} else { // post 2.3
			$category_check = " WHERE {$tp}terms.term_id = " . $curr_cat_id . " ";
		}

		$cat_info = $c_cat->cat_name;
		$ddop_header = str_replace('%C', $cat_info, $ddop_header);

	}






	if ($ddop_other_cats && !$ddop_sep_cats) {

		// show other cats too, but in one list

		$category_check = " WHERE (";
		
		$i = 1;

		foreach ($cat_list as $c) {

			if ($ver < 2.3) {
				$category_check .= " category_id = " . $c->cat_ID . " ";
			} else { // post 2.3
				$category_check .= " {$tp}terms.term_id = " . $c->cat_ID . " ";
			}

			if ($i < sizeof($cat_list)) {
				$category_check .= " OR ";
			}

			$i++;

		}

		$category_check .= ") ";




		$cat_info = "";

		$i = 1;

		foreach ($cat_list as $c) {

			$cat_info .= $c->cat_name;

			if ($i < sizeof($cat_list)) {
				$cat_info .= ", ";
			}

			$i++;
		}

		$ddop_header = str_replace('%C', $cat_info, $ddop_header);

	}





	// ------------------------------------








	// see if we show current post
	if (!$ddop_inc_current) {
		$ddop_inc_current = " AND ID != " . $c_post . " ";
	} else {
		$ddop_inc_current = " ";
	}

	// sorting
	$newest_check = ' ASC ';
	if ($ddop_newest_first) {
		$newest_check = ' DESC ';
	}








	if (!$ddop_other_cats || ($ddop_other_cats && !$ddop_sep_cats)) {

		if ($ver < 2.3) {

			$last_posts = (array)$wpdb->get_results("
				SELECT DISTINCT ID, post_title, post_date, post_category
				FROM {$tp}posts, {$tp}post2cat 
				{$category_check}
				AND {$tp}posts.ID = {$tp}post2cat.post_id 
				{$ddop_inc_current} 
				AND post_status = 'publish' 
				ORDER BY post_date {$newest_check} 
				LIMIT {$ddop_num}
			");
	
		} else { // post 2.3

			$last_posts = (array)$wpdb->get_results("
				SELECT DISTINCT ID, 
					post_title, 
					post_date, 
					{$tp}terms.term_id as post_category
				FROM {$tp}posts, {$tp}terms, {$tp}term_relationships, {$tp}term_taxonomy 
				{$category_check}
				AND {$tp}posts.ID = {$tp}term_relationships.object_id
				AND {$tp}term_relationships.term_taxonomy_id = {$tp}term_taxonomy.term_taxonomy_id
				AND {$tp}term_taxonomy.term_id = {$tp}terms.term_id 
				{$ddop_inc_current} 
				AND post_status = 'publish' 
				ORDER BY post_date {$newest_check} 
				LIMIT {$ddop_num}
			");
	
		}


		if (sizeof($last_posts) > 0) {

		
			$the_output .= $ddop_header;

			$the_output .= "<ul>";

			foreach ($last_posts as $lpost) {

				$the_output .= '<li><a href="' . get_permalink($lpost->ID) . '">' . htmlspecialchars($lpost->post_title) . '</a>';

				if ($ddop_show_date) {
					$the_output .= ' - ' . date($ddop_date_format, strtotime($lpost->post_date));
				}
		
				$the_output .= '</li>';

			}

			$the_output .= "</ul>";

		}

	}






	if ($ddop_other_cats && $ddop_sep_cats) {


		foreach ($cat_list as $c) {

			$the_output .= str_replace('%C', $c->cat_name, $ddop_header);

			if ($ver < 2.3) {

				$category_check = " WHERE category_id = " . $c->cat_ID . " ";

				$last_posts = (array)$wpdb->get_results("
					SELECT DISTINCT ID, post_title, post_date, post_category
					FROM {$tp}posts, {$tp}post2cat 
					{$category_check}
					AND {$tp}posts.ID = {$tp}post2cat.post_id 
					{$ddop_inc_current} 
					AND post_status = 'publish' 
					ORDER BY post_date {$newest_check} 
					LIMIT {$ddop_num}
				");	

			} else { // post 2.3

				$category_check = " WHERE {$tp}terms.term_id = " . $c->cat_ID . " ";

				$last_posts = (array)$wpdb->get_results("
					SELECT DISTINCT ID, 
						post_title, 
						post_date, 
						{$tp}terms.term_id as post_category
					FROM {$tp}posts, {$tp}terms, {$tp}term_relationships, {$tp}term_taxonomy 
					{$category_check}
					AND {$tp}posts.ID = {$tp}term_relationships.object_id
					AND {$tp}term_relationships.term_taxonomy_id = {$tp}term_taxonomy.term_taxonomy_id
					AND {$tp}term_taxonomy.term_id = {$tp}terms.term_id 
					{$ddop_inc_current} 
					AND post_status = 'publish' 
					ORDER BY post_date {$newest_check} 
					LIMIT {$ddop_num}
				");	


			}

			if (sizeof($last_posts) > 0) {

				$the_output .= '<ul>';

				foreach ($last_posts as $lpost) {

					$the_output .= '<li><a href="' . get_permalink($lpost->ID) . '">' . htmlspecialchars($lpost->post_title) . '</a>';

					if ($ddop_show_date) {
						$the_output .= ' - ' . date($ddop_date_format, strtotime($lpost->post_date));
					}
		
					$the_output .= '</li>';

				}	
		
				$the_output .= '</ul>';


			}


		}



	}







	return '<div class="ddop">' . $the_output . '</div>';

}






function ddop_generate($content) {

	if (strpos($content, "<!-- ddpostsfromcat -->") !== FALSE) {
		$content = preg_replace('/<p>\s*<!--(.*)-->\s*<\/p>/i', "<!--$1-->", $content); 
		$content = str_replace("<!-- ddpostsfromcat -->", ddop_show_posts(), $content);
	}

	if (is_single()) {
		if (get_option('ddop_all_posts')) {
			return $content . ddop_show_posts();
		} 
	}

	return $content;
}




add_filter('the_content', 'ddop_generate');
add_action('admin_menu', 'ddop_add_option_pages');






?>