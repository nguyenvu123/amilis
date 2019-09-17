<?php

// Create new table if it doesn't exist
global $wpdb;
$charset_collate = $wpdb->get_charset_collate();

// $table_name = $wpdb->prefix . 'cities';

// if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) {

//     $sql = "CREATE TABLE $table_name (
//         id mediumint(9) NOT NULL AUTO_INCREMENT,
//         department_code mediumint(5) NOT NULL,
//         insee_code mediumint(5) NOT NULL,
//         zip_code mediumint(5) NOT NULL,
//         name text DEFAULT '' NOT NULL,
//         slug text DEFAULT '' NOT NULL,
//         gps_lat float(12,8) NOT NULL,
//         gps_lng float(12,8) NOT NULL,
//         multi boolean DEFAULT '0' NOT NULL,
//         PRIMARY KEY  (id)
//     ) $charset_collate;";

//     require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
//     dbDelta( $sql );
    
// }


// Table that store TO DO
// $table_name = $wpdb->prefix . 'agences_codes';

// if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) {

//     $sql = "CREATE TABLE $table_name (
//         id mediumint(9) NOT NULL AUTO_INCREMENT,
//         zip_code mediumint(5) NOT NULL,
//         town text DEFAULT '' NOT NULL,
//         agence text DEFAULT '' NOT NULL,
//         agence_id mediumint(9) NOT NULL,
//         gps_lat float(12,8) NOT NULL,
//         gps_lng float(12,8) NOT NULL,
//         PRIMARY KEY  (id)
//     ) $charset_collate;";

//     require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
//     dbDelta( $sql );
    
// }