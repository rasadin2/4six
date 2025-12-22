<?php
/**
 * Promotions Custom Post Type
 *
 * @package foursix
 */

/**
 * Register Promotions Custom Post Type
 */
function foursix_register_promotions_post_type() {
    $labels = array(
        'name'                  => _x( 'Promotions', 'Post Type General Name', 'foursix' ),
        'singular_name'         => _x( 'Promotion', 'Post Type Singular Name', 'foursix' ),
        'menu_name'             => __( 'Promotions', 'foursix' ),
        'name_admin_bar'        => __( 'Promotion', 'foursix' ),
        'archives'              => __( 'Promotion Archives', 'foursix' ),
        'attributes'            => __( 'Promotion Attributes', 'foursix' ),
        'parent_item_colon'     => __( 'Parent Promotion:', 'foursix' ),
        'all_items'             => __( 'All Promotions', 'foursix' ),
        'add_new_item'          => __( 'Add New Promotion', 'foursix' ),
        'add_new'               => __( 'Add New', 'foursix' ),
        'new_item'              => __( 'New Promotion', 'foursix' ),
        'edit_item'             => __( 'Edit Promotion', 'foursix' ),
        'update_item'           => __( 'Update Promotion', 'foursix' ),
        'view_item'             => __( 'View Promotion', 'foursix' ),
        'view_items'            => __( 'View Promotions', 'foursix' ),
        'search_items'          => __( 'Search Promotion', 'foursix' ),
        'not_found'             => __( 'Not found', 'foursix' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'foursix' ),
        'featured_image'        => __( 'Featured Image', 'foursix' ),
        'set_featured_image'    => __( 'Set featured image', 'foursix' ),
        'remove_featured_image' => __( 'Remove featured image', 'foursix' ),
        'use_featured_image'    => __( 'Use as featured image', 'foursix' ),
        'insert_into_item'      => __( 'Insert into promotion', 'foursix' ),
        'uploaded_to_this_item' => __( 'Uploaded to this promotion', 'foursix' ),
        'items_list'            => __( 'Promotions list', 'foursix' ),
        'items_list_navigation' => __( 'Promotions list navigation', 'foursix' ),
        'filter_items_list'     => __( 'Filter promotions list', 'foursix' ),
    );

    $args = array(
        'label'                 => __( 'Promotion', 'foursix' ),
        'description'           => __( 'Betting promotions and bonuses', 'foursix' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 25,
        'menu_icon'             => 'dashicons-megaphone',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );

    register_post_type( 'promotion', $args );
}
add_action( 'init', 'foursix_register_promotions_post_type', 0 );

/**
 * Add Custom Meta Boxes for Promotions
 */
function foursix_add_promotion_meta_boxes() {
    add_meta_box(
        'promotion_details',
        __( 'Promotion Details', 'foursix' ),
        'foursix_render_promotion_meta_box',
        'promotion',
        'normal',
        'high'
    );

    add_meta_box(
        'promotion_terms_claim',
        __( 'Terms & How to Claim', 'foursix' ),
        'foursix_render_terms_claim_meta_box',
        'promotion',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'foursix_add_promotion_meta_boxes' );

/**
 * Render Promotion Meta Box
 */
function foursix_render_promotion_meta_box( $post ) {
    wp_nonce_field( 'foursix_promotion_meta_box', 'foursix_promotion_nonce' );

    $badge_text = get_post_meta( $post->ID, '_promotion_badge_text', true );
    $badge_color = get_post_meta( $post->ID, '_promotion_badge_color', true );
    $icon_type = get_post_meta( $post->ID, '_promotion_icon_type', true );
    $icon_value = get_post_meta( $post->ID, '_promotion_icon_value', true );
    $subtitle = get_post_meta( $post->ID, '_promotion_subtitle', true );
    $button_text = get_post_meta( $post->ID, '_promotion_button_text', true );
    $button_url = get_post_meta( $post->ID, '_promotion_button_url', true );
    $button_color = get_post_meta( $post->ID, '_promotion_button_color', true );
    $menu_order = get_post_meta( $post->ID, '_promotion_menu_order', true );

    ?>
    <table class="form-table">
        <tr>
            <th><label for="promotion_badge_text"><?php _e( 'Badge Text', 'foursix' ); ?></label></th>
            <td>
                <input type="text" id="promotion_badge_text" name="promotion_badge_text" value="<?php echo esc_attr( $badge_text ); ?>" class="regular-text">
                <p class="description"><?php _e( 'e.g., "NEW USER", "WEEKLY", "FRIDAY"', 'foursix' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="promotion_badge_color"><?php _e( 'Badge Color', 'foursix' ); ?></label></th>
            <td>
                <select id="promotion_badge_color" name="promotion_badge_color">
                    <option value="green" <?php selected( $badge_color, 'green' ); ?>><?php _e( 'Green', 'foursix' ); ?></option>
                    <option value="yellow" <?php selected( $badge_color, 'yellow' ); ?>><?php _e( 'Yellow', 'foursix' ); ?></option>
                    <option value="orange" <?php selected( $badge_color, 'orange' ); ?>><?php _e( 'Orange', 'foursix' ); ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="promotion_icon_type"><?php _e( 'Icon Type', 'foursix' ); ?></label></th>
            <td>
                <select id="promotion_icon_type" name="promotion_icon_type">
                    <option value="gift" <?php selected( $icon_type, 'gift' ); ?>><?php _e( 'Gift (৳)', 'foursix' ); ?></option>
                    <option value="trophy" <?php selected( $icon_type, 'trophy' ); ?>><?php _e( 'Trophy (%)', 'foursix' ); ?></option>
                    <option value="zap" <?php selected( $icon_type, 'zap' ); ?>><?php _e( 'Zap (%)', 'foursix' ); ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="promotion_icon_value"><?php _e( 'Icon Value', 'foursix' ); ?></label></th>
            <td>
                <input type="text" id="promotion_icon_value" name="promotion_icon_value" value="<?php echo esc_attr( $icon_value ); ?>" class="regular-text">
                <p class="description"><?php _e( 'e.g., "10,000", "10", "50"', 'foursix' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="promotion_subtitle"><?php _e( 'Subtitle', 'foursix' ); ?></label></th>
            <td>
                <input type="text" id="promotion_subtitle" name="promotion_subtitle" value="<?php echo esc_attr( $subtitle ); ?>" class="regular-text">
                <p class="description"><?php _e( 'e.g., "Up to 100% Match Bonus", "10% Weekly Cashback"', 'foursix' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="promotion_button_text"><?php _e( 'Button Text', 'foursix' ); ?></label></th>
            <td>
                <input type="text" id="promotion_button_text" name="promotion_button_text" value="<?php echo esc_attr( $button_text ); ?>" class="regular-text">
                <p class="description"><?php _e( 'Default: "Claim Bonus"', 'foursix' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="promotion_button_url"><?php _e( 'Button URL', 'foursix' ); ?></label></th>
            <td>
                <input type="url" id="promotion_button_url" name="promotion_button_url" value="<?php echo esc_url( $button_url ); ?>" class="regular-text">
                <p class="description"><?php _e( 'The URL where the button should link to', 'foursix' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="promotion_button_color"><?php _e( 'Button Color', 'foursix' ); ?></label></th>
            <td>
                <select id="promotion_button_color" name="promotion_button_color">
                    <option value="green" <?php selected( $button_color, 'green' ); ?>><?php _e( 'Green', 'foursix' ); ?></option>
                    <option value="yellow" <?php selected( $button_color, 'yellow' ); ?>><?php _e( 'Yellow/Orange', 'foursix' ); ?></option>
                    <option value="purple" <?php selected( $button_color, 'purple' ); ?>><?php _e( 'Purple', 'foursix' ); ?></option>
                    <option value="pink" <?php selected( $button_color, 'pink' ); ?>><?php _e( 'Pink', 'foursix' ); ?></option>
                    <option value="blue" <?php selected( $button_color, 'blue' ); ?>><?php _e( 'Blue', 'foursix' ); ?></option>
                    <option value="orange" <?php selected( $button_color, 'orange' ); ?>><?php _e( 'Orange', 'foursix' ); ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="promotion_card_color"><?php _e( 'Card Color Scheme', 'foursix' ); ?></label></th>
            <td>
                <select id="promotion_card_color" name="promotion_card_color">
                    <option value="teal" <?php selected( get_post_meta( $post->ID, '_promotion_card_color', true ), 'teal' ); ?>><?php _e( 'Teal (New Players)', 'foursix' ); ?></option>
                    <option value="navy" <?php selected( get_post_meta( $post->ID, '_promotion_card_color', true ), 'navy' ); ?>><?php _e( 'Navy (Weekly)', 'foursix' ); ?></option>
                    <option value="purple" <?php selected( get_post_meta( $post->ID, '_promotion_card_color', true ), 'purple' ); ?>><?php _e( 'Purple (Referral)', 'foursix' ); ?></option>
                    <option value="burgundy" <?php selected( get_post_meta( $post->ID, '_promotion_card_color', true ), 'burgundy' ); ?>><?php _e( 'Burgundy (Daily)', 'foursix' ); ?></option>
                    <option value="blue" <?php selected( get_post_meta( $post->ID, '_promotion_card_color', true ), 'blue' ); ?>><?php _e( 'Blue (Weekly)', 'foursix' ); ?></option>
                    <option value="brown" <?php selected( get_post_meta( $post->ID, '_promotion_card_color', true ), 'brown' ); ?>><?php _e( 'Brown (Weekend)', 'foursix' ); ?></option>
                    <option value="yellow-brown" <?php selected( get_post_meta( $post->ID, '_promotion_card_color', true ), 'yellow-brown' ); ?>><?php _e( 'Yellow-Brown (VIP)', 'foursix' ); ?></option>
                    <option value="dark-teal" <?php selected( get_post_meta( $post->ID, '_promotion_card_color', true ), 'dark-teal' ); ?>><?php _e( 'Dark Teal (Special)', 'foursix' ); ?></option>
                </select>
                <p class="description"><?php _e( 'Choose the color scheme that matches your promotion type', 'foursix' ); ?></p>
            </td>
        </tr>
        <tr>
            <th><label for="promotion_menu_order"><?php _e( 'Display Order', 'foursix' ); ?></label></th>
            <td>
                <input type="number" id="promotion_menu_order" name="promotion_menu_order" value="<?php echo esc_attr( $menu_order ); ?>" class="small-text">
                <p class="description"><?php _e( 'Lower numbers appear first (e.g., 1, 2, 3)', 'foursix' ); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Render Terms & How to Claim Meta Box
 */
function foursix_render_terms_claim_meta_box( $post ) {
    wp_nonce_field( 'foursix_terms_claim_meta_box', 'foursix_terms_claim_nonce' );

    $terms_conditions = get_post_meta( $post->ID, '_promotion_terms_conditions', true );
    $how_to_claim = get_post_meta( $post->ID, '_promotion_how_to_claim', true );
    ?>

    <style>
        .promotion-meta-section {
            margin-bottom: 30px;
        }
        .promotion-meta-section h3 {
            margin: 0 0 15px 0;
            padding: 10px 0;
            border-bottom: 2px solid #f0f0f1;
        }
        .repeater-field {
            background: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 10px;
        }
        .repeater-field input {
            width: 100%;
            margin-top: 5px;
        }
        .add-repeater-btn {
            margin-top: 10px;
        }
        .remove-repeater-btn {
            color: #d63638;
            cursor: pointer;
            float: right;
            text-decoration: none;
        }
        .remove-repeater-btn:hover {
            color: #a00;
        }
    </style>

    <div class="promotion-meta-section">
        <h3><?php _e( 'Terms & Conditions', 'foursix' ); ?></h3>
        <p class="description"><?php _e( 'Add bullet points for terms and conditions (one per line)', 'foursix' ); ?></p>
        <textarea id="promotion_terms_conditions" name="promotion_terms_conditions" rows="8" class="large-text"><?php echo esc_textarea( $terms_conditions ); ?></textarea>
        <p class="description">
            <?php _e( 'Example:', 'foursix' ); ?><br>
            Minimum deposit: ৳500<br>
            Wagering requirement: 5x bonus amount<br>
            Valid for 30 days from activation<br>
            Available for new users only
        </p>
    </div>

    <div class="promotion-meta-section">
        <h3><?php _e( 'How to Claim', 'foursix' ); ?></h3>
        <p class="description"><?php _e( 'Add step-by-step instructions (one per line)', 'foursix' ); ?></p>
        <textarea id="promotion_how_to_claim" name="promotion_how_to_claim" rows="6" class="large-text"><?php echo esc_textarea( $how_to_claim ); ?></textarea>
        <p class="description">
            <?php _e( 'Example:', 'foursix' ); ?><br>
            Create a new 4six account<br>
            Make your first deposit of ৳500 or more<br>
            Bonus automatically credited to your account<br>
            Start betting and fulfill wagering requirements
        </p>
    </div>
    <?php
}

/**
 * Save Promotion Meta Data
 */
function foursix_save_promotion_meta( $post_id ) {
    if ( ! isset( $_POST['foursix_promotion_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['foursix_promotion_nonce'], 'foursix_promotion_meta_box' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $fields = array(
        'promotion_badge_text'   => 'sanitize_text_field',
        'promotion_badge_color'  => 'sanitize_text_field',
        'promotion_icon_type'    => 'sanitize_text_field',
        'promotion_icon_value'   => 'sanitize_text_field',
        'promotion_subtitle'     => 'sanitize_text_field',
        'promotion_button_text'  => 'sanitize_text_field',
        'promotion_button_url'   => 'esc_url_raw',
        'promotion_button_color' => 'sanitize_text_field',
        'promotion_card_color'   => 'sanitize_text_field',
        'promotion_menu_order'   => 'absint',
    );

    foreach ( $fields as $field => $sanitize_callback ) {
        if ( isset( $_POST[ $field ] ) ) {
            update_post_meta( $post_id, '_' . $field, call_user_func( $sanitize_callback, $_POST[ $field ] ) );
        }
    }

    // Save Terms & Conditions and How to Claim
    if ( isset( $_POST['foursix_terms_claim_nonce'] ) && wp_verify_nonce( $_POST['foursix_terms_claim_nonce'], 'foursix_terms_claim_meta_box' ) ) {
        if ( isset( $_POST['promotion_terms_conditions'] ) ) {
            update_post_meta( $post_id, '_promotion_terms_conditions', sanitize_textarea_field( $_POST['promotion_terms_conditions'] ) );
        }
        if ( isset( $_POST['promotion_how_to_claim'] ) ) {
            update_post_meta( $post_id, '_promotion_how_to_claim', sanitize_textarea_field( $_POST['promotion_how_to_claim'] ) );
        }
    }
}
add_action( 'save_post_promotion', 'foursix_save_promotion_meta' );
