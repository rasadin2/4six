<?php
/**
 * Template part for displaying single blog post with custom design
 *
 * @package foursix
 */
?>

<div class="blog-single-container">
    <!-- Back to Blog Button -->
    <a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" class="back-to-blog">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Blog
    </a>

    <article id="post-<?php the_ID(); ?>" <?php post_class( 'blog-single-article' ); ?>>

        <!-- Featured Image with Icon Overlay -->
        <div class="blog-featured-image">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'full' ); ?>
            <?php endif; ?>

            <!-- Default Icon Overlay if no featured image or always visible -->
            <div class="blog-featured-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
        </div>

        <!-- Meta Information Bar -->
        <div class="blog-meta-bar">
            <div class="blog-meta-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span><?php echo get_the_date( 'F j, Y' ); ?></span>
            </div>

            <div class="blog-meta-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span><?php echo get_the_author(); ?></span>
            </div>

            <div class="blog-meta-item">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span><?php echo foursix_reading_time(); ?> min read</span>
            </div>
        </div>

        <!-- Title -->
        <h1 class="blog-title"><?php the_title(); ?></h1>

        <!-- Excerpt -->
        <?php if ( has_excerpt() ) : ?>
            <div class="blog-excerpt">
                <?php the_excerpt(); ?>
            </div>
        <?php endif; ?>

        <!-- Content -->
        <div class="blog-content entry-content">
            <?php
            the_content( sprintf(
                wp_kses(
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
        </div>

    </article>

    <!-- CTA Section (Before Related Posts) -->
    <?php
    $cta_data = foursix_get_blog_cta_data( get_the_ID() );

    if ( $cta_data ) :
    ?>
        <div class="blog-cta-box">
            <h4><?php echo esc_html( $cta_data['title'] ); ?></h4>
            <p><?php echo esc_html( $cta_data['description'] ); ?></p>
            <a href="<?php echo esc_url( $cta_data['button_url'] ); ?>" class="blog-cta-button">
                <?php echo esc_html( $cta_data['button_text'] ); ?>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    <?php endif; ?>

    <!-- Related Posts Section -->
    <?php
    // Get current post's categories
    $categories = get_the_category();
    $category_ids = array();

    if ( $categories ) {
        foreach ( $categories as $category ) {
            $category_ids[] = $category->term_id;
        }
    }

    // Query for related posts
    $related_args = array(
        'post_type'      => 'post',
        'posts_per_page' => 2,
        'post__not_in'   => array( get_the_ID() ),
        'orderby'        => 'rand',
        'post_status'    => 'publish',
    );

    // Add category filter if categories exist
    if ( ! empty( $category_ids ) ) {
        $related_args['category__in'] = $category_ids;
    }

    $related_posts = new WP_Query( $related_args );

    if ( $related_posts->have_posts() ) :
    ?>
        <div class="blog-related-section">
            <h3 class="blog-related-title">Related Posts</h3>

            <div class="blog-bottom-nav">
                <?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="blog-nav-card">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="blog-nav-card-thumb">
                                <?php the_post_thumbnail( 'medium' ); ?>
                            </div>
                        <?php endif; ?>

                        <h4><?php the_title(); ?></h4>

                        <?php if ( has_excerpt() ) : ?>
                            <p><?php echo wp_trim_words( get_the_excerpt(), 15, '...' ); ?></p>
                        <?php else : ?>
                            <p><?php echo wp_trim_words( get_the_content(), 15, '...' ); ?></p>
                        <?php endif; ?>

                        <span class="blog-nav-card-link">
                            Read More
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </span>
                    </a>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    <?php endif; ?>

</div>
