<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
Contact Page Location Map Settings

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

class Contact_Page_Location_Map_Settings extends People_Contact_Admin_UI
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
	public $option_name = 'people_contact_location_map_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'people_contact_location_map_settings';
	
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
				'success_message'	=> __( 'Profiles Location Map Settings successfully saved.', 'cup_cp' ),
				'error_message'		=> __( 'Error: Profiles Location Map Settings can not save.', 'cup_cp' ),
				'reset_message'		=> __( 'Profiles Location MapSettings successfully reseted.', 'cup_cp' ),
			);
		
		add_action( $this->plugin_name . '-' . $this->parent_tab . '_tab_end', array( $this, 'include_script' ) );
			
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
			'name'				=> 'location-map',
			'label'				=> __( 'Profiles Location Map', 'cup_cp' ),
			'callback_function'	=> 'contact_page_location_map_settings_form',
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
            	'name' 		=> __( 'Google Map Setting', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Show Map', 'cup_cp' ),
				'desc' 		=> __( "Show Profiles location map at top of the Contact Us Page.", 'cup_cp' ),
				'id' 		=> 'hide_maps_frontend',
				'type' 		=> 'onoff_checkbox',
				'default' 	=> 0,
				'checked_value'		=> 0,
				'unchecked_value' 	=> 1,
				'checked_label'		=> __( 'ON', 'cup_cp' ),
				'unchecked_label' 	=> __( 'OFF', 'cup_cp' ),				
			),
			array(  
				'name' 		=> __( 'Zoom Level', 'cup_cp' ),
				'id' 		=> 'zoom_level',
				'type' 		=> 'slider',
				'min'		=> 1,
				'max'		=> 19,
				'default'	=> 4,
				'increment'	=> 1
			),
			array(  
				'name' 		=> __( 'Map Type', 'cup_cp' ),
				'id' 		=> 'map_type',
				'type' 		=> 'select',
				'default'	=> 'ROADMAP',
				'options'		=> array( 
					'ROADMAP' 	=> 'ROADMAP', 
					'SATELLITE' => 'SATELLITE', 
					'HYBRID' 	=> 'HYBRID',
					'TERRAIN'	=> 'TERRAIN',
				),
				'css' 		=> 'width:120px;',
			),
			array(  
				'name' 		=> __( 'Map Width Type', 'cup_cp' ),
				'id' 		=> 'map_width_type',
				'class'		=> 'map_width_type',
				'type' 		=> 'switcher_checkbox',
				'default'	=> 'percent',
				'checked_value'		=> 'percent',
				'unchecked_value' 	=> 'px',
				'checked_label'		=> __( 'Responsive', 'cup_cp' ),
				'unchecked_label' 	=> __( 'Fixed Wide', 'cup_cp' ),
			),
			array(
            	'class' 	=> 'map_width_type_percent',
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> '',
				'id' 		=> 'map_width_responsive',
				'desc'		=> '%',
				'type' 		=> 'slider',
				'default'	=> 100,
				'min'		=> 10,
				'max'		=> 100,
				'increment'	=> 1,
			),
			array(
            	'class' 	=> 'map_width_type_fixed',
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> '',
				'id' 		=> 'map_width_fixed',
				'desc'		=> 'px',
				'type' 		=> 'text',
				'default'	=> 400,
				'css' 		=> 'width:60px;',
			),
			
			array(
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Map Height', 'cup_cp' ),
				'desc'		=> 'px',
				'id' 		=> 'map_height',
				'type' 		=> 'text',
				'default'	=> 400,
				'css' 		=> 'width:60px;',
			),
			
			array(
            	'name' 		=> __( 'Primary Location Address', 'cup_cp' ),
				'desc'		=> __( 'Enter a Primary location address in a format that google can find. Example Street Number Street name Suburb, Town, postcode / zip code, Country. The map will open with this location as its center.', 'cup_cp' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Center Address', 'cup_cp' ),
				'id' 		=> 'center_address',
				'type' 		=> 'text',
				'default'	=> 'Australia',
			),
        ));
	}
	
	public function include_script() {
	?>
<script>
(function($) {
$(document).ready(function() {
	if ( $("input.map_width_type:checked").val() == 'percent') {
		$(".map_width_type_fixed").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
		$(".map_width_type_percent").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	} else {
		$(".map_width_type_fixed").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		$(".map_width_type_percent").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
	}
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.map_width_type', function( event, value, status ) {
		if ( status == 'true' ) {
			$(".map_width_type_fixed").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
			$(".map_width_type_percent").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		} else {
			$(".map_width_type_fixed").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
			$(".map_width_type_percent").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
		}
	});
});
})(jQuery);
</script>
    <?php	
	}
}

global $contact_page_location_map_settings;
$contact_page_location_map_settings = new Contact_Page_Location_Map_Settings();

/** 
 * contact_page_location_map_settings_form()
 * Define the callback function to show subtab content
 */
function contact_page_location_map_settings_form() {
	global $contact_page_location_map_settings;
	$contact_page_location_map_settings->settings_form();
}

?>