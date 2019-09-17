<?php

function main_script() {
    $args = array(
        'nonce' => wp_create_nonce( 'CQi59nWfSaDzWSjt6ng548zR' ),
        'url'   => admin_url( 'admin-ajax.php' )
    );

    wp_enqueue_script( 'main_script', JS_FOLDER.'main.js', array( 'jquery' ), '1.2', true );
    wp_localize_script( 'main_script', 'ajax_object', $args );
}

add_action( 'wp_enqueue_scripts', 'main_script' );

function devis_gratuit_script() {
    $args = array(
        'nonce' => wp_create_nonce( 'CQi59nWfSaDzWSjt6ng548zR' ),
        'url'   => admin_url( 'admin-ajax.php' ),
        'form_url' => 'demander-un-devis-gratuit'
    );

    wp_enqueue_script( 'devis_gratuit_script', JS_FOLDER.'devis-gratuit.js', array( 'jquery' ), '1.3', true );
    wp_localize_script( 'devis_gratuit_script', 'ajax_object', $args );
}

add_action( 'wp_enqueue_scripts', 'devis_gratuit_script' );



function devisGratuitSubmit() {
    global $wpdb;

    // Get all POST params
    $params = array();
    parse_str($_POST['data'], $params);

    // Check empty field, anti spam
    if ( !empty($params['your_subject']) ) {
        $response['status'] = 'success';
        $response['thank_you_url'] = site_url('/');
        echo json_encode($response);
        die();
    }

    // Check wp nonce
    if ( !isset($params['devis_gratuit_wpnonce']) || !wp_verify_nonce($params['devis_gratuit_wpnonce'], 'devis_gratuit_action') ) {
        echo 'You are not allowed!';
        die();
    }
    
    $data = [];
    $devis_gratuit_data = array(
        'agence_id' => 0,
        'search_for' => '',
        'frequency' => '',
        'services' => '',
        'services_ids' => '',
        'time' => current_time( 'mysql' ),
        'name' => '',
        'email' => '',
        'phone' => '',
        'zipcode' => '',
        'agence' => '',
        'ip' => get_ip(),
        'newsletter' => 0,
        'contacte' => 0,
        'status' => 'new'
    );

    $error = false;

    $response = [
        'status' => '',
        'message' => "We didn't find an agency for you.",
        'agence' => 'false',
        'agence_name' => ''
    ];

    // Take POST data
    $data['name'] = $_POST['name'];
    $data['email'] = $_POST['email'];
    $data['phone'] = $_POST['phone'];
    $data['code_postal'] = preg_replace("/[^0-9]/", "", $_POST['code_postal']);
    $data['newsletter'] = $_POST['newsletter'];


    // Search for & frequency
    $data['search_for'] = $params['aide-pour'];

    $frequency = array(
        '0' => 'Je ne sais pas',
        '-1' => 'Tous les Jours',
        '3' => '1 à 3 Jours',
        '5' => '3 à 5 Jours'
    );
    $data['frequency'] = $frequency[$params['combien-fois']];

    // Services
    $services = array();
    $search_for = array();
    

    if ( $params['services'] ) {
        foreach ($params['services'] as $key => $value) {
            if ( is_numeric($value) )
                array_push($services, $value);
       }

       $args = [
           'posts_per_page' => -1,
           'orderby' => 'title',
           'order' => 'ASC',
           'post_type' => 'service',
           'include' => $services
       ];
       $services_db = get_posts($args);
       
       foreach ( $services_db as $s) {
           array_push($search_for, $s->post_title);
       }
       $data['services'] = implode(',', $search_for);
       $data['services_ids'] = implode(',', $services);
    }


    // Form data validation
    $error = false;

    // Match agence by zipcode
    $sql = "SELECT postal_code, town, agence, agence_id FROM agences WHERE postal_code=".$data['code_postal']." ORDER BY town ASC LIMIT 0,1";
    $agence = $wpdb->get_results( $sql );

    if ( $agence ) {
        // select agence post type
        $agence_post = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_status='publish' AND ID = '%d'", $agence[0]->agence_id ) );

        $agence_email = get_field('email', $agence_post[0]->ID);

        $response['agence'] = 'true';
        $response['message'] = 'We found '.$agence_post[0]->post_title.' agence for you!';
        $response['agence_name'] = $agence_post[0]->post_title;

        $devis_gratuit_data['agence_id'] = $agence_post[0]->ID;
        $devis_gratuit_data['agence'] = $agence_post[0]->post_title;
    }

    // Subscribe to newsletter
    if ( !empty($_POST['newsletter']) && $_POST['newsletter'] == '1' ) {
        $devis_gratuit_data['newsletter'] = 1;

        $newsletter_data = [
            'email' => $data['email'],
            'status' => 'subscribed',
            'firstname' => $data['name'],
            'lastname' => ''
        ];
        syncMailChimp($newsletter_data);
    }



    // Database insert rows
    $table_name = 'devis_gratuit';

    $_SESSION['trackingItemId'] = '';

    // if no error, proceed to database insert
    if ( !$error ) {
        $devis_gratuit_data['name'] = $data['name'];
        $devis_gratuit_data['email'] = $data['email'];
        $devis_gratuit_data['phone'] = $data['phone'];
        $devis_gratuit_data['zipcode'] = $data['code_postal'];

        
       $devis_gratuit_data['search_for'] = $data['search_for'];
       $devis_gratuit_data['frequency'] = $data['frequency'];

       $devis_gratuit_data['services'] = $data['services'];
       $devis_gratuit_data['services_ids'] = $data['services_ids'];

        $wpdb->insert( $table_name, $devis_gratuit_data);

        session_start();
        $lastid = $wpdb->insert_id;
        $_SESSION['trackingItemId'] = $lastid;
        $response['lastId'] = $_SESSION['trackingItemId'];
    }



    // Send the email admin email
    $admin_emails = returnAdminEmailAddresses();
    
    if ( $agence_email )
        array_push($admin_emails, $agence_email);
    else
        array_push($admin_emails, 'professionnel@prestadomicile.com');

    $subject = 'Réception un devis gratuit';

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8'."\r\n";
    $headers .= 'From: Amelis Groupe Sodexo <'.FROM_EMAIL.'>'."\r\n";

    if ($agence_email)
        $headers .= 'Bcc: <'.$agence_email.'>'."\r\n";

    $message = '';
    $message .= '<p><strong>Recherche une aide pour:</strong> '.$data['search_for'].'</p>';
    $message .= '<p><strong>Nom:</strong> '.$data['name'].'</p>';
    $message .= '<p><strong>Téléphone:</strong> '.$data['phone'].'</p>';
    $message .= '<p><strong>Email:</strong> '.$data['email'].'</p>';
    $message .= '<p><strong>Code postal:</strong> '.$data['code_postal'].'</p>';

    if ( $devis_gratuit_data['newsletter'] == 1 )
        $message .= '<p><strong>Newsletter:</strong> Oui</p>';

    if ( $devis_gratuit_data['agence_id'] > 0 ) {
        $message .= '<p><strong>Agence:</strong> '.$devis_gratuit_data['agence'].'</p>';
        $message .= '<p><strong>Agence email:</strong> '.$agence_email.'</p>';
    }

    $message .= '<p><strong>Fois par semaine:</strong> '.$data['frequency'].'</p>';
    $message .= '<p><strong>Prestations de service:</strong> '.str_replace(',', ', ', $data['services']).'</p>';


    $message .= "\r\n"."\r\n";

    wp_mail( $admin_emails, $subject, $message, $headers );



    // Send the user email
    send_devis_gratuit_email($devis_gratuit_data);


    remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

    $response['status'] = 'success';
    $response['thank_you_url'] = site_url(PATH_DEVIS_THANK_YOU);

    echo json_encode($response);

    die();
}

add_action('wp_ajax_devisGratuitSubmit', 'devisGratuitSubmit');
add_action('wp_ajax_nopriv_devisGratuitSubmit', 'devisGratuitSubmit');