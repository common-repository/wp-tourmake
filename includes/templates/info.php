<?php
if ( ! defined( 'ABSPATH' ) ) exit;

//plugin main page
function wptm_info(){
    ?>
    <div class="wrap">
        <div class="row">
            <h1 class="wptm-info-title"><?php _e('WP Tourmake', 'wp-tourmake'); ?></h1>
        </div>
        <div class="wptm-wrapper">
            <div class="thanks">
                <div class="wptm-note">
                    <i class="dashicons dashicons-format-quote" aria-hidden="true"></i>
                    <p>
					    <?php _e('Thank you for using our plugin! From today, integrating virtual tours created with Tourmake and Viewmake on WordPress sites will be easier and more practical. For any report, request for information or problems encountered, do not hesitate to contact us by writing to wordpress@tourmake.it', 'wp-tourmake'); ?>
                        <span class="author"><?php _e('Tourmake', 'wp-tourmake'); ?></span>
                    </p>
                </div>
            </div>
            <div class="wptm-box wptm-pro">
                <div class="wptm-box-title">
                    <i class="fa fa-star-o" aria-hidden="true"></i><?php _e('Pro Version', 'wp-tourmake'); ?>

                </div>
                <div class="wptm-box-content">
                    <p><?php _e('<b>WP Tourmake Pro</b> gives you the opportunity to enrich your website\'s pages with <b>Tourmake hotspots</b> and to create a <b>gallery</b> with your Viewmakes.', 'wp-tourmake'); ?></p>
                    <p><?php _e('The display of the hotspots is fully customizable according to the style that best suits your website and it\'s responsive, to adapt to mobile devices like tablets and smartphones.', 'wp-tourmake'); ?></p>
                    <p><?php _e('WP Tourmake Pro gives you the option to <b>enable/disable</b> the display of the hotspots related to your virtual tour: in this way you will be able to better illustrate to visitors the products and services you offer!', 'wp-tourmake'); ?></p>
                    <p class="wptm-usage-title"><?php _e('Shortcodes', 'wp-tourmake'); ?></p>
                    <div class="wptm-shortcode">
                        <span class="wptm-shortcode-syntax">[tm_hotspots code=myhotspots]</span>
                        <div class="wptm-example-pro-grid">
                            <div class="wptm-shortcode-example-pro">
                                <img src="<?php echo plugins_url('/includes/assets/images/hotspot_list.jpg', dirname(__DIR__)); ?>">
                            </div>
                            <div class="wptm-shortcode-example-pro">
                                <img src="<?php echo plugins_url('/includes/assets/images/hotspot_grid.jpg', dirname(__DIR__)); ?>">
                            </div>
                            <div class="wptm-shortcode-example-pro">
                                <img src="<?php echo plugins_url('/includes/assets/images/hotspot_carousel.jpg', dirname(__DIR__)); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="wptm-shortcode">
                        <span class="wptm-shortcode-syntax">[viewmake_gallery code=mygallery]</span>
                        <div class="wptm-example-pro-grid">
                            <div class="wptm-shortcode-example-pro">
                                <img src="<?php echo plugins_url('/includes/assets/images/vm_gallery.jpg', dirname(__DIR__)); ?>">
                            </div>
                            <div class="wptm-shortcode-example-pro">
                                <img src="<?php echo plugins_url('/includes/assets/images/vm_gallery1.jpg', dirname(__DIR__)); ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wptm-box info">
                <div class="wptm-box-title">
                    <i class="fa fa-question-circle" aria-hidden="true"></i><?php _e('What is WP Tourmake?', 'wp-tourmake'); ?>
                </div>
                <div class="wptm-box-content">
                    <p><?php _e('<b>WP Tourmake</b> generates shortcodes that allow you to quickly and easily add your <b>Tourmake</b>\'s and <b>Viewmake</b>\'s virtual tours to your website pages.', 'wp-tourmake'); ?></p>
                </div>
            </div>
            <div class="wptm-box wptm-usage">
                <div class="wptm-box-title">
                    <i class="fa fa-cogs" aria-hidden="true"></i><?php _e('Tutorial', 'wp-tourmake'); ?>
                </div>
                <div class="wptm-box-content">
                    <p style="line-height: 1.8; margin: 8px 0 0;">
				        <?php _e('Go to the admin menu <span class="wptm-menu-tag"> WP Tourmake<b> > </b>My tours</span> and click <span class="wptm-add-new-action">Add new</span>.', 'wp-tourmake'); ?><br>
                    </p>
                    <p style="margin-top: 0;">
				        <?php _e('Fill the <b>form</b> with tour informations and customizations and save settings to create the shortcode. All your shortcodes will soon appear in the table.<br>Now you just have to <b>copy and paste</b> shortcodes on your pages!', 'wp-tourmake'); ?>
                    </p>
                    <p class="wptm-usage-title"><?php _e('Shortcodes', 'wp-tourmake'); ?></p>
                    <div class="wptm-shortcode">
                        <span class="wptm-shortcode-syntax">[tourmake code=mytourmake]</span>
                        <div class="wptm-shortcode-example">
                            <img src="<?php echo plugins_url('/includes/assets/images/tourmake.jpg', dirname(__DIR__)); ?>">
                        </div>
                    </div>
                    <div class="wptm-shortcode">
                        <span class="wptm-shortcode-syntax">[viewmake code=myviewmake]</span>
                        <div class="wptm-shortcode-example">
                            <img src="<?php echo plugins_url('/includes/assets/images/viewmake.jpg', dirname(__DIR__)); ?>">
                        </div>
                    </div>
                    <p class="wptm-usage-title"><?php _e('Parameters', 'wp-tourmake'); ?></p>
                    <div class="wptm-parameters">
                        <span class='wptm-code'>code</span>
                        <p class="wptm-code-desc">
					        <?php _e('This is a <b>required parameter</b> that is automatically populated starting from the name that will be inserted in the form. There can not be two modules of the same type with the same name.', 'wp-tourmake'); ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
}