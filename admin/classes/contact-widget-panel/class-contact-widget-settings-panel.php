<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * People Contact Widget Information Panel
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 */
class People_Contact_Widget_Settings_Panel 
{
	public static function get_settings_default() {
		$default_settings = array(
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'people_contact_widget_settings';
		$customized_settings = get_option($option_name);
		if ( !is_array($customized_settings) ) $customized_settings = array();
		
		$default_settings = People_Contact_Widget_Settings_Panel::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		if ($reset) {
			update_option($option_name, $default_settings);
		} else {
			update_option($option_name, $customized_settings);
		}
				
	}
	
	public static function get_settings() {
		global $people_contact_widget_settings;
		$customized_settings = get_option('people_contact_widget_settings');
		if ( !is_array($customized_settings) ) $customized_settings = array();
		$default_settings = People_Contact_Widget_Settings_Panel::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		foreach ($customized_settings as $key => $value) {
			if (!isset($default_settings[$key])) continue;
			
			if ( !is_array($default_settings[$key]) ) {
				if ( trim($value) == '' ) $customized_settings[$key] = $default_settings[$key];
				else $customized_settings[$key] = esc_attr( stripslashes( $value ) );
			}
		}
		
		$people_contact_widget_settings = $customized_settings;
		
		return $customized_settings;
	}
	
	public static function panel_page() {
		
		$option_name = 'people_contact_widget_settings';
		if (isset($_REQUEST['bt_save_settings'])) {
			
			$customized_settings = array();
			update_option($option_name, $customized_settings);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			People_Contact_Widget_Settings_Panel::set_settings_default(true);
		}
		
		$customized_settings = get_option($option_name);
		$default_settings = People_Contact_Widget_Settings_Panel::get_settings_default();
		if ( !is_array($customized_settings) ) $customized_settings = $default_settings;
		else $customized_settings = array_merge($default_settings, $customized_settings);
		
		extract($customized_settings);
				
		?>
     
        <h3><?php _e('Contact Us Widget', 'cup_cp'); ?> <a class="add-new-h2 a3-view-docs-button" target="_blank" href="<?php echo PEOPLE_CONTACT_DOCS_URI;?>#section-22" ><?php _e('View Docs', 'cup_cp'); ?></a></h3>
        <p><?php _e('This plugin includes a Contact Us Widget. Use it to add Business / Organization Details, information and a general Contact Us form to the Contact Us Page sidebar. All of the Widget settings are here on the Contact Widget tab. Use the plugins built in Contact Form or add a custom form by shortcode from a Contact Form plugin of your choice.', 'cup_cp'); ?></p>
		<h3><?php _e('Contact Page Sidebar', 'cup_cp'); ?></h3>
        <p><?php _e('We recommend that you create a new sidebar and assign it to the Contact Us Page. If you do you can then add the Contact Widget to that sidebar and it will only show on the Contact Us page. We recommend you install this plugin <a href="http://wordpress.org/plugins/woosidebars/" target="_blank">WooSidebars</a> and use it to create the custom sidebar.', 'cup_cp'); ?></p>
	<?php
	}
}
?>