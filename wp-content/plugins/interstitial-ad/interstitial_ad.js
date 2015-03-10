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

// Full Ad Object - Have to send as array, but would prefer to use an object
var dfp_ad_data = ad_positions[0];
console.log(dfp_ad_data);
/**
 * Ad Positions
 */
googletag.cmd.push(function() {
    // Loads the Ad Positions
    load_ad_positions(dfp_ad_data);
    // Slot Rendering events

    googletag.pubads().enableSingleRequest();
    googletag.pubads()
        .addEventListener(
        'slotRenderEnded',
        (function(event) {
            var ad_unit = event.slot.getAdUnitPath();
            if (
                ad_unit == (dfp_ad_data.account_id + dfp_ad_data.roadblock_id) &&
                event.isEmpty !== true
            ) {
                console.log(ad_unit);
                console.log(event);
                show_interstitial();
            }
        })
    );
    googletag.pubads().collapseEmptyDivs(true);
    // Go
    googletag.enableServices();
});

/**
 * Loads Ad Position
 *
 * @param {Array} dfp_ad_data - Array of ad positions
 */
function load_ad_positions(dfp_ad_data) {
    var positions = dfp_ad_data.positions,
        acct_id = dfp_ad_data.account_id,
        roadblock_id = dfp_ad_data.roadblock_id;

    for (var ad_pos in positions) {
        googletag.defineSlot(
            acct_id + positions[ad_pos].ad_name,
            positions[ad_pos].sizes,
            positions[ad_pos].position_tag
        ).addService(googletag.pubads());
        if (positions[ad_pos].out_of_page === true) {
            googletag.defineOutOfPageSlot(
                acct_id + positions[ad_pos].ad_name,
                positions[ad_pos].position_tag + '-oop'
            ).addService(googletag.pubads());
        }
        if (positions[ad_pos].ad_name == roadblock_id) {
            create_interstitial(positions[ad_pos].position_tag);
        }
    }
}

/**
 * If Slot is rendered, show it.
 */
function show_interstitial() {
    jQuery('.interstitialAd').show();
}

/**
 * Interstitial Ad Javascript
 *
 * @param {String} ad_tag - Div tag for the ad position
 */
function create_interstitial(ad_tag) {
    append_interstitial(ad_tag);
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
        'googletag.cmd.push(function() { googletag.display("' + ad_tag + '"); });' +
        '</script>' +
        '</div>' +
        '<!-- Roadblock out-of-page -->' +
        '<div id="' + ad_tag + '-oop">' +
        '<script type="text/javascript">' +
        'googletag.cmd.push(function() { googletag.display("' + ad_tag + '-oop"); });' +
        '</script>' +
        '</div>' +
        '</div>'
    );

    var close_overlay = function() {
        jQuery(this).hide();
    };

    $ad_postition = jQuery('.interstitialAd');
    $close_button = jQuery('.close-interstitial');

    $ad_postition.on('click', close_overlay);
    $close_button.on('click', close_overlay);
}