<?php

function contact_script() {
    $args = array(
        'nonce' => wp_create_nonce( 'CQi59nWfSaDzWSjt6ng548zR' ),
        'url'   => admin_url( 'admin-ajax.php' )
    );

    wp_enqueue_script( 'contact_script', JS_FOLDER.'contact.js', array( 'jquery' ), '1.2', true );
    wp_localize_script( 'contact_script', 'ajax_object', $args );
}

add_action( 'wp_enqueue_scripts', 'contact_script' );


function contactSubmit() {
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
    $contact_data = array(
        'agence_id' => '0',
        'time' => current_time( 'mysql' ),
        'subject' => '',
        'name' => '',
        'email' => '',
        'phone' => '',
        'agence' => '',
        'ip' => get_ip(),
        'newsletter' => 0,
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

    $data['agence'] = $_POST['agence'];

    $data['subject'] = $_POST['subject'];

    // select agence post type
    $agence_post = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_status='publish' AND ID = '%d'", $data['agence'] ) );

    $agence_email = get_field('email', $agence_post[0]->ID);

    $response['agence'] = 'true';
    $response['message'] = 'We found '.$agence_post[0]->post_title.' agence for you!';
    $response['agence_name'] = $agence_post[0]->post_title;

    $contact_data['agence_id'] = $agence_post[0]->ID;
    $contact_data['agence'] = $agence_post[0]->post_title;


    

    // Subscribe to newsletter
    if ( !empty($_POST['newsletter']) && $_POST['newsletter'] == '1' ) {
        $contact_data['newsletter'] = 1;

        $newsletter_data = [
            'email' => $data['email'],
            'status' => 'subscribed',
            'firstname' => $data['name'],
            'lastname' => ''
        ];
        syncMailChimp($newsletter_data);
    }

    

    // Database insert rows
    $table_name = 'contact';

    // if no error, proceed to database insert
    if ( !$error ) {
        
        $contact_data['name'] = $data['name'];
        $contact_data['email'] = $data['email'];
        $contact_data['phone'] = $data['phone'];
        $contact_data['subject'] = $data['subject'];
        $contact_data['phone'] = $data['phone'];

        $wpdb->insert( $table_name, $contact_data);
    }


     // Send the email admin email
     $admin_emails = returnAdminEmailAddresses();
 
     $subject = 'Amelis Contact Form';
 
     $headers  = 'MIME-Version: 1.0' . "\r\n";
     $headers .= 'Content-type: text/html; charset=UTF-8'."\r\n";
     $headers .= 'From: Amelis Groupe Sodexo <'.FROM_EMAIL.'>'."\r\n";
 
     if ($agence_email)
         $headers .= 'Bcc: <'.$agence_email.'>'."\r\n";
 
     $message = '';
     $message .= '<p><strong>Subject:</strong> '.$data['subject'].'</p>';
     $message .= '<p><strong>Agence:</strong> '.$contact_data['agence'].'</p>';
     $message .= '<p><strong>Name:</strong> '.$data['name'].'</p>';
     $message .= '<p><strong>Phone:</strong> '.$data['phone'].'</p>';
     $message .= '<p><strong>Email:</strong> '.$data['email'].'</p>';

     if ( $contact_data['newsletter'] )
         $message .= '<p><strong>Newsletter:</strong> Oui</p>';
 
     $message .= "\r\n"."\r\n";
 
     wp_mail( $admin_emails, $subject, $message, $headers );



    // Send the user email
    send_contact_email($contact_data);

    $response['status'] = 'success';
    $response['thank_you_url'] = site_url(PATH_CONTACT_THANK_YOU);

    echo json_encode($response);

    die();

}


add_action('wp_ajax_contactSubmit', 'contactSubmit');
add_action('wp_ajax_nopriv_contactSubmit', 'contactSubmit');