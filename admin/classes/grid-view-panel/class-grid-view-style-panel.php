<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * People Contact Grid View Layout Style Panel 
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 */
class People_Contact_Grid_View_Style_Panel 
{
	public static function get_settings_default() {
		$default_settings = array(
			'grid_view_item_background'			=> '#FFFFFF',
			'grid_view_item_border_width'		=> '1',
			'grid_view_item_border_style'		=> 'solid',
			'grid_view_item_border_color'		=> '#DBDBDB',
			'grid_view_item_border_radius'		=> '0',
			'grid_view_item_padding_tb'			=> '10',
			'grid_view_item_padding_lr'			=> '10',
			'grid_view_item_shadow'				=> '1',
			'grid_view_item_shadow_color'		=> '#DBDBDB',
		);
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'people_contact_grid_view_style';
		
		$default_settings = People_Contact_Grid_View_Style_Panel::get_settings_default();
				
		if ($reset) {
			update_option($option_name, $default_settings);
		} else {
			update_option($option_name, $default_settings);
		}
				
	}
	
	public static function get_settings() {
		global $people_contact_grid_view_style;
		$people_contact_grid_view_style = People_Contact_Grid_View_Style_Panel::get_settings_default();
		
		return $people_contact_grid_view_style;
	}
	
	public static function panel_page() {
		$option_name = 'people_contact_grid_view_style';
		if (isset($_REQUEST['bt_save_settings'])) {
			People_Contact_Grid_View_Style_Panel::set_settings_default(true);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			People_Contact_Grid_View_Style_Panel::set_settings_default(true);
		}
		
		$customized_settings = $default_settings = People_Contact_Grid_View_Style_Panel::get_settings_default();
		
		extract($customized_settings);
		
		$df_border_style = array('solid'=>'Solid','dashed'=>'Dashed','dotted'=>'Dotted');
				
		?>
        <h3><?php _e('Grid View Styles', 'cup_cp'); ?> <a class="add-new-h2 a3-view-docs-button" target="_blank" href="<?php echo PEOPLE_CONTACT_DOCS_URI;?>#section-18" ><?php _e('View Docs', 'cup_cp'); ?></a></h3>
		<p><?php _e('Create custom Style for People Grid View display on Contact Us page and profile inserted by shortcode on posts and pages.', 'cup_cp'); ?></p>
  
                  <table cellspacing="0" class="form-table">
                  
                  	<tr valign="top">
                        <th class="titledesc" scope="rpw"><label for="grid_view_item_padding_tb"><?php _e('Grid View content padding top/bottom','cup_cp'); ?></label></th>
                        <td class="forminp">
                            <input disabled="disabled" type="text" name="<?php echo $option_name;?>[grid_view_item_padding_tb]" id="grid_view_item_padding_tb" value="<?php echo $grid_view_item_padding_tb;?>" style="width:120px;" /> <span class="description">px</span>
                        </td>
                    </tr>
                    
                    <tr valign="top">
                        <th class="titledesc" scope="rpw"><label for="grid_view_item_padding_lr"><?php _e('Grid View content padding left/right','cup_cp'); ?></label></th>
                        <td class="forminp">
                            <input disabled="disabled" type="text" name="<?php echo $option_name;?>[grid_view_item_padding_lr]" id="grid_view_item_padding_lr" value="<?php echo $grid_view_item_padding_lr;?>" style="width:120px;" /> <span class="description">px</span>
                        </td>
                    </tr>
                  
                    <tr valign="top">
                        <th class="titledesc" scope="rpw"><label for="grid_view_item_background"><?php _e('Grid View background Colour','cup_cp'); ?></label></th>
                        <td class="forminp">
                            <input type="text" class="colorpick" name="<?php echo $option_name;?>[grid_view_item_background]" id="grid_view_item_background" value="<?php echo $grid_view_item_background;?>" style="width:120px;" /> <span class="description"><?php _e('Grid View body background colour. Default ', 'cup_cp');?> <code><?php echo $default_settings['grid_view_item_background'] ?></code></span>
                            <div id="colorPickerDiv_content_background_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                        </td>
                    </tr>
                    
                    <tr>
                        <th class="titledesc" scope="row"><label for="grid_view_item_border_width"><?php _e('Grid View border weight','cup_cp'); ?></label></th>
                        <td class="forminp">
                            <select class="chzn-select" style="width:120px;" id="grid_view_item_border_width" name="<?php echo $option_name;?>[grid_view_item_border_width]">
                            <?php
							
							for( $i = 0 ; $i <= 19 ; $i++){
								if($grid_view_item_border_width == $i){ 
									echo '<option value="'.htmlspecialchars($i).'" selected="selected">'.$i.'px</option>';
								}else{
									echo '<option value="'.htmlspecialchars($i).'">'.$i.'px</option>';
								}
							}
                            ?>                                  
                            </select> <span class="description"><?php _e('Default', 'cup_cp');?> <code><?php echo $default_settings['grid_view_item_border_width'] ?>px</code></span>
                        </td>
                    </tr>
                    
                    <tr>
                        <th class="titledesc" scope="row"><label for="grid_view_item_border_style"><?php _e('Grid View border style','cup_cp'); ?></label></th>
                        <td class="forminp">
                
                            <select class="chzn-select" style="width:120px;" id="grid_view_item_border_style" name="<?php echo $option_name;?>[grid_view_item_border_style]">
                            <?php
							
							foreach( $df_border_style as $key=>$value ){
								if($grid_view_item_border_style == $key){ 
									echo '<option value="'.htmlspecialchars($key).'" selected="selected">'.$value.'</option>';
								}else{
									echo '<option value="'.htmlspecialchars($key).'">'.$value.'</option>';
								}
							}
                            ?>                                  
                            </select>
                        </td>
                    </tr>
                    
                    <tr valign="top">
                        <th class="titledesc" scope="rpw"><label for="grid_view_item_border_color"><?php _e('Grid View border colour','cup_cp'); ?></label></th>
                        <td class="forminp">
                            <input type="text" class="colorpick" name="<?php echo $option_name;?>[grid_view_item_border_color]" id="grid_view_item_border_color" value="<?php echo $grid_view_item_border_color;?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'cup_cp');?> <code><?php echo $default_settings['grid_view_item_border_color'] ?></code></span>
                            <div id="colorPickerDiv_content_background_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                        </td>
                    </tr>
                    
                    <tr>
                        <th class="titledesc" scope="row"><label for="grid_view_item_border_radius"><?php _e('Grid View Border radius','cup_cp'); ?></label></th>
                        <td class="forminp">
                            <select class="chzn-select" style="width:120px;" id="grid_view_item_border_radius" name="<?php echo $option_name;?>[grid_view_item_border_radius]">
                            <?php
							
							for( $i = 0 ; $i <= 19 ; $i++){
								if($grid_view_item_border_radius == $i){ 
									echo '<option value="'.htmlspecialchars($i).'" selected="selected">'.$i.'px</option>';
								}else{
									echo '<option value="'.htmlspecialchars($i).'">'.$i.'px</option>';
								}
							}
                            ?>                                  
                            </select> <span class="description"><?php _e('Create rounded corner style, Square is Default', 'cup_cp');?> <code><?php echo $default_settings['grid_view_item_border_radius'] ?>px</code></span>
                        </td>
                    </tr>
                    
        			<tr valign="top">
                        <th class="titledesc" scope="row"><label for="grid_view_item_shadow"><?php _e( 'Enable/Disable Shadow', 'cup_cp' );?></label></th>
                        <td class="forminp">                    
                            <label><input disabled="disabled" type="checkbox" <?php checked( $grid_view_item_shadow, '1' ); ?> value="1" id="grid_view_item_shadow" name="<?php echo $option_name; ?>[grid_view_item_shadow]" /> <span class=""><?php _e("Check to enable Grid View shadow effect.", 'cup_cp');?></span></label>
                        </td>
                    </tr>
                    
                    <tr valign="top">
                        <th class="titledesc" scope="rpw"><label for="grid_view_item_shadow_color"><?php _e('Grid View shadow colour','cup_cp'); ?></label></th>
                        <td class="forminp">
                            <input type="text" class="colorpick" name="<?php echo $option_name;?>[grid_view_item_shadow_color]" id="grid_view_item_shadow_color" value="<?php echo $grid_view_item_shadow_color;?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'cup_cp');?> <code><?php echo $default_settings['grid_view_item_shadow_color'] ?></code></span>
                            <div id="colorPickerDiv_content_background_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                        </td>
                    </tr>
                  </table>
	<?php
	}
}
?>