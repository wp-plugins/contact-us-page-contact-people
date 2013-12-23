<?php
/**
 * People Contact Hook Filter
 *
 * Table Of Contents
 *
 * register_admin_screen()
 * contact_manager_load_only_script()
 * add_new_load_only_script()
 * admin_header_script()
 * people_update_orders()
 * a3_wp_admin()
 * admin_sidebar_menu_css()
 * plugin_extra_links()
 *
 */
class People_Contact_Hook_Filter
{
	public static function register_admin_screen () {
		global $query_string, $current_user;
		$current_user_id = $current_user->user_login;
	
		$contact_manager = add_menu_page( __('Contact Us', 'cup_cp'), __('Contact Us', 'cup_cp'), 'manage_options', 'people-contact-manager', array( 'People_Contact_Manager_Panel', 'admin_screen' ), null, '27.222');
		
		$profile = add_submenu_page('people-contact-manager', __( 'Profiles', 'cup_cp' ), __( 'Profiles', 'cup_cp' ), 'manage_options', 'people-contact-manager', array( 'People_Contact_Manager_Panel', 'admin_screen' ) );
		
		$add_new = add_submenu_page('people-contact-manager', __( 'Add New Profile', 'cup_cp' ), __( 'Add New Profile', 'cup_cp' ), 'manage_options', 'people-contact', array( 'People_Contact_AddNew', 'admin_screen_add_edit' ) );
		
		$categories_page = add_submenu_page('people-contact-manager', __( 'Groups', 'cup_cp' ), __( 'Groups', 'cup_cp' ), 'manage_options', 'people-category-manager', array( 'People_Category_Manager_Panel', 'admin_screen' ) );
		
		add_action( "admin_print_scripts-" . $contact_manager, array( 'People_Contact_Hook_Filter', 'contact_manager_load_only_script') );
		add_action( "admin_print_scripts-" . $profile, array( 'People_Contact_Hook_Filter', 'contact_manager_load_only_script') );
		add_action( "admin_print_scripts-" . $add_new, array( 'People_Contact_Hook_Filter', 'add_new_load_only_script') );
		add_action( "admin_print_scripts-" . $categories_page, array( 'People_Contact_Hook_Filter', 'category_manager_load_only_script') );
	
	} // End register_admin_screen()
	
	public static function add_style_header() {
		wp_enqueue_style( 'people_contact_style', PEOPLE_CONTACT_CSS_URL.'/style.css' );
	}
	
	public static function add_google_fonts() {
		global $people_contact_fonts_face;
		global $people_email_inquiry_popup_form_style;
		
		$google_fonts = array( $people_email_inquiry_popup_form_style['inquiry_contact_heading_font']['face'], $people_email_inquiry_popup_form_style['inquiry_form_site_name_font']['face'], $people_email_inquiry_popup_form_style['inquiry_form_profile_position_font']['face'], $people_email_inquiry_popup_form_style['inquiry_form_profile_name_font']['face'], $people_email_inquiry_popup_form_style['inquiry_contact_popup_text']['face'], $people_email_inquiry_popup_form_style['inquiry_contact_button_font']['face'] );
		
		$people_contact_fonts_face->generate_google_webfonts( $google_fonts );
	}
	
	public static function include_customized_style() { 
		include( PEOPLE_CONTACT_DIR. '/templates/customized_style.php' );
	}
	
	public static function fix_window_console_ie() {
	?>
    <script type="text/javascript">
		if(!(window.console && console.log)) {
			console = {
				log: function(){},
				debug: function(){},
				info: function(){},
				warn: function(){},
				error: function(){}
			};
		}
	</script>

    <?php	
	}
	
	public static function browser_body_class( $classes, $class = '' ) {
		if ( !is_array($classes) ) $classes = array();
		
		global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
 
		if($is_lynx) $classes[] = 'lynx';
		elseif($is_gecko) $classes[] = 'gecko';
		elseif($is_opera) $classes[] = 'opera';
		elseif($is_NS4) $classes[] = 'ns4';
		elseif($is_safari) $classes[] = 'safari';
		elseif($is_chrome) $classes[] = 'chrome';
		elseif($is_IE) {
			$browser = $_SERVER['HTTP_USER_AGENT'];
			$browser = substr( "$browser", 25, 8);
			if ($browser == "MSIE 7.0"  ) {
				$classes[] = 'ie7';
				$classes[] = 'ie';
			} elseif ($browser == "MSIE 6.0" ) {
				$classes[] = 'ie6';
				$classes[] = 'ie';
			} elseif ($browser == "MSIE 8.0" ) {
				$classes[] = 'ie8';
				$classes[] = 'ie';
			} elseif ($browser == "MSIE 9.0" ) {
				$classes[] = 'ie9';
				$classes[] = 'ie';
			} else {
				$classes[] = 'ie';
			}
		} else { $classes[] = 'unknown'; }
 
		if( $is_iphone ) $classes[] = 'iphone';
		
		return $classes;

	}
	
	public static function frontend_header_scripts() {
		wp_enqueue_script('jquery');
		
		global $is_IE;
		if($is_IE){ wp_enqueue_script( 'respondjs', PEOPLE_CONTACT_JS_URL . '/respond-ie.js' ); }	
	}
	
	public static function frontend_footer_scripts() {
	?>
    	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			$(document).on("click", ".people_email_inquiry_form_button", function(){	
				var contact_id = $(this).attr("contact_id");
				var people_email_inquiry_error = "";
				var people_email_inquiry_have_error = false;
						
				var filter = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				var profile_email = $("#profile_email_" + contact_id).val();
				var profile_name = $("#profile_name_" + contact_id).val();
				var c_name = $("#c_name_" + contact_id).val();
				var c_subject = $("#c_subject_" + contact_id).val();
				var c_email = $("#c_email_" + contact_id).val();
				var c_phone = $("#c_phone_" + contact_id).val();
				var c_message = $("#c_message_" + contact_id).val();
				var send_copy = 0;
				if ( $("#send_copy_" + contact_id).is(':checked') )
					send_copy = 1;
				
				if (c_name.replace(/^\s+|\s+$/g, '') == "") {
					people_email_inquiry_error += "<?php _e('Please enter your Name', 'cup_cp'); ?>\n";
					people_email_inquiry_have_error = true;
				}
				if (c_email == "" || !filter.test(c_email)) {
					people_email_inquiry_error += "<?php _e('Please enter valid Email address', 'cup_cp'); ?>\n";
					people_email_inquiry_have_error = true;
				}
				if (c_phone.replace(/^\s+|\s+$/g, '') == "") {
					people_email_inquiry_error += "<?php _e('Please enter your Phone', 'cup_cp'); ?>\n";
					people_email_inquiry_have_error = true;
				}
				if (c_message.replace(/^\s+|\s+$/g, '') == "") {
					people_email_inquiry_error += "<?php _e('Please enter your Message', 'cup_cp'); ?>\n";
					people_email_inquiry_have_error = true;
				}
				
				if (people_email_inquiry_have_error) {
					alert(people_email_inquiry_error);
					return false;
				}
				
				$(this).attr("disabled", "disabled");
				
				var wait = $('.ajax-wait');
				wait.css('display','block');
				
				var data = {
					action: 		"send_a_contact",
					contact_id: 	contact_id,
					profile_email:	profile_email,
					profile_name:	profile_name,
					c_name: 		c_name,
					c_email: 		c_email,
					c_phone: 		c_phone,
					c_subject:		c_subject,
					c_message: 		c_message,
					send_copy:		send_copy,
					security: 		"<?php echo wp_create_nonce("send-a-contact");?>"
				};
	
				$.post( '<?php echo admin_url('admin-ajax.php', 'relative');?>', data, function(response) {
					$('#people_email_inquiry_content_' + contact_id ).html(response);
					wait.css('display','none');
				});
				return false;
			});
		});
		</script>
    <?php	
	}
	
	public static function contact_manager_load_only_script(){
		wp_enqueue_script('jquery-ui-sortable');
	}
	
	public static function category_manager_load_only_script() {
		wp_enqueue_script('jquery-ui-sortable');
	}
	
	public static function add_new_load_only_script(){
		wp_enqueue_script('jquery-ui-autocomplete', '', array('jquery-ui-widget', 'jquery-ui-position'), '1.8.6');
		wp_enqueue_script('maps-googleapis','https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false' );
	}
	
	public static function admin_header_script() {
		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		
		wp_register_style( 'people_contact_manager', PEOPLE_CONTACT_CSS_URL.'/admin.css' );
		wp_enqueue_style( 'people_contact_manager' );
	}
		
	public static function people_update_orders() {
		check_ajax_referer( 'people_update_orders', 'security' );
		$updateRecordsArray  = $_REQUEST['recordsArray'];
		$i = 0;
		foreach ($updateRecordsArray as $recordIDValue) {
			$i++;
			People_Contact_Profile_Data::update_order($recordIDValue, $i);
		}
		die();
	}
	
	public static function a3_wp_admin() {
		wp_enqueue_style( 'a3rev-wp-admin-style', PEOPLE_CONTACT_CSS_URL . '/a3_wp_admin.css' );
	}
	
	public static function admin_sidebar_menu_css() {
		wp_enqueue_style( 'a3rev-people-contact-admin-sidebar-menu-style', PEOPLE_CONTACT_CSS_URL . '/admin_sidebar_menu.css' );
	}
	
	public static function plugin_extra_links($links, $plugin_name) {
		if ( $plugin_name != PEOPLE_CONTACT_NAME) {
			return $links;
		}
		$links[] = '<a href="http://docs.a3rev.com/user-guides/plugins-extensions/woocommerce/contact-us-page-contact-people/" target="_blank">'.__('Documentation', 'cup_cp').'</a>';
		$links[] = '<a href="http://wordpress.org/support/plugin/contact-us-page-contact-people/" target="_blank">'.__('Support', 'cup_cp').'</a>';
		return $links;
	}
}
?>