<?php
/**
 * Template Name: Custom Full Width Template
 * Template Post Type: page
 *
 * Custom page template with full width layout
 *
 * @package notout
 */

get_header();
?>

<div id="primary" class="content-area custom-template">
	<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<!-- Hero Section -->
			<section class="hero-section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 80px 20px; text-align: center; color: white;">
				<div class="container">
					<h1 style="font-size: 3em; margin-bottom: 20px;"><?php the_title(); ?></h1>
					<p style="font-size: 1.2em; max-width: 800px; margin: 0 auto;">
						<?php echo get_the_excerpt() ? get_the_excerpt() : 'আপনার পৃষ্ঠার বিবরণ এখানে যোগ করুন'; ?>
					</p>
				</div>
			</section>

			<!-- Main Content Section -->
			<section class="main-content-section" style="padding: 60px 20px;">
				<div class="container">
					<div class="entry-content">
						<?php
						the_content();

						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'notout' ),
							'after'  => '</div>',
						) );
						?>
					</div>
				</div>
			</section>

			<!-- Features Section -->
			<section class="features-section" style="background: #f8f9fa; padding: 60px 20px;">
				<div class="container">
					<h2 style="text-align: center; margin-bottom: 40px; font-size: 2.5em;">বৈশিষ্ট্য</h2>
					<div class="features-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">

						<div class="feature-box" style="background: white; padding: 30px; border-radius: 10px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
							<div class="feature-icon" style="font-size: 3em; margin-bottom: 15px;">🎯</div>
							<h3 style="margin-bottom: 10px;">নিখুঁত নির্ভুলতা</h3>
							<p>সর্বোচ্চ মানের সেবা প্রদান</p>
						</div>

						<div class="feature-box" style="background: white; padding: 30px; border-radius: 10px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
							<div class="feature-icon" style="font-size: 3em; margin-bottom: 15px;">⚡</div>
							<h3 style="margin-bottom: 10px;">দ্রুত গতি</h3>
							<p>তাৎক্ষণিক প্রসেসিং</p>
						</div>

						<div class="feature-box" style="background: white; padding: 30px; border-radius: 10px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
							<div class="feature-icon" style="font-size: 3em; margin-bottom: 15px;">🛡️</div>
							<h3 style="margin-bottom: 10px;">সম্পূর্ণ নিরাপদ</h3>
							<p>SSL এনক্রিপশন সুরক্ষা</p>
						</div>

						<div class="feature-box" style="background: white; padding: 30px; border-radius: 10px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
							<div class="feature-icon" style="font-size: 3em; margin-bottom: 15px;">📱</div>
							<h3 style="margin-bottom: 10px;">মোবাইল বান্ধব</h3>
							<p>সব ডিভাইসে কাজ করে</p>
						</div>

					</div>
				</div>
			</section>

			<!-- CTA Section -->
			<section class="cta-section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 60px 20px; text-align: center; color: white;">
				<div class="container">
					<h2 style="font-size: 2.5em; margin-bottom: 20px;">এখনই শুরু করুন</h2>
					<p style="font-size: 1.2em; margin-bottom: 30px;">আজই যোগ দিয়ে বিশেষ অফার পান</p>
					<a href="#" style="display: inline-block; background: white; color: #667eea; padding: 15px 40px; border-radius: 50px; text-decoration: none; font-weight: bold; font-size: 1.1em; transition: transform 0.3s;">
						যোগ দিন
					</a>
				</div>
			</section>

			<?php
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
			?>

		</article>

		<?php
		endwhile; // End of the loop.
		?>

	</main>
</div>

<style>
/* Custom Template Styles */
.custom-template .container {
	max-width: 1200px;
	margin: 0 auto;
	padding: 0 15px;
}

.custom-template .entry-content {
	font-size: 1.1em;
	line-height: 1.8;
}

.custom-template .entry-content h2 {
	margin-top: 40px;
	margin-bottom: 20px;
	font-size: 2em;
}

.custom-template .entry-content h3 {
	margin-top: 30px;
	margin-bottom: 15px;
	font-size: 1.5em;
}

.custom-template .entry-content p {
	margin-bottom: 20px;
}

.custom-template .entry-content ul,
.custom-template .entry-content ol {
	margin-bottom: 20px;
	padding-left: 30px;
}

.custom-template .entry-content li {
	margin-bottom: 10px;
}

/* Responsive Design */
@media (max-width: 768px) {
	.hero-section h1 {
		font-size: 2em !important;
	}

	.hero-section p {
		font-size: 1em !important;
	}

	.features-grid {
		grid-template-columns: 1fr !important;
	}

	.cta-section h2 {
		font-size: 1.8em !important;
	}
}

/* Hover Effects */
.feature-box {
	transition: transform 0.3s, box-shadow 0.3s;
}

.feature-box:hover {
	transform: translateY(-5px);
	box-shadow: 0 5px 20px rgba(0,0,0,0.15) !important;
}

.cta-section a:hover {
	transform: scale(1.05);
}
</style>

<?php
get_footer();
?>
