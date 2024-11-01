<?php
if ( ! defined( 'ABSPATH' ) ) exit;
//insert tour form
function wptm_render_tour_form(){
    ?>
        <form method="post" id="wptm_form">
            <h3 class="wptm-label"><?php _e('Tour name', 'wp-tourmake'); ?></h3>
            <input type="text" name="tour_name" value="" required>
            <h3 class="wptm-label"><?php _e('Link', 'wp-tourmake'); ?></h3>
            <input type="text" name="link" class="regular-text" value="" required placeholder="https://link.it">
            <h3 class="wptm-label"><?php _e('Zoom lock', 'wp-tourmake'); ?><input type="checkbox" name="zoom_lock" value=""></h3>
            <h3 class="wptm-label"><?php _e('Fullscreen', 'wp-tourmake'); ?><input type="checkbox" name="fullscreen" value=""></h3>
            <h3 class="wptm-label"><?php _e('Height', 'wp-tourmake'); ?></h3>
            <input type="number" name="height" min="300" value="300"> px
            <h3 class="wptm-label"><?php _e('Width', 'wp-tourmake'); ?></h3>
            <input type="number" name="width" min="400" value="400"> px
            <div>
                <input type="submit" name="insert_tour" class="submit action-button" value="<?php _e('Save', 'wp-tourmake'); ?>" />
            </div>
        </form>
    <?php
}

//edit tour form
function wptm_render_edit_tour_form($tour){
    ?>
        <form method="post" id="wptm_form">
            <h3 class="wptm-label"><?php _e('Tour name', 'wp-tourmake'); ?></h3>
            <input type="text" name="tour_name"  value="<?php echo $tour->name ?>" required>
            <h3 class="wptm-label"><?php _e('Link', 'wp-tourmake'); ?></h3>
            <input type="text" name="link" class="regular-text" value="<?php echo $tour->link ?>" disabled>
            <h3 class="wptm-label"><?php _e('Zoom lock', 'wp-tourmake'); ?><input type="checkbox" name="zoom_lock" <?php if ($tour->zoom == 1) echo 'checked'; ?> value="1"></h3>
            <h3 class="wptm-label"><?php _e('Fullscreen', 'wp-tourmake'); ?><input type="checkbox" name="fullscreen" <?php if ($tour->fullscreen == 1) echo 'checked'; ?> value="1"></h3>
            <h3 class="wptm-label"><?php _e('Height', 'wp-tourmake'); ?></h3>
            <input type="number" name="height" min="300" value="<?php if ($tour->height){ echo $tour->height; }else{ echo '300'; } ?>"> px
            <h3 class="wptm-label"><?php _e('Width', 'wp-tourmake'); ?></h3>
            <input type="number" name="width" min="400" value="<?php if ($tour->width){ echo $tour->width; }else{ echo '400'; } ?>"> px
            <input type="hidden" name="tour_id" value="<?php echo $tour->id; ?>">
            <div>
                <input type="submit" name="edit_tour" class="submit action-button" value="<?php _e('Save', 'wp-tourmake'); ?>" />
            </div>
        </form>
    <?php
}