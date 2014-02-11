<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
People Email Inquiry Default Form Style Settings

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

class People_Email_Inquiry_Popup_Form_Style_Settings extends People_Contact_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'default-contact-form';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'people_email_inquiry_popup_form_style';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'people_email_inquiry_popup_form_style';
	
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
				'success_message'	=> __( 'Default Form Style Settings successfully saved.', 'cup_cp' ),
				'error_message'		=> __( 'Error: Default Form Style Settings can not save.', 'cup_cp' ),
				'reset_message'		=> __( 'Default Form Style Settings successfully reseted.', 'cup_cp' ),
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
			'name'				=> 'default-form-style',
			'label'				=> __( 'Default Form Style', 'cup_cp' ),
			'callback_function'	=> 'people_email_inquiry_popup_form_style_settings_form',
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
            	'name' 		=> __( 'Form Background Colour', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Background Colour', 'cup_cp' ),
				'desc' 		=> __( 'Default', 'cup_cp' ) . ' [default_value]',
				'id' 		=> 'inquiry_form_bg_colour',
				'type' 		=> 'color',
				'default'	=> '#FFFFFF'
			),
			
			array(
            	'name' 		=> __( 'Form Heading Text', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Heading Text', 'cup_cp' ),
				'id' 		=> 'inquiry_contact_heading',
				'type' 		=> 'text',
				'default'	=> __( 'This email will be delivered to:', 'cup_cp' ),
			),
			array(  
				'name' 		=> __( 'Text Font', 'cup_cp' ),
				'id' 		=> 'inquiry_contact_heading_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '14px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#000000' )
			),
			
			array(
            	'name' 		=> __( 'Business / Organization Name', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Name Text', 'cup_cp' ),
				'id' 		=> 'inquiry_form_site_name',
				'type' 		=> 'text',
				'default'	=> get_bloginfo('blogname'),
			),
			array(  
				'name' 		=> __( 'Name Font', 'cup_cp' ),
				'id' 		=> 'inquiry_form_site_name_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '28px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#000000' )
			),
			
			array(
            	'name' 		=> __( 'Profile Title / Position', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Title / Position Font', 'cup_cp' ),
				'id' 		=> 'inquiry_form_profile_position_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '14px', 'face' => 'Arial, sans-serif', 'style' => 'bold', 'color' => '#000000' )
			),
			
			array(
            	'name' 		=> __( 'Profile Name', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Profile Name Font', 'cup_cp' ),
				'id' 		=> 'inquiry_form_profile_name_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '14px', 'face' => 'Arial, sans-serif', 'style' => 'bold', 'color' => '#000000' )
			),
			
			array(
            	'name' 		=> __( 'Form Content Font', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Content Font', 'cup_cp' ),
				'id' 		=> 'inquiry_contact_popup_text',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#000000' )
			),
			
			array(
            	'name' 		=> __( 'Form Input Field Style', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Background Colour', 'cup_cp' ),
				'desc' 		=> __( 'Default', 'cup_cp' ) . ' [default_value]',
				'id' 		=> 'inquiry_input_bg_colour',
				'type' 		=> 'color',
				'default'	=> '#FAFAFA'
			),
			array(  
				'name' 		=> __( 'Font Colour', 'cup_cp' ),
				'desc' 		=> __( 'Default', 'cup_cp' ) . ' [default_value]',
				'id' 		=> 'inquiry_input_font_colour',
				'type' 		=> 'color',
				'default'	=> '#000000'
			),
			array(  
				'name' 		=> __( 'Input Field Borders', 'cup_cp' ),
				'id' 		=> 'inquiry_input_border',
				'type' 		=> 'border',
				'default'	=> array( 'width' => '1px', 'style' => 'solid', 'color' => '#CCCCCC', 'corner' => 'square' , 'rounded_value' => 0 ),
			),
			
			array(
            	'name' 		=> __( 'Form Send / Submit Button', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Send Button Title', 'cup_cp' ),
				'desc' 		=> __( "&lt;empty&gt; for default SEND", 'cup_cp' ),
				'id' 		=> 'inquiry_contact_text_button',
				'type' 		=> 'text',
				'default'	=> __( 'SEND', 'cup_cp' ),
			),
			array(  
				'name' 		=> __( 'Background Colour', 'cup_cp' ),
				'desc' 		=> __( 'Default', 'cup_cp' ) . ' [default_value]',
				'id' 		=> 'inquiry_contact_button_bg_colour',
				'type' 		=> 'color',
				'default'	=> '#EE2B2B'
			),
			array(  
				'name' 		=> __( 'Background Colour Gradient From', 'cup_cp' ),
				'desc' 		=> __( 'Default', 'cup_cp' ) . ' [default_value]',
				'id' 		=> 'inquiry_contact_button_bg_colour_from',
				'type' 		=> 'color',
				'default'	=> '#FBCACA'
			),
			array(  
				'name' 		=> __( 'Background Colour Gradient To', 'cup_cp' ),
				'desc' 		=> __( 'Default', 'cup_cp' ) . ' [default_value]',
				'id' 		=> 'inquiry_contact_button_bg_colour_to',
				'type' 		=> 'color',
				'default'	=> '#EE2B2B'
			),
			array(  
				'name' 		=> __( 'Button Border', 'cup_cp' ),
				'id' 		=> 'inquiry_contact_button_border',
				'type' 		=> 'border',
				'default'	=> array( 'width' => '1px', 'style' => 'solid', 'color' => '#EE2B2B', 'corner' => 'rounded' , 'rounded_value' => 3 ),
			),
			array(  
				'name' 		=> __( 'Button Font', 'cup_cp' ),
				'id' 		=> 'inquiry_contact_button_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#FFFFFF' )
			),
			
			array(
            	'name' 		=> __( 'Style Form With Theme CSS', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Form CSS Class', 'cup_cp' ),
				'desc' 		=> __( "&lt;empty&gt; for default or enter custom form CSS", 'cup_cp' ),
				'id' 		=> 'inquiry_contact_form_class',
				'type' 		=> 'text',
				'default'	=> ''
			),
			array(  
				'name' 		=> __( 'Button CSS Class', 'cup_cp' ),
				'desc' 		=> __( 'Enter your own button CSS class', 'cup_cp' ),
				'id' 		=> 'inquiry_contact_button_class',
				'type' 		=> 'text',
				'default'	=> ''
			),
			
        ));
	}
	
}

global $people_email_inquiry_popup_form_style_settings;
$people_email_inquiry_popup_form_style_settings = new People_Email_Inquiry_Popup_Form_Style_Settings();

/** 
 * people_email_inquiry_popup_form_style_settings_form()
 * Define the callback function to show subtab content
 */
function people_email_inquiry_popup_form_style_settings_form() {
	global $people_email_inquiry_popup_form_style_settings;
	$people_email_inquiry_popup_form_style_settings->settings_form();
}

?>