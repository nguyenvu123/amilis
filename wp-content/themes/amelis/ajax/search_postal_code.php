<?php
function postalCodeAutocomplete() {

    global $wpdb;

    $query = $_POST['query'];

    if ( !is_numeric($query) )
        die();

    // Look for the searched postal code in our database of postal codes
    $sql = "SELECT postal_code, name FROM postal_codes WHERE CAST(postal_code as CHAR) LIKE '".$query."%' ORDER BY NAME ASC LIMIT 0,50";
    $postal_codes = $wpdb->get_results( $sql );


    $response = array();
    $response['suggestions'] = array();
    $response['agence_found'] = 'false';

    if ( count($postal_codes) > 0 ) :
        foreach ( $postal_codes as $pc) {
            $postal_code = array();

            $postal_code = [
                'value' => $pc->postal_code.' '.ucwords(strtolower($pc->name)),
                'data' => $pc->postal_code
            ];

            array_push($response['suggestions'], $postal_code);
        }
    endif;

    echo json_encode($response);
    die();
}

add_action('wp_ajax_postalCodeAutocomplete', 'postalCodeAutocomplete');
add_action('wp_ajax_nopriv_postalCodeAutocomplete', 'postalCodeAutocomplete');