<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
Grid View Layout Settings

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

class People_Contact_Grid_View_Layout_Settings extends People_Contact_Admin_UI
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
	public $option_name = 'people_contact_grid_view_layout';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'people_contact_grid_view_layout';
	
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
				'success_message'	=> __( 'Profile Card Layout successfully saved.', 'cup_cp' ),
				'error_message'		=> __( 'Error: Profile Card Layout can not save.', 'cup_cp' ),
				'reset_message'		=> __( 'Profile Card Layout successfully reseted.', 'cup_cp' ),
			);
		
		add_action( $this->plugin_name . '-' . $this->parent_tab . '_tab_end', array( $this, 'include_script' ) );
			
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
			'name'				=> 'profile-card-type',
			'label'				=> __( 'Profile Card Type', 'cup_cp' ),
			'callback_function'	=> 'people_contact_grid_view_layout_settings_form',
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
            	'name' 		=> __( 'Select a Profile Card Type', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Profile Image Position', 'cup_cp' ),
				'id' 		=> 'thumb_image_position',
				'type' 		=> 'onoff_radio',
				'class'		=> 'thumb_image_position',
				'default' 	=> 'left',
				'onoff_options' => array(
					array(
						'val' 				=> 'left',
						'text' 				=> __( 'Card Type 1. Image Left - Content Right', 'cup_cp' ) . ' (' . __( 'Default', 'cup_cp' ) . ')',
						'checked_label'		=> __( 'ON', 'cup_cp') ,
						'unchecked_label' 	=> __( 'OFF', 'cup_cp') ,
					),
					array(
						'val' 				=> 'right',
						'text' 				=> __( 'Card Type 2. Content Left - Image Right', 'cup_cp' ),
						'checked_label'		=> __( 'ON', 'cup_cp') ,
						'unchecked_label' 	=> __( 'OFF', 'cup_cp') ,
					),
					array(
						'val' 				=> 'top',
						'text' 				=> __( 'Card Type 3. Image Top - Content Bottom', 'cup_cp' ),
						'checked_label'		=> __( 'ON', 'cup_cp') ,
						'unchecked_label' 	=> __( 'OFF', 'cup_cp') ,
					),
				),			
			),
			
			array(
            	'class'		=> 'thumb_image_position_side',
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Profile Image Wide', 'cup_cp' ),
				'desc'		=> '%. ' . __( 'Set as a percentage of total Profile Card wide.', 'cup_cp' ),
				'id' 		=> 'thumb_image_wide',
				'type' 		=> 'slider',
				'default'	=> 25,
				'min'		=> 25,
				'max'		=> 50,
				'increment'	=> 1,
			),
			array(
            	'class'		=> 'thumb_image_position_top',
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Fix Image Height', 'cup_cp' ),
				'desc' 		=> __( "Check to activate. Wide of image auto scaled to original proportion of tall.", 'cup_cp' ),
				'id' 		=> 'fix_thumb_image_height',
				'type' 		=> 'onoff_checkbox',
				'default'	=> '1',
				'checked_value'		=> 1,
				'unchecked_value' 	=> 0,
				'checked_label'		=> __( 'ON', 'cup_cp' ),
				'unchecked_label' 	=> __( 'OFF', 'cup_cp' ),
			),
			array(  
				'name' 		=> __( 'Image Fixed Height in Profile Card', 'cup_cp' ),
				'desc'		=> 'px. ' . __( 'Max height of image. Example set 200px and will fix image container at 200px with image aligned to the top. Default', 'cup_cp' ) . ' [default_value]px',
				'id' 		=> 'thumb_image_height',
				'type' 		=> 'text',
				'default'	=> 150,
				'css'		=> 'width:40px;',
			),
			array(  
				'name' 		=> __( 'Show Profile Title Position', 'cup_cp' ),
				'id' 		=> 'item_title_position',
				'type' 		=> 'switcher_checkbox',
				'default'	=> 'above',
				'checked_value' 	=> 'above',
				'unchecked_value' 	=> 'below',
				'checked_label'		=> __( 'Above the image', 'cup_cp' ),
				'unchecked_label' 	=> __( 'Below the image', 'cup_cp' ),
			),
			
        ));
	}
	
	public function include_script() {
	?>
<script>
(function($) {
$(document).ready(function() {
	if ( $("input.thumb_image_position:checked").val() == 'top') {
		$(".thumb_image_position_top").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		$(".thumb_image_position_side").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
	} else {
		$(".thumb_image_position_top").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
		$(".thumb_image_position_side").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	}
	$(document).on( "a3rev-ui-onoff_radio-switch", '.thumb_image_position', function( event, value, status ) {
		if ( value == 'top' && status == 'true' ) {
			$(".thumb_image_position_top").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
			$(".thumb_image_position_side").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
		} else {
			$(".thumb_image_position_top").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
			$(".thumb_image_position_side").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		}
	});
});
})(jQuery);
</script>
    <?php	
	}
	
}

global $people_contact_grid_view_layout_settings;
$people_contact_grid_view_layout_settings = new People_Contact_Grid_View_Layout_Settings();

/** 
 * people_contact_grid_view_layout_settings_form()
 * Define the callback function to show subtab content
 */
function people_contact_grid_view_layout_settings_form() {
	global $people_contact_grid_view_layout_settings;
	$people_contact_grid_view_layout_settings->settings_form();
}

?>