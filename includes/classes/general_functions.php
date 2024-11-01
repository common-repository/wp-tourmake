<?php

namespace WPTourmake;

if ( ! defined( 'ABSPATH' ) ) exit;

class Wptm_general_functions
{
    //order records
    public static function wptm_toggle_order()
    {
	    if (isset($_GET['order'])){
		    $order = $_GET['order'];
		    if ($order === 'desc') {
			    return 'asc';
		    } else {
			    return 'desc';
		    }
	    }else{
		    return 'desc';
	    }
    }

    public static function wptm_get_complete_admin_url(){
        return admin_url().'admin.php?';
    }


    //messages
    public static function wptm_print_error_message ($message)
    {
        ?>
        <div id="setting-error-settings-updated" class="notice-error notice is-dismissible"><p><?php echo $message; ?></p></div>
        <?php
    }

    public static function wptm_print_success_message ($message)
    {
        ?>
        <div id="setting-error-settings-updated" class="notice-success notice is-dismissible"><p><?php echo $message; ?></p></div>
        <?php
    }

    public static function wptm_print_info_message ($message)
    {
        ?>
        <div id="shortcode" class="notice-info notice is-dismissible"><p><?php echo $message; ?></p></div>
        <?php
    }
}