<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package foursix
 */

get_header();
?>
<div class="foursix-single-post-wrapper">
	<div id="primary" class="foursix-content-area">
		<main id="main" class="foursix-site-main">

			<?php
			/**
			 * foursix_before_main_content hook
			 */
			do_action( 'foursix_before_main_content' );

			while ( have_posts() ) :
				the_post();

				// Use custom single post template
				get_template_part( 'template-parts/post/content', 'single' );

			endwhile; // End of the loop.

			/**
			 * foursix_after_main_content hook
			 */
			do_action( 'foursix_after_main_content' );
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div>


<?php
get_footer();
