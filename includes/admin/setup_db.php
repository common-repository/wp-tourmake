<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function wptm_db_tables() {
    global $wpdb;

    $wp_tm_table = $wpdb->prefix . 'tourmake';
	$wp_vm_table = $wpdb->prefix . 'viewmake';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $wp_tm_table(
					id INT NOT NULL auto_increment,
					idembed VARCHAR (32) NOT NULL,
				    link VARCHAR(255) NOT NULL,
				    name VARCHAR(50) NOT NULL,
				    code VARCHAR(50) NOT NULL,
				    date DATE NOT NULL,
				    author VARCHAR(30) NOT NULL,
				    height INT(4) NOT NULL,
				    width INT(4) NOT NULL,
				    zoom TINYINT(1) NOT NULL,
				    fullscreen TINYINT(1) NOT NULL,
				    lang VARCHAR(2),
				    pov_pitch FLOAT,
				    pov_heading FLOAT,
				    pov_zoom FLOAT,
				    pov_pano VARCHAR(100),
				    PRIMARY KEY  (id)
				    ) $charset_collate;";

    require_once(ABSPATH . '/wp-admin/includes/upgrade.php');
    dbDelta($sql);

	$sql = "CREATE TABLE IF NOT EXISTS $wp_vm_table(
					id INT NOT NULL auto_increment,
					idembed VARCHAR (32) NOT NULL,
				    link VARCHAR(255) NOT NULL,
				    name VARCHAR(60) NOT NULL,
				    code VARCHAR(70) NOT NULL,
				    date DATE NOT NULL,
				    author VARCHAR(30) NOT NULL,
				    height INT(4) NOT NULL,
				    width INT(4) NOT NULL,
				    zoom TINYINT(1) NOT NULL,
				    fullscreen TINYINT(1) NOT NULL,
				    preview VARCHAR(255),
				    lang VARCHAR(2),
				    PRIMARY KEY  (id)
				    ) $charset_collate;";
	require_once(ABSPATH . '/wp-admin/includes/upgrade.php');
	dbDelta($sql);
}