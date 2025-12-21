<?php
/**
 * Blog Cards Shortcode
 *
 * Usage: [blog_cards loadmore="true" perpage="6" category="sports"]
 *
 * @package foursix
 */

/**
 * Blog Cards Shortcode Function
 */
function foursix_blog_cards_shortcode( $atts ) {
    // Parse shortcode attributes
    $atts = shortcode_atts( array(
        'loadmore'  => 'false',
        'perpage'   => 6,
        'category'  => '',
        'order'     => 'DESC',
        'orderby'   => 'date',
    ), $atts, 'blog_cards' );

    // Convert loadmore to boolean
    $show_loadmore = filter_var( $atts['loadmore'], FILTER_VALIDATE_BOOLEAN );
    $posts_per_page = absint( $atts['perpage'] );
    $category = sanitize_text_field( $atts['category'] );

    // Generate unique ID for this instance
    $unique_id = 'blog-cards-' . uniqid();

    // Query arguments
    $query_args = array(
        'post_type'      => 'post',
        'posts_per_page' => $posts_per_page,
        'order'          => $atts['order'],
        'orderby'        => $atts['orderby'],
        'post_status'    => 'publish',
    );

    // Add category filter if specified
    if ( ! empty( $category ) ) {
        $query_args['category_name'] = $category;
    }

    // Execute query
    $blog_query = new WP_Query( $query_args );

    // Start output buffering
    ob_start();

    if ( $blog_query->have_posts() ) :
    ?>
    <div class="blog-cards-section">
        <div class="container">
            <div class="blog-cards-grid" id="<?php echo esc_attr( $unique_id ); ?>"
                 data-page="1"
                 data-perpage="<?php echo esc_attr( $posts_per_page ); ?>"
                 data-category="<?php echo esc_attr( $category ); ?>"
                 data-order="<?php echo esc_attr( $atts['order'] ); ?>"
                 data-orderby="<?php echo esc_attr( $atts['orderby'] ); ?>">

                <?php
                while ( $blog_query->have_posts() ) : $blog_query->the_post();
                    foursix_render_blog_card();
                endwhile;
                ?>

            </div>

            <?php if ( $show_loadmore && $blog_query->max_num_pages > 1 ) : ?>
                <div class="blog-cards-loadmore">
                    <button class="loadmore-btn"
                            data-target="<?php echo esc_attr( $unique_id ); ?>"
                            data-max-pages="<?php echo esc_attr( $blog_query->max_num_pages ); ?>">
                        <span class="loadmore-text">Load More Articles</span>
                        <span class="loadmore-loader" style="display: none;">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-dasharray="12 40" />
                            </svg>
                            Loading...
                        </span>
                    </button>
                    <div class="loadmore-status">
                        Showing <span class="current-count"><?php echo esc_html( $blog_query->post_count ); ?></span>
                        of <span class="total-count"><?php echo esc_html( $blog_query->found_posts ); ?></span> articles
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
    <?php
    endif;

    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode( 'blog_cards', 'foursix_blog_cards_shortcode' );

/**
 * Render Single Blog Card
 */
function foursix_render_blog_card() {
    // Get post data
    $post_id = get_the_ID();
    $reading_time = foursix_get_reading_time( $post_id );
    $author_name = get_the_author();
    $category = get_the_category();
    $category_name = ! empty( $category ) ? esc_html( $category[0]->name ) : 'Uncategorized';
    ?>
    <article class="blog-card" data-post-id="<?php echo esc_attr( $post_id ); ?>">
        <div class="blog-card-image">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'medium', array( 'class' => 'card-thumbnail' ) ); ?>
            <?php else : ?>
                <div class="trend-icon">
                    <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 45L27.5 32.5L37.5 42.5L52.5 15" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M45 15H52.5V22.5" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            <?php endif; ?>
        </div>
        <div class="blog-card-content">
            <span class="read-time"><?php echo esc_html( $reading_time ); ?> min read</span>
            <h3 class="blog-card-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
            <p class="blog-card-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20, '...' ) ); ?></p>
            <div class="blog-card-footer">
                <div class="blog-card-meta">
                    <span class="blog-date">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.6667 2.66669H3.33333C2.59695 2.66669 2 3.26364 2 4.00002V13.3334C2 14.0697 2.59695 14.6667 3.33333 14.6667H12.6667C13.403 14.6667 14 14.0697 14 13.3334V4.00002C14 3.26364 13.403 2.66669 12.6667 2.66669Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10.6667 1.33331V3.99998" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M5.33333 1.33331V3.99998" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 6.66669H14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <?php echo get_the_date(); ?>
                    </span>
                    <span class="blog-author">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.3333 14V12.6667C13.3333 11.9594 13.0524 11.2811 12.5523 10.781C12.0522 10.281 11.3739 10 10.6667 10H5.33333C4.62609 10 3.94781 10.281 3.44772 10.781C2.94762 11.2811 2.66667 11.9594 2.66667 12.6667V14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8 7.33333C9.47276 7.33333 10.6667 6.13943 10.6667 4.66667C10.6667 3.19391 9.47276 2 8 2C6.52724 2 5.33333 3.19391 5.33333 4.66667C5.33333 6.13943 6.52724 7.33333 8 7.33333Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <?php echo esc_html( $author_name ); ?>
                    </span>
                </div>
                <a href="<?php the_permalink(); ?>" class="read-more">
                    Read More
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.16666 10H15.8333" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10 4.16669L15.8333 10L10 15.8334" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
        </div>
    </article>
    <?php
}

/**
 * Calculate Reading Time
 */
function foursix_get_reading_time( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    $content = get_post_field( 'post_content', $post_id );
    $word_count = str_word_count( strip_tags( $content ) );
    $reading_time = ceil( $word_count / 200 ); // 200 words per minute

    return max( 1, $reading_time ); // Minimum 1 minute
}

/**
 * AJAX Load More Handler
 */
function foursix_load_more_posts() {
    // Verify nonce
    check_ajax_referer( 'foursix_loadmore_nonce', 'nonce' );

    // Get parameters
    $page = isset( $_POST['page'] ) ? absint( $_POST['page'] ) : 1;
    $perpage = isset( $_POST['perpage'] ) ? absint( $_POST['perpage'] ) : 6;
    $category = isset( $_POST['category'] ) ? sanitize_text_field( $_POST['category'] ) : '';
    $order = isset( $_POST['order'] ) ? sanitize_text_field( $_POST['order'] ) : 'DESC';
    $orderby = isset( $_POST['orderby'] ) ? sanitize_text_field( $_POST['orderby'] ) : 'date';

    // Query arguments
    $query_args = array(
        'post_type'      => 'post',
        'posts_per_page' => $perpage,
        'paged'          => $page,
        'order'          => $order,
        'orderby'        => $orderby,
        'post_status'    => 'publish',
    );

    // Add category filter if specified
    if ( ! empty( $category ) ) {
        $query_args['category_name'] = $category;
    }

    // Execute query
    $blog_query = new WP_Query( $query_args );

    // Response data
    $response = array(
        'success' => false,
        'html'    => '',
        'has_more' => false,
        'current_page' => $page,
        'max_pages' => 0,
        'total_posts' => 0,
        'loaded_count' => 0,
    );

    if ( $blog_query->have_posts() ) {
        ob_start();

        while ( $blog_query->have_posts() ) {
            $blog_query->the_post();
            foursix_render_blog_card();
        }

        $response['success'] = true;
        $response['html'] = ob_get_clean();
        $response['has_more'] = $page < $blog_query->max_num_pages;
        $response['max_pages'] = $blog_query->max_num_pages;
        $response['total_posts'] = $blog_query->found_posts;
        $response['loaded_count'] = ( $page * $perpage );
    }

    wp_reset_postdata();
    wp_send_json( $response );
}
add_action( 'wp_ajax_foursix_load_more', 'foursix_load_more_posts' );
add_action( 'wp_ajax_nopriv_foursix_load_more', 'foursix_load_more_posts' );

/**
 * Enqueue Load More Scripts
 */
function foursix_blog_cards_scripts() {
    wp_enqueue_script(
        'foursix-blog-cards',
        get_template_directory_uri() . '/assets/js/blog-cards.js',
        array( 'jquery' ),
        '1.0.0',
        true
    );

    // Localize script with AJAX URL and nonce
    wp_localize_script(
        'foursix-blog-cards',
        'foursixBlogCards',
        array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'foursix_loadmore_nonce' ),
        )
    );
}
add_action( 'wp_enqueue_scripts', 'foursix_blog_cards_scripts' );
