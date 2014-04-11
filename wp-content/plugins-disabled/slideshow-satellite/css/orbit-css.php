<?php 
header("Content-Type: text/css");
$styles = array();
foreach ($_GET as $skey => $sval) :
	$styles[$skey] = urldecode($sval);
endforeach;
IF ($styles['width_temp']) {
	$styles['width'] = $styles['width_temp'];
}
IF ($styles['height_temp']) {
	$styles['height'] = $styles['height_temp'];
}
IF (!$styles['thumbheight']) {
    $styles['thumbheight'] = "75";
}
if ($styles['background'] == '#000000') {
	$loadbg = $styles['background']." url('../images/loading.gif')";
} else {
	$loadbg = $styles['background']." url('../images/spinner.gif')";
}
IF ($styles['navbuttons'] == 0) { $navright = 'url(../images/right-arrow.png) no-repeat 0 0';$navleft = 'url(../images/left-arrow.png) no-repeat 0 0'; }
IF ($styles['navbuttons'] == 1) { $navright = 'url("../pro/images/right-sq.png") no-repeat 30px 0';$navleft = 'url(../pro/images/left-sq.png) no-repeat 0 0'; }
IF ($styles['navbuttons'] == 2) { $navright = 'url(../pro/images/right-rd.png) no-repeat 30px 0';$navleft = 'url(../pro/images/left-rd.png) no-repeat 0 0'; }
IF ($styles['navbuttons'] == 3) { $navright = 'url(../pro/images/right-pl.png) no-repeat 30px 0';$navleft = 'url(../pro/images/left-pl.png) no-repeat 0 0'; }
IF ($styles['nav'] == 'off') { $navright = 'none'; $navleft = 'none'; }

$extrathumbarea = (int) $styles['thumbareamargin'];
$brtopspace = (int) $styles['height'] *.69;
$trtopspace = (int) $styles['height'] *.17;
$sattxtwidth = (int) $styles['width'] *.48;
$arrowpush = (int) $styles['navpush'];
$thumbrow = (int) $styles['thumbspacing'];
IF ($styles['infomin'] == "Y") {
    ?>
    .orbit-caption h5, .orbit-caption p { margin:0 !important; }
<?php } ?>
    
/*** CLEAR CSS ****/
ul.orbit-thumbnails, ul.orbit-thumbnails li, {
    margin: 0;
    padding: 0;
    background:0;
    list-style-type:none;
}

#featured, #featured1, #featured2, #featured3 {
    width: <?php echo $styles['width'] ?>px;
    height: <?php echo $styles['height'] ?>px;
    background:<?php echo($loadbg)?> no-repeat center center;
    overflow: hidden; 
    }
#featured>div, #featured1>div, #featured2>div, #featured3>div { display: none; }

div.orbit-default {
    margin-top:20px;
}
div.orbit-wrapper {
    width: <?php echo $styles['width'] ?>px;
    height: <?php echo $styles['height'] ?>px;
    margin: 0 auto;
    background:<?php echo $styles['background']?>; /* VAR BACKGROUND */
    border:<?php echo $styles['border']; ?>;
    position: relative; }

div.orbit {
    width: 1px;
    height: 1px;
    position: relative;
    overflow: hidden }

div.orbit>img {
    position: absolute;
    top: 0;
    left: 0;
    display: none; }

div.orbit>a {
    border: none;
    position: absolute;
    top: 0;
    left: 0;
    line-height: 0; 
    display: none; }

.orbit>div {
    position: absolute;
    top: 0;
    left: 0;
    width: <?php echo $styles['width'] ?>px;
    height: <?php echo $styles['height'] ?>px; 
    border: 0;
    }
/* Note: If your slider only uses content or anchors, you're going to want to put the width and height declarations on the ".orbit>div" and "div.orbit>a" tags in addition to just the .orbit-wrapper */
/* SPECIAL IMAGES */

div.sorbit-tall, div.sorbit-wide, div.sorbit-basic {
	background:<?php echo $styles['background']?>; /* VAR BACKGROUND */
}
div.sorbit-tall img {
	height: <?php echo $styles['height'] ?>px; /* VAR HEIGHT */
	display:block;
        max-width:100%;}
	
div.sorbit-wide {
	display: table-cell;
        text-align:center;
	vertical-align:middle;
	height: <?php echo $styles['height'] ?>px; /* VAR HEIGHT */
        width: <?php echo $styles['width'] ?>px; 
        }

/**/
div.sorbit-wide img{
	/*width:<?php echo $styles['width'] ?>px;*/ /* VAR Width */
        /*max-width:<?php echo $styles['width'] ?>px;*/ /* VAR Width */
        width:auto;
        height:auto;
	vertical-align:middle;
	display:inline-block;
        }
	
div.sorbit-basic img{
	margin: 0 auto;
	vertical-align:middle;
	display:block;
        max-width:100%;
        }	

a.sorbit-link {
    height: <?php echo $styles['height'] ?>px; /* VAR HEIGHT */
    display: block;
}
/* Don't Change - Positioning */
.absoluteCenter {
 margin:auto;
 position:absolute;
 top:0;
 bottom:0;
 left:0;
 right:0;
}
/* Sizing */
img.absoluteCenter {
 max-height:100%;
 max-width:100%;
}


/* TIMER
   ================================================== */
div.timer {
    width: 30px;
    height: 30px;
    overflow: hidden;
    position: absolute;
    top: -30px;
    right: -4px;
    opacity: .6;
    cursor: pointer;
    display: <?php echo($styles['playshow'] == Y) ? "block" : "none";?>;
    z-index: 100; }

span.rotator {
    display: none;
	/*display:none\9;  ie8 and below hack */
    width: 40px;
    height: 40px;
    position: absolute;
    top: 0;
    left: -20px;
    /*opacity: .6;*/
	/*filter: alpha(opacity=60);	*/
    /*background: url(../images/rotator-black.png) no-repeat;*/
    z-index: 1; 
    /*-moz-transform: <?php echo($styles['autotimer'] == Y) ? "" : "none !important"; ?>;*/
    }
span.mask {
    display: block;
    width: 20px;
    height: 40px;
    position: absolute;
    top: 0;
    right: 0;
    z-index: 2;
    overflow: hidden; }
span.rotator.move {
    left: 0 }
span.mask.move {
    width: 40px;
    left: 0;
    /*background: url(../images/timer-black.png) repeat 0 0; */
    }
span.pause {
    display: block;
    width: 40px;
    height: 40px;
    position: absolute;
    top: 0;
    left: 0;
    background: url(../images/pause-black.png) no-repeat;
    z-index: 4;
    opacity: .5; }
span.pause.active {
    background: url(../images/pause-black.png) no-repeat 0 -40px }
div.timer:hover span.pause,
span.pause.active {
    opacity: 1 }

/* CAPTIONS
   ================================================== */
.orbit-caption {
    display: none;
    font-family: "HelveticaNeue", "Helvetica-Neue", Helvetica, Arial, sans-serif; }
    
.orbit-wrapper .orbit-caption {
    background: rgba(<?php echo(hex2RGB($styles['infobackground'], true)); ?>,.6);
    z-index: 100;
    color: <?php echo $styles['infocolor']; ?>;
    text-align: center;
    font-size: 13px;
    position: absolute;
    right: 0;
    bottom: 0;
    width: 100%; }
@media \0screen {
   .orbit-wrapper .orbit-caption { background:transparent !important; filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000050,endColorstr=#99000050);zoom: 1;   }
}


.orbit-caption h5 {
    color:<?php echo $styles['infocolor']; ?>; 
    padding:4px 8px 3px; 
    font-size:1.4em; 
    font-weight:bold;
    }
.orbit-caption p {
    color: <?php echo $styles['infocolor']; ?>;
    padding-bottom: 7px;
    font-size:.9em;
    font-weight:bold;
}
div.orbit-wrapper .sattext {
    bottom: auto !important;
    height: auto;
    float:right;
    text-align:left;
    position:absolute;
    width:<?php echo($sattxtwidth)?>px;
    background: rgba(<?php echo(hex2RGB($styles['infobackground'], true)); ?>,.6);
    border: 2px solid rgba(<?php echo(hex2RGB($styles['infocolor'], true)); ?>,.6);
    border-right:0px;
    }
div.orbit-wrapper .sattextBR {
    top: <?php echo ($brtopspace)?>px;    
}
div.orbit-wrapper .sattextTR {
    top: <?php echo ($trtopspace)?>px;    
}
a.sorbit-link:hover {
    text-decoration:none;}
    
div.sattext p { color:<?php echo $styles['infocolor']; ?>; padding:0 8px 3px;}
div.sattext h5 {
    color:<?php echo $styles['infocolor']; ?>; 
    padding:4px 8px 3px; 
    font-size:1.2em; 
    }
    
.orbit-default .thumb-on {
    margin-bottom: <?php echo ((int) $styles['thumbheight'] + $styles['thumbspacing'] + $styles['thumbspacing'] +5); ?>px; 
}
.orbit-default.default-thumbs .orbit-wrapper {
    height: <?php echo ((int) $styles['height'] + $styles['thumbheight'] + $styles['thumbspacing'] + $styles['thumbspacing'] + $styles['thumbmargin'] + 5); ?>px;
}

/* DIRECTIONAL NAV
   ================================================== */
div.slider-nav {
    display: block }
div.slider-nav span {
    width: 78px;
    height: 100px;
    text-indent: -9999px;
    position: absolute;
    z-index: 100;
    top: 50%;
    margin-top: -<?php echo($styles['thumbheight']);?>px;
    cursor: pointer; }
div.slider-nav span.right {
    background: <?php echo($navright); ?>;
	/*background: background: url(../images/right-arrow.png) no-repeat 0 0*/
    right: 0;
    <?php if ($arrowpush > 0) ?>
        margin-right: -<?php echo((int)$arrowpush); ?>px;
    }
div.slider-nav span.left {
    background: <?php echo($navleft); ?>;
    left: 0; 
    <?php if ($arrowpush > 0) ?>
        margin-left: -<?php echo((int)$arrowpush); ?>px;
    }

/* BULLET NAV
   ================================================== */
ul.orbit-bullets {
    display: block;
    height: 12px;
    position: relative;
}
.orbit-bullets {
    position: absolute;
    z-index: 100;
    list-style: none;
/*    left: 50%;
    margin-left: -50px;*/
    padding: 0 0 0 15px; }

.orbit-bullets li, .orbit-thumbnails li {
    float: left;
    margin: <?php echo ((int) $styles['thumbspacing']) ?>px;
    cursor: pointer;
    color: #999;
/*    text-indent: -9999px;
    background: url(../images/bullets.jpg) no-repeat 4px 0;*/
    overflow: hidden; }

/* THUMBNAIL NAV
   ================================================== */

ul.orbit-thumbnails {
    height:auto;
    margin: 5px auto;
    list-style-type:none
}
.thumbholder {
    width: <?php echo (int) ($styles['width'] - 40) ?>px; /* 40px for the #slideleft and #slideright*/
    overflow:hidden;
    margin: <?php echo $styles['thumbmargin']; ?>px auto 0 auto;
}
    
.orbit-thumbnails li {
    width: <?php echo($styles['thumbheight']);?>px;
    height: <?php echo($styles['thumbheight']);?>px;
    -moz-border-radius:4px;
    -webkit-border-radius:4px;
    border: 2px solid <?php echo($styles['background'])?>;
    border-radius:4px;
    background: none !important;
    padding: 0 !important;
    opacity: .<?php echo($styles['thumbopacity']);?>;
    overflow:hidden;
    margin: <?php echo( (int) ($styles['thumbspacing']-2));?>px;
}
.orbit-thumbnails li img {
    max-width:100%;
}
.orbit-thumbnails li:hover {
    opacity: 1;
}
.orbit-thumbnails li.active {
    border: 2px solid <?php echo($styles['thumbactive']);?>;
    margin: <?php echo( (int) ($styles['thumbspacing']-2));?>px;
    opacity: 1;
}

.orbit-bullets li.active {
    color: #222;
    background-position: -8px 0; }
#slideleft, #slideright {
    text-indent: -9999px;
    height:<?php echo ((int) $styles['thumbheight']); ?>px;
    margin-top:-<?php echo ((int) $styles['thumbheight'] + 5); ?>px;
}
#slideleft { float:left; width:20px; 
    background:url('../images/scroll-left.gif') center center no-repeat; 
    background-color:<?php echo $styles['background']; ?>;
    position:relative;
    z-index:100;
}
#slideleft:hover { background-color:#666; }
#slideright { float:right; width:20px; 
    background:<?php echo $styles['background']; ?> url('../images/scroll-right.gif') center center no-repeat; }
#slideright:hover { background-color:#666; }

/****************************************
/**** FULL RIGHT & LEFT SECTIONS ***/
    
.full-right, .full-left {
    width:<?php echo ((int)($styles['thumbarea'] + $styles['width'] + $extrathumbarea ) ); ?>px;
    clear:both;
    margin-top:20px;
}
.full-right .orbit-wrapper, .full-left .orbit-wrapper {
    margin: 0 !important;
    width:<?php echo ((int)($styles['thumbarea'] + $styles['width'] + $extrathumbarea )); ?>px !important;
    height:<?php echo ($styles['height']); ?>px !important;
}
.full-right .orbit-thumbnails li, .full-left .orbit-thumbnails li {
    height:<?php echo ((int) $styles['thumbheight']); ?>px;
    width:<?php echo ((int) $styles['thumbheight']); ?>px;
    margin:<?php echo ((int) $styles['thumbspacing'] -2) ?>px;
}
.full-right .orbit-thumbnails, .full-left .orbit-thumbnails {
    margin: 0 !important;
    left:0;
    width:<?php echo ((int)($styles['thumbarea'])); ?>px !important;
    position:relative;
}
.full-right .orbit-thumbnails {
    float: right;
}
.full-left .orbit-thumbnails {
    float: left;
}
.full-right div.sorbit-wide img, .full-left div.sorbit-wide img {
/*    margin-top: <?php echo ((int)($styles['thumbspacing'])); ?>px;*/
}
.full-left .orbit {
    float:right;
}
.full-right .orbit {
    float:left;
}
.full-right .thumbholder, .full-left .thumbholder {
    width: <?php echo (int)($styles['thumbarea']); ?>px;
    }
.full-right .thumbholder {
    margin-left: <?php echo ($extrathumbarea );?>px;
    float:left;
    left:0;
}
.full-left .thumbholder {
    margin-right: <?php echo ($extrathumbarea );?>px;
    float:right;
    right:0;
}
div.full-right .orbit-wrapper div.timer {
    right:<?php echo ((int)($styles['thumbarea'] + $extrathumbarea )); ?>px;
}
.full-right div.orbit-caption {
    width:<?php echo ((int) ($styles['width'])) ?>px;
    right:<?php echo ((int)($styles['thumbarea'] + $extrathumbarea)); ?>px;
}
.full-left div.orbit-caption {
    width:<?php echo ((int) ($styles['width'])) ?>px;
    left:<?php echo ((int)($styles['thumbarea'] + $extrathumbarea)); ?>px;
}
.full-left div.sattext {
    left: auto;
}
.full-left div.sattext, .full-right div.sattext {
    width:<?php echo ($sattxtwidth) ?>px; 
}
.full-right .slider-nav span.right {
    right:<?php echo ((int)($styles['thumbarea'] + $extrathumbarea)); ?>px
}
.full-left .slider-nav span.left {
    left:<?php echo ((int)($styles['thumbarea'] + $extrathumbarea)); ?>px
}
.full-right div.orbit-wrapper, .full-left div.orbit-wrapper {
    border:0;
}
.full-right #slideleft, .full-right #slideright, .full-left #slideleft, .full-left #slideright {
    display:none;
}
.orbit-thumbnails li.has-thumb {
    background: none;

li > li.has-thumb {
    width: auto; 
    height: <?php echo($styles['thumbheight']); ?> }
}

.orbit-thumbnails li.active.has-thumb {
    background-position: 0 0;
    border-top: 2px solid #000; }	

<?php

/**
 * Convert a hexa decimal color code to its RGB equivalent
 *
 * @param string $hexStr (hexadecimal color value)
 * @param boolean $returnAsString (if set true, returns the value separated by the separator character. Otherwise returns associative array)
 * @param string $seperator (to separate RGB values. Applicable only if second parameter is true.)
 * @return array or string (depending on second parameter. Returns False if invalid hex color value)
 */                                                                                                
function hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
    $rgbArray = array();
    if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
        $colorVal = hexdec($hexStr);
        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
        $rgbArray['blue'] = 0xFF & $colorVal;
    } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
        $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
        $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
        $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
    } else {
        return false; //Invalid hex color code
    }
    return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
} ?>