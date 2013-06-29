<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * People Contact Widget Panel
 *
 * Table Of Contents
 *
 * panel_manager()
 */
class People_Contact_Widget_Panel
{
	
	public static function panel_manager() {
		$message = '';
		if (isset($_REQUEST['bt_save_settings'])) {
			$message = '<div class="updated" id=""><p>'.__('Contact Widget Successfully saved.', 'cup_cp').'</p></div>';
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			$message = '<div class="updated" id=""><p>'.__('Contact Widget Successfully reseted.', 'cup_cp').'</p></div>';
		}
		
		?>
        <?php echo $message; ?>
	<form action="" method="post">
    <div id="a3_plugin_panel_container">
    	<div id="a3_plugin_panel_fields" class="a3_subsubsub_section">
        	<ul class="subsubsub">
            	<li><a href="#contact-widget-settings" class="current"><?php _e('Settings', 'cup_cp'); ?></a> | </li>
            	<li><a href="#contact-widget-information"><?php _e('Contact Infomation', 'cup_cp'); ?></a> | </li>
                <li><a href="#contact-widget-email-contact-form"><?php _e('Email Contact Form', 'cup_cp'); ?></a> | </li>
                <li><a href="#contact-widget-maps"><?php _e('Maps Settings', 'cup_cp'); ?></a></li>
			</ul>
            <br class="clear">
            <div class="section" id="contact-widget-settings">
            	<?php People_Contact_Widget_Settings_Panel::panel_page(); ?>
            </div>
            <div class="section" id="contact-widget-information">
            	<?php People_Contact_Widget_Information_Panel::panel_page(); ?>
            </div>
            <div class="section" id="contact-widget-email-contact-form">
            	<?php People_Contact_Widget_Email_Contact_Form_Panel::panel_page(); ?>
            </div>
            <div class="section" id="contact-widget-maps">
            	<?php People_Contact_Widget_Maps_Panel::panel_page(); ?>
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