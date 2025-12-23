<?php
/**
 * Blog Post CTA Section Meta Box
 *
 * Adds customizable CTA section to blog posts with default values
 *
 * @package foursix
 */

/**
 * Add Meta Box
 */
function foursix_blog_cta_add_meta_box() {
    add_meta_box(
        'foursix_blog_cta',
        'Blog CTA Section',
        'foursix_blog_cta_meta_box_callback',
        'post',
        'normal',
        'default'
    );
}
add_action( 'add_meta_boxes', 'foursix_blog_cta_add_meta_box' );

/**
 * Meta Box Callback
 */
function foursix_blog_cta_meta_box_callback( $post ) {
    // Add nonce for security
    wp_nonce_field( 'foursix_blog_cta_nonce', 'foursix_blog_cta_nonce_field' );

    // Get existing values - Bottom CTA
    $cta_title = get_post_meta( $post->ID, '_blog_cta_title', true );
    $cta_description = get_post_meta( $post->ID, '_blog_cta_description', true );
    $cta_button_text = get_post_meta( $post->ID, '_blog_cta_button_text', true );
    $cta_button_url = get_post_meta( $post->ID, '_blog_cta_button_url', true );
    $cta_enabled = get_post_meta( $post->ID, '_blog_cta_enabled', true );

    // Get existing values - Mid Content CTA
    $mid_cta_enabled = get_post_meta( $post->ID, '_blog_mid_cta_enabled', true );
    $mid_cta_title = get_post_meta( $post->ID, '_blog_mid_cta_title', true );
    $mid_cta_items = get_post_meta( $post->ID, '_blog_mid_cta_items', true );
    $mid_cta_position = get_post_meta( $post->ID, '_blog_mid_cta_position', true );

    // Set default values if empty - Bottom CTA
    if ( empty( $cta_enabled ) ) {
        $cta_enabled = '1'; // Enabled by default
    }
    if ( empty( $cta_title ) ) {
        $cta_title = 'Ready to Place Your Bets?';
    }
    if ( empty( $cta_description ) ) {
        $cta_description = 'Join 4six today and start betting on your favorite sports and casino games with the best odds in Bangladesh!';
    }
    if ( empty( $cta_button_text ) ) {
        $cta_button_text = 'Sign Up Now';
    }
    if ( empty( $cta_button_url ) ) {
        $cta_button_url = '#';
    }

    // Set default values if empty - Mid Content CTA
    if ( empty( $mid_cta_enabled ) ) {
        $mid_cta_enabled = '1'; // Enabled by default
    }
    if ( empty( $mid_cta_title ) ) {
        $mid_cta_title = 'Top IPL Betting Markets:';
    }
    if ( empty( $mid_cta_items ) ) {
        $mid_cta_items = "Match Winner - Predict which team will win the match\nTop Batsman - Bet on the highest run-scorer in the match\nTotal Runs - Over/under on total runs scored\nTournament Winner - Long-term bet on the IPL champion";
    }
    if ( empty( $mid_cta_position ) ) {
        $mid_cta_position = '3'; // After 3rd paragraph by default
    }

    ?>
    <div style="padding: 15px 0;">
        <p style="margin-bottom: 20px; color: #666; font-style: italic;">
            Customize the call-to-action section that appears before related posts. Leave fields empty to use default values.
        </p>

        <!-- Enable/Disable CTA -->
        <p style="margin-bottom: 20px;">
            <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox"
                       name="blog_cta_enabled"
                       value="1"
                       <?php checked( $cta_enabled, '1' ); ?>
                       style="margin: 0;">
                <strong>Enable CTA Section</strong>
            </label>
        </p>

        <!-- CTA Title -->
        <p>
            <label for="blog_cta_title" style="display: block; margin-bottom: 5px; font-weight: 600;">
                CTA Title:
            </label>
            <input type="text"
                   id="blog_cta_title"
                   name="blog_cta_title"
                   value="<?php echo esc_attr( $cta_title ); ?>"
                   placeholder="Ready to Place Your Bets?"
                   style="width: 100%; padding: 8px 12px; font-size: 14px;">
        </p>

        <!-- CTA Description -->
        <p>
            <label for="blog_cta_description" style="display: block; margin-bottom: 5px; font-weight: 600;">
                CTA Description:
            </label>
            <textarea id="blog_cta_description"
                      name="blog_cta_description"
                      rows="3"
                      placeholder="Join 4six today and start betting..."
                      style="width: 100%; padding: 8px 12px; font-size: 14px;"><?php echo esc_textarea( $cta_description ); ?></textarea>
        </p>

        <!-- Button Text -->
        <p>
            <label for="blog_cta_button_text" style="display: block; margin-bottom: 5px; font-weight: 600;">
                Button Text:
            </label>
            <input type="text"
                   id="blog_cta_button_text"
                   name="blog_cta_button_text"
                   value="<?php echo esc_attr( $cta_button_text ); ?>"
                   placeholder="Sign Up Now"
                   style="width: 100%; padding: 8px 12px; font-size: 14px;">
        </p>

        <!-- Button URL -->
        <p>
            <label for="blog_cta_button_url" style="display: block; margin-bottom: 5px; font-weight: 600;">
                Button URL:
            </label>
            <input type="url"
                   id="blog_cta_button_url"
                   name="blog_cta_button_url"
                   value="<?php echo esc_url( $cta_button_url ); ?>"
                   placeholder="https://example.com/register"
                   style="width: 100%; padding: 8px 12px; font-size: 14px;">
        </p>

        <div style="background: #f0f0f1; padding: 12px; border-left: 4px solid #2271b1; margin-top: 20px;">
            <p style="margin: 0; font-size: 13px; color: #646970;">
                <strong>💡 Tip:</strong> The CTA section will appear after the blog content and before related posts.
                It matches the design from your screenshot with yellow/golden border and gradient background.
            </p>
        </div>

        <!-- Separator -->
        <hr style="margin: 40px 0; border: none; border-top: 2px solid #e0e0e0;">

        <!-- Mid-Content CTA Section -->
        <h3 style="margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid #2271b1;">Mid-Content Info Box</h3>

        <p style="margin-bottom: 20px; color: #666; font-style: italic;">
            This teal-bordered info box appears in the middle of your post content. Perfect for highlighting key information, markets, or tips.
        </p>

        <!-- Enable/Disable Mid CTA -->
        <p style="margin-bottom: 20px;">
            <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox"
                       name="blog_mid_cta_enabled"
                       value="1"
                       <?php checked( $mid_cta_enabled, '1' ); ?>
                       style="margin: 0;">
                <strong>Enable Mid-Content Box</strong>
            </label>
        </p>

        <!-- Mid CTA Title -->
        <p>
            <label for="blog_mid_cta_title" style="display: block; margin-bottom: 5px; font-weight: 600;">
                Box Title:
            </label>
            <input type="text"
                   id="blog_mid_cta_title"
                   name="blog_mid_cta_title"
                   value="<?php echo esc_attr( $mid_cta_title ); ?>"
                   placeholder="Top IPL Betting Markets:"
                   style="width: 100%; padding: 8px 12px; font-size: 14px;">
        </p>

        <!-- Mid CTA Items -->
        <p>
            <label for="blog_mid_cta_items" style="display: block; margin-bottom: 5px; font-weight: 600;">
                List Items:
                <span style="font-weight: normal; color: #666; font-size: 12px;">(One per line. Format: <code>Label - Description</code>)</span>
            </label>
            <textarea id="blog_mid_cta_items"
                      name="blog_mid_cta_items"
                      rows="6"
                      placeholder="Match Winner - Predict which team will win&#10;Top Batsman - Bet on the highest run-scorer&#10;Total Runs - Over/under on total runs scored"
                      style="width: 100%; padding: 8px 12px; font-size: 14px; font-family: monospace;"><?php echo esc_textarea( $mid_cta_items ); ?></textarea>
        </p>

        <!-- Mid CTA Position -->
        <p>
            <label for="blog_mid_cta_position" style="display: block; margin-bottom: 5px; font-weight: 600;">
                Insert After Paragraph:
                <span style="font-weight: normal; color: #666; font-size: 12px;">(Enter paragraph number, e.g., 3 = after 3rd paragraph)</span>
            </label>
            <input type="number"
                   id="blog_mid_cta_position"
                   name="blog_mid_cta_position"
                   value="<?php echo esc_attr( $mid_cta_position ); ?>"
                   min="1"
                   max="20"
                   placeholder="3"
                   style="width: 150px; padding: 8px 12px; font-size: 14px;">
        </p>

        <div style="background: #d7f7e8; padding: 12px; border-left: 4px solid #10b981; margin-top: 20px;">
            <p style="margin: 0; font-size: 13px; color: #0f5132;">
                <strong>✨ Design:</strong> Teal/cyan gradient border, dark teal background, bullet points with bold labels.
                Automatically inserted into your post content at the specified position.
            </p>
        </div>
    </div>
    <?php
}

/**
 * Save Meta Box Data
 */
function foursix_blog_cta_save_meta_box( $post_id ) {
    // Check nonce
    if ( ! isset( $_POST['foursix_blog_cta_nonce_field'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['foursix_blog_cta_nonce_field'], 'foursix_blog_cta_nonce' ) ) {
        return;
    }

    // Check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // Save enabled status
    $cta_enabled = isset( $_POST['blog_cta_enabled'] ) ? '1' : '0';
    update_post_meta( $post_id, '_blog_cta_enabled', $cta_enabled );

    // Save CTA Title
    if ( isset( $_POST['blog_cta_title'] ) ) {
        update_post_meta( $post_id, '_blog_cta_title', sanitize_text_field( $_POST['blog_cta_title'] ) );
    }

    // Save CTA Description
    if ( isset( $_POST['blog_cta_description'] ) ) {
        update_post_meta( $post_id, '_blog_cta_description', sanitize_textarea_field( $_POST['blog_cta_description'] ) );
    }

    // Save Button Text
    if ( isset( $_POST['blog_cta_button_text'] ) ) {
        update_post_meta( $post_id, '_blog_cta_button_text', sanitize_text_field( $_POST['blog_cta_button_text'] ) );
    }

    // Save Button URL
    if ( isset( $_POST['blog_cta_button_url'] ) ) {
        update_post_meta( $post_id, '_blog_cta_button_url', esc_url_raw( $_POST['blog_cta_button_url'] ) );
    }

    // Save Mid-Content CTA Data
    $mid_cta_enabled = isset( $_POST['blog_mid_cta_enabled'] ) ? '1' : '0';
    update_post_meta( $post_id, '_blog_mid_cta_enabled', $mid_cta_enabled );

    if ( isset( $_POST['blog_mid_cta_title'] ) ) {
        update_post_meta( $post_id, '_blog_mid_cta_title', sanitize_text_field( $_POST['blog_mid_cta_title'] ) );
    }

    if ( isset( $_POST['blog_mid_cta_items'] ) ) {
        update_post_meta( $post_id, '_blog_mid_cta_items', sanitize_textarea_field( $_POST['blog_mid_cta_items'] ) );
    }

    if ( isset( $_POST['blog_mid_cta_position'] ) ) {
        update_post_meta( $post_id, '_blog_mid_cta_position', absint( $_POST['blog_mid_cta_position'] ) );
    }
}
add_action( 'save_post', 'foursix_blog_cta_save_meta_box' );

/**
 * Get CTA Data with Defaults
 *
 * Helper function to get CTA data with fallback to defaults
 */
function foursix_get_blog_cta_data( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    // Check if CTA is enabled
    $enabled = get_post_meta( $post_id, '_blog_cta_enabled', true );
    if ( $enabled === '0' ) {
        return false; // CTA disabled
    }

    // Get meta values or use defaults
    $title = get_post_meta( $post_id, '_blog_cta_title', true );
    if ( empty( $title ) ) {
        $title = 'Ready to Place Your Bets?';
    }

    $description = get_post_meta( $post_id, '_blog_cta_description', true );
    if ( empty( $description ) ) {
        $description = 'Join 4six today and start betting on your favorite sports and casino games with the best odds in Bangladesh!';
    }

    $button_text = get_post_meta( $post_id, '_blog_cta_button_text', true );
    if ( empty( $button_text ) ) {
        $button_text = 'Sign Up Now';
    }

    $button_url = get_post_meta( $post_id, '_blog_cta_button_url', true );
    if ( empty( $button_url ) ) {
        $button_url = '#';
    }

    return array(
        'title'       => $title,
        'description' => $description,
        'button_text' => $button_text,
        'button_url'  => $button_url,
    );
}

/**
 * Inject Mid-Content CTA Box into Post Content
 */
function foursix_inject_mid_content_cta( $content ) {
    // Only run on single post pages
    if ( ! is_single() || get_post_type() !== 'post' ) {
        return $content;
    }

    global $post;

    // Check if mid-content CTA is enabled
    $enabled = get_post_meta( $post->ID, '_blog_mid_cta_enabled', true );
    if ( $enabled === '0' ) {
        return $content; // Disabled
    }

    // Get mid-content CTA data
    $title = get_post_meta( $post->ID, '_blog_mid_cta_title', true );
    if ( empty( $title ) ) {
        $title = 'Top IPL Betting Markets:';
    }

    $items_text = get_post_meta( $post->ID, '_blog_mid_cta_items', true );
    if ( empty( $items_text ) ) {
        $items_text = "Match Winner - Predict which team will win the match\nTop Batsman - Bet on the highest run-scorer in the match\nTotal Runs - Over/under on total runs scored\nTournament Winner - Long-term bet on the IPL champion";
    }

    $position = get_post_meta( $post->ID, '_blog_mid_cta_position', true );
    if ( empty( $position ) ) {
        $position = 3; // Default to after 3rd paragraph
    }

    // Parse items
    $items = array();
    $lines = explode( "\n", trim( $items_text ) );
    foreach ( $lines as $line ) {
        $line = trim( $line );
        if ( ! empty( $line ) ) {
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

    // Generate the mid-content box HTML
    ob_start();
    ?>
    <div class="blog-markets-box blog-mid-content-box">
        <h4><?php echo esc_html( $title ); ?></h4>
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
    $mid_cta_html = ob_get_clean();

    // Split content by paragraphs (look for closing </p> tags)
    $paragraphs = preg_split( '/(<\/p>)/i', $content, -1, PREG_SPLIT_DELIM_CAPTURE );

    // Count actual paragraphs (every pair of array items is one paragraph)
    $paragraph_count = 0;
    $new_content = '';
    $inserted = false;

    for ( $i = 0; $i < count( $paragraphs ); $i++ ) {
        $new_content .= $paragraphs[ $i ];

        // Check if this is a closing tag
        if ( $paragraphs[ $i ] === '</p>' ) {
            $paragraph_count++;

            // Insert mid-content box after specified paragraph
            if ( $paragraph_count == $position && ! $inserted ) {
                $new_content .= "\n\n" . $mid_cta_html . "\n\n";
                $inserted = true;
            }
        }
    }

    // If we couldn't insert (not enough paragraphs), append to end
    if ( ! $inserted && ! empty( $items ) ) {
        $new_content .= "\n\n" . $mid_cta_html;
    }

    return $new_content;
}
add_filter( 'the_content', 'foursix_inject_mid_content_cta', 20 );
