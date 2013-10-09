<style>
/* Grid View Layout */
<?php
global $people_contact_admin_interface, $people_contact_fonts_face;
global $people_contact_grid_view_layout;
?>
#people_contacts_container .people-entry-item .p_content_left, .people-entry-item .p_content_left{
	width: <?php echo ( (int) $people_contact_grid_view_layout['thumb_image_wide'] - 1 ); ?>% !important;
	float: left !important;
	text-align:center;
}
#people_contacts_container .people-entry-item .p_content_right, .people-entry-item .p_content_right{
	width: <?php echo ( 100 - 1 - (int) $people_contact_grid_view_layout['thumb_image_wide'] ); ?>% !important;
	float: right !important;
}

/* Thumb Image Style */
<?php
global $people_contact_grid_view_image_style;
extract( $people_contact_grid_view_image_style );
?>
#people_contacts_container .people-entry-item .p_content_left img, .people-entry-item .p_content_left img{
	width: auto !important;
	max-width:100% !important;
}

#people_contacts_container .people-entry-item .p_content_left img, .people-entry-item .p_content_left img, body #people_contacts_container #map_canvas .infowindow .info_avatar img, body #people_contacts_container .map_canvas_container .infowindow .info_avatar img, .custom_contact_popup .avatar img {
	background: <?php echo $people_contact_grid_view_image_style['item_image_background']; ?> !important;
	
	<?php echo $people_contact_admin_interface->generate_border_style_css( $people_contact_grid_view_image_style['item_image_border'] ); ?>
	padding:<?php echo $item_image_padding;?>px !important;

	border-radius: 200px !important;
	-moz-border-radius: 200px !important;
	-webkit-border-radius: 200px !important;
	<?php echo $people_contact_admin_interface->generate_shadow_css( $people_contact_grid_view_image_style['item_image_shadow'] ); ?>

	box-sizing:border-box !important;
	-moz-box-sizing:border-box !important;
	-webkit-box-sizing:border-box !important;
}

<?php
global $people_contact_grid_view_style;
?>
#people_contacts_container .people_item .people-entry-item, .people_item .people-entry-item{
	background-color:<?php echo $people_contact_grid_view_style['grid_view_item_background'];?>;
	<?php echo $people_contact_admin_interface->generate_border_css( $people_contact_grid_view_style['grid_view_item_border'] ); ?>
	padding:<?php echo $people_contact_grid_view_style['grid_view_item_padding_top'];?>px <?php echo $people_contact_grid_view_style['grid_view_item_padding_right'];?>px <?php echo $people_contact_grid_view_style['grid_view_item_padding_bottom'];?>px <?php echo $people_contact_grid_view_style['grid_view_item_padding_left'];?>px;
	
	<?php echo $people_contact_admin_interface->generate_shadow_css( $people_contact_grid_view_style['grid_view_item_shadow'] ); ?>
}
#people_contacts_container .infowindow{
	background-color:<?php echo $people_contact_grid_view_style['grid_view_item_background'];?>;
	padding:10px;
}

<?php
// Email Inquiry Form Button Style
global $people_contact_popup_style_settings;
extract($people_contact_popup_style_settings);
?>

/* Email Inquiry Form Style */
.custom_contact_popup * {
	box-sizing:content-box !important;
	-moz-box-sizing:content-box !important;
	-webkit-box-sizing:content-box !important;	
}
body .custom_contact_popup, .custom_contact_popup, body .custom_contact_popup div, body .custom_contact_popup p, body .custom_contact_popup span, body .custom_contact_popup h1, body .custom_contact_popup h3, body .custom_contact_popup input, body .custom_contact_popup a {
	/* Font */
	<?php echo $people_contact_fonts_face->generate_font_css( $people_contact_popup_style_settings['contact_popup_text_font'] ); ?>
}
.custom_contact_popup h1 {
	clear:none !important;
	margin-top:0px !important;
	margin-bottom:5px !important;
}
.custom_contact_popup input[type="text"] {
	border-width:1px;
}
.custom_contact_popup textarea {
	border-width:1px;
}
</style>