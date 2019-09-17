<?php

  add_action('save_post', 'save_post_meta', 1, 2);
	function save_post_meta($post_id, $post) {
		$post_meta 	= array();

		// if(isset($_POST['rating']))
		// 		$post_meta['rating'] = $_POST['rating'];


		foreach ($post_meta as $key => $value) { // Cycle through the $events_meta array!
				if( $post->post_type == 'revision' ) return; // Don't store custom data twice

				$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
				if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
						update_post_meta($post->ID, $key, $value);
				} else { // If the custom field doesn't have a value
						add_post_meta($post->ID, $key, $value);
				}
				if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
		}

	}
