<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * People Contact Grid View Image Style Panel 
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 */
class People_Contact_Grid_View_Image_Style_Panel 
{
	public static function get_settings_default() {
		$default_settings = array(
			'item_image_background'				=> '#FFFFFF',
			'item_image_border_width'			=> '1',
			'item_image_border_style'			=> 'solid',
			'item_image_border_color'			=> '#DBDBDB',
			'item_image_border_type'			=> 'rounder',
			'item_image_padding'				=> '2',
			'item_image_shadow'					=> '1',
			'item_image_shadow_color'			=> '#DBDBDB',
		);
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'people_contact_grid_view_image_style';
		
		$default_settings = People_Contact_Grid_View_Image_Style_Panel::get_settings_default();
		
		if ($reset) {
			update_option($option_name, $default_settings);
		} else {
			update_option($option_name, $default_settings);
		}
				
	}
	
	public static function get_settings() {
		global $people_contact_grid_view_image_style;
		$people_contact_grid_view_image_style = People_Contact_Grid_View_Image_Style_Panel::get_settings_default();
		
		return $people_contact_grid_view_image_style;
	}
	
	public static function panel_page() {
		$option_name = 'people_contact_grid_view_image_style';
		if (isset($_REQUEST['bt_save_settings'])) {
			People_Contact_Grid_View_Image_Style_Panel::set_settings_default(true);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			People_Contact_Grid_View_Image_Style_Panel::set_settings_default(true);
		}
		
		$customized_settings = $default_settings = People_Contact_Grid_View_Image_Style_Panel::get_settings_default();
		
		extract($customized_settings);
		
		$df_border_style = array('solid'=>'Solid','dashed'=>'Dashed','dotted'=>'Dotted');
				
		?>
		<h3><?php _e('Profile Image Style', 'cup_cp'); ?> <a class="add-new-h2 a3-view-docs-button" target="_blank" href="<?php echo PEOPLE_CONTACT_DOCS_URI;?>#section-19" ><?php _e('View Docs', 'cup_cp'); ?></a></h3>  
                  <table cellspacing="0" class="form-table">
                    <tr>
                        <th class="titledesc" scope="row"><label for="item_image_border_type"><?php _e('Presentation Style','cup_cp'); ?></label></th>
                        <td class="forminp">
                            <select class="chzn-select" style="width:220px;" id="item_image_border_type" name="<?php echo $option_name; ?>[item_image_border_type]">
                                <option selected="selected" value="rounder"><?php _e('Rounded Border', 'cup_cp');?></option>
                                <option value="square"><?php _e('Square Border', 'cup_cp');?></option>
                                <option value="no"><?php _e('Flat Image', 'cup_cp');?></option>
                            </select>
                        </td>
                    </tr>
 				</table>
                
                <h3><?php _e('Custom Styling', 'cup_cp'); ?></h3>  
                  <table cellspacing="0" class="form-table">
                  	<tr valign="top">
                        <th class="titledesc" scope="rpw"><label for="item_image_background"><?php _e('Image Background Colour','cup_cp'); ?></label></th>
                        <td class="forminp">
                            <input type="text" class="colorpick" name="<?php echo $option_name;?>[item_image_background]" id="item_image_background" value="<?php echo $item_image_background;?>" style="width:120px;" /> <span class="description"><?php _e('Shows in Image Padding area or if image is transparent. Default', 'cup_cp');?> <code><?php echo $default_settings['item_image_background'] ?></code></span>
                            <div id="colorPickerDiv_item_image_background" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th class="titledesc" scope="rpw"><label for="item_image_padding"><?php _e('Image Padding','cup_cp'); ?></label></th>
                        <td class="forminp">
                            <input disabled="disabled" type="text" name="<?php echo $option_name;?>[item_image_padding]" id="item_image_padding" value="<?php echo $item_image_padding;?>" style="width:120px;" /> <span class="description">px. <?php _e('Overall size of image reduced by the size of padding set here.', 'cup_cp');?></span>
                        </td>
                    </tr>
                    
                    <tr>
                        <th class="titledesc" scope="row"><label for="item_image_border_width"><?php _e('Image Border weight','cup_cp'); ?></label></th>
                        <td class="forminp">
                            <select class="chzn-select" style="width:120px;" id="item_image_border_width" name="<?php echo $option_name;?>[item_image_border_width]">
                            <?php
							
							for( $i = 0 ; $i <= 19 ; $i++){
								if($item_image_border_width == $i){ 
									echo '<option value="'.htmlspecialchars($i).'" selected="selected">'.$i.'px</option>';
								}else{
									echo '<option value="'.htmlspecialchars($i).'">'.$i.'px</option>';
								}
							}
                            ?>                                  
                            </select> <span class="description"><?php _e('Default', 'cup_cp');?> <code><?php echo $default_settings['item_image_border_width'] ?>px</code></span>
                        </td>
                    </tr>
                    
                    <tr>
                        <th class="titledesc" scope="row"><label for="item_image_border_style"><?php _e('Image Border style','cup_cp'); ?></label></th>
                        <td class="forminp">
                
                            <select class="chzn-select" style="width:120px;" id="item_image_border_style" name="<?php echo $option_name;?>[item_image_border_style]">
                            <?php
							
							foreach( $df_border_style as $key=>$value ){
								if($item_image_border_style == $key){ 
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
                        <th class="titledesc" scope="rpw"><label for="item_image_border_color"><?php _e('Image Border colour','cup_cp'); ?></label></th>
                        <td class="forminp">
                            <input type="text" class="colorpick" name="<?php echo $option_name;?>[item_image_border_color]" id="item_image_border_color" value="<?php echo $item_image_border_color;?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'cup_cp');?> <code><?php echo $default_settings['item_image_border_color'] ?></code></span>
                            <div id="colorPickerDiv_item_image_border_color" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                        </td>
                    </tr>
                                    
        			<tr valign="top">
                        <th class="titledesc" scope="row"><label for="item_image_shadow"><?php _e( 'Enable/Disable Shadow', 'cup_cp' );?></label></th>
                        <td class="forminp">                    
                            <label><input disabled="disabled" type="checkbox" checked="checked" value="1" id="item_image_shadow" name="<?php echo $option_name; ?>[item_image_shadow]" /> <span class=""><?php _e("Check to enable Image shadow effect.", 'cup_cp');?></span></label>
                        </td>
                    </tr>
                    
                    <tr valign="top">
                        <th class="titledesc" scope="rpw"><label for="item_image_shadow_color"><?php _e('Image shadow colour','cup_cp'); ?></label></th>
                        <td class="forminp">
                            <input type="text" class="colorpick" name="<?php echo $option_name;?>[item_image_shadow_color]" id="item_image_shadow_color" value="<?php echo $item_image_shadow_color;?>" style="width:120px;" /> <span class="description"><?php _e('Default', 'cup_cp');?> <code><?php echo $default_settings['item_image_shadow_color'] ?></code></span>
                            <div id="colorPickerDiv_item_image_shadow_color" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
                        </td>
                    </tr>
                  </table>
	<?php
	}
}
?>