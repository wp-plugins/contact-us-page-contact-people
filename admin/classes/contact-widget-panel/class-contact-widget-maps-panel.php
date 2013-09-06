<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * People Contact Widget Map Panel
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 */
class People_Contact_Widget_Maps_Panel 
{
	public static function get_settings_default() {
		$default_settings = array(
			'widget_location'							=> 'Australia',
			'widget_zoom_level'							=> 6,
			'widget_map_type'								=> 'ROADMAP',
			'widget_map_height'							=> 150,
			'widget_map_width'								=> 100,
			'widget_map_width_type'						=> 'percent',
			'widget_hide_maps_frontend'					=> 0,
			'widget_maps_callout_text'					=> '',
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'people_contact_widget_maps';
		$customized_settings = get_option($option_name);
		if ( !is_array($customized_settings) ) $customized_settings = array();
		
		$default_settings = People_Contact_Widget_Maps_Panel::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		if ($reset) {
			update_option($option_name, $default_settings);
		} else {
			update_option($option_name, $customized_settings);
		}
				
	}
	
	public static function get_settings() {
		global $people_contact_widget_maps;
		$customized_settings = get_option('people_contact_widget_maps');
		if ( !is_array($customized_settings) ) $customized_settings = array();
		$default_settings = People_Contact_Widget_Maps_Panel::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		foreach ($customized_settings as $key => $value) {
			if (!isset($default_settings[$key])) continue;
			
			if ( !is_array($default_settings[$key]) ) {
				if ( trim($value) == '' ) $customized_settings[$key] = $default_settings[$key];
				else $customized_settings[$key] = esc_attr( stripslashes( $value ) );
			}
		}
		
		$people_contact_widget_maps = $customized_settings;
		
		return $customized_settings;
	}
	
	public static function panel_page() {
		$option_name = 'people_contact_widget_maps';
		if (isset($_REQUEST['bt_save_settings'])) {
			
			$customized_settings = $_REQUEST[$option_name];
			if (!isset($customized_settings['widget_hide_maps_frontend'])) $customized_settings['widget_hide_maps_frontend'] = 1;
			update_option($option_name, $customized_settings);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			People_Contact_Widget_Maps_Panel::set_settings_default(true);
		}
		
		$customized_settings = get_option($option_name);
		$default_settings = People_Contact_Widget_Maps_Panel::get_settings_default();
		if ( !is_array($customized_settings) ) $customized_settings = $default_settings;
		else $customized_settings = array_merge($default_settings, $customized_settings);
		
		extract($customized_settings);
		
		wp_enqueue_script('jquery-ui-autocomplete', '', array('jquery-ui-widget', 'jquery-ui-position'), '1.8.6');
		wp_enqueue_script('maps-googleapis','https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false' );		
		?>
        <script type="text/javascript" >
        jQuery(document).ready(function ($) { 
			var geocoder;
			  geocoder = new google.maps.Geocoder();
			  $(function() {
				$("#widget_location").autocomplete({
				  //This bit uses the geocoder to fetch address values
				  source: function(request, response) {
					geocoder.geocode( {'address': request.term }, function(results, status) {
					  response($.map(results, function(item) {
						return {
						  label:  item.formatted_address,
						  value: item.formatted_address,
						  latitude: item.geometry.location.lat(),
						  longitude: item.geometry.location.lng()
						}
					  }));
					})
				  }
				});
			});
		});
		</script>
        <h3><?php _e('Maps Settings', 'cup_cp'); ?> <a class="add-new-h2 a3-view-docs-button" target="_blank" href="<?php echo PEOPLE_CONTACT_DOCS_URI;?>#section-25" ><?php _e('View Docs', 'cup_cp'); ?></a></h3>
		<table class="form-table">
        	<tr valign="top">
		    	<th class="titledesc" scope="row"><label for="widget_hide_maps_frontend"><?php _e( 'Enable/Disable Map', 'cup_cp' );?></label></th>
		    	<td class="forminp"> <input type="checkbox" <?php checked( $widget_hide_maps_frontend, '0' ); ?> value="0" id="widget_hide_maps_frontend" name="<?php echo $option_name; ?>[widget_hide_maps_frontend]" /> <span class=""><?php _e("Check to enable a Google map on the Widget", 'cup_cp');?></span>
				</td>
			</tr>
        	<tr valign="top">
		    	<th class="titledesc" scope="row"><label for="widget_location"><?php _e( 'Location', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" id="widget_location" class="map_option" name="<?php echo $option_name; ?>[widget_location]" value="<?php echo $widget_location;?>" style="width:300px" />
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="widget_zoom_level"><?php _e( 'Zoom Level', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <select class="chzn-select" style="width:120px;" id="widget_zoom_level" name="<?php echo $option_name; ?>[widget_zoom_level]">
							<?php for( $i = 1 ; $i <= 19 ; $i++ ){ ?>
							<option value="<?php echo ($i); ?>" <?php selected( $widget_zoom_level, $i ); ?>><?php echo $i; ?></option>
							<?php } ?>                                  
					</select>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="widget_map_type"><?php _e( 'Map Type', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <select class="chzn-select" style="width:120px;" id="widget_map_type" name="<?php echo $option_name; ?>[widget_map_type]">
						<option value="ROADMAP" selected="selected">ROADMAP</option>
                        <option value="SATELLITE" <?php selected( $widget_map_type, 'SATELLITE' ); ?>>SATELLITE</option>
                        <option value="HYBRID" <?php selected( $widget_map_type, 'HYBRID' ); ?>>HYBRID</option>
                        <option value="TERRAIN" <?php selected( $widget_map_type, 'TERRAIN' ); ?>>TERRAIN</option>
					</select>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="widget_map_width_type"><?php _e( 'Map Width Type', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <select class="chzn-select" style="width:120px;" id="widget_map_width_type" name="<?php echo $option_name; ?>[widget_map_width_type]">
						<option value="percent" selected="selected">%</option>
                        <option value="px" <?php selected( $widget_map_width_type, 'px' ); ?>>px</option>
					</select>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="widget_map_width"><?php _e( 'Map Width', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $widget_map_width ) ); ?>" name="<?php echo $option_name; ?>[widget_map_width]" id="widget_map_width" style="width:120px;"  />
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="widget_map_height"><?php _e( 'Map height', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $widget_map_height ) ); ?>" name="<?php echo $option_name; ?>[widget_map_height]" id="widget_map_height" style="width:120px;"  /> px
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="widget_maps_callout_text"><?php _e( 'Map Callout Text', 'cup_cp' );?></label></th>
		    	<td class="forminp">
                    <textarea style="width:300px;height:80px;" name="<?php echo $option_name; ?>[widget_maps_callout_text]" id="widget_maps_callout_text"><?php echo $widget_maps_callout_text; ?></textarea>  <div class=""><?php _e("Text or HTML that will be output when you click on the map marker for your location.", 'cup_cp');?></div>
				</td>
			</tr>
		</table>
	<?php
	}
}
?>