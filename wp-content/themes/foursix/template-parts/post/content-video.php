<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package foursix
 */
/**
 * Options value
 */
$foursix_options = foursix_theme_options();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if( 'default' == $foursix_options['foursix_header_type'] ) : ?>
	<header class="entry-header">
        <p>Format: Video</p>
		<?php  
		/**
		 * foursix_before_entry_title hook
		 */
		do_action( 'foursix_before_entry_title' );

		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		/**
		 * foursix_after_entry_title hook
		 * 
		 * foursix_entry_meta - 10
		 */
		do_action( 'foursix_after_entry_title' );
		?>
	</header><!-- .entry-header -->
	<?php endif; ?>

	<?php foursix_post_thumbnail(); ?>

	<?php  
	/**
	 * foursix_before_content hook
	 */
	do_action( 'foursix_before_content' );
	?>
	<div class="entry-content">
		<?php
		the_content( sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'foursix' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'foursix' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<?php  
	/**
	 * foursix_after_content hook
	 */
	do_action( 'foursix_after_content' );
	?>

	<footer class="entry-footer">
		<?php foursix_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
