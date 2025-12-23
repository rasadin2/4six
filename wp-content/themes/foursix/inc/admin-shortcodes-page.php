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
 * Handle Promotion Generation
 */
function foursix_handle_promotion_generation() {
    if ( ! isset( $_POST['foursix_generate_promotions_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['foursix_generate_promotions_nonce'], 'foursix_generate_promotions' ) ) {
        wp_die( 'Security check failed' );
    }

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Unauthorized access' );
    }

    $generated = 0;

    // Sample promotion data
    $promotions_data = array(
        array(
            'title' => 'Welcome Bonus - 100% up to ৳10,000',
            'content' => 'Get a 100% match bonus on your first deposit up to ৳10,000. Double your bankroll and start betting with more money!',
            'badge_text' => 'New Players',
            'badge_color' => 'green',
            'icon_type' => 'gift',
            'icon_value' => '10,000',
            'subtitle' => '100% up to ৳10,000',
            'button_text' => 'Claim This Offer',
            'button_color' => 'green',
            'card_color' => 'teal',
            'terms' => "Minimum deposit: ৳500\nWagering requirement: 5x bonus amount\nValid for 30 days from activation\nAvailable for new users only",
            'claim' => "Create a new 4six account\nMake your first deposit of ৳500 or more\nBonus automatically credited to your account\nStart betting and fulfill wagering requirements",
            'menu_order' => 1
        ),
        array(
            'title' => 'Cricket Cashback - 10% Every Week',
            'content' => 'Lost on cricket betting this week? Get 10% cashback on all your cricket losses every Monday, up to ৳5,000!',
            'badge_text' => 'Weekly Offer',
            'badge_color' => 'yellow',
            'icon_type' => 'trophy',
            'icon_value' => '10',
            'subtitle' => '10% Weekly Cashback',
            'button_text' => 'Claim This Offer',
            'button_color' => 'yellow',
            'card_color' => 'navy',
            'terms' => "Minimum loss: ৳500 to qualify\nMaximum cashback: 10,000 per week\nCalculated every Monday\nNo wagering requirement on cashback",
            'claim' => "Bet on cricket matches during the week\nLosses are calculated every Sunday\nCashback credited every Monday at 12:00 PM\nUse cashback immediately or save it",
            'menu_order' => 2
        ),
        array(
            'title' => 'Refer a Friend - ৳1,000 Bonus',
            'content' => 'Invite your friends to 4six and earn ৳1,000 for each friend who signs up and makes their first deposit!',
            'badge_text' => 'Referral Bonus',
            'badge_color' => 'green',
            'icon_type' => 'gift',
            'icon_value' => '1,000',
            'subtitle' => '৳1,000 per referral',
            'button_text' => 'Claim This Offer',
            'button_color' => 'purple',
            'card_color' => 'purple',
            'terms' => "Friend must be new to 4six\nMinimum friend deposit: ৳1,000\nYour friend receives ৳500 signup bonus\nUnlimited referrals allowed",
            'claim' => "Get your unique referral link\nShare it with your using your link\nFriend makes first deposit of ৳1,000+\nBoth receive bonuses within 24 hours",
            'menu_order' => 3
        ),
        array(
            'title' => 'Live Betting Boost - 20% Extra Winnings',
            'content' => 'Bet on live cricket and football matches and get 20% extra on your winnings! Available daily from 6 PM to 12 AM',
            'badge_text' => 'Daily Offer',
            'badge_color' => 'orange',
            'icon_type' => 'zap',
            'icon_value' => '20',
            'subtitle' => '20% Boost Daily',
            'button_text' => 'Claim This Offer',
            'button_color' => 'pink',
            'card_color' => 'burgundy',
            'terms' => "Available 6 PM - 12 AM only\nMinimum bet: ৳100\nApplies to live cricket and football bets\nMaximum boost: ৳2,000 per day",
            'claim' => "Place live bets during promotional hours\nIf you bet wins, 20% extra credited\nNo opt-in required, automatic\nWinnings paid as boosted bets",
            'menu_order' => 4
        ),
        array(
            'title' => 'Free Bet Friday - ৳500 Risk Free',
            'content' => 'Every Friday, place a ৳500 bet on any sport. If you lose, we\'ll refund your stake as a free bet!',
            'badge_text' => 'Weekly Offer',
            'badge_color' => 'green',
            'icon_type' => 'gift',
            'icon_value' => '500',
            'subtitle' => '৳500 Risk Free',
            'button_text' => 'Claim This Offer',
            'button_color' => 'blue',
            'card_color' => 'blue',
            'terms' => "Available every Friday\nOne free bet per user\nQualifying bet must be ৳500\nFree bet valid for 7 days",
            'claim' => "Opt-in to the promotion on Friday\nPlace a single ৳500 bet on any sport\nIf bet loses, free bet credited within 2 hrs\nUse free bet on any sport within 7 days",
            'menu_order' => 5
        ),
        array(
            'title' => 'Casino Reload Bonus - 50% up to ৳5,000',
            'content' => 'Reload your account every weekend and get 50% extra for casino and slots games!',
            'badge_text' => 'Weekend Offer',
            'badge_color' => 'orange',
            'icon_type' => 'trophy',
            'icon_value' => '50',
            'subtitle' => '50% Weekend Reload',
            'button_text' => 'Claim This Offer',
            'button_color' => 'orange',
            'card_color' => 'brown',
            'terms' => "Available Friday to Sunday\nMinimum deposit: ৳1,000\nMaximum bonus: ৳5,000\nWagering requirement: 30x bonus",
            'claim' => "Make a deposit between Friday-Sunday\nEnter promo code: CASINO50\n50% bonus credited instantly\nPlay casino games and clear wagering",
            'menu_order' => 6
        ),
        array(
            'title' => 'VIP Loyalty Rewards Program',
            'content' => 'Climb the VIP tiers and unlock exclusive bonuses, higher withdrawal limits, personal account manager, and special gifts!',
            'badge_text' => 'VIP Program',
            'badge_color' => 'yellow',
            'icon_type' => 'trophy',
            'icon_value' => 'VIP',
            'subtitle' => 'Exclusive VIP Benefits',
            'button_text' => 'Learn More',
            'button_color' => 'yellow',
            'card_color' => 'yellow-brown',
            'terms' => "Automatic tier progression\nEarn points with every ৳100 wagered\nHigher tiers: bigger bonuses\nPersonal VIP manager from Gold tier",
            'claim' => "Start betting to earn VIP points\nReach tier milestones automatically\nEarn 1 point for every ৳100 wagered\nClaim VIP benefits from your dashboard",
            'menu_order' => 7
        ),
        array(
            'title' => 'IPL Special - Enhanced Odds Daily',
            'content' => 'Get 20% better odds on every IPL match! Bet on your favorite teams with enhanced odds daily!',
            'badge_text' => 'IPL Special',
            'badge_color' => 'green',
            'icon_type' => 'trophy',
            'icon_value' => '20',
            'subtitle' => 'Enhanced IPL Odds',
            'button_text' => 'Claim This Offer',
            'button_color' => 'green',
            'card_color' => 'dark-teal',
            'terms' => "Valid during IPL season\nEnhanced odds on selected markets\nOne enhanced bet per user per day\nMaximum stake: ৳2,000",
            'claim' => "Check daily IPL enhanced odds\nPlace bet on promoted market\nOdds automatically boosted\nWinnings paid at boosted rate",
            'menu_order' => 8
        ),
        array(
            'title' => 'Accumulator Insurance - 5 Fold Refund',
            'content' => 'Place a 5+ selection accumulator. If just one leg lets you down, we\'ll refund your stake up to ৳1,000!',
            'badge_text' => 'Acca Offer',
            'badge_color' => 'yellow',
            'icon_type' => 'gift',
            'icon_value' => '1,000',
            'subtitle' => '5-Fold Protection',
            'button_text' => 'Claim This Offer',
            'button_color' => 'yellow',
            'card_color' => 'navy',
            'terms' => "Minimum 5 selections required\nEach selection min odds 1.50\nOne leg must lose, rest must win\nMaximum refund: ৳1,000",
            'claim' => "Build an accumulator with 5+ selections\nPlace your bet (min stake ৳100)\nIf exactly 1 leg loses, get refund\nRefund credited as free bet within 24h",
            'menu_order' => 9
        ),
        array(
            'title' => 'Monday Reload - 25% Bonus',
            'content' => 'Start your week right with a 25% reload bonus every Monday! Available for all users.',
            'badge_text' => 'Weekly',
            'badge_color' => 'green',
            'icon_type' => 'zap',
            'icon_value' => '25',
            'subtitle' => '25% Monday Boost',
            'button_text' => 'Claim This Offer',
            'button_color' => 'green',
            'card_color' => 'teal',
            'terms' => "Available every Monday\nMinimum deposit: ৳500\nMaximum bonus: ৳2,500\nWagering: 5x bonus amount",
            'claim' => "Make a deposit on Monday\nUse promo code: MONDAY25\nBonus credited automatically\nStart betting to clear wagering",
            'menu_order' => 10
        ),
        array(
            'title' => 'Football Frenzy - ৳10,000 Prize Pool',
            'content' => 'Compete with other players in our weekly football betting competition. Top 20 players share ৳10,000!',
            'badge_text' => 'Competition',
            'badge_color' => 'orange',
            'icon_type' => 'trophy',
            'icon_value' => '10,000',
            'subtitle' => 'Weekly Competition',
            'button_text' => 'Join Now',
            'button_color' => 'blue',
            'card_color' => 'blue',
            'terms' => "Runs Monday to Sunday\nBet on football to earn leaderboard points\nTop 20 players win prizes\nNo minimum bet required",
            'claim' => "Opt-in to weekly competition\nPlace football bets during the week\nTrack your rank on leaderboard\nPrizes paid every Monday",
            'menu_order' => 11
        ),
        array(
            'title' => 'Birthday Bonus - ৳2,000 Free',
            'content' => 'Celebrate your birthday with us! Get a special ৳2,000 bonus on your birthday month.',
            'badge_text' => 'Special',
            'badge_color' => 'green',
            'icon_type' => 'gift',
            'icon_value' => '2,000',
            'subtitle' => 'Birthday Gift',
            'button_text' => 'Claim Gift',
            'button_color' => 'pink',
            'card_color' => 'purple',
            'terms' => "Must verify birthdate in account\nAvailable once per year\nNo deposit required\nWagering: 3x bonus",
            'claim' => "Verify your birthdate in profile\nWait for birthday month\nClaim bonus from promotions page\nEnjoy your birthday gift!",
            'menu_order' => 12
        ),
        array(
            'title' => 'Early Payout - Football Wins',
            'content' => 'Bet on football match winner. If your team goes 2 goals ahead, we pay you early - even if they lose!',
            'badge_text' => 'Football',
            'badge_color' => 'yellow',
            'icon_type' => 'zap',
            'icon_value' => '2',
            'subtitle' => '2 Goals Ahead',
            'button_text' => 'Learn More',
            'button_color' => 'yellow',
            'card_color' => 'burgundy',
            'terms' => "Applies to pre-match football only\nMatch Winner market only\nYour team must go 2 goals ahead\nMaximum payout: ৳50,000",
            'claim' => "Place bet on Match Winner market\nIf your team leads by 2 goals\nBet is settled as winner immediately\nEven if final result is different",
            'menu_order' => 13
        ),
        array(
            'title' => 'Streak Bonus - Win 5 Get ৳500',
            'content' => 'Win 5 bets in a row and earn a ৳500 bonus! The more you win consecutively, the bigger the rewards.',
            'badge_text' => 'Loyalty',
            'badge_color' => 'green',
            'icon_type' => 'trophy',
            'icon_value' => '500',
            'subtitle' => '5-Win Streak',
            'button_text' => 'Start Streak',
            'button_color' => 'green',
            'card_color' => 'teal',
            'terms' => "Minimum bet: ৳200 per bet\nMinimum odds: 1.50 per bet\nAll 5 bets must win\nBonus credited automatically",
            'claim' => "Place qualifying bets\nWin 5 consecutive bets\n৳500 bonus credited automatically\nUse bonus on any sport",
            'menu_order' => 14
        ),
        array(
            'title' => 'Tennis Accumulator - 20% Boost',
            'content' => 'Build a tennis accumulator with 3+ selections and get a 20% boost on your winnings!',
            'badge_text' => 'Tennis',
            'badge_color' => 'yellow',
            'icon_type' => 'zap',
            'icon_value' => '20',
            'subtitle' => '20% Acca Boost',
            'button_text' => 'Bet Tennis',
            'button_color' => 'blue',
            'card_color' => 'blue',
            'terms' => "Minimum 3 tennis selections\nEach selection min odds 1.30\nMaximum boost: ৳3,000\nPre-match bets only",
            'claim' => "Build tennis accumulator (3+ legs)\nPlace your bet\nIf acca wins, 20% boost applied\nBoost paid with winnings",
            'menu_order' => 15
        ),
        array(
            'title' => 'Midweek Madness - 50% Deposit Bonus',
            'content' => 'Wednesdays just got better! Get 50% bonus on deposits made every Wednesday.',
            'badge_text' => 'Wednesday',
            'badge_color' => 'orange',
            'icon_type' => 'gift',
            'icon_value' => '50',
            'subtitle' => 'Wednesday Special',
            'button_text' => 'Deposit Now',
            'button_color' => 'orange',
            'card_color' => 'brown',
            'terms' => "Every Wednesday only\nMinimum deposit: ৳1,000\nMaximum bonus: ৳3,000\nWagering: 6x bonus",
            'claim' => "Make deposit on Wednesday\nUse code: WED50\nBonus credited instantly\nPlay and clear wagering",
            'menu_order' => 16
        ),
        array(
            'title' => 'First Goal Scorer Insurance',
            'content' => 'Bet on First Goalscorer. If your player scores 2nd, 3rd or 4th, get your stake back as free bet!',
            'badge_text' => 'Football',
            'badge_color' => 'green',
            'icon_type' => 'trophy',
            'icon_value' => 'FGS',
            'subtitle' => 'Scorer Insurance',
            'button_text' => 'Place Bet',
            'button_color' => 'green',
            'card_color' => 'dark-teal',
            'terms' => "First Goalscorer market only\nIf player scores 2nd/3rd/4th\nStake refunded as free bet\nMax refund: ৳1,500 per bet",
            'claim' => "Bet on First Goalscorer\nIf player doesn't score first\nBut scores 2nd/3rd/4th instead\nGet stake back as free bet",
            'menu_order' => 17
        ),
        array(
            'title' => 'Price Boost - Daily Special',
            'content' => 'Every day we boost odds on selected markets! Check daily specials for enhanced prices up to 50%!',
            'badge_text' => 'Daily',
            'badge_color' => 'yellow',
            'icon_type' => 'zap',
            'icon_value' => '50',
            'subtitle' => 'Boosted Odds',
            'button_text' => 'View Boosts',
            'button_color' => 'yellow',
            'card_color' => 'navy',
            'terms' => "New boosts added daily\nMaximum stake varies per boost\nUsually ৳500-৳2,000\nOne boost per user per day",
            'claim' => "Check promotions page daily\nFind price boost markets\nPlace bet with boosted odds\nWinnings paid at enhanced rate",
            'menu_order' => 18
        ),
        array(
            'title' => 'E-Sports Welcome - ৳3,000 Bonus',
            'content' => 'New to E-Sports betting? Get a 100% welcome bonus up to ৳3,000 on your first E-Sports deposit!',
            'badge_text' => 'E-Sports',
            'badge_color' => 'green',
            'icon_type' => 'trophy',
            'icon_value' => '3,000',
            'subtitle' => '100% E-Sports',
            'button_text' => 'Start E-Sports',
            'button_color' => 'purple',
            'card_color' => 'purple',
            'terms' => "First E-Sports bet only\nMinimum deposit: ৳500\nWagering: 8x bonus\nValid on Dota 2, CS:GO, LOL",
            'claim' => "Make first E-Sports deposit\nUse code: ESPORTS100\nBonus credited for E-Sports\nBet on your favorite games",
            'menu_order' => 19
        ),
        array(
            'title' => 'Super Sunday - ৳15,000 Prize Pool',
            'content' => 'Every Sunday, bet on featured matches to climb the leaderboard. Top 50 players share ৳15,000!',
            'badge_text' => 'Sunday',
            'badge_color' => 'orange',
            'icon_type' => 'trophy',
            'icon_value' => '15,000',
            'subtitle' => 'Sunday Leaderboard',
            'button_text' => 'Join Competition',
            'button_color' => 'blue',
            'card_color' => 'blue',
            'terms' => "Every Sunday only\nBet on promoted markets\nTop 50 on leaderboard win\n1st place: ৳3,000",
            'claim' => "Opt-in on Sunday morning\nBet on featured Sunday matches\nEarn points for each bet\nPrizes paid Monday morning",
            'menu_order' => 20
        ),
    );

    foreach ( $promotions_data as $promo_data ) {
        $post_data = array(
            'post_title'   => $promo_data['title'],
            'post_content' => $promo_data['content'],
            'post_status'  => 'publish',
            'post_author'  => get_current_user_id(),
            'post_type'    => 'promotion',
        );

        $post_id = wp_insert_post( $post_data );

        if ( $post_id && ! is_wp_error( $post_id ) ) {
            // Save all meta fields
            update_post_meta( $post_id, '_promotion_badge_text', $promo_data['badge_text'] );
            update_post_meta( $post_id, '_promotion_badge_color', $promo_data['badge_color'] );
            update_post_meta( $post_id, '_promotion_icon_type', $promo_data['icon_type'] );
            update_post_meta( $post_id, '_promotion_icon_value', $promo_data['icon_value'] );
            update_post_meta( $post_id, '_promotion_subtitle', $promo_data['subtitle'] );
            update_post_meta( $post_id, '_promotion_button_text', $promo_data['button_text'] );
            update_post_meta( $post_id, '_promotion_button_url', '#' );
            update_post_meta( $post_id, '_promotion_button_color', $promo_data['button_color'] );
            update_post_meta( $post_id, '_promotion_card_color', $promo_data['card_color'] );
            update_post_meta( $post_id, '_promotion_menu_order', $promo_data['menu_order'] );
            update_post_meta( $post_id, '_promotion_terms_conditions', $promo_data['terms'] );
            update_post_meta( $post_id, '_promotion_how_to_claim', $promo_data['claim'] );

            $generated++;
        }
    }

    add_settings_error(
        'foursix_messages',
        'foursix_message',
        sprintf( __( 'Successfully generated %d promotions with complete meta data!', 'foursix' ), $generated ),
        'success'
    );
}
add_action( 'admin_init', 'foursix_handle_promotion_generation' );

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
 * Handle FAQ Generation
 */
function foursix_handle_faq_generation() {
    if ( ! isset( $_POST['foursix_generate_faqs_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( $_POST['foursix_generate_faqs_nonce'], 'foursix_generate_faqs' ) ) {
        wp_die( 'Security check failed' );
    }

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Unauthorized access' );
    }

    $generated = 0;

    // Create FAQ categories first
    $categories_data = array(
        array(
            'name' => 'Registration and Identity Verification',
            'slug' => 'registration-identity',
            'icon' => 'question'
        ),
        array(
            'name' => 'Account Security',
            'slug' => 'account-security',
            'icon' => 'lock'
        ),
        array(
            'name' => 'General FAQs',
            'slug' => 'general-faqs',
            'icon' => 'lightbulb'
        ),
        array(
            'name' => 'Technical Help',
            'slug' => 'technical-help',
            'icon' => 'tools'
        ),
        array(
            'name' => 'Funding',
            'slug' => 'funding',
            'icon' => 'money'
        ),
    );

    $category_ids = array();
    foreach ( $categories_data as $cat_data ) {
        $term = term_exists( $cat_data['slug'], 'faq_category' );
        if ( ! $term ) {
            $term = wp_insert_term( $cat_data['name'], 'faq_category', array( 'slug' => $cat_data['slug'] ) );
        }
        if ( ! is_wp_error( $term ) ) {
            $category_ids[ $cat_data['slug'] ] = array(
                'term_id' => is_array( $term ) ? $term['term_id'] : $term,
                'icon' => $cat_data['icon']
            );
        }
    }

    // Sample FAQ data
    $faqs_data = array(
        // Registration and Identity Verification (4 FAQs)
        array(
            'category' => 'registration-identity',
            'question' => 'How do I open an account with 4six?',
            'answer' => '<p>Opening an account with 4six is quick and easy. Click the "Sign Up" button on our homepage, fill in your personal details including name, email, phone number, and date of birth. Create a secure password and accept our terms and conditions. You will receive a verification email - click the link to activate your account.</p><p>Once verified, you can log in and start betting immediately. For full access to all features, complete your identity verification by submitting your ID documents.</p>'
        ),
        array(
            'category' => 'registration-identity',
            'question' => 'Can I open more than one 4six account?',
            'answer' => '<p>No, each person is allowed only one account with 4six. Multiple accounts (also called duplicate accounts) are strictly prohibited and violate our terms and conditions.</p><p>If we detect multiple accounts, all accounts will be closed and any winnings or bonuses forfeited. This policy helps us prevent fraud and ensure fair play for all users.</p>'
        ),
        array(
            'category' => 'registration-identity',
            'question' => 'Can you open an account from anywhere in the world?',
            'answer' => '<p>4six accepts customers from Bangladesh and selected international locations. However, we do not accept customers from restricted territories due to legal and regulatory requirements.</p><p>Before creating an account, please check our Terms & Conditions for the complete list of restricted countries. Using VPN or proxy services to circumvent these restrictions is prohibited and will result in account closure.</p>'
        ),
        array(
            'category' => 'registration-identity',
            'question' => 'Will I need to provide additional ID to have my account fully verified like other sportsbooks or betting exchanges?',
            'answer' => '<p>Yes, for your security and to comply with regulations, you will need to complete identity verification. This involves submitting a government-issued ID (National ID card, Passport, or Driving License) and proof of address (utility bill or bank statement within last 3 months).</p><p>Upload clear photos of these documents through your account dashboard. Verification usually takes 24-48 hours. Until verified, you may have limited withdrawal options and betting limits.</p>'
        ),

        // Account Security (5 FAQs)
        array(
            'category' => 'account-security',
            'question' => 'If I leave money in my 4six account, will my funds be secure?',
            'answer' => '<p>Yes, your funds are completely secure. 4six uses industry-leading encryption technology to protect your account and financial information. All deposits are held in segregated bank accounts separate from company operating funds.</p><p>We comply with international financial security standards and undergo regular security audits. Your money is safe and available for withdrawal at any time subject to our standard withdrawal procedures.</p>'
        ),
        array(
            'category' => 'account-security',
            'question' => 'What does SSL mean?',
            'answer' => '<p>SSL stands for Secure Sockets Layer, a security protocol that encrypts data transmitted between your browser and our servers. When you see the padlock icon in your browser address bar, it means SSL is active and your connection is secure.</p><p>SSL encryption prevents hackers from intercepting sensitive information like passwords, personal details, and payment information. All pages on 4six use SSL encryption for maximum security.</p>'
        ),
        array(
            'category' => 'account-security',
            'question' => 'Does 4six use encrypted connections?',
            'answer' => '<p>Yes, 4six uses 256-bit SSL encryption on all pages, ensuring that every interaction with our site is completely secure. This is the same level of encryption used by banks and financial institutions.</p><p>Your personal information, login credentials, and financial transactions are all protected by this advanced encryption. You can verify this by looking for "https://" and the padlock icon in your browser address bar.</p>'
        ),
        array(
            'category' => 'account-security',
            'question' => 'Why do I have to provide you copies of sensitive documents?',
            'answer' => '<p>Document verification is a legal requirement to prevent fraud, money laundering, and underage gambling. By verifying your identity, we protect both you and our platform from illegal activities.</p><p>Your documents are handled with strict confidentiality and stored securely using encryption. We only request necessary documents and never share your information with third parties without your consent or legal requirement. This verification also protects your account from unauthorized access.</p>'
        ),
        array(
            'category' => 'account-security',
            'question' => 'What happens if I don\'t send you the required documentation?',
            'answer' => '<p>If you don\'t complete identity verification, your account will have restricted functionality. You may face limitations such as lower deposit limits, restricted withdrawal options, or inability to claim certain promotions.</p><p>In some cases, if verification is not completed within a specified timeframe, we may temporarily suspend your account until documents are provided. This is a standard industry practice to ensure security and regulatory compliance.</p>'
        ),

        // General FAQs (4 FAQs)
        array(
            'category' => 'general-faqs',
            'question' => 'What is a \'back\' bet?',
            'answer' => '<p>A back bet is a traditional bet where you are betting FOR something to happen. For example, if you back Manchester United to win, you win if Manchester United wins the match.</p><p>This is the most common type of bet and the one you\'re probably most familiar with. The odds tell you how much you will win relative to your stake. Higher odds mean bigger potential winnings but lower probability.</p>'
        ),
        array(
            'category' => 'general-faqs',
            'question' => 'What is a \'lay\' bet?',
            'answer' => '<p>A lay bet is the opposite of a back bet - you are betting AGAINST something happening. For example, if you lay Manchester United to win, you win if they lose or draw.</p><p>Lay betting is popular on betting exchanges. When you lay a bet, you are essentially acting as the bookmaker, offering odds to other bettors. Your potential loss is higher than your stake because you must pay out if the outcome occurs.</p>'
        ),
        array(
            'category' => 'general-faqs',
            'question' => 'Why is there a delay when I place bets on a live betting market?',
            'answer' => '<p>The delay (usually 2-5 seconds) during live betting exists to prevent unfair advantages from real-time information. This buffer time ensures all bets are accepted under fair conditions and prevents exploitation of live feed delays.</p><p>During significant events in the match (like a goal about to be scored), the market may be temporarily suspended for longer to adjust odds. This is normal and protects both you and us from incorrect odds.</p>'
        ),
        array(
            'category' => 'general-faqs',
            'question' => 'What does \'Market Exposure\' mean?',
            'answer' => '<p>Market Exposure refers to the maximum amount you could lose on a particular market based on all your active bets. It represents your total risk exposure before the market is settled.</p><p>For example, if you have multiple bets on the same cricket match, your exposure is calculated as the worst-case scenario across all possible outcomes. Understanding your exposure helps you manage risk and avoid over-betting.</p>'
        ),

        // Technical Help (4 FAQs)
        array(
            'category' => 'technical-help',
            'question' => 'What are the recommended technical requirements for using 4six?',
            'answer' => '<p>For the best experience, we recommend using the latest version of Chrome, Firefox, Safari, or Edge browsers. Your device should have a stable internet connection with minimum 2 Mbps speed.</p><p>Mobile users should use Android 6.0 or iOS 11.0 or higher. Enable JavaScript and cookies in your browser settings. Clear your browser cache regularly if you experience any loading issues. A screen resolution of at least 1024x768 is recommended for desktop use.</p>'
        ),
        array(
            'category' => 'technical-help',
            'question' => 'The 4six website won\'t load correctly for me, what should I do?',
            'answer' => '<p>First, try clearing your browser cache and cookies, then refresh the page. Make sure you\'re using an updated browser version. If the problem persists, try a different browser or device to isolate the issue.</p><p>Check your internet connection and firewall settings. Sometimes antivirus software can block certain features. If you\'re using a VPN, try disabling it. Contact our support team if the issue continues - provide details about your browser, device, and the specific problem you\'re experiencing.</p>'
        ),
        array(
            'category' => 'technical-help',
            'question' => 'What happens if the 4six site goes down?',
            'answer' => '<p>In the rare event of technical difficulties, all active bets remain valid and are settled normally once the service is restored. Any in-play bets are handled according to our betting rules.</p><p>We have backup systems and work quickly to restore service. You can check our social media channels for updates during any downtime. If a match finishes while the site is down, bets are settled based on official results.</p>'
        ),
        array(
            'category' => 'technical-help',
            'question' => 'How do I cancel a bet?',
            'answer' => '<p>Once a bet is placed and confirmed, it cannot be cancelled. This is standard across all betting platforms because odds and markets are continuously changing.</p><p>Always review your bet slip carefully before confirming. You have a few seconds after clicking "Place Bet" to review, but once confirmed, the bet is final. Some markets may offer Cash Out options which allow you to close your bet early for a settlement value.</p>'
        ),

        // Funding (3 FAQs)
        array(
            'category' => 'funding',
            'question' => 'How do I fund my account?',
            'answer' => '<p>You can fund your 4six account using multiple payment methods: bKash, Nagad, Rocket (mobile banking), bank transfer, or international cards (Visa/Mastercard).</p><p>Log into your account, go to "Deposit", select your preferred payment method, enter the amount, and follow the instructions. Most deposits are instant. Minimum deposit is ৳500 for mobile banking and ৳1,000 for bank transfers. We don\'t charge any deposit fees.</p>'
        ),
        array(
            'category' => 'funding',
            'question' => 'Can someone else make a deposit on my behalf to 4six?',
            'answer' => '<p>No, all deposits must come from a payment method in your own name. Deposits from third parties (including family members) are not allowed and will be rejected.</p><p>This policy prevents money laundering and ensures account security. If we detect third-party deposits, we may freeze your account pending investigation. Only deposit using payment methods registered in the same name as your 4six account.</p>'
        ),
        array(
            'category' => 'funding',
            'question' => 'I have deposited from someone else\'s payment account in error, what are my next steps to rectify this?',
            'answer' => '<p>Contact our support team immediately with full details: the deposit amount, time, payment method, and whose account was used. We will investigate and may need to return the funds to the original payment source.</p><p>Your account may be temporarily restricted until this is resolved. To avoid delays, ensure all future deposits come from payment methods in your own name. In some cases, you may need to provide additional verification documents.</p>'
        ),
    );

    foreach ( $faqs_data as $faq_data ) {
        $post_data = array(
            'post_title'   => $faq_data['question'],
            'post_content' => $faq_data['answer'],
            'post_status'  => 'publish',
            'post_author'  => get_current_user_id(),
            'post_type'    => 'faq',
        );

        $post_id = wp_insert_post( $post_data );

        if ( $post_id && ! is_wp_error( $post_id ) ) {
            // Assign category
            if ( isset( $category_ids[ $faq_data['category'] ] ) ) {
                wp_set_post_terms( $post_id, array( $category_ids[ $faq_data['category'] ]['term_id'] ), 'faq_category' );

                // Save icon meta
                update_post_meta( $post_id, '_faq_icon_type', $category_ids[ $faq_data['category'] ]['icon'] );
            }

            $generated++;
        }
    }

    add_settings_error(
        'foursix_messages',
        'foursix_message',
        sprintf( __( 'Successfully generated %d FAQs across 5 categories!', 'foursix' ), $generated ),
        'success'
    );
}
add_action( 'admin_init', 'foursix_handle_faq_generation' );

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

                <!-- Promotions Shortcode -->
                <div class="shortcode-card">
                    <div class="shortcode-header">
                        <h3>Promotions Display</h3>
                        <span class="shortcode-tag">[promotions]</span>
                    </div>

                    <div class="shortcode-description">
                        <p>Display betting promotions and bonuses in a beautiful card layout with customizable options.</p>
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
                                    <td><code>count</code></td>
                                    <td>number</td>
                                    <td>3</td>
                                    <td>Number of promotions to display</td>
                                </tr>
                                <tr>
                                    <td><code>show_all</code></td>
                                    <td>boolean</td>
                                    <td>true</td>
                                    <td>Show "View All Promotions" button</td>
                                </tr>
                                <tr>
                                    <td><code>orderby</code></td>
                                    <td>string</td>
                                    <td>menu_order</td>
                                    <td>Sort by (menu_order, date, title, rand)</td>
                                </tr>
                                <tr>
                                    <td><code>order</code></td>
                                    <td>string</td>
                                    <td>ASC</td>
                                    <td>Sort order (ASC or DESC)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="shortcode-examples">
                        <h4>Usage Examples:</h4>
                        <div class="example-item">
                            <strong>Basic usage:</strong>
                            <code class="code-block">[promotions]</code>
                            <p class="example-desc">Display 3 promotions in default order</p>
                        </div>
                        <div class="example-item">
                            <strong>Show more promotions:</strong>
                            <code class="code-block">[promotions count="6"]</code>
                            <p class="example-desc">Display 6 promotions</p>
                        </div>
                        <div class="example-item">
                            <strong>Without "View All" button:</strong>
                            <code class="code-block">[promotions show_all="false"]</code>
                            <p class="example-desc">Hide the view all promotions button</p>
                        </div>
                        <div class="example-item">
                            <strong>Custom sorting:</strong>
                            <code class="code-block">[promotions orderby="date" order="DESC"]</code>
                            <p class="example-desc">Show newest promotions first</p>
                        </div>
                    </div>

                    <div class="shortcode-features">
                        <h4>✨ Features:</h4>
                        <ul>
                            <li>✅ Responsive 3-column grid layout</li>
                            <li>✅ Customizable badge colors (Green, Yellow, Orange)</li>
                            <li>✅ Multiple icon types (Gift, Trophy, Zap)</li>
                            <li>✅ Animated card hover effects</li>
                            <li>✅ Gradient button styles</li>
                            <li>✅ Custom promotion ordering</li>
                            <li>✅ Dark theme design matching Figma</li>
                            <li>✅ Mobile-optimized layout</li>
                        </ul>
                    </div>

                    <div class="shortcode-features">
                        <h4>📝 Custom Fields (in Promotions post editor):</h4>
                        <ul>
                            <li>🏷️ Badge Text & Color (NEW USER, WEEKLY, FRIDAY)</li>
                            <li>🎨 Icon Type & Value (৳10,000, 10%, 50%)</li>
                            <li>📄 Subtitle (promotional tagline)</li>
                            <li>🔗 Button Text & URL</li>
                            <li>🎯 Button Color (Green or Yellow)</li>
                            <li>📊 Display Order (for custom sorting)</li>
                        </ul>
                    </div>
                </div>

                <!-- Promotion Detail Shortcode -->
                <div class="shortcode-card">
                    <div class="shortcode-header">
                        <h3>Promotion Detail View</h3>
                        <span class="shortcode-tag">[promotion_detail]</span>
                    </div>

                    <div class="shortcode-description">
                        <p>Display a detailed view of a single promotion with Terms & Conditions and How to Claim sections.</p>
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
                                    <td><code>id</code></td>
                                    <td>number</td>
                                    <td>required</td>
                                    <td>The promotion post ID to display</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="shortcode-examples">
                        <h4>Usage Examples:</h4>
                        <div class="example-item">
                            <strong>Basic usage:</strong>
                            <code class="code-block">[promotion_detail id="123"]</code>
                            <p class="example-desc">Display promotion with ID 123</p>
                        </div>
                        <div class="example-item">
                            <strong>How to find promotion ID:</strong>
                            <p class="example-desc">Go to <strong>Promotions → All Promotions</strong>, hover over a promotion title, and look at the URL in your browser's status bar. The number after "post=" is the ID.</p>
                        </div>
                    </div>

                    <div class="shortcode-features">
                        <h4>✨ Features:</h4>
                        <ul>
                            <li>✅ Full-width detail layout with gradient header</li>
                            <li>✅ Two-column grid (Terms & How to Claim)</li>
                            <li>✅ Bullet points for Terms & Conditions</li>
                            <li>✅ Numbered steps for How to Claim</li>
                            <li>✅ Prominent "Claim This Offer" button</li>
                            <li>✅ Responsive single-column on mobile</li>
                            <li>✅ Dark theme matching Figma design</li>
                            <li>✅ Icon indicators for sections</li>
                        </ul>
                    </div>

                    <div class="shortcode-features">
                        <h4>📝 Required Meta Fields:</h4>
                        <ul>
                            <li>📋 Terms & Conditions (one item per line)</li>
                            <li>📝 How to Claim (step-by-step, one per line)</li>
                            <li>🎫 Badge text (e.g., "New Players")</li>
                            <li>📄 Subtitle (displays in title)</li>
                            <li>🔗 Button text & URL</li>
                        </ul>
                    </div>
                </div>

                <!-- Promotions List Shortcode -->
                <div class="shortcode-card">
                    <div class="shortcode-header">
                        <h3>Promotions List (Compact Cards)</h3>
                        <span class="shortcode-tag">[promotions_list]</span>
                    </div>

                    <div class="shortcode-description">
                        <p>Display all promotions in a vertical list with compact detail cards. Each promotion shows full details including Terms & Conditions and How to Claim in a single card layout.</p>
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
                                    <td><code>count</code></td>
                                    <td>number</td>
                                    <td>-1 (all)</td>
                                    <td>Number of promotions to display</td>
                                </tr>
                                <tr>
                                    <td><code>orderby</code></td>
                                    <td>string</td>
                                    <td>menu_order</td>
                                    <td>Sort by (menu_order, date, title, rand)</td>
                                </tr>
                                <tr>
                                    <td><code>order</code></td>
                                    <td>string</td>
                                    <td>ASC</td>
                                    <td>Sort order (ASC or DESC)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="shortcode-examples">
                        <h4>Usage Examples:</h4>
                        <div class="example-item">
                            <strong>Basic usage (all promotions):</strong>
                            <code class="code-block">[promotions_list]</code>
                            <p class="example-desc">Display all promotions in list order</p>
                        </div>
                        <div class="example-item">
                            <strong>Show specific count:</strong>
                            <code class="code-block">[promotions_list count="5"]</code>
                            <p class="example-desc">Display only first 5 promotions</p>
                        </div>
                        <div class="example-item">
                            <strong>Custom sorting:</strong>
                            <code class="code-block">[promotions_list orderby="date" order="DESC"]</code>
                            <p class="example-desc">Show newest promotions first</p>
                        </div>
                    </div>

                    <div class="shortcode-features">
                        <h4>✨ Features:</h4>
                        <ul>
                            <li>✅ Vertical list layout with stacked cards</li>
                            <li>✅ 8 color scheme options per card</li>
                            <li>✅ Icon + badge in header</li>
                            <li>✅ Two-column Terms & Claim sections</li>
                            <li>✅ 6 button color variations</li>
                            <li>✅ Responsive single-column on mobile</li>
                            <li>✅ Compact design perfect for listing pages</li>
                            <li>✅ Smooth hover animations</li>
                        </ul>
                    </div>

                    <div class="shortcode-features">
                        <h4>🎨 Color Schemes Available:</h4>
                        <ul>
                            <li>🟢 Teal (New Players)</li>
                            <li>🔵 Navy (Weekly Offer)</li>
                            <li>🟣 Purple (Referral Bonus)</li>
                            <li>🔴 Burgundy (Daily Offer)</li>
                            <li>🔷 Blue (Weekly Cashback)</li>
                            <li>🟫 Brown (Weekend Offer)</li>
                            <li>🟨 Yellow-Brown (VIP Program)</li>
                            <li>🟩 Dark Teal (IPL Special)</li>
                        </ul>
                    </div>

                    <div class="shortcode-features">
                        <h4>🔘 Button Colors:</h4>
                        <ul>
                            <li>Green • Yellow/Orange • Purple • Pink • Blue • Orange</li>
                        </ul>
                    </div>
                </div>

                <!-- FAQ List Shortcode -->
                <div class="shortcode-card">
                    <div class="shortcode-header">
                        <h3>FAQ Accordion List</h3>
                        <span class="shortcode-tag">[faq_list]</span>
                    </div>

                    <div class="shortcode-description">
                        <p>Display FAQs grouped by category with accordion expand/collapse functionality. Perfect for help pages and support sections.</p>
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
                                    <td><code>category</code></td>
                                    <td>string</td>
                                    <td>all</td>
                                    <td>FAQ category slug to filter (empty shows all)</td>
                                </tr>
                                <tr>
                                    <td><code>orderby</code></td>
                                    <td>string</td>
                                    <td>menu_order</td>
                                    <td>Sort by (menu_order, date, title)</td>
                                </tr>
                                <tr>
                                    <td><code>order</code></td>
                                    <td>string</td>
                                    <td>ASC</td>
                                    <td>Sort order (ASC or DESC)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="shortcode-examples">
                        <h4>Usage Examples:</h4>
                        <div class="example-item">
                            <strong>All FAQs grouped by category:</strong>
                            <code class="code-block">[faq_list]</code>
                            <p class="example-desc">Display all FAQs organized by their categories with accordion</p>
                        </div>
                        <div class="example-item">
                            <strong>Specific category only:</strong>
                            <code class="code-block">[faq_list category="account-security"]</code>
                            <p class="example-desc">Show only Account Security FAQs</p>
                        </div>
                        <div class="example-item">
                            <strong>Custom sorting:</strong>
                            <code class="code-block">[faq_list orderby="title" order="ASC"]</code>
                            <p class="example-desc">Sort FAQs alphabetically by question</p>
                        </div>
                    </div>

                    <div class="shortcode-features">
                        <h4>✨ Features:</h4>
                        <ul>
                            <li>✅ Category grouping with colored headers</li>
                            <li>✅ Accordion expand/collapse animation</li>
                            <li>✅ FAQ count badge per category</li>
                            <li>✅ Custom icons per category (5 types)</li>
                            <li>✅ Rich text support in answers</li>
                            <li>✅ Accessibility (ARIA attributes)</li>
                            <li>✅ Green gradient design theme</li>
                            <li>✅ Fully responsive mobile layout</li>
                        </ul>
                    </div>

                    <div class="shortcode-features">
                        <h4>🎨 Category Icons:</h4>
                        <ul>
                            <li>❓ Question Mark (General FAQs)</li>
                            <li>🔒 Lock (Security/Account)</li>
                            <li>💡 Lightbulb (General Info)</li>
                            <li>🔧 Tools (Technical Help)</li>
                            <li>💰 Money (Funding/Payments)</li>
                        </ul>
                    </div>

                    <div class="shortcode-features">
                        <h4>📝 Setup Instructions:</h4>
                        <ul>
                            <li>1️⃣ Go to <strong>FAQs → Categories</strong> and create categories</li>
                            <li>2️⃣ Go to <strong>FAQs → Add New</strong> to create FAQ items</li>
                            <li>3️⃣ Enter question as <strong>Title</strong></li>
                            <li>4️⃣ Enter answer as <strong>Content</strong> (supports formatting, lists, links)</li>
                            <li>5️⃣ Select <strong>Category</strong> and <strong>Icon</strong></li>
                            <li>6️⃣ Use <code>[faq_list]</code> shortcode on any page</li>
                        </ul>
                    </div>
                </div>

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

                <!-- Blog Content Boxes -->
                <div class="shortcode-card">
                    <div class="shortcode-header">
                        <h3>Blog Content Boxes</h3>
                        <span class="shortcode-tag">[markets_box] [cta_box]</span>
                    </div>

                    <div class="shortcode-description">
                        <p>Special styled content boxes for blog posts. Add emphasis to key information, markets, or calls-to-action within your blog content.</p>
                    </div>

                    <div class="shortcode-parameters">
                        <h4>Markets Box Parameters:</h4>
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
                                    <td><code>title</code></td>
                                    <td>string</td>
                                    <td>Key Markets</td>
                                    <td>Box title/heading</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="shortcode-examples">
                        <h4>Markets Box Usage:</h4>
                        <div class="example-item">
                            <strong>Betting markets list:</strong>
                            <code class="code-block">[markets_box title="Top IPL Betting Markets"]
Match Winner - Predict which team will win the match
Top Batsman - Bet on the highest run-scorer in the match
Total Runs - Over/under on total runs scored
Tournament Winner - Long-term bet on the IPL champion
[/markets_box]</code>
                            <p class="example-desc">Creates a teal-bordered box with market options list</p>
                        </div>
                    </div>

                    <div class="shortcode-parameters">
                        <h4>CTA Box Parameters:</h4>
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
                                    <td><code>title</code></td>
                                    <td>string</td>
                                    <td>Ready to Get Started?</td>
                                    <td>CTA box heading</td>
                                </tr>
                                <tr>
                                    <td><code>button_text</code></td>
                                    <td>string</td>
                                    <td>Sign Up Now</td>
                                    <td>Button label text</td>
                                </tr>
                                <tr>
                                    <td><code>button_url</code></td>
                                    <td>URL</td>
                                    <td>#</td>
                                    <td>Button destination link</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="shortcode-examples">
                        <h4>CTA Box Usage:</h4>
                        <div class="example-item">
                            <strong>Call-to-action box:</strong>
                            <code class="code-block">[cta_box title="Ready to Place Your Bets?" button_text="Sign Up Now" button_url="/register"]
Join 4six today and start betting on your favorite sports and casino games with the best odds in Bangladesh!
[/cta_box]</code>
                            <p class="example-desc">Creates an orange/yellow bordered CTA box with signup button</p>
                        </div>
                    </div>

                    <div class="shortcode-features">
                        <h4>✨ Features:</h4>
                        <ul>
                            <li>✅ Teal gradient box for markets/key info</li>
                            <li>✅ Orange/yellow gradient box for CTAs</li>
                            <li>✅ Custom bullet points and formatting</li>
                            <li>✅ Responsive design matching blog theme</li>
                            <li>✅ Easy to use within blog post content</li>
                            <li>✅ Support for label - description format</li>
                        </ul>
                    </div>
                </div>

            </div>

            <!-- Promotion Generator Section -->
            <div class="foursix-admin-section">
                <h2>🎁 Promotion Generator</h2>

                <div class="generator-card">
                    <div class="generator-description">
                        <p>Generate 20 sample promotions with complete meta data including Terms & Conditions and How to Claim. Perfect for testing and demonstration purposes.</p>
                    </div>

                    <form method="post" action="">
                        <?php wp_nonce_field( 'foursix_generate_promotions', 'foursix_generate_promotions_nonce' ); ?>

                        <div class="generator-controls">
                            <div class="control-group">
                                <button type="submit" class="button button-primary button-hero">
                                    <span class="dashicons dashicons-megaphone"></span>
                                    Generate 20 Promotions
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="generator-info">
                        <h4>🎯 What will be generated:</h4>
                        <ul>
                            <li><strong>20 unique promotions</strong> with realistic betting offers</li>
                            <li><strong>All meta fields:</strong> Badge text, icon type, subtitle, button colors</li>
                            <li><strong>8 color schemes:</strong> Teal, Navy, Purple, Burgundy, Blue, Brown, Yellow-Brown, Dark Teal</li>
                            <li><strong>Terms & Conditions:</strong> 4 bullet points per promotion</li>
                            <li><strong>How to Claim:</strong> 4 step-by-step instructions per promotion</li>
                            <li><strong>Categories:</strong> Welcome, Weekly, Referral, Daily, VIP, Special offers</li>
                        </ul>
                        <p class="description" style="margin-top: 15px;"><strong>Note:</strong> This will create 20 new promotions immediately. They will be published and visible on your site.</p>
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

            <!-- FAQ Generator Section -->
            <div class="foursix-admin-section">
                <h2>❓ FAQ Generator</h2>

                <div class="generator-card">
                    <div class="generator-description">
                        <p>Generate 20 sample FAQs across 5 categories with complete answers. Perfect for testing the FAQ accordion and populating your help section.</p>
                    </div>

                    <form method="post" action="">
                        <?php wp_nonce_field( 'foursix_generate_faqs', 'foursix_generate_faqs_nonce' ); ?>

                        <div class="generator-controls">
                            <div class="control-group">
                                <button type="submit" class="button button-primary button-hero">
                                    <span class="dashicons dashicons-editor-help"></span>
                                    Generate 20 FAQs
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="generator-info">
                        <h4>🎯 What will be generated:</h4>
                        <ul>
                            <li><strong>5 FAQ Categories:</strong> Registration & Identity, Account Security, General FAQs, Technical Help, Funding</li>
                            <li><strong>20 FAQs total:</strong> 4-5 questions per category</li>
                            <li><strong>Category Icons:</strong> Question mark, Lock, Lightbulb, Tools, Money icons</li>
                            <li><strong>Rich Answers:</strong> Detailed multi-paragraph answers with helpful information</li>
                            <li><strong>Organized Structure:</strong> Questions grouped by category for easy navigation</li>
                            <li><strong>Accordion Display:</strong> Automatic expand/collapse functionality</li>
                        </ul>
                        <p class="description" style="margin-top: 15px;"><strong>Topics Include:</strong> Account creation, security verification, betting terminology, technical troubleshooting, deposit methods, and more.</p>
                        <p class="description"><strong>Note:</strong> This will create 20 new FAQ posts and 5 categories immediately. They will be published and visible on your site.</p>
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
