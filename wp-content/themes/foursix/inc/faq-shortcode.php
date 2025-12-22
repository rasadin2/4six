<?php
/**
 * FAQ Shortcode
 */

/**
 * FAQ List Shortcode - Display FAQs grouped by category with accordion
 *
 * Usage: [faq_list category="slug"] or [faq_list] for all
 */
function foursix_faq_list_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'category' => '',
        'orderby'  => 'menu_order',
        'order'    => 'ASC',
    ), $atts, 'faq_list' );

    ob_start();

    // Get all FAQ categories
    $category_args = array(
        'taxonomy'   => 'faq_category',
        'hide_empty' => true,
        'orderby'    => 'name',
        'order'      => 'ASC',
    );

    // If specific category requested
    if ( ! empty( $atts['category'] ) ) {
        $category_args['slug'] = $atts['category'];
    }

    $categories = get_terms( $category_args );

    if ( empty( $categories ) || is_wp_error( $categories ) ) {
        return '<p>No FAQs found.</p>';
    }

    ?>
    <div class="faq-list-container">
        <?php foreach ( $categories as $category ) :
            // Get FAQs for this category
            $faq_args = array(
                'post_type'      => 'faq',
                'posts_per_page' => -1,
                'orderby'        => $atts['orderby'],
                'order'          => $atts['order'],
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'faq_category',
                        'field'    => 'term_id',
                        'terms'    => $category->term_id,
                    ),
                ),
            );

            $faqs = new WP_Query( $faq_args );

            if ( ! $faqs->have_posts() ) {
                continue;
            }

            // Get category icon (from first FAQ or default)
            $icon_type = 'question';
            if ( $faqs->have_posts() ) {
                $faqs->the_post();
                $first_faq_icon = get_post_meta( get_the_ID(), '_faq_icon_type', true );
                if ( $first_faq_icon ) {
                    $icon_type = $first_faq_icon;
                }
                wp_reset_postdata();
            }

            $faq_count = $faqs->post_count;
            ?>

            <div class="faq-category-section">
                <div class="faq-category-header">
                    <div class="faq-category-icon">
                        <?php if ( $icon_type === 'lock' ) : ?>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="5" y="11" width="14" height="10" rx="2" stroke="currentColor" stroke-width="2"/>
                                <path d="M8 11V7a4 4 0 0 1 8 0v4" stroke="currentColor" stroke-width="2"/>
                                <circle cx="12" cy="16" r="1" fill="currentColor"/>
                            </svg>
                        <?php elseif ( $icon_type === 'lightbulb' ) : ?>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 18h6M10 22h4M12 2v1M4.22 4.22l.7.7M2 12h1M20.78 4.22l-.7.7M21 12h1M12 6a6 6 0 0 1 3.5 10.89V19a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-2.11A6 6 0 0 1 12 6z" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        <?php elseif ( $icon_type === 'tools' ) : ?>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        <?php elseif ( $icon_type === 'money' ) : ?>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                                <path d="M12 6v12M9.5 9a2.5 2.5 0 0 1 5 0c0 1.5-2 2-2 2s2 .5 2 2a2.5 2.5 0 0 1-5 0" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        <?php else : ?>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3M12 17h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        <?php endif; ?>
                    </div>
                    <h2 class="faq-category-title"><?php echo esc_html( $category->name ); ?></h2>
                    <span class="faq-count-badge"><?php echo esc_html( $faq_count ); ?></span>
                </div>

                <div class="faq-items">
                    <?php
                    $faqs->rewind_posts();
                    $faq_index = 0;
                    while ( $faqs->have_posts() ) :
                        $faqs->the_post();
                        $faq_id = 'faq-' . get_the_ID();
                        ?>
                        <div class="faq-item">
                            <button class="faq-question"
                                    aria-expanded="false"
                                    aria-controls="<?php echo esc_attr( $faq_id ); ?>"
                                    data-faq-toggle>
                                <span class="faq-question-icon">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.5"/>
                                        <path d="M6 6a2 2 0 0 1 4 0c0 1.5-2 2-2 2M8 11h.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                </span>
                                <span class="faq-question-text"><?php the_title(); ?></span>
                                <span class="faq-toggle-icon">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 7.5L10 12.5L15 7.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </span>
                            </button>
                            <div class="faq-answer" id="<?php echo esc_attr( $faq_id ); ?>" hidden>
                                <div class="faq-answer-content">
                                    <?php the_content(); ?>
                                </div>
                            </div>
                        </div>
                    <?php
                        $faq_index++;
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>

        <?php endforeach; ?>
    </div>

    <script>
    (function() {
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('[data-faq-toggle]');

            toggleButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';
                    const answerId = this.getAttribute('aria-controls');
                    const answer = document.getElementById(answerId);

                    // Toggle current FAQ
                    this.setAttribute('aria-expanded', !isExpanded);
                    this.classList.toggle('active');

                    if (answer) {
                        if (isExpanded) {
                            answer.hidden = true;
                        } else {
                            answer.hidden = false;
                        }
                    }
                });
            });
        });
    })();
    </script>

    <?php
    return ob_get_clean();
}
add_shortcode( 'faq_list', 'foursix_faq_list_shortcode' );

/**
 * Enqueue FAQ Styles
 */
function foursix_enqueue_faq_styles() {
    $post_content = get_post()->post_content ?? '';

    if ( has_shortcode( $post_content, 'faq_list' ) || is_post_type_archive( 'faq' ) || is_tax( 'faq_category' ) ) {
        wp_enqueue_style( 'foursix-faq', get_template_directory_uri() . '/assets/css/faq.css', array(), '1.0.0' );
    }
}
add_action( 'wp_enqueue_scripts', 'foursix_enqueue_faq_styles' );
