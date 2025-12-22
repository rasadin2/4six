<?php
/**
 * Promotions Shortcode
 *
 * @package foursix
 */

/**
 * Register Promotions Shortcode
 */
function foursix_promotions_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'count'     => 3,
        'show_all'  => 'true',
        'orderby'   => 'menu_order',
        'order'     => 'ASC',
    ), $atts );

    $args = array(
        'post_type'      => 'promotion',
        'posts_per_page' => intval( $atts['count'] ),
        'orderby'        => sanitize_text_field( $atts['orderby'] ),
        'order'          => sanitize_text_field( $atts['order'] ),
        'post_status'    => 'publish',
    );

    if ( $atts['orderby'] === 'menu_order' ) {
        $args['meta_key'] = '_promotion_menu_order';
        $args['orderby'] = 'meta_value_num';
    }

    $query = new WP_Query( $args );

    if ( ! $query->have_posts() ) {
        return '';
    }

    ob_start();
    ?>

    <div class="promotions-section">
        <div class="promotions-header">
            <div class="exclusive-badge">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 0L12.2451 6.90983H19.5106L13.6327 11.1803L15.8779 18.0902L10 13.8197L4.12215 18.0902L6.36729 11.1803L0.489435 6.90983H7.75486L10 0Z" fill="currentColor"/>
                </svg>
                Exclusive Offers
            </div>
            <h2 class="promotions-title">Amazing Promotions & Bonuses</h2>
            <p class="promotions-description">Maximize your winnings with our exclusive promotions designed for Bangladeshi players. More bonuses, more wins!</p>
        </div>

        <div class="promotions-grid">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <?php
                $badge_text = get_post_meta( get_the_ID(), '_promotion_badge_text', true );
                $badge_color = get_post_meta( get_the_ID(), '_promotion_badge_color', true ) ?: 'green';
                $icon_type = get_post_meta( get_the_ID(), '_promotion_icon_type', true ) ?: 'gift';
                $icon_value = get_post_meta( get_the_ID(), '_promotion_icon_value', true );
                $subtitle = get_post_meta( get_the_ID(), '_promotion_subtitle', true );
                $button_text = get_post_meta( get_the_ID(), '_promotion_button_text', true ) ?: 'Claim Bonus';
                $button_url = get_post_meta( get_the_ID(), '_promotion_button_url', true ) ?: '#';
                $button_color = get_post_meta( get_the_ID(), '_promotion_button_color', true ) ?: 'green';
                ?>

                <div class="promotion-card">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="promotion-image">
                            <?php the_post_thumbnail( 'medium', array( 'class' => 'promotion-img' ) ); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( $badge_text ) : ?>
                        <div class="promotion-badge badge-<?php echo esc_attr( $badge_color ); ?>">
                            <?php echo esc_html( $badge_text ); ?>
                        </div>
                    <?php endif; ?>

                    <div class="promotion-icon">
                        <?php if ( $icon_type === 'gift' ) : ?>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 12v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6M2 7h20v5H2zM12 22V7M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7zM12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="icon-currency">৳</span>
                        <?php elseif ( $icon_type === 'trophy' ) : ?>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6M18 9h1.5a2.5 2.5 0 0 0 0-5H18M4 22h16M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22M18 2H6v7a6 6 0 0 0 12 0V2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        <?php else : ?>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        <?php endif; ?>
                        <span class="icon-value"><?php echo esc_html( $icon_value ); ?><?php echo $icon_type !== 'gift' ? '%' : ''; ?></span>
                    </div>

                    <div class="promotion-content">
                        <h3 class="promotion-card-title"><?php the_title(); ?></h3>
                        <?php if ( $subtitle ) : ?>
                            <p class="promotion-subtitle"><?php echo esc_html( $subtitle ); ?></p>
                        <?php endif; ?>
                        <div class="promotion-description">
                            <?php the_content(); ?>
                        </div>
                        <a href="<?php echo esc_url( $button_url ); ?>" class="promotion-button button-<?php echo esc_attr( $button_color ); ?>">
                            <?php echo esc_html( $button_text ); ?>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                </div>

            <?php endwhile; ?>
        </div>

        <?php if ( $atts['show_all'] === 'true' ) : ?>
            <div class="promotions-footer">
                <a href="<?php echo esc_url( get_post_type_archive_link( 'promotion' ) ); ?>" class="view-all-button">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.5 5L12.5 10L7.5 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    View All Promotions
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.5 5L12.5 10L7.5 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <p class="promotions-terms">*Terms and conditions apply. Minimum deposit requirements may vary. Please read the full promotion details.</p>
            </div>
        <?php endif; ?>
    </div>

    <?php
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode( 'promotions', 'foursix_promotions_shortcode' );

/**
 * Promotion Detail Shortcode
 */
function foursix_promotion_detail_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'id' => 0,
    ), $atts );

    $promotion_id = intval( $atts['id'] );

    if ( ! $promotion_id ) {
        return '<p>' . __( 'Please specify a promotion ID.', 'foursix' ) . '</p>';
    }

    $promotion = get_post( $promotion_id );

    if ( ! $promotion || $promotion->post_type !== 'promotion' ) {
        return '<p>' . __( 'Promotion not found.', 'foursix' ) . '</p>';
    }

    // Get meta data
    $badge_text = get_post_meta( $promotion_id, '_promotion_badge_text', true );
    $badge_color = get_post_meta( $promotion_id, '_promotion_badge_color', true ) ?: 'green';
    $icon_type = get_post_meta( $promotion_id, '_promotion_icon_type', true ) ?: 'gift';
    $icon_value = get_post_meta( $promotion_id, '_promotion_icon_value', true );
    $subtitle = get_post_meta( $promotion_id, '_promotion_subtitle', true );
    $button_text = get_post_meta( $promotion_id, '_promotion_button_text', true ) ?: 'Claim This Offer';
    $button_url = get_post_meta( $promotion_id, '_promotion_button_url', true ) ?: '#';
    $terms_conditions = get_post_meta( $promotion_id, '_promotion_terms_conditions', true );
    $how_to_claim = get_post_meta( $promotion_id, '_promotion_how_to_claim', true );

    ob_start();
    ?>

    <div class="promotion-detail-section">
        <div class="promotion-detail-header">
            <?php if ( $badge_text ) : ?>
                <div class="promotion-detail-badge">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 7.5H14.5L12 2L9.5 7.5H4L8.5 11L6.5 16.5L12 13L17.5 16.5L15.5 11L20 7.5Z" fill="currentColor"/>
                    </svg>
                    <?php echo esc_html( $badge_text ); ?>
                </div>
            <?php endif; ?>

            <h2 class="promotion-detail-title">
                <?php echo esc_html( $promotion->post_title ); ?>
                <?php if ( $subtitle ) : ?>
                    <span class="promotion-detail-subtitle"> - <?php echo esc_html( $subtitle ); ?></span>
                <?php endif; ?>
            </h2>

            <div class="promotion-detail-description">
                <?php echo wpautop( $promotion->post_content ); ?>
            </div>
        </div>

        <div class="promotion-detail-content">
            <div class="promotion-detail-grid">
                <!-- Terms & Conditions Column -->
                <div class="promotion-detail-column">
                    <div class="promotion-detail-box">
                        <h3 class="promotion-detail-box-title">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="2"/>
                                <path d="M10 6V10L13 13" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            Terms & Conditions
                        </h3>
                        <?php if ( $terms_conditions ) : ?>
                            <ul class="promotion-detail-list">
                                <?php
                                $terms_lines = explode( "\n", $terms_conditions );
                                foreach ( $terms_lines as $term ) {
                                    $term = trim( $term );
                                    if ( ! empty( $term ) ) {
                                        echo '<li>' . esc_html( $term ) . '</li>';
                                    }
                                }
                                ?>
                            </ul>
                        <?php else : ?>
                            <p class="no-content"><?php _e( 'No terms and conditions specified.', 'foursix' ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- How to Claim Column -->
                <div class="promotion-detail-column">
                    <div class="promotion-detail-box">
                        <h3 class="promotion-detail-box-title">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="2"/>
                                <circle cx="10" cy="10" r="3" fill="currentColor"/>
                            </svg>
                            How to Claim
                        </h3>
                        <?php if ( $how_to_claim ) : ?>
                            <ol class="promotion-detail-steps">
                                <?php
                                $claim_lines = explode( "\n", $how_to_claim );
                                foreach ( $claim_lines as $step ) {
                                    $step = trim( $step );
                                    if ( ! empty( $step ) ) {
                                        echo '<li>' . esc_html( $step ) . '</li>';
                                    }
                                }
                                ?>
                            </ol>
                        <?php else : ?>
                            <p class="no-content"><?php _e( 'No claim instructions specified.', 'foursix' ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="promotion-detail-footer">
            <a href="<?php echo esc_url( $button_url ); ?>" class="promotion-detail-button">
                <?php echo esc_html( $button_text ); ?>
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.5 5L12.5 10L7.5 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
    </div>

    <?php
    return ob_get_clean();
}
add_shortcode( 'promotion_detail', 'foursix_promotion_detail_shortcode' );

/**
 * Promotions List Shortcode (Compact Detail Cards)
 */
function foursix_promotions_list_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'count'    => -1,
        'orderby'  => 'menu_order',
        'order'    => 'ASC',
    ), $atts );

    $args = array(
        'post_type'      => 'promotion',
        'posts_per_page' => intval( $atts['count'] ),
        'orderby'        => sanitize_text_field( $atts['orderby'] ),
        'order'          => sanitize_text_field( $atts['order'] ),
        'post_status'    => 'publish',
    );

    if ( $atts['orderby'] === 'menu_order' ) {
        $args['meta_key'] = '_promotion_menu_order';
        $args['orderby'] = 'meta_value_num';
    }

    $query = new WP_Query( $args );

    if ( ! $query->have_posts() ) {
        return '';
    }

    ob_start();
    ?>

    <div class="promotions-list-container">
        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <?php
            $badge_text = get_post_meta( get_the_ID(), '_promotion_badge_text', true );
            $badge_color = get_post_meta( get_the_ID(), '_promotion_badge_color', true ) ?: 'green';
            $icon_type = get_post_meta( get_the_ID(), '_promotion_icon_type', true ) ?: 'gift';
            $icon_value = get_post_meta( get_the_ID(), '_promotion_icon_value', true );
            $subtitle = get_post_meta( get_the_ID(), '_promotion_subtitle', true );
            $button_text = get_post_meta( get_the_ID(), '_promotion_button_text', true ) ?: 'Claim This Offer';
            $button_url = get_post_meta( get_the_ID(), '_promotion_button_url', true ) ?: '#';
            $button_color = get_post_meta( get_the_ID(), '_promotion_button_color', true ) ?: 'green';
            $card_color = get_post_meta( get_the_ID(), '_promotion_card_color', true ) ?: 'teal';
            $terms_conditions = get_post_meta( get_the_ID(), '_promotion_terms_conditions', true );
            $how_to_claim = get_post_meta( get_the_ID(), '_promotion_how_to_claim', true );
            ?>

            <div class="promo-list-card card-color-<?php echo esc_attr( $card_color ); ?>">
                <!-- Header (Colored Section) -->
                <div class="promo-list-header">
                    <div class="promo-list-badge-wrapper">
                        <?php if ( $icon_type === 'gift' ) : ?>
                            <svg class="promo-list-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 12v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6M2 7h20v5H2zM12 22V7M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7zM12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        <?php elseif ( $icon_type === 'trophy' ) : ?>
                            <svg class="promo-list-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6M18 9h1.5a2.5 2.5 0 0 0 0-5H18M4 22h16M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22M18 2H6v7a6 6 0 0 0 12 0V2z" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        <?php else : ?>
                            <svg class="promo-list-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        <?php endif; ?>
                        <?php if ( $badge_text ) : ?>
                            <span class="promo-list-badge"><?php echo esc_html( $badge_text ); ?></span>
                        <?php endif; ?>
                    </div>
                    <h3 class="promo-list-title"><?php the_title(); ?></h3>
                    <?php if ( $subtitle ) : ?>
                        <p class="promo-list-subtitle"><?php echo esc_html( $subtitle ); ?></p>
                    <?php endif; ?>
                    <div class="promo-list-description">
                        <?php the_content(); ?>
                    </div>
                </div>

                <!-- Content (Dark Section) -->
                <div class="promo-list-content">
                    <div class="promo-list-grid">
                        <!-- Terms & Conditions -->
                        <div class="promo-list-column">
                            <h4 class="promo-list-column-title">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="8" cy="8" r="6" stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M8 5V8L10 10" stroke="currentColor" stroke-width="1.5"/>
                                </svg>
                                Terms & Conditions
                            </h4>
                            <?php if ( $terms_conditions ) : ?>
                                <ul class="promo-list-items">
                                    <?php
                                    $terms_lines = explode( "\n", $terms_conditions );
                                    foreach ( $terms_lines as $term ) {
                                        $term = trim( $term );
                                        if ( ! empty( $term ) ) {
                                            echo '<li>' . esc_html( $term ) . '</li>';
                                        }
                                    }
                                    ?>
                                </ul>
                            <?php endif; ?>
                        </div>

                        <!-- How to Claim -->
                        <div class="promo-list-column">
                            <h4 class="promo-list-column-title">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="8" cy="8" r="6" stroke="currentColor" stroke-width="1.5"/>
                                    <circle cx="8" cy="8" r="2" fill="currentColor"/>
                                </svg>
                                How to Claim
                            </h4>
                            <?php if ( $how_to_claim ) : ?>
                                <ol class="promo-list-steps">
                                    <?php
                                    $claim_lines = explode( "\n", $how_to_claim );
                                    foreach ( $claim_lines as $step ) {
                                        $step = trim( $step );
                                        if ( ! empty( $step ) ) {
                                            echo '<li>' . esc_html( $step ) . '</li>';
                                        }
                                    }
                                    ?>
                                </ol>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="promo-list-footer">
                    <a href="<?php echo esc_url( $button_url ); ?>" class="promo-list-button button-<?php echo esc_attr( $button_color ); ?>">
                        <?php echo esc_html( $button_text ); ?>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </a>
                </div>
            </div>

        <?php endwhile; ?>
    </div>

    <?php
    wp_reset_postdata();
    return ob_get_clean();
}
add_shortcode( 'promotions_list', 'foursix_promotions_list_shortcode' );

/**
 * Enqueue Promotions Styles
 */
function foursix_enqueue_promotions_styles() {
    $post_content = get_post()->post_content ?? '';

    if ( has_shortcode( $post_content, 'promotions' ) || has_shortcode( $post_content, 'promotion_detail' ) || has_shortcode( $post_content, 'promotions_list' ) || is_post_type_archive( 'promotion' ) ) {
        wp_enqueue_style( 'foursix-promotions', get_template_directory_uri() . '/assets/css/promotions.css', array(), '1.0.0' );

        if ( has_shortcode( $post_content, 'promotions_list' ) ) {
            wp_enqueue_style( 'foursix-promotions-list', get_template_directory_uri() . '/assets/css/promotions-list.css', array( 'foursix-promotions' ), '1.0.0' );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'foursix_enqueue_promotions_styles' );
