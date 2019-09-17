<?php

function gir_script() {
    $args = array(
        'nonce' => wp_create_nonce( 'CQi59nWfSaDzWSjt6ng548zR' ),
        'url'   => admin_url( 'admin-ajax.php' )
    );

    wp_enqueue_script( 'gir_script', JS_FOLDER.'gir.js', array( 'jquery' ), '1.2', true );
    wp_localize_script( 'gir_script', 'ajax_object', $args );
}

add_action( 'wp_enqueue_scripts', 'gir_script' );


function girSubmit() {
    require_once locate_template('/gir/amelis_test.gir.php');
    
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


    $gir = new TestGir($params['questions'] );
    $score = $gir->computeScore();
    
    global $wpdb;
    
    $data = [];
    $gir_data = array(
        'agence_id' => 0,
        'time' => current_time( 'mysql' ),
        'name' => '',
        'email' => '',
        'phone' => '',
        'zipcode' => '',
        'score' => '',
        'agence_id' => '',
        'agence' => '',
        'ip' => get_ip(),
        'newsletter' => 0,
        'contacte' => 0,
        'status' => 'new'
    );


    $data['name'] = $_POST['name'];
    $data['email'] = $_POST['email'];
    $data['phone'] = $_POST['phone'];
    $data['code_postal'] = preg_replace("/[^0-9]/", "", $_POST['code_postal']);

    $agence_email = '';

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

        $gir_data['agence_id'] = $agence_post[0]->ID;
        $gir_data['agence'] = $agence_post[0]->post_title;
    }

    // Je souhaite être contacté
    if ( !empty($_POST['contactesign']) && $_POST['contactesign'] == '1' )
        $gir_data['contacte'] = 1;

    

    // Subscribe to newsletter
    if ( !empty($_POST['newsletter']) && $_POST['newsletter'] == '1' ) {
        $gir_data['newsletter'] = 1;

        $newsletter_data = [
            'email' => $data['email'],
            'status' => 'subscribed',
            'firstname' => $data['name'],
            'lastname' => ''
        ];
        syncMailChimp($newsletter_data);
    }



    // Database insert rows
    $table_name = 'gir';

    $_SESSION['trackingItemId'] = '';

    // if no error, proceed to database insert
    if ( !$error ) {
        $gir_data['name'] = $data['name'];
        $gir_data['email'] = $data['email'];
        $gir_data['phone'] = $data['phone'];
        $gir_data['zipcode'] = $data['code_postal'];
        $gir_data['score'] = $score;

        $wpdb->insert( $table_name, $gir_data);

        session_start();
        $lastid = $wpdb->insert_id;
        $_SESSION['trackingItemId'] = $lastid;
        $response['lastId'] = $_SESSION['trackingItemId'];
    }

    


    // Test results messages
    $test_results = array (
        1 => "Personne confinée au lit ou au fauteuil, dont les fonctions mentales sont gravement altérées et qui nécessite une présence indispensable et continue d'intervenants. Ou personne en fin de vie",
        2 => "Personne confinée au lit ou au fauteuil, dont les fonctions mentales ne sont pas totalement altérées et dont l'état exige une prise en charge pour la plupart des activités de la vie courante. Ou personne dont les fonctions mentales sont altérées, mais qui est capable de se déplacer et qui nécessite une surveillance permanente.",
        3 => "Personne ayant conservé son autonomie mentale, partiellement son autonomie locomotrice, mais qui a besoin quotidiennement et plusieurs fois par jour d'une aide pour les soins corporels.",
        4 => "Personne n'assumant pas seule ses transferts mais qui, une fois levée, peut se déplacer à l'intérieur de son logement, et qui a besoin d'aides pour la toilette et l'habillage, Ou personne n'ayant pas de problèmes locomoteurs mais qui doit être aidée pour les soins corporels et les repas.",
        5 => "Personne ayant seulement besoin d'une aide ponctuelle pour la toilette, la préparation des repas et le ménage.",
        6 => "Personne encore autonome pour les actes essentiels de la vie courante."
    );
    $test_brief_results = array (
        1 => 'Dépendance totale',
        2 => 'Grande dépendance',
        3 => 'Dépendance corporelle',
        4 => 'Dépendance corporelle partielle',
        5 => 'Dépendance corporelle légère',
        6 => 'Pas de dépendance notable',
    );

    // Send the email admin email
    $admin_emails = returnAdminEmailAddresses();
    if ( $agence_email )
        array_push($admin_emails, $agence_email);

    $subject = 'Réception de votre demande de GIR test';

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8'."\r\n";
    $headers .= 'From: Amelis Groupe Sodexo <'.FROM_EMAIL.'>'."\r\n";

    if ($agence_email)
        $headers .= 'Bcc: <'.$agence_email.'>'."\r\n";

    $message = '';
    $message .= '<p><strong>Name:</strong> '.$data['name'].'</p>';
    $message .= '<p><strong>Phone:</strong> '.$data['phone'].'</p>';
    $message .= '<p><strong>Email:</strong> '.$data['email'].'</p>';
    $message .= '<p><strong>Postal Code:</strong> '.$data['code_postal'].'</p>';

    if ( $gir_data['newsletter'] == 1 )
        $message .= '<p><strong>Newsletter:</strong> Oui</p>';

    if ( $gir_data['contacte'] == 1 )
        $message .= '<p><strong>Je souhaite être contacté:</strong> Oui</p>';
    else
        $message .= '<p><strong>Je souhaite être contacté:</strong> Non</p>';

    if ( $gir_data['agence_id'] > 0 ) {
        $message .= '<p><strong>Agence:</strong> '.$gir_data['agence'].'</p>';
        $message .= '<p><strong>Agence email:</strong> '.$agence_email.'</p>';
    }

    $message .= '<p>GIR <strong>'.$score.' ('.$test_brief_results[$score].').</strong></p>';
    $message .= '<p><strong><em>'.$test_results[$score].'</em></strong></p>';

    $message .= "\r\n"."\r\n";

    wp_mail( $admin_emails, $subject, $message, $headers );


     // Send the user email
     $subject = 'Amelis groupe Sodexo: Résultat du test GIR';

     $headers  = 'MIME-Version: 1.0' . "\r\n";
     $headers .= 'Content-type: text/html; charset=UTF-8'."\r\n";
     $headers .= 'From: Amelis Groupe Sodexo <'.FROM_EMAIL.'>'."\r\n";
 
     $message = '';
     $message .= '<p>Bonjour '.$data['name'].',</p>';
     $message .= '<p>Veuillez trouver ci-dessous le résultat de votre test GIR.</p>';
     $message .= '<p>Selon la grille AGGIR, vous relevez du GIR <strong>'.$score.' ('.$test_brief_results[$score].').</strong></p>';
     $message .= '<p><strong><em>'.$test_results[$score].'</em></strong></p>';
     $message .= '<p>L’allocation APA est octroyée aux personnes de plus de 60 ans et dont le degré de dépendance se situe en GIR 1 à 4.</p>';
     $message .= '<p>Contactez-nous pour plus de renseignements sur l’APA et nos services d’aide à domicile.</p>';
 
     wp_mail( $data['email'], $subject, $message, $headers );
 
 
 
     remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
    
    $response['status'] = 'success';
    $response['message'] = 'success';
    $response['thank_you_url'] = site_url(PATH_GIR_THANK_YOU);

    echo json_encode($response);


    die();
}

add_action('wp_ajax_girSubmit', 'girSubmit');
add_action('wp_ajax_nopriv_girSubmit', 'girSubmit');