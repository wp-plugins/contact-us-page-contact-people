<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
People Email Inquiry Global Settings

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

class People_Email_Inquiry_Global_Settings extends People_Contact_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'settings';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'people_email_inquiry_global_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'people_email_inquiry_global_settings';
	
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
				'success_message'	=> __( 'Email Inquiry Settings successfully saved.', 'cup_cp' ),
				'error_message'		=> __( 'Error: Email Inquiry Settings can not save.', 'cup_cp' ),
				'reset_message'		=> __( 'Email Inquiry Settings successfully reseted.', 'cup_cp' ),
			);
			
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'reset_default_settings' ) );
		
		add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
		
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
			'name'				=> 'global-settings',
			'label'				=> __( 'Settings', 'cup_cp' ),
			'callback_function'	=> 'people_contact_email_inquiry_global_settings_form',
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
            	'name' => __( 'Contact Form Type', 'cup_cp' ),
                'type' => 'heading',
           	),
			array(  
				'name' 		=> __( 'Plugins Default Contact Form', 'cup_cp' ),
				'id' 		=> 'contact_form_type_other',
				'class'		=> 'contact_form_type_other default_contact_form_type',
				'type' 		=> 'onoff_radio',
				'default' 	=> 0,
				'onoff_options' => array(
					array(
						'val' 				=> 0,
						'text' 				=> '',
						'checked_label'		=> __( 'ON', 'cup_cp') ,
						'unchecked_label' 	=> __( 'OFF', 'cup_cp') ,
					),
					
				),			
			),
			array(  
				'name' 		=> __( 'Create form by Shortcode', 'cup_cp' ),
				'id' 		=> 'contact_form_type_other',
				'class'		=> 'contact_form_type_other',
				'type' 		=> 'onoff_radio',
				'default' 	=> 0,
				'onoff_options' => array(
					array(
						'val' 				=> 1,
						'text' 				=> __( "Only Contact Form 7 or Gravity Forms shortcode will work here", 'cup_cp' ),
						'checked_label'		=> __( 'ON', 'cup_cp') ,
						'unchecked_label' 	=> __( 'OFF', 'cup_cp') ,
					),
					
				),			
			),
			
			array(
            	'name' => __( 'Select a Pop-Up Tool', 'cup_cp' ),
                'type' => 'heading',
           	),
			array(  
				'name' 		=> __( "Pop-Up Tool", 'cup_cp' ),
				'id' 		=> 'inquiry_popup_type',
				'type' 		=> 'switcher_checkbox',
				'default'	=> 'fb',
				'checked_value'		=> 'fb',
				'unchecked_value'	=> 'colorbox',
				'checked_label'		=> __( 'FANCYBOX', 'cup_cp' ),
				'unchecked_label' 	=> __( 'COLORBOX', 'cup_cp' ),
			),
			
        ));
	}
}

global $people_contact_email_inquiry_global_settings;
$people_contact_email_inquiry_global_settings = new People_Email_Inquiry_Global_Settings();

/** 
 * people_email_inquiry_global_settings_form()
 * Define the callback function to show subtab content
 */
function people_contact_email_inquiry_global_settings_form() {
	global $people_contact_email_inquiry_global_settings;
	$people_contact_email_inquiry_global_settings->settings_form();
}

?>