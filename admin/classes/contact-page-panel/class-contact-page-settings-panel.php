<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * People Contact Page Settings Panel
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 */
class People_Contact_Page_Settings_Panel {
	public static function get_settings_default() {
		$default_settings = array(
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'people_contact_settings';
		$customized_settings = get_option($option_name);
		if ( !is_array($customized_settings) ) $customized_settings = array();
		
		$default_settings = People_Contact_Page_Settings_Panel::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		if ($reset) {
			update_option($option_name, $default_settings);
			update_option('a3_people_contact_clean_on_deletion', 0);
			$uninstallable_plugins = (array) get_option('uninstall_plugins');
			unset($uninstallable_plugins[PEOPLE_CONTACT_NAME]);
			update_option('uninstall_plugins', $uninstallable_plugins);
		} else {
			update_option($option_name, $customized_settings);
			if ( get_option('a3_people_contact_clean_on_deletion') == '') {
				update_option('a3_people_contact_clean_on_deletion', 0);
			}
		}
				
	}
	
	public static function get_settings() {
		global $people_contact_settings;
		$customized_settings = get_option('people_contact_settings');
		if ( !is_array($customized_settings) ) $customized_settings = array();
		$default_settings = People_Contact_Page_Settings_Panel::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		foreach ($customized_settings as $key => $value) {
			if (!isset($default_settings[$key])) continue;
			
			if ( !is_array($default_settings[$key]) ) {
				if ( trim($value) == '' ) $customized_settings[$key] = $default_settings[$key];
				else $customized_settings[$key] = esc_attr( stripslashes( $value ) );
			}
		}
		
		$people_contact_settings = $customized_settings;
		
		return $customized_settings;
	}
	
	public static function panel_page() {
		$option_name = 'people_contact_settings';
		if (isset($_REQUEST['bt_save_settings'])) {
			
			update_option('contact_us_page_id', $_REQUEST['contact_us_page_id']);
			
			$customized_settings = array();
			update_option($option_name, $customized_settings);
			
			if ( isset($_REQUEST['a3_people_contact_clean_on_deletion']) ) {
				update_option('a3_people_contact_clean_on_deletion', $_REQUEST['a3_people_contact_clean_on_deletion']);
			} else { 
				update_option('a3_people_contact_clean_on_deletion', 0);
				$uninstallable_plugins = (array) get_option('uninstall_plugins');
				unset($uninstallable_plugins[PEOPLE_CONTACT_NAME]);
				update_option('uninstall_plugins', $uninstallable_plugins);
			}
		
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			People_Contact_Page_Settings_Panel::set_settings_default(true);
		}
		
		$customized_settings = get_option($option_name);
		$default_settings = People_Contact_Page_Settings_Panel::get_settings_default();
		if ( !is_array($customized_settings) ) $customized_settings = $default_settings;
		else $customized_settings = array_merge($default_settings, $customized_settings);
		
		extract($customized_settings);
		
		$pages = get_pages('title_li=&orderby=name');
		$contact_us_page_id = get_option('contact_us_page_id');
		?>
        <h3><?php _e('Contact Us Page', 'cup_cp'); ?></h3>
        <p><?php _e('A "Contact Us Page" was auto created on activation of the plugin. It contains the shortcode [people_contacts] required to show the contact us page. If it was not or you want to change it, create a new page, add the shortcode and then set it here.'); ?></p>
        <table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="contact_us_page_id"><?php _e( 'Contact Us', 'cup_cp' );?></label></th>
		    	<td class="forminp">  
                        
                    <select class="chzn-select" style="width:300px;" id="contact_us_page_id" name="contact_us_page_id">
                    		<option selected='selected' value='0'><?php _e('Select Page','cup_cp'); ?></option>
                                    <?php
                                    foreach ( $pages as $page ) {
                                        if ( $page->ID == $contact_us_page_id ) {
                                            $selected = "selected='selected'";	
                                        } else {
                                            $selected = "";		
                                        }
                                        echo "<option $selected value='".$page->ID."'>". $page->post_title."</option>";
                                    }
                                    ?>
							
					</select> <span class="description"><?php _e('Page contents', 'cup_cp');?>: [people_contacts]</span>
				</td>
			</tr>
		</table>
        
        <h3><?php _e('House Keeping', 'cup_cp');?> :</h3>		
        <table class="form-table">
            <tr valign="top" class="">
				<th class="titledesc" scope="row"><label for="a3_people_contact_clean_on_deletion"><?php _e('Clean up on Deletion', 'cup_cp');?></label></th>
				<td class="forminp">
						<label>
						<input <?php checked( get_option('a3_people_contact_clean_on_deletion'), 1); ?> type="checkbox" value="1" id="a3_people_contact_clean_on_deletion" name="a3_people_contact_clean_on_deletion">
						<?php _e('Check this box and if you ever delete this plugin it will completely remove all tables and data it created, leaving no trace it was ever here. If upgrading to the Pro Version this is not recommended.', 'cup_cp');?></label> <br>
				</td>
			</tr>
		</table>
	<?php
	}
}
?>