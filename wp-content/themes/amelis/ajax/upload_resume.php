<?php

function uploadResume() {

    $response = [
        'status' => '',
        'message' => ''
    ];

    if( !empty($_FILES['file']['name']) ) {
        $uploadedFile = '';

        if(!empty($_FILES["file"]["type"])){
            $fileName = time().'_'.$_FILES['file']['name'];
            $valid_extensions = array("doc", "docx", "pdf");
            $temporary = explode(".", $_FILES["file"]["name"]);

            $file_extension = end($temporary);

            if( !in_array($file_extension, $valid_extensions) ) {
                $response['status'] = 'error';
                $response['message'] = 'Téléchargez svp le document en format pdf ou doc';
                echo json_encode($response);
            } else {
                $response['status'] = 'success';
                $response['message'] = '';
                echo json_encode($response);
            }

        } else {
            $response['status'] = 'error';
            $response['message'] = 'No file uploaded.';
            echo json_encode($response);
        }

        die();
    } else {
        $response['status'] = 'error';
        $response['message'] = 'No file type uploaded.';
        echo json_encode($response);
    }

    die();
}

add_action('wp_ajax_uploadResume', 'uploadResume');
add_action('wp_ajax_nopriv_uploadResume', 'uploadResume');


function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}