<?php
/**
 * Call this function when plugin is deactivated
 */
function people_contact_install(){
	update_option('a3rev_wp_people_contact_version', '1.1.2.2');
	$contact_us_page_id = People_Contact_Functions::create_page( esc_sql( 'contact-us-page' ), '', __('Contact Us Page', 'cup_cp'), '[people_contacts]' );
	update_option('contact_us_page_id', $contact_us_page_id);
	People_Contact_Profile_Data::install_database();
	
	// Set Settings Default from Admin Init
	global $people_contact_admin_init;
	$people_contact_admin_init->set_default_settings();
	
	update_option('a3rev_wp_people_contact_just_installed', true);
}


update_option('a3rev_wp_people_contact_plugin', 'contact_us_page_contact_people');

/**
 * Load languages file
 */
function wp_people_contact_init() {
	if ( get_option('a3rev_wp_people_contact_just_installed') ) {
		delete_option('a3rev_wp_people_contact_just_installed');
		wp_redirect( admin_url( 'admin.php?page=people-contact-manager', 'relative' ) );
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

	global $people_contact_admin_init;
	$people_contact_admin_init->init();
	
	// Add upgrade notice to Dashboard pages
	add_filter( $people_contact_admin_init->plugin_name . '_plugin_extension', array( 'People_Contact_Functions', 'plugin_pro_notice' ) );
		
	$admin_pages = $people_contact_admin_init->admin_pages();
	if ( is_array( $admin_pages ) && count( $admin_pages ) > 0 ) {
		foreach ( $admin_pages as $admin_page ) {
			add_action( $people_contact_admin_init->plugin_name . '-' . $admin_page . '_tab_start', array( 'People_Contact_Functions', 'plugin_extension_start' ) );
			add_action( $people_contact_admin_init->plugin_name . '-' . $admin_page . '_tab_end', array( 'People_Contact_Functions', 'plugin_extension_end' ) );
		}
	}
	
	add_action('init', array('People_Contact_AddNew', 'profile_form_action') );
	
	add_action( 'admin_menu', array( 'People_Contact_Hook_Filter', 'register_admin_screen' ), 9 );
	
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
	if ( in_array( basename ($_SERVER['PHP_SELF']), array('admin.php', 'edit.php') ) && isset( $_REQUEST['page'] ) && in_array( $_REQUEST['page'], array('people-contact-manager', 'people-contact', 'people-contact-settings', 'people-category-manager' ) ) ) {
		add_action('admin_head', array('People_Contact_Hook_Filter', 'admin_header_script'));
	}
	
	// Upgrade to 1.0.3
	if(version_compare(get_option('a3rev_wp_people_contact_version'), '1.0.3') === -1){
		People_Contact_Profile_Data::install_database();
		People_Contact_Functions::upgrade_to_1_0_3();
		update_option('a3rev_wp_people_contact_version', '1.0.3');
	}
	
	// Upgrade to 1.1.1
	if(version_compare(get_option('a3rev_wp_people_contact_version'), '1.1.1') === -1){
		$people_contact_grid_view_layout = get_option( 'people_contact_grid_view_layout', array() );
		$people_contact_global_settings = array(
			'grid_view_team_title' 	=> $people_contact_grid_view_layout['grid_view_team_title'],
			'grid_view_col'			=> $people_contact_grid_view_layout['grid_view_col'],
		);
		update_option( 'people_contact_global_settings', $people_contact_global_settings );
		
		$people_contact_location_map_settings = get_option( 'people_contact_location_map_settings', array() );
		$people_contact_location_map_settings['map_width_responsive'] = $people_contact_location_map_settings['map_width'];
		$people_contact_location_map_settings['map_width_fixed'] = $people_contact_location_map_settings['map_width'];
		update_option( 'people_contact_location_map_settings', $people_contact_location_map_settings );
		
		update_option('a3rev_wp_people_contact_version', '1.1.1');
	}
	
	update_option('a3rev_wp_people_contact_version', '1.1.2.2');
?>