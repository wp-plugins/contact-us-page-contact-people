<?php
/*
Plugin Name: Contact Us page - Contact people LITE
Description: Instantly and easily create a simply stunning Contact Us page on almost any theme. Google location map, People Contact Profiles and a fully featured Contact Us widget. Fully responsive and easy to customize. Pro Version upgrade for even more features.
Version: 1.1.2
Author: A3 Revolution
Author URI: http://www.a3rev.com/
Requires at least: 3.3
Tested up to: 3.6.1
License: GPLv2 or later
*/

/*
	Contact Us page - Contact people Pro. Plugin for wordpress.
	Copyright © 2011 A3 Revolution Software Development team
	
	A3 Revolution Software Development team
	admin@a3rev.com
	PO Box 1170
	Gympie 4570
	QLD Australia
*/

// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'PEOPLE_CONTACT_PATH', dirname(__FILE__));
define( 'PEOPLE_CONTACT_TEMPLATE_PATH', PEOPLE_CONTACT_PATH . '/templates' );
define( 'PEOPLE_CONTACT_FOLDER', dirname(plugin_basename(__FILE__)) );
define( 'PEOPLE_CONTACT_URL', untrailingslashit( plugins_url( '/', __FILE__ ) ) );
define( 'PEOPLE_CONTACT_DIR', WP_CONTENT_DIR.'/plugins/'.PEOPLE_CONTACT_FOLDER);
define( 'PEOPLE_CONTACT_NAME', plugin_basename(__FILE__) );
define( 'PEOPLE_CONTACT_TEMPLATE_URL', PEOPLE_CONTACT_URL . '/templates' );
define( 'PEOPLE_CONTACT_CSS_URL', PEOPLE_CONTACT_URL . '/assets/css' );
define( 'PEOPLE_CONTACT_JS_URL', PEOPLE_CONTACT_URL . '/assets/js' );
define( 'PEOPLE_CONTACT_IMAGE_URL', PEOPLE_CONTACT_URL . '/assets/images' );
if(!defined("PEOPLE_CONTACT_AUTHOR_URI"))
    define("PEOPLE_CONTACT_AUTHOR_URI", "http://a3rev.com/shop/contact-us-page-contact-people/");
if(!defined("PEOPLE_CONTACT_ULTIMATE_URI"))
    define("PEOPLE_CONTACT_ULTIMATE_URI", "http://a3rev.com/shop/contact-people-ultimate/");
if(!defined("PEOPLE_CONTACT_DOCS_URI"))
    define("PEOPLE_CONTACT_DOCS_URI", "http://docs.a3rev.com/user-guides/plugins-extensions/wordpress/contact-us-page-contact-people/");

include('admin/admin-ui.php');
include('admin/admin-interface.php');

include('admin/admin-pages/admin-settings-page.php');

include('admin/admin-init.php');

include('classes/data/class-profiles-data.php');

include('classes/class-people-contact-functions.php');
include('classes/class-people-contact-hook.php');
include('classes/class-people-contact.php');

include('admin/classes/class-people-contact-addnew.php');
include('admin/classes/class-people-contact-manager-panel.php');
include('admin/classes/class-people-category-manager-panel.php');

include('shortcodes/class-people-contact-shortcodes.php');
include('widgets/class-people-contact-widgets.php');

// Editor
include 'tinymce3/tinymce.php';

include('admin/people-contact-init.php');

/**
* Call when the plugin is activated
*/
register_activation_hook(__FILE__, 'people_contact_install');

function people_contact_uninstall() {
	if ( get_option('a3_people_contact_clean_on_deletion') == 1 ) {
		delete_option('people_contact_settings');
		delete_option('people_contact_global_settings');
		delete_option('people_contact_location_map_settings');
		delete_option('people_contact_contact_forms_settings');
		delete_option('people_contact_popup_style_settings');
		
		delete_option('people_contact_grid_view_style');
		delete_option('people_contact_grid_view_layout');
		delete_option('people_contact_grid_view_icon');
		delete_option('people_contact_widget_settings');
		delete_option('people_contact_widget_maps');
		delete_option('people_contact_widget_information');
		delete_option('people_contact_widget_email_contact_form');
		
		delete_option('contact_arr');
		delete_option('profile_email_page_id');
		delete_option('a3rev_wp_people_contact_plugin');
		delete_option('a3rev_wp_people_contact_message');
		delete_option('contact_us_page_id');
		delete_option('a3rev_wp_people_contact_version');
		
		delete_option('a3_people_contact_clean_on_deletion');
		
		global $wpdb;
		$wpdb->query('DROP TABLE IF EXISTS ' . $wpdb->prefix . 'cup_cp_profiles');
		
	}
}
if ( get_option('a3_people_contact_clean_on_deletion') == 1 ) {
	register_uninstall_hook( __FILE__, 'people_contact_uninstall' );
}
?>