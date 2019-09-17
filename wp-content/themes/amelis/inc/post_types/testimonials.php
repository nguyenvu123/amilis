<?php

add_action('init', 'register_temoignages', 0);
function register_temoignages () {
    $labels = array(
      'name'               => 'Témoignages',
      'parent_item_colon'  => '',
      'singular_name'			 => 'Témoignage',
      'menu_name'          => 'Témoignages',
      'add_new'					=> 'Add Témoignage',
      'add_new_item'		=> 'Add Témoignage',
      'edit_item'				=> 'Edit Témoignage'
    );
    $args = array(
      'labels'        	=> $labels,
      'description'   	=> '',
      'public'        	=> true,
      'menu_position' 	=> 9,
      'supports'      	=> array( 'title', 'editor', 'thumbnail', 'revisions' ),
      'has_archive'   	=> 'temoignage'
    );
    register_post_type( 'temoignage', $args );
}