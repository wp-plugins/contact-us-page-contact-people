<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * People Contact_Page Contact Forms Panel
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 */
class People_Contact_Page_Contact_Forms_Panel {
	public static function get_settings_default() {
		$default_settings = array(
			'email_from_name'						=> get_bloginfo('blogname'),
			'email_from_address'					=> get_bloginfo('admin_email'),
			'send_copy'								=> 'no',
			'contact_form_type_other'				=> 0,
			'contact_form_type_shortcode'			=> '',
			
			'contact_form_3rd_open_type'			=> 'new_page',
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'people_contact_contact_forms_settings';
		
		$default_settings = People_Contact_Page_Contact_Forms_Panel::get_settings_default();
				
		if ($reset) {
			update_option($option_name, $default_settings);
		} else {
			update_option($option_name, $default_settings);
		}
				
	}
	
	public static function get_settings() {
		global $people_contact_contact_forms_settings;
		$people_contact_contact_forms_settings = People_Contact_Page_Contact_Forms_Panel::get_settings_default();
		
		return $people_contact_contact_forms_settings;
	}
	
	public static function panel_page() {
		$option_name = 'people_contact_contact_forms_settings';
		if (isset($_REQUEST['bt_save_settings'])) {
			People_Contact_Page_Contact_Forms_Panel::set_settings_default(true);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			People_Contact_Page_Contact_Forms_Panel::set_settings_default(true);
		}
		
		$customized_settings = $default_settings = People_Contact_Page_Contact_Forms_Panel::get_settings_default();
		
		extract($customized_settings);
		
		$pages = get_pages('title_li=&orderby=name');
		
		?>
        <h3><?php _e('Default People Contact Forms', 'cup_cp'); ?></h3>
        <p><?php _e('The People contact form set here applies to every profile. Create a unique contact form for a profile by adding a contact form shortcode from Contact Form 7 or Gravity Forms on the Profiles edit page. <strong>Note:</strong> You must have the 3rd Party Contact Form setting enabled here to be able to do that.' ,'cup_cp'); ?></p>
		<table class="form-table">
        	
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="contact_form_type_other_default"><?php _e( 'Default Contact Form', 'cup_cp' );?></label></th>
		    	<td class="forminp">   
                    <label><input disabled="disabled" type="radio" checked="checked" value="0" id="contact_form_type_other_default" name="<?php echo $option_name; ?>[contact_form_type_other]" /> <span class=""><?php _e(' Check to us the plugins default contact pop-up form.', 'cup_cp');?></span></label>
				</td>
			</tr>
        	<tr valign="top">
		    	<th class="titledesc" scope="row"><label for="email_from_name"><?php _e( '"From" Name', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" disabled="disabled" value="<?php esc_attr_e( stripslashes( $email_from_name ) ); ?>" name="<?php echo $option_name; ?>[email_from_name]" id="email_from_name" style="width:300px;"  /> <span class="description"><?php _e('&lt;empty&gt; defaults to Site Title', 'cup_cp');?></span>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="email_from_address"><?php _e( '"From" Email Address', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" disabled="disabled" value="<?php esc_attr_e( stripslashes( $email_from_address ) ); ?>" name="<?php echo $option_name; ?>[email_from_address]" id="email_from_address" style="width:300px;"  /> <span class="description"><?php _e('&lt;empty&gt; defaults to WordPress admin email address', 'cup_cp');?></span>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="send_copy"><?php _e( 'Send Copy to Sender', 'cup_cp' );?></label></th>
		    	<td class="forminp">
                	<label><input disabled="disabled" type="checkbox" value="yes" id="send_copy" name="<?php echo $option_name; ?>[send_copy]" /> <span class=""><?php _e('Checked adds opt in/out option to the bottom of the People Contact form Popup.', 'cup_cp');?></span></label>
				</td>
			</tr>
		</table>
        
        <h3><?php _e('3RD Party Contact Form', 'cup_cp'); ?></h3>
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="contact_form_type_other"><?php _e( '3rd Party Contact Form', 'cup_cp' );?></label></th>
		    	<td class="forminp">   
                    <label><input disabled="disabled" type="radio" value="1" id="contact_form_type_other" name="<?php echo $option_name; ?>[contact_form_type_other]" /> <span class=""><?php _e('Check to enable contact form from Gravity Forms or Contact Form 7. Form opens on a new page.', 'cup_cp');?></span></label>
				</td>
			</tr>
            
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="contact_form_type_shortcode"><?php _e( 'Contact Form Shortcode', 'cup_cp' );?></label></th>
		    	<td class="forminp">    
                    <input disabled="disabled" type="text" id="contact_form_type_shortcode" class="map_option" name="<?php echo $option_name; ?>[contact_form_type_shortcode]" value='' style="width:300px" /> <span class="description"><?php _e('Enter Shortcode from Gavity Forms or Contact Form 7', 'cup_cp');?></span>
				</td>
			</tr>
            <tr valign="top">
				<th class="titledesc" scope="rpw"><label><?php _e('Custom Form Open Options', 'cup_cp'); ?></label></th>
				<td class="forminp">
                	<label><input disabled="disabled" type="radio" name="<?php echo $option_name; ?>[contact_form_3rd_open_type]" value="new_page" checked="checked" /> <?php _e('Open contact form on new page', 'cup_cp'); ?> - <?php _e('new window', 'cup_cp'); ?>. <span class="description">(<?php _e('Default', 'cup_cp');?>)</span></label><br />
                    <label><input disabled="disabled" type="radio" name="<?php echo $option_name; ?>[contact_form_3rd_open_type]" value="new_page_same_window" /> <?php _e('Open contact form on new page', 'cup_cp'); ?> - <?php _e('same window', 'cup_cp'); ?>.</label><br />
                    <label><input disabled="disabled" type="radio" name="<?php echo $option_name; ?>[contact_form_3rd_open_type]" value="popup" /> <?php _e('Open contact form by Pop-up', 'cup_cp'); ?>.</label>
			</tr>
		</table>
        <h3><?php _e('People Contact Form Page', 'cup_cp'); ?></h3>
        <p><?php _e('A "Profile Email Page" was auto created on activation of the plugin. It contains the shortcode [profile_email_page] and is required to show the contact form for each profile. If it was not or you want to change it, create a new page, add the shortcode and then set it here.', 'cup_cp'); ?></p>
        
		<table class="form-table">    
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="profile_email_page_id"><?php _e( 'Profile Contact Page', 'cup_cp' );?></label></th>
		    	<td class="forminp">  
                    
                    <select class="chzn-select" style="width:300px;" id="profile_email_page_id" name="profile_email_page_id">
                    		<option selected='selected' value='0'><?php _e('Select Page','cup_cp'); ?></option>
                                    <?php
                                    foreach ( $pages as $page ) {
                                        echo "<option value='".$page->ID."'>". $page->post_title."</option>";
                                    }
                                    ?>
							
					</select> <span class="description"><?php _e('Page contents', 'cup_cp');?>: [profile_email_page]</span>
				</td>
			</tr>
            
        </table>
        
        <h3><?php _e('Global Re-Set', 'cup_cp'); ?></h3>
       
		<table class="form-table">    
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="global_reset_profile"><?php _e( 'Global Re-Set', 'cup_cp' );?></label></th>
		    	<td class="forminp">  
                    
                    <label><input disabled="disabled" type="checkbox" value="1" id="global_reset_profile" name="global_reset_profile" /> <span class=""><?php _e("Check and 'Save Changes' to auto reset all unique profile contact form shortcodes that have been set, to the Global Contact shortcode set on this page.", 'cup_cp');?></span></label>
				</td>
			</tr>
            
        </table>
	<?php
	}
}
?>