<?php

add_action('init', 'register_services', 0);
function register_services () {
    $labels = array(
      'name'               => 'Services',
      'parent_item_colon'  => '',
      'singular_name'			 => 'Service',
      'menu_name'          => 'Services',
      'add_new'					=> 'Add Service',
      'add_new_item'		=> 'Add Service',
      'edit_item'				=> 'Edit Service'
    );
    $args = array(
      'labels'        	=> $labels,
      'description'   	=> '',
      'public'        	=> true,
      'menu_position' 	=> 8,
      'hierarchical'    => true,
      'supports'      	=> array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ),
      'has_archive'   	=> 'nos-services',
      'rewrite' => array('slug' => 'nos-services'),
    );
    register_post_type( 'service', $args );
}