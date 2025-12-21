<?php
/**
 * Welcome Popup Admin Settings
 *
 * @package foursix
 */

/**
 * Add admin menu for popup settings
 */
function foursix_popup_admin_menu() {
    add_menu_page(
        __( 'Welcome Popup Settings', 'foursix' ),
        __( 'Welcome Popup', 'foursix' ),
        'manage_options',
        'foursix-welcome-popup',
        'foursix_popup_settings_page',
        'dashicons-megaphone',
        65
    );
}
add_action( 'admin_menu', 'foursix_popup_admin_menu' );

/**
 * Get predefined icon options
 */
function foursix_popup_get_icon_options() {
    return array(
        'gift' => __( 'Gift (Deposit/Bonus)', 'foursix' ),
        'star' => __( 'Star (Free Spins/Special)', 'foursix' ),
        'chart' => __( 'Chart (Cashback/Growth)', 'foursix' ),
        'trophy' => __( 'Trophy (Achievement)', 'foursix' ),
        'coins' => __( 'Coins (Money/Rewards)', 'foursix' ),
    );
}

/**
 * Sanitize features array
 */
function foursix_popup_sanitize_features( $input ) {
    if ( ! is_array( $input ) ) {
        return array();
    }

    $sanitized = array();
    foreach ( $input as $feature ) {
        if ( ! is_array( $feature ) ) {
            continue;
        }

        $sanitized_feature = array(
            'title' => isset( $feature['title'] ) ? sanitize_text_field( $feature['title'] ) : '',
            'subtitle' => isset( $feature['subtitle'] ) ? sanitize_text_field( $feature['subtitle'] ) : '',
            'icon_type' => isset( $feature['icon_type'] ) && in_array( $feature['icon_type'], array( 'predefined', 'custom' ) ) ? $feature['icon_type'] : 'predefined',
            'icon_value' => isset( $feature['icon_value'] ) ? sanitize_text_field( $feature['icon_value'] ) : 'gift',
        );

        $sanitized[] = $sanitized_feature;
    }

    return $sanitized;
}

/**
 * Register all settings
 */
function foursix_popup_register_settings() {
    // Content Settings
    register_setting( 'foursix_popup_content', 'foursix_popup_alert_text', 'sanitize_text_field' );
    register_setting( 'foursix_popup_content', 'foursix_popup_title', 'sanitize_text_field' );
    register_setting( 'foursix_popup_content', 'foursix_popup_bonus_label', 'sanitize_text_field' );
    register_setting( 'foursix_popup_content', 'foursix_popup_bonus_amount', 'sanitize_text_field' );
    register_setting( 'foursix_popup_content', 'foursix_popup_bonus_extra', 'sanitize_text_field' );
    register_setting( 'foursix_popup_content', 'foursix_popup_bonus_subtitle', 'sanitize_text_field' );
    register_setting( 'foursix_popup_content', 'foursix_popup_bonus_info', 'sanitize_text_field' );
    register_setting( 'foursix_popup_content', 'foursix_popup_button_text', 'sanitize_text_field' );
    register_setting( 'foursix_popup_content', 'foursix_popup_button_url', 'esc_url_raw' );

    // Features (Repeater Field)
    register_setting( 'foursix_popup_content', 'foursix_popup_features', 'foursix_popup_sanitize_features' );

    // Behavior Settings
    register_setting( 'foursix_popup_behavior', 'foursix_popup_show_delay', 'absint' );
    register_setting( 'foursix_popup_behavior', 'foursix_popup_enable_auto_show', array(
        'type' => 'boolean',
        'default' => true,
    ) );

    // Visual Settings
    register_setting( 'foursix_popup_visual', 'foursix_popup_bg_gradient_start', 'sanitize_hex_color' );
    register_setting( 'foursix_popup_visual', 'foursix_popup_bg_gradient_end', 'sanitize_hex_color' );
    register_setting( 'foursix_popup_visual', 'foursix_popup_primary_color', 'sanitize_hex_color' );
    register_setting( 'foursix_popup_visual', 'foursix_popup_text_color', 'sanitize_hex_color' );
}
add_action( 'admin_init', 'foursix_popup_register_settings' );

/**
 * Enqueue admin scripts and styles
 */
function foursix_popup_admin_scripts( $hook ) {
    if ( 'toplevel_page_foursix-welcome-popup' !== $hook ) {
        return;
    }

    // WordPress color picker
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker' );

    // WordPress media uploader
    wp_enqueue_media();

    // Custom admin CSS
    wp_enqueue_style(
        'foursix-popup-admin',
        get_template_directory_uri() . '/assets/css/welcome-popup-admin.css',
        array(),
        '1.0.0'
    );

    // Custom admin JS
    wp_enqueue_script(
        'foursix-popup-admin',
        get_template_directory_uri() . '/assets/js/welcome-popup-admin.js',
        array( 'jquery', 'wp-color-picker' ),
        '1.0.0',
        true
    );
}
add_action( 'admin_enqueue_scripts', 'foursix_popup_admin_scripts' );

/**
 * Get default values
 */
function foursix_popup_get_defaults() {
    return array(
        'alert_text' => 'সীমিত সময়ের অফার',
        'title' => 'মেগা স্বাগতম অফার',
        'bonus_label' => 'পর্যন্ত পান',
        'bonus_amount' => '২০০%',
        'bonus_extra' => '১০০',
        'bonus_subtitle' => 'বোনাস + ফ্রি স্পিন',
        'bonus_info' => '৫০,০০০ টাকা পর্যন্ত বোনাস',
        'button_text' => 'এখনই রেজিস্টার করুন',
        'button_url' => '#',
        'features' => array(
            array(
                'title' => '২০০% ডিপোজিট ম্যাচ',
                'subtitle' => 'প্রথম ডিপোজিটে',
                'icon_type' => 'predefined',
                'icon_value' => 'gift',
            ),
            array(
                'title' => '১০০ ফ্রি স্পিন',
                'subtitle' => 'জনপ্রিয় স্লটে',
                'icon_type' => 'predefined',
                'icon_value' => 'star',
            ),
            array(
                'title' => '১৫% সাপ্তাহিক ক্যাশব্যাক',
                'subtitle' => 'প্রতি সোমবার',
                'icon_type' => 'predefined',
                'icon_value' => 'chart',
            ),
        ),
        'show_delay' => 1500,
        'enable_auto_show' => true,
        'bg_gradient_start' => '#E8F5E8',
        'bg_gradient_end' => '#FFFFFF',
        'primary_color' => '#009966',
        'text_color' => '#002C22',
    );
}

/**
 * Render settings page
 */
function foursix_popup_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have sufficient permissions to access this page.', 'foursix' ) );
    }

    $defaults = foursix_popup_get_defaults();
    $active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'content';
    ?>
    <div class="wrap foursix-popup-admin">
        <h1><?php esc_html_e( 'Welcome Popup Settings', 'foursix' ); ?></h1>

        <h2 class="nav-tab-wrapper">
            <a href="?page=foursix-welcome-popup&tab=content" class="nav-tab <?php echo $active_tab === 'content' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e( 'Content', 'foursix' ); ?>
            </a>
            <a href="?page=foursix-welcome-popup&tab=visual" class="nav-tab <?php echo $active_tab === 'visual' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e( 'Visual', 'foursix' ); ?>
            </a>
            <a href="?page=foursix-welcome-popup&tab=behavior" class="nav-tab <?php echo $active_tab === 'behavior' ? 'nav-tab-active' : ''; ?>">
                <?php esc_html_e( 'Behavior', 'foursix' ); ?>
            </a>
        </h2>

        <div class="foursix-popup-settings-content">
            <?php
            if ( $active_tab === 'content' ) {
                foursix_popup_content_tab( $defaults );
            } elseif ( $active_tab === 'visual' ) {
                foursix_popup_visual_tab( $defaults );
            } elseif ( $active_tab === 'behavior' ) {
                foursix_popup_behavior_tab( $defaults );
            }
            ?>
        </div>
    </div>
    <?php
}

/**
 * Content Tab
 */
function foursix_popup_content_tab( $defaults ) {
    ?>
    <form method="post" action="options.php">
        <?php settings_fields( 'foursix_popup_content' ); ?>

        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="foursix_popup_alert_text"><?php esc_html_e( 'Alert Banner Text', 'foursix' ); ?></label>
                </th>
                <td>
                    <input type="text"
                           id="foursix_popup_alert_text"
                           name="foursix_popup_alert_text"
                           value="<?php echo esc_attr( get_option( 'foursix_popup_alert_text', $defaults['alert_text'] ) ); ?>"
                           class="regular-text">
                    <p class="description"><?php esc_html_e( 'Text shown in the alert banner (e.g., "Limited Time Offer")', 'foursix' ); ?></p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="foursix_popup_title"><?php esc_html_e( 'Main Title', 'foursix' ); ?></label>
                </th>
                <td>
                    <input type="text"
                           id="foursix_popup_title"
                           name="foursix_popup_title"
                           value="<?php echo esc_attr( get_option( 'foursix_popup_title', $defaults['title'] ) ); ?>"
                           class="regular-text">
                    <p class="description"><?php esc_html_e( 'Main popup title', 'foursix' ); ?></p>
                </td>
            </tr>

            <tr>
                <th scope="row" colspan="2">
                    <h3><?php esc_html_e( 'Bonus Section', 'foursix' ); ?></h3>
                </th>
            </tr>

            <tr>
                <th scope="row">
                    <label for="foursix_popup_bonus_label"><?php esc_html_e( 'Bonus Label', 'foursix' ); ?></label>
                </th>
                <td>
                    <input type="text"
                           id="foursix_popup_bonus_label"
                           name="foursix_popup_bonus_label"
                           value="<?php echo esc_attr( get_option( 'foursix_popup_bonus_label', $defaults['bonus_label'] ) ); ?>"
                           class="regular-text">
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="foursix_popup_bonus_amount"><?php esc_html_e( 'Bonus Amount', 'foursix' ); ?></label>
                </th>
                <td>
                    <input type="text"
                           id="foursix_popup_bonus_amount"
                           name="foursix_popup_bonus_amount"
                           value="<?php echo esc_attr( get_option( 'foursix_popup_bonus_amount', $defaults['bonus_amount'] ) ); ?>"
                           class="regular-text">
                    <p class="description"><?php esc_html_e( 'e.g., "200%"', 'foursix' ); ?></p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="foursix_popup_bonus_extra"><?php esc_html_e( 'Bonus Extra', 'foursix' ); ?></label>
                </th>
                <td>
                    <input type="text"
                           id="foursix_popup_bonus_extra"
                           name="foursix_popup_bonus_extra"
                           value="<?php echo esc_attr( get_option( 'foursix_popup_bonus_extra', $defaults['bonus_extra'] ) ); ?>"
                           class="regular-text">
                    <p class="description"><?php esc_html_e( 'Additional bonus number (e.g., "100")', 'foursix' ); ?></p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="foursix_popup_bonus_subtitle"><?php esc_html_e( 'Bonus Subtitle', 'foursix' ); ?></label>
                </th>
                <td>
                    <input type="text"
                           id="foursix_popup_bonus_subtitle"
                           name="foursix_popup_bonus_subtitle"
                           value="<?php echo esc_attr( get_option( 'foursix_popup_bonus_subtitle', $defaults['bonus_subtitle'] ) ); ?>"
                           class="regular-text">
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="foursix_popup_bonus_info"><?php esc_html_e( 'Bonus Info', 'foursix' ); ?></label>
                </th>
                <td>
                    <input type="text"
                           id="foursix_popup_bonus_info"
                           name="foursix_popup_bonus_info"
                           value="<?php echo esc_attr( get_option( 'foursix_popup_bonus_info', $defaults['bonus_info'] ) ); ?>"
                           class="regular-text">
                </td>
            </tr>

            <tr>
                <th scope="row" colspan="2">
                    <h3><?php esc_html_e( 'Features (Repeatable)', 'foursix' ); ?></h3>
                    <p class="description"><?php esc_html_e( 'Add, remove, or reorder features. Click "Add Feature" to add more.', 'foursix' ); ?></p>
                </th>
            </tr>

            <tr>
                <td colspan="2">
                    <div id="popup-features-repeater">
                        <?php
                        $features = get_option( 'foursix_popup_features', $defaults['features'] );
                        if ( empty( $features ) ) {
                            $features = $defaults['features'];
                        }

                        $icon_options = foursix_popup_get_icon_options();

                        foreach ( $features as $index => $feature ) :
                            ?>
                            <div class="feature-repeater-row" data-index="<?php echo esc_attr( $index ); ?>">
                                <div class="feature-row-header">
                                    <span class="dashicons dashicons-move drag-handle"></span>
                                    <strong><?php esc_html_e( 'Feature', 'foursix' ); ?> #<?php echo esc_html( $index + 1 ); ?></strong>
                                    <button type="button" class="button remove-feature-row"><?php esc_html_e( 'Remove', 'foursix' ); ?></button>
                                </div>
                                <div class="feature-row-content">
                                    <div class="feature-field">
                                        <label><?php esc_html_e( 'Title', 'foursix' ); ?></label>
                                        <input type="text"
                                               name="foursix_popup_features[<?php echo esc_attr( $index ); ?>][title]"
                                               value="<?php echo esc_attr( $feature['title'] ); ?>"
                                               class="regular-text"
                                               placeholder="<?php esc_attr_e( 'Feature title', 'foursix' ); ?>">
                                    </div>

                                    <div class="feature-field">
                                        <label><?php esc_html_e( 'Subtitle', 'foursix' ); ?></label>
                                        <input type="text"
                                               name="foursix_popup_features[<?php echo esc_attr( $index ); ?>][subtitle]"
                                               value="<?php echo esc_attr( $feature['subtitle'] ); ?>"
                                               class="regular-text"
                                               placeholder="<?php esc_attr_e( 'Feature subtitle', 'foursix' ); ?>">
                                    </div>

                                    <div class="feature-field">
                                        <label><?php esc_html_e( 'Icon', 'foursix' ); ?></label>
                                        <div class="icon-selection">
                                            <div class="icon-options">
                                                <?php foreach ( $icon_options as $icon_key => $icon_label ) : ?>
                                                    <label class="icon-option">
                                                        <input type="radio"
                                                               name="foursix_popup_features[<?php echo esc_attr( $index ); ?>][icon_value]"
                                                               value="<?php echo esc_attr( $icon_key ); ?>"
                                                               data-icon-type="predefined"
                                                               <?php checked( $feature['icon_type'] === 'predefined' && $feature['icon_value'] === $icon_key ); ?>>
                                                        <span class="icon-preview icon-<?php echo esc_attr( $icon_key ); ?>">
                                                            <?php echo esc_html( $icon_label ); ?>
                                                        </span>
                                                    </label>
                                                <?php endforeach; ?>
                                            </div>
                                            <input type="hidden"
                                                   name="foursix_popup_features[<?php echo esc_attr( $index ); ?>][icon_type]"
                                                   value="<?php echo esc_attr( $feature['icon_type'] ); ?>"
                                                   class="icon-type-field">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button type="button" id="add-feature-row" class="button button-secondary">
                        <span class="dashicons dashicons-plus-alt"></span>
                        <?php esc_html_e( 'Add Feature', 'foursix' ); ?>
                    </button>
                </td>
            </tr>

            <tr>
                <th scope="row" colspan="2">
                    <h3><?php esc_html_e( 'Button', 'foursix' ); ?></h3>
                </th>
            </tr>

            <tr>
                <th scope="row">
                    <label for="foursix_popup_button_text"><?php esc_html_e( 'Button Text', 'foursix' ); ?></label>
                </th>
                <td>
                    <input type="text"
                           id="foursix_popup_button_text"
                           name="foursix_popup_button_text"
                           value="<?php echo esc_attr( get_option( 'foursix_popup_button_text', $defaults['button_text'] ) ); ?>"
                           class="regular-text">
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="foursix_popup_button_url"><?php esc_html_e( 'Button URL', 'foursix' ); ?></label>
                </th>
                <td>
                    <input type="url"
                           id="foursix_popup_button_url"
                           name="foursix_popup_button_url"
                           value="<?php echo esc_url( get_option( 'foursix_popup_button_url', $defaults['button_url'] ) ); ?>"
                           class="regular-text">
                    <p class="description"><?php esc_html_e( 'URL for the register button', 'foursix' ); ?></p>
                </td>
            </tr>
        </table>

        <?php submit_button(); ?>
    </form>
    <?php
}

/**
 * Visual Tab
 */
function foursix_popup_visual_tab( $defaults ) {
    ?>
    <form method="post" action="options.php">
        <?php settings_fields( 'foursix_popup_visual' ); ?>

        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="foursix_popup_bg_gradient_start"><?php esc_html_e( 'Background Gradient Start', 'foursix' ); ?></label>
                </th>
                <td>
                    <input type="text"
                           id="foursix_popup_bg_gradient_start"
                           name="foursix_popup_bg_gradient_start"
                           value="<?php echo esc_attr( get_option( 'foursix_popup_bg_gradient_start', $defaults['bg_gradient_start'] ) ); ?>"
                           class="color-picker">
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="foursix_popup_bg_gradient_end"><?php esc_html_e( 'Background Gradient End', 'foursix' ); ?></label>
                </th>
                <td>
                    <input type="text"
                           id="foursix_popup_bg_gradient_end"
                           name="foursix_popup_bg_gradient_end"
                           value="<?php echo esc_attr( get_option( 'foursix_popup_bg_gradient_end', $defaults['bg_gradient_end'] ) ); ?>"
                           class="color-picker">
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="foursix_popup_primary_color"><?php esc_html_e( 'Primary Color', 'foursix' ); ?></label>
                </th>
                <td>
                    <input type="text"
                           id="foursix_popup_primary_color"
                           name="foursix_popup_primary_color"
                           value="<?php echo esc_attr( get_option( 'foursix_popup_primary_color', $defaults['primary_color'] ) ); ?>"
                           class="color-picker">
                    <p class="description"><?php esc_html_e( 'Used for icons and accents', 'foursix' ); ?></p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="foursix_popup_text_color"><?php esc_html_e( 'Text Color', 'foursix' ); ?></label>
                </th>
                <td>
                    <input type="text"
                           id="foursix_popup_text_color"
                           name="foursix_popup_text_color"
                           value="<?php echo esc_attr( get_option( 'foursix_popup_text_color', $defaults['text_color'] ) ); ?>"
                           class="color-picker">
                </td>
            </tr>
        </table>

        <?php submit_button(); ?>
    </form>
    <?php
}

/**
 * Behavior Tab
 */
function foursix_popup_behavior_tab( $defaults ) {
    ?>
    <form method="post" action="options.php">
        <?php settings_fields( 'foursix_popup_behavior' ); ?>

        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="foursix_popup_show_delay"><?php esc_html_e( 'Show Delay (milliseconds)', 'foursix' ); ?></label>
                </th>
                <td>
                    <input type="number"
                           id="foursix_popup_show_delay"
                           name="foursix_popup_show_delay"
                           value="<?php echo esc_attr( get_option( 'foursix_popup_show_delay', $defaults['show_delay'] ) ); ?>"
                           min="0"
                           max="10000"
                           step="100"
                           class="small-text">
                    <p class="description"><?php esc_html_e( 'Time to wait before showing popup on first visit (in milliseconds). 1000ms = 1 second', 'foursix' ); ?></p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="foursix_popup_enable_auto_show"><?php esc_html_e( 'Enable Auto Show', 'foursix' ); ?></label>
                </th>
                <td>
                    <label>
                        <input type="checkbox"
                               id="foursix_popup_enable_auto_show"
                               name="foursix_popup_enable_auto_show"
                               value="1"
                               <?php checked( get_option( 'foursix_popup_enable_auto_show', $defaults['enable_auto_show'] ), true ); ?>>
                        <?php esc_html_e( 'Automatically show popup on first visit', 'foursix' ); ?>
                    </label>
                    <p class="description"><?php esc_html_e( 'If disabled, users must click the trigger icon to see the popup', 'foursix' ); ?></p>
                </td>
            </tr>
        </table>

        <?php submit_button(); ?>
    </form>
    <?php
}
