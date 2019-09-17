<?php

function disable_yoast_schema_data($data){
	$data = array();
	return $data;
}
add_filter('wpseo_json_ld_output', 'disable_yoast_schema_data', 10, 1);



	// add post id column in admin
	add_filter( 'manage_agence_posts_columns', 'revealid_add_id_column', 5 );
	add_action( 'manage_agence_posts_custom_column', 'revealid_id_column_content', 5, 2 );


	function revealid_add_id_column( $columns ) {
	$columns['revealid_id'] = 'ID';
		return $columns;
	}

	function revealid_id_column_content( $column, $id ) {
		if( 'revealid_id' == $column ) {
			echo $id;
		}
	}



	add_filter('locale', 'wpse27056_setLocale');
	function wpse27056_setLocale($locale) {
		if ( !is_admin() ) {
			return 'fr_FR';
		}

		return $locale;
	}



	add_filter('next_post_link', 'post_link_attributes');
	add_filter('previous_post_link', 'post_link_attributes');

	function post_link_attributes($output) {
	    $code = 'class="btn btn-border btn-dark"';
	    return str_replace('<a href=', '<a '.$code.' href=', $output);
	}


			// Social Media

		function my_new_contactmethods( $contactmethods ) {
			// Add Twitter
			$contactmethods['twitter'] = 'Twitter';
			//add Linkedin
			$contactmethods['linkedin'] = 'LinkedIn';
			//add Google
			$contactmethods['google'] = 'Google Plus';
			//add Facebook
			$contactmethods['facebook'] = 'Facebook';
			return $contactmethods;
		}
		add_filter('user_contactmethods','my_new_contactmethods',10,1);

		add_filter( 'pre_option_link_manager_enabled', '__return_true' );

		add_filter( 'wp_mail_content_type', 'set_html_content_type' );
		function set_html_content_type() {
			return 'text/html';
		}




	function custom_excerpt_length( $length ) {
		return 13;
	}
	add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

	function get_the_frontpage_excerpt($length){
		$excerpt = get_the_content();
		$excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
		$excerpt = strip_shortcodes($excerpt);
		$excerpt = strip_tags($excerpt);
		$excerpt = substr($excerpt, 0, $length);
		$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
		$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
		return $excerpt;
	}



	function short_title($after = '', $length) {
		$mytitle = explode(' ', get_the_title(), $length);
		if (count($mytitle)>=$length) {
			array_pop($mytitle);
			$mytitle = implode(" ",$mytitle). $after;
		} else {
			$mytitle = implode(" ",$mytitle);
		}
		return $mytitle;
	}


	// add_filter( 'wp_default_scripts', 'dequeue_jquery_migrate' );
  //
	// function dequeue_jquery_migrate( &$scripts){
	// 	if(!is_admin()){
	// 		$scripts->remove( 'jquery');
	// 		$scripts->add( 'jquery', false, array( 'jquery-core' ), '1.10.2' );
	// 	}
	// }



	// Return an alternate title, without prefix, for every type used in the get_the_archive_title().
add_filter('get_the_archive_title', function ($title) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title = '<span class="vcard">' . get_the_author() . '</span>';
    } elseif ( is_year() ) {
        $title = get_the_date( _x( 'Y', 'yearly archives date format' ) );
    } elseif ( is_month() ) {
        $title = get_the_date( _x( 'F Y', 'monthly archives date format' ) );
    } elseif ( is_day() ) {
        $title = get_the_date( _x( 'F j, Y', 'daily archives date format' ) );
    } elseif ( is_tax( 'post_format' ) ) {
        if ( is_tax( 'post_format', 'post-format-aside' ) ) {
            $title = _x( 'Asides', 'post format archive title' );
        } elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
            $title = _x( 'Galleries', 'post format archive title' );
        } elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
            $title = _x( 'Images', 'post format archive title' );
        } elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
            $title = _x( 'Videos', 'post format archive title' );
        } elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
            $title = _x( 'Quotes', 'post format archive title' );
        } elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
            $title = _x( 'Links', 'post format archive title' );
        } elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
            $title = _x( 'Statuses', 'post format archive title' );
        } elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
            $title = _x( 'Audio', 'post format archive title' );
        } elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
            $title = _x( 'Chats', 'post format archive title' );
        }
    } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( '', false );
    } elseif ( is_tax() ) {
        $title = single_term_title( '', false );
    } else {
        $title = __( 'Archives' );
    }
    return $title;
});

// Add page slug to body classes
	function add_slug_body_class( $classes ) {
		global $post;
		if ( isset( $post ) ) {
			$classes[] = $post->post_type . '-' . $post->post_name;
		}
		return $classes;
	}
add_filter( 'body_class', 'add_slug_body_class' );

function change_wp_search_size($query) {
    if ( $query->is_search ) // Make sure it is a search page
        $query->query_vars['posts_per_page'] = -1; // Change -1 to the number of posts you would like to show

    return $query; // Return our modified query variables
}
add_filter('pre_get_posts', 'change_wp_search_size'); // Hook our custom function onto the request filter