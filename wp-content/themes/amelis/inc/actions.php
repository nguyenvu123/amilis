<?php

	// enqueue styles and scripts the right way
	function enqueue_front_page_scripts() {
			wp_register_style( 'main', CSS_FOLDER.'main.min.css', false, date('ymdhis'), false );
			wp_register_style( 'google_fonts', 'https://fonts.googleapis.com/css?family=IBM+Plex+Sans:300,400,400i,500,600,700&amp;subset=latin-ext' );

			wp_enqueue_style('google_fonts');
			// wp_enqueue_style('main');

			wp_enqueue_script( 'jquery');
			// wp_enqueue_script('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js', array('jquery'), '1.0', true);
			// wp_enqueue_script('maps_api', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBHpx78atlJrgAZFhIZvrKoJe1_AdEhGA4', '', '');
			wp_enqueue_script('headroom', JS_FOLDER . 'headroom.js', array('jquery'), '1.0', true);
			wp_enqueue_script('jquery.headroom', JS_FOLDER . 'jquery.headroom.js', array('jquery'), '1.0', true);

			wp_enqueue_script('autocomplete', JS_FOLDER . 'jquery.autocomplete.min.js', array('jquery'), '1.0', true);

			wp_enqueue_script( 'helpers', JS_FOLDER . 'helpers.js', array('jquery'), '1.4', true );
			wp_enqueue_script( 'owl', JS_FOLDER . 'owl.carousel.min.js', array('jquery'), '1.4', true );
	}
	add_action( 'wp_enqueue_scripts', 'enqueue_front_page_scripts', 1 );

	function my_custom_styles() {

  		wp_register_style( 'main_customs', CSS_FOLDER_CUSTOMS.'main.css', false, date('ymdhis'), false );
  		wp_enqueue_style( 'main_customs' );
	}
	add_action( 'wp_enqueue_scripts', 'my_custom_styles', 33);

	// Load css to admin
	function load_custom_wp_admin_style($hook) {
		wp_enqueue_style( 'admin_css', CSS_FOLDER.'admin.min.css');
		wp_enqueue_style( 'tableexport', CSS_FOLDER.'tableexport.min.css');

		wp_enqueue_script( 'xlsx', JS_FOLDER . 'xlsx.core.min.js', array('jquery'), '1.4', true );
		wp_enqueue_script( 'filesaver', JS_FOLDER . 'FileSaver.min.js', array('jquery'), '1.4', true );
		wp_enqueue_script( 'tableexport', JS_FOLDER . 'tableexport.min.js', array('jquery'), '1.4', true );

		wp_enqueue_script( 'admin', JS_FOLDER . 'admin.js', array('jquery'), '1.4', true );
	}
	add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );



	// add featured image and menus
	add_theme_support('post-thumbnails');
	add_theme_support( 'menus' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'yoast-seo-breadcrumbs' );


	// enable excerpt for pages
	add_action( 'init', 'my_add_excerpts_to_pages' );
	function my_add_excerpts_to_pages() {
			 add_post_type_support( 'page', 'excerpt' );
	}



	// remove CSS from recent comments widget
	function wp_theme_remove_recent_comments_style() {
		global $wp_widget_factory;
		if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
			remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
		}
	}

	function wp_theme_head_cleanup() {
		// http://wpengineer.com/1438/wordpress-header/
		remove_action('wp_head', 'feed_links', 2);
		remove_action('wp_head', 'feed_links_extra', 3);
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'index_rel_link');
		remove_action('wp_head', 'parent_post_rel_link', 10, 0);
		remove_action('wp_head', 'start_post_rel_link', 10, 0);
		remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
		remove_action('wp_head', 'wp_generator');
		remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
		remove_action('wp_head', 'noindex', 1);
		add_action('wp_head', 'wp_theme_remove_recent_comments_style', 1);
	}

	add_action('init', 'wp_theme_head_cleanup');

	add_action('get_header', 'remove_admin_login_header');
	function remove_admin_login_header() {
		remove_action('wp_head', '_admin_bar_bump_cb');
	}


	/**
	 * Register our sidebars and widgetized areas.
	 *
	 */
	function amelis_widgets_init() {

		register_sidebar( array(
			'name'          => 'Blog post right sidebar',
			'id'            => 'blog_single_right_1',
			'before_widget' => '<div>',
			'after_widget'  => '</div><div class="h-space-20"></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		) );

	}
	add_action( 'widgets_init', 'amelis_widgets_init' );

	// Remove thank you pages (and other) from search
	add_action('pre_get_posts','wpse67626_exclude_posts_from_search');
	function wpse67626_exclude_posts_from_search( $query ){

		if( $query->is_search() ){
			//Exclude posts by ID
			$post_ids = array(2754, 2746, 2641, 2744, 2765, 2740, 2762, 2733, 2769, 2643, 2772, 2731, 2758, 2687, 145, 328, 2896, 2727, 2783);
			$query->set('post__not_in', $post_ids);
		}

}


?>
