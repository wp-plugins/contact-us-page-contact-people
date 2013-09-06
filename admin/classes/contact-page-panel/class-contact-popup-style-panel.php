<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * People Contact Popup Style Panel
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 */
class People_Contact_Popup_Style_Panel {
	public static function get_settings_default() {
		$default_settings = array(
			'contact_popup_text_font'			=> '',
			'contact_popup_text_font_size'		=> '',
			'contact_popup_text_font_style'		=> '',
			'contact_popup_text_font_colour'	=> '',
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'people_contact_popup_style_settings';
		
		$default_settings = People_Contact_Popup_Style_Panel::get_settings_default();
				
		if ($reset) {
			update_option($option_name, $default_settings);
		} else {
			update_option($option_name, $default_settings);
		}
				
	}
	
	public static function get_settings() {
		global $people_contact_popup_style_settings;
		
		$people_contact_popup_style_settings = People_Contact_Popup_Style_Panel::get_settings_default();
		
		return $people_contact_popup_style_settings;
	}
	
	public static function panel_page() {
		$option_name = 'people_contact_popup_style_settings';
		if (isset($_REQUEST['bt_save_settings'])) {
			People_Contact_Popup_Style_Panel::set_settings_default(true);
		} elseif ( isset($_REQUEST['bt_reset_settings']) ) {
			People_Contact_Popup_Style_Panel::set_settings_default(true);
		}
		
		$customized_settings = $default_settings = People_Contact_Popup_Style_Panel::get_settings_default();
		
		extract($customized_settings);
		
		$fonts = People_Contact_Functions::get_font();
				
		?>
        <h3><?php _e('Email Pop-up Font Styling', 'cup_cp'); ?> <a class="add-new-h2 a3-view-docs-button" target="_blank" href="<?php echo PEOPLE_CONTACT_DOCS_URI;?>#section-15" ><?php _e('View Docs', 'cup_cp'); ?></a></h3>
		<table class="form-table">
			<tr>
				<th class="titledesc" scope="row"><label for="contact_popup_text_font"><?php _e('Font', 'cup_cp');?></label></th>
				<td class="forminp">
					<select class="chzn-select" style="width:120px;" id="contact_popup_text_font" name="<?php echo $option_name; ?>[contact_popup_text_font]">
						<option value="" selected="selected"><?php _e('Select Font', 'cup_cp');?></option>
						<?php foreach($fonts as $key=>$value){ ?>
                        <option value='<?php echo htmlspecialchars($key); ?>'><?php echo $value; ?></option>
						<?php } ?>                                  
					</select> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'cup_cp');?></span>
				</td>
			</tr>
			<tr>
				<th class="titledesc" scope="row"><label for="contact_popup_text_font_size"><?php _e('Font Size', 'cup_cp');?></label></th>
				<td class="forminp">
					<select class="chzn-select" style="width:120px;" id="contact_popup_text_font_size" name="<?php echo $option_name; ?>[contact_popup_text_font_size]">
						<option value="" selected="selected"><?php _e('Select Size', 'cup_cp');?></option>
                        <?php for( $i = 9 ; $i <= 40 ; $i++ ){ ?>
                        <option value="<?php echo ($i); ?>px" ><?php echo $i; ?>px</option>
                        <?php } ?>                                  
                        </select> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'cup_cp');?></span>
                    </td>
			</tr>
			<tr>
				<th class="titledesc" scope="row"><label for="contact_popup_text_font_style"><?php _e('Font Style', 'cup_cp');?></label></th>
				<td class="forminp">
					<select class="chzn-select" style="width:120px;" id="contact_popup_text_font_style" name="<?php echo $option_name; ?>[contact_popup_text_font_style]">
						<option value="" selected="selected"><?php _e('Select Style', 'cup_cp');?></option>
						<option value="normal"><?php _e('Normal', 'cup_cp');?></option>
						<option value="italic"><?php _e('Italic', 'cup_cp');?></option>
						<option value="bold"><?php _e('Bold', 'cup_cp');?></option>
						<option value="bold_italic"><?php _e('Bold/Italic', 'cup_cp');?></option>
					</select> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'cup_cp');?></span>
				</td>
			</tr>
			<tr valign="top">
				<th class="titledesc" scope="rpw"><label for="contact_popup_text_font_colour"><?php _e('Font Colour','cup_cp'); ?></label></th>
				<td class="forminp">
					<input type="text" class="colorpick" name="<?php echo $option_name; ?>[contact_popup_text_font_colour]" id="contact_popup_text_font_colour" value="" style="width:120px;" /> <span class="description"><?php _e('&lt;empty&gt; to use theme style', 'cup_cp');?></span>
					<div id="colorPickerDiv_inquiry_contact_popup_text_font_colour" class="colorpickdiv" style="z-index: 100;background:#eee;border:1px solid #ccc;position:absolute;display:none;"></div>
				</td>
			</tr>
		</table>
	<?php
	}
}
?>