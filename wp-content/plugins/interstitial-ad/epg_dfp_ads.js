/** Javascript for Google Ads **/
/* Ad Scripts - Supplied by DoubleClick for Publishers */
var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
(function() {
    var gads = document.createElement('script');
    gads.type = 'text/javascript';
    var useSSL = 'https:' == document.location.protocol;
    gads.src = (useSSL ? 'https:' : 'http:') +
    '//www.googletagservices.com/tag/js/gpt.js';
    var node = document.getElementsByTagName('script')[0];
    node.parentNode.insertBefore(gads, node);
})();

/**
 * Ad Position Creation
 */
googletag.cmd.push(function() {
        // Ad Positions Object
    var dfp_ad_data = epg_ad_positions[0],
        // ID for Roadblock Ad
        roadblock_id = dfp_ad_data.roadblock_id,
        // DFP Account ID
        acct_id = dfp_ad_data.account_id,
        // Function to run when rendering event
        slot_render = (function(event) {
            if (event.isEmpty !== true) {
                var ad_unit = event.slot.getAdUnitPath(),
                    pop_under_id = acct_id + roadblock_id;
                show_interstitial(ad_unit, pop_under_id);
            }
        });
    /**
     * Loads Ad Position
     *
     * @param {Array} positions - Array of ad positions
     */
    function load_ad_positions(positions) {
        for (var ad_pos in positions) {
            define_ad_slot(positions[ad_pos]);
            render_ad_slot(positions[ad_pos]);
        }
    }

    function define_ad_slot(position) {
        googletag.defineSlot(
            acct_id + position.ad_name,
            position.sizes,
            position.position_tag
        ).addService(googletag.pubads());
        if (position.out_of_page === true) {
            googletag.defineOutOfPageSlot(
                acct_id + position.ad_name,
                position.position_tag + '-oop'
            ).addService(googletag.pubads());
        }
    }

    function render_ad_slot(position) {
        if (position.ad_name == roadblock_id) {
            append_interstitial(position.position_tag);
        }
    }
    // Generates Ad Slots
    load_ad_positions(dfp_ad_data.positions);
    // Enable Single Request
    googletag.pubads().enableSingleRequest();
    // Slot Rendering Events
    googletag.pubads().addEventListener('slotRenderEnded', slot_render);
    // Collapse Empty Divs
    googletag.pubads().collapseEmptyDivs(true);
    // Go
    googletag.enableServices();
});

/**
 *
 * @param {String} ad_id
 * @param {String} interstitial_id
 */
function show_interstitial(ad_id, interstitial_id) {
    if (ad_id == interstitial_id) {
        jQuery('.interstitialAd').show();
    }
}

/**
 *
 * @param {String} ad_tag - Div tag for the ad position
 */
function append_interstitial(ad_tag) {
    jQuery('body').ready().prepend('<div class="interstitialAd">' +
        '<div class="close-interstitial">X</div>' +
        '<!-- Roadblock -->' +
        '<div id=' + ad_tag + '>' +
        '<script type="text/javascript">' +
        'googletag.cmd.push(function() { ' +
        'googletag.display("' + ad_tag + '"); });' +
        '</script>' +
        '</div>' +
        '<!-- Roadblock out-of-page -->' +
        '<div id="' + ad_tag + '-oop">' +
        '<script type="text/javascript">' +
        'googletag.cmd.push(function() { ' +
        'googletag.display("' + ad_tag + '-oop"); });' +
        '</script>' +
        '</div>' +
        '</div>'
    );

    var close_overlay = function() {
            jQuery(this).hide();
        };
    var $ad_postition = jQuery('.interstitialAd'),
        $close_button = jQuery('.close-interstitial');

    $ad_postition.on('click', close_overlay);
    $close_button.on('click', close_overlay);
}
