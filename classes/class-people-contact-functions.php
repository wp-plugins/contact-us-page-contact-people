<?php
/**
 * People Contact Functions
 *
 * Table Of Contents
 *
 * plugins_loaded()
 * create_page()
 * people_contact_register_sidebar()

 */
class People_Contact_Functions 
{	
	
	/** 
	 * Set global variable when plugin loaded
	 */
	public static function plugins_loaded() {
		
	}
	
	public static function contact_to_people( $profile_data = array(), $send_copy_yourself = 1 ) {
		global $people_contact_contact_forms_settings;
		
		$contact_success = __("Thanks for your contact - we'll be in touch with you as soon as possible!", 'cup_cp');
		
		$to_email = esc_attr( stripslashes( $profile_data['to_email'] ) );
			
		$from_name = get_option('blogname');
			
		$from_email = get_option('admin_email');
			
			$headers = array();
			$headers[] = 'MIME-Version: 1.0';
			$headers[] = 'Content-type: text/html; charset='. get_option('blog_charset');
			$headers[] = 'From: '.$from_name.' <'.$from_email.'>';
			$headers_yourself = $headers;
			
			$subject_yourself = __('[Copy]:', 'cup_cp').' '. stripslashes( $profile_data['subject'] );
			
			$content = '
	<table width="99%" cellspacing="0" cellpadding="1" border="0" bgcolor="#eaeaea"><tbody>
	  <tr>
		<td>
		  <table width="100%" cellspacing="0" cellpadding="5" border="0" bgcolor="#ffffff"><tbody>
			<tr bgcolor="#eaf2fa">
			  <td colspan="2"><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px"><strong>'.__('Profile Name', 'cup_cp').'</strong></font> 
			  </td></tr>
			<tr bgcolor="#ffffff">
			  <td width="20">&nbsp;</td>
			  <td><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px">[profile_name]</font> </td></tr>
			<tr bgcolor="#eaf2fa">
			  <td colspan="2"><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px"><strong>'.__('Contact Name', 'cup_cp').'</strong></font> 
			  </td></tr>
			<tr bgcolor="#ffffff">
			  <td width="20">&nbsp;</td>
			  <td><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px">[contact_name]</font> </td></tr>
			<tr bgcolor="#eaf2fa">
			  <td colspan="2"><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px"><strong>'.__('Contact Email Address', 'cup_cp').'</strong></font> </td></tr>
			<tr bgcolor="#ffffff">
			  <td width="20">&nbsp;</td>
			  <td><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px"><a target="_blank" href="mailto:[contact_email]">[contact_email]</a></font> 
			  </td></tr>
			<tr bgcolor="#eaf2fa">
			  <td colspan="2"><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px"><strong>'.__('Contact Phone', 'cup_cp').'</strong></font> </td></tr>
			<tr bgcolor="#ffffff">
			  <td width="20">&nbsp;</td>
			  <td><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px">[contact_phone]</font> </td></tr>
			<tr bgcolor="#eaf2fa">
			  <td colspan="2"><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px"><strong>'.__('Message', 'cup_cp').'</strong></font> </td></tr>
			<tr bgcolor="#ffffff">
			  <td width="20">&nbsp;</td>
			  <td><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px">[message]</font> 
		  </td></tr></tbody></table></td></tr></tbody></table>';
		  
			$content = str_replace('[profile_name]', esc_attr( stripslashes( $profile_data['profile_name']) ), $content);
			$content = str_replace('[contact_name]', esc_attr( stripslashes( $profile_data['contact_name']) ), $content);
			$content = str_replace('[contact_email]', esc_attr( stripslashes( $profile_data['contact_email']) ), $content);
			$content = str_replace('[contact_phone]', esc_attr( stripslashes( $profile_data['contact_phone']) ), $content);
			$content = str_replace('[message]', wpautop( stripslashes( $profile_data['message']) ), $content);
			
			$content = apply_filters('people_contact_contact_profile_content', $content, $profile_data );
			
			// Filters for the email
			add_filter( 'wp_mail_from', array( 'People_Contact_Functions', 'profile_get_from_address' ) );
			add_filter( 'wp_mail_from_name', array( 'People_Contact_Functions', 'profile_get_from_name' ) );
			add_filter( 'wp_mail_content_type', array( 'People_Contact_Functions', 'get_content_type' ) );
			
			wp_mail( $to_email, stripslashes( $profile_data['subject'] ), $content, $headers, '' );
						
			// Unhook filters
			remove_filter( 'wp_mail_from', array( 'People_Contact_Functions', 'profile_get_from_address' ) );
			remove_filter( 'wp_mail_from_name', array( 'People_Contact_Functions', 'profile_get_from_name' ) );
			remove_filter( 'wp_mail_content_type', array( 'People_Contact_Functions', 'get_content_type' ) );
			return $contact_success;
	}
	
	public static function contact_to_site( $contact_data = array(), $send_copy_yourself = 1 ) {
		global $people_contact_widget_email_contact_form;
					
		$contact_success = __("Thanks for your contact - we'll be in touch with you as soon as possible!", 'cup_cp');
		
		if ( $people_contact_widget_email_contact_form['widget_email_to'] == '' )
			$to_email = get_option('admin_email');
		else
			$to_email = $people_contact_widget_email_contact_form['widget_email_to'];
			
		$cc_emails = '';
		if ( trim( $people_contact_widget_email_contact_form['widget_email_cc']) != '' ) 
			$cc_emails = $people_contact_widget_email_contact_form['widget_email_cc'];
		
		$from_name = get_option('blogname');
			
		$from_email = get_option('admin_email');
				
			$headers = array();
			$headers[] = 'MIME-Version: 1.0';
			$headers[] = 'Content-type: text/html; charset='. get_option('blog_charset');
			$headers[] = 'From: '.$from_name.' <'.$from_email.'>';
			$headers_yourself = $headers;
			
			if (trim($cc_emails) != '') {
				$cc_emails_a = explode("," , $cc_emails);
				if (is_array($cc_emails_a) && count($cc_emails_a) > 0) {
					foreach ($cc_emails_a as $cc_email) {
						$headers[] = 'Cc: '.$cc_email;
					}
				} else {
					$headers[] = 'Cc: '.$cc_emails;
				}
			}
			
			$subject_yourself = __('[Copy]:', 'cup_cp').' '. stripslashes( $contact_data['subject']) ;
			
			$content = '
	<table width="99%" cellspacing="0" cellpadding="1" border="0" bgcolor="#eaeaea"><tbody>
	  <tr>
		<td>
		  <table width="100%" cellspacing="0" cellpadding="5" border="0" bgcolor="#ffffff"><tbody>
			<tr bgcolor="#eaf2fa">
			  <td colspan="2"><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px"><strong>'.__('Name', 'cup_cp').'</strong></font> 
			  </td></tr>
			<tr bgcolor="#ffffff">
			  <td width="20">&nbsp;</td>
			  <td><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px">[contact_name]</font> </td></tr>
			<tr bgcolor="#eaf2fa">
			  <td colspan="2"><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px"><strong>'.__('Email Address', 'cup_cp').'</strong></font> </td></tr>
			<tr bgcolor="#ffffff">
			  <td width="20">&nbsp;</td>
			  <td><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px"><a target="_blank" href="mailto:[contact_email]">[contact_email]</a></font> 
			  </td></tr>
			<tr bgcolor="#eaf2fa">
			  <td colspan="2"><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px"><strong>'.__('Message', 'cup_cp').'</strong></font> </td></tr>
			<tr bgcolor="#ffffff">
			  <td width="20">&nbsp;</td>
			  <td><font style="FONT-FAMILY:sans-serif;FONT-SIZE:12px">[message]</font> 
		  </td></tr></tbody></table></td></tr></tbody></table>';
		  
			$content = str_replace('[contact_name]', esc_attr( stripslashes( $contact_data['contact_name']) ), $content);
			$content = str_replace('[contact_email]', esc_attr( stripslashes( $contact_data['contact_email']) ), $content);
			$content = str_replace('[message]', wpautop( stripslashes( $contact_data['message']) ), $content);
			
			$content = apply_filters('people_contact_contact_site_content', $content, $contact_data );
			
			// Filters for the email
			add_filter( 'wp_mail_from', array( 'People_Contact_Functions', 'get_from_address' ) );
			add_filter( 'wp_mail_from_name', array( 'People_Contact_Functions', 'get_from_name' ) );
			add_filter( 'wp_mail_content_type', array( 'People_Contact_Functions', 'get_content_type' ) );
			
			wp_mail( $to_email, stripslashes( $contact_data['subject'] ), $content, $headers, '' );
			
			
			// Unhook filters
			remove_filter( 'wp_mail_from', array( 'People_Contact_Functions', 'get_from_address' ) );
			remove_filter( 'wp_mail_from_name', array( 'People_Contact_Functions', 'get_from_name' ) );
			remove_filter( 'wp_mail_content_type', array( 'People_Contact_Functions', 'get_content_type' ) );
			
			return $contact_success;
	}
	
	public static function profile_get_from_address() {
		$from_email = get_option('admin_email');
			
		return $from_email;
	}
	
	public static function profile_get_from_name() {
		$from_name = get_option('blogname');
			
		return $from_name;
	}
	
	public static function get_from_address() {
		$from_email = get_option('admin_email');
			
		return $from_email;
	}
	
	public static function get_from_name() {
		$from_name = get_option('blogname');
			
		return $from_name;
	}
	
	public static function get_content_type() {
		return 'text/html';
	}
		
	/**
	 * Create Page
	 */
	public static function create_page( $slug, $option, $page_title = '', $page_content = '', $post_parent = 0 ) {
		global $wpdb;
				
		$page_id = $wpdb->get_var( "SELECT ID FROM `" . $wpdb->posts . "` WHERE `post_content` LIKE '%$page_content%'  AND `post_type` = 'page' ORDER BY ID DESC LIMIT 1" );
		 
		if ( $page_id != NULL ) 
			return $page_id;
		
		$page_data = array(
			'post_status' 		=> 'publish',
			'post_type' 		=> 'page',
			'post_author' 		=> 1,
			'post_name' 		=> $slug,
			'post_title' 		=> $page_title,
			'post_content' 		=> $page_content,
			'post_parent' 		=> $post_parent,
			'comment_status' 	=> 'closed'
		);
		$page_id = wp_insert_post( $page_data );
		
		return $page_id;
	}
	
	public static function people_contact_register_sidebar() {
		global $wpdb;
		register_sidebar(array(
		  'name' => __( 'Contact Page Sidebar', 'cup_cp' ),
		  'id' => 'contact-us-sidebar',
		  'description' => __( 'Contact Page Widgets area.', 'cup_cp' ),
		  'before_widget' => '<div id="%1$s" class="widget %2$s">',
		  'after_widget' => '</div>',
		  'before_title' => '<h3>',
		  'after_title' => '</h3><div style="clear:both;"></div>'
		));
	}
	
	public static function plugin_extension_start() {
		global $people_contact_admin_init;
		
		$people_contact_admin_init->plugin_extension_start();
	}
	
	public static function plugin_extension_end() {
		global $people_contact_admin_init;
		
		$people_contact_admin_init->plugin_extension_end();
	}
	
	public static function plugin_pro_notice() {
		$html = '';
		$html .= '<a href="http://a3rev.com/shop/" target="_blank" style="float:right;margin-top:5px; margin-left:10px;" ><img src="'.PEOPLE_CONTACT_IMAGE_URL.'/a3logo.png" /></a>';
		$html .= '<h3>'.__('Upgrade available for Extra Functionality', 'cup_cp').'</h3>';
		$html .= '<p>'.__("<strong>NOTE:</strong> All the functions inside the Yellow border are extra functionality that is only available by upgrading to one of 2 fully supported Pro Version plugins", 'cup_cp').':</p>';
		$html .= '<h3>* <a href="'.PEOPLE_CONTACT_AUTHOR_URI.'" target="_blank">'.__('Contact Us Page - Contact People Pro', 'cup_cp').'</a></h3>';
		$html .= '<h3>'.__('Pro Version Features', 'cup_cp').':</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>1. '.__("Profile Contact Grid WYSIWYG Style & Layout editor.", 'cup_cp').'</li>';
		$html .= '<li>2. '.__("Upload custom icons - 'No Image' and contact icons.", 'cup_cp').'</li>';
		$html .= '<li>3. '.__("Profile Short Description feature.", 'cup_cp').'</li>';
		$html .= '<li>4. '.__('Individual Profile Contact Profile Shortcode feature.', 'cup_cp').'</li>';
		$html .= '<li>5. '.__('Create custom contact form for Profiles.', 'cup_cp').'</li>';
		$html .= '<li>6. '.__("Integration with Contact Form 7 & Gravity Forms.", 'cup_cp').'</li>';
		$html .= '<li>7. '.__("Add unique contact forms for individual profiles.", 'cup_cp').'</li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '<h3>* <a href="'.PEOPLE_CONTACT_ULTIMATE_URI.'" target="_blank">'.__('Contact People Ultimate', 'cup_cp').'</a></h3>';
		$html .= '<h3>'.__('Ultimate Version Features', 'cup_cp').':</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>1. '.__("Includes all Contact Us Page Pro features plus.", 'cup_cp').'</li>';
		$html .= '<li>2. '.__("Groups - Create groups and assign Profiles to groups.", 'cup_cp').'</li>';
		$html .= '<li>3. '.__("Add Groups to posts and page via shortcode.", 'cup_cp').'</li>';
		$html .= '<li>4. '.__('Show Group with or without Google map.', 'cup_cp').'</li>';
		$html .= '<li>5. '.__('Set Group Column layout display.', 'cup_cp').'</li>';
		$html .= '<li>6. '.__("Show or don't show Group title.", 'cup_cp').'</li>';
		$html .= '<li>7. '.__("Sort Profile Order within groups.", 'cup_cp').'</li>';
		$html .= '<li>8. '.__("Show multiple groups on the same page.", 'cup_cp').'</li>';
		$html .= '</ul>';
		$html .= '</p>';
		$html .= '<h3>'.__('View this plugins', 'cup_cp').' <a href="http://docs.a3rev.com/user-guides/plugins-extensions/woocommerce/contact-us-page-contact-people/" target="_blank">'.__('documentation', 'cup_cp').'</a></h3>';
		$html .= '<h3>'.__('Visit this plugins', 'cup_cp').' <a href="http://wordpress.org/support/plugin/contact-us-page-contact-people/" target="_blank">'.__('support forum', 'cup_cp').'</a></h3>';
		$html .= '<h3>'.__('More FREE a3rev WordPress plugins', 'cup_cp').'</h3>';
		$html .= '<p>';
		$html .= '<ul style="padding-left:10px;">';
		$html .= '<li>* <a href="http://wordpress.org/plugins/wp-email-template/" target="_blank">'.__('WordPress Email Template', 'cup_cp').'</a></li>';
		$html .= '<li>* <a href="http://wordpress.org/plugins/page-views-count/" target="_blank">'.__('Page View Count', 'cup_cp').'</a></li>';
		$html .= '</ul>';
		$html .= '</p>';
		return $html;
	}
	
	public static function extension_shortcode() {
		$html = '';
		$html .= '<div id="a3_plugin_shortcode_extensions">'.__("Upgrading to the", 'cup_cp').' <a target="_blank" href="'.PEOPLE_CONTACT_AUTHOR_URI.'">'.__('Pro Version', 'cup_cp').'</a> '.__("activates this shortcode feature as well.", 'cup_cp').'</div>';
		return $html;	
	}
	
	public static function ultimate_extension_shortcode() {
		$html = '';
		$html .= '<div id="a3_plugin_shortcode_extensions">'.__("Upgrading to the", 'cup_cp').' <a target="_blank" href="'.PEOPLE_CONTACT_ULTIMATE_URI.'">'.__('Ultimate Version', 'cup_cp').'</a> '.__("activates this shortcode feature as well.", 'cup_cp').'</div>';
		return $html;	
	}
	
	public static function upgrade_to_1_0_3() {
		$contacts = get_option('contact_arr');
		if ( is_array($contacts) && count($contacts) > 0 ) {
			$i = 0;
			foreach ( $contacts as $key => $value ) {
				$i++;
				$new_value = array();
				foreach ( $value as $key => $field ) {
					$new_value[$key] = esc_attr( stripslashes( $field ) );
				}
				$new_value['c_order'] = $i;
				People_Contact_Profile_Data::insert_row( $new_value );
			}
		}
	}
}
?>