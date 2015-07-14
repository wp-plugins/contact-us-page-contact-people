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

		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_end', array( $this, 'include_script' ) );

		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'reset_default_settings' ) );
		
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
                'id'		=> 'ei_contact_form_type_box',
                'is_box'	=> true,
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
						'text' 				=> '<span style="color: green;"><strong>'.__( 'Pro Version', '' ).'</strong></span>. '
						. __( "Only Contact Form 7 or Gravity Forms shortcode will work here", 'cup_cp' )
						. '</span>'
						. '<div style="padding-top: 5px; clear: both; font-size: 13px;">'.__( '<strong>Important!</strong> Profile Email Custom Contact forms created by Contact Form 7 or Gravity Forms shortcode and the ability to add custom forms for individual profiles is an  advanced Feature found in the Pro and Ultimate version.', 'cup_cp' ).'</div>'
						. '<span>',
						'checked_label'		=> __( 'ON', 'cup_cp') ,
						'unchecked_label' 	=> __( 'OFF', 'cup_cp') ,
					),
					
				),			
			),

			// Default Form Settings
			array(
            	'name' 		=> __( 'Form Settings', 'cup_cp' ),
                'type' 		=> 'heading',
                'class'		=> 'ei_default_form_container',
                'id'		=> 'ei_built_contact_form_box',
                'is_box'	=> true,
           	),
			array(
				'name' 		=> __( "Email 'From' Settings", 'cup_cp' ),
				'desc'		=> __( 'The following options affect the sender (email address and name) used in Profile Email Inquiries.', 'cup_cp' ),
				'class'		=> 'default_contact_form_options',
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( '"From" Name', 'cup_cp' ),
				'desc'		=> __( 'Leave empty and your site title will be used', 'cup_cp' ),
				'id' 		=> 'email_from_name',
				'type' 		=> 'text',
				'default'	=> get_bloginfo('blogname'),
				'free_version'	=> true,
			),
			array(  
				'name' 		=> __( '"From" Email Address', 'cup_cp' ),
				'desc'		=> __( 'Leave empty and your WordPress admin email address will be used', 'cup_cp' ),
				'id' 		=> 'email_from_address',
				'type' 		=> 'text',
				'default'	=> get_bloginfo('admin_email'),
				'free_version'	=> true,
			),
			array(
				'name' 		=> __( "Sender 'Request A Copy'", 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Send Copy to Sender', 'cup_cp' ),
				'desc' 		=> __( "Gives users a checkbox option to send a copy of the Inquiry email to themselves", 'cup_cp' ),
				'id' 		=> 'send_copy',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'yes',
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'YES', 'cup_cp' ),
				'unchecked_label' 	=> __( 'NO', 'cup_cp' ),
				'free_version'	=> true,
			),


			// Default Form Style
			array(
            	'name' 		=> __( 'Form Background Colour', 'cup_cp' ),
                'type' 		=> 'heading',
                'class'		=> 'ei_default_form_container',
                'id'		=> 'ei_form_background_color_box',
                'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( 'Background Colour', 'cup_cp' ),
				'desc' 		=> __( 'Default', 'cup_cp' ) . ' [default_value]',
				'id' 		=> 'inquiry_form_bg_colour',
				'type' 		=> 'color',
				'default'	=> '#FFFFFF',
				'free_version'	=> true,
			),
			
			array(
            	'name' 		=> __( 'Form Titles and Fonts', 'cup_cp' ),
                'type' 		=> 'heading',
                'class'		=> 'ei_default_form_container',
                'id'		=> 'ei_form_titles_fonts_box',
                'is_box'	=> true,
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
				'free_version'	=> true,
			),
			array(  
				'name' 		=> __( 'Text Font', 'cup_cp' ),
				'id' 		=> 'inquiry_contact_heading_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '14px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#000000' ),
				'free_version'	=> true,
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
				'free_version'	=> true,
			),
			array(  
				'name' 		=> __( 'Name Font', 'cup_cp' ),
				'id' 		=> 'inquiry_form_site_name_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '28px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#000000' ),
				'free_version'	=> true,
			),
			
			array(
            	'name' 		=> __( 'Profile Title / Position', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Title / Position Font', 'cup_cp' ),
				'id' 		=> 'inquiry_form_profile_position_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '14px', 'face' => 'Arial, sans-serif', 'style' => 'bold', 'color' => '#000000' ),
				'free_version'	=> true,
			),
			
			array(
            	'name' 		=> __( 'Profile Name', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Profile Name Font', 'cup_cp' ),
				'id' 		=> 'inquiry_form_profile_name_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '14px', 'face' => 'Arial, sans-serif', 'style' => 'bold', 'color' => '#000000' ),
				'free_version'	=> true,
			),
			
			array(
            	'name' 		=> __( 'Form Content Font', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Content Font', 'cup_cp' ),
				'id' 		=> 'inquiry_contact_popup_text',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#000000' ),
				'free_version'	=> true,
			),
			
			array(
            	'name' 		=> __( 'Form Input Field Style', 'cup_cp' ),
                'type' 		=> 'heading',
                'class'		=> 'ei_default_form_container',
                'id'		=> 'ei_form_input_style_box',
                'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( 'Background Colour', 'cup_cp' ),
				'desc' 		=> __( 'Default', 'cup_cp' ) . ' [default_value]',
				'id' 		=> 'inquiry_input_bg_colour',
				'type' 		=> 'color',
				'default'	=> '#FAFAFA',
				'free_version'	=> true,
			),
			array(  
				'name' 		=> __( 'Font Colour', 'cup_cp' ),
				'desc' 		=> __( 'Default', 'cup_cp' ) . ' [default_value]',
				'id' 		=> 'inquiry_input_font_colour',
				'type' 		=> 'color',
				'default'	=> '#000000',
				'free_version'	=> true,
			),
			array(  
				'name' 		=> __( 'Input Field Borders', 'cup_cp' ),
				'id' 		=> 'inquiry_input_border',
				'type' 		=> 'border',
				'default'	=> array( 'width' => '1px', 'style' => 'solid', 'color' => '#CCCCCC', 'corner' => 'square' , 'rounded_value' => 0 ),
				'free_version'	=> true,
			),
			
			array(
            	'name' 		=> __( 'Form Send / Submit Button', 'cup_cp' ),
                'type' 		=> 'heading',
                'class'		=> 'ei_default_form_container',
                'id'		=> 'ei_form_send_button_box',
                'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( 'Send Button Title', 'cup_cp' ),
				'desc' 		=> __( "&lt;empty&gt; for default SEND", 'cup_cp' ),
				'id' 		=> 'inquiry_contact_text_button',
				'type' 		=> 'text',
				'default'	=> __( 'SEND', 'cup_cp' ),
				'free_version'	=> true,
			),
			array(  
				'name' 		=> __( 'Background Colour', 'cup_cp' ),
				'desc' 		=> __( 'Default', 'cup_cp' ) . ' [default_value]',
				'id' 		=> 'inquiry_contact_button_bg_colour',
				'type' 		=> 'color',
				'default'	=> '#EE2B2B',
				'free_version'	=> true,
			),
			array(  
				'name' 		=> __( 'Background Colour Gradient From', 'cup_cp' ),
				'desc' 		=> __( 'Default', 'cup_cp' ) . ' [default_value]',
				'id' 		=> 'inquiry_contact_button_bg_colour_from',
				'type' 		=> 'color',
				'default'	=> '#FBCACA',
				'free_version'	=> true,
			),
			array(  
				'name' 		=> __( 'Background Colour Gradient To', 'cup_cp' ),
				'desc' 		=> __( 'Default', 'cup_cp' ) . ' [default_value]',
				'id' 		=> 'inquiry_contact_button_bg_colour_to',
				'type' 		=> 'color',
				'default'	=> '#EE2B2B',
				'free_version'	=> true,
			),
			array(  
				'name' 		=> __( 'Button Border', 'cup_cp' ),
				'id' 		=> 'inquiry_contact_button_border',
				'type' 		=> 'border',
				'default'	=> array( 'width' => '1px', 'style' => 'solid', 'color' => '#EE2B2B', 'corner' => 'rounded' , 'rounded_value' => 3 ),
				'free_version'	=> true,
			),
			array(  
				'name' 		=> __( 'Button Font', 'cup_cp' ),
				'id' 		=> 'inquiry_contact_button_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#FFFFFF' ),
				'free_version'	=> true,
			),

			array(
            	'name' 		=> __( 'Success Message Setup', 'cup_cp' ),
                'type' 		=> 'heading',
                'class'		=> 'ei_default_form_container',
                'id'		=> 'ei_success_message_box',
                'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( 'Success Message', 'cup_cp' ),
				'desc' 		=> __( 'Message that user will see after their Inquiry is sent.', 'cup_cp' ),
				'id' 		=> 'people_email_inquiry_contact_success',
				'type' 		=> 'wp_editor',
				'textarea_rows'		=> 15,
				'default'	=> __( "Thanks for your inquiry - we'll be in touch with you as soon as possible!", 'cup_cp' ),
				'separate_option'	=> true,
				'free_version'	=> true,
			),


			// #3rd Contact Form
			array(
            	'name' 		=> __( 'Form Shortcode', 'cup_cp' ),
				'desc'		=> __( 'Create a contact form that applies to all Profiles by adding a form shortcode from the Contact Form 7 or Gravity Forms plugins.', 'cup_cp' ),
                'type' 		=> 'heading',
                'class'		=> 'pro_feature_fields ei_3rd_form_container',
                'id'		=> 'ei_form_shortcode_box',
                'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( 'Form Shortcode', 'cup_cp' ),
				'desc'		=> __( 'Can add unique form shortcode on each profile.', 'cup_cp' ),
				'id' 		=> 'contact_form_type_shortcode',
				'type' 		=> 'text',
				'default'	=> '',
			),

			array(
            	'name' 		=> __( 'Reset Profiles Form Shortcodes', 'cup_cp' ),
                'type' 		=> 'heading',
                'class'		=> 'pro_feature_fields ei_3rd_form_container',
                'id'		=> 'ei_reset_form_shortcodes_open_box',
                'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( 'Global Re-Set', 'cup_cp' ),
				'desc' 		=> __( "ON and Save Changes will reset all profiles that have a unique contact form shortcode to the form shortcode set on this page.", 'cup_cp' ),
				'id' 		=> 'contact_page_global_reset_profile',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'no',
				'separate_option'	=> true,
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'YES', 'cup_cp' ),
				'unchecked_label' 	=> __( 'NO', 'cup_cp' ),
			),
			
			array(
				'name' 		=> __( 'Form Open Options', 'cup_cp' ),
                'type' 		=> 'heading',
                'class'		=> 'pro_feature_fields ei_3rd_form_container',
                'id'		=> 'ei_form_open_box',
                'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( 'Open Options', 'cup_cp' ),
				'id' 		=> 'contact_form_3rd_open_type',
				'class'		=> 'contact_form_3rd_open_type',
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

			// Popup Tool
			array(
            	'name' => __( 'Select a Pop-Up Tool', 'cup_cp' ),
                'type' => 'heading',
                'class'		=> 'pro_feature_fields ei_popup_tool_container',
                'id'		=> 'ei_popup_tool_box',
                'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( "Pop-Up Tool", 'cup_cp' ),
				'class'		=> 'inquiry_popup_type',
				'id' 		=> 'inquiry_popup_type',
				'type' 		=> 'switcher_checkbox',
				'default'	=> 'fb',
				'checked_value'		=> 'fb',
				'unchecked_value'	=> 'colorbox',
				'checked_label'		=> __( 'FANCYBOX', 'cup_cp' ),
				'unchecked_label' 	=> __( 'COLORBOX', 'cup_cp' ),
			),



			// Fancybox Popup
			array(
            	'name' 		=> __( 'Fancybox Pop-Up Settings', 'cup_cp' ),
                'type' 		=> 'heading',
                'class'		=> 'pro_feature_fields ei_fancybox_settings_container',
                'id'		=> 'ei_fancybox_settings_box',
                'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( "Fix Position on Scroll", 'cup_cp' ),
				'id' 		=> 'fancybox_center_on_scroll',
				'type' 		=> 'onoff_radio',
				'default'	=> 'true',
				'onoff_options' => array(
					array(
						'val' 				=> 'true',
						'text'				=> __( 'Pop-up stays centered in screen while page scrolls behind it.', 'cup_cp' ) ,
						'checked_label'		=> 'ON',
						'unchecked_label' 	=> 'OFF',
					),
					
					array(
						'val' 				=> 'false',
						'text' 				=> __( 'Pop-up scrolls up and down with the page.', 'cup_cp' ) ,
						'checked_label'		=> 'ON',
						'unchecked_label' 	=> 'OFF',
					) 
				),
			),
			array(  
				'name' 		=> __( 'Open Transition Effect', 'cup_cp' ),
				'desc' 		=> __( "Choose a pop-up opening effect. Default - None.", 'cup_cp' ),
				'id' 		=> 'fancybox_transition_in',
				'css' 		=> 'width:80px;',
				'type' 		=> 'select',
				'default'	=> 'none',
				'options'	=> array(
						'none'			=> __( 'None', 'cup_cp' ) ,	
						'fade'			=> __( 'Fade', 'cup_cp' ) ,	
						'elastic'		=> __( 'Elastic', 'cup_cp' ) ,
					),
			),
			array(  
				'name' 		=> __( 'Close Transistion Effect', 'cup_cp' ),
				'desc' 		=> __( "Choose a pop-up closing effect. Default - None.", 'cup_cp' ),
				'id' 		=> 'fancybox_transition_out',
				'css' 		=> 'width:80px;',
				'type' 		=> 'select',
				'default'	=> 'none',
				'options'	=> array(
						'none'			=> __( 'None', 'cup_cp' ) ,	
						'fade'			=> __( 'Fade', 'cup_cp' ) ,	
						'elastic'		=> __( 'Elastic', 'cup_cp' ) ,
					),
			),
			array(  
				'name' 		=> __( 'Opening Speed', 'cup_cp' ),
				'desc' 		=> __( 'Milliseconds when open pop-up', 'cup_cp' ),
				'id' 		=> 'fancybox_speed_in',
				'type' 		=> 'text',
				'css' 		=> 'width:40px;',
				'default'	=> '300'
			),
			array(  
				'name' 		=> __( 'Closing Speed', 'cup_cp' ),
				'desc' 		=> __( 'Milliseconds when close pop-up', 'cup_cp' ),
				'id' 		=> 'fancybox_speed_out',
				'type' 		=> 'text',
				'css' 		=> 'width:40px;',
				'default'	=> '0'
			),
			array(  
				'name' 		=> __( 'Background Overlay Colour', 'cup_cp' ),
				'desc' 		=> __( 'Select a colour or empty for no colour.', 'cup_cp' ). ' ' . __( 'Default', 'cup_cp' ). ' [default_value]',
				'id' 		=> 'fancybox_overlay_color',
				'type' 		=> 'color',
				'default'	=> '#666666'
			),


			// ColorBox Popup
			array(
            	'name' 		=> __( 'Colorbox Pop-Up Settings', 'cup_cp' ),
                'type' 		=> 'heading',
                'class'		=> 'pro_feature_fields ei_colorbox_settings_container',
                'id'		=> 'ei_colorbox_settings_box',
                'is_box'	=> true,
           	),
			array(  
				'name' 		=> __( "Fix Position on Scroll", 'cup_cp' ),
				'id' 		=> 'colorbox_center_on_scroll',
				'type' 		=> 'onoff_radio',
				'default'	=> 'true',
				'onoff_options' => array(
					array(
						'val' 				=> 'true',
						'text'				=> __( 'Pop-up stays centered in screen while page scrolls behind it.', 'cup_cp' ) ,
						'checked_label'		=> 'ON',
						'unchecked_label' 	=> 'OFF',
					),
					
					array(
						'val' 				=> 'false',
						'text' 				=> __( 'Pop-up scrolls up and down with the page.', 'cup_cp' ) ,
						'checked_label'		=> 'ON',
						'unchecked_label' 	=> 'OFF',
					) 
				),
			),
			array(  
				'name' 		=> __( 'Open & Close Transition Effect', 'cup_cp' ),
				'desc' 		=> __( "Choose a pop-up opening & closing effect. Default - None", 'cup_cp' ),
				'id' 		=> 'colorbox_transition',
				'css' 		=> 'width:80px;',
				'type' 		=> 'select',
				'default'	=> 'none',
				'options'	=> array(
						'none'			=> __( 'None', 'cup_cp' ) ,	
						'fade'			=> __( 'Fade', 'cup_cp' ) ,	
						'elastic'		=> __( 'Elastic', 'cup_cp' ) ,
					),
			),
			array(  
				'name' 		=> __( 'Opening & Closing Speed', 'cup_cp' ),
				'desc' 		=> __( 'Milliseconds when open and close pop-up', 'cup_cp' ),
				'id' 		=> 'colorbox_speed',
				'type' 		=> 'text',
				'css' 		=> 'width:40px;',
				'default'	=> '300'
			),
			array(  
				'name' 		=> __( 'Background Overlay Colour', 'cup_cp' ),
				'desc' 		=> __('Select a colour or empty for no colour.', 'cup_cp'). ' ' . __('Default', 'cup_cp'). ' [default_value]',
				'id' 		=> 'colorbox_overlay_color',
				'type' 		=> 'color',
				'default'	=> '#666666'
			),

			array(
            	'name' 		=> __( 'Profile Shortcode Email Page', 'cup_cp' ),
				'desc'		=> __( 'A "Profile Email Page" was auto created on activation of the plugin. It contains the shortcode [profile_email_page] which is required to show the contact form created by shortcode for each profile. If it was not created or you want to change it, create a new page, add the shortcode and then set it here.', 'cup_cp' ),
                'type' 		=> 'heading',
                'class'		=> 'pro_feature_fields ei_3rd_form_container',
                'id'		=> 'ei_page_display_shortcode_box',
                'is_box'	=> true,
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

        ));
	}

	public function include_script() {
	?>
<script>
(function($) {
$(document).ready(function() {
	if ( $("input.contact_form_type_other:checked").val() == 1) {
		$(".ei_default_form_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
		if ( $("input.contact_form_3rd_open_type:checked").val() != 'popup') {
			$(".ei_popup_tool_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
			$(".ei_fancybox_settings_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
			$(".ei_colorbox_settings_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
		}
	} else {
		$(".ei_3rd_form_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
	}
	$(document).on( "a3rev-ui-onoff_radio-switch", '.contact_form_type_other', function( event, value, status ) {
		$(".ei_default_form_container").attr('style','display:none;');
		$(".ei_3rd_form_container").attr('style','display:none;');
		$(".ei_popup_tool_container").attr('style','display:none;');
		$(".ei_fancybox_settings_container").attr('style','display:none;');
		$(".ei_colorbox_settings_container").attr('style','display:none;');
		if ( value == 1 && status == 'true' ) {
			$(".ei_3rd_form_container").slideDown();
			$(".ei_default_form_container").slideUp();
			if ( $("input.contact_form_3rd_open_type:checked").val() == 'popup') {
				$(".ei_popup_tool_container").slideDown();
				if ( $("input.inquiry_popup_type:checked").val() == 'fb') {
					$(".ei_fancybox_settings_container").slideDown();
					$(".ei_colorbox_settings_container").slideUp();
				} else {
					$(".ei_fancybox_settings_container").slideUp();
					$(".ei_colorbox_settings_container").slideDown();
				}
			}
		} else if ( status == 'true' ) {
			$(".ei_3rd_form_container").slideUp();
			$(".ei_default_form_container").slideDown();
			$(".ei_popup_tool_container").slideDown();
			if ( $("input.inquiry_popup_type:checked").val() == 'fb') {
				$(".ei_fancybox_settings_container").slideDown();
				$(".ei_colorbox_settings_container").slideUp();
			} else {
				$(".ei_fancybox_settings_container").slideUp();
				$(".ei_colorbox_settings_container").slideDown();
			}
		}
	});

	$(document).on( "a3rev-ui-onoff_radio-switch", '.contact_form_3rd_open_type', function( event, value, status ) {
		$(".ei_popup_tool_container").attr('style','display:none;');
		$(".ei_fancybox_settings_container").attr('style','display:none;');
		$(".ei_colorbox_settings_container").attr('style','display:none;');
		if ( value == 'popup' && status == 'true' ) {
			$(".ei_popup_tool_container").slideDown();
			if ( $("input.inquiry_popup_type:checked").val() == 'fb') {
				$(".ei_fancybox_settings_container").slideDown();
				$(".ei_colorbox_settings_container").slideUp();
			} else {
				$(".ei_fancybox_settings_container").slideUp();
				$(".ei_colorbox_settings_container").slideDown();
			}
		}
	});

	if ( $("input.inquiry_popup_type:checked").val() == 'fb') {
		$(".ei_colorbox_settings_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
	} else {
		$(".ei_fancybox_settings_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden', 'margin-bottom' : '0px'} );
	}
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.inquiry_popup_type', function( event, value, status ) {
		$(".ei_fancybox_settings_container").attr('style','display:none;');
		$(".ei_colorbox_settings_container").attr('style','display:none;');
		if ( status == 'true' ) {
			$(".ei_fancybox_settings_container").slideDown();
			$(".ei_colorbox_settings_container").slideUp();
		} else {
			$(".ei_fancybox_settings_container").slideUp();
			$(".ei_colorbox_settings_container").slideDown();
		}
	});
});
})(jQuery);
</script>
    <?php
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
