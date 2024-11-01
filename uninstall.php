<?php
if ( ! defined( 'ABSPATH' ) ) exit;

	if (!defined('WP_UNINSTALL_PLUGIN')) {
		die;
	}

	global $wpdb;
	$wp_tm_table = $wpdb->prefix . 'tourmake';
	$wp_vm_table = $wpdb->prefix . 'viewmake';

	$sql = "DROP TABLE IF EXISTS $wp_tm_table";
	$wpdb->query($sql);

	$sql = "DROP TABLE IF EXISTS $wp_vm_table";
	$wpdb->query($sql);

	add_shortcode('tourmake', '__return_false');
	add_shortcode('viewmake', '__return_false');