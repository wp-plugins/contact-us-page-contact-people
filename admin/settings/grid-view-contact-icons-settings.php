<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
Grid View Contact Icons Settings

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

class People_Contact_Contact_Icons_Settings extends People_Contact_Admin_UI
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
	public $option_name = 'people_contact_grid_view_icon';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'people_contact_grid_view_icon';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 4;
	
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
				'success_message'	=> __( 'Profile Card Contact Icons successfully saved.', 'cup_cp' ),
				'error_message'		=> __( 'Error: Profile Card Contact Icons can not save.', 'cup_cp' ),
				'reset_message'		=> __( 'Profile Card Contact Icons successfully reseted.', 'cup_cp' ),
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
			'name'				=> 'profile-card-contact-icons',
			'label'				=> __( 'Profile Card Contact Icons', 'cup_cp' ),
			'callback_function'	=> 'people_contact_contact_icons_settings_form',
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
            	'name' 		=> __( 'Upload Custom Default Profile Image', 'cup_cp' ),
				'desc'		=> __( "Upload custom 'No Image' image, .jpg or.png format.", 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Default Profile Image', 'cup_cp' ),
				'id' 		=> 'default_profile_image',
				'type' 		=> 'upload',
				'default'	=> PEOPLE_CONTACT_IMAGE_URL.'/no-avatar.png',
			),
			array(
            	'name' 		=> __( 'Upload Custom Contact Icons', 'cup_cp' ),
				'desc'		=> __( "Delete default icons. Upload custom icons, transparent .png format, 16px by 16px recommended size.", 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Phone icon', 'cup_cp' ),
				'id' 		=> 'grid_view_icon_phone',
				'type' 		=> 'upload',
				'default'	=> PEOPLE_CONTACT_IMAGE_URL.'/p_icon_phone.png',
			),
			array(  
				'name' 		=> __( 'Fax icon', 'cup_cp' ),
				'id' 		=> 'grid_view_icon_fax',
				'type' 		=> 'upload',
				'default'	=> PEOPLE_CONTACT_IMAGE_URL.'/p_icon_fax.png',
			),
			array(  
				'name' 		=> __( 'Mobile icon', 'cup_cp' ),
				'id' 		=> 'grid_view_icon_mobile',
				'type' 		=> 'upload',
				'default'	=> PEOPLE_CONTACT_IMAGE_URL.'/p_icon_mobile.png',
			),
			array(  
				'name' 		=> __( 'Email icon', 'cup_cp' ),
				'id' 		=> 'grid_view_icon_email',
				'type' 		=> 'upload',
				'default'	=> PEOPLE_CONTACT_IMAGE_URL.'/p_icon_email.png',
			),
			array(  
				'name' 		=> __( 'Email Link Text', 'cup_cp' ),
				'desc'		=> __( 'Set hyperlink text that shows to the right of the Email icon. Default', 'cup_cp' ) . " '[default_value]'",
				'id' 		=> 'grid_view_email_text',
				'type' 		=> 'text',
				'default'	=> __( 'Click Here', 'cup_cp' ),
			),
			array(  
				'name' 		=> __( 'Website icon', 'cup_cp' ),
				'id' 		=> 'grid_view_icon_website',
				'type' 		=> 'upload',
				'default'	=> PEOPLE_CONTACT_IMAGE_URL.'/p_icon_website.png',
			),
			array(  
				'name' 		=> __( 'Website Link Text', 'cup_cp' ),
				'desc'		=> __( 'Set hyperlink text that shows to the right of the Website icon. Default', 'cup_cp' ) . " '[default_value]'",
				'id' 		=> 'grid_view_website_text',
				'type' 		=> 'text',
				'default'	=> __( 'Visit Website', 'cup_cp' ),
			),
			
        ));
	}
		
}

global $people_contact_contact_icons_settings;
$people_contact_contact_icons_settings = new People_Contact_Contact_Icons_Settings();

/** 
 * people_contact_contact_icons_settings_form()
 * Define the callback function to show subtab content
 */
function people_contact_contact_icons_settings_form() {
	global $people_contact_contact_icons_settings;
	$people_contact_contact_icons_settings->settings_form();
}

?>