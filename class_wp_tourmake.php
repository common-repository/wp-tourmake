<?php

namespace WPTourmake;

if ( ! defined( 'ABSPATH' ) ) exit;

require_once __DIR__ . '/includes/admin/pages.php';
require_once __DIR__ . '/includes/classes/wptm_shortcode.php';
require_once __DIR__ . '/includes/classes/vm_functions.php';
require_once __DIR__ . '/includes/classes/tm_functions.php';
require_once __DIR__ . '/includes/classes/general_functions.php';

if (!class_exists('Class_wp_tourmake')){
	class Class_wp_tourmake
	{
		public function __construct() {
			$this->wptm_add_actions();
			wptm_shortcode::wptm_add_shortcodes();
		}

		private function wptm_add_actions() {
			if( is_admin()){
				add_action( 'admin_init', 'wptm_redirect' );
				add_action('admin_menu', [ $this, 'wptm_register_admin_pages' ],110);
				add_action('admin_enqueue_scripts', [ $this, 'wptm_admin_scripts' ] );
			}
			add_action('wp_enqueue_scripts', [ $this, 'wptm_scripts' ] );
		}

		public function wptm_scripts() {
			wp_enqueue_style( 'wp-tourmake-style',
				plugins_url( 'includes/assets/css/style.css', __FILE__ ) );
			wp_enqueue_script('jquery');
			wp_enqueue_script('tourmake-api','https://content.tourmake.it/api/tourmake-api.js', array('jquery'), '', true);
			wp_enqueue_script('tour', plugins_url('/includes/assets/js/tour.js', __FILE__), array('jquery'), '', true);
		}

		public function wptm_admin_scripts(){
			wp_enqueue_style( 'wp-tourmake-admin',
				plugins_url( 'includes/assets/css/admin.css', __FILE__ ) );
			wp_enqueue_style( 'tourmake-font',
				plugins_url( 'includes/assets/tourmake-font/css/tourmake-font.css', __FILE__ ));
			wp_enqueue_style( 'fa-icons', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
			wp_enqueue_script('admin-js', plugins_url('/includes/assets/js/admin.js', __FILE__), array('jquery'), '', true);
			wp_enqueue_script('validator-js', plugins_url('/includes/assets/js/validator/validator.js', __FILE__), array('jquery'), '', true);
			wp_enqueue_script('validator-messages-js', plugins_url('/includes/assets/js/validator/messages_it.js', __FILE__), array('jquery'), '', true);
		}

		public function wptm_register_admin_pages(){
			add_menu_page(
				__('WP Tourmake', 'wp-tourmake'),
				__('WP Tourmake', 'wp-tourmake'),
				'manage_options',
				'wp-tourmake-main-page',
				'wptm_main_page',
				plugins_url('/includes/images/tourmake_icon-16x28.png', __FILE__),
				200);
			add_submenu_page(
				'wp-tourmake-main-page',
				__('My tours', 'wp-tourmake'),
				__('My tours', 'wp-tourmake'),
				'manage_options',
				'wp-tourmake-tour-list',
				'wptm_tour_list');
			add_submenu_page(
				'',
				__('Insert tour', 'wp-tourmake'),
				__('Insert tour', 'wp-tourmake'),
				'manage_options',
				'wp-tourmake-insert-tour',
				'wptm_insert_page');
			add_submenu_page(
				'',__('Edit tour', 'wp-tourmake'),
				__('Edit tour', 'wp-tourmake'),
				'manage_options',
				'wp-tourmake-edit-tour',
				'wptm_edit_page');
			add_submenu_page(
				'wp-tourmake-main-page',
				'',
				'<span class="dashicons dashicons-star-filled" style="color: #7FFF00"></span><span style="color: #7FFF00; font-weight: bold;"> '. __('Go Pro', 'wp-tourmake').'</span>',
				'manage_options',
				'wp-tourmake-pro-page',
				'wptm_redirect');
		}
	}
}

new Class_wp_tourmake();