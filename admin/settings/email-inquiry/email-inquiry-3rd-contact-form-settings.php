<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
People Email Inquiry 3RD Contact Form Settings

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

class People_Email_Inquiry_3RD_Contact_Form_Settings extends People_Contact_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = '3rd-contact-form';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'people_email_inquiry_3rd_contact_form_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'people_email_inquiry_3rd_contact_form_settings';
	
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
		//$this->subtab_init();
		
		$this->form_messages = array(
				'success_message'	=> __( 'Custom Form Settings successfully saved.', 'cup_cp' ),
				'error_message'		=> __( 'Error: Custom Form Settings can not save.', 'cup_cp' ),
				'reset_message'		=> __( 'Custom Form Settings successfully reseted.', 'cup_cp' ),
			);
		
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
				
		add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'reset_default_settings' ) );
		add_action( $this->plugin_name . '-'. $this->form_key.'_settings_start', array( $this, 'pro_fields_before' ) );
		add_action( $this->plugin_name . '-'. $this->form_key.'_settings_end', array( $this, 'pro_fields_after' ) );
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
	/* reset_default_settings()
	/* Reset default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function reset_default_settings() {
		global $people_contact_admin_interface;
		
		$people_contact_admin_interface->reset_settings( $this->form_fields, $this->option_name, true, true );
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
			'name'				=> '3rd-contact-form',
			'label'				=> __( 'Custom Form', 'cup_cp' ),
			'callback_function'	=> 'people_email_inquiry_custom_contact_form_settings_form',
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
            	'name' 		=> __( 'Contact Form from another Plugin', 'cup_cp' ),
				'desc'		=> __( 'Create a contact form that applies to all Profiles by adding a form shortcode from the Contact Form 7 or Gravity Forms plugins.', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Enter Global Form Shortcode', 'cup_cp' ),
				'desc'		=> __( 'Can add unique form shortcode on each profile.', 'cup_cp' ),
				'id' 		=> 'contact_form_type_shortcode',
				'type' 		=> 'text',
				'default'	=> '',
			),
			
			array(
				'name' 		=> __( 'Custom Form Open Options', 'cup_cp' ),
				'class'		=> '3rd_contact_form_options',
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Form Open Options', 'cup_cp' ),
				'id' 		=> 'contact_form_3rd_open_type',
				'type' 		=> 'onoff_radio',
				'default' 	=> 'new_page',
				'onoff_options' => array(
					array(
						'val' 				=> 'new_page',
						'text' 				=> __( 'Open contact form on new page', 'cup_cp' ) . ' - ' . __( 'new window', 'cup_cp' ) . '<span class="description">(' . __( 'Default', 'cup_cp' ) . ')</span>',
						'checked_label'		=> __( 'ON', 'cup_cp') ,
						'unchecked_label' 	=> __( 'OFF', 'cup_cp') ,
					),
					array(
						'val' 				=> 'new_page_same_window',
						'text' 				=> __( 'Open contact form on new page', 'cup_cp' ) . ' - ' . __( 'same window', 'cup_cp' ),
						'checked_label'		=> __( 'ON', 'cup_cp') ,
						'unchecked_label' 	=> __( 'OFF', 'cup_cp') ,
					),
					array(
						'val' 				=> 'popup',
						'text' 				=> __( 'Open contact form by Pop-up', 'cup_cp' ),
						'checked_label'		=> __( 'ON', 'cup_cp') ,
						'unchecked_label' 	=> __( 'OFF', 'cup_cp') ,
					),
				),			
			),
			
			array(
            	'name' 		=> __( 'Page For Displaying shortcode Forms', 'cup_cp' ),
				'class'		=> '3rd_contact_form_options',
				'desc'		=> __( 'A "Profile Email Page" was auto created on activation of the plugin. It contains the shortcode [profile_email_page] which is required to show the contact form created by shortcode for each profile. If it was not created or you want to change it, create a new page, add the shortcode and then set it here.', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Profile Contact Page', 'cup_cp' ),
				'desc' 		=> __( 'Page contents:', 'cup_cp' ).' [profile_email_page]',
				'id' 		=> 'profile_email_page_id',
				'type' 		=> 'single_select_page',
				'default'	=> '',
				'separate_option'	=> true,
				'css'		=> 'width:300px;',
			),
			
			array(
            	'name' 		=> __( 'Reset Profiles Contact Form Shortcodes', 'cup_cp' ),
				'class'		=> '3rd_contact_form_options',
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Global Re-Set', 'cup_cp' ),
				'desc' 		=> __( "Set to Yes and Save Changes will reset all profiles that have a unique contact form shortcode to the form shortcode set on this page.", 'cup_cp' ),
				'id' 		=> 'contact_page_global_reset_profile',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'no',
				'separate_option'	=> true,
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'YES', 'cup_cp' ),
				'unchecked_label' 	=> __( 'NO', 'cup_cp' ),
			),
			
        ));
	}
	
}

global $people_email_inquiry_custom_contact_form_settings;
$people_email_inquiry_custom_contact_form_settings = new People_Email_Inquiry_3RD_Contact_Form_Settings();

/** 
 * people_email_inquiry_custom_contact_form_settings_form()
 * Define the callback function to show subtab content
 */
function people_email_inquiry_custom_contact_form_settings_form() {
	global $people_email_inquiry_custom_contact_form_settings;
	$people_email_inquiry_custom_contact_form_settings->settings_form();
}

?>