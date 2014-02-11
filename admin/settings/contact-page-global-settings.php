<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
Contact Page Global Settings

TABLE OF CONTENTS

- var parent_tab
- var subtab_data
- var option_name
- var form_key
- var position
- var form_fields
- var form_messages

- __construct()
- subtab_init()
- set_default_settings()
- get_settings()
- subtab_data()
- add_subtab()
- settings_form()
- init_form_fields()

-----------------------------------------------------------------------------------*/

class Contact_Page_Global_Settings extends People_Contact_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'contact-page';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'people_contact_global_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'people_contact_global_settings';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 1;
	
	/**
	 * @var array
	 */
	public $form_fields = array();
	
	/**
	 * @var array
	 */
	public $form_messages = array();
	
	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		$this->init_form_fields();
		$this->subtab_init();
		
		$this->form_messages = array(
				'success_message'	=> __( 'Contact Page Settings successfully saved.', 'cup_cp' ),
				'error_message'		=> __( 'Error: Contact Page Settings can not save.', 'cup_cp' ),
				'reset_message'		=> __( 'Contact Page Settings successfully reseted.', 'cup_cp' ),
			);
			
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'clean_on_deletion' ) );
		
		add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* subtab_init() */
	/* Sub Tab Init */
	/*-----------------------------------------------------------------------------------*/
	public function subtab_init() {
		
		add_filter( $this->plugin_name . '-' . $this->parent_tab . '_settings_subtabs_array', array( $this, 'add_subtab' ), $this->position );
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* set_default_settings()
	/* Set default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function set_default_settings() {
		global $people_contact_admin_interface;
		
		$people_contact_admin_interface->reset_settings( $this->form_fields, $this->option_name, false );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* clean_on_deletion()
	/* Process when clean on deletion option is un selected */
	/*-----------------------------------------------------------------------------------*/
	public function clean_on_deletion() {
		if ( ( isset( $_POST['bt_save_settings'] ) || isset( $_POST['bt_reset_settings'] ) ) && get_option( 'a3_people_contact_lite_clean_on_deletion' ) == 0  )  {
			$uninstallable_plugins = (array) get_option('uninstall_plugins');
			unset($uninstallable_plugins[PEOPLE_CONTACT_NAME]);
			update_option('uninstall_plugins', $uninstallable_plugins);
		}
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* get_settings()
	/* Get settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function get_settings() {
		global $people_contact_admin_interface;
		
		$people_contact_admin_interface->get_settings( $this->form_fields, $this->option_name );
	}
	
	/**
	 * subtab_data()
	 * Get SubTab Data
	 * =============================================
	 * array ( 
	 *		'name'				=> 'my_subtab_name'				: (required) Enter your subtab name that you want to set for this subtab
	 *		'label'				=> 'My SubTab Name'				: (required) Enter the subtab label
	 * 		'callback_function'	=> 'my_callback_function'		: (required) The callback function is called to show content of this subtab
	 * )
	 *
	 */
	public function subtab_data() {
		
		$subtab_data = array( 
			'name'				=> 'global-settings',
			'label'				=> __( 'Settings', 'cup_cp' ),
			'callback_function'	=> 'contact_page_global_settings_form',
		);
		
		if ( $this->subtab_data ) return $this->subtab_data;
		return $this->subtab_data = $subtab_data;
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* add_subtab() */
	/* Add Subtab to Admin Init
	/*-----------------------------------------------------------------------------------*/
	public function add_subtab( $subtabs_array ) {
	
		if ( ! is_array( $subtabs_array ) ) $subtabs_array = array();
		$subtabs_array[] = $this->subtab_data();
		
		return $subtabs_array;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* settings_form() */
	/* Call the form from Admin Interface
	/*-----------------------------------------------------------------------------------*/
	public function settings_form() {
		global $people_contact_admin_interface;
		
		$output = '';
		$output .= $people_contact_admin_interface->admin_forms( $this->form_fields, $this->form_key, $this->option_name, $this->form_messages );
		
		return $output;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* init_form_fields() */
	/* Init all fields of this form */
	/*-----------------------------------------------------------------------------------*/
	public function init_form_fields() {
		
  		// Define settings			
     	$this->form_fields = apply_filters( $this->option_name . '_settings_fields', array(
			
			array(
            	'name' 		=> __( 'Profile Cards Title', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Title Before Cards', 'cup_cp' ),
				'id' 		=> 'grid_view_team_title',
				'type' 		=> 'text',
				'default'	=> __( 'Team Contacts', 'cup_cp' ),
			),
			array(
            	'name' 		=> __( 'Profile Cards Per Row', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Cards Per Row', 'cup_cp' ),
				'desc'		=> __( 'Max 5 Cards per row', 'cup_cp' ),
				'id' 		=> 'grid_view_col',
				'type' 		=> 'slider',
				'default'	=> 2,
				'min'		=> 1,
				'max'		=> 5,
				'increment'	=> 1,
			),
			
			array(
            	'name' 		=> __( 'Contact Us Page', 'cup_cp' ),
				'desc'		=> __( 'A "Contact Us Page" was auto created on activation of the plugin. It contains the shortcode [people_contacts] required to show the contact us page. If it was not or you want to change it, create a new page, add the shortcode and then set it here.', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Contact Us', 'cup_cp' ),
				'desc' 		=> __( 'Page contents:', 'cup_cp' ).' [people_contacts]',
				'id' 		=> 'contact_us_page_id',
				'type' 		=> 'single_select_page',
				'default'	=> '',
				'separate_option'	=> true,
				'css'		=> 'width:300px;',
			),
			
			array(
            	'name' 		=> __( 'House Keeping :', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Clean up on Deletion', 'cup_cp' ),
				'desc' 		=> __( "On deletion (not deactivate) the plugin will completely remove all tables and data it created, leaving no trace it was ever here.", 'cup_cp' ),
				'id' 		=> 'a3_people_contact_lite_clean_on_deletion',
				'type' 		=> 'onoff_checkbox',
				'default'	=> '1',
				'separate_option'	=> true,
				'checked_value'		=> 1,
				'unchecked_value' 	=> 0,
				'checked_label'		=> __( 'ON', 'cup_cp' ),
				'unchecked_label' 	=> __( 'OFF', 'cup_cp' ),
			),
        ));
	}
}

global $contact_page_global_settings;
$contact_page_global_settings = new Contact_Page_Global_Settings();

/** 
 * contact_page_global_settings_form()
 * Define the callback function to show subtab content
 */
function contact_page_global_settings_form() {
	global $contact_page_global_settings;
	$contact_page_global_settings->settings_form();
}

?>