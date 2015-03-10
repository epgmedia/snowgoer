<?php
/*
Plugin Name: Interstitial Ad
Description: Displays an interstitial ad. Frequency is controlled within Doubleclick for Publishers
Author: Christopher Gerber
Author URI: http://www.chriswgerber.com/
Version: 1.0
*/

class epg_interstitial_ads {

	/** @var object|null - Contains ad position data */
	public $positions;

	/** @var string - Stores the URI of the directory */
	public $dir_uri;

	/** @var array - Interstitial Ad Position data */
	public $data = array(
			'ad_name' => '',
			'position_tag' => '',
			'sizes' => [1, 1],
			'out_of_page' => true
		);

	/** @var string|null Name of the ad position */
	public $page_code_id;

    /**
     * PHP5 Constructor
     */
    public function __construct() {
	    // Plugin URI
	    $this->dir_uri      = plugins_url( null, __FILE__ );
	    // Ad Code ID
	    $this->page_code_id = get_option('epg-ad-code-id');
	    // Creates the Setting
	    add_action( 'admin_init', array( $this, 'setting_init' ) );
	    // Enqueues Scripts and Styles
	    add_action( 'wp_enqueue_scripts', array($this, 'scripts_and_styles') );
	    // Adds Styles to head.
	    add_action('wp_head', array($this, 'css_style') );

    }

	/**
	 * Registers Scripts. Localizes data to interstitial_ad.js
	 */
	public function scripts_and_styles() {
		// Preps the script
		wp_register_script(
			'epg_interstitial_ad',
			$this->dir_uri . '/interstitial_ad.js',
			array( 'jquery' ),
			false,
			false
		);

		// Prep the data
		$this->positions = new stdClass;
		$this->positions->roadblock_id = $this->page_code_id;
		$this->data['ad_name']      = $this->page_code_id;
		$this->data['position_tag'] = 'gpt-tag-roadblock-1001';
		$this->positions->positions[]  = $this->data;

		// Get all the ad positions
		$ad_positions = apply_filters('epg_ad_positions', $this->positions);
		// Send data to front end.
		wp_localize_script( 'epg_interstitial_ad', 'ad_positions', array($ad_positions) );
		wp_enqueue_script( 'epg_interstitial_ad' );
	}

	/**
	 * Styles for the popunder ad.
	 */
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

	/**
	 * Registers Settings Field.
	 */
	public function setting_init() {

		// Regular setting. Escapes attributes on display
		register_setting( 'general', 'epg-ad-code-id', 'esc_attr' );

		// Simple Settings field
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

	/**
	 * Settings Callback Function
	 *
	 * @param $args array
	 */
	public function setting_callback($args) {
		?>
		<input name="<?php echo $args['id'] ?>" type="<?php echo $args['type'] ?>" id="<?php echo $args['id'] ?>" value="<?php echo $args['value'] ?>" class="regular-text">
		<?php
	}
}

new epg_interstitial_ads();