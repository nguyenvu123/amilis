<?php


function getAllAgences() {
    $args = array(
        'post_type'  => 'agence',
        'numberposts' => -1,
        'order' => 'ASC',
        'orderby' => 'title',
        'post_parent' => 0

    );
    $agences = get_posts( $args );
    return $agences;
}



function showJobPositions() {
    $jobs = array(
        '1' => 'Responsable secteur / Coordinateur h/f',
        '2' => 'Gestionnaire recrutement et planning h/f',
        '3' => 'Responsable opérations planning h/f',
        '4' => 'Directeur d’agence h/f',
        '5' => 'Fonctions support siège h/f',
        '6' => 'Stage ou Alternance h/f'
    );
    return $jobs;
}