<?php

if ( ! defined( 'ABSPATH' ) ) exit;

use WPTourmake\Wptm_tm_functions;
use WPTourmake\Wptm_vm_functions;
use WPTourmake\Wptm_general_functions;

    //tab navigation
    function wptm_display_tabs($active_tab){
        ?>
        <h2 class="nav-tab-wrapper">
            <a href="?page=wp-tourmake-tour-list&tab=tourmake" class="nav-tab <?php if($active_tab == 'tourmake'){echo 'nav-tab-active';} ?> ">
                <h2 class="wptm-tab-title"><?php _e('Tourmake', 'wp-tourmake'); ?></h2>
            </a>
            <a href="?page=wp-tourmake-tour-list&tab=viewmake" class="nav-tab <?php if($active_tab == 'viewmake'){echo 'nav-tab-active';} ?>">
                <h2 class="wptm-tab-title"><?php _e('Viewmake', 'wp-tourmake'); ?></h2>
            </a>
        </h2>
        <?php
    }

    //tour table
    function wptm_render_tour_table($results, $active_tab){
        $totale = count($results);
        ?>
        <div class="wrap">
            <div class="row wptm-btn-row">
                <a href="<?php echo add_query_arg(array('page' => 'wp-tourmake-insert-tour', 'type' => $active_tab), Wptm_general_functions::wptm_get_complete_admin_url()); ?>"><button class="page-title-action wptm-button"> <?php _e('Add new', 'wp-tourmake'); ?></button></a>
            </div>
            <?php
            if ($totale == 0){
                ?>
                <div class="wptm-no-tour"><?php _e('Nothing to display.', 'wp-tourmake'); ?></div>
                <?php
            }else {
                ?>
                <ul class="subsubsub">
                    <li class="wptm-all">
                        <a class="current" aria-current="page">
                            <?php _e('All', 'wp-tourmake'); ?><span class="count">(<?php echo $totale; ?>)</span>
                        </a>
                    </li>
                </ul>
                <form method="post">
                    <div class="tablenav top">
                        <select name="action" id="bulk-action-selector-top">
                            <option value="-1"><?php _e('Bulk actions', 'wp-tourmake'); ?></option>
                            <option value="delete-selected"><?php _e('Delete', 'wp-tourmake'); ?></option>
                        </select>
                        <input type="submit" class="button action" name="apply" value="<?php _e('Apply', 'wp-tourmake'); ?>">
                    </div>
                    <table class="wptm-table widefat fixed striped">
                        <thead>
                        <tr>
                            <td id="cb" class="wptm-check-column">
                                <input type="checkbox" title="<?php _e('Select all', 'wp-tourmake'); ?>" id="cb-select-all" name="button_all">
                            </td>
                            <th scope="col" id="shortcode" class="column-date">
                                <?php _e('Shortcode', 'wp-tourmake'); ?>
                            </th>
                            <th scope="col" class="column-date"><?php _e('Tour', 'wp-tourmake'); ?></th>
                            <th scope="col" class="column-author sortable <?php echo Wptm_general_functions::wptm_toggle_order(); ?>">
                                <a href="<?php echo add_query_arg(array('page' => 'wp-tourmake-tour-list', 'tab' => $active_tab, 'orderby' => 'author', 'order' => Wptm_general_functions::wptm_toggle_order()), Wptm_general_functions::wptm_get_complete_admin_url()); ?>">
                                    <span><?php _e('Author', 'wp-tourmake'); ?></span><span class="sorting-indicator"></span>
                                </a>
                            </th>
                            <th scope="col" class="column-author sortable <?php echo Wptm_general_functions::wptm_toggle_order(); ?>">
                                <a href="<?php echo add_query_arg(array('page' => 'wp-tourmake-tour-list', 'tab' => $active_tab, 'orderby' => 'date', 'order' => Wptm_general_functions::wptm_toggle_order()), Wptm_general_functions::wptm_get_complete_admin_url()); ?>">
                                    <span><?php _e('Date', 'wp-tourmake'); ?></span><span class="sorting-indicator"></span>
                                </a>
                            </th>
                            <th scope="col" class="column-author"><?php _e('Height', 'wp-tourmake'); ?></th>
                            <th scope="col" class="column-author"><?php _e('Width', 'wp-tourmake'); ?></th>
                        </tr>
                        </thead>
                        <tbody id="the-list">
                        <?php
                        foreach ($results as $entry) {
                            ?>
                            <tr id="tour-<?php echo $entry->id; ?>">
                                <th scope="row" class="wptm-check-column">
                                    <input title="<?php _e('Select tour', 'wp-tourmake'); ?>" id="cb-select-<?php echo $entry->id; ?>" type="checkbox" name="tour[]" value="<?php echo $entry->id; ?>">
                                </th>
                                <td class="column-date">
                                    <strong>
                                        <?php
                                        if ($active_tab == 'tourmake'){
                                            echo Wptm_tm_functions::wptm_generate_tourmake_shortcode($entry->code);
                                        }else{
                                            echo Wptm_vm_functions::wptm_generate_viewmake_shortcode($entry->code);
                                        }
                                        ?>
                                    </strong>
                                    <div class="row-actions">
                                        <span class="wptm-edit">
                                            <?php
                                            if ($active_tab == 'tourmake'){
                                                ?>
                                                <a href="<?php echo add_query_arg(array('page' => 'wp-tourmake-edit-tour', 'type' => 'tourmake', 'tour' => $entry->id), Wptm_general_functions::wptm_get_complete_admin_url()); ?>"><?php _e('Edit', 'wp-tourmake'); ?></a>
                                                <?php
                                            }else{
                                                ?>
                                                <a href="<?php echo add_query_arg(array('page' => 'wp-tourmake-edit-tour', 'type' => 'viewmake', 'tour' => $entry->id), Wptm_general_functions::wptm_get_complete_admin_url()); ?>"><?php _e('Edit', 'wp-tourmake'); ?></a>
                                                <?php
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </td>
                                <td class="column-date">
                                    <strong>
                                        <a class="row-title" href="<?php echo $entry->link; ?>" target="_blank"><?php echo $entry->name; ?></a>
                                    </strong>
                                </td>
                                <td class="column-date">
                                    <?php echo $entry->author; ?>
                                </td>
                                <td class="column-author">
                                    <?php echo date('d-m-Y', strtotime($entry->date)); ?>
                                </td>
                                <td class="column-author">
                                    <?php echo $entry->height . 'px'; ?>
                                </td>
                                <td class="column-author">
                                    <?php echo $entry->width . 'px'; ?>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td id="cb" class="wptm-check-column">
                                <input type="checkbox" title="<?php _e('Select all', 'wp-tourmake'); ?>" id="cb-select-all" name="button_all">
                            </td>
                            <th scope="col" id="shortcode" class="column-date">
                                <?php _e('Shortcode', 'wp-tourmake'); ?>
                            </th>
                            <th scope="col" class="column-date"><?php _e('Tour', 'wp-tourmake'); ?></th>
                            <th scope="col" class="column-date sortable <?php echo Wptm_general_functions::wptm_toggle_order(); ?>">
                                <a href="<?php echo add_query_arg(array('page' => 'wp-tourmake-tour-list', 'tab' => $active_tab, 'orderby' => 'author', 'order' => Wptm_general_functions::wptm_toggle_order()), Wptm_general_functions::wptm_get_complete_admin_url()); ?>">
                                    <span><?php _e('Author', 'wp-tourmake'); ?></span><span class="sorting-indicator"></span>
                                </a>
                            </th>
                            <th scope="col" class="column-author sortable <?php echo Wptm_general_functions::wptm_toggle_order(); ?>">
                                <a href="<?php echo add_query_arg(array('page' => 'wp-tourmake-tour-list', 'tab' => $active_tab, 'orderby' => 'date', 'order' => Wptm_general_functions::wptm_toggle_order()), Wptm_general_functions::wptm_get_complete_admin_url()); ?>">
                                    <span><?php _e('Date', 'wp-tourmake'); ?></span><span class="sorting-indicator"></span>
                                </a>
                            </th>
                            <th scope="col" class="column-author"><?php _e('Height', 'wp-tourmake'); ?></th>
                            <th scope="col" class="column-author"><?php _e('Width', 'wp-tourmake'); ?></th>
                        </tr>
                        </tfoot>
                    </table>
                </form>
                <?php
            }
            ?>
        </div>
        <?php
    }