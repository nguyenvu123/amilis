<?php

add_action('init', 'register_agence_member', 0);
function register_agence_member () {
    $labels = array(
      'name'               => 'Agence Member',
      'parent_item_colon'  => '',
      'singular_name'			 => 'Agence Member',
      'menu_name'          => 'Agence Member',
      'add_new'					=> 'Add Agence Member',
      'add_new_item'		=> 'Add Agence Member',
      'edit_item'				=> 'Edit Agence Member'
    );
    $args = array(
      'labels'        	=> $labels,
      'description'   	=> '',
      'public'        	=> true,
      'menu_position' 	=> 7,
      'supports'      	=> array( 'title' ),
      'has_archive'   	=> 'agence-member'
    );
    register_post_type( 'agence-member', $args );
}