<?php
$root = __FILE__;
for ($i = 0; $i < 4; $i++) $root = dirname($root);
require_once($root . '/wp-config.php');
require_once(ABSPATH . 'wp-admin/admin-functions.php');
class SatelliteAjax extends SatellitePlugin {
	var $safecommands = array('slides_order');
	function SatelliteAjax($cmd) {
		$this -> register_plugin('slideshow-satellite', __FILE__);
		if (!empty($cmd)) {		
			if (in_array($cmd, $this -> safecommands) || current_user_can('edit_plugins')) {			
				if (method_exists($this, $cmd)) {
					$this -> $cmd();
				}
			}
		}
	}
	function slides_order() {
		if (!empty($_REQUEST['item'])) {
			foreach ($_REQUEST['item'] as $order => $slide_id) {
				$this -> Slide -> save_field('slide_order', $order, array('id' => $slide_id));
			}
		
			?><br/><div style="color:red;"><?php _e('Slides have been ordered', SATL_PLUGIN_NAME); ?></div><?php
		}
	}
}
$SatelliteAjax = new SatelliteAjax($_GET['cmd']);
?>