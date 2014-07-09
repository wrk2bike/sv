<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */

get_header(); ?>

		<div id="container" class="<?php af_layout_class(); ?>">
			<div id="content" role="main">
		<header>
			<h1 class="page-title">
				<span> Catalogue</span>
			</h1>
				<?php
					// 	echo '<div class="archive-meta">' . 'Text to describe this category' . '</div>';
				?>
		</header>

<?php
	/* Since we called the_post() above, we need to
	 * rewind the loop back to the beginning that way
	 * we can run the loop properly, in full.
	 */
	//rewind_posts();

	//$archive_layout = of_get_option($shortname . '_archive_layout');

	/* Run the loop for the archives page to output the posts. */
	
	// SVEdit:  Copied this pafge from Archive.php, removed most everything, hardcoded the title and chagned the next line:
		// get_template_part( 'content', 'index' );
		get_template_part( 'content', 'autofocus' );
?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
