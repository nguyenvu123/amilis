<?php

function emploi_script() {
    $args = array(
        'nonce' => wp_create_nonce( 'CQi59nWfSaDzWSjt6ng548zR' ),
        'url'   => admin_url( 'admin-ajax.php' ),
        'form_url' => 'emploi/auxiliaire-de-vie/postuler'
    );

    wp_enqueue_script( 'emploi_script', JS_FOLDER.'emploi.js', array( 'jquery' ), '1.2', true );
    wp_localize_script( 'emploi_script', 'ajax_object', $args );
}

add_action( 'wp_enqueue_scripts', 'emploi_script' );


// Submit data function
function emploiSubmit() {
    global $wpdb;

    if ( email_is_spam(trim(strtolower($_POST['email']))) ) {
        $response['status'] = 'success';
        $response['thank_you_url'] = site_url(PATH_EMPLOI_AUXILIAIRE_THANK_YOU);
        echo json_encode($response);
        die();
    }

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
    $emploi_data = array(
        'agence_id' => 0,
        'type' => '',
        'time' => current_time( 'mysql' ),
        'name' => '',
        'email' => '',
        'phone' => '',
        'zipcode' => '',
        'experience' => '',
        'diplome' => '',
        'agence' => '',
        'resume_uploaded' => '',
        'structures' => '',
        'position_id' => '',
        'position' => '',
        'linkedin' => '',
        'ip' => get_ip(),
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

    if ( !empty($_POST['code_postal']) )
        $data['code_postal'] = preg_replace("/[^0-9]/", "", $_POST['code_postal']);
    else
        $data['code_postal'] = '';

    $data['experience'] = $_POST['experience'];
    $data['diplome'] = $_POST['diplome'];
    $data['agence'] = $_POST['agence'];

    $emploi_data['type'] = $_POST['emploi_type'];
    

    // Verify if there's a job selection
    if ( !empty($_POST['job_selection']) && is_numeric($_POST['job_selection']) ) {
        $jobs = showJobPositions();
        foreach ( $jobs as $key => $value) {
            if ( $_POST['job_selection'] == $key) {
                $emploi_data['position_id'] = $key;
                $emploi_data['position'] = $value;
            }
        }
    }

    // Check if there are any structures
    $structures = array();

    if ( !empty($params['structure_1'] ) ) 
        array_push($structures, array(
            'structure' => $params['structure_1'],
            'duree' => $params['duree_1']
        ) );

    if ( !empty($params['structure_2'] ) )
        array_push($structures, array(
            'structure' => $params['structure_2'],
            'duree' => $params['duree_2']
        ) );

    if ( !empty($params['structure_3'] ) )
        array_push($structures, array(
            'structure' => $params['structure_3'],
            'duree' => $params['duree_3']
        ) );
    
    $emploi_data['structures'] = json_encode($structures);

    // Linkedin profile
    if ( !empty($_POST['linkedin']) )
        $emploi_data['linkedin'] = $_POST['linkedin'];



    // Form data validation
    $error = false;

    // Match agence by zipcode
    if ( $data['agence'] != '99999') {
        if ( $data['agence'] ) {
            $sql = "SELECT postal_code, town, agence, agence_id FROM agences_work WHERE postal_code=".$data['agence']." ORDER BY town ASC LIMIT 0,1";
        } else {
            $sql = "SELECT postal_code, town, agence, agence_id FROM agences_work WHERE postal_code=".$data['code_postal']." ORDER BY town ASC LIMIT 0,1";
        }
    
        $agence = $wpdb->get_results( $sql );
    
        if ( $agence ) {
            // select agence post type
            $agence_post = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_status='publish' AND ID = '%d'", $agence[0]->agence_id ) );
    
            $agence_email = get_field('email_emploi', $agence_post[0]->ID);
    
            $response['agence'] = 'true';
            $response['message'] = 'We found '.$agence_post[0]->post_title.' agence for you!';
            $response['agence_name'] = $agence_post[0]->post_title;
    
            $emploi_data['agence_id'] = $agence_post[0]->ID;
            $emploi_data['agence'] = $agence_post[0]->post_title;
        }
    } else {
        $response['agence_name'] = HQ_NAME;
        $emploi_data['agence_id'] = 0;
        $emploi_data['agence'] = HQ_NAME;
        $agence_email = 'recrutement.support@amelis-services.com';
    }


    // Upload file
    $fileName = '';
    if( !empty($_FILES['file']['name']) ) {
        $uploadedFile = '';

        if(!empty($_FILES["file"]["type"])){
            $fileName = time().'_'.$_FILES['file']['name'];
            $valid_extensions = array("doc", "docx", "pdf");
            $temporary = explode(".", $_FILES["file"]["name"]);

            $file_extension = end($temporary);

            if( in_array($file_extension, $valid_extensions) ) {
                $sourcePath = $_FILES['file']['tmp_name'];

                $root = $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/resumes/';
                $random_folder = generateRandomString();

                mkdir( $root.$random_folder, 0777 );

                $filePath = $root.$random_folder.'/'.$fileName;
                
                $targetPath = $filePath;

                try {
                    if( move_uploaded_file($sourcePath, $targetPath) ) {
                        chmod( $targetPath, 0777);

                        $uploadedFile = $fileName;
    
                        $response['status'] = 'success';
                        $response['message'] = 'File uploaded!';
                        $response['filename'] = $filePath;
                        $emploi_data['resume_uploaded'] = $random_folder.'/'.$fileName;
                        // echo json_encode($response);
                    } else {
                        $response['status'] = 'error';
                        $response['message'] = "Couldn't move file.";
                        // echo json_encode($response);
                    }
                } catch (Exception $e) {
                    $response['status'] = 'error';
                    $response['message'] = 'Caught exception: '.$e->getMessage();
                    // echo json_encode($response);
                }

            } else {
                $response['status'] = 'error';
                $response['message'] = 'Téléchargez svp le document en format pdf ou doc';
                // echo json_encode($response);
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'No file uploaded.';
            // echo json_encode($response);
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'No file type uploaded.';
        // echo json_encode($response);
    }


 

    // Database insert rows
    $table_name = 'emploi';

    $_SESSION['trackingItemId'] = '';

    // if no error, proceed to database insert
    if ( !$error ) {
        
        $emploi_data['name'] = $data['name'];
        $emploi_data['email'] = $data['email'];
        $emploi_data['phone'] = $data['phone'];
        $emploi_data['zipcode'] = $data['code_postal'];
        $emploi_data['experience'] = $data['experience'];
        $emploi_data['diplome'] = $data['diplome'];

        $wpdb->insert( $table_name, $emploi_data);

        session_start();
        $lastid = $wpdb->insert_id;
        $_SESSION['trackingItemId'] = $lastid;
        $response['lastId'] = $_SESSION['trackingItemId'];
    }

    // Send the email admin email
    $admin_emails = returnAdminEmailAddresses();
    if ( $agence_email )
        array_push($admin_emails, $agence_email);

    if ( $emploi_data['type'] == 'auxiliaire' )
        $subject = 'Formulaire de candidature Auxiliaire de vie';

    if ( $emploi_data['type'] == 'administratif' )
    $subject = 'Formulaire de candidature Poste en agence';

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8'."\r\n";
    $headers .= 'From: Amelis Groupe Sodexo <'.FROM_EMAIL.'>'."\r\n";

    if ($agence_email)
        $headers .= 'Bcc: <'.$agence_email.'>'."\r\n";

    if ( $emploi_data['type'] == 'administratif' )
        $headers .= 'Bcc: <recrutement.support@amelis-services.com>'."\r\n";
        

    $message = '';
    $message .= '<p><strong>Nom:</strong> '.$data['name'].'</p>';
    $message .= '<p><strong>Téléphone:</strong> '.$data['phone'].'</p>';
    $message .= '<p><strong>E-mail:</strong> '.$data['email'].'</p>';

    if ( $data['code_postal'] )
        $message .= '<p><strong>Code postal:</strong> '.$data['code_postal'].'</p>';

    if ( $emploi_data['agence_id'] > 0 ) {
        $message .= '<p><strong>Agence:</strong> '.$emploi_data['agence'].'</p>';
        $message .= '<p><strong>E-mail de l’agence:</strong> '.$agence_email.'</p>';
    }

    if ( $data['agence'] == '99999' ) {
        $message .= '<p><strong>Agence:</strong> '.HQ_NAME.'</p>';
    }

    if ( $emploi_data['position'] )
        $message .= '<p><strong>Poste souhaité:</strong> '.$emploi_data['position'].'</p>';

    if ( $emploi_data['linkedin'] )
        $message .= '<p><strong>Linkedin:</strong> <a href="'.$emploi_data['linkedin'].'">'.$emploi_data['linkedin'].'</a></p>';


    if ( $emploi_data['experience'] && $emploi_data['type'] == 'auxiliaire' )
        $message .= '<p><strong>3 ans d’experience professionnelle dans le secteur social:</strong> '.($emploi_data['experience'] == 1) ? 'Oui' : 'Non'.'</p>';
    
    if ( $structures ) {
        $message .= '<ol>';
        foreach ( $structures as $s) : 
            $message .= '<li>'.$s['structure'].' - '.$s['duree'].' ans'.'</li>';
        endforeach;
        $message .= '</ol>';
    }

    if ( $emploi_data['diplome'] )
        $message .= '<p><strong>Diplome du secteur social:</strong> '.$emploi_data['diplome'].'</p>';


    $message .= "\r\n"."\r\n";

    $attachments = NULL;

    if ( $fileName )
        $attachments = WP_CONTENT_DIR . '/uploads/resumes/'.$random_folder.'/'.$fileName;

    wp_mail( $admin_emails, $subject, $message, $headers, $attachments );



    // Send the user email
    if ( $emploi_data['type'] == 'auxiliaire' )
        send_emploi_auxiliaire_email($emploi_data);
    
    if ( $emploi_data['type'] == 'administratif' )
        send_emploi_administratif_email($emploi_data);

    remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

    // Send success
    $response['status'] = 'success';
        $response['thank_you_url'] = site_url(PATH_EMPLOI_AUXILIAIRE_THANK_YOU);

    if ( $emploi_data['type'] == 'administratif')
        $response['thank_you_url'] = site_url(PATH_EMPLOI_ADMINISTRATIF_THANK_YOU);

    if ( $emploi_data['type'] == 'auxiliaire')
        $response['thank_you_url'] = site_url(PATH_EMPLOI_AUXILIAIRE_THANK_YOU);

    echo json_encode($response);

    die();

}

add_action('wp_ajax_emploiSubmit', 'emploiSubmit');
add_action('wp_ajax_nopriv_emploiSubmit', 'emploiSubmit');