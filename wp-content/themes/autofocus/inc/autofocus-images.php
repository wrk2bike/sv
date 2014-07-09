<?php
/**
 *	AutoFocus Image Functions
 *
 *	Build the functions, galleries, and sliders for images. 
 *
*/

/**
 *	Create the Featured Post Area
 */
function af_featured_posts() {
	global $post, $af_flickr, $shortname;

	if ( (is_home() || is_front_page()) && !is_paged() ) : 
	
	$sticky = get_option('sticky_posts');
	$sticky_count = (count($sticky));


	if (is_active_sidebar('intro-widget-area')) { ?>

		<aside id="intro-widget-area" class="widget-area" role="complementary">
			<ul class="xoxo">

			<?php
				/* When we call the dynamic_sidebar() function, it'll spit out
				 * the widgets for that widget area. If it instead returns false,
				 * then the sidebar simply doesn't exist, so we'll hard-code in
				 * some default sidebar stuff just in case.
				 */
				if ( ! dynamic_sidebar( 'intro-widget-area' ) ) : ?>
			
					<?php dynamic_sidebar( 'intro-widget-area' ); ?>
			
			<?php endif; // end primary widget area ?>

			</ul>
		</aside><!-- #intro-widget-area .widget-area -->

	<?php } 
	
		// if Sticky Posts exist and the slider is turned off, Show a static sticky area
		if ( (get_option('sticky_posts' ) && ( of_get_option($shortname . '_sliding_sticky_area') == FALSE ) ) || (of_get_option($shortname . '_sliding_sticky_area') == TRUE && $sticky_count == '1') ) { ?>

			<?php 
			// Set Up New Query
			$randomStickyNo = 0;
			$randomStickyNo = (rand()%(count($sticky)));
			$postno = $sticky[($randomStickyNo)];
			$static_sticky_query = null;
			$temp = $static_sticky_query;
			$static_sticky_query = new WP_Query();
			$static_sticky_query->query('orderby=rand&post_status=publish&showposts=1&p=' . $postno); ?>

			<?php while ($static_sticky_query->have_posts()) : $static_sticky_query->the_post(); $do_not_duplicate = $post->ID; ?>
				<div id="sticky-area">

					<article id="post-<?php the_ID(); ?>" class="post">
						<header>
							<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
							<?php af_posted_on(); ?>
						</header>
			
						<?php af_entry_image('full-post-thumbnail'); ?>
			
						<div class="entry-content">
							<?php the_excerpt(); ?>
						</div><!-- .entry-content -->
						<?php edit_post_link( __( 'Edit', 'autofocus' ), '<footer class="entry-utility"><span class="edit-link">', '<a href="#" title="Save" class="save-position">' . __('Save', 'autofocus') . '</a><a href="#" title="Reset" class="reset-position">' . __('Reset', 'autofocus') . '</a></span></footer><!-- .entry-utility -->' ); ?>			
					</article><!-- #post-## -->

				</div><!-- #sticky-area -->
			<?php endwhile; ?>
			<?php $static_sticky_query = null; $temp = $static_sticky_query; ?>


	<?php } // if Sliding Featured Area option is true
			elseif (get_option('sticky_posts') && (of_get_option($shortname . '_sliding_sticky_area') == TRUE)) { ?>

			<div id="sticky-area" class="entry-gallery-container">
			<div id="gallery-container" class="cycle">

			<?php
			// Set Up New Query
			$temp = null;
			$sliding_sticky_query = $temp;
			$sliding_sticky_query = new WP_Query();
			$sliding_sticky_query->query(array(
				// 'orderby' => 'rand', 
				'showposts' => '10',
				'post__in' => get_option('sticky_posts')
				)); ?>

			<?php while ($sliding_sticky_query->have_posts()) : $sliding_sticky_query->the_post(); $do_not_duplicate = $sliding_sticky_query->post->ID; ?>

					<article id="post-<?php the_ID(); ?>" class="post">
						<header>
							<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
							<?php af_posted_on(); ?>
						</header>
			
						<?php af_entry_image('full-post-thumbnail'); ?>
			
						<div class="entry-content">
							<?php the_excerpt(); ?>
						</div><!-- .entry-content -->
			
						<?php edit_post_link( __( 'Edit', 'autofocus' ), '<footer class="entry-utility"><span class="edit-link">', '<a href="#" title="Save" class="save-position">' . __('Save', 'autofocus') . '</a><a href="#" title="Reset" class="reset-position">' . __('Reset', 'autofocus') . '</a></span></footer><!-- .entry-utility -->' ); ?>			
					</article><!-- #post-## -->

			<?php endwhile; ?>
			<?php $sliding_sticky_query = $temp;
				$temp = null; ?>

			</div><!-- .cycle -->
			</div><!-- .entry-gallery-container -->

		<?php } 
	endif;
}


/**
 * Create the AutoFocus entry image loop
 */
function af_entry_image( $af_size = 'medium' ) {
	global $post;
	
	// Grab X & Y positions
	$af_image_ypos = get_post_meta($post->ID, 'af_image_pos_top_value', true);
	$af_image_xpos = get_post_meta($post->ID, 'af_image_pos_left_value', true);

	// If the position settings are empty or we’re on a single Post, set the values to ZERO
	if ( is_single() || $af_image_ypos == '' || $af_image_ypos == '0') {
		$af_image_ypos = '0';
	} else {
		$af_image_ypos = $af_image_ypos . 'px';
	}

	if ( is_single() || $af_image_xpos == '' || $af_image_xpos == '0' ) {
		$af_image_xpos = '0';
	} else {
		$af_image_xpos = $af_image_xpos . 'px';
	}
    
	// Is Flickr is enabled?
	if ( get_post_meta($post->ID, 'enable_flickr', true) ) : 
	
		// Set Flickr Sizes
		$af_flickr_size = null;
		if ($af_size == 'full' || $af_size == 'large' || $af_size == 'single-post-thumbnail' || $af_size == 'front-page-thumbnail' || $af_size == 'full-post-thumbnail') { 
			$af_flickr_size = '_b';
		} elseif ($af_size == 'medium') { 
			$af_flickr_size = '_z';
		} elseif ($af_size == 'thumbnail' || $af_size == 'archive-thumbnail') {
			$af_flickr_size = '_m';
		} ?>

		<span class="entry-image flickr-image">
			<a class="entry-image-post-link dragthis" style="position:relative;left:<?php echo $af_image_xpos; ?>;top:<?php echo $af_image_ypos; ?>" title="<?php printf( esc_attr__( '%s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" href="<?php the_permalink(); ?>">
				<img src="<?php echo get_flickr_set_primary_uri($post->ID, $af_flickr_size); ?>" class="attachment-ha-full-gallery wp-post-image" alt="<?php printf( esc_attr__( 'View %s &rarr;', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" /></a>
		</span><!-- .entry-image -->
		<?php af_image_credit(); ?>	
	
	<?php elseif ( has_post_thumbnail() ) : ?>

		<span class="entry-image">
			<a class="entry-image-post-link dragthis" style="position:relative;left:<?php echo $af_image_xpos; ?>;top:<?php echo $af_image_ypos; ?>" title="<?php printf( esc_attr__( '%s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( $af_size ); ?></a>
		</span><!-- .entry-image -->
		<?php af_image_credit(); ?>	

	<?php else : 

		$linkedimgtag = get_post_meta($post->ID, 'image_tag', true);
		$args = array(
			'order'          => 'ASC',
			'post_type'      => 'attachment',
			'post_parent'    => get_the_ID(),
			'post_mime_type' => 'image',
			'post_status'    => null,
			'numberposts'    => 1,
		);

		$attachments = get_posts($args);
		
		if ($attachments) {
			foreach ($attachments as $attachment) { ?>
			
				<span class="entry-image">
					<a class="entry-image-post-link dragthis" style="position:relative;left:<?php echo $af_image_xpos; ?>;top:<?php echo $af_image_ypos; ?>" title="<?php printf( esc_attr__( '%s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" href="<?php the_permalink(); ?>">
						<?php echo wp_get_attachment_image($attachment->ID, $af_size); ?>
					</a>
				</span><!-- .entry-image -->
				<?php af_image_credit(); ?>	

			<?php }

		} elseif ( $linkedimgtag != '' ) { ?>
				<span class="entry-image">
					<a class="entry-image-post-link dragthis" style="position:relative;left:<?php echo $af_image_xpos; ?>;top:<?php echo $af_image_ypos; ?>" title="<?php printf( esc_attr__( '%s', 'autofocus' ), the_title_attribute( 'echo=0' ) ); ?>" href="<?php the_permalink(); ?>">
						<?php echo $linkedimgtag; ?>
					</a>
				</span><!-- .entry-image -->
				<?php af_image_credit(); ?>	

		<?php } else { 
			echo "<!-- This post doesn’t have an image attachment! -->";
		}
		
		endif;

}

/**
 *	Setup Images for posts without attachments
 */
function af_entry_image_setup($postid) {
	global $post;
	$post = get_post($postid);

	//	get url
	if ( !preg_match('/<img ([^>]*)src=(\"|\')(.+?)(\2)([^>\/]*)\/*>/', $post->post_content, $matches) ) {
		return false;
	}

	//	url setup /**/
	$post->image_url = $matches[3];
	if ( !$post->image_url = preg_replace('/\?w\=[0-9]+/','', $post->image_url) )
		return false;

	$post->image_url = esc_url( $post->image_url, 'raw' );
	
	delete_post_meta($post->ID, 'image_url');
	delete_post_meta($post->ID, 'image_tag');

	add_post_meta($post->ID, 'image_url', $post->image_url);
	add_post_meta($post->ID, 'image_tag', '<img src="'.$post->image_url.'" />');
}
add_action('publish_post', 'af_entry_image_setup');
add_action('publish_page', 'af_entry_image_setup');


/**
 * Create the AutoFocus image slider
 */
function af_single_entry_image( $af_size = 'full-post-thumbnail', $af_slider_count ) {
	global $post;

		if ( (get_post_meta($post->ID, 'enable_flickr', true)) ) { 
			
			// Pull imgaes from Flickr and display them in the slider
			if ( (get_post_meta($post->ID, 'show_gallery', true) == 'true') ) :

				get_flickr_photo_slider($af_size, $af_slider_count);
			
			else : ?>
			
			<div class="entry-image-container">
				<?php af_entry_image($af_size); ?>
			</div><!-- .entry-image-container -->

			<?php endif;

		} elseif ( get_post_meta($post->ID, 'videoembed_value', true) ) {  ?>

			<div class="entry-video-container">
				<?php 
					$af_video_url = get_post_meta($post->ID, 'videoembed_value', true);
					$oembed_url = wp_oembed_get($af_video_url, array( 'width' => 800, 'height' => 600 )); 
					echo $oembed_url; 
				?>
			</div><!-- .entry-video-container -->

		<?php 
		} elseif ( (get_post_meta($post->ID, 'show_gallery', true) == 'true') ) { ?>

			<div class="entry-gallery-container">
			<div id="cycle-gallery" class="cycle">
				<?php 
					$af_slider_count = get_post_meta($post->ID, 'slider_count_value', true);
					$args = array(
						'order'		  => 'ASC',
						'orderby'		 => 'menu_order ID',
						'post_type'	  => 'attachment',
						'post_parent'	=> $post->ID,
						'post_mime_type' => 'image',
						'post_status'	=> null,
						// Change the number of images to show in the gallery below
						'numberposts'	=> $af_slider_count, 
					);
					$attachments = get_posts($args);
					if ($attachments) {
						foreach ($attachments as $attachment) {
							echo "\t\t\t\t\t<span class=\"entry-image\">" . wp_get_attachment_image($attachment->ID, $af_size, false, false) . "</span>\n";
						}
					} ?>
			</div><!-- .cycle -->
			</div><!-- .entry-gallery-container	 -->

		<?php } else { ?>
	
			<div class="entry-image-container">
				<?php af_entry_image($af_size); ?>
			</div><!-- .entry-image-container -->
		<?php } 
}

/**
 *	Update Image Positions with AJAX
 */
function update_image_xy_pos() {
	if ( '' == get_post_meta($_POST['id'], 'af_image_pos_top_value', $_POST['topPos']) && '' == get_post_meta($_POST['id'], 'af_image_pos_left_value', $_POST['leftPos']) ) {
		add_post_meta($_POST['id'], 'af_image_pos_top_value', $_POST['topPos']);
		add_post_meta($_POST['id'], 'af_image_pos_left_value', $_POST['leftPos']);
	} else {
		update_post_meta($_POST['id'], 'af_image_pos_top_value', $_POST['topPos']);
		update_post_meta($_POST['id'], 'af_image_pos_left_value', $_POST['leftPos']);
	}
	echo __('AutoFocus Image Position Settings Saved', 'autofocus');
	die();
}
add_action('wp_ajax_af_save_ajax_hook','update_image_xy_pos');

function reset_image_xy_pos() {
	delete_post_meta($_POST['id'], 'af_image_pos_top_value', $_POST['topPos']);
	delete_post_meta($_POST['id'], 'af_image_pos_left_value', $_POST['leftPos']);
	echo __('AutoFocus Image Position Settings Reset', 'autofocus');
	die();
}
add_action('wp_ajax_af_reset_ajax_hook','reset_image_xy_pos');


/**
 *	Image Author/Credit Display
 */
function af_image_credit() { 
	global $post;
		
	if ( get_post_meta($post->ID, 'copyright_value', true) ) {  ?>
		<span class="photo-credit"><?php echo get_post_meta($post->ID, 'copyright_value', true); ?></span>
	<?php } elseif ( get_the_author_meta('user_url') == '' ) { ?>
		<span class="photo-credit">&copy; <?php the_time('Y'); ?> <?php the_author_meta('display_name'); ?>. <?php _e('All rights reserved.', 'autofocus'); ?></span>
	<?php } else { ?>
		<span class="photo-credit">&copy; <?php the_time('Y'); ?> <a href="<?php the_author_meta('user_url'); ?>" target="_blank" rel="author"><?php the_author_meta('display_name'); ?></a>. <?php _e('All rights reserved.', 'autofocus'); ?></span>
	<?php } ?>

<?php } 

/**
 *	Grab EXIF Data from Attachments
 *	http://www.bloggingtips.com/2008/07/20/wordpress-gallery-and-exif/
 */
function af_display_exif_data() {
	global $id, $post;

	$imgmeta = wp_get_attachment_metadata($id);

	$shutterspeed_meta = $imgmeta['image_meta']['shutter_speed'];
	if ( $shutterspeed_meta > 0 ) {
		$display_shutterspeed_meta = "1/" . 1 / $shutterspeed_meta;
	} else {
		$display_shutterspeed_meta = 0;
	}

	//	Start to display EXIF and IPTC data of digital photograph
	echo '<h3 id="exif-data">' . __('Exif Data', 'autofocus') . '</h3>';
	echo '<ul>';
	echo '<li><span class="exif-title">' . __('Date Taken:', 'autofocus') . '</span> ' . date("d-M-Y H:i:s", $imgmeta['image_meta']['created_timestamp']) . '</li>';
	echo '<li><span class="exif-title">' . __('Copyright:', 'autofocus') . '</span> ' . $imgmeta['image_meta']['copyright'] . '</li>';
	echo '<li><span class="exif-title">' . __('Credit:', 'autofocus') . '</span> ' . $imgmeta['image_meta']['credit'] . '</li>';
	echo '<li><span class="exif-title">' . __('Title:', 'autofocus') . '</span> ' . $imgmeta['image_meta']['title'] . '</li>';
	echo '<li><span class="exif-title">' . __('Caption:', 'autofocus') . '</span> ' . $imgmeta['image_meta']['caption'] . '</li>';
	echo '<li><span class="exif-title">' . __('Camera:', 'autofocus') . '</span> ' . $imgmeta['image_meta']['camera'] . '</li>';
	echo '<li><span class="exif-title">' . __('Focal Length:', 'autofocus') . '</span> ' . $imgmeta['image_meta']['focal_length'] . 'mm</li>';
	echo '<li><span class="exif-title">' . __('Aperture:', 'autofocus') . '</span> f/' . $imgmeta['image_meta']['aperture'] . '</li>';
	echo '<li><span class="exif-title">' . __('ISO:', 'autofocus') . '</span> ' . $imgmeta['image_meta']['iso'] . '</li>';
	echo '<li><span class="exif-title">' . __('Shutter Speed:', 'autofocus') . '</span> ' . $display_shutterspeed_meta . '</li>';
	echo '</ul>';
}

/**
 *	Get the Post Thumbnail URL for the EXIF link
 */
function af_exif_link( $post_id = NULL, $size = 'full-post-thumbnail', $attr = '' ) {
	global $id;
	$post_id = ( NULL === $post_id ) ? $id : $post_id;
	$post_thumbnail_id = get_post_thumbnail_id( $post_id );
	$size = apply_filters( 'full-post-thumbnail', $size );
	if ( $post_thumbnail_id ) {
		$thumburl = get_attachment_link( $post_thumbnail_id, $size, false, $attr );
	} else {
		$thumburl = '';
	}
	return $thumburl;
}

/**
 *	Add Images/Video/Embeds to feeds
 *
 *	- Based on the Custom Fields for Feeds Plugin by Justin Tadlock: 
 *	- http://justintadlock.com/archives/2008/01/27/custom-fields-for-feeds-wordpress-plugin
 *
 */
function af_feed_content( $content ) {
	global $post, $id;
	
	$blog_key = substr( md5( get_bloginfo('url') ), 0, 16 );
	
	if ( !is_feed() ) return $content;
 
//	Is there a Video attached?
	if ( get_post_meta($post->ID, 'videoembed_value', true) ) {
		$af_video_url = get_post_meta($post->ID, 'videoembed_value', true);
		$mediafeed = '[embed width="600" height="400"]' . $af_video_url . '[/embed]';
	}

//	If there’s no video is there an image thumbnail?
	if ( has_post_thumbnail() ) {
		$mediafeed = the_post_thumbnail('medium');
	}

//	If there's a video or an image, display the media with the content
	if ($mediafeed !== '') {
		$content = '<p>' . $mediafeed . '</p><br />' . $content;
		return $content;
 
//	If there's no media, just display the content
	} else {
		$content = $content;
		return $content;
	}
}
add_filter('the_content', 'af_feed_content');

?>