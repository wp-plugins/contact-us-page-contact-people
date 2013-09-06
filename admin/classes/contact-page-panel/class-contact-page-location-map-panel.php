<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * People Contact Page Location Map Panel
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 */
class People_Contact_Page_Location_Map_Panel {
	public static function get_settings_default() {
		$default_settings = array(
			'hide_maps_frontend'					=> 0,
			'zoom_level'							=> 4,
			'map_type'								=> 'ROADMAP',
			'map_height'							=> 400,
			'map_width'								=> 100,
			'map_width_type'						=> 'percent',
			'center_address'						=> 'Australia',
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'people_contact_location_map_settings';
		$customized_settings = get_option($option_name);
		if ( !is_array($customized_settings) ) $customized_settings = array();
		
		$default_settings = People_Contact_Page_Location_Map_Panel::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		if ($reset) {
			update_option($option_name, $default_settings);
		} else {
			update_option($option_name, $customized_settings);
		}
				
	}
	
	public static function get_settings() {
		global $people_contact_location_map_settings;
		$customized_settings = get_option('people_contact_location_map_settings');
		if ( !is_array($customized_settings) ) $customized_settings = array();
		$default_settings = People_Contact_Page_Location_Map_Panel::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		foreach ($customized_settings as $key => $value) {
			if (!isset($default_settings[$key])) continue;
			
			if ( !is_array($default_settings[$key]) ) {
				if ( trim($value) == '' ) $customized_settings[$key] = $default_settings[$key];
				else $customized_settings[$key] = esc_attr( stripslashes( $value ) );
			}
		}
		
		$people_contact_location_map_settings = $customized_settings;
		
		return $customized_settings;
	}
	
	public static function panel_page() {
		$option_name = 'people_contact_location_map_settings';
		if (isset($_REQUEST['bt_save_settings'])) {
			$customized_settings = $_REQUEST[$option_name];
			if (!isset($customized_settings['hide_maps_frontend'])) $customized_settings['hide_maps_frontend'] = 1;
			update_option($option_name, $customized_settings);
			$message = '<div class="updated" id=""><p>'.__('Location Map Settings Successfully saved.', 'cup_cp').'</p></div>';
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			People_Contact_Page_Location_Map_Panel::set_settings_default(true);
			$message = '<div class="updated" id=""><p>'.__('Location Map Settings Successfully saved.', 'cup_cp').'</p></div>';
		}
		
		$customized_settings = get_option($option_name);
		$default_settings = People_Contact_Page_Location_Map_Panel::get_settings_default();
		if ( !is_array($customized_settings) ) $customized_settings = $default_settings;
		else $customized_settings = array_merge($default_settings, $customized_settings);
		
		extract($customized_settings);
		
		$pages = get_pages('title_li=&orderby=name');
		?>
        <h3><?php _e('Location Map Settings', 'cup_cp'); ?> <a class="add-new-h2 a3-view-docs-button" target="_blank" href="<?php echo PEOPLE_CONTACT_DOCS_URI;?>#section-13" ><?php _e('View Docs', 'cup_cp'); ?></a></h3>
		<table class="form-table">
            
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="hide_maps_frontend"><?php _e( 'Enable/Disable Map', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <label><input type="checkbox" <?php checked( $hide_maps_frontend, '0' ); ?> value="0" id="hide_maps_frontend" name="<?php echo $option_name; ?>[hide_maps_frontend]" /> <span class=""><?php _e("Check to enable google location map on Contact Us Page.", 'cup_cp');?></span></label>
				</td>
			</tr>
        
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="zoom_level"><?php _e( 'Zoom Level', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <select class="chzn-select" style="width:120px;" id="zoom_level" name="<?php echo $option_name; ?>[zoom_level]">
							<?php for( $i = 1 ; $i <= 19 ; $i++ ){ ?>
							<option value="<?php echo ($i); ?>" <?php selected( $zoom_level, $i ); ?>><?php echo $i; ?></option>
							<?php } ?>                                  
					</select>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="map_type"><?php _e( 'Map Type', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <select class="chzn-select" style="width:120px;" id="map_type" name="<?php echo $option_name; ?>[map_type]">
						<option value="ROADMAP" selected="selected">ROADMAP</option>
                        <option value="SATELLITE" <?php selected( $map_type, 'SATELLITE' ); ?>>SATELLITE</option>
                        <option value="HYBRID" <?php selected( $map_type, 'HYBRID' ); ?>>HYBRID</option>
                        <option value="TERRAIN" <?php selected( $map_type, 'TERRAIN' ); ?>>TERRAIN</option>
					</select>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="map_width_type"><?php _e( 'Map Width Type', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <select class="chzn-select" style="width:120px;" id="map_width_type" name="<?php echo $option_name; ?>[map_width_type]">
						<option value="percent" selected="selected">%</option>
                        <option value="px" <?php selected( $map_width_type, 'px' ); ?>>px</option>
					</select>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="map_width"><?php _e( 'Map Width', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $map_width ) ); ?>" name="<?php echo $option_name; ?>[map_width]" id="map_width" style="width:120px;"  />
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="map_height"><?php _e( 'Map Height', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $map_height ) ); ?>" name="<?php echo $option_name; ?>[map_height]" id="map_height" style="width:120px;"  /> px
				</td>
			</tr>
        </table>    
        <h3><?php _e('Primary Location Address', 'cup_cp'); ?></h3>
        <p><?php _e('Enter a Primary location address in a format that google can find. Example Street Number Street name Suburb, Town, postcode / zip code, Country. The map will open with this location as its center.', 'cup_cp'); ?></p>
        
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="center_address"><?php _e( 'Center Address', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $center_address ) ); ?>" name="<?php echo $option_name; ?>[center_address]" id="center_address" style="width:300px;"  />
				</td>
			</tr>
       
		</table>
	<?php
	}
}
?>