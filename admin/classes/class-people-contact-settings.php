<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
/**
 * People Contact Settings
 *
 * Table Of Contents
 *
 * settings_dashboard()
 */
class People_Contact_Settings {
	public static function settings_dashboard() {
	?>
		<style>
		.code, code{font-family:inherit;font-size:inherit;}
		.form-table{margin:0;border-collapse:separate;}
		.icon32-people-contact-settings {background:url(<?php echo PEOPLE_CONTACT_IMAGE_URL; ?>/a3-plugins.png) no-repeat left top !important;}
		.subsubsub{white-space:normal;}
		.subsubsub li{ white-space:nowrap;}
		img.help_tip{float: right; margin: 0 -10px 0 0;}
		#a3_plugin_panel_container { position:relative; margin-top:10px;}
		#a3_plugin_panel_fields {width:65%; float:left;}
		#a3_plugin_panel_upgrade_area { position:relative; margin-left: 65%; padding-left:10px;}
		#a3_plugin_panel_extensions { border:2px solid #E6DB55;-webkit-border-radius:10px;-moz-border-radius:10px;-o-border-radius:10px; border-radius: 10px; color: #555555; margin: 0px; padding: 5px 10px; text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8); background:#FFFBCC; }
		.pro_feature_fields { margin-right: -12px; position: relative; z-index: 10; border:2px solid #E6DB55;-webkit-border-radius:10px 0 0 10px;-moz-border-radius:10px 0 0 10px;-o-border-radius:10px 0 0 10px; border-radius: 10px 0 0 10px; border-right: 2px solid #FFFFFF; }
		.pro_feature_fields h3 { margin:8px 5px; }
		.pro_feature_fields p { margin-left:5px; }
		.pro_feature_fields  .form-table td, .pro_feature_fields .form-table th { padding:4px 10px; }
		</style>
		<div class="wrap">
			<div class="icon32 icon32-people-contact-settings" id="icon32-email-cart-options"><br></div>
			<h2 class="nav-tab-wrapper">
			<?php
			$current_tab = (isset($_REQUEST['tab'])) ? $_REQUEST['tab'] : '';
			$tabs = array(
				'map-settings'				=> __( 'Contact Page', 'cup_cp' ),
				'grid-view'				=> __( 'Grid View', 'cup_cp' ),
				'contact-widget'				=> __( 'Contact Widget', 'cup_cp' ),
			);
		
			foreach ($tabs as $name => $label) :
				echo '<a href="' . admin_url( 'admin.php?page=people-contact-settings&tab=' . $name ) . '" class="nav-tab ';
				if ( $current_tab == '' && $name == 'map-settings' ) echo 'nav-tab-active';
				if ( $current_tab == $name ) echo 'nav-tab-active';
				echo '">' . $label . '</a>';
			endforeach;
			?>
			</h2>
			<div style="width:100%; float:left;">
			<?php
			switch ($current_tab) :
				case 'grid-view':
					People_Contact_Grid_View_Panel::panel_manager();
					break;
				case 'contact-widget':
					People_Contact_Widget_Panel::panel_manager();
					break;
				default :
					People_Contact_Page_Panel::panel_manager();
					break;
			endswitch;
			?>
			</div>
			<div style="clear:both; margin-bottom:20px;"></div>
		</div>
	<?php
	}
}
?>