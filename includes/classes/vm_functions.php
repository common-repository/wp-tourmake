<?php

namespace WPTourmake;

if ( ! defined( 'ABSPATH' ) ) exit;

class Wptm_vm_functions
{
    public static function wptm_generate_viewmake_shortcode($code)
    {
        return '[viewmake code='.$code.']';
    }

    //insert vievamake callback function
    public static function wptm_save_viewmake(){
	    $name = sanitize_text_field($_POST['tour_name']);
	    $link = sanitize_text_field($_POST['link']);
	    $zoom = isset($_POST['zoom_lock']);
	    $full = isset($_POST['fullscreen']);
	    $height = filter_var($_POST['height'], FILTER_SANITIZE_NUMBER_INT);
	    $width = filter_var($_POST['width'], FILTER_SANITIZE_NUMBER_INT);
	    $code = strtolower(str_replace(array(' ', ',', '.', '-'), '_', $name));

	    if(filter_var(trim($link),FILTER_VALIDATE_URL)) {
		    $tour_id = self::wptm_get_vm_idembed( $link );
		    if ( $tour_id != false ) {
			    if ( is_null( self::wptm_find_viewmake( $code ) ) ) {
				    $preview = self::wptm_get_vm_preview_api( $tour_id );
				    $lang = self::wptm_get_viewmake_language($link);
				    if ( self::wptm_insert_viewmake( $tour_id, $link, $name, $code, $height, $width, $zoom, $full, $preview, $lang ) ) {
					    $shortcode = self::wptm_generate_viewmake_shortcode( $code );
					    Wptm_general_functions::wptm_print_success_message( esc_html__( 'Insert completed!', 'wp-tourmake' ) );
					    Wptm_general_functions::wptm_print_info_message( $shortcode );
				    } else {
					    Wptm_general_functions::wptm_print_error_message( esc_html__( 'Insert failed!', 'wp-tourmake' ) );
				    }
			    } else {
				    Wptm_general_functions::wptm_print_error_message( esc_html__( 'This name is already in use. Try another one!', 'wp-tourmake' ) );
			    }
		    } else {
			    Wptm_general_functions::wptm_print_error_message( esc_html__( 'Link not valid!', 'wp-tourmake' ) );
		    }
	    }else {
		    Wptm_general_functions::wptm_print_error_message( esc_html__( 'Link not valid!', 'wp-tourmake' ) );
	    }
    }

    //insert viewmake record db
    public static function wptm_insert_viewmake($idembed, $link, $name, $code, $height = 500, $width = 700, $zoom = 0, $full = 0, $preview, $lang)
    {
        global $wpdb;
        global $current_user;

        wp_get_current_user();
        $author = $current_user->user_login;

        $date = date('Y-m-d');

        $table_name = $wpdb->prefix . "viewmake";

        $data = array(
        	'idembed' => $idembed,
	        'link' => $link,
	        'name' => $name,
	        'code' => $code,
	        'date' => $date,
	        'author' => $author,
	        'height' => $height,
	        'width' => $width,
	        'zoom' => $zoom,
	        'fullscreen' => $full,
	        'preview' => $preview,
	        'lang' => $lang
        );

        if(!$wpdb->insert($table_name, $data))
        {
            return false;
        }
        return true;
    }

    //edit viewmake callback function
    public static function wptm_update_viewmake($tour){
	    $name = sanitize_text_field($_POST['tour_name']);
	    $zoom = isset($_POST['zoom_lock']);
	    $full = isset($_POST['fullscreen']);
	    $height = filter_var($_POST['height'], FILTER_SANITIZE_NUMBER_INT);
	    $width = filter_var($_POST['width'], FILTER_SANITIZE_NUMBER_INT);
	    $code = strtolower(str_replace(array(' ', ',', '.', '-'), '_', $name));

	    if ($code != $tour->code){
		    if( is_null(self::wptm_find_viewmake($code)) ){
			    if (self::wptm_edit_viewmake($tour->id, $name, $code, $height, $width, $zoom, $full)){
				    $shortcode = self::wptm_generate_viewmake_shortcode($code);
				    Wptm_general_functions::wptm_print_success_message( esc_html__('Changes saved!', 'wp-tourmake'));
				    Wptm_general_functions::wptm_print_info_message($shortcode);
			    }else{
				    Wptm_general_functions::wptm_print_error_message( esc_html__('Error during saving changes!', 'wp-tourmake'));
			    }
		    }else{
			    Wptm_general_functions::wptm_print_error_message( esc_html__('This name is already in use. Try another one!', 'wp-tourmake'));
		    }
	    }else{
		    if (self::wptm_edit_viewmake($tour->id, $name, $code, $height, $width, $zoom, $full)){
			    $shortcode = self::wptm_generate_viewmake_shortcode($code);
			    Wptm_general_functions::wptm_print_success_message( esc_html__('Changes saved!', 'wp-tourmake'));
			    Wptm_general_functions::wptm_print_info_message($shortcode);
		    }else{
			    Wptm_general_functions::wptm_print_error_message( esc_html__('Error during saving changes!', 'wp-tourmake'));
		    }
	    }
    }

    //update viewmake record db
    public static function wptm_edit_viewmake($id, $name, $code, $height, $width, $zoom, $full){
        global $wpdb;

        $table_name = $wpdb->prefix . "viewmake";

        $data = array(
        	'name' => $name,
	        'code' => $code,
	        'height' => $height,
	        'width' => $width,
	        'zoom' => $zoom,
	        'fullscreen' => $full
        );

        $where = array(
        	'id' => $id
        );

        if(!$wpdb->update($table_name, $data, $where)){
            return false;
        }
        return true;
    }

    //find viewmake record by code
    public static function wptm_find_viewmake($code){
        global $wpdb;

        $query = "SELECT * FROM {$wpdb->prefix}viewmake WHERE code = '{$code}'";
        $results = $wpdb->get_results($query);

        if (!$results){
        	return null;
        }else{
	        return $results[0];
        }
    }

	//find viewmake record by id
    public static function wptm_find_viewmake_by_id($id){
        global $wpdb;

        $query = "SELECT * FROM {$wpdb->prefix}viewmake WHERE id = '{$id}'";
        $results = $wpdb->get_results($query);

        return $results[0];
    }

	//delete viewmake record
    public static function wptm_remove_viewmake($id)
    {
        global $wpdb;

        $table_name = $wpdb->prefix . "viewmake";

        $where = array(
        	'id' => $id
        );

        $delete = $wpdb->delete($table_name, $where);
        return $delete;
    }

	//get all viewmake records
    public static function wptm_get_all_viewmake()
    {
        global $wpdb;
	    $wp_viewmake_table = $wpdb->prefix . 'viewmake';

	    $check_query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
			 WHERE table_name = '{$wp_viewmake_table}'
             AND table_schema = 'wordpress'
             AND column_name LIKE 'sync'";
	    $row = $wpdb->get_results($check_query);

	    if(!empty($row)){
		    if (isset($_GET['orderby'])){
			    $query = "SELECT * FROM {$wpdb->prefix}viewmake WHERE sync IS NULL ORDER BY ".$_GET['orderby']." ".$_GET['order'];
		    }else{
			    $query = "SELECT * FROM {$wpdb->prefix}viewmake WHERE sync IS NULL;";
		    }
	    }else{
		    if (isset($_GET['orderby'])){
			    $query = "SELECT * FROM {$wpdb->prefix}viewmake ORDER BY ".$_GET['orderby']." ".$_GET['order'];
		    }else{
			    $query = "SELECT * FROM {$wpdb->prefix}viewmake;";
		    }
	    }

        $results = $wpdb->get_results($query);
        return $results;
    }

	//check viewmake domain
    private static function wptm_check_vm_domain_name ($url){
        $data = parse_url($url);
        $host = $data['host'];
        $hostname = explode(".", $host);
        $domain = $hostname[count($hostname) - 2] . "." . $hostname[count($hostname) - 1];

        if (strpos($domain, 'viewmake') === false) {
            return false;
        }
        return true;
    }

	//get viewmake idembed
    public static function wptm_get_vm_idembed($url){
        $data = parse_url($url);
        $path = $data['path'];

        $check = self::wptm_check_vm_domain_name($url);
        if(!$check){
            $id_embed = false;
        }else { //id embed
            $path_sections = explode('/', $path);
            $id_embed = $path_sections[count($path_sections) - 1];
        }
        return $id_embed;
    }

	public static function wptm_vm_not_found_template(){
		return '<div class="wptm-empty-vm"><img src="'.plugins_url('/includes/images/logo_viewmake.png', dirname(__DIR__)).'"></div>';
	}

	//get viewmake preview
	public static function wptm_get_vm_preview_api($idEmbed){
		$url = "http://www.tourmake.it/it/tour/api/viewmake.json?ie=".$idEmbed;
		$args = array(
			'headers' => array(
				'Content-type' => 'application/json'
			)
		);
		$result = wp_remote_get($url, $args);
		$vm_details = json_decode($result['body'], true);
		return $vm_details['thumbnailUrl'];
	}

	public static function wptm_get_viewmake_language($link){
		$data = parse_url($link);
		$path = $data['path'];
		$path_sections = explode('/', $path);
		$lang = $path_sections[count($path_sections) - 3];
		return $lang;
	}
}