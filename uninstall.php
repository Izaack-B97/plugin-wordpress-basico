<?php

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) exit(); // or die()

// Continuamos con las acciones que desamos 
$option_name = 'mi_opcion';
delete_option( $option_name );

global $wpdb;
$wpdb->query('DROP TABLE IF EXISTS {$wpdb->prefix}mitabla');

