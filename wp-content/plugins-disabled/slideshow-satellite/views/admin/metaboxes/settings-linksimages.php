<table class="form-table">
	<tbody>
    	<tr>
        	<th><label for="imagesbox_N"><?php _e('Open Images in...', SATL_PLUGIN_NAME); ?></label></th>
            <td>
                <label><input <?php echo ($this -> get_option('imagesbox') == "N") ? 'checked="checked"' : ''; ?> type="radio" name="imagesbox" value="N" id="imagesbox_N" /> <?php _e('No Link', SATL_PLUGIN_NAME); ?></label>
                <label><input <?php echo ($this -> get_option('imagesbox') == "W") ? 'checked="checked"' : ''; ?> type="radio" name="imagesbox" value="W" id="imagesbox_W" /> <?php _e('Window', SATL_PLUGIN_NAME); ?></label>
            	<label><input <?php echo ($this -> get_option('imagesbox') == "T") ? 'checked="checked"' : ''; ?> type="radio" name="imagesbox" value="T" id="imagesbox_T" /> <?php _e('Thickbox', SATL_PLUGIN_NAME); ?></label>
            	<label><input <?php echo ($this -> get_option('imagesbox') == "S") ? 'checked="checked"' : ''; ?> type="radio" name="imagesbox" value="S" id="imagesbox_S" /> <?php _e('Custom', SATL_PLUGIN_NAME); ?></label>
            	<span class="howto"><?php _e('Thickbox comes standard with your Wordpress install. Shadowbox and Prettyphoto are great custom options, they come with themes or plugins', SATL_PLUGIN_NAME); ?></span>
            </td>
        </tr>
        <tr>
            <th><?php _e('Recommendations', SATL_PLUGIN_NAME);?> </th>
            <td>
                    <div><a href="http://wordpress.org/extend/plugins/shadowbox-js/" target="_blank">Shadowbox Plugin</a></div>
                    <div><a href="http://wordpress.org/extend/plugins/wp-prettyphoto/" target="_blank">PrettyPhoto Plugin</a></div>
            </td>
        </tr>
        <tr>
            <th><label for="pagelink"><?php _e('Page Link Target', SATL_PLUGIN_NAME); ?></label></th>
            <td>
                <label><input <?php echo ($this -> get_option('pagelink') == "S") ? 'checked="checked"' : ''; ?> type="radio" name="pagelink" value="S" id="pagelink_S" /> <?php _e('Current Tab', SATL_PLUGIN_NAME); ?></label>
            	<label><input <?php echo ($this -> get_option('pagelink') == "B") ? 'checked="checked"' : ''; ?> type="radio" name="pagelink" value="B" id="pagelink_B" /> <?php _e('New Tab', SATL_PLUGIN_NAME); ?></label>
            	<span class="howto"><?php _e('Same as setting that <em>target</em> pages are &quot;_self&quot; or &quot;_blank&quot;', SATL_PLUGIN_NAME); ?></span>
            </td>
        </tr>
	<?php if ( SATL_PRO ) {		?>
		<tr>
        	<th><label for="captionlink_N"><?php _e('Use Caption Field as a Link?', SATL_PLUGIN_NAME); ?></label></th>
            <td>
                <label><input <?php echo ($this -> get_option('captionlink') == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="captionlink" value="S" id="captionlink_Y" /> <?php _e('Yes', SATL_PLUGIN_NAME); ?></label>
            	<label><input <?php echo ($this -> get_option('captionlink') == ("N"||"")) ? 'checked="checked"' : ''; ?> type="radio" name="captionlink" value="B" id="captionlink_N" /> <?php _e('No', SATL_PLUGIN_NAME); ?></label>
            	<span class="howto"><?php _e('If using the <strong>Wordpress Image Gallery</strong> you can still link out to a new page by using the Caption Field', SATL_PLUGIN_NAME); ?></span>
            </td>
        </tr>
        
		<?php } ?>
        
    </tbody>
</table>