
<?php
global $satellite_init_ok;
if (!empty($slides)) :

    $style = $this->get_option('styles');
    $imagesbox = $this->get_option('imagesbox');
    $textloc = $this->get_option('textlocation');
    if ($this->get_option('autoslide') == "Y") {
        $autospeed = $this->get_option('autospeed');
        $autospeed2 = $this->get_option('autospeed2');
    }
    else {
        $autospeed = '0';
        $autospeed2 = '0';
    }
    if ($this->get_option('othumbs') != 'B') { // if thumbs on bullcenter = false
        $this->update_option('bullcenter', 'false');
    }
    if ($this->get_option('transition_temp') == "F") { // fade, horizontal-slide, vertical-slide, horizontal-push
        $transition = "fade";
    } elseif ($this->get_option('transition_temp') == "OHS") {
        $transition = "horizontal-slide";
    } elseif ($this->get_option('transition_temp') == "OVS") {
        $transition = "vertical-slide";
    } elseif ($this->get_option('transition_temp') == "OHP") {
        $transition = "horizontal-push";
    }
    ?>

    <?php if ($frompost) : ?>
        <!-- =======================================
        THE ORBIT SLIDER CONTENT 
        ======================================= -->
        <div class="<?php echo ( $this->get_option('thumbnails_temp') == 'FR') ? 'full-right' : 'full-left';?>">
            <div id="featured<?php echo $satellite_init_ok; ?>"> 
                <?php foreach ($slides as $slider) : ?>  
                    <?php $full_image_href = wp_get_attachment_image_src($slider->ID, 'full', false); ?>
                    <?php $thumbnail_link = wp_get_attachment_image_src($slider->ID, 'thumbnail', false); ?>

                    <?php
                    if ($this->get_option('abscenter') == "Y" ) {
                        echo "<div class='sorbit-wide absoluteCenter' data-caption='#post-{$slider->ID}' data-thumb='{$thumbnail_link[0]}'>";
                    } else {
                        echo "<div class='sorbit-basic' data-caption='#post-{$slider->ID}' data-thumb='{$thumbnail_link[0]}'>";
                    }
                    ?>
                    <?PHP if ($this->get_option('wpattach') == 'Y') { ?>
                        <a href="<?php echo $attachment_link; ?>" rel="" title="<?php echo $slider->post_title; ?>">
                    <?PHP } elseif ($imagesbox != "N" && $this->get_option('nolinker') != 'Y') { ?>
                        <a class="thickbox sorbit-link" href="<?php echo $full_image_href[0]; ?>" rel="" title="<?php echo $slider->post_title; ?>">
                    <?PHP } ?>
                        <img <?php echo ($this->get_option('abscenter') == "Y") ? "class='absoluteCenter'":"" ?> src="<?php echo $full_image_href[0]; ?>" 
                             alt="<?php echo $imagesbox . $slider->post_title; ?>" />
                        <?PHP if ($imagesbox != "N" && $this->get_option('nolinker') != 'Y') { ?></a><?PHP } ?>
                </div>
            
                <span class="orbit-caption" id="post-<?php echo $slider->ID; ?>">
                    <h5><?php echo $slider->post_title; ?></h5>
                    <p><?php echo $slider->post_content; ?></p>
                </span>
            <?php endforeach;  ?>
            </div> <!-- end featured -->

        </div>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('#featured<?php echo $satellite_init_ok; ?>').orbit({
                    animation: '<?PHP echo ($transition) ? $transition : $this->get_option('transition'); ?>',                  // fade, horizontal-slide, vertical-slide, horizontal-push
                    animationSpeed: <?php echo($this->get_option('duration')); ?>,                // how fast animations are
                    timer: <?PHP echo ($this->get_option("autoslide_temp") == "Y" ) ? 'true' : 'false'; ?>, 	 // true or false to have the timer
                    advanceSpeed: <?PHP echo ($autospeed2); ?>, 		 // if timer is enabled, time between transitions 
                    pauseOnHover: false, 		 // if you hover pauses the slider
                    startClockOnMouseOut: false, 	 // if clock should start on MouseOut
                    startClockOnMouseOutAfter: 1000, 	 // how long after MouseOut should the timer start again
                    directionalNav: true, 		 // manual advancing directional navs
                    captions: <?php echo($this->get_option('information_temp') == 'Y') ? 'true' : 'false'; ?>,	 // do you want captions?
                    captionAnimation: 'slideOpen', 		 // fade, slideOpen, none
                    captionAnimationSpeed: 800, 	 // if so how quickly should they animate in
                    bullets: true,		 // true or false to activate the bullet navigation
                    bulletThumbs: true,		 // thumbnails for the bullets
                    bulletThumbLocation: '',	 // location from this file where thumbs will be
                    afterSlideChange: function(){},    // empty function 
                    centerBullets: <?php echo $this->get_option('bullcenter'); ?>                    
                });				
            });
        </script> 
        <!--  CUSTOM GALLERY -->
    <?php else : ?>  

        <div class="<?php echo ( $this->get_option('thumbnails_temp') == 'FR') ? 'full-right' : 'full-left';?>">
            <div id="featured<?php echo $satellite_init_ok; ?>"> 
                <?php $i = 0; ?>
                <?php foreach ($slides as $slider) : ?>     
                    <?php
                    if ($this->get_option('abscenter') == "Y" ) {
                        echo "<div class='sorbit-wide absoluteCenter' data-caption='#custom-$i'
                            data-thumb='{$this->Html->image_url($this->Html->thumbname($slider->image))}'>";
                    } else {
                        echo "<div class='sorbit-basic' data-caption='#custom-$i'
                            data-thumb='{$this->Html->image_url($this->Html->thumbname($slider->image))}'>";
                    }
                    ?>					
                    <?php if ($slider->uselink == "Y" && !empty($slider->link)) : ?>
                        <a href="<?php echo $slider->link; ?>" title="<?php echo $slider->title; ?>" target="<?php echo ($this->get_option('pagelink') == "S") ? "_self":"_blank" ?>">
                    <?PHP elseif ($imagesbox != "N" && $this->get_option('nolinker') != 'Y') : ?>
                        <a class="thickbox sorbit-link" href="<?php echo $this->Html->image_url($slider->image); ?>" rel="" title="<?php echo $slider->title; ?>">
                    <?PHP endif; ?>


                    <img <?php echo ($this->get_option('abscenter') == "Y") ? "class='absoluteCenter'":"" ?> 
                        src="<?php echo $this->Html->image_url($slider->image); ?>" 
                        alt="<?php echo $slider->title; ?>"                       
                        />
                    
                    <?PHP if (( $imagesbox != "N" && $this->get_option('nolinker') != 'Y' ) || $slider->uselink == "Y") : ?></a><?PHP endif; ?>
                </div>
                <?php if ($slider->textlocation != "N") { ?>
                <span class="orbit-caption <?php echo ($slider->textlocation == 'BR'|| $slider->textlocation == 'TR') ? ' sattext sattext'.$slider->textlocation:''?>" id="custom-<?php echo $i; ?>">
                    <h5><?php echo $slider->title; ?></h5>
                    <p><?php echo $slider->description; ?></p>
                </span> 
                <?php } ?>
                <?php $i = $i +1; ?>
            <?php endforeach; ?>
            </div> <!-- end featured -->
            
        </div>

        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('#featured<?php echo $satellite_init_ok; ?>').orbit({
                    animation: '<?PHP echo ($transition) ? $transition : $this->get_option('transition'); ?>',                  // fade, horizontal-slide, vertical-slide, horizontal-push
                    animationSpeed: <?php echo($this->get_option('duration')); ?>,                // how fast animations are
                    timer: <?PHP echo ($this->get_option("autoslide_temp") == "Y" ) ? 'true' : 'false'; ?>, 	 // true or false to have the timer
                    advanceSpeed: <?PHP echo ($autospeed2); ?>, 		 // if timer is enabled, time between transitions 
                    pauseOnHover: false, 		 // if you hover pauses the slider
                    startClockOnMouseOut: false, 	 // if clock should start on MouseOut
                    startClockOnMouseOutAfter: 1000, 	 // how long after MouseOut should the timer start again
                    directionalNav: true, 		 // manual advancing directional navs
                    captions: <?php echo($this->get_option('information_temp') == 'Y') ? 'true' : 'false'; ?>,	 // do you want captions?
                    captionAnimation: 'slideOpen', 		 // fade, slideOpen, none
                    captionAnimationSpeed: 800, 	 // if so how quickly should they animate in
                    bullets: true,		 // true or false to activate the bullet navigation
                    bulletThumbs: true,		 // thumbnails for the bullets
                    bulletThumbLocation: '',	 // location from this file where thumbs will be
                    afterSlideChange: function(){},    // empty function 
                    centerBullets: <?php echo $this->get_option('bullcenter'); ?>                    
                });				
            });
        </script> 

    <?php endif; 
    /******** PRO ONLY **************/
    if ( SATL_PRO && $this->get_option('keyboard') == 'Y') {
            require SATL_PLUGIN_DIR . '/pro/keyboard.html';

    }
    endif; ?>