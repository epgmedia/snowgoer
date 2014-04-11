<!--start of breaking news-->

<?php $count = 1; ?>
<?php $recent = new WP_Query("cat=" . get_theme_mod('breakingnews-cat') . "&showposts=" . get_theme_mod('breakingnews-scrollbox')); while($recent->have_posts()) : $recent->the_post();?><?php $headline = get_post_meta($post->ID, breakingnewsheadline, true); $breakingnewslink = get_post_meta($post->ID, breakingnewslink, true); ?>

<?php if ($count==1) { $exitkey=6; ?>

<div id="breakingnews">
    <div id="newsticker3-demo">    
        <div class="newsticker3-jcarousellite">
        <ul>
<?php } ?>
                <li>
                <div class="info">
					<p>
                    <?php if ($breakingnewslink) { ?><a href="<?php echo $breakingnewslink; ?>"><span class="breakingnewsheadline"><?php echo $headline; ?></span></a><?php } else { ?><span class="breakingnewsheadline"><?php echo $headline; } ?></span>
                    <span class="breakingnewsdate"> <?php the_time('F j, Y'); ?> at <?php the_time('g:i a'); ?> <?php edit_post_link(); ?></span>
                    </p>
                </div>
                <div class="clear"></div>
            </li>

<?php $count++ ?>
<?php endwhile; ?>
<?php wp_reset_query(); ?>
<?php if ($exitkey==6) { $exitkey=0; ?>

        </ul>
    </div>
   </div>
</div>
<?php } ?>

<!--end of breaking news scrollbox-->