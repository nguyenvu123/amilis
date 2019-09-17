<?php

add_action('init', 'register_faq', 0);
function register_faq () {
    $faq_labels = array(
        'name'               => 'FAQ',
        'singular_name'      => 'FAQ Item',
        'menu_name'          => 'FAQ Items',
        'name_admin_bar'     => 'FAQ Item',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New FAQ Item',
        'new_item'           => 'New FAQ Item',
        'edit_item'          => 'Edit FAQ Item',
        'view_item'          => 'View FAQ Item',
        'all_items'          => 'All FAQ Items',
        'search_items'       => 'Search FAQ',
        'parent_item_colon'  => 'Parent FAQ Item:',
        'not_found'          => 'No FAQ items found.',
        'not_found_in_trash' => 'No FAQ items found in Trash.',
    );

    $faq_args = array(
        'labels'             => $faq_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'menu_icon'          => 'dashicons-media-document',
        'rewrite'            => array( 'slug' => 'faq' ),
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'has_archive'        => true,
        'supports'           => array( 'title', 'editor')
    );
    register_post_type( 'faq', $faq_args );
}

function my_custom_taxonomy() {
    $labels = array(
        'name'              => _x( 'FAQ category', 'taxonomy general name', 'amelis' ),
        'singular_name'     => _x( 'FAQ category', 'taxonomy singular name', 'amelis' ),
        'search_items'      => __( 'Search FAQ categories', 'amelis' ),
        'all_items'         => __( 'All FAQ categories', 'amelis' ),
        'parent_item'       => __( 'Parent FAQ category', 'amelis' ),
        'parent_item_colon' => __( 'Parent FAQ category:', 'amelis' ),
        'edit_item'         => __( 'Edit FAQ category', 'amelis' ),
        'view_item'         => __( 'View FAQ category', 'amelis'),
        'update_item'       => __( 'Update FAQ category', 'amelis' ),
        'add_new_item'      => __( 'Add New FAQ category', 'amelis' ),
        'new_item_name'     => __( 'New FAQ category Name', 'amelis' ),
        'menu_name'         => __( 'FAQ category', 'amelis' ),
    );

    $args = array(
        'has_archive'       => true,
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
    );
    register_taxonomy( 'faq-category', array( 'faq' ), $args );
  }
add_action( 'init', 'my_custom_taxonomy' );