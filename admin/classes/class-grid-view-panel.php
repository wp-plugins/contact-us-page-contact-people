<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * People Contact Grid View Panel
 *
 * Table Of Contents
 *
 * panel_manager()
 */
class People_Contact_Grid_View_Panel
{
	
	public static function panel_manager() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			$message = '<div class="updated" id=""><p>'.__('Grid View Settings Successfully saved.', 'cup_cp').'</p></div>';
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			$message = '<div class="updated" id=""><p>'.__('Grid View Settings Successfully reseted.', 'cup_cp').'</p></div>';
		}
		
		?>
        <?php echo $message; ?>
	<form action="" method="post">
    <div id="a3_plugin_panel_container">
    	<div id="a3_plugin_panel_fields" class="a3_subsubsub_section">
        	<ul class="subsubsub">
            	<li><a href="#grid-view-layout" class="current"><?php _e('Profile Grid Layout', 'cup_cp'); ?></a> | </li>
                <li><a href="#grid-view-styles"><?php _e('Grid View Styles', 'cup_cp'); ?></a> | </li>
                <li><a href="#thumb-image-styles"><?php _e('Profile Image Style', 'cup_cp'); ?></a> | </li>
                <li><a href="#grid-view-icons"><?php _e('Grid View Contact Icons', 'cup_cp'); ?></a></li>
			</ul>
            <br class="clear">
            
            <div class="section" id="grid-view-layout">
            	<?php People_Contact_Grid_View_Layout_Panel::panel_page(); ?>
            </div>
            <div class="section" id="grid-view-styles">
            	<div class="pro_feature_fields">
            	<?php People_Contact_Grid_View_Style_Panel::panel_page(); ?>
                </div>
            </div>
            <div class="section" id="thumb-image-styles">
            	<div class="pro_feature_fields">
            	<?php People_Contact_Grid_View_Image_Style_Panel::panel_page(); ?>
                </div>
            </div>
            <div class="section" id="grid-view-icons">
            	<div class="pro_feature_fields">
            	<?php People_Contact_Grid_View_Icon_Panel::panel_page(); ?>
                </div>
            </div>
		</div>
        <div id="a3_plugin_panel_upgrade_area"><?php echo People_Contact_Functions::plugin_pro_notice(); ?></div>
    </div>
    <div style="clear:both;"></div>
    		<p class="submit">
                <input type="submit" value="<?php _e('Save changes', 'cup_cp'); ?>" class="button-primary" name="bt_save_settings" id="bt_save_settings">
				<input type="submit" name="bt_reset_settings" id="bt_reset_settings" class="button" value="<?php _e('Reset Settings', 'cup_cp'); ?>"  />
        		<input type="hidden" id="last_tab" name="subtab" />
            </p>
    </form>
	<?php
	}
}
?>