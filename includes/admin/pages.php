<?php

if ( ! defined( 'ABSPATH' ) ) exit;

require_once dirname(__DIR__ ).'/templates/tour-form.php';
require_once dirname(__DIR__ ).'/templates/info.php';
require_once dirname(__DIR__ ).'/templates/tables.php';

use WPTourmake\Wptm_general_functions;
use WPTourmake\Wptm_vm_functions;
use WPTourmake\Wptm_tm_functions;

function wptm_main_page(){
    wptm_info();
}

//pro version redirect
function wptm_redirect(){
	if ( empty( $_GET['page'] ) ) {
		return;
	}

	if ( 'wp-tourmake-pro-page' === $_GET['page'] ) {
		wp_redirect( 'https://wp.tourmake.it/wp-tourmake-pro/' );
		die;
	}
}

//tour list page
function wptm_tour_list()
{
	$tab = filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_SPECIAL_CHARS);
    //set active tab
	$active_tab = "tourmake";
	if($tab) {
		if($tab == "viewmake") {
			$active_tab = "viewmake";
		} else {
			$active_tab = "tourmake";
		}
	}

	//delete from list
	if(array_key_exists('apply', $_POST)) {
		if($_POST['action'] == 'delete-selected') {
			foreach ($_POST['tour'] as $delete_tour_id) {
			    $id = sanitize_key($delete_tour_id);
				if($tab == 'viewmake'){
					$deleted = Wptm_vm_functions::wptm_remove_viewmake($id);
				}else{
					$deleted = Wptm_tm_functions::wptm_remove_tourmake($id);
				}

			}
			if($deleted) {
				Wptm_general_functions::wptm_print_success_message(esc_html__('Deleted!', 'wp-tourmake'));
			} else {
				Wptm_general_functions::wptm_print_error_message(esc_html__('Error during deleting. Try again!', 'wp-tourmake'));
			}
		}
	}
	?>

    <div class="wrap">
        <h1 class="wptm-title"><?php echo esc_html__( 'My tours', 'wp-tourmake' )?></h1>
		<?php
		wptm_display_tabs($active_tab);
		if ($active_tab == 'tourmake'){
			$results = Wptm_tm_functions::wptm_get_all_tourmake();
			wptm_render_tour_table($results, $active_tab);
		}else if ($active_tab == 'viewmake'){
			$results = Wptm_vm_functions::wptm_get_all_viewmake();
			wptm_render_tour_table($results, $active_tab);
		}
		?>
    </div>
	<?php
}

//insert page
function wptm_insert_page() {
	$tour_type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_SPECIAL_CHARS);

	//insert result
	if(array_key_exists('insert_tour',$_POST)) {
		if ($tour_type == 'tourmake'){
			Wptm_tm_functions::wptm_save_tourmake();
		}else{
			Wptm_vm_functions::wptm_save_viewmake();
		}
	}

	?>
    <div class="wrap">
        <h1 class="wp-heading-inline"><?php _e('Insert tour', 'wp-tourmake'); ?></h1>
		<?php
		    wptm_render_tour_form();
		?>
    </div>
	<?php
}

//edit page
function wptm_edit_page()
{
	$tour_type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_SPECIAL_CHARS);
	$id = filter_input(INPUT_GET, 'tour', FILTER_SANITIZE_SPECIAL_CHARS);

	//edit results
	if (array_key_exists('edit_tour', $_POST)) {
		$tour_id = sanitize_key($_POST['tour_id']);
		if ( $tour_type == 'tourmake' ) {
			$tour = Wptm_tm_functions::wptm_find_tourmake_by_id( $tour_id );
			Wptm_tm_functions::wptm_update_tourmake( $tour );
		} else {
			$tour = Wptm_vm_functions::wptm_find_viewmake_by_id( $tour_id );
			Wptm_vm_functions::wptm_update_viewmake( $tour );
		}
	}

    if ($tour_type == 'tourmake'){
        $tour = Wptm_tm_functions::wptm_find_tourmake_by_id($id);
    }else{
        $tour = Wptm_vm_functions::wptm_find_viewmake_by_id($id);
    }

    ?>
        <div class="wrap">
            <h1 class="wp-heading-inline"><?php _e('Edit tour', 'wp-tourmake'); ?></h1>
            <?php
                wptm_render_edit_tour_form($tour);
            ?>
        </div>
    <?php
}