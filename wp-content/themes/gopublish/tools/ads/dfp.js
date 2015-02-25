/**
 * Ad Positions
 */

    var googletag = googletag || {};
    googletag.cmd = googletag.cmd || [];
    (function() {
        var gads = document.createElement('script');
        gads.async = true;
        gads.type = 'text/javascript';
        var useSSL = 'https:' == document.location.protocol;
        gads.src = (useSSL ? 'https:' : 'http:') +
        '//www.googletagservices.com/tag/js/gpt.js';
        var node = document.getElementsByTagName('script')[0];
        node.parentNode.insertBefore(gads, node);
    })();

    googletag.cmd.push(function() {
        /*
         * acct_id   = DFP account ID
         * ad_div_id = ROS div ID
         */
        var acct_id = '/35190362/';

        function load_ad_positions( positions ) {

            for ( var ad_pos in positions ) {

                googletag.defineSlot(
                    acct_id + positions[ad_pos].ad_name,
                    positions[ad_pos].sizes,
                    positions[ad_pos].position_tag
                ).addService(googletag.pubads());


                if ( positions[ad_pos].out_of_page === true ) {

                    googletag.defineOutOfPageSlot(
                        acct_id + positions[ad_pos].ad_name,
                        positions[ad_pos].position_tag + '-oop'
                    ).addService(googletag.pubads());

                }
            }

        }

        var ad_positions = ad_data;

        load_ad_positions(ad_positions);

        googletag.pubads().collapseEmptyDivs(true);
        googletag.enableServices();
    });