<?php
function getAgenceByPostalCode() {

    global $wpdb;

    $postal_code = $_POST['postal_code'];

    if ( !is_numeric($postal_code) )
        die();

    if ( $_POST['type'] == 'emploi')
        $agence = $wpdb->get_results( $wpdb->prepare("SELECT * FROM agences_work WHERE postal_code='%s'", strtolower($postal_code) ) );
    else
        $agence = $wpdb->get_results( $wpdb->prepare("SELECT * FROM agences WHERE postal_code='%s'", strtolower($postal_code) ) );

    // No agence found
    if (!$agence) {
        $response = [
            'status' => 'success',
            'agence' => 'false',
            'agence_data' => '',
            'agence_post' => '',
            'message' => 'Nothing to show.'
        ];
        echo json_encode($response);
        die();
    }


    $agence_post = $wpdb->get_results( "SELECT ID, menu_order, post_date, post_title, post_status FROM $wpdb->posts WHERE post_status='publish' AND ID=". $agence[0]->agence_id  );
    $agence_post[0]->url = get_permalink($agence_post[0]->ID);

    $dir = get_posts(array(
        'post_type' => 'agence-member',
        'orderby' => 'id',
        'order' => 'asc',
        'posts_per_page' => -1,
        'meta_key' => 'position',
        'meta_value' => array('Directrice', 'Directeur'),
        'meta_query' => array(
            array(
                'key' => 'agence', // name of custom field
                'value' => '"' . $agence_post[0]->ID . '"', // matches exactly "123", not just 123. This prevents a match for "1234"
                'compare' => 'LIKE'
            )
        )
    ));



    if ( $agence ) {
        $response = [
            'status' => 'success',
            'agence' => 'true',
            'agence_data' => $agence,
            'agence_post' => $agence_post[0],
            'agence_url' => get_permalink($agence_post[0]->ID),
            'data' => array (
                'latitude' => get_field('latitude', $agence_post[0]->ID),
                'longitude' => get_field('longitude', $agence_post[0]->ID),
                'phone' => get_field('phone', $agence_post[0]->ID),
                'phone_formatted' => str_replace(' ', '', get_field('phone', $agence_post[0]->ID)),
                'email' => get_field('email', $agence_post[0]->ID),
                'director' => array (
                    'position' => get_field('position', $dir[0]->ID),
                    'name' => $dir[0]->post_title
                )
            ),
            'message' => "Vous serez contacté par l'Agence Amelis de ".$agence_post[0]->post_title.'.'
        ];

        if ( $agence_post[0]->ID == 17 || $agence_post[0]->ID == 93 ) {
            $response['message'] = "Vous serez contacté par l'Agence Amelis d'".$agence_post[0]->post_title.'.';
        } else if ( $agence_post[0]->ID == 97 ) {
            $response['message'] = "Vous serez contacté par l'Agence Amelis du ".str_replace('Le ', '', $agence_post[0]->post_title).'.';
        }
    }
    else {
        $response = [
            'status' => 'success',
            'agence' => 'false',
            'agence_data' => '',
            'agence_post' => '',
            'message' => 'Nothing to show.'
        ];
    }
    echo json_encode($response);
    die();
}

add_action('wp_ajax_getAgenceByPostalCode', 'getAgenceByPostalCode');
add_action('wp_ajax_nopriv_getAgenceByPostalCode', 'getAgenceByPostalCode');