<?php
/**
 * People Contact Hook Filter
 *
 * Table Of Contents
 *
 * register_admin_screen()
 * contact_manager_load_only_script()
 * add_new_load_only_script()
 * settings_load_only_script()
 * admin_header_script()
 * admin_footer_scripts()
 * people_update_orders()
 * plugin_extra_links()
 *
 */
class People_Contact_Hook_Filter
{
	public static function register_admin_screen () {
		global $query_string, $current_user;
		$current_user_id = $current_user->user_login;
	
		$contact_manager = add_menu_page( __('Contact Us', 'cup_cp'), __('Contact Us', 'cup_cp'), 'manage_options', 'people-contact-manager', array( 'People_Contact_Manager_Panel', 'admin_screen' ), PEOPLE_CONTACT_IMAGE_URL.'/option-icon-maps.png', '27.222');
		
		$profile = add_submenu_page('people-contact-manager', __( 'Profiles', 'cup_cp' ), __( 'Profiles', 'cup_cp' ), 'manage_options', 'people-contact-manager', array( 'People_Contact_Manager_Panel', 'admin_screen' ) );
		
		$add_new = add_submenu_page('people-contact-manager', __( 'Add New Profile', 'cup_cp' ), __( 'Add New Profile', 'cup_cp' ), 'manage_options', 'people-contact', array( 'People_Contact_AddNew', 'admin_screen_add_edit' ) );
		//$grid_view_style_css = add_submenu_page('people-contact-manager', __( 'Grid View Style', 'cup_cp' ), __( 'Grid View Style', 'cup_cp' ), 'manage_options', 'people-contact-style-css', array( &$this, 'grid_view_style_css' ) );
		$settings = add_submenu_page('people-contact-manager', __( 'Settings', 'cup_cp' ), __( 'Settings', 'cup_cp' ), 'manage_options', 'people-contact-settings', array( 'People_Contact_Settings', 'settings_dashboard' ) );
		add_action( "admin_print_scripts-" . $contact_manager, array( 'People_Contact_Hook_Filter', 'contact_manager_load_only_script') );
		add_action( "admin_print_scripts-" . $profile, array( 'People_Contact_Hook_Filter', 'contact_manager_load_only_script') );
		add_action( "admin_print_scripts-" . $add_new, array( 'People_Contact_Hook_Filter', 'add_new_load_only_script') );
		add_action( "admin_print_scripts-" . $settings, array( 'People_Contact_Hook_Filter', 'settings_load_only_script') );
		//add_action( "admin_print_scripts-" . $grid_view_style_css, array( &$this, 'contact_manager_load_only') );
	
	} // End register_admin_screen()
	
	public static function add_style_header() {
		wp_enqueue_style( 'people_contact_style', PEOPLE_CONTACT_CSS_URL.'/style.css' );
	}
	
	public static function include_customized_style() { 
		include( PEOPLE_CONTACT_DIR. '/templates/customized_style.php' );
	}
	
	public static function fix_window_console_ie() {
	?>
    <script type="text/javascript">
		if(!(window.console && console.log)) {
			console = {
				log: function(){},
				debug: function(){},
				info: function(){},
				warn: function(){},
				error: function(){}
			};
		}
	</script>

    <?php	
	}
	
	public static function browser_body_class( $classes, $class = '' ) {
		if ( !is_array($classes) ) $classes = array();
		
		global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
 
		if($is_lynx) $classes[] = 'lynx';
		elseif($is_gecko) $classes[] = 'gecko';
		elseif($is_opera) $classes[] = 'opera';
		elseif($is_NS4) $classes[] = 'ns4';
		elseif($is_safari) $classes[] = 'safari';
		elseif($is_chrome) $classes[] = 'chrome';
		elseif($is_IE) {
			$browser = $_SERVER['HTTP_USER_AGENT'];
			$browser = substr( "$browser", 25, 8);
			if ($browser == "MSIE 7.0"  ) {
				$classes[] = 'ie7';
				$classes[] = 'ie';
			} elseif ($browser == "MSIE 6.0" ) {
				$classes[] = 'ie6';
				$classes[] = 'ie';
			} elseif ($browser == "MSIE 8.0" ) {
				$classes[] = 'ie8';
				$classes[] = 'ie';
			} elseif ($browser == "MSIE 9.0" ) {
				$classes[] = 'ie9';
				$classes[] = 'ie';
			} else {
				$classes[] = 'ie';
			}
		} else { $classes[] = 'unknown'; }
 
		if( $is_iphone ) $classes[] = 'iphone';
		
		return $classes;

	}
	
	public static function contact_manager_load_only_script(){
		wp_enqueue_script('jquery-ui-sortable');
	}
	
	public static function add_new_load_only_script(){
		wp_enqueue_script('jquery-ui-autocomplete', '', array('jquery-ui-widget', 'jquery-ui-position'), '1.8.6');
		wp_enqueue_script('maps-googleapis','https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false' );
		People_Contact_Uploader::uploader_js();
	}
	
	public function settings_load_only_script(){
		People_Contact_Uploader::uploader_js();
	}
	
	public static function admin_header_script() {
		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		
		wp_enqueue_script('jquery');
		wp_enqueue_script('farbtastic');
		wp_enqueue_style('farbtastic');
		wp_register_style( 'people_contact_manager', PEOPLE_CONTACT_CSS_URL.'/admin.css' );
		wp_enqueue_style( 'people_contact_manager' );
		wp_enqueue_style( 'tipTip-style', PEOPLE_CONTACT_JS_URL . '/tipTip/tipTip.css' );
		wp_enqueue_script( 'tipTip', PEOPLE_CONTACT_JS_URL . '/tipTip/jquery.tipTip'.$suffix.'.js', array(), false );
	}
	
	public static function admin_footer_scripts() {
		$suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
		
		wp_enqueue_script('jquery');
		
		wp_enqueue_style( 'a3rev-chosen-style', PEOPLE_CONTACT_JS_URL . '/chosen/chosen.css' );
		wp_enqueue_script( 'chosen', PEOPLE_CONTACT_JS_URL . '/chosen/chosen.jquery'.$suffix.'.js', array(), false, true );
		wp_enqueue_script( 'a3rev-chosen-script-init', PEOPLE_CONTACT_JS_URL.'/init-chosen.js', array(), false, true );
	?>
<script type="text/javascript">
jQuery(window).load(function(){
	// Subsubsub tabs
	jQuery('div.a3_subsubsub_section ul.subsubsub li a:eq(0)').addClass('current');
	jQuery('div.a3_subsubsub_section .section:gt(0)').hide();
	jQuery('div.a3_subsubsub_section ul.subsubsub li a').click(function(){
		var $clicked = jQuery(this);
		var $section = $clicked.closest('.a3_subsubsub_section');
		var $target  = $clicked.attr('href');
	
		$section.find('a').removeClass('current');
	
		if ( $section.find('.section:visible').size() > 0 ) {
			$section.find('.section:visible').fadeOut( 100, function() {
				$section.find( $target ).fadeIn('fast');
			});
		} else {
			$section.find( $target ).fadeIn('fast');
		}
	
		$clicked.addClass('current');
		jQuery('#last_tab').val( $target );
	
		return false;
	});
	<?php if (isset($_REQUEST['subtab']) && $_REQUEST['subtab']) echo 'jQuery("div.a3_subsubsub_section ul.subsubsub li a[href='.$_REQUEST['subtab'].']").click();'; ?>
});
(function($){
	$(function(){
		// Tooltips
		$(".help_tip").tipTip({
			"attribute" : "tip",
			"fadeIn" : 50,
			"fadeOut" : 50
		});
		// Color picker
		$('.colorpick').each(function(){
			$('.colorpickdiv', $(this).parent()).farbtastic(this);
			$(this).click(function() {
				if ( $(this).val() == "" ) $(this).val('#000000');
				$('.colorpickdiv', $(this).parent() ).show();
			});	
		});
		$(document).mousedown(function(){
			$('.colorpickdiv').hide();
		});
	});
})(jQuery);
</script>
    <?php
	}
	
	public static function people_update_orders() {
		check_ajax_referer( 'people_update_orders', 'security' );
		$updateRecordsArray  = $_REQUEST['recordsArray'];
		$i = 0;
		foreach ($updateRecordsArray as $recordIDValue) {
			$i++;
			People_Contact_Profile_Data::update_order($recordIDValue, $i);
		}
		die();
	}
	
	public static function plugin_extra_links($links, $plugin_name) {
		if ( $plugin_name != PEOPLE_CONTACT_NAME) {
			return $links;
		}
		$links[] = '<a href="http://docs.a3rev.com/user-guides/plugins-extensions/woocommerce/contact-us-page-contact-people/" target="_blank">'.__('Documentation', 'cup_cp').'</a>';
		$links[] = '<a href="http://wordpress.org/support/plugin/contact-us-page-contact-people/" target="_blank">'.__('Support', 'cup_cp').'</a>';
		return $links;
	}
}
?>