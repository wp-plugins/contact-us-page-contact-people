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
			'grid_view_team_title'					=> __('Team Contacts', 'cup_cp'),
			'grid_view_col'							=> 2,
			'thumb_image_position'					=> 'left',
			'thumb_image_wide'						=> 30,
			'fix_thumb_image_height'				=> 0,
			'thumb_image_height'					=> 150,
			'item_title_position'					=> 'above',
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'people_contact_grid_view_layout';
		$customized_settings = get_option($option_name);
		if ( !is_array($customized_settings) ) $customized_settings = array();
		
		$default_settings = People_Contact_Grid_View_Layout_Panel::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		$free_default_settings = $default_settings;
		unset($free_default_settings['grid_view_team_title']);
		unset($free_default_settings['grid_view_col']);
		$customized_settings = array_merge($customized_settings, $free_default_settings);
		
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
        
        <div class="pro_feature_fields">
        <table class="form-table">
            <tr valign="top">
				<th class="titledesc" scope="row"><label><?php _e('Profile Image Position', 'cup_cp');?></label></th>
				<td class="forminp">
                	<label><input type="radio" class="thumb_image_position" name="<?php echo $option_name; ?>[thumb_image_position]" value="top" /> <?php _e('Image Top - Content Bottom', 'cup_cp');?></label><br />
                    <label><input type="radio" checked="checked" class="thumb_image_position" name="<?php echo $option_name; ?>[thumb_image_position]" value="left" /> <?php _e('Image Left - Content Right', 'cup_cp');?></label><br />
                    <label><input type="radio" class="thumb_image_position" name="<?php echo $option_name; ?>[thumb_image_position]" value="right" /> <?php _e('Content Left - Image Right', 'cup_cp');?></label>
				</td>
			</tr>
			<tr valign="top" class="thumb_image_position_side" style="" >
				<th class="titledesc" scope="row"><label for="thumb_image_wide"><?php _e('Thumbnail Image Wide', 'cup_cp');?></label></th>
				<td class="forminp">
					<select class="chzn-select" style="width:120px;" id="thumb_image_wide" >
                    	<?php for( $i = 25 ; $i <= 50 ; $i++ ){ ?>
						<option value="<?php echo ($i); ?>" <?php selected( $thumb_image_wide, $i ); ?>><?php echo $i; ?>%</option>
						<?php } ?>
					</select>
				</td>
			</tr>
            <tr valign="top" class="thumb_image_position_top" style=" display:none ">
				<th class="titledesc" scope="rpw"><label for="fix_thumb_image_height"><?php _e('Fix Image Height','cup_cp'); ?></label></th>
				<td class="forminp">
					<label><input disabled="disabled" type="checkbox" name="<?php echo $option_name; ?>[fix_thumb_image_height]" value="1" id="fix_thumb_image_height" /> <span class=""><?php _e('Check to activate. Wide of image auto scaled to original proportion of tall.', 'cup_cp');?></span></label>
				</td>
			</tr>
			<tr valign="top" class="thumb_image_position_top" style=" display:none ">
				<th class="titledesc" scope="rpw"><label for="thumb_image_height"><?php _e('Image Fixed Height in Grid View','cup_cp'); ?></label></th>
				<td class="forminp">
					<input disabled="disabled" type="text" name="<?php echo $option_name; ?>[thumb_image_height]" id="thumb_image_height" value="150" style="width:120px" />px. <span class="description"><?php _e('Max height of image. Example set 200px and will fix image container at 200px with image aligned to the top. Default', 'cup_cp');?> <code><?php echo $default_settings['thumb_image_height']; ?>px</code></span>
				</td>
			</tr>
            <tr valign="top" class="thumb_image_position_top" style=" display:none ">
				<th class="titledesc" scope="row"><label for="item_title_position"><?php _e('Show Profile Title Position', 'cup_cp');?></label></th>
				<td class="forminp">
					<select class="chzn-select" style="width:220px;" id="item_title_position">
						<option selected="selected" value="above"><?php _e('Above the image', 'cup_cp');?></option>
						<option value="below"><?php _e('Below the image', 'cup_cp');?></option>
					</select>
				</td>
			</tr>
		</table>
        </div>
        <script type="text/javascript">
			(function($){		
				$(function(){	
					$('.thumb_image_position').click(function(){
						if ($("input[name='<?php echo $option_name; ?>[thumb_image_position]']:checked").val() == 'top') {
							$(".thumb_image_position_top").show();
							$(".thumb_image_position_side").hide();
						} else {
							$(".thumb_image_position_top").hide();
							$(".thumb_image_position_side").show();
						}
					});
				});		  
			})(jQuery);
		</script>
	<?php
	}
}
?>