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
#people_contacts_container .people-entry-item .p_content_left img, .people-entry-item .p_content_left img{
	width: auto !important;
	max-width:100% !important;
}

#people_contacts_container .people-entry-item .p_content_left img, .people-entry-item .p_content_left img, body #people_contacts_container #map_canvas .infowindow .info_avatar img, body #people_contacts_container .map_canvas_container .infowindow .info_avatar img, .custom_contact_popup .people_email_inquiry_default_image_container img {
	background: <?php echo $people_contact_grid_view_layout['item_image_background']; ?> !important;
	
	<?php echo $people_contact_admin_interface->generate_border_style_css( $people_contact_grid_view_layout['item_image_border'] ); ?>
	padding:<?php echo $people_contact_grid_view_layout['item_image_padding'];?>px !important;

	border-radius: 200px !important;
	-moz-border-radius: 200px !important;
	-webkit-border-radius: 200px !important;
	<?php echo $people_contact_admin_interface->generate_shadow_css( $people_contact_grid_view_layout['item_image_shadow'] ); ?>

	box-sizing:border-box !important;
	-moz-box-sizing:border-box !important;
	-webkit-box-sizing:border-box !important;
}

#people_contacts_container .people_item .people-entry-item, .people_item .people-entry-item{
	background-color:<?php echo $people_contact_grid_view_layout['grid_view_item_background'];?>;
	<?php echo $people_contact_admin_interface->generate_border_css( $people_contact_grid_view_layout['grid_view_item_border'] ); ?>
	padding:<?php echo $people_contact_grid_view_layout['grid_view_item_padding_top'];?>px <?php echo $people_contact_grid_view_layout['grid_view_item_padding_right'];?>px <?php echo $people_contact_grid_view_layout['grid_view_item_padding_bottom'];?>px <?php echo $people_contact_grid_view_layout['grid_view_item_padding_left'];?>px;
	<?php echo $people_contact_admin_interface->generate_shadow_css( $people_contact_grid_view_layout['grid_view_item_shadow'] ); ?>
}
#people_contacts_container .infowindow{
	background-color:<?php echo $people_contact_grid_view_layout['grid_view_item_background'];?>;
	padding:10px;
}

<?php
// Email Inquiry Form Button Style
global $people_email_inquiry_global_settings;
extract($people_email_inquiry_global_settings);
?>

/* Email Inquiry Form Style */
.custom_contact_popup * {
	box-sizing:content-box !important;
	-moz-box-sizing:content-box !important;
	-webkit-box-sizing:content-box !important;	
}
.people_ei_cb #cboxLoadedContent, .custom_contact_popup, #fancybox-content > div {
	background-color: <?php echo $inquiry_form_bg_colour; ?> !important;
}
.custom_contact_popup {
	width:520px;	
}
body .custom_contact_popup, .custom_contact_popup {
	/* Font */
	<?php echo $people_contact_fonts_face->generate_font_css( $inquiry_contact_popup_text ); ?>
}
.people_email_inquiry_contact_heading {
	/* Font */
	<?php echo $people_contact_fonts_face->generate_font_css( $inquiry_contact_heading_font ); ?>
}
.people_email_inquiry_site_name {
	/* Font */
	<?php echo $people_contact_fonts_face->generate_font_css( $inquiry_form_site_name_font ); ?>
}
.people_email_inquiry_profile_position {
	/* Font */
	<?php echo $people_contact_fonts_face->generate_font_css( $inquiry_form_profile_position_font ); ?>
}
.people_email_inquiry_profile_name {
	/* Font */
	<?php echo $people_contact_fonts_face->generate_font_css( $inquiry_form_profile_name_font ); ?>
}
.custom_contact_popup input, .custom_contact_popup textarea{
	/*Border*/
	<?php echo $people_contact_admin_interface->generate_border_css( $inquiry_input_border ); ?>
	
	/*Background*/
	background-color: <?php echo $inquiry_input_bg_colour; ?> !important;
	
	/* Font */
	color: <?php echo $inquiry_input_font_colour; ?> !important;
}

/* Email Inquiry Form Button Style */
body .people_email_inquiry_form_button, .people_email_inquiry_form_button {
	position: relative !important;
	cursor:pointer;
	display: inline-block !important;
	line-height: 1 !important;
}
body .people_email_inquiry_form_button, .people_email_inquiry_form_button {
	padding: 7px 10px !important;
	margin:0;
	
	/*Background*/
	background-color: <?php echo $inquiry_contact_button_bg_colour; ?> !important;
	background: -webkit-gradient(
					linear,
					left top,
					left bottom,
					color-stop(.2, <?php echo $inquiry_contact_button_bg_colour_from; ?>),
					color-stop(1, <?php echo $inquiry_contact_button_bg_colour_to; ?>)
				) !important;;
	background: -moz-linear-gradient(
					center top,
					<?php echo $inquiry_contact_button_bg_colour_from; ?> 20%,
					<?php echo $inquiry_contact_button_bg_colour_to; ?> 100%
				) !important;;
	
	/*Border*/
	<?php echo $people_contact_admin_interface->generate_border_css( $inquiry_contact_button_border ); ?>
	
	/* Font */
	<?php echo $people_contact_fonts_face->generate_font_css( $inquiry_contact_button_font ); ?>
		
	text-align: center !important;
	text-shadow: 0 -1px 0 hsla(0,0%,0%,.3);
	text-decoration: none !important;
}
</style>
