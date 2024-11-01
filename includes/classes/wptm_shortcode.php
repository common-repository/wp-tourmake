<?php

namespace WPTourmake;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class wptm_shortcode
{
	public static function wptm_add_shortcodes(){
		add_shortcode('tourmake', array( __CLASS__, 'wptm_tourmake_shortcode'));
		add_shortcode('viewmake', array( __CLASS__, 'wptm_viewmake_shortcode'));
	}

	//tourmake shortcode callback
	public static function wptm_tourmake_shortcode($atts)
	{
		shortcode_atts( array(
			'code' => '',
		), $atts, 'tourmake' );

		$tour = Wptm_tm_functions::wptm_find_tourmake($atts['code']);

		if ($tour){

		    $pov_info = '';
		    if($tour->pov_heading != null){
		        $pov_info.='data-heading = "'.$tour->pov_heading.'" ';
            }
            if($tour->pov_pitch != null){
                $pov_info.='data-pitch = "'.$tour->pov_pitch.'" ';
            }
            if($tour->pov_zoom != null){
                $pov_info.='data-zoom = "'.$tour->pov_zoom.'" ';
            }
            if($tour->pov_pano != null){
                $pov_info.='data-pano = "'.$tour->pov_pano.'" ';
            }

			$information = '<div class="wptm-tour-wrapper">
                        <div id="wptm-tour-container" class="wptm-tour-container" 
                        data-id="'.$tour->idembed.'" 
                        data-locale="'.$tour->lang.'" 
                        data-fullscreen="'.$tour->fullscreen.'" 
                        data-scroll="'.$tour->zoom.'"
                        '.$pov_info.'
                        style="height: '.$tour->height.'px; width: '.$tour->width.'px;"></div>
                    </div>';
		}else{
			$information = Wptm_tm_functions::wptm_tm_not_found_template();
		}

		return $information;
	}

	//viewmake shortcode callback
	public static function wptm_viewmake_shortcode($atts)
	{
		shortcode_atts( array(
			'code' => '0',
		), $atts, 'viewmake' );

		$tour = Wptm_vm_functions::wptm_find_viewmake($atts['code']);
		$scroll = '';
		$fullscreen = '';
		if ($tour){
			if($tour->zoom) {
				$scroll = '?scroll=0';
			}

			if ($tour->fullscreen) {
				$fullscreen = 'allowfullscreen';
			}

			$information = '<div class="wptm-vm-container" style="height: '.$tour->height.'px; width: '.$tour->width.'px;">
	                    <iframe src="'.$tour->link.$scroll.'" '.$fullscreen.' style="height: '.$tour->height.'px; width: '.$tour->width.'px;"></iframe>
                    </div>';
		}else{
			$information = Wptm_vm_functions::wptm_vm_not_found_template();
		}

		return $information;
	}
}