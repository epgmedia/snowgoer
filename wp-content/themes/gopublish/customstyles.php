<style type="text/css" media="screen">
#pagetop {height:<?php echo get_theme_mod('wrap-margin'); ?>!important;}
<?php if (get_theme_mod('leaderboard-background-on')=="Transparent") { ?>
#leaderboard {background:none!important}
<?php } else { ?>
#leaderboard {background-color:<?php echo get_theme_mod('leaderboard-background'); ?>!important;}
<?php } ?>
<?php if (get_theme_mod('leaderboard-background-on-footer')=="Transparent") { ?>
#leaderboardfooter {background:none!important}
<?php } else { ?>
#leaderboardfooter {background-color:<?php echo get_theme_mod('leaderboard-background-footer'); ?>!important;}
<?php } ?>
#breakingnews {background-color:<?php echo get_theme_mod('breakingnews-color'); ?>!important; color:<?php echo get_theme_mod('breakingnews-text'); ?>!important;}
#breakingnews a { color: <?php echo get_theme_mod('breakingnews-text'); ?> !important; }
.breakingnewsheadline { color: <?php echo get_theme_mod('breakingnews-text'); ?> !important; }
#breakingnews, #navbar {border-bottom: 1px solid <?php echo get_theme_mod('navbar-borders'); ?> !important;}
#navbar {border-top: 1px solid <?php echo get_theme_mod('navbar-borders'); ?> !important;}
a, a:visited { color: <?php echo get_theme_mod('accentcolor-links'); ?>; }
a:hover { color: <?php echo get_theme_mod('accentcolor-links'); ?>; }
a h3.homeheadline, a.homeheadline { color: <?php echo get_theme_mod('accentcolor-headlines'); ?>!important; }
a:hover h3.homeheadline { color: <?php echo get_theme_mod('accentcolor-headlines'); ?>!important; text-decoration:underline!important; }
a:hover p.viewall, a:hover p.sectionhead {text-decoration: underline;}
body { background<?php if (get_theme_mod('background')=="On") { ?>-color<?php } ?>: <?php echo get_theme_mod('accentcolor-header'); ?>  !important;}
#footer { background-color: <?php echo get_theme_mod('accentcolor-header'); ?> !important; border-top:5px solid <?php echo get_theme_mod('footerborder'); ?> !important;}
#header, #headerleft { height:<?php echo get_theme_mod('header-height'); ?>px!important}
#header h1, #header p { color: <?php echo get_theme_mod('accentcolor-header-text'); ?> !important; }
#navbar, #navbar a, #nav li li a, #nav li li a:link, #nav li li a:visited { background-color: <?php echo get_theme_mod('accentcolor1') ?> !important; color: <?php echo get_theme_mod('accentcolor1-text'); ?> !important; }
#navbar a:hover, #nav li li a:hover, #nav li li a:active { background-color: <?php echo get_theme_mod('accentcolor2') ?> !important; color: <?php echo get_theme_mod('accentcolor2-text'); ?> !important; }
#subnavbar { background-color: <?php echo get_theme_mod('accentcolor2'); ?> !important; color: <?php echo get_theme_mod('accentcolor2-text'); ?> !important;  }
#subnav a { background-color: <?php echo get_theme_mod('accentcolor2'); ?> !important; color: <?php echo get_theme_mod('accentcolor2-text'); ?> !important;  }
.subnavbarright a {color: <?php echo get_theme_mod('accentcolor2-text'); ?> !important;  }
#subnav a:hover { background-color: <?php echo get_theme_mod('accentcolor1'); ?> !important; color: <?php echo get_theme_mod('accentcolor1-text'); ?> !important; }
#subnav li li a, #subnav li li a:link, #subnav li li a:visited { background-color: <?php echo get_theme_mod('accentcolor2'); ?> !important; color: <?php echo get_theme_mod('accentcolor2-text'); ?> !important;  }
#subnav li li a:hover, #subnav li li a:active { color: <?php echo get_theme_mod('accentcolor1-text'); ?> !important;  background-color: <?php echo get_theme_mod('accentcolor1'); ?> !important; }
.teasergrade { color: <?php echo get_theme_mod('accentcolor-links'); ?> !important; }
#content h5 { color: <?php echo get_theme_mod('accentcolor1'); ?> !important; }
table.stats th:hover { color:<?php echo get_theme_mod('accentcolor1'); ?> !important; }
.teasertitle { color:<?php echo get_theme_mod('accentcolor-links'); ?> !important; }
#pscroller3 a { color: <?php echo get_theme_mod('accentcolor-links'); ?> !important; }
.newsticker-jcarousellite .sportsscore span.cat{ color:<?php echo get_theme_mod('accentcolor-links'); ?> !important; }

<?php if (get_theme_mod('header-background') == "Gradient") { ?>
#header {background-color: <?php echo get_theme_mod('accentcolor-header2'); ?> !important;}
<?php } else if (get_theme_mod('header-background') == "Color") { ?>
#header {background: <?php echo get_theme_mod('accentcolor-header2'); ?> !important;}
<?php } else if (get_theme_mod('header-background') == "Transparent") { ?>
#header {background-image:none!important;background-color:none!important;}
<?php } ?>

.headerleft a { color: <?php echo get_theme_mod('accentcolor-header-text'); ?> !important; }
#footer p, #footer a { color: <?php echo get_theme_mod('footer-text'); ?> !important; }
#tagline li li a, #tagline li li a:link, #tagline li li a:visited{ background: <?php echo get_theme_mod('accentcolor2'); ?> !important; color: <?php echo get_theme_mod('accentcolor2-text'); ?> !important;  }
#tagline a:hover, #tagline li a:hover { background: <?php echo get_theme_mod('accentcolor2'); ?> !important; color: <?php echo get_theme_mod('accentcolor2-text'); ?> !important;  }
#tagline li li a:hover, #tagline li li a:active { background: <?php echo get_theme_mod('accentcolor1'); ?> !important; color: <?php echo get_theme_mod('accentcolor1-text'); ?> !important; }
.wp-polls .pollbar { background: <?php echo get_theme_mod('accentcolor2'); ?>;border: 1px solid <?php echo get_theme_mod('accentcolor2'); ?>; }
<?php if (get_theme_mod('postareaborder')=="On") { ?>
.postarea { border: 1px solid <?php echo get_theme_mod('accentcolor2'); ?> !important; }
<?php } else { ?>
.postarea { border: none !important; }
<?php } ?>
h3.gform_title { background: <?php echo get_theme_mod('accentcolor1'); ?> !important; padding-left:7px !important;}

.innerwrap { background: <?php echo get_theme_mod('innerbackground'); ?> !important; background-image:none !important; }

<?php if (get_theme_mod('bullet-point')!="") { ?>
.homebottomleft ul li, #homepageright ul li, #homepageleft ul li, #homepagewide ul li, #contentleft ul li, #sidebar ul li, #sidebar ul li li, #sidebar ul li ul li {background:url(<?php echo get_theme_mod('bullet-point'); ?>) no-repeat 0px 2px;}

<?php } ?>

<?php if (get_theme_mod('background')=="Pattern") {?>
body {background: url(<?php echo get_theme_mod('background-pattern'); ?>) <?php if (get_theme_mod('background-tile')=="No") { echo 'no-'; } ?>repeat !important;background-color:<?php echo get_theme_mod('accentcolor-header'); ?>!important;}

	<?php if (get_theme_mod('header-background')=="Transparent") { ?>
	#header {background-color:none!important;background-image:none!important;background:none!important;}
	<?php } ?>

#footer {background-color:none!important;background-image:none!important;background:none!important;}
<?php } ?>
/* widget header styles for SNO widgets */

h4.widget1 { background: <?php echo get_theme_mod('widgetcolor4'); ?> url(<?php bloginfo('template_url'); ?>/images/navbg.png) repeat-x !important; background-color: <?php echo get_theme_mod('widgetcolor1'); ?> !important; color: <?php echo get_theme_mod('widgetcolor1-text'); ?> !important; border-left:<?php echo get_theme_mod('widget1-thickness'); ?> solid <?php echo get_theme_mod('widgetborder1'); ?> !important; border-right:<?php echo get_theme_mod('widget1-thickness'); ?> solid <?php echo get_theme_mod('widgetborder1'); ?> !important; border-top:<?php echo get_theme_mod('widget1-thickness'); ?> solid <?php echo get_theme_mod('widgetborder1'); ?> !important; font-weight:normal !important; padding-left:10px !important; font-size:17px !important;line-height:26px !important;  margin:0px !important;}
h4.widget1 a { color: <?php echo get_theme_mod('widgetcolor1-text'); ?> !important; }

h4.widget2 { background: <?php echo get_theme_mod('widgetcolor4'); ?> url(<?php bloginfo('template_url'); ?>/images/navbg.png) repeat-x !important; background-color: <?php echo get_theme_mod('widgetcolor2'); ?> !important; color: <?php echo get_theme_mod('widgetcolor2-text'); ?> !important; padding-left:10px !important; font-size:17px !important;line-height:26px !important; margin:0px !important; font-weight:normal !important; }
h4.widget2 a { color: <?php echo get_theme_mod('widgetcolor2-text'); ?> !important; }

h4.widget3, .adheader { background: <?php echo get_theme_mod('widgetcolor4'); ?> url(<?php bloginfo('template_url'); ?>/images/navbg.png) repeat-x !important; background-color: <?php echo get_theme_mod('widgetcolor3'); ?> !important; color: <?php echo get_theme_mod('widgetcolor3-text'); ?> !important; text-transform:uppercase !important; font-size: 10px !important; padding-top:0px !important; text-align:center !important; line-height:15px !important; margin:0px !important; font-weight:normal !important; }
h4.widget3 a { color: <?php echo get_theme_mod('widgetcolor3-text'); ?> !important; }

h4.widget4 { text-transform:uppercase; font-size:12px; background: <?php echo get_theme_mod('widgetcolor4'); ?> url(<?php bloginfo('template_url'); ?>/images/navbg.png) repeat-x !important; color: <?php echo get_theme_mod('widgetcolor4-text'); ?> !important; line-height: 26px!important; font-weight:normal!important;padding:0px 10px !important;}
h4.widget4 a { color: <?php echo get_theme_mod('widgetcolor4-text'); ?> !important; }

h4.widget5 { background-image:none!important; border-top: 10px solid <?php echo get_theme_mod('widgetcolor5'); ?>;background-color: <?php echo get_theme_mod('widgetbackground5'); ?> !important; color: <?php echo get_theme_mod('widgetcolor5-text'); ?> !important; padding-left:10px !important;font-size:17px !important; line-height: 26px!important; font-weight:bold!important;}
h4.widget5 a { color: <?php echo get_theme_mod('widgetcolor5-text'); ?> !important; }

h4.widget6 { background: <?php echo get_theme_mod('widgetcolor4'); ?> url(<?php bloginfo('template_url'); ?>/images/navbg.png) repeat-x !important; border: <?php echo get_theme_mod('widget6-thickness'); ?> solid <?php echo get_theme_mod('widgetborder6'); ?> !important; background-color: <?php echo get_theme_mod('widgetcolor6'); ?> !important; color: <?php echo get_theme_mod('widgetcolor6-text'); ?> !important; padding-left:10px !important;font-size:17px !important; line-height: 26px!important; font-weight:normal!important; }
h4.widget6 a { color: <?php echo get_theme_mod('widgetcolor6-text'); ?> !important; }

h4.widget7 { color:<?php echo get_theme_mod('widgetcolor7-text'); ?> !important ;background:<?php echo get_theme_mod('widgetcolor7'); ?> !important ;border-bottom:<?php echo get_theme_mod('widget7-thickness'); ?> solid <?php echo get_theme_mod('widgetborder7'); ?> !important; padding-left:10px !important;font-size:17px !important; line-height: 26px!important; font-weight:normal!important;  }
h4.widget7 a { color: <?php echo get_theme_mod('widgetcolor7-text'); ?> !important; }

/* widget body styles for SNO widgets */

.widgetbody1 { border-left: <?php echo get_theme_mod('widget1-thickness'); ?> solid <?php echo get_theme_mod('widgetborder1'); ?>; border-right: <?php echo get_theme_mod('widget1-thickness'); ?> solid <?php echo get_theme_mod('widgetborder1'); ?>; border-bottom: <?php echo get_theme_mod('widget1-thickness'); ?> solid <?php echo get_theme_mod('widgetborder1'); ?>; background-color: <?php echo get_theme_mod('widgetbackground1'); ?>; margin-bottom:10px; padding:10px;overflow:hidden;}

.widgetbody2 { border-left: <?php echo get_theme_mod('widget2-thickness'); ?> solid <?php echo get_theme_mod('widgetborder2'); ?>; border-right: <?php echo get_theme_mod('widget2-thickness'); ?> solid <?php echo get_theme_mod('widgetborder2'); ?>; border-bottom: <?php echo get_theme_mod('widget2-thickness'); ?> solid <?php echo get_theme_mod('widgetborder2'); ?>; background-color: <?php echo get_theme_mod('widgetbackground2'); ?>; margin-bottom:10px; padding:10px;overflow:hidden;}

.widgetbody3 { border-right: <?php echo get_theme_mod('widget3-thickness'); ?> solid <?php echo get_theme_mod('widgetborder3'); ?>; border-left: <?php echo get_theme_mod('widget3-thickness'); ?> solid <?php echo get_theme_mod('widgetborder3'); ?>; background-color: <?php echo get_theme_mod('widgetbackground3'); ?>; padding:10px;overflow:hidden;}

.widgetfooter3 { background: <?php echo get_theme_mod('widgetcolor3'); ?> url(<?php bloginfo('template_url'); ?>/images/navbg.png) repeat-x !important; margin-bottom:10px; height:15px;width:100%;display:block;background-color: <?php echo get_theme_mod('widgetcolor3'); ?>;}

.widgetbody4 { border-left: <?php echo get_theme_mod('widget4-thickness'); ?> solid <?php echo get_theme_mod('widgetborder4'); ?>; border-right: <?php echo get_theme_mod('widget4-thickness'); ?> solid <?php echo get_theme_mod('widgetborder4'); ?>; border-bottom: <?php echo get_theme_mod('widget4-thickness'); ?> solid <?php echo get_theme_mod('widgetborder4'); ?>; background-color: #ffffff; margin-bottom:10px; padding:10px; clear:both;overflow:hidden;}

.widgetbody5 { border-bottom: <?php echo get_theme_mod('widget5-thickness'); ?> solid <?php echo get_theme_mod('widgetborder5'); ?>; background-color: <?php echo get_theme_mod('widgetbackground5'); ?>; margin-bottom:10px; padding:10px;overflow:hidden;}

.widgetbody6 { border-left: <?php echo get_theme_mod('widget6-thickness'); ?> solid <?php echo get_theme_mod('widgetborder6'); ?>; border-right: <?php echo get_theme_mod('widget6-thickness'); ?> solid <?php echo get_theme_mod('widgetborder6'); ?>; border-bottom: <?php echo get_theme_mod('widget6-thickness'); ?> solid <?php echo get_theme_mod('widgetborder6'); ?>; background-color: <?php echo get_theme_mod('widgetbackground6'); ?>; margin-bottom:10px; padding:10px;overflow:hidden;}

.widgetbody7 { background-color: <?php echo get_theme_mod('widgetbackground7'); ?>; margin-bottom:10px; padding:10px;overflow:hidden;}

/* styles for widgets not included with theme */

<?php if (get_theme_mod('widget-style')=="Style 1") { ?>

#content h2, #homepageleft h2, #homepageright h2, #homepage h2, #sidebar h2 { background-color: <?php echo get_theme_mod('widgetcolor1'); ?> !important; color: <?php echo get_theme_mod('widgetcolor1-text'); ?> !important; border-left:<?php echo get_theme_mod('widget1-thickness'); ?> solid <?php echo get_theme_mod('widgetborder1'); ?> !important; border-right:<?php echo get_theme_mod('widget1-thickness'); ?> solid <?php echo get_theme_mod('widgetborder1'); ?> !important; border-top:<?php echo get_theme_mod('widget1-thickness'); ?> solid <?php echo get_theme_mod('widgetborder1'); ?> !important; }

.widgetbody, #permalinksidebar, .comments, .homecolumnwide { border-left: <?php echo get_theme_mod('widget1-thickness'); ?> solid <?php echo get_theme_mod('widgetborder1'); ?> !important; border-right: <?php echo get_theme_mod('widget1-thickness'); ?> solid <?php echo get_theme_mod('widgetborder1'); ?> !important; border-bottom: <?php echo get_theme_mod('widget1-thickness'); ?> solid <?php echo get_theme_mod('widgetborder1'); ?> !important; background-color: <?php echo get_theme_mod('widgetbackground1'); ?> !important;}

#homepage h2 a, #sidebar h2 a, #content h2 a { color: <?php echo get_theme_mod('widgetcolor1-text'); ?> !important; }

<?php } else if (get_theme_mod('widget-style')=="Style 2") { ?>

#content h2, #homepageleft h2, #homepageright h2, #homepage h2, #sidebar h2 { background-color: <?php echo get_theme_mod('widgetcolor2'); ?> !important; color: <?php echo get_theme_mod('widgetcolor2-text'); ?> !important;  }
#homepage h2 a, #sidebar h2 a, #content h2 a { color: <?php echo get_theme_mod('widgetcolor2-text'); ?> !important; }

.widgetbody, #permalinksidebar, .comments, .homecolumnwide { border-left: <?php echo get_theme_mod('widget2-thickness'); ?> solid <?php echo get_theme_mod('widgetborder2'); ?> !important; border-right: <?php echo get_theme_mod('widget2-thickness'); ?> solid <?php echo get_theme_mod('widgetborder2'); ?> !important; border-bottom: <?php echo get_theme_mod('widget2-thickness'); ?> solid <?php echo get_theme_mod('widgetborder2'); ?> !important; background-color: <?php echo get_theme_mod('widgetbackground2'); ?> !important;}

<?php } else if (get_theme_mod('widget-style')=="Style 3") { ?>

#content h2, #homepageleft h2, #homepageright h2, #homepage h2, #sidebar h2 { background-color: <?php echo get_theme_mod('widgetcolor3'); ?> !important; color: <?php echo get_theme_mod('widgetcolor3-text'); ?> !important; padding-left:10px !important; text-align:center !important; font-size: 10px !important;line-height:15px !important;font-weight:normal !important; text-transform:uppercase !important; }
#homepage h2 a, #sidebar h2 a, #content h2 a { color: <?php echo get_theme_mod('widgetcolor3-text'); ?> !important; }

.widgetbody, #permalinksidebar, .comments, .homecolumnwide { border-right: <?php echo get_theme_mod('widget3-thickness'); ?> solid <?php echo get_theme_mod('widgetborder3'); ?> !important; border-left: <?php echo get_theme_mod('widget3-thickness'); ?> solid <?php echo get_theme_mod('widgetborder3'); ?> !important; background-color: <?php echo get_theme_mod('widgetbackground3'); ?> !important;}

.widgetfooter {height:15px;width:100%;display:block;background-color: <?php echo get_theme_mod('widgetcolor3'); ?>}

<?php } else if (get_theme_mod('widget-style')=="Style 4") { ?>

.titlewrap300 { background: #FFFFFF url(<?php bloginfo('template_url'); ?>/images/sidebartop.gif) top no-repeat; float: left; width: 300px; margin: 0px 0px 0px 0px; padding: 10px 9px 0px 9px; border-left: 1px solid <?php echo get_theme_mod('widgetborder4'); ?> !important; border-right: 1px solid <?php echo get_theme_mod('widgetborder4'); ?> !important; border-top: 1px solid <?php echo get_theme_mod('widgetborder4'); ?> !important; overflow: hidden; }
.titlewrap400 { background: #FFFFFF url(<?php bloginfo('template_url'); ?>/images/featuredtop420.gif) top no-repeat; float: left; width: 400px; margin: 0px 0px 0px 0px; padding: 10px 9px 0px 9px; border-left: 1px solid <?php echo get_theme_mod('widgetborder4'); ?> !important; border-right: 1px solid <?php echo get_theme_mod('widgetborder4'); ?> !important; border-top: 1px solid <?php echo get_theme_mod('widgetborder4'); ?> !important; overflow:hidden; }
.titlewrap280, .aeholder { background: #FFFFFF url(<?php bloginfo('template_url'); ?>/images/homecolumntop.gif) top no-repeat; float: left; width: 280px; margin: 0px 0px 0px 0px; padding: 10px 9px 0px 9px; border-left: 1px solid <?php echo get_theme_mod('widgetborder4'); ?> !important; border-right: 1px solid <?php echo get_theme_mod('widgetborder4'); ?> !important; border-top: 1px solid <?php echo get_theme_mod('widgetborder4'); ?> !important; overflow:hidden; }
.titlewrap610 { background: #FFFFFF url(<?php bloginfo('template_url'); ?>/images/homepagetop.gif) top no-repeat; float: left; width: 590px; margin: 0px 0px 0px 0px; padding: 10px 9px 0px 9px; border-left: 1px solid <?php echo get_theme_mod('widgetborder4'); ?> !important; border-right: 1px solid <?php echo get_theme_mod('widgetborder4'); ?> !important; border-top: 1px solid <?php echo get_theme_mod('widgetborder4'); ?> !important; overflow:hidden; }
.titlewrap160 { background: #FFFFFF url(<?php bloginfo('template_url'); ?>/images/featuredtop176.gif) top no-repeat; float: left; width: 160px; margin: 0px 0px 0px 0px; padding: 10px 9px 0px 9px; border-left: 1px solid <?php echo get_theme_mod('widgetborder4'); ?> !important; border-right: 1px solid <?php echo get_theme_mod('widgetborder4'); ?> !important; border-top: 1px solid <?php echo get_theme_mod('widgetborder4'); ?> !important; overflow:hidden; }
.titlewrap { background: #FFFFFF url(<?php bloginfo('template_url'); ?>/images/sidebartop.gif) top no-repeat; float: left; margin: 0px 0px 0px 0px; padding: 10px 9px 0px 9px; border-left: 1px solid <?php echo get_theme_mod('widgetborder4'); ?> !important; border-right: 1px solid <?php echo get_theme_mod('widgetborder4'); ?> !important; border-top: 1px solid <?php echo get_theme_mod('widgetborder4'); ?> !important; overflow: hidden; }

#content h2, #l_sidebar h2, #homepageleft h2, #homepageright h2, #homepage h2, #sidebar h2, #sidebarae h2   { text-transform:uppercase; font-size:12px;background-color: <?php echo get_theme_mod('widgetcolor4'); ?> !important; color: <?php echo get_theme_mod('widgetcolor4-text'); ?> !important;  }

#homepage h2 a, #sidebar h2 a, #content h2 a { color: <?php echo get_theme_mod('widgetcolor4-text'); ?> !important; }


.widgetbody, #permalinksidebar, .comments, .homecolumnwide { background: #ffffff!important; border-left: 1px solid <?php echo get_theme_mod('widgetborder4'); ?> !important; border-right: 1px solid <?php echo get_theme_mod('widgetborder4'); ?> !important; border-bottom: 1px solid <?php echo get_theme_mod('widgetborder4'); ?> !important; background-color: #ffffff !important;clear:both;}


<?php } else if (get_theme_mod('widget-style')=="Style 5") { ?>

#content h2, #homepageleft h2, #homepageright h2, #homepage h2, #sidebar h2 { background-image:none!important; border-top: 10px solid <?php echo get_theme_mod('widgetcolor5'); ?>;background-color: <?php echo get_theme_mod('widgetbackground5'); ?> !important; color: <?php echo get_theme_mod('widgetcolor5-text'); ?> !important; font-weight:bold !important; }


.widgetbody, #permalinksidebar, .comments, .homecolumnwide { border-bottom: <?php echo get_theme_mod('widget5-thickness'); ?> solid <?php echo get_theme_mod('widgetborder5'); ?> !important; background-color: <?php echo get_theme_mod('widgetbackground5'); ?> !important;}

#homepage h2 a, #sidebar h2 a, #content h2 a { color: <?php echo get_theme_mod('widgetcolor5-text'); ?> !important; }

<?php } else if (get_theme_mod('widget-style')=="Style 6") { ?>

#content h2, #homepageleft h2, #homepageright h2, #homepage h2, #sidebar h2 { border: <?php echo get_theme_mod('widget6-thickness'); ?> solid <?php echo get_theme_mod('widgetborder6'); ?> !important;background-color: <?php echo get_theme_mod('widgetcolor6'); ?> !important; color: <?php echo get_theme_mod('widgetcolor6-text'); ?> !important;  }
#homepage h2 a, #sidebar h2 a, #content h2 a { color: <?php echo get_theme_mod('widgetcolor6-text'); ?> !important; }

.widgetbody, #permalinksidebar, .comments, .homecolumnwide { border-left: <?php echo get_theme_mod('widget6-thickness'); ?> solid <?php echo get_theme_mod('widgetborder6'); ?> !important; border-right: <?php echo get_theme_mod('widget6-thickness'); ?> solid <?php echo get_theme_mod('widgetborder6'); ?> !important; border-bottom: <?php echo get_theme_mod('widget6-thickness'); ?> solid <?php echo get_theme_mod('widgetborder6'); ?> !important; background-color: <?php echo get_theme_mod('widgetbackground6'); ?> !important;}

<?php } else if (get_theme_mod('widget-style')=="Style 7") { ?>

#content h2, #homepageleft h2, #homepageright h2, #homepage h2, #sidebar h2 { color:<?php echo get_theme_mod('widgetcolor7-text'); ?> !important;background:<?php echo get_theme_mod('widgetcolor7'); ?> !important;border-bottom:<?php echo get_theme_mod('widget7-thickness'); ?> solid <?php echo get_theme_mod('widgetborder7'); ?> !important;  }
#homepage h2 a, #sidebar h2 a, #content h2 a { color: <?php echo get_theme_mod('widgetcolor7-text'); ?> !important; }

.widgetbody, #permalinksidebar, .comments, .homecolumnwide { background-color: <?php echo get_theme_mod('widgetbackground7'); ?> !important;}

<?php } ?>

#permalinksidebar h2 {color: #000000!important;background:none!important;border:none!important;font-size:14px!important;line-height:20px!important;}

<?php if (get_theme_mod('top-stories-wide')=="Style 2") { ?>

.insert { width: 310px; height: 280px; background: <?php echo get_theme_mod('topstoriesbackground'); ?> !important; color: #000000;padding: 10px; line-height: 1.5em; position:absolute; right:0px; top:0px; border-left: 4px solid <?php echo get_theme_mod('topstoriesbackground'); ?> !important; overflow:hidden; }
.insert h3, .insert h3 a { line-height: 24px !important; font-size: 20px !important; font-weight: bold !important; margin: 0 0 10px 0; color: <?php echo get_theme_mod('accentcolor-links'); ?> !important; margin-bottom:6px !important;  }
#homepagefull p { line-height: 20px; font-size:15px; margin-top:0px;}
#homepagefull {background: #FFFFFF;float: left;width: 938px;margin: 10px 0px 0px 10px;padding: 0px 0px 0px 0px;position:relative;border:1px solid <?php echo get_theme_mod('topstoriesborder'); ?>}
#homepagefull a img {border:none;}
.captionbox {position:absolute; top:230px;left:50px;width:210px;}
.captionbox p {font-size:12px !important; line-height:14px !important;font-weight:normal !important;font-style:italic !important;}
.contentbox {position:absolute: top:10px; height:210px;overflow:hidden;}
.desc h3 {color:#ffffff!important;margin-top:8px!important;margin-left:10px!important;}
.desc a {color:#ffffff!important;}

<?php } else if (get_theme_mod('top-stories-wide')=="Style 1") { ?>

.insert { width: 591px; height: 90px; background: #000000; color: #ffffff; padding: 0px 10px; line-height: 1.2em; opacity: 0.7; filter:alpha(opacity=70); position:absolute; top:220px; left:0px overflow:hidden;
}
.insert h2 { line-height: 1em; font-size: 22px; font-weight: normal; margin: 0 0 10px 0; }
.insert a:link, .insert a:visited { color: #FFFFFF; text-decoration: none; }
.insert a:hover { text-decoration: underline; }
.insert h3 a, .insert h3 a:visited { color: #ffffff !important;	font-size: 16px !important;	line-height:24px !important; }
#slider { width: 100%; margin: 0 auto; position: relative; }
.hptabber {border:1px solid <?php echo get_theme_mod('topstoriesborder'); ?>; }
.desc h3 {color:#ffffff!important;margin-top:8px!important;margin-left:10px!important;}
.desc a {color:#ffffff!important;}
#homepagetop p { line-height: 20px; font-size:15px; margin-top:0px;}
#homepagetop {background: #FFFFFF;float: left;width: 608px;margin: 0px 0px 10px 10px;padding: 0px 0px 0px 0px;position:relative;border:1px solid <?php echo get_theme_mod('topstoriesborder'); ?>}
#homepagetop a img {border:none;}
#slideshow .desc {width:608px!important;}
#slideshow {width:610px!important;}
<?php } else if (get_theme_mod('top-stories-wide')=="Style 3") { ?>

.insert { width: 306px; height: 280px; background: <?php echo get_theme_mod('topstoriesbackground'); ?> !important; color: #000000;padding: 10px; line-height: 1.5em; position:absolute; right:0px; top:0px; border-left: 4px solid <?php echo get_theme_mod('topstoriesbackground'); ?> !important; overflow:hidden; }
.insert h3, .insert h3 a { line-height: 24px !important; font-size: 20px !important; font-weight: bold !important; margin: 0 0 10px 0; color: <?php echo get_theme_mod('accentcolor-links'); ?> !important; margin-bottom:6px !important;  }
#homepagefull p { line-height: 22px; font-size:15px; margin-top:0px;}
#homepagefull {background: #FFFFFF;float: left;width: 938px;margin: 10px 0px 0px 10px;padding: 0px 0px 0px 0px;position:relative;border:1px solid <?php echo get_theme_mod('topstoriesborder'); ?>}
#homepagefull a img {border:none;}
.captionbox {position:absolute; top:250px;left:10px;width:300px;padding-top:5px;background: <?php echo get_theme_mod('topstoriesbackground'); ?>;}
.captionbox p {font-size:12px !important; line-height:14px !important;font-weight:normal !important;font-style:italic !important;}
.contentbox {position:absolute: top:10px; height:280px;overflow:hidden;}
#slideshow_navigation{right:345px !important;}
<?php } ?>

<?php if ((get_theme_mod('top-stories-nav-buttons')=="Top") && (get_theme_mod('top-stories-wide')=="Style 1")) { ?>
#slideshow_navigation{top:-285px !important;}
.topstoriescontainer {height:311px!important;}
#homepagetop {margin-bottom:0px!important;}
<?php } else if ((get_theme_mod('top-stories-nav-buttons')=="Top") && (get_theme_mod('top-stories-wide')=="Style 2")) { ?>
#slideshow_navigation{top:-275px !important;right:35px !important;}
.topstoriescontainer {height:311px!important;}
#homepagefull {margin-bottom:-10px!important;}
<?php } else if ((get_theme_mod('top-stories-nav-buttons')=="Top") && (get_theme_mod('top-stories-wide')=="Style 3")) { ?>
#slideshow_navigation{top:-275px !important;right:360px !important;}
.topstoriescontainer {height:311px!important;}
#homepagefull {margin-bottom:-10px!important;}
<?php } else if ((get_theme_mod('top-stories-nav-buttons')=="Bottom") && (get_theme_mod('top-stories-wide')=="Style 1")) { ?>
#slideshow_navigation{top:-35px !important;}
.topstoriescontainer {height:311px!important;}
#homepagetop {margin-bottom:0px!important;}
<?php } else if ((get_theme_mod('top-stories-nav-buttons')=="Bottom") && (get_theme_mod('top-stories-wide')=="Style 2")) { ?>
#slideshow_navigation{top:-25px !important;right:35px !important;}
.topstoriescontainer {height:311px!important;}
#homepagefull {margin-bottom:-10px!important;}
<?php } else if ((get_theme_mod('top-stories-nav-buttons')=="Bottom") && (get_theme_mod('top-stories-wide')=="Style 3")) { ?>
#slideshow_navigation{top:-25px !important;right:360px !important;}
.topstoriescontainer {height:311px!important;}
#homepagefull {margin-bottom:-10px!important;}
<?php } else if ((get_theme_mod('top-stories-nav-buttons')=="Below") && (get_theme_mod('top-stories-wide')=="Style 1")) { ?>
.topstoriescontainer {height:351px!important;}
#slideshow_navigation{top:5px !important; right:272px!important;}
#slideshow_navigation a {margin:0px 4px!important;}
<?php } else if ((get_theme_mod('top-stories-nav-buttons')=="Below") && (get_theme_mod('top-stories-wide')=="Style 3")) { ?>
#slideshow_navigation{top:15px !important; right:430px!important;}
#slideshow_navigation a {margin:0px 4px!important;}
.topstoriescontainer {height:351px!important;}
<?php } else if ((get_theme_mod('top-stories-nav-buttons')=="Below") && (get_theme_mod('top-stories-wide')=="Style 2")) { ?>
#slideshow_navigation{top:15px !important; right:430px!important;}
#slideshow_navigation a {margin:0px 4px!important;}
.topstoriescontainer {height:351px!important;}
<?php } ?>

<?php if (get_theme_mod('widget-shadows')=="On") { ?>
.widgetwrap { -moz-box-shadow: 1px 1px 5px #888; -webkit-box-shadow: 1px 1px 5px #888; box-shadow: 1px 1px 5px #888;}
<?php } ?>

<?php if (get_theme_mod('top-stories-shadow')=="On") { ?>
#homepagetop, #homepagetopsports, #homepagefull { -moz-box-shadow: 1px 1px 5px #888; -webkit-box-shadow: 1px 1px 5px #888; box-shadow: 1px 1px 5px #888;}
<?php } ?>

<?php if (get_theme_mod('outer-shadows')=="On") { ?>
#wrap, #breakingnews { -moz-box-shadow: 0px 10px 20px #222; -webkit-box-shadow: 0px 10px 20px #222; box-shadow: 0px 10px 20px #222;}
<?php if (get_theme_mod('leaderboard-background-on')!="Transparent") { ?>
#leaderboard { -moz-box-shadow: 0px 10px 20px #222; -webkit-box-shadow: 0px 10px 20px #222; box-shadow: 0px 10px 20px #222;}
<?php } ?>
<?php } ?>

<?php if (get_theme_mod('show-breadcrumb')=="No") { ?>
.breadcrumb {display:none!important;}
<?php } ?>


.postarearacingchallenge {
	background: #FFFFFF;
	float: left;
	width: 920px;
	margin: 5px 10px 5px;
	padding: 10px;
	border: 1px solid #DDDDDD;
	}


.postareatrashtalkers {
	background-image:url('http://www.snowgoer.com/wp-content/uploads/2013/04/Final-Round.jpg');
background-size:100%;
background-repeat:no-repeat;
	float: left;
	width: 920px;
	height:600px;
	margin: 5px 10px 5px;
	padding: 10px;
	border: 1px solid #DDDDDD;
	}

.sublink {
text-align:center;
margin-left:auto;
margin-right:auto;
font-size:150%;
	}

.racingchallengeraces
{
background-color:#E8E8E8;
border: 1px solid #DDDDDD;
padding: 5px;
border: 1px;

}

.postarearacingchallenge ul li {
        background: url(images/bulletarrow.png) no-repeat scroll 2px 2px;
	padding: 0px 0px 0px 10px;
	margin: 0px;
        font-size:12px;
list-style-position: inside;
	}

a img {
    border: 0;
}



#skin {
	position: absolute;
	width: 100%;
	height: 2000px;
	margin-left: auto;
	margin-right: auto;
	top: 0px;
	left: 0px;
	z-index: 1;
}



.SGPagination {
	position: relative;
	width: auto;
margin: 30px;	
font-size: 16px;

}

#subform    {
background-image:url('http://www.snowgoer.com/wp-content/uploads/2011/12/Subform-SG.jpg');
background-repeat:no-repeat;
padding:80px 25px;
width:375px;
height:100px; 
line-height: 5px;
}



</style>