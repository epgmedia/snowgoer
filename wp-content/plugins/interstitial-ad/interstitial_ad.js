
// Ad Scripts
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

/** Interstitial Ad Javascript **/

googletag.cmd.push( function() {
    googletag.defineSlot( popunder_ad_data.ad_position, [1, 1], popunder_ad_data.position_tag ).addService( googletag.pubads() );
    googletag.defineOutOfPageSlot( popunder_ad_data.ad_position, popunder_ad_data.position_tag + '-oop' ).addService( googletag.pubads() );

    googletag.pubads().addEventListener('slotRenderEnded', function(event) {
        var f_slot = event.slot.i;
        console.log(event.slot);
        if ( ( f_slot === popunder_ad_data.ad_position) && !event.isEmpty ) {
            jQuery( '.interstitialAd' ).show();
        }
    });
    googletag.enableServices();
});

jQuery('body').ready( function( $ ) {

    $('body').prepend(
        '<div class="interstitialAd">' +
            '<div class="close-interstitial">X</div>' +
            '<!-- Roadblock -->' +
            '<div id=' + popunder_ad_data.position_tag + '>' +
                '<script type="text/javascript">' +
                    'googletag.cmd.push(function() { googletag.display("' + popunder_ad_data.position_tag + '"); });' +
                '</script>' +
            '</div>' +
            '<!-- Roadblock out-of-page -->' +
            '<div id="' + popunder_ad_data.position_tag + '-oop">' +
                '<script type="text/javascript">' +
                    'googletag.cmd.push(function() { googletag.display("' + popunder_ad_data.position_tag + '-oop"); });' +
                '</script>' +
            '</div>' +
        '</div>');

    var close_overlay = function() {
        $(this).hide();
    };

    $ad_postition = $('.interstitialAd');
    $close_button = $('.close-interstitial');

	$ad_postition.on("click", close_overlay);
	$close_button.on("click", close_overlay);

});