<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * People Contact Page Panel
 *
 * Table Of Contents
 *
 * panel_manager()
 */
class People_Contact_Page_Panel
{
	
	public static function panel_manager() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			$message = '<div class="updated" id=""><p>'.__('Contact Page Successfully saved.', 'cup_cp').'</p></div>';
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			$message = '<div class="updated" id=""><p>'.__('Contact Page Successfully reseted.', 'cup_cp').'</p></div>';
		}
		
		?>
        <?php echo $message; ?>
	<form action="" method="post">
    <div id="a3_plugin_panel_container">
    	<div id="a3_plugin_panel_fields" class="a3_subsubsub_section">
        	<ul class="subsubsub">
            	<li><a href="#contact-page-settings" class="current"><?php _e('Settings', 'cup_cp'); ?></a> | </li>
                <li><a href="#contact-page-location-map"><?php _e('Location Map', 'cup_cp'); ?></a> | </li>
                <li><a href="#contact-page-contact-forms"><?php _e('People Contact Forms', 'cup_cp'); ?></a> | </li>
                <li><a href="#contact-popup-style"><?php _e('Contact Pop-Up Style', 'cup_cp'); ?></a></li>
			</ul>
            <br class="clear">
            
            <div class="section" id="contact-page-settings">
            	<?php People_Contact_Page_Settings_Panel::panel_page(); ?>
            </div>
            <div class="section" id="contact-page-location-map">
            	<?php People_Contact_Page_Location_Map_Panel::panel_page(); ?>
            </div>
            <div class="section" id="contact-page-contact-forms">
            	<div class="pro_feature_fields">
            	<?php People_Contact_Page_Contact_Forms_Panel::panel_page(); ?>
                </div>
            </div>
            <div class="section" id="contact-popup-style">
            	<div class="pro_feature_fields">
            	<?php People_Contact_Popup_Style_Panel::panel_page(); ?>
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