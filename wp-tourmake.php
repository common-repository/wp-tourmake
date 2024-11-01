<?php
/*
Plugin Name: WP Tourmake
Plugin URI: https://wordpress.org/plugins/wp-tourmake
Description: WP Tourmake plugin generates shortcodes to add Tourmake's and Viewmake's virtual tours in your website pages.
Version: 1.0.1
Author: Tourmake
Author URI: http://www.tourmake.it
License: GPLv2 or later
*/

if ( ! defined( 'ABSPATH' ) ) exit;

function wptm_load(){
    load_plugin_textdomain( 'wp-tourmake', false, dirname( plugin_basename(__FILE__) ) . '/languages');

    require( __DIR__ . '/class_wp_tourmake.php' );
}
add_action( 'plugins_loaded', 'wptm_load' );

include_once __DIR__ . '/includes/admin/setup_db.php';
register_activation_hook( __FILE__, 'wptm_db_tables'); //set db tables