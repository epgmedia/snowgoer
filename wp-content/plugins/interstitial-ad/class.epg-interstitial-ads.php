<?php
/*
Plugin Name: Interstitial Ad
Description: Displays an interstitial ad. Frequency is controlled within Doubleclick for Publishers
Author: Christopher Gerber
Author URI: http://www.chriswgerber.com/
Version: 1.0
*/

class epg_interstitial_ads {

	public $dir_uri;

    /** Variables */
	public $data = array();

	public $page_code_id = '';

    /**
     * Constructor
     */
    public function __construct() {
	    // Plugin URI
	    $this->dir_uri      = plugins_url( null, __FILE__ );

	    // Ad Code ID
	    $this->page_code_id = get_option('epg-ad-code-id');

	    // Ad Position to Enqueue
	    $this->data['ad_position'] = '/35190362/' . $this->page_code_id;
	    $this->data['position_tag'] = 'gpt-tag-roadblock-1111';

	    add_action( 'admin_init', array( $this, 'setting_init' ) );
	    add_action( 'wp_enqueue_scripts', array($this, 'scripts_and_styles') );

	    add_action('wp_head', array($this, 'css_style') );

    }

	public function scripts_and_styles() {

		wp_register_script(
			'epg_interstitial_ad',
			$this->dir_uri . '/interstitial_ad.js',
			array( 'jquery' ),
			false,
			false
		);

		wp_localize_script( 'epg_interstitial_ad', 'popunder_ad_data', $this->data );
		wp_enqueue_script( 'epg_interstitial_ad' );

	}

	public function css_style() {
		?>
		<style type="text/css">

		.interstitialAd {
			display: none;
			z-index: 10000;
			width: 100%;
			height: 100%;
			background-color: rgba( 0, 0, 0, 0.70);
			color: #000000;
			margin: auto;
			padding: 0;
			position: fixed;
			top: 0;
			left: 0;
			text-align: center;
			alignment-baseline: central;
		}

		.interstitialAd #<?php echo $this->data['position_tag']; ?> {
			z-index: 10001;
			display: block !important;
			margin: 15% 25%;
			position: relative;
		}

		.interstitialAd #<?php echo $this->data['position_tag']; ?> iframe {
			-webkit-box-shadow: 0px 0px 30px 0px rgba(0, 0, 0, 0.9);
			-moz-box-shadow:    0px 0px 30px 0px rgba(0, 0, 0, 0.9);
			box-shadow:         0px 0px 30px 0px rgba(0, 0, 0, 0.9);
		}

		.close-interstitial {

			cursor: pointer;
			position: absolute;
			right: 0.5em;
			top: 0.5em;

			-moz-box-shadow:inset 0px 1px 0px 0px #ffffff;
			-webkit-box-shadow:inset 0px 1px 0px 0px #ffffff;
			box-shadow:inset 0px 1px 0px 0px #ffffff;
			background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ededed), color-stop(1, #dfdfdf) );
			background:-moz-linear-gradient( center top, #ededed 5%, #dfdfdf 100% );
			filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ededed', endColorstr='#dfdfdf');
			background-color:#ededed;
			-webkit-border-top-left-radius:20px;
			-moz-border-radius-topleft:20px;
			border-top-left-radius:20px;
			-webkit-border-top-right-radius:20px;
			-moz-border-radius-topright:20px;
			border-top-right-radius:20px;
			-webkit-border-bottom-right-radius:20px;
			-moz-border-radius-bottomright:20px;
			border-bottom-right-radius:20px;
			-webkit-border-bottom-left-radius:20px;
			-moz-border-radius-bottomleft:20px;
			border-bottom-left-radius:20px;
			text-indent:0;
			border:1px solid #dcdcdc;
			display:inline-block;
			color:#777777;
			font-family: Verdana;
			font-size:24px;
			font-weight:normal;
			font-style:normal;
			height:50px;
			line-height:50px;
			width:50px;
			text-decoration:none;
			text-align:center;
			text-shadow:1px 1px 0px #ffffff;
		}

		.close-interstitial:hover {
			background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #dfdfdf), color-stop(1, #ededed) );
			background:-moz-linear-gradient( center top, #dfdfdf 5%, #ededed 100% );
			filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#dfdfdf', endColorstr='#ededed');
			background-color:#dfdfdf;
		}

		/* This button was generated using CSSButtonGenerator.com */

		</style>
		<?php
	}

	public function setting_init() {

		register_setting( 'general', 'epg-ad-code-id', 'esc_attr' );

		add_settings_field(
			'epg-ad-code-id',
			'Interstitial Ad Position ID',
			array( $this, 'setting_callback' ),
			'general',
			'default',
			array(
				'label_for' => 'epg-ad-code-id',
			    'id' => 'epg-ad-code-id',
			    'type' => 'text',
			    'value' => $this->page_code_id,
			)
		);

	}

	public function setting_callback($args) {
		?>
		<input name="<?php echo $args['id'] ?>" type="<?php echo $args['type'] ?>" id="<?php echo $args['id'] ?>" value="<?php echo $args['value'] ?>" class="regular-text">
		<?php
	}
}

new epg_interstitial_ads();
