<?php

namespace WPTourmake;

if ( ! defined( 'ABSPATH' ) ) exit;

class Wptm_tm_functions
{
    public static function wptm_generate_tourmake_shortcode($code)
    {
        return '[tourmake code='.$code.']';
    }

    //insert tourmake callback function
    public static function wptm_save_tourmake(){
	    $name = sanitize_text_field($_POST['tour_name']);
	    $link = sanitize_text_field($_POST['link']);
	    $zoom = isset($_POST['zoom_lock']);
	    $full = isset($_POST['fullscreen']);
	    $height = filter_var($_POST['height'], FILTER_SANITIZE_NUMBER_INT);
	    $width = filter_var($_POST['width'], FILTER_SANITIZE_NUMBER_INT);
	    $code = strtolower(str_replace(array(' ', ',', '.', '-'), '_', $name));

	    if(filter_var(trim($link),FILTER_VALIDATE_URL)) {
		    $check = self::wptm_get_tm_idembed( $link );
		    if ( $check != false ) {
			    if ( is_null( self::wptm_find_tourmake( $code ) ) ) {
			    	$tour_id = $check['idembed'];
			    	$lang = $check['lang'];
			    	$startingPov = $check['startingPosition'];
				    if ( self::wptm_insert_tourmake( $tour_id, $link, $name, $code, $height, $width, $zoom, $full, $lang, $startingPov ) ) {
					    $shortcode = self::wptm_generate_tourmake_shortcode( $code );
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

	//insert tourmake record db
    public static function wptm_insert_tourmake($idembed, $link, $name, $code, $height = 500, $width = 700, $zoom = 0, $full = 0, $lang, $startingPov)
    {
        global $wpdb;
        global $current_user;

        wp_get_current_user();
        $author = $current_user->user_login;

        $date = date('Y-m-d');

        $table_name = $wpdb->prefix . "tourmake";

        $pov_pitch = null;
        $pov_heading = null;
        $pov_zoom = null;
        $pov_pano = null;

        if($startingPov != null){
            if(count($startingPov) > 0){
                if(isset($startingPov['pitch'])){
                    $pov_pitch = $startingPov['pitch'];
                }
                if(isset($startingPov['heading'])){
                    $pov_heading = $startingPov['heading'];
                }
                if(isset($startingPov['zoom'])){
                    $pov_zoom = $startingPov['zoom'];
                }
                if(isset($startingPov['pano'])){
                    $pov_pano = $startingPov['pano'];
                }
            }
        }

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
	        'lang' => $lang,
            'pov_pitch' => $pov_pitch,
            'pov_heading' => $pov_heading,
            'pov_zoom' => $pov_zoom,
            'pov_pano' => $pov_pano
        );

        if(!$wpdb->insert($table_name, $data )) {
            return false;
        }
        return true;
    }

	//edit tourmake callback function
    public static function wptm_update_tourmake($tour){
	    $name = sanitize_text_field($_POST['tour_name']);
	    $zoom = isset($_POST['zoom_lock']);
	    $full = isset($_POST['fullscreen']);
	    $height = filter_var($_POST['height'], FILTER_SANITIZE_NUMBER_INT);
	    $width = filter_var($_POST['width'], FILTER_SANITIZE_NUMBER_INT);
	    $code = strtolower(str_replace(array(' ', ',', '.', '-'), '_', $name));

	    if ($code != $tour->code){
		    if( is_null(self::wptm_find_tourmake($code)) ){
			    if(self::wptm_edit_tourmake($tour->id, $name, $code, $height, $width, $zoom, $full)){
				    $shortcode = self::wptm_generate_tourmake_shortcode($code);
				    Wptm_general_functions::wptm_print_success_message( esc_html__('Changes saved!', 'wp-tourmake'));
				    Wptm_general_functions::wptm_print_info_message($shortcode);
			    }else{
				    Wptm_general_functions::wptm_print_error_message( esc_html__('Error during saving changes!', 'wp-tourmake'));
			    }
		    }else{
			    Wptm_general_functions::wptm_print_error_message( esc_html__('This name is already in use. Try another one!', 'wp-tourmake'));
		    }
	    }else{
		    if(self::wptm_edit_tourmake($tour->id, $name, $code, $height, $width, $zoom, $full)){
			    $shortcode = self::wptm_generate_tourmake_shortcode($code);
			    Wptm_general_functions::wptm_print_success_message( esc_html__('Changes saved!', 'wp-tourmake'));
			    Wptm_general_functions::wptm_print_info_message($shortcode);
		    }else{
			    Wptm_general_functions::wptm_print_error_message( esc_html__('Error during saving changes!', 'wp-tourmake'));
		    }
	    }
    }

	//update tourmake record db
    public static function wptm_edit_tourmake($id, $name, $code, $height, $width, $zoom, $full){
        global $wpdb;

        $table_name = $wpdb->prefix . "tourmake";

        $data = array(
        	'name' => $name,
	        'code' => $code,
	        'height' => $height,
	        'width' => $width,
	        'zoom' => $zoom,
	        'fullscreen' => $full
        );

        $where =  array(
        	'id' => $id
        );

        if(!$wpdb->update($table_name, $data, $where)){
            return false;
        }
        return true;
    }

	//find tourmake record by code
    public static function wptm_find_tourmake($code){
        global $wpdb;

        $query = "SELECT * FROM {$wpdb->prefix}tourmake WHERE code = '{$code}'";
        $results = $wpdb->get_results($query);

        if (!$results){
        	return null;
        }else{
	        return $results[0];
        }
    }

	//find tourmake record by id
    public static function wptm_find_tourmake_by_id($id){
        global $wpdb;

        $query = "SELECT * FROM {$wpdb->prefix}tourmake WHERE id = '{$id}'";
        $results = $wpdb->get_results($query);

        return $results[0];
    }

	//delete tourmake record db
    public static function wptm_remove_tourmake($id)
    {
        global $wpdb;

        $table_name = $wpdb->prefix . "tourmake";

        $where = array(
        	'id' => $id
        );

        $delete = $wpdb->delete($table_name, $where);
        return $delete;
    }

	//get all tourmake records
    public static function wptm_get_all_tourmake()
    {
        global $wpdb;

        if (isset($_GET['orderby'])){
            $query = "SELECT * FROM {$wpdb->prefix}tourmake ORDER BY ".$_GET['orderby']." ".$_GET['order'];
        }else{
            $query = "SELECT * FROM {$wpdb->prefix}tourmake;";
        }
        $results = $wpdb->get_results($query);

        return $results;
    }

	//check tourmake domain
    private static function wptm_check_tm_domain_name ($url){
        $data = parse_url($url);
        $host = $data['host'];
        $hostname = explode(".", $host);
        $domain = $hostname[count($hostname) - 2] . "." . $hostname[count($hostname) - 1];

        if (strpos($domain, 'tourmake') === false && strpos($domain, 'tm3.co') === false) {
            return false;
        }
        return true;
    }

	//get tourmake idembed
    public static function wptm_get_tm_idembed($url){
        $data = parse_url($url);

        $query = explode('&', $data['query']);
        $size = sizeof($query);
        $startingPosition = array();

        for($i=0; $i<$size; $i++){
            $element = explode('=', $query[$i]);
            $startingPosition[$element[0]] = $element[1];
        }

        $hostname = explode(".", $data['host']);
        $path = $data['path'];
        $domain = $hostname[count($hostname) - 2] . "." . $hostname[count($hostname) - 1];

        $check = self::wptm_check_tm_domain_name($url);
        if(!$check){
            $id_embed = false;
        }elseif (strpos($domain, 'tm3.co') !== false) { //shortlink
            $long_url = self::wptm_get_long_url($url);
            $path = parse_url($long_url,PHP_URL_PATH);
            $path_sections = explode('/', $path);
            $id_embed = $path_sections[count($path_sections) - 1];
            $lang = $path_sections[count($path_sections) - 3];
        } elseif (strpos($domain, 'tourmake') !== false && strpos($path, '/tour') === false ){ //slug
            $slug = str_replace('/', '', $path);
            $tour_data = self::wptm_get_tm_data_api($slug);
            $id_embed = $tour_data['idEmbed'];
            $lang = 'en';
        }else { //id embed
            $path_sections = explode('/', $path);
            $id_embed = $path_sections[count($path_sections) - 1];
	        $lang = $path_sections[count($path_sections) - 3];
        }

        if (!$id_embed){
        	return false;
        }else{
	        $info = array(
		        'idembed' => $id_embed,
		        'lang' => $lang,
                'startingPosition' => $startingPosition
	        );
	        return $info;
        }
    }

    //get tourmake url from shortlink
    private static function wptm_get_long_url($shortlink){
	    $result = wp_remote_get($shortlink);
	    $response = $result['http_response']->get_response_object();
	    $long_url = $response->url;
        return $long_url;
    }

    //get tourmake data
    private static function wptm_get_tm_data_api($slug){
        $url = "https://tourmake.it/it/tour/api/tour.json?s=".$slug;
	    $args = array(
		    'headers' => array(
			    'Content-type' => 'application/json'
		    )
	    );
	    $result = wp_remote_get($url, $args);
        return json_decode($result['body'], true);
    }

	public static function wptm_tm_not_found_template(){
		return '<div class="wptm-empty-tm"><img src="'.plugins_url('/includes/images/logo_tourmake.png', dirname(__DIR__)).'"></div>';
	}
}