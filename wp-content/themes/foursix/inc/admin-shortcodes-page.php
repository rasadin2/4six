<?php
/**
 * Admin Shortcodes Documentation & Tools Page
 *
 * @package foursix
 */

/**
 * Add Admin Menu
 */
function foursix_add_shortcodes_admin_menu() {
    add_menu_page(
        'Shortcodes & Tools',
        'Shortcodes',
        'manage_options',
        'foursix-shortcodes',
        'foursix_render_shortcodes_page',
        'dashicons-shortcode',
        30
    );
}
add_action( 'admin_menu', 'foursix_add_shortcodes_admin_menu' );

/**
 * Handle Post Generation
 */
function foursix_handle_post_generation() {
    if ( ! isset( $_POST['foursix_generate_posts_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['foursix_generate_posts_nonce'], 'foursix_generate_posts' ) ) {
        wp_die( 'Security check failed' );
    }

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Unauthorized access' );
    }

    $post_count = isset( $_POST['post_count'] ) ? absint( $_POST['post_count'] ) : 20;
    $generated = 0;

    // Sample post data
    $sample_titles = array(
        'IPL 2025 Betting Guide: Tips and Strategies for Bangladeshi Bettors',
        'How to Use bKash, Nagad, and Rocket for Online Betting in Bangladesh',
        'Understanding Betting Odds: A Beginner\'s Guide for Bangladesh',
        'Top 10 Cricket Betting Sites in Bangladesh for 2025',
        'Football Betting Strategies: Expert Tips for Bangladesh Bettors',
        'Live Betting vs Pre-Match Betting: Which is Better?',
        'How to Manage Your Betting Bankroll Effectively',
        'The Psychology of Successful Sports Betting',
        'Understanding Value Bets: How to Find Them',
        'Mobile Betting Apps: Complete Guide for Bangladeshi Users',
        'Bangladesh Premier League: Betting Preview and Predictions',
        'In-Play Betting Strategies for Cricket Matches',
        'How to Read Cricket Betting Markets',
        'Responsible Gambling: Setting Limits and Staying Safe',
        'Accumulator Bets Explained: Risks and Rewards',
        'Cash Out Feature: When to Use It for Maximum Profit',
        'Tennis Betting Guide: From Basics to Advanced Strategies',
        'E-Sports Betting: The New Frontier for Bangladesh',
        'Weather Impact on Cricket Betting: What You Need to Know',
        'Betting Bonuses and Promotions: How to Maximize Value'
    );

    $sample_excerpts = array(
        'Get ready for IPL 2025 with our comprehensive betting guide. Learn expert strategies, market analysis, and tips to maximize your cricket betting success.',
        'A complete guide to depositing and withdrawing funds using Bangladesh\'s most popular mobile banking services. Fast, secure, and convenient.',
        'Learn how to read and calculate betting odds like decimal, fractional, and American formats. Understand implied probability and find value bets.',
        'Discover the most trusted and reliable betting platforms available for Bangladeshi bettors in 2025. Compare features, bonuses, and payment methods.',
        'Master the art of football betting with proven strategies from professional bettors. Improve your win rate and betting discipline.',
        'Compare the advantages and disadvantages of live betting versus traditional pre-match betting. Choose the right approach for your style.',
        'Learn professional bankroll management techniques to protect your funds and maximize long-term profitability in sports betting.',
        'Understand the mental aspects of betting success. Learn to control emotions, avoid tilt, and make rational betting decisions.',
        'Discover how to identify value bets that give you an edge over bookmakers. Mathematical approach to profitable betting.',
        'Everything you need to know about betting on mobile devices. App reviews, features comparison, and mobile-exclusive bonuses.'
    );

    $categories = get_categories( array(
        'taxonomy'   => 'category',
        'hide_empty' => false,
    ) );

    $category_ids = array();
    if ( ! empty( $categories ) ) {
        foreach ( $categories as $cat ) {
            $category_ids[] = $cat->term_id;
        }
    }

    // Generate posts
    for ( $i = 0; $i < $post_count; $i++ ) {
        $title = $sample_titles[ $i % count( $sample_titles ) ];
        $excerpt = $sample_excerpts[ $i % count( $sample_excerpts ) ];

        // Generate longer content
        $content = '<p>' . $excerpt . '</p>';
        $content .= '<h2>Introduction</h2>';
        $content .= '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>';
        $content .= '<h2>Key Points</h2>';
        $content .= '<ul><li>Strategic approach to maximize your betting success</li>';
        $content .= '<li>Risk management and bankroll protection techniques</li>';
        $content .= '<li>Market analysis and value identification</li>';
        $content .= '<li>Common mistakes to avoid as a bettor</li></ul>';
        $content .= '<h2>Detailed Analysis</h2>';
        $content .= '<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>';
        $content .= '<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>';
        $content .= '<h2>Conclusion</h2>';
        $content .= '<p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>';

        $post_data = array(
            'post_title'   => $title . ' #' . ( $i + 1 ),
            'post_content' => $content,
            'post_excerpt' => $excerpt,
            'post_status'  => 'publish',
            'post_author'  => get_current_user_id(),
            'post_type'    => 'post',
        );

        $post_id = wp_insert_post( $post_data );

        if ( $post_id && ! is_wp_error( $post_id ) ) {
            // Assign random category if available
            if ( ! empty( $category_ids ) ) {
                $random_cat = $category_ids[ array_rand( $category_ids ) ];
                wp_set_post_categories( $post_id, array( $random_cat ) );
            }

            $generated++;
        }
    }

    add_settings_error(
        'foursix_messages',
        'foursix_message',
        sprintf( __( 'Successfully generated %d posts!', 'foursix' ), $generated ),
        'success'
    );
}
add_action( 'admin_init', 'foursix_handle_post_generation' );

/**
 * Render Admin Page
 */
function foursix_render_shortcodes_page() {
    ?>
    <div class="wrap foursix-admin-wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

        <?php settings_errors( 'foursix_messages' ); ?>

        <div class="foursix-admin-container">

            <!-- Shortcodes Documentation Section -->
            <div class="foursix-admin-section">
                <h2>📚 Available Shortcodes</h2>

                <!-- Blog Cards Shortcode -->
                <div class="shortcode-card">
                    <div class="shortcode-header">
                        <h3>Blog Cards Grid</h3>
                        <span class="shortcode-tag">[blog_cards]</span>
                    </div>

                    <div class="shortcode-description">
                        <p>Display blog posts in a professional grid layout with optional load more functionality.</p>
                    </div>

                    <div class="shortcode-parameters">
                        <h4>Parameters:</h4>
                        <table class="widefat">
                            <thead>
                                <tr>
                                    <th>Parameter</th>
                                    <th>Type</th>
                                    <th>Default</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>loadmore</code></td>
                                    <td>boolean</td>
                                    <td>false</td>
                                    <td>Enable/disable load more button</td>
                                </tr>
                                <tr>
                                    <td><code>perpage</code></td>
                                    <td>number</td>
                                    <td>6</td>
                                    <td>Number of posts to display per page/load</td>
                                </tr>
                                <tr>
                                    <td><code>category</code></td>
                                    <td>string</td>
                                    <td>-</td>
                                    <td>Category slug to filter posts</td>
                                </tr>
                                <tr>
                                    <td><code>order</code></td>
                                    <td>string</td>
                                    <td>DESC</td>
                                    <td>Sort order (DESC or ASC)</td>
                                </tr>
                                <tr>
                                    <td><code>orderby</code></td>
                                    <td>string</td>
                                    <td>date</td>
                                    <td>Sort by (date, title, rand, etc.)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="shortcode-examples">
                        <h4>Usage Examples:</h4>
                        <div class="example-item">
                            <strong>Basic usage:</strong>
                            <code class="code-block">[blog_cards]</code>
                            <p class="example-desc">Display 6 recent posts in grid layout</p>
                        </div>
                        <div class="example-item">
                            <strong>With load more:</strong>
                            <code class="code-block">[blog_cards loadmore="true" perpage="9"]</code>
                            <p class="example-desc">Show 9 posts with load more button</p>
                        </div>
                        <div class="example-item">
                            <strong>Category filter:</strong>
                            <code class="code-block">[blog_cards loadmore="true" perpage="6" category="sports"]</code>
                            <p class="example-desc">Show sports category posts with pagination</p>
                        </div>
                        <div class="example-item">
                            <strong>Custom sorting:</strong>
                            <code class="code-block">[blog_cards orderby="title" order="ASC" perpage="12"]</code>
                            <p class="example-desc">Show 12 posts sorted alphabetically</p>
                        </div>
                    </div>

                    <div class="shortcode-features">
                        <h4>✨ Features:</h4>
                        <ul>
                            <li>✅ Responsive 3-column grid layout</li>
                            <li>✅ AJAX-powered load more functionality</li>
                            <li>✅ Animated card insertion</li>
                            <li>✅ Reading time calculation</li>
                            <li>✅ Category filtering support</li>
                            <li>✅ Progress counter display</li>
                            <li>✅ Professional gradient design</li>
                            <li>✅ Mobile-optimized layout</li>
                        </ul>
                    </div>
                </div>

            </div>

            <!-- Post Generator Section -->
            <div class="foursix-admin-section">
                <h2>🚀 Post Generator</h2>

                <div class="generator-card">
                    <div class="generator-description">
                        <p>Generate sample blog posts for testing and development purposes. This will create posts with realistic content, titles, and categories.</p>
                    </div>

                    <form method="post" action="">
                        <?php wp_nonce_field( 'foursix_generate_posts', 'foursix_generate_posts_nonce' ); ?>

                        <div class="generator-controls">
                            <div class="control-group">
                                <label for="post_count">Number of Posts:</label>
                                <input type="number"
                                       id="post_count"
                                       name="post_count"
                                       value="20"
                                       min="1"
                                       max="100"
                                       class="regular-text">
                                <p class="description">Generate between 1 and 100 sample posts</p>
                            </div>

                            <div class="control-group">
                                <button type="submit" class="button button-primary button-hero">
                                    <span class="dashicons dashicons-plus-alt"></span>
                                    Generate Posts
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="generator-info">
                        <h4>ℹ️ What will be generated:</h4>
                        <ul>
                            <li>Posts with realistic betting/sports-related titles</li>
                            <li>Structured content with headings and paragraphs</li>
                            <li>Excerpts and reading time</li>
                            <li>Random category assignments</li>
                            <li>Published status (immediately visible)</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        .foursix-admin-wrap {
            background: #f0f0f1;
            margin: -10px -20px;
            padding: 20px;
        }

        .foursix-admin-wrap h1 {
            background: #fff;
            padding: 20px 30px;
            margin: 0 0 20px 0;
            border-left: 4px solid #2271b1;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .foursix-admin-container {
            max-width: 1200px;
        }

        .foursix-admin-section {
            background: #fff;
            padding: 30px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .foursix-admin-section h2 {
            margin: 0 0 25px 0;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f1;
            font-size: 22px;
        }

        .shortcode-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }

        .shortcode-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e0e0e0;
        }

        .shortcode-header h3 {
            margin: 0;
            color: #1d2327;
        }

        .shortcode-tag {
            background: linear-gradient(135deg, #2271b1 0%, #1d5a8a 100%);
            color: #fff;
            padding: 8px 16px;
            border-radius: 6px;
            font-family: monospace;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .shortcode-description {
            margin: 15px 0;
            font-size: 15px;
            line-height: 1.6;
        }

        .shortcode-parameters h4,
        .shortcode-examples h4,
        .shortcode-features h4 {
            margin: 20px 0 12px 0;
            color: #1d2327;
            font-size: 16px;
        }

        .shortcode-parameters table {
            margin: 10px 0;
        }

        .shortcode-parameters table th {
            background: #f0f0f1;
            font-weight: 600;
        }

        .shortcode-parameters table code {
            background: #f0f0f1;
            padding: 3px 8px;
            border-radius: 3px;
            color: #d63638;
            font-size: 13px;
        }

        .example-item {
            background: #f8f9fa;
            border-left: 4px solid #2271b1;
            padding: 15px;
            margin: 10px 0;
            border-radius: 4px;
        }

        .example-item strong {
            display: block;
            margin-bottom: 8px;
            color: #1d2327;
        }

        .code-block {
            display: block;
            background: #1d2327;
            color: #50fa7b;
            padding: 12px 15px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            margin: 8px 0;
            overflow-x: auto;
        }

        .example-desc {
            margin: 8px 0 0 0;
            font-size: 13px;
            color: #646970;
            font-style: italic;
        }

        .shortcode-features ul {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            margin: 10px 0;
            padding: 0;
            list-style: none;
        }

        .shortcode-features li {
            background: #f0f0f1;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 14px;
        }

        .generator-card {
            border: 2px dashed #2271b1;
            border-radius: 8px;
            padding: 25px;
            background: linear-gradient(135deg, #f0f8ff 0%, #ffffff 100%);
        }

        .generator-description {
            margin-bottom: 20px;
            font-size: 15px;
            line-height: 1.6;
        }

        .generator-controls {
            background: #fff;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            border: 1px solid #e0e0e0;
        }

        .control-group {
            margin-bottom: 20px;
        }

        .control-group:last-child {
            margin-bottom: 0;
        }

        .control-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #1d2327;
        }

        .control-group input[type="number"] {
            max-width: 200px;
        }

        .button-hero {
            padding: 12px 24px !important;
            height: auto !important;
            font-size: 16px !important;
        }

        .button-hero .dashicons {
            font-size: 18px;
            height: 18px;
            width: 18px;
            vertical-align: middle;
            margin-right: 5px;
        }

        .generator-info {
            margin-top: 20px;
            padding: 15px;
            background: #fff;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
        }

        .generator-info h4 {
            margin: 0 0 12px 0;
            color: #1d2327;
        }

        .generator-info ul {
            margin: 0;
            padding-left: 20px;
        }

        .generator-info li {
            margin: 6px 0;
            line-height: 1.6;
        }

        @media (max-width: 782px) {
            .shortcode-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .shortcode-features ul {
                grid-template-columns: 1fr;
            }

            .foursix-admin-section {
                padding: 20px;
            }
        }
    </style>
    <?php
}
