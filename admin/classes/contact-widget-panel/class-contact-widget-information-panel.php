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
class People_Contact_Widget_Information_Panel 
{
	public static function get_settings_default() {
		$default_settings = array(
			'widget_info_address'						=> '',
			'widget_info_phone'							=> '',
			'widget_info_fax'							=> '',
			'widget_info_mobile'						=> '',
			'widget_content_before_maps'				=> '',
			'widget_content_after_maps'					=> '',
			'widget_info_email'							=> '',
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'people_contact_widget_information';
		$customized_settings = get_option($option_name);
		if ( !is_array($customized_settings) ) $customized_settings = array();
		
		$default_settings = People_Contact_Widget_Information_Panel::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		if ($reset) {
			update_option($option_name, $default_settings);
		} else {
			update_option($option_name, $customized_settings);
		}
				
	}
	
	public static function get_settings() {
		global $people_contact_widget_information;
		$customized_settings = get_option('people_contact_widget_information');
		if ( !is_array($customized_settings) ) $customized_settings = array();
		$default_settings = People_Contact_Widget_Information_Panel::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		foreach ($customized_settings as $key => $value) {
			if (!isset($default_settings[$key])) continue;
			
			if ( !is_array($default_settings[$key]) ) {
				if ( trim($value) == '' ) $customized_settings[$key] = $default_settings[$key];
				else $customized_settings[$key] = esc_attr( stripslashes( $value ) );
			}
		}
		
		$people_contact_widget_information = $customized_settings;
		
		return $customized_settings;
	}
	
	public static function panel_page() {
		
		$option_name = 'people_contact_widget_information';
		if (isset($_REQUEST['bt_save_settings'])) {
			
			$customized_settings = $_REQUEST[$option_name];
			if (!isset($customized_settings['widget_show_contact_form'])) $customized_settings['widget_show_contact_form'] = 0;
			update_option($option_name, $customized_settings);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			People_Contact_Widget_Information_Panel::set_settings_default(true);
		}
		
		$customized_settings = get_option($option_name);
		$default_settings = People_Contact_Widget_Information_Panel::get_settings_default();
		if ( !is_array($customized_settings) ) $customized_settings = $default_settings;
		else $customized_settings = array_merge($default_settings, $customized_settings);
		
		extract($customized_settings);
				
		?>
     
        <h3><?php _e('Add Contact Details', 'cup_cp'); ?> <a class="add-new-h2 a3-view-docs-button" target="_blank" href="<?php echo PEOPLE_CONTACT_DOCS_URI;?>#section-23" ><?php _e('View Docs', 'cup_cp'); ?></a></h3>
        <p><?php _e("Add contact details to show in the widget, &lt;empty&gt; fields don't show on front end.", 'cup_cp'); ?></p>
		<table class="form-table">
            
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="widget_info_address"><?php _e( 'Address', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" id="widget_info_address" class="map_option" name="<?php echo $option_name; ?>[widget_info_address]" value="<?php echo $widget_info_address;?>" style="width:300px" />
				</td>
			</tr>
            
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="widget_info_phone"><?php _e( 'Phone', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" id="widget_info_phone" class="map_option" name="<?php echo $option_name; ?>[widget_info_phone]" value="<?php echo $widget_info_phone;?>" style="width:300px" />
				</td>
			</tr>
            
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="widget_info_fax"><?php _e( 'Fax', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" id="widget_info_fax" class="map_option" name="<?php echo $option_name; ?>[widget_info_fax]" value="<?php echo $widget_info_fax;?>" style="width:300px" />
				</td>
			</tr>
            
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="widget_info_mobile"><?php _e( 'Mobile', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" id="widget_info_mobile" class="map_option" name="<?php echo $option_name; ?>[widget_info_mobile]" value="<?php echo $widget_info_mobile;?>" style="width:300px" />
				</td>
			</tr>
            
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="widget_info_email"><?php _e( 'Visible Email address', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" id="widget_info_email" class="map_option" name="<?php echo $option_name; ?>[widget_info_email]" value="<?php echo $widget_info_email;?>" style="width:300px" />
				</td>
			</tr>
            
        </table>    
        <h3><?php _e('Contact widget content', 'cup_cp'); ?></h3>
		<table class="form-table">   
            
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="widget_content_before_maps"><?php _e( 'Content before Map', 'cup_cp' );?></label></th>
		    	<td class="forminp">  
                    <?php wp_editor(stripslashes($widget_content_before_maps), 'widget_content_before_maps', array('textarea_name' => $option_name.'[widget_content_before_maps]', 'wpautop' => true, 'textarea_rows' => 15 ) ); ?>       
                    <!--<textarea style="width:300px;height:80px;" name="<?php echo $option_name; ?>[widget_content_before_maps]" id="widget_content_before_maps"><?php echo $widget_content_before_maps; ?></textarea>-->  <span class=""><?php _e("Content will show above map on widget. Leave &lt;empty&gt; to disable.", 'cup_cp');?></span>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="widget_content_after_maps"><?php _e( 'Content after Map', 'cup_cp' );?></label></th>
		    	<td class="forminp">
                    <?php wp_editor(stripslashes($widget_content_after_maps), 'widget_content_after_maps', array('textarea_name' => $option_name.'[widget_content_after_maps]', 'wpautop' => true, 'textarea_rows' => 15 ) ); ?>
                    <!--<textarea style="width:300px;height:80px;" name="<?php echo $option_name; ?>[widget_content_after_maps]" id="widget_content_after_maps"><?php echo $widget_content_after_maps; ?></textarea>-->  <span class=""><?php _e("Content will show below map on widget. Leave &lt;empty&gt; to disable.", 'cup_cp');?></span>
				</td>
			</tr>
            
		</table>
	<?php
	}
}
?>