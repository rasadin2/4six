<?php
/**
 * Welcome Popup Modal
 *
 * @package foursix
 */

/**
 * Enqueue welcome popup scripts and styles
 */
function foursix_welcome_popup_scripts() {
    // Enqueue CSS
    wp_enqueue_style(
        'foursix-welcome-popup',
        get_template_directory_uri() . '/assets/css/welcome-popup.css',
        array(),
        '1.0.0'
    );

    // Enqueue JavaScript
    wp_enqueue_script(
        'foursix-welcome-popup',
        get_template_directory_uri() . '/assets/js/welcome-popup.js',
        array(),
        '1.0.0',
        true
    );

    // Pass settings to JavaScript
    $show_delay = foursix_get_popup_option( 'show_delay' );
    wp_localize_script(
        'foursix-welcome-popup',
        'foursixPopupSettings',
        array(
            'showDelay' => absint( $show_delay ),
        )
    );
}
add_action( 'wp_enqueue_scripts', 'foursix_welcome_popup_scripts' );

/**
 * Get popup setting with default fallback
 */
function foursix_get_popup_option( $key, $default = '' ) {
    $defaults = array(
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

    $default_value = isset( $defaults[ $key ] ) ? $defaults[ $key ] : $default;
    return get_option( 'foursix_popup_' . $key, $default_value );
}

/**
 * Get feature icon SVG
 */
function foursix_get_feature_icon_svg( $icon_name ) {
    $icons = array(
        'gift' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.6667 6.66669H3.33333C2.8731 6.66669 2.5 7.03978 2.5 7.50002V9.16669C2.5 9.62692 2.8731 10 3.33333 10H16.6667C17.1269 10 17.5 9.62692 17.5 9.16669V7.50002C17.5 7.03978 17.1269 6.66669 16.6667 6.66669Z" stroke="#002C22" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 6.66669V17.5" stroke="#002C22" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/><path d="M15.8333 10V15.8333C15.8333 16.2754 15.6577 16.6993 15.3451 17.0118C15.0326 17.3244 14.6087 17.5 14.1666 17.5H5.83329C5.39127 17.5 4.96734 17.3244 4.65478 17.0118C4.34222 16.6993 4.16663 16.2754 4.16663 15.8333V10" stroke="#002C22" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/><path d="M6.24996 6.66667C5.69743 6.66667 5.16752 6.44717 4.77682 6.05647C4.38612 5.66577 4.16663 5.13587 4.16663 4.58333C4.16663 4.0308 4.38612 3.50089 4.77682 3.11019C5.16752 2.71949 5.69743 2.5 6.24996 2.5C7.05386 2.48599 7.84165 2.87605 8.51057 3.6193C9.1795 4.36255 9.69852 5.4245 9.99996 6.66667C10.3014 5.4245 10.8204 4.36255 11.4893 3.6193C12.1583 2.87605 12.9461 2.48599 13.75 2.5C14.3025 2.5 14.8324 2.71949 15.2231 3.11019C15.6138 3.50089 15.8333 4.0308 15.8333 4.58333C15.8333 5.13587 15.6138 5.66577 15.2231 6.05647C14.8324 6.44717 14.3025 6.66667 13.75 6.66667" stroke="#002C22" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/></svg>',

        'star' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_18_13201)"><path d="M8.28074 12.9167C8.20634 12.6283 8.05602 12.3651 7.84542 12.1545C7.63482 11.9439 7.37164 11.7935 7.08324 11.7192L1.97074 10.4008C1.88352 10.3761 1.80675 10.3235 1.75209 10.2512C1.69742 10.1788 1.66785 10.0907 1.66785 9.99998C1.66785 9.90931 1.69742 9.82112 1.75209 9.74878C1.80675 9.67644 1.88352 9.62391 1.97074 9.59915L7.08324 8.27998C7.37153 8.20566 7.63465 8.05546 7.84524 7.84502C8.05584 7.63457 8.20621 7.37156 8.28074 7.08332L9.59908 1.97082C9.62358 1.88325 9.67606 1.8061 9.74851 1.75115C9.82096 1.69619 9.90939 1.66644 10.0003 1.66644C10.0913 1.66644 10.1797 1.69619 10.2521 1.75115C10.3246 1.8061 10.3771 1.88325 10.4016 1.97082L11.7191 7.08332C11.7935 7.37171 11.9438 7.6349 12.1544 7.8455C12.365 8.0561 12.6282 8.20642 12.9166 8.28082L18.0291 9.59832C18.117 9.62257 18.1945 9.67499 18.2498 9.74755C18.305 9.8201 18.335 9.90878 18.335 9.99998C18.335 10.0912 18.305 10.1799 18.2498 10.2524C18.1945 10.325 18.117 10.3774 18.0291 10.4017L12.9166 11.7192C12.6282 11.7935 12.365 11.9439 12.1544 12.1545C11.9438 12.3651 11.7935 12.6283 11.7191 12.9167L10.4007 18.0292C10.3762 18.1167 10.3238 18.1939 10.2513 18.2488C10.1789 18.3038 10.0904 18.3335 9.99949 18.3335C9.90856 18.3335 9.82012 18.3038 9.74768 18.2488C9.67523 18.1939 9.62275 18.1167 9.59824 18.0292L8.28074 12.9167Z" stroke="#002C22" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/><path d="M16.6666 2.5V5.83333" stroke="#002C22" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/><path d="M18.3333 4.16669H15" stroke="#002C22" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/><path d="M3.33337 14.1667V15.8334" stroke="#002C22" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/><path d="M4.16667 15H2.5" stroke="#002C22" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/></g><defs><clipPath id="clip0_18_13201"><rect width="20" height="20" fill="white"/></clipPath></defs></svg>',

        'chart' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.3333 5.83331L11.25 12.9166L7.08329 8.74998L1.66663 14.1666" stroke="#002C22" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/><path d="M13.3334 5.83331H18.3334V10.8333" stroke="#002C22" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/></svg>',

        'trophy' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.83337 7.5V5C5.83337 4.55797 6.00897 4.13405 6.32153 3.82149C6.63409 3.50893 7.05801 3.33333 7.50004 3.33333H12.5C12.9421 3.33333 13.366 3.50893 13.6786 3.82149C13.9911 4.13405 14.1667 4.55797 14.1667 5V7.5" stroke="#002C22" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M5.83337 10C4.94933 10 4.10153 9.64881 3.47641 9.02369C2.85129 8.39857 2.50004 7.55072 2.50004 6.66667C2.50004 6.22464 2.67564 5.80072 2.9882 5.48816C3.30076 5.1756 3.72468 5 4.16671 5H5.83337V10Z" stroke="#002C22" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M14.1667 10C15.0507 10 15.8985 9.64881 16.5236 9.02369C17.1488 8.39857 17.5 7.55072 17.5 6.66667C17.5 6.22464 17.3244 5.80072 17.0119 5.48816C16.6993 5.1756 16.2754 5 15.8334 5H14.1667V10Z" stroke="#002C22" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 13.3333C11.841 13.3333 14.1667 12.0833 14.1667 10V5H5.83337V10C5.83337 12.0833 8.15904 13.3333 10 13.3333Z" stroke="#002C22" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.5 16.6667H12.5" stroke="#002C22" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 13.3333V16.6667" stroke="#002C22" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',

        'coins' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.5 7.5C14.3409 7.5 15.8333 6.00762 15.8333 4.16667C15.8333 2.32572 14.3409 0.833333 12.5 0.833333C10.659 0.833333 9.16663 2.32572 9.16663 4.16667C9.16663 6.00762 10.659 7.5 12.5 7.5Z" stroke="#002C22" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.5 10.8333C9.34095 10.8333 10.8333 9.34095 10.8333 7.5C10.8333 5.65905 9.34095 4.16667 7.5 4.16667C5.65905 4.16667 4.16663 5.65905 4.16663 7.5C4.16663 9.34095 5.65905 10.8333 7.5 10.8333Z" stroke="#002C22" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M12.5 14.1667C14.3409 14.1667 15.8333 12.6743 15.8333 10.8333C15.8333 8.99238 14.3409 7.5 12.5 7.5C10.659 7.5 9.16663 8.99238 9.16663 10.8333C9.16663 12.6743 10.659 14.1667 12.5 14.1667Z" stroke="#002C22" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
    );

    return isset( $icons[ $icon_name ] ) ? $icons[ $icon_name ] : $icons['gift'];
}

/**
 * Render the welcome popup modal HTML and trigger icon
 */
function foursix_render_welcome_popup() {
    // Get all dynamic settings
    $alert_text = foursix_get_popup_option( 'alert_text' );
    $title = foursix_get_popup_option( 'title' );
    $bonus_label = foursix_get_popup_option( 'bonus_label' );
    $bonus_amount = foursix_get_popup_option( 'bonus_amount' );
    $bonus_extra = foursix_get_popup_option( 'bonus_extra' );
    $bonus_subtitle = foursix_get_popup_option( 'bonus_subtitle' );
    $bonus_info = foursix_get_popup_option( 'bonus_info' );
    $button_text = foursix_get_popup_option( 'button_text' );
    $button_url = foursix_get_popup_option( 'button_url' );
    $feature1_title = foursix_get_popup_option( 'feature1_title' );
    $feature1_subtitle = foursix_get_popup_option( 'feature1_subtitle' );
    $feature2_title = foursix_get_popup_option( 'feature2_title' );
    $feature2_subtitle = foursix_get_popup_option( 'feature2_subtitle' );
    $feature3_title = foursix_get_popup_option( 'feature3_title' );
    $feature3_subtitle = foursix_get_popup_option( 'feature3_subtitle' );
    ?>
    <div class="welcome-popop-modal">
        <div class="wel-offer-modal-box">
            <div class="container">
                <div class="header">
                    <div class="coins coin1"></div>
                    <div class="coins coin2"></div>
                    <div class="coins coin3"></div>
                    <div class="coins coin4"></div>

                    <div class="alert-banner">
                        <span class="icon-offer">⚡</span> <?php echo esc_html( $alert_text ); ?>
                    </div>

                    <button class="close-btn">✕</button>

                    <div class="crown-icon">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19.2701 5.44331C19.3421 5.31265 19.4478 5.2037 19.5762 5.12782C19.7046 5.05193 19.851 5.0119 20.0001 5.0119C20.1493 5.0119 20.2957 5.05193 20.4241 5.12782C20.5525 5.2037 20.6582 5.31265 20.7301 5.44331L25.6501 14.7833C25.7675 14.9996 25.9312 15.1872 26.1297 15.3327C26.3281 15.4782 26.5563 15.5779 26.7978 15.6247C27.0394 15.6716 27.2883 15.6644 27.5267 15.6036C27.7651 15.5428 27.9871 15.43 28.1768 15.2733L35.3051 9.16664C35.442 9.05535 35.6106 8.99034 35.7867 8.98098C35.9629 8.97162 36.1374 9.01839 36.2853 9.11455C36.4332 9.21072 36.5467 9.35132 36.6096 9.51613C36.6724 9.68093 36.6814 9.86143 36.6351 10.0316L31.9118 27.1083C31.8154 27.4578 31.6077 27.7662 31.3201 27.987C31.0326 28.2078 30.681 28.3288 30.3185 28.3316H9.68347C9.3207 28.3291 8.96865 28.2083 8.68079 27.9875C8.39293 27.7667 8.18496 27.458 8.08847 27.1083L3.3668 10.0333C3.32055 9.8631 3.32951 9.6826 3.39237 9.51779C3.45524 9.35299 3.56877 9.21239 3.71664 9.11622C3.8645 9.02005 4.03907 8.97328 4.2152 8.98264C4.39134 8.992 4.55997 9.05701 4.6968 9.16831L11.8235 15.275C12.0131 15.4317 12.2352 15.5445 12.4736 15.6053C12.712 15.666 12.9609 15.6733 13.2025 15.6264C13.444 15.5796 13.6722 15.4798 13.8706 15.3343C14.0691 15.1889 14.2328 15.0012 14.3501 14.785L19.2701 5.44331Z" stroke="#002C22" stroke-width="3.33333" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8.33337 35H31.6667" stroke="#002C22" stroke-width="3.33333" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>

                    <div class="title">
                        <span class="icon-welco">🎉</span> <?php echo esc_html( $title ); ?>  <span class="icon-welco2">🎉</span>
                    </div>
                </div>

                <div class="content">
                    <div class="bonus-offer-box">
                        <div class="bonus-label">
                            <span class="icon-wel">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_18_13249)">
                                        <path d="M14.6667 4.66669L9.00004 10.3334L5.66671 7.00002L1.33337 11.3334" stroke="#009966" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M10.6666 4.66669H14.6666V8.66669" stroke="#009966" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_18_13249">
                                            <rect width="16" height="16" fill="white"/>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </span><?php echo esc_html( $bonus_label ); ?>
                        </div>
                        <div class="bonus-box">
                            <span class="bonus-amount"><?php echo esc_html( $bonus_amount ); ?></span>
                            <span class="plus-icon">+</span>
                            <span class="bonus-extra"> <?php echo esc_html( $bonus_extra ); ?></span>
                        </div>
                        <div class="bonus-subtitle"><?php echo esc_html( $bonus_subtitle ); ?></div>
                        <div class="bonus-info"><?php echo esc_html( $bonus_info ); ?></div>
                    </div>

                    <div class="features">
                        <?php
                        // Get features array from settings
                        $features = foursix_get_popup_option( 'features' );
                        if ( empty( $features ) ) {
                            // Fallback to default features structure
                            $features = array(
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
                            );
                        }

                        // Loop through each feature and render
                        foreach ( $features as $feature ) :
                            $icon_value = isset( $feature['icon_value'] ) ? $feature['icon_value'] : 'gift';
                            $title = isset( $feature['title'] ) ? $feature['title'] : '';
                            $subtitle = isset( $feature['subtitle'] ) ? $feature['subtitle'] : '';
                        ?>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <?php echo foursix_get_feature_icon_svg( $icon_value ); ?>
                            </div>
                            <div class="feature-text">
                                <div class="feature-title"><?php echo esc_html( $title ); ?></div>
                                <div class="feature-subtitle"><?php echo esc_html( $subtitle ); ?></div>
                            </div>
                            <div class="checkmark">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_18_13196)">
                                        <path d="M18.1676 8.33332C18.5482 10.2011 18.2769 12.1428 17.3991 13.8348C16.5213 15.5268 15.09 16.8667 13.3438 17.6311C11.5977 18.3955 9.64227 18.5381 7.80367 18.0353C5.96506 17.5325 4.35441 16.4145 3.24031 14.8678C2.12622 13.3212 1.57602 11.4394 1.68147 9.53615C1.78692 7.63294 2.54165 5.8234 3.81979 4.4093C5.09793 2.9952 6.82223 2.06202 8.70514 1.76537C10.588 1.46872 12.5157 1.82654 14.1667 2.77916" stroke="#5EA500" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M7.5 9.16665L10 11.6666L18.3333 3.33331" stroke="#5EA500" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_18_13196">
                                            <rect width="20" height="20" fill="white"/>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <a href="<?php echo esc_url( $button_url ); ?>" class="register-btn">
                        <span class="icon-welco">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 8H4C3.44772 8 3 8.44772 3 9V11C3 11.5523 3.44772 12 4 12H20C20.5523 12 21 11.5523 21 11V9C21 8.44772 20.5523 8 20 8Z" stroke="#002C22" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 8V21" stroke="#002C22" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M19 12V19C19 19.5304 18.7893 20.0391 18.4142 20.4142C18.0391 20.7893 17.5304 21 17 21H7C6.46957 21 5.96086 20.7893 5.58579 20.4142C5.21071 20.0391 5 19.5304 5 19V12" stroke="#002C22" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M7.5 8.00001C6.83696 8.00001 6.20107 7.73662 5.73223 7.26778C5.26339 6.79894 5 6.16305 5 5.50001C5 4.83697 5.26339 4.20108 5.73223 3.73224C6.20107 3.2634 6.83696 3.00001 7.5 3.00001C8.46469 2.9832 9.41003 3.45127 10.2127 4.34317C11.0154 5.23507 11.6383 6.50941 12 8.00001C12.3617 6.50941 12.9846 5.23507 13.7873 4.34317C14.59 3.45127 15.5353 2.9832 16.5 3.00001C17.163 3.00001 17.7989 3.2634 18.2678 3.73224C18.7366 4.20108 19 4.83697 19 5.50001C19 6.16305 18.7366 6.79894 18.2678 7.26778C17.7989 7.73662 17.163 8.00001 16.5 8.00001" stroke="#002C22" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <?php echo esc_html( $button_text ); ?>
                        <span class="right-arrow">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 12H19" stroke="#002C22" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 5L19 12L12 19" stroke="#002C22" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Trigger Icon - Blinking Button to Reopen Modal -->
    <div class="popup-trigger-icon" title="View Special Offer">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 8H4C3.44772 8 3 8.44772 3 9V11C3 11.5523 3.44772 12 4 12H20C20.5523 12 21 11.5523 21 11V9C21 8.44772 20.5523 8 20 8Z"/>
            <path d="M12 8V21"/>
            <path d="M19 12V19C19 19.5304 18.7893 20.0391 18.4142 20.4142C18.0391 20.7893 17.5304 21 17 21H7C6.46957 21 5.96086 20.7893 5.58579 20.4142C5.21071 20.0391 5 19.5304 5 19V12"/>
            <path d="M7.5 8C6.83696 8 6.20107 7.73661 5.73223 7.26777C5.26339 6.79893 5 6.16304 5 5.5C5 4.83696 5.26339 4.20107 5.73223 3.73223C6.20107 3.26339 6.83696 3 7.5 3C8.46469 2.98599 9.41002 3.45126 10.2127 4.34316C11.0154 5.23506 11.6383 6.5094 12 8C12.3617 6.5094 12.9846 5.23506 13.7873 4.34316C14.59 3.45126 15.5353 2.98599 16.5 3C17.163 3 17.7989 3.26339 18.2678 3.73223C18.7366 4.20107 19 4.83696 19 5.5C19 6.16304 18.7366 6.79893 18.2678 7.26777C17.7989 7.73661 17.163 8 16.5 8"/>
        </svg>
    </div>
    <?php
}
add_action( 'wp_footer', 'foursix_render_welcome_popup' );
