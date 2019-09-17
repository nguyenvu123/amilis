<?php

function apa_script() {
    $args = array(
        'nonce' => wp_create_nonce( 'CQi59nWfSaDzWSjt6ng548zR' ),
        'url'   => admin_url( 'admin-ajax.php' )
    );

    wp_enqueue_script( 'apa_script', JS_FOLDER.'apa.js', array( 'jquery' ), '1.2', true );
    wp_localize_script( 'apa_script', 'ajax_object', $args );
}

add_action( 'wp_enqueue_scripts', 'apa_script' );


function apaSubmit() {
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
    if ( !isset($params['web_form_wpnonce']) || !wp_verify_nonce($params['web_form_wpnonce'], 'web_form_action') ) {
        echo 'You are not allowed!';
        die();
    }
    
    $data = [];
    $form_data = array(
        'type' => '',
        'time' => current_time( 'mysql' ),
        'name' => '',
        'email' => '',
        'phone' => '',
        'zipcode' => '',
        'type' => '',
        'department' => 0,
        'agence_id' => 0,
        'agence' => '',
        'ip' => get_ip(),
        'newsletter' => '',
        'contacte' => '',
        'status' => 'new'
    );
    $types = array ('APA Guide', 'APA Formulaire', 'PCH Guide', 'PCH Formulaire', 'ARDH');

    $error = false;

    $response = [
        'status' => '',
        'agence' => 'false',
        'agence_name' => ''
    ];

    // Take POST data
    $data['name'] = $_POST['name'];
    $data['email'] = $_POST['email'];
    $data['phone'] = $_POST['phone'];
    $data['code_postal'] = preg_replace("/[^0-9]/", "", $_POST['code_postal']);

    $data['agence'] = $_POST['agence'];

    // Check form type
    if ( !empty($_POST['type']) && in_array($_POST['type'], $types) ) {
        $form_data['type'] = $_POST['type'];
    } else {
        die();
    }


    $data['department'] = 0;
    if ( $_POST['department'] )
        $data['department'] = $_POST['department'];

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
        // $response['message'] = 'We found '.$agence_post[0]->post_title.' agence for you!';
        // $response['agence_name'] = $agence_post[0]->post_title;

        $form_data['agence_id'] = $agence_post[0]->ID;
        $form_data['agence'] = $agence_post[0]->post_title;
    }

    // Je souhaite être contacté
    if ( !empty($_POST['contactesign']) && $_POST['contactesign'] == '1' )
        $form_data['contacte'] = 1;

    // Subscribe to newsletter
    if ( !empty($_POST['newsletter']) && $_POST['newsletter'] == '1' ) {
        $form_data['newsletter'] = 1;

        $newsletter_data = [
            'email' => $data['email'],
            'status' => 'subscribed',
            'firstname' => $data['name'],
            'lastname' => ''
        ];
        syncMailChimp($newsletter_data);
    }



    // Database insert rows
    $table_name = 'forms';

    $_SESSION['trackingItemId'] = '';

    // if no error, proceed to database insert
    if ( !$error ) {
        
        $form_data['name'] = $data['name'];
        $form_data['email'] = $data['email'];
        $form_data['phone'] = $data['phone'];
        $form_data['zipcode'] = $data['code_postal'];
        $form_data['department'] = $data['department'];

        $wpdb->insert( $table_name, $form_data);

        session_start();
        $lastid = $wpdb->insert_id;
        $_SESSION['trackingItemId'] = $lastid;
        $response['lastId'] = $_SESSION['trackingItemId'];
    }

    // Send the email admin email
    $admin_emails = returnAdminEmailAddresses();

    switch ($form_data['type']) {
        case 'APA Guide':
                $subject = 'Demande de guide APA';
            break;
        case 'APA Formulaire':
                $subject = 'Demande de formulaire APA';
            break;
        case 'PCH Guide':
                $subject = 'Demande de guide PCH';
            break;
        case 'PCH Formulaire':
                $subject = 'Demande de formulaire PCH';
            break;
        case 'ARDH':
                $subject = 'Demande de formulaire ARDH';
            break;
    }



    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8'."\r\n";
    $headers .= 'From: Amelis Groupe Sodexo <'.FROM_EMAIL.'>'."\r\n";

    if ($agence_email)
        $headers .= 'Bcc: <'.$agence_email.'>'."\r\n";

    $message = '';
    $message .= '<p><strong>Nom:</strong> '.$data['name'].'</p>';
    $message .= '<p><strong>Téléphone:</strong> '.$data['phone'].'</p>';
    $message .= '<p><strong>Email:</strong> '.$data['email'].'</p>';
    $message .= '<p><strong>Code postal:</strong> '.$data['code_postal'].'</p>';

    if ( $form_data['newsletter'] == 1 )
        $message .= '<p><strong>Newsletter:</strong> Oui</p>';


    if ( $form_data['contacte'] == 1 )
        $message .= '<p><strong>Je souhaite être contacté:</strong> Oui</p>';
    else
        $message .= '<p><strong>Je souhaite être contacté:</strong> Non</p>';

    $message .= '<p><strong>Formulaire:</strong> '.$form_data['type'].'</p>';

    if ( $form_data['department'] > 0 ) {
        $message .= '<p><strong>Département:</strong> '.$form_data['department'].'</p>';
    }

    $message .= "\r\n"."\r\n";

    wp_mail( $admin_emails, $subject, $message, $headers );


    // Send the user email
    $types = array ('APA Guide', 'APA Formulaire', 'PCH Guide', 'PCH Formulaire', 'ARDH');
    
    switch ($form_data['type']) {
        case 'APA Guide':
                $response['thank_you_url'] = send_APA_guide_email($form_data);
            break;
        case 'APA Formulaire':
                $response['thank_you_url'] = send_APA_formulaire_email($form_data);
            break;
        case 'PCH Guide':
                $response['thank_you_url'] = send_PCH_guide_email($form_data);
            break;
        case 'PCH Formulaire':
                $response['thank_you_url'] = send_PCH_formulaire_email($form_data);
            break;
        case 'ARDH':
                $response['thank_you_url'] = send_ARDH_guide_email($form_data);
            break;
    }

    
    $response['status'] == 'success';
    echo json_encode($response);



    die();
}

add_action('wp_ajax_apaSubmit', 'apaSubmit');
add_action('wp_ajax_nopriv_apaSubmit', 'apaSubmit');