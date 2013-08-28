<?php
/**
 * Call this function when plugin is deactivated
 */
function people_contact_install(){
	update_option('a3rev_wp_people_contact_version', '1.0.8');
	$contact_us_page_id = People_Contact_Functions::create_page( esc_sql( 'contact-us-page' ), '', __('Contact Us Page', 'cup_cp'), '[people_contacts]' );
	update_option('contact_us_page_id', $contact_us_page_id);
	People_Contact_Profile_Data::install_database();
	People_Contact_Page_Settings_Panel::set_settings_default();
	People_Contact_Page_Location_Map_Panel::set_settings_default();
	People_Contact_Page_Contact_Forms_Panel::set_settings_default();
	People_Contact_Popup_Style_Panel::set_settings_default();
	People_Contact_Grid_View_Layout_Panel::set_settings_default();
	People_Contact_Grid_View_Style_Panel::set_settings_default();
	People_Contact_Grid_View_Image_Style_Panel::set_settings_default();
	People_Contact_Grid_View_Icon_Panel::set_settings_default();
	People_Contact_Widget_Settings_Panel::set_settings_default();
	People_Contact_Widget_Information_Panel::set_settings_default();
	People_Contact_Widget_Email_Contact_Form_Panel::set_settings_default();
	People_Contact_Widget_Maps_Panel::set_settings_default();
	
	update_option('a3rev_wp_people_contact_just_installed', true);
}


update_option('a3rev_wp_people_contact_plugin', 'contact_us_page_contact_people');

/**
 * Load languages file
 */
function wp_people_contact_init() {
	if ( get_option('a3rev_wp_people_contact_just_installed') ) {
		delete_option('a3rev_wp_people_contact_just_installed');
		wp_redirect( ( ( is_ssl() || force_ssl_admin() || force_ssl_login() ) ? str_replace( 'http:', 'https:', admin_url( 'admin.php?page=people-contact-manager' ) ) : str_replace( 'https:', 'http:', admin_url( 'admin.php?page=people-contact-manager' ) ) ) );
		exit;
	}
	load_plugin_textdomain( 'cup_cp', false, PEOPLE_CONTACT_FOLDER.'/languages' );
}
// Add language
add_action('init', 'wp_people_contact_init');

//Resgister Sidebar
add_action('init', array('People_Contact_Functions', 'people_contact_register_sidebar'),99);


// Load global settings when Plugin loaded
add_action( 'plugins_loaded', array( 'People_Contact_Functions', 'plugins_loaded' ), 8 );

// Add text on right of Visit the plugin on Plugin manager page
add_filter( 'plugin_row_meta', array('People_Contact_Hook_Filter', 'plugin_extra_links'), 10, 2 );

	add_action('init', array('People_Contact_AddNew', 'profile_form_action') );

	
	add_action( 'admin_menu', array( 'People_Contact_Hook_Filter', 'register_admin_screen' ),12 );
	
	add_action( 'get_header', array( 'People_Contact_Hook_Filter', 'frontend_header_scripts' ) );
		
	// Include style into header
	add_action('get_header', array('People_Contact_Hook_Filter', 'add_style_header') );
	
	// Add Custom style on frontend
	add_action( 'wp_head', array( 'People_Contact_Hook_Filter', 'include_customized_style'), 11);
	
	// Add script to fix for IE
	add_action( 'wp_head', array( 'People_Contact_Hook_Filter', 'fix_window_console_ie') );
	
	add_filter( 'body_class', array( 'People_Contact_Hook_Filter', 'browser_body_class'), 10, 2 );
	
	//Ajax Sort Contact
	add_action('wp_ajax_people_update_orders', array( 'People_Contact_Hook_Filter', 'people_update_orders') );
	add_action('wp_ajax_nopriv_people_update_orders', array( 'People_Contact_Hook_Filter', 'people_update_orders') );
				
	$GLOBALS['people_contact'] = new People_Contact();
	
	$GLOBALS['people_contact_shortcode'] = new People_Contact_Shortcode();
	
	// Include script admin plugin
	if ( in_array( basename ($_SERVER['PHP_SELF']), array('admin.php', 'edit.php') ) && isset( $_REQUEST['page'] ) && in_array( $_REQUEST['page'], array('people-contact-manager', 'people-contact', 'people-contact-settings') ) ) {
		add_action('admin_head', array('People_Contact_Hook_Filter', 'admin_header_script'));
		add_action('admin_footer', array('People_Contact_Hook_Filter', 'admin_footer_scripts'));
	}
	
	// Upgrade to 1.0.3
	if(version_compare(get_option('a3rev_wp_people_contact_version'), '1.0.3') === -1){
		People_Contact_Profile_Data::install_database();
		People_Contact_Functions::upgrade_to_1_0_3();
		update_option('a3rev_wp_people_contact_version', '1.0.3');
	}
	
	// Upgrade to 1.0.5
	if(version_compare(get_option('a3rev_wp_people_contact_version'), '1.0.5') === -1){
		People_Contact_Grid_View_Layout_Panel::set_settings_default();
		People_Contact_Grid_View_Image_Style_Panel::set_settings_default();
		update_option('a3rev_wp_people_contact_version', '1.0.5');
	}
	
	update_option('a3rev_wp_people_contact_version', '1.0.8');
?>