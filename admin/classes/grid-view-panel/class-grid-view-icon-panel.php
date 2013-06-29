<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * People Contact Grid View Icon Panel 
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 */
class People_Contact_Grid_View_Icon_Panel 
{
	public static function get_settings_default() {
		$default_settings = array(
			'default_profile_image'							=> PEOPLE_CONTACT_IMAGE_URL.'/no-avatar.png',
			'grid_view_icon_phone'							=> PEOPLE_CONTACT_IMAGE_URL.'/p_icon_phone.png',
			'grid_view_icon_fax'							=> PEOPLE_CONTACT_IMAGE_URL.'/p_icon_fax.png',
			'grid_view_icon_mobile'							=> PEOPLE_CONTACT_IMAGE_URL.'/p_icon_mobile.png',
			'grid_view_icon_email'							=> PEOPLE_CONTACT_IMAGE_URL.'/p_icon_email.png',
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'people_contact_grid_view_icon';
		
		$default_settings = People_Contact_Grid_View_Icon_Panel::get_settings_default();
		
		if ($reset) {
			update_option($option_name, $default_settings);
		} else {
			update_option($option_name, $default_settings);
		}
				
	}
	
	public static function get_settings() {
		global $people_contact_grid_view_icon;
		$people_contact_grid_view_icon = People_Contact_Grid_View_Icon_Panel::get_settings_default();
		
		return $people_contact_grid_view_icon;
	}
	
	public static function panel_page() {
		$option_name = 'people_contact_grid_view_icon';
		if (isset($_REQUEST['bt_save_settings'])) {
			People_Contact_Grid_View_Icon_Panel::set_settings_default(true);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			People_Contact_Grid_View_Icon_Panel::set_settings_default(true);
		}
		
		$customized_settings = $default_settings = People_Contact_Grid_View_Icon_Panel::get_settings_default();
		
		extract($customized_settings);
				
		?>
        <h3><?php _e('Upload Custom Default Profile Image', 'cup_cp'); ?></h3>
        <p><?php _e("Upload custom 'No Image' image, .jpg or.png format, 150px by 150px recommended size.", 'cup_cp'); ?></p>
		<table class="form-table">
        	<tr valign="top">
				  <th scope="row"><label for="default_profile_image"><?php _e("Default Profile Image", 'cup_cp'); ?></label></th>
				  <td>
                  <?php echo People_Contact_Uploader::upload_input_fields( $option_name, 'default_profile_image', __('Default Profile Image', 'cup_cp'), $default_profile_image, '', '236px' ); ?>
                  </td>
			</tr>
		</table>
        
        <h3><?php _e('Upload Custom Contact Icons', 'cup_cp'); ?></h3>
        <p><?php _e('Delete default icons. Upload custom icons, transparent .png format, 16px by 16px recommended size.', 'cup_cp'); ?></p>
		<table class="form-table">
        	<tr valign="top">
				  <th scope="row"><label for="grid_view_icon_phone"><?php _e("Phone icon", 'cup_cp'); ?></label></th>
				  <td>
                  <?php echo People_Contact_Uploader::upload_input_fields( $option_name, 'grid_view_icon_phone', __('Icon Phone', 'cup_cp'), $grid_view_icon_phone, '', '236px' ); ?>
                  </td>
			</tr>
            <tr valign="top">
				  <th scope="row"><label for="grid_view_icon_fax"><?php _e("Fax icon", 'cup_cp'); ?></label></th>
				  <td>
                  <?php echo People_Contact_Uploader::upload_input_fields( $option_name, 'grid_view_icon_fax', __('Icon Fax', 'cup_cp'), $grid_view_icon_fax, '', '236px' ); ?>
                  </td>
			</tr>
            <tr valign="top">
				  <th scope="row"><label for="grid_view_icon_mobile"><?php _e("Mobile icon", 'cup_cp'); ?></label></th>
				  <td>
                  <?php echo People_Contact_Uploader::upload_input_fields( $option_name, 'grid_view_icon_mobile', __('Icon Mobile', 'cup_cp'), $grid_view_icon_mobile, '', '236px' ); ?>
                  </td>
			</tr>
            <tr valign="top">
				  <th scope="row"><label for="grid_view_icon_email"><?php _e("Email icon", 'cup_cp'); ?></label></th>
				  <td>
                  <?php echo People_Contact_Uploader::upload_input_fields( $option_name, 'grid_view_icon_email', __('Icon Email', 'cup_cp'), $grid_view_icon_email, '', '236px' ); ?>
                  </td>
			</tr>
		</table>
	<?php
	}
}
?>