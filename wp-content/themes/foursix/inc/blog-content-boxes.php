<?php
/**
 * Blog Content Boxes - Shortcodes for special content elements in blog posts
 *
 * @package foursix
 */

/**
 * Markets Box Shortcode
 *
 * Usage: [markets_box title="Top IPL Betting Markets"]
 * Content: Add list items as shortcode content
 *
 * Example:
 * [markets_box title="Top IPL Betting Markets"]
 * Match Winner - Predict which team will win the match
 * Top Batsman - Bet on the highest run-scorer in the match
 * Total Runs - Over/under on total runs scored
 * Tournament Winner - Long-term bet on the IPL champion
 * [/markets_box]
 */
function foursix_markets_box_shortcode( $atts, $content = null ) {
    $atts = shortcode_atts( array(
        'title' => 'Key Markets',
    ), $atts, 'markets_box' );

    // Process content to extract list items
    $items = array();
    if ( $content ) {
        $lines = explode( "\n", trim( $content ) );
        foreach ( $lines as $line ) {
            $line = trim( $line );
            if ( ! empty( $line ) ) {
                // Check if line contains " - " separator
                if ( strpos( $line, ' - ' ) !== false ) {
                    list( $label, $description ) = explode( ' - ', $line, 2 );
                    $items[] = array(
                        'label' => trim( $label ),
                        'description' => trim( $description ),
                    );
                } else {
                    $items[] = array(
                        'label' => '',
                        'description' => $line,
                    );
                }
            }
        }
    }

    ob_start();
    ?>
    <div class="blog-markets-box">
        <h4><?php echo esc_html( $atts['title'] ); ?></h4>
        <ul class="blog-markets-list">
            <?php foreach ( $items as $item ) : ?>
                <li>
                    <?php if ( ! empty( $item['label'] ) ) : ?>
                        <strong><?php echo esc_html( $item['label'] ); ?>:</strong>
                    <?php endif; ?>
                    <span><?php echo esc_html( $item['description'] ); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'markets_box', 'foursix_markets_box_shortcode' );

/**
 * CTA Box Shortcode
 *
 * Usage: [cta_box title="Ready to Place Your Bets?" button_text="Sign Up Now" button_url="#"]
 * Content will be used as the description text
 *
 * Example:
 * [cta_box title="Ready to Place Your Bets?" button_text="Sign Up Now" button_url="/register"]
 * Join 4six today and start betting on your favorite sports and casino games with the best odds in Bangladesh!
 * [/cta_box]
 */
function foursix_cta_box_shortcode( $atts, $content = null ) {
    $atts = shortcode_atts( array(
        'title'       => 'Ready to Get Started?',
        'button_text' => 'Sign Up Now',
        'button_url'  => '#',
    ), $atts, 'cta_box' );

    ob_start();
    ?>
    <div class="blog-cta-box">
        <h4><?php echo esc_html( $atts['title'] ); ?></h4>
        <?php if ( $content ) : ?>
            <p><?php echo esc_html( trim( $content ) ); ?></p>
        <?php endif; ?>
        <a href="<?php echo esc_url( $atts['button_url'] ); ?>" class="blog-cta-button">
            <?php echo esc_html( $atts['button_text'] ); ?>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
        </a>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'cta_box', 'foursix_cta_box_shortcode' );

/**
 * Info Box Shortcode (Generic styled box)
 *
 * Usage: [info_box title="Important Note" style="teal|orange|blue"]
 *
 * Example:
 * [info_box title="Important Note" style="teal"]
 * This is some important information to highlight in your blog post.
 * [/info_box]
 */
function foursix_info_box_shortcode( $atts, $content = null ) {
    $atts = shortcode_atts( array(
        'title' => '',
        'style' => 'teal', // teal, orange, blue
    ), $atts, 'info_box' );

    $box_class = 'blog-info-box blog-info-box-' . sanitize_html_class( $atts['style'] );

    ob_start();
    ?>
    <div class="<?php echo esc_attr( $box_class ); ?>">
        <?php if ( ! empty( $atts['title'] ) ) : ?>
            <h4><?php echo esc_html( $atts['title'] ); ?></h4>
        <?php endif; ?>
        <?php if ( $content ) : ?>
            <div class="blog-info-box-content">
                <?php echo wpautop( do_shortcode( $content ) ); ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'info_box', 'foursix_info_box_shortcode' );
