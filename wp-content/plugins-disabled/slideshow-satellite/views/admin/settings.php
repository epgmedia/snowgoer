<?php
global $post, $post_ID;
$post_ID = 1;
wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false);
wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false);
?>
<div class="wrap">
    
        <img src="<?php echo(SATL_PLUGIN_URL.'/images/Satellite-Logo-sm.png');?>" style="height:100px" />
        
	<h2><?php _e('Configuration Settings', SATL_PLUGIN_NAME); ?></h2>
	
	<form action="<?php echo $this -> url; ?>" name="post" id="post" method="post">
		<div id="poststuff" class="metabox-holder has-right-sidebar">			
			<div id="side-info-column" class="inner-sidebar">		
				<?php do_action('submitpage_box'); ?>	
				<?php do_meta_boxes($this -> menus['satellite'], 'side', $post); ?>
                <?php do_action('submitpage_box'); ?>
				<div id="submitdiv" class="postbox">
                                     <?php if(SATL_PRO) {?>
                	<h3>Thank you plugin supporter!</h3>
                                        <?php $satellitebtn = "Get Support";?>
                                        <?php } else { ?>
                	<h3>Slideshow Satellite Premium!</h3>
                                        <?php $satellitebtn = "Learn More & Get it";?>
                                     <?php } ?>
                    <div class="inside">
                        <div id="minor-publishing">
                            <div id="misc-publishing-actions" class="preminfo">
                                <h4>What's different on the Premium Edition?</h4>
                                <p>Display multiple slideshows in a page</p>
                                <p>Customize height and width per use</p>
                                <p>Have multiple custom slideshows</p>
                                <p>Have multiple arrow options</p>
                                <p>Keyboard navigation</p>
				<p>And more!</p>
                            </div>
                        </div>
                        <div id="major-publishing-actions">
                            <div id="publishing-action">
                                <a href="http://c-pr.es/projects/satellite" class="button-primary" target="_blank"><?php echo($satellitebtn); ?></a>
                            </div>
                            <br class="clear" />
                        </div>
                    </div>
                </div>
           
			</div>
			<div id="post-body">
				<div id="post-body-content">
					<?php do_meta_boxes($this -> menus['satellite'], 'normal', $post); ?>
				</div>
			</div>
			<div id="side-info-column" class="inner-sidebar inner2">		
				<?php do_meta_boxes($this -> menus['satellite'], 'side', $post); ?>
                <?php do_action('submitpage_box'); ?>
			</div>
			<br class="clear" />
			
		</div>
	</form>
        <h4><?php _e('Current Satellite Version:', SATL_PLUGIN_NAME); ?><?php echo($this->get_option('db_version'));?> </h4>
</div>