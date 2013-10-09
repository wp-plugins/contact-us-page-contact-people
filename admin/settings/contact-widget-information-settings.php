<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
Contact Widget Contact Information Settings

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

class People_Contact_Contact_Widget_Information_Settings extends People_Contact_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'contact-widget';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'people_contact_widget_information';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'people_contact_widget_information';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 2;
	
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
				'success_message'	=> __( 'Contact Information Settings successfully saved.', 'cup_cp' ),
				'error_message'		=> __( 'Error: Contact Information Settings can not save.', 'cup_cp' ),
				'reset_message'		=> __( 'Contact Information Settings successfully reseted.', 'cup_cp' ),
			);
			
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
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
			'name'				=> 'contact-widget-information',
			'label'				=> __( 'Contact Information', 'cup_cp' ),
			'callback_function'	=> 'people_contact_contact_widget_information_settings_form',
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
            	'name' 		=> __( 'Add Contact Details', 'cup_cp' ),
				'desc'		=> __( "Add contact details to show in the widget, &lt;empty&gt; fields don't show on front end.", 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Address', 'cup_cp' ),
				'id' 		=> 'widget_info_address',
				'type' 		=> 'text',
				'default'	=> ''
			),
			array(  
				'name' 		=> __( 'Phone', 'cup_cp' ),
				'id' 		=> 'widget_info_phone',
				'type' 		=> 'text',
				'default'	=> ''
			),
			array(  
				'name' 		=> __( 'Fax', 'cup_cp' ),
				'id' 		=> 'widget_info_fax',
				'type' 		=> 'text',
				'default'	=> ''
			),
			array(  
				'name' 		=> __( 'Mobile', 'cup_cp' ),
				'id' 		=> 'widget_info_mobile',
				'type' 		=> 'text',
				'default'	=> ''
			),
			array(  
				'name' 		=> __( 'Visible Email address', 'cup_cp' ),
				'id' 		=> 'widget_info_email',
				'type' 		=> 'text',
				'default'	=> ''
			),
			
			array(
            	'name' 		=> __( 'Contact widget content', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Content before Map', 'cup_cp' ),
				'desc'		=> __( "Content will show above map on widget. Leave &lt;empty&gt; to disable.", 'cup_cp' ),
				'id' 		=> 'widget_content_before_maps',
				'type' 		=> 'wp_editor',
				'default'	=> '',
				'textarea_rows'	=> 15,
			),
			array(  
				'name' 		=> __( 'Content after Map', 'cup_cp' ),
				'desc'		=> __( "Content will show below map on widget. Leave &lt;empty&gt; to disable.", 'cup_cp' ),
				'id' 		=> 'widget_content_after_maps',
				'type' 		=> 'wp_editor',
				'default'	=> '',
				'textarea_rows'	=> 15,
			),
        ));
	}
}

global $people_contact_contact_widget_information_settings;
$people_contact_contact_widget_information_settings = new People_Contact_Contact_Widget_Information_Settings();

/** 
 * people_contact_contact_widget_information_settings_form()
 * Define the callback function to show subtab content
 */
function people_contact_contact_widget_information_settings_form() {
	global $people_contact_contact_widget_information_settings;
	$people_contact_contact_widget_information_settings->settings_form();
}

?>