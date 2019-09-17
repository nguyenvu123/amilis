<?php

add_action('init', 'register_agence', 0);
function register_agence () {
    $labels = array(
      'name'               => 'Agence',
      'parent_item_colon'  => '',
      'singular_name'			 => 'Agence',
      'menu_name'          => 'Agence',
      'add_new'					=> 'Add Agence',
      'add_new_item'		=> 'Add Agence',
      'edit_item'				=> 'Edit Agence'
    );
    $args = array(
      'labels'        	=> $labels,
      'description'   	=> '',
      'public'        	=> true,
      'menu_position' 	=> 6,
      'hierarchical'    => true,
      'supports'      	=> array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ),
      'has_archive'   	=> 'nos-agences',
      'rewrite' => array('slug' => 'nos-agences'),
    );
    register_post_type( 'agence', $args );
}

/*
 * Add columns to agences post list
 */
function add_acf_columns( $columns ) {
  return array_merge ( $columns, array (
    'zipcode' => __ ( 'Postal Code' ),
    'email'   => __ ( 'Email' ) ,
    'phone'   => __ ( 'Phone' )
  ) );
}
add_filter ( 'manage_agence_posts_columns', 'add_acf_columns' );


 /*
 * Add columns to agences post list
 */
function agence_custom_column ( $column, $post_id ) {
  switch ( $column ) {
    case 'zipcode':
      echo get_post_meta ( $post_id, 'zipcode', true );
      break;
    case 'email':
      echo get_post_meta ( $post_id, 'email', true );
      break;
    case 'phone':
      echo get_post_meta ( $post_id, 'phone', true );
      break;
  }
}
add_action ( 'manage_agence_posts_custom_column', 'agence_custom_column', 10, 2 );