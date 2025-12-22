<?php
/**
 * FAQ Custom Post Type
 */

// Register FAQ Post Type
function foursix_register_faq_post_type() {
    $labels = array(
        'name'                  => 'FAQs',
        'singular_name'         => 'FAQ',
        'menu_name'             => 'FAQs',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New FAQ',
        'edit_item'             => 'Edit FAQ',
        'new_item'              => 'New FAQ',
        'view_item'             => 'View FAQ',
        'search_items'          => 'Search FAQs',
        'not_found'             => 'No FAQs found',
        'not_found_in_trash'    => 'No FAQs found in Trash',
        'all_items'             => 'All FAQs',
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'faq' ),
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => 20,
        'menu_icon'             => 'dashicons-editor-help',
        'supports'              => array( 'title', 'editor', 'thumbnail' ),
        'show_in_rest'          => true,
    );

    register_post_type( 'faq', $args );
}
add_action( 'init', 'foursix_register_faq_post_type' );

// Register FAQ Category Taxonomy
function foursix_register_faq_category_taxonomy() {
    $labels = array(
        'name'              => 'FAQ Categories',
        'singular_name'     => 'FAQ Category',
        'search_items'      => 'Search FAQ Categories',
        'all_items'         => 'All FAQ Categories',
        'parent_item'       => 'Parent FAQ Category',
        'parent_item_colon' => 'Parent FAQ Category:',
        'edit_item'         => 'Edit FAQ Category',
        'update_item'       => 'Update FAQ Category',
        'add_new_item'      => 'Add New FAQ Category',
        'new_item_name'     => 'New FAQ Category Name',
        'menu_name'         => 'Categories',
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'faq-category' ),
        'show_in_rest'      => true,
    );

    register_taxonomy( 'faq_category', array( 'faq' ), $args );
}
add_action( 'init', 'foursix_register_faq_category_taxonomy' );

// Add custom meta box for FAQ icon selection
function foursix_add_faq_icon_meta_box() {
    add_meta_box(
        'faq_icon_meta_box',
        'FAQ Icon',
        'foursix_faq_icon_meta_box_callback',
        'faq',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'foursix_add_faq_icon_meta_box' );

function foursix_faq_icon_meta_box_callback( $post ) {
    wp_nonce_field( 'foursix_save_faq_icon', 'foursix_faq_icon_nonce' );
    $icon_type = get_post_meta( $post->ID, '_faq_icon_type', true );
    ?>
    <p>
        <label for="faq_icon_type">Select Icon:</label><br>
        <select name="faq_icon_type" id="faq_icon_type" style="width: 100%;">
            <option value="question" <?php selected( $icon_type, 'question' ); ?>>Question Mark</option>
            <option value="lock" <?php selected( $icon_type, 'lock' ); ?>>Lock (Security)</option>
            <option value="lightbulb" <?php selected( $icon_type, 'lightbulb' ); ?>>Lightbulb (General)</option>
            <option value="tools" <?php selected( $icon_type, 'tools' ); ?>>Tools (Technical)</option>
            <option value="money" <?php selected( $icon_type, 'money' ); ?>>Money (Funding)</option>
        </select>
    </p>
    <?php
}

function foursix_save_faq_icon_meta( $post_id ) {
    if ( ! isset( $_POST['foursix_faq_icon_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['foursix_faq_icon_nonce'], 'foursix_save_faq_icon' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['faq_icon_type'] ) ) {
        update_post_meta( $post_id, '_faq_icon_type', sanitize_text_field( $_POST['faq_icon_type'] ) );
    }
}
add_action( 'save_post', 'foursix_save_faq_icon_meta' );
