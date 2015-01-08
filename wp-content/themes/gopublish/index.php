<?php
/** Index File */

global $post;

get_header();
?>

<div id="content">

	<div id="contentleft">

		<div class="postarea">

			<?php include( get_template_directory() . "/breadcrumb.php" ); ?>

			<?php if ( have_posts() ) : while ( have_posts() ) : the_post();

				$photographer    = get_post_meta( $post->ID, 'photographer', TRUE );
				$caption         = get_post_meta( $post->ID, 'caption', TRUE );
				$video           = get_post_meta( $post->ID, 'video', TRUE );
				$slideshowcredit = get_post_meta( $post->ID, 'slideshowcredit', TRUE );
				$jobtitle        = get_post_meta( $post->ID, 'jobtitle', TRUE );
				$writer          = get_post_meta( $post->ID, 'writer', TRUE );
				$related         = get_post_meta( $post->ID, 'related', TRUE );
				$featured        = get_post_meta( $post->ID, 'featured', TRUE );
				$videographer    = get_post_meta( $post->ID, 'videographer', TRUE ); ?>

				<?php
				if ( $video ) {
					$pattern = "/height=\"[0-9]*\"/";
					$video1  = preg_replace( $pattern, "height='400'", $video );
					$pattern = "/width=\"[0-9]*\"/";
					$video1  = preg_replace( $pattern, "width='590'", $video1 );
					?>
					<div style="margin-bottom:15px"> <?php
						echo $video1;
						if ( $videographer ) { ?>
							<p class="photocredit" style="padding-bottom:0">
								Video Credit: <?php echo $videographer; ?>
							</p>
						<?php } ?>
					</div>
				<?php } ?>

				<h1 style="line-height:40px"><?php the_title(); ?></h1>

				<div id="permalinkphotobox">

					<?php if ( isset( $audio ) ) {
						$audioplayer = "[audio:" . $audio . "]";
						if ( function_exists( 'insert_audio_player' ) ) {
							insert_audio_player( $audioplayer );
						} ?>
						<div style="margin-bottom:15px"></div>
					<?php } ?>

					<?php if ( isset($slideshow) ) {
						$showalbum = "[slideshow id =" . $slideshow . " w=302 h=200]";
						echo do_shortcode( $showalbum ); ?>
						<div style="margin-bottom:15px"></div><?php } ?>

					<?php if ( isset($gallery) ) {
						$showalbum = "[nggallery id =" . $gallery . " w=50 h=50]";
						echo do_shortcode( $showalbum );
					} ?>

					<?php if ( isset( $slideshowcredit ) && strlen($slideshowcredit) >= 1 ) { ?>
						<p class="photocredit">
							Credit: <?php echo $slideshowcredit; ?>
						</p>
					<?php }

					if ( $featured != "No" ) { ?>

						<?php if ( has_post_thumbnail() ) {
							the_post_thumbnail( 'permalink', array( 'class' => 'permalinkimage' ) );
						}

						if ( isset($photographer) && strlen($photographer) >= 1 ) { ?>
							<p class="photocredit">
								Photo Credit: <?php echo $photographer; ?>
							</p>
						<?php }

						if ( $caption ) { ?>
							<p class="photocaption">
								<?php echo $caption; ?>
							</p>
						<?php }

					} ?>

				</div>

				<p>
					<?php snowriter(); ?>
					<?php the_time( 'F j, Y' ); ?>
					<?php edit_post_link( '(Edit)', '', '' ); ?>
					<br/>Filed under <?php the_category( ', ' ) ?>
				</p>

				<?php the_content( __( 'Read more' ) ); ?>
				<div style="clear:both;"></div>

				<?php $related = get_post_meta( $post->ID, 'related', TRUE );
				if ( $related != "No" ) { ?>
					<div style="clear:both;margin-bottom:15px;"></div>
					<div class="widgetwrap">
						<div class="titlewrap610"><h2>Related Content</h2></div>

						<div id="permalinksidebar">
							<?php if ( function_exists( 'ddop_show_posts' ) ) {
								echo ddop_show_posts();
							} ?>
							<h3>Other stories that might interest you...</h3>
							<?php if ( function_exists( 'similar_posts' ) ) {
								similar_posts();
							} ?>

						</div>
						<div class="widgetfooter"></div>
					</div>
				<?php } ?>

				<div class="postmeta">
					<?php the_tags( '<p><span class="tags">Tags: ', ', ',
					                '</span></p>' ); ?>
				</div>


			<?php endwhile;
			else: ?>

				<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p><?php endif; ?>

		</div>

		<div style="clear:both;"></div>

		<?php if ( get_theme_mod( 'comments' ) == "Enable" ) { ?>

			<div class="widgetwrap">
				<div class="titlewrap610"><h2>Comments</h2></div>
				<div class="widgetbody">
					<?php $commentspolicy = get_theme_mod( 'comments-policy' );
					if ( $commentspolicy ) {
						echo '<p>' . $commentspolicy . '</p>';
					} ?>

					<?php comments_template(); // Get wp-comments.php template ?>

				</div>
				<div class="widgetfooter"></div>
			</div>

		<?php } ?>

	</div>

	<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>