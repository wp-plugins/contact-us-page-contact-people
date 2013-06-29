<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * People Contact Widget Email Contact Form Panel
 *
 * Table Of Contents
 *
 * get_settings_default()
 * set_settings_default()
 * get_settings()
 * panel_page()
 */
class People_Contact_Widget_Email_Contact_Form_Panel 
{
	public static function get_settings_default() {
		$default_settings = array(
			'widget_show_contact_form'					=> 0,
			'widget_email_from_name'					=> get_bloginfo('blogname'),
			'widget_email_from_address'					=> get_bloginfo('admin_email'),
			'widget_send_copy'							=> 'no',
			'widget_email_to'							=> get_bloginfo('admin_email'),
			'widget_email_cc'							=> '',
			'widget_input_shortcode'					=> '',
		);
		
		return $default_settings;
	}
	
	public static function set_settings_default($reset=false) {
		$option_name = 'people_contact_widget_email_contact_form';
		$customized_settings = get_option($option_name);
		if ( !is_array($customized_settings) ) $customized_settings = array();
		
		$default_settings = People_Contact_Widget_Email_Contact_Form_Panel::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		$free_default_settings = $default_settings;
		unset($free_default_settings['widget_show_contact_form']);
		unset($free_default_settings['widget_email_to']);
		unset($free_default_settings['widget_email_cc']);
		unset($free_default_settings['widget_input_shortcode']);
		$customized_settings = array_merge($customized_settings, $free_default_settings);
		
		if ($reset) {
			update_option($option_name, $default_settings);
		} else {
			update_option($option_name, $customized_settings);
		}
				
	}
	
	public static function get_settings() {
		global $people_contact_widget_email_contact_form;
		$customized_settings = get_option('people_contact_widget_email_contact_form');
		if ( !is_array($customized_settings) ) $customized_settings = array();
		$default_settings = People_Contact_Widget_Email_Contact_Form_Panel::get_settings_default();
		
		$customized_settings = array_merge($default_settings, $customized_settings);
		
		foreach ($customized_settings as $key => $value) {
			if (!isset($default_settings[$key])) continue;
			
			if ( !is_array($default_settings[$key]) ) {
				if ( trim($value) == '' ) $customized_settings[$key] = $default_settings[$key];
				else $customized_settings[$key] = esc_attr( stripslashes( $value ) );
			}
		}
		
		$people_contact_widget_email_contact_form = $customized_settings;
		
		return $customized_settings;
	}
	
	public static function panel_page() {
		
		$option_name = 'people_contact_widget_email_contact_form';
		if (isset($_REQUEST['bt_save_settings'])) {
			
			$customized_settings = $_REQUEST[$option_name];
			if (!isset($customized_settings['widget_show_contact_form'])) $customized_settings['widget_show_contact_form'] = 0;
			update_option($option_name, $customized_settings);
		}elseif (isset($_REQUEST['bt_reset_settings'])) {
			People_Contact_Widget_Email_Contact_Form_Panel::set_settings_default(true);
		}
		
		$customized_settings = get_option($option_name);
		$default_settings = People_Contact_Widget_Email_Contact_Form_Panel::get_settings_default();
		if ( !is_array($customized_settings) ) $customized_settings = $default_settings;
		else $customized_settings = array_merge($default_settings, $customized_settings);
		
		extract($customized_settings);
				
		?>
		
        <h3><?php _e('Default Email Contact Form', 'cup_cp'); ?></h3>
		<table class="form-table">   
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="widget_show_contact_form"><?php _e( 'Enable/Disable Contact Form', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <label><input type="checkbox" <?php checked( $widget_show_contact_form, '1' ); ?> value="1" id="widget_show_contact_form" name="<?php echo $option_name; ?>[widget_show_contact_form]" /> <span class=""><?php _e("Check to enable default email contact form after content on widget.", 'cup_cp');?></span></label>
				</td>
			</tr>
        </table>
        
        <div class="pro_feature_fields">
        <h3><?php _e('Email Sender', 'cup_cp'); ?></h3>
        <p><?php _e('The following options affect the sender (email address and name) used in Contact Us Widget.', 'cup_cp'); ?></p>
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="widget_email_from_name"><?php _e( '"From" Name', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <input disabled="disabled" type="text" value="<?php esc_attr_e( stripslashes( $widget_email_from_name ) ); ?>" name="<?php echo $option_name; ?>[widget_email_from_name]" id="widget_email_from_name" style="width:300px;"  /> <span class="description"><?php _e('&lt;empty&gt; defaults to Site Title', 'cup_cp');?></span>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="widget_email_from_address"><?php _e( '"From" Email Address', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <input disabled="disabled" type="text" value="<?php esc_attr_e( stripslashes( $widget_email_from_address ) ); ?>" name="<?php echo $option_name; ?>[widget_email_from_address]" id="widget_email_from_address" style="width:300px;"  /> <span class="description"><?php _e('&lt;empty&gt; defaults to WordPress admin email address', 'cup_cp');?></span>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="widget_send_copy"><?php _e( 'Send Copy to Sender', 'cup_cp' );?></label></th>
		    	<td class="forminp">
                	<label><input disabled="disabled" type="checkbox" value="yes" id="widget_send_copy" name="<?php echo $option_name; ?>[widget_send_copy]" /> <span class=""><?php _e('Checked adds opt in/out option to the bottom of the Contact Us Widget form.', 'cup_cp');?></span></label>
				</td>
			</tr>
		</table>
        </div>
        
        <h3><?php _e('Email Delivery', 'cup_cp'); ?></h3>
		<table class="form-table">
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="widget_email_to"><?php _e( 'Inquiry Email goes to', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $widget_email_to ) ); ?>" name="<?php echo $option_name; ?>[widget_email_to]" id="widget_email_to" style="width:300px;"  /> <span class="description"><?php _e('&lt;empty&gt; defaults to WordPress admin email address', 'cup_cp');?></span>
				</td>
			</tr>
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="widget_email_cc"><?php _e( 'CC', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" value="<?php esc_attr_e( stripslashes( $widget_email_cc ) ); ?>" name="<?php echo $option_name; ?>[widget_email_cc]" id="widget_email_cc" style="width:300px;"  /> <span class="description"><?php _e("&lt;empty&gt; defaults to 'no copy sent' or add an email address", 'cup_cp');?></span>
				</td>
			</tr>
		</table>
        <h3><?php _e('Contact Form from another Plugin', 'cup_cp'); ?></h3>
        <p><?php _e('Create the widget contact us form by entering a shortcode from any contact form plugin. <strong>Important</strong> - disable the Default Email Contact form setting at top of this page.', 'cup_cp'); ?></p>
        <table class="form-table">   
            
            <tr valign="top">
		    	<th class="titledesc" scope="row"><label for="widget_input_shortcode"><?php _e( 'Form Shortcode', 'cup_cp' );?></label></th>
		    	<td class="forminp">                    
                    <input type="text" id="widget_input_shortcode" class="map_option" name="<?php echo $option_name; ?>[widget_input_shortcode]" value='<?php echo stripslashes($widget_input_shortcode);?>' style="width:300px" />
				</td>
			</tr>
            
		</table>
	<?php
	}
}
?>