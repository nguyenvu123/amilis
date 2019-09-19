<?php
	setlocale(LC_ALL, 'fr_FR.utf8');
	ini_set('date.timezone', 'Europe/Paris');

	// Keys
	define ('MAIL_CHIMP_KEY', 'e532fd54aee973ed77bfbba7f8f65267-us9');
	define ('MAIL_CHIMP_NEWSLETTER_LIST', '6a1d15c2c5');

	// General info
	define ('CONTACT_PHONE', '01 72 68 02 01');
	define ('HQ_NAME', 'Boulogne-Billancourt (siège)');
	define ('FROM_EMAIL', 'amelis.test@gmail.com');

	// Define some hard coded paths etc
	define ('PATH_DEVIS_THANK_YOU', 'node/20/done');
	define ('PATH_EMPLOI_AUXILIAIRE_THANK_YOU', 'node/214/done');
	define ('PATH_EMPLOI_ADMINISTRATIF_THANK_YOU', 'emploi/agence-administratif/postuler/confirmation');
	
	define ('PATH_APA_GUIDE_THANK_YOU', 'node/277/done'); // APA Guide
	define ('PATH_APA_FORM_THANK_YOU', 'node/278/done'); // APA Formulaire
	define ('PATH_PCH_GUIDE_YOU', 'conseils/aides-financieres/pch/telecharger/confirmation'); // PCH Guide
	define ('PATH_PCH_FORM_THANK_YOU', 'conseils/aides-financieres/pch/telecharger-formulaire/confirmation'); // PCH Formulaire
	define ('PATH_ARDH_THANK_YOU', 'conseils/aides-financieres/ardh/telecharger/confirmation'); // ARDH

	define ('PATH_GIR_THANK_YOU', 'nos-conseils/test-gir/finir'); // GIR

	define ('PATH_CONTACT_THANK_YOU', 'node/255/done'); // CONTACT




	// Define paths to different folders
	define ('CSS_FOLDER', get_template_directory_uri().'/assets/css/');
	define ('CSS_FOLDER_CUSTOMS', get_template_directory_uri().'/assets/customs-css/');
	define ('JS_FOLDER', get_template_directory_uri().'/assets/js/');
	define ('JS_FOLDER_CUSTOMS', get_template_directory_uri().'/assets/customs-js/');
	define ('IMG_FOLDER', get_template_directory_uri().'/assets/images/');

	// Define admin emails array
	function returnAdminEmailAddresses() {
		$emails = array ();
		return $emails;
	}


	// define
	define ('NUMBER_OF_POSTS', get_option('posts_per_page'));
	define ('NUMBER_OF_LEADS_PER_ADMIN_PAGE', 30);

	// Actions
	require_once locate_template('/inc/actions.php');

	// Filters
	require_once locate_template('/inc/filters.php');

	// Shortcodes
	require_once locate_template('/inc/shortcodes.php');

	// Setup thumbnails support
    add_theme_support( 'post-thumbnails' );

    add_image_size( 'listing-thumbnail', 800, 460, true);
    add_image_size( 'listing-featured', 930, 190, true);
	add_image_size( 'listing-single', 1070, 500, true);;

	// Helpers
	require_once locate_template('/helpers/admin.php');
	require_once locate_template('/helpers/get-ip.php');
	require_once locate_template('/helpers/validation.php');
	require_once locate_template('/helpers/forms.php');
	require_once locate_template('/helpers/queries.php');
	require_once locate_template('/helpers/mailchimp.php');
	require_once locate_template('/helpers/others.php');
	
	require_once locate_template('/forms/forms.php');

	// Define additional post types (agences)
	require_once locate_template('/inc/post_types/agences.php');
	require_once locate_template('/inc/post_types/agence-member.php');
	require_once locate_template('/inc/post_types/services.php');
	require_once locate_template('/inc/post_types/faq.php');
	require_once locate_template('/inc/post_types/testimonials.php');

	// Create zip codes table including data of all zipcodes from France
	require_once locate_template('/helpers/init-zipcodes.php');

	// Resume upload
	require_once locate_template('/ajax/upload_resume.php');

	// Devis gratuit form
	require_once locate_template('/ajax/devis_gratuit.php');
	require_once locate_template('/ajax/search_postal_code.php');
	require_once locate_template('/ajax/get_agence_by_code.php');

	// Emploi
	require_once locate_template('/ajax/emploi.php');

	// Gir
	require_once locate_template('/ajax/gir.php');

	// Apa
	require_once locate_template('/ajax/apa.php');

	// Contact
	require_once locate_template('/ajax/contact.php');



	// Custom breadcrumbs
	require_once locate_template('/inc/custom-breadcrumbs.php');

	// Register Custom Navigation Walker
	require_once locate_template('inc/custom_nav_walker.php');

	// Add admin pages for displaying leads
	require_once locate_template('/inc/admin/display_devis_gratuit.php');
	require_once locate_template('/inc/admin/display_emploi.php');
	// require_once locate_template('/inc/admin/display_apa.php');
	require_once locate_template('/inc/admin/display_forms.php');
	require_once locate_template('/inc/admin/display_gir.php');
	require_once locate_template('/inc/admin/display_agences.php');
	require_once locate_template('/inc/admin/display_contact.php');

	// Register footer widget
	$sidebar_args = array(
		'name'          => "Footer Widget",
		'id'            => "footer-widget",
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => "</div>\n",
		'class'         => ''
	);
	register_sidebar( $sidebar_args );

	// Register footer widget
	$sidebar_args2 = array(
		'name'          => "Footer Widget Legal",
		'id'            => "footer-widget-legal",
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => "</div>\n",
		'class'         => ''
	);
	register_sidebar( $sidebar_args2 );