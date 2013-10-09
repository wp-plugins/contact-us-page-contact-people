<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
Profile Image Style Settings

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

class People_Contact_Profile_Image_Style_Settings extends People_Contact_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'profile-cards';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'people_contact_grid_view_image_style';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'people_contact_grid_view_image_style';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 3;
	
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
				'success_message'	=> __( 'Profile Image Style successfully saved.', 'cup_cp' ),
				'error_message'		=> __( 'Error: Profile Image Style can not save.', 'cup_cp' ),
				'reset_message'		=> __( 'Profile Image Style successfully reseted.', 'cup_cp' ),
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
			'name'				=> 'profile-image-styles',
			'label'				=> __( 'Profile Image Style', 'cup_cp' ),
			'callback_function'	=> 'people_contact_profile_image_style_settings_form',
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
            	'name' 		=> __( 'Profile Image Style', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Presentation Style', 'cup_cp' ),
				'id' 		=> 'item_image_border_type',
				'type' 		=> 'select',
				'default'	=> 'rounder',
				'options'		=> array( 
					'rounder' 	=> __( 'Rounded Border', 'cup_cp' ), 
					'square' 	=> __( 'Square Border', 'cup_cp' ), 
					'no' 		=> __( 'Flat Image', 'cup_cp' ), 
				),
				'css' 		=> 'width:160px;',
			),
			
			array(
            	'name' 		=> __( 'Custom Styling', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Image Background Colour', 'cup_cp' ),
				'desc' 		=> __( "Shows in Image Padding area or if image is transparent. Default", 'cup_cp') . ' [default_value]',
				'id' 		=> 'item_image_background',
				'type' 		=> 'color',
				'default'	=> '#FFFFFF'
			),
			array(  
				'name' 		=> __( 'Image Padding', 'cup_cp' ),
				'desc' 		=> 'px. ' . __( "Overall size of image reduced by the size of padding set here.", 'cup_cp') . ' [default_value]',
				'id' 		=> 'item_image_padding',
				'type' 		=> 'text',
				'default'	=> 2,
				'css' 		=> 'width:40px;',
			),
			array(  
				'name' 		=> __( 'Image Border', 'cup_cp' ),
				'id' 		=> 'item_image_border',
				'type' 		=> 'border_styles',
				'default'	=> array( 'width' => '1px', 'style' => 'solid', 'color' => '#DBDBDB' )
			),
			
			array(  
				'name' 		=> __( 'Image Shadow', 'cup_cp' ),
				'id' 		=> 'item_image_shadow',
				'type' 		=> 'box_shadow',
				'default'	=> array( 'enable' => 1, 'h_shadow' => '5px' , 'v_shadow' => '5px', 'blur' => '2px' , 'spread' => '2px', 'color' => '#DBDBDB', 'inset' => '' )
			),
			
        ));
	}
	
}

global $people_contact_profile_image_style_settings;
$people_contact_profile_image_style_settings = new People_Contact_Profile_Image_Style_Settings();

/** 
 * people_contact_profile_image_style_settings_form()
 * Define the callback function to show subtab content
 */
function people_contact_profile_image_style_settings_form() {
	global $people_contact_profile_image_style_settings;
	$people_contact_profile_image_style_settings->settings_form();
}

?>