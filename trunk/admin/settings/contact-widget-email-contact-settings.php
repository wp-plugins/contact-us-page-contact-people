<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
Contact Widget Email Contact Settings

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

class People_Contact_Contact_Widget_Email_Settings extends People_Contact_Admin_UI
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
	public $option_name = 'people_contact_widget_email_contact_form';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'people_contact_widget_email_contact_form';
	
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
				'success_message'	=> __( 'Email Contact Form Settings successfully saved.', 'cup_cp' ),
				'error_message'		=> __( 'Error: Email Contact Form Settings can not save.', 'cup_cp' ),
				'reset_message'		=> __( 'Email Contact Form Settings successfully reseted.', 'cup_cp' ),
			);
		
		add_action( $this->plugin_name . '-' . $this->parent_tab . '_tab_end', array( $this, 'include_script' ) );
			
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
		add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
		
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_init' , array( $this, 'reset_default_settings' ) );
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
		if ( isset( $_POST['bt_save_settings'] ) ) {
			$settings_array = get_option( $this->option_name, array() );
			$settings_array['widget_show_contact_form'] = $_POST[$this->option_name]['widget_show_contact_form'];
			update_option( $this->option_name, $settings_array );
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
			'name'				=> 'email-contact-form',
			'label'				=> __( 'Email Contact Form', 'cup_cp' ),
			'callback_function'	=> 'people_contact_contact_widget_email_settings_form',
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
				'desc'		=> __( 'Create the widget contact us form by entering a shortcode from any contact form plugin.', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Create form by Shortcode', 'cup_cp' ),
				'class'		=> 'widget_show_contact_form',
				'id' 		=> 'widget_show_contact_form',
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
				'free_version'		=> true,
			),
			array(
				'class'		=> 'widget_show_contact_form_another_plugin',
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Form Shortcode', 'cup_cp' ),
				'id' 		=> 'widget_input_shortcode',
				'type' 		=> 'text',
				'default'	=> '',
				'free_version'		=> true,
			),
			
			array(
            	'name' 		=> __( 'Built-in Contact Form', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Use Default Form', 'cup_cp' ),
				'class'		=> 'widget_show_contact_form',
				'id' 		=> 'widget_show_contact_form',
				'type' 		=> 'onoff_radio',
				'default' 	=> 0,
				'onoff_options' => array(
					array(
						'val' 				=> 1,
						'text' 				=> '',
						'checked_label'		=> __( 'ON', 'cup_cp') ,
						'unchecked_label' 	=> __( 'OFF', 'cup_cp') ,
					),
					
				),
				'free_version'		=> true,
			),
			
			array(
            	'name' 		=> __( 'Email Settings', 'cup_cp' ),
				'class'		=> 'pro_feature_fields widget_show_contact_form_default',
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( '"From" Name', 'cup_cp' ),
				'desc' 		=> __( "&lt;empty&gt; defaults to Site Title", 'cup_cp' ),
				'id' 		=> 'widget_email_from_name',
				'type' 		=> 'text',
				'default'	=> get_bloginfo('blogname'),
			),
			array(  
				'name' 		=> __( '"From" Email Address', 'cup_cp' ),
				'desc' 		=> __( "&lt;empty&gt; defaults to WordPress admin email address", 'cup_cp' ),
				'id' 		=> 'widget_email_from_address',
				'type' 		=> 'text',
				'default'	=> get_bloginfo('admin_email'),
			),
			array(  
				'name' 		=> __( 'Send Copy to Sender', 'cup_cp' ),
				'desc' 		=> __( "Gives users a checkbox option to send a copy of the Inquiry email to themselves", 'cup_cp' ),
				'id' 		=> 'widget_send_copy',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 'no',
				'checked_value'		=> 'yes',
				'unchecked_value' 	=> 'no',
				'checked_label'		=> __( 'YES', 'cup_cp' ),
				'unchecked_label' 	=> __( 'NO', 'cup_cp' ),
			),
			
			array(
            	'name' 		=> __( 'Email Delivery', 'cup_cp' ),
				'class'		=> 'widget_show_contact_form_default',
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Inquiry Email goes to', 'cup_cp' ),
				'desc' 		=> __( "&lt;empty&gt; defaults to WordPress admin email address", 'cup_cp' ),
				'id' 		=> 'widget_email_to',
				'type' 		=> 'text',
				'default'	=> get_bloginfo('admin_email'),
				'free_version'		=> true,
			),
			array(  
				'name' 		=> __( 'CC', 'cup_cp' ),
				'desc' 		=> __( "&lt;empty&gt; defaults to 'no copy sent' or add an email address", 'cup_cp' ),
				'id' 		=> 'widget_email_cc',
				'type' 		=> 'text',
				'default'	=> '',
				'free_version'		=> true,
			),
			
        ));
	}
	
	public function include_script() {
	?>
<script>
(function($) {
$(document).ready(function() {
	if ( $("input.widget_show_contact_form:checked").val() == 1) {
		$(".widget_show_contact_form_default").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		$(".widget_show_contact_form_another_plugin").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
	} else {
		$(".widget_show_contact_form_default").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
		$(".widget_show_contact_form_another_plugin").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	}
	$(document).on( "a3rev-ui-onoff_radio-switch", '.widget_show_contact_form', function( event, value, status ) {
		if ( value == 1 && status == 'true' ) {
			$(".widget_show_contact_form_default").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
			$(".widget_show_contact_form_another_plugin").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
		} else {
			$(".widget_show_contact_form_default").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
			$(".widget_show_contact_form_another_plugin").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		}
	});
});
})(jQuery);
</script>
    <?php	
	}
}

global $people_contact_contact_widget_email_settings;
$people_contact_contact_widget_email_settings = new People_Contact_Contact_Widget_Email_Settings();

/** 
 * people_contact_contact_widget_email_settings_form()
 * Define the callback function to show subtab content
 */
function people_contact_contact_widget_email_settings_form() {
	global $people_contact_contact_widget_email_settings;
	$people_contact_contact_widget_email_settings->settings_form();
}

?>