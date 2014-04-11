<?php $styles = $this -> get_option('styles'); ?>
<table class="form-table">
	<tbody>
		<tr class="navbuttons">
			<th><label for="styles.navbuttons"><?php _e('Navigational Buttons', SATL_PLUGIN_NAME); ?></label></th>
			<td>
                            <div class="alignleft" style="width:206px"><img src="<?php echo(SATL_PLUGIN_URL.'/images/nav-options.gif')?>"></div>

			<?php if ( SATL_PRO ) {
				require SATL_PLUGIN_DIR . '/pro/settings-navbuttons.php';
			} else {
			?>
                <select disabled>
                    <option>1- Default </option> <?php _e('1- Default', SATL_PLUGIN_NAME); ?>
                </select>
			<?php } ?>
				<span class="howto clear"><?php _e('Premium Edition Only: Choose your nav arrows for left and right transitioning', SATL_PLUGIN_NAME); ?></span>
			</td>
		</tr>
                <tr class="navpush">
                    <th><label for="styles.navpush"><?php _e('Navigational Push', SATL_PLUGIN_NAME); ?></label></th>
			<td>
				<input style="width:45px;" id="styles.navpush" type="text" name="styles[navpush]" value="<?php echo $styles['navpush']; ?>" /> <?php _e('px', SATL_PLUGIN_NAME); ?>
				<span class="howto"><?php _e('How far your navigational arrows are pushed away from the slideshow', SATL_PLUGIN_NAME); ?></span>
			</td>
                </tr>
 		<tr class="gal-width">
			<th><label for="styles.width"><?php _e('Gallery Width', SATL_PLUGIN_NAME); ?></label></th>
			<td>
				<input style="width:45px;" id="styles.width" type="text" name="styles[width]" value="<?php echo $styles['width']; ?>" /> <?php _e('px', SATL_PLUGIN_NAME); ?>
				<span class="howto"><?php _e('width of the slideshow gallery', SATL_PLUGIN_NAME); ?></span>
			</td>
		</tr>
		<tr class="gal-height">
			<th><label for="styles.height"><?php _e('Gallery Height', SATL_PLUGIN_NAME); ?></label></th>
			<td>
				<input style="width:45px;" id="styles.height" type="text" name="styles[height]" value="<?php echo $styles['height']; ?>" /> <?php _e('px', SATL_PLUGIN_NAME); ?>
				<span class="howto"><?php _e('height of the slideshow gallery', SATL_PLUGIN_NAME); ?></span>
			</td>
		</tr>
		<tr class="border">
			<th><label for="styles.border"><?php _e('Slideshow Border', SATL_PLUGIN_NAME); ?></label></th>
			<td>
				<input type="text" name="styles[border]" value="<?php echo $styles['border']; ?>" id="styles.border" style="width:145px;" />
			</td>
		</tr>
		<tr class="background">
			<th><label for="styles.background"><?php _e('Slideshow Background', SATL_PLUGIN_NAME); ?></label></th>
			<td>
				<input type="text" name="styles[background]" value="<?php echo $styles['background']; ?>" id="styles.background" style="width:65px;" />
			</td>
		</tr>
		<tr>
			<th><label for="styles.infobackground"><?php _e('Caption Background', SATL_PLUGIN_NAME); ?></label></th>
			<td>
				<input type="text" name="styles[infobackground]" value="<?php echo $styles['infobackground']; ?>" id="styles.infobackground" style="width:65px;" />
			</td>
		</tr>
		<tr>
			<th><label for="styles.infocolor"><?php _e('Caption Text Color', SATL_PLUGIN_NAME); ?></label></th>
			<td>
				<input type="text" name="styles[infocolor]" value="<?php echo $styles['infocolor']; ?>" id="styles.infocolor" style="width:65px;" />
			</td>
		</tr>
		<tr>
			<th><label for="styles.playshow"><?php _e('Allow Play/Pause to Show?', SATL_PLUGIN_NAME); ?></label></th>
			<td>
				<label><input <?php echo (empty($styles['playshow']) || $styles['infomin'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="styles[playshow]" value="Y" id="styles.playshow_Y" /> <?php _e('Yes', SATL_PLUGIN_NAME); ?></label>
				<label><input <?php echo ($styles['playshow'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="styles[playshow]" value="N" id="styles.playshow_N" /> <?php _e('No', SATL_PLUGIN_NAME); ?></label>
				<span class="howto"><?php _e('If auto is off, play/pause won\'t show. Here you can hide it while auto is on.', SATL_PLUGIN_NAME); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="styles.infomin"><?php _e('Minimize Caption Bar Height?', SATL_PLUGIN_NAME); ?></label></th>
			<td>
				<label><input <?php echo (empty($styles['infomin']) || $styles['infomin'] == "Y") ? 'checked="checked"' : ''; ?> type="radio" name="styles[infomin]" value="Y" id="styles.infomin_Y" /> <?php _e('Yes, minimize', SATL_PLUGIN_NAME); ?></label>
				<label><input <?php echo ($styles['infomin'] == "N") ? 'checked="checked"' : ''; ?> type="radio" name="styles[infomin]" value="N" id="styles.infomin_N" /> <?php _e('No, keep styling', SATL_PLUGIN_NAME); ?></label>
				<span class="howto"><?php _e('Keep your theme styling for &quot;H5&quot; and &quot;p&quot;? Or minimize them.', SATL_PLUGIN_NAME); ?></span>
			</td>
		</tr>
	</tbody>
</table>