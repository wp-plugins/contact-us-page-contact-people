<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * People Contact Grid View Layout Panel 
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 */
class People_Contact_Grid_View_Layout_Panel 
{
	public static function get_settings_default() {
		$default_settings = array(
			'grid_view_team_title'					=> 'Team Contacts',
			'grid_view_col'							=> 2,
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'people_contact_grid_view_layout';
		$customized_settings = get_option($option_name);
		if ( !is_array($customized_settings) ) $customized_settings = array();
		
		$default_settings = People_Contact_Grid_View_Layout_Panel::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		if ($reset) {
			update_option($option_name, $default_settings);
		} else {
			update_option($option_name, $customized_settings);
		}
				
	}
	
	public static function get_settings() {
		global $people_contact_grid_view_layout;
		$customized_settings = get_option('people_contact_grid_view_layout');
		if ( !is_array($customized_settings) ) $customized_settings = array();
		$default_settings = People_Contact_Grid_View_Layout_Panel::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		foreach ($customized_settings as $key => $value) {
			if (!isset($default_settings[$key])) continue;
			
			if ( !is_array($default_settings[$key]) ) {
				if ( trim($value) == '' ) $customized_settings[$key] = $default_settings[$key];
				else $customized_settings[$key] = esc_attr( stripslashes( $value ) );
			}
		}
		
		$people_contact_grid_view_layout = $customized_settings;
		
		return $customized_settings;
	}
	
	public static function panel_page() {
		$option_name = 'people_contact_grid_view_layout';
		if (isset($_REQUEST['bt_save_settings'])) {
			$customized_settings = $_REQUEST[$option_name];
			update_option($option_name, $customized_settings);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			People_Contact_Grid_View_Layout_Panel::set_settings_default(true);
		}
		
		$customized_settings = get_option($option_name);
		$default_settings = People_Contact_Grid_View_Layout_Panel::get_settings_default();
		if ( !is_array($customized_settings) ) $customized_settings = $default_settings;
		else $customized_settings = array_merge($default_settings, $customized_settings);
		
		extract($customized_settings);
				
		?>
        <h3><?php _e('Grid View Layout', 'cup_cp'); ?></h3>
		<table class="form-table">
        	<tr valign="top">
		    	<th class="titledesc" scope="row"><label for="grid_view_team_title"><?php _e( 'Grid View Title', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" id="grid_view_team_title" class="map_option" name="<?php echo $option_name; ?>[grid_view_team_title]" value="<?php echo $grid_view_team_title;?>" style="width:300px" />
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="grid_view_col"><?php _e( 'Grid View Column', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <select class="chzn-select" style="width:300px;" id="grid_view_col" name="<?php echo $option_name; ?>[grid_view_col]">
							<?php for( $i = 1 ; $i <= 5 ; $i++ ){ ?>
							<option value="<?php echo ($i); ?>" <?php selected( $grid_view_col, $i ); ?>><?php echo $i; ?> <?php _e('column', 'cup_cp'); ?></option>
							<?php } ?>                                  
					</select>
				</td>
			</tr>
		</table>
	<?php
	}
}
?>